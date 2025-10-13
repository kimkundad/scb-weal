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


//     public function submitQuiz(Request $request)
// {
//     try {
//         // ✅ ดึงข้อมูลส่วนตัวจาก Session (เก็บจากหน้าแรก)
//         $userInfo = session('user_info', []);

//         // ✅ ดึงคำตอบทั้งหมดจากฟอร์ม
//         $answers = $request->input('answers', []);

//         // ✅ ตรวจว่ามีข้อมูลหรือไม่
//         if (empty($userInfo) || empty($answers)) {
//             return back()->with('error', 'ข้อมูลไม่ครบ กรุณากรอกใหม่อีกครั้ง');
//         }

//         // ✅ จัดเรียงข้อมูลก่อนบันทึกลงชีต
//         $row = [
//             now()->format('Y-m-d H:i:s'),
//             $userInfo['gender'] ?? '',
//             $userInfo['age'] ?? '',
//             $userInfo['career'] ?? '',
//             $userInfo['province'] ?? '',
//             $userInfo['income'] ?? '',
//         ];

//         // ✅ เพิ่มคำตอบแต่ละข้อเข้าไปต่อท้าย
//         foreach ($answers as $ans) {
//             $row[] = $ans;
//         }

//       //  dd($row);

//         // ✅ บันทึกลง Google Sheet
//         $this->googleSheet->appendRowFlexible(
//             $this->spreadsheetId,
//             $this->sheetName,
//             $row
//         );

//         // ✅ เคลียร์ session หลังบันทึกเสร็จ
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
                // ✅ ดึงข้อมูลส่วนตัวจาก Session
                $userInfo = session('user_info', []);

                // ✅ ดึงคำตอบทั้งหมดจากฟอร์ม
                $answers = $request->input('answers', []);

            //    dd($answers);

                // ✅ ตรวจสอบว่ามีข้อมูลหรือไม่
                if (empty($userInfo) || empty($answers)) {
                    return back()->with('error', 'ข้อมูลไม่ครบ กรุณากรอกใหม่อีกครั้ง');
                }

                // ✅ เตรียมข้อมูลสำหรับ Google Sheet
                // เริ่มตั้งแต่ row 2 โดยใช้ appendRowFlexible
                $row = [
                    now('Asia/Bangkok')->format('Y-m-d H:i:s'),
                    $userInfo['gender'] ?? '',
                    $userInfo['age'] ?? '',
                ];

                // ✅ เพิ่มคำตอบทั้ง 7 ข้อเข้าไป
                foreach ($answers as $ans) {
                    $row[] = $ans;
                }

                // ✅ ส่งไป Google Sheets
                $this->googleSheet->appendRowFlexible(
                    $this->spreadsheetId,
                    $this->sheetName,
                    $row
                );

                // ✅ เก็บคำตอบไว้ใน session เพื่อใช้ตอนคำนวณ result
                session(['quiz_answers' => $answers]);

                // ✅ เคลียร์ session หลังบันทึกเสร็จ
                $request->session()->forget('user_info');


                // ✅ ไปหน้า result
                return redirect('/result')->with('success', 'ส่งข้อมูลเรียบร้อยแล้ว!');
            } catch (\Exception $e) {
                \Log::error('Google Sheet Error: ' . $e->getMessage());
                return back()->with('error', 'เกิดข้อผิดพลาดในการส่งข้อมูล');
            }
        }


    public function storeUserInfo(Request $request)
    {
        // ✅ validate เฉพาะ 2 ฟิลด์ที่เหลืออยู่
        $validated = $request->validate([
            'gender' => 'required|string',
            'age' => 'required|string|max:50', // วัน/เดือน/ปีเกิดเป็นข้อความ (ไม่ numeric แล้ว)
        ]);

        // ✅ เก็บลง session
        session(['user_info' => $validated]);

        // ✅ ไปหน้า intro_quiz ต่อ
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
                'title' => 'เติมมุมบองความมั่นไอให้ตัวคุณ ด้วยพลังเริ่มต้นใหม่ใหม่เขียว',
                'subtitle' => 'สีเขียว แทนพลังธาตุไม้ที่พร้อมก่อเกิดงอกงามทุกเวลา',
                'desc' => 'ความมั่นใจในตัวคุณ เกิดจากความกล้าที่จะเริ่มต้นในสิ่งที่คุณเชื่อ แม้จะเป็นสิ่งใหม่ที่ไม่เคยมีมาก่อน การเปิดใจเรียนรู้ทุกประสบการณ์ คือกุญแจสำคัญของคุณ',
                'footer' => 'ลองเติมมุมมองนี้ด้วยแว่นตาปางแห่งการริเริ่มสร้างสรรค์ ...',
                'path' => '2'
            ],
            'C' => [
                'color_main' => '#BF888A',
                'color_sub' => '#574319',
                'color_desc' => '#AB3B3F',
                'color_footer' => '#574319',
                'bg' => 'linear-gradient(180deg, rgba(253, 231, 226, 1) 0%, rgba(249, 192, 119, 1) 51%, rgba(211, 61, 55, 1) 100%)',
                'title' => 'เติมมุมมองความมั่นใจให้ตัวคุณ ด้วยความกล้าแกร่งแบบสีแดง',
                'subtitle' => 'สีแดง แทนพลังธาตุไฟที่ก้าวข้ามทุกอุปสรรคด้วยความกระตือรือร้น',
                'desc' => 'ความมั่นใจในตัวคุณ เกิดจากความไม่ย่อท้อต่อความท้าทาย การลงมือทำอย่างเชื่อมั่นในพลังที่ตัวเองมี จะสร้างการเปลี่ยนแปลงให้คุณได้ในที่สุด',
                'footer' => 'ลองเติมมุมมองนี้ด้วยแว่นตาปางอำนาจบารมี ...',
                'path' => '3'
            ],
            'D' => [
                'color_main' => '#A29FB4',
                'color_sub' => '#574319',
                'color_desc' => '#6359A2',
                'color_footer' => '#574319',
                'bg' => 'linear-gradient(180deg, rgba(253, 231, 226, 1) 0%, rgba(249, 224, 194, 1) 51%, rgba(162, 159, 180, 1) 100%)',
                'title' => 'เติมมุมมองความมั่นใจให้ตัวคุณ ด้วยความกล้าที่จะเป็นตัวเองของสีม่วง',
                'subtitle' => 'สีม่วง แทนพลังธาตุลมที่เต็มไปด้วยความเปิดกว้างและอิสระ',
                'desc' => 'ความมั่นใจในตัวคุณ เกิดจากการได้แสดงความเป็นตัวเองอย่างสร้างสรรค์ เพียงคุณรักในสิ่งที่เป็น พลังงานภายในของคุณจะไม่มีวันลดลง',
                'footer' => 'ลองเติมมุมมองนี้ด้วยแว่นตาปางแห่งเบตตามหานิยม ...',
                'path' => '4'
            ],
            'E' => [
                'color_main' => '#C2CFD4',
                'color_sub' => '#574319',
                'color_desc' => '#3F6776',
                'color_footer' => '#574319',
                'bg' => 'linear-gradient(180deg, rgba(253, 231, 226, 1) 0%, rgba(249, 224, 194, 1) 51%, rgba(194, 207, 212, 1) 100%)',
                'title' => 'เติมมุมมมองความมั่นใจให้ตัวคุณ ด้วยความรื่นรมย์เบาสบายเเบบสีน้ำเงิน',
                'subtitle' => 'สีน้ำเงิน แทนพลังธาตุน้ำที่มีปัญญาลึกซึ้งและลื่นไหลปรับตัวได้',
                'desc' => 'ความมั่นใจในตัวคุณ เกิดจากความไว้วางใจในตนเองและการใคร่ครวญอย่างมีสติ ความคิดลุ่มลึกในช่วงเวลาแห่งความสงบ จะนำพาความสบายใจและคำตอบที่แท้จริงมาสู่คุณ',
                'footer' => 'ลองเติมมุมบองนี้ด้วยแว่นตาปางแห่งความสำเร็จสบปรารถนา ...',
                'path' => '5'
            ],
            'F' => [
                'color_main' => '#6F5B45',
                'color_sub' => '#574319',
                'color_desc' => '#31200E',
                'color_footer' => '#574319',
                'bg' => 'linear-gradient(180deg, rgba(253, 231, 226, 1) 0%, rgba(249, 224, 194, 1) 51%, rgba(194, 207, 212, 1) 100%)',
                'title' => 'เติมมุมมองความมั่นใจให้ตัวคุณ ด้วยพลังธรรมชาติที่มั่นคงของสีน้ำตาตาล',
                'subtitle' => 'สีน้ำตาล แทนพลังธาตุดินที่เป็นความมั่นคงให้ตัวเองและคนรอบข้าง',
                'desc' => 'ความมั่นใจในตัวคุณ เกิดจากการได้เชื่อมต่อกับผู้คนที่มีความหมายความชื่อสัตย์ มิตรภาพ และความเป็นกันเอง จะดึงดูดผู้คนและการสนับสนุนที่ใช่มาสู่ชีวิตคุณ',
                'footer' => 'ลองเติมมุมมองนี้ด้วยแว่นตาแป้งแห่งวาทศิลป์ ...',
                'path' => '6'
            ],
        ];


        // ✅ ดึงคำตอบจาก session
    $answers = session('quiz_answers', []);

    if (empty($answers)) {
        return redirect('/')->with('error', 'ไม่พบคำตอบในระบบ');
    }

    // ✅ Mapping จาก index → product key
    $map = ['1' => 'A', '2' => 'B', '3' => 'C', '4' => 'D', '5' => 'E', '6' => 'F'];

    // ✅ ถ้ามีข้อ 8 → ใช้ข้อ 8 เป็นหลัก
    if (count($answers) >= 8 && isset($answers[7])) {
        $choice8 = $answers[7];
        $selectedKey = $map[$choice8] ?? 'A';
    } else {
        // ✅ นับจำนวนการเลือกในข้อ 1–7
        $count = array_fill(1, 6, 0); // 1–6

        foreach (array_slice($answers, 0, 7) as $ans) {
            foreach ($map as $num => $letter) {
                if (strpos($ans, $num) !== false) {
                    $count[$num]++;
                }
            }
        }

        // ✅ หาค่ามากสุด
        $max = max($count);
        $topChoices = array_keys($count, $max);

        if (count($topChoices) > 1) {
            // ❌ มีเสมอกันมากกว่า 1 → ต้องตอบข้อ 8 เท่านั้น
            return redirect('/quiz?show=8')
                ->with('error', 'มีคะแนนเสมอกัน กรุณาทำข้อ 8 เพื่อสรุปผลลัพธ์');
        }

        // ✅ ไม่มีเสมอ → ใช้ choice ที่ได้คะแนนสูงสุด
        $selectedKey = $map[$topChoices[0]] ?? 'A';
    }

    // ✅ ดึงข้อมูลสินค้า
    $product = $products[$selectedKey];

    return view('owndays.resulte', compact('product'));
    }

}
