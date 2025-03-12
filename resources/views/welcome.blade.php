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

            <div class="justify-content-center" >
                <img src="{{ url('img/btn/text2x-8.png') }}" class="img-fluid d-block mx-auto" style="width: 75%;" />
                <br>
                <img src="{{ url('img/btn/KV2x-8.png') }}" class="img-fluid d-block mx-auto" style="width: 75%;" />
            </div>
            <br><br>
            <div class="text-center">
                <a href="{{ url('/search') }}">
                    <img src="{{ url('img/btn/btn-register2x-8.png') }}" class="img-fluid d-block mx-auto" style="width: 50%;" />
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
