@extends('frontend.layouts.app')

@section('title', 'Artikel & Berita - Travel Kami')

@push('styles')
<style>
.article-card {
    transition: all 0.3s ease;
}

.article-card:hover {
    transform: translateY(-5px);
}

.article-image-wrapper {
    position: relative;
    overflow: hidden;
}

.article-image {
    transition: transform 0.5s ease;
}

.article-card:hover .article-image {
    transform: scale(1.1);
}

.card-title a {
    transition: color 0.3s ease;
}

.card-title a:hover {
    color: var(--orange-primary) !important;
}

.list-group-item.active {
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    border-color: var(--orange-primary);
}

.pagination {
    gap: 0.5rem;
}

.pagination .page-link {
    border-radius: 8px;
    border: none;
    color: var(--blue-dark);
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    color: white;
    transform: translateY(-2px);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    border: none;
}

@media (max-width: 768px) {
    .article-card {
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="container">
                <div class="hero-text" data-aos="fade-up">
                    <h1 class="hero-title">Artikel</h1>
                    <p class="hero-subtitle">Mengenal Lebih Dekat Perjalanan dan Visi Kami</p>
                    <div class="hero-divider"></div>
                    <div class="hero-breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ url('/') }}"><i class="fas fa-home"></i> Beranda</a>
                        <span><i class="fas fa-chevron-right"></i></span>
                        <span>Artikel</span>
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

<!-- Filter & Search Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="fw-semibold text-blue-dark me-2">
                        <i class="fas fa-filter me-2"></i>Filter Kategori:
                    </span>
                    <a href="{{ route('artikel') }}" 
                       class="btn btn-sm {{ !$kategori ? 'btn-primary' : 'btn-outline-primary' }}">
                        <i class="fas fa-th-large me-1"></i>Semua
                    </a>
                    @foreach($kategoris as $kat)
                        <a href="{{ route('artikel', ['kategori' => $kat]) }}" 
                           class="btn btn-sm {{ $kategori == $kat ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="fas fa-tag me-1"></i>{{ ucfirst($kat) }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-lg-end">
                    <span class="text-muted">
                        <i class="fas fa-newspaper me-2"></i>
                        Total: <strong class="text-orange-primary">{{ $artikels->total() }}</strong> artikel
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Articles Grid Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content - Articles Grid -->
            <div class="col-lg-8">
                @if($artikels->count() > 0)
                    <div class="row g-4">
                        @foreach($artikels as $artikel)
                            <div class="col-md-6 animate-fade-in">
                                <div class="card h-100 article-card">
                                    <!-- Article Image -->
                                    <div class="article-image-wrapper position-relative overflow-hidden">
                                        @if($artikel->gambar_featured)
                                            <img src="{{ asset('storage/' . $artikel->gambar_featured) }}" 
                                                 class="card-img-top article-image" 
                                                 alt="{{ $artikel->judul }}"
                                                 style="height: 250px; object-fit: cover;">
                                        @else
                                            <div class="card-img-top d-flex align-items-center justify-content-center"
                                                 style="height: 250px; background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));">
                                                <i class="fas fa-image text-white" style="font-size: 4rem; opacity: 0.5;"></i>
                                            </div>
                                        @endif
                                        
                                        <!-- Category Badge -->
                                        <span class="position-absolute top-0 start-0 m-3 badge bg-orange-primary">
                                            <i class="fas fa-tag me-1"></i>{{ ucfirst($artikel->kategori) }}
                                        </span>
                                    </div>
                                    
                                    <div class="card-body d-flex flex-column">
                                        <!-- Article Meta -->
                                        <div class="d-flex align-items-center text-muted small mb-3">
                                            <span class="me-3">
                                                <i class="fas fa-user me-1"></i>{{ $artikel->user->name }}
                                            </span>
                                            <span class="me-3">
                                                <i class="fas fa-calendar me-1"></i>{{ $artikel->created_at->format('d M Y') }}
                                            </span>
                                            <span>
                                                <i class="fas fa-eye me-1"></i>{{ number_format($artikel->views) }}
                                            </span>
                                        </div>
                                        
                                        <!-- Article Title -->
                                        <h5 class="card-title mb-3">
                                            <a href="{{ route('artikel.detail', $artikel->slug) }}" 
                                               class="text-decoration-none text-blue-dark">
                                                {{ Str::limit($artikel->judul, 60) }}
                                            </a>
                                        </h5>
                                        
                                        <!-- Article Excerpt -->
                                        <p class="card-text text-muted flex-grow-1">
                                            {{ Str::limit(strip_tags($artikel->konten), 120) }}
                                        </p>
                                        
                                        <!-- Read More Button -->
                                        <a href="{{ route('artikel.detail', $artikel->slug) }}" 
                                           class="btn btn-outline-primary btn-sm mt-auto">
                                            <i class="fas fa-book-open me-2"></i>Baca Selengkapnya
                                            <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $artikels->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-newspaper text-muted" style="font-size: 5rem; opacity: 0.3;"></i>
                        </div>
                        <h4 class="text-muted mb-3">Artikel Tidak Ditemukan</h4>
                        <p class="text-muted mb-4">Maaf, tidak ada artikel dalam kategori ini.</p>
                        <a href="{{ route('artikel') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Lihat Semua Artikel
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Popular Articles Widget -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-gradient text-white" 
                         style="background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));">
                        <h5 class="mb-0">
                            <i class="fas fa-fire me-2"></i>Artikel Populer
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($artikelPopuler->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($artikelPopuler as $popular)
                                    <a href="{{ route('artikel.detail', $popular->slug) }}" 
                                       class="list-group-item list-group-item-action">
                                        <div class="d-flex align-items-start">
                                            @if($popular->gambar_featured)
                                                <img src="{{ asset('storage/' . $popular->gambar_featured) }}" 
                                                     alt="{{ $popular->judul }}"
                                                     class="rounded me-3"
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="rounded me-3 bg-light d-flex align-items-center justify-content-center"
                                                     style="width: 60px; height: 60px; min-width: 60px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 small">{{ Str::limit($popular->judul, 50) }}</h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-eye me-1"></i>{{ number_format($popular->views) }} views
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 text-center text-muted">
                                <i class="fas fa-inbox mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0 small">Belum ada artikel populer</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Categories Widget -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-gradient text-white"
                         style="background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));">
                        <h5 class="mb-0">
                            <i class="fas fa-folder-open me-2"></i>Kategori
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('artikel') }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ !$kategori ? 'active' : '' }}">
                                <span><i class="fas fa-th-large me-2"></i>Semua Kategori</span>
                                <span class="badge bg-primary rounded-pill">{{ $artikels->total() }}</span>
                            </a>
                            @foreach($kategoris as $kat)
                                @php
                                    $count = \App\Models\Artikel::dipublikasi()->where('kategori', $kat)->count();
                                @endphp
                                <a href="{{ route('artikel', ['kategori' => $kat]) }}" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $kategori == $kat ? 'active' : '' }}">
                                    <span><i class="fas fa-tag me-2"></i>{{ ucfirst($kat) }}</span>
                                    <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- CTA Widget -->
                <div class="card shadow-sm text-white" 
                     style="background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-bus-alt" style="font-size: 3rem; opacity: 0.8;"></i>
                        </div>
                        <h5 class="card-title mb-3">Butuh Bantuan?</h5>
                        <p class="card-text mb-4 small">
                            Hubungi kami untuk informasi lebih lanjut tentang layanan travel kami
                        </p>
                        <a href="{{ route('kontak') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-phone me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-background"></div>
    <div class="container">
        <div class="cta-content">
            <div class="cta-icon">
                <i class="fas fa-comments"></i>
            </div>
            <h2 class="cta-title">Punya Pertanyaan?</h2>
            <p class="cta-text">
                Tim kami siap membantu Anda merencanakan perjalanan terbaik. 
                Hubungi kami sekarang untuk konsultasi gratis!
            </p>
            <div class="cta-buttons">
                <a href="https://wa.me/6281234567890" class="btn-cta-primary" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    <span>Hubungi WhatsApp</span>
                </a>
                <a href="{{ route('kontak') }}" class="btn-cta-secondary">
                    <i class="fas fa-envelope"></i>
                    <span>Kirim Pesan</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection