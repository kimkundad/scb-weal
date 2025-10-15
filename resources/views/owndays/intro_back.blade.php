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
    <main class="page-content" style="    margin: 30px 0px;">

      <div class="intro-con">
        <p class="intro-text-2" >
            Interactive Quiz นี้เป็นส่วนหนึ่งของโปรเจกต์ 10th ANNIVERSARY OF OWNDAYS THAILAND<br>
            ดำเนินการโดยบริษัท โอนเดส์ (ประเทศไทย) จำกัด<br>
            จัดทำขึ้นเพื่อสร้างสรรค์สื่อประชาสัมพันธ์สินค้าและรวบรวมข้อมูลเชิงสถิติ<br>
            ตลอดจนส่งเสริมและสนับสนุนให้ทุกคนได้เล็งเห็นแง่มุมความมั่นใจในแบบฉบับของตัวเอง<br><br>
            ทั้งนี้ Interactive Quiz ได้รับการออกแบบภายใต้คำแนะนำของทีมนักจิตวิทยา <br>
            บริษัท มาสเตอร์พีซ มายด์ แคร์ เซอร์วิส จำกัด โดยข้อมูลคำตอบของทุกคน<br>
            จะถูกเก็บรักษาเป็นความลับ และไม่มีคำถามที่นำไปสู่การระบุตัวตนผู้ให้ข้อมูล
        </p>
        <br><br>
        <a href="{{ url('/data') }}" class="start-btn">
            <img src="{{ url('img/owndays/click@3x.png') }}" alt="เริ่มทำแบบทดสอบ">
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
