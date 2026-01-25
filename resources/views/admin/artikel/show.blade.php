@extends('admin.layouts.app')

@section('title', 'Detail Artikel')

@section('content')
<style>
    .page-header-custom {
        margin-bottom: 2rem;
    }
    
    .page-header-custom h2 {
        color: var(--blue-dark);
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .page-header-custom p {
        color: #6c757d;
        margin-bottom: 0;
    }
    
    .badge-published {
        background: linear-gradient(135deg, #28a745, #20c997);
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .badge-draft {
        background: linear-gradient(135deg, #ffc107, #ffb700);
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        color: #000;
    }
    
    .badge-category {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .article-title {
        color: var(--blue-dark);
        font-weight: 700;
        line-height: 1.3;
    }
    
    .meta-info {
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .author-avatar {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .author-avatar i {
        color: white;
        font-size: 0.9rem;
    }
    
    .slug-alert {
        border-left: 4px solid var(--blue-light);
        background: #f8f9fa;
    }
    
    .card-custom {
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: none;
        margin-bottom: 1.5rem;
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 1rem 1.5rem;
    }
    
    .card-header-custom h5 {
        margin: 0;
        font-weight: 600;
    }
    
    .featured-image {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 0 0 12px 12px;
    }
    
    .excerpt-text {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #495057;
        font-style: italic;
        margin: 0;
    }
    
    .content-text {
        font-size: 1rem;
        line-height: 1.8;
        color: #212529;
    }
    
    .badge-tag {
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .stat-row {
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .stat-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }
    
    .stat-label {
        color: #6c757d;
    }
    
    .stat-value {
        color: var(--blue-dark);
        font-weight: 600;
    }
    
    .author-info-avatar {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(33, 158, 188, 0.3);
    }
    
    .author-info-avatar i {
        color: white;
        font-size: 1.8rem;
    }
    
    .author-name {
        color: var(--blue-dark);
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .btn-custom {
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center page-header-custom">
        <div>
            <h2>Detail Artikel</h2>
            <p>Informasi lengkap artikel</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.artikel.edit', $artikel) }}" class="btn btn-primary btn-custom">
                <i class="fas fa-edit me-2"></i>Edit Artikel
            </a>
            <a href="{{ route('admin.artikel.index') }}" class="btn btn-outline-primary btn-custom">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Article Header Card -->
            <div class="card card-custom">
                <div class="card-body">
                    <!-- Status Badge -->
                    <div class="mb-3">
                        @if($artikel->dipublikasi)
                        <span class="badge badge-published">
                            <i class="fas fa-check-circle me-1"></i>Published
                        </span>
                        @else
                        <span class="badge badge-draft">
                            <i class="fas fa-clock me-1"></i>Draft
                        </span>
                        @endif

                        @if($artikel->kategori)
                        <span class="badge badge-category ms-2">
                            <i class="fas fa-folder me-1"></i>{{ $artikel->kategori }}
                        </span>
                        @endif
                    </div>

                    <!-- Title -->
                    <h1 class="mb-3 article-title">
                        {{ $artikel->judul }}
                    </h1>

                    <!-- Meta Info -->
                    <div class="d-flex flex-wrap gap-3 mb-4 meta-info">
                        <div class="d-flex align-items-center gap-2">
                            <div class="author-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <span><strong>{{ $artikel->user->name ?? 'Unknown' }}</strong></span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i class="far fa-calendar"></i>
                            <span>{{ $artikel->tanggal_publikasi ? $artikel->tanggal_publikasi->format('d F Y') : $artikel->created_at->format('d F Y') }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <i class="far fa-clock"></i>
                            <span>{{ $artikel->created_at->format('H:i') }} WIB</span>
                        </div>
                    </div>

                    <!-- Slug -->
                    <div class="alert slug-alert">
                        <small>
                            <i class="fas fa-link me-1"></i>
                            <strong>URL Slug:</strong> <code>{{ $artikel->slug }}</code>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            @if($artikel->gambar_featured)
            <div class="card card-custom">
                <div class="card-header card-header-custom">
                    <h5><i class="fas fa-image me-2"></i>Gambar Featured</h5>
                </div>
                <div class="card-body p-0">
                    <img src="{{ asset('storage/' . $artikel->gambar_featured) }}" 
                         alt="{{ $artikel->judul }}"
                         class="featured-image">
                </div>
            </div>
            @endif

            <!-- Excerpt -->
            @if($artikel->excerpt)
            <div class="card card-custom">
                <div class="card-header card-header-custom">
                    <h5><i class="fas fa-quote-left me-2"></i>Excerpt</h5>
                </div>
                <div class="card-body">
                    <p class="excerpt-text">
                        {{ $artikel->excerpt }}
                    </p>
                </div>
            </div>
            @endif

            <!-- Content -->
            <div class="card card-custom">
                <div class="card-header card-header-custom">
                    <h5><i class="fas fa-file-alt me-2"></i>Konten Artikel</h5>
                </div>
                <div class="card-body">
                    <div class="content-text">
                        {!! nl2br(e($artikel->konten)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card card-custom">
                <div class="card-header card-header-custom">
                    <h5><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.artikel.edit', $artikel) }}" class="btn btn-primary btn-custom">
                            <i class="fas fa-edit me-2"></i>Edit Artikel
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-custom" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>Hapus Artikel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            @if($artikel->tags && count($artikel->tags) > 0)
            <div class="card card-custom">
                <div class="card-header card-header-custom">
                    <h5><i class="fas fa-tags me-2"></i>Tags</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($artikel->tags as $tag)
                        <span class="badge badge-tag">
                            #{{ trim($tag) }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Statistics -->
            <div class="card card-custom">
                <div class="card-header card-header-custom">
                    <h5><i class="fas fa-chart-bar me-2"></i>Statistik</h5>
                </div>
                <div class="card-body">
                    <div class="stat-row">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="stat-label">
                                <i class="fas fa-font me-2"></i>Jumlah Karakter
                            </span>
                            <strong class="stat-value">{{ strlen($artikel->konten) }}</strong>
                        </div>
                    </div>
                    <div class="stat-row">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="stat-label">
                                <i class="fas fa-align-left me-2"></i>Jumlah Kata
                            </span>
                            <strong class="stat-value">{{ str_word_count($artikel->konten) }}</strong>
                        </div>
                    </div>
                    <div class="stat-row">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="stat-label">
                                <i class="far fa-clock me-2"></i>Estimasi Baca
                            </span>
                            <strong class="stat-value">{{ ceil(str_word_count($artikel->konten) / 200) }} menit</strong>
                        </div>
                    </div>
                    <div class="stat-row">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="stat-label">
                                <i class="fas fa-image me-2"></i>Gambar Featured
                            </span>
                            <strong class="stat-value">
                                @if($artikel->gambar_featured)
                                <span class="text-success"><i class="fas fa-check-circle"></i> Ada</span>
                                @else
                                <span class="text-danger"><i class="fas fa-times-circle"></i> Tidak</span>
                                @endif
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Publication Info -->
            <div class="card card-custom">
                <div class="card-header card-header-custom">
                    <h5><i class="fas fa-info-circle me-2"></i>Informasi Publikasi</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Dibuat</small>
                        <strong class="stat-value">
                            <i class="far fa-calendar-plus me-1"></i>
                            {{ $artikel->created_at->format('d F Y, H:i') }} WIB
                        </strong>
                        <div class="text-muted small mt-1">
                            ({{ $artikel->created_at->diffForHumans() }})
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Terakhir Diupdate</small>
                        <strong class="stat-value">
                            <i class="far fa-calendar-check me-1"></i>
                            {{ $artikel->updated_at->format('d F Y, H:i') }} WIB
                        </strong>
                        <div class="text-muted small mt-1">
                            ({{ $artikel->updated_at->diffForHumans() }})
                        </div>
                    </div>

                    @if($artikel->tanggal_publikasi)
                    <div>
                        <small class="text-muted d-block mb-1">Tanggal Publikasi</small>
                        <strong class="stat-value">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ $artikel->tanggal_publikasi->format('d F Y') }}
                        </strong>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Author Info -->
            <div class="card card-custom">
                <div class="card-header card-header-custom">
                    <h5><i class="fas fa-user-edit me-2"></i>Informasi Penulis</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="author-info-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="author-name">{{ $artikel->user->name ?? 'Unknown' }}</h6>
                            <small class="text-muted">{{ $artikel->user->email ?? '-' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="delete-form" action="{{ route('admin.artikel.destroy', $artikel) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection