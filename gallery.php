<?php include 'includes/header.php'; ?>

<!-- Gallery Hero Section -->
<section class="hero-section" style="background-image: url('assets/images/backgrounds/gallery-bg.jpg');">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Our Event <span class="highlight">Gallery</span></h1>
            <p class="hero-subtitle">Browse through our portfolio of successful events we've organized for our clients. From weddings to corporate events, see our work in action.</p>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Event Gallery</h2>
            <p>Filter through our different event categories to find inspiration for your next celebration.</p>
        </div>
        
        <!-- Gallery Filter Buttons -->
        <div class="gallery-filter">
            <button class="filter-btn active" data-filter="all">All Events</button>
            <button class="filter-btn" data-filter="wedding">Weddings</button>
            <button class="filter-btn" data-filter="birthday">Birthdays</button>
            <button class="filter-btn" data-filter="anniversary">Anniversaries</button>
            <button class="filter-btn" data-filter="corporate">Corporate</button>
        </div>
        
        <!-- Gallery Items -->
        <div class="gallery-container">
            <!-- Wedding Gallery Items -->
            <div class="gallery-item" data-category="wedding">
                <img src="assets/images/gallery/galery1.jpg" alt="Luxury Beach Wedding">
                <div class="gallery-overlay">
                    <h3>Luxury Wedding</h3>
                    <p>Beach Destination Wedding</p>
                </div>
            </div>
            
            <div class="gallery-item" data-category="wedding">
                <img src="assets/images/gallery/wedding2.jpg" alt="Traditional Wedding Ceremony" onerror="this.src='assets/images/gallery/galery1.jpg'">
                <div class="gallery-overlay">
                    <h3>Traditional Wedding</h3>
                    <p>Cultural Ceremony</p>
                </div>
            </div>
            
            <div class="gallery-item" data-category="wedding">
                <img src="assets/images/gallery/wedding3.jpg" alt="Garden Wedding" onerror="this.src='assets/images/gallery/galery1.jpg'">
                <div class="gallery-overlay">
                    <h3>Garden Wedding</h3>
                    <p>Outdoor Celebration</p>
                </div>
            </div>
            
            <div class="gallery-item" data-category="wedding">
                <img src="assets/images/gallery/wedding4.jpg" alt="Winter Wedding" onerror="this.src='assets/images/gallery/galery1.jpg'">
                <div class="gallery-overlay">
                    <h3>Winter Wedding</h3>
                    <p>Elegant Indoor Setting</p>
                </div>
            </div>
            
            <!-- Birthday Gallery Items -->
            <div class="gallery-item" data-category="birthday">
                <img src="assets/images/gallery/galery2.jpg" alt="Royal Birthday">
                <div class="gallery-overlay">
                    <h3>Royal Birthday</h3>
                    <p>Themed 30th Birthday</p>
                </div>
            </div>
            
            <div class="gallery-item" data-category="birthday">
                <img src="assets/images/gallery/birthday2.jpg" alt="Kids Birthday Party" onerror="this.src='assets/images/gallery/galery2.jpg'">
                <div class="gallery-overlay">
                    <h3>Kids Birthday</h3>
                    <p>Colorful Adventure Theme</p>
                </div>
            </div>
            
            <div class="gallery-item" data-category="birthday">
                <img src="assets/images/gallery/birthday3.jpg" alt="Sweet 16 Party" onerror="this.src='assets/images/gallery/galery2.jpg'">
                <div class="gallery-overlay">
                    <h3>Sweet 16</h3>
                    <p>Elegant Teen Celebration</p>
                </div>
            </div>
            
            <div class="gallery-item" data-category="birthday">
                <img src="assets/images/gallery/birthday4.jpg" alt="50th Birthday Celebration" onerror="this.src='assets/images/gallery/galery2.jpg'">
                <div class="gallery-overlay">
                    <h3>Golden Jubilee</h3>
                    <p>50th Birthday Celebration</p>
                </div>
            </div>
            
            <!-- Anniversary Gallery Items -->
            <div class="gallery-item" data-category="anniversary">
                <img src="assets/images/gallery/galery3.jpg" alt="Silver Anniversary">
                <div class="gallery-overlay">
                    <h3>Silver Anniversary</h3>
                    <p>25 Years Celebration</p>
                </div>
            </div>
            
            <div class="gallery-item" data-category="anniversary">
                <img src="assets/images/gallery/anniversary2.jpg" alt="Golden Anniversary" onerror="this.src='assets/images/gallery/galery3.jpg'">
                <div class="gallery-overlay">
                    <h3>Golden Anniversary</h3>
                    <p>50 Years of Love</p>
                </div>
            </div>
            
            <div class="gallery-item" data-category="anniversary">
                <img src="assets/images/gallery/anniversary3.jpg" alt="Diamond Anniversary" onerror="this.src='assets/images/gallery/galery3.jpg'">
                <div class="gallery-overlay">
                    <h3>Diamond Anniversary</h3>
                    <p>60 Years Together</p>
                </div>
            </div>
            
            <div class="gallery-item" data-category="anniversary">
                <img src="assets/images/gallery/anniversary4.jpg" alt="First Anniversary" onerror="this.src='assets/images/gallery/galery3.jpg'">
                <div class="gallery-overlay">
                    <h3>First Anniversary</h3>
                    <p>Romantic Celebration</p>
                </div>
            </div>
            
            <!-- Corporate Gallery Items -->
            <div class="gallery-item" data-category="corporate">
                <img src="assets/images/gallery/galery4.jpg" alt="Executive Conference">
                <div class="gallery-overlay">
                    <h3>Executive Conference</h3>
                    <p>Annual Corporate Meeting</p>
                </div>
            </div>
            
            <div class="gallery-item" data-category="corporate">
                <img src="assets/images/gallery/corporate2.jpg" alt="Product Launch" onerror="this.src='assets/images/gallery/galery4.jpg'">
                <div class="gallery-overlay">
                    <h3>Product Launch</h3>
                    <p>Tech Company Showcase</p>
                </div>
            </div>
            
            <div class="gallery-item" data-category="corporate">
                <img src="assets/images/gallery/corporate3.jpg" alt="Team Building Event" onerror="this.src='assets/images/gallery/galery4.jpg'">
                <div class="gallery-overlay">
                    <h3>Team Building</h3>
                    <p>Outdoor Activities</p>
                </div>
            </div>
            
            <div class="gallery-item" data-category="corporate">
                <img src="assets/images/gallery/corporate4.jpg" alt="Award Ceremony" onerror="this.src='assets/images/gallery/galery4.jpg'">
                <div class="gallery-overlay">
                    <h3>Award Ceremony</h3>
                    <p>Employee Recognition Night</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section section-dark">
    <div class="container">
        <div class="section-title">
            <h2>Ready to Plan Your Own Event?</h2>
            <p>Let us help you create memories that will last a lifetime.</p>
        </div>
        <div class="text-center">
            <a href="contact.php" class="btn btn-secondary btn-lg">Contact Us</a>
            <a href="plans.php" class="btn btn-light btn-lg" style="margin-left: 15px;">View Packages</a>
        </div>
    </div>
</section>

<!-- Add JavaScript for gallery filtering -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all filter buttons and gallery items
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    // Add click event to each filter button
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get filter value
            const filterValue = this.getAttribute('data-filter');
            
            // Show/hide gallery items based on filter
            galleryItems.forEach(item => {
                const category = item.getAttribute('data-category');
                
                if (filterValue === 'all' || filterValue === category) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 50);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
    
    // Initialize Lightbox functionality for gallery images
    const galleryOverlays = document.querySelectorAll('.gallery-overlay');
    
    galleryOverlays.forEach(overlay => {
        overlay.addEventListener('click', function() {
            const galleryItem = this.parentElement;
            const img = galleryItem.querySelector('img');
            const title = this.querySelector('h3').textContent;
            const description = this.querySelector('p').textContent;
            
            // Create lightbox elements
            const lightbox = document.createElement('div');
            lightbox.className = 'gallery-lightbox';
            
            lightbox.innerHTML = `
                <div class="lightbox-content">
                    <button class="lightbox-close">&times;</button>
                    <img src="${img.src}" alt="${img.alt}">
                    <div class="lightbox-caption">
                        <h3>${title}</h3>
                        <p>${description}</p>
                    </div>
                </div>
            `;
            
            // Add lightbox to the body
            document.body.appendChild(lightbox);
            
            // Prevent body scrolling
            document.body.style.overflow = 'hidden';
            
            // Add close functionality
            const closeButton = lightbox.querySelector('.lightbox-close');
            
            closeButton.addEventListener('click', function() {
                document.body.removeChild(lightbox);
                document.body.style.overflow = 'auto';
            });
            
            // Close lightbox when clicking outside the image
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) {
                    document.body.removeChild(lightbox);
                    document.body.style.overflow = 'auto';
                }
            });
        });
    });
});
</script>

<!-- Add CSS for Lightbox -->
<style>
.gallery-lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.lightbox-content {
    position: relative;
    max-width: 80%;
    max-height: 80%;
}

.lightbox-content img {
    max-width: 100%;
    max-height: 80vh;
    border: 5px solid var(--light-color);
}

.lightbox-caption {
    background-color: var(--light-color);
    padding: 15px;
    text-align: center;
}

.lightbox-caption h3 {
    color: var(--primary-color);
    margin-bottom: 5px;
}

.lightbox-caption p {
    color: var(--dark-color);
    margin-bottom: 0;
}

.lightbox-close {
    position: absolute;
    top: -40px;
    right: 0;
    font-size: 30px;
    color: var(--light-color);
    background: none;
    border: none;
    cursor: pointer;
}

/* Animation styles for gallery filtering */
.gallery-item {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

/* Responsive adjustments for the filter buttons */
@media (max-width: 576px) {
    .gallery-filter {
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    
    .filter-btn {
        white-space: nowrap;
        margin-right: 10px;
    }
}
</style>

<?php include 'includes/footer.php'; ?> 