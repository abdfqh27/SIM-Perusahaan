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
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .empty-state .empty-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
    }

    .empty-state h3 {
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        background: white;
        border-radius: 15px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        animation: slideInDown 0.3s ease;
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .modal-header h3 {
        margin: 0;
        color: var(--blue-dark);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-header h3 i {
        color: #dc3545;
        font-size: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-body p {
        margin-bottom: 0.75rem;
        color: #495057;
    }

    .warning-text {
        color: #dc3545;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        border-radius: 0 0 15px 15px;
    }

    .btn-cancel {
        background: #6c757d;
        border: none;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    .btn-delete-confirm {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-delete-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.5);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideOutUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-50px);
        }
    }

    @media (max-width: 768px) {
        .gallery-grid {
            grid-template-columns: 1fr;
        }

        .gallery-image {
            height: 200px;
        }

        .modal-content {
            width: 95%;
            margin: 1rem;
        }
    }
</style>
<div class="page-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-images"></i>
        </div>
        <div>
            <h2 class="page-title">Manajemen Galeri</h2>
            <p class="page-subtitle">Kelola foto dan dokumentasi perusahaan</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.gallery.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Galeri</span>
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i>
    <span>{{ session('error') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-primary">
                <i class="fas fa-images"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $galleries->count() }}</h3>
                <p class="stat-label">Total Galeri</p>
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
                <p class="stat-label">Aktif Ditampilkan</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-info">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $galleries->pluck('kategori')->unique()->count() }}</h3>
                <p class="stat-label">Kategori</p>
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
                <p class="stat-label">Tidak Aktif</p>
            </div>
        </div>
    </div>
</div>

<!-- Gallery Grid -->
@if($galleries->isEmpty())
<div class="empty-state">
    <div class="empty-icon">
        <i class="fas fa-images"></i>
    </div>
    <h3>Belum Ada Galeri</h3>
    <p>Mulai tambahkan foto dan dokumentasi perusahaan Anda</p>
    <a href="{{ route('admin.gallery.create') }}" class="btn-primary">
        <i class="fas fa-plus-circle"></i>
        <span>Tambah Galeri Pertama</span>
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
                    <a href="{{ route('admin.gallery.show', $gallery->id) }}" class="action-btn view" title="Lihat Detail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="action-btn edit" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="action-btn delete" title="Hapus" onclick="confirmDelete({{ $gallery->id }})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            @if($gallery->kategori)
            <span class="category-badge">{{ $gallery->kategori }}</span>
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
            <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn-action btn-edit">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
            <button type="button" class="btn-action btn-delete" onclick="confirmDelete({{ $gallery->id }})">
                <i class="fas fa-trash"></i>
                <span>Hapus</span>
            </button>
        </div>
    </div>
    @endforeach
</div>
@endif

<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>
                <i class="fas fa-exclamation-triangle"></i>
                Konfirmasi Hapus
            </h3>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus galeri ini?</p>
            <p class="warning-text">Data yang dihapus tidak dapat dikembalikan!</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete-confirm">
                    <i class="fas fa-trash"></i>
                    <span>Ya, Hapus</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(galleryId) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = `/admin/gallery/${galleryId}`;
    modal.style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        closeDeleteModal();
    }
}

// Auto hide alerts after 5 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>
@endsection