<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheet;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ToyataController extends Controller
{
    //
    protected $googleSheet;

    public function __construct(GoogleSheet $googleSheet)
    {
        $this->googleSheet = $googleSheet;
    }

    // ค่าคงที่ชีตเดียวกับหน้า dashboard
    private string $spreadsheetId = '1RJngja-8UUhudo161oGVvb8s4Vn4Vw-tECbSEx02lPc';
    private string $sheetName     = 'mock up name list';

    // ตารางเวลาเดียวกับหน้าแก้ไข
    private array $slotTest = [
        'A'=>'9.40 - 10.30','B'=>'10.35 - 11.25','C'=>'11.30 - 12.20',
        'D'=>'14.00 - 14.50','E'=>'14.55 - 15.45','F'=>'15.50 - 16.40',
    ];
    private array $slotCar = [
        'A'=>'10.35 - 11.25','B'=>'11.30 - 12.20','C'=>'9.40 - 10.30',
        'D'=>'14.55 - 15.45','E'=>'15.50 - 16.40','F'=>'14.00 - 14.50',
    ];
    private array $slotStrategy = [
        'A'=>'11.30 - 12.20','B'=>'9.40 - 10.30','C'=>'10.35 - 11.25',
        'D'=>'15.50 - 16.40','E'=>'14.00 - 14.50','F'=>'14.55 - 15.45',
    ];


    public function checkIn(Request $request): JsonResponse
    {
        $request->validate([
            'row' => 'required|integer|min:2',   // ต้องมากกว่า header
        ]);

        $spreadsheetId = '1RJngja-8UUhudo161oGVvb8s4Vn4Vw-tECbSEx02lPc';
        $sheetName     = 'mock up name list';
        $row           = (int) $request->input('row');

        // คอลัมน์ J = 10 → A1 notation: {sheet}!J{row}
        $cell = $sheetName . '!J' . $row;

        // เวลาไทย
        date_default_timezone_set('Asia/Bangkok');
        $stamp = date('d/m/Y H:i');

        try {
            $this->googleSheet->updateCell($spreadsheetId, $cell, $stamp);
            return response()->json([
                'ok' => true,
                'display' => $stamp,
            ]);
        } catch (\Throwable $e) {
            \Log::error($e);
            return response()->json(['ok'=>false,'message'=>'Update failed'], 500);
        }
    }


    public function toggleCheckin(Request $request): JsonResponse
        {
            $validated = $request->validate([
                'row'           => ['required','integer','min:2'],
                'sheetName'     => ['required','string'],
                'spreadsheetId' => ['required','string'],
            ]);

            $row = (int) $validated['row'];
            $sheetName = $validated['sheetName'];
            $spreadsheetId = $validated['spreadsheetId'];

            /** @var GoogleSheet $gs */
            $gs = app(GoogleSheet::class);

            try {
                // อ่านค่าปัจจุบันจาก E{row}
                $current = $gs->getCellValue($spreadsheetId, $sheetName, $row, 'J');

                // เตรียม A1 notation ให้ updateCell (quote sheet name เผื่อมีช่องว่าง)
                $sheetQuoted = (new \ReflectionClass($gs))->getMethod('quoteSheetName');
                $sheetQuoted->setAccessible(true);
                $sheet = $sheetQuoted->invoke($gs, $sheetName); // 'Sheet Name' หากจำเป็น
                $cell = "{$sheet}!J{$row}";

                if (!empty($current)) {
                    // undo → ล้างค่า
                    $gs->updateCell($spreadsheetId, $cell, '', 'RAW');
                    return response()->json(['ok' => true, 'checked' => false]);
                } else {
                    // check-in → ใส่ timestamp
                    $stamp = Carbon::now('Asia/Bangkok')->format('Y-m-d H:i:s');
                    $gs->updateCell($spreadsheetId, $cell, $stamp, 'USER_ENTERED');
                    return response()->json(['ok' => true, 'checked' => true, 'checkin' => $stamp]);
                }
            } catch (\Throwable $e) {
                Log::error('toggleCheckin failed', [
                    'row' => $row, 'sheet' => $sheetName, 'spreadsheet' => $spreadsheetId,
                    'err' => $e->getMessage(),
                ]);
                // ชั่วคราวโชว์ข้อความจริงเพื่อดีบัก
                return response()->json(['ok' => false, 'message' => $e->getMessage()], 500);
            }
        }

        // ====== stubs / ตัวอย่าง ======
        private function getSheetValue(string $spreadsheetId, string $range): ?string
        {
            // TODO: แทนที่ด้วยการเรียก Google Sheets API จริง
            // return app('GoogleSheetsService')->getValue($spreadsheetId, $range);
            return null;
        }

        private function updateSheetValue(string $spreadsheetId, string $range, string $value): void
        {
            // TODO: แทนที่ด้วยการเรียก Google Sheets API จริง
            // app('GoogleSheetsService')->updateValue($spreadsheetId, $range, $value);
        }

    public function index(Request $request)
    {
        $spreadsheetId = '1RJngja-8UUhudo161oGVvb8s4Vn4Vw-tECbSEx02lPc';
        $sheetName     = 'mock up name list';   // ใช้ชื่อนี้ทำ A1 notation
        $range         = $sheetName;

        $rows = $this->googleSheet->getSheetData($spreadsheetId, $range) ?? [];
        if (empty($rows)) {
            return view('admin.dashboard.index', [
                'members'     => new LengthAwarePaginator([], 0, 25),
                'stats'       => [],
                'totals'      => ['checkin_all' => 0],
                'groups'      => ['A','B','C','D','E','F'],
                'suggestions' => collect(),
            ]);
        }

        // ---- หา header
        $headerIdx = null;
        $expected  = [
            'no'          => ['no','หมายเลข','no.'],
            'badge'       => ['badge'],
            'group'       => ['group'],
            'name_th'     => ['name (th)','ชื่อ (th)','ชื่อ-นามสกุล','name th'],
            'name_en'     => ['name (en)','name en'],
            'department'  => ['department'],
            'checkin'     => ['check-in','check in','checkin'],   // คอลัมน์เวลาเช็คอิน
            'test_drive'  => ['test drive','testdrive'],
            'car_display' => ['car display','cardisplay'],
            'strategy'    => ['strategy sharing','strategy','strategy sharing time'],
        ];

        foreach ($rows as $i => $r) {
            $line = array_map(fn($v)=>mb_strtolower(trim((string)$v)), $r);
            $hits = 0;
            foreach ($expected as $alts) {
                foreach ($alts as $w) {
                    if (in_array($w, $line, true)) { $hits++; break; }
                }
            }
            if ($hits >= 4) { $headerIdx = $i; break; }
        }
        $headerIdx = $headerIdx ?? 0;

        $headers  = array_map(fn($v)=>trim((string)$v), $rows[$headerIdx] ?? []);
        $headersL = array_map(fn($h)=>mb_strtolower($h), $headers);
        $dataRows = array_slice($rows, $headerIdx + 1);

        // helper หา index จากชื่อหัวคอลัมน์
        $pick = function(array $row, array $keys) use ($headersL) {
            foreach ($keys as $k) {
                $idx = array_search($k, $headersL, true);
                if ($idx !== false) return $row[$idx] ?? null;
            }
            return null;
        };

        // index คอลัมน์แทน (เพื่ออ่านผู้มาแทน)
        $COL_L = 11; // Name (TH) ผู้มาแทน
        $COL_M = 12; // Name (EN) ผู้มาแทน
        $COL_N = 13; // Note ผู้มาแทน

        // ---- map เป็น ALL MEMBERS + เก็บเบอร์แถวจริงของชีต
        $allMembers = collect($dataRows)
            ->filter(fn($r)=>collect($r)->filter(fn($v)=>trim((string)$v) !== '')->isNotEmpty())
            ->values()
            ->map(function($r, $i) use ($pick, $expected, $headerIdx, $COL_L, $COL_M, $COL_N) {
                $sheetRow = $headerIdx + 2 + $i; // 1-based + header อีก 1 แถว
                return [
                    'row'         => $sheetRow,
                    'no'          => (int)($pick($r, $expected['no']) ?: $i + 1),
                    'badge'       => (string)($pick($r, $expected['badge']) ?: ''),
                    'group'       => strtoupper(trim((string)($pick($r, $expected['group']) ?: ''))),
                    'name_th'     => (string)($pick($r, $expected['name_th']) ?: ''),
                    'name_en'     => (string)($pick($r, $expected['name_en']) ?: ''),
                    'department'  => (string)($pick($r, $expected['department']) ?: ''),
                    'checkin'     => (string)($pick($r, $expected['checkin']) ?: ''),
                    'test_drive'  => (string)($pick($r, $expected['test_drive']) ?: ''),
                    'car_display' => (string)($pick($r, $expected['car_display']) ?: ''),
                    'strategy'    => (string)($pick($r, $expected['strategy']) ?: ''),
                    'new_member'  => (string)($pick($r, ['newmember_status','new_member_status']) ?: ''),
                    'instead_th'   => (string)($r[$COL_L] ?? ''),
                    'instead_en'   => (string)($r[$COL_M] ?? ''),
                    'instead_note' => (string)($r[$COL_N] ?? ''),
                    'instead'      => !empty($r[$COL_L]) || !empty($r[$COL_M]) || !empty($r[$COL_N]),
                ];
            });

        // ---- cards summary
        $groups = ['A','B','C','D','E','F'];



        $stats = [];
        foreach ($groups as $g) {
            // นับเฉพาะคนที่อยู่ในกลุ่มนี้ + มีค่า checkin ไม่ว่าง
            $stats["group_{$g}"] = $allMembers
                ->where('group', $g)
                ->filter(fn($m) => !empty($m['checkin']))
                ->count();
        }

        $normalizeGroup = function($g) {
            $g = trim((string)$g);
            return strtoupper($g);
        };

        // คนที่ไม่มีกลุ่ม (group ว่าง หรือ "NO GROUP")
        $normalizeGroup = function($g) {
            return strtoupper(trim((string)$g));
        };

        $stats['no_group_total'] = $allMembers
            ->filter(function($m) use ($normalizeGroup) {
                $g = $normalizeGroup($m['group']);
                return $g === 'NO GROUP' && !empty($m['checkin']);
            })
            ->count();

        // กรองเฉพาะที่เช็คอินแล้ว (ใช้ซ้ำ)
        $checked = $allMembers->filter(fn($m) => !empty($m['checkin']));

        // $stats['external_morning']   = $checked->whereIn('group', ['A','B','C'])->count();
        // $stats['external_afternoon'] = $checked->whereIn('group', ['D','E','F'])->count();

        $totals = ['checkin_all' => $checked->count()];

        // ---- suggestions
        $suggestions = $allMembers
            ->flatMap(fn($m)=>array_filter([$m['name_th'],$m['name_en'],$m['department']]))
            ->unique()
            ->values()
            ->take(300);

        // ---- filters (q, badge, group/status)
        $filtered = $allMembers;

        if ($q = trim((string)$request->input('q'))) {
            $qLower = mb_strtolower($q);
            $filtered = $filtered->filter(fn($m)=>
                str_contains(mb_strtolower($m['name_th']), $qLower) ||
                str_contains(mb_strtolower($m['name_en']), $qLower) ||
                str_contains(mb_strtolower($m['department']), $qLower)
            )->values();
        }

        if ($badge = trim((string)$request->input('badge'))) {
            $filtered = $filtered->where('badge', $badge)->values();
        }

        $status = $request->input('status'); // '', 'checked', 'not_checked', 'newMember', 'instead'
        if ($status === 'checked') {
            $filtered = $filtered->filter(function($m){
                $hasCheckin = !empty($m['checkin']);
                $isNew      = (string)($m['new_member'] ?? '') === '1';
                return $hasCheckin && !$isNew;
            })->values();

        } elseif ($status === 'not_checked') {
            $filtered = $filtered->filter(fn($m) => empty($m['checkin']))->values();

        } elseif ($status === 'newMember') {
            $filtered = $filtered->filter(function($m){
                $isNew      = (string)($m['new_member'] ?? '') === '1';
                return $isNew;
            })->values();

        } elseif ($status === 'instead') {
            $filtered = $filtered->filter(fn($m) => !empty($m['instead']))->values();
        }

        // ---- sorting (ค่าเริ่มต้น = ตามเวลาเช็คอิน ล่าสุดก่อน)
        $sortParam = $request->input('sort');      // ถ้าไม่ส่งมา ให้ default = checkin
        $sortMode  = $sortParam ?: 'checkin';

        // แปลงค่า checkin เป็น timestamp อย่างยืดหยุ่น
        $getTs = function ($m) {
            $v = trim((string)($m['checkin'] ?? ''));
            if ($v === '') return 0;
            // รองรับ "YYYY-mm-dd HH:ii:ss", "d/m/Y H:i", หรือเป็นตัวเลข timestamp อยู่แล้ว
            $normalized = preg_match('#\d{1,2}/\d{1,2}/\d{2,4}#', $v) ? str_replace('/', '-', $v) : $v;
            $ts = is_numeric($v) ? (int)$v : strtotime($normalized);
            return $ts ?: 0;
        };

        if ($sortMode === 'checkin') {
            // เรียงตามเวลาเช็คอิน (ล่าสุดก่อน) — คนที่ยังไม่เช็คอินจะถูกจัดท้ายสุดโดยอัตโนมัติ (ts=0)
            $filtered = $filtered->sortByDesc(fn($m) => $getTs($m))->values();
        } else {
            // ตกกลับไปใช้การเรียงตามชื่อแบบเดิม (new/old)
            $thaiKey = function (string $s): string {
                $s = mb_strtolower($s, 'UTF-8');
                if (preg_match('/^([เแโใไ])([ก-ฮ])(.*)$/u', $s, $m)) {
                    $s = $m[2] . $m[1] . $m[3];
                }
                $s = preg_replace('/[\x{0E31}\x{0E34}-\x{0E3A}\x{0E47}-\x{0E4E}]/u', '', $s);
                $s = preg_replace('/[\s\-]+/u', '', $s);
                return $s;
            };
            $order = $sortParam ?: 'new'; // 'new' = ก-ฮ, 'old' = ฮ-ก
            $filtered = $filtered->sort(function ($a, $b) use ($thaiKey, $order) {
                $ka = $thaiKey((string)($a['name_th'] ?? ''));
                $kb = $thaiKey((string)($b['name_th'] ?? ''));
                $res = strcmp($ka, $kb);
                return $order === 'old' ? -$res : $res;
            })->values();
        }

        // --- pagination
        $perPage = (int) $request->input('per_page', 25);
        $page    = LengthAwarePaginator::resolveCurrentPage('page');

        $items = $filtered->forPage($page, $perPage)->values();

        $paginated = new LengthAwarePaginator(
            $items,
            $filtered->count(),
            $perPage,
            $page,
            [
                'path'     => $request->url(),
                'pageName' => 'page',
            ]
        );
        $paginated->appends($request->except('page'));

        // นับเฉพาะเช็คอินและมีกลุ่ม A-F
        $checkedCount = $allMembers
            ->filter(fn($m) =>
                !empty($m['checkin'])
            )
            ->count();
        $notCheckedCount = $allMembers->count() - $checkedCount;


        $insteadChecked = $allMembers->filter(function ($m) {
        // ต้องมีเช็คอิน และคอลัมน์ L (instead_th) ไม่ว่าง
        return !empty($m['checkin']) && !empty($m['new_member']);
    });

    // แยกตามรอบเวลา
    $stats['instead_morning']   = $insteadChecked->whereIn('group', ['A','B','C'])->count();
    $stats['instead_afternoon'] = $insteadChecked->whereIn('group', ['D','E','F'])->count();


    // helper: ปกติให้ group เป็นตัวพิมพ์ใหญ่ ตัดช่องว่าง
    $normalizeGroup = function($g) {
        return strtoupper(trim((string)$g));
    };

    // helper: แปลงค่า checkin เป็น "ชั่วโมง 0-23"
    // รองรับทั้ง string datetime และ Excel/Sheets serial number
    $checkinHour = function($val) {
        if ($val === null || $val === '') return null;

        if (is_numeric($val)) {
            // Excel serial → UNIX
            $unix = ((float)$val - 25569) * 86400;  // origin 1899-12-30
        } else {
            $unix = strtotime((string)$val);
            if ($unix === false) return null;
        }

        // ปรับ timezone ให้ตรงตามระบบที่ใช้บันทึก (เช่น Asia/Bangkok)
        $dt = new \DateTime("@{$unix}");
        $dt->setTimezone(new \DateTimeZone('Asia/Bangkok'));
        return (int)$dt->format('H');
    };

    
    // กรอง "ไม่มีกลุ่ม"
    $noGroup = $allMembers->filter(function ($m) use ($normalizeGroup) {
        $g = $normalizeGroup($m['group']);
        return $g === '' || $g === 'NO GROUP' || $g === 'No Group';
    });

    // นับตามช่วงเวลา (ยึด checkin)
    $stats['no_group_morning'] = $noGroup
        ->filter(function ($m) use ($checkinHour) {
            $h = $checkinHour($m['checkin'] ?? null);
            return $h !== null && $h < 12;       // ก่อน 12:00
        })
        ->count();

    $stats['no_group_afternoon'] = $noGroup
        ->filter(function ($m) use ($checkinHour) {
            $h = $checkinHour($m['checkin'] ?? null);
            return $h !== null && $h >= 12;      // ตั้งแต่ 12:00 ขึ้นไป
        })
        ->count();


        // ✅ external_morning = กลุ่ม A,B,C + ไม่มีกลุ่มที่เช็คอินก่อนเที่ยง
$stats['external_morning'] = $checked->filter(function($m) use ($checkinHour) {
    if (in_array($m['group'], ['A','B','C'], true)) {
        return true;
    }
    // ถ้าไม่มีกลุ่ม
    if (in_array(strtoupper(trim($m['group'])), ['', 'NO GROUP', 'ไม่มีกลุ่ม'], true)) {
        $h = $checkinHour($m['checkin'] ?? null);
        return $h !== null && $h < 12;
    }
    return false;
})->count();

// ✅ external_afternoon = กลุ่ม D,E,F + ไม่มีกลุ่มที่เช็คอินตอนบ่าย
$stats['external_afternoon'] = $checked->filter(function($m) use ($checkinHour) {
    if (in_array($m['group'], ['D','E','F'], true)) {
        return true;
    }
    // ถ้าไม่มีกลุ่ม
    if (in_array(strtoupper(trim($m['group'])), ['', 'NO GROUP', 'ไม่มีกลุ่ม'], true)) {
        $h = $checkinHour($m['checkin'] ?? null);
        return $h !== null && $h >= 12;
    }
    return false;
})->count();

        return view('admin.dashboard.index', [
            'members'        => $paginated,
            'stats'          => $stats,
            'totals'         => $totals,
            'groups'         => $groups,
            'suggestions'    => $suggestions,
            'sheetName'      => $sheetName,
            'spreadsheetId'  => $spreadsheetId,
            'checkedCount'   => $checkedCount,
            'notCheckedCount'=> $notCheckedCount,
        ]);
    }



    public function create()
    {
        return view('admin.dashboard.create', [
            'sheetName'     => $this->sheetName,
            'spreadsheetId' => $this->spreadsheetId,
            'slotTest'      => $this->slotTest,
            // default fields (ให้โค้ด Blade reuse ง่าย)
            'fields' => [
                'name_th'    => '',
                'name_en'    => '',
                'dept'       => '',
                'badge'      => 'Dealer',
                'group'      => '',
                'testdrive'  => '',
                'cardisplay' => '',
                'strategy'   => '',
                'checkin'    => '',
            ],
        ]);
    }


    public function store(Request $request)
    {
        $v = $request->validate([
            'name_th'    => ['required','string'],
            'name_en'    => ['nullable','string'],
            'dept'       => ['nullable','string'],
            'badge'      => ['nullable','string'],
            'group'      => ['nullable','string'],
            'testdrive'  => ['nullable','string'],
            'cardisplay' => ['nullable','string'],
            'strategy'   => ['nullable','string'],
        ]);

        // $test     = $this->slotTest[$v['group']]     ?? '';
        // $car      = $this->slotCar[$v['group']]      ?? '';
        // $strategy = $this->slotStrategy[$v['group']] ?? '';

       $group    = $v['group']      ?? '';     // เดิมอาจเป็น null
        $test     = $v['testdrive']  ?? '';
        $car      = $v['cardisplay'] ?? '';
        $strategy = $v['strategy']   ?? '';

        $stamp = Carbon::now('Asia/Bangkok')->format('Y-m-d H:i:s');

       // dd($stamp)

        $rowData = [
            '',                      // A
            $v['badge']   ?? '',     // B
            $group,                  // C
            $v['name_th'] ?? '',     // D
            $v['name_en'] ?? '',     // E
            $v['dept']    ?? '',     // F
            $test,                   // G
            $car,                    // H
            $strategy,               // I
            "'".$stamp,                // J
            1,                       // K
        ];


        try {
            // ใช้เมธอด append แบบช่วงกว้าง (ดูข้อ 2)
            $this->googleSheet->appendRowFlexible($this->spreadsheetId, $this->sheetName, $rowData);
            return redirect()->route('dashboard.index')->with('status', 'เพิ่มผู้เข้าร่วมงานสำเร็จ');
        } catch (\Throwable $e) {
            \Log::error('storeMember failed', ['e'=>$e->getMessage()]);
            return back()->withErrors(['store' => 'บันทึกไม่สำเร็จ: '.$e->getMessage()])->withInput();
        }
    }




    public function edit(Request $request)
{
    $validated = $request->validate([
        'row'           => ['required','integer','min:2'],
        'sheetName'     => ['required','string'],
        'spreadsheetId' => ['required','string'],
    ]);

    $row           = (int) $validated['row'];
    $sheetName     = $validated['sheetName'];
    $spreadsheetId = $validated['spreadsheetId'];

    /** @var GoogleSheet $gs */
    $gs = app(\App\Services\GoogleSheet::class);

    // เผื่อชื่อชีตมีช่องว่าง/อักขระพิเศษ
    $sheet = preg_match('/[^A-Za-z0-9_]/', $sheetName)
        ? "'".str_replace("'", "''", $sheetName)."'"
        : $sheetName;

    // ✅ ดึง A..N ของแถวนั้น (รวม J=Check-in, K=newMember_status, L/M/N=ผู้มาแทน)
    $range  = "{$sheet}!A{$row}:N{$row}";
    $values = $gs->getSheetData($spreadsheetId, $range) ?? [[]];

    $fields = $this->rowToFields($values[0] ?? []);

    return view('admin.dashboard.edit', compact('fields', 'row', 'sheetName', 'spreadsheetId'));
}

/**
 * แปลง array ของค่าทั้งแถว (A..N) เป็น fields ที่ view ใช้
 * Index: A=0,B=1,..., J=9, K=10, L=11, M=12, N=13
 */
private function rowToFields(array $r): array
{
    return [
        'no'          => (string)($r[0]  ?? ''),
        'badge'       => (string)($r[1]  ?? ''),
        'group'       => (string)($r[2]  ?? ''),
        'name_th'     => (string)($r[3]  ?? ''), // D
        'name_en'     => (string)($r[4]  ?? ''), // E
        'dept'        => (string)($r[5]  ?? ''), // F
        'testdrive'   => (string)($r[6]  ?? ''), // G
        'cardisplay'  => (string)($r[7]  ?? ''), // H
        'strategy'    => (string)($r[8]  ?? ''), // I
        'checkin'     => (string)($r[9]  ?? ''), // J
        'new_member'  => (string)($r[10] ?? ''), // K = newMember_status

        // ✅ ผู้มาแทน
        'instead_th'   => (string)($r[11] ?? ''), // L
        'instead_en'   => (string)($r[12] ?? ''), // M
        'instead_note' => (string)($r[13] ?? ''), // N
    ];
}

   public function update(Request $request)
    {
        $validated = $request->validate([
            'row'           => ['required','integer','min:2'],
            'sheetName'     => ['required','string'],
            'spreadsheetId' => ['required','string'],
            'badge'         => ['nullable','string'],
            'group'         => ['nullable','string'],
            'name_th'       => ['nullable','string'],
            'name_en'       => ['nullable','string'],
            'dept'          => ['nullable','string'],
            'cardisplay'    => ['nullable','string'],
            'strategy'      => ['nullable','string'],
            'testdrive'     => ['nullable','string'],

            // ผู้มาแทน
            'instead_th'    => ['nullable','string'],
            'instead_en'    => ['nullable','string'],
            'instead_note'  => ['nullable','string'],
            'clear_instead' => ['nullable','in:1'],
        ]);

        // ตารางเวลาอ้างอิงตาม Group
        $slotTest = [
            'A'=>'9.40 - 10.30','B'=>'10.35 - 11.25','C'=>'11.30 - 12.20',
            'D'=>'14.00 - 14.50','E'=>'14.55 - 15.45','F'=>'15.50 - 16.40',
        ];
        $slotCar = [
            'A'=>'10.35 - 11.25','B'=>'11.30 - 12.20','C'=>'9.40 - 10.30',
            'D'=>'14.55 - 15.45','E'=>'15.50 - 16.40','F'=>'14.00 - 14.50',
        ];
        $slotStrategy = [
            'A'=>'11.30 - 12.20','B'=>'9.40 - 10.30','C'=>'10.35 - 11.25',
            'D'=>'15.50 - 16.40','E'=>'14.00 - 14.50','F'=>'14.55 - 15.45',
        ];

        // Override 3 ช่องเวลาให้ตรงตาม Group เสมอ
        // $validated['testdrive']  = $slotTest[$validated['group']] ?? '';
        // $validated['cardisplay'] = $slotCar[$validated['group']] ?? '';
        // $validated['strategy']   = $slotStrategy[$validated['group']] ?? '';

        /** @var \App\Services\GoogleSheet $gs */
        $gs = app(\App\Services\GoogleSheet::class);
        $row           = (int) $validated['row'];
        $sheetName     = $validated['sheetName'];
        $spreadsheetId = $validated['spreadsheetId'];
        $sheet = preg_match('/[^A-Za-z0-9_]/', $sheetName)
            ? "'".str_replace("'", "''", $sheetName)."'"
            : $sheetName;

        // แมพคอลัมน์หลัก
        $mapCols = [
            'badge'     => 'B',
            'group'     => 'C',
            'name_th'   => 'D',
            'name_en'   => 'E',
            'dept'      => 'F',
            'testdrive' => 'G',
            'cardisplay'=> 'H',
            'strategy'  => 'I',
        ];

        try {
            // เขียนคอลัมน์หลัก
            foreach ($mapCols as $field => $col) {
                $cell = "{$sheet}!{$col}{$row}";
                $gs->updateCell($spreadsheetId, $cell, (string)($validated[$field] ?? ''), 'USER_ENTERED');
            }

            // ===== ผู้มาแทน: L / M / N =====
            if ($request->boolean('clear_instead')) {
                // เคลียร์ข้อมูลผู้มาแทนทั้งหมด
                $gs->updateCell($spreadsheetId, "{$sheet}!L{$row}", '', 'USER_ENTERED');
                $gs->updateCell($spreadsheetId, "{$sheet}!M{$row}", '', 'USER_ENTERED');
                $gs->updateCell($spreadsheetId, "{$sheet}!N{$row}", '', 'USER_ENTERED');
            } else {
                $gs->updateCell($spreadsheetId, "{$sheet}!L{$row}", (string)$request->input('instead_th', ''),   'USER_ENTERED');
                $gs->updateCell($spreadsheetId, "{$sheet}!M{$row}", (string)$request->input('instead_en', ''),   'USER_ENTERED');
                $gs->updateCell($spreadsheetId, "{$sheet}!N{$row}", (string)$request->input('instead_note', ''), 'USER_ENTERED');
            }

            // ✅ เช็คอินด้วย (เขียนเวลาลงคอลัมน์ J)
            // $gs->updateCell(
            //     $spreadsheetId,
            //     "{$sheet}!J{$row}",
            //     now('Asia/Bangkok')->format('Y-m-d H:i:s'),
            //     'USER_ENTERED'
            // );

            return redirect()
                ->route('dashboard.index', ['spreadsheetId'=>$spreadsheetId,'sheetName'=>$sheetName,'row'=>$row])
                ->with('status', 'บันทึกข้อมูลสำเร็จ');
        } catch (\Throwable $e) {
            \Log::error('update row failed', ['row'=>$row,'sheet'=>$sheetName,'e'=>$e->getMessage()]);
            return back()->withErrors(['update' => 'บันทึกไม่สำเร็จ: '.$e->getMessage()]);
        }
    }


    public function insteadForm(
            GoogleSheet $gs,
            string $spreadsheetId,
            string $sheetName,
            int $row,
            string $Name // ยังรับไว้ได้ เผื่อใช้เทียบ/โชว์
        ) {
            // อ่านช่วง A..K เฉพาะแถวที่สนใจ
            $range = $sheetName.'!A'.$row.':K'.$row;
            $values = $gs->getSheetData($spreadsheetId, $range);

            // เผื่อคอลัมน์ว่าง ให้ pad ให้ครบ 11 คอลัมน์
            $rowValues = array_pad($values[0] ?? [], 11, '');

            // map เป็น key ชัด ๆ เพื่อใช้ใน blade
            $cols = [
                'no','badge','group','name_th','name_en','dept',
                'testdrive','cardisplay','strategy','checkin','newMember_status'
            ];
            $member = array_combine($cols, $rowValues);

            return view('admin.dashboard.instead', compact(
                'spreadsheetId','sheetName','row','Name','member'
            ));
        }

    public function insteadStore(Request $request)
    {
        $v = $request->validate([
            'spreadsheetId' => ['required','string'],
            'sheetName'     => ['required','string'],
            'row'           => ['required','integer','min:2'],
            'name_th'       => ['required','string'],
            'name_en'       => ['nullable','string'],
            'note'          => ['nullable','string'],
        ]);

        $row           = (int)$v['row'];
        $spreadsheetId = $v['spreadsheetId'];
        $sheetName     = $v['sheetName'];

        // ใส่ quote ให้ชื่อชีตถ้าจำเป็น
        $sheet = preg_match('/[^A-Za-z0-9_]/', $sheetName)
            ? "'".str_replace("'", "''", $sheetName)."'"
            : $sheetName;

        try {
            // 1) เขียนข้อมูลผู้มาแทนลง L/M/N
            $this->googleSheet->updateCell($spreadsheetId, "{$sheet}!L{$row}", (string)$v['name_th'], 'USER_ENTERED');
            $this->googleSheet->updateCell($spreadsheetId, "{$sheet}!M{$row}", (string)($v['name_en'] ?? ''), 'USER_ENTERED');
            $this->googleSheet->updateCell($spreadsheetId, "{$sheet}!N{$row}", (string)($v['note'] ?? ''), 'USER_ENTERED');

            // 2) เช็คอินทันที (ใส่เวลา Asia/Bangkok ลงคอลัมน์ J)
            $stamp = Carbon::now('Asia/Bangkok')->format('Y-m-d H:i:s');
            $this->googleSheet->updateCell($spreadsheetId, "{$sheet}!J{$row}", $stamp, 'USER_ENTERED');

            // return redirect()->route('dashboard.index')->with('status','บันทึกผู้มาแทนและเช็คอินเรียบร้อย');

            return redirect()
    ->route('toyota.edit', [
        'row'           => $row,
        'sheetName'     => $sheetName,
        'spreadsheetId' => $spreadsheetId,
    ])
    ->with('status','บันทึกผู้มาแทนและเช็คอินเรียบร้อย');
        } catch (\Throwable $e) {
            Log::error('insteadStore failed', ['err'=>$e->getMessage(),'row'=>$row,'sheet'=>$sheetName]);
            return back()->withErrors(['store' => 'บันทึกไม่สำเร็จ: '.$e->getMessage()])->withInput();
        }
    }


}
