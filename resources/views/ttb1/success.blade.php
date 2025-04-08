<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Q&A Responsive</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/font.css') }}?v{{time()}}" type="text/css" />
  <style>

   main {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: start;
    text-align: start;
    padding: 20px;
  }

  </style>
</head>
<body>
  <div class="wrapper">
    <header>
      <a href="{{ url('/') }}">
        <img src="{{ url('img/TTB_Logo.svg.png') }}" alt="ttb logo" />
      </a>
    </header>

    <main>
        <h2>Q&A</h2>
        <br><br><br><br><br>
        <img src="{{ url('img/Path@2x.png') }}" style="width: 100px; height: 100px" />
        <br>
        <div class="message">
            ระบบได้รับคำถาม<br>ของคุณเรียบร้อยแล้ว
        </div>
    <br><br>
        <button class="btn-submit-more" onclick="window.location.href='{{ url('/') }}'">
            ส่งคำถามเพิ่มเติม
        </button>
    </main>

    <footer>
      <div class="copyright">
        Ⓒ สงวนลิขสิทธิ์ 2568 ธนาคารทหารไทยธนชาต จำกัด (มหาชน)<br/>
        นโยบายคุ้มครองข้อมูลส่วนบุคคล
      </div>
    </footer>
  </div>
</body>


</html>
