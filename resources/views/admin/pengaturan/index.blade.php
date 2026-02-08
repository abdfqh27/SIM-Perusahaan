@extends('admin.layouts.app')

@section('title', 'Pengaturan Perusahaan')

@section('content')
<style>
    /* Image Upload Section */
    .upload-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .upload-section:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .preview-container {
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
    }
    
    .preview-image {
        max-width: 100%;
        height: auto;
        object-fit: contain;
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 12px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .preview-image:hover {
        border-color: var(--orange-primary);
        transform: scale(1.02);
    }
    
    .logo-preview {
        max-width: 250px;
        max-height: 250px;
    }

    .favicon-preview {
        max-width: 80px;
        max-height: 80px;
    }
    
    .remove-image {
        position: absolute;
        top: -10px;
        right: -10px;
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        border: none;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.4);
    }
    
    .remove-image:hover {
        background: linear-gradient(135deg, #c82333, #bd2130);
        transform: scale(1.15) rotate(90deg);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.6);
    }
    
    /* Custom File Input */
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }
    
    .file-input-wrapper input[type=file] {
        position: absolute;
        left: -9999px;
    }
    
    .file-input-label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding: 0.85rem 2rem;
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        width: 100%;
        box-shadow: 0 4px 12px rgba(33, 158, 188, 0.3);
    }
    
    .file-input-label:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(33, 158, 188, 0.5);
        background: linear-gradient(135deg, var(--blue-lighter), var(--blue-light));
    }

    .file-input-label:active {
        transform: translateY(0);
    }

    .file-input-label i {
        font-size: 1.2rem;
    }
    
    .file-name {
        margin-top: 0.75rem;
        padding: 0.5rem 0.75rem;
        background: rgba(33, 158, 188, 0.1);
        border-radius: 8px;
        font-size: 0.85rem;
        color: var(--blue-dark);
        font-weight: 500;
        font-style: normal;
        display: none;
    }

    .file-name.active {
        display: block;
    }

    .file-name i {
        color: var(--blue-light);
        margin-right: 0.5rem;
    }

    /* Section Headers */
    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid transparent;
        border-image: linear-gradient(90deg, var(--orange-primary), transparent) 1;
    }

    .section-header h5 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-header i {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        box-shadow: 0 4px 12px rgba(251, 133, 0, 0.3);
    }

    /* Form Sections */
    .form-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .form-section:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    /* Enhanced Form Controls */
    .form-label {
        font-weight: 600;
        color: var(--blue-dark);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: var(--orange-primary);
    }

    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.85rem 1.25rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--orange-primary);
        box-shadow: 0 0 0 0.25rem rgba(251, 133, 0, 0.15);
        outline: none;
        transform: translateY(-1px);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Social Media Icons */
    .social-icon {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin-right: 0.5rem;
    }

    .social-icon.facebook {
        background: linear-gradient(135deg, #1877f2, #0d65d9);
        color: white;
    }

    .social-icon.instagram {
        background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
        color: white;
    }

    .social-icon.twitter {
        background: linear-gradient(135deg, #1da1f2, #0c85d0);
        color: white;
    }

    .social-icon.youtube {
        background: linear-gradient(135deg, #ff0000, #cc0000);
        color: white;
    }

    /* Help Text */
    .help-text {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #6c757d;
        padding: 0.5rem 0.75rem;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 3px solid var(--blue-light);
    }

    .help-text i {
        color: var(--blue-light);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        padding-top: 2rem;
        margin-top: 2rem;
        border-top: 2px solid #e9ecef;
    }

    /* Character Counter */
    .char-counter {
        font-size: 0.8rem;
        color: #6c757d;
        text-align: right;
        margin-top: 0.25rem;
    }

    .char-counter.warning {
        color: #ff9800;
    }

    .char-counter.danger {
        color: #dc3545;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-section {
            padding: 1.5rem;
        }

        .section-header h5 {
            font-size: 1.1rem;
        }

        .section-header i {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
        }

        .upload-section {
            padding: 1.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn-primary,
        .action-buttons .btn-secondary {
            width: 100%;
        }
    }

    /* Upload Area Enhancement */
    .upload-area {
        text-align: center;
        padding: 1.5rem;
    }

    .upload-placeholder {
        width: 100%;
        max-width: 200px;
        height: 150px;
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .upload-placeholder:hover {
        border-color: var(--orange-primary);
        background: rgba(251, 133, 0, 0.05);
    }

    .upload-placeholder i {
        font-size: 3rem;
        color: #dee2e6;
        margin-bottom: 0.5rem;
    }

    .upload-placeholder:hover i {
        color: var(--orange-primary);
    }

    .upload-placeholder p {
        margin: 0;
        color: #6c757d;
        font-size: 0.85rem;
    }
</style>

<!-- Gradient Header -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-cog"></i>
        </div>
        <div>
            <h1 class="header-title">Pengaturan Perusahaan</h1>
            <p class="header-subtitle">Kelola informasi dan konfigurasi perusahaan Anda dengan mudah</p>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle me-2"></i>
    {{ session('error') }}
</div>
@endif

<!-- Form Pengaturan -->
<form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data" id="formPengaturan">
    @csrf
    @method('PUT')

    <!-- Informasi Perusahaan -->
    <div class="form-section">
        <div class="section-header">
            <h5>
                <i class="fas fa-building"></i>
                Informasi Perusahaan
            </h5>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nama_perusahaan" class="form-label">
                    <i class="fas fa-building"></i>
                    Nama Perusahaan
                </label>
                <input type="text" 
                       class="form-control @error('nama_perusahaan') is-invalid @enderror" 
                       id="nama_perusahaan" 
                       name="nama_perusahaan" 
                       value="{{ old('nama_perusahaan', $pengaturan->nama_perusahaan) }}"
                       placeholder="Contoh: PT. Maju Bersama Sejahtera">
                @error('nama_perusahaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="tagline" class="form-label">
                    <i class="fas fa-tag"></i>
                    Tagline Perusahaan
                </label>
                <input type="text" 
                       class="form-control @error('tagline') is-invalid @enderror" 
                       id="tagline" 
                       name="tagline" 
                       value="{{ old('tagline', $pengaturan->tagline) }}"
                       placeholder="Contoh: Solusi Transportasi Terpercaya">
                @error('tagline')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">
                <i class="fas fa-align-left"></i>
                Deskripsi Perusahaan
            </label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                      id="deskripsi" 
                      name="deskripsi" 
                      rows="4"
                      maxlength="500"
                      placeholder="Tuliskan deskripsi singkat tentang perusahaan Anda...">{{ old('deskripsi', $pengaturan->deskripsi) }}</textarea>
            <div class="char-counter">
                <span id="descCharCount">0</span>/500 karakter
            </div>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Kontak Informasi -->
    <div class="form-section">
        <div class="section-header">
            <h5>
                <i class="fas fa-address-book"></i>
                Informasi Kontak
            </h5>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">
                <i class="fas fa-map-marker-alt"></i>
                Alamat Lengkap
            </label>
            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                      id="alamat" 
                      name="alamat" 
                      rows="3"
                      placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota, Provinsi 12345">{{ old('alamat', $pengaturan->alamat) }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="telepon" class="form-label">
                    <i class="fas fa-phone"></i>
                    Telepon
                </label>
                <input type="text" 
                       class="form-control @error('telepon') is-invalid @enderror" 
                       id="telepon" 
                       name="telepon" 
                       value="{{ old('telepon', $pengaturan->telepon) }}"
                       placeholder="(021) 12345678">
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    <span>Format: (kode area) nomor</span>
                </div>
                @error('telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="whatsapp" class="form-label">
                    <i class="fab fa-whatsapp"></i>
                    WhatsApp
                </label>
                <input type="text" 
                       class="form-control @error('whatsapp') is-invalid @enderror" 
                       id="whatsapp" 
                       name="whatsapp" 
                       value="{{ old('whatsapp', $pengaturan->whatsapp) }}"
                       placeholder="628123456789">
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    <span>Format: 628xxxxxxxxx</span>
                </div>
                @error('whatsapp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i>
                    Email
                </label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $pengaturan->email) }}"
                       placeholder="info@perusahaan.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Social Media -->
    <div class="form-section">
        <div class="section-header">
            <h5>
                <i class="fas fa-share-alt"></i>
                Media Sosial
            </h5>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label for="facebook" class="form-label">
                    <span class="social-icon facebook">
                        <i class="fab fa-facebook-f"></i>
                    </span>
                    Facebook
                </label>
                <input type="url" 
                       class="form-control @error('facebook') is-invalid @enderror" 
                       id="facebook" 
                       name="facebook" 
                       value="{{ old('facebook', $pengaturan->facebook) }}"
                       placeholder="https://facebook.com/username">
                @error('facebook')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="instagram" class="form-label">
                    <span class="social-icon instagram">
                        <i class="fab fa-instagram"></i>
                    </span>
                    Instagram
                </label>
                <input type="url" 
                       class="form-control @error('instagram') is-invalid @enderror" 
                       id="instagram" 
                       name="instagram" 
                       value="{{ old('instagram', $pengaturan->instagram) }}"
                       placeholder="https://instagram.com/username">
                @error('instagram')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label for="twitter" class="form-label">
                    <span class="social-icon twitter">
                        <i class="fab fa-twitter"></i>
                    </span>
                    Twitter / X
                </label>
                <input type="url" 
                       class="form-control @error('twitter') is-invalid @enderror" 
                       id="twitter" 
                       name="twitter" 
                       value="{{ old('twitter', $pengaturan->twitter) }}"
                       placeholder="https://twitter.com/username">
                @error('twitter')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="youtube" class="form-label">
                    <span class="social-icon youtube">
                        <i class="fab fa-youtube"></i>
                    </span>
                    YouTube
                </label>
                <input type="url" 
                       class="form-control @error('youtube') is-invalid @enderror" 
                       id="youtube" 
                       name="youtube" 
                       value="{{ old('youtube', $pengaturan->youtube) }}"
                       placeholder="https://youtube.com/@channel">
                @error('youtube')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- SEO Settings -->
    <div class="form-section">
        <div class="section-header">
            <h5>
                <i class="fas fa-search"></i>
                Pengaturan SEO
            </h5>
        </div>

        <div class="mb-3">
            <label for="meta_title" class="form-label">
                <i class="fas fa-heading"></i>
                Meta Title
            </label>
            <input type="text" 
                   class="form-control @error('meta_title') is-invalid @enderror" 
                   id="meta_title" 
                   name="meta_title" 
                   value="{{ old('meta_title', $pengaturan->meta_title) }}"
                   maxlength="60"
                   placeholder="Judul website untuk mesin pencari">
            <div class="char-counter">
                <span id="titleCharCount">0</span>/60 karakter
            </div>
            <div class="help-text">
                <i class="fas fa-lightbulb"></i>
                <span>Judul ini akan muncul di hasil pencarian Google</span>
            </div>
            @error('meta_title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="meta_description" class="form-label">
                <i class="fas fa-file-alt"></i>
                Meta Description
            </label>
            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                      id="meta_description" 
                      name="meta_description" 
                      rows="3"
                      maxlength="160"
                      placeholder="Deskripsi singkat website untuk mesin pencari">{{ old('meta_description', $pengaturan->meta_description) }}</textarea>
            <div class="char-counter">
                <span id="metaCharCount">0</span>/160 karakter
            </div>
            <div class="help-text">
                <i class="fas fa-lightbulb"></i>
                <span>Deskripsi ini akan muncul di bawah judul di hasil pencarian</span>
            </div>
            @error('meta_description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="meta_keywords" class="form-label">
                <i class="fas fa-tags"></i>
                Meta Keywords
            </label>
            <input type="text" 
                   class="form-control @error('meta_keywords') is-invalid @enderror" 
                   id="meta_keywords" 
                   name="meta_keywords" 
                   value="{{ old('meta_keywords', $pengaturan->meta_keywords) }}"
                   placeholder="travel, bus, pariwisata, sewa bus, rental mobil">
            <div class="help-text">
                <i class="fas fa-info-circle"></i>
                <span>Pisahkan setiap kata kunci dengan koma (,)</span>
            </div>
            @error('meta_keywords')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Logo & Favicon -->
    <div class="form-section">
        <div class="section-header">
            <h5>
                <i class="fas fa-image"></i>
                Logo & Favicon
            </h5>
        </div>

        <div class="row">
            <!-- Logo -->
            <div class="col-md-6 mb-4">
                <div class="upload-section">
                    <h6 class="text-primary mb-3 fw-bold">
                        <i class="fas fa-image me-2"></i>Logo Perusahaan
                    </h6>
                    
                    <div class="upload-area">
                        @if($pengaturan->logo)
                        <div class="preview-container" id="logoPreviewContainer">
                            <img src="{{ asset('storage/' . $pengaturan->logo) }}" 
                                 alt="Logo" 
                                 class="preview-image logo-preview img-thumbnail"
                                 id="logoPreview">
                        </div>
                        @else
                        <div class="upload-placeholder" id="logoPlaceholder">
                            <i class="fas fa-image"></i>
                            <p>Belum ada logo</p>
                        </div>
                        @endif

                        <div class="file-input-wrapper mt-3">
                            <input type="file" 
                                   name="logo" 
                                   id="logo" 
                                   accept="image/jpeg,image/jpg,image/png,image/gif,image/svg+xml"
                                   class="@error('logo') is-invalid @enderror">
                            <label for="logo" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Pilih Logo Baru</span>
                            </label>
                        </div>
                        <div id="logoFileName" class="file-name"></div>
                        
                        <div class="help-text mt-3">
                            <i class="fas fa-info-circle"></i>
                            <span>Format: JPG, PNG, GIF, SVG | Maksimal: 2MB</span>
                        </div>
                        
                        @error('logo')
                            <div class="text-danger mt-2">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Favicon -->
            <div class="col-md-6 mb-4">
                <div class="upload-section">
                    <h6 class="text-primary mb-3 fw-bold">
                        <i class="fas fa-star me-2"></i>Favicon
                    </h6>
                    
                    <div class="upload-area">
                        @if($pengaturan->favicon)
                        <div class="preview-container" id="faviconPreviewContainer">
                            <img src="{{ asset('storage/' . $pengaturan->favicon) }}" 
                                 alt="Favicon" 
                                 class="preview-image favicon-preview img-thumbnail"
                                 id="faviconPreview">
                        </div>
                        @else
                        <div class="upload-placeholder" id="faviconPlaceholder" style="max-width: 100px; height: 100px;">
                            <i class="fas fa-star"></i>
                            <p>Belum ada favicon</p>
                        </div>
                        @endif

                        <div class="file-input-wrapper mt-3">
                            <input type="file" 
                                   name="favicon" 
                                   id="favicon" 
                                   accept="image/x-icon,image/png"
                                   class="@error('favicon') is-invalid @enderror">
                            <label for="favicon" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Pilih Favicon Baru</span>
                            </label>
                        </div>
                        <div id="faviconFileName" class="file-name"></div>
                        
                        <div class="help-text mt-3">
                            <i class="fas fa-info-circle"></i>
                            <span>Format: ICO, PNG | Maksimal: 1MB</span>
                        </div>
                        
                        @error('favicon')
                            <div class="text-danger mt-2">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="form-section">
        <div class="action-buttons">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                <span>Simpan Pengaturan</span>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character Counter Functions
    function updateCharCounter(inputId, counterId, maxLength) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        
        if (input && counter) {
            const updateCount = () => {
                const length = input.value.length;
                counter.textContent = length;
                
                // Update color based on length
                const parent = counter.parentElement;
                parent.classList.remove('warning', 'danger');
                
                if (length > maxLength * 0.9) {
                    parent.classList.add('danger');
                } else if (length > maxLength * 0.75) {
                    parent.classList.add('warning');
                }
            };
            
            input.addEventListener('input', updateCount);
            updateCount(); // Initial count
        }
    }
    
    // Initialize character counters
    updateCharCounter('deskripsi', 'descCharCount', 500);
    updateCharCounter('meta_title', 'titleCharCount', 60);
    updateCharCounter('meta_description', 'metaCharCount', 160);
    
    // Logo Upload Handler
    const logoInput = document.getElementById('logo');
    const logoFileName = document.getElementById('logoFileName');
    const logoPreview = document.getElementById('logoPreview');
    const logoPlaceholder = document.getElementById('logoPlaceholder');
    const logoPreviewContainer = document.getElementById('logoPreviewContainer');
    
    if (logoInput) {
        logoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Show filename
                logoFileName.innerHTML = `<i class="fas fa-file-image"></i> ${file.name}`;
                logoFileName.classList.add('active');
                
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal adalah 2MB'
                    });
                    logoInput.value = '';
                    logoFileName.classList.remove('active');
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (logoPlaceholder) {
                        logoPlaceholder.style.display = 'none';
                    }
                    
                    if (logoPreview) {
                        logoPreview.src = e.target.result;
                        if (logoPreviewContainer) {
                            logoPreviewContainer.style.display = 'inline-block';
                        }
                    } else {
                        // Create new preview
                        const container = document.createElement('div');
                        container.className = 'preview-container';
                        container.id = 'logoPreviewContainer';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'preview-image logo-preview img-thumbnail';
                        img.id = 'logoPreview';
                        
                        container.appendChild(img);
                        
                        const uploadArea = logoInput.closest('.upload-area');
                        uploadArea.insertBefore(container, uploadArea.firstChild);
                    }
                };
                reader.readAsDataURL(file);
            } else {
                logoFileName.classList.remove('active');
            }
        });
    }
    
    // Favicon Upload Handler
    const faviconInput = document.getElementById('favicon');
    const faviconFileName = document.getElementById('faviconFileName');
    const faviconPreview = document.getElementById('faviconPreview');
    const faviconPlaceholder = document.getElementById('faviconPlaceholder');
    const faviconPreviewContainer = document.getElementById('faviconPreviewContainer');
    
    if (faviconInput) {
        faviconInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Show filename
                faviconFileName.innerHTML = `<i class="fas fa-file-image"></i> ${file.name}`;
                faviconFileName.classList.add('active');
                
                // Validate file size (1MB)
                if (file.size > 1 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal adalah 1MB'
                    });
                    faviconInput.value = '';
                    faviconFileName.classList.remove('active');
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (faviconPlaceholder) {
                        faviconPlaceholder.style.display = 'none';
                    }
                    
                    if (faviconPreview) {
                        faviconPreview.src = e.target.result;
                        if (faviconPreviewContainer) {
                            faviconPreviewContainer.style.display = 'inline-block';
                        }
                    } else {
                        // Create new preview
                        const container = document.createElement('div');
                        container.className = 'preview-container';
                        container.id = 'faviconPreviewContainer';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'preview-image favicon-preview img-thumbnail';
                        img.id = 'faviconPreview';
                        
                        container.appendChild(img);
                        
                        const uploadArea = faviconInput.closest('.upload-area');
                        uploadArea.insertBefore(container, uploadArea.firstChild);
                    }
                };
                reader.readAsDataURL(file);
            } else {
                faviconFileName.classList.remove('active');
            }
        });
    }
    
    // Form Submission Confirmation
    const form = document.getElementById('formPengaturan');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Penyimpanan',
                text: 'Apakah Anda yakin ingin menyimpan perubahan pengaturan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check"></i> Ya, Simpan',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    form.submit();
                }
            });
        });
    }
});
</script>
@endpush
@endsection