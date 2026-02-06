@extends('admin.layouts.app')

@section('title', 'Edit Kategori Bus')
@section('page-title', 'Edit Kategori Bus')

@push('styles')
<style>
    .form-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }
    
    .form-section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f8f9fa;
    }
    
    .form-section-title i {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .form-section-title h5 {
        margin: 0;
        color: var(--blue-dark);
        font-weight: 700;
    }
    
    .info-box {
        background: linear-gradient(135deg, rgba(33, 158, 188, 0.1), rgba(142, 202, 230, 0.1));
        border-left: 4px solid var(--blue-light);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .info-box i {
        color: var(--blue-light);
        margin-right: 0.5rem;
    }
    
    .info-box strong {
        color: var(--blue-dark);
    }
    
    .form-label {
        font-weight: 600;
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--orange-primary);
        box-shadow: 0 0 0 0.2rem rgba(251, 133, 0, 0.1);
    }
    
    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .is-invalid {
        border-color: #dc3545;
    }
    
    .form-text {
        color: #6c757d;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f8f9fa;
    }
    
    .btn-cancel {
        background: #6c757d;
        color: white;
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        color: white;
    }

    .warning-box {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 152, 0, 0.1));
        border-left: 4px solid #ffc107;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .warning-box i {
        color: #ff9800;
        margin-right: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div>
                <h4 class="page-title">Edit Kategori Bus</h4>
                <p class="page-subtitle">Perbarui informasi kategori bus</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.operasional.kategori-bus.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-section-title">
                    <i class="fas fa-list"></i>
                    <h5>Informasi Kategori Bus</h5>
                </div>

                @if($kategoriBu->buses_count > 0)
                <div class="warning-box">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian:</strong> Kategori ini digunakan oleh <strong>{{ $kategoriBu->buses_count }} bus</strong>. 
                    Perubahan akan mempengaruhi data bus tersebut.
                </div>
                @endif

                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    Mengubah data kategori: <strong>{{ $kategoriBu->nama_kategori }}</strong>
                </div>

                <form action="{{ route('admin.operasional.kategori-bus.update', $kategoriBu->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="nama_kategori" class="form-label">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_kategori') is-invalid @enderror" 
                               id="nama_kategori" 
                               name="nama_kategori" 
                               value="{{ old('nama_kategori', $kategoriBu->nama_kategori) }}"
                               placeholder="Contoh: Medium Bus, Big Bus, Executive, dll"
                               required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Masukkan nama kategori bus yang jelas dan deskriptif</small>
                    </div>

                    <div class="mb-4">
                        <label for="kapasitas" class="form-label">
                            Kapasitas Penumpang <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number" 
                                   class="form-control @error('kapasitas') is-invalid @enderror" 
                                   id="kapasitas" 
                                   name="kapasitas" 
                                   value="{{ old('kapasitas', $kategoriBu->kapasitas) }}"
                                   placeholder="Masukkan jumlah kapasitas"
                                   min="1"
                                   required>
                            <span class="input-group-text">Orang</span>
                            @error('kapasitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text">Kapasitas maksimal penumpang untuk kategori ini</small>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.operasional.kategori-bus.index') }}" class="btn-cancel">
                            <i class="fas fa-times"></i>
                            <span>Batal</span>
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <span>Update Kategori</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto focus on first input
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('nama_kategori').focus();
    });
</script>
@endpush