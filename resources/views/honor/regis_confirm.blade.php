<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ส่งข้อมูลสำเร็จ - HONOR</title>
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
    <div class="regis-container" >
      <img src="{{ url('/img/honor/🎉 ส่งข้อมูลสำเร็จ!@2x.png') }}" alt="🎉" style="width: 100%;">

      <p class="regis-subtitle2">
        คุณได้ร่วมกิจกรรม <Br> HONOR Lucky Receipt สำเร็จแล้ว<br>
        รอลุ้นเป็นเจ้าของ Mercedes-Benz และทองคำ<br>
        ประกาศผลวันที่ 20 มกราคม 2569
      </p>

      <a href="{{ url('/my-rights') }}" class="btn-confirm mt-20">ดูสิทธิ์ของฉัน</a>
      <a href="{{ url('/regis_user_upslip') }}" class="btn-secondary mt-10">ส่งใบเสร็จเพิ่ม</a>
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
</html>
