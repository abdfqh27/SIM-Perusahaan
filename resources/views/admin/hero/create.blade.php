@extends('admin.layouts.app')

@section('title', 'Tambah Hero Section')

@section('content')
<style>
    .create-hero-card {
        margin-bottom: 2rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--blue-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-title i {
        color: var(--orange-primary);
        font-size: 1.3rem;
    }
    
    .image-upload-area {
        border: 2px dashed #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .image-upload-area:hover {
        border-color: var(--orange-primary);
        background: rgba(251, 133, 0, 0.05);
    }
    
    .upload-icon {
        font-size: 3rem;
        color: var(--orange-primary);
        margin-bottom: 1rem;
    }
    
    #imagePreview img {
        border-radius: 12px;
        margin-top: 1rem;
    }
    
    .current-image-label {
        font-weight: 600;
        color: var(--blue-dark);
        margin-bottom: 0.75rem;
        display: block;
    }
</style>

<div class="page-header mb-4">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-plus-circle"></i>
        </div>
        <div>
            <h2 class="page-title mb-0">Tambah Hero Section</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.hero.index') }}">Hero Section</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card create-hero-card">
    <div class="card-header">
        <i class="fas fa-edit me-2"></i> Form Tambah Hero Section
    </div>
    <div class="card-body">
        <form id="heroForm" action="{{ route('admin.hero.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Informasi Utama -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-info-circle"></i>
                    <span>Informasi Utama</span>
                </div>
                
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" 
                           name="judul" 
                           value="{{ old('judul') }}" 
                           placeholder="Masukkan judul hero section"
                           required>
                    @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" 
                              name="deskripsi" 
                              rows="4"
                              placeholder="Masukkan deskripsi hero section (opsional)">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tombol Call to Action -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-mouse-pointer"></i>
                    <span>Tombol Call to Action</span>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tombol_text" class="form-label">Teks Tombol</label>
                        <input type="text" 
                               class="form-control @error('tombol_text') is-invalid @enderror" 
                               id="tombol_text" 
                               name="tombol_text" 
                               value="{{ old('tombol_text') }}"
                               placeholder="Contoh: Selengkapnya">
                        @error('tombol_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tombol_link" class="form-label">Link Tombol</label>
                        <input type="text" 
                               class="form-control @error('tombol_link') is-invalid @enderror" 
                               id="tombol_link" 
                               name="tombol_link" 
                               value="{{ old('tombol_link') }}"
                               placeholder="Contoh: /tentang-kami">
                        @error('tombol_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Gambar Hero -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-image"></i>
                    <span>Gambar Hero</span>
                </div>
                
                <div class="mb-3">
                    <label for="gambar" class="form-label">Upload Gambar</label>
                    <div class="image-upload-area">
                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                        <input type="file" 
                               class="form-control @error('gambar') is-invalid @enderror" 
                               id="gambar" 
                               name="gambar" 
                               accept="image/jpeg,image/jpg,image/png"
                               onchange="previewImage(event)">
                        <small class="text-muted d-block mt-2">
                            Format: JPG, PNG | Maksimal: 10MB | Rekomendasi: 1920x1080px
                        </small>
                    </div>
                    @error('gambar')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div id="imagePreview"></div>
                </div>
            </div>

            <!-- Pengaturan -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="urutan" class="form-label">Urutan Tampilan <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control @error('urutan') is-invalid @enderror" 
                               id="urutan" 
                               name="urutan" 
                               value="{{ old('urutan', 0) }}" 
                               min="0"
                               placeholder="0"
                               required>
                        <small class="text-muted">Semakin kecil angka, semakin awal ditampilkan</small>
                        @error('urutan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="aktif" class="form-label">Status Tampilan</label>
                        <select class="form-control @error('aktif') is-invalid @enderror" 
                                id="aktif" 
                                name="aktif">
                            <option value="1" {{ old('aktif', 1) == 1 ? 'selected' : '' }}>Aktif (Ditampilkan)</option>
                            <option value="0" {{ old('aktif') == 0 ? 'selected' : '' }}>Nonaktif (Disembunyikan)</option>
                        </select>
                        @error('aktif')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.hero.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// FUNGSI PREVIEW GAMBAR
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        // Validasi ukuran file (maksimal 10MB)
        if (file.size > 10240 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar',
                text: 'Ukuran file maksimal 10MB',
                confirmButtonText: 'OK'
            });
            event.target.value = '';
            preview.innerHTML = '';
            return;
        }
        
        // Validasi tipe file gambar
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Format File Tidak Valid',
                text: 'Hanya file JPG, JPEG, dan PNG yang diperbolehkan',
                confirmButtonText: 'OK'
            });
            event.target.value = '';
            preview.innerHTML = '';
            return;
        }
        
        // Membaca file dan menampilkan preview gambar
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="mt-3">
                    <span class="current-image-label">Preview Gambar:</span>
                    <img src="${e.target.result}" class="img-thumbnail" style="max-width: 100%; max-height: 400px;">
                </div>
            `;
        };
        reader.readAsDataURL(file);
    } else {
        // Mengosongkan preview jika tidak ada file yang dipilih
        preview.innerHTML = '';
    }
}

// SUBMIT FORM DENGAN KONFIRMASI
document.getElementById('heroForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Konfirmasi Penyimpanan',
        html: 'Apakah Anda yakin ingin menyimpan data hero section ini?<br><small class="text-muted">Pastikan semua data sudah benar sebelum menyimpan.</small>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check"></i> Ya, Simpan',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Menampilkan indikator loading
            Swal.fire({
                title: 'Menyimpan Data...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Mengirim form
            this.submit();
        }
    });
});
</script>
@endpush