<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OWNDAYS</title>
    <link rel="stylesheet" href="{{ url('/home/assets/css/intro.css') }}?v={{ time() }}" type="text/css" />
    <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ url('/img/owndays/favicon.ico') }}">
</head>

<body>
    <div class="page-wrapper2">

        <!-- Header -->
        <header class="page-header">
            <a href="{{ url('/') }}">
      <img src="{{ url('img/owndays/logo.png') }}" alt="OWNDAYS logo" style="margin-left:20px">
      </a>
        </header>

        <!-- Main Content -->
        <main class="page-content" >




            <div class="intro-bg">
                <div class="intro-inner" style="padding: 5px 15px; ">
                    <br><br>
                    <img src="{{ url('img/owndays/' . $product['path'] . '/img.png') }}" style="width:30%;">


                    <!-- หัวข้อหลัก -->
                    <h2 class="result-title" style="color: {{ $product['color_main'] }}">
                        {!! $product['title'] !!}
                    </h2>

                    <!-- คำอธิบายสั้น -->
                    <p class="result-subtitle" style="color: {{ $product['color_sub'] }}">
                        {!! $product['subtitle'] !!}
                    </p>

                    <!-- เนื้อหาคำอธิบาย -->
                    <p class="result-desc" style="color: {{ $product['color_desc'] }}">
                        {!! $product['desc'] !!}
                    </p>

                    <!-- ✅ สไลด์สินค้า -->
                    <div class="product-carousel">
                        <div class="carousel-track">
                            <img src="{{ url('img/owndays/' . $product['path'] . '/p1.png') }}" alt="Product 1">
                            <img src="{{ url('img/owndays/' . $product['path'] . '/p2.png') }}" alt="Product 2">
                            <img src="{{ url('img/owndays/' . $product['path'] . '/p3.png') }}" alt="Product 3">
                        </div>
                        <!-- ปุ่มเลื่อน -->

                    </div>

                    <!-- ข้อความด้านล่าง -->
                    <div class="result-footer">
                        <p class="result-footer-title" style="color: {{ $product['color_footer'] }}">
                            {!! $product['footer'] !!}
                        </p>
                    </div>

                    <br>

                    <a href="{{ $product['link'] }}" class="start-btn" style="margin-bottom: 1px;     width: 90%;">
                        <img src="{{ url('img/owndays/link@3x.png') }}" alt="พร้อมแล้ว ไปต่อกันเลย" class="btn-image">
                    </a>

                    <a href="{{ url('/rating') }}" class="a-link" style="margin-bottom: 30px; margin-top: 15px">
                        <p style="margin: 15px auto">ให้คะแนนแบบสอบถาม</p>
                    </a>

                    <br><br>

                </div>

            </div>

        </main>

        <!-- Footer -->
        <footer class="page-footer2">
            <div class="copyright2">
                COPYRIGHT (C) OWNDAYS co., ltd. ALL RIGHTS RESERVED.<br>
                นโยบายความเป็นส่วนตัว | ข้อตกลงและเงื่อนไขในการบริการ
            </div>
        </footer>

    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const track = document.querySelector(".carousel-track");
        const slides = Array.from(track.children);

        let currentIndex = 0;
        let autoSlideInterval;

        // ✅ ฟังก์ชันเลื่อนสไลด์
        function updateCarousel() {
            const width = slides[0].clientWidth;
            track.style.transform = `translateX(-${currentIndex * width}px)`;
        }



        // ✅ Auto Slide ทุก 3 วินาที
        function startAutoSlide() {
            autoSlideInterval = setInterval(() => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateCarousel();
            }, 3000);
        }

        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        // ✅ รองรับการ “สัมผัสเลื่อน” (มือถือ)
        let startX = 0;
        let isDragging = false;

        track.addEventListener("touchstart", (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
            clearInterval(autoSlideInterval); // หยุด auto ขณะเลื่อน
        });

        track.addEventListener("touchmove", (e) => {
            if (!isDragging) return;
            const diffX = e.touches[0].clientX - startX;
            track.style.transform =
                `translateX(calc(-${currentIndex * slides[0].clientWidth}px + ${diffX}px))`;
        });

        track.addEventListener("touchend", (e) => {
            const diffX = e.changedTouches[0].clientX - startX;
            const threshold = 50; // ระยะขั้นต่ำในการ swipe

            if (diffX > threshold) {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            } else if (diffX < -threshold) {
                currentIndex = (currentIndex + 1) % slides.length;
            }

            updateCarousel();
            isDragging = false;
            startAutoSlide(); // กลับมา auto อีกครั้ง
        });

        window.addEventListener("resize", updateCarousel);

        // ✅ เริ่มทำงานทันที
        updateCarousel();
        startAutoSlide();
    });
</script>

</html>
