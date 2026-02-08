@extends('admin.layouts.app')

@section('title', 'Pesan Kontak')

@section('content')
<style>
    /* Highlight untuk baris yang belum dibaca */
    .table-warning {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
    
    /* Container untuk badge baru */
    .badge-new {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }
    
    /* Styling untuk kolom aksi */
    .action-buttons {
        display: flex;
        gap: 0.25rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    /* Responsif untuk tombol aksi */
    @media (max-width: 768px) {
        .action-buttons {
            gap: 0.15rem;
        }
        
        .action-buttons .btn {
            padding: 0.25rem 0.4rem;
            font-size: 0.8rem;
        }
    }
</style>

<div class="container-fluid">
    {{-- Header Gradient dengan informasi halaman --}}
    <div class="gradient-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div>
                <h2 class="header-title">Pesan Kontak</h2>
                <p class="header-subtitle">Kelola dan respon pesan dari pengunjung</p>
            </div>
        </div>
        <div class="header-actions">
            <button onclick="refreshPage()" class="btn-refresh">
                <i class="fas fa-sync-alt"></i>
                <span>Refresh</span>
            </button>
        </div>
    </div>

    {{-- Grid Statistik Pesan --}}
    <div class="stats-grid">
        {{-- Statistik: Total Pesan --}}
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-primary">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $pesanKontaks->count() }}</h3>
                    <p class="stat-label">Total Pesan</p>
                </div>
            </div>
            <div class="stat-footer">
                <a href="{{ route('admin.pesan-kontak.index') }}" class="stat-link">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Statistik: Pesan Belum Dibaca --}}
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-warning">
                    <i class="fas fa-envelope-open"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $pesanKontaks->where('sudah_dibaca', false)->count() }}</h3>
                    <p class="stat-label">Belum Dibaca</p>
                </div>
            </div>
            @if($pesanKontaks->where('sudah_dibaca', false)->count() > 0)
            <div class="stat-trend">
                <span class="trend-indicator trend-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    Perlu Perhatian
                </span>
            </div>
            @endif
        </div>

        {{-- Statistik: Pesan Sudah Dibaca --}}
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="icon-wrapper icon-success">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $pesanKontaks->where('sudah_dibaca', true)->count() }}</h3>
                    <p class="stat-label">Sudah Dibaca</p>
                </div>
            </div>
            @if($pesanKontaks->where('sudah_dibaca', true)->count() > 0)
            <div class="stat-trend">
                <span class="trend-indicator trend-up">
                    <i class="fas fa-check"></i>
                    Terkelola
                </span>
            </div>
            @endif
        </div>
    </div>

    {{-- Card Tabel Daftar Pesan --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Daftar Pesan
            </h5>
        </div>
        <div class="card-body p-0">
            @if($pesanKontaks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="5%">
                                <i class="fas fa-hashtag"></i>
                            </th>
                            <th width="18%">
                                <i class="fas fa-user"></i> Pengirim
                            </th>
                            <th width="22%">
                                <i class="fas fa-tag"></i> Subjek
                            </th>
                            <th width="15%">
                                <i class="fas fa-calendar"></i> Tanggal
                            </th>
                            <th width="12%">
                                <i class="fas fa-eye"></i> Status
                            </th>
                            <th width="28%" class="text-center">
                                <i class="fas fa-cog"></i> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanKontaks as $index => $pesanKontak)
                        {{-- Highlight baris jika pesan belum dibaca --}}
                        <tr class="{{ !$pesanKontak->sudah_dibaca ? 'table-warning' : '' }}">
                            {{-- Nomor urut --}}
                            <td class="align-middle fw-bold">{{ $index + 1 }}</td>
                            
                            {{-- Informasi pengirim --}}
                            <td class="align-middle">
                                <div class="d-flex flex-column">
                                    <strong class="text-truncate" style="max-width: 200px;">{{ $pesanKontak->nama }}</strong>
                                    <small class="text-muted text-truncate" style="max-width: 200px;">
                                        <i class="fas fa-envelope"></i> {{ $pesanKontak->email }}
                                    </small>
                                    {{-- Badge untuk pesan baru --}}
                                    @if(!$pesanKontak->sudah_dibaca)
                                    <span class="badge bg-warning text-dark mt-1 badge-new">
                                        <i class="fas fa-star"></i> Baru
                                    </span>
                                    @endif
                                </div>
                            </td>
                            
                            {{-- Subjek pesan --}}
                            <td class="align-middle">
                                <div class="text-truncate" style="max-width: 250px;" title="{{ $pesanKontak->subjek }}">
                                    {{ $pesanKontak->subjek }}
                                </div>
                            </td>
                            
                            {{-- Tanggal dan waktu pengiriman --}}
                            <td class="align-middle">
                                <div class="d-flex flex-column">
                                    <span>
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                        {{ $pesanKontak->created_at->format('d M Y') }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i>
                                        {{ $pesanKontak->created_at->format('H:i') }} WIB
                                    </small>
                                </div>
                            </td>
                            
                            {{-- Status baca --}}
                            <td class="align-middle">
                                @if($pesanKontak->sudah_dibaca)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-double"></i> Dibaca
                                </span>
                                @else
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-envelope"></i> Belum
                                </span>
                                @endif
                            </td>
                            
                            {{-- Tombol aksi --}}
                            <td class="align-middle">
                                <div class="action-buttons">
                                    {{-- Tombol lihat detail --}}
                                    <a href="{{ route('admin.pesan-kontak.show', $pesanKontak->id) }}" 
                                       class="btn btn-info btn-sm"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    {{-- Tombol tandai sudah dibaca (hanya tampil jika belum dibaca) --}}
                                    @if(!$pesanKontak->sudah_dibaca)
                                    <form action="{{ route('admin.pesan-kontak.tandai-dibaca', $pesanKontak->id) }}" 
                                          method="POST" 
                                          class="d-inline mark-read-form">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-success btn-sm" 
                                                title="Tandai Dibaca">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    {{-- Tombol hapus --}}
                                    <form action="{{ route('admin.pesan-kontak.destroy', $pesanKontak->id) }}" 
                                          method="POST" 
                                          class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm" 
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            {{-- Tampilan ketika belum ada pesan --}}
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3" style="opacity: 0.3;"></i>
                <h4 class="text-muted">Belum Ada Pesan</h4>
                <p class="text-muted">Belum ada pesan kontak yang masuk</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

// Notifikasi sukses dari session
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
@endif

// Notifikasi error dari session
@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session('error') }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
@endif

document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Hapus Pesan?',
            text: "Pesan yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading saat proses hapus
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit form
                this.submit();
            }
        });
    });
});

document.querySelectorAll('.mark-read-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Tandai Sudah Dibaca?',
            text: "Pesan akan ditandai sebagai sudah dibaca",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Tandai!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading saat proses
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit form
                this.submit();
            }
        });
    });
});

function refreshPage() {
    Swal.fire({
        title: 'Memuat Ulang...',
        text: 'Mengambil data terbaru',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    setTimeout(() => {
        location.reload();
    }, 500);
}

// Auto refrsh setiap 5 menit
setInterval(() => {
    console.log('Auto refresh - checking for new messages');
}, 300000); // 5 menit = 300000 ms
</script>
@endpush
@endsection