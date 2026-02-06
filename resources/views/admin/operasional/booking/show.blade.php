@extends('admin.layouts.app')

@section('title', 'Detail Booking')

@section('content')
<style>
    .detail-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--orange-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .section-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .info-row {
        display: flex;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-label {
        font-weight: 600;
        color: #6c757d;
        width: 200px;
        flex-shrink: 0;
    }
    .info-value {
        color: var(--blue-dark);
        flex: 1;
    }
    .status-badge {
        padding: 0.5rem 1.25rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .status-draft {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }
    .status-confirmed {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }
    .status-selesai {
        background: linear-gradient(135deg, #219EBC, #8ECAE6);
        color: white;
    }
    .status-batal {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }
    .pembayaran-badge {
        padding: 0.5rem 1rem;
        border-radius: 15px;
        font-size: 0.9rem;
        font-weight: 600;
    }
    .pembayaran-belum {
        background: #f8d7da;
        color: #721c24;
    }
    .pembayaran-dp {
        background: #fff3cd;
        color: #856404;
    }
    .pembayaran-lunas {
        background: #d4edda;
        color: #155724;
    }
    .bus-item {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-left: 4px solid var(--orange-primary);
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
    }
    .bus-name {
        font-weight: 700;
        color: var(--blue-dark);
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    .bus-info-item {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.3rem;
    }
    .action-card {
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .booking-header-card {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(251, 133, 0, 0.3);
    }
    .booking-code {
        font-size: 2rem;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        margin-bottom: 0.5rem;
    }
    .booking-date {
        font-size: 0.95rem;
        opacity: 0.9;
    }
    .price-display {
        background: white;
        color: var(--orange-primary);
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
        margin-top: 1rem;
    }
    .price-label {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    .price-amount {
        font-size: 2rem;
        font-weight: 700;
    }
    .timeline-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        position: relative;
    }
    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 15px;
        top: 50px;
        width: 2px;
        height: calc(100% - 20px);
        background: linear-gradient(180deg, var(--orange-primary), transparent);
    }
    .timeline-icon {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(251, 133, 0, 0.3);
    }
    .timeline-content {
        flex: 1;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-file-invoice"></i>
        </div>
        <div>
            <h4 class="page-title mb-0">Detail Booking</h4>
            <p class="page-subtitle">Informasi lengkap booking</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.operasional.booking.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>

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

<!-- Booking Header Card -->
<div class="booking-header-card">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="booking-code">
                <i class="fas fa-ticket-alt me-2"></i>
                {{ $booking->kode_booking }}
            </div>
            <div class="booking-date">
                <i class="far fa-calendar-alt me-2"></i>
                Dibuat pada: {{ $booking->created_at->format('d F Y, H:i') }} WIB
            </div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="mb-2">
                <span class="status-badge status-{{ $booking->status_booking }}">
                    @if($booking->status_booking == 'draft')
                        <i class="fas fa-file-alt"></i> Draft
                    @elseif($booking->status_booking == 'confirmed')
                        <i class="fas fa-check-circle"></i> Confirmed
                    @elseif($booking->status_booking == 'selesai')
                        <i class="fas fa-flag-checkered"></i> Selesai
                    @else
                        <i class="fas fa-times-circle"></i> Batal
                    @endif
                </span>
            </div>
            <div>
                <span class="pembayaran-badge pembayaran-{{ $booking->status_pembayaran }}">
                    @if($booking->status_pembayaran == 'belum_bayar')
                        <i class="fas fa-times-circle"></i> Belum Bayar
                    @elseif($booking->status_pembayaran == 'dp')
                        <i class="fas fa-hourglass-half"></i> DP
                    @else
                        <i class="fas fa-check-circle"></i> Lunas
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
@if(in_array($booking->status_booking, ['draft', 'confirmed']))
<div class="action-card">
    <h6 class="mb-3"><i class="fas fa-tasks me-2"></i>Tindakan Cepat</h6>
    <div class="action-buttons">
        <a href="{{ route('admin.operasional.booking.edit', $booking->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Booking
        </a>
        
        @if($booking->status_booking == 'draft')
        <form action="{{ route('admin.operasional.booking.update-status', $booking->id) }}" 
              method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status_booking" value="confirmed">
            <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi booking ini?')">
                <i class="fas fa-check"></i> Konfirmasi Booking
            </button>
        </form>
        @endif
        
        @if($booking->status_booking == 'confirmed')
        <form action="{{ route('admin.operasional.booking.update-status', $booking->id) }}" 
              method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status_booking" value="selesai">
            <button type="submit" class="btn btn-info" onclick="return confirm('Tandai booking sebagai selesai?')">
                <i class="fas fa-flag-checkered"></i> Tandai Selesai
            </button>
        </form>
        
        <form action="{{ route('admin.operasional.booking.update-status', $booking->id) }}" 
              method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status_booking" value="batal">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Batalkan booking ini?')">
                <i class="fas fa-ban"></i> Batalkan Booking
            </button>
        </form>
        @endif
    </div>
</div>
@endif

<div class="row">
    <!-- Left Column -->
    <div class="col-md-8">
        <!-- Data Pemesan -->
        <div class="detail-section">
            <h5 class="section-title">
                <span class="section-icon">
                    <i class="fas fa-user"></i>
                </span>
                Data Pemesan
            </h5>
            
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-user me-2"></i>Nama Pemesan
                </div>
                <div class="info-value">{{ $booking->nama_pemesan }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-phone me-2"></i>No. HP
                </div>
                <div class="info-value">
                    <a href="tel:{{ $booking->no_hp_pemesan }}" class="text-decoration-none">
                        {{ $booking->no_hp_pemesan }}
                    </a>
                </div>
            </div>
            
            @if($booking->email_pemesan)
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-envelope me-2"></i>Email
                </div>
                <div class="info-value">
                    <a href="mailto:{{ $booking->email_pemesan }}" class="text-decoration-none">
                        {{ $booking->email_pemesan }}
                    </a>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Detail Perjalanan -->
        <div class="detail-section">
            <h5 class="section-title">
                <span class="section-icon">
                    <i class="fas fa-route"></i>
                </span>
                Detail Perjalanan
            </h5>
            
            <div class="timeline-item">
                <div class="timeline-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="timeline-content">
                    <strong>Tempat Jemput</strong>
                    <p class="mb-0 text-muted">{{ $booking->tempat_jemput }}</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="timeline-content">
                    <strong>Tanggal Berangkat</strong>
                    <p class="mb-0 text-muted">
                        {{ $booking->tanggal_berangkat->format('d F Y') }}
                        <span class="badge bg-primary ms-2">{{ $booking->jam_berangkat }}</span>
                    </p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-icon">
                    <i class="fas fa-flag-checkered"></i>
                </div>
                <div class="timeline-content">
                    <strong>Tujuan & Tanggal Selesai</strong>
                    <p class="mb-1"><i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $booking->tujuan }}</p>
                    <p class="mb-0 text-muted">
                        {{ $booking->tanggal_selesai->format('d F Y') }}
                        <span class="badge bg-info ms-2">{{ $durasi }} hari perjalanan</span>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Bus yang Digunakan -->
        <div class="detail-section">
            <h5 class="section-title">
                <span class="section-icon">
                    <i class="fas fa-bus"></i>
                </span>
                Bus yang Digunakan ({{ $booking->buses->count() }})
            </h5>
            
            @forelse($booking->buses as $bus)
            <div class="bus-item">
                <div class="bus-name">
                    <i class="fas fa-bus me-2"></i>{{ $bus->nama_bus }}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="bus-info-item">
                            <i class="fas fa-tag me-2"></i>
                            <strong>Kode:</strong> {{ $bus->kode_bus }}
                        </div>
                        <div class="bus-info-item">
                            <i class="fas fa-list me-2"></i>
                            <strong>Kategori:</strong> {{ $bus->kategoriBus->nama_kategori ?? '-' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bus-info-item">
                            <i class="fas fa-id-card me-2"></i>
                            <strong>No. Polisi:</strong> {{ $bus->nomor_polisi }}
                        </div>
                        <div class="bus-info-item">
                            <i class="fas fa-user-tie me-2"></i>
                            <strong>Sopir:</strong> {{ $bus->sopir->nama ?? 'Belum ditentukan' }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted text-center py-3">
                <i class="fas fa-info-circle me-2"></i>Belum ada bus yang dipilih
            </p>
            @endforelse
        </div>
        
        <!-- Catatan -->
        @if($booking->catatan)
        <div class="detail-section">
            <h5 class="section-title">
                <span class="section-icon">
                    <i class="fas fa-sticky-note"></i>
                </span>
                Catatan
            </h5>
            
            <div class="alert alert-info mb-0">
                <i class="fas fa-info-circle me-2"></i>
                {{ $booking->catatan }}
            </div>
        </div>
        @endif
    </div>
    
    <!-- Right Column -->
    <div class="col-md-4">
        <!-- Informasi Pembayaran -->
        <div class="detail-section">
            <h5 class="section-title">
                <span class="section-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </span>
                Pembayaran
            </h5>
            
            <div class="info-row">
                <div class="info-label">Total Pembayaran</div>
                <div class="info-value">
                    <strong style="color: var(--orange-primary); font-size: 1.25rem;">
                        Rp {{ number_format($booking->total_pembayaran, 0, ',', '.') }}
                    </strong>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Metode</div>
                <div class="info-value">
                    <span class="badge bg-secondary">
                        @if($booking->metode_pembayaran == 'cash')
                            <i class="fas fa-money-bill me-1"></i>Cash
                        @else
                            <i class="fas fa-university me-1"></i>Transfer
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Status Pembayaran</div>
                <div class="info-value">
                    <span class="pembayaran-badge pembayaran-{{ $booking->status_pembayaran }}">
                        @if($booking->status_pembayaran == 'belum_bayar')
                            Belum Bayar
                        @elseif($booking->status_pembayaran == 'dp')
                            DP
                        @else
                            Lunas
                        @endif
                    </span>
                </div>
            </div>
            
            @if($booking->status_pembayaran == 'dp')
            <div class="info-row">
                <div class="info-label">Nominal DP</div>
                <div class="info-value">
                    <strong style="color: #ffc107;">
                        Rp {{ number_format($booking->nominal_dp, 0, ',', '.') }}
                    </strong>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Sisa Pembayaran</div>
                <div class="info-value">
                    <strong style="color: #dc3545;">
                        Rp {{ number_format($booking->total_pembayaran - $booking->nominal_dp, 0, ',', '.') }}
                    </strong>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Informasi Sistem -->
        <div class="detail-section">
            <h5 class="section-title">
                <span class="section-icon">
                    <i class="fas fa-info-circle"></i>
                </span>
                Informasi Sistem
            </h5>
            
            <div class="info-row">
                <div class="info-label">
                    <i class="far fa-calendar-plus me-2"></i>Dibuat
                </div>
                <div class="info-value">
                    <small>{{ $booking->created_at->format('d/m/Y H:i') }}</small>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">
                    <i class="far fa-calendar-check me-2"></i>Diperbarui
                </div>
                <div class="info-value">
                    <small>{{ $booking->updated_at->format('d/m/Y H:i') }}</small>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-hashtag me-2"></i>ID Booking
                </div>
                <div class="info-value">
                    <code>{{ $booking->id }}</code>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="detail-section">
            <h5 class="section-title">
                <span class="section-icon">
                    <i class="fas fa-print"></i>
                </span>
                Aksi Lainnya
            </h5>
            
            <div class="d-grid gap-2">
                <button class="btn btn-outline-primary" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Cetak Detail
                </button>
                
                @if(in_array($booking->status_booking, ['draft', 'batal']))
                <form action="{{ route('admin.operasional.booking.destroy', $booking->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus booking ini? Data tidak dapat dikembalikan!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fas fa-trash me-2"></i>Hapus Booking
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<style media="print">
    .page-header, .admin-navbar, .admin-sidebar, .admin-footer, 
    .action-card, .btn, button, .header-actions {
        display: none !important;
    }
    .detail-section {
        box-shadow: none;
        page-break-inside: avoid;
    }
    body {
        background: white !important;
    }
</style>
@endsection