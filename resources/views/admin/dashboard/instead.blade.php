@extends('admin.layouts.template')

@section('content')
<div class="container my-4" style="max-width:960px">
  @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif
  @if($errors->any()) <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div> @endif

  <h3 class="mb-1 mt-10">เพิ่มผู้มาแทน</h3>
  <div class="text-dark mb-4" style="font-size:20px">ของ {{ $Name }}</div>

  <form method="POST" action="{{ route('toyota.instead.store') }}" class="row g-3">
    @csrf
    <input type="hidden" name="row" value="{{ $row }}">
    <input type="hidden" name="sheetName" value="{{ $sheetName }}">
    <input type="hidden" name="spreadsheetId" value="{{ $spreadsheetId }}">

    <div class="col-md-6">
      <label class="form-label">ชื่อ–นามสกุล (ภาษาไทย) ผู้มาแทน</label>
      <input type="text" class="form-control" name="name_th" value="{{ old('name_th') }}" placeholder="ชื่อ นามสกุล" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">ชื่อ–นามสกุล (ภาษาอังกฤษ) ผู้มาแทน</label>
      <input type="text" class="form-control" name="name_en" value="{{ old('name_en') }}" placeholder="Name Surname">
    </div>

    <div class="col-md-6">
        <label class="form-label">Position</label>
        <input type="text" class="form-control" name="position"
               value="{{ old('position') }}"
               placeholder="ตำแหน่ง">
      </div>

      <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="number" class="form-control" name="phone"
               value="{{ old('phone') }}"
               placeholder="phone">
      </div>



    {{-- <div class="col-md-12"><h3 class="mb-1 mt-10">รายละเอียดกิจกรรม</h3></div> --}}


     @php
        $slotTest = ['A'=>'9.40 - 10.30','B'=>'10.35 - 11.25','C'=>'11.30 - 12.20','D'=>'14.00 - 14.50','E'=>'14.55 - 15.45','F'=>'15.50 - 16.40', 'ไม่มีกลุ่ม' =>''];
        $groupVal = old('group','');
      @endphp

    <div class="col-md-6">
        <label class="form-label">Group</label>
        <select class="form-select" disabled>
            <option>{{ old('group', $member['group'] ?? '') }}</option>
        </select>
        <!-- hidden เอาไว้ส่งค่า -->
        <input type="hidden" name="group" value="{{ old('group', $member['group'] ?? '') }}">
    </div>

    <div class="col-12">
      <label class="form-label">Note</label>
      <textarea class="form-control" name="note" rows="6" placeholder="กรอกเนื้อหา">{{ old('note') }}</textarea>
    </div>

      {{-- <div class="col-md-6">
        <label class="form-label">Test Drive</label>
        <input type="text"
                class="form-control"
                name="testdrive"
                id="testdrive-input"
                value="{{ old('testdrive', $member['testdrive'] ?? '') }}"
                placeholder="เช่น 9.40 - 10.30" readonly>
        </div>

        <div class="col-md-6">
        <label class="form-label">Car Display</label>
        <input type="text"
                class="form-control"
                name="cardisplay"
                id="cardisplay-input"
                value="{{ old('cardisplay', $member['cardisplay'] ?? '') }}"
                placeholder="เช่น 10.35 - 11.25" readonly>
        </div>

        <div class="col-md-6">
        <label class="form-label">Strategy Sharing</label>
        <input type="text"
                class="form-control"
                name="strategy"
                id="strategy-input"
                value="{{ old('strategy', $member['strategy'] ?? '') }}"
                placeholder="เช่น 11.30 - 12.20" readonly>
        </div> --}}


    <div class="col-12 mt-3">
      <button type="submit" class="btn btn-danger btn-lg">บันทึกข้อมูลผู้มาแทน</button>
      <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary">กลับหน้าหลัก</a>
    </div>
  </form>
</div>
@endsection
