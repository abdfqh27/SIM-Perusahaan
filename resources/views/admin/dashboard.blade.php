@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .welcome-card {
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
        border-radius: 15px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(1, 55, 83, 0.2);
        position: relative;
        overflow: hidden;
    }
    
    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 183, 3, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .welcome-content {
        position: relative;
        z-index: 1;
    }
    
    .welcome-time {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
        font-size: 0.95rem;
        opacity: 0.9;
    }
    
    .activity-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    
    .activity-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .activity-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .activity-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
    }
    
    .activity-title i {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 10px;
        color: white;
        font-size: 1.1rem;
    }
    
    .activity-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .activity-item {
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-item:hover {
        background: rgba(251, 133, 0, 0.03);
        padding-left: 1.5rem;
    }
    
    .activity-item-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 0.5rem;
    }
    
    .activity-item-title {
        font-weight: 600;
        color: var(--blue-dark);
        margin: 0;
        line-height: 1.4;
    }
    
    .activity-item-time {
        font-size: 0.85rem;
        color: #6c757d;
        white-space: nowrap;
        margin-left: 1rem;
    }
    
    .activity-item-desc {
        color: #6c757d;
        font-size: 0.9rem;
        margin: 0;
        line-height: 1.5;
    }
    
    .activity-item-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        flex-wrap: wrap;
    }
    
    .activity-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .badge-unread {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .badge-read {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .badge-draft {
        background: rgba(255, 193, 7, 0.1);
        color: #ff9800;
    }
    
    .badge-published {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    
    .chart-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .chart-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .chart-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    .empty-state p {
        margin: 0;
        font-size: 1rem;
    }
    
    .views-count {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: var(--orange-primary);
        font-weight: 500;
    }
    
    .bulan-stat-card {
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.05), rgba(255, 183, 3, 0.05));
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        border: 2px solid rgba(251, 133, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .bulan-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(251, 133, 0, 0.2);
        border-color: var(--orange-primary);
    }
    
    .bulan-stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--orange-primary);
        margin-bottom: 0.5rem;
        line-height: 1;
    }
    
    .bulan-stat-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    
    .bulan-stat-year {
        font-size: 0.8rem;
        color: #6c757d;
    }

    @media (max-width: 768px) {
        .welcome-card {
            padding: 1.5rem;
        }
        
        .activity-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .activity-item-header {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .activity-item-time {
            margin-left: 0;
        }
    }
</style>

<!-- Welcome Card -->
<div class="welcome-card animate-fade-in">
    <div class="welcome-content">
        <h2 style="margin: 0 0 0.5rem 0; font-size: 2rem; font-weight: 700;">
            {{ $sapaan }}, {{ auth()->user()->name }}!
        </h2>
        <p style="margin: 0; font-size: 1.1rem; opacity: 0.95;">
            Selamat datang di Dashboard Admin {{ config('app.name') }}
        </p>
        <div class="welcome-time">
            <i class="fas fa-calendar-day"></i>
            <span>{{ $hariIni }}</span>
            <span style="margin: 0 0.5rem;">•</span>
            <i class="fas fa-clock"></i>
            <span>{{ $jamSekarang }} WIB</span>
        </div>
    </div>
</div>

<!-- Statistik Grid -->
<div class="stats-grid animate-slide-in">
    <!-- Armada -->
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-primary">
                <i class="fas fa-bus"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $totalArmada }}</div>
                <div class="stat-label">Total Armada</div>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-indicator trend-up">
                <i class="fas fa-check-circle"></i>
                {{ $totalArmadaTersedia }} Tersedia
            </span>
            @if($totalArmadaUnggulan > 0)
            <span class="trend-indicator trend-alert" style="margin-left: 0.5rem;">
                <i class="fas fa-star"></i>
                {{ $totalArmadaUnggulan }} Unggulan
            </span>
            @endif
        </div>
        <div class="stat-footer">
            <a href="{{ route('admin.armada.index') }}" class="stat-link">
                Kelola Armada <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Layanan -->
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-info">
                <i class="fas fa-cogs"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $totalLayanan }}</div>
                <div class="stat-label">Total Layanan</div>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-indicator trend-up">
                <i class="fas fa-check-circle"></i>
                {{ $totalLayananAktif }} Aktif
            </span>
            @if($totalLayananUnggulan > 0)
            <span class="trend-indicator trend-alert" style="margin-left: 0.5rem;">
                <i class="fas fa-star"></i>
                {{ $totalLayananUnggulan }} Unggulan
            </span>
            @endif
        </div>
        <div class="stat-footer">
            <a href="{{ route('admin.layanan.index') }}" class="stat-link">
                Kelola Layanan <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Artikel -->
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-success">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $totalArtikel }}</div>
                <div class="stat-label">Total Artikel</div>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-indicator trend-up">
                <i class="fas fa-check-circle"></i>
                {{ $totalArtikelPublish }} Dipublikasi
            </span>
            @if($totalArtikelDraft > 0)
            <span class="trend-indicator trend-neutral" style="margin-left: 0.5rem;">
                <i class="fas fa-file-alt"></i>
                {{ $totalArtikelDraft }} Draft
            </span>
            @endif
        </div>
        <div class="stat-footer">
            <a href="{{ route('admin.artikel.index') }}" class="stat-link">
                Kelola Artikel <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Gallery -->
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-warning">
                <i class="fas fa-images"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $totalGallery }}</div>
                <div class="stat-label">Total Gallery</div>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-indicator trend-up">
                <i class="fas fa-check-circle"></i>
                {{ $totalGalleryTampil }} Ditampilkan
            </span>
        </div>
        <div class="stat-footer">
            <a href="{{ route('admin.gallery.index') }}" class="stat-link">
                Kelola Gallery <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Pesan Kontak -->
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-danger">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $totalPesan }}</div>
                <div class="stat-label">Pesan Masuk</div>
            </div>
        </div>
        <div class="stat-trend">
            @if($totalPesanBelumDibaca > 0)
            <span class="trend-indicator trend-down">
                <i class="fas fa-exclamation-circle"></i>
                {{ $totalPesanBelumDibaca }} Belum Dibaca
            </span>
            @else
            <span class="trend-indicator trend-up">
                <i class="fas fa-check-circle"></i>
                Semua Sudah Dibaca
            </span>
            @endif
        </div>
        <div class="stat-footer">
            <a href="{{ route('admin.pesan-kontak.index') }}" class="stat-link">
                Lihat Pesan <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Users -->
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-secondary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $totalUsers }}</div>
                <div class="stat-label">Total Pengguna</div>
            </div>
        </div>
        <div class="stat-trend">
            <span class="trend-indicator trend-neutral">
                <i class="fas fa-user-shield"></i>
                Administrator
            </span>
        </div>
        <div class="stat-footer">
            <a href="{{ route('admin.users.index') }}" class="stat-link">
                Kelola User <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Aktivitas Terbaru -->
<div class="row">
    <div class="col-lg-6">
        <!-- Pesan Terbaru -->
        <div class="activity-card">
            <div class="activity-header">
                <div class="activity-title">
                    <i class="fas fa-envelope"></i>
                    <span>Pesan Terbaru</span>
                </div>
                <a href="{{ route('admin.pesan-kontak.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> Lihat Semua
                </a>
            </div>
            
            @if($pesanTerbaru->count() > 0)
                <ul class="activity-list">
                    @foreach($pesanTerbaru as $pesan)
                    <li class="activity-item">
                        <div class="activity-item-header">
                            <h6 class="activity-item-title">
                                <i class="fas fa-user-circle" style="color: var(--blue-light); margin-right: 0.5rem;"></i>
                                {{ $pesan->nama }}
                            </h6>
                            <span class="activity-item-time">
                                <i class="fas fa-clock"></i> {{ $pesan->waktu_relatif }}
                            </span>
                        </div>
                        <p class="activity-item-desc">{{ Str::limit($pesan->pesan, 100) }}</p>
                        <div class="activity-item-meta">
                            <span class="activity-badge {{ $pesan->sudah_dibaca ? 'badge-read' : 'badge-unread' }}">
                                <i class="fas fa-{{ $pesan->sudah_dibaca ? 'check-circle' : 'exclamation-circle' }}"></i>
                                {{ $pesan->sudah_dibaca ? 'Sudah Dibaca' : 'Belum Dibaca' }}
                            </span>
                            <span style="color: #6c757d;">
                                <i class="fas fa-envelope"></i> {{ $pesan->email }}
                            </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada pesan masuk</p>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-6">
        <!-- Artikel Terbaru -->
        <div class="activity-card">
            <div class="activity-header">
                <div class="activity-title">
                    <i class="fas fa-newspaper"></i>
                    <span>Artikel Terbaru</span>
                </div>
                <a href="{{ route('admin.artikel.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> Lihat Semua
                </a>
            </div>
            
            @if($artikelTerbaru->count() > 0)
                <ul class="activity-list">
                    @foreach($artikelTerbaru as $artikel)
                    <li class="activity-item">
                        <div class="activity-item-header">
                            <h6 class="activity-item-title">{{ Str::limit($artikel->judul, 60) }}</h6>
                            <span class="activity-item-time">
                                <i class="fas fa-clock"></i> {{ $artikel->waktu_relatif }}
                            </span>
                        </div>
                        <div class="activity-item-meta">
                            <span class="activity-badge {{ $artikel->dipublikasi ? 'badge-published' : 'badge-draft' }}">
                                <i class="fas fa-{{ $artikel->dipublikasi ? 'check-circle' : 'file-alt' }}"></i>
                                {{ $artikel->dipublikasi ? 'Dipublikasi' : 'Draft' }}
                            </span>
                            <span style="color: #6c757d;">
                                <i class="fas fa-user"></i> {{ $artikel->user->name }}
                            </span>
                            <span class="views-count">
                                <i class="fas fa-eye"></i> {{ number_format($artikel->views) }}
                            </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state">
                    <i class="fas fa-newspaper"></i>
                    <p>Belum ada artikel</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Artikel Populer & Statistik -->
<div class="row">
    <div class="col-lg-6">
        <!-- Artikel Terpopuler -->
        <div class="chart-container">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="fas fa-fire" style="color: var(--orange-primary);"></i>
                    Artikel Terpopuler
                </h5>
            </div>
            
            @if($artikelPopuler->count() > 0)
                <ul class="activity-list">
                    @foreach($artikelPopuler as $index => $artikel)
                    <li class="activity-item">
                        <div class="activity-item-header">
                            <h6 class="activity-item-title">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary)); color: white; border-radius: 8px; margin-right: 0.75rem; font-size: 0.9rem; font-weight: 700;">
                                    {{ $index + 1 }}
                                </span>
                                {{ Str::limit($artikel->judul, 50) }}
                            </h6>
                        </div>
                        <div class="activity-item-meta">
                            <span class="views-count">
                                <i class="fas fa-eye"></i> {{ number_format($artikel->views) }} views
                            </span>
                            <span style="color: #6c757d;">
                                <i class="fas fa-calendar"></i> 
                                {{ \App\Helpers\DateHelper::formatIndonesia($artikel->tanggal_publikasi, 'd M Y') }}
                            </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state">
                    <i class="fas fa-chart-line"></i>
                    <p>Belum ada data artikel populer</p>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-6">
        <!-- Statistik Gallery -->
        <div class="chart-container">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="fas fa-chart-pie" style="color: var(--blue-light);"></i>
                    Gallery per Kategori
                </h5>
            </div>
            
            @if($galleryPerKategori->count() > 0)
                <ul class="activity-list">
                    @foreach($galleryPerKategori as $item)
                    <li class="activity-item">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <span style="font-weight: 600; color: var(--blue-dark); text-transform: capitalize;">
                                    {{ $item->kategori ?? 'Tanpa Kategori' }}
                                </span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <span style="font-size: 1.5rem; font-weight: 700; color: var(--orange-primary);">
                                    {{ $item->total }}
                                </span>
                                <span style="color: #6c757d; display: flex; align-items: center; gap: 0.25rem;">
                                    <i class="fas fa-images"></i> foto
                                </span>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state">
                    <i class="fas fa-images"></i>
                    <p>Belum ada data gallery</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Statistik Artikel per Bulan -->
@if($artikelPerBulan->count() > 0)
<div class="chart-container">
    <div class="chart-header">
        <h5 class="chart-title">
            <i class="fas fa-chart-bar" style="color: var(--orange-primary);"></i>
            Statistik Artikel 6 Bulan Terakhir
        </h5>
    </div>
    
    <div class="row">
        @foreach($artikelPerBulan as $data)
        <div class="col-md-2 col-sm-4 col-6 mb-3">
            <div class="bulan-stat-card">
                <div class="bulan-stat-number">
                    {{ $data->total }}
                </div>
                <div class="bulan-stat-label">
                    {{ $data->nama_bulan }}
                </div>
                <div class="bulan-stat-year">
                    {{ $data->tahun }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@endsection