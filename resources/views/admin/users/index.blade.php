@extends('admin.layouts.app')

@section('title', 'Manajemen User')

@section('content')
<style>
.user-table-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e9ecef;
}

.user-table-avatar-placeholder {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.2rem;
}

.user-table-name {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #6c757d;
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    display: block;
    opacity: 0.3;
    color: #6c757d;
}

.empty-state-title {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 500;
    color: #6c757d;
}

.empty-state-subtitle {
    margin: 0.5rem 0 0 0;
    font-size: 0.9rem;
    color: #adb5bd;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.btn-action {
    padding: 0.4rem 1rem;
    font-size: 0.85rem;
}
</style>
<!-- Header Section -->
<div class="gradient-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-users-cog"></i>
        </div>
        <div>
            <h2 class="header-title">Manajemen User</h2>
            <p class="header-subtitle">Kelola Daftar Pengguna</p>
        </div>
    </div>
    <div class="header-actions">
        <button class="btn-refresh" onclick="location.reload()">
            <i class="fas fa-sync-alt"></i>
            <span>Refresh</span>
        </button>
        <a href="{{ route('admin.users.create') }}" class="btn-add">
            <i class="fas fa-plus"></i>
            <span>Tambah User</span>
        </a>
    </div>
</div>

<!-- Alert -->
@if(session('success'))
<div class="alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert-danger">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
</div>
@endif

<!-- Statistik Grid -->
<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h2 class="stat-number">{{ $users->count() }}</h2>
                <p class="stat-label">Total User</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-success">
                <i class="fas fa-crown"></i>
            </div>
            <div class="stat-content">
                <h2 class="stat-number">{{ $users->filter(fn($u) => $u->role && $u->role->slug === 'owner')->count() }}</h2>
                <p class="stat-label">Owner</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-info">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-content">
                <h2 class="stat-number">{{ $users->filter(fn($u) => $u->role && $u->role->slug === 'admin-company')->count() }}</h2>
                <p class="stat-label">Admin Company</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div class="icon-wrapper icon-warning">
                <i class="fas fa-user-cog"></i>
            </div>
            <div class="stat-content">
                <h2 class="stat-number">{{ $users->filter(fn($u) => $u->role && $u->role->slug === 'admin-operasional')->count() }}</h2>
                <p class="stat-label">Admin Operasional</p>
            </div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 10%;">Foto</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 23%;">Email</th>
                        <th style="width: 12%;">Role</th>
                        <th style="width: 13%;">Terdaftar</th>
                        <th style="width: 17%; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                     alt="{{ $user->name }}" 
                                     class="user-table-avatar">
                            @else
                                <div class="user-table-avatar-placeholder">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role ? $user->role->nama : 'ROLE NULL' }}</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                   class="btn-info btn-action" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   class="btn-warning btn-action"
                                   title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                      method="POST" 
                                      style="display: inline;" 
                                      class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn-danger btn-action"
                                            title="Hapus User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <button class="btn-secondary btn-action" 
                                        disabled 
                                        title="Tidak dapat menghapus akun sendiri">
                                    <i class="fas fa-lock"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-inbox empty-state-icon"></i>
                                <p class="empty-state-title">Belum ada data user</p>
                                <p class="empty-state-subtitle">Klik tombol "Tambah User" untuk menambahkan user baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete konfirmasi
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data user akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
        
        // Auto hide alerts
        const alerts = document.querySelectorAll('.alert-success, .alert-danger');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    });
</script>
@endpush