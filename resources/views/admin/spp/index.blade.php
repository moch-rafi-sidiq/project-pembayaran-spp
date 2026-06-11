@extends('layouts.admin')

@section('title', 'Manajemen SPP')
@section('header', 'Data SPP')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div class="fw-bold"><i class="fas fa-file-invoice-dollar me-2"></i>Data SPP</div>
        <a href="/admin/spp/create" class="btn btn-primary btn-sm">+ Tambah SPP</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($spp as $index => $s)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $s->tahun }}</td>
                        <td>Rp {{ number_format($s->nominal, 0, ',', '.') }}</td>
                        <td>{{ $s->keterangan }}</td>
                        <td>
                            <a href="/admin/spp/{{ $s->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/admin/spp/{{ $s->id }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus SPP {{ $s->tahun }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data SPP</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
EOF