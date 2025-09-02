@extends('admin.layouts.template')

@section('content')
<div class="container my-4" style="max-width:960px">
  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      @foreach($errors->all() as $err) <div>{{ $err }}</div> @endforeach
    </div>
  @endif

  <h3 class="mb-1 mt-10">แก้ไขรายชื่อ</h3>
  <div class="text-dark mb-4" style="font-size:20px">{{ $fields['name_th'] }}</div>

  <form method="POST" action="{{ route('toyota.update') }}">
    @csrf
    <input type="hidden" name="row" value="{{ $row }}">
    <input type="hidden" name="sheetName" value="{{ $sheetName }}">
    <input type="hidden" name="spreadsheetId" value="{{ $spreadsheetId }}">

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">ชื่อ–นามสกุล (ภาษาไทย)</label>
        <input type="text" class="form-control" name="name_th" value="{{ old('name_th', $fields['name_th']) }}" placeholder="ชื่อ นามสกุล">
      </div>
      <div class="col-md-6">
        <label class="form-label">ชื่อ–นามสกุล (ภาษาอังกฤษ)</label>
        <input type="text" class="form-control" name="name_en" value="{{ old('name_en', $fields['name_en']) }}" placeholder="Name Surname">
      </div>

      <div class="col-md-6">
        <label class="form-label">Department</label>
        <input type="text" class="form-control" name="dept" value="{{ old('dept', $fields['dept']) }}" placeholder="รายชื่อบริษัท">
      </div>
      <div class="col-md-6">
        <label class="form-label">Badge (ประเภท)</label>
        <select class="form-select" name="badge">
          @php $badge = old('badge', $fields['badge']); @endphp
          @foreach(['Dealer','TMT','AFFILIATE'] as $opt)
            <option value="{{ $opt }}" {{ $badge === $opt ? 'selected' : '' }}>{{ $opt }}</option>
          @endforeach
        </select>
      </div>


{{-- ========== ผู้มาแทน ========== --}}
@php
  $hasInstead = !empty($fields['instead_th'] ?? '')
             || !empty($fields['instead_en'] ?? '')
             || !empty($fields['instead_note'] ?? '');
@endphp

@if($hasInstead)
  <div class="col-md-12"><h3 class="mb-1 mt-10">ผู้มาแทน</h3></div>

  <div class="col-md-6">
    <label class="form-label">ชื่อ–นามสกุล (ภาษาไทย) ผู้มาแทน</label>
    <input type="text" class="form-control" name="instead_th"
           value="{{ old('instead_th', $fields['instead_th'] ?? '') }}"
           placeholder="เช่น นาย สมชาย มาแทน">
  </div>
  <div class="col-md-6">
    <label class="form-label">ชื่อ–นามสกุล (ภาษาอังกฤษ) ผู้มาแทน</label>
    <input type="text" class="form-control" name="instead_en"
           value="{{ old('instead_en', $fields['instead_en'] ?? '') }}"
           placeholder="Name Surname">
  </div>

  <div class="col-12">
    <label class="form-label">Note</label>
    <textarea class="form-control" name="instead_note" rows="5"
              placeholder="สาเหตุ/รายละเอียดเพิ่มเติม">{{ old('instead_note', $fields['instead_note'] ?? '') }}</textarea>
  </div>
@endif
{{-- ========== /ผู้มาแทน ========== --}}


      <div class="col-md-12"> <h3 class="mb-1 mt-10">รายละเอียดกิจกรรม</h3></div>
@php
  // ใช้ค่าว่าง '' เป็นคีย์ของ "ไม่มีกลุ่ม"
  $slotTest = [
    'A'=>'9.40 - 10.30','B'=>'10.35 - 11.25','C'=>'11.30 - 12.20',
    'D'=>'14.00 - 14.50','E'=>'14.55 - 15.45','F'=>'15.50 - 16.40',
    '' => '9.40 - 10.30', // ไม่มีกลุ่ม
  ];
  $slotCar = [
    'A'=>'10.35 - 11.25','B'=>'11.30 - 12.20','C'=>'9.40 - 10.30',
    'D'=>'14.55 - 15.45','E'=>'15.50 - 16.40','F'=>'14.00 - 14.50',
    '' => '10.35 - 11.25', // ไม่มีกลุ่ม
  ];
  $slotStrategy = [
    'A'=>'11.30 - 12.20','B'=>'9.40 - 10.30','C'=>'10.35 - 11.25',
    'D'=>'15.50 - 16.40','E'=>'14.00 - 14.50','F'=>'14.55 - 15.45',
    '' => '11.30 - 12.20', // ไม่มีกลุ่ม
  ];

  // กรณีในชีตเคยบันทึกเป็นคำว่า "ไม่มีกลุ่ม" ให้ map เป็นค่าว่าง
  $groupRaw = old('group', $fields['group'] ?? '');
  $groupVal = ($groupRaw === 'ไม่มีกลุ่ม') ? '' : $groupRaw;

  $testdriveVal  = old('testdrive',  $fields['testdrive']  ?? ($slotTest[$groupVal]     ?? ''));
  $cardisplayVal = old('cardisplay', $fields['cardisplay'] ?? ($slotCar[$groupVal]      ?? ''));
  $strategyVal   = old('strategy',   $fields['strategy']   ?? ($slotStrategy[$groupVal] ?? ''));
@endphp


<div class="col-md-6">
  <label class="form-label">Group</label>
  <select class="form-select" name="group" id="group-select">
    {{-- ตัวเลือก "ไม่มีกลุ่ม" (value = '') --}}
    <option value="" {{ $groupVal === '' ? 'selected' : '' }}>ไม่มีกลุ่ม</option>
    @foreach(['A','B','C','D','E','F'] as $g)
      <option value="{{ $g }}" {{ $groupVal === $g ? 'selected' : '' }}>{{ $g }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-6">
  <label class="form-label">Test Drive</label>
  <input type="text" class="form-control" name="testdrive" id="testdrive-input"
         value="{{ $testdriveVal }}" placeholder="เช่น 9.40 - 10.30">
</div>

<div class="col-md-6">
  <label class="form-label">Car Display</label>
  <input type="text" class="form-control" name="cardisplay" id="cardisplay-input"
         value="{{ $cardisplayVal }}" placeholder="เช่น 10.35 - 11.25">
</div>

<div class="col-md-6">
  <label class="form-label">Strategy Sharing</label>
  <input type="text" class="form-control" name="strategy" id="strategy-input"
         value="{{ $strategyVal }}" placeholder="เช่น 11.30 - 12.20">
</div>

      <div class="col-12">
        <div class="text-muted small">
          Check-in (อ่านอย่างเดียว): {{ $fields['checkin'] ?: '—' }}
        </div>
      </div>
    </div>

    <div class="mt-4">
      <button type="submit" class="btn btn-danger btn-lg">บันทึก</button>
      <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
  </form>
  <br><br><br><br>
</div>

@endsection

@section('scripts')
<script>
  (function(){
    // คีย์ '' แทน "ไม่มีกลุ่ม" ให้ตรงกับฝั่ง PHP
    const slotTest     = {A:'9.40 - 10.30', B:'10.35 - 11.25', C:'11.30 - 12.20', D:'14.00 - 14.50', E:'14.55 - 15.45', F:'15.50 - 16.40', '':'9.40 - 10.30'};
    const slotCar      = {A:'10.35 - 11.25', B:'11.30 - 12.20', C:'9.40 - 10.30',  D:'14.55 - 15.45', E:'15.50 - 16.40', F:'14.00 - 14.50', '':'10.35 - 11.25'};
    const slotStrategy = {A:'11.30 - 12.20', B:'9.40 - 10.30',  C:'10.35 - 11.25', D:'15.50 - 16.40', E:'14.00 - 14.50', F:'14.55 - 15.45', '':'11.30 - 12.20'};

    const sel  = document.getElementById('group-select');
    const tInp = document.getElementById('testdrive-input');
    const cInp = document.getElementById('cardisplay-input');
    const sInp = document.getElementById('strategy-input');

    function apply(g){
      // อย่า return เมื่อ g ว่าง — ให้ใช้คีย์ ''
      if (g in slotTest)     tInp.value = slotTest[g];
      if (g in slotCar)      cInp.value = slotCar[g];
      if (g in slotStrategy) sInp.value = slotStrategy[g];
    }

    if (sel && tInp && cInp && sInp) {
      sel.addEventListener('change', () => apply(sel.value));
      // prefill ครั้งแรกตามค่าปัจจุบัน (รวมกรณี '')
      apply(sel.value);
    }
  })();
</script>
@endsection
