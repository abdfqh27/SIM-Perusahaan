@extends('admin.layouts.app')

@section('title', $pageTitle)

@section('content')
<style>
    .report-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border-left: 4px solid transparent;
    }

    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(251, 133, 0, 0.15);
        border-left-color: var(--orange-primary);
    }

    .report-icon {
        width: 70px;
        height: 70px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .report-icon i {
        font-size: 2rem;
        color: white;
    }

    .report-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 0.75rem;
    }

    .report-desc {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .report-form {
        margin-top: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--orange-primary);
        box-shadow: 0 0 0 3px rgba(251, 133, 0, 0.1);
    }

    .btn-group-report {
        display: flex;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }

    .btn-report {
        flex: 1;
        padding: 0.75rem 1rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn-view {
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white;
        box-shadow: 0 3px 10px rgba(33, 158, 188, 0.3);
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(33, 158, 188, 0.5);
        color: white;
    }

    .btn-pdf {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
    }

    .btn-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.5);
        color: white;
    }

    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .reports-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .report-card {
            padding: 1.5rem;
        }

        .btn-group-report {
            flex-direction: column;
        }
    }
</style>

<!-- Header Section -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-images"></i>
        </div>
        <div>
            <h2 class="header-title">Laporan</h2>
            <p class="header-subtitle">Kelola dan cetak laporan operasional</p>
        </div>
    </div>
</div>

<!-- Reports Grid -->
<div class="reports-grid">
    <!-- Laporan Jadwal Keberangkatan -->
    <div class="report-card">
        <div class="report-icon" style="background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <h3 class="report-title">Jadwal Keberangkatan Bus</h3>
        <p class="report-desc">Laporan jadwal keberangkatan bus berdasarkan rentang tanggal tertentu</p>
        
        <form action="{{ route('admin.laporan.jadwal-keberangkatan') }}" method="GET" class="report-form" id="formJadwal">
            <div class="form-group">
                <label class="form-label">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" required>
            </div>
            
            <div class="btn-group-report">
                <button type="submit" name="format" value="web" class="btn-report btn-view">
                    <i class="fas fa-eye"></i>
                    <span>Lihat</span>
                </button>
                <button type="submit" name="format" value="pdf" class="btn-report btn-pdf">
                    <i class="fas fa-file-pdf"></i>
                    <span>PDF</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Laporan Ketersediaan Bus -->
    <div class="report-card">
        <div class="report-icon" style="background: linear-gradient(135deg, #28a745, #20c997);">
            <i class="fas fa-bus"></i>
        </div>
        <h3 class="report-title">Ketersediaan Bus</h3>
        <p class="report-desc">Laporan status ketersediaan bus dalam periode tertentu</p>
        
        <form action="{{ route('admin.laporan.ketersediaan-bus') }}" method="GET" class="report-form">
            <div class="form-group">
                <label class="form-label">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" required>
            </div>
            
            <div class="btn-group-report">
                <button type="submit" name="format" value="web" class="btn-report btn-view">
                    <i class="fas fa-eye"></i>
                    <span>Lihat</span>
                </button>
                <button type="submit" name="format" value="pdf" class="btn-report btn-pdf">
                    <i class="fas fa-file-pdf"></i>
                    <span>PDF</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Laporan Pendapatan -->
    <div class="report-card">
        <div class="report-icon" style="background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <h3 class="report-title">Pendapatan</h3>
        <p class="report-desc">Laporan pendapatan bulanan dan analisis pembayaran</p>
        
        <form action="{{ route('admin.laporan.pendapatan') }}" method="GET" class="report-form">
            <div class="form-group">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-control" required>
                    <option value="">Pilih Bulan</option>
                    @foreach($listBulan as $key => $bulan)
                        <option value="{{ $key }}">{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-control" required>
                    <option value="">Pilih Tahun</option>
                    @foreach($listTahun as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="btn-group-report">
                <button type="submit" name="format" value="web" class="btn-report btn-view">
                    <i class="fas fa-eye"></i>
                    <span>Lihat</span>
                </button>
                <button type="submit" name="format" value="pdf" class="btn-report btn-pdf">
                    <i class="fas fa-file-pdf"></i>
                    <span>PDF</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Laporan Performa Bus -->
    <div class="report-card">
        <div class="report-icon" style="background: linear-gradient(135deg, #ffc107, #ff9800);">
            <i class="fas fa-chart-bar"></i>
        </div>
        <h3 class="report-title">Performa Bus</h3>
        <p class="report-desc">Laporan performa dan utilisasi bus per bulan</p>
        
        <form action="{{ route('admin.laporan.performa-bus') }}" method="GET" class="report-form">
            <div class="form-group">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-control" required>
                    <option value="">Pilih Bulan</option>
                    @foreach($listBulan as $key => $bulan)
                        <option value="{{ $key }}">{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-control" required>
                    <option value="">Pilih Tahun</option>
                    @foreach($listTahun as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="btn-group-report">
                <button type="submit" name="format" value="web" class="btn-report btn-view">
                    <i class="fas fa-eye"></i>
                    <span>Lihat</span>
                </button>
                <button type="submit" name="format" value="pdf" class="btn-report btn-pdf">
                    <i class="fas fa-file-pdf"></i>
                    <span>PDF</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Laporan Rekap Bulanan -->
    <div class="report-card">
        <div class="report-icon" style="background: linear-gradient(135deg, #6f42c1, #9b59b6);">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <h3 class="report-title">Rekap Bulanan</h3>
        <p class="report-desc">Laporan rekap lengkap aktivitas bulanan sistem</p>
        
        <form action="{{ route('admin.laporan.rekap-bulanan') }}" method="GET" class="report-form">
            <div class="form-group">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-control" required>
                    <option value="">Pilih Bulan</option>
                    @foreach($listBulan as $key => $bulan)
                        <option value="{{ $key }}">{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-control" required>
                    <option value="">Pilih Tahun</option>
                    @foreach($listTahun as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="btn-group-report">
                <button type="submit" name="format" value="web" class="btn-report btn-view">
                    <i class="fas fa-eye"></i>
                    <span>Lihat</span>
                </button>
                <button type="submit" name="format" value="pdf" class="btn-report btn-pdf">
                    <i class="fas fa-file-pdf"></i>
                    <span>PDF</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection