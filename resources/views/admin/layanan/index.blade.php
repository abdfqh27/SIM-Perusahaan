@extends('admin.layouts.app')

@section('title', 'Kelola Layanan')

@section('content')
<style>
    .layanans-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .layanan-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .layanan-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(251, 133, 0, 0.2);
    }

    .layanan-image {
        position: relative;
        height: 220px;
        overflow: hidden;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .layanan-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .layanan-card:hover .layanan-image img {
        transform: scale(1.1);
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
        color: white;
        font-size: 4rem;
        opacity: 0.3;
    }

    .layanan-badges {
        position: absolute;
        top: 1rem;
        left: 1rem;
        right: 1rem;
        display: flex;
        justify-content: space-between;
        z-index: 10;
    }

    .badge {
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .badge-featured {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
    }

    .badge-active {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .badge-inactive {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }

    .layanan-order {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .layanan-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .layanan-icon-name {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .layanan-icon-display {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(251, 133, 0, 0.3);
    }

    .layanan-icon-name h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--blue-dark);
        line-height: 1.3;
    }

    .layanan-description {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 1rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .layanan-fasilitas {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--blue-light);
        font-size: 0.9rem;
        font-weight: 500;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e9ecef;
    }

    .layanan-actions {
        display: grid;
        grid-template-columns: 1fr 1fr 50px;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    .btn-action {
        height: 45px;
        border: none;
        border-radius: 10px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-action i {
        font-size: 1.1rem;
    }

    .btn-action.btn-view {
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    }

    .btn-action.btn-edit {
        background: linear-gradient(135deg, #ffc107, #ff9800);
    }

    .btn-action.btn-delete {
        background: linear-gradient(135deg, #dc3545, #c82333);
        width: 50px;
    }

    .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .d-inline {
        display: inline;
        width: 100%;
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
        color: var(--orange-primary);
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }

    .empty-state h3 {
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
        font-size: 1.5rem;
    }

    .empty-state p {
        color: #6c757d;
        margin-bottom: 2rem;
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .layanans-grid {
            grid-template-columns: 1fr;
        }

        .layanan-image {
            height: 180px;
        }

        .layanan-icon-display {
            width: 45px;
            height: 45px;
            font-size: 1.4rem;
        }

        .layanan-icon-name h3 {
            font-size: 1rem;
        }

        .layanan-badges {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .layanan-actions {
            grid-template-columns: 1fr;
        }

        .btn-action.btn-delete {
            width: 100%;
        }
    }

    @keyframes slideOutUp {
        from { opacity: 1; transform: translateY(0); }
        to   { opacity: 0; transform: translateY(-20px); }
    }
</style>

<!-- Header Section -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-concierge-bell"></i>
        </div>
        <div>
            <h2 class="header-title">Kelola Layanan</h2>
            <p class="header-subtitle">Kelola Daftar Layanan Perusahaan</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.layanan.create') }}" class="btn-add">
            <i class="fas fa-plus"></i>
            <span>Tambah Layanan</span>
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

<!-- Statistik Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-primary">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $layanans->count() }}</h3>
                <p class="stat-label">Total Layanan</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $layanans->where('aktif', true)->count() }}</h3>
                <p class="stat-label">Layanan Aktif</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-warning">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $layanans->where('unggulan', true)->count() }}</h3>
                <p class="stat-label">Layanan Unggulan</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-secondary">
                <i class="fas fa-eye-slash"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $layanans->where('aktif', false)->count() }}</h3>
                <p class="stat-label">Tidak Aktif</p>
            </div>
        </div>
    </div>
</div>

<!-- Layanan Grid -->
@forelse($layanans as $item)
    @if($loop->first)
    <div class="layanans-grid">
    @endif
        <div class="layanan-card">
            <div class="layanan-image">
                @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}">
                @else
                    <div class="no-image">
                        <i class="fas fa-image"></i>
                    </div>
                @endif
                <div class="layanan-badges">
                    <div>
                        @if($item->unggulan)
                            <span class="badge badge-featured">
                                <i class="fas fa-star"></i> Unggulan
                            </span>
                        @endif
                    </div>
                    <div>
                        <span class="badge badge-{{ $item->aktif ? 'active' : 'inactive' }}">
                            <i class="fas fa-circle"></i> {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
                <div class="layanan-order">
                    <i class="fas fa-sort"></i> Urutan: {{ $item->urutan }}
                </div>
            </div>

            <div class="layanan-body">
                <div class="layanan-icon-name">
                    @if($item->icon)
                        <div class="layanan-icon-display">
                            <i class="{{ $item->icon }}"></i>
                        </div>
                    @endif
                    <h3>{{ $item->nama }}</h3>
                </div>

                <p class="layanan-description">
                    {{ $item->deskripsi_singkat ? Str::limit($item->deskripsi_singkat, 100) : 'Tidak ada deskripsi' }}
                </p>

                @if($item->fasilitas && count($item->fasilitas) > 0)
                <div class="layanan-fasilitas">
                    <i class="fas fa-list-check"></i>
                    <span>{{ count($item->fasilitas) }} Fasilitas</span>
                </div>
                @endif
            </div>

            <div class="layanan-actions">
                <a href="{{ route('admin.layanan.show', $item) }}" class="btn-action btn-view" title="Lihat Detail">
                    <i class="fas fa-eye"></i>
                    <span>Lihat</span>
                </a>
                <a href="{{ route('admin.layanan.edit', $item) }}" class="btn-action btn-edit" title="Edit">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
                {{-- type="button" agar tidak langsung submit — dikontrol lewat JS --}}
                <form action="{{ route('admin.layanan.destroy', $item) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-action btn-delete btn-hapus" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    @if($loop->last)
    </div>
    @endif
@empty
<div class="empty-state">
    <i class="fas fa-box-open"></i>
    <h3>Belum Ada Layanan</h3>
    <p>Mulai tambahkan layanan pertama Anda</p>
    <a href="{{ route('admin.layanan.create') }}" class="btn-primary">
        <i class="fas fa-plus-circle"></i>
        <span>Tambah Layanan</span>
    </a>
</div>
@endforelse
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Auto hide alerts setelah 5 detik
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        alert.style.animation = 'slideOutUp 0.5s ease';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);

// Konfirmasi hapus — delegasi ke tombol .btn-hapus agar tidak ada submit native
document.querySelectorAll('.btn-hapus').forEach(btn => {
    btn.addEventListener('click', function () {
        const form = this.closest('form');
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: 'Apakah Anda yakin ingin menghapus layanan ini?<br><small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            reverseButtons: true,
            focusCancel: true,
        }).then(result => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush