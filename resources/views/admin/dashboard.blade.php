@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<style>
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s;
        border-left: 4px solid;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .stat-card .icon {
        font-size: 2.5rem;
        opacity: 0.2;
        position: absolute;
        right: 20px;
        bottom: 20px;
    }
</style>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #2563EB;">
            <h6>Total Siswa</h6>
            <h2 class="mt-2">{{ number_format($total_siswa) }}</h2>
            <i class="fas fa-users icon"></i>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #10B981;">
            <h6>Total Pembayaran</h6>
            <h2 class="mt-2">Rp {{ number_format($total_pembayaran,0,',','.') }}</h2>
            <i class="fas fa-money-bill icon"></i>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #EF4444;">
            <h6>Tagihan Belum Lunas</h6>
            <h2 class="mt-2">{{ number_format($belum_lunas) }}</h2>
            <i class="fas fa-exclamation-triangle icon"></i>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="border-left-color: #F59E0B;">
            <h6>Pendapatan Bulan Ini</h6>
            <h2 class="mt-2">Rp {{ number_format($pendapatan_bulan,0,',','.') }}</h2>
            <i class="fas fa-chart-line icon"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-chart-line me-2"></i>Grafik Pembayaran {{ date('Y') }}
            </div>
            <div class="card-body p-3">
                <div style="position: relative; height: 350px; width: 100%;">
                    <canvas id="paymentChart" style="display: block; width: 100%; height: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-chart-pie me-2"></i>Ringkasan
            </div>
            <div class="card-body text-center">
                <h4 class="text-primary">Rp {{ number_format($pendapatan_tahun,0,',','.') }}</h4>
                <small class="text-muted">Total Pendapatan {{ date('Y') }}</small>
                <hr>
                <div class="row mt-3">
                    <div class="col-6">
                        <h5>{{ number_format($total_siswa) }}</h5>
                        <small>Siswa Aktif</small>
                    </div>
                    <div class="col-6">
                        <h5>{{ number_format($belum_lunas) }}</h5>
                        <small>Belum Lunas</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-clock me-2"></i>Pembayaran Terbaru
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>Tanggal</th><th>Siswa</th><th>Jumlah</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @foreach($pembayaran_terbaru as $p)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($p->tanggal_bayar)) }}</td>
                                <td>{{ $p->siswa->name ?? '-' }}</td>
                                <td>Rp {{ number_format($p->jumlah,0,',','.') }}</td>
                                <td><span class="badge bg-success">{{ $p->status }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-bell me-2"></i>Tagihan Jatuh Tempo
            </div>
            <div class="card-body">
                @foreach($tagihan_jatuh_tempo as $tagihan)
                <div class="alert alert-warning mb-2">
                    <strong>{{ $tagihan->siswa->name ?? '-' }}</strong><br>
                    <small>{{ $tagihan->bulan }} {{ $tagihan->tahun }}</small><br>
                    <small>Jatuh tempo: {{ date('d/m/Y', strtotime($tagihan->jatuh_tempo)) }}</small>
                </div>
                @endforeach
                @if($tagihan_jatuh_tempo->count() == 0)
                <div class="text-center text-muted">Tidak ada tagihan jatuh tempo</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('paymentChart');
    if (canvas) {
        // **PERBAIKAN: Hapus chart yang sudah ada jika canvas sudah digunakan**
        if (canvas.chart) {
            canvas.chart.destroy();
        }
        
        // Data dari controller
        const chartData = @json($chart_data ?? array_fill(0, 12, 0));
        
        console.log('Data grafik:', chartData);
        
        // Hitung total dari chart data
        const totalDariGrafik = chartData.reduce((a, b) => a + b, 0);
        const totalPembayaran = {{ $total_pembayaran ?? 0 }};
        
        console.log('Total dari grafik: Rp ' + totalDariGrafik);
        console.log('Total pembayaran: Rp ' + totalPembayaran);
        
        // **PERBAIKAN: Simpan chart instance ke canvas**
        canvas.chart = new Chart(canvas, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pembayaran (Rp)',
                    data: chartData,
                    backgroundColor: '#2563EB',
                    borderRadius: 6,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { 
                            font: { size: 10 },
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                                }
                                if (value >= 1000) {
                                    return 'Rp ' + (value / 1000).toFixed(0) + ' rb';
                                }
                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush