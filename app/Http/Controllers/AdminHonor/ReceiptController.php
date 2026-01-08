<?php

namespace App\Http\Controllers\AdminHonor;

use App\Http\Controllers\Controller;
use App\Models\participant_receipt;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\ParticipantReceiptLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReceiptController extends Controller
{
    /**
     * แสดงหน้า dashboard + รายการใบเสร็จ
     */
    public function index(Request $request)
    {
        // Summary
        $summary = [
            'participants' => participant_receipt::distinct('phone')->count('phone'),
            'receipts_total' => participant_receipt::count(),
            'pending' => participant_receipt::where('status', 'pending')->count(),
            'approved' => participant_receipt::where('status', 'approved')->count(),
            'rejected' => participant_receipt::where('status', 'failed')->count(),
        ];

        $query = participant_receipt::query();

        // ------------------------------
        // 🔍 ค้นหาทั่วไป
        // ------------------------------
        if ($q = $request->q) {

            $q_no_dash = str_replace('-', '', $q);

            $query->where(function ($sub) use ($q, $q_no_dash) {
                $sub->where('receipt_number', 'like', "%{$q}%")
                    ->orWhere('imei', 'like', "%{$q}%")
                    ->orWhere('first_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('store_name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhereRaw("REPLACE(phone, '-', '') LIKE ?", ["%{$q_no_dash}%"]);
            });
        }

        // ------------------------------
        // 📌 กรองสถานะ
        // ------------------------------
        $status = $request->status;

        if ($status === 'approved') {
            $query->where('status', 'approved');
        } elseif ($status === 'rejected') {
            $query->where('status', 'failed');
        } elseif ($status === 'pending') {
            $query->where('status', 'pending');
        }

        // ------------------------------
        // 📅 กรองวันที่ตามประเภทสถานะ
        // ------------------------------
        $start = $this->parseDate($request->start_date)?->startOfDay();
$end   = $this->parseDate($request->end_date)?->endOfDay();

        if ($start || $end) {

            // ถ้าเลือก "อนุมัติแล้ว"
            if ($status === 'approved') {

                $query->whereBetween('approved_at', [
                    $start ?? Carbon::minValue(),
                    $end ?? Carbon::maxValue()
                ]);

            // ถ้าเลือก "ไม่ผ่าน"
            } elseif ($status === 'rejected') {

                $query->whereBetween('rejected_at', [
                    $start ?? Carbon::minValue(),
                    $end ?? Carbon::maxValue()
                ]);

            // pending หรือไม่ระบุสถานะ → ใช้ created_at
            } else {

                $query->whereBetween('created_at', [
                    $start ?? Carbon::minValue(),
                    $end ?? Carbon::maxValue()
                ]);
            }
        }

        // -----------------------------------------------------------------
        // 🔽 เรียงลำดับ: ลงทะเบียนล่าสุด อยู่ด้านบนเสมอ
        // -----------------------------------------------------------------
        $receipts = $query->orderByDesc('created_at')
                        ->paginate(20)
                        ->withQueryString();

        return view('adminHonor.receipts.index', compact('summary', 'receipts'));
    }

    private function parseDate($date)
{
    if (!$date) return null;

    // ถ้าเป็นรูปแบบ Y-m-d เช่น 2025-12-01
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        return Carbon::parse($date);
    }

    // ถ้าเป็นรูปแบบ d/m/Y เช่น 01/12/2025
    if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
        return Carbon::createFromFormat('d/m/Y', $date);
    }

    return null; // ป้องกัน error
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
        $fileName = 'participant_receipts_' . now()->format('Ymd_His') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = [
            'No.',
            'Phone',
            'Prefix',
            'First Name',
            'Last Name',
            'HBD',
            'ID Type',
            'Citizen ID',
            'Passport ID',
            'Email',
            'Province',
            'Purchase Date',
            'Purchase Time',
            'Receipt Number',
            'IMEI',
            'Store Name',
            'Receipt File Path',
            'Reject Reason',
            'Status',
            'Approved At',
            'Rejected At',
            'Checked By',
            'Created At',
            'Updated At',
        ];

        $sheet->fromArray($headers, null, 'A1');

        // Data
        $rowNumber = 2;
        // Running number (เริ่ม 1)
        $runningNumber = 1;

        participant_receipt::orderBy('id')
        ->chunk(500, function ($rows) use ($sheet, &$rowNumber, &$runningNumber) {
            foreach ($rows as $row) {
                $sheet->fromArray([
                    $runningNumber, // 👈 ใช้เลขรันแทน id
                    $row->phone,
                    $row->prefix,
                    $row->first_name,
                    $row->last_name,
                    optional($row->hbd)->format('Y-m-d') ?? $row->hbd,
                    $row->id_type,
                    $row->citizen_id,
                    $row->passport_id,
                    $row->email,
                    $row->province,
                    optional($row->purchase_date)->format('Y-m-d') ?? $row->purchase_date,
                    optional($row->purchase_time)->format('H:i:s') ?? $row->purchase_time,
                    $row->receipt_number,
                    $row->imei,
                    $row->store_name,
                    $row->receipt_file_path,
                    $row->reject_reason,
                    $row->status,
                    optional($row->approved_at)->toDateTimeString(),
                    optional($row->rejected_at)->toDateTimeString(),
                    $row->checked_by,
                    optional($row->created_at)->toDateTimeString(),
                    optional($row->updated_at)->toDateTimeString(),
                ], null, 'A' . $rowNumber);

                $rowNumber++;      // แถว Excel
                $runningNumber++;  // เลขรัน
            }
        });

        // ปรับ auto width
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
