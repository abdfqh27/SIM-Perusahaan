@extends('frontend.layouts.app')

@section('title', $layanan->nama . ' - Layanan')

@push('styles')
<style>
.layanan-detail-section {
    padding: 80px 0;
}

.detail-container {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 3rem;
    margin-bottom: 3rem;
}

/* Main Content Area */
.detail-main {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.detail-header-image {
    width: 100%;
    height: 450px;
    position: relative;
    overflow: hidden;
}

.detail-header-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.detail-header-image .no-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #e9ecef, #dee2e6);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 5rem;
    color: #adb5bd;
}

.detail-badge-container {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    gap: 0.75rem;
}

.detail-badge {
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    color: white;
    padding: 0.5rem 1.25rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 15px rgba(251, 133, 0, 0.4);
}

.status-badge {
    background: linear-gradient(135deg, #10b981, #059669);
}

.detail-content {
    padding: 3rem;
}

.detail-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--blue-dark);
    margin-bottom: 1rem;
    line-height: 1.2;
}

.detail-meta {
    display: flex;
    gap: 2rem;
    padding: 1.5rem 0;
    border-top: 2px solid #e9ecef;
    border-bottom: 2px solid #e9ecef;
    margin-bottom: 2rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.meta-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.meta-info label {
    display: block;
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 0.25rem;
}

.meta-info span {
    display: block;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--blue-dark);
}

.detail-description {
    margin-bottom: 3rem;
}

.detail-description h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--blue-dark);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.detail-description h3 i {
    color: var(--orange-primary);
}

.detail-description .short-desc {
    font-size: 1.1rem;
    color: #666;
    line-height: 1.8;
    margin-bottom: 1.5rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-left: 4px solid var(--orange-primary);
    border-radius: 8px;
}

.detail-description .full-desc {
    font-size: 1rem;
    color: #555;
    line-height: 1.8;
}

.detail-description .full-desc p {
    margin-bottom: 1rem;
}

.fasilitas-section {
    margin-bottom: 3rem;
}

.fasilitas-section h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--blue-dark);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.fasilitas-section h3 i {
    color: var(--orange-primary);
}

.fasilitas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
}

.facility-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    border-left: 3px solid var(--orange-primary);
    transition: all 0.3s ease;
}

.facility-item:hover {
    background: white;
    box-shadow: 0 4px 15px rgba(251, 133, 0, 0.15);
    transform: translateX(5px);
}

.facility-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
}

.facility-text {
    font-size: 0.95rem;
    color: var(--blue-dark);
    font-weight: 500;
}

/* Sidebar */
.detail-sidebar {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.sidebar-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.sidebar-card h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--blue-dark);
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
}

.price-card {
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    color: white;
}

.price-card h3 {
    color: white;
    border-bottom-color: rgba(255, 255, 255, 0.2);
}

.price-amount {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.price-label {
    font-size: 0.95rem;
    opacity: 0.9;
    margin-bottom: 2rem;
}

.contact-buttons {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.contact-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.contact-btn i {
    font-size: 1.2rem;
}

.btn-whatsapp {
    background: white;
    color: var(--orange-primary);
}

.btn-whatsapp:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    color: var(--orange-secondary);
}

.btn-phone {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid white;
}

.btn-phone:hover {
    background: white;
    color: var(--orange-primary);
    transform: translateY(-3px);
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.info-item:hover {
    background: #e9ecef;
}

.info-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
}

.info-content label {
    display: block;
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 0.25rem;
}

.info-content span {
    display: block;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--blue-dark);
}

/* Other layanans */
.other-layanans-section {
    padding: 80px 0;
    background: #f8f9fa;
}

.section-header-alt {
    text-align: center;
    margin-bottom: 3rem;
}

.section-header-alt h2 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--blue-dark);
    margin-bottom: 0.5rem;
}

.section-header-alt p {
    font-size: 1.1rem;
    color: #666;
}

.other-layanans-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.other-layanan-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    text-decoration: none;
    display: block;
}

.other-layanan-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(251, 133, 0, 0.2);
}

.other-layanan-image {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.other-layanan-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.other-layanan-card:hover .other-layanan-image img {
    transform: scale(1.1);
}

.other-layanan-image .no-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #e9ecef, #dee2e6);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: #adb5bd;
}

.other-layanan-content {
    padding: 1.5rem;
}

.other-layanan-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--blue-dark);
    margin-bottom: 0.75rem;
}

.other-layanan-desc {
    font-size: 0.9rem;
    color: #666;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.other-layanan-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.other-layanan-price {
    font-size: 1rem;
    font-weight: 600;
    color: var(--orange-primary);
}

.other-layanan-link {
    color: var(--orange-primary);
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}

.other-layanan-card:hover .other-layanan-link {
    transform: translateX(5px);
}

/* Empty State */
.no-fasilitas {
    text-align: center;
    padding: 3rem;
    background: #f8f9fa;
    border-radius: 12px;
}

.no-fasilitas i {
    font-size: 3rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}

.no-fasilitas p {
    color: #666;
    font-size: 1rem;
}

/* Responsive */
@media (max-width: 1200px) {
    .detail-container {
        grid-template-columns: 1fr 340px;
        gap: 2rem;
    }
}

@media (max-width: 991px) {
    .detail-container {
        grid-template-columns: 1fr;
    }
    
    .detail-sidebar {
        order: -1;
    }
    
    .detail-title {
        font-size: 2rem;
    }
    
    .fasilitas-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .layanan-detail-section {
        padding: 60px 0;
    }
    
    .detail-header-image {
        height: 300px;
    }
    
    .detail-content {
        padding: 2rem 1.5rem;
    }
    
    .detail-title {
        font-size: 1.75rem;
    }
    
    .detail-meta {
        flex-direction: column;
        gap: 1rem;
    }
    
    .other-layanans-grid {
        grid-template-columns: 1fr;
    }
    
    .price-amount {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .detail-badge-container {
        flex-direction: column;
        top: 15px;
        right: 15px;
    }
    
    .detail-content {
        padding: 1.5rem 1rem;
    }
    
    .sidebar-card {
        padding: 1.5rem;
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
            <h1 class="hero-title" data-aos="fade-up">{{ $layanan->nama }}</h1>
            @if($layanan->deskripsi_singkat)
            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">
                {{ Str::limit($layanan->deskripsi_singkat, 100) }}
            </p>
            @endif
            <div class="hero-divider"></div>
            <div class="hero-breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ url('/') }}"><i class="fas fa-home"></i> Beranda</a>
                <span><i class="fas fa-chevron-right"></i></span>
                <a href="{{ route('layanan') }}">Layanan</a>
                <span><i class="fas fa-chevron-right"></i></span>
                <span>{{ $layanan->nama }}</span>
            </div>
        </div>
    </div>
    <div class="hero-decoration">
        <div class="decoration-circle circle-1"></div>
        <div class="decoration-circle circle-2"></div>
        <div class="decoration-circle circle-3"></div>
    </div>
</section>

<section class="layanan-detail-section">
    <div class="container">
        <div class="detail-container">
            <!-- Main Content -->
            <div class="detail-main" data-aos="fade-up">
                <!-- Header Image -->
                <div class="detail-header-image">
                    @if($layanan->gambar)
                        <img src="{{ asset($layanan->gambar) }}" alt="{{ $layanan->nama }}">
                    @else
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                    
                    <div class="detail-badge-container">
                        @if($layanan->unggulan)
                        <div class="detail-badge">
                            <i class="fas fa-crown"></i>
                            <span>Unggulan</span>
                        </div>
                        @endif
                        
                        @if($layanan->aktif)
                        <div class="detail-badge status-badge">
                            <i class="fas fa-check-circle"></i>
                            <span>Tersedia</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Content -->
                <div class="detail-content">
                    <h1 class="detail-title">{{ $layanan->nama }}</h1>
                    
                    <!-- Meta Information -->
                    <div class="detail-meta">
                        @if($layanan->harga)
                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div class="meta-info">
                                <label>Harga Mulai</label>
                                <span>Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endif
                        
                        @if($layanan->fasilitas && count($layanan->fasilitas) > 0)
                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="meta-info">
                                <label>Total Fasilitas</label>
                                <span>{{ count($layanan->fasilitas) }} Fasilitas</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Description -->
                    <div class="detail-description">
                        <h3>
                            <i class="fas fa-info-circle"></i>
                            Deskripsi Layanan
                        </h3>
                        
                        @if($layanan->deskripsi_singkat)
                        <div class="short-desc">
                            {{ $layanan->deskripsi_singkat }}
                        </div>
                        @endif
                        
                        @if($layanan->deskripsi_lengkap)
                        <div class="full-desc">
                            {!! nl2br(e($layanan->deskripsi_lengkap)) !!}
                        </div>
                        @endif
                    </div>
                    
                    <!-- fasilitas -->
                    @if($layanan->fasilitas && count($layanan->fasilitas) > 0)
                    <div class="fasilitas-section">
                        <h3>
                            <i class="fas fa-list-check"></i>
                            Fasilitas yang Tersedia
                        </h3>
                        
                        <div class="fasilitas-grid">
                            @foreach($layanan->fasilitas as $fasilitas)
                            <div class="facility-item">
                                <div class="facility-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="facility-text">{{ $fasilitas }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="no-fasilitas">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada fasilitas yang terdaftar untuk layanan ini</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="detail-sidebar">
                <!-- Price Card -->
                @if($layanan->harga)
                <div class="sidebar-card price-card" data-aos="fade-up" data-aos-delay="100">
                    <h3>Harga Layanan</h3>
                    <div class="price-amount">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</div>
                    <div class="price-label">Harga mulai dari</div>
                    
                    <div class="contact-buttons">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengaturans->whatsapp ?? '') }}?text=Halo,%20saya%20tertarik%20dengan%20layanan%20{{ urlencode($layanan->nama) }}" 
                           class="contact-btn btn-whatsapp" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                        
                        @if($pengaturans->phone ?? null)
                        <a href="tel:{{ $pengaturans->phone }}" class="contact-btn btn-phone">
                            <i class="fas fa-phone"></i>
                            <span>Telepon</span>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
                
                <!-- layanan Info -->
                <div class="sidebar-card" data-aos="fade-up" data-aos-delay="200">
                    <h3>Informasi Layanan</h3>
                    
                    <div class="info-list">
                        @if($layanan->icon)
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="{{ $layanan->icon }}"></i>
                            </div>
                            <div class="info-content">
                                <label>Kategori</label>
                                <span>{{ $layanan->nama }}</span>
                            </div>
                        </div>
                        @endif
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div class="info-content">
                                <label>Urutan</label>
                                <span>{{ $layanan->urutan }}</span>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="info-content">
                                <label>Ditambahkan</label>
                                <span>{{ $layanan->formatted_created_at }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($layananLainnya->count() > 0)
<section class="other-layanans-section">
    <div class="container">
        <div class="section-header-alt" data-aos="fade-up">
            <h2>Layanan Lainnya</h2>
            <p>Lihat layanan lain yang mungkin Anda minati</p>
        </div>
        
        <div class="other-layanans-grid">
            @foreach($layananLainnya as $index => $item)
            <a href="{{ route('layanan.detail', $item->slug) }}" 
               class="other-layanan-card" 
               data-aos="fade-up" 
               data-aos-delay="{{ $index * 100 }}">
                <div class="other-layanan-image">
                    @if($item->gambar)
                        <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama }}">
                    @else
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                </div>
                
                <div class="other-layanan-content">
                    <h3 class="other-layanan-title">{{ $item->nama }}</h3>
                    
                    @if($item->deskripsi_singkat)
                    <p class="other-layanan-desc">
                        {{ Str::limit($item->deskripsi_singkat, 80) }}
                    </p>
                    @endif
                    
                    <div class="other-layanan-meta">
                        @if($item->harga)
                        <span class="other-layanan-price">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </span>
                        @endif
                        <i class="fas fa-arrow-right other-layanan-link"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-background"></div>
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <div class="cta-icon">
                <i class="fas fa-phone-alt"></i>
            </div>
            <h2 class="cta-title">Tertarik dengan Layanan Ini?</h2>
            <p class="cta-text">Hubungi kami sekarang untuk informasi lebih lanjut dan dapatkan penawaran terbaik</p>
            <div class="cta-buttons">
                <a href="{{ route('kontak') }}" class="btn-cta-primary">
                    <span>Hubungi Kami</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{ route('layanan') }}" class="btn-cta-secondary">
                    <span>Lihat Semua Layanan</span>
                    <i class="fas fa-th"></i>
                </a>
            </div>
        </div>
    </div>
</section>

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