@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')
@section('header', 'Dashboard Siswa')

@section('content')

<style>
    .icon-circle {
    width: 55px;
    height: 55px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
</style>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="border-left: 4px solid #2563EB;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Tagihan</h6>
                    <h2 class="mb-0">Rp {{ number_format($total_tagihan,0,',','.') }}</h2>
                </div>
                <div class="icon-circle" style="background: rgba(37,99,235,0.1);">
                    <i class="fas fa-file-invoice" style="color: #2563EB; font-size: 1.8rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="border-left: 4px solid #10B981;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Sudah Dibayar</h6>
                    <h2 class="mb-0">Rp {{ number_format($sudah_bayar,0,',','.') }}</h2>
                </div>
                <div class="icon-circle" style="background: rgba(16,185,129,0.1);">
                    <i class="fas fa-check-circle" style="color: #10B981; font-size: 1.8rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="border-left: 4px solid #EF4444;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Sisa Tagihan</h6>
                    <h2 class="mb-0">Rp {{ number_format($sisa_tagihan,0,',','.') }}</h2>
                </div>
                <div class="icon-circle" style="background: rgba(239,68,68,0.1);">
                    <i class="fas fa-exclamation-triangle" style="color: #EF4444; font-size: 1.8rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white fw-bold">
        <i class="fas fa-user me-2"></i>Profil Singkat
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><th>NIS</th><td>: {{ Auth::user()->nis }}</td></tr>
                    <tr><th>Nama</th><td>: {{ Auth::user()->name }}</td></tr>
                    <tr><th>Kelas</th><td>: {{ Auth::user()->kelas->nama_kelas ?? '-' }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><th>Jurusan</th><td>: {{ Auth::user()->jurusan->nama_jurusan ?? '-' }}</td></tr>
                    <tr><th>Tahun Ajaran</th><td>: {{ Auth::user()->tahun_ajaran }}</td></tr>
                    <tr><th>Status</th><td>: <span class="badge bg-success">Aktif</span></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-white fw-bold">
        <i class="fas fa-clock me-2"></i>Riwayat Pembayaran Terakhir
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>Tanggal</th><th>Bulan</th><th>Tahun</th><th>Jumlah</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach($riwayat_terbaru as $r)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($r->tanggal_bayar)) }}</td>
                        <td>{{ $r->bulan }}</td>
                        <td>{{ $r->tahun }}</td>
                        <td>Rp {{ number_format($r->jumlah,0,',','.') }}</td>
                        <td><span class="badge bg-{{ $r->status == 'Lunas' ? 'success' : 'warning' }}">{{ $r->status }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection