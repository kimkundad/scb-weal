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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>

/* สไตล์ radio ให้สวยเหมือน checkbox */


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

    <header class="page-header">
        <a href="{{ url('/') }}">
            <img src="{{ url('img/honor/logo@2x.png') }}" alt="HONOR Logo" style="margin-left:20px">
        </a>
        <a href="{{ url('/logout-honor') }}" class="btn-logout-header">
                <i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ
            </a>
    </header>

    <main class="page-content">

            <div class="regis-container">
    <h1 class="regis-title">แก้ไขข้อมูลส่วนตัว <br> Edit Personal Information</h1>
    <p class="regis-subtitle">อัปเดตข้อมูลของคุณเพื่อใช้ในกิจกรรม <br> Update your details for participation in the event.</p>

    <form method="POST" action="{{ url('/edit-profile') }}" onsubmit="return validateForm();" class="regis-form">
        @csrf


        <!-- คำนำหน้า -->
        <label>คำนำหน้า</label>
        <select name="prefix" class="regis-input" required>
            <option value="">-- เลือก / Select --</option>
            <option value="Mr." {{ $user->prefix == 'Mr.' ? 'selected' : '' }}>Mr.</option>
            <option value="Mrs." {{ $user->prefix == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
            <option value="Ms." {{ $user->prefix == 'Ms.' ? 'selected' : '' }}>Ms.</option>
        </select>

        <label>ชื่อ (Name)</label>
        <input type="text" name="first_name" class="regis-input" value="{{ $user->first_name }}" required>

        <label>นามสกุล (Lastname)</label>
        <input type="text" name="last_name" class="regis-input" value="{{ $user->last_name }}" required>

        <label for="hbd_day">วัน เดือน ปีเกิด (Date of Birth)</label>

<div class="hbd-wrapper">

    {{-- ⭐ DAY --}}
    <select name="hbd_day" id="hbd_day" class="regis-input hbd-select">
        @php
            $day = old('hbd_day') ?? \Carbon\Carbon::parse($user->hbd)->format('d');
        @endphp

        @for ($i = 1; $i <= 31; $i++)
            <option value="{{ sprintf('%02d', $i) }}"
                {{ $day == sprintf('%02d', $i) ? 'selected' : '' }}>
                {{ $i }}
            </option>
        @endfor
    </select>

    {{-- ⭐ MONTH --}}
    @php
        $month = old('hbd_month') ?? \Carbon\Carbon::parse($user->hbd)->format('m');
    @endphp

    <select name="hbd_month" id="hbd_month" class="regis-input hbd-select">

        <option value="01" {{ $month=='01' ? 'selected' : '' }}>มกราคม</option>
        <option value="02" {{ $month=='02' ? 'selected' : '' }}>กุมภาพันธ์</option>
        <option value="03" {{ $month=='03' ? 'selected' : '' }}>มีนาคม</option>
        <option value="04" {{ $month=='04' ? 'selected' : '' }}>เมษายน</option>
        <option value="05" {{ $month=='05' ? 'selected' : '' }}>พฤษภาคม</option>
        <option value="06" {{ $month=='06' ? 'selected' : '' }}>มิถุนายน</option>
        <option value="07" {{ $month=='07' ? 'selected' : '' }}>กรกฎาคม</option>
        <option value="08" {{ $month=='08' ? 'selected' : '' }}>สิงหาคม</option>
        <option value="09" {{ $month=='09' ? 'selected' : '' }}>กันยายน</option>
        <option value="10" {{ $month=='10' ? 'selected' : '' }}>ตุลาคม</option>
        <option value="11" {{ $month=='11' ? 'selected' : '' }}>พฤศจิกายน</option>
        <option value="12" {{ $month=='12' ? 'selected' : '' }}>ธันวาคม</option>
    </select>

    {{-- ⭐ YEAR (พ.ศ.) --}}
    @php
        $yearAD   = \Carbon\Carbon::parse($user->hbd)->format('Y');  // ค.ศ.
        $yearTH   = $yearAD + 543; // แปลงเป็น พ.ศ.
        $yearOld  = old('hbd_year') ?? $yearTH;

        $maxYear = date('Y') + 543 - 17;
        $minYear = $maxYear - 80;
    @endphp

    <select name="hbd_year" id="hbd_year" class="regis-input hbd-select">
        @foreach (range($maxYear, $minYear) as $y)
            <option value="{{ $y }}" {{ $yearOld == $y ? 'selected' : '' }}>
                {{ $y }}
            </option>
        @endforeach
    </select>

    {{-- ⭐ hidden field ส่ง พ.ศ. ไป Laravel --}}
    <input type="hidden" id="hbd" name="hbd">

</div>

        <!-- ประเภทเอกสาร -->
        <div class="id-wrapper">

            <label class="custom-radio">
                <input type="radio" name="id_type" value="citizen"
                       {{ $user->id_type == 'citizen' ? 'checked' : '' }}>
                <span class="radiomark"></span>
                เลขบัตรประชาชน (Identification Number)
            </label>
            <input type="text" name="citizen_id" maxlength="13"
                   class="regis-input"
                   value="{{ $user->citizen_id }}">

            <br><br>

            <label class="custom-radio">
                <input type="radio" name="id_type" value="passport"
                       {{ $user->id_type == 'passport' ? 'checked' : '' }}>
                <span class="radiomark"></span>
                หมายเลขพาสปอร์ต (Passport Number)
            </label>
            <input type="text" name="passport_id"
                   class="regis-input"
                   value="{{ $user->passport_id }}">
        </div>

        <label>Email</label>
        <input type="email" name="email" class="regis-input"
               value="{{ $user->email }}" required>

<label>จังหวัด (Province)</label>
       <select name="province" class="regis-input" required>
    <option value="">-- เลือกจังหวัด --</option>

    @php
        $provinces = [
            "กรุงเทพมหานคร","กระบี่","กาญจนบุรี","กาฬสินธุ์","กำแพงเพชร","ขอนแก่น",
            "จันทบุรี","ฉะเชิงเทรา","ชลบุรี","ชัยนาท","ชัยภูมิ","ชุมพร","เชียงราย",
            "เชียงใหม่","ตรัง","ตราด","ตาก","นครนายก","นครปฐม","นครพนม","นครราชสีมา",
            "นครศรีธรรมราช","นครสวรรค์","นนทบุรี","นราธิวาส","น่าน","บึงกาฬ","บุรีรัมย์",
            "ปทุมธานี","ประจวบคีรีขันธ์","ปราจีนบุรี","ปัตตานี","พระนครศรีอยุธยา","พังงา",
            "พัทลุง","พิจิตร","พิษณุโลก","เพชรบุรี","เพชรบูรณ์","แพร่","พะเยา","ภูเก็ต",
            "มหาสารคาม","มุกดาหาร","แม่ฮ่องสอน","ยโสธร","ยะลา","ร้อยเอ็ด","ระนอง","ระยอง",
            "ราชบุรี","ลพบุรี","ลำปาง","ลำพูน","เลย","ศรีสะเกษ","สกลนคร","สงขลา","สตูล",
            "สมุทรปราการ","สมุทรสงคราม","สมุทรสาคร","สระแก้ว","สระบุรี","สิงห์บุรี",
            "สุโขทัย","สุพรรณบุรี","สุราษฎร์ธานี","สุรินทร์","หนองคาย","หนองบัวลำภู","อ่างทอง",
            "อุดรธานี","อุทัยธานี","อุตรดิตถ์","อุบลราชธานี","อำนาจเจริญ"
        ];
    @endphp

    @foreach($provinces as $p)
        <option value="{{ $p }}" {{ $user->province == $p ? 'selected' : '' }}>
            {{ $p }}
        </option>
    @endforeach
</select>


        <div class="text-center">
            <button type="submit" class="btn-confirm mt-20">บันทึกข้อมูล</button>
        </div>
    </form>
</div>
    </main>

    <footer class="page-footer2">
        <div class="copyright2">
            © 2025 HONOR Thailand All rights reserved. <br>
            <a href="{{ url('/terms') }}" class="footer-link">เงื่อนไขกิจกรรม</a> |
            <a href="{{ url('/privacy-policy') }}" class="footer-link">นโยบายความเป็นส่วนตัว</a>
        </div>
    </footer>

</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// ---------------------------------------------------
// ✔ ตรวจสอบอายุ >= 18 ปี จาก input type="date"
// ---------------------------------------------------
function checkAge() {
    let hbd = document.querySelector("input[name='hbd']").value;
    if (!hbd) return false;

    let birth = new Date(hbd);
    let today = new Date();
    let age = today.getFullYear() - birth.getFullYear();

    if (today < new Date(today.getFullYear(), birth.getMonth(), birth.getDate())) {
        age--;
    }
    console.log(age);
    return age >= 18;
}

// ---------------------------------------------------
// ✔ ตรวจสอบ Citizen ID / Passport ID
// ---------------------------------------------------
function validateIdentity() {
    const type = document.querySelector("input[name='id_type']:checked");
    if (!type) return false;

    const citizen = document.querySelector("input[name='citizen_id']").value.trim();
    const passport = document.querySelector("input[name='passport_id']").value.trim();

    if (type.value === "citizen") {
        return /^\d{13}$/.test(citizen);
    }

    if (type.value === "passport") {
        return passport.length >= 6;
    }

    return false;
}

// ---------------------------------------------------
// ✔ ตรวจสอบอีเมล format
// ---------------------------------------------------
function validateEmailFormat() {
    const email = document.querySelector("input[name='email']").value.trim();
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|net|co\.th|org|io|edu|gov)$/;
    return regex.test(email);
}

// ---------------------------------------------------
// ✔ ฟังก์ชัน Validate ฟอร์มทั้งหมด (SweetAlert2)
// ---------------------------------------------------
function validateForm() {

    // ------------------------------
    // 1) ดึงค่าวัน / เดือน / ปี (พ.ศ.)
    // ------------------------------
    const d = document.getElementById("hbd_day").value;
    const m = document.getElementById("hbd_month").value;
    const y_th = document.getElementById("hbd_year").value;

    // สร้างวันเกิดแบบ พ.ศ. ส่งไป Laravel
    document.getElementById("hbd").value = `${y_th}-${m}-${d}`;

    // ------------------------------
    // 2) ตรวจสอบอายุ >= 18 ปี + ตรวจวัน cutoff
    // ------------------------------


    // ------------------------------
    // ⭐ เงื่อนไขเพิ่มเติม:
    // ห้ามเกิดหลัง 14 มกราคม 2551
    // ------------------------------
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

    // --------------------------------------------------
    // 4) ตรวจ Citizen / Passport
    // --------------------------------------------------
    const type = document.querySelector("input[name='id_type']:checked");
    const citizen = document.querySelector("input[name='citizen_id']").value.trim();
    const passport = document.querySelector("input[name='passport_id']").value.trim();

    if (!type) {
        Swal.fire({
            icon: "warning",
            title: "กรุณาเลือกประเภทเอกสาร",
        });
        return false;
    }

    if (type.value === "citizen" && !/^\d{13}$/.test(citizen)) {
        Swal.fire({
            icon: "warning",
            title: "เลขบัตรประชาชนไม่ถูกต้อง",
            text: "กรุณากรอกเลขบัตรประชาชน 13 หลัก",
        });
        return false;
    }

    if (type.value === "passport" && passport.length < 6) {
        Swal.fire({
            icon: "warning",
            title: "หมายเลขพาสปอร์ตไม่ถูกต้อง",
            text: "กรุณากรอกพาสปอร์ตอย่างน้อย 6 ตัวอักษร",
        });
        return false;
    }

    // --------------------------------------------------
    // 5) ตรวจ Email
    // --------------------------------------------------
    const email = document.querySelector("input[name='email']").value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {
        Swal.fire({
            icon: "warning",
            title: "อีเมลไม่ถูกต้อง",
            text: "กรุณากรอกอีเมลให้ถูกต้อง เช่น example@mail.com",
        });
        return false;
    }

    return true;
}



</script>



</body>
</html>
