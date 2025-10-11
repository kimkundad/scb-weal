<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>OwnDays</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/owndays.css') }}?v={{ time() }}" type="text/css" />
  <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ url('/img/owndays/favicon.ico') }}?v={{ time() }}">

  <!-- Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



</head>
<body>
  <div class="wrapper">
    <header>
      <a href="{{ url('/') }}">
        <img src="{{ url('img/owndays/logo.png') }}" alt="owndays logo" />
      </a>
    </header>

        <main>

            <div class="question-section">
                <div class="intro-container2">
                    <div class="intro-container">
                        <img src="{{ url('img/owndays/text@3x@3x.png') }}" style="width: 278px; margin-top:45px">


        <form action="{{ url('/submitForm') }}" method="POST" id="infoForm" class="form-container">
        @csrf

        <div class="form-group">
                <label>เพศ</label>
                <select name="gender" required>
                  <option value="">ไม่ระบุ</option>
                  <option value="ชาย">ชาย</option>
                  <option value="หญิง">หญิง</option>
                  <option value="อื่นๆ">อื่นๆ</option>
                </select>
              </div>

              <div class="form-group">
                <label>วัน/เดือน/ปีเกิด</label>
                <input type="text" id="birthday" name="age" placeholder="เลือกวันเกิดของคุณ" required>
            </div>

        <!-- ปุ่มซ้อนอยู่บนรูป -->
                       <a href="javascript:void(0)" onclick="submitInfoForm()"
                        class="btn-image-link pt-45-res w-btn-90" style="bottom: auto;">
                        <img src="{{ url('img/owndays/confirm.png') }}"
                            alt="พร้อมแล้ว ไปต่อกันเลย"
                            class="btn-image">
                        </a>

      </form>


                    </div>
                </div>
            </div>
        </main>


    <footer>
      <div class="copyright">
        COPYRIGHT (C) OWNDAYS co., ltd. ALL RIGHTS RESERVED. <br> นโยบายความเป็นส่วนตัว | ข้อตกลงและเงื่อนไขในการบริการ
      </div>
    </footer>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- ภาษาไทย -->
<script src="https://npmcdn.com/flatpickr/dist/l10n/th.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    flatpickr("#birthday", {
      locale: "th",
      dateFormat: "d/m/Y",       // รูปแบบไทย
      maxDate: "today",          // ห้ามเลือกวันอนาคต
      disableMobile: true,       // ใช้ theme เดิมบนมือถือด้วย
      defaultDate: null
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
