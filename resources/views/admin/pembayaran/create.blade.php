@extends('layouts.admin')

@section('title', 'Tambah Pembayaran')
@section('header', 'Form Tambah Pembayaran')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Form Tambah Pembayaran</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.pembayaran.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Siswa <span class="text-danger">*</span></label>
                    <select name="siswa_id" class="form-select" required>
                        <option value="">Pilih Siswa</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">SPP <span class="text-danger">*</span></label>
                    <select name="spp_id" class="form-select" required>
                        <option value="">Pilih Tahun SPP</option>
                        @foreach($spp as $s)
                            <option value="{{ $s->id }}">{{ $s->tahun }} - Rp {{ number_format($s->nominal,0,',','.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Bulan <span class="text-danger">*</span></label>
                    <select name="bulan" class="form-select" required>
                        <option value="">Pilih Bulan</option>
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                            <option value="{{ $b }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tahun <span class="text-danger">*</span></label>
                    <input type="text" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Bayar <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Metode <span class="text-danger">*</span></label>
                    <select name="metode" class="form-select" required>
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="Lunas">Lunas</option>
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection