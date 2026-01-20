@extends('admin.layouts.app')

@section('title', 'Edit Layanan')

@section('content')
<style>
    .form-header {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #e9ecef;
    }

    .header-back .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        color: var(--blue-dark);
        border: 2px solid #e9ecef;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .header-back .btn-back:hover {
        background: var(--blue-dark);
        color: white;
        border-color: var(--blue-dark);
        transform: translateX(-5px);
    }

    .header-text h2 {
        margin: 0 0 0.5rem 0;
        color: var(--blue-dark);
        font-size: 1.75rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .header-text p {
        margin: 0;
        color: #6c757d;
        font-size: 0.95rem;
    }

    .form-container {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .form-row {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-row .form-group {
        margin-bottom: 0;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--blue-dark);
        font-weight: 600;
        font-size: 0.95rem;
    }

    .required {
        color: #dc3545;
        margin-left: 0.25rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--orange-primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(251, 133, 0, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        background: #fff5f5;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .form-text {
        display: block;
        margin-top: 0.5rem;
        color: #6c757d;
        font-size: 0.875rem;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .icon-input-group {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .icon-input-group .form-control {
        flex: 1;
    }

    .icon-preview {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(251, 133, 0, 0.3);
        transition: all 0.3s ease;
    }

    .current-image {
        margin-bottom: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        text-align: center;
    }

    .current-image img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .current-image-label {
        display: block;
        margin-top: 0.75rem;
        color: #6c757d;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .image-upload-area {
        position: relative;
        border: 3px dashed #e9ecef;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .image-upload-area:hover {
        border-color: var(--orange-primary);
        background: white;
    }

    .image-upload-area input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .upload-placeholder {
        pointer-events: none;
    }

    .upload-placeholder i {
        font-size: 3rem;
        color: var(--orange-primary);
        margin-bottom: 1rem;
        display: block;
    }

    .upload-placeholder p {
        color: var(--blue-dark);
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .upload-placeholder span {
        color: #6c757d;
        font-size: 0.875rem;
    }

    .image-preview {
        position: relative;
        max-width: 400px;
        margin: 0 auto;
    }

    .image-preview img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-remove-image {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 35px;
        height: 35px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
    }

    .btn-remove-image:hover {
        background: #c82333;
        transform: scale(1.1);
    }

    .fasilitas-container {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .fasilitas-item {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .fasilitas-item .form-control {
        flex: 1;
    }

    .btn-remove-fasilitas {
        width: 45px;
        height: 45px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .btn-remove-fasilitas:hover {
        background: #c82333;
        transform: scale(1.05);
    }

    .btn-add-fasilitas {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-add-fasilitas:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .custom-switches {
        display: flex;
        gap: 2rem;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 10px;
    }

    .custom-switch-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .custom-switch-item input[type="checkbox"] {
        width: 50px;
        height: 26px;
        appearance: none;
        background: #ccc;
        border-radius: 13px;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-switch-item input[type="checkbox"]:before {
        content: '';
        position: absolute;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: white;
        top: 2px;
        left: 2px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .custom-switch-item input[type="checkbox"]:checked {
        background: var(--orange-primary);
    }

    .custom-switch-item input[type="checkbox"]:checked:before {
        left: 26px;
    }

    .custom-switch-item label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
        cursor: pointer;
        color: var(--blue-dark);
        font-weight: 600;
    }

    .custom-switch-item label i {
        font-size: 1.2rem;
        color: var(--orange-primary);
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #e9ecef;
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        color: #6c757d;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #6c757d;
        color: white;
        border-color: #6c757d;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 2rem;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(251, 133, 0, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 133, 0, 0.4);
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .form-row .form-group {
            margin-bottom: 1.5rem;
        }

        .custom-switches {
            flex-direction: column;
            gap: 1rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-cancel, .btn-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="form-header">
    <div class="header-back">
        <a href="{{ route('admin.layanan.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
    <div class="header-text">
        <h2><i class="fas fa-edit"></i> Edit Layanan</h2>
        <p>Perbarui informasi layanan</p>
    </div>
</div>

<div class="form-container">
    <form action="{{ route('admin.layanan.update', $layanan) }}" method="POST" enctype="multipart/form-data" id="layananForm">
        @csrf
        @method('PUT')
        
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="nama">Nama Layanan <span class="required">*</span></label>
                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $layanan->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group col-md-4">
                <label for="urutan">Urutan Tampil <span class="required">*</span></label>
                <input type="number" name="urutan" id="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', $layanan->urutan) }}" min="0" required>
                @error('urutan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <label for="deskripsi_singkat">Deskripsi Singkat</label>
            <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="3" class="form-control @error('deskripsi_singkat') is-invalid @enderror">{{ old('deskripsi_singkat', $layanan->deskripsi_singkat) }}</textarea>
            <small class="form-text">Deskripsi singkat akan ditampilkan di halaman daftar layanan</small>
            @error('deskripsi_singkat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="deskripsi_lengkap">Deskripsi Lengkap</label>
            <textarea name="deskripsi_lengkap" id="deskripsi_lengkap" rows="6" class="form-control @error('deskripsi_lengkap') is-invalid @enderror">{{ old('deskripsi_lengkap', $layanan->deskripsi_lengkap) }}</textarea>
            <small class="form-text">Deskripsi lengkap akan ditampilkan di halaman detail layanan</small>
            @error('deskripsi_lengkap')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="icon">Icon (Font Awesome Class)</label>
                <div class="icon-input-group">
                    <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon', $layanan->icon) }}" placeholder="fas fa-concierge-bell">
                    <div class="icon-preview" id="iconPreview">
                        @if($layanan->icon)
                            <i class="{{ $layanan->icon }}"></i>
                        @else
                            <i class="fas fa-icons"></i>
                        @endif
                    </div>
                </div>
                <small class="form-text">Contoh: fas fa-spa, fas fa-hotel, fas fa-utensils</small>
                @error('icon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="harga">Harga (Opsional)</label>
                <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $layanan->harga) }}" min="0" step="1000" placeholder="0">
                <small class="form-text">Masukkan harga layanan jika diperlukan</small>
                @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <label for="gambar">Gambar Layanan</label>
            @if($layanan->gambar)
            <div class="current-image">
                <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="{{ $layanan->nama }}">
                <span class="current-image-label">Gambar saat ini</span>
            </div>
            @endif
            <div class="image-upload-area" id="imageUploadArea">
                <input type="file" name="gambar" id="gambar" class="form-control-file @error('gambar') is-invalid @enderror" accept="image/jpeg,image/jpg,image/png">
                <div class="upload-placeholder" id="uploadPlaceholder">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Klik atau drag & drop gambar di sini untuk mengganti</p>
                    <span>Format: JPG, JPEG, PNG (Max: 10MB)</span>
                </div>
                <div class="image-preview" id="imagePreview" style="display: none;">
                    <img src="" alt="Preview">
                    <button type="button" class="btn-remove-image" id="removeImage">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @error('gambar')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Fasilitas</label>
            <div class="fasilitas-container" id="fasilitasContainer">
                @if($layanan->fasilitas && count($layanan->fasilitas) > 0)
                    @foreach($layanan->fasilitas as $fasilitas)
                    <div class="fasilitas-item">
                        <input type="text" name="fasilitas[]" class="form-control" value="{{ $fasilitas }}" placeholder="Nama fasilitas">
                        <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endforeach
                @else
                    <div class="fasilitas-item">
                        <input type="text" name="fasilitas[]" class="form-control" placeholder="Nama fasilitas">
                        <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
            </div>
            <button type="button" class="btn-add-fasilitas" id="addFasilitas">
                <i class="fas fa-plus"></i> Tambah Fasilitas
            </button>
        </div>
        
        <div class="form-group">
            <div class="custom-switches">
                <div class="custom-switch-item">
                    <input type="checkbox" name="unggulan" id="unggulan" value="1" {{ old('unggulan', $layanan->unggulan) ? 'checked' : '' }}>
                    <label for="unggulan">
                        <i class="fas fa-star"></i>
                        <span>Layanan Unggulan</span>
                    </label>
                </div>
                
                <div class="custom-switch-item">
                    <input type="checkbox" name="aktif" id="aktif" value="1" {{ old('aktif', $layanan->aktif) ? 'checked' : '' }}>
                    <label for="aktif">
                        <i class="fas fa-toggle-on"></i>
                        <span>Aktif</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <a href="{{ route('admin.layanan.index') }}" class="btn-cancel">
                <i class="fas fa-times"></i> Batal
            </a>
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Update Layanan
            </button>
        </div>
    </form>
</div>

<script>
// Icon Preview
document.getElementById('icon').addEventListener('input', function() {
    const iconPreview = document.getElementById('iconPreview');
    const iconClass = this.value || 'fas fa-icons';
    iconPreview.innerHTML = `<i class="${iconClass}"></i>`;
});

// Image Upload Preview
const imageInput = document.getElementById('gambar');
const imageUploadArea = document.getElementById('imageUploadArea');
const uploadPlaceholder = document.getElementById('uploadPlaceholder');
const imagePreview = document.getElementById('imagePreview');
const removeImageBtn = document.getElementById('removeImage');

imageInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.querySelector('img').src = e.target.result;
            uploadPlaceholder.style.display = 'none';
            imagePreview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

removeImageBtn.addEventListener('click', function() {
    imageInput.value = '';
    uploadPlaceholder.style.display = 'block';
    imagePreview.style.display = 'none';
});

// Drag and drop
imageUploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.borderColor = 'var(--orange-primary)';
    this.style.background = 'white';
});

imageUploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.style.borderColor = '#e9ecef';
    this.style.background = '#f8f9fa';
});

imageUploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    this.style.borderColor = '#e9ecef';
    this.style.background = '#f8f9fa';
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        imageInput.files = files;
        imageInput.dispatchEvent(new Event('change'));
    }
});

// Fasilitas Management
document.getElementById('addFasilitas').addEventListener('click', function() {
    const container = document.getElementById('fasilitasContainer');
    const newItem = document.createElement('div');
    newItem.className = 'fasilitas-item';
    newItem.innerHTML = `
        <input type="text" name="fasilitas[]" class="form-control" placeholder="Nama fasilitas">
        <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(newItem);
});

function removeFasilitas(button) {
    const container = document.getElementById('fasilitasContainer');
    if (container.children.length > 1) {
        button.closest('.fasilitas-item').remove();
    } else {
        alert('Minimal harus ada satu fasilitas');
    }
}
</script>
@endsection