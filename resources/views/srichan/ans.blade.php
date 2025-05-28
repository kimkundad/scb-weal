<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SRICHANDxBamBam - ศรีจันทร์ อิน-สกิน เอ็กซ์ แบมแบม สกิน มอยส์เจอร์ เบิร์ส บ็อกเซ็ต</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/srichan.css') }}?v={{ time() }}" type="text/css" />
   <link rel="icon" type="image/jpeg" sizes="32x32" href="{{ url('img/srichand/cropped-logo-srichand-1-192x192.jpeg') }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
   <style>

   .question-section h2 {
    text-align: left;
    font-size: 28px;
    margin-bottom: 20px;
}
.question-section {
    text-align: left;
}
.assets1{
    font-size:22px;
    color: #fff
}
.assets1 span{
    font-size:22px;
    color: #E8C02B
}
.text-center{
    text-align:center
}
.text-basck{
        color: darkgrey;
    text-decoration: none;
    font-size:18px
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
      <div class="question-section">
      <br> <br>
        <h2>{{ request('full_name') }}</h2>
         <br>
        <div>
        <p class="assets1">LUCKY FAN - <span>EXCLUSIVE ZONE</span></p>
        <h2>Seat No: {{ request('seat') }}</h2>
        </div>

        <br>
        <br>
        <br>
        <form class="qa-form" id="qaForm">
          @csrf


          <button type="submit" class="submit-btn" >ลงทะเบียน</button>
          <div class="text-center">
          <br>
            <a href="{{ url('/') }}" class="text-basck"><p>ค้นหาด้วยชื่อหรือเลขที่นั่ง</p></a>
          </div>

        </form>
      </div>
    </main>

    {{-- <footer>
      <div class="copyright">
        Ⓒ สงวนลิขสิทธิ์ 2568 ธนาคารทหารไทยธนชาต จำกัด (มหาชน)<br/>
        นโยบายคุ้มครองข้อมูลส่วนบุคคล
      </div>
    </footer> --}}
  </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('qaForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const code = "{{ request('code') }}"; // ✅ ใช้ code แทนชื่อ
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('{{ url("/register_user") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify({ code: code }) // ✅ ส่ง code ไป backend
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
          icon: 'success',
          title: 'ลงทะเบียนสำเร็จ',
          text: data.message,
          confirmButtonText: 'ไปต่อ'
        }).then(() => {
          window.location.href = "{{ url('/srichan_success') }}";
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'เกิดข้อผิดพลาด',
          text: data.message,
          confirmButtonText: 'ลองอีกครั้ง'
        });
      }
    })
    .catch(error => {
      Swal.fire({
        icon: 'error',
        title: 'ข้อผิดพลาดในการเชื่อมต่อ',
        text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
        confirmButtonText: 'ตกลง'
      });
    });
  });
</script>

</body>
</html>
