@extends('admin.layouts.app')

@section('title', 'Manajemen Galeri')

@section('content')
<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .gallery-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
    }

    .gallery-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(251, 133, 0, 0.2);
    }

    .gallery-card.inactive {
        opacity: 0.6;
    }

    .gallery-card.inactive::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        pointer-events: none;
    }

    .gallery-image {
        position: relative;
        height: 250px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .gallery-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-card:hover .gallery-image img {
        transform: scale(1.1);
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.7));
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gallery-card:hover .image-overlay {
        opacity: 1;
    }

    .overlay-actions {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 1.1rem;
    }

    .action-btn.view {
        background: linear-gradient(135deg, #219EBC, #8ECAE6);
    }

    .action-btn.edit {
        background: linear-gradient(135deg, #ffc107, #ff9800);
    }

    .action-btn.delete {
        background: linear-gradient(135deg, #dc3545, #c82333);
    }

    .action-btn:hover {
        transform: scale(1.1);
    }

    .category-badge, .status-badge {
        position: absolute;
        top: 1rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 10;
    }

    .category-badge {
        left: 1rem;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
    }

    .status-badge.inactive-badge {
        right: 1rem;
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .gallery-content {
        padding: 1.25rem;
    }

    .gallery-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .gallery-description {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .gallery-meta {
        display: flex;
        justify-content: space-between;
        padding-top: 0.75rem;
        border-top: 1px solid #e9ecef;
    }

    .meta-item {
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .gallery-actions {
        display: flex;
        gap: 0.5rem;
        padding: 1rem 1.25rem;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    .btn-action {
        flex: 1;
        padding: 0.6rem 1rem;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn-action.btn-edit {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
    }

    .btn-action.btn-delete {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .empty-state i {
        font-size: 5rem;
        color: #e9ecef;
        margin-bottom: 1.5rem;
    }

    .empty-state h4 {
        color: var(--blue-dark);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #6c757d;
        margin-bottom: 2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .gallery-grid {
            grid-template-columns: 1fr;
        }

        .gallery-image {
            height: 200px;
        }
    }
</style>
<!-- Gradient Header -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-images"></i>
        </div>
        <div>
            <h2 class="header-title">Manajemen Gallery</h2>
            <p class="header-subtitle">Kelola Foto dan Dokumentasi Perusahaan</p>
        </div>
    </div>
    <div class="header-actions">
        <button class="btn-refresh" onclick="location.reload()">
            <i class="fas fa-sync-alt"></i>
            <span>Refresh</span>
        </button>
        <a href="{{ route('admin.gallery.create') }}" class="btn-add">
            <i class="fas fa-plus"></i>
            <span>Tambah Gallery</span>
        </a>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i>
    <span>{{ session('error') }}</span>
</div>
@endif

<!-- Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-primary">
                <i class="fas fa-images"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $galleries->count() }}</h3>
                <p class="stat-label">Total Gallery</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-success">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $galleries->where('tampilkan', true)->count() }}</h3>
                <p class="stat-label">Ditampilkan</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-warning">
                <i class="fas fa-eye-slash"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $galleries->where('tampilkan', false)->count() }}</h3>
                <p class="stat-label">Disembunyikan</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-info">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $galleries->pluck('kategori')->filter()->unique()->count() }}</h3>
                <p class="stat-label">Kategori</p>
            </div>
        </div>
    </div>
</div>

<!-- Gallery Grid -->
@if($galleries->isEmpty())
<div class="empty-state">
    <i class="fas fa-images"></i>
    <h4>Belum Ada Gallery</h4>
    <p>Mulai tambahkan foto ke gallery Anda</p>
    <a href="{{ route('admin.gallery.create') }}" class="btn-primary">
        <i class="fas fa-plus me-2"></i>
        Tambah Gallery Pertama
    </a>
</div>
@else
<div class="gallery-grid">
    @foreach($galleries as $gallery)
    <div class="gallery-card {{ $gallery->tampilkan ? '' : 'inactive' }}">
        <!-- Image -->
        <div class="gallery-image">
            <img src="{{ asset('storage/' . $gallery->gambar) }}" alt="{{ $gallery->judul }}">
            <div class="image-overlay">
                <div class="overlay-actions">
                    <a href="{{ route('admin.gallery.show', $gallery) }}" class="action-btn view" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.gallery.edit', $gallery) }}" class="action-btn edit" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" 
                            class="action-btn delete" 
                            data-id="{{ $gallery->id }}" 
                            data-name="{{ $gallery->judul }}"
                            title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            @if($gallery->kategori)
            <span class="category-badge">{{ $gallery->kategori_label }}</span>
            @endif
            @if(!$gallery->tampilkan)
            <span class="status-badge inactive-badge">Tidak Aktif</span>
            @endif
        </div>

        <!-- Content -->
        <div class="gallery-content">
            <h3 class="gallery-title">{{ $gallery->judul }}</h3>
            @if($gallery->deskripsi)
            <p class="gallery-description">{{ Str::limit($gallery->deskripsi, 80) }}</p>
            @endif
            <div class="gallery-meta">
                <span class="meta-item">
                    <i class="fas fa-sort-numeric-down"></i>
                    Urutan: {{ $gallery->urutan }}
                </span>
                <span class="meta-item">
                    <i class="fas fa-{{ $gallery->tampilkan ? 'eye' : 'eye-slash' }}"></i>
                    {{ $gallery->tampilkan ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>
        </div>

        <!-- Actions -->
        <div class="gallery-actions">
            <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn-action btn-edit">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
            <button type="button" 
                    class="btn-action btn-delete" 
                    data-id="{{ $gallery->id }}" 
                    data-name="{{ $gallery->judul }}">
                <i class="fas fa-trash"></i>
                <span>Hapus</span>
            </button>
        </div>
    </div>
    @endforeach
</div>
@endif

<!-- Hidden Form untuk Delete -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete confirmation
    const deleteButtons = document.querySelectorAll('.btn-action.btn-delete, .action-btn.delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            const galleryId = this.getAttribute('data-id');
            const galleryName = this.getAttribute('data-name');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Gallery <strong>${galleryName}</strong> akan dihapus permanen beserta gambarnya!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menghapus...',
                        html: 'Sedang menghapus gallery dan gambarnya',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit form
                    const form = document.getElementById('deleteForm');
                    form.action = `/admin/gallery/${galleryId}`;
                    form.submit();
                }
            });
            
            return false;
        }, true); // Use capture phase
    });
    
    // Auto hide alerts
    const alerts = document.querySelectorAll('.alert-success, .alert-danger');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});
</script>
@endpush