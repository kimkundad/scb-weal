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
      <div class="quiz-block" id="question-{{ $index }}"
       style="display: {{ $index == 0 ? 'block' : 'none' }}; {{ $index == 7 ? 'display:none;' : '' }}">

        {{-- โปรเกรส: ปกติแสดง 1/7 ... 7/7; ข้อ 8 จะอัปเดตเป็น 8/8 ทาง JS ตอนปลดล็อก --}}
        <div class="quiz-progress">
            <span class="cur">{{ min($index+1, 7) }}</span>/<span class="total">7</span>
        </div>
        <div class="quiz-question">{{ $q['question'] }}</div>

        <div class="quiz-options">
          @foreach ($q['choices'] as $cIdx => $choice)
            <label class="quiz-option">
                {{-- เก็บ index ของ choice ด้วย จะช่วยนับคะแนน --}}
                <input type="radio"
                    name="answers[{{ $index }}]"
                    value="{{ $cIdx + 1 }}"
                    data-choice-index="{{ $cIdx }}">
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
document.addEventListener('DOMContentLoaded', function () {
  const blocks   = [...document.querySelectorAll('.quiz-block')];
  const totalAll = blocks.length;       // จริง ๆ = 8
  const q8       = document.querySelector('#question-7'); // บล็อกข้อ 8
  const chosenIdx = {}; // เก็บ choice-index ที่เลือกในแต่ละข้อ: {0:2, 1:5, ...}

  // ฟังก์ชันช่วย: เช็คว่ามี "เสมอกันที่อันดับ 1" ไหม
  function isTopTie(countMap) {
    // countMap เช่น [2,3,0,3,1,0]
    const max = Math.max(...countMap);
    const howManyMax = countMap.filter(v => v === max).length;
    return howManyMax >= 2; // เสมอถ้าจำนวนที่มีค่ามากสุดมากกว่า 1
  }

  // นับคะแนนจากคำตอบ 7 ข้อแรก (เฉพาะข้อ 0..6)
  function buildCountsFromFirst7() {
    // เรามีตัวเลือก 6 ตัว (A..F) → สร้าง array 6 ช่องไว้เก็บนับ
    const counts = [0,0,0,0,0,0];
    for (let q = 0; q <= 6; q++) {
      const c = chosenIdx[q];
      if (typeof c === 'number' && c >=0 && c < 6) counts[c]++;
    }
    return counts;
  }

  // อัปเดตปุ่มข้อ 7 (index 6) ให้แสดงภาพ check (เพราะจะไปสู่การตัดสิน)
  const lastOfFirst7 = document.querySelector('#question-6 .next-btn img');
  if (lastOfFirst7) {
    lastOfFirst7.src = "{{ url('img/owndays/checkBtn@3x.png') }}";
    lastOfFirst7.alt = "ยืนยันคำตอบ";
  }

  // ตั้งค่า enable/disable ปุ่มเมื่อยังไม่เลือก
  blocks.forEach((block, index) => {
    const nextBtn = block.querySelector('.next-btn');
    const radios  = block.querySelectorAll('input[type="radio"]');
    let selected  = false;

    // disable ปุ่มก่อนเลือก
    nextBtn.style.pointerEvents = 'none';
    nextBtn.style.opacity = '0.5';

    radios.forEach(radio => {
      radio.addEventListener('change', () => {
        selected = true;
        nextBtn.style.pointerEvents = 'auto';
        nextBtn.style.opacity = '1';
      });
    });

    nextBtn.addEventListener('click', () => {
      if (!selected) return;

      // บันทึก index ของ choice ที่เลือก (ไว้คำนวณคะแนน)
      const picked = block.querySelector('input[type="radio"]:checked');
      if (picked) {
        const cIdx = Number(picked.dataset.choiceIndex); // 0..5
        chosenIdx[index] = cIdx;
      }

      // --- กรณี index <= 5: ไปข้อถัดไปปกติ
      if (index < 6) {
        block.style.display = 'none';
        blocks[index + 1].style.display = 'block';
        return;
      }

      // --- เมื่ออยู่ที่ข้อ 7 (index === 6) → ตรวจเสมอ
      if (index === 6) {
        const counts = buildCountsFromFirst7();
        const tie = isTopTie(counts);

        if (tie) {
          // ปลดล็อกข้อ 8
          if (q8) {
            // อัปเดต progress ของข้อ 8 เป็น 8/8
            const cur = q8.querySelector('.quiz-progress .cur');
            const total = q8.querySelector('.quiz-progress .total');
            if (cur) cur.textContent = '8';
            if (total) total.textContent = '8';

            block.style.display = 'none';
            q8.style.display = 'block';

            // เปลี่ยนปุ่มของข้อ 8 เป็นปุ่ม check (และกดแล้ว submit)
            const q8BtnImg = q8.querySelector('.next-btn img');
            if (q8BtnImg) {
              q8BtnImg.src = "{{ url('img/owndays/checkBtn@3x.png') }}";
              q8BtnImg.alt = "ยืนยันคำตอบ";
            }

            const q8Btn = q8.querySelector('.next-btn');
            const q8Radios = q8.querySelectorAll('input[type="radio"]');
            // ตัวตรวจเลือกสำหรับข้อ 8
            q8Btn.style.pointerEvents = 'none';
            q8Btn.style.opacity = '0.5';
            q8Radios.forEach(r => {
              r.addEventListener('change', () => {
                q8Btn.style.pointerEvents = 'auto';
                q8Btn.style.opacity   = '1';
              });
            });
            q8Btn.onclick = () => document.getElementById('quizForm').submit();
          }
        } else {
          // ไม่มีเสมอ → ส่งเลย
          document.getElementById('quizForm').submit();
        }

        return;
      }

      // --- เผื่อกรณีมาถึงข้อ 8 แล้ว (index === 7) → ส่งเลย
      if (index === 7) {
        document.getElementById('quizForm').submit();
      }
    });
  });
});
</script>


</html>
