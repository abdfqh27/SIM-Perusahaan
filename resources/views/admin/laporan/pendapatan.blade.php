@extends('admin.layouts.app')

@section('title', $judul)

@section('content')
<style>
    .analysis-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .analysis-section:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .analysis-title {
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

    .analysis-title i {
        color: var(--orange-primary);
        font-size: 1.5rem;
    }

    .analysis-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .analysis-item {
        padding: 1.5rem;
        background: white;
        border-radius: 12px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .analysis-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--orange-primary), var(--orange-secondary));
        transition: width 0.3s ease;
    }

    .analysis-item:hover {
        border-color: var(--orange-primary);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(251, 133, 0, 0.2);
    }

    .analysis-item:hover::before {
        width: 100%;
        opacity: 0.05;
    }

    .analysis-item h5 {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 0 0 0.75rem 0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .analysis-item-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .analysis-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--blue-dark);
        line-height: 1;
    }

    .analysis-count {
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.1), rgba(255, 183, 3, 0.1));
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        color: var(--orange-primary);
        font-size: 0.85rem;
        white-space: nowrap;
        border: 1px solid rgba(251, 133, 0, 0.2);
    }

    .report-header {
        margin-bottom: 2rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    /* Badge Styling */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
    }

    .badge-warning {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
        box-shadow: 0 3px 10px rgba(255, 193, 7, 0.3);
    }

    .badge-secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
        box-shadow: 0 3px 10px rgba(108, 117, 125, 0.3);
    }

    /* Table Styling */
    .table thead th {
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border: none;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: linear-gradient(90deg, rgba(251, 133, 0, 0.05), transparent);
        transform: scale(1.002);
    }

    .table tbody td strong {
        color: var(--blue-dark);
        font-weight: 700;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
        display: block;
    }

    .empty-state p {
        color: #6c757d;
        margin: 0;
        font-size: 1rem;
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

        .analysis-section,
        .card {
            box-shadow: none !important;
            break-inside: avoid;
        }
    }

    @media (max-width: 768px) {
        .analysis-grid {
            grid-template-columns: 1fr;
        }

        .analysis-item-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .analysis-value {
            font-size: 1.25rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn-primary,
        .action-buttons .btn-secondary,
        .action-buttons .btn-info,
        .action-buttons .btn-danger,
        .action-buttons .btn-success {
            width: 100%;
            justify-content: center;
        }

        .table {
            font-size: 0.85rem;
        }

        .table thead th,
        .table tbody td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>

<!-- Gradient Header -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-money-bill-wave"></i>
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
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <p class="stat-number">{{ \App\Helpers\DateHelper::formatRupiah($totalLunas) }}</p>
                <p class="stat-label">Sudah Lunas</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-info">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="stat-content">
                <p class="stat-number">{{ \App\Helpers\DateHelper::formatRupiah($totalDP) }}</p>
                <p class="stat-label">Total DP</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <p class="stat-number">{{ \App\Helpers\DateHelper::formatRupiah($totalBelumLunas) }}</p>
                <p class="stat-label">Belum Lunas</p>
            </div>
        </div>
    </div>
</div>

<!-- Analysis by Status -->
<div class="analysis-section">
    <h3 class="analysis-title">
        <i class="fas fa-chart-pie"></i>
        Analisis Berdasarkan Status Pembayaran
    </h3>
    <div class="analysis-grid">
        @foreach($byStatusPembayaran as $status => $data)
            <div class="analysis-item">
                <h5>{{ ucfirst($status) }}</h5>
                <div class="analysis-item-content">
                    <div class="analysis-value">{{ \App\Helpers\DateHelper::formatRupiah($data['total']) }}</div>
                    <div class="analysis-count">{{ $data['count'] }} transaksi</div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Analysis by Kategori Bus -->
<div class="analysis-section">
    <h3 class="analysis-title">
        <i class="fas fa-bus"></i>
        Analisis Berdasarkan Kategori Bus
    </h3>
    <div class="analysis-grid">
        @foreach($byKategoriBus as $kategori => $data)
            <div class="analysis-item">
                <h5>{{ $kategori }}</h5>
                <div class="analysis-item-content">
                    <div class="analysis-value">{{ \App\Helpers\DateHelper::formatRupiah($data['total']) }}</div>
                    <div class="analysis-count">{{ $data['count'] }} booking</div>
                </div>
            </div>
        @endforeach
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
        <a href="{{ route('admin.laporan.pendapatan', array_merge(request()->all(), ['format' => 'pdf'])) }}" class="btn-danger">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
        <a href="{{ route('admin.laporan.pendapatan', array_merge(request()->all(), ['format' => 'excel'])) }}" class="btn-success">
            <i class="fas fa-file-excel"></i> Download Excel
        </a>
    </div>
</div>

<!-- Detail Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Detail Transaksi</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Booking</th>
                        <th>Tanggal</th>
                        <th>Pemesan</th>
                        <th>Tujuan</th>
                        <th>Total Bayar</th>
                        <th>DP</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $booking->kode_booking }}</strong></td>
                            <td>{{ \App\Helpers\DateHelper::formatIndonesia($booking->tanggal_berangkat) }}</td>
                            <td>{{ $booking->nama_pemesan }}</td>
                            <td>{{ $booking->tujuan }}</td>
                            <td><strong>{{ \App\Helpers\DateHelper::formatRupiah($booking->total_pembayaran) }}</strong></td>
                            <td>{{ \App\Helpers\DateHelper::formatRupiah($booking->nominal_dp ?? 0) }}</td>
                            <td>
                                @if($booking->status_pembayaran == 'lunas')
                                    <span class="badge badge-success">Lunas</span>
                                @elseif($booking->status_pembayaran == 'dp')
                                    <span class="badge badge-warning">DP</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($booking->status_pembayaran) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-receipt"></i>
                                    <p>Tidak ada data transaksi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection