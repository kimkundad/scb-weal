<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Q&A Responsive</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/font.css') }}?v={{ time() }}" type="text/css" />
</head>
<body>
  <div class="wrapper">
    <header>
      <a href="{{ url('/') }}">
        <img src="{{ url('img/TTB_Logo.svg.png') }}" alt="ttb logo" />
      </a>
    </header>

    <main>
      <div class="question-section">
        <h2>Q&A</h2>

        <form class="qa-form" id="qaForm">
          @csrf
          <input type="hidden" name="id" id="topicId" value="{{ $id }}">

          <label for="question">โปรดระบุคำถาม</label>
          <textarea id="question" name="question" rows="5" placeholder="พิมพ์คำถามของคุณที่นี่..."></textarea>

          <button type="submit" class="submit-btn" style="display: none;">ส่งคำถาม</button>
          <button type="button" class="submit-btn-dis" disabled>ส่งคำถาม</button>
        </form>
      </div>
    </main>

    <footer>
      <div class="copyright">
        Ⓒ สงวนลิขสิทธิ์ 2568 ธนาคารทหารไทยธนชาต จำกัด (มหาชน)<br/>
        นโยบายคุ้มครองข้อมูลส่วนบุคคล
      </div>
    </footer>
  </div>

  <script>
    const questionInput = document.getElementById('question');
    const btnActive = document.querySelector('.submit-btn');
    const btnDisabled = document.querySelector('.submit-btn-dis');

    function toggleSubmitButton() {
      const question = questionInput.value.trim();
      const isReady = question !== '';

      btnActive.style.display = isReady ? 'inline-block' : 'none';
      btnDisabled.style.display = isReady ? 'none' : 'inline-block';
    }

    questionInput.addEventListener('input', toggleSubmitButton);

    document.getElementById('qaForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      btnActive.disabled = true;
      btnActive.innerText = "กำลังส่ง...";

      const question = questionInput.value.trim();
      const topicId = document.getElementById('topicId').value;

      if (!question) {
        alert("กรุณากรอกคำถาม");
        btnActive.disabled = false;
        btnActive.innerText = "ส่งคำถาม";
        return;
      }

      const formData = new FormData();
      formData.append('question', question);
      formData.append('id', topicId);
      formData.append('_token', '{{ csrf_token() }}');

      try {
        const res = await fetch(`{{ url('/post_ans_ttb3') }}`, {
          method: 'POST',
          body: formData
        });

        const result = await res.json();

        if (result.success) {
          window.location.href = "{{ url('/ans_success') }}";
        } else {
          alert(result.message || 'เกิดข้อผิดพลาด');
          btnActive.disabled = false;
          btnActive.innerText = "ส่งคำถาม";
        }
      } catch (err) {
        alert('เกิดข้อผิดพลาดในการเชื่อมต่อ');
        console.error(err);
        btnActive.disabled = false;
        btnActive.innerText = "ส่งคำถาม";
      }
    });

    window.addEventListener('DOMContentLoaded', toggleSubmitButton);
  </script>
</body>
</html>
