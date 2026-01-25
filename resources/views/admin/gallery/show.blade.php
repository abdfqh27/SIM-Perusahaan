@extends('admin.layouts.app')

@section('title', 'Detail Galeri')

@section('content')
<style>
    .detail-container {
    max-width: 1400px;
    margin: 0 auto;
    }

    .detail-header {
        background: white;
        border-radius: 15px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

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
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(33, 158, 188, 0.3);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(33, 158, 188, 0.5);
        color: white;
    }

    .header-right {
        display: flex;
        gap: 1rem;
    }

    .btn-edit {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border: none;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(251, 133, 0, 0.3);
        transition: all 0.3s ease;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 133, 0, 0.5);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.5);
    }

    /* Detail Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    /* Image Section */
    .detail-image-section {
        position: sticky;
        top: calc(var(--navbar-height) + 2rem);
        height: fit-content;
    }

    .image-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .image-wrapper {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .image-wrapper img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 12px;
        max-height: 600px;
        object-fit: contain;
    }

    .btn-fullscreen {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 40px;
        height: 40px;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        opacity: 0;
    }

    .image-wrapper:hover .btn-fullscreen {
        opacity: 1;
    }

    .btn-fullscreen:hover {
        background: rgba(0, 0, 0, 0.8);
        transform: scale(1.1);
    }

    .category-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        box-shadow: 0 3px 10px rgba(251, 133, 0, 0.3);
    }

    .status-badge {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    }

    .active-badge {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .inactive-badge {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }

    /* Info Section */
    .detail-info-section {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .info-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .info-card .card-header {
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
        color: white;
        padding: 1rem 1.5rem;
    }

    .info-card .card-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-card .card-body {
        padding: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-item:first-child {
        padding-top: 0;
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .info-label i {
        width: 20px;
        text-align: center;
    }

    .info-value {
        color: var(--blue-dark);
        font-weight: 500;
        padding-left: 1.75rem;
        line-height: 1.6;
    }

    .text-break {
        word-break: break-all;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge-category {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
    }

    .badge-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .badge-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    /* Fullscreen Modal */
    .fullscreen-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.95);
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .fullscreen-content {
        max-width: 90%;
        max-height: 90vh;
        object-fit: contain;
        animation: zoomIn 0.3s ease;
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.8);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .fullscreen-close {
        position: absolute;
        top: 2rem;
        right: 3rem;
        color: white;
        font-size: 3rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10000;
    }

    .fullscreen-close:hover {
        color: var(--orange-primary);
        transform: rotate(90deg);
    }

    .fullscreen-caption {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        font-size: 1.2rem;
        font-weight: 600;
        text-align: center;
        background: rgba(0, 0, 0, 0.7);
        padding: 1rem 2rem;
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    /* Delete Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 9998;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px);
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        max-width: 500px;
        width: 90%;
        overflow: hidden;
        animation: slideUp 0.3s ease;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        padding: 1.5rem 2rem;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-body p {
        margin: 0 0 1rem 0;
        color: var(--blue-dark);
        line-height: 1.6;
    }

    .warning-text {
        color: #dc3545;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        background: #f8f9fa;
    }

    .btn-cancel {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 3px 10px rgba(108, 117, 125, 0.3);
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.5);
    }

    .btn-delete-confirm {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        transition: all 0.3s ease;
    }

    .btn-delete-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.5);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
        
        .detail-image-section {
            position: relative;
            top: 0;
        }
    }

    @media (max-width: 768px) {
        .detail-header {
            padding: 1rem;
            flex-direction: column;
            align-items: flex-start;
        }
        
        .header-right {
            width: 100%;
        }
        
        .btn-edit,
        .btn-delete {
            flex: 1;
            justify-content: center;
        }
        
        .fullscreen-close {
            top: 1rem;
            right: 1rem;
            font-size: 2.5rem;
        }
        
        .fullscreen-caption {
            bottom: 1rem;
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
        }
        
        .modal-content {
            width: 95%;
        }
        
        .modal-header {
            padding: 1rem 1.5rem;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            padding: 1rem 1.5rem;
            flex-direction: column-reverse;
        }
        
        .btn-cancel,
        .btn-delete-confirm {
            width: 100%;
            justify-content: center;
        }
    }
</style>
<div class="detail-container">
    <!-- Header -->
    <div class="detail-header">
        <div class="header-left">
            <a href="{{ route('admin.gallery.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="page-title">
                    <i class="fas fa-image"></i>
                    Detail Galeri
                </h2>
                <p class="page-subtitle">Informasi lengkap galeri</p>
            </div>
        </div>
        <div class="header-right">
            <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="btn btn-edit">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
            <button type="button" class="btn btn-delete" onclick="confirmDelete()">
                <i class="fas fa-trash"></i>
                <span>Hapus</span>
            </button>
        </div>
    </div>

    <!-- Content -->
    <div class="detail-grid">
        <!-- Image Section -->
        <div class="detail-image-section">
            <div class="image-card">
                <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $gallery->gambar) }}" alt="{{ $gallery->judul }}" id="mainImage">
                    <button class="btn-fullscreen" onclick="openFullscreen()">
                        <i class="fas fa-expand"></i>
                    </button>
                    @if($gallery->kategori)
                    <span class="category-badge">{{ $gallery->kategori }}</span>
                    @endif
                    <span class="status-badge {{ $gallery->tampilkan ? 'active-badge' : 'inactive-badge' }}">
                        <i class="fas fa-{{ $gallery->tampilkan ? 'eye' : 'eye-slash' }}"></i>
                        {{ $gallery->tampilkan ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="detail-info-section">
            <!-- Basic Info Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-info-circle"></i>
                        Informasi Galeri
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-heading"></i>
                            Judul
                        </div>
                        <div class="info-value">{{ $gallery->judul }}</div>
                    </div>

                    @if($gallery->deskripsi)
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-align-left"></i>
                            Deskripsi
                        </div>
                        <div class="info-value">{{ $gallery->deskripsi }}</div>
                    </div>
                    @endif

                    @if($gallery->kategori)
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-tag"></i>
                            Kategori
                        </div>
                        <div class="info-value">
                            <span class="badge badge-category">{{ $gallery->kategori }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-sort-numeric-down"></i>
                            Urutan
                        </div>
                        <div class="info-value">{{ $gallery->urutan }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-eye"></i>
                            Status
                        </div>
                        <div class="info-value">
                            <span class="badge {{ $gallery->tampilkan ? 'badge-success' : 'badge-danger' }}">
                                <i class="fas fa-{{ $gallery->tampilkan ? 'check-circle' : 'times-circle' }}"></i>
                                {{ $gallery->tampilkan ? 'Aktif Ditampilkan' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

             <div class="info-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-clock"></i>
                        Informasi Waktu
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-calendar-plus"></i>
                            Dibuat
                        </div>
                        <div class="info-value">
                            {{ $gallery->created_at->format('d F Y, H:i') }} WIB
                        </div>
                    </div>

                    @if($gallery->updated_at && $gallery->updated_at != $gallery->created_at)
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-calendar-edit"></i>
                            Terakhir Diupdate
                        </div>
                        <div class="info-value">
                            {{ $gallery->updated_at->format('d F Y, H:i') }} WIB
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-file-image"></i>
                        Informasi File
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-link"></i>
                            Path File
                        </div>
                        <div class="info-value text-break">{{ $gallery->gambar }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-hdd"></i>
                            Ukuran File
                        </div>
                        <div class="info-value">
                            @php
                                $filePath = storage_path('app/public/' . $gallery->gambar);
                                $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                                $fileSizeKB = round($fileSize / 1024, 2);
                                $fileSizeMB = round($fileSize / (1024 * 1024), 2);
                            @endphp
                            @if($fileSizeMB >= 1)
                                {{ $fileSizeMB }} MB
                            @else
                                {{ $fileSizeKB }} KB
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Modal -->
<div id="fullscreenModal" class="fullscreen-modal">
    <span class="fullscreen-close" onclick="closeFullscreen()">&times;</span>
    <img class="fullscreen-content" id="fullscreenImg">
    <div class="fullscreen-caption" id="fullscreenCaption"></div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>
                <i class="fas fa-exclamation-triangle"></i>
                Konfirmasi Hapus
            </h3>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus galeri <strong>"{{ $gallery->judul }}"</strong>?</p>
            <p class="warning-text">Data yang dihapus tidak dapat dikembalikan!</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-cancel" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </button>
            <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete-confirm">
                    <i class="fas fa-trash"></i>
                    <span>Ya, Hapus</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Fullscreen Image
    function openFullscreen() {
        const modal = document.getElementById('fullscreenModal');
        const img = document.getElementById('mainImage');
        const modalImg = document.getElementById('fullscreenImg');
        const caption = document.getElementById('fullscreenCaption');
        
        modal.style.display = 'flex';
        modalImg.src = img.src;
        caption.innerHTML = '{{ $gallery->judul }}';
        document.body.style.overflow = 'hidden';
    }

    function closeFullscreen() {
        document.getElementById('fullscreenModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Delete Modal
    function confirmDelete() {
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        const fullscreenModal = document.getElementById('fullscreenModal');
        const deleteModal = document.getElementById('deleteModal');
        
        if (event.target === fullscreenModal) {
            closeFullscreen();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    }

    // Close fullscreen on ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeFullscreen();
            closeDeleteModal();
        }
    });
</script>

@endsection