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
    <div class="regis-container" style="text-align: center;">
      <img src="{{ url('/img/honor/success!@2x.png') }}" alt="🎉" style="width: 80%;">
      <h1 class="regis-title">Submission successful!</h1>

      <p class="regis-subtitle2">
        คุณได้ร่วมกิจกรรม <Br> HONOR X9d ทนนน... จัด! คุ้มจัด ลุ้นขับ Mercedes-Benz สำเร็จแล้ว<br>
        รอลุ้นเป็นเจ้าของ Mercedes-Benz และทองคำ<br>
        ประกาศผลวันที่ 13 มกราคม 2569
      </p>
       <p class="regis-subtitle2">
        You have successfully joined the event.<br>
        Results will be announced on<br>
        January 13, 2026
      </p>

      <a href="{{ url('/my-rights') }}" class="btn-confirm mt-20">View my eligibility</a>
      <a href="{{ url('/regis_user_upslip') }}" class="btn-secondary mt-10">Add more eligibility</a>
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
