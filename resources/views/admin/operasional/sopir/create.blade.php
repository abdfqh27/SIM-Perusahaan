@extends('admin.layouts.app')

@section('title', 'Tambah Sopir')

@section('content')
<div class="admin-content">
    <!-- Page Header -->
    <div class="gradient-header">
        <div class="header-left">
            <a href="{{ route('admin.operasional.sopir.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div>
                <h2 class="header-title">Tambah sopir</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.operasional.sopir.index') }}">sopir</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit"></i> Form Data Sopir
        </div>
        <div class="card-body">
            <form action="{{ route('admin.operasional.sopir.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Nama Lengkap -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_sopir" class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('nama_sopir') is-invalid @enderror" 
                                       id="nama_sopir" 
                                       name="nama_sopir" 
                                       value="{{ old('nama_sopir') }}" 
                                       placeholder="Masukkan nama lengkap"
                                       required>
                            </div>
                            @error('nama_sopir')
                                <div class="invalid-feedback-custom">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- NIK -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nik" class="form-label">
                                NIK (16 Digit) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-id-card-alt"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('nik') is-invalid @enderror" 
                                       id="nik" 
                                       name="nik" 
                                       value="{{ old('nik') }}" 
                                       placeholder="Masukkan 16 digit NIK"
                                       maxlength="16"
                                       required>
                            </div>
                            @error('nik')
                                <div class="invalid-feedback-custom">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- No. HP -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_hp" class="form-label">
                                No. HP <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('no_hp') is-invalid @enderror" 
                                       id="no_hp" 
                                       name="no_hp" 
                                       value="{{ old('no_hp') }}" 
                                       placeholder="08xxxxxxxxxx"
                                       maxlength="15"
                                       required>
                            </div>
                            @error('no_hp')
                                <div class="invalid-feedback-custom">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Jenis SIM -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_sim" class="form-label">
                                Jenis SIM <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-certificate"></i>
                                </span>
                                <select class="form-control @error('jenis_sim') is-invalid @enderror" 
                                        id="jenis_sim" 
                                        name="jenis_sim" 
                                        required>
                                    <option value="">Pilih Jenis SIM</option>
                                    <option value="SIM A" {{ old('jenis_sim') == 'SIM A' ? 'selected' : '' }}>SIM A</option>
                                    <option value="SIM B1" {{ old('jenis_sim') == 'SIM B1' ? 'selected' : '' }}>SIM B1</option>
                                    <option value="SIM B2" {{ old('jenis_sim') == 'SIM B2' ? 'selected' : '' }}>SIM B2</option>
                                </select>
                            </div>
                            @error('jenis_sim')
                                <div class="invalid-feedback-custom">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- No. SIM -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_sim" class="form-label">
                                No. SIM <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('no_sim') is-invalid @enderror" 
                                       id="no_sim" 
                                       name="no_sim" 
                                       value="{{ old('no_sim') }}" 
                                       placeholder="Masukkan nomor SIM"
                                       maxlength="20"
                                       required>
                            </div>
                            @error('no_sim')
                                <div class="invalid-feedback-custom">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status" class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon">
                                    <i class="fas fa-toggle-on"></i>
                                </span>
                                <select class="form-control @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                            </div>
                            @error('status')
                                <div class="invalid-feedback-custom">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="col-12">
                        <div class="form-group">
                            <label for="alamat" class="form-label">
                                Alamat <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-icon" style="align-items: flex-start; padding-top: 0.75rem;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" 
                                          name="alamat" 
                                          rows="4" 
                                          placeholder="Masukkan alamat lengkap"
                                          required>{{ old('alamat') }}</textarea>
                            </div>
                            @error('alamat')
                                <div class="invalid-feedback-custom">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                    <button type="reset" class="btn-secondary">
                        <i class="fas fa-redo"></i> Reset Form
                    </button>
                    <a href="{{ route('admin.operasional.sopir.index') }}" class="btn-danger">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card" style="margin-top: 1.5rem;">
        <div class="card-body" style="background: linear-gradient(135deg, rgba(251, 133, 0, 0.05), rgba(255, 183, 3, 0.05));">
            <div style="display: flex; gap: 1rem; align-items: flex-start;">
                <div style="color: var(--orange-primary); font-size: 2rem;">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div>
                    <h5 style="color: var(--blue-dark); margin: 0 0 0.5rem 0; font-weight: 600;">
                        <i class="fas fa-lightbulb"></i> Informasi Penting
                    </h5>
                    <ul style="margin: 0; padding-left: 1.25rem; color: #6c757d; line-height: 1.8;">
                        <li>Pastikan semua data yang diisi sudah benar dan sesuai</li>
                        <li>NIK harus 16 digit angka sesuai KTP</li>
                        <li>Nomor SIM harus masih berlaku dan sesuai jenis SIM</li>
                        <li>Nomor HP harus aktif dan dapat dihubungi</li>
                        <li>Sopir baru akan berstatus "Belum Bertugas" sampai ditugaskan ke bus</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Form Styling */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--blue-dark);
    font-size: 0.95rem;
}

.input-group {
    position: relative;
    display: flex;
}

.input-icon {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--orange-primary);
    font-size: 1.1rem;
    z-index: 10;
    pointer-events: none;
}

.form-control {
    width: 100%;
    padding: 0.75rem 0.75rem 0.75rem 3rem;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: var(--orange-primary);
    box-shadow: 0 0 0 0.2rem rgba(251, 133, 0, 0.15);
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.form-control::placeholder {
    color: #adb5bd;
}

select.form-control {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23FB8500' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 12px;
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
    padding-top: 0.75rem;
}

.invalid-feedback-custom {
    display: block;
    margin-top: 0.5rem;
    color: #dc3545;
    font-size: 0.875rem;
    font-weight: 500;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid #e9ecef;
    flex-wrap: wrap;
}

.text-danger {
    color: #dc3545;
}

/* Responsive */
@media (max-width: 768px) {
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions button,
    .form-actions a {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection