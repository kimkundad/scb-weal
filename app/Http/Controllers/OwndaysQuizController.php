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


    public function showResult()
    {
        // สินค้าทั้งหมดพร้อมรายละเอียด
        $products = [
            'A' => [
                'color_main' => '#E2C391',
                'color_sub' => '#574319',
                'color_desc' => '#9B8462',
                'color_footer' => '#574319',
                'bg' => 'linear-gradient(180deg, rgba(253, 231, 226, 1) 0%, rgba(245, 212, 168, 1) 50%, rgba(230, 185, 123, 1) 100%)',
                'title' => 'เติมมุมมองความมั่นใจให้ตัวคุณ ด้วยประกายโดดเด่นในพลังของสีทอง',
                'subtitle' => 'แทนพลังธาตุทองแห่งความชัดเจนในตัวตนที่นำมาสู่ความมั่งมีและอุดมสมบูรณ์',
                'desc' => 'ความมั่นใจในตัวคุณ เกิดจากการตระหนักว่าคุณสามารถก้าวเดินบนเส้นทางแห่งการเติบโตได้ด้วยตัวเอง<br>ทุกความสำเร็จ ไม่ว่าเล็กหรือใหญ่ จะเป็นเข็มทิศที่พาคุณไปข้างหน้าอย่างมั่นใจ',
                'footer' => 'ลองเติมมุมมองนี้ด้วยแว่นตาปางประกานพร ...',
                'path' => '1'
            ],
            'B' => [
                'color_main' => '#C8D9C0',
                'color_sub' => '#574319',
                'color_desc' => '#506C4F',
                'color_footer' => '#574319',
                'bg' => 'linear-gradient(180deg, rgba(253, 231, 226, 1) 0%, rgba(245, 212, 168, 1) 51%, rgba(155, 183, 154, 1) 100%)',
                'title' => 'เติมมุมมองความมั่นใจให้ตัวคุณ ด้วยประกายแห่งความเขียวธรรมชาติ',
                'subtitle' => 'แทนพลังแห่งความสงบและการเติบโตในเส้นทางของตัวเอง',
                'desc' => 'ความมั่นใจของคุณเกิดจากความเรียบง่ายและความมั่นคง<br>การเติบโตในแบบของตัวเองคือความสำเร็จที่แท้จริง',
                'footer' => 'ลองเติมมุมมองนี้ด้วยแว่นตาปางประกานพร ...',
                'path' => '2'
            ],
            'C' => [
                'color_main' => '#BF888A',
                'color_sub' => '#574319',
                'color_desc' => '#AB3B3F',
                'color_footer' => '#574319',
                'bg' => 'linear-gradient(180deg, rgba(253, 231, 226, 1) 0%, rgba(249, 192, 119, 1) 51%, rgba(211, 61, 55, 1) 100%)',
                'title' => 'เติมมุมมองความมั่นใจให้ตัวคุณ ด้วยพลังสีชมพูอบอุ่น',
                'subtitle' => 'แทนพลังแห่งความรัก ความเข้าใจ และความจริงใจต่อชีวิต',
                'desc' => 'ความมั่นใจของคุณเกิดจากความอ่อนโยนและศรัทธาในตัวเอง<br>ความอบอุ่นของคุณคือแรงบันดาลใจให้กับผู้คนรอบข้าง',
                'footer' => 'ลองเติมมุมมองนี้ด้วยแว่นตาปางประกานพร ...',
                'path' => '3'
            ],
            'D' => [
                'color_main' => '#A29FB4',
                'color_sub' => '#574319',
                'color_desc' => '#5F5C6E',
                'color_footer' => '#574319',
                'bg' => 'linear-gradient(180deg, rgba(253, 231, 226, 1) 0%, rgba(249, 224, 194, 1) 51%, rgba(162, 159, 180, 1) 100%)',
                'title' => 'เติมมุมมองแห่งความสงบและมั่นคงในพลังสีเทา',
                'subtitle' => 'แทนความสมดุลของเหตุผลและความรู้สึก',
                'desc' => 'ความมั่นใจของคุณเกิดจากการเข้าใจตัวเองอย่างลึกซึ้ง<br>และพร้อมยืนหยัดในสิ่งที่เชื่ออย่างมั่นคง',
                'footer' => 'ลองเติมมุมมองนี้ด้วยแว่นตาปางประกานพร ...',
                'path' => '4'
            ],
            'E' => [
                'color_main' => '#C2CFD4',
                'color_sub' => '#574319',
                'color_desc' => '#5A707A',
                'color_footer' => '#574319',
                'bg' => 'linear-gradient(180deg, rgba(253, 231, 226, 1) 0%, rgba(249, 224, 194, 1) 51%, rgba(194, 207, 212, 1) 100%)',
                'title' => 'เติมมุมมองแห่งความสงบเยือกเย็นและความลึกซึ้งในสีฟ้าเทา',
                'subtitle' => 'แทนความสบายใจ ความเรียบง่าย และความมั่นคงในใจ',
                'desc' => 'คุณมั่นใจในความสงบของตนเอง และพร้อมส่งพลังบวกไปให้คนรอบข้าง<br>เส้นทางของคุณคือความเรียบง่ายที่เปี่ยมด้วยความหมาย',
                'footer' => 'ลองเติมมุมมองนี้ด้วยแว่นตาปางประกานพร ...',
                'path' => '5'
            ],
        ];


        // ✅ สุ่มสินค้า 1 ตัว
        $randomKey = array_rand($products);
        $product = $products[$randomKey];

        return view('owndays.resulte', compact('product'));
    }

}
