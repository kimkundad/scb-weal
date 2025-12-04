<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Primary Meta Tags -->
    <title>ลุ้นขับ Mercedes-Benz เมื่อซื้อ HONOR X9d 5G</title>
    <meta name="title" content="ลุ้นขับ Mercedes-Benz เมื่อซื้อ HONOR X9d 5G">
    <meta name="description" content="ชิงรถ C 350e AMG + ทองคำ 10 รางวัล รวมมูลค่ากว่า 3.2 ล้านบาท | ร่วมกิจกรรม 4 ธ.ค. 68 – 11 ม.ค. 69 | ประกาศผล 13 ม.ค. 69">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://honorluckydraw.com/">
    <meta property="og:title" content="ลุ้นขับ Mercedes-Benz เมื่อซื้อ HONOR X9d 5G">
    <meta property="og:description" content="ชิงรถ C 350e AMG + ทองคำ 10 รางวัล มูลค่ารวมกว่า 3.2 ล้านบาท">
    <meta property="og:image" content="{{ url('img/honor/224402.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://honorluckydraw.com/">
    <meta property="twitter:title" content="ลุ้นขับ Mercedes-Benz เมื่อซื้อ HONOR X9d 5G">
    <meta property="twitter:description" content="ชิงรถ C 350e AMG + ทองคำ 10 รางวัล มูลค่ารวมกว่า 3.2 ล้านบาท">
    <meta property="twitter:image" content="{{ url('img/honor/224402.jpg') }}">
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
    .custom-radio input[type="radio"]:checked+.radiomark::after {
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
                <h1 class="regis-title">ลงทะเบียนข้อมูลผู้ใช้ <br>Register user information</h1>
                <p class="regis-subtitle">กรอกข้อมูลของคุณเพื่อสร้างบัญชีผู้ใช้สำหรับเข้าร่วมกิจกรรม HONOR X9d ทนนน... จัด! คุ้มจัด ลุ้นขับ Mercedes-Benz <br>
Fill in your details to create a user account for
participant in the event

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

                <form method="POST" action="{{ url('/regis_user_data') }}" onsubmit="return validateForm();"
                    class="regis-form">
                    @csrf

                    <!-- คำนำหน้า -->
                    <label>คำนำหน้า</label>
                    <select name="prefix" class="regis-input">
                        <option value="">-- เลือก / Select --</option>
                        <option value="Mr." {{ old('prefix') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                        <option value="Mrs." {{ old('prefix') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                        <option value="Ms." {{ old('prefix') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                    </select>
                    @error('prefix')
                        <p class="input-error">{{ $message }}</p>
                    @enderror


                    <label>ชื่อ (Name)</label>
                    <input type="text" name="first_name" class="regis-input" value="{{ old('first_name') }}">

                    <label>นามสกุล (Lastname)</label>
                    <input type="text" name="last_name" class="regis-input" value="{{ old('last_name') }}">

                    <label for="hbd_day">วัน เดือน ปีเกิด (Date of Birth)</label>

                    <div class="hbd-wrapper">
                        <select name="hbd_day" id="hbd_day" class="regis-input hbd-select">
                            @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ sprintf('%02d', $i) }}"
                                    {{ old('hbd_day') == sprintf('%02d', $i) ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <select name="hbd_month" id="hbd_month" class="regis-input hbd-select">


                            <option value="01" {{ old('hbd_month') == '01' ? 'selected' : '' }}>มกราคม</option>
                            <option value="02" {{ old('hbd_month') == '02' ? 'selected' : '' }}>กุมภาพันธ์</option>
                            <option value="03" {{ old('hbd_month') == '03' ? 'selected' : '' }}>มีนาคม</option>
                            <option value="04" {{ old('hbd_month') == '04' ? 'selected' : '' }}>เมษายน</option>
                            <option value="05" {{ old('hbd_month') == '05' ? 'selected' : '' }}>พฤษภาคม</option>
                            <option value="06" {{ old('hbd_month') == '06' ? 'selected' : '' }}>มิถุนายน</option>
                            <option value="07" {{ old('hbd_month') == '07' ? 'selected' : '' }}>กรกฎาคม</option>
                            <option value="08" {{ old('hbd_month') == '08' ? 'selected' : '' }}>สิงหาคม</option>
                            <option value="09" {{ old('hbd_month') == '09' ? 'selected' : '' }}>กันยายน</option>
                            <option value="10" {{ old('hbd_month') == '10' ? 'selected' : '' }}>ตุลาคม</option>
                            <option value="11" {{ old('hbd_month') == '11' ? 'selected' : '' }}>พฤศจิกายน</option>
                            <option value="12" {{ old('hbd_month') == '12' ? 'selected' : '' }}>ธันวาคม</option>
                        </select>
                        @php
                            $maxYear = date('Y') + 543 - 17; // อายุครบ 18
                            $minYear = $maxYear - 80; // ย้อนหลัง 80 ปี (ปรับได้)
                        @endphp

                        <select name="hbd_year" id="hbd_year" class="regis-input hbd-select">
                            @foreach (range($maxYear, $minYear) as $y)
                                <option value="{{ $y }}" {{ old('hbd_year') == $y ? 'selected' : '' }}>
                                    {{ $y }}</option>
                            @endforeach
                        </select>

                        <input type="hidden" id="hbd" name="hbd">
                    </div>

                    <p id="age-error" class="input-error">ต้องมีอายุอย่างน้อย 18 ปีบริบูรณ์</p>

                    <!-- ตัวเลือกประเภทเอกสาร -->
                    <div class="id-wrapper">

                        <label class="custom-radio">
                            <input type="radio" name="id_type" value="citizen"
                                {{ old('id_type') == 'citizen' ? 'checked' : '' }}>
                            <span class="radiomark"></span>
                            เลขบัตรประชาชน (Identification Number)
                        </label>
                        <input type="text" id="citizen_id" name="citizen_id" class="regis-input" maxlength="13"
                            value="{{ old('citizen_id') }}" placeholder="กรอกเลขบัตรประชาชน 13 หลัก">
                        <br><br>
                        <label class="custom-radio">
                            <input type="radio" name="id_type" value="passport"
                                {{ old('id_type') == 'passport' ? 'checked' : '' }}>
                            <span class="radiomark"></span>
                            หมายเลขพาสปอร์ต (Passport Number)
                        </label>
                        <input type="text" id="passport_id" name="passport_id" class="regis-input"
                            value="{{ old('passport_id') }}" placeholder="กรอกเลขพาสปอร์ต">

                    </div>
                    <p id="id-error" class="input-error">กรุณากรอกข้อมูลตามประเภทที่เลือก</p>


                    <label for="email">อีเมล (E-mail)</label>
                    <input type="email" name="email" class="regis-input" value="{{ old('email') }}"
                        title="กรุณากรอกอีเมลให้ถูกต้อง เช่น your@email.com">

                    <p id="email-error" class="input-error" style="display:none;">
                        กรุณากรอกอีเมลให้ถูกต้อง
                    </p>

                    <label for="province">จังหวัด (Province)</label>
                    <input list="province-list" name="province" id="province" class="regis-input"
                        value="{{ old('province') }}">

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


                    @if (session('email_exists'))
                        @php
                            $email = session('email_value');
                            [$name, $domain] = explode('@', $email);
                            $maskedEmail = substr($name, 0, 1) . '***@' . $domain;
                        @endphp

                        <div class="alert-box text-center">
                            <p class="alert-text">
                                อีเมล {{ $maskedEmail }} ของคุณได้ลงทะเบียนแล้ว
                            </p>

                            <a href="{{ url('/dashboard2') }}?email={{ urlencode($email) }}"
                                class="btn-confirm mt-20">
                                โปรดเข้าสู่หน้าตรวจสอบสิทธิ์
                            </a>
                        </div>
                    @endif

                    @if (!session('email_exists'))
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
                <a href="{{ url('/terms') }}" class="footer-link">เงื่อนไขกิจกรรม</a> |
                <a href="{{ url('/privacy-policy') }}" class="footer-link">นโยบายความเป็นส่วนตัว</a>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JS ส่วนตรวจสอบข้อมูล -->
    <script>
        function validateForm() {

            const prefix = document.querySelector("select[name='prefix']").value.trim();
            const fname = document.querySelector("input[name='first_name']").value.trim();
            const lname = document.querySelector("input[name='last_name']").value.trim();

            const d = document.getElementById("hbd_day").value;
            const m = document.getElementById("hbd_month").value;
            const y_th = document.getElementById("hbd_year").value; // พ.ศ.

            const idType = document.querySelector("input[name='id_type']:checked");
            const citizen = document.getElementById("citizen_id").value.trim();
            const passport = document.getElementById("passport_id").value.trim();
            const email = document.querySelector("input[name='email']").value.trim();
            const province = document.getElementById("province").value.trim();


            // --------------------------
            // 1) ตรวจว่ากรอกข้อมูลครบ
            // --------------------------
            if (!prefix || !fname || !lname || !d || !m || !y_th || !province) {
                Swal.fire({
                    icon: "warning",
                    title: "กรุณากรอกข้อมูลให้ครบทุกช่อง",
                });
                return false;
            }

            if (!idType) {
                Swal.fire({
                    icon: "warning",
                    title: "กรุณาเลือกประเภทเอกสาร",
                });
                return false;
            }


            // --------------------------
            // 2) ตรวจสอบอายุ >= 18 ปี
            // ห้ามเกิดหลัง 14 ม.ค. 2551
            // --------------------------
            let y_ad = parseInt(y_th) - 543;
            let birthDate = new Date(`${y_ad}-${m}-${d}`);
            let minBirthDate = new Date("2008-01-14"); // 14 ม.ค. 2551

            if (birthDate > minBirthDate) {
                Swal.fire({
                    icon: "error",
                    title: "อายุไม่ถึง 18 ปีบริบูรณ์",
                    text: "ผู้ที่เกิดหลังวันที่ 14 มกราคม 2551 ไม่สามารถเข้าร่วมกิจกรรมได้",
                });
                return false;
            }

            // ส่งค่า พ.ศ. ไป Laravel
            document.getElementById("hbd").value = `${y_th}-${m}-${d}`;


            // --------------------------
            // 3) ตรวจบัตรประชาชน / พาสปอร์ต
            // --------------------------
            if (idType.value === "citizen") {
                if (!/^\d{13}$/.test(citizen)) {
                    Swal.fire({
                        icon: "error",
                        title: "เลขบัตรประชาชนไม่ถูกต้อง",
                        text: "กรุณากรอกเลขบัตรประชาชน 13 หลัก",
                    });
                    return false;
                }
            }

            if (idType.value === "passport") {
                if (passport.length < 6) {
                    Swal.fire({
                        icon: "error",
                        title: "หมายเลขพาสปอร์ตไม่ถูกต้อง",
                        text: "กรุณากรอกพาสปอร์ตอย่างน้อย 6 ตัวอักษร",
                    });
                    return false;
                }
            }

            if (isNaN(birthDate.getTime())) {
                Swal.fire({
                    icon: "error",
                    title: "วันเกิดไม่ถูกต้อง"
                });
                return false;
            }


            const provinceList = [...document.querySelectorAll('#province-list option')].map(o => o.value);
            if (!provinceList.includes(province)) {
                Swal.fire({
                    icon: "warning",
                    title: "กรุณาเลือกจังหวัดจากรายการ"
                });
                return false;
            }


            // --------------------------
            // 4) ตรวจอีเมล
            // --------------------------
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (!emailPattern.test(email)) {
                Swal.fire({
                    icon: "error",
                    title: "อีเมลไม่ถูกต้อง",
                    text: "กรุณากรอกอีเมลให้ถูกต้อง เช่น example@email.com",
                });
                return false;
            }

            return true;
        }
    </script>



</body>

</html>
