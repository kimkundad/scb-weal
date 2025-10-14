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
        <main class="page-content">

            <div class="intro-bg">
                <div class="intro-inner" style="padding: 5px 15px; ">



                    <img src="{{ url('img/owndays/ประสบการณ์ความพึงพอใจที่@2x.png') }}" alt="intro"
                        class="mt-100 img-w">


                        <section class="rating-section">

       {{-- <p>Row index ที่ถูกบันทึกไว้: {{ session()->get('quiz_row') }}</p> --}}


                        <div class="stars" id="ratingStars">
                            <!-- สร้างดาว 11 ดวง (0–10) -->
                            <span data-value="1">★</span>
                            <span data-value="2">★</span>
                            <span data-value="3">★</span>
                            <span data-value="4">★</span>
                            <span data-value="5">★</span>
                            <span data-value="6">★</span>
                            <span data-value="7">★</span>
                            <span data-value="8">★</span>
                            <span data-value="9">★</span>
                            <span data-value="10">★</span>
                        </div>


                        </section>



                    <a class="start-btn" id="submitRating">
                        <img src="{{ url('img/owndays/pointBtn.png') }}" alt="พร้อมแล้ว ไปต่อกันเลย" class="btn-image">
                    </a>

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
document.addEventListener('DOMContentLoaded', function() {
  const stars = document.querySelectorAll('#ratingStars span');
  const submitBtn = document.getElementById('submitRating');
  let selectedRating = 0;

  stars.forEach(star => {
    // เมื่อ hover ดาว
    star.addEventListener('mouseenter', () => {
      const value = parseInt(star.dataset.value);
      highlightStars(value);
    });

    // เมื่อออกจาก hover
    star.addEventListener('mouseleave', () => {
      highlightStars(selectedRating);
    });

    // เมื่อคลิกเลือกดาว
    star.addEventListener('click', () => {
      selectedRating = parseInt(star.dataset.value);
      highlightStars(selectedRating);
    });
  });

  function highlightStars(count) {
    stars.forEach((s, index) => {
      s.classList.toggle('active', index < count);
    });
  }

  submitBtn.addEventListener('click', () => {
    if (selectedRating === 0) {
      alert('กรุณาให้คะแนนก่อนส่ง');
      return;
    }

    // ✅ ส่งข้อมูลไปยัง backend หรือ Google Sheet
    fetch('{{ url("/submitRating") }}', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': '{{ csrf_token() }}'
  },
  body: JSON.stringify({ rating: selectedRating })
})
.then(res => res.json())
.then(data => {
  if (data.success) {
    window.location.href = data.redirect; // ✅ ไปหน้า final
  }
})
    .catch(() => alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง'));
  });



});
</script>

</html>
