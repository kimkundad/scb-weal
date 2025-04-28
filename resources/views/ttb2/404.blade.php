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
    padding: 0px 20px 180px 20px; /* เผื่อพื้นที่ให้เห็นถนน */
}

  </style>
</head>
<body>
    <div class="wrapper">
        <main>

            <div style=" display: flex; flex-direction: column; ">

                <br>
               <div class="form-section-custom road-bg">
                    <p style="font-size:23px; font-weight: 700; text-align: center; margin-bottom: 15px">รหัสพนักงานนี้ <br>
ได้ลงทะเบียนแล้วก่อนหน้านี้ <br>
หากคุณไม่ได้เป็นผู้ทำการลงทะเบียน <br>
กรุณาติดต่อเจ้าหน้าที่</p>

                </div>


            </div>

        </main>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</html>
