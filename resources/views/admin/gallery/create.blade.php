@extends('admin.layouts.app')

@section('title', 'Tambah Gallery')

@section('content')
<style>
    /* Form Switch Large */
    .form-switch-lg {
        padding-left: 3rem;
    }

    .form-switch-lg .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
    }

    .form-check-label {
        cursor: pointer;
        font-weight: 500;
        color: var(--blue-dark);
    }

    /* Image Preview */
    .image-preview-container {
        margin-top: 1.5rem;
        position: relative;
        border: 2px dashed #e9ecef;
        border-radius: 15px;
        padding: 1.5rem;
        background: #f8f9fa;
    }

    .preview-label {
        font-weight: 600;
        color: var(--blue-dark);
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .preview-image {
        width: 100%;
        max-width: 500px;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        display: block;
    }

    .btn-remove-preview {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        border-radius: 50%;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
    }

    .btn-remove-preview:hover {
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.5);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #e9ecef;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn-primary,
        .form-actions .btn-secondary {
            width: 100%;
            justify-content: center;
        }

        .preview-image {
            max-width: 100%;
        }
    }
</style>
<!-- Gradient Header -->
<div class="gradient-header">
    <div class="header-left">
        <a href="{{ route('admin.gallery.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="header-icon">
            <i class="fas fa-plus-circle"></i>
        </div>
        <div>
            <h1 class="header-title">Tambah Gallery Baru</h1>
            <p class="header-subtitle">Tambahkan foto ke koleksi gallery</p>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-edit me-2"></i>
        Form Tambah Gallery
    </div>
    <div class="card-body">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" id="galleryForm">
            @csrf

            <div class="row">
                <!-- Judul -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="judul" class="form-label">
                            Judul Gallery <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul') }}"
                               placeholder="Masukkan judul gallery"
                               required>
                        @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Kategori -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select @error('kategori') is-invalid @enderror" 
                                id="kategori" 
                                name="kategori">
                            <option value="">Pilih Kategori</option>
                            @foreach($daftarKategori as $key => $value)
                            <option value="{{ $key }}" {{ old('kategori') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                            @endforeach
                        </select>
                        @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" 
                          name="deskripsi" 
                          rows="4"
                          placeholder="Masukkan deskripsi gallery (opsional)">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Deskripsi singkat tentang foto ini</small>
            </div>

            <!-- Upload Gambar -->
            <div class="mb-3">
                <label for="gambar" class="form-label">
                    Gambar <span class="text-danger">*</span>
                </label>
                <input type="file" 
                       class="form-control @error('gambar') is-invalid @enderror" 
                       id="gambar" 
                       name="gambar"
                       accept="image/jpeg,image/jpg,image/png,image/webp"
                       required>
                @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">
                    Format: JPG, JPEG, PNG, WebP | Maksimal: 10MB | Otomatis dikonversi ke WebP HD
                </small>
                
                <!-- Preview -->
                <div id="imagePreview" class="image-preview-container" style="display: none;">
                    <div class="preview-label">Preview Gambar:</div>
                    <img id="previewImage" src="" alt="Preview" class="preview-image">
                    <button type="button" class="btn-remove-preview" id="removePreview">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Urutan (Read-only) -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="urutan" class="form-label">Urutan</label>
                        <input type="number" 
                               class="form-control" 
                               id="urutan" 
                               name="urutan" 
                               value="{{ $nextUrutan }}"
                               readonly>
                        <small class="text-muted">Urutan otomatis: {{ $nextUrutan }}</small>
                    </div>
                </div>

                <!-- Status Tampilkan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label d-block">Status Tampilan</label>
                        <div class="form-check form-switch form-switch-lg">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="tampilkan" 
                                   name="tampilkan"
                                   {{ old('tampilkan', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tampilkan">
                                <span id="statusLabel">Tampilkan di website</span>
                            </label>
                        </div>
                        <small class="text-muted">Gallery akan ditampilkan di halaman depan</small>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save me-2"></i>
                    Simpan Gallery
                </button>
                <a href="{{ route('admin.gallery.index') }}" class="btn-secondary">
                    <i class="fas fa-times me-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gambarInput = document.getElementById('gambar');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const removePreview = document.getElementById('removePreview');
        const tampilkanCheckbox = document.getElementById('tampilkan');
        const statusLabel = document.getElementById('statusLabel');
        const galleryForm = document.getElementById('galleryForm');

        // Image Preview
        gambarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Tidak Valid',
                        text: 'Hanya file JPG, JPEG, PNG, dan WebP yang diperbolehkan!'
                    });
                    gambarInput.value = '';
                    return;
                }

                // Validate file size (10MB)
                if (file.size > 10 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal 10MB!'
                    });
                    gambarInput.value = '';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove Preview
        removePreview.addEventListener('click', function() {
            gambarInput.value = '';
            previewImage.src = '';
            imagePreview.style.display = 'none';
        });

        // Toggle Status Label
        tampilkanCheckbox.addEventListener('change', function() {
            if (this.checked) {
                statusLabel.textContent = 'Tampilkan di website';
            } else {
                statusLabel.textContent = 'Sembunyikan dari website';
            }
        });

        // Form Submit Confirmation
        galleryForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate gambar
            if (!gambarInput.files.length) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gambar Wajib Diupload',
                    text: 'Silakan upload gambar terlebih dahulu!'
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Simpan',
                text: "Apakah data gallery sudah benar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Periksa Lagi',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menyimpan...',
                        html: 'Sedang mengupload dan memproses gambar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    galleryForm.submit();
                }
            });
        });
    });
</script>
@endpush