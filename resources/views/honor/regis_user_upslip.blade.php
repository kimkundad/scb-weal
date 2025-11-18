<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ส่งใบเสร็จเข้าร่วมกิจกรรม - HONOR</title>
    <link rel="stylesheet" href="{{ url('/home/assets/css/honor.css') }}?v={{ time() }}" />
</head>

<style>
.imei-group {
    display: flex;
    gap: 10px;
    align-items: center;
}

.btn-check-imei {
    background: #007bff;
    padding: 10px 16px;
    border: none;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    white-space: nowrap;
}

.imei-status {
    font-size: 22px;
    margin-left: 10px;
    font-weight: bold;
}

.imei-status.success {
    color: #28a745;
}

.imei-status.error {
    color: #dc3545;
}

.imei-input {
    border: 1px solid #cbd5e1;   /* ปกติ */
}

.imei-input.error {
    border: 1px solid #dc3545;   /* แดงเมื่อผิด */
}

.imei-input.success {
    border: 1px solid #28a745;   /* เขียวเมื่อถูก */
}

.btn-logout {
    display: inline-block;
    background: #dc3545;     /* สีแดง */
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    margin-top: 15px;
}

.btn-logout:hover {
    background: #bb2d3b;
}
</style>
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

                    {{-- <label>หมายเลข IMEI เครื่อง</label>
                    <input type="text" name="imei" id="imei" maxlength="15" class="regis-input"
                        placeholder="กรอกหมายเลข IMEI 15 หลัก" required>
                    <p id="imei-error" class="input-error" style="display:none;">กรุณากรอก IMEI ให้ถูกต้อง (15
                        หลักตัวเลขเท่านั้น)</p> --}}


                        <label>หมายเลข IMEI เครื่อง</label>
                        <div class="imei-group">
                            <input
                                type="text"
                                name="imei"
                                id="imei"
                                maxlength="15"
                                class="regis-input imei-input"
                                placeholder="กรอกหมายเลข IMEI 15 หลัก"
                                required
                            >

                            <button type="button" id="check-imei-btn" class="btn-check-imei">
                                ตรวจสอบ
                            </button>

                            <span id="imei-status" class="imei-status"></span>
                        </div>

                        <p id="imei-error" class="input-error" style="display:none;">กรุณากรอก IMEI ให้ถูกต้อง</p>

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
    <br>  <br>
                        <!-- 🔴 ปุ่มออกจากระบบ -->
                        <a href="{{ url('/logout-honor') }}" class="btn-logout mt-10">ออกจากระบบ</a>
                    </div>

                    <p class="info-text">
                        เมื่อส่งข้อมูลสำเร็จ ระบบจะแสดงข้อความยืนยัน และนับสิทธิ์ของคุณอัตโนมัติ
                    </p>
                        <br>  <br>
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


<script>
document.getElementById("check-imei-btn").addEventListener("click", function () {

    let imei = document.getElementById("imei").value.trim();
    let status = document.getElementById("imei-status");
    let error = document.getElementById("imei-error");
    let imeiInput = document.getElementById("imei");

    // Reset
    status.innerHTML = "";
    status.className = "imei-status";

    if (!/^\d{15}$/.test(imei)) {
        error.style.display = "block";
        status.classList.add("error");
        status.innerHTML = "✕";
        return;
    }

    error.style.display = "none";

    // ส่ง AJAX ไปตรวจสอบ
    fetch("{{ url('/check-imei') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ imei: imei })
    })
    .then(res => res.json())
    .then(data => {

    // เคลียร์ class ก่อน
    imeiInput.classList.remove("error", "success");

    if (data.valid) {

        // เปลี่ยนสี input เป็นเขียว
        imeiInput.classList.add("success");

        status.classList.add("success");
        status.innerHTML = "✓";
        window.imei_valid = true;

    } else {

        // เปลี่ยน input เป็นสีแดง
        imeiInput.classList.add("error");

        status.classList.add("error");
        status.innerHTML = "✕";
        window.imei_valid = false;

        if (data.used) {
            alert("หมายเลข IMEI นี้ถูกใช้สิทธิ์แล้ว");
        } else {
            alert(data.message);
        }
    }
});
});


// ป้องกันการกด submit โดยยังไม่ได้ตรวจสอบ IMEI
function validateIMEI() {
    if (!window.imei_valid) {
        alert("กรุณากดปุ่ม 'ตรวจสอบ' IMEI ก่อนส่งข้อมูล");
        return false;
    }
    return true;
}
</script>



</body>

</html>
