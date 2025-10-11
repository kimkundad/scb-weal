<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
                    <div class="intro-inner" style="padding: 5px 15px; ">
                    <div class="intro-container">

                      <!-- ลำดับข้อ -->
                    <div class="quiz-progress">8/8</div>

                    <!-- คำถาม -->
                    <div class="quiz-question" style="margin-top:55px">
                        ในสายตาของเพื่อนๆ จุดแข็งและความโดดเด่นของคุณคือ..
                    </div>

                    <!-- ตัวเลือก -->
                    <div class="quiz-options" style="margin-top:25px">
                        <label class="quiz-option">
                        <input type="radio" name="answer" value="มองโลกในแง่ดี">
                        <span>มองโลกในแง่ดี</span>
                        </label>

                        <label class="quiz-option">
                        <input type="radio" name="answer" value="กล้าทดลองและมีพลังแบบคนรุ่นใหม่">
                        <span>กล้าทดลองและมีพลังแบบคนรุ่นใหม่</span>
                        </label>

                        <label class="quiz-option">
                        <input type="radio" name="answer" value="เปี่ยมด้วยความกระตือรือร้น">
                        <span>เปี่ยมด้วยความกระตือรือร้น</span>
                        </label>

                        <label class="quiz-option">
                        <input type="radio" name="answer" value="ศิลปินนักสร้างสรรค์จากความรื่นรมย์ในชีวิต">
                        <span>ศิลปินนักสร้างสรรค์จากความรื่นรมย์ในชีวิต</span>
                        </label>

                        <label class="quiz-option">
                        <input type="radio" name="answer" value="มีความอบอุ่นและความอ่อนโยนที่ลึกซึ้ง">
                        <span>มีความอบอุ่นและความอ่อนโยนที่ลึกซึ้ง</span>
                        </label>

                        <label class="quiz-option">
                        <input type="radio" name="answer" value="มีความเป็นธรรมชาติ เข้าถึงง่าย">
                        <span>มีความเป็นธรรมชาติ เข้าถึงง่าย</span>
                        </label>
                    </div>


                        <a href="{{ url('/resulte') }}" class="btn-image-link pt-45-res w-btn-90" style="bottom: auto;">
                        <img src="{{ url('img/owndays/checkBtn@3x.png') }}"
                            alt="พร้อมแล้ว ไปต่อกันเลย"
                            class="btn-image">
                        </a>



                    </div>
                    </div>
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

