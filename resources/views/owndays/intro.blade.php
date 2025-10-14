<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OWNDAYS</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/intro.css') }}?v={{ time() }}" type="text/css" />
  <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ url('/img/owndays/favicon.ico') }}">
</head>

<body>
  <div class="page-wrapper">

    <!-- Header -->
    <header class="page-header">
      <a href="{{ url('/') }}">
      <img src="{{ url('img/owndays/logo.png') }}" alt="OWNDAYS logo" style="margin-left:20px">
      </a>
    </header>

    <!-- Main Content -->
    <main class="page-content">

      <div class="intro-con">
        <p class="intro-text">
            Interactive Quiz นี้จัดทำขึ้นในโอกาส <br> 10th ANNIVERSARY OF OWNDAYS THAILAND<br>
            โดยบริษัท อะบัฟทูว์ จำกัด<br> วัตถุประสงค์เพื่อสำรวจความคิดเห็นและรวบรวมข้อมูลเชิงสถิติ<br><br>
            แบบทดสอบนี้พัฒนาภายใต้คำแนะนำของ<br>ทีมนักจิตวิทยา บริษัท มาสเตอร์พีซ มายด์ แคร์ เซอร์วิส จำกัด<br>
            คำตอบทั้งหมดจะถูกเก็บเป็นความลับ <br> และไม่มีคำถามใดที่สามารถระบุตัวตนผู้ตอบได้
        </p>
        <br><br>
        <a href="{{ url('/data') }}" class="start-btn">
            <img src="{{ url('img/owndays/ยอมรับและเริ่มทำแบบทดสอบ@3x.png') }}" alt="เริ่มทำแบบทดสอบ">
        </a>
      </div>

    </main>

    <!-- Footer -->
    <footer class="page-footer">
      <div class="copyright">
        COPYRIGHT (C) OWNDAYS co., ltd. ALL RIGHTS RESERVED.<br>
        นโยบายความเป็นส่วนตัว | ข้อตกลงและเงื่อนไขในการบริการ
      </div>
    </footer>

  </div>
</body>
</html>
