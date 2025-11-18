<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\participant_receipt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    //
    public function showPhoneForm()
    {
        return view('honor.regis_honor');
    }

    // public function storePhone(Request $request)
    // {
    //  //   dd($request->phone);
    //     $request->validate([
    //         'phone' => ['required']
    //     ]);
    //     // เก็บเบอร์โทรใน session
    //     $request->session()->put('phone', $request->phone);

    //   //  dd(session()->get('phone'));

    //     return redirect('/regis_user_data');
    // }


    public function storePhone(Request $request)
    {
        $request->validate([
            'phone' => ['required']
        ]);

        $request->session()->forget('phone');

        // ล้างขีด 099-999-9999 → 0999999999
        $phone = str_replace('-', '', $request->phone);
     //   dd($phone);
        // เช็คเบอร์ซ้ำ
        $exists = participant_receipt::where('phone', $phone)->exists();

        if ($exists) {
            return back()->with([
                'phone_exists' => true,
                'phone_value' => $phone
            ]);
        }

        // หากไม่ซ้ำ เก็บเบอร์โทรใน session
        $request->session()->put('phone', $request->phone);

        return redirect('/regis_user_data');
    }



    public function showUserDataForm(Request $request)
    {
        if (!$request->session()->has('phone')) {
            return redirect('/regis_honor');
        }
        return view('honor.regis_user_data');
    }

    // public function storeUserData(Request $request)
    // {
    //     $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'last_name'  => 'required|string|max:255',
    //         'email'      => 'required|email|max:255',
    //         'province'   => 'required|string|max:255',
    //     ]);

    //     // เก็บข้อมูลเพิ่มเติมใน session
    //     $request->session()->put('user_data', $request->only(
    //         'first_name','last_name','email','province'
    //     ));

    //     return redirect('/regis_user_upslip');
    // }

    public function storeUserData(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'province'   => 'required|string|max:255',
            'hbd'        => 'required|date|before:today',
        ]);

     //   dd($request->hbd);

        // เช็คอีเมลซ้ำ
        $emailExists = participant_receipt::where('email', $request->email)->exists();

        if ($emailExists) {
            return back()->with([
                'email_exists' => true,
                'email_value' => $request->email
            ]);
        }

        // เก็บ user data ลง session
        $request->session()->put('user_data', $request->only(
            'first_name','last_name','email','province','hbd'
        ));

        return redirect('/regis_user_upslip');
    }



    public function showUploadForm(Request $request)
    {
        if (!$request->session()->has('phone') || !$request->session()->has('user_data')) {
            return redirect('/regis_honor');
        }
        return view('honor.regis_user_upslip');
    }

    // public function storeUpload(Request $request)
    // {
    //     $request->validate([
    //         'purchase_date'   => 'required|date',
    //         'purchase_time'   => 'required',
    //         'receipt_number'  => 'required|string|max:255',
    //         'imei'            => ['required','digits:15'],
    //         'store_name'      => 'required|string|max:255',
    //         'receipt_file'    => 'required|file|mimes:jpg,jpeg,png,pdf|max:8120', // 5MB
    //     ]);

    //     // ดึงข้อมูล session
    //     $phone     = $request->session()->get('phone');
    //     $userData  = $request->session()->get('user_data');

    //     // อัปโหลดไฟล์
    //   //  $path = $request->file('receipt_file')->store('receipts', 'public');

    //     $filename = 'honor/receipt_file/' . uniqid() . '.' . $request->file('receipt_file')->getClientOriginalExtension();
    //     Storage::disk('spaces')->put($filename, file_get_contents($request->file('receipt_file')), 'public');

    //     $fullUrl = config('filesystems.disks.spaces.url') . '/' . $filename;

    //     // สร้าง record ใหม่
    //     participant_receipt::create(array_merge([
    //         'phone'             => $phone,
    //         'purchase_date'     => $request->purchase_date,
    //         'purchase_time'     => $request->purchase_time,
    //         'receipt_number'    => $request->receipt_number,
    //         'imei'              => $request->imei,
    //         'store_name'        => $request->store_name,
    //         'receipt_file_path' => $fullUrl,
    //     ], $userData));

    //     // ล้าง session ที่ใช้แล้ว
    //    // $request->session()->forget(['phone','user_data']);

    //     return redirect('/regis_confirm');
    // }




public function storeUpload(Request $request)
{
    $request->validate([
        'purchase_date'   => 'required|date',
        'purchase_time'   => 'required',
        'receipt_number'  => 'required|string|max:255',
        'imei'            => ['required','digits:15'],
        'store_name'      => 'required|string|max:255',
        'receipt_file'    => 'required|file|mimes:jpg,jpeg,png,pdf|max:8120',
    ]);

    // ดึงข้อมูล session
    $phone     = $request->session()->get('phone');
    $userData  = $request->session()->get('user_data');

    // ตรวจสอบ IMEI อีกครั้งแบบ Backend → กันโกง 100%
    $imeiRow = DB::table('honor_imei_list')->where('imei', $request->imei)->first();

    if (!$imeiRow) {
        return back()->withErrors(['imei' => 'ไม่พบหมายเลข IMEI นี้ในระบบ!']);
    }

    if ($imeiRow->used == 1) {
        return back()->withErrors(['imei' => 'หมายเลข IMEI นี้ถูกใช้สิทธิ์แล้ว!']);
    }

    // อัปโหลดไฟล์ไป Spaces
    $filename = 'honor/receipt_file/' . uniqid() . '.' .
                $request->file('receipt_file')->getClientOriginalExtension();

    Storage::disk('spaces')->put($filename, file_get_contents($request->file('receipt_file')), 'public');

    $fullUrl = config('filesystems.disks.spaces.url') . '/' . $filename;

    // บันทึกใบเสร็จ
    participant_receipt::create(array_merge([
        'phone'             => $phone,
        'purchase_date'     => $request->purchase_date,
        'purchase_time'     => $request->purchase_time,
        'receipt_number'    => $request->receipt_number,
        'imei'              => $request->imei,
        'store_name'        => $request->store_name,
        'receipt_file_path' => $fullUrl,
    ], $userData));

    // ✅ บันทึกว่า IMEI ใช้ไปแล้ว
    DB::table('honor_imei_list')
        ->where('imei', $request->imei)
        ->update(['used' => true]);

    // ล้าง session ถ้าต้องการ
    // $request->session()->forget(['phone','user_data']);

    return redirect('/regis_confirm');
}


    public function showConfirm()
    {
        return view('honor.regis_confirm');
    }

    public function showLoginOrRedirect(Request $request)
{
    // แสดง my_rights เสมอ (ไม่ redirect แล้ว)
    return view('honor.my_rights');
}

    // public function showDashboard(Request $request)
    // {
    //     $phone = $request->input('phone') ?? $request->session()->get('phone');
    //     dd($phone);

    //     if (!$phone) {
    //         return redirect('/my-rights');
    //     }

    //     // เก็บหรืออัปเดตเบอร์โทรใน session
    //     $request->session()->put('phone', $phone);

    //     $receipts = participant_receipt::where('phone', $phone)->latest()->get();
    //     $totalApproved = $receipts->where('status', 'approved')->count();

    //     return view('honor.dashboard', compact('receipts', 'totalApproved'));
    // }


    public function showDashboard(Request $request)
    {
        // รับจาก query string
        $phone = $request->input('phone');

        if ($phone) {
            // แปลง 095-846-7741 → 0958467741
            $phone = str_replace('-', '', $phone);

            // เก็บลง session ใหม่
            $request->session()->put('phone', $phone);
        } else {
            // fallback: ใช้จาก session หากไม่มี query
            $phone = $request->session()->get('phone');
        }

        if (!$phone) {
            return redirect('/my-rights');
        }

      //  dd($phone);

        // Query ข้อมูลตามเบอร์
        $receipts = participant_receipt::where('phone', $phone)->latest()->get();
        $totalApproved = $receipts->where('status', 'approved')->count();

        return view('honor.dashboard', compact('receipts', 'totalApproved'));
    }


    public function showDashboard2(Request $request)
    {
        // ดึงจาก ?email=xxx หากมี
        $email = $request->query('email') ?? $request->session()->get('email');

        if (!$email) {
            return redirect('/regis_user_data');
        }

        // บันทึกลง session เผื่อใช้ต่อ
        $request->session()->put('email', $email);

        // ดึงข้อมูลของผู้ใช้
        $receipts = participant_receipt::where('email', $email)->latest()->get();
        $totalApproved = $receipts->where('status', 'approved')->count();

        return view('honor.dashboard', compact('receipts', 'totalApproved'));
    }

    public function checkImei(Request $request)
{
    $request->validate([
        'imei' => 'required|digits:15'
    ]);

    // ค้นหา IMEI ในฐานข้อมูล
    $imei = DB::table('honor_imei_list')->where('imei', $request->imei)->first();

    // ไม่พบ IMEI
    if (!$imei) {
        return response()->json([
            'valid' => false,
            'used' => false,
            'message' => 'ไม่พบหมายเลข IMEI นี้ในระบบ'
        ]);
    }

    // พบ IMEI → ต้องตรวจสอบว่าถูกใช้แล้วหรือยัง
    if ($imei->used == 1) {
        return response()->json([
            'valid' => false,
            'used' => true,
            'message' => 'หมายเลข IMEI นี้ถูกใช้สิทธิ์แล้ว'
        ]);
    }

    // ใช้งานได้
    return response()->json([
        'valid' => true,
        'used' => false,
        'message' => 'IMEI ถูกต้องและยังไม่ถูกใช้งาน'
    ]);
}


}
