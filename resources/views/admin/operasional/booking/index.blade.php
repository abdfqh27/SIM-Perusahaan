@extends('admin.layouts.app')

@section('title', 'Manajemen Booking')

@section('content')
<style>
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .status-draft {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }
    .status-confirmed {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }
    .status-selesai {
        background: linear-gradient(135deg, #219EBC, #8ECAE6);
        color: white;
    }
    .status-batal {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }
    .badge-pembayaran {
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .pembayaran-belum_bayar {
        background: #f8d7da;
        color: #721c24;
    }
    .pembayaran-dp {
        background: #fff3cd;
        color: #856404;
    }
    .pembayaran-lunas {
        background: #d4edda;
        color: #155724;
    }
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .action-buttons .btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        border-radius: 8px;
    }
    .booking-code {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: var(--orange-primary);
        font-size: 0.95rem;
    }
    .table-booking tbody tr {
        vertical-align: middle;
    }
    .bus-count {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        padding: 0.3rem 0.7rem;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }
    .stat-card-compact {
        background: white;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .stat-card-compact:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
</style>

<!-- Header Section -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-images"></i>
        </div>
        <div>
            <h2 class="header-title">Kelola Pesanan</h2>
            <p class="header-subtitle">Kelola data pesanan</p>
        </div>
    </div>
    <div class="header-actions">
        <button class="btn-refresh" onclick="location.reload()">
            <i class="fas fa-sync-alt"></i>
            <span>Refresh</span>
        </button>
        <a href="{{ route('admin.operasional.booking.create') }}" class="btn-add">
            <i class="fas fa-plus"></i>
            <span>Tambah Pesanan</span>
        </a>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Statistics -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card-compact">
            <div class="d-flex align-items-center">
                <div class="icon-wrapper icon-primary me-3" style="width: 50px; height: 50px;">
                    <i class="fas fa-clipboard-list" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['total'] }}</h3>
                    <small class="text-muted">Total Booking</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card-compact">
            <div class="d-flex align-items-center">
                <div class="icon-wrapper icon-success me-3" style="width: 50px; height: 50px;">
                    <i class="fas fa-check-double" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['confirmed'] }}</h3>
                    <small class="text-muted">Confirmed</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card-compact">
            <div class="d-flex align-items-center">
                <div class="icon-wrapper icon-secondary me-3" style="width: 50px; height: 50px;">
                    <i class="fas fa-file-alt" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['draft'] }}</h3>
                    <small class="text-muted">Draft</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card-compact">
            <div class="d-flex align-items-center">
                <div class="icon-wrapper icon-info me-3" style="width: 50px; height: 50px;">
                    <i class="fas fa-flag-checkered" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['selesai'] }}</h3>
                    <small class="text-muted">Selesai</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Search -->
<div class="filter-card">
    <form action="{{ route('admin.operasional.booking.index') }}" method="GET" id="filterForm">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold">
                    <i class="fas fa-search me-1"></i> Cari Booking
                </label>
                <input type="text" 
                       class="form-control" 
                       name="search" 
                       value="{{ $filters['search'] ?? '' }}"
                       placeholder="Cari kode booking, nama pemesan...">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">
                    <i class="fas fa-filter me-1"></i> Status Booking
                </label>
                <select class="form-select" name="status">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ ($filters['status'] ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="confirmed" {{ ($filters['status'] ?? '') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="selesai" {{ ($filters['status'] ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ ($filters['status'] ?? '') == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">
                    <i class="fas fa-money-bill-wave me-1"></i> Pembayaran
                </label>
                <select class="form-select" name="pembayaran">
                    <option value="">Semua</option>
                    <option value="belum_bayar" {{ ($filters['pembayaran'] ?? '') == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="dp" {{ ($filters['pembayaran'] ?? '') == 'dp' ? 'selected' : '' }}>DP</option>
                    <option value="lunas" {{ ($filters['pembayaran'] ?? '') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">
                    <i class="fas fa-calendar me-1"></i> Dari Tanggal
                </label>
                <input type="date" 
                       class="form-control" 
                       name="tanggal_dari" 
                       value="{{ $filters['tanggal_dari'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">
                    <i class="fas fa-calendar me-1"></i> Sampai Tanggal
                </label>
                <input type="date" 
                       class="form-control" 
                       name="tanggal_sampai" 
                       value="{{ $filters['tanggal_sampai'] ?? '' }}">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <a href="{{ route('admin.operasional.booking.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-redo"></i> Reset Filter
                </a>
                @if(count(array_filter($filters ?? [])) > 0)
                    <span class="badge bg-info ms-2">
                        <i class="fas fa-filter"></i> {{ count(array_filter($filters)) }} filter aktif
                    </span>
                @endif
            </div>
        </div>
    </form>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-booking table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Kode Booking</th>
                        <th>Pemesan</th>
                        <th>Tujuan & Jadwal</th>
                        <th>Bus</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $index => $booking)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="booking-code">{{ $booking->kode_booking }}</span>
                            <br>
                            <small class="text-muted">
                                <i class="far fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($booking->created_at)->timezone('Asia/Jakarta')->translatedFormat('d/m/Y H:i') }} WIB
                            </small>
                        </td>
                        <td>
                            <strong>{{ $booking->nama_pemesan }}</strong>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-phone"></i> {{ $booking->no_hp_pemesan }}
                            </small>
                            @if($booking->email_pemesan)
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-envelope"></i> {{ $booking->email_pemesan }}
                            </small>
                            @endif
                        </td>
                        <td>
                            <div class="mb-1">
                                <i class="fas fa-map-marker-alt text-danger"></i>
                                <strong>{{ $booking->tujuan }}</strong>
                            </div>
                            <small class="text-muted">
                                <i class="far fa-calendar-alt"></i>
                                {{ $booking->tanggal_berangkat->format('d/m/Y') }}
                                -
                                {{ $booking->tanggal_selesai->format('d/m/Y') }}
                            </small>
                            <br>
                            <small class="text-muted">
                                <i class="far fa-clock"></i>
                                {{ $booking->jam_berangkat }}
                                ({{ $booking->durasi_hari }} hari)
                            </small>
                        </td>
                        <td>
                            <span class="bus-count">
                                <i class="fas fa-bus"></i> {{ $booking->buses->count() }}
                            </span>
                            @if($booking->buses->count() > 0)
                            <br>
                            <small class="text-muted">
                                {{ $booking->buses->first()->nama_bus }}
                                @if($booking->buses->count() > 1)
                                    <br>+{{ $booking->buses->count() - 1 }} lainnya
                                @endif
                            </small>
                            @endif
                        </td>
                        <td>
                            <div class="mb-2">
                                <strong style="color: var(--orange-primary);">
                                    Rp {{ number_format($booking->total_pembayaran, 0, ',', '.') }}
                                </strong>
                            </div>
                            <span class="badge-pembayaran pembayaran-{{ $booking->status_pembayaran }}">
                                @if($booking->status_pembayaran == 'belum_bayar')
                                    <i class="fas fa-times-circle"></i> Belum Bayar
                                @elseif($booking->status_pembayaran == 'dp')
                                    <i class="fas fa-hourglass-half"></i> DP ({{ number_format($booking->nominal_dp, 0, ',', '.') }})
                                @else
                                    <i class="fas fa-check-circle"></i> Lunas
                                @endif
                            </span>
                            <br>
                            <small class="text-muted">{{ ucfirst($booking->metode_pembayaran) }}</small>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $booking->status_booking }}">
                                @if($booking->status_booking == 'draft')
                                    <i class="fas fa-file-alt"></i> Draft
                                @elseif($booking->status_booking == 'confirmed')
                                    <i class="fas fa-check-circle"></i> Confirmed
                                @elseif($booking->status_booking == 'selesai')
                                    <i class="fas fa-flag-checkered"></i> Selesai
                                @else
                                    <i class="fas fa-times-circle"></i> Batal
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.operasional.booking.show', $booking->id) }}" 
                                   class="btn btn-info btn-sm" 
                                   title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(in_array($booking->status_booking, ['draft', 'confirmed']))
                                <a href="{{ route('admin.operasional.booking.edit', $booking->id) }}" 
                                   class="btn btn-warning btn-sm" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif

                                @if($booking->status_booking == 'draft')
                                <form action="{{ route('admin.operasional.booking.update-status', $booking->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_booking" value="confirmed">
                                    <button type="submit" 
                                            class="btn btn-success btn-sm" 
                                            title="Konfirmasi"
                                            onclick="return confirm('Konfirmasi booking ini?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif

                                @if(in_array($booking->status_booking, ['draft', 'batal']))
                                <form action="{{ route('admin.operasional.booking.destroy', $booking->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm" 
                                            title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus booking ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">
                                @if(count(array_filter($filters ?? [])) > 0)
                                    Tidak ada booking yang sesuai dengan filter
                                @else
                                    Belum ada data booking
                                @endif
                            </p>
                            <a href="{{ route('admin.operasional.booking.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Buat Booking Baru
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Auto-submit form on select change untuk pengalaman yang lebih baik
document.querySelectorAll('select[name="status"], select[name="pembayaran"]').forEach(function(select) {
    select.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});
</script>
@endsection