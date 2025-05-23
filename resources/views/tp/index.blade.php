<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>สมาคมศิษย์เก่าทวีธาภิเศก</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/tp.css') }}?v={{ time() }}" type="text/css" />
  <link rel="icon" type="image/png" sizes="32x32" href="{{ url('img/tp/favicon_v5.png') }}" />
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
                <form class="qa-form" action="{{ url('/tp_step1') }}" method="POST" id="qaForm">
                @csrf
                    <div class="text-left">
                        <p class="head-text">ข้อมูลส่วนตัว</p>
                    </div>

                    <div class="form-group">
                    <label>ชื่อ-นามสกุล</label>
                    <input type="text" name="fullname" placeholder="ชื่อจริงและนามสกุลของศิษย์เก่า" value="{{ session('form.fullname') }}" required>
                    </div>

                    <div class="form-row">
                    <div class="form-group">
                        <label>เบอร์ติดต่อ</label>
                        <input type="tel" name="phone" placeholder="08X XXX XXXX" value="{{ session('form.phone') }}" required>
                    </div>
                    <div class="form-group">
                        <label>LINE ID</label>
                        <input type="text" name="line" placeholder="XXXXXX" value="{{ session('form.line') }}" required>
                    </div>
                    </div>

                    <div class="form-row">
                    <div class="form-group">
                        <label>ชื่อเล่น</label>
                        <input type="text" name="nickname" value="{{ session('form.nickname') }}" placeholder="ชื่อหรือฉายา" required>
                    </div>
                    <div class="form-group">
                        <label>รุ่น</label>
                        <input type="text" name="generation" value="{{ session('form.generation') }}" placeholder="ระบุรุ่นหรือปีที่จบ" required>
                    </div>
                    </div>

                    <div class="form-group">
                        <label>ที่อยู่ปัจจุบัน</label>
                        <select name="address" required>
                            <option value="">-- เลือกจังหวัด --</option>
                            @php
                            $provinces = [
                                'กรุงเทพมหานคร', 'กระบี่', 'กาญจนบุรี', 'กาฬสินธุ์', 'กำแพงเพชร',
                                'ขอนแก่น', 'จันทบุรี', 'ฉะเชิงเทรา', 'ชลบุรี', 'ชัยนาท',
                                'ชัยภูมิ', 'ชุมพร', 'เชียงราย', 'เชียงใหม่', 'ตรัง',
                                'ตราด', 'ตาก', 'นครนายก', 'นครปฐม', 'นครพนม',
                                'นครราชสีมา', 'นครศรีธรรมราช', 'นครสวรรค์', 'นราธิวาส', 'น่าน',
                                'นนทบุรี', 'บึงกาฬ', 'บุรีรัมย์', 'ประจวบคีรีขันธ์', 'ปราจีนบุรี',
                                'ปัตตานี', 'พระนครศรีอยุธยา', 'พังงา', 'พัทลุง', 'พิจิตร',
                                'พิษณุโลก', 'เพชรบุรี', 'เพชรบูรณ์', 'แพร่', 'พะเยา',
                                'ภูเก็ต', 'มหาสารคาม', 'มุกดาหาร', 'แม่ฮ่องสอน', 'ยะลา',
                                'ยโสธร', 'ร้อยเอ็ด', 'ระนอง', 'ระยอง', 'ราชบุรี',
                                'ลพบุรี', 'ลำปาง', 'ลำพูน', 'เลย', 'ศรีสะเกษ',
                                'สกลนคร', 'สงขลา', 'สตูล', 'สมุทรปราการ', 'สมุทรสงคราม',
                                'สมุทรสาคร', 'สระแก้ว', 'สระบุรี', 'สิงห์บุรี', 'สุโขทัย',
                                'สุพรรณบุรี', 'สุราษฎร์ธานี', 'สุรินทร์', 'หนองคาย', 'หนองบัวลำภู',
                                'อ่างทอง', 'อำนาจเจริญ', 'อุดรธานี', 'อุตรดิตถ์', 'อุทัยธานี',
                                'อุบลราชธานี'
                            ];
                            $selectedProvince = session('form.address');
                            @endphp

                            @foreach($provinces as $province)
                            <option value="{{ $province }}" {{ $selectedProvince == $province ? 'selected' : '' }}>
                                {{ $province }}
                            </option>
                            @endforeach
                        </select>
                        </div>
                    <br><br><br>
                    <button type="submit" >ถัดไป</button>


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
document.getElementById('qaForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const inputs = this.querySelectorAll('input, select, textarea');
  const missingFields = [];

  inputs.forEach(input => {
    if (input.hasAttribute('required') && input.value.trim() === '') {
      const label = input.closest('.form-group')?.querySelector('label')?.innerText || input.name;
      missingFields.push(label);
    }
  });

  if (missingFields.length > 0) {
    Swal.fire({
      icon: 'warning',
      title: 'กรอกข้อมูลไม่ครบ!',
      html: 'กรุณากรอกช่องต่อไปนี้ให้ครบ:<br><ul style="text-align:left;">' +
        missingFields.map(f => `<li>• ${f}</li>`).join('') +
        '</ul>',
      confirmButtonText: 'ตกลง',
      confirmButtonColor: '#00c853'
    });
  } else {
    // ส่งฟอร์มเมื่อครบทุกช่อง
    this.submit();
  }
});
</script>




</body>
</html>
