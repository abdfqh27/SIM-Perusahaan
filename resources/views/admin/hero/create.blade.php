@extends('admin.layouts.app')

@section('title', 'Tambah Hero Section')

@section('content')
<style>
    .create-hero-card {
        margin-bottom: 2rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--blue-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-title i {
        color: var(--orange-primary);
        font-size: 1.3rem;
    }
    
    .image-upload-area {
        border: 2px dashed #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .image-upload-area:hover {
        border-color: var(--orange-primary);
        background: rgba(251, 133, 0, 0.05);
    }
    
    .upload-icon {
        font-size: 3rem;
        color: var(--orange-primary);
        margin-bottom: 1rem;
    }
    
    #imagePreview img {
        border-radius: 12px;
        margin-top: 1rem;
    }
    
    .current-image-label {
        font-weight: 600;
        color: var(--blue-dark);
        margin-bottom: 0.75rem;
        display: block;
    }
    
    .auto-urutan-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: 0 4px 15px rgba(33, 158, 188, 0.3);
        margin-bottom: 1rem;
    }
    
    .auto-urutan-badge i {
        font-size: 1.3rem;
    }
    
    .info-box {
        background: #f0f9ff;
        border-left: 4px solid var(--blue-light);
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
    }
    
    .info-box i {
        color: var(--blue-light);
        margin-right: 0.5rem;
    }

    /* Highlight animasi untuk field yang kosong */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%       { transform: translateX(-8px); }
        40%       { transform: translateX(8px); }
        60%       { transform: translateX(-5px); }
        80%       { transform: translateX(5px); }
    }
    .field-shake {
        animation: shake 0.4s ease;
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
</style>

<!-- Header Section -->
<div class="gradient-header">
    <div class="header-left">
        <a href="{{ route('admin.hero.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="header-icon">
            <i class="fas fa-plus-circle"></i>
        </div>
        <div>
            <h2 class="header-title">Tambah Hero Section</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.hero.index') }}">Hero Section</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card create-hero-card">
    <div class="card-header">
        <i class="fas fa-edit me-2"></i> Form Tambah Hero Section
    </div>
    <div class="card-body">
        <form id="heroForm" action="{{ route('admin.hero.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            
            <!-- Informasi Urutan Otomatis -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-sort-numeric-down"></i>
                    <span>Informasi Urutan</span>
                </div>
                
                <div class="auto-urutan-badge">
                    <i class="fas fa-magic"></i>
                    <span>Hero baru akan otomatis masuk ke urutan: <strong>#{{ $nextUrutan }}</strong></span>
                </div>
                
                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    <small>
                        Urutan hero section akan ditambahkan otomatis. Anda dapat mengubah urutan nanti melalui menu edit.
                    </small>
                </div>
            </div>
            
            <!-- Informasi Utama -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-info-circle"></i>
                    <span>Informasi Utama</span>
                </div>
                
                <div class="mb-3">
                    <label for="judul" class="form-label">
                        Judul <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" 
                           name="judul" 
                           value="{{ old('judul') }}" 
                           placeholder="Masukkan judul hero section"
                           data-label="Judul">
                    @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="invalid-feedback" id="judul-error"></div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" 
                              name="deskripsi" 
                              rows="4"
                              placeholder="Masukkan deskripsi hero section (opsional)">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tombol Call to Action -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-mouse-pointer"></i>
                    <span>Tombol Call to Action</span>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tombol_text" class="form-label">Teks Tombol <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('tombol_text') is-invalid @enderror" 
                               id="tombol_text" 
                               name="tombol_text" 
                               value="{{ old('tombol_text') }}"
                               placeholder="Contoh: Selengkapnya">
                        @error('tombol_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tombol_link" class="form-label">Link Tombol <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('tombol_link') is-invalid @enderror" 
                               id="tombol_link" 
                               name="tombol_link" 
                               value="{{ old('tombol_link') }}"
                               placeholder="Contoh: /tentang-kami">
                        @error('tombol_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Gambar Hero -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-image"></i>
                    <span>Gambar Hero</span>
                </div>
                
                <div class="mb-3">
                    <label for="gambar" class="form-label">Upload Gambar <span class="text-danger">*</span></label>
                    <div class="image-upload-area">
                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                        <input type="file" 
                               class="form-control @error('gambar') is-invalid @enderror" 
                               id="gambar" 
                               name="gambar" 
                               accept="image/jpeg,image/jpg,image/png"
                               onchange="previewImage(event)">
                        <small class="text-muted d-block mt-2">
                            Format: JPG, PNG | Maksimal: 10MB | Rekomendasi: 1920x1080px
                        </small>
                    </div>
                    @error('gambar')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div id="imagePreview"></div>
                </div>
            </div>

            <!-- Pengaturan Status -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </div>
                
                <div class="mb-3">
                    <label for="aktif" class="form-label">Status Tampilan</label>
                    <select class="form-control @error('aktif') is-invalid @enderror" 
                            id="aktif" 
                            name="aktif">
                        <option value="1" {{ old('aktif', 1) == 1 ? 'selected' : '' }}>Aktif (Ditampilkan)</option>
                        <option value="0" {{ old('aktif') == 0 ? 'selected' : '' }}>Nonaktif (Disembunyikan)</option>
                    </select>
                    @error('aktif')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.hero.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// PREVIEW GAMBAR 
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const file    = event.target.files[0];

    if (!file) {
        preview.innerHTML = '';
        return;
    }

    // Validasi ukuran file (maks 10MB)
    if (file.size > 10240 * 1024) {
        Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: 'Ukuran file maksimal 10MB' });
        event.target.value = '';
        preview.innerHTML  = '';
        return;
    }

    // Validasi tipe file
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!validTypes.includes(file.type)) {
        Swal.fire({ icon: 'error', title: 'Format Tidak Valid', text: 'Hanya JPG, JPEG, dan PNG yang diperbolehkan' });
        event.target.value = '';
        preview.innerHTML  = '';
        return;
    }

    // Bersihkan error gambar jika file sudah dipilih
    clearFieldError('gambar');

    const reader  = new FileReader();
    reader.onload = function (e) {
        preview.innerHTML = `
            <div class="mt-3">
                <span class="current-image-label">Preview Gambar:</span>
                <img src="${e.target.result}" class="img-thumbnail" style="max-width:100%;max-height:400px;">
            </div>
        `;
    };
    reader.readAsDataURL(file);
}

// HELPER: Tampilkan error pada field ─
function showFieldError(el, label) {
    el.classList.add('is-invalid', 'field-shake');

    let errEl = document.getElementById(el.id + '-error');
    if (!errEl) {
        errEl    = document.createElement('div');
        errEl.id = el.id + '-error';
        errEl.classList.add('invalid-feedback');
        // Untuk input file, taruh error setelah parent .image-upload-area
        const insertAfter = el.closest('.image-upload-area') ?? el;
        insertAfter.parentNode.insertBefore(errEl, insertAfter.nextSibling);
    }
    errEl.style.display = 'block';
    errEl.textContent   = label + ' wajib diisi.';

    el.addEventListener('animationend', () => el.classList.remove('field-shake'), { once: true });
}

// HELPER: Bersihkan error pada field ─
function clearFieldError(id) {
    const el    = document.getElementById(id);
    const errEl = document.getElementById(id + '-error');
    if (el)    el.classList.remove('is-invalid');
    if (errEl) errEl.style.display = 'none';
}

// HELPER: Scroll ke field 
function scrollToField(el) {
    const offset = 80;
    const top    = el.getBoundingClientRect().top + window.pageYOffset - offset;
    window.scrollTo({ top, behavior: 'smooth' });
    // Fokus hanya untuk non-file input
    if (el.type !== 'file') el.focus();
}

// BERSIHKAN ERROR SAAT USER MENGISI ['judul', 'deskripsi', 'tombol_text', 'tombol_link'].forEach(function (id) {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('input', function () {
            if (el.value.trim()) clearFieldError(id);
        });
    }
});
// Gambar: clear error saat file berubah (sudah ditangani di previewImage)
document.getElementById('gambar').addEventListener('change', function () {
    if (this.files.length > 0) clearFieldError('gambar');
});

// VALIDASI SEMUA FIELD WAJIB 
function validateAllFields() {
    const fields = [
        { id: 'judul',       label: 'Judul',       type: 'text' },
        { id: 'deskripsi',   label: 'Deskripsi',   type: 'text' },
        { id: 'tombol_text', label: 'Teks Tombol', type: 'text' },
        { id: 'tombol_link', label: 'Link Tombol', type: 'text' },
        { id: 'gambar',      label: 'Gambar',      type: 'file' },
    ];

    let firstEmptyEl = null;

    fields.forEach(function (field) {
        const el      = document.getElementById(field.id);
        const isEmpty = field.type === 'file'
            ? (!el || el.files.length === 0)
            : (!el || el.value.trim() === '');

        if (isEmpty) {
            showFieldError(el, field.label);
            if (!firstEmptyEl) firstEmptyEl = el;
        } else {
            clearFieldError(field.id);
        }
    });

    if (firstEmptyEl) {
        scrollToField(firstEmptyEl);
        return false;
    }

    return true;
}

// SUBMIT FORM 
document.getElementById('heroForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Validasi dulu — jika ada yang kosong, STOP di sini (tidak ada konfirmasi/loading)
    if (!validateAllFields()) return;

    // Semua terisi → tampilkan konfirmasi
    Swal.fire({
        title: 'Konfirmasi Penyimpanan',
        html: 'Hero baru akan ditambahkan ke urutan <strong>#{{ $nextUrutan }}</strong><br><small class="text-muted">Pastikan semua data sudah benar sebelum menyimpan.</small>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check"></i> Ya, Simpan',
        cancelButtonText:  '<i class="fas fa-times"></i> Batal',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menyimpan Data...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
            this.submit();
        }
    });
});
</script>
@endpush