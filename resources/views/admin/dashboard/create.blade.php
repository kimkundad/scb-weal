@extends('admin.layouts.template')

@section('title')
  <title>เพิ่มผู้เข้าร่วมงาน</title>
@endsection

@section('content')
<div class="container my-4" style="max-width:960px">
  @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif
  @if($errors->any())
    <div class="alert alert-danger">@foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach</div>
  @endif

  <h3 class="mb-1 mt-10">เพิ่มรายชื่อ</h3>
  <div class="text-muted mb-4">ของ คาร์ล ออฟพินบอร์น</div>

  <form method="POST" action="{{ route('members.store') }}">
    @csrf

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">ชื่อ–นามสกุล (ภาษาไทย)</label>
        <input type="text" class="form-control" name="name_th" value="{{ old('name_th') }}" placeholder="ชื่อ นามสกุล" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">ชื่อ–นามสกุล (ภาษาอังกฤษ)</label>
        <input type="text" class="form-control" name="name_en" value="{{ old('name_en') }}" placeholder="Name Surname">
      </div>

      <div class="col-md-6">
        <label class="form-label">Department</label>
        <input type="text" class="form-control" name="dept" value="{{ old('dept') }}" placeholder="รายชื่อบริษัท">
      </div>
      <div class="col-md-6">
        <label class="form-label">Badge (ประเภท)</label>
        @php $badge = old('badge','Dealer'); @endphp
        <select class="form-select" name="badge" required>
          @foreach(['Dealer','TMT','AFFILIATE'] as $opt)
            <option value="{{ $opt }}" {{ $badge === $opt ? 'selected' : '' }}>{{ $opt }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-12"><h3 class="mb-1 mt-10">รายละเอียดกิจกรรม</h3></div>

      @php
        $slotTest = ['A'=>'9.40 - 10.30','B'=>'10.35 - 11.25','C'=>'11.30 - 12.20','D'=>'14.00 - 14.50','E'=>'14.55 - 15.45','F'=>'15.50 - 16.40'];
        $slotCar  = ['A'=>'10.35 - 11.25','B'=>'11.30 - 12.20','C'=>'9.40 - 10.30','D'=>'14.55 - 15.45','E'=>'15.50 - 16.40','F'=>'14.00 - 14.50'];
        $slotStr  = ['A'=>'11.30 - 12.20','B'=>'9.40 - 10.30','C'=>'10.35 - 11.25','D'=>'15.50 - 16.40','E'=>'14.00 - 14.50','F'=>'14.55 - 15.45'];
        $groupVal = old('group','');
        $testVal  = old('testdrive',  $slotTest[$groupVal] ?? '');
        $carVal   = old('cardisplay', $slotCar[$groupVal]  ?? '');
        $strVal   = old('strategy',   $slotStr[$groupVal]  ?? '');
      @endphp

      <div class="col-md-6">
        <label class="form-label">Exhibition round / Group</label>
        <select class="form-select" name="group" id="group-select" required>
          <option value="">-- เลือกกลุ่ม --</option>
          @foreach($slotTest as $g => $t)
            <option value="{{ $g }}" {{ $groupVal === $g ? 'selected' : '' }}>
              {{ $g }} (กลุ่ม) – {{ $t }} (Test Drive)
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Test Drive</label>
        <input type="text" class="form-control" name="testdrive" id="testdrive-input" value="{{ $testVal }}" placeholder="เช่น 9.40 - 10.30">
      </div>

      <div class="col-md-6">
        <label class="form-label">Car Display</label>
        <input type="text" class="form-control" name="cardisplay" id="cardisplay-input" value="{{ $carVal }}" placeholder="เช่น 10.35 - 11.25">
      </div>

      <div class="col-md-6">
        <label class="form-label">Strategy Sharing</label>
        <input type="text" class="form-control" name="strategy" id="strategy-input" value="{{ $strVal }}" placeholder="เช่น 11.30 - 12.20">
      </div>
    </div>

    <div class="mt-4">
      <button type="submit" class="btn btn-danger btn-lg">เพิ่มรายชื่อ</button>
      <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
  (function(){
    const slotTest     = {A:'9.40 - 10.30', B:'10.35 - 11.25', C:'11.30 - 12.20', D:'14.00 - 14.50', E:'14.55 - 15.45', F:'15.50 - 16.40'};
    const slotCar      = {A:'10.35 - 11.25', B:'11.30 - 12.20', C:'9.40 - 10.30',  D:'14.55 - 15.45', E:'15.50 - 16.40', F:'14.00 - 14.50'};
    const slotStrategy = {A:'11.30 - 12.20', B:'9.40 - 10.30',  C:'10.35 - 11.25', D:'15.50 - 16.40', E:'14.00 - 14.50', F:'14.55 - 15.45'};

    const sel = document.getElementById('group-select');
    const t   = document.getElementById('testdrive-input');
    const c   = document.getElementById('cardisplay-input');
    const s   = document.getElementById('strategy-input');

    function apply() {
      const g = sel.value;
      if (slotTest[g])     t.value = slotTest[g];
      if (slotCar[g])      c.value = slotCar[g];
      if (slotStrategy[g]) s.value = slotStrategy[g];
    }

    if (sel && t && c && s) {
      sel.addEventListener('change', apply);
      // prefill ครั้งแรก (กรณีมีค่า group เดิม)
      if (sel.value) apply();
    }
  })();
</script>
@endsection
