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

.field__input, .field__textarea {
    border-radius: 50px;
        height: 65px;
        font-family: 'TTB ExtraBold', sans-serif !important;
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

            <form id="form_search" class="form" method="POST" action="{{ url('/api_search') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="text-center">
                <div class="p-26 step1 text-center" style="">
                        <div class="form-group">
                            <div class="text-center"> <p style="color: white; font-size: 32px; font-family: 'TTB ExtraBold', sans-serif !important;">กรอกรหัสพนักงาน</p> </div>
                            <input type="text" name="employee_code" style="width:310px" id="employeeCode" value="{{ old('number') }}" class="field__input" required>
                        </div>
                                <div id="result" style="margin-top: 10px; height: 70px; color: green;  text-align: center; font-size: 20px; ">
                        </div>
                        <div class="text-center">
                            <img id="searchBtn" src="{{ url('img/btn/btn-enter2x-8.png') }}" style="width:55%" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>


@endsection

@section('scripts')

<script>
document.getElementById('searchBtn').addEventListener('click', function(event) {
    event.preventDefault(); // ป้องกันการ submit ทันที

    // แสดง loading animation
    document.getElementById('loading').style.display = 'block';

    // ส่งฟอร์มหลังจากแสดง loading
    setTimeout(() => {
        document.getElementById('form_search').submit();
    }, 500); // เพิ่มเวลาเล็กน้อยเพื่อให้เห็น loading
});
</script>

@stop('scripts')
