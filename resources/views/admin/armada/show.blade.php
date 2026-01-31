@extends('admin.layouts.app')

@section('title', 'Detail Armada - ' . $armada->nama)

@section('content')
<style>
    .detail-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
    }

    .section-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .section-title-text {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin: 0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .info-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--blue-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-value i {
        color: var(--orange-primary);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .badge-active {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(32, 201, 151, 0.15));
        color: #28a745;
        border: 2px solid #28a745;
    }

    .badge-inactive {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.15), rgba(200, 35, 51, 0.15));
        color: #dc3545;
        border: 2px solid #dc3545;
    }

    .badge-featured {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(255, 152, 0, 0.15));
        color: #ffc107;
        border: 2px solid #ffc107;
    }

    .main-image-container {
        width: 100%;
        height: 500px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        margin-bottom: 2rem;
        position: relative;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .main-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #6c757d;
    }

    .main-image-placeholder i {
        font-size: 5rem;
        color: #e9ecef;
        margin-bottom: 1rem;
    }

    .galeri-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }

    .galeri-item {
        position: relative;
        width: 100%;
        padding-top: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .galeri-item:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(251, 133, 0, 0.3);
    }

    .galeri-item img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .galeri-empty {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .galeri-empty i {
        font-size: 3rem;
        color: #e9ecef;
        margin-bottom: 1rem;
    }

    .fasilitas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }

    .fasilitas-card {
        padding: 1rem;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
    }

    .fasilitas-card:hover {
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.1), rgba(255, 183, 3, 0.1));
        transform: translateX(5px);
    }

    .fasilitas-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .fasilitas-name {
        font-weight: 600;
        color: var(--blue-dark);
        font-size: 0.95rem;
    }

    .deskripsi-box {
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid var(--orange-primary);
    }

    .deskripsi-text {
        color: #495057;
        line-height: 1.8;
        margin: 0;
        white-space: pre-wrap;
    }

    .deskripsi-empty {
        color: #6c757d;
        font-style: italic;
    }

    /* Lightbox for gallery */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .lightbox.active {
        display: flex;
    }

    .lightbox-content {
        max-width: 90%;
        max-height: 90%;
        position: relative;
    }

    .lightbox-image {
        max-width: 100%;
        max-height: 90vh;
        border-radius: 10px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.5);
    }

    .lightbox-close {
        position: absolute;
        top: -40px;
        right: 0;
        background: white;
        color: #333;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .lightbox-close:hover {
        background: var(--orange-primary);
        color: white;
        transform: rotate(90deg);
    }

    @media (max-width: 768px) {
        .main-image-container {
            height: 300px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .galeri-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }

        .fasilitas-grid {
            grid-template-columns: 1fr;
        }

        .detail-section {
            padding: 1.5rem;
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
            <i class="fas fa-bus"></i>
        </div>
        <div>
            <h1 class="header-title">{{ $armada->nama }}</h1>
            <p class="header-subtitle">Detail lengkap informasi armada</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.armada.edit', $armada) }}" class="btn-header-action btn-edit">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </a>
        <form action="{{ route('admin.armada.destroy', $armada) }}" 
              method="POST" 
              class="delete-form"
              style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-header-action btn-delete">
                <i class="fas fa-trash"></i>
                <span>Hapus</span>
            </button>
        </form>
    </div>
</div>

<!-- Main Image -->
<div class="main-image-container">
    @if($armada->gambar_utama)
        <img src="{{ asset('storage/' . $armada->gambar_utama) }}" 
             alt="{{ $armada->nama }}" 
             class="main-image">
    @else
        <div class="main-image-placeholder">
            <i class="fas fa-bus"></i>
            <p>Tidak ada gambar utama</p>
        </div>
    @endif
</div>

<!-- Informasi Dasar -->
<div class="detail-section">
    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-info-circle"></i>
        </div>
        <h2 class="section-title-text">Informasi Dasar</h2>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Nama Armada</span>
            <span class="info-value">
                <i class="fas fa-bus"></i>
                {{ $armada->nama }}
            </span>
        </div>

        <div class="info-item">
            <span class="info-label">Tipe Bus</span>
            <span class="info-value">
                <i class="fas fa-tag"></i>
                {{ $armada->tipe_bus }}
            </span>
        </div>

        <div class="info-item">
            <span class="info-label">Kapasitas</span>
            <span class="info-value">
                <i class="fas fa-users"></i>
                {{ $armada->kapasitas_min }} - {{ $armada->kapasitas_max }} Penumpang
            </span>
        </div>

        <div class="info-item">
            <span class="info-label">Urutan Tampilan</span>
            <span class="info-value">
                <i class="fas fa-sort-numeric-up"></i>
                Urutan ke-{{ $armada->urutan }}
            </span>
        </div>

        <div class="info-item">
            <span class="info-label">Status Ketersediaan</span>
            <span class="info-value">
                @if($armada->tersedia)
                    <span class="status-badge badge-active">
                        <i class="fas fa-check-circle"></i>
                        Tersedia
                    </span>
                @else
                    <span class="status-badge badge-inactive">
                        <i class="fas fa-times-circle"></i>
                        Tidak Tersedia
                    </span>
                @endif
            </span>
        </div>

        <div class="info-item">
            <span class="info-label">Status Unggulan</span>
            <span class="info-value">
                @if($armada->unggulan)
                    <span class="status-badge badge-featured">
                        <i class="fas fa-star"></i>
                        Armada Unggulan
                    </span>
                @else
                    <span class="status-badge badge-inactive">
                        <i class="fas fa-star"></i>
                        Bukan Unggulan
                    </span>
                @endif
            </span>
        </div>
    </div>
</div>

<!-- Deskripsi -->
<div class="detail-section">
    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-align-left"></i>
        </div>
        <h2 class="section-title-text">Deskripsi</h2>
    </div>

    <div class="deskripsi-box">
        @if($armada->deskripsi)
            <p class="deskripsi-text">{{ $armada->deskripsi }}</p>
        @else
            <p class="deskripsi-text deskripsi-empty">Tidak ada deskripsi</p>
        @endif
    </div>
</div>

<!-- Fasilitas -->
<div class="detail-section">
    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-list-check"></i>
        </div>
        <h2 class="section-title-text">Fasilitas</h2>
    </div>

    @if($armada->fasilitas && count($armada->fasilitas) > 0)
        <div class="fasilitas-grid">
            @foreach($armada->fasilitas as $fasilitas)
                <div class="fasilitas-card">
                    <div class="fasilitas-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="fasilitas-name">{{ $fasilitas }}</span>
                </div>
            @endforeach
        </div>
    @else
        <div class="galeri-empty">
            <i class="fas fa-list-check"></i>
            <p>Tidak ada fasilitas yang ditambahkan</p>
        </div>
    @endif
</div>

<!-- Galeri -->
<div class="detail-section">
    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-images"></i>
        </div>
        <h2 class="section-title-text">Galeri Foto</h2>
    </div>

    @if($armada->galeri && count($armada->galeri) > 0)
        <div class="galeri-grid">
            @foreach($armada->galeri as $index => $gambar)
                <div class="galeri-item" onclick="openLightbox('{{ asset('storage/' . $gambar) }}')">
                    <img src="{{ asset('storage/' . $gambar) }}" 
                         alt="Galeri {{ $armada->nama }} - {{ $index + 1 }}">
                </div>
            @endforeach
        </div>
    @else
        <div class="galeri-empty">
            <i class="fas fa-images"></i>
            <p>Tidak ada gambar di galeri</p>
        </div>
    @endif
</div>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <div class="lightbox-content" onclick="event.stopPropagation()">
        <button class="lightbox-close" onclick="closeLightbox()">
            <i class="fas fa-times"></i>
        </button>
        <img src="" alt="Preview" class="lightbox-image" id="lightbox-image">
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Lightbox functions
    function openLightbox(imageSrc) {
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        lightboxImage.src = imageSrc;
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Close lightbox with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });

    // Handle delete confirmation
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.querySelector('.delete-form');
        
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data armada '{{ $armada->nama }}' akan dihapus permanen beserta semua gambarnya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Menghapus...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        deleteForm.submit();
                    }
                });
            });
        }
    });
</script>
@endsection