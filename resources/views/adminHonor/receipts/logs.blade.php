@extends('adminHonor.layouts.template')

@section('title')
    <title>ประวัติการทำรายการใบเสร็จ</title>
@endsection

@section('stylesheet')
    <style>
        .table thead tr {
            background-color: #F9FAFB;
        }

        .table thead th {
            font-size: 0.8rem;
            letter-spacing: 0.03em;
        }

        .status-approved {
            color: #17C653;
            font-weight: 600;
        }

        .status-rejected {
            color: #F1416C;
            font-weight: 600;
        }

        .status-pending {
            color: #F6A609;
            font-weight: 600;
        }

        .filter-label {
            font-size: 0.8rem;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl py-6">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-5 mt-md-10 mb-6">

            <div>
                <a href="{{ url('admin-honor/receipts') ?? '#' }}" class="btn btn-danger">
                    กลับหน้าแรก
                </a>

            </div>
        </div>

        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-5 mt-md-10 mb-6">
            <div class="mb-3 mb-md-0">
                <h2 class="fw-bold mb-1">ประวัติการทำรายการใบเสร็จ</h2>
                <div class="text-muted">
                    ตรวจสอบว่า admin คนไหน อนุมัติหรือปฏิเสธใบเสร็จใด เวลาใด
                </div>
            </div>
        </div>

        {{-- Filter bar --}}
        <form method="GET" action="{{ route('adminHonor.receipts.logs') }}" class="card mb-6">
            <div class="card-body py-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="filter-label mb-1">ชื่อผู้ใช้ (Admin)</label>
                        <input type="text"
                               name="username"
                               value="{{ request('username') }}"
                               class="form-control"
                               placeholder="เช่น admin001">
                    </div>

                    <div class="col-md-4">
                        <label class="filter-label mb-1">ค้นหาใบเสร็จ / IMEI / เบอร์</label>
                        <input type="text"
                               name="q"
                               value="{{ request('q') }}"
                               class="form-control"
                               placeholder="เลขใบเสร็จ / IMEI / เบอร์โทร">
                    </div>

                    <div class="col-md-2">
                        <label class="filter-label mb-1">การกระทำ</label>
                        <select name="action" class="form-select">
                            <option value="">ทั้งหมด</option>
                            <option value="approved" {{ request('action') === 'approved' ? 'selected' : '' }}>อนุมัติ</option>
                            <option value="rejected" {{ request('action') === 'rejected' ? 'selected' : '' }}>ปฏิเสธ</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex gap-2 justify-content-md-end">
                        <button type="submit" class="btn btn-dark w-100">
                            กรอง
                        </button>
                        <a href="{{ route('adminHonor.receipts.logs') }}" class="btn btn-light d-none d-md-inline-flex">
                            ล้าง
                        </a>
                    </div>
                </div>
            </div>
        </form>

        {{-- Table logs --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-7 gy-4 mb-0">
                        <thead>
                        <tr class="text-start text-gray-500 fw-bold text-uppercase">
                            <th class="min-w-160px">เวลา</th>
                            <th class="min-w-120px">Admin</th>
                            <th class="min-w-100px">การกระทำ</th>
                            <th class="min-w-100px">สถานะเดิม</th>
                            <th class="min-w-100px">สถานะใหม่</th>
                            <th class="min-w-140px">เลขใบเสร็จ</th>
                            <th class="min-w-140px">IMEI</th>
                            <th class="min-w-120px">เบอร์โทร</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($logs as $log)
                            @php
                                $receipt = $log->receipt;
                                $user    = $log->user;
                            @endphp
                            <tr>
                                <td>
                                    {{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : '-' }}
                                </td>
                                <td>
                                    {{ $user->username ?? 'ไม่พบผู้ใช้' }}
                                </td>
                                <td>
                                    @if($log->action === 'approved')
                                        <span class="status-approved">อนุมัติ</span>
                                    @elseif($log->action === 'rejected')
                                        <span class="status-rejected">ปฏิเสธ</span>
                                    @else
                                        {{ $log->action }}
                                    @endif
                                </td>
                                <td>
                                    {{ $log->old_status ?? '-' }}
                                </td>
                                <td>
                                    {{ $log->new_status ?? '-' }}
                                </td>
                                <td>
                                    {{ $receipt->receipt_number ?? '-' }}
                                </td>
                                <td>
                                    {{ $receipt->imei ?? '-' }}
                                </td>
                                <td>
                                    {{ $receipt->phone ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-10 text-muted">
                                    ยังไม่มีประวัติการทำรายการ
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>



            @include('adminHonor.pagination.default', ['paginator' => $logs])
        </div>
    </div>
@endsection
