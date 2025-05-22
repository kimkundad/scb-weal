<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Sheets;

class TPController extends Controller
{
    //

    protected $googleSheet;

    public function __construct(GoogleSheet $googleSheet)
    {
        $this->googleSheet = $googleSheet;
    }

    public function postStep1(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required',
            'phone' => 'required',
            'line' => 'nullable',
            'nickname' => 'nullable',
            'generation' => 'nullable',
            'address' => 'required',
        ]);

        session(['form.fullname' => $validated['fullname']]);
        session(['form.phone' => $validated['phone']]);
        session(['form.line' => $validated['line']]);
        session(['form.nickname' => $validated['nickname']]);
        session(['form.generation' => $validated['generation']]);
        session(['form.address' => $validated['address']]);

        return redirect(url('p2'));
    }


    public function postStep2(Request $request)
    {

        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'position' => 'required|string|max:100',
            'location' => 'required|string|max:255',
        ]);

        session([
            'form.company' => $validated['company'],
            'form.type' => $validated['type'],
            'form.position' => $validated['position'],
            'form.location' => $validated['location'],
        ]);

        return redirect(url('p3'));
    }


    public function postStep3(Request $request)
    {
        $validated = $request->validate([
            'activity' => 'required|string|max:255',
            'help' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'join_sme_clinic' => 'nullable|in:1'
        ]);

        // รวมข้อมูลทุกหน้า
        $formData = array_merge(session('form', []), $validated);

        try {
        $spreadsheetId = '1KpOTl70lSk6lbaAPQG8Vsv9x0KgGt4k04vqzF9ortAo';
        $sheetName = 'NETWORKING #4';
        $rows = $this->googleSheet->getSheetData($spreadsheetId, $sheetName);
        $nextRowNumber = max(count($rows) - 1, 1) + 1;

        // เตรียมข้อมูลสำหรับบันทึกใน Google Sheet
        $row = [
            $nextRowNumber,
            $formData['fullname'] ?? '',
            $formData['phone'] ?? '',
            $formData['line'] ?? '',
            $formData['nickname'] ?? '',
            $formData['generation'] ?? '',
            $formData['address'] ?? '',
            $formData['company'] ?? '',
            $formData['type'] ?? '',
            $formData['position'] ?? '',
            $formData['location'] ?? '',
            $formData['activity'] ?? '',
            $formData['help'] ?? '',
            $formData['target'] ?? '',
            ' ',
            now()->format('Y-m-d H:i')
        ];

        // บันทึกลง Google Sheets


            $this->googleSheet->appendRow($spreadsheetId, 'NETWORKING #4', $row);
        } catch (\Exception $e) {
            Log::error('Google Sheet Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'ไม่สามารถบันทึกข้อมูลลง Google Sheets ได้']);
        }

        // เคลียร์ session
        session()->forget('form');

        return redirect(url('tp_ans_success'));
    }

}
