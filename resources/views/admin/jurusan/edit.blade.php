@extends('layouts.admin')

@section('title', 'Edit Jurusan')
@section('header', 'Edit Jurusan')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Form Edit Jurusan</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.jurusan.update', $jurusan->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Kode Jurusan</label>
                <input type="text" name="kode_jurusan" class="form-control" value="{{ $jurusan->kode_jurusan }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Jurusan</label>
                <input type="text" name="nama_jurusan" class="form-control" value="{{ $jurusan->nama_jurusan }}" required>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
EOF