<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HONOR - ลงทะเบียน</title>
    <link rel="stylesheet" href="{{ url('/home/assets/css/honor.css') }}?v={{ time() }}" />
    <link rel="icon" type="image/x-icon" href="{{ url('/img/honor/favicon.ico') }}">
</head>


<style>
    .captcha-wrapper {
        margin-top: 20px;
    }

    .captcha-box {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin: 10px 0;
    }

    .captcha-text {
        font-size: 24px;
        padding: 8px 18px;
        background: #f1f1f1;
        border-radius: 8px;
        letter-spacing: 4px;
        font-weight: 700;
    }

    .captcha-refresh {
        background: #000;
        color: #fff;
        border: none;
        padding: 8px 14px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
    }

    .captcha-refresh:hover {
        background: #999;
    }

    .captcha-input {
        text-align: center;
        font-size: 20px;
        letter-spacing: 4px;
    }
</style>

<style>
    .alert-box {
        margin-top: 20px;
        padding: 15px;
        background: #fff3cd;
        border: 1px solid #ffeeba;
        border-radius: 12px;
        text-align: center;
    }

    .alert-text {
        font-size: 16px;
        color: #856404;
        margin-bottom: 10px;
    }
</style>

<body>

    <div class="page-wrapper2">
        <!-- Header -->
        <header class="page-header">
            <a href="{{ url('/') }}">
                <img src="{{ url('img/honor/logo@2x.png') }}" alt="HONOR logo" style="margin-left:20px">
            </a>
        </header>

        <!-- Main Content -->
        <main class="page-content">
            <div class="regis-container">
                <h1 class="regis-title">เข้าร่วมกิจกรรมด้วย<br>เบอร์โทรของคุณ</h1>
                <p class="regis-subtitle">กรอกเบอร์โทรศัพท์ของคุณเพื่อเริ่มต้นเข้าร่วมกิจกรรม</p>

                <form method="POST" action="{{ url('/regis_honor') }}" class="regis-form">
                    @csrf
                    <div class="phone-wrapper">
                        <label for="phone" class="phone-label">เบอร์โทรศัพท์มือถือ</label>

                        <input type="text" name="phone" id="phone" class="regis-input phone-input"
                            placeholder="099-999-9999" maxlength="12" inputmode="numeric" >
                    </div>


                    <div class="captcha-wrapper">
                        <label for="captcha_input" class="phone-label">กรอกรหัสยืนยัน (Captcha)</label>

                        <div class="captcha-box">
                            <span id="captcha_text" class="captcha-text"></span>
                            <button type="button" id="refresh_captcha" class="captcha-refresh" style="font-family: 'Anuphan', sans-serif;font-size: 18px;padding: 12px 16px;">↻</button>
                        </div>

                        <input type="text" name="captcha_input" id="captcha_input" class="regis-input captcha-input"
                            placeholder="กรอกรหัส 4 หลัก" maxlength="4" inputmode="numeric" >
                    </div>


                    <button type="submit" id="btn-submit" class="btn-confirm mt-20">ยืนยันเบอร์โทร</button>


                </form>


                @if (session('phone_exists'))
                        <div class="alert-box">

                            @php
                                $rawPhone = str_replace('-', '', session('phone_value')); // เอาเฉพาะตัวเลข
                                $maskedPhone =
                                    substr($rawPhone, 0, 3) .
                                    '-' .
                                    substr($rawPhone, 3, 3) .
                                    '-' .
                                    substr($rawPhone, 6, 4);
                            @endphp


                            <p class="alert-text">
                                เบอร์โทรศัพท์ {{ $maskedPhone }} ของคุณได้ลงทะเบียนแล้ว
                            </p>

                            <form method="POST" action="{{ url('/go-dashboard') }}" class="">
                                @csrf
                                <input type="hidden" name="phone" value="{{ $maskedPhone }}">
                                <button type="submit" class="btn-confirm mt-20">โปรดเข้าสู่หน้าตรวจสอบสิทธิ์</button>
                            </form>
                        </div>

                    @endif
            </div>
        </main>



        <!-- Footer -->
        <footer class="page-footer2">
        <div class="copyright2">
            © 2025 HONOR Thailand All rights reserved. <br>
            <a href="{{ url('/terms') }}" class="footer-link">เงื่อนไขกิจกรรม</a> |
            <a href="{{ url('/privacy-policy') }}" class="footer-link">นโยบายความเป็นส่วนตัว</a>
        </div>
    </footer>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// --- Lock number + format ---
document.getElementById("phone").addEventListener("input", function(e) {
    let value = e.target.value.replace(/\D/g, "");

    if (value.length > 10) value = value.slice(0, 10);

    let formatted = "";
    if (value.length > 0) formatted = value.substring(0, 3);
    if (value.length > 3) formatted += "-" + value.substring(3, 6);
    if (value.length > 6) formatted += "-" + value.substring(6, 10);

    e.target.value = formatted;
});


// --- SweetAlert2 Form Validation ---
document.querySelector(".regis-form").addEventListener("submit", function(e) {

    const phone = document.getElementById("phone").value.replace(/\D/g, "");
    const captchaDisplay = document.getElementById("captcha_text").textContent.trim();
    const captchaInput = document.getElementById("captcha_input").value.trim();

    // ตรวจเบอร์โทร
    if (phone.length !== 10) {
        e.preventDefault();
        Swal.fire({
            icon: "warning",
            title: "กรุณากรอกเบอร์โทรศัพท์ให้ครบ 10 หลัก",
            confirmButtonText: "ตกลง"
        });
        return false;
    }

    // ตรวจ Captcha ว่าไม่ได้กรอก
    if (captchaInput === "") {
        e.preventDefault();
        Swal.fire({
            icon: "warning",
            title: "โปรดกรอกรหัสยืนยัน",
            confirmButtonText: "ตกลง"
        });
        return false;
    }

    // ตรวจ Captcha ไม่ตรง
    if (captchaDisplay !== captchaInput) {
        e.preventDefault();
        Swal.fire({
            icon: "error",
            title: "รหัสยืนยันไม่ถูกต้อง",
            text: "กรุณาลองใหม่อีกครั้ง",
            confirmButtonText: "ตกลง"
        });
        generateCaptcha();
        document.getElementById("captcha_input").value = "";
        return false;
    }
});


// --- Disable Submit When Phone Exists ---
document.addEventListener("DOMContentLoaded", function() {

    const phoneExists = {{ session('phone_exists') ? 'true' : 'false' }};

    if (phoneExists) {
        const btn = document.getElementById("btn-submit");
        {{-- if (btn) {
            btn.disabled = true;
            btn.style.opacity = "0.4";
            btn.style.cursor = "not-allowed";
            btn.innerText = "เบอร์นี้ถูกใช้แล้ว";
        } --}}
    }

});


// --- Captcha Generator ---
function generateCaptcha() {
    let code = Math.floor(1000 + Math.random() * 9000);
    document.getElementById("captcha_text").textContent = code;
}

document.getElementById("refresh_captcha").addEventListener("click", generateCaptcha);

// โหลดตอนเริ่ม
generateCaptcha();

</script>


</body>

</html>
