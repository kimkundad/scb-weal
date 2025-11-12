<?php

namespace App\Http\Controllers\AdminHonor;

use App\Http\Controllers\Controller;
use App\Models\ParticipantReceiptLog;
use Illuminate\Http\Request;

class ReceiptLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ParticipantReceiptLog::query()
            ->with(['user', 'receipt'])     // eager load user + receipt
            ->orderByDesc('created_at');

        // ค้นหา username admin
        if ($username = $request->get('username')) {
            $query->whereHas('user', function ($q) use ($username) {
                $q->where('username', 'like', "%{$username}%");
            });
        }

        // ค้นหาเลขใบเสร็จ หรือ IMEI
        if ($keyword = $request->get('q')) {
            $query->whereHas('receipt', function ($q) use ($keyword) {
                $q->where('receipt_number', 'like', "%{$keyword}%")
                  ->orWhere('imei', 'like', "%{$keyword}%")
                  ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        // filter action (approved / rejected)
        if ($action = $request->get('action')) {
            $query->where('action', $action);
        }

        $logs = $query->paginate(30)->withQueryString();

        return view('adminHonor.receipts.logs', [
            'logs' => $logs,
        ]);
    }
}
