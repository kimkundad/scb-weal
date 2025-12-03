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


    <link rel="stylesheet" href="{{ url('/home/assets/css/honor.css') }}?v={{ time() }}" type="text/css" />
    <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ url('/img/honor/favicon.ico') }}">
</head>


<style>
/* ───────────────────────────────────────────
   Responsive Intro Cover (เฉพาะหน้านี้)
──────────────────────────────────────────── */
.intro-bg {
    width: 100%;
    display: flex;
    justify-content: center;
}

.intro-inner {
    width: 100%;
    max-width: 900px; /* กำหนด Max สำหรับ Desktop */
    margin: 0 auto;
}

.intro-img {
    width: 100%;
    height: auto;
    aspect-ratio: 16 / 9;   /* ควบคุมสัดส่วนรูป */
    object-fit: cover;      /* ครอบพื้นที่อย่างสวยงาม */
    border-radius: 6px;
}

/* ปุ่มใต้ภาพขยายตามความกว้าง */
.intro-inner .btn-confirm {
    display: block;
    margin: 20px auto 0 auto;

    max-width: 350px;
}

/* สำหรับจอใหญ่ (Desktop 1200px+) */
@media (min-width: 1200px) {
    .intro-inner {
        max-width: 1100px; /* ใหญ่ขึ้น แต่ไม่ล้น */
    }
}

/* สำหรับมือถือ */
@media (max-width: 767px) {
    .intro-img {
        aspect-ratio: unset;
        height: auto;   /* ปล่อยรูปตามสัดส่วนจริง */
        object-fit: contain; /* หรือ cover หากต้องการ */
    }
}
</style>
<style>
body.index-page .page-wrapper2 {
    max-width: 100% !important;
}
.btn-full {
    width: 100%;
    display: block;
    text-align: center;
    padding: 14px 0;
    border-radius: 12px;
    font-size: 18px;
}

.intro-desktop {
    display: none;
}

/* ถ้าเป็น Desktop ≥ 768px → ซ่อนรูปมือถือ และแสดงรูป Desktop */
@media (min-width: 768px) {
    .intro-mobile {
        display: none;
    }
    .intro-desktop {
        display: block;
    }
}
</style>

<body class="index-page">
    <div class="page-wrapper2">

        <!-- Header -->
        <header class="page-header">
            <a href="{{ url('/') }}">
                <img src="{{ url('img/honor/logo@2x.png') }}" alt="OWNDAYS logo" style="margin-left:20px">
            </a>
        </header>
        <!-- Main Content -->
        <main class="page-content">

            <div class="intro-bg">
                <div class="intro-inner">
                    <img src="{{ url('img/honor/219423.jpg') }}"
     alt="intro mobile"
     class="intro-img intro-mobile">

<img src="{{ url('img/honor/224402.jpg') }}"
     alt="intro desktop"
     class="intro-img intro-desktop">


                    <a id="btnJoin" href="{{ url('/terms_conditions') }}"
                    class="btn-full btn-confirm mt-20"
                    style="display:none;">
                        Join the event
                    </a>

                    <a id="btnVerify" href="{{ url('/dashboard') }}"
                    class="btn-full btn-secondary mt-20 mw-350"
                    style="display:none;">
                    Verify your eligibility
                    </a>

                </div>
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
</body>


<script>
document.addEventListener("DOMContentLoaded", function () {

    // เวลาเริ่มแสดงปุ่ม (ตามโซนเวลาไทย)
    const showTime = new Date("2025-12-04T01:58:00+07:00");

    function checkTime() {
        const now = new Date();
            console.log('showTime', showTime)
        if (now >= showTime) {
            document.getElementById("btnJoin").style.display = "";
            document.getElementById("btnVerify").style.display = "";
        } else {
            // ยังไม่ถึงเวลา — ซ่อนไว้ก่อน
            document.getElementById("btnJoin").style.display = "none";
            document.getElementById("btnVerify").style.display = "none";
        }
    }

    // เช็คทันทีที่โหลด
    checkTime();

    // เช็คทุกๆ 1 วินาที (เพื่อไม่ต้องกด Refresh)
    setInterval(checkTime, 3000);
});
</script>

</html>
