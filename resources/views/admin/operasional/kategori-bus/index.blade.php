@extends('admin.layouts.app')

@section('title', 'Kategori Bus')
@section('page-title', 'Kategori Bus')

@push('styles')
<style>
    .kategori-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .kategori-badge i {
        font-size: 1rem;
    }
    
    .kategori-badge-primary {
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.1), rgba(255, 183, 3, 0.1));
        color: #FB8500;
        border: 1px solid rgba(251, 133, 0, 0.3);
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }
    
    .action-buttons .btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }
    
    .empty-state h5 {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        color: #adb5bd;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="gradient-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-images"></i>
            </div>
            <div>
                <h2 class="header-title">Kelola Kategori Bus</h2>
                <p class="header-subtitle">Kelola Daftar Kategori Bus</p>
            </div>
        </div>
        <a href="{{ route('admin.operasional.kategori-bus.create') }}" class="btn-hero-add">
            <i class="fas fa-plus"></i>
            <span>Tambah Hero Section</span>
        </a>
    </div>

    <!-- Kategori Table -->
    <div class="card">
        <div class="card-body">
            @if($kategories->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-list-ul"></i>
                    <h5>Belum Ada Kategori Bus</h5>
                    <p>Mulai tambahkan kategori bus untuk mengelompokkan armada Anda</p>
                    <a href="{{ route('admin.operasional.kategori-bus.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Kategori Pertama
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 40%;">Nama Kategori</th>
                                <th style="width: 20%;">Kapasitas</th>
                                <th style="width: 15%;">Jumlah Bus</th>
                                <th style="width: 20%;" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategories as $index => $kategori)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $kategori->nama_kategori }}</strong>
                                </td>
                                <td>
                                    <div class="kategori-badge kategori-badge-primary">
                                        <i class="fas fa-users"></i>
                                        <span>{{ $kategori->kapasitas }} Orang</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $kategori->buses_count }} Bus</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.operasional.kategori-bus.edit', $kategori->id) }}" 
                                           class="btn btn-warning" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.operasional.kategori-bus.destroy', $kategori->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger" 
                                                    title="Hapus"
                                                    {{ $kategori->buses_count > 0 ? 'disabled' : '' }}>
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
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush