@extends('admin.layouts.app')

@section('title', 'Edit Bus')

@section('content')
<style>
/* Form Label Required */
.form-label.required {
    font-weight: 600;
    color: var(--blue-dark);
    margin-bottom: 0.5rem;
    display: block;
}

/* Status Radio Group */
.status-radio-group {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.status-radio-item {
    display: flex;
    align-items: center;
}

.status-radio-item .form-check-input {
    width: 20px;
    height: 20px;
    margin-right: 0.5rem;
    cursor: pointer;
}

.status-radio-item .form-check-label {
    cursor: pointer;
    display: flex;
    align-items: center;
    margin-bottom: 0;
}

.status-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all var(--transition-speed) ease;
}

.status-aktif {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.status-perawatan {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.status-radio-item input:checked + label .status-badge {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.status-aktif:hover {
    background: rgba(40, 167, 69, 0.2);
}

.status-perawatan:hover {
    background: rgba(255, 193, 7, 0.2);
}

/* Form Actions */
.form-actions {
    border-top: 2px solid #e9ecef;
    padding-top: 1.5rem;
    margin-top: 1rem;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

/* Form Text Muted Enhancement */
.form-text.text-muted {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.85rem;
    color: #6c757d;
}

.form-text.text-muted i {
    margin-right: 0.25rem;
}

/* Breadcrumb in Header */
.gradient-header .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0.5rem 0 0 0;
}

.gradient-header .breadcrumb-item {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
}

.gradient-header .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: color var(--transition-speed) ease;
}

.gradient-header .breadcrumb-item a:hover {
    color: white;
}

.gradient-header .breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.7);
}

.gradient-header .breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255, 255, 255, 0.6);
    padding: 0 0.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .status-radio-group {
        flex-direction: column;
        gap: 1rem;
    }
    
    .form-actions {
        flex-direction: column-reverse;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}
</style>
<div class="admin-content">
    <!-- Page Header -->
    <div class="gradient-header">
        <div class="header-left">
            <a href="{{ route('admin.operasional.bus.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div>
                <h2 class="header-title">Edit Bus</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.operasional.bus.index') }}">Bus</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i>
            Formulir Edit Data Bus
        </div>
        <div class="card-body">
            <form action="{{ route('admin.operasional.bus.update', $bu->id) }}" method="POST" id="editBusForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Kode Bus -->
                    <div class="col-md-6 mb-4">
                        <label for="kode_bus" class="form-label required">
                            Kode Bus <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('kode_bus') is-invalid @enderror" 
                               id="kode_bus" 
                               name="kode_bus" 
                               value="{{ old('kode_bus', $bu->kode_bus) }}"
                               placeholder="Contoh: BUS001"
                               required>
                        @error('kode_bus')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Nama Bus -->
                    <div class="col-md-6 mb-4">
                        <label for="nama_bus" class="form-label required">
                            Nama Bus <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_bus') is-invalid @enderror" 
                               id="nama_bus" 
                               name="nama_bus" 
                               value="{{ old('nama_bus', $bu->nama_bus) }}"
                               placeholder="Contoh: Bus Pariwisata Deluxe"
                               required>
                        @error('nama_bus')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Kategori Bus -->
                    <div class="col-md-6 mb-4">
                        <label for="kategori_bus_id" class="form-label required">
                            Kategori Bus <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('kategori_bus_id') is-invalid @enderror" 
                                id="kategori_bus_id" 
                                name="kategori_bus_id"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategories as $kategori)
                            <option value="{{ $kategori->id }}" 
                                {{ old('kategori_bus_id', $bu->kategori_bus_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }} ({{ $kategori->jumlah_seat }} Seat)
                            </option>
                            @endforeach
                        </select>
                        @error('kategori_bus_id')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Sopir -->
                    <div class="col-md-6 mb-4">
                        <label for="sopir_id" class="form-label">
                            Sopir
                        </label>
                        <select class="form-control @error('sopir_id') is-invalid @enderror" 
                                id="sopir_id" 
                                name="sopir_id">
                            <option value="">-- Pilih Sopir (Opsional) --</option>
                            @forelse($sopirs as $sopir)
                            <option value="{{ $sopir->id }}" 
                                {{ old('sopir_id', $bu->sopir_id) == $sopir->id ? 'selected' : '' }}>
                                {{ $sopir->nama_sopir }} - {{ $sopir->no_hp }}
                            </option>
                            @empty
                            <option value="" disabled>Tidak ada sopir tersedia</option>
                            @endforelse
                        </select>
                        @error('sopir_id')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Menampilkan sopir tersedia + sopir saat ini
                            @if($bu->sopir_id)
                                <span class="text-info">(Sopir saat ini: {{ $bu->sopir->nama_sopir }})</span>
                            @endif
                        </small>
                    </div>

                    <!-- Warna Bus -->
                    <div class="col-md-6 mb-4">
                        <label for="warna_bus" class="form-label required">
                            Warna Bus <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('warna_bus') is-invalid @enderror" 
                               id="warna_bus" 
                               name="warna_bus" 
                               value="{{ old('warna_bus', $bu->warna_bus) }}"
                               placeholder="Contoh: Putih, Merah, Biru"
                               required>
                        @error('warna_bus')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Masukkan nama warna bus
                        </small>
                    </div>

                    <!-- Nomor Polisi -->
                    <div class="col-md-6 mb-4">
                        <label for="nomor_polisi" class="form-label required">
                            Nomor Polisi <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nomor_polisi') is-invalid @enderror" 
                               id="nomor_polisi" 
                               name="nomor_polisi" 
                               value="{{ old('nomor_polisi', $bu->nomor_polisi) }}"
                               placeholder="Contoh: B 1234 XYZ"
                               required>
                        @error('nomor_polisi')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Nomor polisi akan otomatis diubah ke huruf besar
                        </small>
                    </div>

                    <!-- Status -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label required">
                            Status <span class="text-danger">*</span>
                        </label>
                        <div class="status-radio-group">
                            <div class="status-radio-item">
                                <input class="form-check-input @error('status') is-invalid @enderror" 
                                       type="radio" 
                                       name="status" 
                                       id="status_aktif" 
                                       value="aktif"
                                       {{ old('status', $bu->status) == 'aktif' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_aktif">
                                    <span class="status-badge status-aktif">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                </label>
                            </div>
                            <div class="status-radio-item">
                                <input class="form-check-input @error('status') is-invalid @enderror" 
                                       type="radio" 
                                       name="status" 
                                       id="status_perawatan" 
                                       value="perawatan"
                                       {{ old('status', $bu->status) == 'perawatan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_perawatan">
                                    <span class="status-badge status-perawatan">
                                        <i class="fas fa-tools"></i> Perawatan
                                    </span>
                                </label>
                            </div>
                        </div>
                        @error('status')
                        <div class="invalid-feedback" style="display: block;">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Pilih status operasional bus
                        </small>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.operasional.bus.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto uppercase nomor polisi
    document.getElementById('nomor_polisi').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });

    // Auto capitalize warna bus
    document.getElementById('warna_bus').addEventListener('input', function(e) {
        const value = e.target.value;
        e.target.value = value.charAt(0).toUpperCase() + value.slice(1).toLowerCase();
    });

    // Form validation with SweetAlert2
    document.getElementById('editBusForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;
        let emptyFieldNames = [];
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                
                const label = document.querySelector(`label[for="${field.id}"]`);
                if (label) {
                    emptyFieldNames.push(label.textContent.replace('*', '').trim());
                }
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Form Tidak Lengkap',
                html: `Mohon lengkapi field berikut:<br><strong>${emptyFieldNames.join(', ')}</strong>`,
                confirmButtonText: 'OK'
            });
            
            return false;
        }
        
        // Konfirmasi sebelum submit
        Swal.fire({
            title: 'Konfirmasi Perubahan',
            html: `
                <div style="text-align: left; padding: 1rem;">
                    <p>Apakah Anda yakin ingin menyimpan perubahan data bus ini?</p>
                    <hr>
                    <p><strong>Kode Bus:</strong> ${document.getElementById('kode_bus').value}</p>
                    <p><strong>Nama Bus:</strong> ${document.getElementById('nama_bus').value}</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-save"></i> Ya, Update!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menyimpan Perubahan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit form
                e.target.submit();
            }
        });
    });
    
    // Session messages
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
    @endif
    
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session('error') }}',
        confirmButtonText: 'OK'
    });
    @endif
});
</script>
@endsection