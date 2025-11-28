<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>เข้าสู่ระบบ - HONOR</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/honor.css') }}?v={{ time() }}" />
</head>
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

    <h1 class="regis-title">เข้าร่วมกิจกรรมด้วยเบอร์โทรของคุณ</h1>

    @php
      $sessionPhone = session('phone');
    @endphp

    @if ($sessionPhone)
      <div class="info-text mt-20" style="text-align:center;">
        📱 เบอร์โทรที่คุณใช้งานล่าสุดคือ<br>
        <strong>{{ $sessionPhone }}</strong>
        <br><br>
        <a href="{{ url('/dashboard') }}?phone={{ $sessionPhone }}" class="btn-confirm mt-20">ดูสิทธิ์ของฉัน</a>
        <p class="mt-20" style="color: #64748b;">หรือกรอกเบอร์ใหม่ด้านล่างเพื่อตรวจสอบข้อมูลอื่น</p>
      </div>
    @endif

    <form method="POST" action="{{ url('/go-dashboard') }}" class="regis-form mt-30">
    @csrf
      @if(session()->get('phone'))
      <label for="phone">เปลี่ยนเบอร์โทร</label>
      @endif
      <input
        type="text"
        name="phone"
        id="phone"
        class="regis-input phone-input"
        placeholder="099-999-9999"
        maxlength="12"
        inputmode="numeric"
        required
    >
      <p class="mt-20" style="margin-top: -10px;font-size: 14px;color: #64748b;">กรอกเบอร์โทรศัพท์ของคุณที่ได้ลงทะเบียนไว้กับเรา</p>

      <button type="submit" class="btn-secondary mt-20">ดูข้อมูลเบอร์นี้</button>
    </form>

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

</body>

<script>
  // ล็อกเฉพาะตัวเลข และไม่เกิน 10 หลัก
  const phoneInput = document.getElementById('phone');
  phoneInput.addEventListener('input', () => {
    phoneInput.value = phoneInput.value.replace(/[^0-9]/g, '').slice(0, 10);
  });
</script>

<script>
    document.getElementById("phone").addEventListener("input", function(e) {
        let value = e.target.value.replace(/\D/g, ""); // เอาเฉพาะตัวเลข

        // จำกัดแค่ 10 หลัก
        if (value.length > 10) value = value.slice(0, 10);

        // จัดฟอร์แมต 099-999-9999
        let formatted = "";

        if (value.length > 0) {
            formatted = value.substring(0, 3);
        }
        if (value.length > 3) {
            formatted += "-" + value.substring(3, 6);
        }
        if (value.length > 6) {
            formatted += "-" + value.substring(6, 10);
        }

        e.target.value = formatted;
    });
</script>
</html>
