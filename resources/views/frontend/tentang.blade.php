@extends('frontend.layouts.app')

@section('title', 'Tentang Kami')

@push('styles')
<style>
    .tentang-section {
        padding: 80px 0;
        position: relative;
    }
    
    .tentang-section:nth-child(even) {
        background: #f8f9fa;
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
    
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 1rem;
    }
    
    .section-divider {
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--orange-primary), var(--orange-secondary));
        margin-bottom: 2rem;
        border-radius: 2px;
    }
    
    .section-description {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 2rem;
    }
    
    .content-text {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #555;
        text-align: justify;
    }
    
    /* Sejarah Section */
    .image-wrapper {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .image-decoration {
        position: absolute;
        top: -20px;
        right: -20px;
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 15px;
        opacity: 0.2;
        z-index: 0;
    }
    
    .section-image {
        width: 100%;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        position: relative;
        z-index: 1;
        transition: transform 0.3s ease;
    }
    
    .section-image:hover {
        transform: scale(1.02);
    }
    
    .image-overlay-pattern {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 10px,
            rgba(251, 133, 0, 0.05) 10px,
            rgba(251, 133, 0, 0.05) 20px
        );
        pointer-events: none;
        z-index: 2;
    }
    
    .image-placeholder {
        width: 100%;
        height: 400px;
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: #adb5bd;
    }
    
    /* Visi Misi Card */
    .visi-misi-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    
    .visi-misi-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(251, 133, 0, 0.2);
    }
    
    .visi-card {
        border-top: 4px solid var(--orange-primary);
    }
    
    .misi-card {
        border-top: 4px solid var(--blue-light);
    }
    
    .card-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 15px;
        font-size: 2rem;
        color: white;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 20px rgba(251, 133, 0, 0.3);
    }
    
    .misi-card .card-icon {
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
        box-shadow: 0 8px 20px rgba(2, 48, 71, 0.3);
    }
    
    .card-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 1rem;
    }
    
    .card-divider {
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, var(--orange-primary), var(--orange-secondary));
        margin-bottom: 1.5rem;
        border-radius: 2px;
    }
    
    .card-content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #555;
    }
    
    .card-decoration {
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 50%;
        opacity: 0.05;
    }
    
    /* Nilai Perusahaan Card */
    .nilai-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .nilai-decoration-top,
    .nilai-decoration-bottom {
        position: absolute;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        opacity: 0.1;
    }
    
    .nilai-decoration-top {
        top: -30px;
        right: -30px;
    }
    
    .nilai-decoration-bottom {
        bottom: -30px;
        left: -30px;
    }
    
    .nilai-icon-wrapper {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .nilai-icon {
        width: 90px;
        height: 90px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 20px;
        font-size: 2.5rem;
        color: white;
        box-shadow: 0 10px 30px rgba(251, 133, 0, 0.4);
    }
    
    .nilai-content {
        font-size: 1.1rem;
        line-height: 2;
        color: #555;
        position: relative;
        z-index: 1;
    }
    
    .nilai-pattern {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: repeating-linear-gradient(
            0deg,
            transparent,
            transparent 35px,
            rgba(251, 133, 0, 0.03) 35px,
            rgba(251, 133, 0, 0.03) 36px
        );
        pointer-events: none;
    }
    
    /* Pengalaman Card */
    .pengalaman-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .pengalaman-decoration-left,
    .pengalaman-decoration-right {
        position: absolute;
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
        opacity: 0.05;
    }
    
    .pengalaman-decoration-left {
        top: -50px;
        left: -50px;
        border-radius: 0 50% 50% 0;
    }
    
    .pengalaman-decoration-right {
        bottom: -50px;
        right: -50px;
        border-radius: 50% 0 0 50%;
    }
    
    .pengalaman-icon-wrapper {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .pengalaman-icon {
        width: 90px;
        height: 90px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
        border-radius: 20px;
        font-size: 2.5rem;
        color: white;
        box-shadow: 0 10px 30px rgba(2, 48, 71, 0.4);
    }
    
    .pengalaman-content {
        font-size: 1.1rem;
        line-height: 2;
        color: #555;
        position: relative;
        z-index: 1;
    }
    
    .card-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(251, 133, 0, 0.1) 0%, transparent 70%);
        transform: translate(-50%, -50%);
        pointer-events: none;
    }
    
    .pengalaman-dots {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        margin-top: 2rem;
    }
    
    .pengalaman-dots span {
        width: 10px;
        height: 10px;
        background: var(--orange-primary);
        border-radius: 50%;
        display: block;
        animation: dot-pulse 1.5s infinite ease-in-out;
    }
    
    .pengalaman-dots span:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .pengalaman-dots span:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes dot-pulse {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.5);
            opacity: 0.5;
        }
    }
    
    /* CTA Section */
    .tentang-cta {
        padding: 100px 0;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, var(--blue-dark) 0%, #023d54 100%);
    }
    
    .cta-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            radial-gradient(circle at 20% 50%, rgba(251, 133, 0, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(33, 158, 188, 0.1) 0%, transparent 50%);
        z-index: 0;
    }
    
    .cta-background::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background-image: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 50px,
            rgba(255, 255, 255, 0.03) 50px,
            rgba(255, 255, 255, 0.03) 51px
        );
        animation: slide 20s linear infinite;
    }
    
    @keyframes slide {
        0% {
            transform: translate(0, 0);
        }
        100% {
            transform: translate(50px, 50px);
        }
    }
    
    .cta-content {
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        padding: 3rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 30px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .cta-icon {
        width: 100px;
        height: 100px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 50%;
        font-size: 3rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 15px 40px rgba(251, 133, 0, 0.4);
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }
    
    .cta-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
    
    .cta-text {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 2.5rem;
        line-height: 1.8;
    }
    
    .cta-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .btn-cta-primary,
    .btn-cta-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-cta-primary {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        box-shadow: 0 8px 25px rgba(251, 133, 0, 0.4);
    }
    
    .btn-cta-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(251, 133, 0, 0.5);
        color: white;
    }
    
    .btn-cta-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
    }
    
    .btn-cta-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-3px);
        color: white;
    }
    
    .btn-cta-primary::before,
    .btn-cta-secondary::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .btn-cta-primary:hover::before,
    .btn-cta-secondary:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .btn-cta-primary i,
    .btn-cta-secondary i {
        font-size: 1.2rem;
        position: relative;
        z-index: 1;
    }
    
    .btn-cta-primary span,
    .btn-cta-secondary span {
        position: relative;
        z-index: 1;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .section-title {
            font-size: 2rem;
        }
        
        .image-wrapper {
            margin-top: 2rem;
        }
        
        .cta-title {
            font-size: 2rem;
        }
        
        .cta-text {
            font-size: 1.1rem;
        }
    }
    
    @media (max-width: 768px) {
        .tentang-section {
            padding: 60px 0;
        }
        
        .section-title {
            font-size: 1.75rem;
        }
        
        .visi-misi-card,
        .nilai-card,
        .pengalaman-card {
            padding: 2rem;
        }
        
        .tentang-cta {
            padding: 60px 0;
        }
        
        .cta-content {
            padding: 2rem;
        }
        
        .cta-icon {
            width: 80px;
            height: 80px;
            font-size: 2.5rem;
        }
        
        .cta-title {
            font-size: 1.75rem;
        }
        
        .cta-buttons {
            flex-direction: column;
            align-items: stretch;
        }
        
        .btn-cta-primary,
        .btn-cta-secondary {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="tentang-page">
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="container">
                <div class="hero-text" data-aos="fade-up">
                    <h1 class="hero-title">Tentang Kami</h1>
                    <p class="hero-subtitle">Mengenal Lebih Dekat Perjalanan dan Visi Kami</p>
                    <div class="hero-divider"></div>
                    <div class="hero-breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ url('/') }}"><i class="fas fa-home"></i> Beranda</a>
                        <span><i class="fas fa-chevron-right"></i></span>
                        <span>Tentang Kami</span>
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

    @if($tentang && $tentang->sejarah)
    <section class="tentang-section sejarah-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="section-badge">
                        <i class="fas fa-history"></i>
                        Sejarah Kami
                    </div>
                    <h2 class="section-title">Perjalanan Kami</h2>
                    <div class="section-divider"></div>
                    <div class="content-text">
                        {!! nl2br(e($tentang->sejarah)) !!}
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    @if($tentang->gambar_perusahaan)
                    <div class="image-wrapper">
                        <div class="image-decoration"></div>
                        <img src="{{ asset('storage/' . $tentang->gambar_perusahaan) }}" 
                             alt="Perusahaan" 
                             class="section-image">
                        <div class="image-overlay-pattern"></div>
                    </div>
                    @else
                    <div class="image-placeholder">
                        <i class="fas fa-building"></i>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($tentang && ($tentang->visi || $tentang->misi))
    <section class="tentang-section visi-misi-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="section-badge mx-auto">
                    <i class="fas fa-eye"></i>
                    Visi & Misi
                </div>
                <h2 class="section-title">Tujuan Kami</h2>
                <div class="section-divider mx-auto"></div>
            </div>

            <div class="row g-4">
                @if($tentang->visi)
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="visi-misi-card visi-card">
                        <div class="card-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="card-title">Visi</h3>
                        <div class="card-divider"></div>
                        <div class="card-content">
                            {!! nl2br(e($tentang->visi)) !!}
                        </div>
                        <div class="card-decoration"></div>
                    </div>
                </div>
                @endif

                @if($tentang->misi)
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="visi-misi-card misi-card">
                        <div class="card-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3 class="card-title">Misi</h3>
                        <div class="card-divider"></div>
                        <div class="card-content">
                            {!! nl2br(e($tentang->misi)) !!}
                        </div>
                        <div class="card-decoration"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    <!-- Nilai Perusahaan Section -->
    @if($tentang && $tentang->nilai_perusahaan)
    <section class="tentang-section nilai-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="section-badge mx-auto">
                    <i class="fas fa-gem"></i>
                    Nilai Perusahaan
                </div>
                <h2 class="section-title">Nilai-Nilai yang Kami Pegang</h2>
                <div class="section-divider mx-auto"></div>
                <p class="section-description">Fondasi kuat yang membentuk budaya dan identitas perusahaan kami</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">
                    <div class="nilai-card">
                        <div class="nilai-decoration-top"></div>
                        <div class="nilai-icon-wrapper">
                            <div class="nilai-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                        </div>
                        <div class="nilai-content">
                            {!! nl2br(e($tentang->nilai_perusahaan)) !!}
                        </div>
                        <div class="nilai-pattern"></div>
                        <div class="nilai-decoration-bottom"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Pengalaman Section -->
    @if($tentang && $tentang->pengalaman)
    <section class="tentang-section pengalaman-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="section-badge mx-auto">
                    <i class="fas fa-trophy"></i>
                    Pengalaman Perusahaan
                </div>
                <h2 class="section-title">Jejak Kesuksesan Kami</h2>
                <div class="section-divider mx-auto"></div>
                <p class="section-description">Perjalanan panjang yang penuh dengan pencapaian dan pembelajaran</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">
                    <div class="pengalaman-card">
                        <div class="pengalaman-decoration-left"></div>
                        <div class="pengalaman-decoration-right"></div>
                        <div class="pengalaman-icon-wrapper">
                            <div class="pengalaman-icon">
                                <i class="fas fa-award"></i>
                            </div>
                        </div>
                        <div class="pengalaman-content">
                            {!! nl2br(e($tentang->pengalaman)) !!}
                        </div>
                        <div class="card-glow"></div>
                        <div class="pengalaman-dots">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="tentang-cta">
        <div class="cta-background"></div>
        <div class="container">
            <div class="cta-content" data-aos="zoom-in">
                <div class="cta-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h2 class="cta-title">Mari Berkembang Bersama</h2>
                <p class="cta-text">Bergabunglah dengan kami dalam perjalanan menuju kesuksesan yang berkelanjutan</p>
                <div class="cta-buttons">
                    <a href="{{ route('kontak') }}" class="btn btn-cta-primary">
                        <i class="fas fa-envelope"></i>
                        <span>Hubungi Kami</span>
                    </a>
                    <a href="{{ route('layanan') }}" class="btn btn-cta-secondary">
                        <i class="fas fa-briefcase"></i>
                        <span>Lihat Layanan</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- AOS Animation -->
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