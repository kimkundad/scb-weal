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
            color: #F6A609; /* เหลืองส้ม */
        }

        .status-approved {
            color: #17C653; /* เขียว */
        }

        .status-rejected {
            color: #F1416C; /* แดง */
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
    </style>

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
                <a href="{{ route('adminHonor.receipts.export') ?? '#' }}" class="btn btn-dark">
                    Export ข้อมูล
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
                {{-- hidden query อื่น ๆ ที่ต้องการเก็บ --}}
                @foreach (request()->except(['q', 'status', 'page']) as $k => $v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endforeach

                <div class="row g-3 align-items-center">
                    {{-- Search --}}
                    <div class="col-md-5">
                        <div class="position-relative">
                            <input type="text"
                                   class="form-control"
                                   name="q"
                                   value="{{ request('q') }}"
                                   placeholder="ค้นหาใบเสร็จ / IMEI / ชื่อผู้ใช้...">
                        </div>
                    </div>

                    {{-- Status dropdown --}}
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">ทั้งหมด</option>
                            <option value="pending"  {{ request('status') === 'pending' ? 'selected' : '' }}>รอตรวจสอบ</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>อนุมัติแล้ว</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>ไม่ผ่าน</option>
                        </select>
                    </div>

                    {{-- Right buttons --}}
                    <div class="col-md-4 d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-dark">
                            กรอง
                        </button>
                        <a href="{{ url()->current() }}" class="btn btn-light">
                            ล้างตัวกรอง
                        </a>
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
                                <th class="min-w-80px">วันที่ส่ง</th>
                                <th class="min-w-160px">ชื่อผู้ใช้</th>
                                <th class="min-w-140px">หมายเลขใบเสร็จ</th>
                                <th class="min-w-140px">IMEI</th>
                                <th class="min-w-100px">รุ่น</th>
                                <th class="min-w-100px">สถานะ</th>
                                <th class="min-w-200px text-end">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($receipts as $r)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($r->submitted_at ?? $r->created_at)->format('d M Y') }}</td>
                                    <td>{{ $r->user_name ?? '-' }}</td>
                                    <td>{{ $r->receipt_no ?? '-' }}</td>
                                    <td>{{ $r->imei ?? '-' }}</td>
                                    <td>{{ $r->model ?? '-' }}</td>

                                    {{-- สถานะ --}}
                                    <td>
                                        @php($status = $r->status ?? 'pending')
                                        @if($status === 'approved')
                                            <span class="status-text status-approved">อนุมัติ</span>
                                        @elseif($status === 'failed')
                                            <span class="status-text status-rejected">ไม่ผ่าน</span>
                                        @else
                                            <span class="status-text status-pending">รอตรวจสอบ</span>
                                        @endif
                                    </td>

                                    {{-- ปุ่มจัดการ --}}
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            {{-- ปุ่มดูรายละเอียด แทนที่จะวิ่งไป route --}}
                                            <button type="button"
                                                    class="btn btn-light-gray btn-sm btn-show-receipt"
                                                    data-fullname="{{ trim(($r->first_name ?? '') . ' ' . ($r->last_name ?? '')) }}"
                                                    data-phone="{{ $r->phone }}"
                                                    data-email="{{ $r->email }}"
                                                    data-province="{{ $r->province }}"
                                                    data-purchase-date="{{ $r->purchase_date }}"
                                                    data-purchase-time="{{ $r->purchase_time }}"
                                                    data-receipt-number="{{ $r->receipt_number }}"
                                                    data-imei="{{ $r->imei }}"
                                                    data-store="{{ $r->store_name }}"
                                                    data-status="{{ $r->status }}"
                                                    data-receipt-file="{{ $r->receipt_file_path }}">
                                                <i class="fa-solid fa-eye me-1"></i> ดูรายละเอียด
                                            </button>

                                            <form action="{{ route('adminHonor.receipts.approve', $r->id) ?? '#' }}"
                                                  method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-dark btn-sm">
                                                    ✓ อนุมัติ
                                                </button>
                                            </form>

                                            <form action="{{ route('adminHonor.receipts.reject', $r->id) ?? '#' }}"
                                                  method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm">
                                                    ✕ ปฏิเสธ
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-10 text-muted">
                                        ไม่พบรายการใบเสร็จ
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination (ถ้ามี) --}}
            @if(method_exists($receipts, 'links'))
                <div class="card-footer py-4">
                    {{ $receipts->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>


    {{-- Modal แสดงรายละเอียดใบเสร็จ --}}
<div class="modal fade" id="receiptDetailModal" tabindex="-1" aria-labelledby="receiptDetailModalLabel" aria-hidden="true">
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
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>วันที่ซื้อ:</strong> <span id="detail-purchase-date">-</span></p>
                        <p class="mb-1"><strong>เวลาที่ซื้อ:</strong> <span id="detail-purchase-time">-</span></p>
                        <p class="mb-1"><strong>หมายเลขใบเสร็จ:</strong> <span id="detail-receipt-number">-</span></p>
                        <p class="mb-1"><strong>IMEI:</strong> <span id="detail-imei">-</span></p>
                        <p class="mb-1"><strong>ร้านค้า:</strong> <span id="detail-store">-</span></p>
                        <p class="mb-1"><strong>สถานะ:</strong>
                            <span id="detail-status" class="status-text">-</span>
                        </p>
                    </div>
                </div>

                <hr>

                <div>
                    <h6 class="mb-2">หลักฐานการซื้อ (Slip / ใบเสร็จ)</h6>
                    <div class="border rounded p-2 text-center">
                        <img id="detail-receipt-image" src="" alt="หลักฐานการซื้อ"
                             class="img-fluid" style="max-height: 450px; object-fit: contain;">
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.btn-show-receipt');
        const modalEl = document.getElementById('receiptDetailModal');
        if (!modalEl) return;

        const modal = new bootstrap.Modal(modalEl);

        buttons.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();

                // เติมข้อมูล text
                document.getElementById('detail-fullname').textContent      = this.dataset.fullname || '-';
                document.getElementById('detail-phone').textContent         = this.dataset.phone || '-';
                document.getElementById('detail-email').textContent         = this.dataset.email || '-';
                document.getElementById('detail-province').textContent      = this.dataset.province || '-';
                document.getElementById('detail-purchase-date').textContent = this.dataset.purchaseDate || '-';
                document.getElementById('detail-purchase-time').textContent = this.dataset.purchaseTime || '-';
                document.getElementById('detail-receipt-number').textContent= this.dataset.receiptNumber || '-';
                document.getElementById('detail-imei').textContent          = this.dataset.imei || '-';
                document.getElementById('detail-store').textContent         = this.dataset.store || '-';

                // สถานะ + สี
                const statusEl = document.getElementById('detail-status');
                const status = this.dataset.status || 'pending';
                statusEl.classList.remove('status-pending', 'status-approved', 'status-rejected');

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
</script>
@endsection
