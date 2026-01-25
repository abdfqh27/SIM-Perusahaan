@extends('admin.layouts.app')

@section('title', 'Detail Armada - ' . $armada->nama)

@section('content')
<style>
.btn-back {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    border: none;
    border-radius: 12px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all var(--transition-speed) ease;
    box-shadow: 0 3px 10px rgba(33, 158, 188, 0.3);
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(33, 158, 188, 0.5);
    color: white;
}

.detail-card {
    margin-bottom: 1.5rem;
}

/* Main Image */
.armada-main-image {
    border-radius: 15px;
    overflow: hidden;
    position: relative;
}

.armada-main-image img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform var(--transition-speed) ease;
}

.armada-main-image:hover img {
    transform: scale(1.02);
}

.no-image-large {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 5rem 2rem;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 15px;
}

.no-image-large i {
    font-size: 5rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}

.no-image-large p {
    color: #6c757d;
    font-size: 1.1rem;
    margin: 0;
}

/* Gallery Grid */
.armada-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.gallery-item-detail {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    transition: all var(--transition-speed) ease;
    cursor: pointer;
}

.gallery-item-detail:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.gallery-item-detail img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
    transition: transform var(--transition-speed) ease;
}

.gallery-item-detail:hover img {
    transform: scale(1.1);
}

/* Description */
.armada-description {
    color: #495057;
    line-height: 1.8;
    font-size: 1rem;
}

/* fasilitas Grid */
.fasilitas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.facility-badge {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    border-radius: 10px;
    transition: all var(--transition-speed) ease;
    font-weight: 500;
}

.facility-badge.available {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.05));
    border-left: 4px solid #28a745;
    color: #155724;
}

.facility-badge.unavailable {
    background: linear-gradient(135deg, rgba(108, 117, 125, 0.1), rgba(90, 98, 104, 0.05));
    border-left: 4px solid #6c757d;
    color: #495057;
    opacity: 0.7;
}

.facility-badge:hover {
    transform: translateX(5px);
}

.facility-badge i {
    font-size: 1.5rem;
}

.facility-badge.available i {
    color: #28a745;
}

.facility-badge.unavailable i {
    color: #6c757d;
}

/* Info List */
.info-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e9ecef;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6c757d;
    font-weight: 500;
    font-size: 0.9rem;
}

.info-label i {
    color: var(--orange-primary);
    width: 20px;
    text-align: center;
}

.info-value {
    text-align: right;
}

.info-value strong {
    color: var(--blue-dark);
    font-size: 1rem;
}

.info-value small {
    color: #6c757d;
}

/* Badge Variants */
.badge-type-detail {
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

.badge-warning {
    background: linear-gradient(135deg, #ffc107, #ff9800);
    color: #212529;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

.badge-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

/* Action Buttons */
.action-buttons-list {
    display: flex;
    flex-direction: column;
}

.action-buttons-list .btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

/* Image Modal */
.modal-content {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    background: transparent;
}

.modal-body {
    position: relative;
    background: transparent;
}

.btn-close-modal {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 40px;
    height: 40px;
    background: rgba(0, 0, 0, 0.7);
    border: none;
    border-radius: 50%;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    transition: all var(--transition-speed) ease;
}

.btn-close-modal:hover {
    background: rgba(220, 53, 69, 0.9);
    transform: scale(1.1);
}

#modalImage {
    border-radius: 15px;
}

/* Responsive */
@media (max-width: 768px) {
    .armada-gallery {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }

    .gallery-item-detail img {
        height: 150px;
    }

    .fasilitas-grid {
        grid-template-columns: 1fr;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .info-value {
        text-align: left;
        width: 100%;
    }

    .page-header .header-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-actions {
        width: 100%;
        margin-top: 1rem;
    }

    .header-actions .btn {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .armada-gallery {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }

    .gallery-item-detail img {
        height: 120px;
    }
}
</style>
<div class="armada-show">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <a href="{{ route('admin.armada.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="page-title">
                        <i class="fas fa-bus"></i>
                        {{ $armada->nama }}
                    </h1>
                    <p class="page-subtitle">Detail lengkap armada</p>
                </div>
            </div>
            <div class="header-right">
                <a href="{{ route('admin.armada.edit', $armada->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i>
                    Edit Armada
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Main Image Card -->
            <div class="card detail-card">
                <div class="card-body p-0">
                    @if($armada->gambar_utama)
                        <div class="armada-main-image">
                            <img src="{{ asset('storage/' . $armada->gambar_utama) }}" 
                                 alt="{{ $armada->nama }}"
                                 class="img-fluid">
                        </div>
                    @else
                        <div class="no-image-large">
                            <i class="fas fa-bus"></i>
                            <p>Tidak ada gambar</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Gallery Card -->
            @if($armada->galeri && count($armada->galeri) > 0)
                <div class="card detail-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-images"></i>
                            Galeri Gambar
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="armada-gallery">
                            @foreach($armada->galeri as $image)
                                <div class="gallery-item-detail">
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         alt="Gallery"
                                         class="img-fluid"
                                         data-bs-toggle="modal"
                                         data-bs-target="#imageModal"
                                         onclick="showImage('{{ asset('storage/' . $image) }}')">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Description Card -->
            <div class="card detail-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-align-left"></i>
                        Deskripsi
                    </h5>
                </div>
                <div class="card-body">
                    @if($armada->deskripsi)
                        <div class="armada-description">
                            {!! nl2br(e($armada->deskripsi)) !!}
                        </div>
                    @else
                        <p class="text-muted">Tidak ada deskripsi</p>
                    @endif
                </div>
            </div>

            <!-- fasilitas Card -->
            <div class="card detail-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-cogs"></i>
                        Fasilitas
                    </h5>
                </div>
                <div class="card-body">
                    @if($armada->fasilitas->count() > 0)
                        <div class="fasilitas-grid">
                            @foreach($armada->fasilitas as $facility)
                                <div class="facility-badge {{ $facility->tersedia ? 'available' : 'unavailable' }}">
                                    @if($facility->icon)
                                        <i class="{{ $facility->icon }}"></i>
                                    @else
                                        <i class="fas fa-check"></i>
                                    @endif
                                    <span>{{ $facility->nama_fasilitas }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada fasilitas yang ditambahkan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Info Card -->
            <div class="card detail-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Informasi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-tag"></i>
                                Tipe Bus
                            </div>
                            <div class="info-value">
                                <span class="badge badge-type-detail">{{ $armada->tipe_bus }}</span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-users"></i>
                                Kapasitas
                            </div>
                            <div class="info-value">
                                <strong>{{ $armada->kapasitas }} Orang</strong>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-sort-numeric-down"></i>
                                Urutan
                            </div>
                            <div class="info-value">
                                <span class="badge badge-secondary">{{ $armada->urutan }}</span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-star"></i>
                                Status Unggulan
                            </div>
                            <div class="info-value">
                                @if($armada->unggulan)
                                    <span class="badge badge-warning">
                                        <i class="fas fa-star"></i> Ya
                                    </span>
                                @else
                                    <span class="badge badge-secondary">Tidak</span>
                                @endif
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-eye"></i>
                                Ketersediaan
                            </div>
                            <div class="info-value">
                                @if($armada->tersedia)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> Tersedia
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i> Tidak Tersedia
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar"></i>
                                Dibuat
                            </div>
                            <div class="info-value">
                                <small>{{ $armada->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-clock"></i>
                                Update Terakhir
                            </div>
                            <div class="info-value">
                                <small>{{ $armada->updated_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card detail-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-tasks"></i>
                        Aksi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="action-buttons-list">
                        <a href="{{ route('armada.detail', $armada->slug) }}" 
                           class="btn btn-info w-100 mb-2"
                           target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                            Lihat di Website
                        </a>
                        <a href="{{ route('admin.armada.edit', $armada->id) }}" 
                           class="btn btn-warning w-100 mb-2">
                            <i class="fas fa-edit"></i>
                            Edit Armada
                        </a>
                        <form action="{{ route('admin.armada.destroy', $armada->id) }}" 
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus armada ini? Data yang dihapus tidak dapat dikembalikan!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i>
                                Hapus Armada
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
                <img src="" id="modalImage" class="img-fluid w-100" alt="Preview">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showImage(src) {
    document.getElementById('modalImage').src = src;
}
</script>
@endpush
@endsection