<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Sri Maju Trans</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite CSS & JS -->
    @vite(['resources/css/auth/forgot-password.css', 'resources/js/frontend/app.js'])
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

    <!-- Main Container -->
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
                            <span>Password Baru</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Aman & Terenkripsi</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-sync-alt"></i>
                            <span>Siap Digunakan</span>
                        </div>
                    </div>

                    <div class="decoration-circle circle-1"></div>
                    <div class="decoration-circle circle-2"></div>
                    <div class="decoration-circle circle-3"></div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="login-form-section">
                <div class="form-content">
                    <!-- Header -->
                    <div class="form-header">
                        <div class="icon-header success">
                            <i class="fas fa-lock-open"></i>
                        </div>
                        <h2 class="form-title">Buat Password Baru</h2>
                        <p class="form-subtitle">Buat password baru untuk akun <strong>{{ $email }}</strong></p>
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

                    <!-- Reset Password Form -->
                    <form method="POST" action="{{ route('password.update.new') }}" class="login-form">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">

                        <!-- New Password -->
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password Baru
                            </label>
                            <div class="input-wrapper">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required placeholder="Minimal 8 karakter">
                                <i class="fas fa-lock input-icon"></i>
                                <button type="button" class="toggle-password" data-target="password">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Gunakan kombinasi huruf, angka, dan simbol
                            </small>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-2"></i>Konfirmasi Password
                            </label>
                            <div class="input-wrapper">
                                <input id="password_confirmation" type="password" class="form-control"
                                    name="password_confirmation" required placeholder="Ulangi password baru">
                                <i class="fas fa-lock input-icon"></i>
                                <button type="button" class="toggle-password" data-target="password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strength-fill"></div>
                            </div>
                            <span class="strength-text" id="strength-text">Masukkan password</span>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-login">
                            <span class="btn-text">Reset Password</span>
                            <i class="fas fa-save btn-icon"></i>
                        </button>

                        <!-- Divider -->
                        <div class="divider">
                            <span>atau</span>
                        </div>

                        <!-- Back to Login -->
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-back">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali ke Login
                        </a>
                    </form>

                    <!-- Footer -->
                    <div class="form-footer">
                        <p class="footer-text">
                            &copy; {{ date('Y') }} Sri Maju Trans. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle Password Visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Password Strength Checker
        const passwordInput = document.getElementById('password');
        const strengthFill = document.getElementById('strength-fill');
        const strengthText = document.getElementById('strength-text');

        passwordInput.addEventListener('input', function () {
            const password = this.value;
            let strength = 0;
            let text = '';
            let color = '';

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            switch (strength) {
                case 0:
                case 1:
                    text = 'Sangat Lemah';
                    color = '#dc3545';
                    break;
                case 2:
                    text = 'Lemah';
                    color = '#fd7e14';
                    break;
                case 3:
                    text = 'Sedang';
                    color = '#ffc107';
                    break;
                case 4:
                    text = 'Kuat';
                    color = '#20c997';
                    break;
                case 5:
                    text = 'Sangat Kuat';
                    color = '#198754';
                    break;
            }

            if (password.length === 0) {
                strengthFill.style.width = '0%';
                strengthText.textContent = 'Masukkan password';
                strengthText.style.color = '#6c757d';
            } else {
                strengthFill.style.width = (strength * 20) + '%';
                strengthFill.style.background = color;
                strengthText.textContent = text;
                strengthText.style.color = color;
            }
        });

        // Menutup alert otomatis
        const alerts = document.querySelectorAll('.custom-alert');
        alerts.forEach(function (alert) {
            setTimeout(function () {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Animasi
        window.addEventListener('load', function () {
            document.querySelector('.login-wrapper').classList.add('animate-in');
        });

        // Animasi validasi form
        const form = document.querySelector('.login-form');
        const inputs = form.querySelectorAll('.form-control');

        inputs.forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function () {
                if (this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });

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

        setInterval(createParticle, 300);
    </script>
</body>

</html>