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
            border-bottom: 3px solid #28a745;
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

        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-item {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            text-align: center;
        }

        .info-item h4 {
            font-size: 8pt;
            color: #6c757d;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .info-item p {
            font-size: 14pt;
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
            vertical-align: top;
        }

        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 8pt;
            font-weight: bold;
            display: inline-block;
        }

        .badge-available {
            background: #28a745;
            color: white;
        }

        .badge-busy {
            background: #dc3545;
            color: white;
        }

        .booking-detail {
            background: #fff3e0;
            padding: 6px;
            border-radius: 4px;
            margin-bottom: 4px;
            font-size: 8pt;
            border-left: 3px solid #FB8500;
        }

        .booking-detail:last-child {
            margin-bottom: 0;
        }

        .text-small {
            font-size: 8pt;
            color: #6c757d;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $judul }}</h1>
        <p>Periode: {{ \App\Helpers\DateHelper::formatIndonesia($tanggalAwal) }} - {{ \App\Helpers\DateHelper::formatIndonesia($tanggalAkhir) }}</p>
    </div>

    <div class="info-box">
        <div class="info-grid">
            <div class="info-item">
                <h4>Total Bus</h4>
                <p>{{ $buses->count() }}</p>
            </div>
            <div class="info-item">
                <h4>Bus Tersedia</h4>
                <p style="color: #28a745;">{{ $buses->filter(function($bus) { return $bus->bookings->isEmpty(); })->count() }}</p>
            </div>
            <div class="info-item">
                <h4>Bus Terpakai</h4>
                <p style="color: #dc3545;">{{ $buses->filter(function($bus) { return $bus->bookings->isNotEmpty(); })->count() }}</p>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Kode Bus</th>
                <th width="13%">Nomor Polisi</th>
                <th width="12%">Kategori</th>
                <th width="14%">Sopir</th>
                <th width="10%">Status</th>
                <th width="35%">Detail Booking</th>
            </tr>
        </thead>
        <tbody>
            @forelse($buses as $index => $bus)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-bold">{{ $bus->kode_bus }}</td>
                    <td>{{ $bus->nomor_polisi }}</td>
                    <td>{{ $bus->kategoriBus->nama_kategori ?? '-' }}</td>
                    <td>{{ $bus->sopir->nama_sopir ?? '-' }}</td>
                    <td>
                        @if($bus->bookings->isEmpty())
                            <span class="badge badge-available">Tersedia</span>
                        @else
                            <span class="badge badge-busy">Terpakai</span>
                        @endif
                    </td>
                    <td>
                        @if($bus->bookings->isNotEmpty())
                            @foreach($bus->bookings as $booking)
                                <div class="booking-detail">
                                    <strong>{{ $booking->kode_booking }}</strong><br>
                                    Tujuan: {{ $booking->tujuan }}<br>
                                    {{ \App\Helpers\DateHelper::formatIndonesia($booking->tanggal_berangkat) }} - {{ \App\Helpers\DateHelper::formatIndonesia($booking->tanggal_selesai) }}
                                </div>
                            @endforeach
                        @else
                            <span class="text-small">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data bus</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis oleh sistem pada {{ \App\Helpers\DateHelper::formatIndonesia(now()) }}</p>
    </div>
</body>
</html>