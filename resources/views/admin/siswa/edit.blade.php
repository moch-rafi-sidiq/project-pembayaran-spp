@extends('layouts.admin')

@section('title', 'Edit Siswa')
@section('header', 'Edit Data Siswa')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Form Edit Siswa</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.siswa.update', $siswa->id) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIS <span class="text-danger">*</span></label>
                    <input type="text" name="nis" class="form-control" value="{{ $siswa->nis }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ $siswa->name }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="">Pilih</option>
                        <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kelas <span class="text-danger">*</span></label>
                    <select name="kelas_id" class="form-select" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jurusan <span class="text-danger">*</span></label>
                    <select name="jurusan_id" class="form-select" required>
                        <option value="">Pilih Jurusan</option>
                        @foreach($jurusan as $j)
                            <option value="{{ $j->id }}" {{ $siswa->jurusan_id == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                    <input type="text" name="tahun_ajaran" class="form-control" value="{{ $siswa->tahun_ajaran }}" required>
                </div>
                <div class="col-md-6 mb-3">
    <label class="form-label">Email <span class="text-danger">*</span></label>
    <input type="email" name="email" class="form-control" value="{{ $siswa->email }}" required>
    <small class="text-muted">Digunakan untuk notifikasi tagihan jatuh tempo</small>
</div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" value="{{ $siswa->no_telepon }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status Aktif</label>
                    <select name="status_aktif" class="form-select">
                        <option value="1" {{ $siswa->status_aktif == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $siswa->status_aktif == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ $siswa->alamat }}</textarea>
                </div>
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection