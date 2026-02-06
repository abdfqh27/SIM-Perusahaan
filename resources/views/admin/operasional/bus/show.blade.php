@extends('admin.layouts.app')

@section('title', 'Detail Bus')

@section('content')
<div class="admin-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <h1 class="page-title">Detail Bus</h1>
                <p class="page-subtitle">Informasi lengkap bus {{ $bu->nama_bus }}</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.operasional.bus.edit', $bu->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
            <a href="{{ route('admin.operasional.bus.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert-danger">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
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
                            <div style="
                                padding: 1.25rem;
                                background: linear-gradient(135deg, rgba(251, 133, 0, 0.05), rgba(255, 183, 3, 0.05));
                                border-radius: 12px;
                                border-left: 4px solid var(--orange-primary);
                            ">
                                <div style="
                                    font-size: 0.85rem;
                                    color: #6c757d;
                                    margin-bottom: 0.5rem;
                                    font-weight: 500;
                                ">
                                    <i class="fas fa-barcode me-1"></i>
                                    Kode Bus
                                </div>
                                <div style="
                                    font-size: 1.5rem;
                                    font-weight: 700;
                                    color: var(--orange-primary);
                                    font-family: 'Courier New', monospace;
                                ">
                                    {{ $bu->kode_bus }}
                                </div>
                            </div>
                        </div>

                        <!-- Nama Bus -->
                        <div class="col-md-6 mb-4">
                            <div style="
                                padding: 1.25rem;
                                background: linear-gradient(135deg, rgba(33, 158, 188, 0.05), rgba(142, 202, 230, 0.05));
                                border-radius: 12px;
                                border-left: 4px solid var(--blue-light);
                            ">
                                <div style="
                                    font-size: 0.85rem;
                                    color: #6c757d;
                                    margin-bottom: 0.5rem;
                                    font-weight: 500;
                                ">
                                    <i class="fas fa-tag me-1"></i>
                                    Nama Bus
                                </div>
                                <div style="
                                    font-size: 1.25rem;
                                    font-weight: 600;
                                    color: var(--blue-dark);
                                ">
                                    {{ $bu->nama_bus }}
                                </div>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6 mb-4">
                            <div style="
                                padding: 1.25rem;
                                background: #f8f9fa;
                                border-radius: 12px;
                                border: 2px solid #e9ecef;
                            ">
                                <div style="
                                    font-size: 0.85rem;
                                    color: #6c757d;
                                    margin-bottom: 0.5rem;
                                    font-weight: 500;
                                ">
                                    <i class="fas fa-th-large me-1"></i>
                                    Kategori Bus
                                </div>
                                <div style="
                                    font-size: 1.1rem;
                                    font-weight: 600;
                                    color: var(--blue-dark);
                                ">
                                    {{ $bu->kategoriBus->nama_kategori ?? '-' }}
                                </div>
                                @if($bu->kategoriBus)
                                <div style="
                                    margin-top: 0.5rem;
                                    font-size: 0.9rem;
                                    color: #6c757d;
                                ">
                                    <i class="fas fa-chair me-1"></i>
                                    {{ $bu->kategoriBus->jumlah_seat }} Kursi
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Sopir -->
                        <div class="col-md-6 mb-4">
                            <div style="
                                padding: 1.25rem;
                                background: #f8f9fa;
                                border-radius: 12px;
                                border: 2px solid #e9ecef;
                            ">
                                <div style="
                                    font-size: 0.85rem;
                                    color: #6c757d;
                                    margin-bottom: 0.5rem;
                                    font-weight: 500;
                                ">
                                    <i class="fas fa-user-tie me-1"></i>
                                    Sopir
                                </div>
                                <div style="
                                    font-size: 1.1rem;
                                    font-weight: 600;
                                    color: var(--blue-dark);
                                ">
                                    {{ $bu->sopir->nama ?? '-' }}
                                </div>
                                @if($bu->sopir)
                                <div style="
                                    margin-top: 0.5rem;
                                    font-size: 0.9rem;
                                    color: #6c757d;
                                ">
                                    <i class="fas fa-phone me-1"></i>
                                    {{ $bu->sopir->nomor_telepon }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Warna -->
                        <div class="col-md-6 mb-4">
                            <div style="
                                padding: 1.25rem;
                                background: #f8f9fa;
                                border-radius: 12px;
                                border: 2px solid #e9ecef;
                            ">
                                <div style="
                                    font-size: 0.85rem;
                                    color: #6c757d;
                                    margin-bottom: 0.75rem;
                                    font-weight: 500;
                                ">
                                    <i class="fas fa-palette me-1"></i>
                                    Warna Bus
                                </div>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="
                                        width: 60px;
                                        height: 60px;
                                        border-radius: 12px;
                                        background: {{ strtolower($bu->warna_bus) }};
                                        border: 3px solid #dee2e6;
                                        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
                                    "></div>
                                    <div>
                                        <div style="
                                            font-size: 1.1rem;
                                            font-weight: 600;
                                            color: var(--blue-dark);
                                        ">
                                            {{ ucfirst($bu->warna_bus) }}
                                        </div>
                                        <div style="
                                            font-size: 0.85rem;
                                            color: #6c757d;
                                            font-family: 'Courier New', monospace;
                                        ">
                                            {{ strtoupper($bu->warna_bus) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nomor Polisi -->
                        <div class="col-md-6 mb-4">
                            <div style="
                                padding: 1.25rem;
                                background: #f8f9fa;
                                border-radius: 12px;
                                border: 2px solid #e9ecef;
                            ">
                                <div style="
                                    font-size: 0.85rem;
                                    color: #6c757d;
                                    margin-bottom: 0.5rem;
                                    font-weight: 500;
                                ">
                                    <i class="fas fa-car me-1"></i>
                                    Nomor Polisi
                                </div>
                                <div style="
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
                                ">
                                    {{ $bu->nomor_polisi }}
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
                                    <th>Customer</th>
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
                                    <td>{{ $booking->customer->nama ?? '-' }}</td>
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
                    
                    <div style="
                        text-align: center;
                        padding: 2rem 1rem;
                    ">
                        <div style="
                            width: 100px;
                            height: 100px;
                            margin: 0 auto 1.5rem;
                            background: {{ $config['bg'] }};
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            box-shadow: 0 5px 15px {{ $config['bg'] }};
                        ">
                            <i class="fas {{ $config['icon'] }}" style="
                                font-size: 3rem;
                                color: {{ $config['color'] }};
                            "></i>
                        </div>
                        <h4 style="
                            color: {{ $config['color'] }};
                            font-weight: 700;
                            margin-bottom: 0.5rem;
                        ">
                            {{ $config['text'] }}
                        </h4>
                        <p style="color: #6c757d; margin: 0;">
                            {{ $config['desc'] }}
                        </p>
                    </div>

                    @if($bookingAktif)
                    <div style="
                        margin-top: 1.5rem;
                        padding: 1rem;
                        background: linear-gradient(135deg, rgba(33, 158, 188, 0.05), rgba(142, 202, 230, 0.05));
                        border-radius: 8px;
                        border-left: 3px solid var(--blue-light);
                    ">
                        <div style="
                            font-size: 0.85rem;
                            color: #6c757d;
                            margin-bottom: 0.5rem;
                        ">
                            <i class="fas fa-info-circle me-1"></i>
                            Booking Aktif
                        </div>
                        <div style="
                            font-weight: 600;
                            color: var(--blue-dark);
                            margin-bottom: 0.5rem;
                        ">
                            {{ $bookingAktif->kode_booking }}
                        </div>
                        <div style="
                            font-size: 0.85rem;
                            color: #6c757d;
                        ">
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
                    <form action="{{ route('admin.operasional.bus.update-status', $bu->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: var(--blue-dark);">
                                Status Saat Ini
                            </label>
                            <div style="
                                padding: 0.75rem 1rem;
                                background: #f8f9fa;
                                border-radius: 8px;
                                border: 2px solid #e9ecef;
                            ">
                                @if($bu->status == 'aktif')
                                <span style="
                                    color: #28a745;
                                    font-weight: 600;
                                    display: flex;
                                    align-items: center;
                                    gap: 0.5rem;
                                ">
                                    <i class="fas fa-check-circle"></i>
                                    Aktif
                                </span>
                                @else
                                <span style="
                                    color: #ffc107;
                                    font-weight: 600;
                                    display: flex;
                                    align-items: center;
                                    gap: 0.5rem;
                                ">
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
                            <select name="status" class="form-control" style="
                                padding: 0.75rem 1rem;
                                border: 2px solid #e9ecef;
                                border-radius: 8px;
                            ">
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
                <div class="card-body" style="padding: 1rem;">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <a href="{{ route('admin.operasional.bus.edit', $bu->id) }}" 
                           class="btn btn-warning w-100">
                            <i class="fas fa-edit"></i>
                            Edit Data Bus
                        </a>
                        <form action="{{ route('admin.operasional.bus.destroy', $bu->id) }}" 
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus bus {{ $bu->nama_bus }}?')">
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
@endsection