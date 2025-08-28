@extends('admin.layouts.template')

@section('content')
<div class="container my-4" style="max-width:960px">
  @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif
  @if($errors->any()) <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div> @endif

  <h3 class="mb-1 mt-10">เพิ่มผู้มาแทน</h3>
  <div class="text-muted mb-4">ของ คาร์ล ออฟพินบอร์น</div>

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

    <div class="col-12">
      <label class="form-label">Note</label>
      <textarea class="form-control" name="note" rows="6" placeholder="กรอกเนื้อหา">{{ old('note') }}</textarea>
    </div>

    <div class="col-12 mt-3">
      <button type="submit" class="btn btn-danger btn-lg">บันทึกข้อมูลผู้ติดตาม</button>
      <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary">ยกเลิก</a>
    </div>
  </form>
</div>
@endsection
