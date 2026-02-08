@extends('admin.layouts.app')

@section('title', 'Detail Pesan Kontak')

@section('content')
<style>
    /* Styling untuk konten pesan */
    .message-content-box {
        padding: 1rem;
        background: #f8f9fa;
        border-left: 4px solid var(--orange-primary);
        border-radius: 0.5rem;
        white-space: pre-wrap;
        line-height: 1.8;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    /* Styling untuk metadata box */
    .metadata-box {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .metadata-box:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }
    
    /* Styling untuk info pengirim */
    .sender-info-item {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .sender-info-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    /* Styling untuk action buttons */
    .action-btn {
        width: 100%;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .action-btn:last-child {
        margin-bottom: 0;
    }
    
    /* Badge styling di header */
    .status-badge {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    /* Responsif untuk mobile */
    @media (max-width: 991px) {
        .card.mb-3,
        .card {
            margin-bottom: 1rem !important;
        }
    }
</style>

<div class="container-fluid">
    {{-- Header Gradient dengan navigasi kembali --}}
    <div class="gradient-header">
        <div class="header-left">
            {{-- Tombol kembali ke daftar pesan --}}
            <a href="{{ route('admin.pesan-kontak.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-icon">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <div>
                <h2 class="header-title">Detail Pesan Kontak</h2>
                <p class="header-subtitle">Informasi lengkap pesan dari pengunjung</p>
            </div>
        </div>
        <div class="header-actions">
            {{-- Badge status pesan --}}
            @if($pesanKontak->sudah_dibaca)
            <span class="badge bg-success status-badge">
                <i class="fas fa-check-double"></i> Sudah Dibaca
            </span>
            @else
            <span class="badge bg-warning text-dark status-badge">
                <i class="fas fa-envelope"></i> Belum Dibaca
            </span>
            @endif
        </div>
    </div>

    <div class="row">
        {{-- Kolom Utama: Konten Pesan --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tag me-2"></i>{{ $pesanKontak->subjek }}
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Isi Pesan --}}
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-comment-dots"></i> Isi Pesan
                        </label>
                        <div class="message-content-box">{{ $pesanKontak->pesan }}</div>
                    </div>

                    {{-- Metadata: Tanggal Kirim dan Dibaca --}}
                    <div class="row">
                        {{-- Tanggal Kirim --}}
                        <div class="col-md-6">
                            <div class="metadata-box mb-3">
                                <small class="text-muted d-block mb-1">
                                    <i class="fas fa-calendar-alt"></i> Dikirim Pada
                                </small>
                                <strong>{{ $pesanKontak->tanggal_kirim }}</strong>
                                <div class="mt-1">
                                    <span class="badge bg-info">{{ $pesanKontak->waktu_relatif }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal Dibaca (jika sudah dibaca) --}}
                        @if($pesanKontak->sudah_dibaca && $pesanKontak->dibaca_pada)
                        <div class="col-md-6">
                            <div class="metadata-box mb-3">
                                <small class="text-muted d-block mb-1">
                                    <i class="fas fa-eye"></i> Dibaca Pada
                                </small>
                                <strong>{{ $pesanKontak->tanggal_dibaca }}</strong>
                                <div class="mt-1">
                                    <span class="badge bg-success">{{ \App\Helpers\DateHelper::diffForHumans($pesanKontak->dibaca_pada) }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Sidebar: Info Pengirim & Aksi --}}
        <div class="col-lg-4">
            {{-- Card Informasi Pengirim --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>Informasi Pengirim
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Nama Pengirim --}}
                    <div class="sender-info-item">
                        <label class="form-label text-muted small">
                            <i class="fas fa-user"></i> Nama
                        </label>
                        <p class="mb-0 fw-bold">{{ $pesanKontak->nama }}</p>
                    </div>

                    {{-- Email Pengirim --}}
                    <div class="sender-info-item">
                        <label class="form-label text-muted small">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <p class="mb-0">
                            <a href="mailto:{{ $pesanKontak->email }}" class="text-decoration-none">
                                {{ $pesanKontak->email }}
                            </a>
                        </p>
                    </div>

                    {{-- Nomor Telepon (jika ada) --}}
                    @if($pesanKontak->telepon)
                    <div class="sender-info-item">
                        <label class="form-label text-muted small">
                            <i class="fas fa-phone"></i> Telepon
                        </label>
                        <p class="mb-0">
                            <a href="tel:{{ $pesanKontak->telepon }}" class="text-decoration-none">
                                {{ $pesanKontak->telepon }}
                            </a>
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Card Tombol Aksi --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tools me-2"></i>Tindakan
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Tombol WhatsApp (jika ada nomor telepon) --}}
                    @if($pesanKontak->telepon)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesanKontak->telepon) }}?text=Halo {{ $pesanKontak->nama }}, terima kasih atas pesan Anda mengenai: {{ $pesanKontak->subjek }}" 
                       target="_blank"
                       class="btn btn-success action-btn">
                        <i class="fab fa-whatsapp"></i>
                        Hubungi via WhatsApp
                    </a>
                    @endif

                    {{-- Tombol Tandai Sudah Dibaca (hanya jika belum dibaca) --}}
                    @if(!$pesanKontak->sudah_dibaca)
                    <form action="{{ route('admin.pesan-kontak.tandai-dibaca', $pesanKontak->id) }}" 
                          method="POST" 
                          class="mark-read-form">
                        @csrf
                        <button type="submit" class="btn btn-info action-btn">
                            <i class="fas fa-check"></i>
                            Tandai Sudah Dibaca
                        </button>
                    </form>
                    @endif

                    {{-- Tombol Hapus Pesan --}}
                    <form action="{{ route('admin.pesan-kontak.destroy', $pesanKontak->id) }}" 
                          method="POST"
                          class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger action-btn">
                            <i class="fas fa-trash"></i>
                            Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>
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

document.querySelector('.delete-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Hapus Pesan?',
        text: "Pesan yang dihapus tidak dapat dikembalikan dan Anda akan diarahkan ke halaman daftar pesan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
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

document.querySelector('.mark-read-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Tandai Sudah Dibaca?',
        text: "Pesan akan ditandai sebagai sudah dibaca",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tandai!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-info',
            cancelButton: 'btn btn-secondary'
        }
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

@if(!$pesanKontak->sudah_dibaca)
window.addEventListener('beforeunload', function(e) {
    // Cek apakah form mark-read masih ada (pesan belum dibaca)
    if (!document.querySelector('.mark-read-form')) {
        return;
    }
    
    e.preventDefault();
    e.returnValue = 'Pesan ini belum ditandai sebagai dibaca. Yakin ingin meninggalkan halaman?';
});
@endif

document.querySelectorAll('a[href^="mailto:"]').forEach(link => {
    link.addEventListener('contextmenu', function(e) {
        if (e.ctrlKey) {
            e.preventDefault();
            const email = this.href.replace('mailto:', '').split('?')[0];
            
            // Copy ke clipboard menggunakan Clipboard API
            navigator.clipboard.writeText(email).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Disalin!',
                    text: 'Email berhasil disalin ke clipboard',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });
        }
    });
});

document.querySelectorAll('a[href^="tel:"]').forEach(link => {
    link.addEventListener('contextmenu', function(e) {
        if (e.ctrlKey) {
            e.preventDefault();
            const phone = this.href.replace('tel:', '');
            
            // Copy ke clipboard menggunakan Clipboard API
            navigator.clipboard.writeText(phone).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Disalin!',
                    text: 'Nomor telepon berhasil disalin ke clipboard',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });
        }
    });
});

setTimeout(() => {
    if (document.querySelector('a[href^="mailto:"]') || document.querySelector('a[href^="tel:"]')) {
        Swal.fire({
            icon: 'info',
            title: 'Tips!',
            html: 'Tekan <strong>Ctrl + Klik Kanan</strong> pada email atau telepon untuk menyalin',
            timer: 5000,
            timerProgressBar: true,
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false
        });
    }
}, 1000);
</script>
@endpush
@endsection