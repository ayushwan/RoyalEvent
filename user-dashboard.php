<?php
// Include header
include 'includes/header.php';

// Check if user is logged in
if (!is_user_logged_in()) {
    set_flash_message('error', 'Please login to access the dashboard');
    redirect('login.php');
}

// Get user details
$user_id = $_SESSION['user_id'];
$user = get_user_by_id($user_id);

// Get active page from URL
$page = isset($_GET['page']) ? clean_input($_GET['page']) : 'dashboard';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'profile') {
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Check if email already exists and it's not the user's current email
    $email_check_query = "SELECT * FROM users WHERE email = '$email' AND id != $user_id";
    $email_check_result = mysqli_query($conn, $email_check_query);
    
    if (mysqli_num_rows($email_check_result) > 0) {
        $update_error = "Email already exists. Please use a different email";
    } else {
        // If current password provided, process password change
        if (!empty($current_password)) {
            // Verify current password
            if (!verify_password($current_password, $user['password'])) {
                $update_error = "Current password is incorrect";
            } elseif (empty($new_password) || empty($confirm_password)) {
                $update_error = "Please enter new password and confirmation";
            } elseif ($new_password !== $confirm_password) {
                $update_error = "New passwords do not match";
            } elseif (strlen($new_password) < 6) {
                $update_error = "New password must be at least 6 characters long";
            } else {
                // Password change is valid, update profile with new password
                $hashed_password = hash_password($new_password);
                $update_query = "UPDATE users SET name = '$name', email = '$email', password = '$hashed_password' WHERE id = $user_id";
            }
        } else {
            // No password change, just update name and email
            $update_query = "UPDATE users SET name = '$name', email = '$email' WHERE id = $user_id";
        }
        
        // Execute update if no errors
        if (!isset($update_error)) {
            if (mysqli_query($conn, $update_query)) {
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $update_success = "Profile updated successfully";
                // Refresh user data
                $user = get_user_by_id($user_id);
            } else {
                $update_error = "Error updating profile: " . mysqli_error($conn);
            }
        }
    }
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'change-password') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate inputs
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $password_error = "Please fill in all password fields";
    } elseif (!verify_password($current_password, $user['password'])) {
        $password_error = "Current password is incorrect";
    } elseif ($new_password !== $confirm_password) {
        $password_error = "New passwords do not match";
    } elseif (strlen($new_password) < 6) {
        $password_error = "New password must be at least 6 characters long";
    } else {
        // All validations passed, update password
        $hashed_password = hash_password($new_password);
        $update_query = "UPDATE users SET password = '$hashed_password' WHERE id = $user_id";
        
        if (mysqli_query($conn, $update_query)) {
            $password_success = "Password changed successfully";
        } else {
            $password_error = "Error changing password: " . mysqli_error($conn);
        }
    }
}

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'feedback') {
    $booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : null;
    $feedback_text = clean_input($_POST['feedback_text']);
    $rating = (int)$_POST['rating'];
    
    // Validate inputs
    if (empty($feedback_text) || $rating < 1 || $rating > 5) {
        $feedback_error = "Please provide feedback text and a rating between 1 and 5";
    } else {
        // Insert feedback
        $feedback_query = "INSERT INTO feedback (user_id, booking_id, feedback_text, rating) VALUES ($user_id, " . ($booking_id ? $booking_id : "NULL") . ", '$feedback_text', $rating)";
        
        if (mysqli_query($conn, $feedback_query)) {
            $feedback_success = "Thank you for your feedback!";
            // Clear form data
            $feedback_text = "";
            $rating = 0;
        } else {
            $feedback_error = "Error submitting feedback: " . mysqli_error($conn);
        }
    }
}

// Get user's bookings
$bookings = get_user_bookings($user_id);

// Get user's feedback
$feedback_query = "SELECT f.*, b.event_type, b.plan 
                  FROM feedback f 
                  LEFT JOIN bookings b ON f.booking_id = b.id 
                  WHERE f.user_id = $user_id 
                  ORDER BY f.date DESC";
$feedback_result = mysqli_query($conn, $feedback_query);
$feedbacks = [];

if ($feedback_result && mysqli_num_rows($feedback_result) > 0) {
    while ($feedback = mysqli_fetch_assoc($feedback_result)) {
        $feedbacks[] = $feedback;
    }
}
?>

<!-- Dashboard Page -->
<section class="dashboard">
    <div class="container">
        <div class="dashboard-container">
            <!-- Sidebar -->
            <div class="dashboard-sidebar">
                <div class="user-info">
                    <div class="user-avatar">
                        <img src="assets/images/avatars/default-avatar.png" alt="User Avatar">
                    </div>
                    <h4 class="user-name"><?php echo $user['name']; ?></h4>
                    <p class="user-email"><?php echo $user['email']; ?></p>
                </div>
                
                <ul class="sidebar-menu">
                    <li>
                        <a href="?page=dashboard" class="<?php echo $page === 'dashboard' ? 'active' : ''; ?>">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="?page=profile" class="<?php echo $page === 'profile' ? 'active' : ''; ?>">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                    </li>
                    <li>
                        <a href="?page=bookings" class="<?php echo $page === 'bookings' ? 'active' : ''; ?>">
                            <i class="fas fa-calendar-check"></i> My Bookings
                        </a>
                    </li>
                    <li>
                        <a href="?page=feedback" class="<?php echo $page === 'feedback' ? 'active' : ''; ?>">
                            <i class="fas fa-comment"></i> Feedback
                        </a>
                    </li>
                    <li>
                        <a href="?page=change-password" class="<?php echo $page === 'change-password' ? 'active' : ''; ?>">
                            <i class="fas fa-key"></i> Change Password
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main Content -->
            <div class="dashboard-content">
                <?php if ($page === 'dashboard'): ?>
                    <!-- Dashboard Overview -->
                    <div class="dashboard-title">
                        <h2>Dashboard</h2>
                        <p>Welcome back, <?php echo $user['name']; ?>!</p>
                    </div>
                    
                    <!-- Dashboard Cards -->
                    <div class="dashboard-cards">
                        <div class="dashboard-card">
                            <div class="card-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="card-info">
                                <div class="card-value"><?php echo count($bookings); ?></div>
                                <div class="card-label">Total Bookings</div>
                            </div>
                        </div>
                        
                        <div class="dashboard-card">
                            <div class="card-icon">
                                <i class="fas fa-comment"></i>
                            </div>
                            <div class="card-info">
                                <div class="card-value"><?php echo count($feedbacks); ?></div>
                                <div class="card-label">Feedback Submitted</div>
                            </div>
                        </div>
                        
                        <?php
                            // Count pending bookings
                            $pending_count = 0;
                            foreach ($bookings as $booking) {
                                if ($booking['status'] === 'Pending') {
                                    $pending_count++;
                                }
                            }
                        ?>
                        <div class="dashboard-card">
                            <div class="card-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="card-info">
                                <div class="card-value"><?php echo $pending_count; ?></div>
                                <div class="card-label">Pending Bookings</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Bookings -->
                    <div class="dashboard-section">
                        <h3>Recent Bookings</h3>
                        
                        <?php if (empty($bookings)): ?>
                            <div class="alert alert-info">You have no bookings yet. <a href="plans.php">Book an event now</a>.</div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Event Type</th>
                                            <th>Package</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        // Display only the 5 most recent bookings
                                        $recent_bookings = array_slice($bookings, 0, 5);
                                        foreach ($recent_bookings as $booking): 
                                        ?>
                                            <tr>
                                                <td><?php echo $booking['event_type']; ?></td>
                                                <td><?php echo $booking['plan']; ?></td>
                                                <td><?php echo format_date($booking['event_date']); ?></td>
                                                <td>
                                                    <?php echo format_booking_status($booking['status']); ?>
                                                </td>
                                                <td>
                                                    <a href="?page=bookings&view=<?php echo $booking['id']; ?>" class="btn btn-sm btn-primary">View</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <?php if (count($bookings) > 5): ?>
                                <div class="text-right">
                                    <a href="?page=bookings" class="btn btn-secondary">View All Bookings</a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    
                <?php elseif ($page === 'profile'): ?>
                    <!-- User Profile -->
                    <div class="dashboard-title">
                        <h2>My Profile</h2>
                        <p>Manage your personal information</p>
                    </div>
                    
                    <?php if (isset($update_error)): ?>
                        <div class="alert alert-danger"><?php echo $update_error; ?></div>
                    <?php endif; ?>
                    
                    <?php if (isset($update_success)): ?>
                        <div class="alert alert-success"><?php echo $update_success; ?></div>
                    <?php endif; ?>
                    
                    <form action="?page=profile" method="POST" class="needs-validation">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $user['name']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <h4>Change Password (Optional)</h4>
                            <p class="text-muted small">Leave blank if you don't want to change your password</p>
                            
                            <label for="current_password">Current Password</label>
                            <div style="position: relative;">
                                <input type="password" name="current_password" id="current_password" class="form-control">
                                <button type="button" class="password-toggle" data-target="#current_password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div style="position: relative;">
                                <input type="password" name="new_password" id="new_password" class="form-control">
                                <button type="button" class="password-toggle" data-target="#new_password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <div style="position: relative;">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                                <button type="button" class="password-toggle" data-target="#confirm_password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                    
                <?php elseif ($page === 'bookings'): ?>
                    <!-- Bookings -->
                    <div class="dashboard-title">
                        <h2>My Bookings</h2>
                        <p>View and manage your event bookings</p>
                    </div>
                    
                    <?php
                    // Check if viewing a specific booking
                    if (isset($_GET['view']) && is_numeric($_GET['view'])) {
                        $booking_id = (int)$_GET['view'];
                        $viewing_booking = get_booking_by_id($booking_id, $user_id);
                        
                        if ($viewing_booking):
                    ?>
                        <div class="booking-details">
                            <a href="?page=bookings" class="btn btn-secondary btn-sm mb-3"><i class="fas fa-arrow-left"></i> Back to All Bookings</a>
                            
                            <div class="card">
                                <div class="card-header">
                                    <h3>Booking #<?php echo $viewing_booking['id']; ?></h3>
                                    <p class="mb-0">
                                        <span class="badge badge-primary">
                                            <?php echo days_until_event($viewing_booking['event_date']); ?> days remaining
                                        </span>
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Event Details</h4>
                                            <p><strong>Event Type:</strong> <?php echo $viewing_booking['event_type']; ?></p>
                                            <p><strong>Package:</strong> <?php echo $viewing_booking['plan']; ?></p>
                                            <p><strong>Event Date:</strong> <?php echo format_date($viewing_booking['event_date']); ?></p>
                                            <p><strong>Guest Count:</strong> <?php echo $viewing_booking['guest_count']; ?></p>
                                            <p><strong>Venue:</strong> <?php echo $viewing_booking['venue'] ?: 'To be determined'; ?></p>
                                            <p><strong>Booking Status:</strong> <?php echo format_booking_status($viewing_booking['status']); ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>Booking Information</h4>
                                            <p><strong>Total Amount:</strong> <?php echo format_price($viewing_booking['total_amount']); ?></p>
                                            <p><strong>Booking Status:</strong> <?php echo format_booking_status($viewing_booking['status']); ?></p>
                                            
                                            <p><strong>Booking Date:</strong> <?php echo format_date($viewing_booking['created_at']); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <h4>Additional Information</h4>
                                        <p><?php echo $viewing_booking['message'] ?: 'No additional information provided.'; ?></p>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <!-- Add feedback button if booking is completed -->
                                        <?php if ($viewing_booking['status'] === 'Completed'): ?>
                                            <a href="?page=feedback&booking_id=<?php echo $viewing_booking['id']; ?>" class="btn btn-secondary">Leave Feedback</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger">Booking not found.</div>
                    <?php endif; 
                    } else {
                        // Show all bookings
                        if (empty($bookings)): 
                    ?>
                        <div class="alert alert-info">You have no bookings yet. <a href="plans.php">Book an event now</a>.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Event Type</th>
                                        <th>Package</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bookings as $booking): ?>
                                        <tr>
                                            <td><?php echo $booking['id']; ?></td>
                                            <td><?php echo $booking['event_type']; ?></td>
                                            <td><?php echo $booking['plan']; ?></td>
                                            <td><?php echo format_date($booking['event_date']); ?></td>
                                            <td><?php echo format_price($booking['total_amount']); ?></td>
                                            <td>
                                                <?php echo format_booking_status($booking['status']); ?>
                                            </td>
                                            <td>
                                                <a href="?page=bookings&view=<?php echo $booking['id']; ?>" class="btn btn-sm btn-primary">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; 
                    } 
                    ?>
                    
                <?php elseif ($page === 'feedback'): ?>
                    <!-- Feedback -->
                    <div class="dashboard-title">
                        <h2>Feedback</h2>
                        <p>Share your experience with us</p>
                    </div>
                    
                    <!-- Feedback Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3>Submit Feedback</h3>
                        </div>
                        <div class="card-body">
                            <?php if (isset($feedback_error)): ?>
                                <div class="alert alert-danger"><?php echo $feedback_error; ?></div>
                            <?php endif; ?>
                            
                            <?php if (isset($feedback_success)): ?>
                                <div class="alert alert-success"><?php echo $feedback_success; ?></div>
                            <?php endif; ?>
                            
                            <form action="?page=feedback" method="POST" class="needs-validation">
                                <div class="form-group">
                                    <label for="booking_id">Select Event (Optional)</label>
                                    <select name="booking_id" id="booking_id" class="form-control">
                                        <option value="">General Feedback</option>
                                        <?php 
                                        // Get completed bookings for feedback
                                        foreach ($bookings as $booking): 
                                            if ($booking['status'] === 'Completed'):
                                        ?>
                                            <option value="<?php echo $booking['id']; ?>" <?php echo (isset($_GET['booking_id']) && $_GET['booking_id'] == $booking['id']) ? 'selected' : ''; ?>>
                                                <?php echo $booking['event_type'] . ' - ' . $booking['plan'] . ' (' . format_date($booking['event_date']) . ')'; ?>
                                            </option>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="rating">Rating</label>
                                    <div class="rating-input">
                                        <div class="rating-stars">
                                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                                <input type="radio" name="rating" id="rating-<?php echo $i; ?>" value="<?php echo $i; ?>" <?php echo (isset($rating) && $rating == $i) ? 'checked' : ''; ?> required>
                                                <label for="rating-<?php echo $i; ?>"><i class="fas fa-star"></i></label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="feedback_text">Feedback</label>
                                    <textarea name="feedback_text" id="feedback_text" class="form-control" rows="5" placeholder="Share your experience with our services..." required><?php echo isset($feedback_text) ? $feedback_text : ''; ?></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Submit Feedback</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Previous Feedback -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Your Previous Feedback</h3>
                        </div>
                        <div class="card-body">
                            <?php if (empty($feedbacks)): ?>
                                <div class="alert alert-info">You haven't submitted any feedback yet.</div>
                            <?php else: ?>
                                <div class="previous-feedbacks">
                                    <?php foreach ($feedbacks as $feedback): ?>
                                        <div class="feedback-item">
                                            <div class="feedback-header">
                                                <div class="feedback-rating">
                                                    <?php 
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        if ($i <= $feedback['rating']) {
                                                            echo '<i class="fas fa-star"></i>';
                                                        } else {
                                                            echo '<i class="far fa-star"></i>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="feedback-date">
                                                    <?php echo format_date($feedback['date']); ?>
                                                </div>
                                            </div>
                                            <div class="feedback-text">
                                                <?php echo $feedback['feedback_text']; ?>
                                            </div>
                                            <div class="feedback-event">
                                                <?php if ($feedback['booking_id']): ?>
                                                    <small>For: <?php echo $feedback['event_type'] . ' - ' . $feedback['plan']; ?></small>
                                                <?php else: ?>
                                                    <small>General Feedback</small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                <?php elseif ($page === 'change-password'): ?>
                    <!-- Change Password -->
                    <div class="dashboard-title">
                        <h2>Change Password</h2>
                        <p>Update your account password</p>
                    </div>
                    
                    <?php if (isset($password_error)): ?>
                        <div class="alert alert-danger"><?php echo $password_error; ?></div>
                    <?php endif; ?>
                    
                    <?php if (isset($password_success)): ?>
                        <div class="alert alert-success"><?php echo $password_success; ?></div>
                    <?php endif; ?>
                    
                    <form action="?page=change-password" method="POST" class="needs-validation">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div style="position: relative;">
                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                                <button type="button" class="password-toggle" data-target="#current_password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div style="position: relative;">
                                <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6">
                                <button type="button" class="password-toggle" data-target="#new_password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Password must be at least 6 characters long</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <div style="position: relative;">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6">
                                <button type="button" class="password-toggle" data-target="#confirm_password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
/* Add these styles for badges */
.badge {
    display: inline-block;
    padding: 0.25em 0.6em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}

.badge-primary {
    color: #fff;
    background-color: var(--primary-color);
}

.badge-secondary {
    color: #fff;
    background-color: #6c757d;
}

.badge-success {
    color: #fff;
    background-color: #28a745;
}

.badge-danger {
    color: #fff;
    background-color: #dc3545;
}

.badge-warning {
    color: #212529;
    background-color: #ffc107;
}

.badge-info {
    color: #fff;
    background-color: #17a2b8;
}

/* Star Rating Styles */
.rating-stars {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating-stars input {
    display: none;
}

.rating-stars label {
    cursor: pointer;
    font-size: 1.5rem;
    color: #ddd;
    margin-right: 5px;
}

.rating-stars label:hover,
.rating-stars label:hover ~ label,
.rating-stars input:checked ~ label {
    color: var(--secondary-color);
}

/* Previous Feedback Styles */
.previous-feedbacks {
    max-height: 500px;
    overflow-y: auto;
}

.feedback-item {
    border-bottom: 1px solid var(--border-color);
    padding: 15px 0;
}

.feedback-item:last-child {
    border-bottom: none;
}

.feedback-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.feedback-rating {
    color: var(--secondary-color);
}

.feedback-date {
    color: #777;
    font-size: 0.9rem;
}

.feedback-text {
    margin-bottom: 10px;
}

.feedback-event {
    color: #777;
}

/* Card Styles */
.card {
    background-color: var(--light-color);
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.card-header {
    background-color: #f9f9f9;
    padding: 15px 20px;
    border-bottom: 1px solid var(--border-color);
}

.card-header h3 {
    margin: 0;
    font-size: 1.3rem;
}

.card-body {
    padding: 20px;
}

.mb-3 {
    margin-bottom: 15px;
}

.mb-4 {
    margin-bottom: 20px;
}

.mt-4 {
    margin-top: 20px;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
}

.col-md-6 {
    padding: 0 15px;
    width: 50%;
}

@media (max-width: 768px) {
    .col-md-6 {
        width: 100%;
    }
}

/* Dashboard Section */
.dashboard-section {
    margin-top: 30px;
}

.dashboard-section h3 {
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border-color);
}

/* Text utilities */
.text-right {
    text-align: right;
}

.text-muted {
    color: #6c757d;
}

.small {
    font-size: 0.875em;
}
</style>

<?php include 'includes/footer.php'; ?> 