@extends('frontend.layouts.app')

@section('title', $armada->nama . ' - Armada')

@push('styles')
<style>
/* Import dari app.css - Fleet Detail Specific Styles */

/* Hero Section */
.fleet-detail-hero {
    position: relative;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--blue-dark) 0%, var(--blue-light) 100%);
    overflow: hidden;
    padding: 120px 0 80px;
}

.fleet-detail-hero .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(2, 48, 71, 0.7);
    z-index: 1;
}

.fleet-detail-hero .hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}

.fleet-detail-hero .hero-text {
    max-width: 800px;
    margin: 0 auto;
}

.fleet-detail-hero .hero-breadcrumb {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.fleet-detail-hero .hero-breadcrumb a {
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.fleet-detail-hero .hero-breadcrumb a:hover {
    color: var(--orange-secondary);
}

.fleet-detail-hero .hero-breadcrumb span {
    color: rgba(255, 255, 255, 0.7);
}

.fleet-detail-hero .hero-breadcrumb span:last-child {
    color: var(--orange-secondary);
    font-weight: 500;
}

.fleet-detail-hero .hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: white;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    font-family: var(--font-primary);
}

.fleet-detail-hero .featured-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(251, 133, 0, 0.4);
    margin-top: 1rem;
}

/* Main Content */
.fleet-detail-content {
    padding: 80px 0;
    background: #f8f9fa;
}

/* Fleet Images */
.fleet-images {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.fleet-images .main-image {
    position: relative;
    width: 100%;
    height: 500px;
    overflow: hidden;
    background: #f8f9fa;
}

.fleet-images .main-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.fleet-images .no-image-large {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #e9ecef, #dee2e6);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
}

.fleet-images .no-image-large i {
    font-size: 5rem;
    margin-bottom: 1rem;
}

.fleet-images .no-image-large p {
    font-size: 1.25rem;
    font-weight: 500;
}

/* Gallery Thumbs */
.gallery-thumbs {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
}

.gallery-thumbs .thumb-item {
    position: relative;
    width: 100%;
    height: 100px;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s ease;
}

.gallery-thumbs .thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-thumbs .thumb-item:hover,
.gallery-thumbs .thumb-item.active {
    border-color: var(--orange-primary);
    transform: scale(1.05);
}

.gallery-thumbs .thumb-item:hover img {
    transform: scale(1.1);
}

/* Fleet Info Section */
.fleet-info-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--blue-dark);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: var(--font-primary);
}

.section-title i {
    color: var(--orange-primary);
    font-size: 1.5rem;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.info-box {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 15px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.info-box:hover {
    background: white;
    border-color: var(--orange-primary);
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(251, 133, 0, 0.2);
}

.info-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    border-radius: 15px;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.info-content {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 0.875rem;
    color: #666;
    margin-bottom: 0.25rem;
}

.info-value {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--blue-dark);
}

.info-value.status-available {
    color: #28a745;
}

/* Fleet Description */
.fleet-description {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.description-content {
    font-size: 1rem;
    line-height: 1.8;
    color: #555;
}

/* Fleet Facilities Section */
.fleet-facilities-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.facilities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.facility-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.facility-item:hover {
    background: white;
    border-color: var(--orange-primary);
    transform: translateX(5px);
}

.facility-icon {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    border-radius: 10px;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.facility-name {
    font-size: 1rem;
    font-weight: 500;
    color: var(--blue-dark);
}

/* Sidebar */
.sidebar-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

/* CTA Card */
.cta-card {
    text-align: center;
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
    color: white;
}

.cta-card .card-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    border-radius: 50%;
    font-size: 2rem;
    box-shadow: 0 10px 30px rgba(251, 133, 0, 0.3);
}

.cta-card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: white;
}

.cta-card p {
    font-size: 1rem;
    margin-bottom: 1.5rem;
    color: rgba(255, 255, 255, 0.85);
}

.cta-card .btn-primary {
    width: 100%;
    justify-content: center;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

/* Other Fleets */
.sidebar-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--blue-dark);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.sidebar-title i {
    color: var(--orange-primary);
}

.other-fleet-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.other-fleet-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 15px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.other-fleet-item:hover {
    background: white;
    border-color: var(--orange-primary);
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(251, 133, 0, 0.2);
}

.other-fleet-image {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
}

.other-fleet-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.other-fleet-image .no-image-small {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #e9ecef, #dee2e6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 1.5rem;
}

.other-fleet-info {
    flex: 1;
}

.other-fleet-info h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--blue-dark);
    margin-bottom: 0.25rem;
}

.fleet-type-small {
    display: inline-block;
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.fleet-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.875rem;
    color: #666;
}

.fleet-meta i {
    color: var(--orange-primary);
}

.other-fleet-item > i {
    color: var(--orange-primary);
    font-size: 1.25rem;
}

.btn-view-all {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-view-all:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(251, 133, 0, 0.4);
    color: white;
}

/* Share Card */
.share-buttons {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.share-btn {
    width: 100%;
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
    color: white;
    font-size: 1.25rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.share-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.share-btn.facebook {
    background: #1877f2;
}

.share-btn.twitter {
    background: #1da1f2;
}

.share-btn.whatsapp {
    background: #25d366;
}

.share-btn.email {
    background: #ea4335;
}

/* Related Fleets Section */
.related-fleets {
    padding: 80px 0;
    background: white;
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

.section-header .section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--blue-dark);
    margin-bottom: 0;
    display: block;
}

/* Fleets Slider */
.fleets-slider {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}

.fleet-slide {
    width: 100%;
}

.fleet-card-small {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.fleet-card-small:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.fleet-image-small {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.fleet-image-small img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.fleet-card-small:hover .fleet-image-small img {
    transform: scale(1.1);
}

.fleet-image-small .no-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #e9ecef, #dee2e6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 3rem;
}

.featured-tag {
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

.fleet-info-small {
    padding: 1.5rem;
}

.fleet-info-small h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--blue-dark);
    margin-bottom: 0.5rem;
}

.fleet-info-small .type {
    display: inline-block;
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.fleet-info-small .meta {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    font-size: 0.95rem;
    color: #666;
    margin-bottom: 1rem;
}

.fleet-info-small .meta i {
    color: var(--orange-primary);
    margin-right: 0.25rem;
}

.btn-detail-small {
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

.btn-detail-small:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(251, 133, 0, 0.4);
    color: white;
}

/* Responsive Design */
@media (max-width: 991px) {
    .fleet-detail-hero .hero-title {
        font-size: 2.5rem;
    }
    
    .info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .facilities-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .fleet-detail-hero {
        padding: 100px 0 60px;
    }
    
    .fleet-detail-hero .hero-title {
        font-size: 2rem;
    }
    
    .fleet-detail-content {
        padding: 60px 0;
    }
    
    .fleet-images .main-image {
        height: 350px;
    }
    
    .gallery-thumbs {
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    }
    
    .gallery-thumbs .thumb-item {
        height: 70px;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .facilities-grid {
        grid-template-columns: 1fr;
    }
    
    .share-buttons {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .fleets-slider {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .fleet-detail-hero .hero-title {
        font-size: 1.75rem;
    }
    
    .fleet-detail-hero .featured-badge {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }
    
    .fleet-images .main-image {
        height: 250px;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .section-header .section-title {
        font-size: 2rem;
    }
    
    .fleet-info-section,
    .fleet-description,
    .fleet-facilities-section,
    .sidebar-card {
        padding: 1.5rem;
    }
    
    .cta-card .card-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="fleet-detail-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container">
            <div class="hero-text" data-aos="fade-up">
                <div class="hero-breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <a href="{{ route('armada') }}">Armada</a>
                    <span>/</span>
                    <span>{{ $armada->nama }}</span>
                </div>
                <h1 class="hero-title">{{ $armada->nama }}</h1>
                @if($armada->unggulan)
                    <div class="featured-badge">
                        <i class="fas fa-star"></i>
                        Armada Unggulan
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="fleet-detail-content">
    <div class="container">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Main Image & Gallery -->
                <div class="fleet-images" data-aos="fade-up">
                    <div class="main-image">
                        @if($armada->gambar_utama)
                            <img src="{{ asset('storage/' . $armada->gambar_utama) }}" 
                                 alt="{{ $armada->nama }}"
                                 id="mainImage">
                        @else
                            <div class="no-image-large">
                                <i class="fas fa-bus"></i>
                                <p>Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>

                    @if($armada->galeri && count($armada->galeri) > 0)
                        <div class="gallery-thumbs">
                            @if($armada->gambar_utama)
                                <div class="thumb-item active" onclick="changeImage('{{ asset('storage/' . $armada->gambar_utama) }}', this)">
                                    <img src="{{ asset('storage/' . $armada->gambar_utama) }}" alt="{{ $armada->nama }}">
                                </div>
                            @endif
                            @foreach($armada->galeri as $image)
                                <div class="thumb-item" onclick="changeImage('{{ asset('storage/' . $image) }}', this)">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Fleet Info -->
                <div class="fleet-info-section" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Tentang Armada
                    </h2>
                    <div class="info-grid">
                        <div class="info-box">
                            <div class="info-icon">
                                <i class="fas fa-bus"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Tipe Bus</span>
                                <span class="info-value">{{ $armada->tipe_bus }}</span>
                            </div>
                        </div>
                        <div class="info-box">
                            <div class="info-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Kapasitas</span>
                                <span class="info-value">{{ $armada->kapasitas }}</span>
                            </div>
                        </div>
                        <div class="info-box">
                            <div class="info-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Fasilitas</span>
                                <span class="info-value">{{ $armada->jumlah_fasilitas }} Item</span>
                            </div>
                        </div>
                        <div class="info-box">
                            <div class="info-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Status</span>
                                <span class="info-value status-available">Tersedia</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($armada->deskripsi)
                    <div class="fleet-description" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="section-title">
                            <i class="fas fa-align-left"></i>
                            Deskripsi
                        </h2>
                        <div class="description-content">
                            {!! nl2br(e($armada->deskripsi)) !!}
                        </div>
                    </div>
                @endif

                <!-- Facilities -->
                @if($armada->fasilitas && is_array($armada->fasilitas) && count($armada->fasilitas) > 0)
                    <div class="fleet-facilities-section" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="section-title">
                            <i class="fas fa-star"></i>
                            Fasilitas Tersedia
                        </h2>
                        <div class="facilities-grid">
                            @foreach($armada->fasilitas as $facility)
                                <div class="facility-item">
                                    <div class="facility-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span class="facility-name">{{ $facility }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Sidebar -->
            <div class="col-lg-4">
                <!-- Contact CTA -->
                <div class="sidebar-card cta-card" data-aos="fade-left">
                    <div class="card-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Butuh Bantuan?</h3>
                    <p>Hubungi kami untuk informasi lebih lanjut atau pemesanan</p>
                    <a href="{{ route('kontak') }}" class="btn-primary">
                        <i class="fas fa-phone-alt"></i>
                        Hubungi Sekarang
                    </a>
                </div>

                <!-- Other Fleets -->
                @if($armadaLainnya->count() > 0)
                    <div class="sidebar-card other-fleets" data-aos="fade-left" data-aos-delay="100">
                        <h3 class="sidebar-title">
                            <i class="fas fa-bus"></i>
                            Armada Lainnya
                        </h3>
                        <div class="other-fleet-list">
                            @foreach($armadaLainnya as $other)
                                <a href="{{ route('armada.detail', $other->slug) }}" class="other-fleet-item">
                                    <div class="other-fleet-image">
                                        @if($other->gambar_utama)
                                            <img src="{{ asset('storage/' . $other->gambar_utama) }}" alt="{{ $other->nama }}">
                                        @else
                                            <div class="no-image-small">
                                                <i class="fas fa-bus"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="other-fleet-info">
                                        <h4>{{ $other->nama }}</h4>
                                        <span class="fleet-type-small">{{ $other->tipe_bus }}</span>
                                        <div class="fleet-meta">
                                            <span>
                                                <i class="fas fa-users"></i>
                                                {{ $other->kapasitas }}
                                            </span>
                                        </div>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @endforeach
                        </div>
                        <a href="{{ route('armada') }}" class="btn-view-all">
                            Lihat Semua Armada
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endif

                <!-- Share -->
                <div class="sidebar-card share-card" data-aos="fade-left" data-aos-delay="200">
                    <h3 class="sidebar-title">
                        <i class="fas fa-share-alt"></i>
                        Bagikan
                    </h3>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('armada.detail', $armada->slug)) }}" 
                           target="_blank" 
                           class="share-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('armada.detail', $armada->slug)) }}&text={{ urlencode($armada->nama) }}" 
                           target="_blank" 
                           class="share-btn twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($armada->nama . ' - ' . route('armada.detail', $armada->slug)) }}" 
                           target="_blank" 
                           class="share-btn whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="mailto:?subject={{ urlencode($armada->nama) }}&body={{ urlencode(route('armada.detail', $armada->slug)) }}" 
                           class="share-btn email">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Fleets -->
@if($armadaLainnya->count() > 0)
<section class="related-fleets">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">
                <i class="fas fa-bus"></i>
                Armada Lainnya
            </span>
            <h2 class="section-title">Pilihan Armada Lainnya</h2>
        </div>

        <div class="fleets-slider" data-aos="fade-up" data-aos-delay="100">
            @foreach($armadaLainnya as $other)
                <div class="fleet-slide">
                    <div class="fleet-card-small">
                        <div class="fleet-image-small">
                            @if($other->gambar_utama)
                                <img src="{{ asset('storage/' . $other->gambar_utama) }}" alt="{{ $other->nama }}">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-bus"></i>
                                </div>
                            @endif
                            @if($other->unggulan)
                                <div class="featured-tag">
                                    <i class="fas fa-star"></i>
                                </div>
                            @endif
                        </div>
                        <div class="fleet-info-small">
                            <h3>{{ $other->nama }}</h3>
                            <span class="type">{{ $other->tipe_bus }}</span>
                            <div class="meta">
                                <span><i class="fas fa-users"></i> {{ $other->kapasitas }}</span>
                                <span><i class="fas fa-cogs"></i> {{ $other->jumlah_fasilitas }}</span>
                            </div>
                            <a href="{{ route('armada.detail', $other->slug) }}" class="btn-detail-small">
                                Lihat Detail
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });

    // Change Main Image
    function changeImage(src, element) {
        document.getElementById('mainImage').src = src;
        
        // Remove active class from all thumbs
        document.querySelectorAll('.thumb-item').forEach(thumb => {
            thumb.classList.remove('active');
        });
        
        // Add active class to clicked thumb
        element.classList.add('active');
    }
</script>
@endpush