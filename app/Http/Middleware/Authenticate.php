<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {

            // ✅ ถ้าเป็นเส้นทางของ honor admin
            if (
                $request->is('admin-honor/*') ||                 // URL path ขึ้นต้นด้วย admin-honor
                $request->routeIs('adminHonor.*') ||             // ชื่อ route ขึ้นต้นด้วย adminHonor.
                $request->getHost() === 'honor.mawathecreation.com' // หรือมาจากโดเมน honor โดยตรง
            ) {
                return route('adminHonor.login');
            }

            // ✅ เคสอื่น ๆ ใช้ login เดิมของระบบ
            return route('login');
        }

        return null;
    }
}
