@extends('admin.layouts.app')

@section('title', 'Manajemen Bus')

@section('content')
<style>
/* Bus Code Styling */
.bus-code {
    color: var(--orange-primary);
    font-weight: 600;
}

/* Badge Kategori */
.badge-kategori {
    background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    color: white;
    padding: 0.35rem 0.75rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 500;
    display: inline-block;
}

/* Driver Info */
.driver-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.driver-info i {
    color: var(--blue-light);
    font-size: 1.2rem;
}

/* Color Display */
.color-display {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* License Plate */
.license-plate {
    color: var(--blue-dark);
    font-family: 'Courier New', monospace;
    letter-spacing: 1px;
}

/* Status Badge */
.status-badge {
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.action-buttons .btn-sm {
    padding: 0.4rem 0.75rem;
    border-radius: 6px;
}

.delete-form {
    display: inline;
    margin: 0;
}

/* Empty State */
.empty-state {
    padding: 3rem !important;
}

.empty-state div {
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    margin: 0;
    font-size: 1.1rem;
}

.empty-link {
    color: var(--orange-primary);
    margin-top: 0.5rem;
    display: inline-block;
    text-decoration: none;
    transition: color 0.3s ease;
}

.empty-link:hover {
    color: var(--orange-secondary);
}

/* Alert Banner Success */
.alert-success-custom {
    background: #d4edda;
    border-left: 4px solid #28a745;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 1rem;
    animation: slideInDown 0.3s ease;
}

.alert-success-custom i {
    color: #28a745;
    font-size: 1.5rem;
}

.alert-success-custom .alert-content {
    flex: 1;
    color: #155724;
    font-weight: 500;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Alert Banner Error */
.alert-danger-custom {
    background: #f8d7da;
    border-left: 4px solid #dc3545;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 1rem;
    animation: slideInDown 0.3s ease;
}

.alert-danger-custom i {
    color: #dc3545;
    font-size: 1.5rem;
}

.alert-danger-custom .alert-content {
    flex: 1;
    color: #721c24;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
    }
    
    .table {
        font-size: 0.85rem;
    }
}
</style>
<div class="admin-content">
    <!-- Header Section -->
    <div class="gradient-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-bus"></i>
            </div>
            <div>
                <h2 class="header-title">Manajemen Bus</h2>
                <p class="header-subtitle">Kelola data bus dan status operasional</p>
            </div>
        </div>
        <div class="header-actions">
            <button class="btn-refresh" onclick="location.reload()">
                <i class="fas fa-sync-alt"></i>
                <span>Refresh</span>
            </button>
            <a href="{{ route('admin.operasional.bus.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                <span>Tambah Bus</span>
            </a>
        </div>
    </div>

    <!-- Alert Success Banner -->
    @if(session('success'))
    <div class="alert-success-custom">
        <i class="fas fa-check-circle"></i>
        <div class="alert-content">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <!-- Alert Error Banner -->
    @if(session('error'))
    <div class="alert-danger-custom">
        <i class="fas fa-exclamation-circle"></i>
        <div class="alert-content">
            {{ session('error') }}
        </div>
    </div>
    @endif

    <!-- Statistics Grid -->
    <div class="stats-grid">
        <!-- Total Bus -->
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-primary">
                    <i class="fas fa-bus"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['total'] }}</h3>
                    <p class="stat-label">Total Bus</p>
                </div>
            </div>
            <div class="stat-footer">
                <a href="#" class="stat-link">
                    Lihat Semua
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Bus Aktif -->
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['aktif'] }}</h3>
                    <p class="stat-label">Bus Aktif</p>
                </div>
            </div>
            <div class="stat-trend">
                <span class="trend-indicator trend-up">
                    <i class="fas fa-arrow-up"></i>
                    Siap Beroperasi
                </span>
            </div>
        </div>

        <!-- Dalam Perawatan -->
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-warning">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['perawatan'] }}</h3>
                    <p class="stat-label">Dalam Perawatan</p>
                </div>
            </div>
            <div class="stat-trend">
                <span class="trend-indicator trend-alert">
                    <i class="fas fa-wrench"></i>
                    Sedang Maintenance
                </span>
            </div>
        </div>

        <!-- Sedang Dipakai -->
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-info">
                    <i class="fas fa-route"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['sedang_dipakai'] }}</h3>
                    <p class="stat-label">Sedang Dipakai</p>
                </div>
            </div>
            <div class="stat-trend">
                <span class="trend-indicator trend-neutral">
                    <i class="fas fa-clock"></i>
                    Hari Ini
                </span>
            </div>
        </div>

        <!-- Tanpa Sopir -->
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-secondary">
                    <i class="fas fa-user-slash"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['tanpa_sopir'] }}</h3>
                    <p class="stat-label">Tanpa Sopir</p>
                </div>
            </div>
            <div class="stat-trend">
                <span class="trend-indicator trend-neutral">
                    <i class="fas fa-exclamation-triangle"></i>
                    Perlu Perhatian
                </span>
            </div>
        </div>
    </div>

    <!-- Bus Table Card -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-list me-2"></i>
            Daftar Bus
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Kode Bus</th>
                            <th width="15%">Nama Bus</th>
                            <th width="12%">Kategori</th>
                            <th width="15%">Sopir</th>
                            <th width="10%">Warna</th>
                            <th width="12%">No. Polisi</th>
                            <th width="10%">Status</th>
                            <th width="11%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($buses as $index => $bus)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong class="bus-code">{{ $bus->kode_bus }}</strong>
                            </td>
                            <td>{{ $bus->nama_bus }}</td>
                            <td>
                                <span class="badge-kategori">
                                    {{ $bus->kategoriBus->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="driver-info">
                                    <i class="fas fa-user-circle"></i>
                                    <span>{{ $bus->sopir->nama_sopir ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="color-display">
                                    <span>{{ ucfirst($bus->warna_bus) }}</span>
                                </div>
                            </td>
                            <td>
                                <strong class="license-plate">{{ $bus->nomor_polisi }}</strong>
                            </td>
                            <td>
                                @php
                                    $statusRealtime = $bus->status_realtime;
                                    $statusConfig = [
                                        'tersedia' => ['color' => '#28a745', 'bg' => 'rgba(40, 167, 69, 0.1)', 'icon' => 'fa-check-circle', 'text' => 'Tersedia'],
                                        'dipakai' => ['color' => '#219EBC', 'bg' => 'rgba(33, 158, 188, 0.1)', 'icon' => 'fa-route', 'text' => 'Dipakai'],
                                        'perawatan' => ['color' => '#ffc107', 'bg' => 'rgba(255, 193, 7, 0.1)', 'icon' => 'fa-tools', 'text' => 'Perawatan']
                                    ];
                                    $config = $statusConfig[$statusRealtime] ?? $statusConfig['tersedia'];
                                @endphp
                                <span class="status-badge" style="background: {{ $config['bg'] }}; color: {{ $config['color'] }};">
                                    <i class="fas {{ $config['icon'] }}"></i>
                                    {{ $config['text'] }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.operasional.bus.show', $bus->id) }}" 
                                       class="btn btn-info btn-sm" 
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($bus->sopir_id)
                                    <button type="button" 
                                            class="btn btn-warning btn-sm" 
                                            onclick="confirmRemoveSopir('{{ $bus->id }}', '{{ $bus->nama_bus }}', '{{ $bus->sopir->nama_sopir }}')"
                                            title="Lepas Sopir">
                                        <i class="fas fa-user-minus"></i>
                                    </button>
                                    @endif
                                    
                                    <a href="{{ route('admin.operasional.bus.edit', $bus->id) }}" 
                                       class="btn btn-success btn-sm" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.operasional.bus.destroy', $bus->id) }}" 
                                          method="POST" 
                                          class="delete-form"
                                          data-bus-name="{{ $bus->nama_bus }}"
                                          data-has-sopir="{{ $bus->sopir_id ? 'true' : 'false' }}"
                                          data-sopir-name="{{ $bus->sopir->nama_sopir ?? '' }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center empty-state">
                                <div>
                                    <i class="fas fa-inbox"></i>
                                    <p>Belum ada data bus</p>
                                    <a href="{{ route('admin.operasional.bus.create') }}" class="empty-link">
                                        Tambah bus pertama
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // AUTO HIDE ALERT BANNER AFTER 5 SECONDS
    const alertBanners = document.querySelectorAll('.alert-success-custom, .alert-danger-custom');
    alertBanners.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // HANDLE DELETE CONFIRMATION
    const deleteForms = document.querySelectorAll('.delete-form');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const busName = this.getAttribute('data-bus-name');
            const hasSopir = this.getAttribute('data-has-sopir') === 'true';
            const sopirName = this.getAttribute('data-sopir-name');
            
            if (hasSopir) {
                Swal.fire({
                    title: 'Bus Masih Memiliki Sopir!',
                    html: `
                        <div style="text-align: left; padding: 1rem;">
                            <p><strong>Bus:</strong> ${busName}</p>
                            <p><strong>Sopir:</strong> ${sopirName}</p>
                            <hr>
                            <p style="color: #dc3545;">
                                <i class="fas fa-exclamation-triangle"></i> 
                                Bus tidak dapat dihapus karena masih ada sopir yang bertugas.
                            </p>
                            <p style="margin-top: 1rem;">
                                Silakan <strong>lepaskan sopir terlebih dahulu</strong> dengan klik tombol 
                                <span style="color: #ffc107;"><i class="fas fa-user-minus"></i> Lepas Sopir</span>
                            </p>
                        </div>
                    `,
                    icon: 'warning',
                    confirmButtonText: 'OK, Mengerti',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Bus <strong>${busName}</strong> akan dihapus (soft delete).<br>Data historis akan tetap tersimpan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    form.submit();
                }
            });
        });
    });
});

// FUNCTION: REMOVE SOPIR
function confirmRemoveSopir(busId, busName, sopirName) {
    Swal.fire({
        title: 'Lepaskan Sopir?',
        html: `
            <div style="text-align: left; padding: 1rem;">
                <p>Apakah Anda yakin ingin melepaskan:</p>
                <p><strong>Sopir:</strong> <span style="color: #fb8500;">${sopirName}</span></p>
                <p><strong>Dari Bus:</strong> ${busName}</p>
                <hr>
                <p style="color: #28a745;">
                    <i class="fas fa-check-circle"></i> 
                    Sopir akan tersedia untuk ditugaskan ke bus lain.
                </p>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-user-minus"></i> Ya, Lepaskan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Melepaskan Sopir...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/operasional/bus/${busId}/remove-sopir`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
@endsection