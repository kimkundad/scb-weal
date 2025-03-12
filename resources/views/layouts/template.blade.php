<!-- headers-->
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="ยินดีต้อนรับเหล่ากองทัพผีเสื้อ เข้าสู่ค่ำคืนแห่งการเปลี่ยนแปลงที่มีความหมาย The Meaningful Change for Life">
    <title> The Meaningful Change for Life </title>
    <link rel="icon" href="{{ url('img/favicon.ico') }}" type="image/x-icon">

    {{-- <meta property="og:url"           content="https://nextfamilychallenge-vetbuddyexpert.com" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Welcome to Next Family Challenge" />
    <meta property="og:image"         content="{{ url('img/banner_shared.jpg') }}" />
    <meta property="og:description"   content="ขอเรียนเชิญคุณหมอร่วมแชร์ประสบการณ์การรักษาน้องแมวโปรแกรมใหม่! ครบทุกการป้องกันเพื่อน้องแมวโดยเฉพาะ" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="314" /> --}}

    @include('layouts.inc-style')
    @yield('stylesheet')

</head>

<body class="layout-row">


        @yield('content')




    <!-- JavaScripts -->
    @include('layouts.inc-script')
    @yield('scripts')


</body>

</html>
