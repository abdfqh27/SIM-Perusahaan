@extends('admin.layouts.app')

@section('title', 'Detail Sopir')

@section('content')
<div class="admin-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <div>
                <h1 class="page-title">Detail Sopir</h1>
                <p class="page-subtitle">Informasi lengkap sopir {{ $sopir->nama_sopir }}</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.operasional.sopir.edit', $sopir) }}" class="btn-warning">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
            <a href="{{ route('admin.operasional.sopir.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body" style="text-align: center; padding: 2rem;">
                    <!-- Avatar -->
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    
                    <!-- Name -->
                    <h3 class="profile-name">{{ $sopir->nama_sopir }}</h3>
                    
                    <!-- Status Badge -->
                    <div style="margin-bottom: 1.5rem;">
                        @if($sopir->status === 'aktif')
                            <span class="badge-status-large badge-aktif">
                                <i class="fas fa-check-circle"></i> Status Aktif
                            </span>
                        @else
                            <span class="badge-status-large badge-nonaktif">
                                <i class="fas fa-times-circle"></i> Status Non-Aktif
                            </span>
                        @endif
                    </div>

                    <!-- Quick Info -->
                    <div class="quick-info">
                        <div class="quick-info-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <small>Terdaftar Sejak</small>
                                <strong>{{ $sopir->created_at->format('d M Y') }}</strong>
                            </div>
                        </div>
                        <div class="quick-info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <small>Terakhir Diupdate</small>
                                <strong>{{ $sopir->updated_at->format('d M Y') }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="profile-actions">
                        <a href="{{ route('admin.operasional.sopir.edit', $sopir) }}" class="btn-primary" style="width: 100%;">
                            <i class="fas fa-edit"></i> Edit Data
                        </a>
                        <form action="{{ route('admin.operasional.sopir.destroy', $sopir) }}" 
                              method="POST" 
                              style="margin-top: 0.75rem;"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus sopir ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="width: 100%;">
                                <i class="fas fa-trash"></i> Hapus Sopir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-alt"></i> Informasi Personal
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-user"></i> Nama Lengkap
                            </div>
                            <div class="detail-value">{{ $sopir->nama_sopir }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-id-card-alt"></i> NIK
                            </div>
                            <div class="detail-value">{{ $sopir->nik }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-phone"></i> No. HP
                            </div>
                            <div class="detail-value">
                                <a href="tel:{{ $sopir->no_hp }}" class="contact-link">
                                    {{ $sopir->no_hp }}
                                </a>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-certificate"></i> Jenis SIM
                            </div>
                            <div class="detail-value">
                                <span style="background: linear-gradient(135deg, #ffc107, #ff9800); color: white; padding: 0.4rem 0.8rem; border-radius: 8px; font-weight: 600; display: inline-block;">
                                    {{ $sopir->jenis_sim }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-id-card"></i> No. SIM
                            </div>
                            <div class="detail-value">{{ $sopir->no_sim }}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-toggle-on"></i> Status
                            </div>
                            <div class="detail-value">
                                @if($sopir->status === 'aktif')
                                    <span class="badge-status badge-aktif">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge-status badge-nonaktif">
                                        <i class="fas fa-times-circle"></i> Non-Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="detail-item detail-full">
                            <div class="detail-label">
                                <i class="fas fa-map-marker-alt"></i> Alamat
                            </div>
                            <div class="detail-value">{{ $sopir->alamat }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bus Assignment -->
            <div class="card" style="margin-top: 1.5rem;">
                <div class="card-header">
                    <i class="fas fa-bus"></i> Penugasan Bus
                </div>
                <div class="card-body">
                    @if($sopir->bus)
                        <div class="assignment-card">
                            <div class="assignment-header">
                                <div class="assignment-icon">
                                    <i class="fas fa-bus"></i>
                                </div>
                                <div class="assignment-info">
                                    <h4>{{ $sopir->bus->nama_bus }}</h4>
                                    <p>{{ $sopir->bus->plat_nomor }}</p>
                                </div>
                                <div class="assignment-badge">
                                    <span class="badge-assigned">
                                        <i class="fas fa-check"></i> Ditugaskan
                                    </span>
                                </div>
                            </div>
                            
                            <div class="assignment-details">
                                <div class="assignment-detail-item">
                                    <span class="label">Kategori Bus:</span>
                                    <span class="value">{{ $sopir->bus->kategoriBus->nama_kategori ?? '-' }}</span>
                                </div>
                                <div class="assignment-detail-item">
                                    <span class="label">Kapasitas:</span>
                                    <span class="value">{{ $sopir->bus->kapasitas }} penumpang</span>
                                </div>
                                <div class="assignment-detail-item">
                                    <span class="label">Status Bus:</span>
                                    <span class="value">
                                        @if($sopir->bus->status === 'tersedia')
                                            <span style="color: #28a745; font-weight: 600;">
                                                <i class="fas fa-circle" style="font-size: 0.6rem;"></i> Tersedia
                                            </span>
                                        @elseif($sopir->bus->status === 'digunakan')
                                            <span style="color: #ffc107; font-weight: 600;">
                                                <i class="fas fa-circle" style="font-size: 0.6rem;"></i> Digunakan
                                            </span>
                                        @else
                                            <span style="color: #dc3545; font-weight: 600;">
                                                <i class="fas fa-circle" style="font-size: 0.6rem;"></i> Maintenance
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="no-assignment">
                            <div class="no-assignment-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h4>Belum Ada Penugasan</h4>
                            <p>Sopir ini belum ditugaskan ke bus manapun</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="card" style="margin-top: 1.5rem;">
                <div class="card-header">
                    <i class="fas fa-history"></i> Riwayat Aktivitas
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker timeline-success"></div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <strong>Data Diperbarui</strong>
                                    <span class="timeline-date">{{ $sopir->updated_at->format('d M Y, H:i') }}</span>
                                </div>
                                <p>Data sopir terakhir diperbarui</p>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-marker timeline-primary"></div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <strong>Data Dibuat</strong>
                                    <span class="timeline-date">{{ $sopir->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <p>Sopir terdaftar dalam sistem</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Profile Card Styles */
.profile-avatar {
    width: 120px;
    height: 120px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px rgba(251, 133, 0, 0.3);
}

.profile-avatar i {
    font-size: 4rem;
    color: white;
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--blue-dark);
    margin: 0 0 1rem 0;
}

.badge-status-large {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.5rem;
    border-radius: 25px;
    font-size: 0.95rem;
    font-weight: 600;
}

.quick-info {
    margin: 2rem 0;
    padding: 1.5rem 0;
    border-top: 2px solid #e9ecef;
    border-bottom: 2px solid #e9ecef;
}

.quick-info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 0;
    text-align: left;
}

.quick-info-item i {
    font-size: 1.8rem;
    color: var(--orange-primary);
    width: 40px;
    text-align: center;
}

.quick-info-item small {
    display: block;
    color: #6c757d;
    font-size: 0.8rem;
    margin-bottom: 0.25rem;
}

.quick-info-item strong {
    display: block;
    color: var(--blue-dark);
    font-size: 0.95rem;
}

.profile-actions {
    margin-top: 1.5rem;
}

/* Detail Grid */
.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.detail-full {
    grid-column: 1 / -1;
}

.detail-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-label i {
    color: var(--orange-primary);
    font-size: 1rem;
}

.detail-value {
    font-size: 1rem;
    color: var(--blue-dark);
    font-weight: 500;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 3px solid var(--orange-primary);
}

.contact-link {
    color: var(--blue-light);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.contact-link:hover {
    color: var(--orange-primary);
}

/* Badge Status */
.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
}

.badge-aktif {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.badge-nonaktif {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

/* Assignment Card */
.assignment-card {
    background: linear-gradient(135deg, rgba(33, 158, 188, 0.05), rgba(142, 202, 230, 0.05));
    border-radius: 12px;
    padding: 1.5rem;
    border: 2px solid rgba(33, 158, 188, 0.1);
}

.assignment-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid rgba(33, 158, 188, 0.1);
}

.assignment-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--blue-light), var(--blue-lighter));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.assignment-icon i {
    font-size: 1.8rem;
    color: white;
}

.assignment-info {
    flex: 1;
}

.assignment-info h4 {
    margin: 0 0 0.25rem 0;
    color: var(--blue-dark);
    font-weight: 700;
    font-size: 1.25rem;
}

.assignment-info p {
    margin: 0;
    color: #6c757d;
    font-weight: 500;
}

.badge-assigned {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.assignment-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.assignment-detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.assignment-detail-item .label {
    font-size: 0.8rem;
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.assignment-detail-item .value {
    font-size: 0.95rem;
    color: var(--blue-dark);
    font-weight: 600;
}

/* No Assignment */
.no-assignment {
    text-align: center;
    padding: 3rem 2rem;
}

.no-assignment-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, #6c757d, #5a6268);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.no-assignment-icon i {
    font-size: 2.5rem;
    color: white;
}

.no-assignment h4 {
    color: var(--blue-dark);
    margin: 0 0 0.5rem 0;
    font-weight: 700;
}

.no-assignment p {
    color: #6c757d;
    margin: 0;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0.5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, var(--orange-primary), var(--orange-secondary));
}

.timeline-item {
    position: relative;
    padding-bottom: 2rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -1.5rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 2px var(--orange-primary);
}

.timeline-success {
    background: #28a745;
}

.timeline-primary {
    background: var(--orange-primary);
}

.timeline-content {
    background: #f8f9fa;
    padding: 1rem 1.25rem;
    border-radius: 10px;
    border-left: 3px solid var(--orange-primary);
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.timeline-header strong {
    color: var(--blue-dark);
    font-size: 0.95rem;
}

.timeline-date {
    color: #6c757d;
    font-size: 0.8rem;
}

.timeline-content p {
    margin: 0;
    color: #6c757d;
    font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 991px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .assignment-header {
        flex-wrap: wrap;
    }
    
    .assignment-badge {
        width: 100%;
    }
    
    .badge-assigned {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection