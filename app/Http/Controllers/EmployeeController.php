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

    public function api_search(Request $request){

        //18SooP-dtym3hvIQe9tMhehilOXFU80FeQb95qgVKneM

        $employeeCode = $request->input('employee_code');

        $spreadsheetId = '18SooP-dtym3hvIQe9tMhehilOXFU80FeQb95qgVKneM'; // ใส่ Spreadsheet ID ที่ต้องการ
        $range = 'ตัวอย่างฟอร์มลงทะเบียน'; // ใส่ชื่อ Sheet

         // ดึงข้อมูลทั้งหมดจาก Google Sheet
         $data = $this->googleSheet->getSheetData($spreadsheetId, $range);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่สามารถดึงข้อมูลจาก Google Sheets'
            ]);
        }

        // ค้นหาข้อมูลในคอลัมน์ที่ 4 (index 3 เนื่องจาก index เริ่มต้นที่ 0)
        $row = $this->googleSheet->findRowByColumnValue($data, 0, $employeeCode);

        if ($row) {
            // ตรวจสอบว่ามีข้อมูลในคอลัมน์ "วันและเวลาที่ลงทะเบียน" หรือไม่
            $checkinDate = isset($row[6]) && !empty($row[6]) ? $row[6] : null; // คอลัมน์ G (index 6)

            if ($checkinDate) {
                // ✅ ถ้าลงทะเบียนแล้ว → ไปหน้า result ทันที
                $tableNumber = isset($row[7]) ? $row[7] : "N/A"; // คอลัมน์ H (index 7)
                return redirect()->route('result', ['tableNumber' => $tableNumber]);
            }

            // ✅ ถ้ายังไม่ลงทะเบียน → ไปหน้า regis
            return view('regis', ['data' => $row]);
        } else {
            // ❌ ถ้าไม่พบพนักงาน → ไปหน้า 404
            return view('404');
        }

    }





    public function register(Request $request)
{
    $employeeCode = $request->input('employee_code');

    // ข้อมูล Google Sheets
    $spreadsheetId = '18SooP-dtym3hvIQe9tMhehilOXFU80FeQb95qgVKneM';
    $range = 'ตัวอย่างฟอร์มลงทะเบียน';

    // ดึงข้อมูลจาก Google Sheets
    $data = $this->googleSheet->getSheetData($spreadsheetId, $range);

    if (!$data) {
        return response()->json([
            'success' => false,
            'message' => 'ไม่สามารถดึงข้อมูลจาก Google Sheets'
        ], 500);
    }

    // ค้นหารหัสพนักงาน
    $rowIndex = null;
    $tableNumber = null;
    foreach ($data as $index => $row) {
        if (isset($row[0]) && $row[0] == $employeeCode) {
            $rowIndex = $index + 1;
            $tableNumber = isset($row[7]) ? $row[7] : "N/A"; // ดึงหมายเลขโต๊ะจากคอลัมน์ H (index 7)
            break;
        }
    }

    if ($rowIndex === null) {
        return response()->json([
            'success' => false,
            'message' => 'ไม่พบรหัสพนักงานใน Google Sheets'
        ], 404);
    }

    // 🕒 บันทึกเวลาลงทะเบียนลงคอลัมน์ G
    $currentTime = now()->toDateTimeString();
    $column = 'G';
    $this->googleSheet->updateCell($spreadsheetId, "{$column}{$rowIndex}", $currentTime);

    // ✅ ส่ง JSON กลับไปให้ JavaScript ใช้
    return response()->json([
        'success' => true,
        'message' => 'บันทึกเวลาเข้าร่วมสำเร็จ',
        'tableNumber' => $tableNumber
    ]);
}





}
