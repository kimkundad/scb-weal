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
    flex-direction: column; /* เรียงเนื้อหาแนวตั้ง */
    text-align: center;
    color: white;
}
/* หมายเลขโต๊ะ */
.seat-number-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.seat-number {
    font-size: 140px;
    font-weight: bold;
    color: #ff7d00;
    text-align: center; /* จัดข้อความตรงกลางแนวนอน */

    /* ปรับขนาดให้เป็นวงกลม */
    width: 240px;
    height: 240px;
    border-radius: 50%;
    background-color: #fff;

    /* ทำให้ข้อความอยู่กึ่งกลางทั้งแนวตั้งและแนวนอน */
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'TTB ExtraBold'
}
.save-close-btn {
  margin-top: 20px;
  width: 80%;
  cursor: pointer;
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

<div id="main" >
    <div class="chakra-container-page">
        <div id="content" >

            <h2 style="color: white; font-size: 36px;">ลงทะเบียนสำเร็จ!</h2>
            <p style="font-size: 31px;">หมายเลขโต๊ะของคุณ</p>

            <!-- หมายเลขโต๊ะ -->
            <div class="seat-number-container">
                <div class="seat-number">{{ $tableNumber }}</div>
            </div>

            <p style="font-size: 22px; margin-top:10px">
                โปรดแสดงหน้านี้ให้กับเจ้าหน้าที่ <br>
บริเวณประตูทางเข้าฮอล
            </p>

            <!-- ปุ่ม Save & Close -->
            <div class="text-center">
                <a href="{{ url('/') }}">
                    <img src="{{ url('img/btn2/btn-close2x-8-fix.png') }}" style="width:45%" class="save-close-btn img-fluid d-block mx-auto" />
                </a>
            </div>


        </div>
    </div>
</div>


@endsection

@section('scripts')

<script>

  </script>

@stop('scripts')
