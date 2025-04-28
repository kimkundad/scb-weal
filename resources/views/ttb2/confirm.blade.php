<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to Kick-off development journey.</title>
    <link rel="stylesheet" href="{{ url('/home/assets/css/ttb2.css') }}?v{{ time() }}" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('img/favicon.ico') }}" type="image/x-icon">
    <style>
       .name {
            font-size: 28px;
            font-weight: bold;
            color: #004aad;
            margin-bottom: 10px;
        }

        .welcome {
            font-size: 20px;
            color: #01245f;
            margin-bottom: 10px;
        }

        .role {
            font-size: 20px;
            color: #f57c00;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .complete-message {
            font-size: 18px;
            color: #01245f;
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            font-family: 'TTB ExtraBold', sans-serif !important;
        }
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
                <img src="{{ url('img/ttb2/hello@2x.png') }}" class="img-fluid" style="width:80%" />
                </div>
                <br>

                {{-- ตัวอย่างการแสดงผล --}}
                @php
            $employeeCode = request()->query('code');
            $fullName = request()->query('name');
            $welcomeMessage = request()->query('message'); // รับ message เพิ่มถ้าต้องการ
            $alreadyRegistered = request()->query('registered'); // true / false จาก Controller
            @endphp


            <div class="road-bg">
            <div class="text-center ">
                <div class="name">Khun {{ $fullName }}</div>
                <div class="welcome">Welcome to<br>Kick-off development journey.</div>
                <div class="role"><b style="color: #01245f;">You are </b><br>{{ $welcomeMessage ?? 'change agent | 1st year talent' }}</div>
            </div>

                <div class="text-center ">
                    @if($alreadyRegistered == 'true')
                        <!-- แสดงข้อความห้ามลงทะเบียนซ้ำ -->
                        <div class="complete-message" >
                           <p style="color:#01245f; font-size:14px; margin-top:20px;"> รหัสพนักงานนี้<br>ได้ลงทะเบียนแล้วก่อนหน้านี้<br>หากคุณไม่ได้เป็นผู้ทำการลงทะเบียน<br>กรุณาติดต่อเจ้าหน้าที่ </p>
                        </div>
                    @else
                        <!-- ปุ่ม Confirm -->
                        <img src="{{ url('img/ttb2/confirm@2x.png') }}" id="confirm-btn" style="width: 40%; cursor:pointer;" />

                        <!-- ข้อความหลัง Confirm -->
                        <div class="complete-message" id="complete-msg" style="display:none; font-size:14px; color:#01245f; margin-top:20px;">
                            Registration complete.<br>Please capture (or screenshot) this page.
                        </div>
                    @endif
                </div>
</div>

            </div>

        </main>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#confirm-btn').on('click', function() {
            var employeeId = "{{ $employeeCode }}";
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ url("post_submit") }}',
                type: 'POST',
                data: {
                    _token: token,
                    employeeId: employeeId
                },
                success: function(response) {
                    if(response.success) {
                        $('#confirm-btn').hide();
                        $('#complete-msg').show();
                    } else if (response.alreadyRegistered) {
                        $('#confirm-btn').hide();
                        $('.complete-message').html('รหัสพนักงานนี้<br>ได้ลงทะเบียนแล้วก่อนหน้านี้<br>หากคุณไม่ได้เป็นผู้ทำการลงทะเบียน<br>กรุณาติดต่อเจ้าหน้าที่').show();
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + response.message);
                    }
                },
                error: function() {
                    alert('เกิดข้อผิดพลาดในการส่งข้อมูล');
                }
            });
        });
    </script>

</html>
