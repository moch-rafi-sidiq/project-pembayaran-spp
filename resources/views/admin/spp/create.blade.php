@extends('layouts.admin')

@section('title', 'Tambah SPP')
@section('header', 'Tambah SPP')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Form Tambah SPP</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.spp.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Tahun Ajaran</label>
                <input type="text" name="tahun" class="form-control" placeholder="2024/2025" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nominal</label>
                <input type="number" name="nominal" class="form-control" placeholder="250000" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Keterangan (opsional)"></textarea>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.spp.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
EOF