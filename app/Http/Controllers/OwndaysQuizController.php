<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheet;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OwndaysQuizController extends Controller
{
    //
    protected $googleSheet;

    // กำหนด Spreadsheet ID และชื่อชีต
    private string $spreadsheetId = '18HerRK-lezAFkqojl5GRHq6Pj9XdfCtbAB7_fnhm2RI';
    private string $sheetName     = 'ชีต1';

    public function __construct(GoogleSheet $googleSheet)
    {
        $this->googleSheet = $googleSheet;
    }

    /**
     * ✅ บันทึกข้อมูลฟอร์ม + คำตอบทั้งหมดลง Google Sheets
     */
    // public function submitQuiz(Request $request)
    // {

    //     dd($request->all());
    //     try {
    //         $userInfo = session('user_info', []);
    //         $answers = $request->input('answers', []);

    //         $sheetId = $this->spreadsheetId;
    //         $sheetName = $this->sheetName;

    //         // ✅ ตรวจว่ามี header row แล้วหรือยัง
    //         $existingData = $this->googleSheet->getSheetData($sheetId, "{$sheetName}!A1:Z1");
    //         if (empty($existingData)) {
    //             $headers = [
    //                 'Timestamp', 'Gender', 'Age', 'Career', 'Province', 'Income',
    //                 'Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7'
    //             ];

    //             $this->googleSheet->appendRowFlexible($sheetId, $sheetName, $headers);
    //         }

    //         // ✅ เตรียมข้อมูล row ที่จะบันทึก (เริ่มจากแถว 2 เป็นต้นไป)
    //         $row = [
    //             now()->format('Y-m-d H:i:s'),
    //             $userInfo['gender'] ?? '',
    //             $userInfo['age'] ?? '',
    //             $userInfo['career'] ?? '',
    //             $userInfo['province'] ?? '',
    //             $userInfo['income'] ?? '',
    //         ];

    //         for ($i = 1; $i <= 7; $i++) {
    //             $row[] = $answers[$i] ?? '';
    //         }

    //         // ✅ เพิ่มข้อมูล (Google Sheets จะเขียนต่อจากแถว 2 ขึ้นไปเอง)
    //         $this->googleSheet->appendRowFlexible($sheetId, $sheetName, $row);

    //         $request->session()->forget('user_info');

    //         return redirect('/result')->with('success', 'ส่งข้อมูลเรียบร้อยแล้ว!');
    //     } catch (\Exception $e) {
    //         \Log::error('Google Sheet Error: ' . $e->getMessage());
    //         return back()->with('error', 'เกิดข้อผิดพลาดในการส่งข้อมูล');
    //     }
    // }


    public function submitQuiz(Request $request)
{
    try {
        // ✅ ดึงข้อมูลส่วนตัวจาก Session (เก็บจากหน้าแรก)
        $userInfo = session('user_info', []);

        // ✅ ดึงคำตอบทั้งหมดจากฟอร์ม
        $answers = $request->input('answers', []);

        // ✅ ตรวจว่ามีข้อมูลหรือไม่
        if (empty($userInfo) || empty($answers)) {
            return back()->with('error', 'ข้อมูลไม่ครบ กรุณากรอกใหม่อีกครั้ง');
        }

        // ✅ จัดเรียงข้อมูลก่อนบันทึกลงชีต
        $row = [
            now()->format('Y-m-d H:i:s'),
            $userInfo['gender'] ?? '',
            $userInfo['age'] ?? '',
            $userInfo['career'] ?? '',
            $userInfo['province'] ?? '',
            $userInfo['income'] ?? '',
        ];

        // ✅ เพิ่มคำตอบแต่ละข้อเข้าไปต่อท้าย
        foreach ($answers as $ans) {
            $row[] = $ans;
        }

      //  dd($row);

        // ✅ บันทึกลง Google Sheet
        $this->googleSheet->appendRowFlexible(
            $this->spreadsheetId,
            $this->sheetName,
            $row
        );

        // ✅ เคลียร์ session หลังบันทึกเสร็จ
        $request->session()->forget('user_info');

        return redirect('/result')->with('success', 'ส่งข้อมูลเรียบร้อยแล้ว!');
    } catch (\Exception $e) {
        \Log::error('Google Sheet Error: ' . $e->getMessage());
        return back()->with('error', 'เกิดข้อผิดพลาดในการส่งข้อมูล');
    }
}



    public function storeUserInfo(Request $request)
    {
        $validated = $request->validate([
            'gender' => 'required|string',
            'age' => 'required|numeric|min:1|max:120',
            'career' => 'required|string',
            'province' => 'required|string',
            'income' => 'required|string',
        ]);

        // ✅ เก็บไว้ใน session
        session(['user_info' => $validated]);

        // ✅ ไปหน้า intro_quiz
        return redirect('/intro_quiz');
    }

}
