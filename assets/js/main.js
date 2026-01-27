/**
 * koellner.life - Main JavaScript
 * Handles navigation, animations, and interactive elements
 */

// ============================================================================
// Mobile Navigation Toggle
// ============================================================================

document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.getElementById('mobileToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            
            // Animate hamburger icon
            const hamburgers = mobileToggle.querySelectorAll('.hamburger');
            if (navMenu.classList.contains('active')) {
                hamburgers[0].style.transform = 'rotate(45deg) translateY(10px)';
                hamburgers[1].style.opacity = '0';
                hamburgers[2].style.transform = 'rotate(-45deg) translateY(-10px)';
            } else {
                hamburgers[0].style.transform = '';
                hamburgers[1].style.opacity = '1';
                hamburgers[2].style.transform = '';
            }
        });
        
        // Close menu when clicking on a link
        const navLinks = navMenu.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navMenu.classList.remove('active');
                const hamburgers = mobileToggle.querySelectorAll('.hamburger');
                hamburgers[0].style.transform = '';
                hamburgers[1].style.opacity = '1';
                hamburgers[2].style.transform = '';
            });
        });
    }
});

// ============================================================================
// Navbar Scroll Effect
// ============================================================================

let lastScroll = 0;
const navbar = document.getElementById('navbar');

window.addEventListener('scroll', function() {
    const currentScroll = window.pageYOffset;
    
    if (navbar) {
        // Add shadow on scroll
        if (currentScroll > 50) {
            navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.3)';
            navbar.style.backgroundColor = 'rgba(10, 10, 15, 0.95)';
        } else {
            navbar.style.boxShadow = '';
            navbar.style.backgroundColor = 'rgba(10, 10, 15, 0.8)';
        }
    }
    
    lastScroll = currentScroll;
});

// ============================================================================
// Project Filter Functionality
// ============================================================================

document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card');
    
    if (filterButtons.length > 0 && projectCards.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get filter value
                const filterValue = this.getAttribute('data-filter');
                
                // Filter projects
                projectCards.forEach(card => {
                    const categories = card.getAttribute('data-category');
                    
                    if (filterValue === 'all' || categories.includes(filterValue)) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeIn 0.6s ease-out';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }
});

// ============================================================================
// Form Validation
// ============================================================================

document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const subject = document.getElementById('subject');
            const message = document.getElementById('message');
            
            let isValid = true;
            
            // Simple validation
            if (name && name.value.trim() === '') {
                isValid = false;
                name.style.borderColor = 'var(--color-accent-error)';
            } else if (name) {
                name.style.borderColor = '';
            }
            
            if (email && !isValidEmail(email.value)) {
                isValid = false;
                email.style.borderColor = 'var(--color-accent-error)';
            } else if (email) {
                email.style.borderColor = '';
            }
            
            if (subject && subject.value.trim() === '') {
                isValid = false;
                subject.style.borderColor = 'var(--color-accent-error)';
            } else if (subject) {
                subject.style.borderColor = '';
            }
            
            if (message && message.value.trim() === '') {
                isValid = false;
                message.style.borderColor = 'var(--color-accent-error)';
            } else if (message) {
                message.style.borderColor = '';
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
        
        // Remove error styling on input
        const inputs = contactForm.querySelectorAll('.form-input, .form-textarea');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                this.style.borderColor = '';
            });
        });
    }
});

// Email validation helper
function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

// ============================================================================
// Smooth Scroll for Anchor Links
// ============================================================================

document.addEventListener('DOMContentLoaded', function() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Only handle internal anchors (not just #)
            if (href !== '#' && href.length > 1) {
                const targetId = href.substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    e.preventDefault();
                    
                    const offsetTop = targetElement.offsetTop - 100; // Account for fixed navbar
                    
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});

// ============================================================================
// Intersection Observer for Fade-in Animations
// ============================================================================

document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animateElements = document.querySelectorAll('.service-card, .project-card, .skill-category, .value-card');
    
    animateElements.forEach(element => {
        observer.observe(element);
    });
});

// ============================================================================
// Copy to Clipboard Functionality (for email)
// ============================================================================

function copyToClipboard(text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() {
            showNotification('E-Mail-Adresse kopiert!');
        }).catch(function(err) {
            console.error('Fehler beim Kopieren:', err);
        });
    } else {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
            showNotification('E-Mail-Adresse kopiert!');
        } catch (err) {
            console.error('Fehler beim Kopieren:', err);
        }
        document.body.removeChild(textarea);
    }
}

// ============================================================================
// Notification System
// ============================================================================

function showNotification(message, duration = 3000) {
    // Check if notification already exists
    let notification = document.getElementById('notification');
    
    if (!notification) {
        notification = document.createElement('div');
        notification.id = 'notification';
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 16px 24px;
            background: var(--gradient-primary);
            color: white;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-xl);
            z-index: 10000;
            font-size: var(--font-size-sm);
            font-weight: 500;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
        `;
        document.body.appendChild(notification);
    }
    
    notification.textContent = message;
    
    // Show notification
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateY(0)';
    }, 10);
    
    // Hide notification
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, duration);
}

// ============================================================================
// Performance: Lazy Loading Images
// ============================================================================

document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
});

// ============================================================================
// Utility: Debounce Function
// ============================================================================

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ============================================================================
// Console Info (Easter Egg)
// ============================================================================

console.log('%c👋 Hallo!', 'font-size: 24px; font-weight: bold; color: #6366f1;');
console.log('%cInteressiert an der Technik hinter dieser Website?', 'font-size: 14px; color: #a8a9b4;');
console.log('%cKontaktiere mich für ein Gespräch über dein nächstes Projekt!', 'font-size: 14px; color: #a8a9b4;');
console.log('%c🚀 koellner.life', 'font-size: 16px; font-weight: bold; background: linear-gradient(135deg, #6366f1, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;');
