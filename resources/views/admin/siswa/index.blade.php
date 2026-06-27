@extends('layouts.admin')

@section('title', 'Data Siswa')
@section('header', 'Manajemen Data Siswa')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div class="fw-bold">Data Siswa</div>
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Siswa
        </a>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <form method="GET" class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari NIS/Nama" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="kelas_id" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="jurusan_id" class="form-select">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusan as $j)
                    <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover" id="siswaTable">
                <thead>
                    <tr>
                        <th>NIS</th><th>Nama</th><th>JK</th><th>Kelas</th><th>Jurusan</th><th>Tahun Ajaran</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $s)
                    <tr>
                        <td>{{ $s->nis }}</td>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $s->jurusan->nama_jurusan ?? '-' }}</td>
                        <td>{{ $s->tahun_ajaran }}</td>
                        <td>
                            <span class="badge bg-{{ $s->status_aktif ? 'success' : 'danger' }}">
                                {{ $s->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $s->id }}" data-name="{{ $s->name }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $siswa->links() }}
    </div>
</div>

<form id="deleteForm" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>

@push('scripts')
<script>
    document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        confirmDelete(`/admin/siswa/${id}`, name, function() {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/admin/siswa/${id}`;
            deleteForm.submit();
        });
    });
});
</script>
@endpush
@endsection