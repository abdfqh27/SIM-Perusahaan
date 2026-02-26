@extends('admin.layouts.app')

@section('title', 'Edit Armada - ' . $armada->nama)

@section('content')
<style>
    .form-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i { font-size: 1.5rem; color: var(--orange-primary); }
    .form-group { margin-bottom: 1.5rem; }
    .required-indicator { color: #dc3545; margin-left: 0.25rem; }

    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1rem;
    }

    .preview-wrapper {
        position: relative;
        width: 200px;
        height: 200px;
        border: 2px dashed #e9ecef;
        border-radius: 10px;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .preview-wrapper:hover { border-color: var(--orange-primary); background: rgba(251, 133, 0, 0.05); }
    .preview-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    .preview-placeholder { text-align: center; color: #6c757d; padding: 1rem; }
    .preview-placeholder i { font-size: 3rem; color: #e9ecef; margin-bottom: 0.5rem; }

    .fasilitas-container { display: flex; flex-direction: column; gap: 0.75rem; }
    .fasilitas-item-input { display: flex; gap: 0.5rem; align-items: center; }
    .fasilitas-item-input input { flex: 1; }

    .btn-remove-fasilitas {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white; border: none; width: 40px; height: 40px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
        transition: all 0.3s ease; flex-shrink: 0;
    }
    .btn-remove-fasilitas:hover { transform: scale(1.05); box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4); }

    .btn-add-fasilitas {
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white; border: none; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 500;
        cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 0.5rem; margin-top: 0.5rem;
    }
    .btn-add-fasilitas:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(33, 158, 188, 0.4); }

    .switch-container {
        display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f8f9fa;
        border-radius: 10px; margin-bottom: 1rem;
    }

    .switch { position: relative; display: inline-block; width: 60px; height: 34px; }
    .switch input { opacity: 0; width: 0; height: 0; }

    .slider {
        position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
        background-color: #ccc; transition: 0.4s; border-radius: 34px;
    }
    .slider:before {
        position: absolute; content: ""; height: 26px; width: 26px; left: 4px; bottom: 4px;
        background-color: white; transition: 0.4s; border-radius: 50%;
    }
    input:checked + .slider { background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary)); }
    input:checked + .slider:before { transform: translateX(26px); }

    .switch-label { font-weight: 600; color: var(--blue-dark); }
    .switch-description { font-size: 0.85rem; color: #6c757d; margin-left: auto; }

    .form-actions {
        display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;
        padding-top: 2rem; border-top: 2px solid #e9ecef;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white; border: none; padding: 0.8rem 2.5rem; border-radius: 10px; font-weight: 600;
        cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.3);
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(251, 133, 0, 0.5); }

    .btn-cancel {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white; border: none; padding: 0.8rem 2.5rem; border-radius: 10px; font-weight: 600;
        cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center;
        gap: 0.5rem; text-decoration: none;
    }
    .btn-cancel:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4); color: white; }

    /*  GALERI STYLES  */
    .galeri-section-label {
        font-weight: 600;
        color: var(--blue-dark);
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .galeri-existing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .galeri-item {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background: #f8f9fa;
        aspect-ratio: 1;
    }

    .galeri-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .galeri-item-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.45);
        opacity: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .galeri-item:hover .galeri-item-overlay { opacity: 1; }

    .btn-hapus-galeri-ajax {
        background: #dc3545;
        color: white; border: none; width: 40px; height: 40px;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.2s ease; font-size: 0.9rem;
    }
    .btn-hapus-galeri-ajax:hover { background: #c82333; transform: scale(1.1); }

    .galeri-item.deleting {
        opacity: 0.4;
        pointer-events: none;
    }

    .galeri-item.deleted {
        display: none;
    }

    .galeri-empty-text {
        color: #adb5bd;
        font-size: 0.9rem;
        font-style: italic;
        padding: 0.5rem 0;
    }

    /* Upload area untuk gambar baru */
    .galeri-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 1.5rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8f9fa;
        position: relative;
        margin-top: 0.5rem;
    }

    .galeri-upload-area:hover,
    .galeri-upload-area.drag-over {
        border-color: var(--orange-primary);
        background: rgba(251, 133, 0, 0.05);
    }

    .galeri-upload-area i { font-size: 2rem; color: #adb5bd; margin-bottom: 0.5rem; display: block; }
    .galeri-upload-area p { color: #6c757d; margin: 0; font-size: 0.9rem; }
    .galeri-upload-area span { color: var(--orange-primary); font-weight: 600; }

    #galeri-hidden-input-edit {
        position: absolute;
        width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;
    }

    .galeri-new-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .galeri-new-item {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        aspect-ratio: 1;
        border: 2px solid var(--orange-primary);
    }

    .galeri-new-item img { width: 100%; height: 100%; object-fit: cover; display: block; }

    .galeri-new-item-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.45);
        opacity: 0; transition: all 0.3s ease;
        display: flex; align-items: center; justify-content: center;
    }
    .galeri-new-item:hover .galeri-new-item-overlay { opacity: 1; }

    .btn-hapus-new-galeri {
        background: #dc3545;
        color: white; border: none; width: 36px; height: 36px;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.2s ease;
    }
    .btn-hapus-new-galeri:hover { background: #c82333; transform: scale(1.1); }

    .galeri-new-badge {
        position: absolute; top: 6px; right: 6px;
        background: var(--orange-primary); color: white;
        font-size: 0.65rem; padding: 2px 7px; border-radius: 10px; font-weight: 700;
    }

    .galeri-count-badge {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: var(--orange-primary); color: white;
        padding: 0.3rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;
    }

    .btn-add-more-galeri {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white; border: none; padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 500;
        cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 0.5rem; margin-top: 0.75rem;
    }
    .btn-add-more-galeri:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(251, 133, 0, 0.4); }

    @media (max-width: 768px) {
        .form-section { padding: 1.5rem; }
        .form-actions { flex-direction: column; }
        .btn-submit, .btn-cancel { width: 100%; justify-content: center; }
        .switch-container { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
        .switch-description { margin-left: 0; }
        .galeri-existing-grid, .galeri-new-grid { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); }
    }
</style>

<!-- Page Header -->
<div class="gradient-header">
    <div class="header-left">
        <a href="{{ route('admin.armada.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="header-icon">
            <i class="fas fa-edit"></i>
        </div>
        <div>
            <h1 class="header-title">Edit Armada</h1>
            <p class="header-subtitle">{{ $armada->nama }}</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.armada.update', $armada) }}" method="POST" enctype="multipart/form-data" id="formArmada">
    @csrf
    @method('PUT')

    <!-- Informasi Dasar -->
    <div class="form-section">
        <h2 class="section-title">
            <i class="fas fa-info-circle"></i>
            Informasi Dasar
        </h2>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama" class="form-label">
                        Nama Armada<span class="required-indicator">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('nama') is-invalid @enderror"
                           id="nama"
                           name="nama"
                           value="{{ old('nama', $armada->nama) }}"
                           placeholder="Contoh: Bus Pariwisata Executive"
                           required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Slug (URL)</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $armada->slug }}"
                           disabled>
                    <small class="text-muted">Slug otomatis diperbarui jika nama armada diubah</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tipe_bus" class="form-label">
                        Tipe Bus<span class="required-indicator">*</span>
                    </label>
                    <select class="form-select @error('tipe_bus') is-invalid @enderror"
                            id="tipe_bus" name="tipe_bus" required>
                        <option value="">-- Pilih Tipe Bus --</option>
                        @foreach($daftarTipeBus as $tipe)
                            <option value="{{ $tipe }}" {{ old('tipe_bus', $armada->tipe_bus) == $tipe ? 'selected' : '' }}>
                                {{ $tipe }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipe_bus')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="kapasitas_min" class="form-label">
                        Kapasitas Minimum<span class="required-indicator">*</span>
                    </label>
                    <input type="number"
                           class="form-control @error('kapasitas_min') is-invalid @enderror"
                           id="kapasitas_min" name="kapasitas_min"
                           value="{{ old('kapasitas_min', $armada->kapasitas_min) }}"
                           min="1" placeholder="20" required>
                    @error('kapasitas_min')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="kapasitas_max" class="form-label">
                        Kapasitas Maximum<span class="required-indicator">*</span>
                    </label>
                    <input type="number"
                           class="form-control @error('kapasitas_max') is-invalid @enderror"
                           id="kapasitas_max" name="kapasitas_max"
                           value="{{ old('kapasitas_max', $armada->kapasitas_max) }}"
                           min="1" placeholder="45" required>
                    @error('kapasitas_max')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                      id="deskripsi" name="deskripsi" rows="4"
                      placeholder="Deskripsi lengkap tentang armada ini...">{{ old('deskripsi', $armada->deskripsi) }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="urutan" class="form-label">
                Urutan Tampilan<span class="required-indicator">*</span>
            </label>
            <select class="form-select @error('urutan') is-invalid @enderror"
                    id="urutan" name="urutan" required>
                @for($i = 1; $i <= $maxUrutan; $i++)
                    <option value="{{ $i }}" {{ old('urutan', $armada->urutan) == $i ? 'selected' : '' }}>
                        Urutan {{ $i }}
                        @if($allArmadas->where('urutan', $i)->first() && $allArmadas->where('urutan', $i)->first()->id !== $armada->id)
                            - {{ $allArmadas->where('urutan', $i)->first()->nama }}
                        @elseif($allArmadas->where('urutan', $i)->first() && $allArmadas->where('urutan', $i)->first()->id === $armada->id)
                            (Posisi saat ini)
                        @endif
                    </option>
                @endfor
            </select>
            @error('urutan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Mengubah urutan akan menggeser armada lain secara otomatis</small>
        </div>
    </div>

    <!-- Gambar -->
    <div class="form-section">
        <h2 class="section-title">
            <i class="fas fa-images"></i>
            Gambar Armada
        </h2>

        <!-- Gambar Utama -->
        <div class="form-group">
            <label class="form-label">Gambar Utama</label>

            @if($armada->gambar_utama)
            <div class="mb-3">
                <p class="galeri-section-label"><i class="fas fa-image text-muted"></i> Gambar saat ini:</p>
                <div class="preview-wrapper" style="width:200px; height:200px;">
                    <img src="{{ asset('storage/' . $armada->gambar_utama) }}" alt="Gambar Utama">
                </div>
            </div>
            @endif

            <input type="file"
                   class="form-control @error('gambar_utama') is-invalid @enderror"
                   id="gambar_utama" name="gambar_utama"
                   accept="image/jpeg,image/jpg,image/png,image/webp"
                   onchange="previewImage(this, 'preview-utama-new')">
            @error('gambar_utama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Upload gambar baru untuk mengganti yang lama. Format: JPG, PNG, WebP. Maks 10MB.</small>

            <div class="image-preview-container">
                <div class="preview-wrapper" id="preview-utama-new" style="display:none; width:200px; height:200px;">
                </div>
            </div>
        </div>

        <!-- Galeri -->
        <div class="form-group">
            <label class="form-label">Galeri Gambar</label>

            <!-- Galeri yang sudah ada -->
            @if($armada->galeri && count($armada->galeri) > 0)
            <p class="galeri-section-label">
                <i class="fas fa-photo-video text-muted"></i>
                Galeri saat ini — klik ikon hapus untuk menghapus langsung:
            </p>
            <div class="galeri-existing-grid" id="galeri-existing-grid">
                @foreach($armada->galeri as $galeriPath)
                <div class="galeri-item" id="galeri-item-{{ md5($galeriPath) }}" data-path="{{ $galeriPath }}">
                    <img src="{{ asset('storage/' . $galeriPath) }}" alt="Galeri">
                    <div class="galeri-item-overlay">
                        <button type="button"
                                class="btn-hapus-galeri-ajax"
                                onclick="hapusGaleriAjax('{{ $galeriPath }}', '{{ md5($galeriPath) }}')"
                                title="Hapus gambar ini">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="galeri-empty-text" id="galeri-empty-msg">Belum ada gambar galeri.</p>
            @endif

            <hr class="my-3">

            <!-- Upload gambar galeri baru -->
            <p class="galeri-section-label">
                <i class="fas fa-plus-circle" style="color: var(--orange-primary)"></i>
                Tambah gambar galeri baru:
            </p>
            <small class="text-muted d-block mb-2">
                Bisa pilih beberapa gambar sekaligus, atau tambah berkali-kali sebelum menyimpan. Format: JPG, PNG, WebP. Maks 10MB/file.
            </small>

            <div class="galeri-upload-area" id="galeriDropZone">
                <input type="file" id="galeri-hidden-input-edit" accept="image/jpeg,image/jpg,image/png,image/webp" multiple>
                <i class="fas fa-cloud-upload-alt"></i>
                <p><span>Klik untuk pilih gambar</span> atau drag &amp; drop di sini</p>
            </div>

            <div id="galeri-new-grid" class="galeri-new-grid"></div>

            <div id="galeri-new-actions" style="display:none; margin-top: 0.75rem;">
                <span class="galeri-count-badge">
                    <i class="fas fa-images"></i>
                    <span id="galeri-new-count-text">0 gambar baru</span>
                </span>
                <br>
                <button type="button" class="btn-add-more-galeri" onclick="document.getElementById('galeri-tambah-input-edit').click()">
                    <i class="fas fa-plus"></i>
                    Tambah Gambar Lagi
                </button>
                <input type="file" id="galeri-tambah-input-edit" accept="image/jpeg,image/jpg,image/png,image/webp" multiple style="display:none;" onchange="handleNewGaleriFiles(this.files); this.value='';">
            </div>

            <!-- Hidden file inputs untuk submit -->
            <div id="galeri-new-file-inputs" style="display:none;"></div>
        </div>
    </div>

    <!-- Fasilitas -->
    <div class="form-section">
        <h2 class="section-title">
            <i class="fas fa-list-check"></i>
            Fasilitas Armada
        </h2>

        <div id="fasilitas-container" class="fasilitas-container">
            @if(old('fasilitas'))
                @foreach(old('fasilitas') as $fasilitas)
                <div class="fasilitas-item-input">
                    <input type="text" class="form-control" name="fasilitas[]" value="{{ $fasilitas }}" placeholder="Contoh: AC, Reclining Seat, TV, etc">
                    <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)"><i class="fas fa-times"></i></button>
                </div>
                @endforeach
            @elseif($armada->fasilitas && count($armada->fasilitas) > 0)
                @foreach($armada->fasilitas as $fasilitas)
                <div class="fasilitas-item-input">
                    <input type="text" class="form-control" name="fasilitas[]" value="{{ $fasilitas }}" placeholder="Contoh: AC, Reclining Seat, TV, etc">
                    <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)"><i class="fas fa-times"></i></button>
                </div>
                @endforeach
            @else
                <div class="fasilitas-item-input">
                    <input type="text" class="form-control" name="fasilitas[]" placeholder="Contoh: AC, Reclining Seat, TV, etc">
                    <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)"><i class="fas fa-times"></i></button>
                </div>
            @endif
        </div>

        <button type="button" class="btn-add-fasilitas" onclick="addFasilitas()">
            <i class="fas fa-plus"></i>
            Tambah Fasilitas
        </button>
    </div>

    <!-- Status -->
    <div class="form-section">
        <h2 class="section-title">
            <i class="fas fa-toggle-on"></i>
            Status Armada
        </h2>

        <div class="switch-container">
            <label class="switch">
                <input type="checkbox" name="unggulan" value="1"
                       {{ old('unggulan', $armada->unggulan) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
            <span class="switch-label">Armada Unggulan</span>
            <span class="switch-description">Tampilkan sebagai armada unggulan di website</span>
        </div>

        <div class="switch-container">
            <label class="switch">
                <input type="checkbox" name="tersedia" value="1"
                       {{ old('tersedia', $armada->tersedia) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
            <span class="switch-label">Tersedia</span>
            <span class="switch-description">Armada dapat disewa oleh customer</span>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <a href="{{ route('admin.armada.index') }}" class="btn-cancel">
            <i class="fas fa-times"></i>
            Batal
        </a>
        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i>
            Simpan Perubahan
        </button>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const ARMADA_ID = {{ $armada->id }};
    const DELETE_GALERI_URL = "{{ route('admin.armada.deleteGaleriImage', $armada) }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";

    //  HAPUS GALERI VIA AJAX 
    async function hapusGaleriAjax(imagePath, hash) {
        const result = await Swal.fire({
            title: 'Hapus Gambar?',
            text: 'Gambar akan dihapus permanen dari storage dan database.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        });

        if (!result.isConfirmed) return;

        const itemEl = document.getElementById('galeri-item-' + hash);
        itemEl.classList.add('deleting');

        try {
            const response = await fetch(DELETE_GALERI_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ image_path: imagePath })
            });

            const data = await response.json();

            if (data.success) {
                itemEl.classList.add('deleted');
                Swal.fire({
                    title: 'Dihapus!',
                    text: 'Gambar berhasil dihapus.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });

                // Cek apakah galeri sudah kosong
                const existingGrid = document.getElementById('galeri-existing-grid');
                if (existingGrid) {
                    const remaining = existingGrid.querySelectorAll('.galeri-item:not(.deleted)').length;
                    if (remaining === 0) {
                        const emptyMsg = document.getElementById('galeri-empty-msg');
                        if (emptyMsg) emptyMsg.style.display = 'block';
                    }
                }
            } else {
                itemEl.classList.remove('deleting');
                Swal.fire('Gagal', data.message || 'Gagal menghapus gambar.', 'error');
            }
        } catch (err) {
            itemEl.classList.remove('deleting');
            Swal.fire('Error', 'Terjadi kesalahan koneksi.', 'error');
        }
    }

    //  GALERI MULTI-BATCH UPLOAD (BARU) 
    let newGaleriFiles = [];

    const dropZone = document.getElementById('galeriDropZone');
    const hiddenInputEdit = document.getElementById('galeri-hidden-input-edit');

    dropZone.addEventListener('click', function(e) {
        if (e.target !== hiddenInputEdit) hiddenInputEdit.click();
    });
    hiddenInputEdit.addEventListener('change', function() {
        handleNewGaleriFiles(this.files);
        this.value = '';
    });

    dropZone.addEventListener('dragover', function(e) { e.preventDefault(); this.classList.add('drag-over'); });
    dropZone.addEventListener('dragleave', function() { this.classList.remove('drag-over'); });
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        handleNewGaleriFiles(e.dataTransfer.files);
    });

    function handleNewGaleriFiles(fileList) {
        if (!fileList || fileList.length === 0) return;

        Array.from(fileList).forEach(file => {
            if (!['image/jpeg', 'image/jpg', 'image/png', 'image/webp'].includes(file.type)) {
                Swal.fire('Format Tidak Didukung', `File "${file.name}" bukan gambar valid.`, 'warning');
                return;
            }
            if (file.size > 10 * 1024 * 1024) {
                Swal.fire('File Terlalu Besar', `File "${file.name}" melebihi 10MB.`, 'warning');
                return;
            }
            const isDuplicate = newGaleriFiles.some(f => f !== null && f.name === file.name && f.size === file.size);
            if (!isDuplicate) {
                newGaleriFiles.push(file);
                addNewGaleriPreview(file, newGaleriFiles.length - 1);
            }
        });

        updateNewGaleriFileInputs();
        updateNewGaleriUI();
    }

    function addNewGaleriPreview(file, index) {
        const grid = document.getElementById('galeri-new-grid');
        const reader = new FileReader();
        reader.onload = function(e) {
            const item = document.createElement('div');
            item.className = 'galeri-new-item';
            item.dataset.index = index;
            item.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                <div class="galeri-new-badge">BARU</div>
                <div class="galeri-new-item-overlay">
                    <button type="button" class="btn-hapus-new-galeri" onclick="removeNewGaleriItem(${index})" title="Batalkan">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            grid.appendChild(item);
        };
        reader.readAsDataURL(file);
    }

    function removeNewGaleriItem(index) {
        newGaleriFiles[index] = null;
        const item = document.querySelector(`.galeri-new-item[data-index="${index}"]`);
        if (item) item.remove();
        updateNewGaleriFileInputs();
        updateNewGaleriUI();
    }

    function updateNewGaleriFileInputs() {
        const container = document.getElementById('galeri-new-file-inputs');
        container.innerHTML = '';

        const dt = new DataTransfer();
        newGaleriFiles.forEach(file => { if (file !== null) dt.items.add(file); });

        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'galeri[]';
        input.multiple = true;
        input.style.display = 'none';

        try {
            input.files = dt.files;
            container.appendChild(input);
        } catch(e) {
            newGaleriFiles.forEach(file => {
                if (file === null) return;
                const singleDt = new DataTransfer();
                singleDt.items.add(file);
                const singleInput = document.createElement('input');
                singleInput.type = 'file';
                singleInput.name = 'galeri[]';
                singleInput.style.display = 'none';
                singleInput.files = singleDt.files;
                container.appendChild(singleInput);
            });
        }
    }

    function updateNewGaleriUI() {
        const validCount = newGaleriFiles.filter(f => f !== null).length;
        const actions = document.getElementById('galeri-new-actions');
        const countText = document.getElementById('galeri-new-count-text');

        actions.style.display = validCount > 0 ? 'block' : 'none';
        countText.textContent = validCount + ' gambar baru';
    }

    //  PREVIEW GAMBAR UTAMA 
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.style.display = 'flex';
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    //  FASILITAS 
    function addFasilitas() {
        const container = document.getElementById('fasilitas-container');
        const newItem = document.createElement('div');
        newItem.className = 'fasilitas-item-input';
        newItem.innerHTML = `
            <input type="text" class="form-control" name="fasilitas[]" placeholder="Contoh: AC, Reclining Seat, TV, etc">
            <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(newItem);
    }

    function removeFasilitas(button) {
        const container = document.getElementById('fasilitas-container');
        if (container.children.length > 1) {
            button.parentElement.remove();
        } else {
            Swal.fire({ title: 'Perhatian', text: 'Minimal harus ada 1 field fasilitas', icon: 'warning', confirmButtonText: 'OK' });
        }
    }

    //  FORM SUBMIT 
    document.getElementById('formArmada').addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Perubahan data armada akan disimpan",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => { Swal.showLoading(); }
                });
                this.submit();
            }
        });
    });
</script>
@endsection