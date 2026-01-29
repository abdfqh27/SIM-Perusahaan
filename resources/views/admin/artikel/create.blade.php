@extends('admin.layouts.app')

@section('title', 'Tambah Artikel')

@section('content')
<style>
    .page-header-custom {
        margin-bottom: 2rem;
    }
    
    .page-header-custom h2 {
        color: var(--blue-dark);
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .page-header-custom p {
        color: #6c757d;
        margin-bottom: 0;
    }
    
    .form-label-custom {
        color: var(--blue-dark);
        font-weight: 600;
    }
    
    .form-control-custom {
        border-radius: 8px;
        padding: 0.75rem;
    }
    
    .card-custom {
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: none;
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 1rem 1.5rem;
    }
    
    .card-header-custom h5 {
        margin: 0;
        font-weight: 600;
    }
    
    .switch-custom {
        padding-left: 2.5rem;
    }
    
    .switch-custom .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
    }
    
    .switch-custom .form-check-label {
        margin-left: 0.5rem;
        cursor: pointer;
    }
    
    .image-preview-box {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .alert-info-custom {
        background: linear-gradient(135deg, #d1ecf1, #bee5eb);
        border: none;
        border-radius: 8px;
        border-left: 4px solid #17a2b8;
    }
    
    .btn-lg-custom {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 8px;
    }
</style>

<div class="container-fluid">
    <!-- Header Section -->
    <div class="gradient-header">
        <div class="header-left">
            <a href="{{ route('admin.artikel.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div>
                <h2 class="header-title">Tambah artikel</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.artikel.index') }}">Artikel</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card card-custom mb-4">
                    <div class="card-header card-header-custom">
                        <h5><i class="fas fa-edit me-2"></i>Informasi Artikel</h5>
                    </div>
                    <div class="card-body">
                        <!-- Judul -->
                        <div class="mb-4">
                            <label for="judul" class="form-label form-label-custom">
                                Judul Artikel <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-custom @error('judul') is-invalid @enderror" 
                                   id="judul" 
                                   name="judul" 
                                   value="{{ old('judul') }}"
                                   placeholder="Masukkan judul artikel..."
                                   required>
                            @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Judul akan otomatis dikonversi menjadi slug URL</small>
                        </div>

                        <!-- Excerpt -->
                        <div class="mb-4">
                            <label for="excerpt" class="form-label form-label-custom">
                                Excerpt (Ringkasan)
                            </label>
                            <textarea class="form-control form-control-custom @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" 
                                      name="excerpt" 
                                      rows="3"
                                      placeholder="Ringkasan singkat artikel (opsional)...">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Ringkasan yang akan muncul di preview artikel</small>
                        </div>

                        <!-- Konten -->
                        <div class="mb-4">
                            <label for="konten" class="form-label form-label-custom">
                                Konten Artikel <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control form-control-custom @error('konten') is-invalid @enderror" 
                                      id="konten" 
                                      name="konten" 
                                      rows="15"
                                      placeholder="Tulis konten artikel di sini..."
                                      required>{{ old('konten') }}</textarea>
                            @error('konten')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Publish Settings -->
                <div class="card card-custom mb-4">
                    <div class="card-header card-header-custom">
                        <h5><i class="fas fa-cog me-2"></i>Pengaturan Publikasi</h5>
                    </div>
                    <div class="card-body">
                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label form-label-custom">Status</label>
                            <div class="form-check form-switch switch-custom">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="dipublikasi" 
                                       name="dipublikasi"
                                       value="1"
                                       {{ old('dipublikasi') ? 'checked' : '' }}>
                                <label class="form-check-label" for="dipublikasi">
                                    <span id="statusText">{{ old('dipublikasi') ? 'Publikasikan' : 'Simpan sebagai Draft' }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Tanggal Publikasi -->
                        <div class="mb-3">
                            <label for="tanggal_publikasi" class="form-label form-label-custom">
                                Tanggal Publikasi
                            </label>
                            <input type="date" 
                                   class="form-control form-control-custom @error('tanggal_publikasi') is-invalid @enderror" 
                                   id="tanggal_publikasi" 
                                   name="tanggal_publikasi"
                                   value="{{ old('tanggal_publikasi') }}">
                            @error('tanggal_publikasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kosongkan untuk menggunakan tanggal hari ini</small>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="card card-custom mb-4">
                    <div class="card-header card-header-custom">
                        <h5><i class="fas fa-image me-2"></i>Gambar Featured</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" 
                                   class="form-control form-control-custom @error('gambar_featured') is-invalid @enderror" 
                                   id="gambar_featured" 
                                   name="gambar_featured"
                                   accept="image/jpeg,image/jpg,image/png">
                            @error('gambar_featured')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, JPEG, PNG (Max: 10MB)</small>
                        </div>
                        
                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <img id="previewImg" 
                                 src="" 
                                 alt="Preview" 
                                 class="image-preview-box">
                        </div>
                    </div>
                </div>

                <!-- Category & Tags -->
                <div class="card card-custom mb-4">
                    <div class="card-header card-header-custom">
                        <h5><i class="fas fa-tags me-2"></i>Kategori & Tag</h5>
                    </div>
                    <div class="card-body">
                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="kategori" class="form-label form-label-custom">
                                Kategori
                            </label>
                            <input type="text" 
                                   class="form-control form-control-custom @error('kategori') is-invalid @enderror" 
                                   id="kategori" 
                                   name="kategori"
                                   value="{{ old('kategori') }}"
                                   placeholder="Teknologi, Berita, dll...">
                            @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div class="mb-3">
                            <label for="tags" class="form-label form-label-custom">
                                Tags
                            </label>
                            <input type="text" 
                                   class="form-control form-control-custom @error('tags') is-invalid @enderror" 
                                   id="tags" 
                                   name="tags"
                                   value="{{ old('tags') }}"
                                   placeholder="tag1, tag2, tag3...">
                            @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pisahkan dengan koma (,)</small>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg btn-lg-custom d-flex align-items-center justify-content-center">
                        <i class="fas fa-save me-2"></i>Simpan Artikel
                    </button>
                    <a href="{{ route('admin.artikel.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Toggle status text
document.getElementById('dipublikasi').addEventListener('change', function() {
    const statusText = document.getElementById('statusText');
    statusText.textContent = this.checked ? 'Publikasikan' : 'Simpan sebagai Draft';
});

// Image preview
document.getElementById('gambar_featured').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection