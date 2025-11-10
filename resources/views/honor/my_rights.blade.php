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

    <h1 class="regis-title">เข้าสู่ระบบเพื่อดูสิทธิ์</h1>

    @php
      $sessionPhone = session('phone');
    @endphp

    @if ($sessionPhone)
      <div class="info-text mt-20" style="text-align:center;">
        📱 เบอร์โทรที่คุณใช้งานล่าสุดคือ<br>
        <strong>{{ $sessionPhone }}</strong>
        <br><br>
        <a href="{{ url('/dashboard') }}" class="btn-confirm mt-20">ดูสิทธิ์ของฉัน</a>
        <p class="mt-20" style="color: #64748b;">หรือกรอกเบอร์ใหม่ด้านล่างเพื่อตรวจสอบข้อมูลอื่น</p>
      </div>
    @endif

    <form method="get" action="{{ url('/dashboard') }}" class="regis-form mt-30">
      <label for="phone">เปลี่ยนเบอร์โทร</label>
      <input
        type="text"
        name="phone"
        id="phone"
        class="regis-input"
        placeholder="กรอกเบอร์โทรศัพท์"
        maxlength="10"
        pattern="[0-9]{10}"
        inputmode="numeric"
        required
      >
      <button type="submit" class="btn-secondary mt-20">ดูข้อมูลเบอร์นี้</button>
    </form>

  </div>
</main>


  <!-- Footer -->
  <footer class="page-footer2">
    <div class="copyright2">
      © 2025 HONOR Thailand  All rights reserved. <br>
      เงื่อนไขกิจกรรม | นโยบายความเป็นส่วนตัว
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
</html>
