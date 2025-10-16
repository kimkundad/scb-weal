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

                    <br>
                    <form id="quizForm" method="POST" action="{{ url('/quiz/submit') }}">
                        @csrf

                        <div class="quiz-wrapper">
                            @foreach ($questions as $index => $q)
                                <div class="quiz-block" id="question-{{ $index }}"
                                    style="display: {{ $index == 0 ? 'block' : 'none' }}; {{ $index == 7 ? 'display:none;' : '' }}">

                                    {{-- โปรเกรส: ปกติแสดง 1/7 ... 7/7; ข้อ 8 จะอัปเดตเป็น 8/8 ทาง JS ตอนปลดล็อก --}}
                                    <div class="quiz-progress">
                                        <span class="cur">{{ min($index + 1, 7) }}</span>/<span class="total">7</span>
                                    </div>
                                    <br><br>
                                    <div class="quiz-question">{!! $q['question'] !!}</div>

                                    <div class="quiz-options">
                                        @foreach ($q['choices'] as $cIdx => $choice)
                                            <label class="quiz-option">
                                                {{-- เก็บ index ของ choice ด้วย จะช่วยนับคะแนน --}}
                                                <input type="radio" name="answers[{{ $index }}]"
                                                    value="{{ $cIdx + 1 }}"
                                                    data-choice-index="{{ $cIdx }}">
                                                <span style="margin-top:5px; text-align: left;">{!! $choice !!}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <a href="javascript:void(0)" class="start-btn next-btn" data-index="{{ $index }}">
                                        <img src="{{ url('img/owndays/nextBtn.png') }}" alt="พร้อมแล้ว ไปต่อกันเลย"
                                            class="btn-image">
                                    </a>

                                </div>
                            @endforeach
                        </div>
                    </form>




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
document.addEventListener('DOMContentLoaded', function () {
  const blocks = [...document.querySelectorAll('.quiz-block')];
  const q8 = document.querySelector('#question-7');
  const chosenIdx = {}; // เก็บ choice-index ที่เลือกในแต่ละข้อ: {0:2, 1:5, ...}

  // ✅ ฟังก์ชันนับคะแนนจากคำตอบ 7 ข้อแรก (เฉพาะข้อ 0–6)
  function buildCountsFromFirst7() {
    const counts = [0, 0, 0, 0, 0, 0];
    for (let q = 0; q <= 6; q++) {
      const c = chosenIdx[q];
      if (typeof c === 'number' && c >= 0 && c < 6) counts[c]++;
    }
    return counts;
  }

  // ✅ ฟังก์ชันหาว่ามี "กลุ่มที่เสมอกันบนสุด" อะไรบ้าง
  function getTopTiedIndices(counts) {
    const max = Math.max(...counts);
    const topIndices = counts
      .map((v, i) => (v === max ? i : -1))
      .filter(i => i !== -1);
    return topIndices.length > 1 ? topIndices : []; // เสมอเฉพาะถ้ามากกว่า 1 กลุ่ม
  }

  // ✅ ฟังก์ชันแปลง index → label ของกลุ่ม
  function mapIndicesToLabels(indices, labels) {
    return indices.map(i => labels[i]);
  }

  // อัปเดตปุ่มข้อ 7 ให้เป็น “ยืนยันคำตอบ”
  const lastOfFirst7 = document.querySelector('#question-6 .next-btn img');
  if (lastOfFirst7) {
    lastOfFirst7.src = "{{ url('img/owndays/xxRectangle@3x.png') }}";
    lastOfFirst7.alt = "ยืนยันคำตอบ";
  }

  // ✅ ตั้งค่า enable/disable ปุ่มแต่ละข้อ
  blocks.forEach((block, index) => {
    const nextBtn = block.querySelector('.next-btn');
    const radios = block.querySelectorAll('input[type="radio"]');
    let selected = false;

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

      // เก็บคำตอบที่เลือก
      const picked = block.querySelector('input[type="radio"]:checked');
      if (picked) {
        const cIdx = Number(picked.dataset.choiceIndex);
        chosenIdx[index] = cIdx;
      }

      // ถ้าเป็นข้อ 1–6 → ไปข้อต่อไป
      if (index < 6) {
        block.style.display = 'none';
        blocks[index + 1].style.display = 'block';
        return;
      }

      // ✅ เมื่อถึงข้อ 7 → ตรวจเสมอ
      if (index === 6) {
        const counts = buildCountsFromFirst7();
        const tiedIndices = getTopTiedIndices(counts);

        // ถ้ามีเสมอ → แสดงข้อ 8
        if (tiedIndices.length > 0) {

          // --- สร้างตัวเลือกใหม่จาก "ตัวเลือกที่เสมอกัน"
            const labels = [
            { key: 'A', text: 'ตัวตนที่พร้อมเติบโตอย่างสว่างไสว' },
            { key: 'B', text: 'ตัวตนที่พร้อมสร้างเส้นทางใหม่' },
            { key: 'C', text: 'ตัวตนที่พร้อมเป็นพลังปกป้อง' },
            { key: 'D', text: 'ตัวตนที่พร้อมฉายแสงไม่เหมือนใคร' },
            { key: 'E', text: 'ตัวตนที่พร้อมให้พึ่งพาความรู้ความเข้าใจ' },
            { key: 'F', text: 'ตัวตนที่พร้อมเชื่อมโยงผู้คนไว้ด้วยกัน' },
            ];

            const tiedLabels = tiedIndices.map(i => labels[i]);
            const optionsContainer = q8.querySelector('.quiz-options');
            optionsContainer.innerHTML = '';

            tiedLabels.forEach(opt => {
            const label = document.createElement('label');
            label.classList.add('quiz-option');
            label.innerHTML = `
                <input type="radio" name="answers[7]" value="${opt.key}">
                <span>${opt.text}</span>`;
            optionsContainer.appendChild(label);
            });

          // ปรับ progress เป็น 8/8 และเปลี่ยนปุ่มเป็นยืนยัน
          const cur = q8.querySelector('.quiz-progress .cur');
          const total = q8.querySelector('.quiz-progress .total');
          if (cur) cur.textContent = '8';
          if (total) total.textContent = '8';
          const q8BtnImg = q8.querySelector('.next-btn img');
          if (q8BtnImg) {
            q8BtnImg.src = "{{ url('img/owndays/xxRectangle@3x.png') }}";
            q8BtnImg.alt = "ยืนยันคำตอบ";
          }

          block.style.display = 'none';
          q8.style.display = 'block';

          // ปุ่ม submit เฉพาะเมื่อเลือก
          const q8Btn = q8.querySelector('.next-btn');
          const q8Radios = q8.querySelectorAll('input[type="radio"]');
          q8Btn.style.pointerEvents = 'none';
          q8Btn.style.opacity = '0.5';
          q8Radios.forEach(r => {
            r.addEventListener('change', () => {
              q8Btn.style.pointerEvents = 'auto';
              q8Btn.style.opacity = '1';
            });
          });
          q8Btn.onclick = () => document.getElementById('quizForm').submit();
        } else {
          // ไม่มีเสมอ → ส่งฟอร์มทันที
          document.getElementById('quizForm').submit();
        }
      }

      // เผื่อกรณีข้อ 8
      if (index === 7) {
        document.getElementById('quizForm').submit();
      }
    });
  });
});
</script>


</html>
