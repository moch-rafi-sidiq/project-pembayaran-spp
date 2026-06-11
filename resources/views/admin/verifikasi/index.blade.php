@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')
@section('header', 'Verifikasi Pembayaran')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">
        <i class="fas fa-check-circle me-2"></i>Pembayaran Menunggu Verifikasi
    </div>
    <div class="card-body">
        <div class="row mb-3">
    <div class="col-md-4">
        <input type="text" id="searchInput" class="form-control" placeholder=" Cari NIS atau nama siswa...">
    </div>
</div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-hover" id="verifikasiTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl Bayar</th>
                        <th>NIS</th>
                        <th>Siswa</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaran as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ date('d/m/Y', strtotime($p->tanggal_bayar)) }}</td>
                        <td>{{ $p->siswa->nis ?? '-' }}</td>
                        <td>{{ $p->siswa->name ?? '-' }}</td>
                        <td>{{ $p->bulan }}</td>
                        <td>{{ $p->tahun }}</td>
                        <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                        <td><span class="badge bg-info">{{ $p->metode }}</span></td>
                        <td>
                            @if($p->bukti_pembayaran)
                                <a href="{{ Storage::url($p->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm verify-btn" data-id="{{ $p->id }}">
                                <i class="fas fa-check"></i> Verifikasi
                            </button>
                            <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $p->id }}">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada pembayaran menunggu verifikasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="verifyForm" method="POST" style="display:none;">@csrf</form>
<form id="rejectForm" method="POST" style="display:none;">@csrf</form>

@push('scripts')
<script>
    document.querySelectorAll('.verify-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            Swal.fire({
                title: 'Verifikasi Pembayaran?',
                text: 'Pastikan pembayaran sudah valid',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Ya, Verifikasi'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('verifyForm');
                    form.action = `/admin/verifikasi/${this.dataset.id}`;
                    form.submit();
                }
            });
        });
    });
    
    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            Swal.fire({
                title: 'Tolak Pembayaran?',
                text: 'Yakin menolak pembayaran ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Tolak'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('rejectForm');
                    form.action = `/admin/verifikasi/${this.dataset.id}/tolak`;
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#verifikasiTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>
@endpush
@endsection