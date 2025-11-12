<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ Admin Honor</title>

    {{-- ฟอนต์ไทยแบบเดียวกับหน้า receipts --}}
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Bootstrap (ง่ายสุด ใช้ CDN) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: "Kanit", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #f5f5f5;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.10);
            max-width: 420px;
            width: 100%;
            padding: 32px 30px 28px;
        }

        .login-title {
            font-size: 22px;
            font-weight: 600;
        }

        .login-subtitle {
            font-size: 13px;
            color: #6b7280;
        }

        .btn-login {
            border-radius: 999px;
            padding: 10px 20px;
            font-weight: 500;
        }

        .brand-title {
            font-size: 18px;
            font-weight: 600;
        }

        .small-link {
            font-size: 13px;
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="login-card">

        {{-- หัว --}}
        <div class="mb-4 text-center">
            <div class="brand-title mb-1">HONOR Campaign Admin</div>
            <div class="login-subtitle">เข้าสู่ระบบเพื่อจัดการกิจกรรม & รายการใบเสร็จ</div>
        </div>

        {{-- แสดง error --}}
        @if ($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ฟอร์ม login --}}
        <form method="POST" action="{{ route('adminHonor.login.post') }}">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">ชื่อผู้ใช้</label>
                <input type="text"
                    name="username"
                    id="username"
                    value="{{ old('username') }}"
                    class="form-control"
                    placeholder="admin001"
                    required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">รหัสผ่าน</label>
                <input type="password"
                       name="password"
                       id="password"
                       class="form-control"
                       placeholder="••••••••"
                       required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">
                        จดจำการเข้าสู่ระบบ
                    </label>
                </div>
                {{-- ถ้ามีลิงก์ลืมรหัสผ่านค่อยมาเพิ่มตรงนี้ --}}
            </div>

            <div class="d-grid mb-2">
                <button type="submit" class="btn btn-dark btn-login">
                    เข้าสู่ระบบ
                </button>
            </div>

            <div class="text-center small-link mt-2 text-muted">
                ใช้สำหรับทีมงานแคมเปญ HONOR เท่านั้น
            </div>
        </form>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
