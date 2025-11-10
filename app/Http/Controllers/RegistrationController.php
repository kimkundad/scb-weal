<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\participant_receipt;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    //
    public function showPhoneForm()
    {
        return view('honor.regis_honor');
    }

    public function storePhone(Request $request)
    {
       // dd($request->phone);
        $request->validate([
            'phone' => ['required','digits:10']
        ]);
        // เก็บเบอร์โทรใน session
        $request->session()->put('phone', $request->phone);

      //  dd(session()->get('phone'));

        return redirect('/regis_user_data');
    }


    public function showUserDataForm(Request $request)
    {
        if (!$request->session()->has('phone')) {
            return redirect('/regis_honor');
        }
        return view('honor.regis_user_data');
    }

    public function storeUserData(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'province'   => 'required|string|max:255',
        ]);

        // เก็บข้อมูลเพิ่มเติมใน session
        $request->session()->put('user_data', $request->only(
            'first_name','last_name','email','province'
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

    public function storeUpload(Request $request)
    {
        $request->validate([
            'purchase_date'   => 'required|date',
            'purchase_time'   => 'required',
            'receipt_number'  => 'required|string|max:255',
            'imei'            => ['required','digits:15'],
            'store_name'      => 'required|string|max:255',
            'receipt_file'    => 'required|file|mimes:jpg,jpeg,png,pdf|max:8120', // 5MB
        ]);

        // ดึงข้อมูล session
        $phone     = $request->session()->get('phone');
        $userData  = $request->session()->get('user_data');

        // อัปโหลดไฟล์
      //  $path = $request->file('receipt_file')->store('receipts', 'public');

        $filename = 'honor/receipt_file/' . uniqid() . '.' . $request->file('receipt_file')->getClientOriginalExtension();
        Storage::disk('spaces')->put($filename, file_get_contents($request->file('receipt_file')), 'public');

        $fullUrl = config('filesystems.disks.spaces.url') . '/' . $filename;

        // สร้าง record ใหม่
        participant_receipt::create(array_merge([
            'phone'             => $phone,
            'purchase_date'     => $request->purchase_date,
            'purchase_time'     => $request->purchase_time,
            'receipt_number'    => $request->receipt_number,
            'imei'              => $request->imei,
            'store_name'        => $request->store_name,
            'receipt_file_path' => $fullUrl,
        ], $userData));

        // ล้าง session ที่ใช้แล้ว
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

    public function showDashboard(Request $request)
    {
        $phone = $request->input('phone') ?? $request->session()->get('phone');

        if (!$phone) {
            return redirect('/my-rights');
        }

        // เก็บหรืออัปเดตเบอร์โทรใน session
        $request->session()->put('phone', $phone);

        $receipts = participant_receipt::where('phone', $phone)->latest()->get();
        $totalApproved = $receipts->where('status', 'approved')->count();

        return view('honor.dashboard', compact('receipts', 'totalApproved'));
    }

}
