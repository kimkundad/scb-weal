<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SRICHANDxBamBam - ศรีจันทร์ อิน-สกิน เอ็กซ์ แบมแบม สกิน มอยส์เจอร์ เบิร์ส บ็อกเซ็ต</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/srichan.css') }}?v={{ time() }}" type="text/css" />
   <link rel="icon" type="image/jpeg" sizes="32x32" href="{{ url('img/srichand/cropped-logo-srichand-1-192x192.jpeg') }}" />
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
        <img src="{{ url('img/srichand/srichand_logo.png') }}" alt="srichand logo" />
      </a>
    </header>

    <main>
<br><br>
        <br><br><br><br><br>
        <img src="{{ url('img/Path@2x.png') }}" style="width: 100px; height: 100px" />
        <br>
        <div class="message">
            ระบบได้รับคำถาม<br>ของคุณเรียบร้อยแล้ว
        </div>
    <br><br>
        <a style="text-decoration: none;" href="{{ url('/') }}" class="submit-btn" >ค้นหาด้วยชื่อหรือเลขที่นั่ง</a>
    </main>

    {{-- <footer>
      <div class="copyright">
        Ⓒ สงวนลิขสิทธิ์ 2568 ธนาคารทหารไทยธนชาต จำกัด (มหาชน)<br/>
        นโยบายคุ้มครองข้อมูลส่วนบุคคล
      </div>
    </footer> --}}
  </div>
</body>


</html>
