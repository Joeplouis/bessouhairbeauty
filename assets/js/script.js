// Bessou Hair Beauty - Interactive JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Mobile Navigation
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            hamburger.classList.toggle('active');
        });

        // Close menu when clicking on a link
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');
            });
        });
    }

    // Smooth Scrolling for Navigation Links
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

    // Contact Form Handler
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Simple validation
            if (!data.name || !data.email || !data.service) {
                showNotification('Please fill in all required fields.', 'error');
                return;
            }
            
            if (!isValidEmail(data.email)) {
                showNotification('Please enter a valid email address.', 'error');
                return;
            }
            
            // Simulate form submission
            showNotification('Thank you! We\'ll contact you soon to confirm your appointment.', 'success');
            this.reset();
        });
    }

    // Price Management System
    const prices = {
        'box-braids': 120,
        'fulani-braids': 150,
        'goddess-braids': 100,
        'cornrows': 80,
        'knotless-braids': 140,
        'tribal-braids': 110,
        'feed-in-braids': 90,
        'senegalese-twists': 130,
        'passion-twists': 125,
        'braided-buns': 85,
        'boho-braids': 135,
        'micro-braids': 200,
        'ghana-braids': 95,
        'lemonade-braids': 115,
        'faux-locs': 180
    };

    // Function to update prices
    function updatePrices() {
        for (const [service, price] of Object.entries(prices)) {
            const priceElement = document.getElementById(`${service}-price`);
            if (priceElement) {
                priceElement.textContent = `$${price}`;
            }
        }
    }

    // Initialize prices
    updatePrices();

    // Contact Information Management
    const contactInfo = {
        address: '123 Beauty Street, Hair City, HC 12345',
        phone: '+1 (234) 567-8900',
        email: 'hello@bessouhairbeauty.com',
        hours: 'Monday - Saturday: 9:00 AM - 7:00 PM<br>Sunday: 10:00 AM - 5:00 PM'
    };

    // Function to update contact information
    function updateContactInfo() {
        // Update salon info in contact section
        const addressElement = document.getElementById('salon-address');
        const phoneElement = document.getElementById('salon-phone');
        const emailElement = document.getElementById('salon-email');
        const hoursElement = document.getElementById('salon-hours');

        if (addressElement) addressElement.innerHTML = contactInfo.address;
        if (phoneElement) phoneElement.textContent = contactInfo.phone;
        if (emailElement) emailElement.textContent = contactInfo.email;
        if (hoursElement) hoursElement.innerHTML = contactInfo.hours;

        // Update footer info
        const footerAddress = document.getElementById('footer-address');
        const footerPhone = document.getElementById('footer-phone');
        const footerEmail = document.getElementById('footer-email');

        if (footerAddress) footerAddress.textContent = contactInfo.address.split(',').slice(0, 2).join(',');
        if (footerPhone) footerPhone.textContent = contactInfo.phone;
        if (footerEmail) footerEmail.textContent = contactInfo.email;
    }

    // Initialize contact info
    updateContactInfo();

    // Gallery Image Lazy Loading
    const galleryImages = document.querySelectorAll('.gallery-item img');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });

    galleryImages.forEach(img => {
        imageObserver.observe(img);
    });

    // Service Card Animations
    const serviceCards = document.querySelectorAll('.service-card');
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = `${Array.from(serviceCards).indexOf(entry.target) * 0.1}s`;
                entry.target.classList.add('animate-in');
            }
        });
    });

    serviceCards.forEach(card => {
        cardObserver.observe(card);
    });

    // Booking Calendar Integration
    function initializeBookingCalendar() {
        // This would integrate with Google Calendar API
        // For now, we'll just ensure the iframe loads properly
        const calendarEmbed = document.getElementById('google-calendar-embed');
        if (calendarEmbed) {
            console.log('Booking calendar loaded');
        }
    }

    initializeBookingCalendar();

    // Booking Terms Modal (if needed)
    function showBookingTerms() {
        const terms = `
            <div class="modal-content">
                <h3>Booking Terms & Conditions</h3>
                <ul>
                    <li><strong>$30 Deposit:</strong> Required to secure your appointment</li>
                    <li><strong>Late Policy:</strong> If you're more than 1 hour late, your deposit is non-refundable and not deducted from the service price</li>
                    <li><strong>No-Show Policy:</strong> The $30 deposit will be deducted from your total service price for future appointments</li>
                    <li><strong>On-Time Arrival:</strong> Your deposit will be deducted from your total service cost</li>
                </ul>
            </div>
        `;
        return terms;
    }

    // Admin Functions for Easy Updates
    window.BessouAdmin = {
        updatePrice: function(serviceId, newPrice) {
            if (prices[serviceId]) {
                prices[serviceId] = newPrice;
                const priceElement = document.getElementById(`${serviceId}-price`);
                if (priceElement) {
                    priceElement.textContent = `$${newPrice}`;
                }
                showNotification(`Price updated for ${serviceId}`, 'success');
            }
        },
        
        updateContact: function(field, value) {
            if (contactInfo[field]) {
                contactInfo[field] = value;
                updateContactInfo();
                showNotification(`Contact ${field} updated`, 'success');
            }
        },
        
        getPrices: function() {
            return prices;
        },
        
        getContactInfo: function() {
            return contactInfo;
        }
    };

    // Header scroll effect
    const header = document.querySelector('.header');
    let lastScrollTop = 0;

    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > lastScrollTop) {
            // Scrolling down
            header.style.transform = 'translateY(-100%)';
        } else {
            // Scrolling up
            header.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;

        // Add shadow when scrolled
        if (scrollTop > 0) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Service search functionality
    function initializeServiceSearch() {
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.placeholder = 'Search services...';
        searchInput.className = 'service-search';
        
        const servicesHeader = document.querySelector('.services .section-header');
        if (servicesHeader) {
            servicesHeader.appendChild(searchInput);
            
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const serviceCards = document.querySelectorAll('.service-card');
                
                serviceCards.forEach(card => {
                    const serviceName = card.querySelector('h3').textContent.toLowerCase();
                    const serviceDesc = card.querySelector('p').textContent.toLowerCase();
                    
                    if (serviceName.includes(searchTerm) || serviceDesc.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    }

    // Initialize service search
    initializeServiceSearch();
});

// Utility Functions
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Style the notification
    Object.assign(notification.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        padding: '15px 20px',
        borderRadius: '8px',
        color: 'white',
        zIndex: '10000',
        fontSize: '14px',
        maxWidth: '300px',
        boxShadow: '0 4px 15px rgba(0,0,0,0.2)',
        transform: 'translateX(100%)',
        transition: 'transform 0.3s ease-in-out'
    });
    
    // Set background color based on type
    switch(type) {
        case 'success':
            notification.style.background = '#2ecc71';
            break;
        case 'error':
            notification.style.background = '#e74c3c';
            break;
        case 'warning':
            notification.style.background = '#f39c12';
            break;
        default:
            notification.style.background = '#3498db';
    }
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after 5 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
}

// Intersection Observer for scroll animations
function initScrollAnimations() {
    const animateElements = document.querySelectorAll('.service-card, .gallery-item, .feature, .term-item');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    animateElements.forEach(el => {
        observer.observe(el);
    });
}

// Initialize scroll animations when DOM is loaded
document.addEventListener('DOMContentLoaded', initScrollAnimations);

// Google Calendar Booking Integration
function openGoogleCalendarBooking() {
    // This would open Google Calendar booking in a new window
    const calendarUrl = 'https://calendar.google.com/calendar/appointments/schedules';
    window.open(calendarUrl, '_blank', 'width=800,height=600');
}

// WhatsApp integration for quick booking
function openWhatsAppBooking(service = '') {
    const phoneNumber = '1234567890'; // Replace with actual WhatsApp business number
    const message = `Hi! I'd like to book an appointment for ${service || 'hair braiding'}. Can you help me with available times?`;
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}

// Add WhatsApp button to services
document.addEventListener('DOMContentLoaded', function() {
    const serviceCards = document.querySelectorAll('.service-card');
    serviceCards.forEach(card => {
        const serviceName = card.querySelector('h3').textContent;
        const whatsappBtn = document.createElement('button');
        whatsappBtn.innerHTML = '<i class="fab fa-whatsapp"></i> Book via WhatsApp';
        whatsappBtn.className = 'btn-whatsapp';
        whatsappBtn.style.cssText = `
            background: #25d366;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
            font-size: 0.9rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        `;
        whatsappBtn.onclick = () => openWhatsAppBooking(serviceName);
        card.querySelector('.service-content').appendChild(whatsappBtn);
    });
});
