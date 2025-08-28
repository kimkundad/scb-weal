<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheet;


class SrichanController extends Controller
{
    //

    protected $googleSheet;

    public function __construct(GoogleSheet $googleSheet)
    {
        $this->googleSheet = $googleSheet;
    }

public function search_cus(Request $request)
{
    $input = trim($request->input('name'));

    $spreadsheetId = '1KDkKK_Ty2vpAl0CnzjnYC1tFpZSwMJgSChmJS08BS_U';
    $range = 'List';

    $data = $this->googleSheet->getSheetData($spreadsheetId, $range);

    if (!$data) {
        return response()->json([
            'success' => false,
            'message' => 'ไม่สามารถดึงข้อมูลจาก Google Sheets'
        ]);
    }

    $results = [];

    foreach ($data as $row) {
        $fullName = trim($row[1] ?? '');
        $seat     = trim($row[2] ?? '');
        $zone     = trim($row[3] ?? '');
        $code     = trim($row[5] ?? '');
        $nameSeat = trim($row[8] ?? '');

        if (
            stripos($fullName, $input) !== false ||
            stripos($seat, $input) !== false ||
            stripos($code, $input) !== false
        ) {
            $results[] = [
                'full_name' => $fullName,
                'zone' => $zone,
                'seat' => $seat,
                'code' => $code,
                'nameSeat' => $nameSeat,
            ];
        }
    }

    if (count($results)) {
        return response()->json([
            'success' => true,
            'multiple' => count($results) > 1,
            'results' => $results,
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'ไม่พบข้อมูลที่ค้นหา'
    ]);
}




    public function verify($code)
    {
        $spreadsheetId = '1KDkKK_Ty2vpAl0CnzjnYC1tFpZSwMJgSChmJS08BS_U';
        $range = 'List';

        $data = $this->googleSheet->getSheetData($spreadsheetId, $range);

        foreach ($data as $row) {
            // ตรวจสอบว่ามีคอลัมน์ F (index 5) และค่าไม่ว่าง
            if (isset($row[5]) && trim($row[5]) === trim($code)) {
                $fullName = $row[1] ?? '-';
                $seat = $row[2] ?? '-';
                $zone = $row[3] ?? '-';
                $nameSeat = $row[8] ?? '-';

                // ✅ เพิ่ม 'code' เข้าไปใน redirect parameters
                return redirect()->route('showInfo', [
                    'full_name' => $fullName,
                    'zone' => $zone,
                    'seat' => $seat,
                    'code' => $code,
                    'nameSeat' => $nameSeat,
                ]);
            }
        }

        // หากไม่พบโค้ดที่ระบุ ให้แสดงหน้าแจ้งเตือน
        return view('srichan.error', [
            'message' => 'ไม่พบโค้ดที่ระบุ',
            'redirect_url' => url('/')
        ]);


    }




    public function registerUser(Request $request)
    {
        $name = $request->input('name');
        $code = trim($request->input('code'));

        $spreadsheetId = '1KDkKK_Ty2vpAl0CnzjnYC1tFpZSwMJgSChmJS08BS_U';
        $range = 'List'; // แผ่นงานชื่อ List
        $data = $this->googleSheet->getSheetData($spreadsheetId, $range);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่สามารถดึงข้อมูลจาก Google Sheets ได้'
            ]);
        }

        $foundRow = null;
        $rowIndex = 0;

        foreach ($data as $index => $row) {
            if (isset($row[5]) && trim($row[5]) === trim($code)) { // คอลัมน์ B (index 1) คือชื่อ
                $foundRow = $row;
                $rowIndex = $index;
                break;
            }
        }

        if ($foundRow) {
            $targetCell = 'G' . ($rowIndex + 1); // แถวใน Sheet เริ่มจาก 1

            $timestamp = now()->format('Y-m-d H:i:s');
            $this->googleSheet->updateCell($spreadsheetId, "List!$targetCell", $timestamp);

            return response()->json([
                'success' => true,
                'message' => 'ลงทะเบียนสำเร็จ'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'ไม่พบชื่อในระบบ'
        ]);
    }



}
