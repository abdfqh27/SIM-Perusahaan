@extends('frontend.layouts.app')

@section('title', $artikel->judul . ' - Travel Kami')

@section('meta_description', Str::limit(strip_tags($artikel->konten), 160))

@push('styles')
<style>
/* Article Content Styling */
.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4,
.article-content h5,
.article-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: var(--blue-dark);
    font-weight: 600;
}

.article-content p {
    margin-bottom: 1.5rem;
    text-align: justify;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 2rem 0;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.article-content ul,
.article-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

.article-content blockquote {
    border-left: 4px solid var(--orange-primary);
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #666;
    background: #f8f9fa;
    padding: 1rem 1.5rem;
    border-radius: 5px;
}

.article-content a {
    color: var(--orange-primary);
    text-decoration: underline;
}

.article-content a:hover {
    color: var(--orange-secondary);
}

.article-content code {
    background: #f8f9fa;
    padding: 0.2rem 0.5rem;
    border-radius: 3px;
    font-size: 0.9em;
    color: #e83e8c;
}

.article-content pre {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 5px;
    overflow-x: auto;
    margin: 1.5rem 0;
}

.article-content table {
    width: 100%;
    margin: 1.5rem 0;
    border-collapse: collapse;
}

.article-content table th,
.article-content table td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}

.article-content table th {
    background: var(--blue-dark);
    color: white;
    font-weight: 600;
}

/* Article Meta */
.article-meta {
    font-size: 0.95rem;
    color: #666;
}

/* Social Share Buttons */
.social-share .btn {
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.social-share .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Related Articles */
.article-card {
    transition: all 0.3s ease;
}

.article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.article-image {
    transition: transform 0.5s ease;
}

.article-card:hover .article-image {
    transform: scale(1.1);
}

.card-title a:hover {
    color: var(--orange-primary) !important;
}

/* Featured Image */
.article-featured-image {
    position: relative;
    overflow: hidden;
}

.article-featured-image::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100px;
    background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
}

/* Responsive */
@media (max-width: 768px) {
    .article-content {
        font-size: 1rem;
    }
    
    .article-meta {
        font-size: 0.85rem;
    }
    
    .social-share {
        justify-content: center;
    }
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="min-height: 300px;">
    <div class="hero-overlay"></div>
    
    <!-- Hero Decorations -->
    <div class="hero-decoration">
        <div class="decoration-circle circle-1"></div>
        <div class="decoration-circle circle-2"></div>
    </div>
    
    <div class="container">
        <div class="hero-content animate-fade-in">
            <div class="mb-3">
                <span class="badge bg-orange-primary px-3 py-2">
                    <i class="fas fa-tag me-2"></i>{{ ucfirst($artikel->kategori) }}
                </span>
            </div>
            <h1 class="hero-title" style="font-size: 2.5rem;">{{ $artikel->judul }}</h1>
            
            <!-- Breadcrumb -->
            <div class="hero-breadcrumb">
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i>
                    <span>Beranda</span>
                </a>
                <span><i class="fas fa-chevron-right"></i></span>
                <a href="{{ route('artikel') }}">
                    <span>Artikel</span>
                </a>
                <span><i class="fas fa-chevron-right"></i></span>
                <span>{{ Str::limit($artikel->judul, 30) }}</span>
            </div>
        </div>
    </div>
    
    <!-- Wave Effect -->
    <div class="hero-wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
</section>

<!-- Article Detail Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Article Card -->
                <div class="card shadow-sm mb-4">
                    <!-- Article Image -->
                    @if($artikel->gambar_featured)
                        <div class="article-featured-image">
                            <img src="{{ asset('storage/' . $artikel->gambar_featured) }}" 
                                 class="card-img-top" 
                                 alt="{{ $artikel->judul }}"
                                 style="width: 100%; height: 400px; object-fit: cover;">
                        </div>
                    @endif
                    
                    <div class="card-body p-4 p-md-5">
                        <!-- Article Meta -->
                        <div class="article-meta d-flex flex-wrap align-items-center mb-4 pb-4 border-bottom">
                            <div class="me-4 mb-2">
                                <i class="fas fa-user text-orange-primary me-2"></i>
                                <span class="fw-semibold">{{ $artikel->user->name }}</span>
                            </div>
                            <div class="me-4 mb-2">
                                <i class="fas fa-calendar text-orange-primary me-2"></i>
                                <span>{{ $artikel->created_at->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="me-4 mb-2">
                                <i class="fas fa-clock text-orange-primary me-2"></i>
                                <span>{{ ceil(str_word_count(strip_tags($artikel->konten)) / 200) }} menit baca</span>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-eye text-orange-primary me-2"></i>
                                <span>{{ number_format($artikel->views) }} views</span>
                            </div>
                        </div>
                        
                        <!-- Article Content -->
                        <div class="article-content">
                            {!! $artikel->konten !!}
                        </div>
                        
                        <!-- Article Tags/Category -->
                        <div class="mt-5 pt-4 border-top">
                            <div class="d-flex flex-wrap align-items-center">
                                <span class="text-muted me-3 mb-2">
                                    <i class="fas fa-tags me-2"></i>Kategori:
                                </span>
                                <a href="{{ route('artikel', ['kategori' => $artikel->kategori]) }}" 
                                   class="badge bg-orange-primary text-white text-decoration-none px-3 py-2 mb-2">
                                    {{ ucfirst($artikel->kategori) }}
                                </a>
                            </div>
                        </div>
                        
                        <!-- Share Buttons -->
                        <div class="mt-4 pt-4 border-top">
                            <div class="d-flex flex-wrap align-items-center">
                                <span class="text-muted me-3 mb-2">
                                    <i class="fas fa-share-alt me-2"></i>Bagikan:
                                </span>
                                <div class="social-share d-flex gap-2">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('artikel.detail', $artikel->slug)) }}" 
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary mb-2"
                                       title="Bagikan ke Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('artikel.detail', $artikel->slug)) }}&text={{ urlencode($artikel->judul) }}" 
                                       target="_blank"
                                       class="btn btn-sm btn-outline-info mb-2"
                                       title="Bagikan ke Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($artikel->judul . ' - ' . route('artikel.detail', $artikel->slug)) }}" 
                                       target="_blank"
                                       class="btn btn-sm btn-outline-success mb-2"
                                       title="Bagikan ke WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('artikel.detail', $artikel->slug)) }}" 
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary mb-2"
                                       title="Bagikan ke LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-secondary mb-2"
                                            onclick="copyToClipboard('{{ route('artikel.detail', $artikel->slug) }}')"
                                            title="Salin Link">
                                        <i class="fas fa-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Author Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="author-avatar me-3">
                                <div class="rounded-circle bg-gradient d-flex align-items-center justify-content-center text-white"
                                     style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $artikel->user->name }}</h5>
                                <p class="text-muted mb-0 small">
                                    <i class="fas fa-pen me-1"></i>Penulis
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation -->
                <div class="d-flex justify-content-between mb-4">
                    <a href="{{ route('artikel') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Artikel
                    </a>
                </div>
                
                <!-- Related Articles -->
                @if($artikelTerkait->count() > 0)
                    <div class="related-articles mt-5">
                        <h3 class="mb-4">
                            <i class="fas fa-newspaper text-orange-primary me-2"></i>
                            Artikel Terkait
                        </h3>
                        <div class="row g-4">
                            @foreach($artikelTerkait as $related)
                                <div class="col-md-4">
                                    <div class="card h-100 article-card">
                                        @if($related->gambar_featured)
                                            <div class="article-image-wrapper overflow-hidden">
                                                <img src="{{ asset('storage/' . $related->gambar_featured) }}" 
                                                     class="card-img-top article-image" 
                                                     alt="{{ $related->judul }}"
                                                     style="height: 200px; object-fit: cover;">
                                            </div>
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                 style="height: 200px;">
                                                <i class="fas fa-image text-muted fa-3x"></i>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <span class="badge bg-orange-primary mb-2">
                                                {{ ucfirst($related->kategori) }}
                                            </span>
                                            <h6 class="card-title">
                                                <a href="{{ route('artikel.detail', $related->slug) }}" 
                                                   class="text-decoration-none text-blue-dark">
                                                    {{ Str::limit($related->judul, 50) }}
                                                </a>
                                            </h6>
                                            <div class="text-muted small">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $related->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Search Widget -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-search text-orange-primary me-2"></i>Cari Artikel
                        </h5>
                        <form action="{{ route('artikel') }}" method="GET">
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control" 
                                       name="search" 
                                       placeholder="Cari artikel..."
                                       value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Latest Articles Widget -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white"
                         style="background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));">
                        <h5 class="mb-0">
                            <i class="fas fa-clock me-2"></i>Artikel Terbaru
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @php
                            $latestArticles = \App\Models\Artikel::dipublikasi()
                                ->where('id', '!=', $artikel->id)
                                ->latest()
                                ->take(5)
                                ->get();
                        @endphp
                        
                        @if($latestArticles->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($latestArticles as $latest)
                                    <a href="{{ route('artikel.detail', $latest->slug) }}" 
                                       class="list-group-item list-group-item-action">
                                        <div class="d-flex align-items-start">
                                            @if($latest->gambar_featured)
                                                <img src="{{ asset('storage/' . $latest->gambar_featured) }}" 
                                                     alt="{{ $latest->judul }}"
                                                     class="rounded me-3"
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="rounded me-3 bg-light d-flex align-items-center justify-content-center"
                                                     style="width: 60px; height: 60px; min-width: 60px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 small">{{ Str::limit($latest->judul, 50) }}</h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $latest->created_at->format('d M Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- CTA Widget -->
                <div class="card shadow-sm text-white mb-4"
                     style="background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-bus-alt" style="font-size: 3rem; opacity: 0.9;"></i>
                        </div>
                        <h5 class="card-title mb-3">Butuh Travel?</h5>
                        <p class="card-text mb-4 small">
                            Pesan travel sekarang dan nikmati perjalanan nyaman bersama kami
                        </p>
                        <a href="{{ route('kontak') }}" class="btn btn-light">
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
                <i class="fas fa-newspaper"></i>
            </div>
            <h2 class="cta-title">Jangan Lewatkan Artikel Menarik Lainnya</h2>
            <p class="cta-text">
                Dapatkan informasi terbaru seputar travel, tips perjalanan, 
                dan destinasi wisata menarik lainnya
            </p>
            <div class="cta-buttons">
                <a href="{{ route('artikel') }}" class="btn-cta-primary">
                    <i class="fas fa-book-open"></i>
                    <span>Lihat Semua Artikel</span>
                </a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Link berhasil disalin!');
    }, function(err) {
        console.error('Gagal menyalin link: ', err);
    });
}
</script>
@endpush
@endsection