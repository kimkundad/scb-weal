<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>OwnDays</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/owndays.css') }}?v={{ time() }}" type="text/css" />
  <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ url('/img/owndays/favicon.ico') }}?v={{ time() }}">
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

        <div class="form-row">
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
            <label>อายุ</label>
            <input type="text" name="age" placeholder="24" value="{{ old('age') }}" required>
          </div>
        </div>



        <div class="form-group">
          <label>อาชีพ</label>
          <select name="career" required>
            <option value="">เลือกกลุ่มอาชีพ</option>
            <option value="นักเรียน/นักศึกษา">นักเรียน / นักศึกษา</option>
            <option value="พนักงานออฟฟิศ">พนักงานออฟฟิศ</option>
            <option value="เจ้าของกิจการ">เจ้าของกิจการ</option>
            <option value="ฟรีแลนซ์">ฟรีแลนซ์</option>
            <option value="อื่นๆ">อื่นๆ</option>
          </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>จังหวัด</label>
                <select name="province" id="province" required>
                    <option value="">กำลังโหลด...</option>
                </select>
            </div>

          <div class="form-group">
            <label>รายได้โดยประมาณ</label>
            <select name="income" required>
              <option value="">เลือกช่วงรายได้</option>
              <option value="ต่ำกว่า 10,000">ต่ำกว่า 10,000</option>
              <option value="10,000-18,000">10,000 - 18,000</option>
              <option value="18,001-30,000">18,001 - 30,000</option>
              <option value="30,001-50,000">30,001 - 50,000</option>
              <option value="มากกว่า 50,000">มากกว่า 50,000</option>
            </select>
          </div>
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

<script>
  fetch("https://raw.githubusercontent.com/kongvut/thai-province-data/refs/heads/master/api/latest/province.json")
    .then(res => {
      if (!res.ok) throw new Error("HTTP error " + res.status);
      return res.json();
    })
    .then(data => {
      const sel = document.getElementById("province");
      sel.innerHTML = '<option value="">เลือกจังหวัด</option>';
      data.forEach(p => {
        const opt = document.createElement("option");
        opt.value = p.name_th;
        opt.textContent = p.name_th;
        sel.appendChild(opt);
      });
    })
    .catch(err => {
      console.error("โหลดจังหวัดไม่สำเร็จ:", err);
      const sel = document.getElementById("province");
      sel.innerHTML = '<option value="">ไม่สามารถโหลดข้อมูลได้</option>';
    });
</script>


</html>
