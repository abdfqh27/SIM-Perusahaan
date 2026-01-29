@extends('admin.layouts.app')

@section('title', 'Detail Pesan Kontak')

@section('content')
<style>
    .contact-detail-container {
        max-width: 100%;
    }
    
    .message-card {
        margin-bottom: 1.5rem;
    }
    
    .message-status-badge {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1rem;
    }
    
    .badge-read-lg {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .badge-unread-lg {
        background: linear-gradient(135deg, #ffc107, #ffb700);
        color: #000;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .message-subject {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
    }
    
    .message-subject h3 {
        color: var(--blue-dark);
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .message-subject h3 i {
        color: var(--orange-primary);
        font-size: 1.25rem;
    }
    
    .message-content {
        margin-bottom: 1.5rem;
    }
    
    .content-label {
        font-weight: 600;
        color: var(--blue-dark);
        margin-bottom: 0.75rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .content-label i {
        color: var(--orange-primary);
    }
    
    .content-text {
        background: #f8f9fa;
        padding: 1.25rem;
        border-radius: 10px;
        border-left: 4px solid var(--orange-primary);
        color: var(--blue-dark);
        line-height: 1.8;
        font-size: 0.95rem;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    
    .info-card {
        margin-bottom: 1.5rem;
        position: sticky;
        top: 80px;
    }
    
    .info-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(251, 133, 0, 0.2);
    }
    
    .info-icon i {
        color: white;
        font-size: 1.2rem;
    }
    
    .info-content {
        flex: 1;
    }
    
    .info-content label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
        display: block;
    }
    
    .info-content p {
        color: var(--blue-dark);
        font-weight: 500;
        margin: 0;
        font-size: 0.95rem;
        word-break: break-word;
    }
    
    .info-content a {
        color: var(--blue-light);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .info-content a:hover {
        color: var(--orange-primary);
        text-decoration: underline;
    }
    
    .action-card {
        position: sticky;
        top: calc(80px + 1.5rem);
    }
    
    .btn-back {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        border: none;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        box-shadow: 0 3px 10px rgba(108, 117, 125, 0.3);
    }
    
    .btn-back:hover {
        background: linear-gradient(135deg, #5a6268, #6c757d);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.5);
        color: white;
    }
    
    .btn-reply {
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        border: none;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        box-shadow: 0 3px 10px rgba(33, 158, 188, 0.3);
    }
    
    .btn-reply:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(33, 158, 188, 0.5);
        color: white;
    }
    
    .btn-whatsapp {
        background: linear-gradient(135deg, #25D366, #128C7E);
        border: none;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        box-shadow: 0 3px 10px rgba(37, 211, 102, 0.3);
    }
    
    .btn-whatsapp:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 211, 102, 0.5);
        color: white;
    }
    
    .btn-mark-read {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
        cursor: pointer;
    }
    
    .btn-mark-read:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.5);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
        cursor: pointer;
    }
    
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.5);
    }
    
    @media (max-width: 991px) {
        .info-card,
        .action-card {
            position: relative;
            top: 0;
        }
    }
    
    @media (max-width: 768px) {
        .message-subject h3 {
            font-size: 1.25rem;
        }
        
        .content-text {
            padding: 1rem;
            font-size: 0.9rem;
        }
        
        .info-icon {
            width: 40px;
            height: 40px;
        }
        
        .info-icon i {
            font-size: 1rem;
        }
    }
</style>

<div class="contact-detail-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <div>
                    <h1 class="page-title">Detail Pesan Kontak</h1>
                    <p class="page-subtitle">Informasi lengkap pesan dari pengunjung</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('admin.pesan-kontak.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Daftar Pesan
        </a>
    </div>

    <div class="row">
        <!-- Main Message Card -->
        <div class="col-lg-8">
            <div class="card message-card">
                <div class="card-header">
                    <div class="message-status-badge">
                        @if($pesanKontak->sudah_dibaca)
                        <span class="badge-read-lg">
                            <i class="fas fa-check-double"></i> Sudah Dibaca
                        </span>
                        @else
                        <span class="badge-unread-lg">
                            <i class="fas fa-envelope"></i> Belum Dibaca
                        </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Subject -->
                    <div class="message-subject">
                        <h3>
                            <i class="fas fa-tag"></i>
                            {{ $pesanKontak->subjek }}
                        </h3>
                    </div>

                    <!-- Message Content -->
                    <div class="message-content">
                        <label class="content-label">
                            <i class="fas fa-comment-dots"></i>
                            Isi Pesan
                        </label>
                        <div class="content-text">{{ $pesanKontak->pesan }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Sender Info Card -->
            <div class="card info-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        Informasi Pengirim
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-content">
                            <label>Nama</label>
                            <p>{{ $pesanKontak->nama }}</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <label>Email</label>
                            <p>
                                <a href="mailto:{{ $pesanKontak->email }}">
                                    {{ $pesanKontak->email }}
                                </a>
                            </p>
                        </div>
                    </div>

                    @if($pesanKontak->telepon)
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <label>Telepon</label>
                            <p>
                                <a href="tel:{{ $pesanKontak->telepon }}">
                                    {{ $pesanKontak->telepon }}
                                </a>
                            </p>
                        </div>
                    </div>
                    @endif

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="info-content">
                            <label>Tanggal Kirim</label>
                            <p>{{ $pesanKontak->created_at->format('d F Y, H:i') }} WIB</p>
                            <small class="text-muted">
                                {{ $pesanKontak->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>

                    @if($pesanKontak->sudah_dibaca && $pesanKontak->tanggal_dibaca)
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="info-content">
                            <label>Dibaca Pada</label>
                            <p>{{ $pesanKontak->tanggal_dibaca->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Card -->
            <div class="card action-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tools me-2"></i>
                        Tindakan
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Reply Button -->
                    <a href="mailto:{{ $pesanKontak->email }}?subject=Re: {{ $pesanKontak->subjek }}" 
                       class="btn-reply w-100 mb-2">
                        <i class="fas fa-reply"></i>
                        Balas via Email
                    </a>

                    @if($pesanKontak->telepon)
                    <!-- WhatsApp Button -->
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesanKontak->telepon) }}" 
                       target="_blank"
                       class="btn-whatsapp w-100 mb-2">
                        <i class="fab fa-whatsapp"></i>
                        Hubungi via WhatsApp
                    </a>
                    @endif

                    @if(!$pesanKontak->sudah_dibaca)
                    <!-- Mark as Read -->
                    <form action="{{ route('admin.pesan-kontak.mark-read', $pesanKontak->id) }}" 
                          method="POST" 
                          class="mb-2">
                        @csrf
                        <button type="submit" class="btn-mark-read w-100">
                            <i class="fas fa-check"></i>
                            Tandai Sudah Dibaca
                        </button>
                    </form>
                    @endif

                    <!-- Delete Button -->
                    <form action="{{ route('admin.pesan-kontak.destroy', $pesanKontak->id) }}" 
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete w-100">
                            <i class="fas fa-trash"></i>
                            Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>
@endsection