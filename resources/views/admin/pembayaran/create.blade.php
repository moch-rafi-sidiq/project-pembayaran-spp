@extends('layouts.admin')

@section('title', 'Tambah Pembayaran')
@section('header', 'Form Tambah Pembayaran')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Form Tambah Pembayaran</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.pembayaran.store') }}">
            @csrf
            
            <!-- FILTER KELAS & JURUSAN -->
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Filter Kelas</label>
                    <select id="filterKelasSiswa" class="form-select">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Filter Jurusan</label>
                    <select id="filterJurusanSiswa" class="form-select">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusan as $j)
                            <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Siswa <span class="text-danger">*</span></label>
                    <select name="siswa_id" id="siswaSelect" class="form-select" required>
                        <option value="">Cari NIS atau Nama Siswa...</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id }}" 
                                data-kelas="{{ $s->kelas_id }}" 
                                data-jurusan="{{ $s->jurusan_id }}">
                                {{ $s->nis }} - {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- SPP & BULAN -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">SPP <span class="text-danger">*</span></label>
                    <select name="spp_id" class="form-select" required>
                        <option value="">Pilih Tahun SPP</option>
                        @foreach($spp as $s)
                            <option value="{{ $s->id }}">{{ $s->tahun }} - Rp {{ number_format($s->nominal,0,',','.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Bulan <span class="text-danger">*</span></label>
                    <select name="bulan" class="form-select" required>
                        <option value="">Pilih Bulan</option>
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                            <option value="{{ $b }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tahun <span class="text-danger">*</span></label>
                    <input type="text" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Bayar <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Metode <span class="text-danger">*</span></label>
                    <select name="metode" class="form-select" required>
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="Lunas">Lunas</option>
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                    </select>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Inisialisasi Select2
    var siswaSelect = $('#siswaSelect').select2({
        placeholder: 'Cari NIS atau Nama Siswa...',
        allowClear: true,
        width: '100%'
    });

    // Event filter
    $('#filterKelasSiswa, #filterJurusanSiswa').on('change', function() {
        applyFilters();
    });

    function applyFilters() {
        var kelasId = $('#filterKelasSiswa').val();
        var jurusanId = $('#filterJurusanSiswa').val();

        // Hapus semua option di Select2
        siswaSelect.find('option').remove();

        // Tambahkan option placeholder
        siswaSelect.append($('<option>', {
            value: '',
            text: 'Cari NIS atau Nama Siswa...'
        }));

        // Ambil data siswa dari variable PHP
        var siswaData = @json($siswa);
        var filtered = siswaData;

        if (kelasId) {
            filtered = filtered.filter(function(s) {
                return s.kelas_id == kelasId;
            });
        }
        if (jurusanId) {
            filtered = filtered.filter(function(s) {
                return s.jurusan_id == jurusanId;
            });
        }

        // Tambahkan option yang sudah difilter
        filtered.forEach(function(s) {
            siswaSelect.append($('<option>', {
                value: s.id,
                text: s.nis + ' - ' + s.name,
                'data-kelas': s.kelas_id,
                'data-jurusan': s.jurusan_id
            }));
        });

        // Refresh Select2
        siswaSelect.trigger('change');

        // Update placeholder
        var kelasText = $('#filterKelasSiswa option:selected').text();
        var jurusanText = $('#filterJurusanSiswa option:selected').text();
        var placeholder = 'Cari NIS atau Nama Siswa...';
        if (kelasId && jurusanId) {
            placeholder = 'Cari siswa di ' + kelasText + ' - ' + jurusanText + '...';
        } else if (kelasId) {
            placeholder = 'Cari siswa di ' + kelasText + '...';
        } else if (jurusanId) {
            placeholder = 'Cari siswa jurusan ' + jurusanText + '...';
        }
        siswaSelect.attr('placeholder', placeholder);
        siswaSelect.trigger('change');
    }

    // Jalankan filter pertama kali
    applyFilters();
});
</script>
@endpush