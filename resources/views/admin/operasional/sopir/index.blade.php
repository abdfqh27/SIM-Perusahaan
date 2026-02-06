@extends('admin.layouts.app')

@section('title', 'Manajemen Sopir')

@section('content')
<div class="admin-content">
    <!-- Header Section -->
    <div class="gradient-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-images"></i>
            </div>
            <div>
                <h2 class="header-title">Manajemen Data Sopir</h2>
                <p class="header-subtitle">Kelola Data Sopir Bus</p>
            </div>
        </div>
        <a href="{{ route('admin.operasional.sopir.create') }}" class="btn-hero-add">
            <i class="fas fa-plus"></i>
            <span>Tambah Sopir</span>
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
    @endif

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $sopirs->count() }}</h3>
                    <p class="stat-label">Total Sopir</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-success">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $sopirs->where('status', 'aktif')->count() }}</h3>
                    <p class="stat-label">Sopir Aktif</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-info">
                    <i class="fas fa-bus"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $sopirs->whereNotNull('bus_id')->count() }}</h3>
                    <p class="stat-label">Ditugaskan</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-warning">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $sopirs->whereNull('bus_id')->count() }}</h3>
                    <p class="stat-label">Belum Bertugas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-list"></i> Daftar Sopir
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>No. HP</th>
                            <th>Jenis SIM</th>
                            <th>Bus Ditugaskan</th>
                            <th>Status</th>
                            <th style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sopirs as $index => $sopir)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $sopir->nama_sopir }}</strong>
                            </td>
                            <td>
                                <i class="fas fa-id-card-alt text-muted"></i> {{ $sopir->nik }}
                            </td>
                            <td>
                                <i class="fas fa-phone text-muted"></i> {{ $sopir->no_hp }}
                            </td>
                            <td>
                                <span class="badge-sim">
                                    <i class="fas fa-certificate"></i> {{ $sopir->jenis_sim }}
                                </span>
                            </td>
                            <td>
                                @if($sopir->bus)
                                    <span class="badge-bus">
                                        <i class="fas fa-bus"></i> {{ $sopir->bus->nama_bus }}
                                    </span>
                                @else
                                    <span class="badge-unassigned">
                                        <i class="fas fa-minus-circle"></i> Belum Bertugas
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($sopir->status === 'aktif')
                                    <span class="badge-status badge-aktif">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge-status badge-nonaktif">
                                        <i class="fas fa-times-circle"></i> Non-Aktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group-action">
                                    <a href="{{ route('admin.operasional.sopir.show', $sopir) }}" 
                                       class="btn-action btn-action-info" 
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.operasional.sopir.edit', $sopir) }}" 
                                       class="btn-action btn-action-warning" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.operasional.sopir.destroy', $sopir) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus sopir ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-action btn-action-danger" 
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-users" style="font-size: 3rem; color: #ccc;"></i>
                                    <p style="margin-top: 1rem; color: #6c757d;">Belum ada data sopir</p>
                                    <a href="{{ route('admin.operasional.sopir.create') }}" class="btn-primary" style="margin-top: 1rem;">
                                        <i class="fas fa-plus"></i> Tambah Sopir Pertama
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

<style>
/* Badge Styling */
.badge-sim {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: linear-gradient(135deg, #ffc107, #ff9800);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    white-space: nowrap;
}

.badge-bus {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    white-space: nowrap;
}

.badge-unassigned {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    white-space: nowrap;
}

.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    white-space: nowrap;
}

.badge-aktif {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.badge-nonaktif {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

/* Action Buttons */
.btn-group-action {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-start;
}

.btn-action {
    width: 35px;
    height: 35px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: white;
    font-size: 0.9rem;
}

.btn-action-info {
    background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
}

.btn-action-info:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(33, 158, 188, 0.4);
}

.btn-action-warning {
    background: linear-gradient(135deg, #ffc107, #ff9800);
}

.btn-action-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
}

.btn-action-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
}

.btn-action-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

/* Empty State */
.empty-state {
    padding: 2rem;
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .btn-group-action {
        flex-wrap: wrap;
    }
    
    .table td, .table th {
        font-size: 0.85rem;
        padding: 0.75rem 0.5rem;
    }
}
</style>
@endsection