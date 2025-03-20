// RoyalEvent - Main JavaScript file

// Document Ready Function
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            
            // Animate the hamburger to X
            const bars = this.querySelectorAll('.bar');
            bars.forEach(bar => bar.classList.toggle('active'));
        });
    }
    
    // Back to Top Button
    const backToTopButton = document.getElementById('backToTop');
    
    if (backToTopButton) {
        // Show/hide back to top button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        
        // Scroll to top when button is clicked
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Gallery Filter
    const galleryFilterButtons = document.querySelectorAll('.gallery-filter button');
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    if (galleryFilterButtons.length > 0 && galleryItems.length > 0) {
        galleryFilterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                galleryFilterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                
                galleryItems.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');
                    
                    if (filter === 'all' || filter === itemCategory) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }
    
    // Pricing Tabs
    const pricingTabs = document.querySelectorAll('.pricing-tab');
    const pricingContainers = document.querySelectorAll('.pricing-content');
    
    if (pricingTabs.length > 0 && pricingContainers.length > 0) {
        pricingTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                pricingTabs.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                const tabTarget = this.getAttribute('data-target');
                
                pricingContainers.forEach(container => {
                    if (container.id === tabTarget) {
                        container.style.display = 'block';
                    } else {
                        container.style.display = 'none';
                    }
                });
            });
        });
    }
    
    // Form Validation
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        if (form.classList.contains('needs-validation')) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
        }
    });
    
    // Booking Form: Update price when event type or plan changes
    const eventTypeSelect = document.getElementById('event_type');
    const planSelect = document.getElementById('plan');
    const priceDisplay = document.getElementById('price_display');
    const priceInput = document.getElementById('price');
    
    if (eventTypeSelect && planSelect && priceDisplay && priceInput) {
        const updatePrice = function() {
            const eventType = eventTypeSelect.value;
            const plan = planSelect.value;
            
            if (eventType && plan) {
                // Make AJAX request to get price
                fetch(`get_price.php?event_type=${eventType}&plan=${plan}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            priceDisplay.textContent = '$' + data.price;
                            priceInput.value = data.price;
                        }
                    })
                    .catch(error => console.error('Error fetching price:', error));
            }
        };
        
        eventTypeSelect.addEventListener('change', updatePrice);
        planSelect.addEventListener('change', updatePrice);
    }
    
    // Simple Date Picker Enhancement
    const dateInputs = document.querySelectorAll('input[type="date"]');
    
    dateInputs.forEach(input => {
        // Set min date to today
        const today = new Date();
        const year = today.getFullYear();
        let month = today.getMonth() + 1;
        let day = today.getDate();
        
        month = month < 10 ? '0' + month : month;
        day = day < 10 ? '0' + day : day;
        
        input.min = `${year}-${month}-${day}`;
    });
    
    // Simple Tab System for Dashboard
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');
    
    if (tabLinks.length > 0 && tabContents.length > 0) {
        tabLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links
                tabLinks.forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                const tabTarget = this.getAttribute('href').replace('#', '');
                
                tabContents.forEach(content => {
                    if (content.id === tabTarget) {
                        content.style.display = 'block';
                    } else {
                        content.style.display = 'none';
                    }
                });
            });
        });
    }
    
    // Flash Message Auto Hide
    const flashMessages = document.querySelectorAll('.alert');
    
    flashMessages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => {
                message.style.display = 'none';
            }, 500);
        }, 5000);
    });
    
    // Show/Hide Password Toggle
    const passwordToggleBtns = document.querySelectorAll('.password-toggle');
    
    passwordToggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const passwordInput = document.querySelector(this.getAttribute('data-target'));
            
            if (passwordInput) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    passwordInput.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            }
        });
    });
}); 