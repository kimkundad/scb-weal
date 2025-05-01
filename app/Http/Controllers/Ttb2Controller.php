<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Google\Service\Sheets\CopyPasteRequest;
use Google\Service\Sheets\Request as SheetRequest;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;

class Ttb2Controller extends Controller
{
    //

    protected $googleSheet;

    public function __construct(GoogleSheet $googleSheet)
    {
        $this->googleSheet = $googleSheet;
    }

    public function auto_search(Request $request) {
        $employeeCode = $request->input('employee_code');
        $spreadsheetId = '1uDRFk0e305NjtwsWiPey0GdNNvLdbBdx_rOnnB-BLeY';
        $range = 'ฟอร์มลงทะเบียน';

        $data = $this->googleSheet->getSheetData($spreadsheetId, $range);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่สามารถดึงข้อมูลจาก Google Sheets'
            ]);
        }

        // ค้นหาข้อมูล
        $rows = array_slice($data, 1);

        foreach ($rows as $row) {
            if (isset($row[0]) && strval(trim($row[0])) === strval(trim($employeeCode))) {
                $fullName = trim($row[1]); // ชื่อ + นามสกุล

                $messagePart1 = isset($row[3]) ? trim($row[3]) : ''; // คอลัมน์ D
                $messagePart2 = isset($row[4]) ? trim($row[4]) : ''; // คอลัมน์ E

                $alreadyRegistered = isset($row[5]) && !empty($row[5]);

                return response()->json([
                    'success' => true,
                    'full_name' => $fullName,
                    'messagePart1' => $messagePart1,
                    'messagePart2' => $messagePart2,
                    'alreadyRegistered' => $alreadyRegistered
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'ไม่พบรหัสพนักงาน'
        ]);
    }

    public function post_submit(Request $request)
{
    $employeeId = $request->input('employeeId');
    $timestamp = now()->format('Y-m-d H:i:s');

    if (!$employeeId) {
        return response()->json([
            'success' => false,
            'message' => 'เกิดข้อผิดพลาด: ไม่พบรหัสพนักงานที่ส่งมา'
        ]);
    }

    $spreadsheetId = '1uDRFk0e305NjtwsWiPey0GdNNvLdbBdx_rOnnB-BLeY';
    $dataList = $this->googleSheet->getSheetData($spreadsheetId, 'ฟอร์มลงทะเบียน');

    if (!$dataList || !is_array($dataList)) {
        return response()->json([
            'success' => false,
            'message' => 'ไม่สามารถดึงข้อมูลจาก Google Sheets'
        ]);
    }

    $rowIndex = null;
    $fullName = null;
    $alreadyRegistered = false;

    foreach ($dataList as $index => $row) {
        if (isset($row[0]) && trim($row[0]) == trim($employeeId)) {
            $rowIndex = $index + 1;
            $fullName = trim($row[1]) . ' ' . trim($row[2]);
            $alreadyRegistered = isset($row[5]) && !empty($row[5]); // ตรวจสอบว่ามีค่าแล้ว
            break;
        }
    }

    if ($rowIndex) {
        if ($alreadyRegistered) {
            // ❗ ไม่ต้องอัปเดต เพราะเคยลงทะเบียนแล้ว
            return response()->json([
                'success' => false,
                'alreadyRegistered' => true,
                'message' => 'รหัสพนักงานนี้ได้ลงทะเบียนแล้วก่อนหน้านี้',
                'data' => [
                    'employee_id' => $employeeId,
                    'full_name' => $fullName
                ]
            ]);
        }

        // ถ้ายังไม่เคยลงทะเบียน ให้บันทึกเวลา
        $cell = 'F' . $rowIndex;
        $this->googleSheet->updateCell($spreadsheetId, 'ฟอร์มลงทะเบียน!' . $cell, $timestamp);

        return response()->json([
            'success' => true,
            'alreadyRegistered' => false,
            'data' => [
                'employee_id' => $employeeId,
                'full_name' => $fullName,
                'timestamp' => $timestamp
            ]
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'ไม่พบรหัสพนักงานในระบบ'
    ]);
}


public function post_ans_ttb3(Request $request)
{
    $question = $request->input('question');
    $id = $request->input('id');
    $timestamp = now()->format('Y-m-d H:i:s');

    if (!$question || !$id) {
        return response()->json([
            'success' => false,
            'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน'
        ]);
    }

    $spreadsheetId = '1jDiViPp1kVCvDhHzOljyd62VfrSjpYKZKaG4nrfl7EQ';
    $sheetName = 'คำถามรวม';
    $sheetId = 0; // ถ้า Sheet อยู่ตำแหน่งแรก

    $rows = $this->googleSheet->getSheetData($spreadsheetId, $sheetName);
    $nextRowNumber = count($rows) + 1;

    $topics = [
        1 => 'กระบวนการและวิธีการทำงาน',
        2 => 'พัฒนาบุคลากร',
        3 => 'IT & Digital'
    ];

    $topic = $topics[$id] ?? 'อื่น ๆ';

    $newRow = [
        $nextRowNumber,
        $topic,
        $question,
        '', // เพื่อให้ copy format ได้
        $timestamp
    ];

    $this->googleSheet->appendRow($spreadsheetId, $sheetName, $newRow);

    // ✅ คัดลอก Format จาก D2 ไปยัง D{nextRowNumber}
    $requests = [
        new \Google\Service\Sheets\Request([
            'copyPaste' => new \Google\Service\Sheets\CopyPasteRequest([
                'source' => [
                    'sheetId' => $sheetId,
                    'startRowIndex' => 1,
                    'endRowIndex' => 2,
                    'startColumnIndex' => 3,
                    'endColumnIndex' => 4,
                ],
                'destination' => [
                    'sheetId' => $sheetId,
                    'startRowIndex' => $nextRowNumber - 1,
                    'endRowIndex' => $nextRowNumber,
                    'startColumnIndex' => 3,
                    'endColumnIndex' => 4,
                ],
                'pasteType' => 'PASTE_FORMAT'
            ])
        ])
    ];

    $body = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
        'requests' => $requests
    ]);

    $this->googleSheet->getService()->spreadsheets->batchUpdate($spreadsheetId, $body);

    return response()->json([
        'success' => true,
        'data' => $sheetName
    ]);
}


    // public function post_ans_ttb3(Request $request)
    // {
    //     $question = $request->input('question');
    //     $id = $request->input('id');
    //     $timestamp = now()->format('Y-m-d H:i:s');

    //     Log::debug('Post Answer Payload', [
    //         'question' => $question,
    //         'id' => $id
    //     ]);

    //     if (!$question || !$id) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'ข้อมูลไม่ครบ กรุณากรอกข้อมูลทั้งหมด'
    //         ]);
    //     }


    //     $topicMap = [
    //         '1' => 'กระบวนการและวิธีการทำงาน',
    //         '2' => 'พัฒนาบุคลากร',
    //         '3' => 'IT & Digital',
    //     ];

    //     $topicName = $topicMap[$id] ?? 'ไม่ทราบหัวข้อ';

    //     $sheetName = 'คำถามรวม';
    //     $spreadsheetId = '1jDiViPp1kVCvDhHzOljyd62VfrSjpYKZKaG4nrfl7EQ';

    //     $rows = $this->googleSheet->getSheetData($spreadsheetId, $sheetName);
    //     $nextNo = count($rows);

    //     $newRow = [
    //         $nextNo,
    //         $topicName,
    //         $question,
    //         'FALSE', // ช่องสำหรับการตรวจสอบ (ยังไม่ต้องมีการทำเครื่องหมาย)
    //         $timestamp
    //     ];

    //     // 1. เพิ่มคำถามในหัวข้อ
    //     $this->googleSheet->appendRow($spreadsheetId, $sheetName, $newRow);


    //     return response()->json(
    //         [
    //             'success' => true,
    //             'data' => $sheetName
    //         ]
    //     );
    // }


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
