@extends('admin.layouts.app')

@section('title', 'Tambah Armada')

@section('content')
<style>
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

/* Help Card */
.help-card {
    background: linear-gradient(135deg, #fff9e6, #fff);
    border-left: 4px solid var(--orange-primary);
}

.help-card h6 {
    color: var(--blue-dark);
    font-weight: 700;
    margin-bottom: 1rem;
}

.help-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.help-list li {
    padding: 0.5rem 0;
    color: #6c757d;
    font-size: 0.9rem;
    position: relative;
    padding-left: 1.5rem;
}

.help-list li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--orange-primary);
    font-weight: bold;
}

/* Action Buttons Sticky */
.action-buttons-sticky {
    position: sticky;
    top: calc(var(--navbar-height) + 1rem);
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

    .help-card {
        margin-bottom: 1rem;
    }
}
</style>
<div class="armada-create">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <a href="{{ route('admin.armada.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="page-title">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Armada Baru
                    </h1>
                    <p class="page-subtitle">Lengkapi informasi armada bus</p>
                </div>
            </div>
        </div>
    </div>

    <form id="armadaForm" action="{{ route('admin.armada.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Basic Information Card -->
                <div class="card form-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
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
                                       value="{{ old('nama') }}"
                                       placeholder="Contoh: Executive Class"
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
                                    <option value="Medium Bus" {{ old('tipe_bus') == 'Medium Bus' ? 'selected' : '' }}>Medium Bus</option>
                                    <option value="Big Bus" {{ old('tipe_bus') == 'Big Bus' ? 'selected' : '' }}>Big Bus</option>
                                    <option value="Executive Bus" {{ old('tipe_bus') == 'Executive Bus' ? 'selected' : '' }}>Executive Bus</option>
                                    <option value="VIP Bus" {{ old('tipe_bus') == 'VIP Bus' ? 'selected' : '' }}>VIP Bus</option>
                                    <option value="Super VIP Bus" {{ old('tipe_bus') == 'Super VIP Bus' ? 'selected' : '' }}>Super VIP Bus</option>
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
                                           value="{{ old('kapasitas') }}"
                                           min="1"
                                           placeholder="Jumlah kursi"
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
                                       value="{{ old('urutan', 0) }}"
                                       min="0"
                                       placeholder="0"
                                       required>
                                @error('urutan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Semakin kecil angka, semakin awal ditampilkan</small>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" 
                                          rows="5" 
                                          class="form-control @error('deskripsi') is-invalid @enderror"
                                          placeholder="Masukkan deskripsi detail armada...">{{ old('deskripsi') }}</textarea>
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
                        <h5 class="card-title mb-0">
                            <i class="fas fa-images"></i>
                            Gambar Armada
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label">Gambar Utama</label>
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

                        <div>
                            <label class="form-label">Galeri Gambar</label>
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
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="card form-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
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
                                   {{ old('unggulan') ? 'checked' : '' }}>
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
                                   {{ old('tersedia', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tersedia">
                                <i class="fas fa-check-circle text-success"></i>
                                <strong>Tersedia</strong>
                                <small class="d-block text-muted">Armada dapat dilihat di website</small>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="card help-card">
                    <div class="card-body">
                        <h6><i class="fas fa-info-circle"></i> Panduan</h6>
                        <ul class="help-list">
                            <li>Isi semua field yang bertanda <span class="text-danger">*</span></li>
                            <li>Pastikan gambar jelas dan berkualitas baik</li>
                            <li>Deskripsi yang detail membantu customer</li>
                            <li>Set urutan untuk mengatur posisi tampilan</li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons-sticky mt-5">
                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-2 d-flex justify-content-center align-items-center">
                        <i class="fas fa-save me-2"></i>
                        Simpan Armada
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <button type="button" class="btn-remove-gallery" onclick="removeGalleryItem(this, ${i})">
                    <i class="fas fa-times"></i>
                </button>
            `;
            preview.appendChild(div);
        }
        reader.readAsDataURL(file);
    }
});

function removeGalleryItem(btn, index) {
    btn.parentElement.remove();
    
    const preview = document.getElementById('preview_galeri');
    if (preview.children.length === 0) {
        document.getElementById('galeri').value = '';
    }
}

// SUBMIT FORM DENGAN KONFIRMASI
document.getElementById('armadaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Konfirmasi Penyimpanan',
        html: 'Apakah Anda yakin ingin menyimpan armada ini?<br><small class="text-muted">Pastikan semua data sudah benar sebelum menyimpan.</small>',
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
@endsection