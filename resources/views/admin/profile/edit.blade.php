@extends('admin.layouts.app')

@section('title', 'Edit Profil')

@section('page-title', 'Edit Profil')

@section('content')
<style>
        .current-profile-photo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e9ecef;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .current-photo-wrapper {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
    }

    .upload-info-box {
        border: 1px solid #dee2e6;
    }

    .info-item-small {
        font-size: 0.85rem;
        color: #495057;
    }

    .preview-container {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        border: 2px dashed #dee2e6;
    }

    .security-tips {
        font-size: 0.85rem;
        color: #6c757d;
        padding-left: 1.25rem;
        margin-top: 0.5rem;
    }

    .security-tips li {
        margin-bottom: 0.5rem;
    }

    .security-tips li:last-child {
        margin-bottom: 0;
    }

    .optimization-features {
        list-style: none;
        padding-left: 0;
        color: #6c757d;
    }

    .optimization-features li {
        margin-bottom: 0.4rem;
    }

    .input-group .btn-outline-secondary {
        border-left: none;
    }

    .input-group .form-control:focus + .btn-outline-secondary {
        border-color: var(--orange-primary);
    }

    .photo-info .badge {
        font-size: 0.75rem;
    }
</style>
<div class="row">
    <div class="col-lg-10 mx-auto">
        <!-- Page Header -->
        <div class="gradient-header">
            <div class="header-left">
                <a href="{{ route('admin.profile.show') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="header-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <h3 class="header-title mb-0">Edit Profil</h3>
                    <p class="header-subtitle mb-0">Perbarui informasi profil Anda</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Profile Information Card -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user-circle me-2"></i>Informasi Profil
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                            @csrf
                            @method('PUT')

                            <!-- Nama -->
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       placeholder="Masukkan email"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Foto Profil -->
                            <div class="mb-3">
                                <label for="profile_photo" class="form-label">
                                    <i class="fas fa-camera me-1"></i>Foto Profil
                                </label>
                                
                                @if($user->profile_photo)
                                <div class="current-photo-wrapper mb-3">
                                    <div class="d-flex align-items-start justify-content-between mb-2">
                                        <p class="text-muted mb-0">Foto saat ini:</p>
                                        <div class="photo-info">
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Teroptimasi WebP
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                             alt="Current Photo" 
                                             class="current-profile-photo">
                                        <form action="{{ route('admin.profile.photo.delete') }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus foto profil?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash me-1"></i>Hapus Foto
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif

                                <input type="file" 
                                       class="form-control @error('profile_photo') is-invalid @enderror" 
                                       id="profile_photo" 
                                       name="profile_photo"
                                       accept="image/jpeg,image/jpg,image/png"
                                       onchange="previewImage(event)">
                                
                                <!-- Info Helper dengan Badge -->
                                <div class="upload-info-box mt-2 p-3 bg-light rounded">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div class="info-item-small">
                                                <i class="fas fa-file-image text-primary me-1"></i>
                                                <strong>Format:</strong> JPG, JPEG, PNG
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item-small">
                                                <i class="fas fa-weight text-warning me-1"></i>
                                                <strong>Maksimal:</strong> 5MB
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="alert alert-info mb-0 mt-2" style="padding: 0.5rem;">
                                                <i class="fas fa-magic me-1"></i>
                                                <strong>Otomatis Dioptimasi!</strong> 
                                                Foto Anda akan dikonversi ke format WebP dengan ukuran ~40-60KB 
                                                tapi tetap HD 📸✨
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @error('profile_photo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <!-- Preview Foto Baru -->
                                <div id="preview-wrapper" class="mt-3" style="display: none;">
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-eye me-1"></i>Preview foto baru:
                                    </p>
                                    <div class="preview-container">
                                        <img id="preview-image" src="" alt="Preview" class="current-profile-photo">
                                        <div id="file-size-info" class="mt-2">
                                            <span class="badge bg-info">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Ukuran asli: <span id="original-size">0 KB</span>
                                            </span>
                                            <span class="badge bg-success">
                                                <i class="fas fa-arrow-down me-1"></i>
                                                Akan dikompres ~60-70%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2 pt-3 border-top">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.profile.show') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-key me-2"></i>Ubah Password
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Password Lama -->
                            <div class="mb-3">
                                <label for="current_password" class="form-label">
                                    Password Saat Ini
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password"
                                           placeholder="Masukkan password saat ini"
                                           required>
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="togglePassword('current_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Baru -->
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    Password Baru
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password"
                                           placeholder="Masukkan password baru"
                                           required>
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Minimal 8 karakter
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    Konfirmasi Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation"
                                           placeholder="Ulangi password baru"
                                           required>
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-key me-2"></i>Ubah Password
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="mb-2">
                            <i class="fas fa-shield-alt text-primary me-2"></i>Tips Keamanan
                        </h6>
                        <ul class="security-tips mb-0">
                            <li>Gunakan password yang kuat dan unik</li>
                            <li>Minimal 8 karakter</li>
                            <li>Kombinasi huruf besar, kecil, dan angka</li>
                            <li>Jangan bagikan password Anda</li>
                            <li>Ubah password secara berkala</li>
                        </ul>
                    </div>
                </div>

                <!-- WebP Info Card -->
                <div class="card mt-3 border-success">
                    <div class="card-body">
                        <h6 class="mb-2 text-success">
                            <i class="fas fa-bolt me-2"></i>Optimasi Gambar
                        </h6>
                        <p class="small text-muted mb-2">
                            Foto profil Anda otomatis dioptimasi menggunakan teknologi WebP:
                        </p>
                        <ul class="optimization-features small mb-0">
                            <li><i class="fas fa-check text-success me-1"></i>Ukuran 70% lebih kecil</li>
                            <li><i class="fas fa-check text-success me-1"></i>Tetap kualitas HD</li>
                            <li><i class="fas fa-check text-success me-1"></i>Loading super cepat</li>
                            <li><i class="fas fa-check text-success me-1"></i>Hemat bandwidth</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview image before upload with file size
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            // Check file size (5MB = 5242880 bytes)
            if (file.size > 5242880) {
                alert('Ukuran file terlalu besar! Maksimal 5MB.');
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-wrapper').style.display = 'block';
                
                // Display file size
                const sizeInKB = (file.size / 1024).toFixed(2);
                const sizeInMB = (file.size / 1024 / 1024).toFixed(2);
                const displaySize = sizeInMB >= 1 ? sizeInMB + ' MB' : sizeInKB + ' KB';
                
                document.getElementById('original-size').textContent = displaySize;
            }
            reader.readAsDataURL(file);
        }
    }

    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const button = field.nextElementSibling;
        const icon = button.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Form submission with loading state
    document.getElementById('profileForm').addEventListener('submit', function() {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    });
</script>
@endpush
@endsection