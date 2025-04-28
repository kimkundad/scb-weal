<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Q&A Responsive</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/font.css') }}?v{{time()}}" type="text/css" />
  <style>

  </style>
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
            <label for="employeeId">รหัสพนักงาน</label>
            <input type="text" id="employeeId" name="employeeId" placeholder="กรอกรหัสพนักงาน">

            <a class="submit-btn-user" >ยืนยัน</a>

            <input type="hidden" name="full_name" id="fullName">
            <input type="hidden" name="id" id="topicId" value="{{ $id }}">

            <p class="info" style="display: none;"></p>
            <div class="confirmed-status" style="display: none; margin-top: 10px;">
                <img src="{{ url('img/Path@2x.png') }}" style="width: 40px; height: 40px" />
            </div>

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
</body>


<script>
    const input = document.getElementById('employeeId');
    const infoBox = document.querySelector('.info');
    const fullNameInput = document.getElementById('fullName');

    let timer;
    input.addEventListener('input', function () {
      clearTimeout(timer);
      const value = input.value.trim();

      if (value === '') {
        infoBox.style.display = 'none';
        fullNameInput.value = '';
        document.querySelector('.submit-btn-user').style.display = 'none';
        document.querySelector('.confirmed-status').style.display = 'none';
        return;
      }

      timer = setTimeout(() => {
        fetch(`/auto_search?employee_code=${value}`)
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              infoBox.innerHTML = `คุณส่งคำถามในชื่อ <strong>${data.full_name}</strong>`;
              infoBox.style.display = 'block';
              fullNameInput.value = data.full_name;

              localStorage.setItem('employeeId', input.value);
              localStorage.setItem('fullName', data.full_name);

              document.querySelector('.submit-btn-user').style.display = 'inline-block';
            } else {
              infoBox.innerHTML = 'ไม่พบรหัสพนักงาน';
              infoBox.style.display = 'block';
              fullNameInput.value = '';
              document.querySelector('.submit-btn-user').style.display = 'none';
              document.querySelector('.confirmed-status').style.display = 'none';
            }

            toggleSubmitButton();
          });
      }, 300);
    });

    document.querySelector('.submit-btn-user').addEventListener('click', () => {
      const icon = document.querySelector('.confirmed-status');
      icon.style.display = 'inline-block';

      document.dispatchEvent(new Event('fullNameSet'));
      toggleSubmitButton();
    });

    document.getElementById('qaForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const submitBtn = document.querySelector('.submit-btn');
      submitBtn.disabled = true;
      submitBtn.innerText = "กำลังส่ง...";

      const employeeId = document.getElementById('employeeId').value.trim();
      const fullName = document.getElementById('fullName').value.trim();
      const question = document.getElementById('question').value.trim();
      const topicId = document.getElementById('topicId').value;

      if (!employeeId || !fullName || !question) {
        alert("กรุณากรอกข้อมูลให้ครบ");
        submitBtn.disabled = false;
        submitBtn.innerText = "ส่งคำถาม";
        return;
      }

      const formData = new FormData();
      formData.append('employeeId', employeeId);
      formData.append('full_name', fullName);
      formData.append('question', question);
      formData.append('id', topicId);
      formData.append('_token', '{{ csrf_token() }}');

      try {
        const res = await fetch(`{{ url('/post_ans') }}`, {
          method: 'POST',
          body: formData
        });

        const result = await res.json();

        if (result.success) {
          window.location.href = "{{ url('/ans_success') }}";
        } else {
          alert(result.message || 'เกิดข้อผิดพลาด');
          submitBtn.disabled = false;
          submitBtn.innerText = "ส่งคำถาม";
        }
      } catch (err) {
        alert('เกิดข้อผิดพลาดในการเชื่อมต่อ');
        console.error(err);
        submitBtn.disabled = false;
        submitBtn.innerText = "ส่งคำถาม";
      }
    });

    function toggleSubmitButton() {
      const employeeInput = document.getElementById('employeeId');
      const fullNameInput = document.getElementById('fullName');
      const questionInput = document.getElementById('question');

      const btnActive = document.querySelector('.submit-btn');
      const btnDisabled = document.querySelector('.submit-btn-dis');
      const checkIcon = document.querySelector('.confirmed-status');

      const emp = employeeInput.value.trim();
      const fullName = fullNameInput.value.trim();
      const question = questionInput.value.trim();
      const isConfirmed = checkIcon.style.display === 'inline-block';

      const isReady = emp !== '' && fullName !== '' && question !== '' && isConfirmed;

      btnActive.style.display = isReady ? 'inline-block' : 'none';
      btnDisabled.style.display = isReady ? 'none' : 'inline-block';
    }

    window.addEventListener('DOMContentLoaded', () => {
      const employeeInput = document.getElementById('employeeId');
      const fullNameInput = document.getElementById('fullName');
      const infoBox = document.querySelector('.info');

      const savedId = localStorage.getItem('employeeId');
      const savedName = localStorage.getItem('fullName');

      if (savedId) {
        employeeInput.value = savedId;
      }

      if (savedName) {
        fullNameInput.value = savedName;
        infoBox.innerHTML = `คุณส่งคำถามในชื่อ <strong>${savedName}</strong>`;
        infoBox.style.display = 'block';
      }

      toggleSubmitButton();

      employeeInput.addEventListener('input', toggleSubmitButton);
      document.getElementById('question').addEventListener('input', toggleSubmitButton);
      document.addEventListener('fullNameSet', toggleSubmitButton);
    });
  </script>

</html>
