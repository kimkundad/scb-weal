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
  <div class="wrapper">
    <header>
      <a href="{{ url('/') }}">
        <img src="{{ url('img/owndays/logo.png') }}" alt="owndays logo" />
      </a>
    </header>

        <main>

            <div class="question-section">
                <div class="intro-bg">
                    <div class="intro-inner" style="padding: 5px 15px; ">
                    <div class="intro-container">

                      {{-- <!-- ลำดับข้อ -->
                    <div class="quiz-progress">1/8</div>

                    <!-- คำถาม -->
                    <div class="quiz-question" style="margin-top:55px">
                        ในสายตาของเพื่อนๆ จุดแข็งและความโดดเด่นของคุณคือ..
                    </div> --}}

                    <form id="quizForm" method="POST" action="{{ url('/quiz/submit') }}">
  @csrf

  <div class="quiz-wrapper">
    @foreach ($questions as $index => $q)
      <div class="quiz-block" id="question-{{ $index }}" style="display: {{ $index == 0 ? 'block' : 'none' }};">

        <div class="quiz-progress">{{ $index + 1 }}/{{ count($questions) }}</div>
        <div class="quiz-question">{{ $q['question'] }}</div>

        <div class="quiz-options">
          @foreach ($q['choices'] as $choice)
            <label class="quiz-option">
              <input type="radio" name="answers[{{ $index }}]" value="{{ $choice }}">
              <span>{{ $choice }}</span>
            </label>
          @endforeach
        </div>

        {{-- ปุ่มต่อไป --}}
        <div class="quiz-button " style="text-align: -webkit-center;">
          <a href="javascript:void(0)" style="margin-top: 80px; display: block; width:80%"
             class=" pt-45-res w-btn-90 next-btn"
             data-index="{{ $index }}">
            <img src="{{ url('img/owndays/nextBtn.png') }}"
                 alt="ต่อไป"
                 class="btn-image">
          </a>
        </div>


        {{-- <a href="{{ url('/finalQuiz') }}" class="btn-image-link pt-45-res w-btn-90" style="bottom: auto;">
                        <img src="{{ url('img/owndays/nextBtn.png') }}"
                            alt="พร้อมแล้ว ไปต่อกันเลย"
                            class="btn-image">
                        </a> --}}

      </div>
    @endforeach
  </div>
</form>



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
document.addEventListener('DOMContentLoaded', function() {
  const questions = document.querySelectorAll('.quiz-block');
  const total = questions.length;

  questions.forEach((block, index) => {
    const nextBtn = block.querySelector('.next-btn');
    const radios = block.querySelectorAll('input[type="radio"]');
    let selected = false;

    // เริ่มต้นปิดปุ่มไว้ก่อน
    nextBtn.style.pointerEvents = 'none';
    nextBtn.style.opacity = '0.5';

    // เมื่อเลือก radio
    radios.forEach(radio => {
      radio.addEventListener('change', () => {
        selected = true;
        nextBtn.style.pointerEvents = 'auto';
        nextBtn.style.opacity = '1';
      });
    });

    if(index === 5){
        nextBtn.innerHTML = `
          <img src="{{ url('img/owndays/checkBtn@3x.png') }}"
               alt="ยืนยันคำตอบ"
               class="btn-image">`;
      }

    // เมื่อคลิก "ต่อไป"
    nextBtn.addEventListener('click', () => {
      if (!selected) return; // ยังไม่ได้เลือก หยุดไว้ก่อน
      console.log('index', index, 'total', total)


      // ถ้ายังไม่ใช่คำถามสุดท้าย
      if (index < total - 1) {
        block.style.display = 'none';
        questions[index + 1].style.display = 'block';
      }
      else {
        // ✅ ถ้าคำถามสุดท้าย — เปลี่ยนปุ่มเป็น checkBtn
        nextBtn.innerHTML = `
          <img src="{{ url('img/owndays/checkBtn@3x.png') }}"
               alt="ยืนยันคำตอบ"
               class="btn-image">`;

        // ✅ เมื่อกดครั้งสุดท้าย ให้ submit form
        nextBtn.addEventListener('click', () => {
          document.getElementById('quizForm').submit();
        });
      }
    });
  });
});
</script>



</html>
