@extends('layouts.admin')

@section('title', 'Manajemen Jurusan')
@section('header', 'Data Jurusan')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div class="fw-bold"><i class="fas fa-book me-2"></i>Data Jurusan</div>
        <a href="/admin/jurusan/create" class="btn btn-primary btn-sm">+ Tambah Jurusan</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>No</th><th>Kode Jurusan</th><th>Nama Jurusan</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($jurusan as $index => $j)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $j->kode_jurusan }}</td>
                        <td>{{ $j->nama_jurusan }}</td>
                        <td>
                            <a href="/admin/jurusan/{{ $j->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/admin/jurusan/{{ $j->id }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus {{ $j->nama_jurusan }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <td><td colspan="4" class="text-center">Belum ada data jurusan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
EOF