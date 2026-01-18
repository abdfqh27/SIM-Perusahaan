{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sri Maju Trans</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite CSS & JS -->
    @vite(['resources/css/auth/login.css', 'resources/js/frontend/app.js'])
</head>
<body>
    <!-- Animated Background -->
    <div class="login-background">
        <div class="animated-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="shape shape-5"></div>
        </div>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-wrapper">
            <!-- Left Side - Branding -->
            <div class="login-branding">
                <div class="branding-content">
                    <div class="logo-wrapper">
                        <i class="fas fa-bus logo-icon"></i>
                    </div>
                    <h1 class="brand-title">Sri Maju Trans</h1>
                    <p class="brand-subtitle">Sistem Manajemen Transportasi</p>
                    
                    <div class="features-list">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Manajemen Armada Terintegrasi</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Monitoring Real-time</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Keamanan Data Terjamin</span>
                        </div>
                    </div>

                    <div class="decoration-circle circle-1"></div>
                    <div class="decoration-circle circle-2"></div>
                    <div class="decoration-circle circle-3"></div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="login-form-section">
                <div class="form-content">
                    <!-- Header -->
                    <div class="form-header">
                        <h2 class="form-title">Selamat Datang!</h2>
                        <p class="form-subtitle">Silakan login untuk melanjutkan ke dashboard</p>
                    </div>

                    <!-- Alert Messages -->
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf

                        <!-- Email Input -->
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <div class="input-wrapper">
                                <input 
                                    id="email" 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autocomplete="email" 
                                    autofocus
                                    placeholder="Masukkan email Anda"
                                >
                                <i class="fas fa-user input-icon"></i>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <div class="input-wrapper">
                                <input 
                                    id="password" 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    name="password" 
                                    required 
                                    autocomplete="current-password"
                                    placeholder="Masukkan password Anda"
                                >
                                <i class="fas fa-lock input-icon"></i>
                                <button type="button" class="toggle-password" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="form-options">
                            <div class="form-check custom-checkbox">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="remember" 
                                    id="remember" 
                                    {{ old('remember') ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                            <a class="forgot-password" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-login">
                            <span class="btn-text">Masuk ke Dashboard</span>
                            <i class="fas fa-arrow-right btn-icon"></i>
                        </button>

                        <!-- Divider -->
                        <div class="divider">
                            <span>atau</span>
                        </div>

                        <!-- Back to Website -->
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-back">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Website
                        </a>
                    </form>

                    <!-- Footer -->
                    <div class="form-footer">
                        <p class="footer-text">
                            Dikembangkan oleh <strong>Abdullah Faqih</strong>
                        </p>
                        <p class="footer-text mt-1">
                            &copy; {{ date('Y') }} Sri Maju Trans. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Login JS -->
    <script>
    // Toggle tampil/sembunyi password
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }

    // Menutup alert otomatis
    const alerts = document.querySelectorAll('.custom-alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Menambahkan class animasi saat halaman selesai dimuat
    window.addEventListener('load', function() {
        document.querySelector('.login-wrapper').classList.add('animate-in');
    });

    // Animasi validasi form
    const form = document.querySelector('.login-form');
    const inputs = form.querySelectorAll('.form-control');

    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            if (this.value === '') {
                this.parentElement.classList.remove('focused');
            }
        });

        // Menambahkan class focused jika input sudah memiliki nilai
        if (input.value !== '') {
            input.parentElement.classList.add('focused');
        }
    });

    // Animasi partikel
    function createParticle() {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDuration = (Math.random() * 3 + 2) + 's';
        particle.style.opacity = Math.random() * 0.5 + 0.2;
        document.querySelector('.login-background').appendChild(particle);

        setTimeout(() => {
            particle.remove();
        }, 5000);
    }

        // Membuat partikel secara berkala
        setInterval(createParticle, 300);
    </script>
</body>
</html>