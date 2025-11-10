<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>สิทธิ์ของฉัน - HONOR</title>
  <link rel="stylesheet" href="{{ url('/home/assets/css/honor.css') }}?v={{ time() }}" />
</head>
<body>

<div class="page-wrapper2">

  <!-- Header -->
  <header class="page-header">
    <a href="{{ url('/') }}">
      <img src="{{ url('img/honor/logo@2x.png') }}" alt="HONOR logo" style="margin-left:20px">
    </a>
    <!-- เพิ่ม hamburger menu ได้ที่นี่หากต้องการ -->
  </header>

  <!-- Main Content -->
  <main class="page-content">
    <div class="regis-container" style="text-align: center;">
      <h1 class="regis-title">สิทธิ์ของฉัน</h1>
      <p class="regis-subtitle">คุณมีสิทธิ์ลุ้นรางวัลทั้งหมด</p>
      <h2 style="font-size: 48px; font-weight: bold; color: #22c55e;">{{ $totalApproved }} สิทธิ์</h2>

      <a href="{{ url('/regis_user_upslip') }}" class="btn-secondary mt-20">อัปโหลดใบเสร็จเพิ่ม</a>

      <!-- ตารางรายการใบเสร็จ -->
      <div class="receipt-table mt-30">
        <table>
          <thead>
            <tr>
              <th>วันที่ส่ง</th>
              <th>วันที่ซื้อ</th>
              <th>หมายเลข<br>ใบเสร็จ</th>
              <th>IMEI</th>
              <th>สถานะ</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($receipts as $r)
            <tr>
            <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($r->purchase_date)->format('d M Y') }}</td>
            <td>{{ $r->receipt_number }}</td>
            <td>{{ $r->imei }}</td>
            <td><span class="status {{ $r->status }}">{{ $r->status === 'approved' ? 'อนุมัติ' : ($r->status === 'pending' ? 'รอตรวจสอบ' : 'ไม่ผ่าน') }}</span></td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <p class="info-text mt-30">*สถานะการตรวจสอบใบเสร็จจะอัปเดตภายใน 3 วันทำการ</p>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="page-footer2">
    <div class="copyright2">
      © 2025 HONOR Thailand  All rights reserved. <br>
      เงื่อนไขกิจกรรม | นโยบายความเป็นส่วนตัว
    </div>
  </footer>

</div>

</body>
</html>
