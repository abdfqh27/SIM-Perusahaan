@extends('frontend.layouts.app')

@section('title', 'Beranda')
@push('styles')
    @vite('resources/css/frontend/home.css')
@endpush

@section('content')
<!-- Hero Section -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-indicators">
        @foreach($heroes as $index => $hero)
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" 
                class="{{ $index == 0 ? 'active' : '' }}" 
                aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                aria-label="Slide {{ $index + 1 }}"></button>
        @endforeach
    </div>
    
    <div class="carousel-inner">
        @foreach($heroes as $index => $hero)
        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
            <div class="hero-section" 
                 style="background-image: url('{{ asset('storage/' . $hero->gambar) }}');">
                <div class="hero-overlay"></div>
                <div class="hero-particles"></div>
                <div class="container position-relative">
                    <div class="hero-content">
                        <div class="hero-badge mb-4" data-aos="fade-down">
                            <i class="fas fa-star"></i>
                            <span>Layanan Terpercaya #1</span>
                        </div>
                        <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
                            {{ $hero->judul }}
                        </h1>
                        <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                            {{ $hero->deskripsi }}
                        </p>
                        @if($hero->tombol_text)
                        <div class="hero-cta" data-aos="fade-up" data-aos-delay="300">
                            <a href="{{ $hero->tombol_link }}" class="btn btn-hero btn-lg">
                                <span>{{ $hero->tombol_text }}</span>
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                            <a href="#layanan" class="btn btn-hero-outline btn-lg ms-3">
                                <i class="fas fa-play-circle me-2"></i>
                                <span>Lihat Demo</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="hero-scroll-indicator">
                    <div class="mouse"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-icon">
            <i class="fas fa-chevron-left"></i>
        </span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-icon">
            <i class="fas fa-chevron-right"></i>
        </span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Statistik Section -->
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="0">
                    <div class="stat-icon">
                        <i class="fas fa-bus"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number" data-count="50">0</h3>
                        <p class="stat-label">Armada Bus</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number" data-count="10000">0</h3>
                        <p class="stat-label">Pelanggan Puas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number" data-count="500">0</h3>
                        <p class="stat-label">Destinasi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number" data-count="4">0</h3>
                        <p class="stat-label">Tahun Pengalaman</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Profil Singkat -->
@if($tentang)
<section class="tentang-section py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="tentang-image-wrapper">
                    @if($tentang->gambar_perusahaan)
                    <img src="{{ asset('storage/' . $tentang->gambar_perusahaan) }}" 
                         alt="Perusahaan" 
                         class="tentang-image">
                    @endif
                    <div class="tentang-badge">
                        <i class="fas fa-check-circle"></i>
                        <span>Terpercaya</span>
                    </div>
                    <div class="tentang-experience">
                        <h3>4+</h3>
                        <p>Tahun<br>Pengalaman</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="section-header mb-4">
                    <span class="section-badge">Tentang Kami</span>
                    <h2 class="section-title">Mitra Perjalanan Terpercaya Anda</h2>
                </div>
                <p class="tentang-text">{{ Str::limit($tentang->sejarah, 400) }}</p>
                
                <div class="tentang-features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Armada Terawat & Modern</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Driver Profesional & Berpengalaman</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Harga Kompetitif & Transparan</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pelayanan 24/7</span>
                    </div>
                </div>
                
                <a href="{{ route('tentang') }}" class="btn btn-primary btn-lg mt-4">
                    Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Layanan Unggulan -->
<section class="layanan-section py-5" id="layanan">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Layanan Kami</span>
            <h2 class="section-title">Layanan Unggulan</h2>
            <p class="section-subtitle">Berbagai layanan terbaik untuk memenuhi kebutuhan perjalanan Anda</p>
        </div>
        
        <div class="row g-4">
            @foreach($layanan as $index => $layanan)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="layanan-card">
                    <div class="layanan-image">
                        @if($layanan->gambar)
                        <img src="{{ asset($layanan->gambar) }}" alt="{{ $layanan->nama }}">
                        @endif
                        <div class="layanan-overlay">
                            <i class="fas fa-concierge-bell"></i>
                        </div>
                    </div>
                    <div class="layanan-content">
                        <h5 class="layanan-title">{{ $layanan->nama }}</h5>
                        <p class="layanan-description">{{ Str::limit($layanan->deskripsi_singkat, 100) }}</p>
                        <a href="{{ route('layanan.detail', $layanan->slug) }}" class="layanan-link">
                            Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('layanan') }}" class="btn btn-outline-primary btn-lg">
                Lihat Semua Layanan <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Armada Unggulan -->
<section class="armada-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Armada Kami</span>
            <h2 class="section-title">Armada Unggulan</h2>
            <p class="section-subtitle">Bus berkualitas dengan fasilitas terlengkap untuk kenyamanan perjalanan Anda</p>
        </div>
        
        <div class="row g-4">
            @foreach($armada as $index => $armada)
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                <div class="armada-card">
                    <div class="armada-image">
                        @if($armada->gambar_utama)
                        <img src="{{ asset('storage/' . $armada->gambar_utama) }}" alt="{{ $armada->nama }}">
                        @endif
                        <div class="armada-badge">
                            <i class="fas fa-star"></i>
                            <span>Premium</span>
                        </div>
                    </div>
                    <div class="armada-content">
                        <h5 class="armada-title">{{ $armada->nama }}</h5>
                        <div class="armada-specs">
                            <div class="spec-item">
                                <i class="fas fa-users"></i>
                                <span>{{ $armada->kapasitas }} Seat</span>
                            </div>
                            <div class="spec-item">
                                <i class="fas fa-snowflake"></i>
                                <span>AC</span>
                            </div>
                            <div class="spec-item">
                                <i class="fas fa-wifi"></i>
                                <span>WiFi</span>
                            </div>
                        </div>
                        <p class="armada-description">{{ Str::limit($armada->deskripsi, 80) }}</p>
                        <a href="{{ route('armada.detail', $armada->slug) }}" class="btn btn-armada">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('armada') }}" class="btn btn-primary btn-lg">
                Lihat Semua Armada <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section">
    <div class="cta-overlay"></div>
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="zoom-in">
                <div class="cta-icon mb-4">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h2 class="cta-title mb-3">Siap Memulai Perjalanan Anda?</h2>
                <p class="cta-subtitle mb-5">
                    Hubungi kami sekarang untuk informasi lebih lanjut dan pemesanan. 
                    Tim kami siap melayani Anda 24/7
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('kontak') }}" class="btn btn-cta btn-lg">
                        <i class="fas fa-envelope me-2"></i>
                        Hubungi Kami
                    </a>
                    <a href="https://wa.me/6281234567890" class="btn btn-cta-outline btn-lg ms-3" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

{{-- Push JS khusus untuk halaman home --}}
@push('scripts')
    @vite('resources/js/frontend/home.js')
@endpush