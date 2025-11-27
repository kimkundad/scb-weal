<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ลงทะเบียนข้อมูลผู้ใช้ - HONOR</title>
    <link rel="stylesheet" href="{{ url('/home/assets/css/honor.css') }}?v={{ time() }}" />
</head>
<style>
.hbd-wrapper {
    display: flex;
    gap: 10px;
}

.hbd-select {
    flex: 1;
    padding: 12px;
}
</style>
<style>
.hbd-wrapper {
    display: flex;
    gap: 10px;
}

.hbd-select {
    flex: 1;
    padding: 12px;
}

.id-wrapper {
    margin-top: 15px;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 12px;
}

.id-option {
    margin-bottom: 10px;
    font-weight: 600;
}

.input-error {
    color: red;
    margin-top: 5px;
    display: none;
}
/* กล่องครอบ */
.id-wrapper {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 12px;
}

/* สไตล์ radio ให้สวยเหมือน checkbox */
.custom-radio {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-weight: 600;
    margin-bottom: 8px;
    user-select: none;
}

/* ซ่อน radio เดิม */
.custom-radio input[type="radio"] {
    position: absolute;
    opacity: 0;
    width: 20px;
    height: 20px;
    cursor: pointer;
}

/* วงกลม radio */
.radiomark {
    height: 20px;
    width: 20px;
    border: 2px solid #007bff;
    border-radius: 50%;
    display: inline-block;
    position: relative;
}

/* จุดข้างในเมื่อเลือก */
.custom-radio input[type="radio"]:checked + .radiomark::after {
    content: "";
    width: 12px;
    height: 12px;
    background: #007bff;
    border-radius: 50%;
    position: absolute;
    top: 4px;
    left: 4px;
}

/* hover */
.custom-radio:hover .radiomark {
    border-color: #0056b3;
}
</style>
<body>

    <div class="page-wrapper2">
        <!-- Header -->
        <header class="page-header">
            <a href="{{ url('/') }}">
                <img src="{{ url('img/honor/logo@2x.png') }}" alt="HONOR logo" style="margin-left:20px">
            </a>
        </header>

        <!-- Main Content -->
        <main class="page-content">
            <div class="regis-container">
                <h1 class="regis-title">ลงทะเบียนข้อมูลผู้ใช้</h1>
                <p class="regis-subtitle">กรอกข้อมูลของคุณเพื่อสร้างบัญชีผู้ใช้สำหรับเข้าร่วมกิจกรรม HONOR Lucky Receipt
                </p>


                @if ($errors->any())
    <div class="alert-box" style="margin-bottom: 20px; background:#ffe8e8; border:1px solid #ffb3b3;">
        <p style="color:#d00; font-weight:600; margin-bottom:8px;">
            โปรดตรวจสอบข้อมูลให้ครบถ้วน
        </p>

        <ul style="padding-left:18px; color:#b40000; font-size:14px; text-align:left;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                <form method="POST" action="{{ url('/regis_user_data') }}" onsubmit="return validateForm();" class="regis-form">
                    @csrf

                    <!-- คำนำหน้า -->
                    <label>คำนำหน้า</label>
                    <select name="prefix" class="regis-input" required>
                        <option value="">-- เลือก --</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                    @error('prefix')
                        <p class="input-error">{{ $message }}</p>
                    @enderror


                    <label>ชื่อ</label>
                    <input type="text" name="first_name" class="regis-input" required>

                    <label>นามสกุล</label>
                    <input type="text" name="last_name" class="regis-input" required>

                    <label for="hbd_day">วันเดือนปีเกิด</label>

                    <div class="hbd-wrapper">
                        <select id="hbd_day" class="regis-input hbd-select" required></select>
                        <select id="hbd_month" class="regis-input hbd-select" required></select>
                        <select id="hbd_year" class="regis-input hbd-select" required></select>

                        <input type="hidden" name="hbd" id="hbd">
                    </div>

                    <p id="age-error" class="input-error">ต้องมีอายุอย่างน้อย 18 ปีบริบูรณ์</p>

                                <!-- ตัวเลือกประเภทเอกสาร -->
                            <div class="id-wrapper">

                                <label class="custom-radio">
    <input type="radio" name="id_type" value="citizen" required>
    <span class="radiomark"></span>
    เลขบัตรประชาชน
</label>
                                <input type="text" id="citizen_id" name="citizen_id" class="regis-input"
                                    maxlength="13" placeholder="กรอกเลขบัตรประชาชน 13 หลัก">
<br><br>
                                <label class="custom-radio">
    <input type="radio" name="id_type" value="passport">
    <span class="radiomark"></span>
    หมายเลขพาสปอร์ต
</label>
                                <input type="text" id="passport_id" name="passport_id" class="regis-input"
                                    placeholder="กรอกเลขพาสปอร์ต">

                            </div>
                    <p id="id-error" class="input-error">กรุณากรอกข้อมูลตามประเภทที่เลือก</p>


                    <label for="email">อีเมล</label>
<input type="email"
       name="email"
       class="regis-input"
       required
       pattern="[^@\s]+@[^@\s]+\.[^@\s]+"
       title="กรุณากรอกอีเมลให้ถูกต้อง เช่น your@email.com">

<p id="email-error" class="input-error" style="display:none;">
    กรุณากรอกอีเมลให้ถูกต้อง
</p>

                    <label for="province">จังหวัด</label>
                    <input list="province-list" name="province" id="province" class="regis-input" required>

                    <datalist id="province-list">
                        <option value="กรุงเทพมหานคร">
                        <option value="กระบี่">
                        <option value="กาญจนบุรี">
                        <option value="กาฬสินธุ์">
                        <option value="กำแพงเพชร">
                        <option value="ขอนแก่น">
                        <option value="จันทบุรี">
                        <option value="ฉะเชิงเทรา">
                        <option value="ชลบุรี">
                        <option value="ชัยนาท">
                        <option value="ชัยภูมิ">
                        <option value="ชุมพร">
                        <option value="เชียงราย">
                        <option value="เชียงใหม่">
                        <option value="ตรัง">
                        <option value="ตราด">
                        <option value="ตาก">
                        <option value="นครนายก">
                        <option value="นครปฐม">
                        <option value="นครพนม">
                        <option value="นครราชสีมา">
                        <option value="นครศรีธรรมราช">
                        <option value="นครสวรรค์">
                        <option value="นนทบุรี">
                        <option value="นราธิวาส">
                        <option value="น่าน">
                        <option value="บึงกาฬ">
                        <option value="บุรีรัมย์">
                        <option value="ปทุมธานี">
                        <option value="ประจวบคีรีขันธ์">
                        <option value="ปราจีนบุรี">
                        <option value="ปัตตานี">
                        <option value="พระนครศรีอยุธยา">
                        <option value="พังงา">
                        <option value="พัทลุง">
                        <option value="พิจิตร">
                        <option value="พิษณุโลก">
                        <option value="เพชรบุรี">
                        <option value="เพชรบูรณ์">
                        <option value="แพร่">
                        <option value="พะเยา">
                        <option value="ภูเก็ต">
                        <option value="มหาสารคาม">
                        <option value="มุกดาหาร">
                        <option value="แม่ฮ่องสอน">
                        <option value="ยโสธร">
                        <option value="ยะลา">
                        <option value="ร้อยเอ็ด">
                        <option value="ระนอง">
                        <option value="ระยอง">
                        <option value="ราชบุรี">
                        <option value="ลพบุรี">
                        <option value="ลำปาง">
                        <option value="ลำพูน">
                        <option value="เลย">
                        <option value="ศรีสะเกษ">
                        <option value="สกลนคร">
                        <option value="สงขลา">
                        <option value="สตูล">
                        <option value="สมุทรปราการ">
                        <option value="สมุทรสงคราม">
                        <option value="สมุทรสาคร">
                        <option value="สระแก้ว">
                        <option value="สระบุรี">
                        <option value="สิงห์บุรี">
                        <option value="สุโขทัย">
                        <option value="สุพรรณบุรี">
                        <option value="สุราษฎร์ธานี">
                        <option value="สุรินทร์">
                        <option value="หนองคาย">
                        <option value="หนองบัวลำภู">
                        <option value="อ่างทอง">
                        <option value="อุดรธานี">
                        <option value="อุทัยธานี">
                        <option value="อุตรดิตถ์">
                        <option value="อุบลราชธานี">
                        <option value="อำนาจเจริญ">
                    </datalist>


                  @if(session('email_exists'))
                    @php
                        $email = session('email_value');
                        [$name, $domain] = explode('@', $email);
                        $maskedEmail = substr($name, 0, 1) . '***@' . $domain;
                    @endphp

                    <div class="alert-box text-center">
                        <p class="alert-text">
                            อีเมล {{ $maskedEmail }} ของคุณได้ลงทะเบียนแล้ว
                        </p>

                        <a href="{{ url('/dashboard2') }}?email={{ urlencode($email) }}" class="btn-confirm mt-20">
                            โปรดเข้าสู่หน้าตรวจสอบสิทธิ์
                        </a>
                    </div>
                @endif

                @if(!session('email_exists'))
                    <div class="text-center">
                        <button type="submit" class="btn-confirm mt-20">บันทึกและไปต่อ</button>
                    </div>
                @endif

                    <p class="info-text">ข้อมูลนี้จะถูกใช้เพื่อตรวจสอบสิทธิ์และติดต่อเมื่อได้รับรางวัล</p>
                </form>
            </div>
        </main>

        <!-- Footer -->
        <footer class="page-footer2">
            <div class="copyright2">
                © 2025 HONOR Thailand All rights reserved. <br>
                เงื่อนไขกิจกรรม | นโยบายความเป็นส่วนตัว
            </div>
        </footer>
    </div>

<!-- JS ส่วนตรวจสอบข้อมูล -->
<script>
// ---------------------------------------------------
// 1) สร้างวัน เดือน ปี (เหมือนเดิม)
// ---------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {

    const daySelect   = document.getElementById("hbd_day");
    const monthSelect = document.getElementById("hbd_month");
    const yearSelect  = document.getElementById("hbd_year");
    const hbdInput    = document.getElementById("hbd");

    // ใส่วัน
    for (let d = 1; d <= 31; d++) {
        daySelect.innerHTML += `<option value="${String(d).padStart(2, "0")}">${d}</option>`;
    }

    // ใส่เดือน
    // ใส่เดือน
const months = [
    "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน",
    "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม",
    "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
];
    months.forEach((m, i) => {
        monthSelect.innerHTML += `<option value="${String(i+1).padStart(2, "0")}">${m}</option>`;
    });

    // ปีไทย
    const currentYearTH = new Date().getFullYear() + 543;
    const startYearTH = currentYearTH - 80;

    for (let y = currentYearTH - 18; y >= startYearTH; y--) {
        yearSelect.innerHTML += `<option value="${y}">${y}</option>`;
    }

    // ⭐ กำหนดค่า default → 1 มกราคม 2550
    daySelect.value = "01";
    monthSelect.value = "01";
    yearSelect.value = "2550";

    // ⭐ ใส่ค่า default ลง hidden input ให้ Laravel รับค่าได้แน่นอน
    hbdInput.value = "2007-01-01"; // 2550 = 2007
});

// ---------------------------------------------------
// 2) ตรวจสอบอายุ ≥ 18 ปี
// ---------------------------------------------------
function checkAge() {
    let d = document.getElementById("hbd_day").value;
    let m = document.getElementById("hbd_month").value;
    let y = document.getElementById("hbd_year").value;

    if (!d || !m || !y) return false;

    let yearAD = parseInt(y) - 543;
    let birth = new Date(`${yearAD}-${m}-${d}`);
    let today = new Date();
    let age = today.getFullYear() - birth.getFullYear();

    if (today < new Date(today.getFullYear(), birth.getMonth(), birth.getDate())) {
        age--;
    }

    return age >= 18;
}

// ---------------------------------------------------
// 3) ตรวจสอบเลขบัตรประชาชน / พาสปอร์ต
// ---------------------------------------------------
function validateIdentity() {
    let type = document.querySelector("input[name='id_type']:checked");
    if (!type) return false;

    let citizen = document.getElementById("citizen_id").value.trim();
    let passport = document.getElementById("passport_id").value.trim();

    if (type.value === "citizen") {
        return /^\d{13}$/.test(citizen);
    }
    if (type.value === "passport") {
        return passport.length >= 6;
    }

    return false;
}

// ---------------------------------------------------
// 4) ตรวจสอบอีเมล format
// ---------------------------------------------------
function validateEmailFormat() {
    const email = document.getElementById("email").value.trim();
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|co\.th|net|org|io|edu|gov)$/;
    return regex.test(email);
}

// ---------------------------------------------------
// 5) ฟังก์ชันตรวจสอบทั้งหมดก่อน submit
// ---------------------------------------------------
function validateForm() {

    // ตรวจสอบอายุ
    if (!checkAge()) {
        document.getElementById("age-error").style.display = "block";
        return false;
    }
    document.getElementById("age-error").style.display = "none";

    // ตรวจสอบ identity
    if (!validateIdentity()) {
        document.getElementById("id-error").style.display = "block";
        return false;
    }
    document.getElementById("id-error").style.display = "none";

    // ตรวจสอบอีเมล
    if (!validateEmailFormat()) {
        document.getElementById("email-error").style.display = "block";
        return false;
    }
    document.getElementById("email-error").style.display = "none";

    // รวมวันเดือนปีเกิดลง hidden input
    let d = document.getElementById("hbd_day").value;
    let m = document.getElementById("hbd_month").value;
    let y_th = document.getElementById("hbd_year").value;
    let y_ad = y_th - 543;

    document.getElementById("hbd").value = `${y_ad}-${m}-${d}`;

    return true;
}

</script>



</body>

</html>
