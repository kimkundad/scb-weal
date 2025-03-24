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
  background-image: url('{{ url('img/myBg.jpg') }}'); /* ลิงก์รูปภาพ */
  background-size: contain; /* ปรับให้รูปเต็มพื้นที่ */
  background-position: center; /* วางรูปตรงกลาง */
  background-repeat: no-repeat; /* ป้องกันการซ้ำของรูป */
  width: 100%;
    height: 100vh; /* เปลี่ยนจาก 80vh เป็น 100vh */
    display: flex;  /* ใช้ Flexbox */
    justify-content: center; /* จัดตรงกลางแนวนอน */
    align-items: center; /* จัดตรงกลางแนวตั้ง */
    transition: background-image 1s ease-in-out;
}
 @media (max-width: 768px) {
    .chakra-container-page {
        background-size: cover !important; /* ปรับให้รูปเต็มหน้าจอ */
        background-position: center !important;
        overflow: hidden; /* ป้องกันเลื่อนหน้าจอแล้วเห็นส่วนเกิน */
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

            <div class="text-center"> <p style="color: white; font-size: 28px; margin-top: 150px; margin-bottom: 0px; font-family: 'TTB ExtraBold', sans-serif !important;">รหัสพนักงาน</p> </div>
            <div class="text-center"> <p style="color: white; font-size: 34px; margin-bottom: 0px; font-family: 'TTB ExtraBold', sans-serif !important;">{{ $data[0] }}</p> </div>
            <div class="text-center"> <p style="color: white; font-size: 28px; margin-top: 10px; font-family: 'TTB ExtraBold', sans-serif !important;">{{ $data[1] }} {{ $data[2] }}</p>  </div>
            <div class="text-center"> <p style="color: white; font-size: 24px; margin-top: -15px; font-family: 'TTB Regular', sans-serif !important;">{{ $data[3] }}</p> </div>

            <div class="text-center" style="margin-top: 140px">
               <img id="registerBtn" src="{{ url('img/btn2/btn-register_12x-8-fix.png') }}" class="img-fluid d-block mx-auto" style="width: 50%;" />
               <br>
               <a href="{{ url('/search') }}">
               <img src="{{ url('img/btn2/btn-back2x-8-fix.png') }}" class="img-fluid d-block mx-auto" style="width: 50%;" />
               <a>
            </div>

        </div>
    </div>
</div>


@endsection

@section('scripts')

<script>
document.getElementById('registerBtn').addEventListener('click', function() {
    const employeeCode = "{{ $data[0] }}";

    // ✅ แสดง Loading Animation
    document.getElementById('loading').style.display = 'block';

    // ✅ ซ่อน Loading หลังจาก 5 วินาที
    setTimeout(() => {
        document.getElementById('loading').style.display = 'none';
    }, 3000); // 5000ms = 5 วินาที

    fetch("{{ url('/employee/register') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ employee_code: employeeCode })
    })
    .then(response => response.json()) // ✅ รับ JSON ตรง ๆ ไม่มีปัญหา Unexpected token '<'
    .then(data => {
        if (data.success) {
            window.location.href = "{{ url('/result') }}/" + data.tableNumber; // ✅ Redirect ไปที่ /result/{tableNumber}
        } else {
            alert("❌ " + data.message);
        }
    })
    .catch(error => {
        console.error("Fetch Error:", error);
        alert("เกิดข้อผิดพลาด: " + error);
    });
});
</script>



@stop('scripts')
