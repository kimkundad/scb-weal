<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @yield('title')
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

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
