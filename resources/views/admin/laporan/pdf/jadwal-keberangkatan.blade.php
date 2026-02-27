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

        /* KOP SURAT - LAYOUT LOGO KIRI, TEXT KANAN */
        .kop-surat {
            border-bottom: 4px solid #000;
            padding: 15px 0;
            margin-bottom: 20px;
            display: table;
            width: 100%;
        }

        .kop-logo {
            display: table-cell;
            width: 150px;
            vertical-align: middle;
            padding-right: 15px;
        }

        .kop-logo img {
            max-width: 130px;
            max-height: 130px;
            height: auto;
            display: block;
        }

        .kop-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            width: auto;
        }

        .kop-nama-perusahaan {
            font-size: 28pt;
            font-weight: bold;
            color: #FF6600;
            letter-spacing: 2px;
            margin-bottom: 8px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .kop-alamat {
            font-size: 10pt;
            line-height: 1.5;
            color: #000;
            margin-bottom: 5px;
        }

        .kop-kontak {
            font-size: 10pt;
            color: #000;
            margin-top: 5px;
            font-weight: 500;
        }

        /* HEADER LAPORAN */
        .header {
            text-align: center;
            padding: 15px 0;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 16pt;
            color: #023047;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-weight: bold;
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
            border-left: 4px solid #FB8500;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            display: table-cell;
            width: 30%;
            font-weight: bold;
            color: #023047;
        }

        .info-value {
            display: table-cell;
            width: 70%;
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

        table tbody tr:hover {
            background: #fff3e0;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 8pt;
            font-weight: bold;
            display: inline-block;
        }

        .badge-confirmed {
            background: #28a745;
            color: white;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e9ecef;
            text-align: center;
            font-size: 8pt;
            color: #6c757d;
        }

        .text-small {
            font-size: 8pt;
            color: #6c757d;
        }

        .text-bold {
            font-weight: bold;
        }

        .bus-item {
            margin-bottom: 5px;
            padding: 3px 0;
        }

        .bus-item:last-child {
            margin-bottom: 0;
        }

        .no-data {
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- KOP SURAT - LOGO KIRI, TEXT KANAN -->
    <div class="kop-surat">
        <div class="kop-logo">
            @if($pengaturan && $pengaturan->logo)
                <img src="{{ public_path('storage/' . $pengaturan->logo) }}" alt="Logo">
            @endif
        </div>
        <div class="kop-text">
            <div class="kop-nama-perusahaan">
                {{ $pengaturan->nama_perusahaan ?? 'PT. SRIMAJU TRANS' }}
            </div>
            <div class="kop-alamat">
                {{ $pengaturan->alamat ?? 'JL. RAYA CIREBON - KADIPATEN BLOK CAPGAWE RT.004 RW.002 DESA PARAPATAN KECAMATAN SUMBERJAYA-KABUPATEN MAJALENGKA' }}
            </div>
            <div class="kop-kontak">
                Telp. {{ $pengaturan->telepon ?? '+6281226339800' }} | email: {{ $pengaturan->email ?? 'srimajutran1@gmail.com' }}
            </div>
        </div>
    </div>

    <!-- HEADER LAPORAN -->
    <div class="header">
        <h1>{{ $judul }}</h1>
        <p>Periode: {{ \App\Helpers\DateHelper::formatIndonesia($tanggalAwal) }} - {{ \App\Helpers\DateHelper::formatIndonesia($tanggalAkhir) }}</p>
    </div>

    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Total Jadwal:</div>
            <div class="info-value">{{ $bookings->count() }} Keberangkatan</div>
        </div>
        <div class="info-row">
            <div class="info-label">Total Bus:</div>
            <div class="info-value">{{ $bookings->flatMap->buses->unique('id')->count() }} Unit</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tujuan Unik:</div>
            <div class="info-value">{{ $bookings->unique('tujuan')->count() }} Lokasi</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Cetak:</div>
            <div class="info-value">{{ \App\Helpers\DateHelper::formatIndonesia(now()) }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Kode Booking</th>
                <th width="13%">Tanggal & Jam</th>
                <th width="15%">Tujuan</th>
                <th width="15%">Pemesan</th>
                <th width="18%">Bus</th>
                <th width="18%">Sopir</th>
                <th width="5%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $index => $booking)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-bold">{{ $booking->kode_booking }}</td>
                    <td>
                        {{ \App\Helpers\DateHelper::formatIndonesia($booking->tanggal_berangkat) }}<br>
                        <span class="text-small">{{ $booking->jam_berangkat }}</span>
                    </td>
                    <td>{{ $booking->tujuan }}</td>
                    <td>
                        {{ $booking->nama_pemesan }}<br>
                        <span class="text-small">{{ $booking->no_telp }}</span>
                    </td>
                    <td>
                        @forelse($booking->buses as $bus)
                            <div class="bus-item">
                                <strong>{{ $bus->kode_bus }}</strong><br>
                                <span class="text-small">{{ $bus->nomor_polisi }}</span>
                            </div>
                        @empty
                            <span class="no-data">Belum ada bus</span>
                        @endforelse
                    </td>
                    <td>
                        @forelse($booking->buses as $bus)
                            <div class="bus-item">
                                {{ $bus->sopir->nama_sopir ?? '-' }}
                            </div>
                        @empty
                            <span class="no-data">-</span>
                        @endforelse
                    </td>
                    <td>
                        <span class="badge badge-confirmed">{{ ucfirst($booking->status_booking) }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data jadwal keberangkatan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis oleh sistem pada {{ \App\Helpers\DateHelper::formatIndonesia(now()) }}</p>
    </div>
</body>
</html>