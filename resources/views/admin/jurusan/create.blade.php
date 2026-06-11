@extends('layouts.admin')

@section('title', 'Tambah Jurusan')
@section('header', 'Tambah Jurusan')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Form Tambah Jurusan</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.jurusan.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Kode Jurusan <span class="text-danger">*</span></label>
                <input type="text" name="kode_jurusan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
                <input type="text" name="nama_jurusan" class="form-control" required>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
EOF