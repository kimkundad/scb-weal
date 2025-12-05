@extends('adminHonor.layouts.template')

@section('title')
    <title>ภาพรวมกิจกรรม & รายการใบเสร็จ</title>
@endsection

@section('stylesheet')
    <style>
        .card-min {
            min-height: 110px;
        }

        .col-5th {
            flex: 0 0 20%;
            max-width: 20%;
        }

        @media (max-width: 991.98px) {
            .col-5th {
                flex: 0 0 50%;
                max-width: 50%;
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 575.98px) {
            .col-5th {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        .stat-label {
            font-size: 0.9rem;
            color: #7E8299;
        }

        .stat-number {
            font-size: 2.4rem;
            font-weight: 700;
        }

        .stat-sub {
            font-size: 0.75rem;
            color: #A1A5B7;
        }

        .status-text {
            font-weight: 600;
        }

        .status-pending {
            color: #F6A609;
            /* เหลืองส้ม */
        }

        .status-approved {
            color: #17C653;
            /* เขียว */
        }

        .status-rejected {
            color: #F1416C;
            /* แดง */
        }

        .btn-light-gray {
            background-color: #F5F8FA;
            border-color: #E4E6EF;
            color: #5E6278;
        }

        .btn-light-gray:hover {
            background-color: #E4E6EF;
            color: #181C32;
        }

        .table thead tr {
            background-color: #F9FAFB;
        }

        .table thead th {
            font-size: 0.8rem;
            letter-spacing: 0.03em;
        }

        .min-w-180px1 {
            min-width: 120px;
        }

        .btn-group-sm>.btn:not(.btn-outline):not(.btn-dashed):not(.border-hover):not(.border-active):not(.btn-flush):not(.btn-icon),
        .btn:not(.btn-outline):not(.btn-dashed):not(.border-hover):not(.border-active):not(.btn-flush):not(.btn-icon).btn-sm {
            padding: 10px 8px;
        }
    </style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container-xxl py-6">

        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-5 mt-md-10 mb-6">
            <div class="mb-3 mb-md-0">
                <h2 class="fw-bold mb-1">ภาพรวมกิจกรรม & รายการใบเสร็จ</h2>
                <div class="text-muted">ติดตามจำนวนผู้เข้าร่วม, ใบเสร็จ และสถานะการตรวจสอบแบบเรียลไทม์</div>
            </div>

            <div>
                <a href="{{ url('admin-honor/imei-list') ?? '#' }}" class="btn btn-dark">
                    หมายเลข IMEI
                </a>
                <a href="{{ route('adminHonor.receipts.logs') ?? '#' }}" class="btn btn-dark">
                    Logs
                </a>
                <a href="{{ route('adminHonor.receipts.export') ?? '#' }}" class="btn btn-dark">
                    Export ข้อมูล
                </a>
                <a href="{{ url('/admin-honor/logout') ?? '#' }}" class="btn btn-danger">
                    ออกจากระบบ
                </a>
            </div>
        </div>

        {{-- Summary cards --}}
        @php
            $get = fn($k, $d = 0) => $summary[$k] ?? $d;
        @endphp

        <div class="row g-4 mb-6">
            {{-- จำนวนผู้เข้าร่วม --}}
            <div class="col-5th">
                <div class="card border card-min">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="stat-label mb-1">จำนวนผู้เข้าร่วม</div>
                        <div class="stat-number mb-1">{{ number_format($get('participants')) }}</div>
                        <div class="stat-sub">คน</div>
                    </div>
                </div>
            </div>

            {{-- ใบเสร็จทั้งหมด --}}
            <div class="col-5th">
                <div class="card border card-min">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="stat-label mb-1">ใบเสร็จทั้งหมด</div>
                        <div class="stat-number mb-1">{{ number_format($get('receipts_total')) }}</div>
                        <div class="stat-sub">ใบ</div>
                    </div>
                </div>
            </div>

            {{-- รอตรวจสอบ --}}
            <div class="col-5th">
                <div class="card border card-min">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="stat-label mb-1">รอตรวจสอบ</div>
                        <div class="stat-number mb-1 text-warning">
                            {{ number_format($get('pending')) }}
                        </div>
                        <div class="stat-sub">ใบเสร็จ</div>
                    </div>
                </div>
            </div>

            {{-- อนุมัติแล้ว --}}
            <div class="col-5th">
                <div class="card border card-min">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="stat-label mb-1">อนุมัติแล้ว</div>
                        <div class="stat-number mb-1 text-success">
                            {{ number_format($get('approved')) }}
                        </div>
                        <div class="stat-sub">ใบเสร็จ</div>
                    </div>
                </div>
            </div>

            {{-- ไม่ผ่าน --}}
            <div class="col-5th">
                <div class="card border card-min">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="stat-label mb-1">ไม่ผ่าน</div>
                        <div class="stat-number mb-1 text-danger">
                            {{ number_format($get('rejected')) }}
                        </div>
                        <div class="stat-sub">ใบเสร็จ</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search + filter bar --}}
        <form id="filterForm" method="GET" action="{{ url()->current() }}" class="card mb-6">
            <div class="card-body py-4">

                {{-- preserve query --}}
                @foreach (request()->except(['q', 'status', 'start_date', 'end_date', 'page']) as $k => $v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endforeach

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">ค้นหา</label>
                        <input type="text" class="form-control" name="q" value="{{ request('q') }}"
                            placeholder="ค้นหา: ใบเสร็จ / IMEI / ชื่อ / เบอร์โทร / อีเมล">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">สถานะใบเสร็จ</label>
                        <select name="status" class="form-select">
                            <option value="">ทั้งหมด</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>รอตรวจสอบ
                            </option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>อนุมัติแล้ว
                            </option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>ไม่ผ่าน
                            </option>
                        </select>
                    </div>

                    @php
                    function displayDateInput($date) {
                        if (!$date) return '';
                        return \Carbon\Carbon::parse($date)->format('d/m/Y'); // ← แสดง dd/mm/yyyy
                    }
                    @endphp

                    {{-- Date filter --}}
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">ช่วงวันที่</label>
                        <div class="d-flex gap-2">
                            <input type="date" name="start_date" class="form-control "
                                value="{{ request('start_date') }}">
                            <input type="date" name="end_date" class="form-control " value="{{ request('end_date') }}">
                        </div>
                    </div>

                </div>

                {{-- Buttons Row --}}
                <div class="row mt-4">
                    <div class="col d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-dark px-4">กรอง</button>
                        <a href="{{ url()->current() }}" class="btn btn-light px-4">ล้างตัวกรอง</a>
                    </div>
                </div>

            </div>
        </form>



        {{-- Table --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-7 gy-4 mb-0">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold text-uppercase">
                                <th>ลำดับ</th>
                                <th class="min-w-120px">เวลาที่ลงทะเบียน</th>
                                <th class="min-w-160px">ชื่อผู้ใช้</th>
                                <th class="min-w-180px1">เบอร์โทร</th>
                                <th class="min-w-140px">IMEI</th>
                                <th class="min-w-100px">ร้านค้าที่ซื้อ</th>
                                <th class="min-w-100px">วันเกิด</th>
                                <th class="min-w-100px">สถานะ</th>
                                <th class="min-w-180px">วันที่ตรวจสอบ</th>
                                <th class="min-w-180px">ผู้ตรวจสอบ</th>
                                <th class="min-w-200px text-end">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($receipts as $index => $r)
                                <tr>
                                    {{-- ลำดับ --}}
                                    <td>{{ $index + 1 }}</td>

                                    {{-- วันเดือนปี + เวลา (ภาษาไทย) --}}
                                    <td>
                                        @php
                                            \Carbon\Carbon::setLocale('th');
                                            $dt = \Carbon\Carbon::parse($r->created_at);
                                        @endphp
                                        {{ $dt->translatedFormat('j F Y') }}<br>
                                        <small class="text-muted">{{ $dt->format('H:i') }} น.</small>
                                    </td>

                                    {{-- ชื่อผู้ใช้ --}}
                                    <td>{{ $r->user_name ?? '-' }}</td>

                                    <td>{{ $r->phone ?? '-' }}</td>

                                    {{-- หมายเลขใบเสร็จ --}}


                                    {{-- IMEI --}}
                                    <td>{{ $r->imei ?? '-' }}</td>

                                    {{-- รุ่น --}}
                                    <td>{{ $r->model ?? '-' }}</td>
                                    <td>
                                        @if (!empty($r->hbd))
                                            {{ $r->hbd }}
                                            ({{ \Carbon\Carbon::parse($r->hbd)->age }} ปี)
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- สถานะ --}}
                                    <td>
                                        @php($status = $r->status ?? 'pending')
                                        @if ($status === 'approved')
                                            <span class="status-text status-approved">อนุมัติ</span>
                                        @elseif($status === 'failed')
                                            <span class="status-text status-rejected">ไม่ผ่าน</span>
                                        @else
                                            <span class="status-text status-pending">รอตรวจสอบ</span>
                                        @endif
                                    </td>

                                    {{-- วันที่ตรวจสอบ --}}
                                    <td>
                                        @if ($r->approved_at)
                                            <span class="text-success">
                                                {{ \Carbon\Carbon::parse($r->approved_at)->translatedFormat('j F Y H:i') }}
                                                น.
                                            </span>
                                        @elseif($r->rejected_at)
                                            <span class="text-danger">
                                                {{ \Carbon\Carbon::parse($r->rejected_at)->translatedFormat('j F Y H:i') }}
                                                น.
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- ผู้ตรวจสอบ --}}
                                    <td>{{ $r->checked_by ?? '-' }}</td>

                                    {{-- ปุ่มจัดการ --}}
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">

                                            {{-- ปุ่มดูรายละเอียด --}}
                                            <button type="button" class="btn btn-light-gray btn-sm btn-show-receipt"
                                                data-index="{{ $index + 1 }}" data-created="{{ $r->created_at }}"
                                                data-approved="{{ $r->approved_at }}"
                                                data-rejected="{{ $r->rejected_at }}"
                                                data-checked-by="{{ $r->checked_by }}"
                                                data-reject-reason="{{ $r->reject_reason }}"
                                                data-receipt-file="{{ $r->receipt_file_path }}"
                                                data-status="{{ $r->status }}"
                                                data-fullname="{{ trim(($r->first_name ?? '') . ' ' . ($r->last_name ?? '')) }}"
                                                data-phone="{{ $r->phone }}" data-email="{{ $r->email }}"
                                                data-province="{{ $r->province }}"
                                                data-purchase-date="{{ $r->purchase_date }}"
                                                data-purchase-time="{{ $r->purchase_time }}"
                                                data-receipt-number="{{ $r->receipt_number }}"
                                                data-imei="{{ $r->imei }}" data-store="{{ $r->store_name }}"
                                                {{-- ⭐ เพิ่ม 3 ตัวนี้ --}} data-id-type="{{ $r->id_type }}"
                                                data-citizen-id="{{ $r->citizen_id }}"
                                                data-passport-id="{{ $r->passport_id }}">
                                                รายละเอียด
                                            </button>


                                            {{-- อนุมัติ --}}
                                            <form action="{{ route('adminHonor.receipts.approve', $r->id) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-dark btn-sm">✓ อนุมัติ</button>
                                            </form>

                                            {{-- ปฏิเสธ --}}
                                            <button type="button" class="btn btn-danger btn-sm btn-reject"
                                                data-id="{{ $r->id }}" data-imei="{{ $r->imei }}">
                                                ✕ ปฏิเสธ
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-10 text-muted">ไม่พบรายการใบเสร็จ</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>



            @include('adminHonor.pagination.default', ['paginator' => $receipts])
        </div>



    </div>


    <!-- Modal ปฏิเสธ -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">

                <form id="rejectForm" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="modal-header">
                        <h5 class="modal-title">กรอกข้อมูลการใบเสร็จ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <p class="mb-2">
                            <strong>IMEI:</strong> <span id="reject-imei"></span>
                        </p>

                        <label class="form-label">กรุณาระบุสาเหตุที่ปฏิเสธ</label>
                        <textarea name="reject_reason" id="reject_reason" class="form-control" rows="4" required></textarea>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-danger">ยืนยันปฏิเสธ</button>
                    </div>

                </form>

            </div>
        </div>
    </div>



    {{-- Modal แสดงรายละเอียดใบเสร็จ --}}
    <div class="modal fade" id="receiptDetailModal" tabindex="-1" aria-labelledby="receiptDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptDetailModalLabel">รายละเอียดใบเสร็จ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>ชื่อ-นามสกุล:</strong> <span id="detail-fullname">-</span></p>
                            <p class="mb-1"><strong>เบอร์โทร:</strong> <span id="detail-phone">-</span></p>
                            <p class="mb-1"><strong>Email:</strong> <span id="detail-email">-</span></p>
                            <p class="mb-1"><strong>จังหวัด:</strong> <span id="detail-province">-</span></p>

                            <!-- ⭐ เพิ่มข้อมูลเอกสาร -->
                            <p class="mb-1"><strong>ประเภทเอกสาร:</strong> <span id="detail-id-type">-</span></p>
                            <p class="mb-1"><strong>เลขบัตรประชาชน:</strong> <span id="detail-citizen-id">-</span></p>
                            <p class="mb-1"><strong>เลขพาสปอร์ต:</strong> <span id="detail-passport-id">-</span></p>


                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>วันที่ซื้อ:</strong> <span id="detail-purchase-date">-</span></p>
                            <p class="mb-1"><strong>เวลาที่ซื้อ:</strong> <span id="detail-purchase-time">-</span></p>
                            <p class="mb-1"><strong>หมายเลขใบเสร็จ:</strong> <span id="detail-receipt-number">-</span>
                            </p>
                            <p class="mb-1"><strong>IMEI:</strong> <span id="detail-imei">-</span></p>
                            <p class="mb-1"><strong>ร้านค้า:</strong> <span id="detail-store">-</span></p>
                            <p class="mb-1"><strong>สถานะ:</strong>
                                <span id="detail-status" class="status-text">-</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-md-6">
                            <p class="mb-1"><strong>ลงทะเบียนในระบบวันที่:</strong>
                                <span id="detail-created">-</span>
                            </p>

                            <p class="mb-1"><strong>ลำดับใบเสร็จที่ลงทะเบียน:</strong>
                                <span id="detail-index">-</span>
                            </p>

                            <p class="mb-1"><strong>อนุมัติวันที่:</strong>
                                <span id="detail-approved-at">-</span>
                            </p>

                            <p class="mb-1"><strong>เจ้าหน้าที่ที่อนุมัติ:</strong>
                                <span id="detail-checked-by">-</span>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p class="mb-1"><strong>ไม่อนุมัติวันที่:</strong>
                                <span id="detail-rejected-at">-</span>
                            </p>

                            <p class="mb-1"><strong>สาเหตุที่ไม่อนุมัติ:</strong>
                                <span id="detail-reject-reason">-</span>
                            </p>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>
<script>
flatpickr(".date-picker", {
    dateFormat: "d/m/Y",
    locale: "th"
});
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
            const rejectForm = document.getElementById('rejectForm');
            const rejectImei = document.getElementById('reject-imei');

            document.querySelectorAll('.btn-reject').forEach(btn => {
                btn.addEventListener('click', function() {

                    const id = this.dataset.id;
                    const imei = this.dataset.imei ?? "-";

                    // ใส่ข้อมูลใน modal
                    rejectImei.textContent = imei;

                    // ตั้ง action url = receipts/{id}/reject
                    rejectForm.action = `/admin-honor/receipts/${id}/reject`;

                    // เปิด modal
                    rejectModal.show();
                });
            });

        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-show-receipt');
            const modalEl = document.getElementById('receiptDetailModal');
            if (!modalEl) return;

            const modal = new bootstrap.Modal(modalEl);

            buttons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // เติมข้อมูล text
                    document.getElementById('detail-fullname').textContent = this.dataset
                        .fullname || '-';
                    document.getElementById('detail-phone').textContent = this.dataset.phone || '-';
                    document.getElementById('detail-email').textContent = this.dataset.email || '-';
                    document.getElementById('detail-province').textContent = this.dataset
                        .province || '-';
                    document.getElementById('detail-purchase-date').textContent = this.dataset
                        .purchaseDate || '-';
                    document.getElementById('detail-purchase-time').textContent = this.dataset
                        .purchaseTime || '-';
                    document.getElementById('detail-receipt-number').textContent = this.dataset
                        .receiptNumber || '-';
                    document.getElementById('detail-imei').textContent = this.dataset.imei || '-';
                    document.getElementById('detail-store').textContent = this.dataset.store || '-';

                    document.getElementById('detail-id-type').textContent =
                        this.dataset.idType || '-';

                    document.getElementById('detail-citizen-id').textContent =
                        this.dataset.citizenId || '-';

                    document.getElementById('detail-passport-id').textContent =
                        this.dataset.passportId || '-';

                    // สถานะ + สี
                    const statusEl = document.getElementById('detail-status');
                    const status = this.dataset.status || 'pending';
                    statusEl.classList.remove('status-pending', 'status-approved',
                        'status-rejected');

                    if (status === 'approved') {
                        statusEl.textContent = 'อนุมัติ';
                        statusEl.classList.add('status-approved');
                    } else if (status === 'failed') {
                        // ใน DB ใช้ failed แต่บน UI ใช้ "ไม่ผ่าน"
                        statusEl.textContent = 'ไม่ผ่าน';
                        statusEl.classList.add('status-rejected');
                    } else {
                        statusEl.textContent = 'รอตรวจสอบ';
                        statusEl.classList.add('status-pending');
                    }

                    // รูปใบเสร็จ
                    const img = document.getElementById('detail-receipt-image');
                    img.src = this.dataset.receiptFile || '';
                    img.style.display = this.dataset.receiptFile ? 'block' : 'none';

                    // เปิด modal
                    modal.show();
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {

            const buttons = document.querySelectorAll('.btn-show-receipt');
            const modal = new bootstrap.Modal(document.getElementById('receiptDetailModal'));

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {

                    // ลำดับใบเสร็จ
                    document.getElementById('detail-index').textContent = this.dataset.index;

                    // ลงทะเบียนวันที่ (ภาษาไทย)
                    document.getElementById('detail-created').textContent =
                        this.dataset.created ?
                        new Date(this.dataset.created).toLocaleString('th-TH') :
                        '-';

                    // อนุมัติวันที่
                    document.getElementById('detail-approved-at').textContent =
                        this.dataset.approved ?
                        new Date(this.dataset.approved).toLocaleString('th-TH') :
                        '-';

                    // เจ้าหน้าที่
                    document.getElementById('detail-checked-by').textContent =
                        this.dataset.checkedBy || '-';

                    // ไม่อนุมัติวันที่
                    document.getElementById('detail-rejected-at').textContent =
                        this.dataset.rejected ?
                        new Date(this.dataset.rejected).toLocaleString('th-TH') :
                        '-';

                    // สาเหตุ reject
                    document.getElementById('detail-reject-reason').textContent =
                        this.dataset.rejectReason || '-';

                    // โหลดรูปใบเสร็จ
                    const img = document.getElementById('detail-receipt-image');
                    img.src = this.dataset.receiptFile || '';

                    // ปุ่มดาวน์โหลด
                    const downloadBtn = document.getElementById('detail-download-btn');
                    downloadBtn.href = this.dataset.receiptFile || '#';

                    // เปิด modal
                    modal.show();
                });
            });

        });



        document.addEventListener('DOMContentLoaded', function() {

            const buttons = document.querySelectorAll('.btn-show-receipt');
            const downloadBtn = document.getElementById('detail-download-btn');

            buttons.forEach(function(btn) {
                btn.addEventListener('click', function() {

                    let fileUrl = this.dataset.receiptFile;
                    let imei = this.dataset.imei ?? 'unknown';
                    let filename = `receipt_${imei}.jpg`;

                    // ส่งไป controller เพื่อบังคับโหลด
                    downloadBtn.href =
                        `/adminHonor/receipt/download?url=${encodeURIComponent(fileUrl)}&filename=${filename}`;
                });
            });

        });



        document.addEventListener('DOMContentLoaded', function() {

            let modal = null;
            const modalEl = document.getElementById('receiptDetailModal');

            // สร้าง modal แค่ครั้งเดียว
            if (!modal) {
                modal = new bootstrap.Modal(modalEl);
            }

            const buttons = document.querySelectorAll('.btn-show-receipt');
            const downloadBtn = document.getElementById('detail-download-btn');

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {

                    // ... (ใส่ข้อมูลลง modal ตามเดิม)

                    modal.show();
                });
            });

            // ล้าง backdrop เมื่อ modal ปิด
            modalEl.addEventListener('hidden.bs.modal', function() {
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style = "";
            });
        });
    </script>
@endsection
