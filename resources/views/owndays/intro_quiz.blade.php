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
  <div class="page-wrapper2">

    <!-- Header -->
    <header class="page-header">
      <a href="{{ url('/') }}">
      <img src="{{ url('img/owndays/logo.png') }}" alt="OWNDAYS logo" style="margin-left:20px">
      </a>
    </header>

    <!-- Main Content -->
    <main class="page-content" >




        <div class="intro-bg">
                    <div class="intro-inner" style="padding: 5px 15px; ">

                    <img src="{{ url('img/owndays/text@3x@3x.png') }}"
                        alt="intro"
                        class="intro-img">

                        <img src="{{ url('img/owndays/ภาพ ‘ตัวตนของฉัน’ ที่คุณรั@3x.png') }}"
                        alt="intro"
                        class="mt-10 img-w">



        <a href="{{ url('/quiz') }}" class="start-btn">
                                <img src="{{ url('img/owndays/start.png') }}" alt="พร้อมแล้ว ไปต่อกันเลย"
                                    class="btn-image">
                            </a>




      </div>

      </div>

    </main>

    <!-- Footer -->
    <footer class="page-footer2">
      <div class="copyright2">
        COPYRIGHT (C) OWNDAYS co., ltd. ALL RIGHTS RESERVED.<br>
        นโยบายความเป็นส่วนตัว | ข้อตกลงและเงื่อนไขในการบริการ
      </div>
    </footer>

  </div>
</body>
</html>
