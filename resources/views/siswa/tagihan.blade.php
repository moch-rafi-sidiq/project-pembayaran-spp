@extends('layouts.siswa')

@section('title', 'Tagihan SPP')
@section('header', 'Tagihan SPP')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">
        <i class="fas fa-file-invoice me-2"></i>Daftar Tagihan SPP
    </div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
<th>Bulan</th>
<th>Tahun</th>
<th>Nominal</th>
<th>Keterangan</th>
<th>Status</th>
<th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihan as $index => $t)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $t->bulan }}</td>
                        <td>{{ $t->tahun }}</td>
                        <td>Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                         <td>{{ $t->spp->keterangan ?? '-' }}</td>
                        <td>
                            @if($t->status == 'Lunas')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-danger">Belum Lunas</span>
                            @endif
                        </td>
                        <td>
                            @if($t->status != 'Lunas')
                                <button type="button" class="btn btn-primary btn-sm bayar-btn" 
                                    data-bulan="{{ $t->bulan }}"
                                    data-tahun="{{ $t->tahun }}"
                                    data-nominal="{{ $t->nominal }}">
                                    <i class="fas fa-credit-card"></i> Bayar
                                </button>
                            @else
                                <span class="text-success"><i class="fas fa-check-circle"></i> Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada tagihan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Bayar -->
<div class="modal fade" id="bayarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('siswa.tagihan.bayar') }}" enctype="multipart/form-data" id="formBayar">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="bulan" id="bulan">
                    <input type="hidden" name="tahun" id="tahun">
                    
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode" class="form-select" required>
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
    <label class="form-label">Bukti Pembayaran</label>
    <input type="file" name="bukti" class="form-control" accept="image/*" id="buktiInput">
    <small class="text-muted">Upload bukti pembayaran (opsional, maks 2MB)</small>
    
    <!-- Thumbnail preview -->
    <div id="previewContainer" class="mt-2" style="display: none;">
        <img id="buktiPreview" src="#" alt="Preview" style="max-width: 100%; max-height: 150px; border-radius: 8px; border: 1px solid #ddd; padding: 5px;">
        <button type="button" id="removeImage" class="btn btn-danger btn-sm mt-1">Hapus</button>
    </div>
</div>
                    
                    <div class="alert alert-info">
                        <strong>Tagihan:</strong> <span id="infoTagihan"></span><br>
                        <strong>Nominal:</strong> Rp <span id="infoNominal"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Event listener untuk tombol bayar
    document.querySelectorAll('.bayar-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('bulan').value = this.dataset.bulan;
            document.getElementById('tahun').value = this.dataset.tahun;
            document.getElementById('infoTagihan').innerText = this.dataset.bulan + ' ' + this.dataset.tahun;
            document.getElementById('infoNominal').innerText = parseInt(this.dataset.nominal).toLocaleString('id-ID');
            
            var bayarModal = new bootstrap.Modal(document.getElementById('bayarModal'));
            bayarModal.show();
        });
    });
    
    // Compress gambar sebelum upload
    const formBayar = document.getElementById('formBayar');
    if (formBayar) {
        formBayar.addEventListener('submit', function(e) {
            const fileInput = this.querySelector('input[name="bukti"]');
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                if (file.size > 1024 * 1024) {
                    e.preventDefault();
                    compressImage(file, function(compressedBlob) {
                        const newFile = new File([compressedBlob], file.name.replace(/\.[^/.]+$/, '.jpg'), { type: 'image/jpeg' });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(newFile);
                        fileInput.files = dataTransfer.files;
                        formBayar.submit();
                    });
                }
            }
        });
    }
    
    function compressImage(file, callback) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(event) {
            const img = new Image();
            img.src = event.target.result;
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const maxWidth = 800;
                const scale = maxWidth / img.width;
                canvas.width = maxWidth;
                canvas.height = img.height * scale;
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                canvas.toBlob(callback, 'image/jpeg', 0.7);
            };
        };
    }

    // Preview gambar sebelum upload
const buktiInput = document.getElementById('buktiInput');
const previewContainer = document.getElementById('previewContainer');
const buktiPreview = document.getElementById('buktiPreview');
const removeImage = document.getElementById('removeImage');

if (buktiInput) {
    buktiInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                buktiPreview.src = event.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
            buktiPreview.src = '#';
        }
    });
    
    removeImage.addEventListener('click', function() {
        buktiInput.value = '';
        previewContainer.style.display = 'none';
        buktiPreview.src = '#';
    });
}
</script>
@endpush
@endsection