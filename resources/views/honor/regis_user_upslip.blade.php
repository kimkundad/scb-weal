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
    background: #000;
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


</style>
<style>
    .hbd-wrapper {
        display: flex;
        gap: 10px;
    }

    .hbd-select {
        flex: 1;
        padding: 12px;
    }
    </style>
<body>

    <div class="page-wrapper2">

        <!-- Header -->
        <header class="page-header">
            <a href="{{ url('/') }}">
                <img src="{{ url('img/honor/logo@2x.png') }}" alt="HONOR logo" style="margin-left:20px">
            </a>
            <!-- ปุ่มออกจากระบบบนขวา -->
            <a href="{{ url('/logout-honor') }}" class="btn-logout-header">
                ออกจากระบบ
            </a>
        </header>

        <!-- Main Content -->
        <main class="page-content">
            <div class="regis-container">
                <h1 class="regis-title">ส่งข้อมูลการซื้อ</h1>
                <p class="regis-subtitle">
                    กรอกข้อมูลการซื้อสินค้าของคุณให้ครบถ้วน เพื่อรับสิทธิ์ลุ้นรางวัล
                </p>

                <form method="POST" action="{{ url('/regis_user_upslip') }}" onsubmit="return validateForm();" class="regis-form"
                    enctype="multipart/form-data">
                    @csrf

                    <label for="purchase_day">วันที่ซื้อสินค้า</label>

                    <div class="hbd-wrapper">

                        {{-- ⭐ DAY --}}
                        <select name="purchase_day" id="purchase_day" class="regis-input hbd-select" required>
                            <option value="">วัน</option>
                            @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ sprintf('%02d', $i) }}">{{ $i }}</option>
                            @endfor
                        </select>

                        {{-- ⭐ MONTH --}}
                        <select name="purchase_month" id="purchase_month" class="regis-input hbd-select" required>
                            <option value="">เดือน</option>
                            <option value="01">มกราคม</option>
                            <option value="02">กุมภาพันธ์</option>
                            <option value="03">มีนาคม</option>
                            <option value="04">เมษายน</option>
                            <option value="05">พฤษภาคม</option>
                            <option value="06">มิถุนายน</option>
                            <option value="07">กรกฎาคม</option>
                            <option value="08">สิงหาคม</option>
                            <option value="09">กันยายน</option>
                            <option value="10">ตุลาคม</option>
                            <option value="11">พฤศจิกายน</option>
                            <option value="12">ธันวาคม</option>
                        </select>

                        {{-- ⭐ YEAR (พ.ศ.) --}}
                        @php
                            $thisYearTH = date('Y') + 543;
                            $startYearTH = $thisYearTH + 1;  // ซื้อย้อนหลังได้ 3 ปี (ปรับได้ตามต้องการ)
                        @endphp

                        <select name="purchase_year" id="purchase_year" class="regis-input hbd-select" required>

                            @foreach (range($thisYearTH, $startYearTH) as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>

                        <input type="hidden" name="purchase_date" id="purchase_date">
                    </div>



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

                            <button type="button" id="check-imei-btn" class="btn-check-imei" style="font-family: 'Anuphan', sans-serif;font-size: 18px;padding: 16px 16px;">
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
            <a href="{{ url('/terms') }}" class="footer-link">เงื่อนไขกิจกรรม</a> |
            <a href="{{ url('/privacy-policy') }}" class="footer-link">นโยบายความเป็นส่วนตัว</a>
        </div>
    </footer>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function validateForm() {

    // ------------------------------
    // 1) ตรวจวันที่ซื้อสินค้า (วัน / เดือน / ปี พ.ศ.)
    // ------------------------------
    let d = document.getElementById("purchase_day").value;
    let m = document.getElementById("purchase_month").value;
    let y_th = document.getElementById("purchase_year").value;

    if (!d || !m || !y_th) {
        Swal.fire({
            icon: "warning",
            title: "กรุณาเลือกวันที่ซื้อสินค้าให้ครบถ้วน"
        });
        return false;
    }

    // แปลง พ.ศ. → ค.ศ.
    let y_ad = parseInt(y_th) - 543;
    let selectDate = new Date(`${y_ad}-${m}-${d}`);
    let today = new Date();

    if (isNaN(selectDate.getTime())) {
        Swal.fire({
            icon: "error",
            title: "วันที่ไม่ถูกต้อง",
            text: "กรุณาตรวจสอบอีกครั้ง"
        });
        return false;
    }

    if (selectDate > today) {
        Swal.fire({
            icon: "error",
            title: "เลือกวันอนาคตไม่ได้",
            text: "วันที่ซื้อสินค้าต้องไม่เกินวันปัจจุบัน"
        });
        return false;
    }

    // ส่งค่า purchase_date เป็น ค.ศ. ไป backend
    document.getElementById("purchase_date").value = `${y_th}-${m}-${d}`;


    // ------------------------------
    // 2) ตรวจสอบ IMEI (ต้องตรวจสอบก่อนส่ง)
    // ------------------------------
    if (!window.imei_valid) {
        Swal.fire({
            icon: "error",
            title: "กรุณากดปุ่มตรวจสอบ IMEI ก่อนส่งข้อมูล"
        });
        return false;
    }

    // ผ่านทั้งหมด → ส่งฟอร์มได้
    return true;
}
</script>
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


</script>



</body>

</html>
