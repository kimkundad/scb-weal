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

  <form method="POST" action="{{ route('toyota.update') }}">
    @csrf
    <input type="hidden" name="row" value="{{ $row }}">
    <input type="hidden" name="sheetName" value="{{ $sheetName }}">
    <input type="hidden" name="spreadsheetId" value="{{ $spreadsheetId }}">

    <div class="row g-3">
      {{-- ===== ฟิลด์ให้ตรงกับหน้า create ===== --}}
      <div class="col-md-6">
        <label class="form-label">ชื่อ–นามสกุล (ภาษาไทย)</label>
        <input type="text" class="form-control" name="name_th"
               value="{{ old('name_th', $fields['name_th'] ?? '') }}"
               placeholder="ชื่อ นามสกุล" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">ชื่อ–นามสกุล (ภาษาอังกฤษ)</label>
        <input type="text" class="form-control" name="name_en"
               value="{{ old('name_en', $fields['name_en'] ?? '') }}"
               placeholder="Name Surname">
      </div>

      <div class="col-md-6">
        <label class="form-label">Department</label>
        <input type="text" class="form-control" name="dept"
               value="{{ old('dept', $fields['dept'] ?? '') }}"
               placeholder="รายชื่อบริษัท">
      </div>
      <div class="col-md-6">
        <label class="form-label">Position</label>
        <input type="text" class="form-control" name="position"
               value="{{ old('position', $fields['position'] ?? '') }}"
               placeholder="ตำแหน่ง">
      </div>

      <div class="col-md-6">
        <label class="form-label">Region</label>
        @php
          $regionOld = old('region', $fields['region'] ?? '');
          $regionOpts = ['North', 'South', 'Metro', 'Central', 'Northeast', 'Unspecified Region'];
        @endphp
        <select class="form-select" name="region" required>
          @foreach($regionOpts as $opt1)
            <option value="{{ $opt1 }}" {{ $regionOld === $opt1 ? 'selected' : '' }}>
              {{ $opt1 }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="number" class="form-control" name="phone"
               value="{{ old('phone', $fields['phone'] ?? '') }}"
               placeholder="phone">
      </div>


      <div class="col-md-6">
        <label class="form-label">Badge (ประเภท)</label>
        @php $badge = old('badge', $fields['badge'] ?? 'DEALER'); @endphp
        <select class="form-select" name="badge" required>
          @foreach(['DEALER','TMT','TMA','AFFILIATE','EXHIBITION'] as $opt)
            <option value="{{ $opt }}" {{ $badge === $opt ? 'selected' : '' }}>{{ $opt }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Group</label>
        @php $groupVal = old('group', $fields['group'] ?? 'No GROUP'); @endphp
        <select class="form-select" name="group" id="group-select">
          @foreach(['No GROUP','A','B','C','D','E','F'] as $g)
            <option value="{{ $g }}" {{ $groupVal === $g ? 'selected' : '' }}>{{ $g }}</option>
          @endforeach
        </select>
      </div>

      {{-- *** ตัดส่วนเกิน: ผู้มาแทน / TestDrive / CarDisplay / Strategy / Check-in ออกทั้งหมด *** --}}



    {{-- ========== ผู้มาแทน ========== --}}
@php
  $hasInstead = !empty($fields['instead_th'] ?? '');
@endphp

@if($hasInstead)

<div class="col-md-12"> <h3 class="mb-1 mt-10">รายละเอียดผู้มาแทน</h3></div>


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


  <div class="col-md-6">
        <label class="form-label">Position</label>
        <input type="text" class="form-control" name="instead_position"
               value="{{ old('instead_position', $fields['instead_position'] ?? '') }}"
               placeholder="ตำแหน่ง">
      </div>

      <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" class="form-control" name="instead_phone"
               value="{{ old('instead_phone', $fields['instead_phone'] ?? '') }}"
               placeholder="phone">
      </div>

  <div class="col-12">
    <label class="form-label">Note</label>
    <textarea class="form-control" name="instead_note" rows="5"
              placeholder="สาเหตุ/รายละเอียดเพิ่มเติม">{{ old('instead_note', $fields['instead_note'] ?? '') }}</textarea>
  </div>
@endif
{{-- ========== /ผู้มาแทน ========== --}}

</div>

    <div class="mt-4">
      <button type="submit" class="btn btn-danger btn-lg">บันทึก</button>
      <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary">กลับหน้าหลัก</a>
    </div>
  </form>
  <br><br><br><br>
</div>
@endsection

@section('scripts')
{{-- คงสคริปต์แบบหน้า create (มีเงื่อนไขเช็ค null อยู่แล้ว จะไม่รันถ้าไม่มีช่องเวลา) --}}
<script>
(function(){
  const slotTest     = {A:'9.40 - 10.30', B:'10.35 - 11.25', C:'11.30 - 12.20',
                        D:'14.00 - 14.50', E:'14.55 - 15.45', F:'15.50 - 16.40',
                        '':'9.40 - 10.30'};
  const slotCar      = {A:'10.35 - 11.25', B:'11.30 - 12.20', C:'9.40 - 10.30',
                        D:'14.55 - 15.45', E:'15.50 - 16.40', F:'14.00 - 14.50',
                        '':'10.35 - 11.25'};
  const slotStrategy = {A:'11.30 - 12.20', B:'9.40 - 10.30',  C:'10.35 - 11.25',
                        D:'15.50 - 16.40', E:'14.00 - 14.50', F:'14.55 - 15.45',
                        '':'11.30 - 12.20'};

  const sel = document.getElementById('group-select');
  const t   = document.getElementById('testdrive-input');
  const c   = document.getElementById('cardisplay-input');
  const s   = document.getElementById('strategy-input');

  function apply() {
    let g = sel?.value ?? '';
    if (g === 'No GROUP') g = '';
    if (t && c && s) {
      if (g in slotTest)     t.value = slotTest[g];
      if (g in slotCar)      c.value = slotCar[g];
      if (g in slotStrategy) s.value = slotStrategy[g];
    }
  }

  if (sel) {
    sel.addEventListener('change', apply);
    apply();
  }
})();
</script>
@endsection
