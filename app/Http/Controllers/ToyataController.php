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
    $sheetName     = 'mock up name list';   // <— ใช้ชื่อนี้ทำ A1 notation
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
        'checkin'     => ['check-in','check in','checkin'],   // <— เพิ่มคอลัมน์ J
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

    // ---- map เป็น ALL MEMBERS + เก็บเบอร์แถวจริงของชีต
    $allMembers = collect($dataRows)
        ->filter(fn($r)=>collect($r)->filter(fn($v)=>trim((string)$v) !== '')->isNotEmpty())
        ->values()
        ->map(function($r, $i) use ($pick, $expected, $headerIdx) {
            $sheetRow = $headerIdx + 2 + $i; // 1-based + header อีก 1 แถว
            return [
                'row'         => $sheetRow,  // <— ใช้เวลาจะเขียนกลับ (คอลัมน์ J)
                'no'          => (int)($pick($r, $expected['no']) ?: $i + 1),
                'badge'       => (string)($pick($r, $expected['badge']) ?: ''),
                'group'       => (string)($pick($r, $expected['group']) ?: ''),
                'name_th'     => (string)($pick($r, $expected['name_th']) ?: ''),
                'name_en'     => (string)($pick($r, $expected['name_en']) ?: ''),
                'department'  => (string)($pick($r, $expected['department']) ?: ''),
                'checkin'     => (string)($pick($r, $expected['checkin']) ?: ''), // <—
                'test_drive'  => (string)($pick($r, $expected['test_drive']) ?: ''),
                'car_display' => (string)($pick($r, $expected['car_display']) ?: ''),
                'strategy'    => (string)($pick($r, $expected['strategy']) ?: ''),
            ];
        });

    // ---- cards summary (คงเดิมจาก ALL)
    $groups = ['A','B','C','D','E','F'];
    $stats  = [];
    foreach ($groups as $g) {
        $stats["group_{$g}"] = $allMembers->where('group', $g)->count();
    }
    $stats['external_morning']   = ($stats['group_A'] ?? 0) + ($stats['group_B'] ?? 0) + ($stats['group_C'] ?? 0);
    $stats['external_afternoon'] = ($stats['group_D'] ?? 0) + ($stats['group_E'] ?? 0) + ($stats['group_F'] ?? 0);
    $totals = ['checkin_all' => $allMembers->count()];

    // ---- suggestions
    $suggestions = $allMembers->flatMap(fn($m)=>array_filter([$m['name_th'],$m['name_en'],$m['department']]))->unique()->values()->take(300);

    // ---- filters (q, badge, group) + sort
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
    if ($g = trim((string)$request->input('group'))) {
        $filtered = $filtered->where('group', $g)->values();
    }

    // sort: new = ก-ฮ, old = ฮ-ก (เทียบ name_th)
    $sort = $request->input('sort', 'new');
    $filtered = $filtered->sortBy('name_th', SORT_NATURAL | SORT_FLAG_CASE, $sort === 'old')->values();

    // ---- pagination
    $perPage   = (int)$request->input('per_page', 25);
    $page      = LengthAwarePaginator::resolveCurrentPage();
    $items     = $filtered->forPage($page, $perPage)->values();
    $paginated = new LengthAwarePaginator($items, $filtered->count(), $perPage, $page, ['path'=>$request->url(),'query'=>$request->query()]);

    return view('admin.dashboard.index', [
        'members'     => $paginated,
        'stats'       => $stats,
        'totals'      => $totals,
        'groups'      => $groups,
        'suggestions' => $suggestions,
        'sheetName'   => $sheetName,     // <— เผื่อใช้ใน view
        'spreadsheetId' => $spreadsheetId,
    ]);
}

    public function create()
    {
        return view('admin.dashboard.create');
    }



    private function rowToFields(array $row): array
    {
        // A..J => index 0..9
        return [
            'no'        => $row[0] ?? '',
            'badge'     => $row[1] ?? '',
            'group'     => $row[2] ?? '',
            'name_th'   => $row[3] ?? '',
            'name_en'   => $row[4] ?? '',
            'dept'      => $row[5] ?? '',
            'testdrive' => $row[6] ?? '',
            'cardisplay'=> $row[7] ?? '',
            'strategy'  => $row[8] ?? '',
            'checkin'   => $row[9] ?? '', // J (อ่านอย่างเดียวที่หน้านี้)
        ];
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
        $gs = app(GoogleSheet::class);

        // เผื่อชื่อชีตมีช่องว่าง
        $sheet = preg_match('/[^A-Za-z0-9_]/', $sheetName) ? "'".str_replace("'", "''", $sheetName)."'" : $sheetName;
        $range = "{$sheet}!A{$row}:J{$row}";

        $values = $gs->getSheetData($spreadsheetId, $range) ?? [[]];
        $fields = $this->rowToFields($values[0] ?? []);

        return view('admin.dashboard.edit', compact('fields', 'row', 'sheetName', 'spreadsheetId'));
    }

   public function update(Request $request)
{
    $validated = $request->validate([
        'row'           => ['required','integer','min:2'],
        'sheetName'     => ['required','string'],
        'spreadsheetId' => ['required','string'],
        'badge'         => ['nullable','string'],
        'group'         => ['required','string','in:A,B,C,D,E,F'],
        'name_th'       => ['nullable','string'],
        'name_en'       => ['nullable','string'],
        'dept'          => ['nullable','string'],
        'cardisplay'    => ['nullable','string'],
        'strategy'      => ['nullable','string'],
        'testdrive'     => ['nullable','string'],
    ]);

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

    // Override ให้ตรงตาม Group
    $validated['testdrive']  = $slotTest[$validated['group']] ?? '';
    $validated['cardisplay'] = $slotCar[$validated['group']] ?? '';
    $validated['strategy']   = $slotStrategy[$validated['group']] ?? '';

    // === เขียนกลับชีต ===
    /** @var \App\Services\GoogleSheet $gs */
    $gs = app(\App\Services\GoogleSheet::class);
    $row           = (int) $validated['row'];
    $sheetName     = $validated['sheetName'];
    $spreadsheetId = $validated['spreadsheetId'];
    $sheet = preg_match('/[^A-Za-z0-9_]/', $sheetName) ? "'".str_replace("'", "''", $sheetName)."'" : $sheetName;

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
        foreach ($mapCols as $field => $col) {
            $cell = "{$sheet}!{$col}{$row}";
            $gs->updateCell($spreadsheetId, $cell, (string)($validated[$field] ?? ''), 'USER_ENTERED');
        }
        return redirect()
            ->route('toyota.edit', ['spreadsheetId'=>$spreadsheetId,'sheetName'=>$sheetName,'row'=>$row])
            ->with('status', 'บันทึกข้อมูลสำเร็จ');
    } catch (\Throwable $e) {
        \Log::error('update row failed', ['row'=>$row,'sheet'=>$sheetName,'e'=>$e->getMessage()]);
        return back()->withErrors(['update' => 'บันทึกไม่สำเร็จ: '.$e->getMessage()]);
    }
}


}
