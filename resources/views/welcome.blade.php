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
  background-image: url('{{ url('img/bg_first.jpg') }}'); /* ลิงก์รูปภาพ */
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

<div id="main" >
    <div class="chakra-container-page">
        <div id="content" >

            <div class="justify-content-center" >
                <img src="{{ url('img/btn/text2x-8.png') }}" class="img-fluid d-block mx-auto" style="width: 75%;" />
                <br>
                <img src="{{ url('img/btn/KV2x-8-fix.png') }}" class="img-fluid d-block mx-auto" style="width: 75%;" />
            </div>
            <br><br>
            <div class="text-center">
                <a href="{{ url('/search') }}">
                    <img src="{{ url('img/btn2/btn-register2x-8-fix.png') }}" class="img-fluid d-block mx-auto" style="width: 50%;" />
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
