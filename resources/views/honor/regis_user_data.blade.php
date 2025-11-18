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

                <form method="POST" action="{{ url('/regis_user_data') }}" onsubmit="return validateForm();" class="regis-form">
                    @csrf
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

                    <label for="email">อีเมล์</label>
                    <input type="email" name="email" id="email" class="regis-input" required
                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                        title="กรุณากรอกอีเมลให้ถูกต้อง เช่น your@email.com" />

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

<script>
document.querySelectorAll("input[required], select[required], textarea[required]").forEach(function(input) {
    input.addEventListener("invalid", function() {
        this.setCustomValidity("โปรดกรอกข้อมูลให้ครบถ้วน");
    });

    input.addEventListener("input", function() {
        this.setCustomValidity(""); // เคลียร์ข้อความเมื่อพิมพ์ใหม่
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const daySelect   = document.getElementById("hbd_day");
    const monthSelect = document.getElementById("hbd_month");
    const yearSelect  = document.getElementById("hbd_year");
    const hbdInput    = document.getElementById("hbd");

    // ใส่วัน 1-31
    for (let d = 1; d <= 31; d++) {
        daySelect.innerHTML += `<option value="${d.toString().padStart(2,'0')}">${d}</option>`;
    }

    // ใส่เดือนเป็นชื่อไทย
    const months = [
        "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
        "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
    ];

    months.forEach((m, i) => {
        monthSelect.innerHTML += `<option value="${(i+1).toString().padStart(2,'0')}">${m}</option>`;
    });

    // ใส่ปี พ.ศ. → ค.ศ.
    const currentYear = new Date().getFullYear() + 543;
    const startYear   = currentYear - 80; // ย้อนหลัง 80 ปี

    for (let y = currentYear; y >= startYear; y--) {
        yearSelect.innerHTML += `<option value="${y}">${y}</option>`;
    }

    // ก่อน submit → รวมค่า และแปลง พ.ศ. → ค.ศ.
    document.querySelector("form").addEventListener("submit", function () {
        let d = daySelect.value;
        let m = monthSelect.value;
        let y_th = parseInt(yearSelect.value); // พ.ศ.
        let y_ad = y_th - 543; // แปลงเป็น ค.ศ.

        hbdInput.value = `${y_ad}-${m}-${d}`;
    });

});
</script>


</body>

</html>
