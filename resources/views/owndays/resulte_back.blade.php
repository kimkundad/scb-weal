<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>OwnDays</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/owndays.css') }}?v={{ time() }}" type="text/css" />
  <link rel="icon" type="image/x-icon" sizes="32x32" href="{{ url('/img/owndays/favicon.ico') }}?v={{ time() }}">
</head>
<body>
  <div class="wrapper" style="background: {{ $product['bg'] }};">
    <header>
      <a href="{{ url('/') }}">
        <img src="{{ url('img/owndays/logo.png') }}" alt="owndays logo" />
      </a>
    </header>

        <main >

            <div class="question-section">
                <div class="intro-bg">
                    <div class="intro-inner" >
                    <div class="intro-container" >

                        <div style="height:680px">


                            <img src="{{ url('img/owndays/' . $product['path'] . '/img.png') }}" style="width:84px;">


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
                                <button class="carousel-btn prev">‹</button>
                                <button class="carousel-btn next">›</button>
                            </div>

                            <!-- ข้อความด้านล่าง -->
                            <div class="result-footer">
                                <p class="result-footer-title" style="color: {{ $product['color_footer'] }}">
                                    {!! $product['footer'] !!}
                                </p>
                            </div>

                            <img src="{{ url('img/owndays/reNew.png') }}" style="width: 100%">


                            <a href="{{ url('/') }}" class="btn-image-link pt-45-res w-btn-90" style="bottom: -15px">
                            <img src="{{ url('img/owndays/link@3x.png') }}"
                                alt="พร้อมแล้ว ไปต่อกันเลย"
                                class="btn-image">
                            </a>

                        </div>


                    </div>
                    </div>
                </div>
            </div>
        </main>


    <footer>
      <div class="copyright">
        COPYRIGHT (C) OWNDAYS co., ltd. ALL RIGHTS RESERVED. <br> นโยบายความเป็นส่วนตัว | ข้อตกลงและเงื่อนไขในการบริการ
      </div>
    </footer>
  </div>
</body>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const track = document.querySelector(".carousel-track");
    const slides = Array.from(track.children);
    const nextBtn = document.querySelector(".carousel-btn.next");
    const prevBtn = document.querySelector(".carousel-btn.prev");
    let currentIndex = 0;
    let autoSlideInterval;

    // ✅ ฟังก์ชันเลื่อนสไลด์
    function updateCarousel() {
      const width = slides[0].clientWidth;
      track.style.transform = `translateX(-${currentIndex * width}px)`;
    }

    // ✅ ปุ่ม Next / Prev
    nextBtn.addEventListener("click", () => {
      currentIndex = (currentIndex + 1) % slides.length;
      updateCarousel();
      resetAutoSlide();
    });

    prevBtn.addEventListener("click", () => {
      currentIndex = (currentIndex - 1 + slides.length) % slides.length;
      updateCarousel();
      resetAutoSlide();
    });

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
      track.style.transform = `translateX(calc(-${currentIndex * slides[0].clientWidth}px + ${diffX}px))`;
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
