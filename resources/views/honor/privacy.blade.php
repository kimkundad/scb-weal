<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HONOR X9C</title>
    <link rel="stylesheet" href="{{ url('/home/assets/css/honor.css') }}?v={{ time() }}" type="text/css" />
    <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ url('/img/honor/favicon.ico') }}">
</head>

<body>
    <div class="page-wrapper2">

        <!-- Header -->
        <header class="page-header">
            <a href="{{ url('/') }}">
                <img src="{{ url('img/honor/logo@2x.png') }}" alt="OWNDAYS logo" style="margin-left:20px">
            </a>
        </header>
        <!-- Main Content -->
        <main class="page-content">

            <div class="privacy-container">
                <h1 class="privacy-title">เงื่อนไขการร่วมกิจกรรม<br><small>(Terms & Conditions)</small></h1>

                <p class="privacy-paragraph">
                    กิจกรรม “HONOR Lucky Receipt” จัดขึ้นโดย HONOR Thailand
                    เพื่อมอบสิทธิ์ลุ้นรับรางวัลให้กับลูกค้าที่ซื้อสมาร์ทโฟน HONOR X9c ภายในระยะเวลาที่กำหนด
                    (4 ธันวาคม 2568 – 11 มกราคม 2569) และอัปโหลดใบเสร็จผ่านระบบเว็บไซต์ตามขั้นตอนที่ระบุ
                </p>

                <div class="privacy-section">
                    <h2>1. เงื่อนไขการเข้าร่วม</h2>
                    <ul>
                        <li>ผู้เข้าร่วมต้องเป็นบุคคลสัญชาติไทย อายุ 18 ปีขึ้นไป</li>
                        <li>ซื้อสินค้ารุ่น HONOR X9c จากร้านค้าที่ร่วมรายการเท่านั้น</li>
                        <li>ใบเสร็จต้องออกภายในช่วงวันที่ที่กำหนด และต้องมีข้อมูลชัดเจน</li>
                        <li>แต่ละ IMEI สามารถร่วมกิจกรรมได้ 1 สิทธิ์เท่านั้น</li>
                    </ul>
                </div>

                <div class="privacy-section">
                    <h2>2. ของรางวัลและการประกาศผล</h2>
                    <ul>
                        <li>รางวัลใหญ่: รถยนต์ Mercedes-Benz 1 คัน</li>
                        <li>รางวัลปลอบใจ: คูปองเงินสด 50 บาท</li>
                        <li>ประกาศผลผู้โชคดีวันที่ 20 มกราคม 2569</li>
                    </ul>
                </div>

                <div class="privacy-section">
                    <h2>3. นโยบายความเป็นส่วนตัว (Privacy Policy)</h2>
                    <p>
                        ข้อมูลส่วนบุคคลของผู้เข้าร่วม เช่น ชื่อ นามสกุล เบอร์โทรศัพท์ อีเมล และหมายเลข IMEI
                        จะถูกเก็บรวบรวมเพื่อวัตถุประสงค์ในการตรวจสอบสิทธิ์และติดต่อผู้ได้รับรางวัลเท่านั้น
                        โดย HONOR Thailand จะไม่เปิดเผยข้อมูลดังกล่าวแก่บุคคลภายนอก เว้นแต่เป็นไปตามกฎหมาย
                    </p>
                </div>

                <div class="privacy-section">
                    <h2>4. ข้อกำหนดเพิ่มเติม</h2>
                    <p>ผู้จัดขอสงวนสิทธิ์ในการเปลี่ยนแปลงเงื่อนไข โดยไม่ต้องแจ้งให้ทราบล่วงหน้า</p>
                </div>

                <div class="privacy-check mt-20">
                    <label>
                        <input type="checkbox" id="agree" >
                        <span class="checkmark"></span>
                        ข้าพเจ้ายอมรับเงื่อนไขและนโยบายความเป็นส่วนตัว
                    </label>
                </div>


            </div>

            <a href="{{ url('/regis_honor') }}" class="btn-confirm mt-20">เข้าร่วมกิจกรรม</a>
            <br><br>

        </main>


        <!-- Footer -->
        <footer class="page-footer2">
            <div class="copyright2">
                © 2025 HONOR Thailand All rights reserved. <br> เงื่อนไขกิจกรรม | นโยบายความเป็นส่วนตัว
            </div>
        </footer>

    </div>
</body>

</html>
