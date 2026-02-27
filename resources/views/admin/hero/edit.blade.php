@extends('admin.layouts.app')

@section('title', 'Edit Hero Section')

@section('content')
<style>
    .edit-hero-card {
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
    
    .current-image-wrapper {
        position: relative;
        display: inline-block;
    }
    
    .current-image-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 3px 10px rgba(33, 158, 188, 0.3);
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
    
    .preview-label {
        font-weight: 600;
        color: var(--orange-primary);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .preview-label i {
        font-size: 1.1rem;
    }
    
    .urutan-info-box {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 2px solid var(--blue-light);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
    }
    
    .urutan-current {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--blue-dark);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
    }

    /* Animasi shake untuk field kosong */
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

<div class="gradient-header">
    <div class="header-left">
        <a href="{{ route('admin.hero.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="header-icon">
            <i class="fas fa-edit"></i>
        </div>
        <div>
            <h2 class="header-title">Edit Hero Section</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.hero.index') }}">Hero Section</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card edit-hero-card">
    <div class="card-header">
        <i class="fas fa-pen me-2"></i> Form Edit Hero Section
    </div>
    <div class="card-body">
        <form id="heroEditForm" action="{{ route('admin.hero.update', $heroSection) }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')
            
            <!-- Informasi Utama -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-info-circle"></i>
                    <span>Informasi Utama</span>
                </div>
                
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" 
                           name="judul" 
                           value="{{ old('judul', $heroSection->judul) }}" 
                           placeholder="Masukkan judul hero section">
                    @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" 
                              name="deskripsi" 
                              rows="4"
                              placeholder="Masukkan deskripsi hero section">{{ old('deskripsi', $heroSection->deskripsi) }}</textarea>
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
                               value="{{ old('tombol_text', $heroSection->tombol_text) }}"
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
                               value="{{ old('tombol_link', $heroSection->tombol_link) }}"
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
                
                @if($heroSection->gambar)
                <div class="mb-3">
                    <label class="form-label">Gambar Saat Ini</label>
                    <div class="current-image-wrapper">
                        <span class="current-image-badge">
                            <i class="fas fa-check-circle"></i> Gambar Aktif
                        </span>
                        <img src="{{ asset('storage/' . $heroSection->gambar) }}" 
                             alt="Current Hero Image" 
                             class="img-thumbnail" 
                             style="max-width: 100%; max-height: 400px;">
                    </div>
                </div>
                @endif
                
                <div class="mb-3">
                    {{-- Jika sudah ada gambar → opsional (ganti). Jika belum → wajib --}}
                    <label for="gambar" class="form-label">
                        @if($heroSection->gambar)
                            Ganti Gambar <span class="text-muted">(Opsional)</span>
                        @else
                            Upload Gambar <span class="text-danger">*</span>
                        @endif
                    </label>
                    <div class="image-upload-area" id="gambar-upload-area">
                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                        <input type="file" 
                               class="form-control @error('gambar') is-invalid @enderror" 
                               id="gambar" 
                               name="gambar" 
                               accept="image/jpeg,image/jpg,image/png"
                               onchange="previewImage(event)">
                        <small class="text-muted d-block mt-2">
                            @if($heroSection->gambar)
                                Kosongkan jika tidak ingin mengganti gambar<br>
                            @endif
                            Format: JPG, PNG | Maksimal: 10MB | Rekomendasi: 1920x1080px
                        </small>
                    </div>
                    @error('gambar')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div id="imagePreview"></div>
                </div>
            </div>

            <!-- Pengaturan Urutan -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-sort"></i>
                    <span>Urutan Tampilan</span>
                </div>
                
                <div class="urutan-info-box">
                    <div class="d-flex align-items-center mb-2">
                        <span style="font-weight: 500; color: var(--blue-dark);">Urutan Saat Ini:</span>
                        <span class="urutan-current ms-2">
                            <i class="fas fa-hashtag"></i>
                            {{ $heroSection->urutan }}
                        </span>
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i>
                        Pilih urutan tujuan — hero lain akan otomatis bergeser
                    </small>
                </div>
                
                <div class="mb-3">
                    <label for="urutan" class="form-label">Tukar Urutan Dengan <span class="text-danger">*</span></label>
                    <select class="form-control @error('urutan') is-invalid @enderror" 
                            id="urutan" 
                            name="urutan">
                        @foreach($allHeroes as $hero)
                            <option value="{{ $hero->urutan }}" 
                                    {{ old('urutan', $heroSection->urutan) == $hero->urutan ? 'selected' : '' }}>
                                #{{ $hero->urutan }} - {{ Str::limit($hero->judul, 50) }}
                                @if($hero->id == $heroSection->id) (Ini) @endif
                                @if($hero->aktif) ✓ @else ✗ @endif
                            </option>
                        @endforeach
                    </select>
                    @error('urutan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        <i class="fas fa-exchange-alt"></i>
                        Hero lain akan otomatis menyesuaikan urutannya.
                    </small>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-lightbulb"></i>
                    <strong>Cara Kerja:</strong><br>
                    • Pilih urutan yang ingin dituju dari dropdown<br>
                    • Hero lain akan otomatis bergeser untuk memberi tempat<br>
                    • Urutan tetap rapi dan berurutan tanpa gap
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
                        <option value="1" {{ old('aktif', $heroSection->aktif) == 1 ? 'selected' : '' }}>Aktif (Ditampilkan)</option>
                        <option value="0" {{ old('aktif', $heroSection->aktif) == 0 ? 'selected' : '' }}>Nonaktif (Disembunyikan)</option>
                    </select>
                    @error('aktif')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const urutanAwal      = {{ $heroSection->urutan }};
const sudahAdaGambar  = {{ $heroSection->gambar ? 'true' : 'false' }};

// PREVIEW GAMBAR 
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const file    = event.target.files[0];

    if (!file) {
        preview.innerHTML = '';
        return;
    }

    if (file.size > 10240 * 1024) {
        Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: 'Ukuran file maksimal 10MB' });
        event.target.value = '';
        preview.innerHTML  = '';
        return;
    }

    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!validTypes.includes(file.type)) {
        Swal.fire({ icon: 'error', title: 'Format Tidak Valid', text: 'Hanya JPG, JPEG, dan PNG yang diperbolehkan' });
        event.target.value = '';
        preview.innerHTML  = '';
        return;
    }

    // Bersihkan error gambar jika sudah dipilih
    clearFieldError('gambar');

    const reader  = new FileReader();
    reader.onload = function (e) {
        preview.innerHTML = `
            <div class="mt-3">
                <div class="preview-label">
                    <i class="fas fa-eye"></i>
                    <span>Preview Gambar Baru:</span>
                </div>
                <img src="${e.target.result}" class="img-thumbnail" style="max-width:100%;max-height:400px;">
            </div>
        `;
    };
    reader.readAsDataURL(file);
}

// HELPER: Tampilkan error ─
function showFieldError(el, label) {
    el.classList.add('is-invalid', 'field-shake');

    let errEl = document.getElementById(el.id + '-error');
    if (!errEl) {
        errEl    = document.createElement('div');
        errEl.id = el.id + '-error';
        errEl.classList.add('invalid-feedback');
        const insertAfter = el.closest('.image-upload-area') ?? el;
        insertAfter.parentNode.insertBefore(errEl, insertAfter.nextSibling);
    }
    errEl.style.display = 'block';
    errEl.textContent   = label + ' wajib diisi.';

    el.addEventListener('animationend', () => el.classList.remove('field-shake'), { once: true });
}

// HELPER: Bersihkan error ─
function clearFieldError(id) {
    const el    = document.getElementById(id);
    const errEl = document.getElementById(id + '-error');
    if (el)    el.classList.remove('is-invalid');
    if (errEl) errEl.style.display = 'none';
}

// HELPER: Scroll ke field ─
function scrollToField(el) {
    const offset = 80;
    const top    = el.getBoundingClientRect().top + window.pageYOffset - offset;
    window.scrollTo({ top, behavior: 'smooth' });
    if (el.type !== 'file' && el.tagName !== 'SELECT') el.focus();
}

// BERSIHKAN ERROR SAAT USER MENGISI ['judul', 'deskripsi', 'tombol_text', 'tombol_link'].forEach(function (id) {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', function () {
        if (el.value.trim()) clearFieldError(id);
    });
});
document.getElementById('gambar').addEventListener('change', function () {
    if (this.files.length > 0) clearFieldError('gambar');
});

// VALIDASI SEMUA FIELD WAJIB 
function validateAllFields() {
    // Field teks yang selalu wajib
    const textFields = [
        { id: 'judul',       label: 'Judul'       },
        { id: 'deskripsi',   label: 'Deskripsi'   },
        { id: 'tombol_text', label: 'Teks Tombol' },
        { id: 'tombol_link', label: 'Link Tombol' },
    ];

    let firstEmptyEl = null;

    textFields.forEach(function (field) {
        const el    = document.getElementById(field.id);
        const empty = !el || el.value.trim() === '';
        if (empty) {
            showFieldError(el, field.label);
            if (!firstEmptyEl) firstEmptyEl = el;
        } else {
            clearFieldError(field.id);
        }
    });

    // Gambar hanya wajib jika belum ada gambar sebelumnya
    if (!sudahAdaGambar) {
        const gambarEl = document.getElementById('gambar');
        const empty    = !gambarEl || gambarEl.files.length === 0;
        if (empty) {
            showFieldError(gambarEl, 'Gambar');
            if (!firstEmptyEl) firstEmptyEl = gambarEl;
        } else {
            clearFieldError('gambar');
        }
    }

    if (firstEmptyEl) {
        scrollToField(firstEmptyEl);
        return false;
    }

    return true;
}

// SUBMIT FORM 
document.getElementById('heroEditForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Validasi dulu — jika ada yang kosong, STOP (tidak ada konfirmasi/loading)
    if (!validateAllFields()) return;

    // Semua terisi → tampilkan konfirmasi
    const urutanBaru = parseInt(document.getElementById('urutan').value);
    let confirmMessage = '';

    if (urutanBaru !== urutanAwal) {
        confirmMessage = `
            <strong>Tukar Urutan:</strong><br>
            Dari urutan <strong>#${urutanAwal}</strong> ke <strong>#${urutanBaru}</strong><br>
            <small class="text-muted">Hero lain akan otomatis bergeser menyesuaikan urutan.</small>
        `;
    } else {
        confirmMessage = `
            Apakah Anda yakin ingin mengupdate data hero section ini?<br>
            <small class="text-muted">Urutan tetap di posisi #${urutanAwal}</small>
        `;
    }

    Swal.fire({
        title: 'Konfirmasi Update',
        html: confirmMessage,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check"></i> Ya, Update',
        cancelButtonText:  '<i class="fas fa-times"></i> Batal',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Mengupdate Data...',
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