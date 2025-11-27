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

.imei-note {
    font-size: 14px;
    color: #555;
    margin-top: 5px;
    line-height: 1.5;
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

                        <p class="imei-note">
                    <strong>**หมายเหตุ:</strong><br>
                    • สามารถตรวจสอบหมายเลข IMEI ได้โดยกด *#06# บนโทรศัพท์<br>
                    • ใช้หมายเลข IMEI 1 เพื่อลงทะเบียนลุ้นรางวัลได้ 1 สิทธิ์<br>
                    • ผู้ลงทะเบียน 1 คน สามารถลงทะเบียนได้มากกว่า 1 สิทธิ์
                </p>

                        <p id="imei-error" class="input-error" style="display:none;">กรุณากรอก IMEI ให้ถูกต้อง</p>

                    <label>ร้านค้าที่ซื้อ</label>
                    <input type="text" name="store_name" class="regis-input" required>




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

 <!-- JS ตรวจสอบ IMEI -->
<script>
document.getElementById("check-imei-btn").addEventListener("click", function () {

    let imei = document.getElementById("imei").value.trim();
    let status = document.getElementById("imei-status");
    let error = document.getElementById("imei-error");
    let imeiInput = document.getElementById("imei");

    status.innerHTML = "";
    status.className = "imei-status";

    if (!/^\d{15}$/.test(imei)) {
        error.style.display = "block";
        imeiInput.classList.add("error");
        status.innerHTML = "✕";
        status.classList.add("error");
        window.imei_valid = false;
        return;
    }

    error.style.display = "none";

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

        imeiInput.classList.remove("error", "success");

        if (data.valid) {
            imeiInput.classList.add("success");
            status.classList.add("success");
            status.innerHTML = "✓";
            window.imei_valid = true;

        } else {
            imeiInput.classList.add("error");
            status.classList.add("error");
            status.innerHTML = "✕";
            window.imei_valid = false;

            alert(data.used ? "หมายเลข IMEI นี้ถูกใช้สิทธิ์แล้ว" : data.message);
        }
    });
});

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
