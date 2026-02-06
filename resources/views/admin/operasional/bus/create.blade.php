@extends('admin.layouts.app')

@section('title', 'Tambah Bus')

@section('content')
<div class="admin-content">
    <!-- Page Header -->
    <div class="gradient-header">
        <div class="header-left">
            <a href="{{ route('admin.operasional.bus.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div>
                <h2 class="header-title">Tambah bus</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.operasional.bus.index') }}">bus</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i>
            Formulir Data Bus
        </div>
        <div class="card-body">
            <form action="{{ route('admin.operasional.bus.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Kode Bus -->
                    <div class="col-md-6 mb-4">
                        <label for="kode_bus" class="form-label" style="
                            font-weight: 600;
                            color: var(--blue-dark);
                            margin-bottom: 0.5rem;
                            display: block;
                        ">
                            Kode Bus <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('kode_bus') is-invalid @enderror" 
                               id="kode_bus" 
                               name="kode_bus" 
                               value="{{ old('kode_bus') }}"
                               placeholder="Contoh: BUS001"
                               style="
                                   padding: 0.75rem 1rem;
                                   border: 2px solid #e9ecef;
                                   border-radius: 8px;
                                   transition: all 0.3s ease;
                               "
                               onfocus="this.style.borderColor='var(--orange-primary)'"
                               onblur="this.style.borderColor='#e9ecef'">
                        @error('kode_bus')
                        <div class="invalid-feedback" style="
                            display: block;
                            color: #dc3545;
                            font-size: 0.875rem;
                            margin-top: 0.5rem;
                        ">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Nama Bus -->
                    <div class="col-md-6 mb-4">
                        <label for="nama_bus" class="form-label" style="
                            font-weight: 600;
                            color: var(--blue-dark);
                            margin-bottom: 0.5rem;
                            display: block;
                        ">
                            Nama Bus <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_bus') is-invalid @enderror" 
                               id="nama_bus" 
                               name="nama_bus" 
                               value="{{ old('nama_bus') }}"
                               placeholder="Contoh: Bus Pariwisata Deluxe"
                               style="
                                   padding: 0.75rem 1rem;
                                   border: 2px solid #e9ecef;
                                   border-radius: 8px;
                                   transition: all 0.3s ease;
                               "
                               onfocus="this.style.borderColor='var(--orange-primary)'"
                               onblur="this.style.borderColor='#e9ecef'">
                        @error('nama_bus')
                        <div class="invalid-feedback" style="
                            display: block;
                            color: #dc3545;
                            font-size: 0.875rem;
                            margin-top: 0.5rem;
                        ">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Kategori Bus -->
                    <div class="col-md-6 mb-4">
                        <label for="kategori_bus_id" class="form-label" style="
                            font-weight: 600;
                            color: var(--blue-dark);
                            margin-bottom: 0.5rem;
                            display: block;
                        ">
                            Kategori Bus <span style="color: #dc3545;">*</span>
                        </label>
                        <select class="form-control @error('kategori_bus_id') is-invalid @enderror" 
                                id="kategori_bus_id" 
                                name="kategori_bus_id"
                                style="
                                    padding: 0.75rem 1rem;
                                    border: 2px solid #e9ecef;
                                    border-radius: 8px;
                                    transition: all 0.3s ease;
                                    background-position: right 1rem center;
                                "
                                onfocus="this.style.borderColor='var(--orange-primary)'"
                                onblur="this.style.borderColor='#e9ecef'">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategories as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_bus_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }} ({{ $kategori->jumlah_seat }} Seat)
                            </option>
                            @endforeach
                        </select>
                        @error('kategori_bus_id')
                        <div class="invalid-feedback" style="
                            display: block;
                            color: #dc3545;
                            font-size: 0.875rem;
                            margin-top: 0.5rem;
                        ">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Sopir -->
                    <div class="col-md-6 mb-4">
                        <label for="sopir_id" class="form-label" style="
                            font-weight: 600;
                            color: var(--blue-dark);
                            margin-bottom: 0.5rem;
                            display: block;
                        ">
                            Sopir <span style="color: #dc3545;">*</span>
                        </label>
                        <select class="form-control @error('sopir_id') is-invalid @enderror" 
                                id="sopir_id" 
                                name="sopir_id"
                                style="
                                    padding: 0.75rem 1rem;
                                    border: 2px solid #e9ecef;
                                    border-radius: 8px;
                                    transition: all 0.3s ease;
                                    background-position: right 1rem center;
                                "
                                onfocus="this.style.borderColor='var(--orange-primary)'"
                                onblur="this.style.borderColor='#e9ecef'">
                            <option value="">-- Pilih Sopir --</option>
                            @foreach($sopirs as $sopir)
                            <option value="{{ $sopir->id }}" {{ old('sopir_id') == $sopir->id ? 'selected' : '' }}>
                                {{ $sopir->nama }} - {{ $sopir->nomor_telepon }}
                            </option>
                            @endforeach
                        </select>
                        @error('sopir_id')
                        <div class="invalid-feedback" style="
                            display: block;
                            color: #dc3545;
                            font-size: 0.875rem;
                            margin-top: 0.5rem;
                        ">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                        <small style="color: #6c757d; font-size: 0.85rem; margin-top: 0.5rem; display: block;">
                            <i class="fas fa-info-circle"></i> Hanya menampilkan sopir yang belum ditugaskan
                        </small>
                    </div>

                    <!-- Warna Bus -->
                    <div class="col-md-6 mb-4">
                        <label for="warna_bus" class="form-label" style="
                            font-weight: 600;
                            color: var(--blue-dark);
                            margin-bottom: 0.5rem;
                            display: block;
                        ">
                            Warna Bus <span style="color: #dc3545;">*</span>
                        </label>
                        <div style="display: flex; gap: 0.75rem;">
                            <input type="color" 
                                   id="color_picker" 
                                   value="{{ old('warna_bus', '#ffffff') }}"
                                   style="
                                       width: 60px;
                                       height: 48px;
                                       border: 2px solid #e9ecef;
                                       border-radius: 8px;
                                       cursor: pointer;
                                   ">
                            <input type="text" 
                                   class="form-control @error('warna_bus') is-invalid @enderror" 
                                   id="warna_bus" 
                                   name="warna_bus" 
                                   value="{{ old('warna_bus') }}"
                                   placeholder="Contoh: Putih atau #FFFFFF"
                                   style="
                                       flex: 1;
                                       padding: 0.75rem 1rem;
                                       border: 2px solid #e9ecef;
                                       border-radius: 8px;
                                       transition: all 0.3s ease;
                                   "
                                   onfocus="this.style.borderColor='var(--orange-primary)'"
                                   onblur="this.style.borderColor='#e9ecef'">
                        </div>
                        @error('warna_bus')
                        <div class="invalid-feedback" style="
                            display: block;
                            color: #dc3545;
                            font-size: 0.875rem;
                            margin-top: 0.5rem;
                        ">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Nomor Polisi -->
                    <div class="col-md-6 mb-4">
                        <label for="nomor_polisi" class="form-label" style="
                            font-weight: 600;
                            color: var(--blue-dark);
                            margin-bottom: 0.5rem;
                            display: block;
                        ">
                            Nomor Polisi <span style="color: #dc3545;">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nomor_polisi') is-invalid @enderror" 
                               id="nomor_polisi" 
                               name="nomor_polisi" 
                               value="{{ old('nomor_polisi') }}"
                               placeholder="Contoh: B 1234 XYZ"
                               style="
                                   padding: 0.75rem 1rem;
                                   border: 2px solid #e9ecef;
                                   border-radius: 8px;
                                   transition: all 0.3s ease;
                                   text-transform: uppercase;
                               "
                               onfocus="this.style.borderColor='var(--orange-primary)'"
                               onblur="this.style.borderColor='#e9ecef'">
                        @error('nomor_polisi')
                        <div class="invalid-feedback" style="
                            display: block;
                            color: #dc3545;
                            font-size: 0.875rem;
                            margin-top: 0.5rem;
                        ">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label" style="
                            font-weight: 600;
                            color: var(--blue-dark);
                            margin-bottom: 0.75rem;
                            display: block;
                        ">
                            Status <span style="color: #dc3545;">*</span>
                        </label>
                        <div style="display: flex; gap: 2rem;">
                            <div class="form-check" style="display: flex; align-items: center;">
                                <input class="form-check-input @error('status') is-invalid @enderror" 
                                       type="radio" 
                                       name="status" 
                                       id="status_aktif" 
                                       value="aktif"
                                       {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }}
                                       style="
                                           width: 20px;
                                           height: 20px;
                                           margin-right: 0.5rem;
                                           cursor: pointer;
                                       ">
                                <label class="form-check-label" for="status_aktif" style="
                                    cursor: pointer;
                                    display: flex;
                                    align-items: center;
                                    gap: 0.5rem;
                                    font-weight: 500;
                                ">
                                    <span style="
                                        background: rgba(40, 167, 69, 0.1);
                                        color: #28a745;
                                        padding: 0.35rem 0.75rem;
                                        border-radius: 6px;
                                        font-size: 0.9rem;
                                    ">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                </label>
                            </div>
                            <div class="form-check" style="display: flex; align-items: center;">
                                <input class="form-check-input @error('status') is-invalid @enderror" 
                                       type="radio" 
                                       name="status" 
                                       id="status_perawatan" 
                                       value="perawatan"
                                       {{ old('status') == 'perawatan' ? 'checked' : '' }}
                                       style="
                                           width: 20px;
                                           height: 20px;
                                           margin-right: 0.5rem;
                                           cursor: pointer;
                                       ">
                                <label class="form-check-label" for="status_perawatan" style="
                                    cursor: pointer;
                                    display: flex;
                                    align-items: center;
                                    gap: 0.5rem;
                                    font-weight: 500;
                                ">
                                    <span style="
                                        background: rgba(255, 193, 7, 0.1);
                                        color: #ffc107;
                                        padding: 0.35rem 0.75rem;
                                        border-radius: 6px;
                                        font-size: 0.9rem;
                                    ">
                                        <i class="fas fa-tools"></i> Perawatan
                                    </span>
                                </label>
                            </div>
                        </div>
                        @error('status')
                        <div class="invalid-feedback" style="
                            display: block;
                            color: #dc3545;
                            font-size: 0.875rem;
                            margin-top: 0.5rem;
                        ">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div style="
                    border-top: 2px solid #e9ecef;
                    padding-top: 1.5rem;
                    margin-top: 1rem;
                    display: flex;
                    gap: 1rem;
                    justify-content: flex-end;
                ">
                    <a href="{{ route('admin.operasional.bus.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Color picker synchronization
document.getElementById('color_picker').addEventListener('input', function(e) {
    document.getElementById('warna_bus').value = e.target.value;
});

document.getElementById('warna_bus').addEventListener('input', function(e) {
    const value = e.target.value;
    if (value.startsWith('#')) {
        document.getElementById('color_picker').value = value;
    }
});

// Auto uppercase nomor polisi
document.getElementById('nomor_polisi').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});
</script>
@endsection