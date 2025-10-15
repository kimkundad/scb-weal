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

        <p class="index-text">
                           หลายความสำเร็จที่มีความหมาย <br>
                            เริ่มต้นได้จากมุมมองเล็กๆ


                        </p>
                        <p class="index-text" style="margin-top: -10px">


                            มาร่วมค้นหา<br>
                            <b>‘มุมมองความมั่นใจ’</b> กับ OWNDAYS<br>
                            เพื่อเติมทุกวันให้เต็มไปด้วยความสำเร็จ<br>
                            ในแบบของคุณ
                        </p>

                        <p class="index-text-sub" style="margin-bottom: 30px">
                        *Interactive Quiz นี้ไม่ใช่แบบบทสอบทางจิตวิทยา <br>
                        แต่เป็นพื้นที่ให้คุณได้สบตากับตัวเองที่มีพลังความมั่นใจอยู่ภายใน
                        </p>

        <a href="{{ url('/intro') }}" class="start-btn">
            <img src="{{ url('img/owndays/พร้อมแล้ว-ไปต่อกันเลย@3x.png') }}"
                        alt="พร้อมแล้ว ไปต่อกันเลย"
                        class="btn-image">
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
