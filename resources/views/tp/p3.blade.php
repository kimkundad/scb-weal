<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Q&A Responsive</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/tp.css') }}?v={{ time() }}" type="text/css" />
</head>
<body>
  <div class="wrapper">
    <header>
      <a href="{{ url('/') }}">
        <img src="{{ url('img/tp/logo_green_Taweethapisek@2x.png') }}" alt="tp logo" />
      </a>
    </header>

    <main>
      <div class="question-section">

        <h3 class="first-h3">ฐานข้อมูลสมาชิก</h3>
        <h2 class="first-h2">TP BUSINESS NETWORKING #4   </h2>

        <div class="form-wrapper">
            <div class="form-container">
                <form class="qa-form" action="{{ url('/tp_step3') }}" method="POST" id="qaForm">
                @csrf
                    <div class="text-left">
                        <p class="head-text">ความสนใจในการ Networking</p>
                    </div>

                    <div class="form-group">
                        <label>สนใจกิจกรรมใดบ้างเพื่อต่อยอดธุรกิจของท่าน</label>
                        <input type="text" name="activity" placeholder="เช่น Business Matching, งานสัมมนา" required>
                    </div>

                    <div class="form-group">
                        <label>ความช่วยเหลือที่ยินดีให้</label>
                        <input type="text" name="help" placeholder="เช่น เป็นวิทยากร, ให้คำปรึกษา, เปิดโอกาสฝึกงาน" required>
                    </div>

                    <div class="form-group">
                        <label>กลุ่มเป้าหมายที่อยากเชื่อมต่อ</label>
                        <input type="text" name="target" placeholder="เช่น ธุรกิจสายอาหาร, เทคโนโลยี, การเงิน" required>
                    </div>

                    <div class="form-group checkbox-group" style="margin-bottom: -5px;">
                        <label>
                        สนใจเข้าปรึกษาคลินิกธุรกิจเพื่อ SME
                        </label>
                    </div>

                    <div class="form-group checkbox-custom checkbox-success">
                        <input type="checkbox" id="join_sme_clinic" name="join_sme_clinic" value="1">
                        <label for="join_sme_clinic">
                            เข้าปรึกษา
                        </label>
                    </div>

                    <br><br><br>
                    <button type="submit" id="submitBtn">ยืนข้อมูลสมาชิก</button>
                    <br>
                    <a onclick="history.back()" class="back-btn-user">ย้อนกลับ</a>




                </form>
            </div>
        </div>
      </div>
    </main>

    <footer>
      <div class="copyright">
        Ⓒ สงวนลิขสิทธิ์ 2568
      </div>
    </footer>
  </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('qaForm');
  const submitBtn = document.getElementById('submitBtn');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const inputs = form.querySelectorAll('input[required], textarea[required]');
    const missing = [];

    inputs.forEach(input => {
      if (!input.value.trim()) {
        const label = input.closest('.form-group')?.querySelector('label')?.innerText || input.name;
        missing.push(label);
      }
    });

    if (missing.length > 0) {
      Swal.fire({
        icon: 'warning',
        title: 'กรอกข้อมูลไม่ครบ!',
        html: 'กรุณากรอกช่องต่อไปนี้:<ul style="text-align:left;">' +
              missing.map(field => `<li>• ${field}</li>`).join('') + '</ul>',
        confirmButtonText: 'ตกลง',
        confirmButtonColor: '#00c853'
      });
    } else {
      submitBtn.disabled = true;
      submitBtn.innerText = 'กำลังส่ง...';
      form.submit();
    }
  });
});
</script>




</body>
</html>
