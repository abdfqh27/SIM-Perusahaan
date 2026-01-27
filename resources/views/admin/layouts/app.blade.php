<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])
    
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper" id="adminWrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <div class="brand-wrapper">
                    <div class="brand-logo">
                        <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="logo-img">
                    </div>
                    <h4 class="brand-title">Halaman Admin</h4>
                </div>
                <button class="sidebar-close d-lg-none" id="sidebarClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="sidebar-menu">
                <!-- Dashboard -->
                <div class="menu-section">
                    <div class="menu-section-title">
                        <i class="fas fa-th-large"></i>
                        <span>Menu Utama</span>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <!-- Profil Perusahaan - Owner & Admin Company -->
                @if(auth()->user()->role && in_array(auth()->user()->role->slug, ['owner', 'admin-company']))
                <div class="menu-section">
                    <div class="menu-section-title">
                        <i class="fas fa-building"></i>
                        <span>Profil Perusahaan</span>
                    </div>
                    <a href="{{ route('admin.hero.index') }}" class="menu-item {{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
                        <i class="fas fa-image"></i>
                        <span>Hero Section</span>
                    </a>
                    <a href="{{ route('admin.tentang.index') }}" class="menu-item {{ request()->routeIs('admin.tentang.*') ? 'active' : '' }}">
                        <i class="fas fa-info-circle"></i>
                        <span>Tentang Perusahaan</span>
                    </a>
                    <a href="{{ route('admin.layanan.index') }}" class="menu-item {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}">
                        <i class="fas fa-concierge-bell"></i>
                        <span>Layanan</span>
                    </a>
                </div>

                <!-- Armada & Galeri -->
                <div class="menu-section">
                    <div class="menu-section-title">
                        <i class="fas fa-images"></i>
                        <span>Armada & Galeri</span>
                    </div>
                    <a href="{{ route('admin.armada.index') }}" class="menu-item {{ request()->routeIs('admin.armada*') ? 'active' : '' }}">
                        <i class="fas fa-bus"></i>
                        <span>Armada</span>
                    </a>
                    <a href="{{ route('admin.gallery.index') }}" class="menu-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                        <i class="fas fa-camera"></i>
                        <span>Galeri</span>
                    </a>
                </div>

                <!-- Konten -->
                <div class="menu-section">
                    <div class="menu-section-title">
                        <i class="fas fa-file-alt"></i>
                        <span>Konten</span>
                    </div>
                    <a href="{{ route('admin.artikel.index') }}" class="menu-item {{ request()->routeIs('admin.artikel.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i>
                        <span>Artikel</span>
                    </a>
                </div>

                <!-- Komunikasi -->
                <div class="menu-section">
                    <div class="menu-section-title">
                        <i class="fas fa-envelope-open-text"></i>
                        <span>Komunikasi</span>
                    </div>
                    <a href="{{ route('admin.pesan-kontak.index') }}" class="menu-item {{ request()->routeIs('admin.pesan-kontak.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i>
                        <span>Pesan Kontak</span>
                    </a>
                </div>
                @endif

                <!-- Operasional - Owner & Admin Perusahaan -->
                @if(auth()->user()->role && in_array(auth()->user()->role->slug, ['owner', 'admin-perusahaan']))
                <div class="menu-section">
                    <div class="menu-section-title">
                        <i class="fas fa-cogs"></i>
                        <span>Operasional</span>
                    </div>
                    <a href="{{ route('admin.operasional.kategori-bus.index') }}" class="menu-item {{ request()->routeIs('admin.operasional.kategori-bus.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Kategori Bus</span>
                    </a>
                    <a href="{{ route('admin.operasional.sopir.index') }}" class="menu-item {{ request()->routeIs('admin.operasional.sopir.*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i>
                        <span>Sopir</span>
                    </a>
                    <a href="{{ route('admin.operasional.bus.index') }}" class="menu-item {{ request()->routeIs('admin.operasional.bus.*') ? 'active' : '' }}">
                        <i class="fas fa-bus-alt"></i>
                        <span>Bus</span>
                    </a>
                    <a href="{{ route('admin.operasional.booking.index') }}" class="menu-item {{ request()->routeIs('admin.operasional.booking.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Booking / Pesanan</span>
                    </a>
                </div>
                @endif

                <!-- Laporan - Hanya Owner -->
                @if(auth()->user()->role && auth()->user()->role->slug === 'owner')
                <div class="menu-section">
                    <div class="menu-section-title">
                        <i class="fas fa-chart-line"></i>
                        <span>Laporan</span>
                    </div>
                    <a href="{{ route('admin.laporan.index') }}" class="menu-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan & Analisis</span>
                    </a>
                </div>
                @endif
                
                <!-- Pengaturan Sistem -->
                @if(auth()->user()->role && in_array(auth()->user()->role->slug, ['owner', 'admin-company']))
                <div class="menu-section">
                    <div class="menu-section-title">
                        <i class="fas fa-sliders-h"></i>
                        <span>Pengaturan Sistem</span>
                    </div>
                    <a href="{{ route('admin.pengaturan.index') }}" class="menu-item {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                    @if(auth()->user()->isOwner())
                    <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i>
                        <span>Manajemen User</span>
                    </a>
                    @endif
                </div>
                @endif
            </div>

            <!-- Sidebar Footer -->
            <div class="sidebar-footer">
                <a href="{{ route('admin.profile.show') }}" class="user-info-link">
                    <div class="user-info">
                        <div class="user-avatar">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                    alt="{{ auth()->user()->name }}" 
                                    class="user-avatar-img">
                            @else
                                <i class="fas fa-user-circle"></i>
                            @endif
                        </div>
                        <div class="user-details">
                            <p class="user-name" title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</p>
                            <p class="user-role">{{ auth()->user()->role ? auth()->user()->role->nama : 'User' }}</p>
                        </div>
                        <div class="user-action">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Top Navigation -->
            <nav class="admin-navbar">
                <div class="navbar-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="page-title">
                        <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
                    </div>
                </div>
                
                <div class="navbar-right">
                    <a href="{{ url('/') }}" class="btn btn-sm btn-outline-primary me-2" target="_blank">
                        <i class="fas fa-home me-1"></i> Lihat Website
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-logout">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="admin-content">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
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

                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="admin-footer">
                <div class="footer-content">
                    <p class="mb-0">&copy; {{ date('Y') }} PT Sri Maju Trans. All rights reserved.</p>
                    <p class="mb-0">Dibuat oleh Abdullah Faqih <i class="fas fa-heart text-danger"></i></p>
                </div>
            </footer>
        </main>
    </div>

    <!-- Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>