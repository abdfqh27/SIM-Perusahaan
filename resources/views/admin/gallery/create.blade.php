@extends('admin.layouts.app')

@section('title', 'Tambah Galeri')

@section('content')
<style>
.form-container {
    max-width: 1400px;
    margin: 0 auto;
}

.form-header {
    background: white;
    border-radius: 15px;
    padding: 1.5rem 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

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
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(33, 158, 188, 0.3);
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(33, 158, 188, 0.5);
    color: white;
}

.form-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.form-column {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--blue-dark);
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.form-label.required::after {
    content: '*';
    color: #dc3545;
    margin-left: 0.25rem;
}

.form-text {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

/* Toggle Switch */
.toggle-wrapper {
    margin-top: 0.5rem;
}

.toggle-input {
    display: none;
}

.toggle-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    user-select: none;
}

.toggle-slider {
    position: relative;
    width: 50px;
    height: 26px;
    background: #ccc;
    border-radius: 26px;
    transition: all 0.3s ease;
}

.toggle-slider::before {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: white;
    top: 3px;
    left: 3px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.toggle-input:checked + .toggle-label .toggle-slider {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.toggle-input:checked + .toggle-label .toggle-slider::before {
    transform: translateX(24px);
}

.toggle-text {
    font-weight: 500;
    color: var(--blue-dark);
}

/* Upload Area */
.upload-area {
    position: relative;
    border: 2px dashed #e9ecef;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8f9fa;
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-area:hover {
    border-color: var(--orange-primary);
    background: rgba(251, 133, 0, 0.05);
}

.upload-area.drag-over {
    border-color: var(--orange-primary);
    background: rgba(251, 133, 0, 0.1);
    transform: scale(1.02);
}

.upload-area input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.upload-content {
    pointer-events: none;
}

.upload-icon {
    font-size: 4rem;
    color: var(--orange-primary);
    margin-bottom: 1rem;
}

.upload-content h4 {
    color: var(--blue-dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.upload-content p {
    color: #6c757d;
    margin: 0.25rem 0;
}

.file-size {
    font-size: 0.85rem;
    color: #adb5bd;
}

.image-preview {
    position: relative;
    width: 100%;
    height: 100%;
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 10px;
    max-height: 400px;
}

.preview-overlay {
    position: absolute;
    bottom: 1rem;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-preview:hover .preview-overlay {
    opacity: 1;
}

.btn-change {
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    border: none;
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 3px 10px rgba(251, 133, 0, 0.3);
    transition: all 0.3s ease;
}

.btn-change:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(251, 133, 0, 0.5);
}

/* Info Box */
.info-box {
    background: linear-gradient(135deg, rgba(33, 158, 188, 0.1), rgba(142, 202, 230, 0.1));
    border: 1px solid rgba(33, 158, 188, 0.2);
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    gap: 1rem;
}

.info-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.info-content h4 {
    color: var(--blue-dark);
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.75rem 0;
}

.info-content ul {
    margin: 0;
    padding-left: 1.25rem;
    color: #6c757d;
}

.info-content ul li {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
}

.btn-cancel {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    box-shadow: 0 3px 10px rgba(108, 117, 125, 0.3);
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.5);
    color: white;
}

.btn-submit {
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 15px rgba(251, 133, 0, 0.3);
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(251, 133, 0, 0.5);
}

/* Responsive */
@media (max-width: 992px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .form-header {
        padding: 1rem;
    }
    
    .form-card {
        padding: 1.5rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column-reverse;
    }
    
    .btn-cancel,
    .btn-submit {
        width: 100%;
        justify-content: center;
    }
}
</style>
<div class="form-container">
    <!-- Header Section -->
    <div class="gradient-header">
        <div class="header-left">
            <a href="{{ route('admin.gallery.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div>
                <h2 class="header-title">Tambah gallery</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.gallery.index') }}">gallery</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" id="galleryForm">
            @csrf

            <div class="form-grid">
                <!-- Left Column -->
                <div class="form-column">
                    <!-- Judul -->
                    <div class="form-group">
                        <label for="judul" class="form-label required">
                            <i class="fas fa-heading"></i>
                            Judul Foto
                        </label>
                        <input type="text" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul') }}" 
                               placeholder="Contoh: Armada Bus Terbaru 2024"
                               required>
                        @error('judul')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi" class="form-label">
                            <i class="fas fa-align-left"></i>
                            Deskripsi
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="4"
                                  placeholder="Deskripsi singkat tentang foto ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        <small class="form-text">Opsional - Tambahkan deskripsi untuk memberikan konteks pada foto</small>
                    </div>

                    <!-- Kategori -->
                    <div class="form-group">
                        <label for="kategori" class="form-label">
                            <i class="fas fa-tag"></i>
                            Kategori
                        </label>
                        <input type="text" 
                               class="form-control @error('kategori') is-invalid @enderror" 
                               id="kategori" 
                               name="kategori" 
                               value="{{ old('kategori') }}" 
                               placeholder="Contoh: Armada, Kantor, Event, dll"
                               list="kategoriList">
                        <datalist id="kategoriList">
                            <option value="Armada">
                            <option value="Kantor">
                            <option value="Event">
                            <option value="Fasilitas">
                            <option value="Team">
                        </datalist>
                        @error('kategori')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                        @enderror
                        <small class="form-text">Opsional - Gunakan untuk mengelompokkan foto</small>
                    </div>

                    <!-- Urutan & Status -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="urutan" class="form-label required">
                                <i class="fas fa-sort-numeric-down"></i>
                                Urutan
                            </label>
                            <input type="number" 
                                   class="form-control @error('urutan') is-invalid @enderror" 
                                   id="urutan" 
                                   name="urutan" 
                                   value="{{ old('urutan', 0) }}" 
                                   min="0"
                                   required>
                            @error('urutan')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                            @enderror
                            <small class="form-text">Angka lebih kecil = lebih awal ditampilkan</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-eye"></i>
                                Status
                            </label>
                            <div class="toggle-wrapper">
                                <input type="checkbox" 
                                       id="tampilkan" 
                                       name="tampilkan" 
                                       value="1"
                                       {{ old('tampilkan', true) ? 'checked' : '' }}
                                       class="toggle-input">
                                <label for="tampilkan" class="toggle-label">
                                    <span class="toggle-slider"></span>
                                    <span class="toggle-text">Tampilkan di website</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <!-- Image Upload -->
                    <div class="form-group">
                        <label for="gambar" class="form-label required">
                            <i class="fas fa-image"></i>
                            Foto Galeri
                        </label>
                        <div class="upload-area" id="uploadArea">
                            <input type="file" 
                                   class="form-control-file @error('gambar') is-invalid @enderror" 
                                   id="gambar" 
                                   name="gambar" 
                                   accept="image/jpeg,image/jpg,image/png"
                                   required
                                   onchange="previewImage(event)">
                            
                            <div class="upload-content" id="uploadContent">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <h4>Klik atau Drag & Drop</h4>
                                <p>Format: JPG, JPEG, PNG</p>
                                <p class="file-size">Maksimal ukuran: 10MB</p>
                            </div>

                            <div class="image-preview" id="imagePreview" style="display: none;">
                                <img id="previewImg" src="" alt="Preview">
                                <div class="preview-overlay">
                                    <button type="button" class="btn-change" onclick="document.getElementById('gambar').click()">
                                        <i class="fas fa-sync-alt"></i>
                                        Ganti Foto
                                    </button>
                                </div>
                            </div>
                        </div>
                        @error('gambar')
                        <div class="invalid-feedback d-block">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="info-box">
                        <div class="info-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="info-content">
                            <h4>Tips Upload Foto</h4>
                            <ul>
                                <li>Gunakan foto berkualitas tinggi</li>
                                <li>Resolusi minimal 1200x800 pixel</li>
                                <li>Pastikan foto tidak blur</li>
                                <li>Hindari foto dengan watermark</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-cancel">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </a>
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save"></i>
                    <span>Simpan Galeri</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Image Preview
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file size (10MB)
        if (file.size > 10485760) {
            alert('Ukuran file terlalu besar! Maksimal 10MB');
            event.target.value = '';
            return;
        }

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung! Gunakan JPG, JPEG, atau PNG');
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('uploadContent').style.display = 'none';
            document.getElementById('imagePreview').style.display = 'block';
            document.getElementById('previewImg').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

// Drag & Drop
const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('gambar');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, unhighlight, false);
});

function highlight() {
    uploadArea.classList.add('drag-over');
}

function unhighlight() {
    uploadArea.classList.remove('drag-over');
}

uploadArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    fileInput.files = files;
    previewImage({ target: fileInput });
}

// Click to upload
uploadArea.addEventListener('click', function() {
    if (!document.getElementById('imagePreview').style.display || 
        document.getElementById('imagePreview').style.display === 'none') {
        fileInput.click();
    }
});

// Form validation
document.getElementById('galleryForm').addEventListener('submit', function(e) {
    const judul = document.getElementById('judul').value.trim();
    const gambar = document.getElementById('gambar').files[0];

    if (!judul) {
        e.preventDefault();
        alert('Judul foto harus diisi!');
        document.getElementById('judul').focus();
        return;
    }

    if (!gambar) {
        e.preventDefault();
        alert('Foto galeri harus diupload!');
        return;
    }
});
</script>

@endsection