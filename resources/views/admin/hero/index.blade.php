@extends('admin.layouts.app')

@section('title', 'Hero Section')

@section('content')
<style>
/* Hero Alert */
.hero-alert {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    position: relative;
    animation: slideInDown 0.4s ease;
}

.hero-alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    border-left: 4px solid #28a745;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
}

.hero-alert-icon {
    width: 40px;
    height: 40px;
    background: rgba(40, 167, 69, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.hero-alert-icon i {
    font-size: 1.3rem;
    color: #28a745;
}

.hero-alert-content {
    flex: 1;
}

.hero-alert-content strong {
    display: block;
    font-size: 1rem;
    color: #155724;
    margin-bottom: 0.25rem;
}

.hero-alert-content p {
    margin: 0;
    font-size: 0.9rem;
    color: #155724;
}

.hero-alert-close {
    width: 30px;
    height: 30px;
    background: rgba(0, 0, 0, 0.05);
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.hero-alert-close:hover {
    background: rgba(0, 0, 0, 0.1);
    transform: rotate(90deg);
}

.hero-alert-close i {
    color: #155724;
    font-size: 0.9rem;
}

/* Hero Card */
.hero-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.hero-card-header {
    background: linear-gradient(135deg, #023047, #219EBC);
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.hero-card-header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.hero-card-header-left i {
    font-size: 1.5rem;
    color: white;
}

.hero-card-header-left h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
    margin: 0;
}

.hero-card-header-right {
    flex: 1;
    display: flex;
    justify-content: flex-end;
}

/* Hero Search Box */
.hero-search-box {
    position: relative;
    width: 100%;
    max-width: 350px;
}

.hero-search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255, 255, 255, 0.7);
    font-size: 1rem;
}

.hero-search-box input {
    width: 100%;
    padding: 0.7rem 1rem 0.7rem 2.75rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    color: white;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.hero-search-box input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.hero-search-box input:focus {
    outline: none;
    border-color: #FB8500;
    background: rgba(255, 255, 255, 0.25);
}

/* Hero Card Body */
.hero-card-body {
    padding: 2rem;
}

/* Hero Item */
.hero-item {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
    background: white;
}

.hero-item:last-child {
    margin-bottom: 0;
}

.hero-item:hover {
    border-color: #FB8500;
    box-shadow: 0 8px 20px rgba(251, 133, 0, 0.15);
    transform: translateY(-3px);
}

/* Hero Item Image */
.hero-item-image {
    width: 200px;
    height: 130px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    position: relative;
    background: #f8f9fa;
}

.hero-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.hero-item:hover .hero-item-image img {
    transform: scale(1.05);
}

.hero-item-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(251, 133, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.hero-item-image:hover .hero-item-overlay {
    opacity: 1;
}

.hero-item-overlay i {
    font-size: 2rem;
    color: white;
}

.hero-item-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #e9ecef, #dee2e6);
    color: #6c757d;
}

.hero-item-placeholder i {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    opacity: 0.5;
}

.hero-item-placeholder span {
    font-size: 0.85rem;
    font-weight: 500;
}

/* Hero Item Content */
.hero-item-content {
    flex: 1;
    min-width: 0;
}

.hero-item-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 0.75rem;
}

.hero-item-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #023047;
    margin: 0;
}

.hero-item-description {
    font-size: 0.9rem;
    color: #6c757d;
    line-height: 1.6;
    margin: 0 0 0.75rem 0;
}

.hero-item-meta {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.hero-meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: #495057;
}

.hero-meta-item i {
    color: #FB8500;
}

/* Hero Badge */
.hero-badge {
    padding: 0.35rem 0.85rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}

.hero-badge i {
    font-size: 0.6rem;
}

.hero-badge-success {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(32, 201, 151, 0.15));
    color: #28a745;
}

.hero-badge-secondary {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
}

/* Hero Item Actions */
.hero-item-actions {
    display: flex;
    gap: 0.5rem;
    flex-shrink: 0;
}

.hero-form-inline {
    display: inline;
}

.hero-btn {
    width: 45px;
    height: 45px;
    border: none;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.hero-btn i {
    font-size: 1.1rem;
}

.hero-btn-edit {
    background: linear-gradient(135deg, #219EBC, #8ECAE6);
    color: white;
    box-shadow: 0 3px 10px rgba(33, 158, 188, 0.3);
}

.hero-btn-edit:hover {
    background: linear-gradient(135deg, #8ECAE6, #219EBC);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(33, 158, 188, 0.5);
}

.hero-btn-delete {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
}

.hero-btn-delete:hover {
    background: linear-gradient(135deg, #c82333, #bd2130);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.5);
}

/* Hero Empty State */
.hero-empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.hero-empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #e9ecef, #dee2e6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.hero-empty-icon i {
    font-size: 3rem;
    color: #6c757d;
    opacity: 0.5;
}

.hero-empty-state h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #495057;
    margin: 0 0 0.5rem 0;
}

.hero-empty-state p {
    font-size: 1rem;
    color: #6c757d;
    margin: 0 0 2rem 0;
}

/* Responsive */
@media (max-width: 992px) {
    .hero-item {
        flex-direction: column;
        text-align: center;
    }

    .hero-item-image {
        width: 100%;
        height: 200px;
    }

    .hero-item-header {
        flex-direction: column;
        align-items: center;
    }

    .hero-item-meta {
        justify-content: center;
    }

    .hero-item-actions {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .hero-card-header {
        padding: 1rem 1.5rem;
        flex-direction: column;
        align-items: stretch;
    }

    .hero-card-header-right {
        justify-content: stretch;
    }

    .hero-search-box {
        max-width: 100%;
    }

    .hero-card-body {
        padding: 1.5rem;
    }

    .hero-item {
        padding: 1rem;
        gap: 1rem;
    }

    .hero-item-image {
        height: 180px;
    }
}

@media (max-width: 576px) {
    .hero-card-header-left {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .hero-item-meta {
        flex-direction: column;
        gap: 0.5rem;
    }

    .hero-btn {
        width: 40px;
        height: 40px;
    }
}
</style>

<!-- Header Section -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-images"></i>
        </div>
        <div>
            <h2 class="header-title">Hero Section</h2>
            <p class="header-subtitle">Kelola konten hero section website Anda</p>
        </div>
    </div>
    <div class="header-actions">
        <button class="btn-refresh" onclick="location.reload()">
            <i class="fas fa-sync-alt"></i>
            <span>Refresh</span>
        </button>
        <a href="{{ route('admin.hero.create') }}" class="btn-add">
            <i class="fas fa-plus"></i>
            <span>Tambah Hero Section</span>
        </a>
    </div>
</div>

<!-- Alert -->
@if(session('success'))
<div class="hero-alert hero-alert-success">
    <div class="hero-alert-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <div class="hero-alert-content">
        <strong>Berhasil!</strong>
        <p>{{ session('success') }}</p>
    </div>
    <button class="hero-alert-close" onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

<!-- Statistik Section -->
<div class="hero-stats-grid">
    <div class="hero-stat-card">
        <div class="hero-stat-icon hero-stat-icon-primary">
            <i class="fas fa-list"></i>
        </div>
        <div class="hero-stat-content">
            <h3 class="hero-stat-number">{{ $heroes->count() }}</h3>
            <p class="hero-stat-label">Total Hero</p>
        </div>
    </div>
    
    <div class="hero-stat-card">
        <div class="hero-stat-icon hero-stat-icon-success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="hero-stat-content">
            <h3 class="hero-stat-number">{{ $heroes->where('aktif', true)->count() }}</h3>
            <p class="hero-stat-label">Aktif</p>
        </div>
    </div>
    
    <div class="hero-stat-card">
        <div class="hero-stat-icon hero-stat-icon-secondary">
            <i class="fas fa-pause-circle"></i>
        </div>
        <div class="hero-stat-content">
            <h3 class="hero-stat-number">{{ $heroes->where('aktif', false)->count() }}</h3>
            <p class="hero-stat-label">Nonaktif</p>
        </div>
    </div>
</div>

<!-- Hero List Card -->
<div class="hero-card">
    <div class="hero-card-header">
        <div class="hero-card-header-left">
            <i class="fas fa-table"></i>
            <h3>Daftar Hero Section</h3>
        </div>
        <div class="hero-card-header-right">
            <div class="hero-search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari hero section...">
            </div>
        </div>
    </div>
    
    <div class="hero-card-body">
        @forelse($heroes as $hero)
        <div class="hero-item" data-search="{{ strtolower($hero->judul . ' ' . $hero->deskripsi) }}">
            <div class="hero-item-image">
                @if($hero->gambar)
                <img src="{{ asset('storage/' . $hero->gambar) }}" alt="{{ $hero->judul }}">
                <div class="hero-item-overlay">
                    <i class="fas fa-eye"></i>
                </div>
                @else
                <div class="hero-item-placeholder">
                    <i class="fas fa-image"></i>
                    <span>No Image</span>
                </div>
                @endif
            </div>
            
            <div class="hero-item-content">
                <div class="hero-item-header">
                    <h4 class="hero-item-title">{{ $hero->judul }}</h4>
                    <span class="hero-badge hero-badge-{{ $hero->aktif ? 'success' : 'secondary' }}">
                        <i class="fas fa-circle"></i>
                        {{ $hero->aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                
                <p class="hero-item-description">{{ Str::limit($hero->deskripsi, 100) }}</p>
                
                <div class="hero-item-meta">
                    <div class="hero-meta-item">
                        <i class="fas fa-sort-amount-up"></i>
                        <span>Urutan: <strong>{{ $hero->urutan }}</strong></span>
                    </div>
                    <div class="hero-meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $hero->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="hero-item-actions">
                <a href="{{ route('admin.hero.edit', $hero) }}" class="hero-btn hero-btn-edit" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.hero.destroy', $hero) }}" 
                      method="POST" 
                      class="hero-form-inline"
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="hero-btn hero-btn-delete" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="hero-empty-state">
            <div class="hero-empty-icon">
                <i class="fas fa-images"></i>
            </div>
            <h3>Belum Ada Hero Section</h3>
            <p>Mulai tambahkan hero section untuk website Anda</p>
            <a href="{{ route('admin.hero.create') }}" class="btn-hero-add">
                <i class="fas fa-plus"></i>
                <span>Tambah Hero Section</span>
            </a>
        </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete konfirmasi
        const deleteForms = document.querySelectorAll('.hero-form-inline');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data user akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
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

// Fungsi Untuk pencarian
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const heroItems = document.querySelectorAll('.hero-item');
    
    heroItems.forEach(item => {
        const searchData = item.getAttribute('data-search');
        if (searchData.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
@endsection
