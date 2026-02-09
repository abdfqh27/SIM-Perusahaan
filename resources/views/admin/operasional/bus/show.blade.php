@extends('admin.layouts.app')

@section('title', 'Detail Bus')

@section('content')
<style>
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

/* Info Box Styling */
.info-box {
    padding: 1.25rem;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.info-box-label {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-box-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--blue-dark);
}

.info-box-large {
    font-size: 1.5rem;
    font-weight: 700;
}

/* Status Real-time Display */
.status-realtime-display {
    text-align: center;
    padding: 2rem 1rem;
}

.status-icon-wrapper {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.status-icon-wrapper i {
    font-size: 3rem;
}

/* License Plate Display */
.license-plate-display {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background: white;
    border: 3px solid #212529;
    border-radius: 8px;
    font-size: 1.5rem;
    font-weight: 700;
    font-family: 'Courier New', monospace;
    letter-spacing: 3px;
    color: #212529;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

/* Booking Active Info */
.booking-active-info {
    margin-top: 1.5rem;
    padding: 1rem;
    background: linear-gradient(135deg, rgba(33, 158, 188, 0.05), rgba(142, 202, 230, 0.05));
    border-radius: 8px;
    border-left: 3px solid var(--blue-light);
}

/* Quick Actions */
.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

/* Responsive */
@media (max-width: 768px) {
    .license-plate-display {
        font-size: 1.2rem;
        letter-spacing: 2px;
        padding: 0.5rem 1rem;
    }
}
</style>

<div class="admin-content">
    <!-- Page Header -->
    <div class="gradient-header">
        <div class="header-left">
            <a href="{{ route('admin.operasional.bus.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <h2 class="header-title">Detail Bus</h2>
                <p class="header-subtitle">Informasi lengkap bus {{ $bu->nama_bus }}</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.operasional.bus.edit', $bu->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
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

    <div class="row">
        <!-- Left Column - Bus Information -->
        <div class="col-lg-8 mb-4">
            <!-- Main Info Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-bus me-2"></i>
                    Informasi Bus
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Kode Bus -->
                        <div class="col-md-6 mb-4">
                            <div class="info-box" style="
                                background: linear-gradient(135deg, rgba(251, 133, 0, 0.05), rgba(255, 183, 3, 0.05));
                                border-left: 4px solid var(--orange-primary);
                            ">
                                <div class="info-box-label">
                                    <i class="fas fa-barcode"></i>
                                    Kode Bus
                                </div>
                                <div class="info-box-value info-box-large" style="
                                    color: var(--orange-primary);
                                    font-family: 'Courier New', monospace;
                                ">
                                    {{ $bu->kode_bus }}
                                </div>
                            </div>
                        </div>

                        <!-- Nama Bus -->
                        <div class="col-md-6 mb-4">
                            <div class="info-box" style="
                                background: linear-gradient(135deg, rgba(33, 158, 188, 0.05), rgba(142, 202, 230, 0.05));
                                border-left: 4px solid var(--blue-light);
                            ">
                                <div class="info-box-label">
                                    <i class="fas fa-tag"></i>
                                    Nama Bus
                                </div>
                                <div class="info-box-value" style="font-size: 1.25rem;">
                                    {{ $bu->nama_bus }}
                                </div>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6 mb-4">
                            <div class="info-box" style="
                                background: #f8f9fa;
                                border: 2px solid #e9ecef;
                            ">
                                <div class="info-box-label">
                                    <i class="fas fa-th-large"></i>
                                    Kategori Bus
                                </div>
                                <div class="info-box-value">
                                    {{ $bu->kategoriBus->nama_kategori ?? '-' }}
                                </div>
                                @if($bu->kategoriBus)
                                <div style="margin-top: 0.5rem; font-size: 0.9rem; color: #6c757d;">
                                    <i class="fas fa-chair me-1"></i>
                                    {{ $bu->kategoriBus->jumlah_seat }} Kursi
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Sopir -->
                        <div class="col-md-6 mb-4">
                            <div class="info-box" style="
                                background: #f8f9fa;
                                border: 2px solid #e9ecef;
                            ">
                                <div class="info-box-label">
                                    <i class="fas fa-user-tie"></i>
                                    Sopir
                                </div>
                                <div class="info-box-value">
                                    {{ $bu->sopir->nama_sopir ?? '-' }}
                                </div>
                                @if($bu->sopir)
                                <div style="margin-top: 0.5rem; font-size: 0.9rem; color: #6c757d;">
                                    <i class="fas fa-phone me-1"></i>
                                    {{ $bu->sopir->no_hp }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Warna -->
                        <div class="col-md-6 mb-4">
                            <div class="info-box" style="
                                background: #f8f9fa;
                                border: 2px solid #e9ecef;
                            ">
                                <div class="info-box-label">
                                    <i class="fas fa-palette"></i>
                                    Warna Bus
                                </div>
                                <div class="info-box-value" style="font-size: 1.25rem; margin-top: 0.25rem;">
                                    {{ ucfirst($bu->warna_bus) }}
                                </div>
                            </div>
                        </div>

                        <!-- Nomor Polisi -->
                        <div class="col-md-6 mb-4">
                            <div class="info-box" style="
                                background: #f8f9fa;
                                border: 2px solid #e9ecef;
                            ">
                                <div class="info-box-label">
                                    <i class="fas fa-car"></i>
                                    Nomor Polisi
                                </div>
                                <div style="margin-top: 0.75rem;">
                                    <div class="license-plate-display">
                                        {{ $bu->nomor_polisi }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings Card -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-history me-2"></i>
                    Riwayat Booking Terakhir
                </div>
                <div class="card-body">
                    @if($bu->bookings && $bu->bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode Booking</th>
                                    <th>Tanggal</th>
                                    <th>Nama Pemesan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bu->bookings as $booking)
                                <tr>
                                    <td>
                                        <strong style="color: var(--orange-primary);">
                                            {{ $booking->kode_booking }}
                                        </strong>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $booking->tanggal_berangkat->format('d/m/Y') }}
                                        <i class="fas fa-arrow-right mx-1"></i>
                                        {{ $booking->tanggal_selesai->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <i class="fas fa-user me-1"></i>
                                        {{ $booking->nama_pemesan ?? '-' }}
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'draft' => ['bg' => 'rgba(108, 117, 125, 0.1)', 'color' => '#6c757d', 'icon' => 'fa-edit'],
                                                'confirmed' => ['bg' => 'rgba(40, 167, 69, 0.1)', 'color' => '#28a745', 'icon' => 'fa-check-circle'],
                                                'selesai' => ['bg' => 'rgba(33, 158, 188, 0.1)', 'color' => '#219EBC', 'icon' => 'fa-flag-checkered'],
                                                'batal' => ['bg' => 'rgba(220, 53, 69, 0.1)', 'color' => '#dc3545', 'icon' => 'fa-times-circle'],
                                            ];
                                            $statusConfig = $statusColors[$booking->status_booking] ?? $statusColors['draft'];
                                        @endphp
                                        <span style="
                                            background: {{ $statusConfig['bg'] }};
                                            color: {{ $statusConfig['color'] }};
                                            padding: 0.35rem 0.75rem;
                                            border-radius: 6px;
                                            font-size: 0.85rem;
                                            font-weight: 600;
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 0.4rem;
                                        ">
                                            <i class="fas {{ $statusConfig['icon'] }}"></i>
                                            {{ ucfirst($booking->status_booking) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center" style="padding: 3rem;">
                        <i class="fas fa-calendar-times" style="font-size: 3rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                        <p style="color: #6c757d; margin: 0;">Belum ada riwayat booking</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Status & Actions -->
        <div class="col-lg-4">
            <!-- Status Real-time Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-signal me-2"></i>
                    Status Real-time
                </div>
                <div class="card-body">
                    @php
                        $statusConfig = [
                            'tersedia' => [
                                'color' => '#28a745',
                                'bg' => 'rgba(40, 167, 69, 0.1)',
                                'icon' => 'fa-check-circle',
                                'text' => 'Tersedia',
                                'desc' => 'Bus siap untuk booking'
                            ],
                            'dipakai' => [
                                'color' => '#219EBC',
                                'bg' => 'rgba(33, 158, 188, 0.1)',
                                'icon' => 'fa-route',
                                'text' => 'Sedang Dipakai',
                                'desc' => 'Bus dalam perjalanan'
                            ],
                            'perawatan' => [
                                'color' => '#ffc107',
                                'bg' => 'rgba(255, 193, 7, 0.1)',
                                'icon' => 'fa-tools',
                                'text' => 'Perawatan',
                                'desc' => 'Bus sedang maintenance'
                            ]
                        ];
                        $config = $statusConfig[$statusRealtime] ?? $statusConfig['tersedia'];
                    @endphp
                    
                    <div class="status-realtime-display">
                        <div class="status-icon-wrapper" style="
                            background: {{ $config['bg'] }};
                            box-shadow: 0 5px 15px {{ $config['bg'] }};
                        ">
                            <i class="fas {{ $config['icon'] }}" style="color: {{ $config['color'] }};"></i>
                        </div>
                        <h4 style="color: {{ $config['color'] }}; font-weight: 700; margin-bottom: 0.5rem;">
                            {{ $config['text'] }}
                        </h4>
                        <p style="color: #6c757d; margin: 0;">
                            {{ $config['desc'] }}
                        </p>
                    </div>

                    @if($bookingAktif)
                    <div class="booking-active-info">
                        <div style="font-size: 0.85rem; color: #6c757d; margin-bottom: 0.5rem;">
                            <i class="fas fa-info-circle me-1"></i>
                            Booking Aktif
                        </div>
                        <div style="font-weight: 600; color: var(--blue-dark); margin-bottom: 0.5rem;">
                            {{ $bookingAktif->kode_booking }}
                        </div>
                        <div style="font-size: 0.85rem; color: #6c757d; margin-bottom: 0.5rem;">
                            <i class="fas fa-user me-1"></i>
                            {{ $bookingAktif->nama_pemesan }}
                        </div>
                        <div style="font-size: 0.85rem; color: #6c757d;">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $bookingAktif->tanggal_berangkat->format('d/m/Y') }} - 
                            {{ $bookingAktif->tanggal_selesai->format('d/m/Y') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Update Status Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Ubah Status Bus
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.operasional.bus.update-status', $bu->id) }}" method="POST" id="updateStatusForm">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: var(--blue-dark);">
                                Status Saat Ini
                            </label>
                            <div style="padding: 0.75rem 1rem; background: #f8f9fa; border-radius: 8px; border: 2px solid #e9ecef;">
                                @if($bu->status == 'aktif')
                                <span style="color: #28a745; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-check-circle"></i>
                                    Aktif
                                </span>
                                @else
                                <span style="color: #ffc107; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-tools"></i>
                                    Perawatan
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: var(--blue-dark);">
                                Ubah Ke
                            </label>
                            <select name="status" class="form-control" style="padding: 0.75rem 1rem; border: 2px solid #e9ecef; border-radius: 8px;">
                                <option value="aktif" {{ $bu->status == 'aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="perawatan" {{ $bu->status == 'perawatan' ? 'selected' : '' }}>
                                    Perawatan
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i>
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bolt me-2"></i>
                    Aksi Cepat
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <a href="{{ route('admin.operasional.bus.edit', $bu->id) }}" class="btn btn-warning w-100">
                            <i class="fas fa-edit"></i>
                            Edit Data Bus
                        </a>
                        
                        @if($bu->sopir_id)
                        <button type="button" 
                                class="btn btn-info w-100" 
                                onclick="confirmRemoveSopir('{{ $bu->id }}', '{{ $bu->nama_bus }}', '{{ $bu->sopir->nama_sopir }}')">
                            <i class="fas fa-user-minus"></i>
                            Lepas Sopir
                        </button>
                        @endif
                        
                        <form action="{{ route('admin.operasional.bus.destroy', $bu->id) }}" 
                              method="POST"
                              class="delete-form"
                              data-bus-name="{{ $bu->nama_bus }}"
                              data-has-sopir="{{ $bu->sopir_id ? 'true' : 'false' }}"
                              data-sopir-name="{{ $bu->sopir->nama_sopir ?? '' }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i>
                                Hapus Bus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                                <span style="color: #17a2b8;"><i class="fas fa-user-minus"></i> Lepas Sopir</span>
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

    // HANDLE UPDATE STATUS CONFIRMATION
    const updateStatusForm = document.getElementById('updateStatusForm');
    if (updateStatusForm) {
        updateStatusForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const statusSelect = this.querySelector('select[name="status"]');
            const newStatus = statusSelect.value;
            const newStatusText = statusSelect.options[statusSelect.selectedIndex].text;
            
            Swal.fire({
                title: 'Konfirmasi Perubahan Status',
                html: `Apakah Anda yakin ingin mengubah status bus menjadi <strong>${newStatusText}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-save"></i> Ya, Update!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    updateStatusForm.submit();
                }
            });
        });
    }
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
        confirmButtonColor: '#17a2b8',
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
@endsection