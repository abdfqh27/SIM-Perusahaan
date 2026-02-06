@extends('admin.layouts.app')

@section('title', 'Manajemen Bus')

@section('content')
<div class="admin-content">
    <!-- Header Section -->
    <div class="gradient-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-images"></i>
            </div>
            <div>
                <h2 class="header-title">Manajemen Bus</h2>
                <p class="header-subtitle">Kelola data bus dan status oeprasional</p>
            </div>
        </div>
        <div class="header-actions">
            <button class="btn-refresh" onclick="location.reload()">
                <i class="fas fa-sync-alt"></i>
                <span>Refresh</span>
            </button>
            <a href="{{ route('admin.operasional.bus.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                <span>Tambah Bus</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert-danger">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
    </div>
    @endif

    <!-- Statistics Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-primary">
                    <i class="fas fa-bus"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['total'] }}</h3>
                    <p class="stat-label">Total Bus</p>
                </div>
            </div>
            <div class="stat-footer">
                <a href="#" class="stat-link">
                    Lihat Semua
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['aktif'] }}</h3>
                    <p class="stat-label">Bus Aktif</p>
                </div>
            </div>
            <div class="stat-trend">
                <span class="trend-indicator trend-up">
                    <i class="fas fa-arrow-up"></i>
                    Siap Beroperasi
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-warning">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['perawatan'] }}</h3>
                    <p class="stat-label">Dalam Perawatan</p>
                </div>
            </div>
            <div class="stat-trend">
                <span class="trend-indicator trend-alert">
                    <i class="fas fa-wrench"></i>
                    Sedang Maintenance
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-info">
                    <i class="fas fa-route"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $stats['sedang_dipakai'] }}</h3>
                    <p class="stat-label">Sedang Dipakai</p>
                </div>
            </div>
            <div class="stat-trend">
                <span class="trend-indicator trend-neutral">
                    <i class="fas fa-clock"></i>
                    Hari Ini
                </span>
            </div>
        </div>
    </div>

    <!-- Bus Table Card -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-list me-2"></i>
            Daftar Bus
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Kode Bus</th>
                            <th width="15%">Nama Bus</th>
                            <th width="12%">Kategori</th>
                            <th width="15%">Sopir</th>
                            <th width="10%">Warna</th>
                            <th width="12%">No. Polisi</th>
                            <th width="10%">Status</th>
                            <th width="11%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($buses as $index => $bus)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong style="color: var(--orange-primary);">
                                    {{ $bus->kode_bus }}
                                </strong>
                            </td>
                            <td>{{ $bus->nama_bus }}</td>
                            <td>
                                <span style="
                                    background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
                                    color: white;
                                    padding: 0.35rem 0.75rem;
                                    border-radius: 6px;
                                    font-size: 0.85rem;
                                    font-weight: 500;
                                    display: inline-block;
                                ">
                                    {{ $bus->kategoriBus->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-user-circle" style="color: var(--blue-light); font-size: 1.2rem;"></i>
                                    <span>{{ $bus->sopir->nama ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div style="
                                        width: 20px;
                                        height: 20px;
                                        border-radius: 4px;
                                        background: {{ strtolower($bus->warna_bus) }};
                                        border: 2px solid #dee2e6;
                                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                                    "></div>
                                    <span>{{ ucfirst($bus->warna_bus) }}</span>
                                </div>
                            </td>
                            <td>
                                <strong style="
                                    color: var(--blue-dark);
                                    font-family: 'Courier New', monospace;
                                    letter-spacing: 1px;
                                ">
                                    {{ $bus->nomor_polisi }}
                                </strong>
                            </td>
                            <td>
                                @php
                                    $statusRealtime = $bus->status_realtime;
                                    $statusConfig = [
                                        'tersedia' => [
                                            'color' => '#28a745',
                                            'bg' => 'rgba(40, 167, 69, 0.1)',
                                            'icon' => 'fa-check-circle',
                                            'text' => 'Tersedia'
                                        ],
                                        'dipakai' => [
                                            'color' => '#219EBC',
                                            'bg' => 'rgba(33, 158, 188, 0.1)',
                                            'icon' => 'fa-route',
                                            'text' => 'Dipakai'
                                        ],
                                        'perawatan' => [
                                            'color' => '#ffc107',
                                            'bg' => 'rgba(255, 193, 7, 0.1)',
                                            'icon' => 'fa-tools',
                                            'text' => 'Perawatan'
                                        ]
                                    ];
                                    $config = $statusConfig[$statusRealtime] ?? $statusConfig['tersedia'];
                                @endphp
                                <span style="
                                    background: {{ $config['bg'] }};
                                    color: {{ $config['color'] }};
                                    padding: 0.4rem 0.85rem;
                                    border-radius: 20px;
                                    font-size: 0.85rem;
                                    font-weight: 600;
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 0.4rem;
                                ">
                                    <i class="fas {{ $config['icon'] }}"></i>
                                    {{ $config['text'] }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('admin.operasional.bus.show', $bus->id) }}" 
                                       class="btn btn-info btn-sm"
                                       style="padding: 0.4rem 0.75rem; border-radius: 6px;"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.operasional.bus.edit', $bus->id) }}" 
                                       class="btn btn-warning btn-sm"
                                       style="padding: 0.4rem 0.75rem; border-radius: 6px;"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.operasional.bus.destroy', $bus->id) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Yakin ingin menghapus bus {{ $bus->nama_bus }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm"
                                                style="padding: 0.4rem 0.75rem; border-radius: 6px;"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center" style="padding: 3rem;">
                                <div style="color: #6c757d;">
                                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                                    <p style="margin: 0; font-size: 1.1rem;">Belum ada data bus</p>
                                    <a href="{{ route('admin.operasional.bus.create') }}" 
                                       style="color: var(--orange-primary); margin-top: 0.5rem; display: inline-block;">
                                        Tambah bus pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection