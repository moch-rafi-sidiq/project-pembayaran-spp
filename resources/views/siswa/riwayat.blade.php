@extends('layouts.siswa')

@section('title', 'Riwayat Pembayaran')
@section('header', 'Riwayat Pembayaran')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">
        <i class="fas fa-history me-2"></i>Riwayat Pembayaran SPP
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Bayar</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $index => $r)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ date('d/m/Y', strtotime($r->tanggal_bayar)) }}</td>
                        <td>{{ $r->bulan }}</td>
                        <td>{{ $r->tahun }}</td>
                        <td>Rp {{ number_format($r->jumlah, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-info">{{ $r->metode }}</span>
                        </td>
                        <td>
                            @if($r->status == 'Lunas')
                                <span class="badge bg-success">Lunas</span>
                            @elseif($r->status == 'Menunggu Verifikasi')
                                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                            @else
                                <span class="badge bg-danger">Belum Lunas</span>
                            @endif
                        </td>
                        <td>
                            @if($r->bukti_pembayaran)
                                <a href="{{ route('siswa.riwayat.download', $r->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada riwayat pembayaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection