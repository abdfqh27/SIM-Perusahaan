@extends('admin.layouts.app')

@section('title', 'Edit Layanan')

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

    .required { color: #dc3545; margin-left: 0.25rem; }

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

    .form-control.is-invalid { border-color: #dc3545; background: #fff5f5; }

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

    textarea.form-control { resize: vertical; min-height: 100px; }

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
    .icon-input-group { display: flex; gap: 1rem; align-items: center; }
    .icon-input-group .form-control { flex: 1; }

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
    }

    /* Current image */
    .current-image {
        margin-bottom: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        text-align: center;
        border: 2px solid #e9ecef;
    }

    .current-image img {
        max-width: 100%;
        max-height: 250px;
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

    .image-upload-area input[type="file"] {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .upload-placeholder { pointer-events: none; }
    .upload-placeholder i { font-size: 3rem; color: var(--orange-primary); margin-bottom: 1rem; display: block; }
    .upload-placeholder p { color: var(--blue-dark); font-weight: 600; margin-bottom: 0.5rem; font-size: 1.1rem; }
    .upload-placeholder span { color: #6c757d; font-size: 0.875rem; }

    .image-preview { position: relative; max-width: 400px; margin: 0 auto; }
    .image-preview img { width: 100%; height: auto; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

    .btn-remove-image {
        position: absolute;
        top: 10px; right: 10px;
        width: 35px; height: 35px;
        background: #dc3545; color: white;
        border: none; border-radius: 50%;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(220,53,69,0.3);
    }

    .btn-remove-image:hover { background: #c82333; transform: scale(1.1); }

    /* Fasilitas */
    .fasilitas-container { display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1rem; }
    .fasilitas-item { display: flex; gap: 0.75rem; align-items: center; }
    .fasilitas-item .form-control { flex: 1; }

    .btn-remove-fasilitas {
        width: 45px; height: 45px;
        background: #dc3545; color: white;
        border: none; border-radius: 10px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .btn-remove-fasilitas:hover { background: #c82333; transform: scale(1.05); }

    .btn-add-fasilitas {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white; border: none; border-radius: 10px;
        cursor: pointer; font-weight: 600; transition: all 0.3s ease;
    }

    .btn-add-fasilitas:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(52,152,219,0.3); }

    /* Switches */
    .custom-switches { display: flex; gap: 2rem; padding: 1.5rem; background: #f8f9fa; border-radius: 10px; }
    .custom-switch-item { display: flex; align-items: center; gap: 0.75rem; }

    .custom-switch-item input[type="checkbox"] {
        width: 50px; height: 26px;
        appearance: none;
        background: #ccc; border-radius: 13px;
        position: relative; cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-switch-item input[type="checkbox"]:before {
        content: '';
        position: absolute;
        width: 22px; height: 22px;
        border-radius: 50%;
        background: white;
        top: 2px; left: 2px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .custom-switch-item input[type="checkbox"]:checked { background: var(--orange-primary); }
    .custom-switch-item input[type="checkbox"]:checked:before { left: 26px; }

    .custom-switch-item label {
        display: flex; align-items: center; gap: 0.5rem;
        margin: 0; cursor: pointer; color: var(--blue-dark); font-weight: 600;
    }

    .custom-switch-item label i { font-size: 1.2rem; color: var(--orange-primary); }

    /* Urutan selector */
    .urutan-selector { background: #f8f9fa; border: 2px solid #e9ecef; border-radius: 10px; padding: 1.5rem; }

    .current-order-info {
        display: flex; align-items: center; gap: 1rem;
        background: white; padding: 1rem; border-radius: 8px;
        margin-bottom: 1rem; border-left: 4px solid var(--orange-primary);
    }

    .current-order-info i { font-size: 2rem; color: var(--orange-primary); }
    .current-order-info strong { display: block; color: var(--blue-dark); font-size: 1.1rem; margin-bottom: 0.25rem; }
    .current-order-info p { margin: 0; color: #6c757d; font-size: 0.875rem; }

    .urutan-help {
        display: flex; align-items: center; gap: 0.5rem;
        margin-top: 1rem; padding: 0.75rem;
        background: #e3f2fd; border-radius: 8px;
        color: #1976d2; font-size: 0.875rem;
    }

    .urutan-help i { font-size: 1.2rem; }

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

    /* Form actions */
    .form-actions {
        display: flex; gap: 1rem; justify-content: flex-end;
        margin-top: 2rem; padding-top: 2rem;
        border-top: 2px solid #e9ecef;
    }

    .btn-cancel {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white; color: #6c757d;
        border: 2px solid #e9ecef; border-radius: 10px;
        text-decoration: none; font-weight: 600; transition: all 0.3s ease;
    }

    .btn-cancel:hover { background: #6c757d; color: white; border-color: #6c757d; }

    .btn-submit {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.75rem 2rem;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white; border: none; border-radius: 10px;
        cursor: pointer; font-weight: 600; font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(251,133,0,0.3);
    }

    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(251,133,0,0.4); }

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
            <i class="fas fa-edit"></i>
        </div>
        <div>
            <h2 class="header-title">Edit Layanan</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.layanan.index') }}">Layanan</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="form-container">
    <form action="{{ route('admin.layanan.update', $layanan) }}" method="POST" enctype="multipart/form-data" id="layananForm" novalidate>
        @csrf
        @method('PUT')

        {{-- Nama Layanan --}}
        <div class="form-group">
            <label for="nama">Nama Layanan <span class="required">*</span></label>
            <input
                type="text"
                name="nama"
                id="nama"
                class="form-control @error('nama') is-invalid @enderror"
                value="{{ old('nama', $layanan->nama) }}"
                placeholder="Contoh: Spa &amp; Wellness"
                maxlength="255"
                required
            >
            <div class="slug-preview">
                <i class="fas fa-link" style="font-size:0.8rem; flex-shrink:0;"></i>
                <span id="slugText">{{ old('nama') ? Str::slug(old('nama')) : $layanan->slug }}</span>
            </div>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Urutan --}}
        <div class="form-group">
            <label for="urutan">Urutan Tampil <span class="required">*</span></label>
            <div class="urutan-selector">
                <div class="current-order-info">
                    <i class="fas fa-layer-group"></i>
                    <div>
                        <strong>Urutan Saat Ini: #{{ $layanan->urutan }}</strong>
                        <p>Total {{ $maxUrutan }} layanan terdaftar</p>
                    </div>
                </div>
                <select name="urutan" id="urutan" class="form-control @error('urutan') is-invalid @enderror" required>
                    @for($i = 1; $i <= $maxUrutan; $i++)
                        @php $layananDiUrutan = $allLayanans->firstWhere('urutan', $i); @endphp
                        <option value="{{ $i }}" {{ (old('urutan', $layanan->urutan) == $i) ? 'selected' : '' }}>
                            #{{ $i }}
                            @if($layananDiUrutan)
                                → {{ Str::limit($layananDiUrutan->nama, 40) }}
                                @if($layananDiUrutan->id == $layanan->id) ⭐ (Anda di sini) @endif
                            @endif
                        </option>
                    @endfor
                </select>
                <div class="urutan-help">
                    <i class="fas fa-magic"></i>
                    <span>Sistem akan otomatis mengatur ulang urutan layanan lain agar tidak bentrok</span>
                </div>
            </div>
            @error('urutan')
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
            >{{ old('deskripsi_singkat', $layanan->deskripsi_singkat) }}</textarea>
            <div class="char-counter" id="singkatCounter">
                <span id="singkatCount">{{ strlen(old('deskripsi_singkat', $layanan->deskripsi_singkat ?? '')) }}</span>/500
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
            >{{ old('deskripsi_lengkap', $layanan->deskripsi_lengkap) }}</textarea>
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
                    value="{{ old('icon', $layanan->icon) }}"
                    placeholder="fas fa-concierge-bell"
                    maxlength="100"
                    required
                >
                <div class="icon-preview" id="iconPreview">
                    <i class="{{ old('icon', $layanan->icon) ?: 'fas fa-icons' }}"></i>
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

            {{-- Gambar saat ini --}}
            @if($layanan->gambar)
            <div class="current-image" id="currentImageContainer">
                <img src="{{ asset($layanan->gambar) }}" alt="{{ $layanan->nama }}" id="currentImageEl">
                <span class="current-image-label">
                    <i class="fas fa-check-circle" style="color:#28a745;"></i>
                    Gambar saat ini — upload baru di bawah untuk mengganti
                </span>
            </div>
            @endif

            <div class="image-upload-area @error('gambar') is-invalid @enderror" id="imageUploadArea">
                <input
                    type="file"
                    name="gambar"
                    id="gambar"
                    accept="image/jpeg,image/jpg,image/png"
                    {{-- Tidak wajib di edit karena gambar lama masih tersimpan --}}
                >
                <div class="upload-placeholder" id="uploadPlaceholder">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Klik atau drag &amp; drop untuk mengganti gambar</p>
                    <span>Format: JPG, JPEG, PNG (Maks: 10MB)</span>
                    @if(!$layanan->gambar)
                        <br><span style="color:#dc3545; font-weight:600; font-size:0.85rem; margin-top:0.5rem; display:block;">
                            <i class="fas fa-exclamation-circle"></i> Gambar wajib diupload
                        </span>
                    @endif
                </div>
                <div class="image-preview" id="imagePreview" style="display: none;">
                    <img src="" alt="Preview baru">
                    <button type="button" class="btn-remove-image" id="removeImage" title="Batal ganti gambar">
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
                @php
                    $fasilitasList = old('fasilitas', $layanan->fasilitas ?? []);
                    if (empty($fasilitasList)) $fasilitasList = [''];
                @endphp
                @foreach($fasilitasList as $fas)
                <div class="fasilitas-item">
                    <input type="text" name="fasilitas[]" class="form-control"
                        placeholder="Nama fasilitas" value="{{ $fas }}" maxlength="255" required>
                    <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)" title="Hapus">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endforeach
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
                        {{ old('unggulan', $layanan->unggulan) ? 'checked' : '' }}>
                    <label for="unggulan">
                        <i class="fas fa-star"></i>
                        <span>Layanan Unggulan</span>
                    </label>
                </div>
                <div class="custom-switch-item">
                    <input type="checkbox" name="aktif" id="aktif" value="1"
                        {{ old('aktif', $layanan->aktif) ? 'checked' : '' }}>
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
                <i class="fas fa-save"></i> Update Layanan
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
(function initCounter() {
    const textarea = document.getElementById('deskripsi_singkat');
    const counter  = document.getElementById('singkatCounter');
    const countEl  = document.getElementById('singkatCount');

    function update() {
        const len = textarea.value.length;
        countEl.textContent = len;
        counter.className = 'char-counter' + (len >= 500 ? ' danger' : len >= 400 ? ' warning' : '');
    }

    textarea.addEventListener('input', update);
    update(); // inisialisasi saat halaman load
})();

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
const hasExistingImage  = {{ $layanan->gambar ? 'true' : 'false' }};

imageInput.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (e) {
        imagePreview.querySelector('img').src = e.target.result;
        uploadPlaceholder.style.display = 'none';
        imagePreview.style.display      = 'block';
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

    // Gambar: di edit, wajib jika belum ada gambar sebelumnya
    if (!hasExistingImage) {
        const gambar = document.getElementById('gambar').files;
        if (!gambar || gambar.length === 0) {
            errors.push('Gambar layanan wajib diupload');
        }
    }

    const fasilitasInputs = document.querySelectorAll('#fasilitasContainer input[name="fasilitas[]"]');
    let fasilitasValid = true;
    fasilitasInputs.forEach(function (input) {
        if (!input.value.trim()) fasilitasValid = false;
    });
    if (fasilitasInputs.length === 0) {
        errors.push('Minimal satu fasilitas wajib diisi');
    } else if (!fasilitasValid) {
        errors.push('Semua nama fasilitas wajib diisi (tidak boleh ada yang kosong)');
    }

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
        title: 'Konfirmasi Update',
        html: 'Apakah Anda yakin ingin mengupdate data layanan ini?<br>'
            + '<small class="text-muted">Pastikan semua data sudah benar sebelum menyimpan.</small>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check"></i> Ya, Update',
        cancelButtonText:  '<i class="fas fa-times"></i> Batal',
        confirmButtonColor: '#fb8500',
        cancelButtonColor: '#6c757d',
        reverseButtons: true,
        focusCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Mengupdate Data...',
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