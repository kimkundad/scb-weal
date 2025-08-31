@extends('admin.layouts.template')

@section('title')
    <title>รายชื่อสมาชิกทั้งหมด</title>
@endsection

@section('stylesheet')
    <style>
        .card-min {
            min-height: 96px
        }

        .w-120px {
            width: 120px
        }

        .table> :not(caption)>*>* {
            padding-top: .9rem;
            padding-bottom: .9rem;
        }

        .badge-dot {
            position: relative;
            padding-left: 14px
        }

        .badge-dot:before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%)
        }

        .filter-row .form-select,
        .filter-row .form-control {
            height: 38px
        }
    </style>

    <style>
        .dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            vertical-align: middle;
        }

        .dot-green {
            background: #34D399;
        }

        /* check-in */
        .dot-orange {
            background: #EA8238;
        }

        /* เผื่อใช้ */
        .dot-navy {
            background: #001E7E;
        }

        /* เผื่อใช้ */
        .dot-gray {
            background: #9CA3AF;
        }

        /* สีเทาที่คุณขอ */
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container-xxl py-6">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-start mt-10">
            <div>
                <h2 class="fw-bold mb-1">รายชื่อสมาชิกทั้งหมด</h2>
                {{-- <div class="text-muted">Checkin ทั้งหมด
                    <span class="text-success fw-bold">{{ number_format($totals['checkin_all'] ?? 75) }}</span>
                </div> --}}
                <p class="text-muted">
                    เช็คอินแล้ว: <span class="text-success fw-bold">{{ number_format($checkedCount) }}</span>
                    • ยังไม่เช็คอิน: <span class="fw-bold">{{ number_format($notCheckedCount) }}</span>
                </p>
            </div>
            <a href="{{ route('members.create') }}"
                class="btn btn-outline btn-outline-dashed btn-outline-success btn-active-light-success">เพิ่มผู้เข้าร่วมงาน</a>
        </div>


        {{-- Summary cards (A–C → Morning) + (D–F → Afternoon) --}}
        @php
            $get = fn($k, $d = 0) => $stats[$k] ?? $d;
        @endphp
        @php($groups = $groups ?? ['A', 'B', 'C', 'D', 'E', 'F'])

        {{-- Summary cards --}}
        <div class="row g-5 mt-4">
            {{-- Row 1: A, B, C, Morning --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border card-min hover-elevate-up">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-gray-600 fs-7">Group A</div>
                            <div class="fs-2hx fw-bold">{{ number_format($get('group_A')) }}</div>
                            <div class="text-gray-600 fs-8">คน</div>
                        </div>
                        <div class="symbol symbol-45px">
                            <div class="symbol-label bg-light-warning">
                                <i class="fa-solid fa-user fs-2 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border card-min hover-elevate-up">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-gray-600 fs-7">Group B</div>
                            <div class="fs-2hx fw-bold">{{ number_format($get('group_B')) }}</div>
                            <div class="text-gray-600 fs-8">คน</div>
                        </div>
                        <div class="symbol symbol-45px">
                            <div class="symbol-label bg-light-warning">
                                <i class="fa-solid fa-user fs-2 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border card-min hover-elevate-up">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-gray-600 fs-7">Group C</div>
                            <div class="fs-2hx fw-bold">{{ number_format($get('group_C')) }}</div>
                            <div class="text-gray-600 fs-8">คน</div>
                        </div>
                        <div class="symbol symbol-45px">
                            <div class="symbol-label bg-light-warning">
                                <i class="fa-solid fa-user fs-2 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Morning total (A–C) --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border card-min hover-elevate-up">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-gray-600 fs-7">จำนวนผู้ลงทะเบียนรอบเช้า</div>
                            <div class="fs-2hx fw-bold">
                                {{ number_format($get('external_morning')) }}
                            </div>
                            <div class="text-gray-600 fs-8">คน</div>
                        </div>
                        <div class="symbol symbol-45px">
                            <div class="symbol-label bg-light-warning d-flex align-items-center justify-content-center">
                                <img src="{{ asset('img/icons/morning.png') }}" alt="morning" class="w-25px h-25px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 2: D, E, F, Afternoon --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border card-min hover-elevate-up">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-gray-600 fs-7">Group D</div>
                            <div class="fs-2hx fw-bold">{{ number_format($get('group_D')) }}</div>
                            <div class="text-gray-600 fs-8">คน</div>
                        </div>
                        <div class="symbol symbol-45px">
                            <div class="symbol-label bg-light">
                                <i class="fa-solid fa-user fs-2 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border card-min hover-elevate-up">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-gray-600 fs-7">Group E</div>
                            <div class="fs-2hx fw-bold">{{ number_format($get('group_E')) }}</div>
                            <div class="text-gray-600 fs-8">คน</div>
                        </div>
                        <div class="symbol symbol-45px">
                            <div class="symbol-label bg-light">
                                <i class="fa-solid fa-user fs-2 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border card-min hover-elevate-up">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-gray-600 fs-7">Group F</div>
                            <div class="fs-2hx fw-bold">{{ number_format($get('group_F')) }}</div>
                            <div class="text-gray-600 fs-8">คน</div>
                        </div>
                        <div class="symbol symbol-45px">
                            <div class="symbol-label bg-light">
                                <i class="fa-solid fa-user fs-2 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Afternoon total (D–F) --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border card-min hover-elevate-up">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-gray-600 fs-7">จำนวนผู้ลงทะเบียนรอบบ่าย</div>
                            <div class="fs-2hx fw-bold">
                                {{ number_format($get('external_afternoon')) }}
                            </div>
                            <div class="text-gray-600 fs-8">คน</div>
                        </div>
                        <div class="symbol symbol-45px">
                            <div class="symbol-label bg-light d-flex align-items-center justify-content-center">
                                <img src="{{ asset('img/icons/afternoon.png') }}" alt="afternoon" class=" h-25px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search + Filters (one GET form) --}}
        <form id="filterForm" method="GET" action="{{ url()->current() }}" class="mt-6 mb-3">

            {{-- พกพา query อื่น ๆ ที่อาจมีอยู่ (ยกเว้นตัวที่เราจะเปลี่ยนเอง) --}}
            @foreach (request()->except(['q', 'sort', 'badge', 'status', 'page']) as $k => $v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endforeach

            {{-- Search + datalist --}}
            <div class="input-group mb-4">
                <input type="text" class="form-control" name="q" value="{{ request('q') }}"
                    placeholder="ค้นหา (ชื่อภาษาไทย / อังกฤษ / แผนก)…" list="memberSuggestions">
                <button class="btn btn-light" type="submit" style="border:1px solid #E4E6EF">
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                </button>
            </div>

            {{-- suggestion list --}}
            <datalist id="memberSuggestions">
                @foreach ($suggestions ?? collect() as $s)
                    @if (trim($s) !== '')
                        <option value="{{ $s }}"></option>
                    @endif
                @endforeach
            </datalist>

            {{-- Filters row --}}
            <div class="filter-row row g-3 align-items-center">
                <div class="col-auto w-180px">
                    <label class="text-muted me-2">เรียง ก - ฮ</label>
                    <select class="form-select w-180px" name="sort" onchange="submitFilters()">
                        <option value="new" @selected(request('sort', 'new') === 'new')>เรียง ก - ฮ</option>
                        <option value="old" @selected(request('sort') === 'old')>เรียง ฮ - ก</option>
                    </select>
                </div>

                <div class="col-auto w-180px">
                    <label class="text-muted me-2">Badge</label>
                    <select class="form-select w-180px" name="badge" onchange="submitFilters()">
                        <option value="" @selected(request('badge', '') === '')>ทั้งหมด</option>
                        <option value="Dealer" @selected(request('badge') === 'Dealer')>Dealer</option>
                        <option value="TMT" @selected(request('badge') === 'TMT')>TMT</option>
                        <option value="AFFILIATE" @selected(request('badge') === 'AFFILIATE')>AFFILIATE</option>
                    </select>
                </div>

                <div class="col-auto w-180">
                    <label class="text-muted me-2">สถานะ</label>
                    <select class="form-select w-180px" name="status" onchange="submitFilters()">
                        <option value="" @selected(request('status', '') === '')>ทั้งหมด</option>
                        <option value="checked" @selected(request('status') === 'checked')>เช็คอิน</option>
                        <option value="not_checked" @selected(request('status') === 'not_checked')>ยังไม่เช็คอิน</option>
                        <option value="newMember" @selected(request('status') === 'newMember')>รายชื่อใหม่</option>
                        <option value="instead" @selected(request('status') === 'instead')>ผู้มาแทน</option>
                    </select>
                </div>

                <div class="col-auto">
                    <a href="{{ url('admin/dashboard') }}"
                        class="btn btn-outline btn-outline-dashed btn-outline-warning btn-active-light-warning me-2 mt-4">ล้างข้อมูล</a>
                </div>

            </div>



        </form>




        {{-- Table --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-7 gy-4">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold text-uppercase">
                                <th class="min-w-40px">No.</th>
                                <th class="min-w-100px">Badge</th>
                                <th class="min-w-90px">Group</th>
                                <th class="min-w-220px">ชื่อ-นามสกุล</th>
                                <th class="min-w-220px">Department</th>
                                <th class="min-w-140px">Check-in</th>
                                <th class="min-w-140px">Test Drive</th>
                                <th class="min-w-140px">Car Display</th>
                                <th class="min-w-160px">Strategy Sharing</th>
                                <th class="min-w-120px text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-700">
                            @forelse($members as $i => $m)
                                <tr>
                                    <td>{{ ($members->firstItem() ?? 1) + $i }}</td>

                                    <!-- <td>
                                            <span class="badge badge-light me-2">{{ $m['badge'] ?? 'Dealer' }}</span>
                                            <span class="badge-dot"></span>
                                        </td> -->

                                    <td>
                                        <span class="badge badge-light me-2">{{ $m['badge'] ?: '—' }}</span>

                                        <span class="status-dot" id="status-dot-{{ $m['row'] }}">
                                            @if((string)($m['new_member'] ?? '') === '1')
                                             <span class="dot dot-navy"></span>     {{-- รายชื่อใหม่ --}}
                                           @elseif(!empty($m['instead']))
                                             <span class="dot dot-orange"></span>   {{-- ผู้มาแทน --}}
                                           @elseif(!empty($m['checkin']))
                                             <span class="dot dot-green"></span>    {{-- เช็คอินทั่วไป --}}
                                           @endif
                                        </span>
                                    </td>

                                    <td>Group {{ $m['group'] ?? 'A' }}</td>

                                    <td>
                                        <div class="fw-bold">{{ $m['name_th'] ?? '-' }}</div>
                                        <div class="text-muted">{{ $m['name_en'] ?? '' }}</div>
                                    </td>

                                    <td>{{ $m['department'] ?? '-' }}</td>

                                    {{-- ชีตไม่มีคอลัมน์ check-in ก็แสดง placeholder --}}
                                    <td id="checkin-cell-{{ $m['row'] }}">
                                        <div>
                                            {{ $m['checkin'] ? \Illuminate\Support\Str::of($m['checkin'])->beforeLast(' ') : '—' }}
                                        </div>
                                        <div class="text-muted">
                                            {{ $m['checkin'] ? \Illuminate\Support\Str::of($m['checkin'])->afterLast(' ') : '—' }}
                                        </div>
                                    </td>

                                    <td>{{ $m['test_drive'] ?? '-' }}</td>
                                    <td>{{ $m['car_display'] ?? '-' }}</td>
                                    <td>{{ $m['strategy'] ?? '-' }}</td>

                                    <td class="text-end">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light btn-sm btn-checkin"
                                                data-row="{{ $m['row'] }}" data-checkin="{{ $m['checkin'] }}"
                                                data-sheet="{{ $sheetName }}" {{-- << เพิ่ม --}}
                                                data-spreadsheet="{{ $spreadsheetId }}" {{-- << เพิ่ม --}}
                                                data-newmember="{{ (string) ($m['new_member'] ?? '') === '1' ? 1 : 0 }}"
                                                data-instead="{{ !empty($m['instead']) ? 1 : 0 }}"
                                                >
                                                {{ empty($m['checkin']) ? 'Check in' : 'ยกเลิก' }}
                                            </button>
                                            <button type="button"
                                                class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split"
                                                data-bs-toggle="dropdown"></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('toyota.instead.form', ['spreadsheetId'=>$spreadsheetId,'sheetName'=>$sheetName,'row'=>$m['row'],'Name' => $m['name_th'] ]) }}">
                                                        ผู้มาแทน
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('toyota.edit', ['spreadsheetId' => $spreadsheetId, 'sheetName' => $sheetName, 'row' => $m['row']]) }}">
                                                        แก้ไขข้อมูล
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-10">ไม่พบข้อมูล</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Footer: page size + pagination --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center p-5">
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted">แสดง</span>
                        <form method="GET">
                            @foreach (request()->except('per_page', 'page') as $k => $v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                            <select name="per_page" class="form-select form-select-sm w-120px"
                                onchange="this.form.submit()">
                                @foreach ([25, 50, 100, 150] as $n)
                                    <option value="{{ $n }}" @selected((int) request('per_page', 25) === $n)>{{ $n }}
                                        รายการ</option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted">หน้า
                            {{ method_exists($members, 'currentPage') ? $members->currentPage() : 1 }}
                            / {{ method_exists($members, 'lastPage') ? $members->lastPage() : 1 }}</span>
                        @if (method_exists($members, 'links'))
                            {{ $members->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.metronic') }}
                        @endif
                    </div>
                </div>
                <br><br>
                <a href="{{ url('logout') }}"
                    class="btn btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger me-2 mb-2">ออกจากระบบ</a>
                <br><br><br><br>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    {{-- เปิดใช้ DataTables ได้ถ้าต้องการ --}}
    {{-- <script> $('.table').DataTable({ searching:false, paging:false, info:false }); </script> --}}
    <script>
        function submitFilters() {
            const f = document.getElementById('filterForm');
            // รีเซ็ต page -> 1 ทุกครั้งที่เปลี่ยน filter
            const pg = f.querySelector('input[name="page"]');
            if (pg) pg.remove();
            f.submit();
        }
    </script>
    <script>
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.btn-checkin');
            if (!btn) return;

            const row = btn.dataset.row;
            const sheetName = btn.dataset.sheet || '';
            const spreadsheetId = btn.dataset.spreadsheet || '';

            btn.disabled = true;
            const originalText = btn.textContent.trim();

            try {
                const res = await fetch("{{ route('toyota.checkin.toggle') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        row,
                        sheetName,
                        spreadsheetId
                    })
                });

                // กันกรณี 4xx/5xx
                if (!res.ok) {
                    const t = await res.text().catch(() => '');
                    throw new Error(`HTTP ${res.status} ${t}`);
                }

                const data = await res.json();

                if (!data.ok) {
                    throw new Error(data.message || 'Update failed');
                }

                // =========================
                // อัปเดตจุดสี (รองรับทั้ง id เดิม dot-<row> และ status-dot-<row>)
                // =========================
                const dotWrapLegacy = document.getElementById(`dot-${row}`);
                if (dotWrapLegacy) {
                    dotWrapLegacy.innerHTML = data.checked ? '<span class="dot dot-green"></span>' : '';
                }

                const statusDot = document.getElementById(`status-dot-${row}`);
                if (statusDot) {
                    // statusDot.innerHTML = data.checked ? '<span class="dot dot-green"></span>' : '';
                      const isNew     = String(btn.dataset.newmember || '0') === '1';
                      const isInstead = String(btn.dataset.instead    || '0') === '1';
                      if (isNew) {
                        statusDot.innerHTML = '<span class="dot dot-navy"></span>';
                      } else if (isInstead) {
                        statusDot.innerHTML = '<span class="dot dot-orange"></span>';
                      } else {
                        statusDot.innerHTML = data.checked ? '<span class="dot dot-green"></span>' : '';
                      }
                    }

                // =========================
                // อัปเดตช่องวันที่/เวลา check-in (td)
                // ต้องมี <td id="checkin-cell-{{ $m['row'] }}">
                // =========================
                const cellDate = document.getElementById(`checkin-cell-${row}`);
                if (cellDate) {
                    if (data.checked && data.checkin) {
                        // data.checkin คาดรูปแบบ "YYYY-MM-DD HH:mm:ss" (จากเซิร์ฟเวอร์)
                        // เผื่อกรณีได้ ISO "YYYY-MM-DDTHH:mm:ss" ให้แทนที่ 'T' ด้วยช่องว่าง
                        const stamp = String(data.checkin).replace('T', ' ').trim();
                        const parts = stamp.split(' ');
                        const date = parts[0] || '—';
                        const time = (parts[1] || '—').replace(/\.\d+Z?$/, ''); // ตัด .ms หรือ Z ถ้ามี
                        cellDate.innerHTML = `
          <div>${date}</div>
          <div class="text-muted">${time}</div>
        `;
                    } else {
                        cellDate.innerHTML = `
          <div>—</div>
          <div class="text-muted">—</div>
        `;
                    }
                }

                // =========================
                // เปลี่ยนข้อความปุ่ม
                // =========================
                btn.dataset.checkin = data.checked ? (data.checkin || '') : '';
                btn.textContent = data.checked ? 'ยกเลิก' : 'Check in';

            } catch (err) {
                console.error(err);
                alert('ไม่สามารถบันทึก Check-in ได้: ' + (err.message || ''));
                // rollback ข้อความปุ่ม
                btn.textContent = originalText;
            } finally {
                btn.disabled = false;
            }
        });
    </script>
@endsection
