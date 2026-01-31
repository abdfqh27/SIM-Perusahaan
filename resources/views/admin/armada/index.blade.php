@extends('admin.layouts.app')

@section('title', 'Kelola Armada')

@section('content')
<style>
    .armada-card {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .armada-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(251, 133, 0, 0.2);
    }

    .armada-image-wrapper {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .armada-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .armada-card:hover .armada-image {
        transform: scale(1.1);
    }

    .armada-badge-overlay {
        position: absolute;
        top: 1rem;
        left: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        z-index: 10;
    }

    .badge-custom {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .badge-unggulan {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.95), rgba(255, 152, 0, 0.95));
        color: white;
    }

    .badge-tersedia {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.95), rgba(32, 201, 151, 0.95));
        color: white;
    }

    .badge-tidak-tersedia {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.95), rgba(200, 35, 51, 0.95));
        color: white;
    }

    .badge-urutan {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(1, 55, 83, 0.9);
        color: white;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        z-index: 10;
    }

    .armada-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .armada-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .armada-type {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.3rem 0.8rem;
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.1), rgba(255, 183, 3, 0.1));
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--orange-primary);
        margin-bottom: 1rem;
        width: fit-content;
    }

    .armada-info {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .info-icon {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .armada-fasilitas {
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    .fasilitas-title {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .fasilitas-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
    }

    .fasilitas-item {
        padding: 0.25rem 0.6rem;
        background: #f8f9fa;
        border-radius: 10px;
        font-size: 0.75rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .fasilitas-item i {
        font-size: 0.7rem;
        color: var(--orange-primary);
    }

    .armada-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn-action {
        flex: 1;
        padding: 0.6rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-view {
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(33, 158, 188, 0.4);
        color: white;
    }

    .btn-edit-action {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
    }

    .btn-edit-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
        color: white;
    }

    .btn-delete-action {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .btn-delete-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .empty-icon {
        font-size: 5rem;
        color: #e9ecef;
        margin-bottom: 1rem;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #6c757d;
        margin-bottom: 2rem;
    }

    .armada-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .armada-grid {
            grid-template-columns: 1fr;
        }

        .armada-image-wrapper {
            height: 200px;
        }

        .armada-title {
            font-size: 1.1rem;
        }

        .badge-urutan {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }
</style>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert-danger">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

<!-- Page Header -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-bus"></i>
        </div>
        <div>
            <h1 class="header-title">Kelola Armada</h1>
            <p class="header-subtitle">Manajemen armada bus dan fasilitas yang tersedia</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.armada.create') }}" class="btn-add">
            <i class="fas fa-plus"></i>
            <span>Tambah Armada</span>
        </a>
    </div>
</div>

<!-- Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-primary">
                <i class="fas fa-bus"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $armadas->count() }}</h3>
                <p class="stat-label">Total Armada</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $armadas->where('tersedia', true)->count() }}</h3>
                <p class="stat-label">Armada Tersedia</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-warning">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $armadas->where('unggulan', true)->count() }}</h3>
                <p class="stat-label">Armada Unggulan</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-danger">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $armadas->where('tersedia', false)->count() }}</h3>
                <p class="stat-label">Tidak Tersedia</p>
            </div>
        </div>
    </div>
</div>

<!-- Armada Grid -->
@if($armadas->count() > 0)
<div class="armada-grid">
    @foreach($armadas as $armada)
    <div class="card armada-card">
        <div class="armada-image-wrapper">
            @if($armada->gambar_utama)
                <img src="{{ asset('storage/' . $armada->gambar_utama) }}" 
                     alt="{{ $armada->nama }}" 
                     class="armada-image">
            @else
                <div class="armada-image" style="background: linear-gradient(135deg, var(--blue-dark), var(--blue-light)); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-bus" style="font-size: 4rem; color: rgba(255,255,255,0.3);"></i>
                </div>
            @endif

            <div class="armada-badge-overlay">
                @if($armada->unggulan)
                    <span class="badge-custom badge-unggulan">
                        <i class="fas fa-star"></i> Unggulan
                    </span>
                @endif
                
                @if($armada->tersedia)
                    <span class="badge-custom badge-tersedia">
                        <i class="fas fa-check-circle"></i> Tersedia
                    </span>
                @else
                    <span class="badge-custom badge-tidak-tersedia">
                        <i class="fas fa-times-circle"></i> Tidak Tersedia
                    </span>
                @endif
            </div>

            <div class="badge-urutan">{{ $armada->urutan }}</div>
        </div>

        <div class="armada-body">
            <h3 class="armada-title">{{ $armada->nama }}</h3>
            
            <div class="armada-type">
                <i class="fas fa-tag"></i>
                {{ $armada->tipe_bus }}
            </div>

            <div class="armada-info">
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <strong>Kapasitas:</strong> {{ $armada->kapasitas_min }} - {{ $armada->kapasitas_max }} penumpang
                    </div>
                </div>
            </div>

            @if($armada->fasilitas && count($armada->fasilitas) > 0)
            <div class="armada-fasilitas">
                <div class="fasilitas-title">Fasilitas</div>
                <div class="fasilitas-list">
                    @foreach(array_slice($armada->fasilitas, 0, 5) as $fasilitas)
                        <span class="fasilitas-item">
                            <i class="fas fa-check"></i>
                            {{ $fasilitas }}
                        </span>
                    @endforeach
                    @if(count($armada->fasilitas) > 5)
                        <span class="fasilitas-item">
                            <i class="fas fa-plus"></i>
                            {{ count($armada->fasilitas) - 5 }} lainnya
                        </span>
                    @endif
                </div>
            </div>
            @endif

            <div class="armada-actions">
                <a href="{{ route('admin.armada.show', $armada) }}" class="btn-action btn-view">
                    <i class="fas fa-eye"></i>
                    <span>Detail</span>
                </a>
                <a href="{{ route('admin.armada.edit', $armada) }}" class="btn-action btn-edit-action">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
                <form action="{{ route('admin.armada.destroy', $armada) }}" 
                      method="POST" 
                      class="delete-form"
                      style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete-action" style="width: 100%;">
                        <i class="fas fa-trash"></i>
                        <span>Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <div class="empty-icon">
        <i class="fas fa-bus"></i>
    </div>
    <h3 class="empty-title">Belum Ada Armada</h3>
    <p class="empty-text">Mulai tambahkan armada bus pertama Anda untuk mengelola layanan transportasi.</p>
    <a href="{{ route('admin.armada.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i>
        Tambah Armada Pertama
    </a>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete confirmation
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data armada akan dihapus permanen beserta semua gambarnya!",
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
</script>
@endsection