@extends('admin.layouts.app')

@section('title', $judul)

@section('content')
<style>
    .performance-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
        position: relative;
        overflow: hidden;
    }

    .performance-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--orange-primary), var(--orange-secondary));
        transition: width 0.3s ease;
    }

    .performance-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border-color: var(--orange-primary);
    }

    .performance-card:hover::before {
        width: 100%;
        opacity: 0.05;
    }

    .performance-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .bus-info h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin: 0;
    }

    .bus-info p {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 0.25rem 0 0 0;
    }

    .rank-badge {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .performance-card:hover .rank-badge {
        transform: scale(1.1) rotate(10deg);
    }

    .rank-1 { 
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        box-shadow: 0 4px 15px rgba(255, 215, 0, 0.5);
    }
    
    .rank-2 { 
        background: linear-gradient(135deg, #c0c0c0, #d4d4d4);
        box-shadow: 0 4px 15px rgba(192, 192, 192, 0.5);
    }
    
    .rank-3 { 
        background: linear-gradient(135deg, #cd7f32, #e89b6d);
        box-shadow: 0 4px 15px rgba(205, 127, 50, 0.5);
    }
    
    .rank-other { 
        background: linear-gradient(135deg, #6c757d, #5a6268);
    }

    .performance-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
    }

    .perf-stat-box {
        text-align: center;
        padding: 1rem;
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.05), rgba(255, 183, 3, 0.05));
        border-radius: 10px;
        border: 1px solid rgba(251, 133, 0, 0.1);
        transition: all 0.3s ease;
    }

    .perf-stat-box:hover {
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.1), rgba(255, 183, 3, 0.1));
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(251, 133, 0, 0.15);
    }

    .perf-stat-box h5 {
        font-size: 0.8rem;
        color: #6c757d;
        margin: 0 0 0.5rem 0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .perf-stat-box p {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin: 0;
        line-height: 1;
    }

    .top-performer {
        background: linear-gradient(135deg, rgba(255, 215, 0, 0.08), rgba(255, 237, 78, 0.08));
        border-color: #ffd700 !important;
    }

    .top-performer::before {
        background: linear-gradient(180deg, #ffd700, #ffed4e);
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

        .performance-card {
            box-shadow: none !important;
            break-inside: avoid;
        }
    }

    @media (max-width: 768px) {
        .performance-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .rank-badge {
            align-self: flex-end;
        }

        .performance-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .perf-stat-box p {
            font-size: 1rem;
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
        .performance-stats {
            grid-template-columns: 1fr;
        }

        .rank-badge {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
    }
</style>

<!-- Gradient Header -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-chart-bar"></i>
        </div>
        <div>
            <h1 class="header-title">{{ $judul }}</h1>
            <p class="header-subtitle">Periode: {{ $namaBulan }} {{ $tahun }}</p>
        </div>
    </div>
</div>

<!-- Summary Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-info">
                <i class="fas fa-bus"></i>
            </div>
            <div class="stat-content">
                <p class="stat-number">{{ $totalBus }}</p>
                <p class="stat-label">Total Bus</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-primary">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-content">
                <p class="stat-number">{{ \App\Helpers\DateHelper::formatRupiah($totalPendapatan) }}</p>
                <p class="stat-label">Total Pendapatan</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-success">
                <i class="fas fa-route"></i>
            </div>
            <div class="stat-content">
                <p class="stat-number">{{ $totalTrip }}</p>
                <p class="stat-label">Total Trip</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-secondary">
                <i class="fas fa-calculator"></i>
            </div>
            <div class="stat-content">
                <p class="stat-number">{{ $totalTrip > 0 ? \App\Helpers\DateHelper::formatRupiah($totalPendapatan / $totalTrip) : 'Rp 0' }}</p>
                <p class="stat-label">Rata-rata/Trip</p>
            </div>
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
        <a href="{{ route('admin.laporan.performa-bus', array_merge(request()->all(), ['format' => 'pdf'])) }}" class="btn-danger">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
    </div>
</div>

<!-- Performance Cards -->
<div>
    @forelse($buses as $index => $bus)
        <div class="performance-card {{ $index == 0 ? 'top-performer' : '' }}">
            <div class="performance-header">
                <div class="bus-info">
                    <h4>{{ $bus->nomor_bus }}</h4>
                    <p>
                        {{ $bus->kategoriBus->nama_kategori ?? '-' }} | 
                        Sopir: {{ $bus->sopir->nama ?? '-' }}
                    </p>
                </div>
                <div class="rank-badge {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : 'rank-other')) }}">
                    #{{ $index + 1 }}
                </div>
            </div>

            <div class="performance-stats">
                <div class="perf-stat-box">
                    <h5>Total Pendapatan</h5>
                    <p>{{ \App\Helpers\DateHelper::formatRupiah($bus->total_pendapatan) }}</p>
                </div>

                <div class="perf-stat-box">
                    <h5>Total Trip</h5>
                    <p>{{ $bus->total_trip }}</p>
                </div>

                <div class="perf-stat-box">
                    <h5>Total Hari</h5>
                    <p>{{ $bus->total_hari }} Hari</p>
                </div>

                <div class="perf-stat-box">
                    <h5>Rata-rata/Trip</h5>
                    <p>{{ \App\Helpers\DateHelper::formatRupiah($bus->rata_rata_per_trip) }}</p>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> 
            <span>Tidak ada data performa bus untuk periode ini</span>
        </div>
    @endforelse
</div>
@endsection