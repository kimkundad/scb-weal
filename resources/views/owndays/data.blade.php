<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OWNDAYS</title>
    <link rel="stylesheet" href="{{ url('/home/assets/css/intro.css') }}?v={{ time() }}" type="text/css" />
    <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ url('/img/owndays/favicon.ico') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<style>
/* ✅ เพิ่ม dropdown ให้เลือกปีและเดือนได้ง่ายขึ้น */
.flatpickr-current-month {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 6px;
}

.flatpickr-monthDropdown-months, .numInput.cur-year {
  font-size: 15px !important;
  padding: 2px 6px !important;
  border-radius: 4px;
  background-color: #f3f3f3;
  border: 1px solid #ddd;
}
</style>

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

                    <img src="{{ url('img/owndays/fix-title.png') }}" alt="intro" class="intro-img">
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>
 <!-- ✅ Script: ใช้ พ.ศ. ตลอด + แปลงกลับ ค.ศ. ก่อนส่ง -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("birthday");

  const fp = flatpickr(input, {
    locale: "th",
    dateFormat: "d/m/Y",
    maxDate: "today",
    disableMobile: true,
    allowInput: false, // ✅ ปิดโหมด manual เพื่อไม่ให้ค่าหาย
    clickOpens: true,

    onReady: enhanceYearDropdown,
    onOpen: enhanceYearDropdown,
    onYearChange: enhanceYearDropdown,
    onMonthChange: enhanceYearDropdown,

    onChange: function(selectedDates, dateStr, instance) {
      if (dateStr) {
        const [d, m, y] = dateStr.split("/");
        const buddhistYear = parseInt(y) + 543;
        input.value = `${d}/${m}/${buddhistYear}`; // ✅ แสดงเป็น พ.ศ.
      }
    },
  });

  // ✅ แปลงปีใน Header เป็น Dropdown + พ.ศ.
  function enhanceYearDropdown(selectedDates, dateStr, instance) {
    const yearEl = instance.currentYearElement;
    if (!yearEl) return;

    // ถ้าไม่เคยเปลี่ยนเป็น select ให้เปลี่ยนเลย
    if (yearEl.tagName.toLowerCase() !== "select") {
      const currentYear = parseInt(yearEl.value);
      const select = document.createElement("select");
      select.className = "flatpickr-year-select";

      // ✅ เพิ่มปีในช่วงที่เหมาะสม เช่น 1950 - ปัจจุบัน
      for (let y = 1950; y <= new Date().getFullYear(); y++) {
        const option = document.createElement("option");
        option.value = y;
        option.textContent = y + 543; // แสดงเป็น พ.ศ.
        if (y === currentYear) option.selected = true;
        select.appendChild(option);
      }

      // แทนที่ year input เดิม
      yearEl.parentNode.replaceChild(select, yearEl);

      // ✅ เมื่อผู้ใช้เลือกปีใหม่
      select.addEventListener("change", function () {
        instance.changeYear(parseInt(this.value)); // Flatpickr API
      });
    }
  }

  // ✅ ก่อนส่ง form แปลงกลับเป็น ค.ศ.
  const form = document.getElementById("infoForm");
  if (form) {
    form.addEventListener("submit", function () {
      const parts = input.value.split("/");
      if (parts.length === 3) {
        let [d, m, y] = parts;
        if (parseInt(y) > 2500) {
          input.value = `${d}/${m}/${parseInt(y) - 543}`;
        }
      }
    });
  }
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
