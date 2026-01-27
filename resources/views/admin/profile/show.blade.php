@extends('admin.layouts.app')

@section('title', 'Profil Saya')

@section('page-title', 'Profil Saya')

@section('content')
<style>
    .profile-photo-wrapper {
        display: inline-block;
        position: relative;
    }

    .profile-photo-large {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .profile-photo-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 10px 30px rgba(33, 158, 188, 0.2);
    }

    .profile-photo-placeholder i {
        font-size: 5rem;
        color: white;
    }

    .profile-info-section {
        padding: 1rem 0;
    }

    .info-item {
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 8px;
        height: 100%;
    }

    .info-label {
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    .info-value {
        font-size: 1rem;
        color: var(--blue-dark);
        font-weight: 500;
        margin: 0;
    }

    .badge-role {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }
</style>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Profile Header -->
        <div class="gradient-header">
            <div class="header-content">
                <div class="header-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h3 class="header-title mb-0">Profil Saya</h3>
                    <p class="header-subtitle mb-0">Kelola informasi profil Anda</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.profile.edit') }}" class="btn-header-action btn-edit">
                    <i class="fas fa-edit"></i>
                    <span>Edit Profil</span>
                </a>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="card">
            <div class="card-body p-4">
                <!-- Profile Photo Section -->
                <div class="text-center mb-4 pb-4 border-bottom">
                    <div class="profile-photo-wrapper">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                 alt="{{ $user->name }}" 
                                 class="profile-photo-large">
                        @else
                            <div class="profile-photo-placeholder">
                                <i class="fas fa-user-circle"></i>
                            </div>
                        @endif
                    </div>
                    <h4 class="mt-3 mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-0">
                        <i class="fas fa-shield-alt me-1"></i>
                        {{ $user->role ? $user->role->nama : 'User' }}
                    </p>
                </div>

                <!-- Profile Information -->
                <div class="profile-info-section">
                    <h5 class="mb-3">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informasi Profil
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-user me-2"></i>Nama Lengkap
                                </label>
                                <p class="info-value">{{ $user->name }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                                <p class="info-value">{{ $user->email }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-user-tag me-2"></i>Role
                                </label>
                                <p class="info-value">
                                    <span class="badge badge-role">
                                        {{ $user->role ? $user->role->nama : 'User' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">
                                    <i class="fas fa-calendar-alt me-2"></i>Bergabung Sejak
                                </label>
                                <p class="info-value">{{ $user->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary flex-fill">
                        <i class="fas fa-edit me-2"></i>Edit Profil
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection