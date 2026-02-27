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
            border-bottom: 3px solid #ffc107;
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

        .summary-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #ffc107;
        }

        .summary-grid {
            display: table;
            width: 100%;
        }

        .summary-item {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
        }

        .summary-item h4 {
            font-size: 8pt;
            color: #6c757d;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .summary-item p {
            font-size: 11pt;
            color: #023047;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table thead {
            background: #023047;
            color: white;
        }

        table th {
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 9pt;
        }

        table td {
            padding: 8px;
            border-bottom: 1px solid #e9ecef;
            font-size: 9pt;
        }

        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .rank-badge {
            display: inline-block;
            width: 25px;
            height: 25px;
            line-height: 25px;
            text-align: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 9pt;
            color: white;
        }

        .rank-1 { background: #ffd700; }
        .rank-2 { background: #c0c0c0; }
        .rank-3 { background: #cd7f32; }
        .rank-other { background: #6c757d; }

        .top-performer {
            background: #fffbf0 !important;
            border-left: 4px solid #ffd700;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-small {
            font-size: 8pt;
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

    <!-- Summary -->
    <div class="summary-box">
        <div class="summary-grid">
            <div class="summary-item">
                <h4>Total Bus</h4>
                <p>{{ $totalBus }} Unit</p>
            </div>
            <div class="summary-item">
                <h4>Total Pendapatan</h4>
                <p>{{ \App\Helpers\DateHelper::formatRupiah($totalPendapatan) }}</p>
            </div>
            <div class="summary-item">
                <h4>Total Trip</h4>
                <p>{{ $totalTrip }} Perjalanan</p>
            </div>
            <div class="summary-item">
                <h4>Rata-rata/Trip</h4>
                <p>{{ $totalTrip > 0 ? \App\Helpers\DateHelper::formatRupiah($totalPendapatan / $totalTrip) : 'Rp 0' }}</p>
            </div>
        </div>
    </div>

    <!-- Performance Table -->
    <table>
        <thead>
            <tr>
                <th width="6%">Rank</th>
                <th width="15%">Nomor Bus</th>
                <th width="18%">Kategori</th>
                <th width="18%">Sopir</th>
                <th width="18%">Pendapatan</th>
                <th width="10%">Trip</th>
                <th width="8%">Hari</th>
                <th width="7%">Avg/Trip</th>
            </tr>
        </thead>
        <tbody>
            @forelse($buses as $index => $bus)
                <tr class="{{ $index == 0 ? 'top-performer' : '' }}">
                    <td>
                        <span class="rank-badge {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : 'rank-other')) }}">
                            {{ $index + 1 }}
                        </span>
                    </td>
                    <td class="text-bold">{{ $bus->nomor_bus }}</td>
                    <td>{{ $bus->kategoriBus->nama_kategori ?? '-' }}</td>
                    <td>{{ $bus->sopir->nama ?? '-' }}</td>
                    <td class="text-bold">{{ \App\Helpers\DateHelper::formatRupiah($bus->total_pendapatan) }}</td>
                    <td>{{ $bus->total_trip }}</td>
                    <td>{{ $bus->total_hari }}</td>
                    <td class="text-small">{{ \App\Helpers\DateHelper::formatRupiah($bus->rata_rata_per_trip) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data performa bus</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis oleh sistem pada {{ \App\Helpers\DateHelper::formatIndonesia(now()) }}</p>
        <p style="margin-top: 5px;"><strong>Keterangan:</strong> Peringkat diurutkan berdasarkan total pendapatan tertinggi</p>
    </div>
</body>
</html>