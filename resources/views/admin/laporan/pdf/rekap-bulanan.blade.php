<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 3px solid #6f42c1;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18pt;
            color: #023047;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10pt;
            color: #6c757d;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 12pt;
            font-weight: bold;
            color: #023047;
            margin-bottom: 10px;
            padding: 8px 12px;
            background: #f8f9fa;
            border-left: 4px solid #FB8500;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .stats-row {
            display: table-row;
        }

        .stat-item {
            display: table-cell;
            width: 25%;
            padding: 12px;
            text-align: center;
            border: 1px solid #e9ecef;
            background: #fff;
        }

        .stat-item h5 {
            font-size: 8pt;
            color: #6c757d;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .stat-item p {
            font-size: 14pt;
            font-weight: bold;
            color: #023047;
        }

        .stat-item.highlight {
            background: #fff3e0;
        }

        .stat-item.success {
            background: #e8f5e9;
        }

        .stat-item.warning {
            background: #fff8e1;
        }

        .stat-item.danger {
            background: #ffebee;
        }

        .top-destinations {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .destination-item {
            display: table;
            width: 100%;
            padding: 10px;
            background: white;
            margin-bottom: 8px;
            border-radius: 4px;
            border-left: 3px solid #FB8500;
        }

        .destination-item:last-child {
            margin-bottom: 0;
        }

        .dest-rank {
            display: table-cell;
            width: 40px;
            text-align: center;
            font-weight: bold;
            color: #FB8500;
            font-size: 12pt;
        }

        .dest-name {
            display: table-cell;
            font-weight: 600;
            color: #023047;
        }

        .dest-count {
            display: table-cell;
            width: 100px;
            text-align: right;
            font-weight: bold;
            color: #6c757d;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e9ecef;
            text-align: center;
            font-size: 8pt;
            color: #6c757d;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $judul }}</h1>
        <p>Periode: {{ $namaBulan }} {{ $tahun }}</p>
    </div>

    <!-- Rekap Booking -->
    <div class="section">
        <div class="section-title">📅 Rekap Booking</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stat-item">
                    <h5>Total Booking</h5>
                    <p>{{ $totalBooking }}</p>
                </div>
                <div class="stat-item success">
                    <h5>Confirmed</h5>
                    <p style="color: #28a745;">{{ $bookingConfirmed }}</p>
                </div>
                <div class="stat-item warning">
                    <h5>Pending</h5>
                    <p style="color: #ffc107;">{{ $bookingPending }}</p>
                </div>
                <div class="stat-item danger">
                    <h5>Cancelled</h5>
                    <p style="color: #dc3545;">{{ $bookingCancelled }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekap Pendapatan -->
    <div class="section">
        <div class="section-title">💰 Rekap Pendapatan</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stat-item">
                    <h5>Total Pendapatan</h5>
                    <p style="font-size: 12pt;">{{ \App\Helpers\DateHelper::formatRupiah($totalPendapatan) }}</p>
                </div>
                <div class="stat-item success">
                    <h5>Lunas</h5>
                    <p style="font-size: 12pt; color: #28a745;">{{ \App\Helpers\DateHelper::formatRupiah($pendapatanLunas) }}</p>
                </div>
                <div class="stat-item highlight">
                    <h5>Total DP</h5>
                    <p style="font-size: 12pt; color: #219EBC;">{{ \App\Helpers\DateHelper::formatRupiah($totalDP) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekap Bus -->
    <div class="section">
        <div class="section-title">🚌 Rekap Bus</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stat-item">
                    <h5>Total Bus</h5>
                    <p>{{ $totalBus }} Unit</p>
                </div>
                <div class="stat-item success">
                    <h5>Bus Aktif</h5>
                    <p style="color: #28a745;">{{ $busAktif }} Unit</p>
                </div>
                <div class="stat-item warning">
                    <h5>Perawatan</h5>
                    <p style="color: #ffc107;">{{ $busPerawatan }} Unit</p>
                </div>
                <div class="stat-item">
                    <h5>-</h5>
                    <p>-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekap Sopir -->
    <div class="section">
        <div class="section-title">👨‍✈️ Rekap Sopir</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stat-item">
                    <h5>Total Sopir</h5>
                    <p>{{ $totalSopir }} Orang</p>
                </div>
                <div class="stat-item success">
                    <h5>Sopir Aktif</h5>
                    <p style="color: #28a745;">{{ $sopirAktif }} Orang</p>
                </div>
                <div class="stat-item danger">
                    <h5>Non-Aktif</h5>
                    <p style="color: #dc3545;">{{ $sopirNonAktif }} Orang</p>
                </div>
                <div class="stat-item">
                    <h5>-</h5>
                    <p>-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Tujuan -->
    <div class="section">
        <div class="section-title">🗺️ Top 5 Tujuan Populer</div>
        @if($topTujuan->count() > 0)
            <div class="top-destinations">
                @foreach($topTujuan as $index => $tujuan)
                    <div class="destination-item">
                        <div class="dest-rank">#{{ $index + 1 }}</div>
                        <div class="dest-name">{{ $tujuan->tujuan }}</div>
                        <div class="dest-count">{{ $tujuan->total }} trip</div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="text-align: center; color: #6c757d; padding: 20px;">Belum ada data tujuan untuk periode ini</p>
        @endif
    </div>

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis oleh sistem pada {{ \App\Helpers\DateHelper::formatIndonesia(now()) }}</p>
        <p style="margin-top: 5px;"><strong>{{ $namaBulan }} {{ $tahun }}</strong> - Rekap Lengkap Sistem Rental Bus</p>
    </div>
</body>
</html>