@extends('admin.layouts.app')

@section('title', 'Tambah Layanan')

@section('content')
<style>
    .form-container {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
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
        box-sizing: border-box;
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

    /* Slug preview */
    .slug-preview {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
        padding: 0.5rem 0.75rem;
        background: #f0f4ff;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #6c757d;
        min-height: 32px;
    }

    .slug-preview span {
        font-family: monospace;
        color: #1976d2;
        font-weight: 600;
    }

    /* Icon */
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

    /* Image upload */
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

    .image-upload-area:hover,
    .image-upload-area.dragover {
        border-color: var(--orange-primary);
        background: white;
    }

    .image-upload-area.is-invalid {
        border-color: #dc3545;
        background: #fff5f5;
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

    .upload-placeholder .required-badge {
        display: inline-block;
        margin-top: 0.5rem;
        padding: 0.2rem 0.6rem;
        background: #dc3545;
        color: white;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
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

    /* Fasilitas */
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

    /* Switches */
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

    /* Form actions */
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

    /* Info urutan */
    .auto-urutan-info {
        background: #e3f2fd;
        border: 2px solid #2196F3;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .auto-urutan-info i {
        font-size: 2rem;
        color: #2196F3;
        flex-shrink: 0;
    }

    .auto-urutan-info div { flex: 1; }

    .auto-urutan-info h4 {
        margin: 0 0 0.25rem 0;
        color: var(--blue-dark);
        font-size: 1rem;
    }

    .auto-urutan-info p {
        margin: 0;
        color: #6c757d;
        font-size: 0.875rem;
    }

    .auto-urutan-info .urutan-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--orange-primary);
        flex-shrink: 0;
    }

    /* Char counter */
    .char-counter {
        display: flex;
        justify-content: flex-end;
        margin-top: 0.25rem;
        font-size: 0.8rem;
        color: #6c757d;
    }

    .char-counter.warning { color: #f57c00; }
    .char-counter.danger  { color: #dc3545; font-weight: 600; }

    @media (max-width: 768px) {
        .custom-switches { flex-direction: column; gap: 1rem; }
        .form-actions { flex-direction: column; }
        .btn-cancel, .btn-submit { width: 100%; justify-content: center; }
    }
</style>

{{-- Header --}}
<div class="gradient-header">
    <div class="header-left">
        <a href="{{ route('admin.layanan.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="header-icon">
            <i class="fas fa-plus-circle"></i>
        </div>
        <div>
            <h2 class="header-title">Tambah Layanan</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.layanan.index') }}">Layanan</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- Info urutan otomatis --}}
<div class="auto-urutan-info">
    <i class="fas fa-info-circle"></i>
    <div>
        <h4>Urutan Otomatis</h4>
        <p>Layanan baru akan otomatis ditempatkan pada urutan berikutnya. Semua field bertanda <span style="color:#dc3545;font-weight:700;">*</span> wajib diisi.</p>
    </div>
    <div class="urutan-number">#{{ $nextUrutan }}</div>
</div>

<div class="form-container">
    <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data" id="layananForm" novalidate>
        @csrf

        {{-- Nama Layanan --}}
        <div class="form-group">
            <label for="nama">Nama Layanan <span class="required">*</span></label>
            <input
                type="text"
                name="nama"
                id="nama"
                class="form-control @error('nama') is-invalid @enderror"
                value="{{ old('nama') }}"
                placeholder="Contoh: Spa &amp; Wellness"
                maxlength="255"
                required
            >
            <div class="slug-preview">
                <i class="fas fa-link" style="font-size:0.8rem; flex-shrink:0;"></i>
                <span id="slugText">{{ old('nama') ? Str::slug(old('nama')) : '—' }}</span>
            </div>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Deskripsi Singkat --}}
        <div class="form-group">
            <label for="deskripsi_singkat">Deskripsi Singkat <span class="required">*</span></label>
            <textarea
                name="deskripsi_singkat"
                id="deskripsi_singkat"
                rows="3"
                class="form-control @error('deskripsi_singkat') is-invalid @enderror"
                placeholder="Tulis deskripsi singkat layanan (maks. 500 karakter)..."
                maxlength="500"
                required
            >{{ old('deskripsi_singkat') }}</textarea>
            <div class="char-counter" id="singkatCounter">
                <span id="singkatCount">{{ strlen(old('deskripsi_singkat', '')) }}</span>/500
            </div>
            <small class="form-text">Ditampilkan di halaman daftar layanan</small>
            @error('deskripsi_singkat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Deskripsi Lengkap --}}
        <div class="form-group">
            <label for="deskripsi_lengkap">Deskripsi Lengkap <span class="required">*</span></label>
            <textarea
                name="deskripsi_lengkap"
                id="deskripsi_lengkap"
                rows="6"
                class="form-control @error('deskripsi_lengkap') is-invalid @enderror"
                placeholder="Tulis deskripsi lengkap layanan..."
                required
            >{{ old('deskripsi_lengkap') }}</textarea>
            <small class="form-text">Ditampilkan di halaman detail layanan</small>
            @error('deskripsi_lengkap')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Icon --}}
        <div class="form-group">
            <label for="icon">Icon (Font Awesome Class) <span class="required">*</span></label>
            <div class="icon-input-group">
                <input
                    type="text"
                    name="icon"
                    id="icon"
                    class="form-control @error('icon') is-invalid @enderror"
                    value="{{ old('icon') }}"
                    placeholder="fas fa-concierge-bell"
                    maxlength="100"
                    required
                >
                <div class="icon-preview" id="iconPreview">
                    <i class="{{ old('icon', 'fas fa-icons') }}"></i>
                </div>
            </div>
            <small class="form-text">
                Contoh: <code>fas fa-spa</code>, <code>fas fa-hotel</code>, <code>fas fa-utensils</code>.
                Cari icon di <a href="https://fontawesome.com/icons" target="_blank">fontawesome.com/icons</a>
            </small>
            @error('icon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Gambar --}}
        <div class="form-group">
            <label for="gambar">Gambar Layanan <span class="required">*</span></label>
            <div class="image-upload-area @error('gambar') is-invalid @enderror" id="imageUploadArea">
                <input
                    type="file"
                    name="gambar"
                    id="gambar"
                    accept="image/jpeg,image/jpg,image/png"
                    required
                >
                <div class="upload-placeholder" id="uploadPlaceholder">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Klik atau drag &amp; drop gambar di sini</p>
                    <span>Format: JPG, JPEG, PNG (Maks: 10MB)</span>
                    <br>
                    <span class="required-badge"><i class="fas fa-exclamation-circle"></i> Wajib diisi</span>
                </div>
                <div class="image-preview" id="imagePreview" style="display: none;">
                    <img src="" alt="Preview">
                    <button type="button" class="btn-remove-image" id="removeImage" title="Hapus gambar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @error('gambar')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Fasilitas --}}
        <div class="form-group">
            <label>Fasilitas <span class="required">*</span></label>
            <div class="fasilitas-container" id="fasilitasContainer">
                @if(old('fasilitas'))
                    @foreach(old('fasilitas') as $fasilitas)
                    <div class="fasilitas-item">
                        <input type="text" name="fasilitas[]" class="form-control @error('fasilitas') is-invalid @enderror"
                            placeholder="Nama fasilitas" value="{{ $fasilitas }}" maxlength="255" required>
                        <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)" title="Hapus">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endforeach
                @else
                    <div class="fasilitas-item">
                        <input type="text" name="fasilitas[]" class="form-control"
                            placeholder="Nama fasilitas" maxlength="255" required>
                        <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)" title="Hapus">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
            </div>
            @error('fasilitas')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            @error('fasilitas.*')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <button type="button" class="btn-add-fasilitas" id="addFasilitas">
                <i class="fas fa-plus"></i> Tambah Fasilitas
            </button>
        </div>

        {{-- Unggulan & Aktif --}}
        <div class="form-group">
            <div class="custom-switches">
                <div class="custom-switch-item">
                    <input type="checkbox" name="unggulan" id="unggulan" value="1"
                        {{ old('unggulan') ? 'checked' : '' }}>
                    <label for="unggulan">
                        <i class="fas fa-star"></i>
                        <span>Layanan Unggulan</span>
                    </label>
                </div>
                <div class="custom-switch-item">
                    <input type="checkbox" name="aktif" id="aktif" value="1"
                        {{ old('aktif', true) ? 'checked' : '' }}>
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
            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fas fa-save"></i> Simpan Layanan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Slug preview
function toSlug(text) {
    return text.toLowerCase().trim()
        .replace(/[\s\-]+/g, '-')
        .replace(/[^a-z0-9\-]/g, '')
        .replace(/^-+|-+$/g, '');
}

document.getElementById('nama').addEventListener('input', function () {
    document.getElementById('slugText').textContent = toSlug(this.value) || '—';
});

// Char counter deskripsi singkat
document.getElementById('deskripsi_singkat').addEventListener('input', function () {
    const len     = this.value.length;
    const counter = document.getElementById('singkatCounter');
    document.getElementById('singkatCount').textContent = len;
    counter.className = 'char-counter' + (len >= 500 ? ' danger' : len >= 400 ? ' warning' : '');
});

// Icon Preview
document.getElementById('icon').addEventListener('input', function () {
    document.getElementById('iconPreview').innerHTML =
        `<i class="${this.value.trim() || 'fas fa-icons'}"></i>`;
});

// Image Upload Preview
const imageInput        = document.getElementById('gambar');
const imageUploadArea   = document.getElementById('imageUploadArea');
const uploadPlaceholder = document.getElementById('uploadPlaceholder');
const imagePreview      = document.getElementById('imagePreview');
const removeImageBtn    = document.getElementById('removeImage');

imageInput.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (e) {
        imagePreview.querySelector('img').src = e.target.result;
        uploadPlaceholder.style.display = 'none';
        imagePreview.style.display      = 'block';
        imageUploadArea.classList.remove('is-invalid');
    };
    reader.readAsDataURL(file);
});

removeImageBtn.addEventListener('click', function () {
    imageInput.value = '';
    uploadPlaceholder.style.display = 'block';
    imagePreview.style.display      = 'none';
});

imageUploadArea.addEventListener('dragover', function (e) {
    e.preventDefault();
    this.classList.add('dragover');
});

imageUploadArea.addEventListener('dragleave', function () {
    this.classList.remove('dragover');
});

imageUploadArea.addEventListener('drop', function (e) {
    e.preventDefault();
    this.classList.remove('dragover');
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        imageInput.files = files;
        imageInput.dispatchEvent(new Event('change'));
    }
});

// Fasilitas Management
document.getElementById('addFasilitas').addEventListener('click', function () {
    const container = document.getElementById('fasilitasContainer');
    const newItem   = document.createElement('div');
    newItem.className = 'fasilitas-item';
    newItem.innerHTML = `
        <input type="text" name="fasilitas[]" class="form-control"
            placeholder="Nama fasilitas" maxlength="255" required>
        <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)" title="Hapus">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(newItem);
    newItem.querySelector('input').focus();
});

function removeFasilitas(button) {
    const container = document.getElementById('fasilitasContainer');
    if (container.children.length > 1) {
        button.closest('.fasilitas-item').remove();
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Minimal harus ada satu fasilitas',
            confirmButtonColor: '#fb8500',
        });
    }
}

// Validasi client-side sebelum submit─
function validateForm() {
    const errors = [];

    const nama = document.getElementById('nama').value.trim();
    if (!nama) errors.push('Nama layanan wajib diisi');

    const deskSingkat = document.getElementById('deskripsi_singkat').value.trim();
    if (!deskSingkat) errors.push('Deskripsi singkat wajib diisi');

    const deskLengkap = document.getElementById('deskripsi_lengkap').value.trim();
    if (!deskLengkap) errors.push('Deskripsi lengkap wajib diisi');

    const icon = document.getElementById('icon').value.trim();
    if (!icon) errors.push('Icon wajib diisi');

    const gambar = document.getElementById('gambar').files;
    if (!gambar || gambar.length === 0) errors.push('Gambar layanan wajib diupload');

    const fasilitasInputs = document.querySelectorAll('#fasilitasContainer input[name="fasilitas[]"]');
    let fasilitasValid = true;
    fasilitasInputs.forEach(function (input, index) {
        if (!input.value.trim()) {
            fasilitasValid = false;
        }
    });
    if (!fasilitasValid) errors.push('Semua nama fasilitas wajib diisi (tidak boleh ada yang kosong)');

    return errors;
}

// Submit dengan konfirmasi
document.getElementById('layananForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const form   = this;
    const errors = validateForm();

    if (errors.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Data Belum Lengkap',
            html: '<ul style="text-align:left; margin:0; padding-left:1.2rem;">'
                + errors.map(err => `<li>${err}</li>`).join('')
                + '</ul>',
            confirmButtonColor: '#dc3545',
        });
        return;
    }

    Swal.fire({
        title: 'Konfirmasi Penyimpanan',
        html: `Apakah Anda yakin ingin menyimpan layanan ini?<br>
               <small class="text-muted">Layanan akan ditempatkan pada urutan ke-<strong>{{ $nextUrutan }}</strong>.</small>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check"></i> Ya, Simpan',
        cancelButtonText:  '<i class="fas fa-times"></i> Batal',
        confirmButtonColor: '#fb8500',
        cancelButtonColor: '#6c757d',
        reverseButtons: true,
        focusCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menyimpan Data...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading(),
            });
            form.submit();
        }
    });
});

// Tampilkan error validasi dari server
@if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal',
        html: '<ul style="text-align:left; margin:0; padding-left:1.2rem;">'
            + '@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach'
            + '</ul>',
        confirmButtonColor: '#dc3545',
    });
@endif
</script>
@endpush