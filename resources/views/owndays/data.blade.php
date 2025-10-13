<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OWNDAYS</title>
    <link rel="stylesheet" href="{{ url('/home/assets/css/intro.css') }}?v={{ time() }}" type="text/css" />
    <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ url('/img/owndays/favicon.ico') }}">
<link rel="stylesheet" href="{{ url('bootstrap-datepicker-thai/jquery.datetimepicker.css') }}">


</head>

<body>
    <div class="page-wrapper2">

        <!-- Header -->
        <header class="page-header">
            <a href="{{ url('/') }}">
      <img src="{{ url('img/owndays/logo.png') }}" alt="OWNDAYS logo" style="margin-left:20px">
      </a>
        </header>

        <!-- Main Content -->
        <main class="page-content" >


            <div class="intro-bg">
                <div class="intro-inner" style="padding: 5px 15px; ">

                    <img src="{{ url('img/owndays/text@3x@3x.png') }}" alt="intro" class="intro-img">
                    <br><br><br>
                    <form action="{{ url('/submitForm') }}" method="POST" id="infoForm" class="form-container">
                        @csrf

                        <div class="form-group">
                            <label>เพศ</label>
                            <select name="gender" required>
                                <option value="หญิง">หญิง</option>
                                <option value="ชาย">ชาย</option>
                                <option value="LGBTQIA+">LGBTQIA+</option>
                                <option value="ไม่ประสงค์ระบุ">ไม่ประสงค์ระบุ</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>วันเกิดของคุณ</label>
                            <input type="text" id="birthday" name="age" placeholder="เลือกวันเกิดของคุณ"
                                required>
                        </div>
                        <br>
                        <a href="javascript:void(0)" onclick="submitInfoForm()" class="start-btn"
                            style="    margin-bottom: 0px;">
                            <img src="{{ url('img/owndays/confirm.png') }}" alt="พร้อมแล้ว ไปต่อกันเลย"
                                class="btn-image">
                        </a>

                    </form>


                </div>

            </div>

        </main>

        <!-- Footer -->
        <footer class="page-footer2">
            <div class="copyright2">
                COPYRIGHT (C) OWNDAYS co., ltd. ALL RIGHTS RESERVED.<br>
                นโยบายความเป็นส่วนตัว | ข้อตกลงและเงื่อนไขในการบริการ
            </div>
        </footer>

    </div>
</body>

<!-- ✅ ใช้เวอร์ชันที่มี thaiyear ทำงานแน่นอน -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="{{ url('bootstrap-datepicker-thai/jquery.datetimepicker.full.js') }}"></script>




 <!-- ✅ Script: ใช้ พ.ศ. ตลอด + แปลงกลับ ค.ศ. ก่อนส่ง -->
<script type="text/javascript">
$(function(){

    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

    // กรณีใช้แบบ inline
    $("#testdate4").datetimepicker({
        timepicker:false,
        format:'d-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
        lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
        inline:true
    });


    // กรณีใช้แบบ input
    // กรณีใช้แบบ input
    $("#birthday").datetimepicker({
        timepicker:false,
        format:'d-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
        lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
        onSelectDate:function(dp,$input){
            var yearT=new Date(dp).getFullYear()-0;
            var yearTH=yearT+543;
            var fulldate=$input.val();
            var fulldateTH=fulldate.replace(yearT,yearTH);
            $input.val(fulldateTH);
        },
    });
    // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
    $("#birthday").on("mouseenter mouseleave",function(e){
        var dateValue=$(this).val();
        if(dateValue!=""){
                var arr_date=dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
                // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
                //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0
                if(e.type=="mouseenter"){
                    var yearT=arr_date[2]-543;
                }
                if(e.type=="mouseleave"){
                    var yearT=parseInt(arr_date[2])+543;
                }
                dateValue=dateValue.replace(arr_date[2],yearT);
                $(this).val(dateValue);
        }
    });


});
</script>




<script>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("infoForm");
  const birthday = document.getElementById("birthday");

  // ✅ เปลี่ยนข้อความแจ้งเตือนของช่อง "วันเกิด"
  birthday.addEventListener("invalid", function (e) {
    e.target.setCustomValidity("กรุณาเลือกวันเกิดของคุณ");
  });

  birthday.addEventListener("input", function (e) {
    e.target.setCustomValidity(""); // ล้างข้อความเมื่อผู้ใช้แก้ไข
  });

  form.addEventListener("submit", function (e) {
    // ✅ ตรวจสอบว่า valid ไหมก่อนส่ง
    if (!form.checkValidity()) {
      e.preventDefault();
      form.reportValidity();
    }
  });
});
</script>

<script>
    function submitInfoForm() {
        const form = document.getElementById('infoForm');

        // ตรวจสอบว่า field สำคัญกรอกครบไหม
        if (form.checkValidity()) {
            form.submit();
        } else {
            form.reportValidity(); // แจ้งเตือนฟิลด์ที่ยังไม่ครบ
        }
    }
</script>

</html>
