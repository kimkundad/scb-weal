<?php

namespace App\Http\Controllers\AdminHonor;

use App\Http\Controllers\Controller;
use App\Models\participant_receipt;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\ParticipantReceiptLog;
use Illuminate\Support\Facades\Auth;


class ReceiptController extends Controller
{
    /**
     * แสดงหน้า dashboard + รายการใบเสร็จ
     */
    public function index(Request $request)
    {
        // ---- Summary ด้านบน ----
        $summary = [
            // จำนวนผู้เข้าร่วม: นับเบอร์ติดต่อไม่ซ้ำ
            'participants'    => participant_receipt::distinct('phone')->count('phone'),

            // ใบเสร็จทั้งหมด
            'receipts_total'  => participant_receipt::count(),

            // สถานะ
            'pending'         => participant_receipt::where('status', 'pending')->count(),
            'approved'        => participant_receipt::where('status', 'approved')->count(),
            // ใน DB ใช้คำว่า failed แต่บน UI เขียน "ไม่ผ่าน"
            'rejected'        => participant_receipt::where('status', 'failed')->count(),
        ];

        // ---- Query list ใบเสร็จ ----
        $query = participant_receipt::query();

        // ค้นหา (ใบเสร็จ / IMEI / ชื่อ / นามสกุล / เบอร์ ฯลฯ)
        if ($q = $request->get('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('receipt_number', 'like', "%{$q}%")
                    ->orWhere('imei', 'like', "%{$q}%")
                    ->orWhere('first_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('store_name', 'like', "%{$q}%");
            });
        }

        // filter status จาก dropdown (pending / approved / rejected)
        if ($status = $request->get('status')) {

            if ($status === 'rejected') {
                // map ค่าจาก UI -> DB
                $query->where('status', 'failed');
            } else {
                $query->where('status', $status);
            }
        }

        // เรียงล่าสุดอยู่บน
        $receipts = $query
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('adminHonor.receipts.index', [
            'summary'  => $summary,
            'receipts' => $receipts,
        ]);
    }

    /**
     * ดูรายละเอียดใบเสร็จ
     * (คุณค่อยไปทำหน้า show.blade.php เองทีหลังได้)
     */
    public function show(participant_receipt $receipt)
    {
        return view('adminHonor.receipts.show', [
            'receipt' => $receipt,
        ]);
    }

    /**
     * อนุมัติใบเสร็จ
     */
public function approve(participant_receipt $receipt)
{
    $oldStatus = $receipt->status;

    $receipt->update([
        'status'      => 'approved',
        'approved_at' => now(),                // 🟢 เวลาอนุมัติ
        'rejected_at' => null,                 // เคลียร์ rejected
        'checked_by'  => Auth::user()->username ?? Auth::user()->name ?? Auth::id(), // 🟢 ผู้ตรวจสอบ
    ]);

    // บันทึก log
    ParticipantReceiptLog::create([
        'participant_receipt_id' => $receipt->id,
        'user_id'                => Auth::id(),
        'action'                 => 'approved',
        'old_status'             => $oldStatus,
        'new_status'             => 'approved',
    ]);

    return back()->with('success', 'อนุมัติใบเสร็จเรียบร้อยแล้ว');
}


/**
 * ปฏิเสธ / ไม่ผ่านใบเสร็จ
 */
public function reject(Request $request, participant_receipt $receipt)
{
    $request->validate([
        'reject_reason' => 'required|string|max:1000'
    ]);

    $oldStatus = $receipt->status;

    $receipt->update([
        'status'        => 'failed',
        'rejected_at'   => now(),
        'approved_at'   => null,
        'checked_by'    => Auth::user()->name ?? Auth::id(),
        'reject_reason' => $request->reject_reason,
    ]);

    ParticipantReceiptLog::create([
        'participant_receipt_id' => $receipt->id,
        'user_id'    => Auth::id(),
        'action'     => 'rejected',
        'old_status' => $oldStatus,
        'new_status' => 'failed',
    ]);

    return back()->with('success', 'ปฏิเสธใบเสร็จเรียบร้อย');
}


public function downloadReceipt(Request $request)
{
    $url = $request->query('url');
    $filename = $request->query('filename', 'receipt.jpg');

    if (!$url) {
        abort(404, "File not found");
    }

    // ดึงข้อมูลจาก Spaces
    $fileContent = file_get_contents($url);

    return response($fileContent)
        ->header('Content-Type', 'application/octet-stream')
        ->header('Content-Disposition', "attachment; filename=\"$filename\"");
}


    /**
     * Export ข้อมูลเป็น CSV อย่างง่าย
     * (ถ้าอยากใช้ Laravel-Excel ทีหลังสามารถเปลี่ยนภายหลังได้)
     */
    public function export(): StreamedResponse
    {
        $fileName = 'participant_receipts_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            // เขียน BOM สำหรับ Excel ภาษาไทย
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // หัวตาราง
            fputcsv($handle, [
                'ID',
                'Phone',
                'First Name',
                'Last Name',
                'Email',
                'Province',
                'Purchase Date',
                'Purchase Time',
                'Receipt Number',
                'IMEI',
                'Store Name',
                'Status',
                'Created At',
            ]);

            participant_receipt::orderBy('id')
                ->chunk(500, function ($rows) use ($handle) {
                    foreach ($rows as $row) {
                        fputcsv($handle, [
                            $row->id,
                            $row->phone,
                            $row->first_name,
                            $row->last_name,
                            $row->email,
                            $row->province,
                            $row->purchase_date,
                            $row->purchase_time,
                            $row->receipt_number,
                            $row->imei,
                            $row->store_name,
                            $row->status,
                            $row->created_at,
                        ]);
                    }
                });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
