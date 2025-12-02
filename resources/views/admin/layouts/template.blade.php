<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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

    {{-- Global styles (Metronic + ฟอนต์ + ธีมของคุณ) --}}
    @include('admin.layouts.inc-style')

    {{-- เพิ่ม CSS เฉพาะหน้าด้วย @section('stylesheet') --}}
    @yield('stylesheet')
</head>
<body class="app-blank">

    {{-- เนื้อหาของแต่ละหน้า --}}
    @yield('content')

    {{-- Global scripts (Metronic + plugins ทั่วไป) --}}
    @include('admin.layouts.inc-script')

    {{-- เพิ่ม JS เฉพาะหน้าด้วย @section('scripts') --}}
    @yield('scripts')
</body>
</html>
