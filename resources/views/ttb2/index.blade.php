<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome to Kick-off development journey.</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/ttb2.css') }}?v{{time()}}" type="text/css" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ url('img/favicon.ico') }}" type="image/x-icon">
<style>
    .error-message { display: none; }
    .success-message { display: none; font-size:16px; font-weight: 700; color:green; text-align: center; margin-top: 15px; }

    .road-bg {
    background: url('{{ url('img/ttb2/Road@2x.png') }}') no-repeat bottom center;
    background-size: contain;
    background-color: #f2f2f2; /* สีพื้นหลังของ section */
    padding: 40px 20px 120px 20px; /* เผื่อพื้นที่ให้เห็นถนน */
}

  </style>
</head>
<body>
    <div class="wrapper">
        <main>

            <div style=" display: flex; flex-direction: column; ">
                <div class="text-center">
                <img src="{{ url('img/ttb2/intro@2x.png') }}" class="img-fluid" style="width:80%"/>
                </div>
                <br>
               <div class="form-section-custom road-bg">
                    <p style="font-size:18px; font-weight: 700; text-align: center; margin-bottom: 15px">กรอกรหัสพนักงานเพื่อลงทะเบียน</p>
                    <input type="text" id="employee_code" name="employee_code" placeholder="กรอกรหัสพนักงาน">

                    <img src="{{ url('img/ttb2/enter@2x.png') }}" id="search-btn" style="width: 40%; cursor:pointer;" />

                    <div class="error-message" id="error-msg">
                        <p style="font-size:16px; font-weight: 700; color:red; text-align: center; margin-top: 15px;">ไม่พบรหัสพนักงาน</p>
                    </div>
                </div>


            </div>

        </main>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $('#search-btn').on('click', function() {
  var employeeCode = $('#employee_code').val();
  var token = $('meta[name="csrf-token"]').attr('content');

  $.ajax({
    url: '{{ url("auto_search") }}',
    type: 'POST',
    data: {
      _token: token,
      employee_code: employeeCode
    },
    success: function(response) {
      if(response.success) {
        // ถ้าลงทะเบียนแล้ว ➡️ ไปหน้า Notfound
        if(response.alreadyRegistered) {
          window.location.href = '{{ url("/Notfound") }}';
        } else {
          // ถ้ายังไม่ลงทะเบียน ➡️ ไปหน้า confirm_user
          window.location.href = '{{ url("confirm_user") }}' +
            '?code=' + encodeURIComponent(employeeCode) +
            '&name=' + encodeURIComponent(response.full_name) +
            '&message1=' + encodeURIComponent(response.messagePart1) +
            '&message2=' + encodeURIComponent(response.messagePart2) +
            '&registered=' + (response.alreadyRegistered ? 'true' : 'false');
        }
      } else {
        $('#error-msg').show();
      }
    },
    error: function() {
      alert('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์');
    }
  });
});

</script>
</html>
