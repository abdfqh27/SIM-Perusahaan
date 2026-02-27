<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Sri Maju Trans</title>

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
                            <i class="fas fa-shield-alt"></i>
                            <span>Verifikasi 2 Langkah</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-clock"></i>
                            <span>OTP Berlaku 10 Menit</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-lock"></i>
                            <span>Keamanan Terjamin</span>
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
                        <div class="icon-header">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h2 class="form-title">Verifikasi OTP</h2>
                        <p class="form-subtitle">Masukkan kode 6 digit yang telah dikirim ke email
                            <strong>{{ $email }}</strong></p>
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

                    <!-- OTP Form -->
                    <form method="POST" action="{{ route('password.verify.otp') }}" class="login-form">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">

                        <!-- OTP Input -->
                        <div class="form-group">
                            <label for="otp" class="form-label">
                                <i class="fas fa-key me-2"></i>Kode OTP
                            </label>
                            <div class="otp-input-wrapper">
                                <input type="text" id="otp-1" class="otp-input" maxlength="1" autofocus
                                    inputmode="numeric" pattern="[0-9]">
                                <input type="text" id="otp-2" class="otp-input" maxlength="1" inputmode="numeric"
                                    pattern="[0-9]">
                                <input type="text" id="otp-3" class="otp-input" maxlength="1" inputmode="numeric"
                                    pattern="[0-9]">
                                <input type="text" id="otp-4" class="otp-input" maxlength="1" inputmode="numeric"
                                    pattern="[0-9]">
                                <input type="text" id="otp-5" class="otp-input" maxlength="1" inputmode="numeric"
                                    pattern="[0-9]">
                                <input type="text" id="otp-6" class="otp-input" maxlength="1" inputmode="numeric"
                                    pattern="[0-9]">
                            </div>
                            <input type="hidden" name="otp" id="otp-full" required>
                            @error('otp')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Timer -->
                        <div class="otp-timer-wrapper">
                            <p class="otp-timer-text">
                                <i class="fas fa-clock me-1"></i>
                                Kode berlaku: <span id="timer" class="timer-count">10:00</span>
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-login">
                            <span class="btn-text">Verifikasi Kode</span>
                            <i class="fas fa-check-circle btn-icon"></i>
                        </button>

                        <!-- Resend OTP -->
                        <div class="resend-wrapper">
                            <p class="resend-text">Tidak menerima kode?</p>
                            <form method="POST" action="{{ route('password.resend.otp') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <button type="submit" class="btn btn-resend" id="resend-btn">
                                    <i class="fas fa-redo me-1"></i>Kirim Ulang OTP
                                </button>
                            </form>
                        </div>

                        <!-- Divider -->
                        <div class="divider">
                            <span>atau</span>
                        </div>

                        <!-- Back to Email -->
                        <a href="{{ route('password.request') }}" class="btn btn-outline-secondary btn-back">
                            <i class="fas fa-arrow-left me-2"></i>
                            Ganti Email
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
        // OTP Input Handler
        const otpInputs = document.querySelectorAll('.otp-input');
        const otpFull = document.getElementById('otp-full');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                // Hanya angka
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                // Pindah ke input berikutnya
                if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }

                // Update hidden input
                updateOtpFull();
            });

            input.addEventListener('keydown', (e) => {
                // Handle backspace
                if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });

            // Paste handler
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);

                pastedData.split('').forEach((char, i) => {
                    if (otpInputs[i]) {
                        otpInputs[i].value = char;
                    }
                });

                if (pastedData.length > 0) {
                    otpInputs[Math.min(pastedData.length, 5)].focus();
                }

                updateOtpFull();
            });
        });

        function updateOtpFull() {
            let otp = '';
            otpInputs.forEach(input => {
                otp += input.value;
            });
            otpFull.value = otp;
        }

        // Timer
        let timeLeft = 600; // 10 menit dalam detik
        const timerDisplay = document.getElementById('timer');
        const resendBtn = document.getElementById('resend-btn');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft === 0) {
                timerDisplay.textContent = 'Kadaluarsa';
                timerDisplay.classList.add('expired');
                resendBtn.disabled = false;
            } else {
                timeLeft--;
                setTimeout(updateTimer, 1000);
            }
        }

        updateTimer();

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