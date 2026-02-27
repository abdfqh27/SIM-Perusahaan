@extends('admin.layouts.app')

@section('title', 'Edit User')

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

.alert-info-custom {
    background: linear-gradient(135deg, rgba(33, 158, 188, 0.1), rgba(142, 202, 230, 0.1));
    border-left: 4px solid var(--blue-light);
    padding: 1rem 1.25rem;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #0c5460;
    font-size: 0.9rem;
}

.alert-info-custom i {
    color: var(--blue-light);
    font-size: 1.2rem;
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

.user-info-box {
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1.25rem;
}

.user-info-box h6 {
    color: var(--blue-dark);
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.user-info-box h6 i {
    color: var(--orange-primary);
}

.user-info-box p {
    color: #6c757d;
    font-size: 0.85rem;
    margin: 0;
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
                <i class="fas fa-user-edit"></i>
            </div>
            <div>
                <h1 class="page-title">Edit User</h1>
                <p class="page-subtitle">Perbarui informasi user {{ $user->name }}</p>
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
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" id="userForm">
                @csrf
                @method('PUT')

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
                                   value="{{ old('name', $user->name) }}" 
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
                                   value="{{ old('email', $user->email) }}" 
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
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->nama) }}
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

                        <div class="alert-info-custom mb-3">
                            <i class="fas fa-info-circle"></i>
                            <span>Kosongkan password jika tidak ingin mengubahnya</span>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <div class="password-wrapper">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Minimal 8 karakter">
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
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <div class="password-wrapper">
                                <input type="password" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Ketik ulang password">
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
                                @if($user->profile_photo)
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Current Photo">
                                @else
                                    <i class="fas fa-user-circle"></i>
                                    <p>Belum ada foto</p>
                                @endif
                            </div>

                            <div class="mt-3">
                                @if($user->profile_photo)
                                    <button type="button" class="btn-danger w-100 mb-2" onclick="confirmDeletePhoto()">
                                        <i class="fas fa-trash"></i> Hapus Foto
                                    </button>
                                @endif

                                <label for="profile_photo" class="btn-outline-primary w-100 text-center">
                                    <i class="fas fa-upload"></i> {{ $user->profile_photo ? 'Ganti Foto' : 'Pilih Foto' }}
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

                        <!-- Info User -->
                        <div class="user-info-box mt-3">
                            <h6><i class="fas fa-calendar-plus"></i> Dibuat</h6>
                            <p>{{ $user->created_at->format('d M Y, H:i') }}</p>
                            
                            @if($user->updated_at != $user->created_at)
                                <h6 class="mt-3"><i class="fas fa-calendar-check"></i> Terakhir Update</h6>
                                <p>{{ $user->updated_at->format('d M Y, H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>

            <!-- Form Delete Photo (Hidden) -->
            @if($user->profile_photo)
                <form id="deletePhotoForm" action="{{ route('admin.users.photo.delete', $user) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
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

    function confirmDeletePhoto() {
        Swal.fire({
            title: 'Hapus Foto Profil?',
            text: 'Foto profil akan dihapus secara permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, Hapus',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading
                Swal.fire({
                    title: 'Menghapus Foto...',
                    html: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                document.getElementById('deletePhotoForm').submit();
            }
        });
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
        
        // Validasi password jika diisi
        if (password && password.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Password Terlalu Pendek',
                text: 'Password minimal 8 karakter!',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        if (password && password !== confirmation) {
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
        
        // Buat pesan konfirmasi
        let confirmHtml = `
            <div style="text-align: left; padding: 1rem;">
                <p style="margin-bottom: 1rem; color: #6c757d;">Apakah Anda yakin ingin memperbarui data user dengan informasi berikut?</p>
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
        `;
        
        if (password) {
            confirmHtml += `
                    <tr>
                        <td style="padding: 0.5rem; color: #6c757d; font-weight: 600;">Password:</td>
                        <td style="padding: 0.5rem; color: #28a745; font-weight: 600;">
                            <i class="fas fa-check-circle"></i> Akan diperbarui
                        </td>
                    </tr>
            `;
        }
        
        confirmHtml += `
                </table>
                <small class="text-muted d-block mt-3">Pastikan semua perubahan sudah benar sebelum menyimpan.</small>
            </div>
        `;
        
        // Konfirmasi sebelum submit
        Swal.fire({
            title: 'Konfirmasi Perubahan',
            html: confirmHtml,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, Update',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Menampilkan indikator loading
                Swal.fire({
                    title: 'Memperbarui Data...',
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