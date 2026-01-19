@extends('admin.layouts.app')

@section('title', 'Tambah User')

@section('content')
<style>
.form-section-title {
    color: var(--blue-dark);
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-section-title i {
    color: var(--orange-primary);
}

.password-wrapper {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    padding: 5px 10px;
    transition: color 0.3s ease;
}

.toggle-password:hover {
    color: var(--orange-primary);
}

.photo-upload-wrapper {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
}

.photo-preview {
    width: 200px;
    height: 200px;
    margin: 0 auto;
    border-radius: 15px;
    background: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 3px solid #e9ecef;
}

.photo-preview i {
    font-size: 4rem;
    color: #dee2e6;
}

.photo-preview p {
    margin: 0.5rem 0 0 0;
    color: #6c757d;
    font-size: 0.9rem;
}

.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.form-actions {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid #e9ecef;
    display: flex;
    gap: 1rem;
    justify-content: flex-start;
}

@media (max-width: 768px) {
    .form-actions {
        flex-direction: column;
    }

    .form-actions .btn-primary,
    .form-actions .btn-secondary {
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
                <i class="fas fa-user-plus"></i>
            </div>
            <div>
                <h1 class="page-title">Tambah User Baru</h1>
                <p class="page-subtitle">Buat akun user baru untuk sistem</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" id="userForm">
                @csrf

                <div class="row">
                    <!-- Informasi Dasar -->
                    <div class="col-md-8">
                        <h5 class="form-section-title">
                            <i class="fas fa-info-circle"></i> Informasi Dasar
                        </h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="contoh@email.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('role_id') is-invalid @enderror" 
                                    id="role_id" 
                                    name="role_id" 
                                    required>
                                <option value="">-- Pilih Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="form-section-title mt-4">
                            <i class="fas fa-lock"></i> Keamanan
                        </h5>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="password-wrapper">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Minimal 8 karakter"
                                       required>
                                <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                            </div>
                            <small class="text-muted">Password harus minimal 8 karakter</small>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <div class="password-wrapper">
                                <input type="password" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Ketik ulang password"
                                       required>
                                <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Foto Profil -->
                    <div class="col-md-4">
                        <h5 class="form-section-title">
                            <i class="fas fa-image"></i> Foto Profil
                        </h5>

                        <div class="photo-upload-wrapper">
                            <div class="photo-preview" id="photoPreview">
                                <i class="fas fa-user-circle"></i>
                                <p>Belum ada foto</p>
                            </div>

                            <div class="mt-3">
                                <label for="profile_photo" class="btn-outline-primary w-100 text-center">
                                    <i class="fas fa-upload"></i> Pilih Foto
                                </label>
                                <input type="file" 
                                       class="d-none @error('profile_photo') is-invalid @enderror" 
                                       id="profile_photo" 
                                       name="profile_photo" 
                                       accept="image/jpeg,image/jpg,image/png"
                                       onchange="previewPhoto(event)">
                                @error('profile_photo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-2">
                                    Format: JPG, JPEG, PNG<br>
                                    Maksimal: 2MB
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Aksi -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Simpan User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function previewPhoto(event) {
        const preview = document.getElementById('photoPreview');
        const file = event.target.files[0];
        const fileInput = event.target;
        
        if (file) {
            // Validasi tipe file
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format File Salah',
                    text: 'File harus berformat JPG, JPEG, atau PNG!',
                    confirmButtonText: 'OK'
                });
                fileInput.value = '';
                return;
            }
            
            // Validasi ukuran file (max 2MB)
            const maxSize = 2 * 1024 * 1024;
            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal 2MB!',
                    confirmButtonText: 'OK'
                });
                fileInput.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                
                Swal.fire({
                    icon: 'success',
                    title: 'Foto Berhasil Dipilih',
                    text: 'Preview foto telah ditampilkan',
                    timer: 1500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
            reader.readAsDataURL(file);
        }
    }

    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');
        
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

// SUBMIT FORM DENGAN KONFIRMASI
    document.getElementById('userForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmation = document.getElementById('password_confirmation').value;
        const roleId = document.getElementById('role_id').value;
        const roleText = document.getElementById('role_id').options[document.getElementById('role_id').selectedIndex].text;
        
        // Validasi field kosong
        if (!name) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap',
                text: 'Nama lengkap harus diisi!',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        if (!email) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap',
                text: 'Email harus diisi!',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        if (!roleId) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap',
                text: 'Role harus dipilih!',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        if (!password) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap',
                text: 'Password harus diisi!',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        if (password.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Password Terlalu Pendek',
                text: 'Password minimal 8 karakter!',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        if (password !== confirmation) {
            Swal.fire({
                icon: 'error',
                title: 'Password Tidak Cocok',
                text: 'Password dan konfirmasi password harus sama!',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Validasi email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Format Email Salah',
                text: 'Masukkan alamat email yang valid!',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Konfirmasi sebelum submit
        Swal.fire({
            title: 'Konfirmasi Penyimpanan',
            html: `
                <div style="text-align: left; padding: 1rem;">
                    <p style="margin-bottom: 1rem; color: #6c757d;">Apakah Anda yakin ingin menyimpan user baru dengan data berikut?</p>
                    <table style="width: 100%; font-size: 0.95rem;">
                        <tr>
                            <td style="padding: 0.5rem; color: #6c757d; font-weight: 600; width: 40%;">Nama:</td>
                            <td style="padding: 0.5rem; color: #013a52;">${name}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem; color: #6c757d; font-weight: 600;">Email:</td>
                            <td style="padding: 0.5rem; color: #013a52;">${email}</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem; color: #6c757d; font-weight: 600;">Role:</td>
                            <td style="padding: 0.5rem; color: #013a52;">${roleText}</td>
                        </tr>
                    </table>
                    <small class="text-muted d-block mt-3">Pastikan semua data sudah benar sebelum menyimpan.</small>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, Simpan',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Menampilkan indikator loading
                Swal.fire({
                    title: 'Menyimpan Data...',
                    html: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Mengirim form
                this.submit();
            }
        });
    });
</script>
@endpush