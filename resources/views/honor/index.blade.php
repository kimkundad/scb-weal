<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HONOR X9C</title>
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
    width: 80%;
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
                    <img src="{{ url('img/honor/219423.jpg') }}" alt="intro" class="intro-img ">
                    <a href="{{ url('/privacy') }}" class="btn-confirm mt-20">เข้าร่วมกิจกรรม</a>

                    <a href="{{ url('/dashboard') }}" class="btn-secondary mt-20 mw-350">
                        ตรวจสอบสิทธิ์ของคุณ
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

</html>
