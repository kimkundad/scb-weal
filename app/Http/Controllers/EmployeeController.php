<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheet;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    //

    protected $googleSheet;

    public function __construct(GoogleSheet $googleSheet)
    {
        $this->googleSheet = $googleSheet;
    }

    public function search(Request $request)
    {
        // รับค่ารหัสพนักงานจากคำขอ
        $employeeCode = $request->input('employee_code');

        // ตัวอย่าง: ดึงข้อมูลพนักงานจากฐานข้อมูล
        // $employeeData = [
        //     '12345' => 'John Doe',
        //     '67890' => 'Jane Smith'
        // ];

        $spreadsheetId = '1lXKPbJApFJ5cRDLBEd06WLfsTin1tH3cv8TW8jEMK64'; // ใส่ Spreadsheet ID ที่ต้องการ
        $range = 'Sheet1'; // ใส่ชื่อ Sheet

         // ดึงข้อมูลทั้งหมดจาก Google Sheet
         $data = $this->googleSheet->getSheetData($spreadsheetId, $range);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่สามารถดึงข้อมูลจาก Google Sheets'
            ]);
        }

        // ค้นหาข้อมูลในคอลัมน์ที่ 4 (index 3 เนื่องจาก index เริ่มต้นที่ 0)
        $row = $this->googleSheet->findRowByColumnValue($data, 4, $employeeCode);

        if ($row) {
            return response()->json([
                'success' => true,
                'data' => $row // ส่งคืนข้อมูลทั้งแถว
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูลของท่าน โปรดติดต่อเจ้าหน้าที่'
            ]);
        }

    }



    public function register(Request $request)
{
    $employeeCode = $request->input('employee_code');
    $employeeName = $request->input('employee_name');
    $checkin = $request->input('checkin');

    // ข้อมูล Google Sheets
    $spreadsheetId = '1lXKPbJApFJ5cRDLBEd06WLfsTin1tH3cv8TW8jEMK64';
    $range = 'Sheet1!A1:I'; // ช่วงข้อมูลรวมคอลัมน์ I

    // ดึงข้อมูลทั้งหมดจาก Google Sheets
    $data = $this->googleSheet->getSheetData($spreadsheetId, $range);

    if (!$data) {
        return response()->json([
            'success' => false,
            'message' => 'ไม่สามารถดึงข้อมูลจาก Google Sheets'
        ]);
    }

    // ค้นหาแถวของรหัสพนักงานในคอลัมน์ 5 (index 4)
  //  dd($employeeCode);
    $rowIndex = null;
    foreach ($data as $index => $row) {
        if (isset($row[4]) && $row[4] == $employeeCode) {
            $rowIndex = $index + 1; // Google Sheets ใช้เลขแถวเริ่มต้นที่ 1
            break;
        }
    }

    if ($rowIndex === null) {
        return response()->json([
            'success' => false,
            'message' => 'ไม่พบรหัสพนักงานใน Google Sheets'
        ]);
    }

    // กำหนดคอลัมน์เป้าหมาย
    $column = $checkin == 1 ? 'I' : 'J'; // ถ้า checkin == 1 ใช้คอลัมน์ I, ถ้า checkin == 2 ใช้คอลัมน์ J
    $currentTime = now()->toDateTimeString(); // เวลาปัจจุบัน

    //dd($rowIndex);
    // บันทึกเวลาปัจจุบันลงในคอลัมน์ 9 (index I)
    $this->googleSheet->updateCell($spreadsheetId, "{$column}{$rowIndex}", $currentTime);

    return response()->json([
        'success' => true,
        'message' => 'บันทึกเวลาเข้างานสำเร็จ',
        'column' => $column, // สำหรับ Debug
        'row' => $rowIndex
    ]);
}
}
