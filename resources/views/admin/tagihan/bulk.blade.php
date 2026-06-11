@extends('layouts.admin')
@section('title', 'Buat Tagihan Massal')
@section('header', 'Buat Tagihan Massal')
@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Generate Tagihan Bulanan</div>
    <div class="card-body">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        <form method="POST" action="{{ route('tagihan.bulk.generate') }}">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Bulan</label>
                    <select name="bulan" class="form-select" required>
                        <option value="">Pilih</option>
                        <option value="Januari">Januari</option><option value="Februari">Februari</option>
                        <option value="Maret">Maret</option><option value="April">April</option>
                        <option value="Mei">Mei</option><option value="Juni">Juni</option>
                        <option value="Juli">Juli</option><option value="Agustus">Agustus</option>
                        <option value="September">September</option><option value="Oktober">Oktober</option>
                        <option value="November">November</option><option value="Desember">Desember</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Pilih SPP</label>
                    <select name="spp_id" class="form-select" required>
                        <option value="">Pilih SPP</option>
                        @foreach($sppList as $s)
                            <option value="{{ $s->id }}">
                                {{ $s->tahun }} - Rp {{ number_format($s->nominal, 0, ',', '.') }} ({{ $s->keterangan }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </div>
        </form>
        <hr>
        <div class="alert alert-info">
            Jumlah siswa: {{ $siswa_count }}
        </div>
    </div>
</div>
@endsection