@extends('admin.layouts.app')

@section('title', 'Tambah Armada Baru')

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

    .section-title i {
        font-size: 1.5rem;
        color: var(--orange-primary);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .required-indicator {
        color: #dc3545;
        margin-left: 0.25rem;
    }

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

    .preview-wrapper:hover {
        border-color: var(--orange-primary);
        background: rgba(251, 133, 0, 0.05);
    }

    .preview-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-placeholder {
        text-align: center;
        color: #6c757d;
        padding: 1rem;
    }

    .preview-placeholder i {
        font-size: 3rem;
        color: #e9ecef;
        margin-bottom: 0.5rem;
    }

    .fasilitas-container {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .fasilitas-item-input {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .fasilitas-item-input input {
        flex: 1;
    }

    .btn-remove-fasilitas {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .btn-remove-fasilitas:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }

    .btn-add-fasilitas {
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .btn-add-fasilitas:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(33, 158, 188, 0.4);
    }

    .switch-container {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .switch-label {
        font-weight: 600;
        color: var(--blue-dark);
    }

    .switch-description {
        font-size: 0.85rem;
        color: #6c757d;
        margin-left: auto;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #e9ecef;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        border: none;
        padding: 0.8rem 2.5rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 133, 0, 0.5);
    }

    .btn-cancel {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
        border: none;
        padding: 0.8rem 2.5rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
        color: white;
    }

    /* GALERI MULTI-UPLOAD STYLES */
    .galeri-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8f9fa;
        position: relative;
    }

    .galeri-upload-area:hover,
    .galeri-upload-area.drag-over {
        border-color: var(--orange-primary);
        background: rgba(251, 133, 0, 0.05);
    }

    .galeri-upload-area i {
        font-size: 2.5rem;
        color: #adb5bd;
        margin-bottom: 0.75rem;
        display: block;
    }

    .galeri-upload-area p {
        color: #6c757d;
        margin: 0;
        font-size: 0.95rem;
    }

    .galeri-upload-area span {
        color: var(--orange-primary);
        font-weight: 600;
        cursor: pointer;
    }

    #galeri-hidden-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .galeri-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
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
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        opacity: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .galeri-item:hover .galeri-item-overlay {
        opacity: 1;
    }

    .btn-hapus-galeri-item {
        background: #dc3545;
        color: white;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.85rem;
    }

    .btn-hapus-galeri-item:hover {
        background: #c82333;
        transform: scale(1.1);
    }

    .galeri-item-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.6);
        color: white;
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .galeri-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: var(--orange-primary);
        color: white;
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-top: 0.75rem;
    }

    .btn-add-more-galeri {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.75rem;
        position: relative;
        overflow: hidden;
    }

    .btn-add-more-galeri:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(251, 133, 0, 0.4);
    }

    .btn-add-more-galeri input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    @media (max-width: 768px) {
        .form-section { padding: 1.5rem; }
        .form-actions { flex-direction: column; }
        .btn-submit, .btn-cancel { width: 100%; justify-content: center; }
        .preview-wrapper { width: 100%; }
        .switch-container { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
        .switch-description { margin-left: 0; }
        .galeri-grid { grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); }
    }
</style>

<!-- Page Header -->
<div class="gradient-header">
    <div class="header-left">
        <a href="{{ route('admin.armada.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="header-icon">
            <i class="fas fa-plus-circle"></i>
        </div>
        <div>
            <h1 class="header-title">Tambah Armada Baru</h1>
            <p class="header-subtitle">Tambahkan armada bus baru ke dalam sistem</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.armada.store') }}" method="POST" enctype="multipart/form-data" id="formArmada">
    @csrf

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
                           value="{{ old('nama') }}"
                           placeholder="Contoh: Bus Pariwisata Executive"
                           required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Slug URL akan dibuat otomatis dari nama armada</small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="kategori_bus_id" class="form-label">
                        Tipe Bus<span class="required-indicator">*</span>
                    </label>
                    <select class="form-select @error('kategori_bus_id') is-invalid @enderror"
                            id="kategori_bus_id"
                            name="kategori_bus_id"
                            required
                            onchange="updateKapasitas(this)">
                        <option value="">-- Pilih Tipe Bus --</option>
                        @foreach($kategoriBus as $kategori)
                            <option value="{{ $kategori->id }}"
                                    data-min="{{ $kategori->kapasitas_min }}"
                                    data-max="{{ $kategori->kapasitas_max }}"
                                    {{ old('kategori_bus_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_bus_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Kapasitas Minimum</label>
                    <input type="text" class="form-control" id="display_kapasitas_min" 
                        value="{{ old('kategori_bus_id') ? $kategoriBus->find(old('kategori_bus_id'))?->kapasitas_min : '' }}"
                        placeholder="Otomatis dari tipe bus" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Kapasitas Maximum</label>
                    <input type="text" class="form-control" id="display_kapasitas_max"
                        value="{{ old('kategori_bus_id') ? $kategoriBus->find(old('kategori_bus_id'))?->kapasitas_max : '' }}"
                        placeholder="Otomatis dari tipe bus" disabled>
                </div>
            </div>
        </div>
        <small class="text-muted d-block mb-3">Kapasitas diambil otomatis dari tipe bus yang dipilih</small>

        <div class="form-group">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                      id="deskripsi"
                      name="deskripsi"
                      rows="4"
                      placeholder="Deskripsi lengkap tentang armada ini...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Urutan Tampilan</label>
            <input type="text"
                   class="form-control"
                   value="{{ $nextUrutan }}"
                   disabled>
            <small class="text-muted">Armada baru akan ditambahkan di urutan terakhir</small>
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
            <label for="gambar_utama" class="form-label">Gambar Utama</label>
            <input type="file"
                   class="form-control @error('gambar_utama') is-invalid @enderror"
                   id="gambar_utama"
                   name="gambar_utama"
                   accept="image/jpeg,image/jpg,image/png,image/webp"
                   onchange="previewImage(this, 'preview-utama')">
            @error('gambar_utama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Format: JPG, PNG, WebP. Maksimal 10MB. Gambar akan dikonversi ke WebP HD.</small>

            <div class="image-preview-container">
                <div class="preview-wrapper" id="preview-utama">
                    <div class="preview-placeholder">
                        <i class="fas fa-image"></i>
                        <p>Preview gambar utama</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Galeri Multi-Upload -->
        <div class="form-group">
            <label class="form-label">Galeri Gambar</label>
            <small class="text-muted d-block mb-2">
                Pilih satu atau beberapa gambar. Bisa tambah gambar lagi berkali-kali sebelum menyimpan. Format: JPG, PNG, WebP. Maksimal 10MB per file.
            </small>

            <!-- Drop zone -->
            <div class="galeri-upload-area" id="galeriDropZone">
                <input type="file" id="galeri-hidden-input" accept="image/jpeg,image/jpg,image/png,image/webp" multiple>
                <i class="fas fa-cloud-upload-alt"></i>
                <p><span>Klik untuk pilih gambar</span> atau drag &amp; drop di sini</p>
                <p><small>Bisa pilih beberapa gambar sekaligus</small></p>
            </div>

            <!-- Container untuk preview gambar yang sudah dipilih -->
            <div id="galeri-grid" class="galeri-grid"></div>

            <!-- Tombol tambah lebih banyak gambar (muncul setelah ada gambar) -->
            <div id="galeri-actions" style="display:none; margin-top: 0.75rem;">
                <span id="galeri-count-badge" class="galeri-count-badge">
                    <i class="fas fa-images"></i>
                    <span id="galeri-count-text">0 gambar dipilih</span>
                </span>
                <br>
                <button type="button" class="btn-add-more-galeri" onclick="document.getElementById('galeri-tambah-input').click()">
                    <i class="fas fa-plus"></i>
                    Tambah Gambar Lagi
                </button>
                <input type="file" id="galeri-tambah-input" accept="image/jpeg,image/jpg,image/png,image/webp" multiple style="display:none;" onchange="handleGaleriFiles(this.files)">
            </div>

            <!-- Hidden container untuk file inputs yang akan di-submit -->
            <div id="galeri-file-inputs" style="display:none;"></div>
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
                @foreach(old('fasilitas') as $index => $fasilitas)
                <div class="fasilitas-item-input">
                    <input type="text"
                           class="form-control"
                           name="fasilitas[]"
                           value="{{ $fasilitas }}"
                           placeholder="Contoh: AC, Reclining Seat, TV, etc">
                    <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endforeach
            @else
                <div class="fasilitas-item-input">
                    <input type="text"
                           class="form-control"
                           name="fasilitas[]"
                           placeholder="Contoh: AC, Reclining Seat, TV, etc">
                    <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)">
                        <i class="fas fa-times"></i>
                    </button>
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
                <input type="checkbox"
                       name="unggulan"
                       value="1"
                       {{ old('unggulan') ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
            <span class="switch-label">Armada Unggulan</span>
            <span class="switch-description">Tampilkan sebagai armada unggulan di website</span>
        </div>

        <div class="switch-container">
            <label class="switch">
                <input type="checkbox"
                       name="tersedia"
                       value="1"
                       {{ old('tersedia', true) ? 'checked' : '' }}>
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
            Simpan Armada
        </button>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // GALERI MULTI-BATCH UPLOAD
    // Menyimpan semua File objects yang sudah dipilih user
    let galeriFiles = [];

    const dropZone = document.getElementById('galeriDropZone');
    const hiddenInput = document.getElementById('galeri-hidden-input');

    // Klik drop zone -> buka file picker
    dropZone.addEventListener('click', function(e) {
        if (e.target !== hiddenInput) {
            hiddenInput.click();
        }
    });

    // Handle file dari drop zone input
    hiddenInput.addEventListener('change', function() {
        handleGaleriFiles(this.files);
        this.value = ''; // reset supaya bisa pilih file yang sama lagi jika perlu
    });

    // Drag & Drop support
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });
    dropZone.addEventListener('dragleave', function() {
        this.classList.remove('drag-over');
    });
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        handleGaleriFiles(e.dataTransfer.files);
    });

    function handleGaleriFiles(fileList) {
        if (!fileList || fileList.length === 0) return;

        Array.from(fileList).forEach(file => {
            // Validasi tipe file
            if (!['image/jpeg', 'image/jpg', 'image/png', 'image/webp'].includes(file.type)) {
                Swal.fire('Format Tidak Didukung', `File "${file.name}" bukan gambar yang valid (JPG, PNG, WebP).`, 'warning');
                return;
            }
            // Validasi ukuran (10MB)
            if (file.size > 10 * 1024 * 1024) {
                Swal.fire('File Terlalu Besar', `File "${file.name}" melebihi batas 10MB.`, 'warning');
                return;
            }

            // Cek duplikat berdasarkan nama + size
            const isDuplicate = galeriFiles.some(f => f.name === file.name && f.size === file.size);
            if (!isDuplicate) {
                galeriFiles.push(file);
                addGaleriPreview(file, galeriFiles.length - 1);
            }
        });

        updateGaleriFileInputs();
        updateGaleriUI();
    }

    function addGaleriPreview(file, index) {
        const grid = document.getElementById('galeri-grid');
        const reader = new FileReader();

        reader.onload = function(e) {
            const item = document.createElement('div');
            item.className = 'galeri-item';
            item.dataset.index = index;
            item.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                <div class="galeri-item-overlay">
                    <button type="button" class="btn-hapus-galeri-item" onclick="removeGaleriItem(${index})" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="galeri-item-label">${file.name}</div>
            `;
            grid.appendChild(item);
        };

        reader.readAsDataURL(file);
    }

    function removeGaleriItem(index) {
        // Tandai sebagai null (bukan splice supaya index lain tidak bergeser)
        galeriFiles[index] = null;

        // Hapus elemen preview dari DOM
        const item = document.querySelector(`.galeri-item[data-index="${index}"]`);
        if (item) item.remove();

        updateGaleriFileInputs();
        updateGaleriUI();
    }

    function updateGaleriFileInputs() {
        // Rebuild DataTransfer untuk setiap file yang masih ada
        // Karena HTML file input tidak bisa programatically set, kita buat input per-file
        const container = document.getElementById('galeri-file-inputs');
        container.innerHTML = '';

        // Buat satu DataTransfer untuk semua file yang valid
        const dt = new DataTransfer();
        galeriFiles.forEach(file => {
            if (file !== null) dt.items.add(file);
        });

        // Satu input file dengan semua file
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'galeri[]';
        input.multiple = true;
        input.style.display = 'none';

        try {
            input.files = dt.files;
        } catch(e) {
            // Fallback: buat input terpisah per file
            container.innerHTML = '';
            galeriFiles.forEach((file, idx) => {
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
            return;
        }

        container.appendChild(input);
    }

    function updateGaleriUI() {
        const validCount = galeriFiles.filter(f => f !== null).length;
        const actions = document.getElementById('galeri-actions');
        const countText = document.getElementById('galeri-count-text');

        if (validCount > 0) {
            actions.style.display = 'block';
            countText.textContent = validCount + ' gambar dipilih';
        } else {
            actions.style.display = 'none';
        }
    }

    // PREVIEW GAMBAR UTAMA
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // FASILITAS
    function addFasilitas() {
        const container = document.getElementById('fasilitas-container');
        const newItem = document.createElement('div');
        newItem.className = 'fasilitas-item-input';
        newItem.innerHTML = `
            <input type="text" class="form-control" name="fasilitas[]" placeholder="Contoh: AC, Reclining Seat, TV, etc">
            <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)">
                <i class="fas fa-times"></i>
            </button>
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

    // FORM SUBMIT
    document.getElementById('formArmada').addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Simpan Armada?',
            text: "Data armada baru akan disimpan ke database",
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