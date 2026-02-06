@extends('admin.layouts.app')

@section('title', 'Edit Booking')

@section('content')
<style>
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--orange-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .section-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .bus-selection-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
        max-height: 500px;
        overflow-y: auto;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
    }
    .bus-card {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }
    .bus-card:hover {
        border-color: var(--orange-primary);
        box-shadow: 0 5px 15px rgba(251, 133, 0, 0.2);
        transform: translateY(-3px);
    }
    .bus-card.selected {
        border-color: var(--orange-primary);
        background: linear-gradient(135deg, rgba(251, 133, 0, 0.1), rgba(255, 183, 3, 0.05));
        box-shadow: 0 5px 15px rgba(251, 133, 0, 0.3);
    }
    .bus-card-checkbox {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 24px;
        height: 24px;
        accent-color: var(--orange-primary);
    }
    .bus-info h6 {
        color: var(--blue-dark);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .bus-detail {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.3rem;
    }
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .loading-overlay.active {
        display: flex;
    }
    .spinner {
        border: 4px solid rgba(255,255,255,0.3);
        border-top: 4px solid var(--orange-primary);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .alert-info-custom {
        background: linear-gradient(135deg, #d1ecf1, #bee5eb);
        border-left: 4px solid #17a2b8;
        color: #0c5460;
        border-radius: 10px;
        padding: 1rem 1.5rem;
    }
    .required-mark {
        color: #dc3545;
        margin-left: 3px;
    }
    .booking-code-display {
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 1.5rem;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="header-left">
        <div class="header-icon">
            <i class="fas fa-edit"></i>
        </div>
        <div>
            <h4 class="page-title mb-0">Edit Booking</h4>
            <p class="page-subtitle">Ubah data booking - {{ $booking->kode_booking }}</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.operasional.booking.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>

<!-- Alert Messages -->
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan:</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Booking Code Display -->
<div class="booking-code-display">
    <i class="fas fa-ticket-alt me-2"></i>
    Kode Booking: {{ $booking->kode_booking }}
</div>

<form action="{{ route('admin.operasional.booking.update', $booking->id) }}" method="POST" id="bookingForm">
    @csrf
    @method('PUT')
    
    <!-- Section: Data Pemesan -->
    <div class="form-section">
        <h5 class="section-title">
            <span class="section-icon">
                <i class="fas fa-user"></i>
            </span>
            Data Pemesan
        </h5>
        
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Nama Pemesan <span class="required-mark">*</span>
                </label>
                <input type="text" name="nama_pemesan" class="form-control @error('nama_pemesan') is-invalid @enderror" 
                       value="{{ old('nama_pemesan', $booking->nama_pemesan) }}" required>
                @error('nama_pemesan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    No. HP <span class="required-mark">*</span>
                </label>
                <input type="text" name="no_hp_pemesan" class="form-control @error('no_hp_pemesan') is-invalid @enderror" 
                       value="{{ old('no_hp_pemesan', $booking->no_hp_pemesan) }}" required>
                @error('no_hp_pemesan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-12">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email_pemesan" class="form-control @error('email_pemesan') is-invalid @enderror" 
                       value="{{ old('email_pemesan', $booking->email_pemesan) }}">
                @error('email_pemesan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    
    <!-- Section: Detail Perjalanan -->
    <div class="form-section">
        <h5 class="section-title">
            <span class="section-icon">
                <i class="fas fa-route"></i>
            </span>
            Detail Perjalanan
        </h5>
        
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Tujuan <span class="required-mark">*</span>
                </label>
                <input type="text" name="tujuan" class="form-control @error('tujuan') is-invalid @enderror" 
                       value="{{ old('tujuan', $booking->tujuan) }}" required>
                @error('tujuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Tempat Jemput <span class="required-mark">*</span>
                </label>
                <input type="text" name="tempat_jemput" class="form-control @error('tempat_jemput') is-invalid @enderror" 
                       value="{{ old('tempat_jemput', $booking->tempat_jemput) }}" required>
                @error('tempat_jemput')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    Tanggal Berangkat <span class="required-mark">*</span>
                </label>
                <input type="date" name="tanggal_berangkat" id="tanggalBerangkat" 
                       class="form-control @error('tanggal_berangkat') is-invalid @enderror" 
                       value="{{ old('tanggal_berangkat', $booking->tanggal_berangkat->format('Y-m-d')) }}" 
                       min="{{ date('Y-m-d') }}" required>
                @error('tanggal_berangkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    Tanggal Selesai <span class="required-mark">*</span>
                </label>
                <input type="date" name="tanggal_selesai" id="tanggalSelesai" 
                       class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                       value="{{ old('tanggal_selesai', $booking->tanggal_selesai->format('Y-m-d')) }}" 
                       min="{{ date('Y-m-d') }}" required>
                @error('tanggal_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    Jam Berangkat <span class="required-mark">*</span>
                </label>
                <input type="time" name="jam_berangkat" class="form-control @error('jam_berangkat') is-invalid @enderror" 
                       value="{{ old('jam_berangkat', $booking->jam_berangkat) }}" required>
                @error('jam_berangkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <div id="durasiInfo" class="alert-info-custom">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Durasi Perjalanan: <span id="durasiText">{{ $booking->durasi_hari }} hari</span></strong>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Section: Pilih Bus -->
    <div class="form-section">
        <h5 class="section-title">
            <span class="section-icon">
                <i class="fas fa-bus"></i>
            </span>
            Pilih Bus
        </h5>
        
        <div class="alert alert-info-custom mb-3">
            <i class="fas fa-info-circle me-2"></i>
            Bus yang saat ini dipilih akan tetap tersedia. Ubah tanggal untuk melihat bus lain yang tersedia.
        </div>
        
        <div id="busContainer">
            <div class="bus-selection-grid">
                @foreach($buses as $bus)
                <div class="bus-card {{ in_array($bus->id, $selectedBusIds) ? 'selected' : '' }}" onclick="toggleBus(this, {{ $bus->id }})">
                    <input type="checkbox" name="bus_ids[]" value="{{ $bus->id }}" 
                           class="bus-card-checkbox" 
                           {{ in_array($bus->id, $selectedBusIds) ? 'checked' : '' }}
                           onclick="event.stopPropagation()">
                    <div class="bus-info">
                        <h6><i class="fas fa-bus me-2"></i>{{ $bus->nama_bus }}</h6>
                        <div class="bus-detail">
                            <i class="fas fa-tag"></i> {{ $bus->kode_bus }}
                        </div>
                        <div class="bus-detail">
                            <i class="fas fa-list"></i> {{ $bus->kategoriBus->nama_kategori ?? '-' }}
                        </div>
                        <div class="bus-detail">
                            <i class="fas fa-id-card"></i> {{ $bus->nomor_polisi }}
                        </div>
                        <div class="bus-detail">
                            <i class="fas fa-user-tie"></i> {{ $bus->sopir->nama ?? '-' }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        @error('bus_ids')
            <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- Section: Pembayaran -->
    <div class="form-section">
        <h5 class="section-title">
            <span class="section-icon">
                <i class="fas fa-money-bill-wave"></i>
            </span>
            Informasi Pembayaran
        </h5>
        
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Total Pembayaran <span class="required-mark">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="total_pembayaran" id="totalPembayaran" 
                           class="form-control @error('total_pembayaran') is-invalid @enderror" 
                           value="{{ old('total_pembayaran', $booking->total_pembayaran) }}" min="0" required>
                </div>
                @error('total_pembayaran')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Metode Pembayaran <span class="required-mark">*</span>
                </label>
                <select name="metode_pembayaran" class="form-select @error('metode_pembayaran') is-invalid @enderror" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="cash" {{ old('metode_pembayaran', $booking->metode_pembayaran) == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="transfer" {{ old('metode_pembayaran', $booking->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                </select>
                @error('metode_pembayaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Status Pembayaran <span class="required-mark">*</span>
                </label>
                <select name="status_pembayaran" id="statusPembayaran" 
                        class="form-select @error('status_pembayaran') is-invalid @enderror" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="belum_bayar" {{ old('status_pembayaran', $booking->status_pembayaran) == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="dp" {{ old('status_pembayaran', $booking->status_pembayaran) == 'dp' ? 'selected' : '' }}>DP</option>
                    <option value="lunas" {{ old('status_pembayaran', $booking->status_pembayaran) == 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
                @error('status_pembayaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6" id="nominalDpWrapper" style="display: {{ old('status_pembayaran', $booking->status_pembayaran) == 'dp' ? 'block' : 'none' }};">
                <label class="form-label fw-semibold">
                    Nominal DP <span class="required-mark">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="nominal_dp" id="nominalDp" 
                           class="form-control @error('nominal_dp') is-invalid @enderror" 
                           value="{{ old('nominal_dp', $booking->nominal_dp) }}" min="0">
                </div>
                @error('nominal_dp')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Status Booking <span class="required-mark">*</span>
                </label>
                <select name="status_booking" class="form-select @error('status_booking') is-invalid @enderror" required>
                    <option value="draft" {{ old('status_booking', $booking->status_booking) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="confirmed" {{ old('status_booking', $booking->status_booking) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="selesai" {{ old('status_booking', $booking->status_booking) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ old('status_booking', $booking->status_booking) == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
                @error('status_booking')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-12">
                <label class="form-label fw-semibold">Catatan</label>
                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" 
                          rows="3">{{ old('catatan', $booking->catatan) }}</textarea>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    
    <!-- Submit Buttons -->
    <div class="form-section">
        <div class="d-flex gap-3 justify-content-end">
            <a href="{{ route('admin.operasional.booking.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Booking
            </button>
        </div>
    </div>
</form>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="text-center">
        <div class="spinner mb-3"></div>
        <p class="text-white">Memuat data bus...</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalBerangkat = document.getElementById('tanggalBerangkat');
    const tanggalSelesai = document.getElementById('tanggalSelesai');
    const statusPembayaran = document.getElementById('statusPembayaran');
    const nominalDpWrapper = document.getElementById('nominalDpWrapper');
    const nominalDpInput = document.getElementById('nominalDp');
    const totalPembayaran = document.getElementById('totalPembayaran');
    const durasiText = document.getElementById('durasiText');
    
    // Handle tanggal selesai minimum
    tanggalBerangkat.addEventListener('change', function() {
        tanggalSelesai.min = this.value;
        if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
            tanggalSelesai.value = this.value;
        }
        calculateDuration();
        loadAvailableBuses();
    });
    
    tanggalSelesai.addEventListener('change', function() {
        calculateDuration();
        loadAvailableBuses();
    });
    
    // Calculate duration
    function calculateDuration() {
        if (tanggalBerangkat.value && tanggalSelesai.value) {
            const start = new Date(tanggalBerangkat.value);
            const end = new Date(tanggalSelesai.value);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            
            durasiText.textContent = diffDays + ' hari';
        }
    }
    
    // Handle status pembayaran
    statusPembayaran.addEventListener('change', function() {
        if (this.value === 'dp') {
            nominalDpWrapper.style.display = 'block';
            nominalDpInput.required = true;
        } else {
            nominalDpWrapper.style.display = 'none';
            nominalDpInput.required = false;
            if (this.value === 'lunas') {
                nominalDpInput.value = totalPembayaran.value;
            } else {
                nominalDpInput.value = 0;
            }
        }
    });
    
    // Load available buses
    function loadAvailableBuses() {
        if (!tanggalBerangkat.value || !tanggalSelesai.value) {
            return;
        }
        
        const loadingOverlay = document.getElementById('loadingOverlay');
        const busContainer = document.getElementById('busContainer');
        
        loadingOverlay.classList.add('active');
        
        fetch(`{{ route('admin.operasional.booking.bus-tersedia') }}?tanggal_berangkat=${tanggalBerangkat.value}&tanggal_selesai=${tanggalSelesai.value}&booking_id={{ $booking->id }}`)
            .then(response => response.json())
            .then(data => {
                loadingOverlay.classList.remove('active');
                
                if (data.success && data.data.length > 0) {
                    // Get currently selected buses
                    const currentlySelected = Array.from(document.querySelectorAll('input[name="bus_ids[]"]:checked'))
                        .map(cb => parseInt(cb.value));
                    
                    let html = '<div class="bus-selection-grid">';
                    
                    data.data.forEach(bus => {
                        const isSelected = currentlySelected.includes(bus.id);
                        html += `
                            <div class="bus-card ${isSelected ? 'selected' : ''}" onclick="toggleBus(this, ${bus.id})">
                                <input type="checkbox" name="bus_ids[]" value="${bus.id}" class="bus-card-checkbox" ${isSelected ? 'checked' : ''} onclick="event.stopPropagation()">
                                <div class="bus-info">
                                    <h6><i class="fas fa-bus me-2"></i>${bus.nama_bus}</h6>
                                    <div class="bus-detail">
                                        <i class="fas fa-tag"></i> ${bus.kode_bus}
                                    </div>
                                    <div class="bus-detail">
                                        <i class="fas fa-list"></i> ${bus.kategori}
                                    </div>
                                    <div class="bus-detail">
                                        <i class="fas fa-id-card"></i> ${bus.nomor_polisi}
                                    </div>
                                    <div class="bus-detail">
                                        <i class="fas fa-user-tie"></i> ${bus.sopir}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                    busContainer.innerHTML = html;
                } else {
                    busContainer.innerHTML = `
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                            <p>Tidak ada bus yang tersedia pada tanggal tersebut</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                loadingOverlay.classList.remove('active');
                console.error('Error:', error);
            });
    }
});

function toggleBus(card, busId) {
    const checkbox = card.querySelector('input[type="checkbox"]');
    checkbox.checked = !checkbox.checked;
    
    if (checkbox.checked) {
        card.classList.add('selected');
    } else {
        card.classList.remove('selected');
    }
}
</script>
@endsection