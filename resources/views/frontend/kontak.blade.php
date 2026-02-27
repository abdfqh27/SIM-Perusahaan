@extends('frontend.layouts.app')

@section('title', 'Hubungi Kami')

@push('styles')
    <style>
    /* Contact Page Specific Styles */
    
    /* Contact Info Cards Section */
    .contact-info-section {
        padding: 80px 0;
        background: #f8f9fa;
        margin-top: -50px;
        position: relative;
        z-index: 10;
    }
    
    .info-card {
        background: white;
        padding: 2.5rem 2rem;
        border-radius: 20px;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .info-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }
    
    .info-card:hover::before {
        transform: scaleX(1);
    }
    
    .info-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
        border-radius: 20px;
        font-size: 2rem;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(2, 48, 71, 0.3);
    }
    
    .info-card:hover .info-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 30px rgba(2, 48, 71, 0.4);
    }
    
    .whatsapp-card .info-icon {
        background: linear-gradient(135deg, #25D366, #128C7E);
        box-shadow: 0 8px 20px rgba(37, 211, 102, 0.3);
    }
    
    .whatsapp-card:hover .info-icon {
        box-shadow: 0 12px 30px rgba(37, 211, 102, 0.4);
    }
    
    .info-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 0.75rem;
    }
    
    .info-text {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
        line-height: 1.6;
    }
    
    .info-text a {
        color: #666;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .info-text a:hover {
        color: var(--orange-primary);
    }
    
    /* Contact Form Section */
    .contact-form-section {
        padding: 80px 0;
    }
    
    .contact-form-wrapper {
        background: white;
        padding: 3rem;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }
    
    .section-header {
        margin-bottom: 2rem;
    }
    
    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-title i {
        color: var(--orange-primary);
        font-size: 1.75rem;
    }
    
    .section-description {
        font-size: 1rem;
        color: #666;
        line-height: 1.6;
    }
    
    /* Alert Custom */
    .alert-custom {
        display: flex;
        align-items: start;
        gap: 1rem;
        padding: 1.25rem;
        border-radius: 15px;
        border: none;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        border-left: 4px solid #28a745;
    }
    
    .alert-custom i {
        font-size: 1.5rem;
        color: #28a745;
        margin-top: 0.25rem;
    }
    
    .alert-custom strong {
        display: block;
        font-size: 1rem;
        margin-bottom: 0.25rem;
        color: #155724;
    }
    
    .alert-custom p {
        margin: 0;
        color: #155724;
        font-size: 0.95rem;
    }
    
    /* Form Styles */
    .contact-form {
        margin-top: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: var(--blue-dark);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    
    .form-label i {
        color: var(--orange-primary);
        font-size: 0.9rem;
    }
    
    .required {
        color: #dc3545;
    }
    
    .form-control {
        width: 100%;
        padding: 0.875rem 1.25rem;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--orange-primary);
        box-shadow: 0 0 0 4px rgba(251, 133, 0, 0.1);
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    
    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
    }
    
    .invalid-feedback {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #dc3545;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }
    
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 3rem;
        background: linear-gradient(135deg, var(--orange-primary), var(--orange-secondary));
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(251, 133, 0, 0.4);
        width: 100%;
        justify-content: center;
    }
    
    .btn-submit:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(251, 133, 0, 0.6);
        background: linear-gradient(135deg, var(--orange-secondary), var(--orange-primary));
    }
    
    .btn-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    /* Contact Info Box */
    .contact-info-box {
        background: white;
        padding: 2.5rem;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 100px;
    }
    
    .info-box-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    
    .info-box-header i {
        font-size: 1.5rem;
        color: var(--orange-primary);
    }
    
    .info-box-header h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--blue-dark);
        margin: 0;
    }
    
    .info-box-content {
        margin-bottom: 2rem;
    }
    
    .info-box-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e9ecef, transparent);
        margin: 2rem 0;
    }
    
    .schedule-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f8f9fa;
    }
    
    .schedule-item:last-child {
        border-bottom: none;
    }
    
    .schedule-day {
        font-weight: 600;
        color: var(--blue-dark);
    }
    
    .schedule-time {
        color: #666;
        font-size: 0.95rem;
    }
    
    .service-text {
        color: #666;
        line-height: 1.8;
        margin-bottom: 1.5rem;
    }
    
    .btn-whatsapp-large {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        width: 100%;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #25D366, #128C7E);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
    }
    
    .btn-whatsapp-large:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(37, 211, 102, 0.6);
        color: white;
    }
    
    .faq-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0;
        color: #666;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .faq-item:hover {
        color: var(--orange-primary);
        padding-left: 0.5rem;
    }
    
    .faq-item i {
        color: var(--orange-primary);
        font-size: 0.75rem;
    }
    
    /* Map Section */
    .map-section {
        padding: 80px 0;
        background: #f8f9fa;
    }
    
    .map-wrapper {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }
    
    .map-header {
        padding: 2rem;
        background: linear-gradient(135deg, var(--blue-dark), var(--blue-light));
        display: flex;
        align-items: center;
        gap: 1rem;
        color: white;
    }
    
    .map-header i {
        font-size: 2rem;
    }
    
    .map-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }
    
    .map-container {
        position: relative;
        width: 100%;
        height: 450px;
    }
    
    .map-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
    
    /* Responsive Design */
    @media (max-width: 991px) {
        .contact-info-section {
            padding: 60px 0;
        }
        
        .contact-form-section {
            padding: 60px 0;
        }
        
        .contact-form-wrapper {
            margin-bottom: 2rem;
        }
        
        .contact-info-box {
            position: static;
        }
        
        .section-title {
            font-size: 1.75rem;
        }
    }
    
    @media (max-width: 768px) {
        .info-card {
            padding: 2rem 1.5rem;
        }
        
        .contact-form-wrapper {
            padding: 2rem 1.5rem;
        }
        
        .contact-info-box {
            padding: 2rem 1.5rem;
        }
        
        .map-section {
            padding: 60px 0;
        }
        
        .map-container {
            height: 350px;
        }
    }
    
    @media (max-width: 576px) {
        .contact-info-section {
            margin-top: -30px;
        }
        
        .info-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
        
        .section-title {
            font-size: 1.5rem;
            flex-direction: column;
            align-items: start;
        }
        
        .btn-submit {
            padding: 0.875rem 2rem;
        }
        
        .contact-form-wrapper,
        .contact-info-box {
            padding: 1.5rem;
        }
    }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="contact-page">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="container">
                <div class="hero-text" data-aos="fade-up">
                    <h1 class="hero-title">Hubungi Kami</h1>
                    <p class="hero-subtitle">Kami siap melayani dan menjawab pertanyaan Anda</p>
                    <div class="hero-divider"></div>
                    <div class="hero-breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('home') }}">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                        <span><i class="fas fa-chevron-right"></i></span>
                        <span>Kontak</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-wave">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>
        <div class="hero-decoration">
            <div class="decoration-circle circle-1"></div>
            <div class="decoration-circle circle-2"></div>
            <div class="decoration-circle circle-3"></div>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="contact-info-section">
        <div class="container">
            <div class="row g-4">
                <!-- Address Card -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 class="info-title">Alamat</h3>
                        <p class="info-text">{{ $pengaturans['alamat'] ?? 'Alamat belum diatur' }}</p>
                    </div>
                </div>

                <!-- Phone Card -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h3 class="info-title">Telepon</h3>
                        <p class="info-text">
                            <a href="tel:{{ $pengaturans['telepon'] ?? '#' }}">
                                {{ $pengaturans['telepon'] ?? 'Telepon belum diatur' }}
                            </a>
                        </p>
                    </div>
                </div>

                <!-- WhatsApp Card -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="info-card whatsapp-card">
                        <div class="info-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h3 class="info-title">WhatsApp</h3>
                        <p class="info-text">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengaturans['whatsapp'] ?? '') }}" target="_blank">
                                {{ $pengaturans['whatsapp'] ?? 'WhatsApp belum diatur' }}
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Email Card -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3 class="info-title">Email</h3>
                        <p class="info-text">
                            <a href="mailto:{{ $pengaturans['email'] ?? '#' }}">
                                {{ $pengaturans['email'] ?? 'Email belum diatur' }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="container">
            <div class="row align-items-start">
                <!-- Form Column -->
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="contact-form-wrapper">
                        <div class="section-header">
                            <h2 class="section-title">
                                <i class="fas fa-paper-plane"></i>
                                Kirim Pesan
                            </h2>
                            <p class="section-description">
                                Silakan isi formulir di bawah ini untuk menghubungi kami. Kami akan merespons pesan Anda secepatnya.
                            </p>
                        </div>

                        <!-- Success Message -->
                        @if(session('success'))
                        <div class="alert alert-success alert-custom" role="alert" id="success-alert">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Berhasil!</strong>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Contact Form -->
                        <form action="{{ route('kontak.store') }}" method="POST" class="contact-form" id="contactForm">
                            @csrf
                            
                            <div class="row g-3">
                                <!-- Nama -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            Nama Lengkap <span class="required">*</span>
                                        </label>
                                        <input type="text" 
                                               name="nama" 
                                               class="form-control @error('nama') is-invalid @enderror" 
                                               placeholder="Masukkan nama lengkap"
                                               value="{{ old('nama') }}"
                                               required>
                                        @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-envelope"></i>
                                            Email <span class="required">*</span>
                                        </label>
                                        <input type="email" 
                                               name="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               placeholder="email@example.com"
                                               value="{{ old('email') }}"
                                               required>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Telepon -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-phone"></i>
                                            Telepon
                                        </label>
                                        <input type="text" 
                                               name="telepon" 
                                               class="form-control @error('telepon') is-invalid @enderror" 
                                               placeholder="08xx xxxx xxxx"
                                               value="{{ old('telepon') }}">
                                        @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Subjek -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-tag"></i>
                                            Subjek <span class="required">*</span>
                                        </label>
                                        <input type="text" 
                                               name="subjek" 
                                               class="form-control @error('subjek') is-invalid @enderror" 
                                               placeholder="Subjek pesan"
                                               value="{{ old('subjek') }}"
                                               required>
                                        @error('subjek')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Pesan -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-comment-dots"></i>
                                            Pesan <span class="required">*</span>
                                        </label>
                                        <textarea name="pesan" 
                                                  rows="6" 
                                                  class="form-control @error('pesan') is-invalid @enderror" 
                                                  placeholder="Tulis pesan Anda di sini..."
                                                  required>{{ old('pesan') }}</textarea>
                                        @error('pesan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12">
                                    <button type="submit" class="btn-submit" id="submitBtn">
                                        <i class="fas fa-paper-plane"></i>
                                        <span id="btnText">Kirim Pesan</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Column -->
                <div class="col-lg-5" data-aos="fade-left">
                    <div class="contact-info-box">
                        <div class="info-box-header">
                            <i class="fas fa-clock"></i>
                            <h3>Jam Operasional</h3>
                        </div>
                        <div class="info-box-content">
                            <div class="schedule-item">
                                <div class="schedule-day">Senin - Jumat</div>
                                <div class="schedule-time">08:00 - 17:00 WIB</div>
                            </div>
                            <div class="schedule-item">
                                <div class="schedule-day">Sabtu</div>
                                <div class="schedule-time">08:00 - 14:00 WIB</div>
                            </div>
                            <div class="schedule-item">
                                <div class="schedule-day">Minggu</div>
                                <div class="schedule-time">Tutup</div>
                            </div>
                        </div>

                        <div class="info-box-divider"></div>

                        <div class="info-box-header">
                            <i class="fas fa-headset"></i>
                            <h3>Layanan Pelanggan</h3>
                        </div>
                        <div class="info-box-content">
                            <p class="service-text">
                                Tim kami siap membantu Anda 24/7 melalui WhatsApp untuk reservasi darurat dan pertanyaan mendesak.
                            </p>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengaturans['whatsapp'] ?? '') }}" 
                               target="_blank" 
                               class="btn-whatsapp-large">
                                <i class="fab fa-whatsapp"></i>
                                Hubungi via WhatsApp
                            </a>
                        </div>

                        <div class="info-box-divider"></div>

                        <div class="info-box-header">
                            <i class="fas fa-question-circle"></i>
                            <h3>Pertanyaan Umum</h3>
                        </div>
                        <div class="info-box-content">
                            <div class="faq-item">
                                <i class="fas fa-chevron-right"></i>
                                <span>Cara melakukan reservasi?</span>
                            </div>
                            <div class="faq-item">
                                <i class="fas fa-chevron-right"></i>
                                <span>Metode pembayaran?</span>
                            </div>
                            <div class="faq-item">
                                <i class="fas fa-chevron-right"></i>
                                <span>Kebijakan pembatalan?</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section" data-aos="fade-up">
        <div class="container">
            <div class="map-wrapper">
                <div class="map-header">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>Lokasi Kami</h3>
                </div>
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3513.677525210416!2d108.36010158061981!3d-6.70110948089516!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ed985fd97693b%3A0xd95b1854936ea192!2sSRIMAJU%20TRANS%20GARASI!5e1!3m2!1sid!2sid!4v1767000475612!5m2!1sid!2sid" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // AOS Animation
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100,
        easing: 'ease-in-out'
    });

    // Auto hide success message after 5 seconds
    setTimeout(function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);

    // Form submission handling
    const contactForm = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Mengirim...</span>';
        });
    }

    // Reset form after successful submission
    @if(session('success'))
        setTimeout(function() {
            if (contactForm) {
                contactForm.reset();
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> <span>Kirim Pesan</span>';
                }
            }
        }, 100);
    @endif
</script>
@endpush