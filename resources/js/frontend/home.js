// Animasi hitung statistik
const animateCounter = (element) => {
    const target = parseInt(element.getAttribute('data-count'));
    const duration = 2000; // 2 seconds
    const step = target / (duration / 16); // 60fps
    let current = 0;

    const updateCounter = () => {
        current += step;
        if (current < target) {
            element.textContent = Math.floor(current) + '+';
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target + '+';
        }
    };

    updateCounter();
};

// Intersection Observer untuk animasi hitung
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                if (!counter.classList.contains('animated')) {
                    counter.classList.add('animated');
                    animateCounter(counter);
                }
            });
        }
    });
}, { threshold: 0.5 });

// Statisik section
const statsSection = document.querySelector('.stats-section');
if (statsSection) {
    statsObserver.observe(statsSection);
}

// AOS
const initAOS = () => {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('aos-animate');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('[data-aos]').forEach(el => {
        observer.observe(el);
    });
};

// Initialize AOS
initAOS();

// Hero corosel auto heigh
const adjustCarouselHeight = () => {
    const carousel = document.querySelector('#heroCarousel');
    if (carousel) {
        const activeItem = carousel.querySelector('.carousel-item.active .hero-section');
        if (activeItem) {
            // pastikan height minmun
            activeItem.style.minHeight = window.innerHeight + 'px';
        }
    }
};
// menyesuaikan saat memuat dan mengubah ukuran
window.addEventListener('load', adjustCarouselHeight);
window.addEventListener('resize', adjustCarouselHeight);

// Efek card hover
const initCardEffects = () => {
    const cards = document.querySelectorAll('.layanan-card, .armada-card,');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
        });
        
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            
            // Menerapkan efek 3d halus agar hover tidak rusak
            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
        });
    });
};

// Inisialisasi card efek after DOM loaded
document.addEventListener('DOMContentLoaded', initCardEffects);

// Paralax efek untuk hero
const initParallax = () => {
    const heroSections = document.querySelectorAll('.hero-section');
    
    window.addEventListener('scroll', () => {
        heroSections.forEach(hero => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * 0.5;
            hero.style.transform = `translate3d(0, ${rate}px, 0)`;
        });
    });
};

// Inisialisasi parallax
initParallax();

// TESTIMONIAL
// const staggerAnimation = () => {
//     const testimonialCards = document.querySelectorAll('.testimonial-card');
    
//     testimonialCards.forEach((card, index) => {
//         card.style.animationDelay = `${index * 0.1}s`;
//     });
// };

// Initialize stagger animation
staggerAnimation();

// card layanan reveal saat di scroll
const revealOnScroll = () => {
    const layananCards = document.querySelectorAll('.layanan-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    layananCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease-out';
        observer.observe(card);
    });
};

// Inisialisasi reveal animation
revealOnScroll();

// Smooth carosel animasi
const carousel = document.querySelector('#heroCarousel');
if (carousel) {
    carousel.addEventListener('slide.bs.carousel', function (e) {
        const activeItem = e.relatedTarget;
        activeItem.querySelector('.hero-content').style.animation = 'none';
        
        setTimeout(() => {
            activeItem.querySelector('.hero-content').style.animation = '';
        }, 10);
    });
}

// Typing efek untuk hero section
const typingEffect = (element, text, speed = 100) => {
    let i = 0;
    element.textContent = '';
    
    const type = () => {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    };
    
    type();
};

// Floating animasi untuk CTA
const floatAnimation = () => {
    const ctaIcon = document.querySelector('.cta-icon');
    if (ctaIcon) {
        let position = 0;
        let direction = 1;
        
        setInterval(() => {
            position += direction * 0.5;
            if (position > 10 || position < -10) {
                direction *= -1;
            }
            ctaIcon.style.transform = `translateY(${position}px)`;
        }, 50);
    }
};

// Inisialisasi floating animation
floatAnimation();

// Image lazy fade in
const lazyLoadImages = () => {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.style.opacity = '0';
                
                img.onload = () => {
                    img.style.transition = 'opacity 0.5s ease-in';
                    img.style.opacity = '1';
                };
                
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
};

// Inisialisasi lazy loading
lazyLoadImages();

// Button ripple efek
const addRippleEffect = () => {
    const buttons = document.querySelectorAll('.btn');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });
    
    // Add ripple CSS
    const style = document.createElement('style');
    style.textContent = `
        .btn {
            position: relative;
            overflow: hidden;
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
};

// Inisialisasi ripple effect
addRippleEffect();

// Optimasisasi performa
// Fungsi debounce untuk event scroll
const debounce = (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

// Optimize scroll events
const optimizedScroll = debounce(() => {
    // Add any scroll-based animations here
}, 10);

window.addEventListener('scroll', optimizedScroll);

console.log('Home.js loaded successfully! All animations initialized.');