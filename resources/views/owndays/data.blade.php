<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OWNDAYS</title>
    <link rel="stylesheet" href="{{ url('/home/assets/css/intro.css') }}?v={{ time() }}" type="text/css" />
    <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ url('/img/owndays/favicon.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
        <main class="page-content" style="width: 100%;">


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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- ภาษาไทย -->
<script src="https://npmcdn.com/flatpickr/dist/l10n/th.js"></script>

<!-- script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  flatpickr("#birthday", {
    locale: "th",
    dateFormat: "d/m/Y",
    maxDate: "today",
    disableMobile: true,
    allowInput: true,

    onReady: fixThaiYear,
    onOpen: fixThaiYear,
    onMonthChange: fixThaiYear,
    onYearChange: fixThaiYear,
  });

  function fixThaiYear(selectedDates, dateStr, instance) {
    // ✅ แก้ปีใน header ของปฏิทินให้เป็นพ.ศ.
    setTimeout(() => {
      const yearEl = instance.calendarContainer.querySelector(".cur-year");
      if (yearEl) {
        const year = parseInt(yearEl.value);
        if (year < 2500) yearEl.value = year + 543;
      }

      // ✅ ป้องกัน scroll เปลี่ยนปี
      const numInputs = instance.calendarContainer.querySelectorAll(".numInputWrapper");
      numInputs.forEach(wrapper => {
        wrapper.addEventListener("wheel", e => e.preventDefault());
      });
    }, 10);
  }

  // ✅ แปลงเป็นพ.ศ.เฉพาะตอนผู้ใช้พิมพ์เสร็จ (input blur)
  const input = document.getElementById("birthday");
  input.addEventListener("blur", () => {
    const parts = input.value.split("/");
    if (parts.length === 3) {
      let [day, month, year] = parts;
      year = parseInt(year);
      if (year && year < 2400) {
        input.value = `${day}/${month}/${year + 543}`;
      }
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
