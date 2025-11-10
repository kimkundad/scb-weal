<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ส่งใบเสร็จเข้าร่วมกิจกรรม - HONOR</title>
    <link rel="stylesheet" href="{{ url('/home/assets/css/honor.css') }}?v={{ time() }}" />
</head>

<body>

    <div class="page-wrapper2">

        <!-- Header -->
        <header class="page-header">
            <a href="{{ url('/') }}">
                <img src="{{ url('img/honor/logo@2x.png') }}" alt="HONOR logo" style="margin-left:20px">
            </a>
        </header>

        <!-- Main Content -->
        <main class="page-content">
            <div class="regis-container">
                <h1 class="regis-title">ส่งข้อมูลการซื้อ<br>และอัปโหลดใบเสร็จ</h1>
                <p class="regis-subtitle">
                    กรอกข้อมูลการซื้อสินค้าของคุณให้ครบถ้วน และอัปโหลดใบเสร็จเพื่อรับสิทธิ์ลุ้นรางวัล
                </p>

                <form method="POST" action="{{ url('/regis_user_upslip') }}" onsubmit="return validateIMEI();" class="regis-form"
                    enctype="multipart/form-data">
                    @csrf

                    <label>วันที่ซื้อสินค้า</label>
                    <input type="date" name="purchase_date" class="regis-input" required>

                    <label>เวลาที่ซื้อ (โดยประมาณ)</label>
                    <input type="time" name="purchase_time" class="regis-input" required>

                    <label>หมายเลขใบเสร็จ</label>
                    <input type="text" name="receipt_number" class="regis-input" required>

                    <label>หมายเลข IMEI เครื่อง</label>
                    <input type="text" name="imei" id="imei" maxlength="15" class="regis-input"
                        placeholder="กรอกหมายเลข IMEI 15 หลัก" required>
                    <p id="imei-error" class="input-error" style="display:none;">กรุณากรอก IMEI ให้ถูกต้อง (15
                        หลักตัวเลขเท่านั้น)</p>

                    <label>ร้านค้าที่ซื้อ</label>
                    <input type="text" name="store_name" class="regis-input" required>

                    <label>อัปโหลดใบเสร็จ (ภาพ JPG/PNG/PDF)</label>
                    <input type="file" name="receipt_file" id="receipt_file" class="regis-input"
                        accept=".jpg,.jpeg,.png,.pdf" required>
                    <!-- 🔽 ตรงนี้คือจุดแสดง preview -->
                    <div id="preview-container" class="mt-10">
                        <img id="preview-image" style="max-width: 100%; display: none; border-radius: 8px;"
                            alt="Preview Receipt">
                        <p id="preview-filename" class="info-text" style="display:none;"></p>
                    </div>

                    <p class="info-text">ขนาดไฟล์ไม่เกิน 5MB / 1 ใบเสร็จต่อ 1 สิทธิ์</p>

                    <div class="text-center">
                        <button type="submit" class="btn-confirm mt-20">ส่งข้อมูลเข้าร่วมกิจกรรม</button>
                    </div>

                    <p class="info-text">
                        เมื่อส่งข้อมูลสำเร็จ ระบบจะแสดงข้อความยืนยัน และนับสิทธิ์ของคุณอัตโนมัติ
                    </p>
                </form>
            </div>
        </main>

        <!-- Footer -->
        <footer class="page-footer2">
            <div class="copyright2">
                © 2025 HONOR Thailand All rights reserved. <br>
                เงื่อนไขกิจกรรม | นโยบายความเป็นส่วนตัว
            </div>
        </footer>

    </div>

    <script>
        function validateIMEI() {
            const imei = document.getElementById('imei');
            const error = document.getElementById('imei-error');
            const val = imei.value.trim();

            if (!/^\d{15}$/.test(val)) {
                imei.classList.add('error');
                error.style.display = 'block';
                return false;
            }

            imei.classList.remove('error');
            error.style.display = 'none';
            return true;
        }
    </script>

    <script>
  document.getElementById('receipt_file').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const image = document.getElementById('preview-image');
    const filename = document.getElementById('preview-filename');

    if (!file) return;

    const fileType = file.type;
    const validImageTypes = ['image/jpeg', 'image/png'];

    if (validImageTypes.includes(fileType)) {
      const reader = new FileReader();
      reader.onload = function (e) {
        image.src = e.target.result;
        image.style.display = 'block';
        filename.style.display = 'none';
      };
      reader.readAsDataURL(file);
    } else if (fileType === 'application/pdf') {
      image.style.display = 'none';
      filename.textContent = `📄 ไฟล์ PDF: ${file.name}`;
      filename.style.display = 'block';
    } else {
      image.style.display = 'none';
      filename.textContent = 'ไฟล์ไม่รองรับ กรุณาเลือก JPG, PNG หรือ PDF';
      filename.style.display = 'block';
    }
  });
</script>

</body>

</html>
