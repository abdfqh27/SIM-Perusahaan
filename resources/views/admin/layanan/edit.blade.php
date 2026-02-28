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

    /* Shake animation untuk field yang error */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%       { transform: translateX(-8px); }
        40%       { transform: translateX(8px); }
        60%       { transform: translateX(-5px); }
        80%       { transform: translateX(5px); }
    }

    .field-shake {
        animation: shake 0.4s ease;
    }

    /* Highlight merah mencolok untuk field yang wajib diisi */
    .field-error-highlight {
        border-color: #dc3545 !important;
        background: #fff5f5 !important;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.2) !important;
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

    .image-upload-area.is-invalid {
        border-color: #dc3545;
        background: #fff5f5;
    }

    .image-upload-area.field-error-highlight {
        border-color: #dc3545 !important;
        background: #fff5f5 !important;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.2) !important;
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
        <div class="form-group" id="group-nama">
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
        <div class="form-group" id="group-urutan">
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
        <div class="form-group" id="group-deskripsi_singkat">
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
        <div class="form-group" id="group-deskripsi_lengkap">
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
        <div class="form-group" id="group-icon">
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
        <div class="form-group" id="group-gambar">
            <label for="gambar">Gambar Layanan <span class="required">*</span></label>

            {{-- Gambar saat ini --}}
            @if($layanan->gambar)
            <div class="current-image" id="currentImageContainer">
                <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="{{ $layanan->nama }}" id="currentImageEl">
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
        <div class="form-group" id="group-fasilitas">
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
document.getElementById('nama').addEventListener('input', function () {
    const slug = this.value.toLowerCase().trim().replace(/[\s\-]+/g, '-').replace(/[^a-z0-9\-]/g, '').replace(/^-+|-+$/g, '');
    document.getElementById('slugText').textContent = slug || '—';
});

// Char counter (inisialisasi sekaligus saat load)
const deskSingkatEl = document.getElementById('deskripsi_singkat');
function updateCounter() {
    const len = deskSingkatEl.value.length;
    document.getElementById('singkatCount').textContent = len;
    document.getElementById('singkatCounter').className = 'char-counter' + (len >= 500 ? ' danger' : len >= 400 ? ' warning' : '');
}
deskSingkatEl.addEventListener('input', updateCounter);
updateCounter();

// Icon preview
document.getElementById('icon').addEventListener('input', function () {
    document.getElementById('iconPreview').innerHTML = `<i class="${this.value.trim() || 'fas fa-icons'}"></i>`;
});

// Image upload preview
const imageUploadArea  = document.getElementById('imageUploadArea');
const imageInput       = document.getElementById('gambar');
const hasExistingImage = {{ $layanan->gambar ? 'true' : 'false' }};

imageInput.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('imagePreview').querySelector('img').src = e.target.result;
        document.getElementById('uploadPlaceholder').style.display = 'none';
        document.getElementById('imagePreview').style.display = 'block';
        imageUploadArea.classList.remove('field-error-highlight');
    };
    reader.readAsDataURL(file);
});

document.getElementById('removeImage').addEventListener('click', function () {
    imageInput.value = '';
    document.getElementById('uploadPlaceholder').style.display = 'block';
    document.getElementById('imagePreview').style.display = 'none';
});

imageUploadArea.addEventListener('dragover',  e => { e.preventDefault(); imageUploadArea.classList.add('dragover'); });
imageUploadArea.addEventListener('dragleave', ()  => imageUploadArea.classList.remove('dragover'));
imageUploadArea.addEventListener('drop', function (e) {
    e.preventDefault();
    this.classList.remove('dragover');
    if (e.dataTransfer.files.length) {
        imageInput.files = e.dataTransfer.files;
        imageInput.dispatchEvent(new Event('change'));
    }
});

// Tambah fasilitas
document.getElementById('addFasilitas').addEventListener('click', function () {
    const item = document.createElement('div');
    item.className = 'fasilitas-item';
    item.innerHTML = `
        <input type="text" name="fasilitas[]" class="form-control" placeholder="Nama fasilitas" maxlength="255" required>
        <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)" title="Hapus"><i class="fas fa-times"></i></button>
    `;
    document.getElementById('fasilitasContainer').appendChild(item);
    item.querySelector('input').focus();
});

function removeFasilitas(btn) {
    const container = document.getElementById('fasilitasContainer');
    if (container.children.length > 1) {
        btn.closest('.fasilitas-item').remove();
    } else {
        Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Minimal harus ada satu fasilitas', confirmButtonColor: '#fb8500' });
    }
}

// Hapus highlight saat field diisi
document.querySelectorAll('.form-control').forEach(el => {
    el.addEventListener('input', () => el.classList.remove('field-error-highlight'));
});

// Scroll + highlight ke field kosong
function scrollToError(el, doFocus = true) {
    el.classList.remove('field-shake');
    void el.offsetWidth;
    el.classList.add('field-error-highlight', 'field-shake');
    window.scrollTo({ top: el.getBoundingClientRect().top + window.scrollY - 100, behavior: 'smooth' });
    if (doFocus) setTimeout(() => el.focus(), 400);
    el.addEventListener('animationend', () => el.classList.remove('field-shake'), { once: true });
}

// Submit
document.getElementById('layananForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = this;

    const checks = [
        document.getElementById('nama'),
        document.getElementById('deskripsi_singkat'),
        document.getElementById('deskripsi_lengkap'),
        document.getElementById('icon'),
    ];
    for (const el of checks) {
        if (!el.value.trim()) { scrollToError(el); return; }
    }

    if (!hasExistingImage && (!imageInput.files || !imageInput.files.length)) {
        scrollToError(imageUploadArea, false); return;
    }

    const emptyFasilitas = [...document.querySelectorAll('#fasilitasContainer input[name="fasilitas[]"]')]
        .find(i => !i.value.trim());
    if (emptyFasilitas) { scrollToError(emptyFasilitas); return; }

    // Semua valid → konfirmasi
    Swal.fire({
        title: 'Konfirmasi Update',
        html: 'Apakah Anda yakin ingin mengupdate data layanan ini?<br><small class="text-muted">Pastikan semua data sudah benar sebelum menyimpan.</small>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check"></i> Ya, Update',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        confirmButtonColor: '#fb8500',
        cancelButtonColor: '#6c757d',
        reverseButtons: true,
        focusCancel: true,
    }).then(result => { if (result.isConfirmed) form.submit(); });
});
</script>
@endpush