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

            <input type="hidden" name="full_name" id="fullName">
            <input type="hidden" name="id" id="topicId" value="{{ $id }}">

            <p class="info" style="display: none;"></p>

            <label for="question">โปรดระบุคำถาม</label>
            <textarea id="question" name="question" rows="5" placeholder="พิมพ์คำถามของคุณที่นี่..."></textarea>

            <button type="submit" class="submit-btn">ส่งคำถาม</button>
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
            localStorage.setItem('employeeId', input.value); // ✅ เก็บไว้
            localStorage.setItem('fullName', data.full_name); // เก็บชื่อไว้ด้วยถ้าต้องใช้
          } else {
            infoBox.innerHTML = 'ไม่พบรหัสพนักงาน';
            infoBox.style.display = 'block';
            fullNameInput.value = '';
          }
        });
    }, 500);
  });
</script>

<script>
document.getElementById('qaForm').addEventListener('submit', async function (e) {
  e.preventDefault();

  const submitBtn = document.querySelector('.submit-btn');
  submitBtn.disabled = true;
  submitBtn.innerText = "กำลังส่ง..."; // 🔄 loading text

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

</script>

<script>
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
  });
</script>

</html>
