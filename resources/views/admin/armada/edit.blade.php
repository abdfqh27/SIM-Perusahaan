@extends('admin.layouts.app')

@section('title', 'Edit Armada - ' . $armada->nama)

@section('content')
<style>
/* Specific styles for Armada Create/Edit pages */
.btn-back {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    border: none;
    border-radius: 12px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all var(--transition-speed) ease;
    box-shadow: 0 3px 10px rgba(33, 158, 188, 0.3);
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(33, 158, 188, 0.5);
    color: white;
}

.form-card {
    margin-bottom: 1.5rem;
}

.form-label.required::after {
    content: ' *';
    color: #dc3545;
}

.input-group-text {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border: 2px solid #e9ecef;
    border-left: none;
    color: #6c757d;
    font-weight: 500;
}

.form-check-input {
    width: 3rem;
    height: 1.5rem;
    cursor: pointer;
    border: 2px solid #e9ecef;
}

.form-check-input:checked {
    background-color: var(--orange-primary);
    border-color: var(--orange-primary);
}

.form-check-input:focus {
    border-color: var(--orange-primary);
    box-shadow: 0 0 0 0.2rem rgba(251, 133, 0, 0.15);
}

.form-check-label {
    margin-left: 0.75rem;
    cursor: pointer;
}

.form-check-label strong {
    display: block;
    color: var(--blue-dark);
    margin-bottom: 0.25rem;
}

/* Image Upload Styles */
.image-upload-container {
    position: relative;
}

.image-input {
    display: none;
}

.image-upload-label {
    display: block;
    padding: 3rem 2rem;
    border: 3px dashed #e9ecef;
    border-radius: 15px;
    text-align: center;
    cursor: pointer;
    transition: all var(--transition-speed) ease;
    background: #f8f9fa;
}

.image-upload-label:hover {
    border-color: var(--orange-primary);
    background: rgba(251, 133, 0, 0.05);
}

.upload-content i {
    font-size: 3rem;
    color: var(--orange-primary);
    margin-bottom: 1rem;
    display: block;
}

.upload-content p {
    color: var(--blue-dark);
    font-weight: 600;
    margin: 0.5rem 0;
}

.upload-content small {
    color: #6c757d;
}

.image-preview {
    margin-top: 1rem;
}

.preview-image {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.preview-image img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 12px;
}

.btn-remove-preview {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 35px;
    height: 35px;
    background: rgba(220, 53, 69, 0.9);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--transition-speed) ease;
}

.btn-remove-preview:hover {
    background: #dc3545;
    transform: scale(1.1);
}

.gallery-preview {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.gallery-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

.gallery-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    display: block;
}

.btn-remove-gallery {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 30px;
    height: 30px;
    background: rgba(220, 53, 69, 0.9);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--transition-speed) ease;
}

.btn-remove-gallery:hover {
    background: #dc3545;
    transform: scale(1.1);
}

/* Current Images (for edit page) */
.current-image {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 1rem;
}

.current-image img {
    width: 100%;
    height: auto;
    display: block;
}

.current-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
}

.gallery-item-current {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

.gallery-item-current img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    display: block;
}

.gallery-item-actions {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    padding: 0.5rem;
}

.gallery-item-actions .form-check {
    margin: 0;
}

.gallery-item-actions .form-check-input {
    width: 1.5rem;
    height: 1.5rem;
}

.gallery-item-actions .form-check-label {
    color: white;
    margin-left: 0.5rem;
    font-size: 0.85rem;
}

/* Fasilitas Management */
.fasilitas-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.fasilitas-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid var(--orange-primary);
    transition: all var(--transition-speed) ease;
}

.fasilitas-item:hover {
    background: rgba(251, 133, 0, 0.05);
    transform: translateX(5px);
}

.fasilitas-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.fasilitas-icon {
    font-size: 1.5rem;
    color: var(--orange-primary);
    width: 40px;
    text-align: center;
}

.fasilitas-name {
    font-weight: 600;
    color: var(--blue-dark);
}

.badge {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.badge-secondary {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
}

/* Action Buttons Sticky */
.action-buttons-sticky {
    position: sticky;
    top: calc(var(--navbar-height) + 1rem);
}

/* Modal */
.modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.modal-header {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
    color: white;
    border-radius: 15px 15px 0 0;
    border: none;
}

.modal-title {
    font-weight: 700;
}

.btn-close {
    filter: brightness(0) invert(1);
}

.modal-footer {
    border: none;
    padding: 1.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .action-buttons-sticky {
        position: static;
    }

    .gallery-preview,
    .current-gallery {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    }
}
</style>

<div class="armada-edit">
    <!-- Halaman Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <a href="{{ route('admin.armada.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="page-title">
                        <i class="fas fa-edit"></i>
                        Edit Armada: {{ $armada->nama }}
                    </h1>
                    <p class="page-subtitle">Update informasi armada bus</p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.armada.update', $armada->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Basic Informasi Card -->
                <div class="card form-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle"></i>
                            Informasi Dasar
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Nama Armada</label>
                                <input type="text" 
                                       name="nama" 
                                       class="form-control @error('nama') is-invalid @enderror" 
                                       value="{{ old('nama', $armada->nama) }}"
                                       required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Tipe Bus</label>
                                <select name="tipe_bus" 
                                        class="form-select @error('tipe_bus') is-invalid @enderror"
                                        required>
                                    <option value="">Pilih Tipe Bus</option>
                                    <option value="Medium Bus" {{ old('tipe_bus', $armada->tipe_bus) == 'Medium Bus' ? 'selected' : '' }}>Medium Bus</option>
                                    <option value="Big Bus" {{ old('tipe_bus', $armada->tipe_bus) == 'Big Bus' ? 'selected' : '' }}>Big Bus</option>
                                    <option value="Executive Bus" {{ old('tipe_bus', $armada->tipe_bus) == 'Executive Bus' ? 'selected' : '' }}>Executive Bus</option>
                                    <option value="VIP Bus" {{ old('tipe_bus', $armada->tipe_bus) == 'VIP Bus' ? 'selected' : '' }}>VIP Bus</option>
                                    <option value="Super VIP Bus" {{ old('tipe_bus', $armada->tipe_bus) == 'Super VIP Bus' ? 'selected' : '' }}>Super VIP Bus</option>
                                </select>
                                @error('tipe_bus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Kapasitas Penumpang</label>
                                <div class="input-group">
                                    <input type="number" 
                                           name="kapasitas" 
                                           class="form-control @error('kapasitas') is-invalid @enderror" 
                                           value="{{ old('kapasitas', $armada->kapasitas) }}"
                                           min="1"
                                           required>
                                    <span class="input-group-text">
                                        <i class="fas fa-users"></i> Orang
                                    </span>
                                    @error('kapasitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Urutan Tampilan</label>
                                <input type="number" 
                                       name="urutan" 
                                       class="form-control @error('urutan') is-invalid @enderror" 
                                       value="{{ old('urutan', $armada->urutan) }}"
                                       min="0"
                                       required>
                                @error('urutan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" 
                                          rows="5" 
                                          class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $armada->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Upload Card -->
                <div class="card form-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-images"></i>
                            Gambar Armada
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Current Main Image -->
                        <div class="mb-4">
                            <label class="form-label">Gambar Utama Saat Ini</label>
                            @if($armada->gambar_utama)
                                <div class="current-image">
                                    <img src="{{ asset('storage/' . $armada->gambar_utama) }}" alt="{{ $armada->nama }}">
                                </div>
                            @else
                                <p class="text-muted">Tidak ada gambar</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Upload Gambar Utama Baru</label>
                            <div class="image-upload-container">
                                <input type="file" 
                                       name="gambar_utama" 
                                       id="gambar_utama"
                                       class="image-input @error('gambar_utama') is-invalid @enderror"
                                       accept="image/jpeg,image/jpg,image/png">
                                <label for="gambar_utama" class="image-upload-label">
                                    <div class="upload-content">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p>Klik atau drag gambar ke sini</p>
                                        <small>Format: JPG, JPEG, PNG (Maks. 10MB)</small>
                                    </div>
                                </label>
                                <div id="preview_gambar_utama" class="image-preview"></div>
                            </div>
                            @error('gambar_utama')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Gallery -->
                        @if($armada->galeri && count($armada->galeri) > 0)
                            <div class="mb-4">
                                <label class="form-label">Galeri Saat Ini</label>
                                <div class="current-gallery">
                                    @foreach($armada->galeri as $index => $image)
                                        <div class="gallery-item-current">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Gallery {{ $index + 1 }}">
                                            <div class="gallery-item-actions">
                                                <label class="form-check">
                                                    <input type="checkbox" 
                                                           name="hapus_galeri[]" 
                                                           value="{{ $index }}"
                                                           class="form-check-input">
                                                    <span class="form-check-label">Hapus</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div>
                            <label class="form-label">Tambah Gambar ke Galeri</label>
                            <div class="image-upload-container">
                                <input type="file" 
                                       name="galeri[]" 
                                       id="galeri"
                                       class="image-input @error('galeri.*') is-invalid @enderror"
                                       accept="image/jpeg,image/jpg,image/png"
                                       multiple>
                                <label for="galeri" class="image-upload-label">
                                    <div class="upload-content">
                                        <i class="fas fa-images"></i>
                                        <p>Upload multiple gambar</p>
                                        <small>Format: JPG, JPEG, PNG (Maks. 10MB per file)</small>
                                    </div>
                                </label>
                                <div id="preview_galeri" class="gallery-preview"></div>
                            </div>
                            @error('galeri.*')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- fasilitas Management Card -->
                <div class="card form-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cogs"></i>
                            Fasilitas Armada
                        </h5>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addfasilitasModal">
                            <i class="fas fa-plus"></i> Tambah Fasilitas
                        </button>
                    </div>
                    <div class="card-body">
                        @if($armada->fasilitas->count() > 0)
                            <div class="fasilitas-list">
                                @foreach($armada->fasilitas as $fasilitas)
                                    <div class="fasilitas-item">
                                        <div class="fasilitas-info">
                                            @if($fasilitas->icon)
                                                <i class="{{ $fasilitas->icon }} fasilitas-icon"></i>
                                            @endif
                                            <span class="fasilitas-name">{{ $fasilitas->nama_fasilitas }}</span>
                                            @if($fasilitas->tersedia)
                                                <span class="badge badge-success">Tersedia</span>
                                            @else
                                                <span class="badge badge-secondary">Tidak Tersedia</span>
                                            @endif
                                        </div>
                                        <form action="{{ route('admin.armada.fasilitas.destroy', $fasilitas->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus fasilitas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada fasilitas. Klik tombol di atas untuk menambahkan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="card form-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-toggle-on"></i>
                            Status & Pengaturan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input type="checkbox" 
                                   name="unggulan" 
                                   class="form-check-input" 
                                   id="unggulan"
                                   value="1"
                                   {{ old('unggulan', $armada->unggulan) ? 'checked' : '' }}>
                            <label class="form-check-label" for="unggulan">
                                <i class="fas fa-star text-warning"></i>
                                <strong>Armada Unggulan</strong>
                                <small class="d-block text-muted">Tampilkan sebagai armada unggulan</small>
                            </label>
                        </div>

                        <div class="form-check form-switch">
                            <input type="checkbox" 
                                   name="tersedia" 
                                   class="form-check-input" 
                                   id="tersedia"
                                   value="1"
                                   {{ old('tersedia', $armada->tersedia) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tersedia">
                                <i class="fas fa-check-circle text-success"></i>
                                <strong>Tersedia</strong>
                                <small class="d-block text-muted">Armada dapat dilihat di website</small>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons-sticky">
                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-2 d-flex justify-content-center align-items-center">
                        <i class="fas fa-save me-2"></i>
                        Update Armada
                    </button>
                    <a href="{{ route('admin.armada.index') }}" class="btn btn-secondary btn-lg w-100">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="addFasilitasModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.armada.fasilitas.store', $armada->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Fasilitas
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Nama Fasilitas</label>
                        <input type="text" 
                               name="nama_fasilitas" 
                               class="form-control" 
                               placeholder="Contoh: AC, Reclining Seat"
                               required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon (Font Awesome)</label>
                        <input type="text" 
                               name="icon" 
                               class="form-control" 
                               placeholder="Contoh: fas fa-snowflake">
                        <small class="text-muted">Cari icon di <a href="https://fontawesome.com/icons" target="_blank">FontAwesome</a></small>
                    </div>
                    <div class="form-check form-switch">
                        <input type="checkbox" 
                               name="tersedia" 
                               class="form-check-input" 
                               id="fasilitas_tersedia"
                               value="1"
                               checked>
                        <label class="form-check-label" for="fasilitas_tersedia">
                            Fasilitas Tersedia
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Preview Gambar Utama
document.getElementById('gambar_utama').addEventListener('change', function(e) {
    const preview = document.getElementById('preview_gambar_utama');
    preview.innerHTML = '';
    
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="preview-image">
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="btn-remove-preview" onclick="removeMainImage()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        }
        reader.readAsDataURL(file);
    }
});

function removeMainImage() {
    document.getElementById('gambar_utama').value = '';
    document.getElementById('preview_gambar_utama').innerHTML = '';
}

// Preview Galeri
document.getElementById('galeri').addEventListener('change', function(e) {
    const preview = document.getElementById('preview_galeri');
    preview.innerHTML = '';
    
    const files = e.target.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'gallery-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Gallery ${i+1}">
                <button type="button" class="btn-remove-gallery" onclick="removeGalleryItem(this)">
                    <i class="fas fa-times"></i>
                </button>
            `;
            preview.appendChild(div);
        }
        reader.readAsDataURL(file);
    }
});

function removeGalleryItem(btn) {
    btn.parentElement.remove();
    const preview = document.getElementById('preview_galeri');
    if (preview.children.length === 0) {
        document.getElementById('galeri').value = '';
    }
}
</script>
@endpush
@endsection