<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ลงทะเบียนข้อมูลผู้ใช้ - HONOR</title>
    <link rel="stylesheet" href="{{ url('/home/assets/css/honor.css') }}?v={{ time() }}" />
</head>

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


                    <div class="text-center">
                        <button type="submit" class="btn-confirm mt-20">บันทึกและไปต่อ</button>
                    </div>

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



</body>

</html>
