@extends('layouts.siswa')

@section('title', 'Profil Saya')
@section('header', 'Profil Saya')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">
        <i class="fas fa-user me-2"></i>Informasi Profil
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('siswa.profil.update') }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIS</label>
                    <input type="text" class="form-control" value="{{ $siswa->nis }}" readonly disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" value="{{ $siswa->username }}" readonly disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ $siswa->name }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $siswa->email }}" readonly disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <input type="text" class="form-control" value="{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}" readonly disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" value="{{ $siswa->no_telepon }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ $siswa->alamat }}</textarea>
                </div>
            </div>
            
            <hr>
            <h5 class="mt-3">Ganti Password</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection