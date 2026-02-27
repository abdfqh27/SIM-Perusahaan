@extends('admin.layouts.app')

@section('title', $judul)

@section('content')
<style>
    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.1), transparent);
        border-radius: 0 0 0 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-card-inner {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .icon-wrapper i {
        font-size: 2rem;
        color: white;
    }

    .stat-card:hover .icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }

    .icon-info {
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    }

    .icon-success {
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    .icon-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
    }

    .stat-content {
        flex: 1;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin: 0;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.95rem;
        color: #6c757d;
        margin: 0.5rem 0 0 0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Action Buttons Card */
    .action-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
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
        white-space: nowrap;
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

    /* Trend Indicators */
    .trend-indicator {
        font-size: 0.85rem;
        font-weight: 600;
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.3s ease;
    }

    .trend-up {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(32, 201, 151, 0.15));
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.3);
    }

    .trend-up:hover {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.25), rgba(32, 201, 151, 0.25));
        transform: scale(1.05);
    }

    .trend-down {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.15), rgba(200, 35, 51, 0.15));
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.3);
    }

    .trend-down:hover {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.25), rgba(200, 35, 51, 0.25));
        transform: scale(1.05);
    }

    /* Booking Detail Box */
    .booking-detail {
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.05), rgba(255, 183, 3, 0.05));
        padding: 0.75rem;
        border-radius: 10px;
        margin-bottom: 0.5rem;
        border-left: 3px solid var(--orange-primary);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .booking-detail::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 3px;
        height: 100%;
        background: linear-gradient(180deg, var(--orange-primary), var(--orange-secondary));
        transition: width 0.3s ease;
    }

    .booking-detail:hover {
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.1), rgba(255, 183, 3, 0.1));
        transform: translateX(5px);
        box-shadow: 0 3px 10px rgba(251, 133, 0, 0.2);
    }

    .booking-detail:hover::before {
        width: 100%;
        opacity: 0.05;
    }

    .booking-detail strong {
        color: var(--blue-dark);
        font-weight: 700;
        font-size: 0.9rem;
    }

    .booking-detail small {
        color: #6c757d;
        font-size: 0.8rem;
        display: block;
        margin-top: 0.25rem;
        line-height: 1.5;
    }

    .no-booking {
        color: #6c757d;
        font-style: italic;
        font-size: 0.85rem;
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
        .action-card,
        .admin-footer {
            display: none !important;
        }
        
        .admin-main {
            margin-left: 0 !important;
        }
        
        .stats-grid {
            page-break-inside: avoid;
        }

        .stat-card,
        .card {
            box-shadow: none !important;
            break-inside: avoid;
        }

        .table {
            page-break-inside: auto;
        }

        .table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-card-inner {
            gap: 1rem;
        }

        .icon-wrapper {
            width: 60px;
            height: 60px;
        }

        .icon-wrapper i {
            font-size: 1.75rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .stat-label {
            font-size: 0.85rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons a,
        .action-buttons button {
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

        .booking-detail {
            padding: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .stat-card-inner {
            flex-direction: column;
            text-align: center;
        }

        .stat-number {
            font-size: 1.75rem;
        }

        .empty-state i {
            font-size: 3rem;
        }
    }
</style>

<!-- Gradient Header -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
            <i class="fas fa-bus"></i>
        </div>
        <div>
            <h1 class="header-title">{{ $judul }}</h1>
            <p class="header-subtitle">Periode: {{ \App\Helpers\DateHelper::formatIndonesia($tanggalAwal) }} - {{ \App\Helpers\DateHelper::formatIndonesia($tanggalAkhir) }}</p>
        </div>
    </div>
</div>

<!-- Statistics Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-info">
                <i class="fas fa-bus"></i>
            </div>
            <div class="stat-content">
                <p class="stat-number">{{ $buses->count() }}</p>
                <p class="stat-label">Total Bus</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <p class="stat-number">{{ $buses->filter(function($bus) { return $bus->bookings->isEmpty(); })->count() }}</p>
                <p class="stat-label">Bus Tersedia</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-danger">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-content">
                <p class="stat-number">{{ $buses->filter(function($bus) { return $bus->bookings->isNotEmpty(); })->count() }}</p>
                <p class="stat-label">Bus Terpakai</p>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="action-card">
    <div class="action-buttons">
        <a href="{{ route('admin.laporan.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn-info">
            <i class="fas fa-print"></i> Cetak
        </button>
        <a href="{{ route('admin.laporan.ketersediaan-bus', array_merge(request()->all(), ['format' => 'pdf'])) }}" class="btn-danger">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Kode Bus</th>
                        <th width="15%">Nomor Polisi</th>
                        <th width="15%">Kategori</th>
                        <th width="15%">Sopir</th>
                        <th width="10%">Status</th>
                        <th width="25%">Detail Booking</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buses as $index => $bus)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $bus->kode_bus }}</strong></td>
                            <td>{{ $bus->nomor_polisi }}</td>
                            <td>{{ $bus->kategoriBus->nama_kategori ?? '-' }}</td>
                            <td>{{ $bus->sopir->nama_sopir ?? '-' }}</td>
                            <td>
                                @if($bus->bookings->isEmpty())
                                    <span class="trend-indicator trend-up">
                                        <i class="fas fa-check"></i> Tersedia
                                    </span>
                                @else
                                    <span class="trend-indicator trend-down">
                                        <i class="fas fa-times"></i> Terpakai
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($bus->bookings->isNotEmpty())
                                    @foreach($bus->bookings as $booking)
                                        <div class="booking-detail">
                                            <strong>{{ $booking->kode_booking }}</strong>
                                            <small>
                                                Tujuan: {{ $booking->tujuan }}<br>
                                                {{ \App\Helpers\DateHelper::formatIndonesia($booking->tanggal_berangkat) }} - 
                                                {{ \App\Helpers\DateHelper::formatIndonesia($booking->tanggal_selesai) }}
                                            </small>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="no-booking">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-bus-alt"></i>
                                    <p>Tidak ada data bus</p>
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