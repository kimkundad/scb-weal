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
                    <div class="intro-inner" style="padding: 5px 0px; ">

                    <img src="{{ url('img/owndays/fix-title.png') }}"
                        alt="intro"
                        class="intro-img">


                        <p class="intro-text">
                           ภาพ ‘ตัวตนของฉัน’ ที่คุณรับรู้เกี่ยวกับตัวเองตอนนี้ <br>
                            เป็นแบบไหนกันนะ?
                        </p>
                        <p class="intro-text">
                        คุณอาจเป็นวัยรุ่นที่กังวลว่าจะทำตามความฝันได้ไหม <br>
                        เป็นคนหนึ่งที่อยากดูแลคนใกล้ตัวที่รักให้ดี <br>
                        หรือเป็นพนักงานคนหนึ่งที่กำลังค้นหาตัวเอง <br>
                        คำตอบเหล่านั้นไม่มีผิดหรือถูก
                        </p>

                        <p class="intro-text">
                        แต่ถ้าลองสำรวจตัวเองผ่านสายตาอีกแบบ <br> เหมือนเวลาสวมแว่นอันใหม่ <br>
                        คุณอาจพบตัวเองเวอร์ชั่นใหม่ <br> ที่กำลังรอเจอกันอยู่ในอนาคต
                        </p>

                        <p class="intro-text">
                        พร้อมจะไปสำรวจ  ‘ตัวฉันที่เป็นไปได้’ คนนั้น <br> ด้วยกันหรือยัง?
                        </p>
            <br><br>


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
