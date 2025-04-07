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
            <div class="question-list">
            <button class="question-item" data-id="1">กระบวนการและวิธีการทำงาน</button>
            <button class="question-item" data-id="2">กลยุทธ์และแผนธุรกิจ</button>
            <button class="question-item" data-id="3">ความก้าวหน้าทางสายงาน<br>และการพัฒนาบุคลากร</button>
            <button class="question-item" data-id="4">เครื่องมือและระบบงาน<br>ด้าน IT & Digital</button>
            <button class="question-item" data-id="5">ช่องทางการให้บริการ<br>เช่น ttb touch สาขา Call Center</button>
            <button class="question-item" data-id="6">ผลิตภัณฑ์และบริการ</button>
            <button class="question-item" data-id="7">วัฒนธรรมองค์กรและความเป็นอยู่ที่ดี</button>
            <button class="question-item" data-id="8">อื่นๆ</button>
            </div>
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
  const items = document.querySelectorAll('.question-item');
  items.forEach(btn => {
    btn.addEventListener('click', () => {
      // เปลี่ยน class active
      items.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      // Redirect ไปยัง URL พร้อม ID
      const id = btn.getAttribute('data-id');
      window.location.href = `{{ url('ans?id=') }}${id}`;
    });
  });
</script>
</html>
