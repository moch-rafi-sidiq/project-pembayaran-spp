@extends('layouts.admin')

@section('title', 'Tambah Kelas')
@section('header', 'Tambah Kelas')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Form Tambah Kelas</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.kelas.store') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Tingkat</label>
                <select name="tingkat" class="form-select" required>
                    <option value="">Pilih Tingkat</option>
                    <option value="10">X (10)</option>
                    <option value="11">XI (11)</option>
                    <option value="12">XII (12)</option>
                </select>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection