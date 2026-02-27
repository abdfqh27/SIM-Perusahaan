@extends('admin.layouts.app')

@section('title', $judul)

@section('content')
<style>
    .rekap-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .rekap-section:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid var(--orange-primary);
    }

    .section-title i {
        color: var(--orange-primary);
        font-size: 1.5rem;
    }

    .rekap-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .rekap-item {
        padding: 1.5rem;
        background: white;
        border-radius: 12px;
        text-align: center;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .rekap-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--orange-primary), var(--orange-secondary));
        transition: width 0.3s ease;
    }

    .rekap-item:hover {
        border-color: var(--orange-primary);
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(251, 133, 0, 0.2);
    }

    .rekap-item:hover::before {
        width: 100%;
        opacity: 0.05;
    }

    .rekap-item h5 {
        font-size: 0.85rem;
        color: #6c757d;
        margin: 0 0 0.75rem 0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .rekap-item p {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin: 0;
        line-height: 1;
    }

    .top-destinations {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .destination-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
        background: white;
        border-radius: 12px;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
        position: relative;
        overflow: hidden;
    }

    .destination-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(90deg, rgba(251, 133, 0, 0.1), transparent);
        transition: width 0.3s ease;
    }

    .destination-item:hover {
        border-color: var(--orange-primary);
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.15);
    }

    .destination-item:hover::before {
        width: 100%;
    }

    .destination-name {
        font-weight: 600;
        color: var(--blue-dark);
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 1rem;
    }

    .destination-rank {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(251, 133, 0, 0.3);
        transition: all 0.3s ease;
    }

    .destination-item:hover .destination-rank {
        transform: scale(1.15) rotate(5deg);
        box-shadow: 0 6px 15px rgba(251, 133, 0, 0.5);
    }

    .destination-count {
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.1), rgba(255, 183, 3, 0.1));
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        color: var(--orange-primary);
        font-size: 0.9rem;
        border: 1px solid rgba(251, 133, 0, 0.2);
        white-space: nowrap;
    }

    .report-header {
        margin-bottom: 2rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    /* Alert Styling */
    .alert-info {
        background: linear-gradient(135deg, rgba(33, 158, 188, 0.1), rgba(58, 176, 195, 0.1));
        border: 1px solid rgba(33, 158, 188, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        color: var(--blue-dark);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .alert-info i {
        font-size: 1.5rem;
        color: var(--blue-light);
    }

    @media print {
        .admin-sidebar,
        .admin-navbar,
        .report-header,
        .admin-footer {
            display: none !important;
        }
        
        .admin-main {
            margin-left: 0 !important;
        }

        .rekap-section {
            box-shadow: none !important;
            break-inside: avoid;
        }
    }

    @media (max-width: 768px) {
        .rekap-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .rekap-item p {
            font-size: 1.5rem;
        }

        .destination-item {
            flex-direction: column;
            gap: 0.75rem;
            text-align: center;
        }

        .destination-name {
            flex-direction: column;
            gap: 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn-primary,
        .action-buttons .btn-secondary,
        .action-buttons .btn-info,
        .action-buttons .btn-danger {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .rekap-grid {
            grid-template-columns: 1fr;
        }

        .rekap-section {
            padding: 1.5rem;
        }

        .destination-rank {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }
    }
</style>

<!-- Gradient Header -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div>
            <h1 class="header-title">{{ $judul }}</h1>
            <p class="header-subtitle">Periode: {{ $namaBulan }} {{ $tahun }}</p>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="report-header">
    <div class="action-buttons">
        <a href="{{ route('admin.laporan.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn-info">
            <i class="fas fa-print"></i> Cetak
        </button>
        <a href="{{ route('admin.laporan.rekap-bulanan', array_merge(request()->all(), ['format' => 'pdf'])) }}" class="btn-danger">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
    </div>
</div>

<!-- Rekap Booking -->
<div class="rekap-section">
    <h3 class="section-title">
        <i class="fas fa-calendar-check"></i>
        Rekap Booking
    </h3>
    <div class="rekap-grid">
        <div class="rekap-item">
            <h5>Total Booking</h5>
            <p>{{ $totalBooking }}</p>
        </div>
        <div class="rekap-item" style="border-left-color: #28a745;">
            <h5>Confirmed</h5>
            <p>{{ $bookingConfirmed }}</p>
        </div>
        <div class="rekap-item" style="border-left-color: #ffc107;">
            <h5>Pending</h5>
            <p>{{ $bookingPending }}</p>
        </div>
        <div class="rekap-item" style="border-left-color: #dc3545;">
            <h5>Cancelled</h5>
            <p>{{ $bookingCancelled }}</p>
        </div>
    </div>
</div>

<!-- Rekap Pendapatan -->
<div class="rekap-section">
    <h3 class="section-title">
        <i class="fas fa-money-bill-wave"></i>
        Rekap Pendapatan
    </h3>
    <div class="rekap-grid">
        <div class="rekap-item">
            <h5>Total Pendapatan</h5>
            <p style="font-size: 1.5rem;">{{ \App\Helpers\DateHelper::formatRupiah($totalPendapatan) }}</p>
        </div>
        <div class="rekap-item" style="border-left-color: #28a745;">
            <h5>Lunas</h5>
            <p style="font-size: 1.5rem;">{{ \App\Helpers\DateHelper::formatRupiah($pendapatanLunas) }}</p>
        </div>
        <div class="rekap-item" style="border-left-color: var(--blue-light);">
            <h5>Total DP</h5>
            <p style="font-size: 1.5rem;">{{ \App\Helpers\DateHelper::formatRupiah($totalDP) }}</p>
        </div>
    </div>
</div>

<!-- Rekap Bus -->
<div class="rekap-section">
    <h3 class="section-title">
        <i class="fas fa-bus"></i>
        Rekap Bus
    </h3>
    <div class="rekap-grid">
        <div class="rekap-item">
            <h5>Total Bus</h5>
            <p>{{ $totalBus }} Unit</p>
        </div>
        <div class="rekap-item" style="border-left-color: #28a745;">
            <h5>Bus Aktif</h5>
            <p>{{ $busAktif }} Unit</p>
        </div>
        <div class="rekap-item" style="border-left-color: #ffc107;">
            <h5>Perawatan</h5>
            <p>{{ $busPerawatan }} Unit</p>
        </div>
    </div>
</div>

<!-- Rekap Sopir -->
<div class="rekap-section">
    <h3 class="section-title">
        <i class="fas fa-user-tie"></i>
        Rekap Sopir
    </h3>
    <div class="rekap-grid">
        <div class="rekap-item">
            <h5>Total Sopir</h5>
            <p>{{ $totalSopir }} Orang</p>
        </div>
        <div class="rekap-item" style="border-left-color: #28a745;">
            <h5>Sopir Aktif</h5>
            <p>{{ $sopirAktif }} Orang</p>
        </div>
        <div class="rekap-item" style="border-left-color: #dc3545;">
            <h5>Non-Aktif</h5>
            <p>{{ $sopirNonAktif }} Orang</p>
        </div>
    </div>
</div>

<!-- Top Tujuan -->
<div class="rekap-section">
    <h3 class="section-title">
        <i class="fas fa-map-marked-alt"></i>
        Top 5 Tujuan Populer
    </h3>
    
    @if($topTujuan->count() > 0)
        <ul class="top-destinations">
            @foreach($topTujuan as $index => $tujuan)
                <li class="destination-item">
                    <div class="destination-name">
                        <span class="destination-rank">{{ $index + 1 }}</span>
                        <span>{{ $tujuan->tujuan }}</span>
                    </div>
                    <div class="destination-count">{{ $tujuan->total }} trip</div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> 
            <span>Belum ada data tujuan untuk periode ini</span>
        </div>
    @endif
</div>
@endsection