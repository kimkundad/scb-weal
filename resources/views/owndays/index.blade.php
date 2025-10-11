<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>OwnDays</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/owndays.css') }}?v={{ time() }}" type="text/css" />
  <link rel="icon" type="image/png" sizes="32x32" href="{{ url('img/tp/favicon_v5.png') }}" />
</head>
<body>
  <div class="wrapper">
    <header>
      <a href="{{ url('/') }}">
        <img src="{{ url('img/owndays/logo.png') }}" alt="owndays logo" />
      </a>
    </header>


        <main style="padding:0">
            <div class="question-section" style="gap: 0px; max-width: 440px;">
                <div class="intro-container">
                    <img src="{{ url('img/owndays/OWNDAYS-10th_V-fix@3xv2.png') }}"
                        alt="intro"
                        class="intro-img">

                    <!-- ปุ่มซ้อนอยู่บนรูป -->
                    <a href="{{ url('/intro') }}" class="btn-image-link">
                    <img src="{{ url('img/owndays/ยอมรับและเริ่มทำแบบทดสอบ@3x.png') }}"
                        alt="พร้อมแล้ว ไปต่อกันเลย"
                        class="btn-image">
                    </a>
                </div>
            </div>
        </main>


    <footer>
      <div class="copyright">
        COPYRIGHT (C) OWNDAYS co., ltd. ALL RIGHTS RESERVED. <br> นโยบายความเป็นส่วนตัว | ข้อตกลงและเงื่อนไขในการบริการ
      </div>
    </footer>
  </div>

</body>
</html>
