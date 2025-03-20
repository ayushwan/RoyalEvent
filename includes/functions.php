<?php
// Start session if not already started
function session_start_if_not_started() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

// Check if user is logged in
function is_user_logged_in() {
    session_start_if_not_started();
    return isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'user';
}

// Check if admin is logged in
function is_admin_logged_in() {
    session_start_if_not_started();
    return isset($_SESSION['admin_id']);
}

// Redirect to specific page
function redirect($location) {
    header("Location: {$location}");
    exit;
}

// Clean user input to prevent SQL injection and XSS
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if(isset($conn)) {
        $data = mysqli_real_escape_string($conn, $data);
    }
    return $data;
}

// Generate random string (for tokens, etc.)
function generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Format price with currency symbol
function format_price($amount) {
    return '₹' . number_format($amount, 2);
}

// Format date to readable format
function format_date($date) {
    return date('F j, Y', strtotime($date));
}

// Set flash message
function set_flash_message($type, $message) {
    session_start_if_not_started();
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
}

// Get and clear flash message
function get_flash_message() {
    session_start_if_not_started();
    if(isset($_SESSION['flash_message'])) {
        $flash_message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $flash_message;
    }
    return null;
}

// Display flash message
function display_flash_message() {
    $flash_message = get_flash_message();
    if($flash_message) {
        $type = $flash_message['type'];
        $message = $flash_message['message'];
        echo "<div class='alert alert-{$type}'>{$message}</div>";
    }
}

// Get user by ID
function get_user_by_id($user_id) {
    global $conn;
    $user_id = (int)$user_id;
    $query = "SELECT * FROM users WHERE id = {$user_id}";
    $result = mysqli_query($conn, $query);
    
    if($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

// Get admin by ID
function get_admin_by_id($admin_id) {
    global $conn;
    $admin_id = (int)$admin_id;
    $query = "SELECT * FROM admins WHERE id = {$admin_id}";
    $result = mysqli_query($conn, $query);
    
    if($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

// Check if an email exists in users table
function email_exists($email) {
    global $conn;
    $email = clean_input($email);
    $query = "SELECT id FROM users WHERE email = '{$email}'";
    $result = mysqli_query($conn, $query);
    
    return mysqli_num_rows($result) > 0;
}

// Hash password
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verify password
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// Get event types
function get_event_types() {
    return ['Wedding', 'Birthday', 'Anniversary', 'Corporate Event'];
}

// Get plan types
function get_plan_types() {
    return ['Basic', 'Premium', 'Luxury'];
}

// Get event price by type and plan
function get_event_price($event_type, $plan) {
    global $conn;
    $event_type = clean_input($event_type);
    $plan = clean_input($plan);
    
    $query = "SELECT price FROM pricing WHERE event_type = '{$event_type}' AND plan = '{$plan}'";
    $result = mysqli_query($conn, $query);
    
    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['price'];
    }
    return 0;
}


// Get booking by ID
function get_booking_by_id($booking_id, $user_id) {
    global $conn;
    $booking_id = (int)$booking_id;
    $user_id = (int)$user_id;
    
    $query = "SELECT * FROM bookings WHERE id = {$booking_id}";
    
    // If user_id is provided, ensure booking belongs to this user
    if ($user_id > 0) {
        $query .= " AND user_id = {$user_id}";
    }
    
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

// Get all bookings for a user
function get_user_bookings($user_id, $limit = 0) {
    global $conn;
    $user_id = (int)$user_id;
    
    $query = "SELECT * FROM bookings WHERE user_id = {$user_id} ORDER BY created_at DESC";
    
    if ($limit > 0) {
        $query .= " LIMIT {$limit}";
    }
    
    $result = mysqli_query($conn, $query);
    $bookings = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $bookings[] = $row;
        }
    }
    
    return $bookings;
}

// Get all bookings (admin function)
function get_all_bookings($limit = 0, $status = '') {
    global $conn;
    
    $query = "SELECT b.*, u.name as user_name, u.email as user_email 
              FROM bookings b 
              JOIN users u ON b.user_id = u.id";
              
    if (!empty($status)) {
        $status = clean_input($status);
        $query .= " WHERE b.status = '{$status}'";
    }
    
    $query .= " ORDER BY b.created_at DESC";
    
    if ($limit > 0) {
        $query .= " LIMIT {$limit}";
    }
    
    $result = mysqli_query($conn, $query);
    $bookings = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $bookings[] = $row;
        }
    }
    
    return $bookings;
}

// Get booking statuses
function get_booking_statuses() {
    return ['Pending', 'Confirmed', 'Completed', 'Canceled'];
}

// Format booking status with colored badge
function format_booking_status($status) {
    $status_lower = strtolower($status);
    $badge_color = 'secondary';
    
    switch ($status_lower) {
        case 'pending':
            $badge_color = 'warning';
            break;
        case 'confirmed':
            $badge_color = 'info';
            break;
        case 'completed':
            $badge_color = 'success';
            break;
        case 'canceled':
            $badge_color = 'danger';
            break;
    }
    
    return "<span class='status {$status_lower}'>{$status}</span>";
}

// Calculate days remaining until event
function days_until_event($event_date) {
    $now = time();
    $event_time = strtotime($event_date);
    $days_remaining = ceil(($event_time - $now) / 86400);
    
    return max(0, $days_remaining);
}

// Generate booking reference number
function generate_booking_reference() {
    return 'BKG-' . strtoupper(bin2hex(random_bytes(5)));
}
?> 