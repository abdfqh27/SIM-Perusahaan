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
            border-bottom: 3px solid #219EBC;
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
            border-left: 4px solid #219EBC;
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

        .analysis-section {
            margin: 20px 0;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 12pt;
            font-weight: bold;
            color: #023047;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #FB8500;
        }

        .analysis-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .analysis-item {
            display: table-cell;
            width: 50%;
            padding: 10px;
        }

        .analysis-box {
            background: #fff3e0;
            padding: 12px;
            border-radius: 5px;
            border-left: 3px solid #FB8500;
        }

        .analysis-box h5 {
            font-size: 9pt;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .analysis-value {
            font-size: 12pt;
            font-weight: bold;
            color: #023047;
        }

        .analysis-count {
            font-size: 8pt;
            color: #FB8500;
            margin-top: 3px;
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
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 8pt;
        }

        table td {
            padding: 6px;
            border-bottom: 1px solid #e9ecef;
            font-size: 8pt;
        }

        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 7pt;
            font-weight: bold;
            display: inline-block;
        }

        .badge-lunas {
            background: #28a745;
            color: white;
        }

        .badge-dp {
            background: #ffc107;
            color: #212529;
        }

        .text-bold {
            font-weight: bold;
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
                <h4>Total Pendapatan</h4>
                <p>{{ \App\Helpers\DateHelper::formatRupiah($totalPendapatan) }}</p>
            </div>
            <div class="summary-item">
                <h4>Sudah Lunas</h4>
                <p style="color: #28a745;">{{ \App\Helpers\DateHelper::formatRupiah($totalLunas) }}</p>
            </div>
            <div class="summary-item">
                <h4>Total DP</h4>
                <p style="color: #219EBC;">{{ \App\Helpers\DateHelper::formatRupiah($totalDP) }}</p>
            </div>
            <div class="summary-item">
                <h4>Belum Lunas</h4>
                <p style="color: #ffc107;">{{ \App\Helpers\DateHelper::formatRupiah($totalBelumLunas) }}</p>
            </div>
        </div>
    </div>

    <!-- Analysis by Status -->
    <div class="analysis-section">
        <div class="section-title">Analisis Berdasarkan Status Pembayaran</div>
        <div class="analysis-grid">
            @foreach($byStatusPembayaran->chunk(2) as $chunk)
                @foreach($chunk as $status => $data)
                    <div class="analysis-item">
                        <div class="analysis-box">
                            <h5>{{ ucfirst($status) }}</h5>
                            <div class="analysis-value">{{ \App\Helpers\DateHelper::formatRupiah($data['total']) }}</div>
                            <div class="analysis-count">{{ $data['count'] }} transaksi</div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- Analysis by Kategori -->
    <div class="analysis-section">
        <div class="section-title">Analisis Berdasarkan Kategori Bus</div>
        <div class="analysis-grid">
            @foreach($byKategoriBus->chunk(2) as $chunk)
                @foreach($chunk as $kategori => $data)
                    <div class="analysis-item">
                        <div class="analysis-box">
                            <h5>{{ $kategori }}</h5>
                            <div class="analysis-value">{{ \App\Helpers\DateHelper::formatRupiah($data['total']) }}</div>
                            <div class="analysis-count">{{ $data['count'] }} booking</div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <div class="page-break"></div>

    <!-- Detail Table -->
    <div class="section-title">Detail Transaksi</div>
    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Kode</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Pemesan</th>
                <th width="18%">Tujuan</th>
                <th width="14%">Total</th>
                <th width="12%">DP</th>
                <th width="8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $index => $booking)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-bold">{{ $booking->kode_booking }}</td>
                    <td>{{ \App\Helpers\DateHelper::formatIndonesia($booking->tanggal_berangkat) }}</td>
                    <td>{{ $booking->nama_pemesan }}</td>
                    <td>{{ $booking->tujuan }}</td>
                    <td class="text-bold">{{ \App\Helpers\DateHelper::formatRupiah($booking->total_pembayaran) }}</td>
                    <td>{{ \App\Helpers\DateHelper::formatRupiah($booking->nominal_dp ?? 0) }}</td>
                    <td>
                        @if($booking->status_pembayaran == 'lunas')
                            <span class="badge badge-lunas">Lunas</span>
                        @elseif($booking->status_pembayaran == 'dp')
                            <span class="badge badge-dp">DP</span>
                        @else
                            <span>{{ ucfirst($booking->status_pembayaran) }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis oleh sistem pada {{ \App\Helpers\DateHelper::formatIndonesia(now()) }}</p>
    </div>
</body>
</html>