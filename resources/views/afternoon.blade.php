@extends('layouts.template')


@section('title')
Welcome to scb.idx.co.th
@stop

@section('stylesheet')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
#submitBtn{
    cursor: pointer;
}
.chakra-container-page {
  background-image: url('{{ url('img/bg1.png') }}'); /* ลิงก์รูปภาพ */
  background-size: contain; /* ปรับให้รูปเต็มพื้นที่ */
  background-position: top; /* วางรูปตรงกลาง */
  background-repeat: no-repeat; /* ป้องกันการซ้ำของรูป */
  width: 100%; /* ขยายความกว้างเต็ม */
  height: 80vh; /* ใช้ความสูงเต็มหน้าจอ */
  transition: background-image 1s ease-in-out;
}

 /* Hidden class for initial setup */
    .fade-bg {
      animation: fadeBackground 2s ease-in-out forwards; /* Trigger animation */
    }

    /* Keyframes for fade effect */
    @keyframes fadeBackground {
      0% {
        background-image: url('img/bg1.png'); /* Initial image */
      }
      100% {
        background-image: url('img/key2.png'); /* Final image */
      }
    }

</style>

@stop('stylesheet')

@section('content')


<div id="loading" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); z-index: 9999; text-align: center;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <img src="{{ url('img/loading.gif') }}" alt="Loading" style="width: 100px;">
        <p style="color: white; font-size: 18px;">กำลังดำเนินการ...</p>
    </div>
</div>

<div id="main" >
    <div class="chakra-container-page">
        <div id="content" >


            <div class="header_logo">
                <div class="d-flex justify-content-center">
                    <a href="{{ url('/afternoon') }}">
                        <img class="img-fluid logo_website_main" src="{{ url('img/logo_scb@2x.png') }}" />
                    </a>
                </div>
            </div>
            {{-- <div class="step1 ">
                <img src="{{ url('img/bg1.png') }}" class="img-fluid" alt="">
            </div>
            <div class="step2 hidden">
                <img src="{{ url('img/key2.png') }}" class="img-fluid" alt="">
            </div> --}}
            <div class="box-height-10"></div>

                <div class="p-26 step1 hidden text-center" style="margin-top: 180px">
                    <div class="form-group">
                        <img src="{{ url('img/text@3x.png') }}" style="width:180px; margin: 10px" class="img-fluid" alt="">
                        <input type="text" name="number" style="width:310px" id="employeeCode" value="{{ old('number') }}" class="field__input" placeholder="ไม่ต้องใส่ S" required>
                    </div>
                            <div id="result" style="margin-top: 10px; height: 70px; color: green;  text-align: center; font-size: 20px; ">
                    </div>
                    <div class="text-center">
                        <img id="searchBtn" src="{{ url('img/btn1.png') }}" style="width:310px" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="p-26 step2 hidden text-center" style="margin-top: 180px">
                        <img src="{{ url('img/welcome.png') }}" style="width: 180px" class="img-fluid" alt="">
                        <div id="result2">

                        </div>
                        <div class="text-center" style="margin-top: 30px">
                        <img id="registerBtn" src="{{ url('img/btn_register.png') }}" style="width:310px" class="img-fluid" alt="">
                        </div>
                </div>

                <div class="p-26 step3 hidden text-center" >
                        <img src="{{ url('img/success.png') }}" style="width: 180px" class="img-fluid" alt="">
                        <div>
                            <p style="color: white; font-size: 18px">ท่านสามารถดูรายละเอียดงานได้ที่นี่</p>
                        </div>
                        <div style="margin-top: 15px">
                        <img id="successBtn" src="{{ url('img/event.png') }}" style="width:310px" class="img-fluid" alt="">
                        </div>
                </div>




        </div>
    </div>
</div>


@endsection

@section('scripts')

<script>

document.addEventListener("DOMContentLoaded", () => {
      const main = document.getElementById('main');
      const container = document.querySelector(".chakra-container-page");
      const step1 = document.querySelector(".step1");
      // Apply fade-bg class to trigger animation
      setTimeout(() => {
        step1.classList.remove("hidden");
        container.style.backgroundImage = "url('img/key2.png?v2')"; // Set the second background
      }, 2000); // 2-second delay before transition
    });

</script>


<script>
    $(document).ready(function () {

        const loadingDiv = document.getElementById('loading');

        const step2 = document.querySelector(".step2");
        const step1 = document.querySelector(".step1");

        let employeeData = null;

        const showLoading = () => {
        loadingDiv.style.display = 'block';
    };

    const hideLoading = () => {
        loadingDiv.style.display = 'none';
    };

      document.getElementById('searchBtn').addEventListener('click', function () {
    const employeeCode = document.getElementById('employeeCode').value;

    if (!employeeCode) {
        alert('กรุณากรอกรหัสพนักงาน');
        return;
    }

    showLoading(); // แสดง Loading

    fetch('{{ url('/employee/search') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ employee_code: employeeCode })
    })
        .then(response => response.json())
        .then(data => {



            const resultDiv = document.getElementById('result');
            const resultDiv2 = document.getElementById('result2');
            if (data.success) {

                hideLoading();

                step2.classList.remove("hidden");
                step1.classList.add("hidden");
                employeeData = data.data; // เก็บข้อมูลพนักงาน
                resultDiv2.innerHTML = `
                    <div> <p style="color: white; font-size: 22px">${data.data[5]} <br>${data.data[4]}</p> </div>
                    <div> <p style="color: white; font-size: 20px">${data.data[3]}</p> </div>
                `;
            } else {
                hideLoading();
                resultDiv.innerHTML = `<p style="color: white;">ไม่พบข้อมูลของท่าน <br> โปรดติดต่อเจ้าหน้าที่</p>`;

            }
        })
        .catch(error => {
            hideLoading(); // ซ่อน Loading เมื่อเกิดข้อผิดพลาด
                console.error('Error:', error);
        });
});


document.getElementById('registerBtn').addEventListener('click', function () {
            if (!employeeData) {
                alert('ไม่พบข้อมูลพนักงาน กรุณาค้นหาอีกครั้ง');
                return;
            }

            const checkinType = 2; // เปลี่ยนเป็น 1 หรือ 2 ตามกรณี
            const container = document.querySelector(".chakra-container-page");
            const step2 = document.querySelector(".step2");
            const step3 = document.querySelector(".step3");
            showLoading(); // แสดง Loading


            fetch('{{ url('/employee/register') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ employee_code: employeeData[4], employee_name: employeeData[5], checkin : checkinType  })
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading(); // ซ่อน Loading
                    if (data.success) {

                        step3.classList.remove("hidden");
                        step2.classList.add("hidden");

                        container.style.backgroundImage = "url('img/bg1.png')"; // Set the second background

                    } else {
                        alert('เกิดข้อผิดพลาด: ' + data.message);
                    }
                })
                .catch(error => {
                    hideLoading(); // ซ่อน Loading เมื่อเกิดข้อผิดพลาด
                    console.error('Error:', error);
                });
        });


    });
  </script>

@stop('scripts')
