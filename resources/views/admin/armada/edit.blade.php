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

    .current-image-wrapper {
        position: relative;
        width: 200px;
        height: 200px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .current-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        color: white;
        padding: 0.5rem;
        font-size: 0.75rem;
        text-align: center;
    }

    .galeri-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .galeri-preview-item {
        position: relative;
        width: 100%;
        padding-top: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .galeri-preview-item img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .btn-remove-galeri {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        z-index: 10;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .btn-remove-galeri:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.5);
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

    .urutan-info {
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.1), rgba(255, 183, 3, 0.1));
        padding: 1rem;
        border-radius: 10px;
        border-left: 4px solid var(--orange-primary);
        margin-top: 0.5rem;
    }

    .urutan-info-text {
        margin: 0;
        color: #495057;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .form-section {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-submit,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }

        .preview-wrapper,
        .current-image-wrapper {
            width: 100%;
        }

        .switch-container {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .switch-description {
            margin-left: 0;
        }
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
            <p class="header-subtitle">Perbarui informasi armada {{ $armada->nama }}</p>
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
                           required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="slug" class="form-label">
                        Slug (URL)
                    </label>
                    <input type="text" 
                           class="form-control @error('slug') is-invalid @enderror" 
                           id="slug" 
                           name="slug" 
                           value="{{ old('slug', $armada->slug) }}"
                           placeholder="Otomatis diisi jika dikosongkan">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                            id="tipe_bus" 
                            name="tipe_bus" 
                            required>
                        <option value="">-- Pilih Tipe Bus --</option>
                        @foreach($daftarTipeBus as $tipe)
                            <option value="{{ $tipe }}" 
                                    {{ old('tipe_bus', $armada->tipe_bus) == $tipe ? 'selected' : '' }}>
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
                           id="kapasitas_min" 
                           name="kapasitas_min" 
                           value="{{ old('kapasitas_min', $armada->kapasitas_min) }}"
                           min="1"
                           required>
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
                           id="kapasitas_max" 
                           name="kapasitas_max" 
                           value="{{ old('kapasitas_max', $armada->kapasitas_max) }}"
                           min="1"
                           required>
                    @error('kapasitas_max')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                      id="deskripsi" 
                      name="deskripsi" 
                      rows="4">{{ old('deskripsi', $armada->deskripsi) }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="urutan" class="form-label">
                Urutan Tampilan<span class="required-indicator">*</span>
            </label>
            <select class="form-select @error('urutan') is-invalid @enderror" 
                    id="urutan" 
                    name="urutan" 
                    required>
                @for($i = 1; $i <= $maxUrutan; $i++)
                    <option value="{{ $i }}" 
                            {{ old('urutan', $armada->urutan) == $i ? 'selected' : '' }}>
                        Urutan {{ $i }}
                        @if($i == $armada->urutan)
                            (Saat ini)
                        @else
                            @php
                                $armadaAtPosition = $allArmadas->where('urutan', $i)->first();
                            @endphp
                            @if($armadaAtPosition)
                                - {{ $armadaAtPosition->nama }}
                            @endif
                        @endif
                    </option>
                @endfor
            </select>
            @error('urutan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="urutan-info">
                <p class="urutan-info-text">
                    <i class="fas fa-info-circle"></i>
                    Ubah urutan untuk mengatur posisi armada di website. Armada lain akan otomatis disesuaikan.
                </p>
            </div>
        </div>
    </div>

    <!-- Gambar -->
    <div class="form-section">
        <h2 class="section-title">
            <i class="fas fa-images"></i>
            Gambar Armada
        </h2>

        <div class="form-group">
            <label for="gambar_utama" class="form-label">
                Gambar Utama
            </label>
            
            @if($armada->gambar_utama)
                <div class="image-preview-container">
                    <div class="current-image-wrapper">
                        <img src="{{ asset('storage/' . $armada->gambar_utama) }}" alt="Current">
                        <div class="image-label">Gambar Saat Ini</div>
                    </div>
                    <div class="preview-wrapper" id="preview-utama">
                        <div class="preview-placeholder">
                            <i class="fas fa-image"></i>
                            <p>Preview gambar baru</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="image-preview-container">
                    <div class="preview-wrapper" id="preview-utama">
                        <div class="preview-placeholder">
                            <i class="fas fa-image"></i>
                            <p>Preview gambar utama</p>
                        </div>
                    </div>
                </div>
            @endif

            <input type="file" 
                   class="form-control @error('gambar_utama') is-invalid @enderror" 
                   id="gambar_utama" 
                   name="gambar_utama"
                   accept="image/jpeg,image/jpg,image/png,image/webp"
                   onchange="previewImage(this, 'preview-utama')">
            @error('gambar_utama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Upload gambar baru untuk mengganti. Format: JPG, PNG, WebP. Maksimal 10MB.</small>
        </div>

        <div class="form-group">
            <label class="form-label">
                Galeri Gambar
            </label>
            
            @if($armada->galeri && count($armada->galeri) > 0)
                <div class="galeri-preview-container" id="current-galeri">
                    @foreach($armada->galeri as $index => $gambar)
                        <div class="galeri-preview-item" data-path="{{ $gambar }}">
                            <img src="{{ asset('storage/' . $gambar) }}" alt="Galeri {{ $index + 1 }}">
                            <button type="button" 
                                    class="btn-remove-galeri" 
                                    onclick="removeGaleri('{{ $gambar }}', this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif

            <input type="file" 
                   class="form-control @error('galeri.*') is-invalid @enderror" 
                   id="galeri" 
                   name="galeri[]"
                   accept="image/jpeg,image/jpg,image/png,image/webp"
                   multiple
                   onchange="previewNewGaleri(this)">
            @error('galeri.*')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Tambahkan gambar baru ke galeri. Format: JPG, PNG, WebP. Maksimal 10MB per file.</small>
            
            <div class="galeri-preview-container" id="new-galeri-preview"></div>
        </div>
    </div>

    <!-- Fasilitas -->
    <div class="form-section">
        <h2 class="section-title">
            <i class="fas fa-list-check"></i>
            Fasilitas Armada
        </h2>

        <div id="fasilitas-container" class="fasilitas-container">
            @if(old('fasilitas', $armada->fasilitas))
                @foreach(old('fasilitas', $armada->fasilitas) as $fasilitas)
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
                       {{ old('unggulan', $armada->unggulan) ? 'checked' : '' }}>
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
            Update Armada
        </button>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Array untuk menyimpan gambar yang akan dihapus
    let galeriToDelete = [];

    // Preview gambar utama
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Preview galeri baru
    function previewNewGaleri(input) {
        const container = document.getElementById('new-galeri-preview');
        container.innerHTML = '';
        
        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'galeri-preview-item';
                    wrapper.innerHTML = `
                        <img src="${e.target.result}" alt="New Galeri ${index + 1}">
                    `;
                    container.appendChild(wrapper);
                }
                
                reader.readAsDataURL(file);
            });
        }
    }

    // Hapus gambar galeri
    function removeGaleri(path, button) {
        Swal.fire({
            title: 'Hapus Gambar?',
            text: "Gambar akan dihapus dari galeri",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tambahkan ke array delete
                galeriToDelete.push(path);
                
                // Hapus dari tampilan
                button.closest('.galeri-preview-item').remove();
                
                // Update input hidden
                updateDeleteInput();
                
                Swal.fire({
                    title: 'Terhapus!',
                    text: 'Gambar akan dihapus saat form disimpan',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Update input hidden untuk galeri yang dihapus
    function updateDeleteInput() {
        // Hapus input hidden yang sudah ada
        document.querySelectorAll('input[name="hapus_galeri[]"]').forEach(el => el.remove());
        
        // Tambahkan input hidden baru
        const form = document.getElementById('formArmada');
        galeriToDelete.forEach(path => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'hapus_galeri[]';
            input.value = path;
            form.appendChild(input);
        });
    }

    // Tambah fasilitas
    function addFasilitas() {
        const container = document.getElementById('fasilitas-container');
        const newItem = document.createElement('div');
        newItem.className = 'fasilitas-item-input';
        newItem.innerHTML = `
            <input type="text" 
                   class="form-control" 
                   name="fasilitas[]" 
                   placeholder="Contoh: AC, Reclining Seat, TV, etc">
            <button type="button" class="btn-remove-fasilitas" onclick="removeFasilitas(this)">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(newItem);
    }

    // Hapus fasilitas
    function removeFasilitas(button) {
        const container = document.getElementById('fasilitas-container');
        if (container.children.length > 1) {
            button.parentElement.remove();
        } else {
            Swal.fire({
                title: 'Perhatian',
                text: 'Minimal harus ada 1 field fasilitas',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    }

    // Auto-generate slug dari nama
    document.getElementById('nama').addEventListener('input', function() {
        const slugInput = document.getElementById('slug');
        const slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        slugInput.value = slug;
    });

    // Form submission confirmation
    document.getElementById('formArmada').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Update Armada?',
            text: "Perubahan akan disimpan ke database",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                this.submit();
            }
        });
    });
</script>
@endsection