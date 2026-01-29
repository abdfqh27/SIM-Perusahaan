@extends('admin.layouts.app')

@section('title', 'Kelola Tentang Perusahaan')

@section('content')

<style>
.tentang-admin-container {
    max-width: 1400px;
    margin: 0 auto;
}

.tentang-card {
    margin-bottom: 2rem;
}

.form-section {
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
    border-left: 4px solid var(--orange-primary);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e9ecef;
}

.section-header i {
    font-size: 1.5rem;
    color: var(--orange-primary);
}

.section-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--blue-dark);
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label i {
    color: var(--orange-primary);
}

.form-text {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.85rem;
    color: #6c757d;
}

.current-image-wrapper {
    margin-bottom: 1.5rem;
}

.current-image-label {
    font-weight: 600;
    color: var(--blue-dark);
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.current-image-container {
    position: relative;
    display: inline-block;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    cursor: pointer;
}

.current-image {
    max-width: 100%;
    max-height: 400px;
    display: block;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.current-image-container:hover .current-image {
    transform: scale(1.05);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.current-image-container:hover .image-overlay {
    opacity: 1;
}

.image-overlay i {
    color: white;
    font-size: 2.5rem;
}

.custom-file-upload {
    position: relative;
    margin-bottom: 1rem;
}

.custom-file-upload input[type="file"] {
    position: absolute;
    left: -9999px;
}

.file-label {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    color: white;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    box-shadow: 0 3px 10px rgba(33, 158, 188, 0.3);
}

.file-label:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(33, 158, 188, 0.5);
}

.file-label i {
    font-size: 1.2rem;
}

.image-preview {
    margin-top: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    border: 2px dashed #dee2e6;
}

.preview-label {
    font-weight: 600;
    color: var(--blue-dark);
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.image-preview img {
    max-width: 100%;
    max-height: 400px;
    border-radius: 10px;
    display: block;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.form-actions {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.btn-outline-secondary {
    color: #6c757d;
    border: 2px solid #6c757d;
    background: transparent;
}

.btn-outline-secondary:hover {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    border-color: #6c757d;
    color: white;
}

@media (max-width: 768px) {
    .form-section {
        padding: 1rem;
    }
    
    .section-header h3 {
        font-size: 1.1rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="tentang-admin-container">
    {{-- Bagian Header --}}
    <div class="gradient-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <h2 class="header-title">Tentang Kami</h2>
                <p class="header-subtitle">Informasi tentang perusahaan</p>
            </div>
        </div>
    </div>

    {{-- Pesan Alert --}}
    @if(session('success'))
    <div class="alert alert-success custom-alert">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger custom-alert">
        <i class="fas fa-exclamation-circle"></i>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Card Form --}}
    <div class="card tentang-card">
        <div class="card-header">
            <i class="fas fa-edit"></i>
            Form Informasi Perusahaan
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tentang.update') }}" method="POST" enctype="multipart/form-data" id="tentangForm">
                @csrf
                @method('PUT')

                {{-- Sejarah Section --}}
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-history"></i>
                        <h3>Sejarah Perusahaan</h3>
                    </div>
                    <div class="form-group">
                        <label for="sejarah" class="form-label">
                            <i class="fas fa-book"></i> Sejarah
                        </label>
                        <textarea 
                            class="form-control @error('sejarah') is-invalid @enderror" 
                            id="sejarah" 
                            name="sejarah" 
                            rows="6"
                            placeholder="Tuliskan sejarah singkat perusahaan...">{{ old('sejarah', $tentang->sejarah) }}</textarea>
                        @error('sejarah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Ceritakan perjalanan dan perkembangan perusahaan Anda</small>
                    </div>
                </div>

                {{-- Visi Misi Section --}}
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-eye"></i>
                        <h3>Visi & Misi</h3>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="visi" class="form-label">
                                    <i class="fas fa-bullseye"></i> Visi
                                </label>
                                <textarea 
                                    class="form-control @error('visi') is-invalid @enderror" 
                                    id="visi" 
                                    name="visi" 
                                    rows="5"
                                    placeholder="Visi perusahaan...">{{ old('visi', $tentang->visi) }}</textarea>
                                @error('visi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text">Tujuan jangka panjang perusahaan</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="misi" class="form-label">
                                    <i class="fas fa-tasks"></i> Misi
                                </label>
                                <textarea 
                                    class="form-control @error('misi') is-invalid @enderror" 
                                    id="misi" 
                                    name="misi" 
                                    rows="5"
                                    placeholder="Misi perusahaan...">{{ old('misi', $tentang->misi) }}</textarea>
                                @error('misi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text">Langkah-langkah mencapai visi</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Nilai Perusahaan Section --}}
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-star"></i>
                        <h3>Nilai Perusahaan</h3>
                    </div>
                    <div class="form-group">
                        <label for="nilai_perusahaan" class="form-label">
                            <i class="fas fa-heart"></i> Nilai-Nilai Perusahaan
                        </label>
                        <textarea 
                            class="form-control @error('nilai_perusahaan') is-invalid @enderror" 
                            id="nilai_perusahaan" 
                            name="nilai_perusahaan" 
                            rows="6"
                            placeholder="Nilai-nilai yang dijunjung tinggi...">{{ old('nilai_perusahaan', $tentang->nilai_perusahaan) }}</textarea>
                        @error('nilai_perusahaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Prinsip dan budaya kerja perusahaan</small>
                    </div>
                </div>

                {{-- Pengalaman Section --}}
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-award"></i>
                        <h3>Pengalaman</h3>
                    </div>
                    <div class="form-group">
                        <label for="pengalaman" class="form-label">
                            <i class="fas fa-briefcase"></i> Pengalaman & Pencapaian
                        </label>
                        <textarea 
                            class="form-control @error('pengalaman') is-invalid @enderror" 
                            id="pengalaman" 
                            name="pengalaman" 
                            rows="5"
                            placeholder="Pengalaman dan pencapaian perusahaan...">{{ old('pengalaman', $tentang->pengalaman) }}</textarea>
                        @error('pengalaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Prestasi dan pengalaman penting perusahaan</small>
                    </div>
                </div>

                {{-- Gambar Perusahaan --}}
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-image"></i>
                        <h3>Gambar Perusahaan</h3>
                    </div>
                    <div class="form-group">
                        <label for="gambar_perusahaan" class="form-label">
                            <i class="fas fa-camera"></i> Upload Gambar
                        </label>
                        
                        @if($tentang->gambar_perusahaan)
                        <div class="current-image-wrapper">
                            <div class="current-image-label">Gambar Saat Ini:</div>
                            <div class="current-image-container">
                                <img src="{{ asset('storage/' . $tentang->gambar_perusahaan) }}" 
                                     alt="Gambar Perusahaan" 
                                     class="current-image"
                                     id="currentImage">
                                <div class="image-overlay">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="custom-file-upload">
                            <input 
                                type="file" 
                                class="form-control-file" 
                                id="gambar_perusahaan" 
                                name="gambar_perusahaan"
                                accept="image/jpeg,image/jpg,image/png"
                                onchange="previewImage(this)">
                            <label for="gambar_perusahaan" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Pilih Gambar Baru</span>
                            </label>
                        </div>
                        
                        <div id="imagePreview" class="image-preview" style="display: none;">
                            <div class="preview-label">Preview Gambar Baru:</div>
                            <img id="preview" src="" alt="Preview">
                        </div>
                        
                        @error('gambar_perusahaan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        
                        <small class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Format: JPG, JPEG, PNG | Maksimal: 10MB
                        </small>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-undo"></i>
                        Reset
                    </button>
                    <a href="{{ route('tentang') }}" class="btn btn-outline-primary" target="_blank">
                        <i class="fas fa-eye"></i>
                        Preview Halaman
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Preview Gambar
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.style.display = 'none';
        }
    }

    // Zoom Image
    document.addEventListener('DOMContentLoaded', function() {
        const currentImage = document.getElementById('currentImage');
        if (currentImage) {
            currentImage.addEventListener('click', function() {
                window.open(this.src, '_blank');
            });
        }
    });

    // Form Submit dengan Konfirmasi
    document.getElementById('tentangForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Konfirmasi Penyimpanan',
            html: 'Apakah Anda yakin ingin menyimpan informasi perusahaan ini?<br><small class="text-muted">Pastikan semua data sudah benar sebelum menyimpan.</small>',
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

    // Reset button confirmation
    document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Reset Form?',
            text: 'Semua perubahan yang belum disimpan akan hilang!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, Reset',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('tentangForm').reset();
                document.getElementById('imagePreview').style.display = 'none';
                
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Form telah direset',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });
</script>
@endpush

@endsection