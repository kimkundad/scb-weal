<?php

namespace App\Http\Controllers\AdminHonor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * แสดงหน้าฟอร์ม login
     */
    public function showLoginForm()
    {
        return view('adminHonor.auth.login');
    }

    /**
     * รับข้อมูลจากฟอร์ม login
     */
    public function login(Request $request)
    {
        // เปลี่ยนจาก email -> username
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        // ----- เลือกใช้ username -----
        if (Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('adminHonor.receipts.index'));
        }

        // ----- ถ้าอยากให้ name ก็ใช้บล็อกนี้แทนด้านบน -----
        /*
        if (Auth::attempt([
            'name' => $credentials['username'],
            'password' => $credentials['password'],
        ], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('adminHonor.receipts.index'));
        }
        */

        return back()->withErrors([
            'username' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
        ])->onlyInput('username');
    }

    /**
     * logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('adminHonor.login');
    }
}
