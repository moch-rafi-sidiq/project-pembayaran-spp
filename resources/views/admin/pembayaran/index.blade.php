@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')
@section('header', 'Data Pembayaran')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div class="fw-bold"><i class="fas fa-credit-card me-2"></i>Data Pembayaran</div>
        <a href="{{ route('admin.pembayaran.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Pembayaran
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
    <div class="col-md-4">
        <input type="text" id="searchPembayaran" class="form-control" placeholder=" Cari NIS atau nama siswa...">
    </div>
</div>
        <div class="table-responsive">
            <table class="table table-hover" id="pembayaranTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>NIS</th>
                        <th>Siswa</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Status</th>
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
                            @if($p->status == 'Lunas')
                                <span class="badge bg-success">Lunas</span>
                            @elseif($p->status == 'Menunggu Verifikasi')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @else
                                <span class="badge bg-danger">Belum Lunas</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $p->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">Belum ada data pembayaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $pembayaran->links() }}
    </div>
</div>

<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        Swal.fire({
            title: 'Hapus Pembayaran?',
            text: 'Yakin ingin menghapus data pembayaran ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/admin/pembayaran/${this.dataset.id}`;
                deleteForm.submit();
            }
        });
    });
});
</script>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#searchPembayaran').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#pembayaranTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>
@endpush
@endsection