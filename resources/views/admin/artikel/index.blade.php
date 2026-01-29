@extends('admin.layouts.app')

@section('title', 'Manajemen Artikel')

@section('content')
<style>
    .artikel-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .artikel-placeholder {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .artikel-title {
        color: var(--blue-dark);
        font-weight: 600;
        margin-bottom: 0.25rem;
        line-height: 1.3;
    }
    
    .artikel-excerpt {
        color: #6c757d;
        font-size: 0.85rem;
        line-height: 1.4;
    }
    
    .category-badge {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
        border-radius: 6px;
        font-weight: 500;
    }
    
    .author-avatar {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .status-published {
        background: linear-gradient(135deg, #28a745, #20c997);
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-draft {
        background: linear-gradient(135deg, #ffc107, #ffb700);
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        color: #000;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }
    
    .empty-state i {
        font-size: 3rem;
        color: var(--blue-light);
        opacity: 0.5;
        margin-bottom: 1rem;
    }
    
    .btn-action-group {
        display: flex;
        gap: 0.25rem;
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.3s ease;
        border: 1px solid;
    }
    
    .btn-view {
        border-color: var(--blue-light);
        color: var(--blue-light);
        background: transparent;
    }
    
    .btn-view:hover {
        background: var(--blue-light);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-edit {
        border-color: var(--orange-primary);
        color: var(--orange-primary);
        background: transparent;
    }
    
    .btn-edit:hover {
        background: var(--orange-primary);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-delete {
        border-color: #dc3545;
        color: #dc3545;
        background: transparent;
    }
    
    .btn-delete:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
    }
</style>

<div class="container-fluid">
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Header Section -->
    <div class="gradient-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <h2 class="header-title">Manajemen Artikel</h2>
                <p class="header-subtitle">Kelola Artikel Website</p>
            </div>
        </div>
        <div class="header-actions">
            <button class="btn-refresh" onclick="location.reload()">
                <i class="fas fa-sync-alt"></i>
                <span>Refresh</span>
            </button>
            <a href="{{ route('admin.artikel.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                <span>Tambah Artikel</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-primary">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $artikel->count() }}</h3>
                    <p class="stat-label">Total Artikel</p>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $artikel->where('dipublikasi', true)->count() }}</h3>
                    <p class="stat-label">Dipublikasi</p>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-warning">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $artikel->where('dipublikasi', false)->count() }}</h3>
                    <p class="stat-label">Draft</p>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-info">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $artikel->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                    <p class="stat-label">Bulan Ini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- artikels Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Daftar Artikel
                </h5>
                <div class="input-group" style="max-width: 300px;">
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari artikel...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="artikelTable">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 10%;">Gambar</th>
                            <th style="width: 25%;">Judul</th>
                            <th style="width: 12%;">Kategori</th>
                            <th style="width: 12%;">Penulis</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 13%;">Tanggal</th>
                            <th style="width: 13%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($artikel as $index => $item)
                        <tr>
                            <td class="align-middle">{{ $index + 1 }}</td>
                            <td class="align-middle">
                                @if($item->gambar_featured)
                                <img src="{{ asset('storage/' . $item->gambar_featured) }}" 
                                     alt="{{ $item->judul }}" 
                                     class="artikel-thumbnail">
                                @else
                                <div class="artikel-placeholder">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div>
                                    <div class="artikel-title">{{ Str::limit($item->judul, 50) }}</div>
                                    @if($item->excerpt)
                                    <div class="artikel-excerpt">{{ Str::limit($item->excerpt, 60) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle">
                                @if($item->kategori)
                                <span class="badge category-badge">
                                    {{ $item->kategori }}
                                </span>
                                @else
                                <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="author-avatar">
                                        <i class="fas fa-user" style="color: white; font-size: 0.8rem;"></i>
                                    </div>
                                    <span class="small">{{ $item->user->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="align-middle">
                                @if($item->dipublikasi)
                                <span class="badge status-published">
                                    <i class="fas fa-check-circle me-1"></i>Published
                                </span>
                                @else
                                <span class="badge status-draft">
                                    <i class="fas fa-clock me-1"></i>Draft
                                </span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <small class="text-muted">
                                    <i class="far fa-calendar me-1"></i>
                                    {{ $item->tanggal_publikasi ? $item->tanggal_publikasi->format('d M Y') : $item->created_at->format('d M Y') }}
                                </small>
                            </td>
                            <td class="align-middle">
                                <div class="btn-action-group justify-content-center">
                                    <a href="{{ route('admin.artikel.show', $item) }}" 
                                       class="btn btn-action btn-view" 
                                       title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.artikel.edit', $item) }}" 
                                       class="btn btn-action btn-edit" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-action btn-delete" 
                                            onclick="confirmDelete({{ $item->id }})"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $item->id }}" 
                                      action="{{ route('admin.artikel.destroy', $item) }}" 
                                      method="POST" 
                                      class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-newspaper"></i>
                                    <p class="text-muted mb-3">Belum ada artikel</p>
                                    <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Tambah Artikel Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#artikelTable tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

// Delete confirmation
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// Auto hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>
@endsection