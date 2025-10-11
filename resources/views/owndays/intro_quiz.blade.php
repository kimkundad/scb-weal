<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>สมาคมศิษย์เก่าทวีธาภิเศก</title>
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

        <main>

            <div class="question-section">
                <div class="intro-bg">
                    <div class="intro-inner">
                        <div class="intro-container" style="padding-bottom: 40px;">
                            <img src="{{ url('img/owndays/text@3x@3x.png') }}" style="width: 278px; margin-top:10px">


                            <img src="{{ url('img/owndays/ภาพ ‘ตัวตนของฉัน’ ที่คุณรั@3x.png') }}"
                                style="width: 100%; margin-top:8px; margin-bottom: 40px;">



                            <!-- ปุ่มซ้อนอยู่บนรูป -->
                            <a href="{{ url('/quiz') }}" class="btn-image-link">
                                <img src="{{ url('img/owndays/start.png') }}" alt="พร้อมแล้ว ไปต่อกันเลย"
                                    class="btn-image">
                            </a>



                        </div>
                    </div>
                </div>
            </div>
        </main>


        <footer>
            <div class="copyright">
                COPYRIGHT (C) OWNDAYS co., ltd. ALL RIGHTS RESERVED. <br> นโยบายความเป็นส่วนตัว |
                ข้อตกลงและเงื่อนไขในการบริการ
            </div>
        </footer>
    </div>
</body>




</html>
