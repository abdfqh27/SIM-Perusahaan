@extends('admin.layouts.app')

@section('title', 'Edit Gallery')

@section('content')
<style>
    /* Current Image */
    .current-image-container {
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 1.5rem;
        background: #f8f9fa;
        text-align: center;
    }

    .current-image {
        max-width: 100%;
        max-height: 400px;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    .current-image-info {
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 500;
    }

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
        border: 2px dashed var(--orange-primary);
        border-radius: 15px;
        padding: 1.5rem;
        background: rgba(251, 133, 0, 0.05);
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

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid var(--orange-primary);
    }

    .info-label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .info-value {
        font-size: 1rem;
        color: var(--blue-dark);
        font-weight: 600;
    }

    /* Alert Info Custom */
    .alert-info {
        background: linear-gradient(135deg, rgba(33, 158, 188, 0.1), rgba(33, 158, 188, 0.05));
        border: none;
        border-left: 4px solid var(--blue-light);
        color: var(--blue-dark);
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

        .current-image {
            max-height: 300px;
        }

        .preview-image {
            max-width: 100%;
        }

        .info-grid {
            grid-template-columns: 1fr;
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
            <i class="fas fa-edit"></i>
        </div>
        <div>
            <h1 class="header-title">Edit Gallery</h1>
            <p class="header-subtitle">Ubah informasi gallery: {{ $gallery->judul }}</p>
        </div>
    </div>
    <div class="header-actions">
        <form action="{{ route('admin.gallery.destroy', $gallery) }}" 
              method="POST" 
              class="delete-form d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete">
                <i class="fas fa-trash me-2"></i>
                <span>Hapus</span>
            </button>
        </form>
    </div>
</div>

<!-- Form Card -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-edit me-2"></i>
        Form Edit Gallery
    </div>
    <div class="card-body">
        <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data" id="galleryForm">
            @csrf
            @method('PUT')

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
                               value="{{ old('judul', $gallery->judul) }}"
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
                            <option value="{{ $key }}" {{ old('kategori', $gallery->kategori) == $key ? 'selected' : '' }}>
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
                          placeholder="Masukkan deskripsi gallery (opsional)">{{ old('deskripsi', $gallery->deskripsi) }}</textarea>
                @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Gambar Saat Ini -->
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label>
                <div class="current-image-container">
                    <img src="{{ asset('storage/' . $gallery->gambar) }}" 
                         alt="{{ $gallery->judul }}"
                         class="current-image"
                         id="currentImage">
                    <div class="current-image-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Upload gambar baru untuk mengganti
                    </div>
                </div>
            </div>

            <!-- Upload Gambar Baru -->
            <div class="mb-3">
                <label for="gambar" class="form-label">
                    Gambar Baru <small class="text-muted">(Kosongkan jika tidak ingin mengganti)</small>
                </label>
                <input type="file" 
                       class="form-control @error('gambar') is-invalid @enderror" 
                       id="gambar" 
                       name="gambar"
                       accept="image/jpeg,image/jpg,image/png,image/webp">
                @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">
                    Format: JPG, JPEG, PNG, WebP | Maksimal: 10MB | Otomatis dikonversi ke WebP HD
                </small>
                
                <!-- Preview Gambar Baru -->
                <div id="imagePreview" class="image-preview-container" style="display: none;">
                    <div class="preview-label">
                        <i class="fas fa-images me-2"></i>
                        Preview Gambar Baru:
                    </div>
                    <img id="previewImage" src="" alt="Preview" class="preview-image">
                    <button type="button" class="btn-remove-preview" id="removePreview">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Urutan -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="urutan" class="form-label">
                            Urutan <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('urutan') is-invalid @enderror" 
                                id="urutan" 
                                name="urutan"
                                required>
                            @for($i = 1; $i <= $maxUrutan; $i++)
                            <option value="{{ $i }}" {{ old('urutan', $gallery->urutan) == $i ? 'selected' : '' }}>
                                {{ $i }}
                                @if($i == $gallery->urutan)
                                (Saat ini)
                                @endif
                            </option>
                            @endfor
                        </select>
                        @error('urutan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Ubah urutan untuk menggeser posisi gallery
                        </small>
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
                                   {{ old('tampilkan', $gallery->tampilkan) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tampilkan">
                                <span id="statusLabel">
                                    {{ old('tampilkan', $gallery->tampilkan) ? 'Tampilkan di website' : 'Sembunyikan dari website' }}
                                </span>
                            </label>
                        </div>
                        <small class="text-muted">Gallery akan ditampilkan di halaman depan</small>
                    </div>
                </div>
            </div>

            <!-- Info Urutan -->
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Info Urutan:</strong> Jika Anda mengubah urutan, gallery lain akan otomatis bergeser. 
                Misal: mengubah urutan dari 5 ke 2, maka gallery di urutan 2-4 akan bergeser ke 3-5.
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save me-2"></i>
                    Update Gallery
                </button>
                <a href="{{ route('admin.gallery.index') }}" class="btn-secondary">
                    <i class="fas fa-times me-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Gallery Info Card -->
<div class="card mt-3">
    <div class="card-header">
        <i class="fas fa-info-circle me-2"></i>
        Informasi Gallery
    </div>
    <div class="card-body">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Dibuat pada:</div>
                <div class="info-value">
                    {{ \App\Helpers\DateHelper::formatDateTimeIndonesia($gallery->created_at) }}
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Terakhir diupdate:</div>
                <div class="info-value">
                    {{ \App\Helpers\DateHelper::formatDateTimeIndonesia($gallery->updated_at) }}
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Ukuran file:</div>
                <div class="info-value">
                    {{ \App\Helpers\ImageHelper::humanFileSize($gallery->gambar) }}
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Dimensi:</div>
                <div class="info-value">
                    @php
                    $dimensions = \App\Helpers\ImageHelper::getDimensions($gallery->gambar);
                    @endphp
                    {{ $dimensions['width'] }} x {{ $dimensions['height'] }} px
                </div>
            </div>
        </div>
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
        const currentImage = document.getElementById('currentImage');
        const tampilkanCheckbox = document.getElementById('tampilkan');
        const statusLabel = document.getElementById('statusLabel');
        const galleryForm = document.getElementById('galleryForm');
        const deleteForms = document.querySelectorAll('.delete-form');

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
                    
                    // Dim current image
                    currentImage.style.opacity = '0.5';
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove Preview
        removePreview.addEventListener('click', function() {
            gambarInput.value = '';
            previewImage.src = '';
            imagePreview.style.display = 'none';
            currentImage.style.opacity = '1';
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

            Swal.fire({
                title: 'Konfirmasi Update',
                text: "Apakah Anda yakin ingin menyimpan perubahan?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Memperbarui...',
                        html: 'Sedang memproses perubahan',
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

        // Delete Confirmation
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    html: `Gallery <strong>{{ $gallery->judul }}</strong> akan dihapus permanen beserta gambarnya!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'swal2-confirm',
                        cancelButton: 'swal2-cancel'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Menghapus...',
                            html: 'Sedang menghapus gallery',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush