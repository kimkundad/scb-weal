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
                 <form class="qa-form" action="{{ url('/tp_step2') }}" method="POST" id="qaForm">
                @csrf
                    <div class="text-left">
                        <p class="head-text">ข้อมูลธุรกิจ / หน่วยงาน</p>
                    </div>

                    <div class="form-group">
                        <label>ชื่อบริษัท / ธุรกิจ</label>
                        <input type="text" name="company" placeholder="ชื่อองค์กรที่เป็นเจ้าของหรือทำงานอยู่" value="{{ session('form.company') }}" required>
                    </div>

                    <div class="form-group">
                        <label>ประเภทธุรกิจ</label>
                        <select name="type" required>
                            <option value="">เลือกประเภทธุรกิจ</option>
                            <option value="food" {{ session('form.type') == 'food' ? 'selected' : '' }}>อาหารและเครื่องดื่ม (Food & Beverage)</option>
                            <option value="agriculture" {{ session('form.type') == 'agriculture' ? 'selected' : '' }}>การเกษตร / ผลิตภัณฑ์เกษตร (Agriculture)</option>
                            <option value="automotive" {{ session('form.type') == 'automotive' ? 'selected' : '' }}>ยานยนต์ / อะไหล่ (Automotive)</option>
                            <option value="tech" {{ session('form.type') == 'tech' ? 'selected' : '' }}>เทคโนโลยี / ซอฟต์แวร์ (Technology & Software)</option>
                            <option value="education" {{ session('form.type') == 'education' ? 'selected' : '' }}>การศึกษา / ฝึกอบรม (Education & Training)</option>
                            <option value="finance" {{ session('form.type') == 'finance' ? 'selected' : '' }}>การเงิน / ธนาคาร / การลงทุน (Finance & Investment)</option>
                            <option value="ecommerce" {{ session('form.type') == 'ecommerce' ? 'selected' : '' }}>การค้าออนไลน์ / ค้าส่ง / E-Commerce</option>
                            <option value="hospitality" {{ session('form.type') == 'hospitality' ? 'selected' : '' }}>ท่องเที่ยว / โรงแรม / ร้านอาหาร</option>
                            <option value="beauty" {{ session('form.type') == 'beauty' ? 'selected' : '' }}>ความงาม / สุขภาพ / สปา</option>
                            <option value="medical" {{ session('form.type') == 'medical' ? 'selected' : '' }}>แพทย์ / เภสัชกรรม / คลินิก</option>
                            <option value="construction" {{ session('form.type') == 'construction' ? 'selected' : '' }}>การก่อสร้าง / อสังหาริมทรัพย์</option>
                            <option value="logistics" {{ session('form.type') == 'logistics' ? 'selected' : '' }}>โลจิสติกส์ / ขนส่ง / นำเข้า-ส่งออก</option>
                            <option value="fashion" {{ session('form.type') == 'fashion' ? 'selected' : '' }}>แฟชั่น / เครื่องแต่งกาย / เครื่องประดับ</option>
                            <option value="media" {{ session('form.type') == 'media' ? 'selected' : '' }}>สื่อ / การตลาด / โฆษณา</option>
                            <option value="design" {{ session('form.type') == 'design' ? 'selected' : '' }}>งานออกแบบ / สถาปัตยกรรม</option>
                            <option value="energy" {{ session('form.type') == 'energy' ? 'selected' : '' }}>พลังงาน / สิ่งแวดล้อม</option>
                            <option value="legal" {{ session('form.type') == 'legal' ? 'selected' : '' }}>กฎหมาย / บัญชี / ที่ปรึกษา</option>
                            <option value="government" {{ session('form.type') == 'government' ? 'selected' : '' }}>หน่วยงานราชการ / รัฐวิสาหกิจ</option>
                            <option value="sme" {{ session('form.type') == 'sme' ? 'selected' : '' }}>ธุรกิจครอบครัว / SME</option>
                        </select>

                        </div>

                    <div class="form-group">
                        <label>ตำแหน่ง</label>
                        <input name="position" type="text" placeholder="เช่น เจ้าของกิจการ" value="{{ session('form.position') }}" required>
                    </div>

                    {{-- <div class="form-group">
                        <label>ที่ตั้งบริษัท</label>
                        <input name="location" type="text" placeholder="เลือกจังหวัดที่ตั้งสำนักงาน" value="{{ session('form.location') }}" required>
                    </div> --}}

                    <div class="form-group">
                        <label>ที่อยู่ปัจจุบัน</label>
                        <select name="location" required>
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
                            $selectedProvince = session('form.location');
                            @endphp

                            @foreach($provinces as $province)
                            <option value="{{ $province }}" {{ $selectedProvince == $province ? 'selected' : '' }}>
                                {{ $province }}
                            </option>
                            @endforeach
                        </select>
                        </div>


                    <br><br><br>
                    <button type="submit">ถัดไป</button>
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
