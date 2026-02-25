@extends('admin.layouts.app')

@section('title', 'Detail Layanan')

@section('content')
<style>
    .detail-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 1.5rem;
    }

    .detail-main {
        min-width: 0;
    }

    .detail-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .detail-image-section {
        position: relative;
        width: 100%;
        height: 400px;
        overflow: hidden;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .detail-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .detail-no-image {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
        color: white;
    }

    .detail-no-image i {
        font-size: 5rem;
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    .detail-no-image p {
        font-size: 1.1rem;
        opacity: 0.6;
    }

    .detail-badges-overlay {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        right: 1.5rem;
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        z-index: 10;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        backdrop-filter: blur(10px);
    }

    .badge-featured {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
    }

    .badge-active {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    }

    .badge-inactive {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.4);
    }

    .detail-content {
        padding: 2rem;
    }

    .detail-title-section {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #e9ecef;
    }

    .detail-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.2rem;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.3);
    }

    .detail-title-section h1 {
        margin: 0 0 0.5rem 0;
        color: var(--blue-dark);
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .detail-slug {
        margin: 0;
        color: #6c757d;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-section {
        margin-bottom: 2rem;
    }

    .detail-section h3 {
        color: var(--blue-dark);
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .detail-section h3 i {
        color: var(--orange-primary);
    }

    .detail-text {
        color: #495057;
        font-size: 1rem;
        line-height: 1.8;
        margin: 0;
    }

    .facilities-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 0.75rem;
    }

    .facilities-list li {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        color: #495057;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .facilities-list li:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .facilities-list li i {
        color: var(--orange-primary);
        font-size: 1.1rem;
    }

    .detail-sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .info-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .info-card h3 {
        color: var(--blue-dark);
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
    }

    .info-card h3 i {
        color: var(--orange-primary);
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f8f9fa;
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        color: #6c757d;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label i {
        width: 20px;
        text-align: center;
        color: var(--blue-light);
    }

    .info-value {
        color: var(--blue-dark);
        font-weight: 600;
        font-size: 0.95rem;
    }

    .info-value.price {
        color: var(--orange-primary);
        font-size: 1.1rem;
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 0.75rem;
    }

    .status-item:last-child {
        margin-bottom: 0;
    }

    .status-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--blue-dark);
        font-weight: 600;
        font-size: 0.95rem;
    }

    .status-label i {
        width: 24px;
        text-align: center;
        color: var(--orange-primary);
    }

    .status-toggle {
        width: 40px;
        height: 40px;
        background: #dc3545;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .status-toggle.active {
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    .quick-actions-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .quick-actions-card h3 {
        color: var(--blue-dark);
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
    }

    .quick-actions-card h3 i {
        color: var(--orange-primary);
    }

    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        margin-bottom: 0.75rem;
    }

    .quick-action-btn:last-child {
        margin-bottom: 0;
    }

    .quick-action-btn.edit {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
        box-shadow: 0 3px 10px rgba(255, 193, 7, 0.3);
    }

    .quick-action-btn.edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
    }

    .quick-action-btn.view {
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white;
        box-shadow: 0 3px 10px rgba(52, 152, 219, 0.3);
    }

    .quick-action-btn.view:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
    }

    @media (max-width: 992px) {
        .detail-container {
            grid-template-columns: 1fr;
        }

        .detail-sidebar {
            order: 2;
        }

        .detail-image-section {
            height: 300px;
        }
    }

    @media (max-width: 576px) {

        .detail-title-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .facilities-list {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="gradient-header">
    <div class="header-left">
        <a href="{{ route('admin.layanan.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="header-icon">
            <i class="fas fa-info-circle"></i>
        </div>
        <div>
            <h2 class="header-title">Detail Layanan</h2>
            <p class="header-subtitle">Informasi lengkap layanan</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.layanan.edit', $layanan) }}" class="btn-header-action btn-edit">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </a>
        <form action="{{ route('admin.layanan.destroy', $layanan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-header-action btn-delete">
                <i class="fas fa-trash"></i>
                <span>Hapus</span>
            </button>
        </form>
    </div>
</div>

<div class="detail-container">
    <div class="detail-main">
        <div class="detail-card">
            <div class="detail-image-section">
                @if($layanan->gambar)
                    <img src="{{ asset($layanan->gambar) }}" alt="{{ $layanan->nama }}" class="detail-image">
                @else
                    <div class="detail-no-image">
                        <i class="fas fa-image"></i>
                        <p>Tidak ada gambar</p>
                    </div>
                @endif
                
                <div class="detail-badges-overlay">
                    @if($layanan->unggulan)
                        <span class="badge badge-featured">
                            <i class="fas fa-star"></i> Unggulan
                        </span>
                    @endif
                    <span class="badge badge-{{ $layanan->aktif ? 'active' : 'inactive' }}">
                        <i class="fas fa-circle"></i> {{ $layanan->aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
            
            <div class="detail-content">
                <div class="detail-title-section">
                    @if($layanan->icon)
                        <div class="detail-icon">
                            <i class="{{ $layanan->icon }}"></i>
                        </div>
                    @endif
                    <div>
                        <h1>{{ $layanan->nama }}</h1>
                        <p class="detail-slug">
                            <i class="fas fa-link"></i> {{ $layanan->slug }}
                        </p>
                    </div>
                </div>
                
                @if($layanan->deskripsi_singkat)
                <div class="detail-section">
                    <h3><i class="fas fa-align-left"></i> Deskripsi Singkat</h3>
                    <p class="detail-text">{{ $layanan->deskripsi_singkat }}</p>
                </div>
                @endif
                
                @if($layanan->deskripsi_lengkap)
                <div class="detail-section">
                    <h3><i class="fas fa-file-alt"></i> Deskripsi Lengkap</h3>
                    <p class="detail-text">{{ $layanan->deskripsi_lengkap }}</p>
                </div>
                @endif
                
                @if($layanan->fasilitas && count($layanan->fasilitas) > 0)
                <div class="detail-section">
                    <h3><i class="fas fa-list-check"></i> Fasilitas</h3>
                    <ul class="facilities-list">
                        @foreach($layanan->fasilitas as $fasilitas)
                            <li><i class="fas fa-check-circle"></i> {{ $fasilitas }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="detail-sidebar">
        <div class="info-card">
            <h3><i class="fas fa-info-circle"></i> Informasi</h3>
            
            <div class="info-item">
                <span class="info-label">
                    <i class="fas fa-sort"></i> Urutan Tampil
                </span>
                <span class="info-value">{{ $layanan->urutan }}</span>
            </div>
            
            @if($layanan->harga)
            <div class="info-item">
                <span class="info-label">
                    <i class="fas fa-tag"></i> Harga
                </span>
                <span class="info-value price">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span>
            </div>
            @endif
            
            <div class="info-item">
                <span class="info-label">
                    <i class="fas fa-calendar-plus"></i> Dibuat
                </span>
                <span class="info-value">{{ $layanan->created_at->format('d M Y, H:i') }}</span>
            </div>
            
            <div class="info-item">
                <span class="info-label">
                    <i class="fas fa-calendar-edit"></i> Diupdate
                </span>
                <span class="info-value">{{ $layanan->updated_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
        
        <div class="info-card">
            <h3><i class="fas fa-toggle-on"></i> Status</h3>
            
            <div class="status-item">
                <div class="status-label">
                    <i class="fas fa-star"></i>
                    <span>Layanan Unggulan</span>
                </div>
                <div class="status-toggle {{ $layanan->unggulan ? 'active' : '' }}">
                    <i class="fas fa-{{ $layanan->unggulan ? 'check' : 'times' }}"></i>
                </div>
            </div>
            
            <div class="status-item">
                <div class="status-label">
                    <i class="fas fa-power-off"></i>
                    <span>Status Aktif</span>
                </div>
                <div class="status-toggle {{ $layanan->aktif ? 'active' : '' }}">
                    <i class="fas fa-{{ $layanan->aktif ? 'check' : 'times' }}"></i>
                </div>
            </div>
        </div>
        
        <div class="quick-actions-card">
            <h3><i class="fas fa-bolt"></i> Aksi Cepat</h3>
            <a href="{{ route('admin.layanan.edit', $layanan) }}" class="quick-action-btn edit">
                <i class="fas fa-edit"></i>
                <span>Edit Layanan</span>
            </a>
            <a href="{{ url('/layanan/' . $layanan->slug) }}" target="_blank" class="quick-action-btn view">
                <i class="fas fa-external-link-alt"></i>
                <span>Lihat di Frontend</span>
            </a>
        </div>
    </div>
</div>
@endsection