<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('assets/images/backgrounds/hero-bg.jpg');">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Make Your Events <span class="highlight">Royal</span></h1>
            <p class="hero-subtitle">We create unforgettable experiences for weddings, birthdays, anniversaries, and corporate events. Let us turn your dreams into reality with our expert planning and execution.</p>
            <div class="hero-buttons">
                <a href="plans.php" class="btn btn-secondary btn-lg">View Our Packages</a>
                <a href="contact.php" class="btn btn-light btn-lg">Get In Touch</a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Our Event Services</h2>
            <p>We specialize in creating memorable events tailored to your specific needs and budget.</p>
        </div>
        <div class="services-container">
            <!-- Wedding Service -->
            <div class="service-card">
                <div class="service-img">
                    <img src="assets/images/events/wedding.jpg" alt="Wedding Event">
                </div>
                <div class="service-content">
                    <h3 class="service-title">Wedding Planning</h3>
                    <p class="service-desc">Your dream wedding planned to perfection. From intimate ceremonies to grand celebrations, we handle every detail.</p>
                    <a href="plans.php?type=Wedding" class="btn btn-primary">View Packages</a>
                </div>
            </div>
            
            <!-- Birthday Service -->
            <div class="service-card">
                <div class="service-img">
                    <img src="assets/images/events/birthday.jpg" alt="Birthday Event">
                </div>
                <div class="service-content">
                    <h3 class="service-title">Birthday Celebrations</h3>
                    <p class="service-desc">Make your birthday special with our custom-designed parties. From kids to adults, we create joyful memories.</p>
                    <a href="plans.php?type=Birthday" class="btn btn-primary">View Packages</a>
                </div>
            </div>
            
            <!-- Anniversary Service -->
            <div class="service-card">
                <div class="service-img">
                    <img src="assets/images/events/anniversary.jpeg" alt="Anniversary Event">
                </div>
                <div class="service-content">
                    <h3 class="service-title">Anniversary Events</h3>
                    <p class="service-desc">Celebrate your milestone anniversaries with elegance and style. Romantic settings for your special day.</p>
                    <a href="plans.php?type=Anniversary" class="btn btn-primary">View Packages</a>
                </div>
            </div>
            
            <!-- Corporate Service -->
            <div class="service-card">
                <div class="service-img">
                    <img src="assets/images/events/corporate.jpg" alt="Corporate Event">
                </div>
                <div class="service-content">
                    <h3 class="service-title">Corporate Functions</h3>
                    <p class="service-desc">Professional event management for business meetings, conferences, team buildings, and company celebrations.</p>
                    <a href="plans.php?type=Corporate Event" class="btn btn-primary">View Packages</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section section-dark">
    <div class="container">
        <div class="section-title">
            <h2>Why Choose RoyalEvent?</h2>
            <p>We are dedicated to creating unforgettable experiences that exceed your expectations.</p>
        </div>
        <div class="services-container">
            <!-- Feature 1 -->
            <div class="service-card">
                <div class="service-content text-center">
                    <i class="fas fa-crown" style="font-size: 3rem; color: var(--secondary-color); margin-bottom: 15px;"></i>
                    <h3 class="service-title">Premium Experience</h3>
                    <p class="service-desc">We believe every event deserves royal treatment with attention to the finest details to create a luxurious experience.</p>
                </div>
            </div>
            
            <!-- Feature 2 -->
            <div class="service-card">
                <div class="service-content text-center">
                    <i class="fas fa-gem" style="font-size: 3rem; color: var(--secondary-color); margin-bottom: 15px;"></i>
                    <h3 class="service-title">Customized Planning</h3>
                    <p class="service-desc">Every event is unique. We work closely with you to understand your vision and bring it to life exactly as you imagine.</p>
                </div>
            </div>
            
            <!-- Feature 3 -->
            <div class="service-card">
                <div class="service-content text-center">
                    <i class="fas fa-heart" style="font-size: 3rem; color: var(--secondary-color); margin-bottom: 15px;"></i>
                    <h3 class="service-title">Passionate Team</h3>
                    <p class="service-desc">Our experienced event planners are passionate about creating memorable moments and ensuring your total satisfaction.</p>
                </div>
            </div>
            
            <!-- Feature 4 -->
            <div class="service-card">
                <div class="service-content text-center">
                    <i class="fas fa-star" style="font-size: 3rem; color: var(--secondary-color); margin-bottom: 15px;"></i>
                    <h3 class="service-title">5-Star Service</h3>
                    <p class="service-desc">With hundreds of successful events and satisfied clients, we pride ourselves on our reputation for excellence.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Preview Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Event Gallery</h2>
            <p>Take a glimpse at some of our most memorable events we've organized for our clients.</p>
        </div>
        <div class="gallery-container">
            <!-- Gallery Item 1 -->
            <div class="gallery-item" data-category="wedding">
                <img src="assets/images/gallery/galery1.jpg" alt="Wedding Gallery">
                <div class="gallery-overlay">
                    <h3>Luxury Wedding</h3>
                    <p>Beach Destination Wedding</p>
                </div>
            </div>
            
            <!-- Gallery Item 2 -->
            <div class="gallery-item" data-category="birthday">
                <img src="assets/images/gallery/galery2.jpg" alt="Birthday Gallery">
                <div class="gallery-overlay">
                    <h3>Royal Birthday</h3>
                    <p>Themed 30th Birthday</p>
                </div>
            </div>
            
            <!-- Gallery Item 3 -->
            <div class="gallery-item" data-category="anniversary">
                <img src="assets/images/gallery/galery3.jpg" alt="Anniversary Gallery">
                <div class="gallery-overlay">
                    <h3>Silver Anniversary</h3>
                    <p>25 Years Celebration</p>
                </div>
            </div>
            
            <!-- Gallery Item 4 -->
            <div class="gallery-item" data-category="corporate">
                <img src="assets/images/gallery/galery4.jpg" alt="Corporate Gallery">
                <div class="gallery-overlay">
                    <h3>Executive Conference</h3>
                    <p>Annual Corporate Meeting</p>
                </div>
            </div>
        </div>
        <div class="text-center" style="margin-top: 30px;">
            <a href="gallery.php" class="btn btn-secondary">View All Gallery</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section section-dark">
    <div class="container">
        <div class="section-title">
            <h2>Client Testimonials</h2>
            <p>What our clients say about their experience with RoyalEvent.</p>
        </div>
        <div class="testimonials-container">
            <button class="testimonial-nav-btn prev-btn" aria-label="Previous testimonial">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="testimonials-slider">
                <div class="testimonials-track">
                    <!-- Testimonial 1 -->
                    <div class="testimonial-card" data-index="0">
                        <div class="testimonial-img">
                            <img src="assets/images/avatars/cust1.jpg" alt="Kajal & Suraj" onerror="this.src='assets/images/avatars/default-avatar.png'">
                        </div>
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-quote">RoyalEvent made our wedding day absolutely perfect! Every detail was handled with such care and professionalism. Our guests are still talking about how amazing everything was. Highly recommended!</p>
                        <h4 class="testimonial-author">Kajal & Suraj</h4>
                        <p class="testimonial-event">Luxury Wedding Package</p>
                    </div>
                    
                    <!-- Testimonial 2 -->
                    <div class="testimonial-card" data-index="1">
                        <div class="testimonial-img">
                            <img src="assets/images/avatars/cust2.jpg" alt="Rahul Singh" onerror="this.src='assets/images/avatars/default-avatar.png'">
                        </div>
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="testimonial-quote">My daughter's 16th birthday party was a dream come true thanks to RoyalEvent. The decorations, entertainment, and food were all top-notch. The planning process was stress-free and they were very accommodating with our requests.</p>
                        <h4 class="testimonial-author">Rahul Singh</h4>
                        <p class="testimonial-event">Premium Birthday Package</p>
                    </div>
                    
                    <!-- Testimonial 3 -->
                    <div class="testimonial-card" data-index="2">
                        <div class="testimonial-img">
                            <img src="assets/images/avatars/cust3.jpg" alt="Chandan Sahu" onerror="this.src='assets/images/avatars/default-avatar.png'">
                        </div>
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-quote">We hired RoyalEvent for our company's annual gala, and they exceeded our expectations. The venue setup was elegant, the scheduling was flawless, and the team was highly professional. Our employees were impressed!</p>
                        <h4 class="testimonial-author">Chandan Sahu</h4>
                        <p class="testimonial-event">Corporate Event Package</p>
                    </div>
                    
                    <!-- Testimonial 4 -->
                    <div class="testimonial-card" data-index="3">
                        <div class="testimonial-img">
                            <img src="assets/images/avatars/cust4.jpg" alt="Priya & Raj Patel" onerror="this.src='assets/images/avatars/default-avatar.png'">
                        </div>
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <p class="testimonial-quote">Our 25th anniversary celebration was exactly what we envisioned. RoyalEvent's attention to detail and ability to incorporate our cultural traditions made the event truly special. We appreciated their flexibility and creativity.</p>
                        <h4 class="testimonial-author">Priya & Raj Patel</h4>
                        <p class="testimonial-event">Premium Anniversary Package</p>
                    </div>
                    
                    <!-- Testimonial 5 -->
                    <div class="testimonial-card" data-index="4">
                        <div class="testimonial-img">
                            <img src="assets/images/avatars/cust5.jpg" alt="Mr. Rohit Kumar" onerror="this.src='assets/images/avatars/default-avatar.png'">
                        </div>
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="testimonial-quote">I organized a charity fundraiser with RoyalEvent and was amazed by their dedication. They helped us stay within budget while still creating an elegant atmosphere. The event raised more money than expected!</p>
                        <h4 class="testimonial-author">Mr. Rohit Kumar</h4>
                        <p class="testimonial-event">Custom Event Package</p>
                    </div>
                    
                    <!-- Testimonial 6 -->
                    <div class="testimonial-card" data-index="5">
                        <div class="testimonial-img">
                            <img src="assets/images/avatars/testimonial6.jpg" alt="James & Thomas" onerror="this.src='assets/images/avatars/default-avatar.png'">
                        </div>
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-quote">Our wedding was everything we dreamed of and more. RoyalEvent created a beautiful, inclusive celebration that perfectly represented us as a couple. The day went smoothly and we could truly enjoy every moment.</p>
                        <h4 class="testimonial-author">James & Thomas</h4>
                        <p class="testimonial-event">Luxury Wedding Package</p>
                    </div>
                </div>
            </div>
            
            <button class="testimonial-nav-btn next-btn" aria-label="Next testimonial">
                <i class="fas fa-chevron-right"></i>
            </button>
            
            <div class="testimonial-dots">
                <span class="dot active" data-index="0"></span>
                <span class="dot" data-index="1"></span>
                <span class="dot" data-index="2"></span>
                <span class="dot" data-index="3"></span>
                <span class="dot" data-index="4"></span>
                <span class="dot" data-index="5"></span>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Ready to Plan Your Event?</h2>
            <p>Get in touch with us today to start planning your perfect event.</p>
        </div>
        <div class="text-center">
            <a href="contact.php" class="btn btn-primary btn-lg">Contact Us</a>
            <a href="plans.php" class="btn btn-secondary btn-lg" style="margin-left: 15px;">View Pricing</a>
        </div>
    </div>
</section>



<!-- Add JavaScript for testimonial slider -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.querySelector('.testimonials-track');
    const slides = Array.from(document.querySelectorAll('.testimonial-card'));
    const dots = Array.from(document.querySelectorAll('.dot'));
    const nextButton = document.querySelector('.next-btn');
    const prevButton = document.querySelector('.prev-btn');
    
    let currentIndex = 0;
    const slideWidth = slides[0].getBoundingClientRect().width;
    
    // Set initial position
    positionSlides();
    
    // Add event listeners
    nextButton.addEventListener('click', () => {
        if (currentIndex < slides.length - 1) {
            currentIndex++;
            positionSlides();
        }
    });
    
    prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            positionSlides();
        }
    });
    
    dots.forEach(dot => {
        dot.addEventListener('click', e => {
            const targetIndex = parseInt(e.target.getAttribute('data-index'));
            if (targetIndex !== currentIndex) {
                currentIndex = targetIndex;
                positionSlides();
            }
        });
    });
    
    function positionSlides() {
        // Update slide positions
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
        
        // Update button states
        prevButton.disabled = currentIndex === 0;
        nextButton.disabled = currentIndex === slides.length - 1;
        
        // Update dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?> 