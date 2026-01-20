@extends('frontend.layouts.app')

@section('title', 'Layanan Kami')

@push('styles')
<style>
    .layanan-filter {
        padding: 2rem 0;
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    
    .filter-container {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 2rem;
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 50px;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .filter-btn:hover,
    .filter-btn.active {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        border-color: var(--orange-primary);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 133, 0, 0.3);
    }
    
    .filter-btn i {
        font-size: 1rem;
    }
    
    /* layanan Section */
    .layanan-section {
        padding: 80px 0;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .section-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.3);
    }
    
    .section-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
    }
    
    .section-header p {
        font-size: 1.1rem;
        color: #666;
    }
    
    /* layanan Grid */
    .layanan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    
    .featured-grid {
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    }
    
    /* layanan Card */
    .layanan-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
    }
    
    .layanan-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(251, 133, 0, 0.2);
    }
    
    .layanan-card.featured {
        border: 2px solid var(--orange-primary);
    }
    
    /* layanan Badge */
    .layanan-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.4);
    }
    
    .layanan-badge i {
        font-size: 0.9rem;
    }
    
    /* layanan Image */
    .layanan-image {
        position: relative;
        height: 250px;
        overflow: hidden;
    }
    
    .layanan-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .layanan-card:hover .layanan-image img {
        transform: scale(1.1);
    }
    
    .no-image {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #adb5bd;
    }
    
    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, transparent 0%, rgba(2, 48, 71, 0.7) 100%);
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .layanan-card:hover .image-overlay {
        opacity: 1;
    }
    
    .view-btn {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        text-decoration: none;
        transition: all 0.3s ease;
        transform: translateY(20px);
    }
    
    .layanan-card:hover .view-btn {
        transform: translateY(0);
    }
    
    .view-btn:hover {
        transform: scale(1.1) rotate(45deg);
        box-shadow: 0 5px 20px rgba(251, 133, 0, 0.5);
    }
    
    /* layanan Content */
    .layanan-content {
        padding: 2rem;
    }
    
    .layanan-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-bottom: 1rem;
        box-shadow: 0 6px 20px rgba(251, 133, 0, 0.3);
    }
    
    .layanan-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .layanan-title a {
        color: var(--blue-dark);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .layanan-title a:hover {
        color: var(--orange-primary);
    }
    
    .layanan-description {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    /* layanan Meta */
    .layanan-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-top: 1px solid #e9ecef;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 1.5rem;
    }
    
    .layanan-price,
    .layanan-fasilitas-count {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: #666;
    }
    
    .layanan-price i,
    .layanan-fasilitas-count i {
        color: var(--orange-primary);
        font-size: 1rem;
    }
    
    .layanan-price span {
        font-weight: 600;
        color: var(--orange-primary);
    }
    
    /* layanan Link */
    .layanan-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--orange-primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    
    .layanan-link:hover {
        gap: 1rem;
        color: var(--orange-secondary);
    }
    
    .layanan-link i {
        transition: transform 0.3s ease;
    }
    
    .layanan-link:hover i {
        transform: translateX(5px);
    }
    
    /* Empty State */
    .empty-layanan {
        text-align: center;
        padding: 4rem 2rem;
        background: #f8f9fa;
        border-radius: 20px;
    }
    
    .empty-layanan i {
        font-size: 5rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }
    
    .empty-layanan h3 {
        font-size: 1.5rem;
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
    }
    
    .empty-layanan p {
        color: #666;
        font-size: 1rem;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .layanan-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
        
        .featured-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }
    
    @media (max-width: 768px) {
        .layanan-section {
            padding: 60px 0;
        }
        
        .section-header h2 {
            font-size: 2rem;
        }
        
        .layanan-grid,
        .featured-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .layanan-image {
            height: 200px;
        }
        
        .filter-container {
            flex-direction: column;
        }
        
        .filter-btn {
            width: 100%;
            justify-content: center;
        }
    }
    
    @media (max-width: 576px) {
        .layanan-content {
            padding: 1.5rem;
        }
        
        .layanan-meta {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }
    }
    </style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title" data-aos="fade-up">Layanan Kami</h1>
            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">
                Temukan berbagai layanan terbaik yang kami tawarkan untuk kenyamanan Anda
            </p>
            <div class="hero-divider"></div>
            <div class="hero-breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ url('/') }}"><i class="fas fa-home"></i> Beranda</a>
                <span><i class="fas fa-chevron-right"></i></span>
                <span>Layanan</span>
            </div>
        </div>
    </div>
    <div class="hero-decoration">
        <div class="decoration-circle circle-1"></div>
        <div class="decoration-circle circle-2"></div>
        <div class="decoration-circle circle-3"></div>
    </div>
</section>

<section class="layanan-filter">
    <div class="container">
        <div class="filter-container" data-aos="fade-up">
            <button class="filter-btn active" data-filter="all">
                <i class="fas fa-th"></i>
                <span>Semua Layanan</span>
            </button>
            <button class="filter-btn" data-filter="unggulan">
                <i class="fas fa-star"></i>
                <span>Unggulan</span>
            </button>
        </div>
    </div>
</section>

<section class="layanan-section">
    <div class="container">
        @if($layanans->where('unggulan', true)->count() > 0)
        <div class="section-header" data-aos="fade-up">
            <div class="section-badge">
                <i class="fas fa-star"></i>
                <span>Layanan Unggulan</span>
            </div>
            <h2>Layanan Terbaik Kami</h2>
            <p>Pilihan layanan unggulan yang paling diminati</p>
        </div>

        <div class="layanan-grid featured-grid" data-filter-type="unggulan">
            @foreach($layanans->where('unggulan', true) as $layanans)
            <div class="layanan-card featured" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="layanan-badge">
                    <i class="fas fa-crown"></i>
                    <span>Unggulan</span>
                </div>
                
                <div class="layanan-image">
                    @if($layanans->gambar)
                        <img src="{{ asset('storage/' . $layanans->gambar) }}" alt="{{ $layanans->nama }}">
                    @else
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                    <div class="image-overlay">
                        <a href="{{ route('layanan.detail', $layanans->slug) }}" class="view-btn">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="layanan-content">
                    @if($layanans->icon)
                    <div class="layanan-icon">
                        <i class="{{ $layanans->icon }}"></i>
                    </div>
                    @endif
                    
                    <h3 class="layanan-title">
                        <a href="{{ route('layanan.detail', $layanans->slug) }}">{{ $layanans->nama }}</a>
                    </h3>
                    
                    @if($layanans->deskripsi_singkat)
                    <p class="layanan-description">{{ Str::limit($layanans->deskripsi_singkat, 120) }}</p>
                    @endif
                    
                    <div class="layanan-meta">
                        @if($layanans->fasilitas && count($layanans->fasilitas) > 0)
                        <div class="layanan-fasilitas-count">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ count($layanans->fasilitas) }} Fasilitas</span>
                        </div>
                        @endif
                    </div>
                    
                    <a href="{{ route('layanan.detail', $layanans->slug) }}" class="layanan-link">
                        Lihat Detail
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if($layanans->where('unggulan', false)->count() > 0)
        <div class="section-header" data-aos="fade-up" style="margin-top: 4rem;">
            <div class="section-badge">
                <i class="fas fa-concierge-bell"></i>
                <span>Layanan Lainnya</span>
            </div>
            <h2>Layanan Lainnya</h2>
            <p>Berbagai pilihan layanan untuk kebutuhan Anda</p>
        </div>

        <div class="layanan-grid regular-grid" data-filter-type="regular">
            @foreach($layanans->where('unggulan', false) as $layanans)
            <div class="layanan-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="layanan-image">
                    @if($layanans->gambar)
                        <img src="{{ asset('storage/' . $layanans->gambar) }}" alt="{{ $layanans->nama }}">
                    @else
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                    <div class="image-overlay">
                        <a href="{{ route('layanan.detail', $layanans->slug) }}" class="view-btn">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="layanan-content">
                    @if($layanans->icon)
                    <div class="layanan-icon">
                        <i class="{{ $layanans->icon }}"></i>
                    </div>
                    @endif
                    
                    <h3 class="layanan-title">
                        <a href="{{ route('layanan.detail', $layanans->slug) }}">{{ $layanans->nama }}</a>
                    </h3>
                    
                    @if($layanans->deskripsi_singkat)
                    <p class="layanan-description">{{ Str::limit($layanans->deskripsi_singkat, 100) }}</p>
                    @endif
                    
                    <div class="layanan-meta">
                        @if($layanans->harga)
                        <div class="layanan-price">
                            <i class="fas fa-tag"></i>
                            <span>Rp {{ number_format($layanans->harga, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        @if($layanans->fasilitas && count($layanans->fasilitas) > 0)
                        <div class="layanan-fasilitas-count">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ count($layanans->fasilitas) }} Fasilitas</span>
                        </div>
                        @endif
                    </div>
                    
                    <a href="{{ route('layanan.detail', $layanans->slug) }}" class="layanan-link">
                        Lihat Detail
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if($layanans->count() === 0)
        <div class="empty-layanan" data-aos="fade-up">
            <i class="fas fa-box-open"></i>
            <h3>Belum Ada Layanan</h3>
            <p>Saat ini belum ada layanan yang tersedia. Silakan kembali lagi nanti.</p>
        </div>
        @endif
    </div>
</section>

<section class="cta-section">
    <div class="cta-background"></div>
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <div class="cta-icon">
                <i class="fas fa-phone-alt"></i>
            </div>
            <h2 class="cta-title">Butuh Informasi Lebih Lanjut?</h2>
            <p class="cta-text">Tim kami siap membantu Anda menemukan layanan yang tepat</p>
            <div class="cta-buttons">
                <a href="{{ route('kontak') }}" class="btn-cta-primary">
                    <span>Hubungi Kami</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100,
        easing: 'ease-in-out'
    });
</script>
@endsection