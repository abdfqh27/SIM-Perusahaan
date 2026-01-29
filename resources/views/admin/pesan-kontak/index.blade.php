@extends('admin.layouts.app')

@section('title', 'Pesan Kontak')

@section('content')
<style>
    .unread-row {
        background: linear-gradient(90deg, rgba(251, 133, 0, 0.03), transparent);
        font-weight: 500;
    }
    
    .sender-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .badge-new {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        font-size: 0.65rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-weight: 600;
    }
    
    .email-link {
        color: var(--blue-light);
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .email-link:hover {
        color: var(--orange-primary);
        text-decoration: underline;
    }
    
    .subject-preview {
        font-size: 0.9rem;
        color: var(--blue-dark);
        line-height: 1.4;
    }
    
    .date-info {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .date-info i {
        color: var(--blue-light);
        margin-right: 0.25rem;
    }
    
    .badge-read {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        padding: 0.35rem 0.7rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .badge-unread {
        background: linear-gradient(135deg, #ffc107, #ffb700);
        color: #000;
        padding: 0.35rem 0.7rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.25rem;
        justify-content: center;
    }
    
    .btn-view {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 1px solid var(--blue-light);
        color: var(--blue-light);
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn-view:hover {
        background: var(--blue-light);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-mark-read {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 1px solid #28a745;
        color: #28a745;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn-mark-read:hover {
        background: #28a745;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-delete {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 1px solid #dc3545;
        color: #dc3545;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn-delete:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: var(--blue-light);
        opacity: 0.3;
        margin-bottom: 1rem;
    }
    
    .empty-state h4 {
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        color: #6c757d;
    }
    
    .stat-total {
        border-left: 4px solid var(--orange-primary);
    }
    
    .stat-unread {
        border-left: 4px solid #ffc107;
    }
    
    .stat-read {
        border-left: 4px solid #28a745;
    }
</style>

<div class="container-fluid">
    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Header Section -->
    <div class="gradient-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-comment"></i>
            </div>
            <div>
                <h2 class="header-title">Daftar Pesan</h2>
                <p class="header-subtitle">Kelola dan respon pesan dari pengguna</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-total">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Pesan</p>
                            <h3 class="mb-0 fw-bold" style="color: var(--blue-dark);">{{ $pesanKontaks->count() }}</h3>
                        </div>
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary)); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-envelope" style="color: white; font-size: 1.8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card stat-unread">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Belum Dibaca</p>
                            <h3 class="mb-0 fw-bold" style="color: var(--blue-dark);">{{ $pesanKontaks->where('sudah_dibaca', false)->count() }}</h3>
                        </div>
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #ffc107, #ffb700); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-envelope-open" style="color: white; font-size: 1.8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card stat-read">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Sudah Dibaca</p>
                            <h3 class="mb-0 fw-bold" style="color: var(--blue-dark);">{{ $pesanKontaks->where('sudah_dibaca', true)->count() }}</h3>
                        </div>
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #28a745, #20c997); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check-double" style="color: white; font-size: 1.8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Table -->
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
                            <th width="15%">
                                <i class="fas fa-user"></i> Nama
                            </th>
                            <th width="18%">
                                <i class="fas fa-envelope"></i> Email
                            </th>
                            <th width="20%">
                                <i class="fas fa-tag"></i> Subjek
                            </th>
                            <th width="12%">
                                <i class="fas fa-calendar"></i> Tanggal
                            </th>
                            <th width="10%">
                                <i class="fas fa-eye"></i> Status
                            </th>
                            <th width="20%" class="text-center">
                                <i class="fas fa-cog"></i> Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanKontaks as $index => $pesanKontak)
                        <tr class="{{ !$pesanKontak->sudah_dibaca ? 'unread-row' : '' }}">
                            <td class="align-middle">{{ $index + 1 }}</td>
                            <td class="align-middle">
                                <div class="sender-info">
                                    <strong>{{ $pesanKontak->nama }}</strong>
                                    @if(!$pesanKontak->sudah_dibaca)
                                    <span class="badge badge-new">Baru</span>
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle">
                                <a href="mailto:{{ $pesanKontak->email }}" class="email-link">
                                    {{ $pesanKontak->email }}
                                </a>
                            </td>
                            <td class="align-middle">
                                <div class="subject-preview">
                                    {{ Str::limit($pesanKontak->subjek, 40) }}
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="date-info">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $pesanKontak->created_at->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">
                                        {{ $pesanKontak->created_at->format('H:i') }}
                                    </small>
                                </div>
                            </td>
                            <td class="align-middle">
                                @if($pesanKontak->sudah_dibaca)
                                <span class="badge badge-read">
                                    <i class="fas fa-check-double"></i> Dibaca
                                </span>
                                @else
                                <span class="badge badge-unread">
                                    <i class="fas fa-envelope"></i> Belum
                                </span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.pesan-kontak.show', $pesanKontak->id) }}" 
                                       class="btn btn-view" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if(!$pesanKontak->sudah_dibaca)
                                    <form action="{{ route('admin.pesan-kontak.tandai-dibaca', $pesanKontak->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-mark-read" 
                                                title="Tandai Dibaca">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.pesan-kontak.destroy', $pesanKontak->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-delete" 
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
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h4>Belum Ada Pesan</h4>
                <p>Belum ada pesan kontak yang masuk</p>
            </div>
            @endif
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