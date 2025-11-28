<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>นโยบายความเป็นส่วนตัว - HONOR</title>
    <link rel="stylesheet" href="{{ url('/home/assets/css/honor.css') }}">
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
<body>
<div class="page-wrapper2">

    <header class="page-header">
        <a href="{{ url('/') }}">
            <img src="{{ url('img/honor/logo@2x.png') }}" alt="HONOR Logo" style="margin-left:20px">
        </a>
    </header>

    <main class="page-content">

            <div class="regis-container">
    <h1 class="regis-title">แก้ไขข้อมูลส่วนตัว</h1>
    <p class="regis-subtitle">อัปเดตข้อมูลของคุณเพื่อใช้ในกิจกรรม</p>

    <form method="POST" action="{{ url('/edit-profile') }}" onsubmit="return validateForm();" class="regis-form">
        @csrf

        <!-- คำนำหน้า -->
        <label>คำนำหน้า</label>
        <select name="prefix" class="regis-input" required>
            <option value="">-- เลือก --</option>
            <option value="นาย" {{ $user->prefix == 'นาย' ? 'selected' : '' }}>นาย</option>
            <option value="นาง" {{ $user->prefix == 'นาง' ? 'selected' : '' }}>นาง</option>
            <option value="นางสาว" {{ $user->prefix == 'นางสาว' ? 'selected' : '' }}>นางสาว</option>
        </select>

        <label>ชื่อ</label>
        <input type="text" name="first_name" class="regis-input" value="{{ $user->first_name }}" required>

        <label>นามสกุล</label>
        <input type="text" name="last_name" class="regis-input" value="{{ $user->last_name }}" required>

        <label>วันเดือนปีเกิด</label>
        <input type="date" name="hbd" class="regis-input" value="{{ $user->hbd }}" required>

        <!-- ประเภทเอกสาร -->
        <div class="id-wrapper">

            <label class="custom-radio">
                <input type="radio" name="id_type" value="citizen"
                       {{ $user->id_type == 'citizen' ? 'checked' : '' }}>
                <span class="radiomark"></span>
                เลขบัตรประชาชน
            </label>
            <input type="text" name="citizen_id" maxlength="13"
                   class="regis-input"
                   value="{{ $user->citizen_id }}">

            <br><br>

            <label class="custom-radio">
                <input type="radio" name="id_type" value="passport"
                       {{ $user->id_type == 'passport' ? 'checked' : '' }}>
                <span class="radiomark"></span>
                หมายเลขพาสปอร์ต
            </label>
            <input type="text" name="passport_id"
                   class="regis-input"
                   value="{{ $user->passport_id }}">
        </div>

        <label>Email</label>
        <input type="email" name="email" class="regis-input"
               value="{{ $user->email }}" required>

<label>จังหวัด</label>
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

    // อายุ
    if (!checkAge()) {
        Swal.fire({
            icon: "error",
            title: "อายุไม่ถึงเกณฑ์",
            text: "ผู้ใช้งานต้องมีอายุอย่างน้อย 18 ปีขึ้นไป",
            confirmButtonText: "ตกลง"
        });
        return false;
    }

    // citizen / passport
    if (!validateIdentity()) {
        Swal.fire({
            icon: "warning",
            title: "ข้อมูลเอกสารถูกต้องหรือไม่?",
            text: "กรุณาตรวจสอบเลขบัตรประชาชนหรือหมายเลขพาสปอร์ตอีกครั้ง",
            confirmButtonText: "ตกลง"
        });
        return false;
    }

    // email
    if (!validateEmailFormat()) {
        Swal.fire({
            icon: "warning",
            title: "อีเมลไม่ถูกต้อง",
            text: "กรุณากรอกอีเมลในรูปแบบที่ถูกต้อง เช่น example@mail.com",
            confirmButtonText: "ตกลง"
        });
        return false;
    }

    return true;
}

</script>



</body>
</html>
