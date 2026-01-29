@extends('admin.layouts.app')

@section('title', 'Manajemen Armada')

@section('content')

<style>
    .armada-manajemen {
    width: 100%;
}

/* armada Card */
.armada-card {
    margin-top: 0;
}

.armada-card .card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0;
}

.armada-card .card-title i {
    font-size: 1.2rem;
}

/* armada Table */
.armada-table {
    margin-bottom: 0;
}

.armada-table thead th {
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.armada-table tbody td {
    vertical-align: middle;
    padding: 1rem;
}

/* armada Image */
.armada-image {
    width: 100px;
    height: 70px;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}

.armada-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.3s ease;
}

.armada-table tbody tr:hover .armada-image img {
    transform: scale(1.1);
}

.no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #e9ecef, #dee2e6);
    color: #6c757d;
}

.no-image i {
    font-size: 2rem;
    opacity: 0.5;
}

/* armada Info */
.armada-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.armada-info strong {
    font-size: 1rem;
    color: #023047;
}

/* Badge Variations for armada */
.badge {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}

.badge-featured {
    background: linear-gradient(135deg, rgba(251, 133, 0, 0.15), rgba(255, 183, 3, 0.15));
    color: #FB8500;
}

.badge-type {
    background: linear-gradient(135deg, rgba(2, 48, 71, 0.15), rgba(33, 158, 188, 0.15));
    color: #023047;
    font-weight: 600;
}

.badge-available {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(32, 201, 151, 0.15));
    color: #28a745;
}

.badge-unavailable {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

/* Capacity Badge */
.capacity-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.35rem 0.75rem;
    background: linear-gradient(135deg, rgba(142, 202, 230, 0.15), rgba(33, 158, 188, 0.15));
    color: #219EBC;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.capacity-badge i {
    font-size: 0.85rem;
}

/* Order Badge */
.order-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #FB8500, #FFB703);
    color: white;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.95rem;
    box-shadow: 0 2px 8px rgba(251, 133, 0, 0.3);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.action-buttons .btn-sm {
    width: 35px;
    height: 35px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.action-buttons .btn-info {
    background: linear-gradient(135deg, #219EBC, #8ECAE6);
    border: none;
    color: white;
    box-shadow: 0 2px 8px rgba(33, 158, 188, 0.3);
}

.action-buttons .btn-info:hover {
    background: linear-gradient(135deg, #8ECAE6, #219EBC);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(33, 158, 188, 0.5);
}

.action-buttons .btn-warning {
    background: linear-gradient(135deg, #ffc107, #ff9800);
    border: none;
    color: #212529;
    box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);
}

.action-buttons .btn-warning:hover {
    background: linear-gradient(135deg, #ff9800, #ffc107);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.5);
}

.action-buttons .btn-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    border: none;
    color: white;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
}

.action-buttons .btn-danger:hover {
    background: linear-gradient(135deg, #c82333, #bd2130);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.5);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #e9ecef, #dee2e6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-icon i {
    font-size: 3rem;
    color: #6c757d;
    opacity: 0.5;
}

.empty-state h4 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #495057;
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    font-size: 1rem;
    color: #6c757d;
    margin: 0 0 2rem 0;
}

/* Alert Dismissible */
.alert-dismissible {
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    padding-right: 3rem;
}

.alert-dismissible i {
    font-size: 1.2rem;
}

.btn-close {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    opacity: 0.5;
    transition: all 0.3s ease;
}

.btn-close:hover {
    opacity: 1;
}

/* Responsive */
@media (max-width: 1200px) {
    .armada-table {
        font-size: 0.85rem;
    }

    .armada-image {
        width: 80px;
        height: 60px;
    }
}

@media (max-width: 992px) {
    .table-responsive {
        overflow-x: auto;
    }

    .armada-table {
        min-width: 900px;
    }
}

@media (max-width: 768px) {
    .page-header .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .action-buttons {
        flex-wrap: wrap;
    }
}

@media (max-width: 576px) {
    .armada-image {
        width: 60px;
        height: 45px;
    }

    .action-buttons .btn-sm {
        width: 32px;
        height: 32px;
        font-size: 0.85rem;
    }
}
</style>

<!-- Header Section -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-bus"></i>
        </div>
        <div>
            <h2 class="header-title">Manajemen Armada</h2>
            <p class="header-subtitle">Kelola Daftar Armada Anda</p>
        </div>
    </div>
    <div class="header-actions">
        <button class="btn-refresh" onclick="location.reload()">
            <i class="fas fa-sync-alt"></i>
            <span>Refresh</span>
        </button>
        <a href="{{ route('admin.armada.create') }}" class="btn-add">
            <i class="fas fa-plus"></i>
            <span>Tambah Pesanan</span>
        </a>
    </div>
</div>

<!-- Alert Messages -->
    @if(session('success'))
        <div class="alert-success alert-dismissible">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" onclick="this.parentElement.remove()">×</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-danger alert-dismissible">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" onclick="this.parentElement.remove()">×</button>
        </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-icon">
                    <div class="icon-wrapper icon-primary">
                        <i class="fas fa-bus"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $armadas->count() }}</h3>
                    <p class="stat-label">Total Armada</p>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-icon">
                    <div class="icon-wrapper icon-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $armadas->where('tersedia', true)->count() }}</h3>
                    <p class="stat-label">Tersedia</p>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-icon">
                    <div class="icon-wrapper icon-warning">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $armadas->where('unggulan', true)->count() }}</h3>
                    <p class="stat-label">Unggulan</p>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-icon">
                    <div class="icon-wrapper icon-info">
                        <i class="fas fa-chair"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $armadas->sum('kapasitas') }}</h3>
                    <p class="stat-label">Total Kapasitas</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card armada-card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="fas fa-list"></i>
                Daftar Armada
            </h5>
        </div>
        <div class="card-body">
            @if($armadas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover armada-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Gambar</th>
                                <th width="20%">Nama Armada</th>
                                <th width="12%">Tipe Bus</th>
                                <th width="10%">Kapasitas</th>
                                <th width="10%">Fasilitas</th>
                                <th width="8%">Status</th>
                                <th width="10%">Urutan</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($armadas as $index => $armada)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="armada-image">
                                            @if($armada->gambar_utama)
                                                <img src="{{ asset('storage/' . $armada->gambar_utama) }}" 
                                                     alt="{{ $armada->nama }}">
                                            @else
                                                <div class="no-image">
                                                    <i class="fas fa-bus"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="armada-info">
                                            <strong>{{ $armada->nama }}</strong>
                                            @if($armada->unggulan)
                                                <span class="badge badge-featured">
                                                    <i class="fas fa-star"></i> Unggulan
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-type">{{ $armada->tipe_bus }}</span>
                                    </td>
                                    <td>
                                        <span class="capacity-badge">
                                            <i class="fas fa-users"></i>
                                            {{ $armada->kapasitas }} Orang
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="fas fa-cogs"></i>
                                            {{ $armada->fasilitas->count() }} Fasilitas
                                        </span>
                                    </td>
                                    <td>
                                        @if($armada->tersedia)
                                            <span class="badge badge-available">
                                                <i class="fas fa-check"></i> Tersedia
                                            </span>
                                        @else
                                            <span class="badge badge-unavailable">
                                                <i class="fas fa-times"></i> Tidak
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="order-badge">{{ $armada->urutan }}</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.armada.show', $armada->id) }}" 
                                               class="btn-sm btn-info"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.armada.edit', $armada->id) }}" 
                                               class="btn-sm btn-warning"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.armada.destroy', $armada->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Yakin ingin menghapus armada ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn-sm btn-danger"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-bus"></i>
                    </div>
                    <h4>Belum Ada Armada</h4>
                    <p>Mulai tambahkan armada bus perusahaan Anda</p>
                    <a href="{{ route('admin.armada.create') }}" class="btn-primary">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Armada Pertama</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection