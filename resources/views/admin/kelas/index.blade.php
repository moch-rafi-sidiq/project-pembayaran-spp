@extends('layouts.admin')

@section('title', 'Manajemen Kelas')
@section('header', 'Data Kelas')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div class="fw-bold">Data Kelas</div>
        <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary btn-sm">+ Tambah Kelas</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>No</th><th>Nama Kelas</th><th>Tingkat</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($kelas as $index => $k)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->tingkat }}</td>
                        <td>
                            <a href="{{ route('admin.kelas.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <td><td colspan="4" class="text-center">Belum ada data kelas</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection