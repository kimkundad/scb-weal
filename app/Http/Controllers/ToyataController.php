<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheet;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ToyataController extends Controller
{
    //
    protected $googleSheet;

    public function __construct(GoogleSheet $googleSheet)
    {
        $this->googleSheet = $googleSheet;
    }

public function index(Request $request)
{
    // 0) ชี้ชีต
    $spreadsheetId = '1RJngja-8UUhudo161oGVvb8s4Vn4Vw-tECbSEx02lPc';
    $range         = 'mock up name list';

    // 1) โหลดข้อมูลดิบจาก Google Sheets
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

    // 2) หาหัวตารางอัตโนมัติ
    $headerIdx = null;
    $expected  = [
        'no'          => ['no','หมายเลข','no.'],
        'badge'       => ['badge'],
        'group'       => ['group'],
        'name_th'     => ['name (th)','ชื่อ (th)','ชื่อ-นามสกุล','name th'],
        'name_en'     => ['name (en)','name en'],
        'department'  => ['department'],
        'test_drive'  => ['test drive','testdrive'],
        'car_display' => ['car display','cardisplay'],
        'strategy'    => ['strategy sharing','strategy','strategy sharing time'],
    ];
    foreach ($rows as $i => $r) {
        $line = array_map(fn($v) => mb_strtolower(trim((string)$v)), $r);
        $hits = 0;
        foreach ($expected as $alts) {
            foreach ($alts as $word) {
                if (in_array($word, $line, true)) { $hits++; break; }
            }
        }
        if ($hits >= 4) { $headerIdx = $i; break; }
    }
    $headerIdx = $headerIdx ?? 0;

    $headers  = array_map(fn($v)=>trim((string)$v), $rows[$headerIdx] ?? []);
    $headersL = array_map(fn($h)=>mb_strtolower($h), $headers);
    $dataRows = array_slice($rows, $headerIdx + 1);

    // helper: หาค่าโดยชื่อคอลัมน์ (ไม่สนตัวพิมพ์)
    $pick = function(array $row, array $keys) use ($headersL) {
        foreach ($keys as $k) {
            $idx = array_search($k, $headersL, true);
            if ($idx !== false) return $row[$idx] ?? null;
        }
        return null;
    };

    // 3) map เป็น collection ของสมาชิกทั้งหมด (ALL MEMBERS)
    $allMembers = collect($dataRows)
        ->filter(fn($r) => collect($r)->filter(fn($v)=>trim((string)$v) !== '')->isNotEmpty())
        ->values()
        ->map(function($r, $i) use ($pick, $expected) {
            return [
                'no'          => (int)($pick($r, $expected['no']) ?: $i + 1),
                'badge'       => (string)($pick($r, $expected['badge']) ?: ''),
                'group'       => (string)($pick($r, $expected['group']) ?: ''), // A/B/C/...
                'name_th'     => (string)($pick($r, $expected['name_th']) ?: ''),
                'name_en'     => (string)($pick($r, $expected['name_en']) ?: ''),
                'department'  => (string)($pick($r, $expected['department']) ?: ''),
                'test_drive'  => (string)($pick($r, $expected['test_drive']) ?: ''),
                'car_display' => (string)($pick($r, $expected['car_display']) ?: ''),
                'strategy'    => (string)($pick($r, $expected['strategy']) ?: ''),
            ];
        });

    // 4) การ์ดสรุป (คงที่ — ใช้จาก ALL MEMBERS เสมอ)
    $groups = ['A','B','C','D','E','F'];
    $stats  = [];
    foreach ($groups as $g) {
        $stats["group_{$g}"] = $allMembers->where('group', $g)->count();
    }
    $stats['external_morning']   = ($stats['group_A'] ?? 0) + ($stats['group_B'] ?? 0) + ($stats['group_C'] ?? 0);
    $stats['external_afternoon'] = ($stats['group_D'] ?? 0) + ($stats['group_E'] ?? 0) + ($stats['group_F'] ?? 0);

    $totals = ['checkin_all' => $allMembers->count()];

    // 5) สร้างคำแนะนำ (autocomplete) จาก ALL MEMBERS
    $suggestions = $allMembers
        ->flatMap(fn($m) => array_filter([$m['name_th'] ?? null, $m['name_en'] ?? null, $m['department'] ?? null]))
        ->unique()
        ->values()
        ->take(300);

    // 6) กรอง TABLE เฉพาะตามคำค้นหา/ตัวกรอง (ไม่กระทบ stats/totals)
    $filtered = $allMembers;

    // คำค้นหา (ไทย/อังกฤษ/แผนก)
    if ($q = trim((string)$request->input('q'))) {
        $qLower = mb_strtolower($q);
        $filtered = $filtered->filter(function ($m) use ($qLower) {
            return str_contains(mb_strtolower($m['name_th']), $qLower)
                || str_contains(mb_strtolower($m['name_en']), $qLower)
                || str_contains(mb_strtolower($m['department']), $qLower);
        })->values();
    }

    // ตัวกรอง Badge
    $badge = trim((string)$request->input('badge', ''));
    if ($badge !== '') {
        $filtered = $filtered->where('badge', $badge)->values();
    }

    // เรียง ก–ฮ / ฮ–ก  (ใช้ชื่อไทยก่อน ถ้าไม่มีใช้อังกฤษ แล้วค่อย department)
    $keyFn = fn($m) => mb_strtolower(
        trim($m['name_th'] ?: ($m['name_en'] ?: ($m['department'] ?: '')))
    );
    $sort = $request->input('sort', 'new'); // new = ก–ฮ, old = ฮ–ก
    if ($sort === 'old') {
        $filtered = $filtered->sortByDesc($keyFn, SORT_NATURAL)->values();
    } else {
        $filtered = $filtered->sortBy($keyFn, SORT_NATURAL)->values();
    }

    // 7) Pagination สำหรับ TABLE ที่ถูกกรองแล้ว
    $perPage = (int) $request->input('per_page', 25);
    $page    = LengthAwarePaginator::resolveCurrentPage();
    $items   = $filtered->forPage($page, $perPage)->values();

    $paginated = new LengthAwarePaginator(
        $items,
        $filtered->count(),
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    // 8) ส่งให้ view
    return view('admin.dashboard.index', [
        'members'     => $paginated,   // ตาราง (หลังกรอง/เรียงแล้ว)
        'stats'       => $stats,       // การ์ด (รวมทั้งชีต)
        'totals'      => $totals,
        'groups'      => $groups,
        'suggestions' => $suggestions, // autocomplete
    ]);
}

    public function create()
    {
        return view('admin.dashboard.create');
    }
}
