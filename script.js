// Mobile Navigation Toggle
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');
const navLinks = document.querySelectorAll('.nav-link');

// Toggle mobile menu
if (hamburger) {
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    });
}

// Close mobile menu when a link is clicked
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        hamburger.classList.remove('active');
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

// Navbar scroll effect
let lastScroll = 0;
const navbar = document.querySelector('.navbar');

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    
    // Add shadow on scroll
    if (currentScroll > 50) {
        navbar.style.boxShadow = '0 10px 40px rgba(31, 38, 135, 0.2)';
    } else {
        navbar.style.boxShadow = '0 8px 32px 0 rgba(31, 38, 135, 0.15)';
    }
    
    lastScroll = currentScroll;
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
            
            console.log('Form submitted:', data);
        }, 1500);
    });
}

// Add parallax effect to hero section
const hero = document.querySelector('.hero');
const gradientOrbs = document.querySelectorAll('.gradient-orb');

window.addEventListener('scroll', () => {
    if (hero && window.pageYOffset < window.innerHeight) {
        const scrolled = window.pageYOffset;
        gradientOrbs.forEach((orb, index) => {
            const speed = 0.5 + (index * 0.2);
            orb.style.transform = `translate(${scrolled * speed * 0.1}px, ${scrolled * speed * 0.1}px)`;
        });
    }
});

// Add active state to nav links based on scroll position
const sections = document.querySelectorAll('section[id]');

window.addEventListener('scroll', () => {
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
});

// Add cursor trail effect (optional, subtle enhancement)
let cursorTrail = [];
const maxTrailLength = 10;

document.addEventListener('mousemove', (e) => {
    if (window.innerWidth > 768) { // Only on desktop
        cursorTrail.push({ x: e.clientX, y: e.clientY, time: Date.now() });
        
        if (cursorTrail.length > maxTrailLength) {
            cursorTrail.shift();
        }
    }
});

// Performance optimization: Debounce resize events
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        // Handle resize events here if needed
        console.log('Window resized');
    }, 250);
});

// Add loading animation
window.addEventListener('load', () => {
    document.body.style.opacity = '0';
    setTimeout(() => {
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '1';
    }, 100);
});
