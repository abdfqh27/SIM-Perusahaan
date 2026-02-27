@extends('admin.layouts.app')

@section('title', $judul)

@section('content')
<style>
    .report-header {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .report-header:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(251, 133, 0, 0.15);
    }

    .report-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: white;
        border-radius: 12px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .info-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--orange-primary), var(--orange-secondary));
        transition: width 0.3s ease;
    }

    .info-item:hover {
        border-color: var(--orange-primary);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(251, 133, 0, 0.2);
    }

    .info-item:hover::before {
        width: 100%;
        opacity: 0.05;
    }

    .info-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.75rem;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.3);
        transition: all 0.3s ease;
    }

    .info-item:hover .info-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 6px 20px rgba(251, 133, 0, 0.5);
    }

    .info-content {
        flex: 1;
    }

    .info-content h4 {
        font-size: 0.85rem;
        color: #6c757d;
        margin: 0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-content p {
        font-size: 1.5rem;
        color: var(--blue-dark);
        margin: 0.5rem 0 0 0;
        font-weight: 700;
        line-height: 1;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-confirmed {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
    }

    .badge-pending {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
        box-shadow: 0 3px 10px rgba(255, 193, 7, 0.3);
    }

    .badge-cancelled {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
    }

    .bus-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .bus-item {
        padding: 0.5rem 0.75rem;
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.05), rgba(255, 183, 3, 0.05));
        border-radius: 8px;
        font-size: 0.85rem;
        border-left: 3px solid var(--orange-primary);
        transition: all 0.3s ease;
    }

    .bus-item:hover {
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.1), rgba(255, 183, 3, 0.1));
        transform: translateX(5px);
    }

    .bus-item strong {
        color: var(--blue-dark);
        font-weight: 600;
    }

    .bus-item .text-muted {
        color: #6c757d;
        font-size: 0.8rem;
    }

    .no-data {
        color: #6c757d;
        font-style: italic;
        font-size: 0.85rem;
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
        transform: scale(1.005);
    }

    .table tbody td strong {
        color: var(--blue-dark);
        font-weight: 700;
    }

    .table tbody td .text-muted {
        color: #6c757d;
        font-size: 0.85rem;
    }

    @media print {
        .admin-sidebar,
        .admin-navbar,
        .action-buttons,
        .admin-footer {
            display: none !important;
        }
        
        .admin-main {
            margin-left: 0 !important;
        }

        .report-header,
        .card {
            box-shadow: none !important;
        }

        .info-item {
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
        .report-header {
            padding: 1.5rem;
        }

        .report-info {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .info-item {
            padding: 1rem;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }

        .info-content p {
            font-size: 1.25rem;
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
    }
</style>

<!-- Gradient Header -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div>
            <h1 class="header-title">{{ $judul }}</h1>
            <p class="header-subtitle">Periode: {{ \App\Helpers\DateHelper::formatIndonesia($tanggalAwal) }} - {{ \App\Helpers\DateHelper::formatIndonesia($tanggalAkhir) }}</p>
        </div>
    </div>
</div>

<!-- Report Header -->
<div class="report-header">
    <div class="report-info">
        <div class="info-item">
            <div class="info-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="info-content">
                <h4>Total Jadwal</h4>
                <p>{{ $bookings->count() }} Keberangkatan</p>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon">
                <i class="fas fa-bus"></i>
            </div>
            <div class="info-content">
                <h4>Total Bus</h4>
                <p>{{ $bookings->flatMap->buses->unique('id')->count() }} Unit</p>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon">
                <i class="fas fa-map-marked-alt"></i>
            </div>
            <div class="info-content">
                <h4>Tujuan Unik</h4>
                <p>{{ $bookings->unique('tujuan')->count() }} Lokasi</p>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('admin.laporan.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn-info">
            <i class="fas fa-print"></i> Cetak
        </button>
        <a href="{{ route('admin.laporan.jadwal-keberangkatan', array_merge(request()->all(), ['format' => 'pdf'])) }}" class="btn-danger">
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
                        <th>No</th>
                        <th>Kode Booking</th>
                        <th>Tanggal & Jam</th>
                        <th>Tujuan</th>
                        <th>Pemesan</th>
                        <th>Bus</th>
                        <th>Sopir</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $booking->kode_booking }}</strong></td>
                            <td>
                                {{ \App\Helpers\DateHelper::formatIndonesia($booking->tanggal_berangkat) }}<br>
                                <small class="text-muted">{{ $booking->jam_berangkat }}</small>
                            </td>
                            <td>{{ $booking->tujuan }}</td>
                            <td>
                                {{ $booking->nama_pemesan }}<br>
                                <small class="text-muted">{{ $booking->no_telp }}</small>
                            </td>
                            <td>
                                <div class="bus-info">
                                    @forelse($booking->buses as $bus)
                                        <div class="bus-item">
                                            <strong>{{ $bus->kode_bus }}</strong><br>
                                            <small class="text-muted">{{ $bus->nomor_polisi }}</small>
                                        </div>
                                    @empty
                                        <span class="no-data">Belum ada bus</span>
                                    @endforelse
                                </div>
                            </td>
                            <td>
                                <div class="bus-info">
                                    @forelse($booking->buses as $bus)
                                        <div class="bus-item">
                                            {{ $bus->sopir->nama_sopir ?? '-' }}
                                        </div>
                                    @empty
                                        <span class="no-data">-</span>
                                    @endforelse
                                </div>
                            </td>
                            <td>
                                <span class="badge-status badge-{{ strtolower($booking->status_booking) }}">
                                    {{ ucfirst($booking->status_booking) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <div style="padding: 2rem;">
                                    <i class="fas fa-inbox" style="font-size: 3rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                                    <p style="color: #6c757d; margin: 0;">Tidak ada data jadwal keberangkatan</p>
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