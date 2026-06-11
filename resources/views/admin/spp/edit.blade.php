@extends('layouts.admin')

@section('title', 'Edit SPP')
@section('header', 'Edit SPP')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Form Edit SPP</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.spp.update', $spp->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Tahun Ajaran</label>
                <input type="text" name="tahun" class="form-control" value="{{ $spp->tahun }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nominal</label>
                <input type="number" name="nominal" class="form-control" value="{{ $spp->nominal }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ $spp->keterangan }}</textarea>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.spp.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
EOF