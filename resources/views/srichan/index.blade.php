<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SRICHANDxBamBam - ศรีจันทร์ อิน-สกิน เอ็กซ์ แบมแบม สกิน มอยส์เจอร์ เบิร์ส บ็อกเซ็ต</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/srichan.css') }}?v={{ time() }}" type="text/css" />
   <link rel="icon" type="image/jpeg" sizes="32x32" href="{{ url('img/srichand/cropped-logo-srichand-1-192x192.jpeg') }}" />
   <meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <br>
        <form class="qa-form" id="qaForm">
            @csrf
            <div class="form-group">
                <label for="fullname" style="margin-bottom:10px">โปรดระบุชื่อ-นามสกุล</label>
                <input type="text" name="fullname" id="fullname" required>
                <br>
                <button type="button" class="submit-btn" id="search-btn">ค้นหา</button>
            </div>
            <div class="error-message" id="error-msg" style="color: red; display:none;">ไม่พบชื่อ-นามสกุล</div>
        </form>
      </div>
    </main>
    <input type="hidden" value="{{ Auth::user()->username }}">

    {{-- <footer>
      <div class="copyright">
        Ⓒ สงวนลิขสิทธิ์ 2568 ธนาคารทหารไทยธนชาต จำกัด (มหาชน)<br/>
        นโยบายคุ้มครองข้อมูลส่วนบุคคล
      </div>
    </footer> --}}
  </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $('#search-btn').on('click', function () {
    const name = $('#fullname').val();
    const token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      url: '{{ url("/search_cus") }}',
      type: 'POST',
      data: {
        _token: token,
        name: name
      },
      success: function (response) {
        if (response.success) {
          Swal.fire({
            icon: 'success',
            title: 'พบข้อมูลแล้ว',
            text: 'ยินดีต้อนรับคุณ ' + response.full_name,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ไปหน้าข้อมูล'
          }).then(() => {
            window.location.href = response.redirect_url;
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'ไม่พบข้อมูล',
            text: 'กรุณาตรวจสอบชื่อ-นามสกุลอีกครั้ง',
            confirmButtonColor: '#d33',
            confirmButtonText: 'ลองอีกครั้ง'
          });
        }
      },
      error: function () {
        Swal.fire({
          icon: 'error',
          title: 'เกิดข้อผิดพลาด',
          text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
        });
      }
    });
  });
</script>





</body>
</html>
