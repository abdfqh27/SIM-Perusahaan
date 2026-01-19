@extends('admin.layouts.app')

@section('title', 'Detail User')

@section('content')
<style>
.profile-photo-large {
    width: 180px;
    height: 180px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    overflow: hidden;
    border: 5px solid #e9ecef;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.profile-photo-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.default-avatar {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
}

.default-avatar i {
    font-size: 6rem;
    color: #dee2e6;
}

.user-name-large {
    color: var(--blue-dark);
    font-weight: 700;
    font-size: 1.75rem;
    margin-bottom: 0.5rem;
}

.user-role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 15px rgba(251, 133, 0, 0.3);
}

.user-email-box {
    background: #f8f9fa;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    margin: 1rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: #6c757d;
    font-size: 0.95rem;
}

.user-email-box i {
    color: var(--orange-primary);
}

.profile-stats {
    border-top: 2px solid #e9ecef;
    border-bottom: 2px solid #e9ecef;
    padding: 1.5rem 0;
    margin: 1.5rem 0;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 0;
}

.stat-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.stat-info {
    flex: 1;
    text-align: left;
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
}

.stat-value {
    font-size: 1rem;
    color: var(--blue-dark);
    font-weight: 600;
}

.profile-actions {
    margin-top: 1.5rem;
}

.card-header-custom {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 15px 15px 0 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.05rem;
}

.info-grid {
    display: grid;
    gap: 1.5rem;
}

.info-item {
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #e9ecef;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: #6c757d;
    font-weight: 600;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-label i {
    color: var(--orange-primary);
}

.info-value {
    color: var(--blue-dark);
    font-weight: 600;
    font-size: 1rem;
}

.role-badge {
    display: inline-block;
    padding: 0.35rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
}

.role-owner {
    background: linear-gradient(135deg, #ffc107, #ff9800);
    color: #212529;
}

.role-admin-company {
    background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    color: white;
}

.timeline {
    position: relative;
    padding-left: 3rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 22px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, var(--orange-primary), transparent);
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-icon {
    position: absolute;
    left: -2.8rem;
    top: 0;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.timeline-content h6 {
    color: var(--blue-dark);
    font-weight: 700;
    font-size: 1.05rem;
    margin-bottom: 0.5rem;
}

.timeline-content p {
    color: #495057;
    margin-bottom: 0.25rem;
    font-size: 0.95rem;
}

.permission-info {
    padding: 0.5rem 0;
}

.permission-badge {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    font-size: 1.05rem;
}

.permission-badge i {
    font-size: 1.5rem;
}

.full-access {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 152, 0, 0.2));
    border-left: 4px solid #ffc107;
    color: #856404;
}

.company-access {
    background: linear-gradient(135deg, rgba(33, 158, 188, 0.2), rgba(142, 202, 230, 0.2));
    border-left: 4px solid var(--blue-light);
    color: #0c5460;
}

.limited-access {
    background: linear-gradient(135deg, rgba(108, 117, 125, 0.2), rgba(90, 98, 104, 0.2));
    border-left: 4px solid #6c757d;
    color: #383d41;
}

.permission-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.permission-list li {
    padding: 0.75rem 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.95rem;
}

.permission-list li i {
    font-size: 1rem;
}

.permission-list li .fa-check-circle {
    color: #28a745;
}

.permission-list li .fa-times-circle {
    color: #dc3545;
}

@media (max-width: 768px) {
    .info-item {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }

    .header-actions {
        flex-direction: column;
        width: 100%;
    }

    .header-actions .btn-warning,
    .header-actions .btn-secondary {
        width: 100%;
        justify-content: center;
    }
}
</style>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <h1 class="page-title">Detail User</h1>
                <p class="page-subtitle">Informasi lengkap user {{ $user->name }}</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn-warning">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="profile-photo-large">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}">
                        @else
                            <div class="default-avatar">
                                <i class="fas fa-user-circle"></i>
                            </div>
                        @endif
                    </div>

                    <h4 class="user-name-large">{{ $user->name }}</h4>
                    <div class="user-role-badge">
                        <i class="fas fa-shield-alt"></i>
                        {{ ucfirst($user->role->name) }}
                    </div>

                    <div class="user-email-box">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $user->email }}</span>
                    </div>

                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Bergabung</span>
                                <span class="stat-value">{{ $user->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                        @if($user->updated_at != $user->created_at)
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-label">Terakhir Update</span>
                                    <span class="stat-value">{{ $user->updated_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="profile-actions">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn-primary w-100 mb-2">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                        
                        @if($user->id !== auth()->id())
                            <button type="button" class="btn-danger w-100" onclick="confirmDelete()">
                                <i class="fas fa-trash"></i> Hapus User
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail -->
        <div class="col-md-8">
            <!-- Informasi Akun -->
            <div class="card mb-3">
                <div class="card-header-custom">
                    <i class="fas fa-user-cog"></i>
                    <span>Informasi Akun</span>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-id-card"></i>
                                ID User
                            </div>
                            <div class="info-value">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user"></i>
                                Nama Lengkap
                            </div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-envelope"></i>
                                Email
                            </div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-shield-alt"></i>
                                Role
                            </div>
                            <div class="info-value">
                                <span class="role-badge role-{{ strtolower($user->role->name) }}">
                                    {{ ucfirst($user->role->name) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aktifitas  -->
            <div class="card mb-3">
                <div class="card-header-custom">
                    <i class="fas fa-history"></i>
                    <span>Riwayat Aktivitas</span>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon bg-success">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Akun Dibuat</h6>
                                <p>{{ $user->created_at->format('d F Y, H:i') }} WIB</p>
                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                            </div>
                        </div>

                        @if($user->updated_at != $user->created_at)
                            <div class="timeline-item">
                                <div class="timeline-icon bg-info">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Terakhir Diperbarui</h6>
                                    <p>{{ $user->updated_at->format('d F Y, H:i') }} WIB</p>
                                    <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Role Permissions -->
            <div class="card">
                <div class="card-header-custom">
                    <i class="fas fa-key"></i>
                    <span>Hak Akses Role</span>
                </div>
                <div class="card-body">
                    <div class="permission-info">
                        @if($user->role->name === 'owner')
                            <div class="permission-badge full-access">
                                <i class="fas fa-crown"></i>
                                <span>Full Access - Semua Fitur</span>
                            </div>
                            <ul class="permission-list">
                                <li><i class="fas fa-check-circle"></i> Manajemen User</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Profil Perusahaan</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Hero Section</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Layanan</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Armada</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Gallery & Artikel</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Pesan Kontak</li>
                                <li><i class="fas fa-check-circle"></i> Pengaturan Sistem</li>
                            </ul>
                        @elseif($user->role->name === 'admin-company')
                            <div class="permission-badge company-access">
                                <i class="fas fa-user-tie"></i>
                                <span>Admin Company - Manajemen Konten</span>
                            </div>
                            <ul class="permission-list">
                                <li><i class="fas fa-check-circle"></i> Manajemen Profil Perusahaan</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Hero Section</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Layanan</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Armada</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Gallery & Artikel</li>
                                <li><i class="fas fa-check-circle"></i> Manajemen Pesan Kontak</li>
                                <li><i class="fas fa-check-circle"></i> Pengaturan Sistem</li>
                                <li class="text-muted"><i class="fas fa-times-circle"></i> Manajemen User (Terbatas)</li>
                            </ul>
                        @else
                            <div class="permission-badge limited-access">
                                <i class="fas fa-user"></i>
                                <span>{{ ucfirst($user->role->name) }} - Akses Terbatas</span>
                            </div>
                            <ul class="permission-list">
                                <li><i class="fas fa-check-circle"></i> Dashboard</li>
                                <li class="text-muted"><i class="fas fa-times-circle"></i> Akses Lainnya Terbatas</li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    @if($user->id !== auth()->id())
        <form id="deleteForm" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endif
</div>

<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Hapus User?',
            text: 'User {{ $user->name }} akan dihapus secara permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>
@endsection