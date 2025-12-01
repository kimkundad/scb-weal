@extends('adminHonor.layouts.template')

@section('title')
    <title>หมายเลข IMEI ทั้งหมด</title>
@endsection

@section('stylesheet')
    <style>
        .status-unused {
            color: #6B7280;
            font-weight: 600;
        }

        .status-used {
            color: #F1416C;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl py-6">

        <!-- Back button -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-5 mt-md-10 mb-6">
            <a href="{{ url('admin-honor/receipts') }}" class="btn btn-danger">
                กลับหน้าแรก
            </a>
        </div>

        <!-- Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-5 mb-6">
            <div>
                <h2 class="fw-bold mb-1">รายการหมายเลข IMEI ทั้งหมด</h2>
                <div class="text-muted">
                    ตรวจสอบสถานะ IMEI และผู้ใช้งาน
                </div>
            </div>
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('adminHonor.imei.index') }}" class="card mb-6">
            <div class="card-body py-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="filter-label mb-1">ค้นหา IMEI</label>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                            placeholder="กรอกหมายเลข IMEI">
                    </div>

                    <div class="col-md-2 d-flex gap-2 justify-content-md-end">
                        <button type="submit" class="btn btn-dark w-100">
                            ค้นหา
                        </button>
                        <a href="{{ route('adminHonor.imei.index') }}" class="btn btn-light d-none d-md-inline-flex">
                            ล้าง
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-7 gy-4 mb-0">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold text-uppercase">
                                <th class="min-w-120px">IMEI</th>
                                <th class="min-w-140px">สถานะ</th>
                                <th class="min-w-160px">ชื่อ - นามสกุล</th>
                                <th class="min-w-140px">เบอร์โทร</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($imeis as $row)
                                <tr>
                                    <td>{{ $row->imei }}</td>

                                    <td>
                                        @if ($row->phone)
                                            <span class="text-danger">ถูกใช้งานแล้ว</span>
                                        @else
                                            <span class="text-muted">ยังไม่ถูกใช้งาน</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $row->first_name ? $row->first_name . ' ' . $row->last_name : '-' }}
                                    </td>

                                    <td>
                                        {{ $row->phone ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-10 text-muted">
                                        ยังไม่มีรายการ IMEI
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>


            @include('adminHonor.pagination.default', ['paginator' => $imeis])

        </div>
    @endsection
