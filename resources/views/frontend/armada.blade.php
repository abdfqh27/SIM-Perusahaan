@extends('frontend.layouts.app')

@section('title', 'Armada Kami')

@push('styles')
    <style>
    /* Fleet Page Specific Styles */
    
    /* Hero Section - menggunakan styling umum dari CSS global */
    /* .fleet-hero {
        min-height: 450px;
    }
    
    .hero-text {
        max-width: 700px;
        margin: 0 auto;
    } */
    
    /* Featured Fleets Section */
    .featured-fleets {
        padding: 80px 0;
        background: #f8f9fa;
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
    
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 1rem;
    }
    
    .section-subtitle {
        font-size: 1.1rem;
        color: #666;
        max-width: 600px;
        margin: 0 auto;
    }
    
    /* All Fleets Section */
    .all-fleets {
        padding: 80px 0;
    }
    
    /* Fleets Grid */
    .fleets-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    /* Fleet Card */
    .fleet-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }
    
    .fleet-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }
    
    .fleet-card.featured {
        border-top: 4px solid var(--orange-primary);
    }
    
    /* Fleet Badge */
    .fleet-badge {
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
        z-index: 2;
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.4);
    }
    
    /* Fleet Image */
    .fleet-image {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;
    }
    
    .fleet-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .fleet-card:hover .fleet-image img {
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
        background: rgba(2, 48, 71, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .fleet-card:hover .image-overlay {
        opacity: 1;
    }
    
    .btn-view {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        color: var(--blue-dark);
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-view:hover {
        background: var(--orange-primary);
        color: white;
        transform: scale(1.05);
    }
    
    /* Fleet Content */
    .fleet-content {
        padding: 1.5rem;
    }
    
    .fleet-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
        gap: 1rem;
    }
    
    .fleet-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin: 0;
    }
    
    .fleet-type {
        display: inline-block;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }
    
    /* Fleet Info Grid */
    .fleet-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        color: #555;
    }
    
    .info-item i {
        color: var(--orange-primary);
        font-size: 1.1rem;
    }
    
    /* Fleet Description */
    .fleet-description {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.6;
        margin-bottom: 1rem;
    }
    
    /* Fleet Facilities */
    .fleet-facilities {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .facility-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #f8f9fa;
        color: #555;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.8rem;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .facility-badge:hover {
        background: var(--orange-primary);
        color: white;
        border-color: var(--orange-primary);
    }
    
    .facility-badge i {
        font-size: 0.75rem;
    }
    
    .facility-badge.more {
        background: var(--blue-dark);
        color: white;
        border-color: var(--blue-dark);
        font-weight: 600;
    }
    
    /* Fleet Detail Button */
    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
        justify-content: center;
    }
    
    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 133, 0, 0.4);
        color: white;
    }
    
    /* Empty State */
    .empty-state {
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
    
    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        font-size: 1rem;
        color: #666;
    }
    
    /* Responsive Design */
    @media (max-width: 1200px) {
        .fleets-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }
    
    @media (max-width: 991px) {
        .section-title {
            font-size: 2rem;
        }
    }
    
    @media (max-width: 768px) {
        .featured-fleets,
        .all-fleets {
            padding: 60px 0;
        }
        
        .section-title {
            font-size: 1.75rem;
        }
        
        .section-subtitle {
            font-size: 1rem;
        }
        
        .fleets-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .fleet-card {
            border-radius: 15px;
        }
        
        .fleet-image {
            height: 200px;
        }
        
        .fleet-name {
            font-size: 1.25rem;
        }
        
        .fleet-info-grid {
            grid-template-columns: 1fr;
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
                <h1 class="hero-title">Armada Kami</h1>
                <p class="hero-subtitle">Armada modern dengan berbagai pilihan kelas untuk kenyamanan perjalanan Anda</p>
                <div class="hero-divider"></div>
                <div class="hero-breadcrumb" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                    <span><i class="fas fa-chevron-right"></i></span>
                    <span>Armada</span>
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

<!-- Featured Fleets Section -->
@if($armadas->where('unggulan', true)->count() > 0)
<section class="featured-fleets">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">
                <i class="fas fa-star"></i>
                Pilihan Terbaik
            </span>
            <h2 class="section-title">Armada Unggulan</h2>
            <p class="section-subtitle">Armada premium dengan fasilitas terlengkap untuk perjalanan Anda</p>
        </div>

        <div class="fleets-grid">
            @foreach($armadas->where('unggulan', true) as $index => $armada)
                <div class="fleet-card featured" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="fleet-badge">
                        <i class="fas fa-star"></i>
                        Unggulan
                    </div>
                    <div class="fleet-image">
                        @if($armada->gambar_utama)
                            <img src="{{ asset('storage/' . $armada->gambar_utama) }}" alt="{{ $armada->nama }}">
                        @else
                            <div class="no-image">
                                <i class="fas fa-bus"></i>
                            </div>
                        @endif
                        <div class="image-overlay">
                            <a href="{{ route('armada.detail', $armada->slug) }}" class="btn-view">
                                <i class="fas fa-eye"></i>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    <div class="fleet-content">
                        <div class="fleet-header">
                            <h3 class="fleet-name">{{ $armada->nama }}</h3>
                            <span class="fleet-type">{{ $armada->tipe_bus }}</span>
                        </div>
                        <div class="fleet-info-grid">
                            <div class="info-item">
                                <i class="fas fa-users"></i>
                                <span>{{ $armada->kapasitas }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-cogs"></i>
                                <span>{{ $armada->jumlah_fasilitas }} Fasilitas</span>
                            </div>
                        </div>
                        @if($armada->deskripsi)
                            <p class="fleet-description">{{ Str::limit($armada->deskripsi, 100) }}</p>
                        @endif
                        
                        @if($armada->fasilitas && is_array($armada->fasilitas) && count($armada->fasilitas) > 0)
                        <div class="fleet-facilities">
                            @foreach(array_slice($armada->fasilitas, 0, 4) as $facility)
                                <span class="facility-badge" title="{{ $facility }}">
                                    <i class="fas fa-check"></i>
                                    <span>{{ $facility }}</span>
                                </span>
                            @endforeach
                            @if(count($armada->fasilitas) > 4)
                                <span class="facility-badge more">
                                    +{{ count($armada->fasilitas) - 4 }} lainnya
                                </span>
                            @endif
                        </div>
                        @endif
                        
                        <a href="{{ route('armada.detail', $armada->slug) }}" class="btn-detail">
                            Selengkapnya
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- All Fleets Section -->
<section class="all-fleets">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">
                <i class="fas fa-bus"></i>
                Semua Armada
            </span>
            <h2 class="section-title">Pilihan Armada Lengkap</h2>
            <p class="section-subtitle">Temukan armada yang sesuai dengan kebutuhan perjalanan Anda</p>
        </div>

        @if($armadas->count() > 0)
            <div class="fleets-grid">
                @foreach($armadas as $index => $armada)
                    @if(!$armada->unggulan)
                        <div class="fleet-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div class="fleet-image">
                                @if($armada->gambar_utama)
                                    <img src="{{ asset('storage/' . $armada->gambar_utama) }}" alt="{{ $armada->nama }}">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-bus"></i>
                                    </div>
                                @endif
                                <div class="image-overlay">
                                    <a href="{{ route('armada.detail', $armada->slug) }}" class="btn-view">
                                        <i class="fas fa-eye"></i>
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                            <div class="fleet-content">
                                <div class="fleet-header">
                                    <h3 class="fleet-name">{{ $armada->nama }}</h3>
                                    <span class="fleet-type">{{ $armada->tipe_bus }}</span>
                                </div>
                                <div class="fleet-info-grid">
                                    <div class="info-item">
                                        <i class="fas fa-users"></i>
                                        <span>{{ $armada->kapasitas }}</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-cogs"></i>
                                        <span>{{ $armada->jumlah_fasilitas }} Fasilitas</span>
                                    </div>
                                </div>
                                @if($armada->deskripsi)
                                    <p class="fleet-description">{{ Str::limit($armada->deskripsi, 100) }}</p>
                                @endif
                                
                                @if($armada->fasilitas && is_array($armada->fasilitas) && count($armada->fasilitas) > 0)
                                <div class="fleet-facilities">
                                    @foreach(array_slice($armada->fasilitas, 0, 4) as $facility)
                                        <span class="facility-badge" title="{{ $facility }}">
                                            <i class="fas fa-check"></i>
                                            <span>{{ $facility }}</span>
                                        </span>
                                    @endforeach
                                    @if(count($armada->fasilitas) > 4)
                                        <span class="facility-badge more">
                                            +{{ count($armada->fasilitas) - 4 }} lainnya
                                        </span>
                                    @endif
                                </div>
                                @endif
                                
                                <a href="{{ route('armada.detail', $armada->slug) }}" class="btn-detail">
                                    Selengkapnya
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="empty-state" data-aos="fade-up">
                <div class="empty-icon">
                    <i class="fas fa-bus"></i>
                </div>
                <h3>Belum Ada Armada</h3>
                <p>Informasi armada akan segera hadir</p>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <div class="cta-icon">
                <i class="fas fa-phone-alt"></i>
            </div>
            <h2 class="cta-title">Siap Memulai Perjalanan?</h2>
            <p class="cta-text">Hubungi kami untuk informasi lebih lanjut dan pemesanan armada</p>
            <div class="cta-buttons">
                <a href="{{ route('kontak') }}" class="btn-cta-primary">
                    <i class="fas fa-phone-alt"></i>
                    <span>Hubungi Kami</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
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
@endpush