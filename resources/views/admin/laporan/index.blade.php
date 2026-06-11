@extends('layouts.admin')

@section('title', 'Laporan')
@section('header', 'Laporan Pembayaran')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">
        <i class="fas fa-chart-line me-2"></i>Filter Laporan
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.laporan.print') }}" target="_blank">
            @csrf
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Jenis Laporan</label>
                    <select name="jenis" id="jenis" class="form-select" required>
                        <option value="harian">Harian</option>
                        <option value="mingguan">Mingguan</option>
                        <option value="bulanan">Bulanan</option>
                        <option value="tahunan">Tahunan</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3" id="filterTanggal">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3 mb-3" id="filterBulan" style="display:none;">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Pilih Bulan</option>
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                        <option value="{{ $b }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3" id="filterTahun" style="display:none;">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">Pilih Tahun</option>
                        @for($i = 2020; $i <= date('Y'); $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-print me-1"></i>Cetak PDF</button>
                <button type="submit" formaction="{{ route('admin.laporan.excel') }}" class="btn btn-success"><i class="fas fa-file-excel me-1"></i>Export Excel</button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-white fw-bold">
        <i class="fas fa-chart-bar me-2"></i>Statistik
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="alert alert-info text-center">
                    <h6>Total Transaksi</h6>
                    <h3>{{ $total_transaksi ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-success text-center">
                    <h6>Total Pemasukan</h6>
                    <h3>Rp {{ number_format($total_pemasukan ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-primary text-center">
                    <h6>Siswa Lunas</h6>
                    <h3>{{ $siswa_lunas ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-warning text-center">
                    <h6>Siswa Belum Lunas</h6>
                    <h3>{{ $siswa_belum_lunas ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const jenisSelect = document.getElementById('jenis');
    const filterTanggal = document.getElementById('filterTanggal');
    const filterBulan = document.getElementById('filterBulan');
    const filterTahun = document.getElementById('filterTahun');
    
    jenisSelect.addEventListener('change', function() {
        const jenis = this.value;
        filterTanggal.style.display = 'none';
        filterBulan.style.display = 'none';
        filterTahun.style.display = 'none';
        
        if (jenis == 'harian' || jenis == 'mingguan') {
            filterTanggal.style.display = 'block';
        } else if (jenis == 'bulanan') {
            filterBulan.style.display = 'block';
            filterTahun.style.display = 'block';
        } else if (jenis == 'tahunan') {
            filterTahun.style.display = 'block';
        }
    });
    
    jenisSelect.dispatchEvent(new Event('change'));
</script>
@endpush
@endsection