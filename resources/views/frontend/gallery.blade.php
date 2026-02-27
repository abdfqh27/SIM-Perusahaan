@extends('frontend.layouts.app')

@section('title', 'Galeri Perusahaan')

@push('styles')
    <style>
    /* Gallery Page Specific Styles */
    
    /* Hero Section - menggunakan styling umum dari CSS global */
    /* .gallery-hero {
        min-height: 450px;
    } */
    
    /* Filter Section */
    .filter-section {
        padding: 40px 0;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }
    
    .filter-wrapper {
        display: flex;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .filter-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: var(--blue-dark);
        font-size: 1rem;
    }
    
    .filter-label i {
        color: var(--orange-primary);
    }
    
    .filter-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        color: #555;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
    }
    
    .filter-btn:hover {
        background: var(--orange-primary);
        color: white;
        border-color: var(--orange-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.3);
    }
    
    .filter-btn.active {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        border-color: var(--orange-primary);
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.4);
    }
    
    .filter-btn i {
        font-size: 0.85rem;
    }
    
    /* Gallery Section */
    .gallery-section {
        padding: 80px 0;
    }
    
    /* Empty State */
    .empty-gallery {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        border-radius: 50%;
        font-size: 3rem;
        color: #adb5bd;
    }
    
    .empty-gallery h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
    }
    
    .empty-gallery p {
        font-size: 1rem;
        color: #666;
        margin-bottom: 2rem;
    }
    
    .btn-back-gallery {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 2rem;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.3);
    }
    
    .btn-back-gallery:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 133, 0, 0.4);
        color: white;
    }
    
    /* Masonry Gallery Grid */
    .masonry-gallery {
        column-count: 3;
        column-gap: 2rem;
    }
    
    .gallery-item {
        break-inside: avoid;
        margin-bottom: 2rem;
    }
    
    /* Gallery Card */
    .gallery-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }
    
    /* Image Container */
    .image-container {
        position: relative;
        overflow: hidden;
        background: #f8f9fa;
    }
    
    .image-container img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s ease;
    }
    
    .gallery-card:hover .image-container img {
        transform: scale(1.05);
    }
    
    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(2, 48, 71, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .gallery-card:hover .image-overlay {
        opacity: 1;
    }
    
    .btn-zoom {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: white;
        border: none;
        color: var(--blue-dark);
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-zoom:hover {
        background: var(--orange-primary);
        color: white;
        transform: scale(1.1);
    }
    
    .category-tag {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.4);
    }
    
    /* Gallery Info */
    .gallery-info {
        padding: 1.5rem;
    }
    
    .gallery-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    
    .gallery-description {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.6;
        margin: 0;
    }
    
    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    
    .lightbox-close,
    .lightbox-prev,
    .lightbox-next {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.2);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.25rem;
    }
    
    .lightbox-close:hover,
    .lightbox-prev:hover,
    .lightbox-next:hover {
        background: var(--orange-primary);
        border-color: var(--orange-primary);
        transform: scale(1.1);
    }
    
    .lightbox-close {
        top: 2rem;
        right: 2rem;
    }
    
    .lightbox-prev {
        left: 2rem;
        top: 50%;
        transform: translateY(-50%);
    }
    
    .lightbox-prev:hover {
        transform: translateY(-50%) scale(1.1);
    }
    
    .lightbox-next {
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
    }
    
    .lightbox-next:hover {
        transform: translateY(-50%) scale(1.1);
    }
    
    .lightbox-content {
        max-width: 1200px;
        width: 100%;
        display: flex;
        gap: 2rem;
        align-items: center;
    }
    
    .lightbox-image-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .lightbox-image-wrapper img {
        max-width: 100%;
        max-height: 80vh;
        border-radius: 10px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }
    
    .lightbox-info {
        width: 300px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        padding: 2rem;
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .lightbox-info h3 {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .lightbox-info p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .lightbox-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .lightbox-meta span {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.85rem;
    }
    
    .image-counter {
        background: var(--orange-primary);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-weight: 600;
    }
    
    /* Responsive Design */
    @media (max-width: 1200px) {
        .masonry-gallery {
            column-count: 2;
        }
        
        .lightbox-content {
            flex-direction: column;
        }
        
        .lightbox-info {
            width: 100%;
            max-width: 600px;
        }
    }
    
    @media (max-width: 768px) {
        .gallery-section {
            padding: 60px 0;
        }
        
        .filter-wrapper {
            flex-direction: column;
            gap: 1rem;
        }
        
        .filter-buttons {
            width: 100%;
        }
        
        .filter-btn {
            flex: 1;
            justify-content: center;
            min-width: 120px;
        }
        
        .masonry-gallery {
            column-count: 1;
            column-gap: 0;
        }
        
        .gallery-item {
            margin-bottom: 1.5rem;
        }
        
        .lightbox-prev,
        .lightbox-next {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        
        .lightbox-prev {
            left: 1rem;
        }
        
        .lightbox-next {
            right: 1rem;
        }
        
        .lightbox-close {
            top: 1rem;
            right: 1rem;
        }
        
        .lightbox {
            padding: 1rem;
        }
        
        .lightbox-image-wrapper img {
            max-height: 60vh;
        }
    }
    
    @media (max-width: 576px) {
        .filter-section {
            padding: 30px 0;
        }
        
        .filter-btn {
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }
        
        .btn-zoom {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
    }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container">
            <div class="hero-text" data-aos="fade-up">
                <h1 class="hero-title">Galeri Kami</h1>
                <p class="hero-subtitle">Dokumentasi perjalanan dan pencapaian perusahaan</p>
                <div class="hero-divider"></div>
                <div class="hero-breadcrumb" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                    <span><i class="fas fa-chevron-right"></i></span>
                    <span>Galeri</span>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
    <div class="hero-decoration">
        <div class="decoration-circle circle-1"></div>
        <div class="decoration-circle circle-2"></div>
        <div class="decoration-circle circle-3"></div>
    </div>
</section>

<!-- Filter Section -->
@if($kategoris->isNotEmpty())
<section class="filter-section">
    <div class="container">
        <div class="filter-wrapper" data-aos="fade-up">
            <div class="filter-label">
                <i class="fas fa-filter"></i>
                Filter Kategori:
            </div>
            <div class="filter-buttons">
                <a href="{{ route('galeri') }}" 
                   class="filter-btn {{ !$kategori ? 'active' : '' }}">
                    <i class="fas fa-th"></i>
                    Semua
                </a>
                @foreach($kategoris as $kat)
                @if($kat)
                <a href="{{ route('galeri', ['kategori' => $kat]) }}" 
                   class="filter-btn {{ $kategori == $kat ? 'active' : '' }}">
                    <i class="fas fa-tag"></i>
                    {{ $kat }}
                </a>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Gallery Section -->
<section class="gallery-section">
    <div class="container">
        @if($galleries->isEmpty())
        <!-- Empty State -->
        <div class="empty-gallery" data-aos="fade-up">
            <div class="empty-icon">
                <i class="fas fa-images"></i>
            </div>
            <h3>Belum Ada Foto</h3>
            <p>{{ $kategori ? "Tidak ada foto dalam kategori '$kategori'" : 'Galeri akan segera diperbarui' }}</p>
            @if($kategori)
            <a href="{{ route('galeri') }}" class="btn-back-gallery">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Semua Galeri
            </a>
            @endif
        </div>
        @else
        <!-- Gallery Grid -->
        <div class="masonry-gallery">
            @foreach($galleries as $index => $gallery)
            <div class="gallery-item" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                <div class="gallery-card">
                    <div class="image-container">
                        <img src="{{ asset('storage/' . $gallery->gambar) }}" 
                             alt="{{ $gallery->judul }}"
                             loading="lazy">
                        <div class="image-overlay">
                            <button class="btn-zoom" onclick="openLightbox({{ $index }})">
                                <i class="fas fa-search-plus"></i>
                            </button>
                            @if($gallery->kategori)
                            <span class="category-tag">
                                <i class="fas fa-tag"></i>
                                {{ $gallery->kategori }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="gallery-info">
                        <h3 class="gallery-title">{{ $gallery->judul }}</h3>
                        @if($gallery->deskripsi)
                        <p class="gallery-description">{{ Str::limit($gallery->deskripsi, 100) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <div class="cta-icon">
                <i class="fas fa-camera"></i>
            </div>
            <h2 class="cta-title">Ingin Melihat Lebih Banyak?</h2>
            <p class="cta-text">Kunjungi kantor kami atau hubungi untuk informasi lebih lanjut tentang layanan kami</p>
            <div class="cta-buttons">
                <a href="{{ route('kontak') }}" class="btn-cta-primary">
                    <i class="fas fa-phone-alt"></i>
                    <span>Hubungi Kami</span>
                </a>
                <a href="{{ route('armada') }}" class="btn-cta-secondary">
                    <i class="fas fa-bus"></i>
                    <span>Lihat Armada</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
@if($galleries->isNotEmpty())
<div id="lightbox" class="lightbox">
    <button class="lightbox-close" onclick="closeLightbox()">
        <i class="fas fa-times"></i>
    </button>
    <button class="lightbox-prev" onclick="changeImage(-1)">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="lightbox-next" onclick="changeImage(1)">
        <i class="fas fa-chevron-right"></i>
    </button>
    
    <div class="lightbox-content">
        <div class="lightbox-image-wrapper">
            <img id="lightboxImage" src="" alt="">
        </div>
        <div class="lightbox-info">
            <h3 id="lightboxTitle"></h3>
            <p id="lightboxDescription"></p>
            <div class="lightbox-meta">
                <span id="lightboxCategory"></span>
                <span class="image-counter">
                    <span id="currentImage"></span> / <span id="totalImages">{{ $galleries->count() }}</span>
                </span>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
// Gallery data for lightbox
const galleryData = [
    @foreach($galleries as $gallery)
    {
        image: "{{ asset('storage/' . $gallery->gambar) }}",
        title: "{{ $gallery->judul }}",
        description: "{{ $gallery->deskripsi }}",
        category: "{{ $gallery->kategori }}"
    },
    @endforeach
];

let currentImageIndex = 0;

// Open lightbox
function openLightbox(index) {
    currentImageIndex = index;
    updateLightboxContent();
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Close lightbox
function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Change image
function changeImage(direction) {
    currentImageIndex += direction;
    
    if (currentImageIndex < 0) {
        currentImageIndex = galleryData.length - 1;
    } else if (currentImageIndex >= galleryData.length) {
        currentImageIndex = 0;
    }
    
    updateLightboxContent();
}

// Update lightbox content
function updateLightboxContent() {
    const data = galleryData[currentImageIndex];
    document.getElementById('lightboxImage').src = data.image;
    document.getElementById('lightboxTitle').textContent = data.title;
    document.getElementById('lightboxDescription').textContent = data.description;
    document.getElementById('lightboxCategory').textContent = data.category ? data.category : '';
    document.getElementById('currentImage').textContent = currentImageIndex + 1;
    
    // Add animation
    const img = document.getElementById('lightboxImage');
    img.style.opacity = '0';
    img.style.transform = 'scale(0.9)';
    
    setTimeout(() => {
        img.style.transition = 'all 0.3s ease';
        img.style.opacity = '1';
        img.style.transform = 'scale(1)';
    }, 50);
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightbox');
    if (lightbox && lightbox.style.display === 'flex') {
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowLeft') {
            changeImage(-1);
        } else if (e.key === 'ArrowRight') {
            changeImage(1);
        }
    }
});

// Close on outside click
const lightboxElement = document.getElementById('lightbox');
if (lightboxElement) {
    lightboxElement.addEventListener('click', function(e) {
        if (e.target === this) {
            closeLightbox();
        }
    });
}

// AOS Animation
AOS.init({
    duration: 1000,
    once: true,
    offset: 100,
    easing: 'ease-in-out'
});

// Lazy loading images
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img[loading="lazy"]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.src;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    }
});
</script>
@endpush