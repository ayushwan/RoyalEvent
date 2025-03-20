<?php
// Include header
include 'includes/header.php';

// Check if user is logged in
if (!is_user_logged_in()) {
    set_flash_message('error', 'Please login to book an event');
    redirect('login.php');
}

// Get user details
$user_id = $_SESSION['user_id'];
$user = get_user_by_id($user_id);

// Get event type and plan from URL
$event_type = isset($_GET['type']) ? clean_input($_GET['type']) : '';
$plan = isset($_GET['plan']) ? clean_input($_GET['plan']) : '';

// Validate event type and plan
$valid_event_types = get_event_types();
$valid_plans = get_plan_types();

if (!in_array($event_type, $valid_event_types)) {
    $event_type = '';
}

if (!in_array($plan, $valid_plans)) {
    $plan = '';
}

// Get pricing information
$price = 0;
if (!empty($event_type) && !empty($plan)) {
    $price = get_event_price($event_type, $plan);
}

// Get pricing details
$sql = "SELECT * FROM pricing WHERE event_type = '$event_type' AND plan = '$plan'";
$result = mysqli_query($conn, $sql);
$pricing_details = mysqli_fetch_assoc($result);

// Process booking form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $event_type = clean_input($_POST['event_type']);
    $plan = clean_input($_POST['plan']);
    $event_date = clean_input($_POST['event_date']);
    $guest_count = (int)$_POST['guest_count'];
    $venue = clean_input($_POST['venue']);
    $message = clean_input($_POST['message']);
    
    // Validate form data
    $errors = array();
    
    if (empty($event_type)) {
        $errors[] = "Event type is required";
    }
    
    if (empty($plan)) {
        $errors[] = "Plan is required";
    }
    
    if (empty($event_date)) {
        $errors[] = "Event date is required";
    } else {
        // Check if date is in the future
        $selected_date = strtotime($event_date);
        $current_date = strtotime(date('Y-m-d'));
        
        if ($selected_date < $current_date) {
            $errors[] = "Event date must be in the future";
        }
    }
    
    if ($guest_count <= 0) {
        $errors[] = "Guest count must be greater than zero";
    }
    
    // If no errors, process booking
    if (empty($errors)) {
        // Get pricing for event type and plan
        $price = get_event_price($event_type, $plan);
        
        if ($price <= 0) {
            $errors[] = "Invalid price for selected event type and plan";
        } else {
            // Calculate total amount
            $total_amount = $price;
            
            // Generate reference number
            $reference = generate_booking_reference();
            
            // Insert booking into database - set as confirmed directly
            $sql = "INSERT INTO bookings (user_id, event_type, plan, event_date, guest_count, venue, message, total_amount, reference_number, status) 
                    VALUES ($user_id, '$event_type', '$plan', '$event_date', $guest_count, '$venue', '$message', $total_amount, '$reference', 'Confirmed')";
            
            if (mysqli_query($conn, $sql)) {
                $booking_id = mysqli_insert_id($conn);
                
                // Set success message and redirect
                set_flash_message('success', 'Your booking has been successfully created and confirmed. Check your dashboard for details.');
                
                // Redirect to dashboard
                redirect('user-dashboard.php?page=bookings');
                exit;
            } else {
                $errors[] = "Error creating booking: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!-- Booking Page -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Book Your Event</h2>
            <p>Fill in the details below to book your perfect event with RoyalEvent.</p>
        </div>
        
        <?php if (isset($error) && !empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="booking-container">
            <!-- Booking Form -->
            <div class="booking-form">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="needs-validation">
                    <div class="form-group">
                        <label for="event_type">Event Type *</label>
                        <select name="event_type" id="event_type" class="form-control" required>
                            <option value="">Select Event Type</option>
                            <?php foreach ($valid_event_types as $type): ?>
                                <option value="<?php echo $type; ?>" <?php echo ($event_type == $type) ? 'selected' : ''; ?>><?php echo $type; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="plan">Package *</label>
                        <select name="plan" id="plan" class="form-control" required>
                            <option value="">Select Package</option>
                            <?php foreach ($valid_plans as $p): ?>
                                <option value="<?php echo $p; ?>" <?php echo ($plan == $p) ? 'selected' : ''; ?>><?php echo $p; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="event_date">Event Date *</label>
                        <input type="date" name="event_date" id="event_date" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="guest_count">Number of Guests *</label>
                        <input type="number" name="guest_count" id="guest_count" class="form-control" min="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="venue">Preferred Venue (Optional)</label>
                        <input type="text" name="venue" id="venue" class="form-control" placeholder="If you have a venue in mind, let us know">
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Additional Requirements/Message (Optional)</label>
                        <textarea name="message" id="message" class="form-control" rows="5" placeholder="Tell us any specific requirements or additional information for your event"></textarea>
                    </div>
                    
                    <input type="hidden" name="price" id="price" value="<?php echo $price; ?>">
                    
                    <button type="submit" class="btn btn-primary btn-block">Book Now</button>
                </form>
            </div>
            
            <!-- Booking Summary -->
            <div class="booking-summary">
                <h3>Booking Summary</h3>
                
                <div id="booking-details">
                    <?php if (!empty($event_type) && !empty($plan) && $price > 0): ?>
                        <div class="summary-item">
                            <div class="summary-label">Event Type:</div>
                            <div class="summary-value"><?php echo $event_type; ?></div>
                        </div>
                        
                        <div class="summary-item">
                            <div class="summary-label">Package:</div>
                            <div class="summary-value"><?php echo $plan; ?></div>
                        </div>
                        
                        <div class="summary-item summary-total">
                            <div class="summary-label">Total Price:</div>
                            <div class="summary-value" id="price_display"><?php echo format_price($price); ?></div>
                        </div>
                        
                        <?php if (isset($pricing_details) && !empty($pricing_details)): ?>
                            <div class="package-details">
                                <h4>Package Details</h4>
                                <p><?php echo $pricing_details['description']; ?></p>
                                
                                <h5>What's Included:</h5>
                                <ul class="feature-list">
                                    <?php 
                                    $features = explode(",", $pricing_details['features']);
                                    foreach ($features as $feature):
                                    ?>
                                        <li><i class="fas fa-check"></i> <?php echo trim($feature); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <!-- Quick Book Button -->
                            <form action="" method="POST" class="mt-4">
                                <input type="hidden" name="event_type" value="<?php echo $event_type; ?>">
                                <input type="hidden" name="plan" value="<?php echo $plan; ?>">
                                <input type="hidden" name="price" value="<?php echo $price; ?>">
                                <input type="hidden" name="event_date" value="<?php echo date('Y-m-d', strtotime('+30 days')); ?>">
                                <input type="hidden" name="guest_count" value="50">
                                <input type="hidden" name="venue" value="To be determined">
                                <input type="hidden" name="message" value="Quick booking - details to be confirmed">
                                
                                <button type="submit" class="btn btn-secondary btn-block">Quick Book Now</button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Please select an event type and package to see the booking summary.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Feature List Styles */
.feature-list {
    list-style: none;
    padding: 0;
    margin: 15px 0;
}

.feature-list li {
    margin-bottom: 10px;
    display: flex;
    align-items: flex-start;
}

.feature-list li i {
    color: var(--secondary-color);
    margin-right: 10px;
    margin-top: 4px;
}

/* Package Details Styles */
.package-details {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.package-details h4 {
    margin-bottom: 15px;
}

.package-details h5 {
    margin: 15px 0 10px;
}

.package-details p {
    margin-bottom: 15px;
}

/* Additional styling for booking buttons */
.mt-4 {
    margin-top: 1.5rem;
}

.btn-primary, .btn-secondary {
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover, .btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-secondary {
    background-color: var(--secondary-color);
    color: var(--primary-color);
}

.btn-secondary:hover {
    box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
}

/* Quick Book styling */
.booking-summary .btn-block {
    padding: 12px;
    font-size: 1rem;
    border-radius: 5px;
    margin-top: 15px;
}
</style>

<!-- Get Price AJAX Endpoint -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const eventTypeSelect = document.getElementById('event_type');
    const planSelect = document.getElementById('plan');
    const priceDisplay = document.getElementById('price_display');
    const priceInput = document.getElementById('price');
    const bookingDetails = document.getElementById('booking-details');
    
    // Update price when event type or plan changes
    function updatePrice() {
        const eventType = eventTypeSelect.value;
        const plan = planSelect.value;
        
        if (eventType && plan) {
            // Redirect to the same page with parameters
            window.location.href = `booking.php?type=${encodeURIComponent(eventType)}&plan=${encodeURIComponent(plan)}`;
        }
    }
    
    // Event listeners
    if (eventTypeSelect && planSelect) {
        eventTypeSelect.addEventListener('change', updatePrice);
        planSelect.addEventListener('change', updatePrice);
    }
    
    // Date picker restrictions (can't select past dates)
    const dateInput = document.getElementById('event_date');
    if (dateInput) {
        const today = new Date();
        const year = today.getFullYear();
        let month = today.getMonth() + 1;
        let day = today.getDate();
        
        month = month < 10 ? '0' + month : month;
        day = day < 10 ? '0' + day : day;
        
        dateInput.min = `${year}-${month}-${day}`;
    }
});
</script>

<?php include 'includes/footer.php'; ?> 