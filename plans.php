<?php
// Include header
include 'includes/header.php';

// Get selected event type from URL parameter, default to Wedding if not set
$selected_type = isset($_GET['type']) ? clean_input($_GET['type']) : 'Wedding';

// Get all event types
$event_types = get_event_types();

// Get pricing plans for the selected event type
$sql = "SELECT * FROM pricing WHERE event_type = '$selected_type' ORDER BY FIELD(plan, 'Basic', 'Premium', 'Luxury')";
$result = mysqli_query($conn, $sql);
$plans = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $plans[] = $row;
    }
}
?>

<!-- Plans Section -->
<section class="section" style="background-image: url('assets/images/backgrounds/hero-bg.jpg'); background-size: cover; background-position: center; position: relative; color: white; padding: 80px 0;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 1;"></div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="contact-us" id="pricing-plans" style="text-align: center;">
            <h2>Our Pricing Plans</h2>
            <p>Choose the perfect package for your special event. We offer various options to fit your needs and budget.</p>
        </div>
        
        <!-- Event Type Tabs -->
        <div class="pricing-tabs">
            <?php foreach ($event_types as $event_type): ?>
                <a href="?type=<?php echo urlencode($event_type); ?>" class="pricing-tab <?php echo ($selected_type == $event_type) ? 'active' : ''; ?>">
                    <?php echo $event_type; ?>
                </a>
            <?php endforeach; ?>
        </div>
        
        <!-- Plans Container -->
        <div class="pricing-container">
            <?php if (empty($plans)): ?>
                <div class="alert alert-info">No pricing plans found for this event type.</div>
            <?php else: ?>
                <?php foreach ($plans as $index => $plan): ?>
                    <div class="pricing-plan">
                        <?php if ($index == 1): ?>
                            <div class="plan-popular">Most Popular</div>
                        <?php endif; ?>
                        <div class="pricing-header">
                            <h3 class="plan-name"><?php echo $plan['plan']; ?> Package</h3>
                            <div class="plan-price"><?php echo format_price($plan['price']); ?></div>
                            <div class="plan-duration">per event</div>
                        </div>
                        <div class="pricing-body">
                            <p><?php echo $plan['description']; ?></p>
                            <ul class="plan-features">
                                <?php 
                                $features = explode(",", $plan['features']);
                                foreach ($features as $feature):
                                ?>
                                    <li><i class="fas fa-check"></i> <?php echo trim($feature); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <?php if (is_user_logged_in()): ?>
                                <a href="booking.php?type=<?php echo urlencode($selected_type); ?>&plan=<?php echo urlencode($plan['plan']); ?>" class="btn btn-primary">Book Now</a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-primary">Login to Book</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section" style="background-color: #f5f5f5;">
    <div class="container">
        <div class="section-title">
            <h2>Frequently Asked Questions</h2>
            <p>Find answers to common questions about our event planning services.</p>
        </div>
        
        <div style="max-width: 800px; margin: 0 auto;">
            <div class="accordion">
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>What is included in each package?</h3>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Each package includes venue selection, event planning and coordination, basic decoration, catering, and event duration as specified. Premium and Luxury packages include additional services like photography, entertainment, and more elaborate decorations. For a detailed list of what's included in each package, please refer to the package descriptions above.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>Can I customize a package to fit my specific needs?</h3>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Absolutely! Our packages are designed to be starting points. We can customize any package to add or remove services based on your requirements and budget. Please contact us to discuss your specific needs, and we'll create a tailored package for you.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>How far in advance should I book my event?</h3>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="accordion-content">
                        <p>For weddings and large corporate events, we recommend booking at least 6-12 months in advance to ensure venue availability and enough time for planning. For birthdays and anniversaries, 3-6 months is typically sufficient. However, we can accommodate last-minute bookings depending on availability.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>What is the payment process?</h3>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="accordion-content">
                        <p>We require a 25% deposit to secure your booking date. The remaining balance is due 14 days before the event date. We accept various payment methods including credit/debit cards, bank transfers, and PayPal.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h3>What is your cancellation policy?</h3>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Cancellations made more than 60 days before the event date receive a full refund minus a $100 administration fee. Cancellations between 30-60 days before the event receive a 50% refund. Cancellations less than 30 days before the event are not eligible for a refund. We understand that circumstances can change, so please contact us to discuss your specific situation.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Ready to Book Your Event?</h2>
            <p>Contact us today to start planning your perfect event with RoyalEvent.</p>
        </div>
        <div class="text-center">
            <?php if (is_user_logged_in()): ?>
                <a href="booking.php" class="btn btn-primary btn-lg">Book Now</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary btn-lg">Login to Book</a>
                <a href="signup.php" class="btn btn-secondary btn-lg" style="margin-left: 15px;">Create an Account</a>
            <?php endif; ?>
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

<style>
/* Accordion Styles */
.accordion {
    margin-top: 30px;
}

.accordion-item {
    margin-bottom: 15px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.accordion-header {
    padding: 15px 20px;
    background-color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.accordion-header h3 {
    margin: 0;
    font-size: 1.1rem;
    color: var(--primary-color);
}

.accordion-header i {
    font-size: 1rem;
    color: var(--primary-color);
    transition: all 0.3s ease;
}

.accordion-content {
    padding: 0 20px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.accordion-content p {
    padding: 10px 0 20px;
}

.accordion-item.active .accordion-header {
    background-color: #f9f9f9;
}
</style>

<?php include 'includes/footer.php'; ?> 