<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HONOR - ลงทะเบียน</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/honor.css') }}?v={{ time() }}" />
  <link rel="icon" type="image/x-icon" href="{{ url('/img/honor/favicon.ico') }}">
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
      <h1 class="regis-title">เข้าร่วมกิจกรรมด้วย<br>เบอร์โทรของคุณ</h1>
      <p class="regis-subtitle">กรอกเบอร์โทรศัพท์ของคุณเพื่อเริ่มต้นเข้าร่วมกิจกรรม</p>

      <form method="POST" action="{{ url('/regis_honor') }}" class="regis-form">
        @csrf
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
        <button type="submit" class="btn-confirm mt-20">ยืนยันเบอร์โทร</button>
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

<script>
  // ล็อกเฉพาะตัวเลข และไม่เกิน 10 หลัก
  const phoneInput = document.getElementById('phone');
  phoneInput.addEventListener('input', () => {
    phoneInput.value = phoneInput.value.replace(/[^0-9]/g, '').slice(0, 10);
  });
</script>

</body>
</html>
