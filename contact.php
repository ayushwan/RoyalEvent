<?php
// Include header
include 'includes/header.php';

// Initialize variables
$name = $email = $subject = $message = '';
$error = '';
$success = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $subject = clean_input($_POST['subject']);
    $message = clean_input($_POST['message']);
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "Please fill in all fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address";
    } else {
        // Insert message into database
        $sql = "INSERT INTO contacts (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Your message has been sent successfully. We will get back to you soon!";
            
            // Clear form fields after successful submission
            $name = $email = $subject = $message = '';
            
            // Additional: Send email notification to admin (optional)
            // mail('admin@royalevent.com', 'New Contact Form Submission', $message, "From: $email");
        } else {
            $error = "Error sending message: " . mysqli_error($conn);
        }
    }
}
?>

<!-- Page Header -->
<section class="section" style="background-color: var(--primary-color); padding: 60px 0;">
    <div class="container">
        <div class="text-center" style="color: var(--light-color);">
            <h1 id="contact-us">Contact Us</h1>
            <p>We'd love to hear from you! Get in touch with us for any questions or inquiries.</p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section">
    <div class="container">
        <div class="contact-container">
            <div class="contact-info">
                <h3>Contact Information</h3>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Our Location</h4>
                        <p>DSPMU, new building, Ranchi, Jharkhand-834001</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Phone Number</h4>
                        <p>+91 9876543210</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Email Address</h4>
                        <p>info@royalevent.com</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Working Hours</h4>
                        <p>Monday to Friday: 9AM - 6PM</p>
                    </div>
                </div>
                
                <!-- Social Media Links -->
                <div style="margin-top: 30px;">
                    <h4 style="color: var(--light-color); margin-bottom: 15px;">Follow Us</h4>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="contact-form">
                <h3>Send Us a Message</h3>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="needs-validation">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter subject" value="<?php echo htmlspecialchars($subject); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea name="message" id="message" class="form-control" placeholder="Enter your message" rows="5" required><?php echo htmlspecialchars($message); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<!-- <section class="section" style="padding-top: 0;">
    <div class="container">
        <div style="width: 100%; height: 400px; background-color: #f5f5f5; border-radius: 10px; overflow: hidden;"> -->
            <!-- Placeholder for a map. In a real implementation, you would use Google Maps or another map service -->
            <!-- <div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; text-align: center; padding: 20px;">
                <div>
                    <i class="fas fa-map-marked-alt" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 15px;"></i>
                    <h3>Map Location</h3>
                    <p>This is where a map would be displayed showing our office location.</p>
                    <p>For an actual implementation, you would integrate Google Maps API here.</p>
                </div>
            </div>
        </div>
    </div>
</section> -->

<!-- FAQ Section -->
<section class="section" style="background-color: #f5f5f5;">
    <div class="container">
        <div class="section-title">
            <h2>Frequently Asked Questions</h2>
            <p>Find answers to common questions about our services.</p>
        </div>
        
        <div style="max-width: 800px; margin: 0 auto;">
            <div class="accordion">
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>How can I book an event?</h3>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="accordion-content">
                        <p>You can book an event through our website by creating an account, selecting your desired event type and package, and completing the booking form. Alternatively, you can contact us directly by phone or email for personalized assistance.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>What areas do you serve?</h3>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="accordion-content">
                        <p>We primarily serve the metropolitan area and surrounding suburbs within a 50-mile radius. For events outside this area, additional travel fees may apply. Please contact us for specific information about your location.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>Do you offer venue recommendations?</h3>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Yes! We have partnerships with various venues suitable for different types of events. Once you book our services, our event planners will provide venue recommendations based on your preferences, budget, and event size.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Simple accordion functionality
document.addEventListener('DOMContentLoaded', function() {
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    
    accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const accordionItem = this.parentElement;
            const accordionContent = this.nextElementSibling;
            const icon = this.querySelector('i');
            
            // Toggle the active class
            accordionItem.classList.toggle('active');
            
            // Toggle the plus/minus icon
            if (accordionItem.classList.contains('active')) {
                icon.classList.replace('fa-plus', 'fa-minus');
                accordionContent.style.maxHeight = accordionContent.scrollHeight + 'px';
            } else {
                icon.classList.replace('fa-minus', 'fa-plus');
                accordionContent.style.maxHeight = '0';
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?> 