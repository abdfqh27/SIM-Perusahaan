<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Sri Maju Trans - Rental Bus Terpercaya di Indonesia')">
    <meta name="keywords" content="rental bus, sewa bus, pariwisata, transportasi">
    <meta name="author" content="Sri Maju Trans">
    <title>@yield('title', 'Beranda') - {{ config('app.name', 'Sri Maju Trans') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('storage/favicon.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite CSS & JS -->
    @vite(['resources/css/frontend/app.css', 'resources/js/frontend/app.js'])
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('storage/logo.png') }}" alt="Sri Maju Trans Logo" class="me-2">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}">
                            <i class="fas fa-info-circle me-1"></i> Tentang Kami
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('layanan*') ? 'active' : '' }}" href="{{ route('layanan') }}">
                            <i class="fas fa-concierge-bell me-1"></i> Layanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('armada*') ? 'active' : '' }}" href="{{ route('armada') }}">
                            <i class="fas fa-bus me-1"></i> Armada
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('galeri') ? 'active' : '' }}" href="{{ route('galeri') }}">
                            <i class="fas fa-images me-1"></i> Galeri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('artikel*') ? 'active' : '' }}" href="{{ route('artikel') }}">
                            <i class="fas fa-newspaper me-1"></i> Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">
                            <i class="fas fa-envelope me-1"></i> Kontak
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <!-- Tentanng Section -->
                <div class="col-lg-4 col-md-6 animate-fade-in">
                    <h5 class="mb-3">
                        <i class="fas fa-bus-alt me-2"></i>Tentang Kami
                    </h5>
                    <p class="text-white-50">
                        Sri Maju Trans adalah perusahaan rental bus terpercaya dengan armada lengkap dan pelayanan terbaik untuk perjalanan Anda. Kami berkomitmen memberikan pengalaman perjalanan yang aman, nyaman, dan berkesan.
                    </p>
                    <div class="mt-3">
                        <img src="{{ asset('storage/logo.png') }}" alt="Sri Maju Trans" class="footer-logo">
                    </div>
                </div>
                
                <!-- Kontak Section -->
                <div class="col-lg-4 col-md-6 animate-fade-in" style="animation-delay: 0.2s;">
                    <h5 class="mb-3">
                        <i class="fas fa-map-marked-alt me-2"></i>Kontak Kami
                    </h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Jl. Raya Utama No. 123, Jakarta
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:02112345678" class="text-white-50 text-decoration-none">021-12345678</a>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-mobile-alt me-2"></i>
                            <a href="tel:081234567890" class="text-white-50 text-decoration-none">0812-3456-7890</a>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:info@srimajutrans.com" class="text-white-50 text-decoration-none">info@srimajutrans.com</a>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-clock me-2"></i>
                            Senin - Minggu: 24 Jam
                        </li>
                    </ul>
                </div>
                
                <!-- Social Media Section -->
                <div class="col-lg-4 col-md-12 animate-fade-in" style="animation-delay: 0.4s;">
                    <h5 class="mb-3">
                        <i class="fas fa-share-alt me-2"></i>Ikuti Kami
                    </h5>
                    <p class="text-white-50 mb-3">
                        Dapatkan update terbaru, promo menarik, dan tips perjalanan dari kami melalui media sosial.
                    </p>
                    <div class="social-links d-flex gap-3">
                        <a href="https://facebook.com" class="text-white" title="Facebook" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook-f fs-5"></i>
                        </a>
                        <a href="https://instagram.com" class="text-white" title="Instagram" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-instagram fs-5"></i>
                        </a>
                        <a href="https://twitter.com" class="text-white" title="Twitter" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-twitter fs-5"></i>
                        </a>
                        <a href="https://youtube.com" class="text-white" title="YouTube" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-youtube fs-5"></i>
                        </a>
                        <a href="https://tiktok.com" class="text-white" title="TikTok" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-tiktok fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <hr class="my-4" style="border-color: rgba(255, 255, 255, 0.1);">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0 text-white-50">
                        <i class="fas fa-copyright me-1"></i>
                        {{ date('Y') }} Sri Maju Trans. All Rights Reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0 text-white-50">
                        Made with <i class="fas fa-heart" style="color: var(--orange-primary);"></i> in Indonesia by <strong>Abdullah Faqih</strong>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/6281234567890?text=Halo%20Sri%20Maju%20Trans,%20saya%20ingin%20bertanya%20tentang%20layanan%20rental%20bus" 
       class="whatsapp-float position-fixed bottom-0 end-0 m-4 text-white text-decoration-none"
       style="z-index: 1000;"
       target="_blank"
       rel="noopener noreferrer"
       title="Hubungi Kami via WhatsApp">
        <i class="fab fa-whatsapp fs-2"></i>
    </a>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    
    <!-- Smooth Scroll -->
    <script>
        // Smooth scrolling untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.padding = '0.5rem 0';
                navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.2)';
            } else {
                navbar.style.padding = '1rem 0';
                navbar.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
            }
        });

        // Auto close navbar on mobile after clicking link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
            });
        });
    </script>
</body>
</html>