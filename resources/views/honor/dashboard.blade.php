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
    /* ครอบตารางให้เลื่อนได้ */
    .table-scroll {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* ป้องกันตารางยืดหรือบีบจนแปลก */
    .table-scroll table {
        border-collapse: collapse;
        min-width: 420px;
        /* ความกว้างขั้นต่ำ ให้เหมาะกับเนื้อหา */
        width: max-content;
        /* ให้ตารางหดขยายตามเนื้อหาจริง */
    }

    /* เฮดเดอร์ตาราง */
    .table-scroll th {
        white-space: nowrap;
        background: #f5f5f5;
        padding: 10px;
        font-weight: bold;
        text-align: center;
    }

    /* แต่ละเซลล์ */
    .table-scroll td {
        white-space: nowrap;
        padding: 10px;
        text-align: center;
    }

    /* ≤ 480px (มือถือจอใหญ่) */
    @media (max-width: 480px) {
        .table-scroll {
            max-width: 450px;
            margin: 0 auto;
        }
    }

    /* ≤ 430px (iPhone XR/11/Samsung Note) */
    @media (max-width: 430px) {
        .table-scroll {
            max-width: 410px;
            margin: 0 auto;
        }
    }

    /* ≤ 400px (Pixel / Android หลายรุ่น) */
    @media (max-width: 400px) {
        .table-scroll {
            max-width: 380px;
            margin: 0 auto;
        }
    }

    /* ≤ 375px (iPhone SE, Samsung รุ่นเล็ก) */
    @media (max-width: 375px) {
        .table-scroll {
            max-width: 360px;
            margin: 0 auto;
        }
    }

    /* ≤ 360px (มือถือรุ่นเล็กมาก, จอเล็กจีน) */
    @media (max-width: 360px) {
        .table-scroll {
            max-width: 340px;
            margin: 0 auto;
        }
    }

    /* ≤ 330px (กรณี extreme เช่น หน้าจอเล็กมาก) */
    @media (max-width: 330px) {
        .table-scroll {
            max-width: 310px;
            margin: 0 auto;
        }
    }

    .table-scroll th,
    .table-scroll td {
        padding: 6px 0px;
        /* บีบช่องว่างซ้าย-ขวาให้แคบลง */
        white-space: nowrap;
        text-align: center;
    }
</style>

<body>

    <div class="page-wrapper2">

        <!-- Header -->
        <header class="page-header">
            <a href="{{ url('/') }}">
                <img src="{{ url('img/honor/logo@2x.png') }}" alt="HONOR logo" style="margin-left:20px">
            </a>
            <!-- เพิ่ม hamburger menu ได้ที่นี่หากต้องการ -->
            <a href="{{ url('/logout-honor') }}" class="btn-logout-header">
                <i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ
            </a>
        </header>

        <!-- Main Content -->
        <main class="page-content">
            <div class="regis-container" style="text-align: center;">
                <h1 class="regis-title">สิทธิ์ของฉัน {{ session()->get('phone') }} <br> My eligibility </h1>
                <p class="regis-subtitle">คุณมีสิทธิ์ลุ้นรางวัลทั้งหมด <br> Total eligibility for the lucky draw</p>
                <h2 style="font-size: 48px; font-weight: bold; color: #22c55e;">{{ $totalApproved }} สิทธิ์ <span style="font-size: 22px;">(Eligibility)</span></h2>

                <a href="{{ url('/regis_user_upslip') }}" class="btn-secondary mt-20">เพิ่มสิทธิ์ลุ้นรางวัล</a>

                <a href="{{ url('/edit-profile') }}" class="btn-confirm mt-20">
                    แก้ไขข้อมูลส่วนตัว
                </a>


                <!-- ตารางรายการใบเสร็จ -->
                <div class="receipt-table mt-30">
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>วันที่ส่ง <br> Summit date</th>
                                    <th>วันที่ซื้อ <br> Purchase date</th>
                                    <th>IMEI</th>
                                    <th>สถานะ <br> Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    function thaidate($date)
                                    {
                                        $d = \Carbon\Carbon::parse($date);
                                        $months = [
                                            'Jan' => 'ม.ค.',
                                            'Feb' => 'ก.พ.',
                                            'Mar' => 'มี.ค.',
                                            'Apr' => 'เม.ย.',
                                            'May' => 'พ.ค.',
                                            'Jun' => 'มิ.ย.',
                                            'Jul' => 'ก.ค.',
                                            'Aug' => 'ส.ค.',
                                            'Sep' => 'ก.ย.',
                                            'Oct' => 'ต.ค.',
                                            'Nov' => 'พ.ย.',
                                            'Dec' => 'ธ.ค.',
                                        ];

                                        $day = $d->format('d');
                                        $month = $months[$d->format('M')];
                                        $year = $d->year + 543;

                                        return "{$day} {$month} {$year}";
                                    }
                                @endphp

                                @foreach ($receipts as $r)
                                    <tr>
                                        <td>{{ thaidate($r->created_at) }}</td>
                                        <td>{{ thaidate($r->purchase_date) }}</td>
                                        <td>{{ $r->imei }}</td>
                                        <td>
                                            <span class="status {{ $r->status }}">
                                                {{ $r->status === 'approved' ? 'Approved' : ($r->status === 'pending' ? 'Pending' : 'Reject') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="info-text mt-30">*สถานะการตรวจสอบใบเสร็จจะอัปเดตภายใน 3 วันทำการ</p>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                confirmButtonText: 'ตกลง',
                timer: 2500
            });
        </script>
    @endif

</body>

</html>
