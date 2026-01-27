// Mobile Navigation Toggle
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');
const navLinks = document.querySelectorAll('.nav-link');

// Toggle mobile menu
if (hamburger) {
    hamburger.addEventListener('click', () => {
        const isExpanded = hamburger.getAttribute('aria-expanded') === 'true';
        hamburger.setAttribute('aria-expanded', !isExpanded);
        hamburger.setAttribute('aria-label', isExpanded ? 'Menü öffnen' : 'Menü schließen');
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    });
}

// Close mobile menu when a link is clicked
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        if (hamburger) {
            hamburger.classList.remove('active');
            hamburger.setAttribute('aria-expanded', 'false');
            hamburger.setAttribute('aria-label', 'Menü öffnen');
        }
        navMenu.classList.remove('active');
    });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const offset = 80; // Height of fixed navbar
            const targetPosition = target.offsetTop - offset;
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Navbar scroll effect with throttling
const navbar = document.querySelector('.navbar');
let ticking = false;

window.addEventListener('scroll', () => {
    if (!ticking) {
        window.requestAnimationFrame(() => {
            const currentScroll = window.pageYOffset;
            
            // Add shadow on scroll
            if (currentScroll > 50) {
                navbar.style.boxShadow = '0 10px 40px rgba(31, 38, 135, 0.2)';
            } else {
                navbar.style.boxShadow = '0 8px 32px 0 rgba(31, 38, 135, 0.15)';
            }
            
            ticking = false;
        });
        ticking = true;
    }
});

// Intersection Observer for scroll animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe elements for animation
document.addEventListener('DOMContentLoaded', () => {
    // Animate cards and sections
    const animatedElements = document.querySelectorAll('.glass-card, .service-card, .section-header');
    
    animatedElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(el);
    });
});

// Contact form handling
const contactForm = document.querySelector('.contact-form');

if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(contactForm);
        const data = Object.fromEntries(formData);
        
        // Simple validation
        if (!data.name || !data.email || !data.message) {
            alert('Bitte füllen Sie alle Felder aus.');
            return;
        }
        
        // Email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(data.email)) {
            alert('Bitte geben Sie eine gültige E-Mail-Adresse ein.');
            return;
        }
        
        // Simulate form submission (replace with actual backend integration)
        const submitButton = contactForm.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'Wird gesendet...';
        submitButton.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            submitButton.textContent = 'Nachricht gesendet! ✓';
            submitButton.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            
            // Reset form
            contactForm.reset();
            
            // Reset button after 3 seconds
            setTimeout(() => {
                submitButton.textContent = originalText;
                submitButton.style.background = '';
                submitButton.disabled = false;
            }, 3000);
        }, 1500);
    });
}

// Add parallax effect to hero section
const hero = document.querySelector('.hero');
const gradientOrbs = document.querySelectorAll('.gradient-orb');
let parallaxTicking = false;

window.addEventListener('scroll', () => {
    if (!parallaxTicking && hero && window.pageYOffset < window.innerHeight) {
        window.requestAnimationFrame(() => {
            const scrolled = window.pageYOffset;
            gradientOrbs.forEach((orb, index) => {
                const speed = 0.5 + (index * 0.2);
                const translateX = scrolled * speed * 0.1;
                const translateY = scrolled * speed * 0.1;
                
                // Preserve the original transform for orb-3
                if (index === 2) {
                    orb.style.transform = `translate(calc(-50% + ${translateX}px), calc(-50% + ${translateY}px))`;
                } else {
                    orb.style.transform = `translate(${translateX}px, ${translateY}px)`;
                }
            });
            parallaxTicking = false;
        });
        parallaxTicking = true;
    }
});

// Add active state to nav links based on scroll position
const sections = document.querySelectorAll('section[id]');
let navTicking = false;

window.addEventListener('scroll', () => {
    if (!navTicking) {
        window.requestAnimationFrame(() => {
            const scrollY = window.pageYOffset;
            
            sections.forEach(current => {
                const sectionHeight = current.offsetHeight;
                const sectionTop = current.offsetTop - 100;
                const sectionId = current.getAttribute('id');
                const correspondingLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);
                
                if (correspondingLink) {
                    if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                        correspondingLink.style.color = 'var(--primary-color)';
                    } else {
                        correspondingLink.style.color = '';
                    }
                }
            });
            navTicking = false;
        });
        navTicking = true;
    }
});

// Performance optimization: Debounce resize events
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        // Resize particles canvas if exists
        if (particlesCanvas) {
            initParticles();
        }
    }, 250);
});

// Smooth page load
document.body.style.opacity = '1';

// AI Particles Animation
const particlesCanvas = document.getElementById('ai-particles');
let particles = [];
let particlesCtx;

if (particlesCanvas) {
    particlesCtx = particlesCanvas.getContext('2d');
    
    function initParticles() {
        particlesCanvas.width = window.innerWidth;
        particlesCanvas.height = window.innerHeight;
        particles = [];
        
        // Create particles
        const particleCount = Math.min(50, Math.floor(window.innerWidth / 20));
        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: Math.random() * particlesCanvas.width,
                y: Math.random() * particlesCanvas.height,
                size: Math.random() * 2 + 1,
                speedX: (Math.random() - 0.5) * 0.5,
                speedY: (Math.random() - 0.5) * 0.5,
                color: `hsla(${180 + Math.random() * 60}, 100%, ${50 + Math.random() * 30}%, ${0.3 + Math.random() * 0.4})`
            });
        }
    }
    
    function animateParticles() {
        particlesCtx.clearRect(0, 0, particlesCanvas.width, particlesCanvas.height);
        
        particles.forEach((particle, i) => {
            // Update position
            particle.x += particle.speedX;
            particle.y += particle.speedY;
            
            // Wrap around screen
            if (particle.x < 0) particle.x = particlesCanvas.width;
            if (particle.x > particlesCanvas.width) particle.x = 0;
            if (particle.y < 0) particle.y = particlesCanvas.height;
            if (particle.y > particlesCanvas.height) particle.y = 0;
            
            // Draw particle
            particlesCtx.beginPath();
            particlesCtx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            particlesCtx.fillStyle = particle.color;
            particlesCtx.fill();
            
            // Draw connections
            particles.forEach((otherParticle, j) => {
                if (i !== j) {
                    const dx = particle.x - otherParticle.x;
                    const dy = particle.y - otherParticle.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);
                    
                    if (distance < 150) {
                        particlesCtx.beginPath();
                        particlesCtx.moveTo(particle.x, particle.y);
                        particlesCtx.lineTo(otherParticle.x, otherParticle.y);
                        particlesCtx.strokeStyle = `rgba(0, 212, 255, ${0.2 * (1 - distance / 150)})`;
                        particlesCtx.lineWidth = 0.5;
                        particlesCtx.stroke();
                    }
                }
            });
        });
        
        requestAnimationFrame(animateParticles);
    }
    
    initParticles();
    animateParticles();
}
