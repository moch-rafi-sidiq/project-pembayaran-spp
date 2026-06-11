@extends('layouts.admin')

@section('title', 'Edit Kelas')
@section('header', 'Edit Kelas')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Form Edit Kelas</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.kelas.update', $kelas->id) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" value="{{ $kelas->nama_kelas }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Tingkat</label>
                <select name="tingkat" class="form-select" required>
                    <option value="">Pilih Tingkat</option>
                    <option value="10" {{ $kelas->tingkat == '10' ? 'selected' : '' }}>X (10)</option>
                    <option value="11" {{ $kelas->tingkat == '11' ? 'selected' : '' }}>XI (11)</option>
                    <option value="12" {{ $kelas->tingkat == '12' ? 'selected' : '' }}>XII (12)</option>
                </select>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection