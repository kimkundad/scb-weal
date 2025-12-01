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

    public function editProfile(Request $request)
    {
        $phone = $request->session()->get('phone');

        if (!$phone) {
            return redirect('/regis_honor')->withErrors(['กรุณาเข้าสู่ระบบ']);
        }

        // ดึงข้อมูลล่าสุดของผู้ใช้
        $user = participant_receipt::where('phone', $phone)
            ->orderBy('id', 'desc')
            ->first();

        if (!$user) {
            return redirect('/regis_honor')->withErrors(['ไม่พบข้อมูลผู้ใช้']);
        }

        return view('honor.edit_profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $phone = $request->session()->get('phone');

        if (!$phone) {
            return redirect('/regis_honor')->withErrors(['session หมดอายุ']);
        }
      //  dd($request->all());
        $request->validate([
            'prefix'      => 'required|string|max:20',
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'hbd'         => 'required',
            'id_type'     => 'required|in:citizen,passport',
            'citizen_id'  => 'nullable|required_if:id_type,citizen|digits:13',
            'passport_id' => 'nullable|required_if:id_type,passport|string|min:6',
            'email'       => 'required|email|max:255',
            'province'    => 'required|string|max:255',
        ]);

        participant_receipt::where('phone', $phone)->update([
            'prefix'      => $request->prefix,
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'hbd'         => $request->hbd,
            'id_type'     => $request->id_type,
            'citizen_id'  => $request->citizen_id,
            'passport_id' => $request->passport_id,
            'email'       => $request->email,
            'province'    => $request->province,
        ]);

        return redirect('/dashboard')->with('success', 'อัปเดตข้อมูลสำเร็จ!');
    }



    public function storePhone(Request $request)
    {
        $request->validate([
            'phone' => ['required']
        ]);

      //  $request->session()->forget('phone');

        // ล้างขีด 099-999-9999 → 0999999999
       // $phone = str_replace('-', '', $request->phone);
       // dd($request->phone);
        // เช็คเบอร์ซ้ำ
        $phone = $request->phone;
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

    // public function storeUserData(Request $request)
    // {
    //     $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'last_name'  => 'required|string|max:255',
    //         'email'      => 'required|email|max:255',
    //         'province'   => 'required|string|max:255',
    //         'hbd'        => 'required|date|before:today',
    //     ]);

    //  //   dd($request->hbd);

    //     // เช็คอีเมลซ้ำ
    //     $emailExists = participant_receipt::where('email', $request->email)->exists();

    //     if ($emailExists) {
    //         return back()->with([
    //             'email_exists' => true,
    //             'email_value' => $request->email
    //         ]);
    //     }

    //     // เก็บ user data ลง session
    //     $request->session()->put('user_data', $request->only(
    //         'first_name','last_name','email','province','hbd'
    //     ));

    //     return redirect('/regis_user_upslip');
    // }


    // public function storeUserData(Request $request)
    // {

    //   //  dd($request->all());
    //     // -------------------------------
    //     // 1) Validate ฟอร์ม
    //     // -------------------------------

    //     if (empty($request->hbd)) {
    //         $request->merge([
    //             'hbd' => '2007-01-01'  // 1 มกราคม 2550
    //         ]);
    //     }



    //     $request->validate([
    //         'prefix'      => 'required|string|max:20',
    //         'first_name'  => 'required|string|max:255',
    //         'last_name'   => 'required|string|max:255',
    //         'hbd'         => 'required|date|before:-18 years', // ต้องอายุ ≥ 18 ปี
    //         'id_type'     => 'required|in:citizen,passport',
    //         'email'       => 'required|email|max:255',
    //         'province'    => 'required|string|max:255',

    //         // เลือก citizen = ต้องกรอกบัตรประชาชน
    //         'citizen_id'  => 'required_if:id_type,citizen|nullable|digits:13',

    //         // เลือก passport = ต้องกรอกพาสปอร์ต
    //         'passport_id' => 'required_if:id_type,passport|nullable|string|min:6|max:30',
    //     ],
    //     [
    //         'prefix.required'     => 'กรุณาเลือกคำนำหน้า',
    //         'citizen_id.required_if' => 'กรุณากรอกเลขบัตรประชาชน',
    //         'citizen_id.digits'   => 'เลขบัตรประชาชนต้องมี 13 หลัก',
    //         'passport_id.required_if' => 'กรุณากรอกเลขพาสปอร์ต',
    //         'email.email'         => 'รูปแบบอีเมลไม่ถูกต้อง',
    //         'hbd.before'          => 'อายุต้องมากกว่า 18 ปี',
    //     ]);

    //     // -------------------------------
    //     // 2) เช็คอีเมลซ้ำ
    //     // -------------------------------
    //     $emailExists = participant_receipt::where('email', $request->email)->exists();

    //     if ($emailExists) {
    //         return back()->with([
    //             'email_exists' => true,
    //             'email_value' => $request->email
    //         ]);
    //     }

    //     // -------------------------------
    //     // 3) เตรียมข้อมูล identity
    //     // -------------------------------
    //     $identityNumber = $request->id_type === 'citizen'
    //         ? $request->citizen_id       // เลขบัตรประชาชน
    //         : $request->passport_id;     // พาสปอร์ต

    //     // -------------------------------
    //     // 4) บันทึกข้อมูลลง Session
    //     // -------------------------------
    //     $request->session()->put('user_data', [
    //         'prefix'      => $request->prefix,
    //         'first_name'  => $request->first_name,
    //         'last_name'   => $request->last_name,
    //         'hbd'         => $request->hbd,
    //         'id_type'     => $request->id_type,
    //         'citizen_id'  => $request->citizen_id,
    //         'passport_id' => $request->passport_id,
    //         'email'       => $request->email,
    //         'province'    => $request->province,
    //     ]);

    //     // -------------------------------
    //     // 5) Redirect ไปอัปโหลด Slip
    //     // -------------------------------
    //     return redirect('/regis_user_upslip');
    // }


    public function storeUserData(Request $request)
    {
        $request->validate([
            'prefix'      => 'required|string|max:20',
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'hbd'         => 'required',
            'id_type'     => 'required|in:citizen,passport',
            'citizen_id'  => 'nullable|required_if:id_type,citizen|digits:13',
            'passport_id' => 'nullable|required_if:id_type,passport|string|min:6',
            'email'       => 'required|email|max:255',
            'province'    => 'required|string|max:255',
        ]);

        // เช็คอีเมลซ้ำ
        $emailExists = participant_receipt::where('email', $request->email)->exists();

        if ($emailExists) {
            return back()->with([
                'email_exists' => true,
                'email_value' => $request->email
            ]);
        }

        // เก็บข้อมูลลง session
        $request->session()->put('user_data', [
            'prefix'      => $request->prefix,
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'hbd'         => $request->hbd,
            'id_type'     => $request->id_type,
            'citizen_id'  => $request->citizen_id,
            'passport_id' => $request->passport_id,
            'email'       => $request->email,
            'province'    => $request->province,
        ]);

        return redirect('/regis_user_upslip');
    }





    // public function showUploadForm(Request $request)
    // {
    //    // dd($request->session()->has('user_data'));
    //     if (!$request->session()->has('phone') || !$request->session()->has('user_data')) {
    //         return redirect('/regis_honor');
    //     }

    //     return view('honor.regis_user_upslip');
    // }


    public function showUploadForm(Request $request)
{
    $phone = $request->session()->get('phone');
  //  dd($request->session()->get('phone'));

    if (!$phone) {
        return redirect('/regis_honor');
    }

    // ถ้าไม่มี user_data ใน session → ดึงจากฐานข้อมูลแทน
    if (!$request->session()->has('user_data')) {

        $last = participant_receipt::where('phone', $phone)
                ->orderBy('id', 'desc')
                ->first();

        if ($last) {
            $request->session()->put('user_data', [
                'prefix'      => $last->prefix ?? null,
                'first_name'  => $last->first_name ?? null,
                'last_name'   => $last->last_name ?? null,
                'hbd'         => $last->hbd ?? null,
                'id_type'     => $last->id_type ?? null,
                'citizen_id'  => $last->citizen_id ?? null,
                'passport_id' => $last->passport_id ?? null,
                'email'       => $last->email ?? null,
                'province'    => $last->province ?? null,
            ]);
        } else {
            // ไม่มีข้อมูล user จริง ๆ → บังคับกลับไปเริ่มใหม่
            return redirect('/regis_honor');
        }
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




// public function storeUpload(Request $request)
// {
//     $request->validate([
//         'purchase_date'   => 'required|date',
//         'purchase_time'   => 'required',
//         'receipt_number'  => 'required|string|max:255',
//         'imei'            => ['required','digits:15'],
//         'store_name'      => 'required|string|max:255',
//         'receipt_file'    => 'required|file|mimes:jpg,jpeg,png,pdf|max:8120',
//     ]);

//     // ดึงข้อมูล session
//     $phone     = $request->session()->get('phone');
//     $userData  = $request->session()->get('user_data');

//     // ตรวจสอบ IMEI อีกครั้งแบบ Backend → กันโกง 100%
//     $imeiRow = DB::table('honor_imei_list')->where('imei', $request->imei)->first();

//     if (!$imeiRow) {
//         return back()->withErrors(['imei' => 'ไม่พบหมายเลข IMEI นี้ในระบบ!']);
//     }

//     if ($imeiRow->used == 1) {
//         return back()->withErrors(['imei' => 'หมายเลข IMEI นี้ถูกใช้สิทธิ์แล้ว!']);
//     }

//     // อัปโหลดไฟล์ไป Spaces
//     $filename = 'honor/receipt_file/' . uniqid() . '.' .
//                 $request->file('receipt_file')->getClientOriginalExtension();

//     Storage::disk('spaces')->put($filename, file_get_contents($request->file('receipt_file')), 'public');

//     $fullUrl = config('filesystems.disks.spaces.url') . '/' . $filename;

//     // บันทึกใบเสร็จ
//     participant_receipt::create(array_merge([
//         'phone'             => $phone,
//         'purchase_date'     => $request->purchase_date,
//         'purchase_time'     => $request->purchase_time,
//         'receipt_number'    => $request->receipt_number,
//         'imei'              => $request->imei,
//         'store_name'        => $request->store_name,
//         'receipt_file_path' => $fullUrl,
//     ], $userData));

//     // ✅ บันทึกว่า IMEI ใช้ไปแล้ว
//     DB::table('honor_imei_list')
//         ->where('imei', $request->imei)
//         ->update(['used' => true]);

//     // ล้าง session ถ้าต้องการ
//     // $request->session()->forget(['phone','user_data']);

//     return redirect('/regis_confirm');
// }


public function storeUpload(Request $request)
{
    $request->validate([
        'purchase_date' => 'required|date',
        'store_name_select' => 'required|string|max:255',
        'store_name' => 'nullable|string|max:255',
        'imei'          => ['required', 'digits:15'],
    ]);

    // เลือกร้านค้า
    $storeName = $request->store_name_select !== "other"
        ? $request->store_name_select
        : $request->store_name;

    // ดึง session
    $phone    = $request->session()->get('phone');
    $userData = $request->session()->get('user_data');

    if (!$phone || !$userData) {
        return redirect('/')->withErrors(['session' => 'Session หมดอายุ กรุณาเริ่มใหม่อีกครั้ง']);
    }

    // ตรวจสอบ IMEI backend
    $imeiRow = DB::table('honor_imei_list')->where('imei', $request->imei)->first();

    if (!$imeiRow) {
        return back()->withErrors(['imei' => 'ไม่พบหมายเลข IMEI นี้ในระบบ!']);
    }

    if ($imeiRow->used == 1) {
        return back()->withErrors(['imei' => 'หมายเลข IMEI นี้ถูกใช้สิทธิ์แล้ว!']);
    }

    // บันทึกข้อมูลลงฐานข้อมูล participant_receipts
    $new = participant_receipt::create([
        'phone'             => $phone,
        'prefix'            => $userData['prefix']      ?? null,
        'first_name'        => $userData['first_name']  ?? null,
        'last_name'         => $userData['last_name']   ?? null,
        'hbd'               => $userData['hbd']         ?? null,
        'id_type'           => $userData['id_type']     ?? null,
        'citizen_id'        => $userData['citizen_id']  ?? null,
        'passport_id'       => $userData['passport_id'] ?? null,
        'email'             => $userData['email']       ?? null,
        'province'          => $userData['province']    ?? null,

        'purchase_date'     => $request->purchase_date,
        'purchase_time'     => null,
        'receipt_number'    => null,
        'imei'              => $request->imei,
        'store_name'        => $storeName,
        'receipt_file_path' => null,
    ]);

    // อัพเดทสถานะ IMEI ว่า "ใช้แล้ว"
    DB::table('honor_imei_list')
        ->where('imei', $request->imei)
        ->update(['used' => 1]);

    return redirect('/regis_confirm');
}



    public function showConfirm()
    {
        return view('honor.regis_confirm');
    }

    public function showLoginOrRedirect(Request $request)
    {
        // ถ้ามีเบอร์ใน session อยู่แล้ว → ไป dashboard เลย
        if ($request->session()->has('phone')) {
            return redirect('/dashboard');
        }

        // ถ้าไม่มี → แสดงหน้ากรอกเบอร์ (my_rights)
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


    public function goDashboard(Request $request)
    {
        // รับจาก query string
        $phone = $request->input('phone');
        $request->session()->put('phone', $phone);
        if ($phone) {
            // แปลง 095-846-7741 → 0958467741
          //  $phone = str_replace('-', '', $phone);

            // เก็บลง session ใหม่

        } else {
            // fallback: ใช้จาก session หากไม่มี query
            $phone = $request->session()->get('phone');
        }

       // dd($phone);

        if (!$phone) {
            return redirect('/my-rights');
        }

      //  dd($phone);

        // Query ข้อมูลตามเบอร์
        $receipts = participant_receipt::where('phone', $phone)->latest()->get();
        $totalApproved = $receipts->where('status', 'approved')->count();

        return view('honor.dashboard', compact('receipts', 'totalApproved'));
    }




    public function showDashboard(Request $request)
{
    // ดึงเบอร์โทรจาก session เท่านั้น
    $phone = $request->session()->get('phone');

    // ถ้าไม่มี session -> ให้กลับไปกรอกเบอร์ก่อน
    if (!$phone) {
        return redirect('/my-rights');
    }

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
