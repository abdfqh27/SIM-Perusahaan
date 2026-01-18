document.addEventListener('DOMContentLoaded', function() {
    // FUNGSI TOGGLE SIDEBAR
    
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const adminSidebar = document.getElementById('adminSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const adminWrapper = document.getElementById('adminWrapper');

    // Toggle sidebar saat tombol diklik (untuk desktop)
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            // Cek apakah mode desktop atau mobile
            if (window.innerWidth >= 992) {
                // Desktop: toggle class sidebar-hidden
                adminWrapper.classList.toggle('sidebar-hidden');
                
                // Simpan status sidebar ke localStorage
                if (adminWrapper.classList.contains('sidebar-hidden')) {
                    localStorage.setItem('adminSidebarState', 'hidden');
                } else {
                    localStorage.setItem('adminSidebarState', 'visible');
                }
            } else {
                // Mobile: tampilkan sidebar dan overlay
                adminSidebar.classList.add('active');
                sidebarOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    }

    // Menutup sidebar pada mode mobile
    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeMobileSidebar);
    }

    // Menutup sidebar saat overlay diklik
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeMobileSidebar);
    }

    // Fungsi untuk menutup sidebar pada mode mobile
    function closeMobileSidebar() {
        adminSidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Memuat status sidebar dari localStorage saat halaman dimuat (khusus desktop)
    if (window.innerWidth >= 992) {
        const savedState = localStorage.getItem('adminSidebarState');
        if (savedState === 'hidden') {
            adminWrapper.classList.add('sidebar-hidden');
        }
    }

    // Menangani perubahan ukuran layar
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth >= 992) {
                // Mode desktop
                closeMobileSidebar();
                
                // Kembalikan status sidebar desktop
                const savedState = localStorage.getItem('adminSidebarState');
                if (savedState === 'hidden') {
                    adminWrapper.classList.add('sidebar-hidden');
                } else {
                    adminWrapper.classList.remove('sidebar-hidden');
                }
            } else {
                // Mode mobile
                adminWrapper.classList.remove('sidebar-hidden');
            }
        }, 250);
    });

    // ALERT OTOMATIS HILANG
    
    const alerts = document.querySelectorAll('.custom-alert');
    if (alerts.length > 0) {
        alerts.forEach(function(alert) {
            // Menutup alert otomatis setelah 5 detik
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    }

    // SMOOTH SCROLLING
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // INISIALISASI TOOLTIP
    
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // DIALOG KONFIRMASI
    
    const deleteButtons = document.querySelectorAll('.btn-delete, [data-confirm]');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm') || 
                          'Apakah Anda yakin ingin menghapus data ini?';
            
            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
        });
    });

    // PENINGKATAN VALIDASI FORM
    
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // PREVIEW GAMBAR
    
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(function(input) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    // Cari elemen preview gambar
                    const previewId = input.getAttribute('data-preview');
                    if (previewId) {
                        const preview = document.getElementById(previewId);
                        if (preview) {
                            preview.src = event.target.result;
                            preview.style.display = 'block';
                        }
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // STATUS LOADING PADA TOMBOL SUBMIT
    
    const submitButtons = document.querySelectorAll('button[type="submit"]');
    submitButtons.forEach(function(button) {
        const form = button.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                button.disabled = true;
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                
                // Aktifkan kembali tombol setelah 3 detik (pengaman)
                setTimeout(function() {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }, 3000);
            });
        }
    });

    // PENINGKATAN TABEL
    
    // Menambahkan efek klik pada baris tabel yang memiliki data-href
    const clickableRows = document.querySelectorAll('tr[data-href]');
    clickableRows.forEach(function(row) {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function() {
            window.location.href = this.getAttribute('data-href');
        });
    });

    // FUNGSI PENCARIAN
    
    const searchInputs = document.querySelectorAll('[data-search]');
    searchInputs.forEach(function(input) {
        input.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const targetSelector = this.getAttribute('data-search');
            const items = document.querySelectorAll(targetSelector);
            
            items.forEach(function(item) {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    });

    // ANIMASI COUNTER
    
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-count'));
        const duration = 1000;
        const step = target / (duration / 16);
        let current = 0;

        const timer = setInterval(function() {
            current += step;
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 16);
    }

    const counters = document.querySelectorAll('[data-count]');
    counters.forEach(animateCounter);

    // PENANDAAN MENU AKTIF
    
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.menu-item');
    
    menuItems.forEach(function(item) {
        const href = item.getAttribute('href');
        if (href && currentPath.includes(href.split('?')[0])) {
            item.classList.add('active');
        }
    });

    // FUNGSI CETAK
    
    const printButtons = document.querySelectorAll('[data-print]');
    printButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            window.print();
        });
    });

    // SALIN KE CLIPBOARD
    
    const copyButtons = document.querySelectorAll('[data-copy]');
    copyButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-copy');
            const target = document.getElementById(targetId);
            
            if (target) {
                const text = target.textContent || target.value;
                navigator.clipboard.writeText(text).then(function() {
                    // Menampilkan pesan berhasil disalin
                    const originalText = button.textContent;
                    button.textContent = 'Tersalin!';
                    setTimeout(function() {
                        button.textContent = originalText;
                    }, 2000);
                });
            }
        });
    });

    // INFORMASI DI CONSOLE
    
    console.log('%c Admin Panel Berhasil Dimuat! ', 
                'background: linear-gradient(135deg, #FB8500, #FFB703); color: white; padding: 10px; font-size: 14px; font-weight: bold;');
    console.log('%c Dikembangkan dengan ❤️ ', 
                'color: #023047; font-size: 12px;');
});