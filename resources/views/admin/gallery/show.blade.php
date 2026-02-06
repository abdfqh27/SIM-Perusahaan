@extends('admin.layouts.app')

@section('title', 'Detail Gallery')

@section('content')
<style>
    /* Gallery Image Container */
    .gallery-image-container {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 10px;
    }

    .gallery-detail-image {
        max-width: 100%;
        max-height: 600px;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .gallery-detail-image:hover {
        transform: scale(1.02);
    }

    /* Detail Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .detail-item {
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid var(--orange-primary);
        transition: all 0.3s ease;
    }

    .detail-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .detail-item.full-width {
        grid-column: 1 / -1;
    }

    .detail-label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 1.1rem;
        color: var(--blue-dark);
        font-weight: 600;
        line-height: 1.6;
    }

    /* Badge Urutan */
    .badge-urutan {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
        color: white;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.25rem;
        box-shadow: 0 4px 15px rgba(33, 158, 188, 0.3);
    }

    /* Badge Kategori */
    .badge-kategori {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.25rem;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 600;
    }

    .badge-perjalanan {
        background: rgba(33, 158, 188, 0.15);
        color: var(--blue-light);
    }

    .badge-armada {
        background: rgba(251, 133, 0, 0.15);
        color: var(--orange-primary);
    }

    .badge-kegiatan {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    /* Badge Status */
    .badge-status {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.25rem;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 600;
    }

    .badge-status-active {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .badge-status-inactive {
        background: rgba(108, 117, 125, 0.15);
        color: #6c757d;
    }

    /* File Info List */
    .file-info-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .file-info-item {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid var(--blue-light);
    }

    .file-info-label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .file-info-value {
        font-size: 1rem;
        color: var(--blue-dark);
        font-weight: 700;
    }

    /* Timeline */
    .timeline-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .timeline-item {
        display: flex;
        gap: 1rem;
    }

    .timeline-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .timeline-icon i {
        font-size: 1.2rem;
        color: white;
    }

    .timeline-icon-success {
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    .timeline-icon-info {
        background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-label {
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .timeline-value {
        font-size: 1rem;
        color: var(--blue-dark);
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .timeline-relative {
        font-size: 0.85rem;
        color: #6c757d;
        font-style: italic;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .gallery-detail-image {
            max-height: 400px;
        }

        .gallery-image-container {
            padding: 1rem;
        }
    }
</style>
<!-- Gradient Header -->
<div class="gradient-header">
    <div class="header-left">
        <a href="{{ route('admin.gallery.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="header-icon">
            <i class="fas fa-image"></i>
        </div>
        <div>
            <h1 class="header-title">Detail Gallery</h1>
            <p class="header-subtitle">{{ $gallery->judul }}</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn-header-action btn-edit">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </a>
        <form action="{{ route('admin.gallery.destroy', $gallery) }}" 
              method="POST" 
              class="delete-form d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-header-action btn-delete">
                <i class="fas fa-trash"></i>
                <span>Hapus</span>
            </button>
        </form>
    </div>
</div>

<!-- Gallery Image -->
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-image me-2"></i>
        Gambar Gallery
    </div>
    <div class="card-body">
        <div class="gallery-image-container">
            <img src="{{ asset('storage/' . $gallery->gambar) }}" 
                 alt="{{ $gallery->judul }}"
                 class="gallery-detail-image">
        </div>
    </div>
</div>

<!-- Gallery Information -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i>
                Informasi Gallery
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-heading me-2"></i>
                            Judul
                        </div>
                        <div class="detail-value">{{ $gallery->judul }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-tag me-2"></i>
                            Kategori
                        </div>
                        <div class="detail-value">
                            @if($gallery->kategori)
                            <span class="badge-kategori badge-{{ $gallery->kategori }}">
                                {{ $gallery->kategori_label }}
                            </span>
                            @else
                            <span class="text-muted">Tidak ada kategori</span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-item full-width">
                        <div class="detail-label">
                            <i class="fas fa-align-left me-2"></i>
                            Deskripsi
                        </div>
                        <div class="detail-value">
                            @if($gallery->deskripsi)
                            {{ $gallery->deskripsi }}
                            @else
                            <span class="text-muted">Tidak ada deskripsi</span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-sort-numeric-up me-2"></i>
                            Urutan
                        </div>
                        <div class="detail-value">
                            <span class="badge-urutan">{{ $gallery->urutan }}</span>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-eye me-2"></i>
                            Status Tampilan
                        </div>
                        <div class="detail-value">
                            @if($gallery->tampilkan)
                            <span class="badge-status badge-status-active">
                                <i class="fas fa-check-circle me-1"></i>
                                Ditampilkan
                            </span>
                            @else
                            <span class="badge-status badge-status-inactive">
                                <i class="fas fa-times-circle me-1"></i>
                                Disembunyikan
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- File Information -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-file-image me-2"></i>
                Informasi File
            </div>
            <div class="card-body">
                <div class="file-info-list">
                    <div class="file-info-item">
                        <div class="file-info-label">
                            <i class="fas fa-hdd me-2"></i>
                            Ukuran File
                        </div>
                        <div class="file-info-value">
                            {{ \App\Helpers\ImageHelper::humanFileSize($gallery->gambar) }}
                        </div>
                    </div>

                    <div class="file-info-item">
                        <div class="file-info-label">
                            <i class="fas fa-expand-arrows-alt me-2"></i>
                            Dimensi
                        </div>
                        <div class="file-info-value">
                            @php
                            $dimensions = \App\Helpers\ImageHelper::getDimensions($gallery->gambar);
                            @endphp
                            {{ $dimensions['width'] }} x {{ $dimensions['height'] }} px
                        </div>
                    </div>

                    <div class="file-info-item">
                        <div class="file-info-label">
                            <i class="fas fa-file-code me-2"></i>
                            Format
                        </div>
                        <div class="file-info-value">
                            WebP (HD Quality)
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timestamp Information -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clock me-2"></i>
                Timeline
            </div>
            <div class="card-body">
                <div class="timeline-list">
                    <div class="timeline-item">
                        <div class="timeline-icon timeline-icon-success">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-label">Dibuat</div>
                            <div class="timeline-value">
                                {{ \App\Helpers\DateHelper::formatDateTimeIndonesia($gallery->created_at) }}
                            </div>
                            <div class="timeline-relative">
                                {{ \App\Helpers\DateHelper::diffForHumans($gallery->created_at) }}
                            </div>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-icon timeline-icon-info">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-label">Terakhir Diupdate</div>
                            <div class="timeline-value">
                                {{ \App\Helpers\DateHelper::formatDateTimeIndonesia($gallery->updated_at) }}
                            </div>
                            <div class="timeline-relative">
                                {{ \App\Helpers\DateHelper::diffForHumans($gallery->updated_at) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete Confirmation
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    html: `Gallery <strong>{{ $gallery->judul }}</strong> akan dihapus permanen beserta gambarnya!`,
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
    });
</script>
@endpush