<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TtbController extends Controller
{
    //

    protected $googleSheet;

    public function __construct(GoogleSheet $googleSheet)
    {
        $this->googleSheet = $googleSheet;
    }

    public function auto_search(Request $request) {
        $employeeCode = $request->input('employee_code');
        $spreadsheetId = '1Q1i2VAna27ERbYaZey7RDR7gXicBZz_jL6WS8lGrt-Q';
        $range = 'Data List';

        $data = $this->googleSheet->getSheetData($spreadsheetId, $range);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่สามารถดึงข้อมูลจาก Google Sheets'
            ]);
        }

        // ค้นหาข้อมูล
        foreach ($data as $row) {
            if (isset($row[0]) && trim($row[0]) === trim($employeeCode)) {
                $fullName = trim($row[1]) . ' ' . trim($row[2]); // ชื่อ + นามสกุล
                return response()->json([
                    'success' => true,
                    'full_name' => $fullName
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'ไม่พบรหัสพนักงาน'
        ]);
    }


    public function post_ans(Request $request)
    {
        $employeeId = $request->input('employeeId');
        $question = $request->input('question');
        $id = $request->input('id');
        $full_name = $request->input('full_name');
        $timestamp = now()->format('Y-m-d H:i:s');

        Log::debug('Post Answer Payload', [
            'employeeId' => $employeeId,
            'full_name' => $full_name,
            'question' => $question,
            'id' => $id
        ]);

        if (!$employeeId || !$full_name || !$question) {
            return response()->json([
                'success' => false,
                'message' => 'ข้อมูลไม่ครบ กรุณากรอกข้อมูลทั้งหมด'
            ]);
        }

        $sheetMap = [
            1 => 'กระบวนการและวิธีการทำงาน',
            2 => 'กลยุทธ์และแผนธุรกิจ',
            3 => 'พัฒนาบุคลากร',
            4 => 'IT & Digital',
            5 => 'ช่องทางการให้บริการ',
            6 => 'ผลิตภัณฑ์และบริการ',
            7 => 'วัฒนธรรมองค์กร',
            8 => 'อื่นๆ'
        ];

        $sheetName = $sheetMap[$id] ?? 'อื่นๆ';
        $spreadsheetId = '1Q1i2VAna27ERbYaZey7RDR7gXicBZz_jL6WS8lGrt-Q';

        $rows = $this->googleSheet->getSheetData($spreadsheetId, $sheetName);
        $nextNo = count($rows);

        $newRow = [
            $nextNo,
            $employeeId,
            $full_name,
            $timestamp,
            $question
        ];

        // 1. เพิ่มคำถามในหัวข้อ
        $this->googleSheet->appendRow($spreadsheetId, $sheetName, $newRow);

        // 2. อัปเดตเวลาใน Data List
        $dataList = $this->googleSheet->getSheetData($spreadsheetId, 'Data List');

        $rowIndex = null;
        foreach ($dataList as $index => $row) {
            if (isset($row[0]) && trim($row[0]) == trim($employeeId)) {
                $rowIndex = $index + 1;
                break;
            }
        }

        if ($rowIndex) {
            $cell = 'F' . $rowIndex;
            $this->googleSheet->updateCell($spreadsheetId, 'Data List!' . $cell, $timestamp);
        }

        return response()->json(
            [
                'success' => true,
                'data' => $sheetName
            ]
        );
    }






}
