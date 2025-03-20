<?php
// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';

// Start session if not already started
session_start_if_not_started();

// Check if admin is logged in
if (!is_admin_logged_in()) {
    set_flash_message('error', 'Please login to access the admin dashboard');
    redirect('admin-login.php');
}

// Get admin details
$admin_id = $_SESSION['admin_id'];
$admin = get_admin_by_id($admin_id);

// Get current page from URL
$page = isset($_GET['page']) ? clean_input($_GET['page']) : 'dashboard';

// Get database statistics for dashboard
$stats = [];

// Total users
$sql = "SELECT COUNT(*) as count FROM users";
$result = mysqli_query($conn, $sql);
$stats['total_users'] = mysqli_fetch_assoc($result)['count'];

// Total bookings
$sql = "SELECT COUNT(*) as count FROM bookings";
$result = mysqli_query($conn, $sql);
$stats['total_bookings'] = mysqli_fetch_assoc($result)['count'];

// Pending bookings
$sql = "SELECT COUNT(*) as count FROM bookings WHERE status = 'Pending'";
$result = mysqli_query($conn, $sql);
$stats['pending_bookings'] = mysqli_fetch_assoc($result)['count'];

// Total admins
$sql = "SELECT COUNT(*) as count FROM admins";
$result = mysqli_query($conn, $sql);
$stats['total_admins'] = mysqli_fetch_assoc($result)['count'];

// Total feedback
$sql = "SELECT COUNT(*) as count FROM feedback";
$result = mysqli_query($conn, $sql);
$stats['total_feedback'] = mysqli_fetch_assoc($result)['count'];

// Recent users
$sql = "SELECT * FROM users ORDER BY id DESC LIMIT 5";
$result = mysqli_query($conn, $sql);
$recent_users = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $recent_users[] = $row;
    }
}

// Recent bookings
$sql = "SELECT b.*, u.name as user_name 
        FROM bookings b 
        JOIN users u ON b.user_id = u.id 
        ORDER BY b.id DESC LIMIT 5";
$result = mysqli_query($conn, $sql);
$recent_bookings = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $recent_bookings[] = $row;
    }
}

// Process actions
$action = isset($_GET['action']) ? clean_input($_GET['action']) : '';
$delete = isset($_GET['delete']) ? (int)$_GET['delete'] : 0;
$view = isset($_GET['view']) ? (int)$_GET['view'] : 0;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$success_message = '';
$error_message = '';

// Handle booking status update
if ($page === 'manage-bookings' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $booking_id = (int)$_POST['booking_id'];
    $new_status = clean_input($_POST['booking_status']);
    
    // Validate status
    $valid_statuses = ['Pending', 'Confirmed', 'Completed', 'Canceled'];
    if (in_array($new_status, $valid_statuses)) {
        $sql = "UPDATE bookings SET status = '$new_status' WHERE id = $booking_id";
        if (mysqli_query($conn, $sql)) {
            $success_message = "Booking status updated successfully";
        } else {
            $error_message = "Error updating booking status: " . mysqli_error($conn);
        }
    } else {
        $error_message = "Invalid status selected";
    }
}

// Handle user deletion
if ($page === 'manage-users' && $delete > 0) {
    $sql = "DELETE FROM users WHERE id = $delete";
    if (mysqli_query($conn, $sql)) {
        $success_message = "User successfully deleted";
    } else {
        $error_message = "Error deleting user: " . mysqli_error($conn);
    }
}

// Handle admin deletion
if ($page === 'manage-admins' && $delete > 0) {
    // Prevent admin from deleting themselves
    if ($delete == $admin_id) {
        $error_message = "You cannot delete your own admin account";
    } else {
        $sql = "DELETE FROM admins WHERE id = $delete";
        if (mysqli_query($conn, $sql)) {
            $success_message = "Admin successfully deleted";
        } else {
            $error_message = "Error deleting admin: " . mysqli_error($conn);
        }
    }
}

// Handle user view
if ($page === 'manage-users' && $view > 0) {
    $user_sql = "SELECT * FROM users WHERE id = $view";
    $user_result = mysqli_query($conn, $user_sql);
    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_detail = mysqli_fetch_assoc($user_result);
        
        // Get user's bookings
        $bookings_sql = "SELECT * FROM bookings WHERE user_id = $view ORDER BY created_at DESC";
        $bookings_result = mysqli_query($conn, $bookings_sql);
        $user_bookings = [];
        if ($bookings_result && mysqli_num_rows($bookings_result) > 0) {
            while ($row = mysqli_fetch_assoc($bookings_result)) {
                $user_bookings[] = $row;
            }
        }
        
        // Get user's feedback
        $feedback_sql = "SELECT * FROM feedback WHERE user_id = $view ORDER BY date DESC";
        $feedback_result = mysqli_query($conn, $feedback_sql);
        $user_feedback = [];
        if ($feedback_result && mysqli_num_rows($feedback_result) > 0) {
            while ($row = mysqli_fetch_assoc($feedback_result)) {
                $user_feedback[] = $row;
            }
        }
    }
}

// Handle admin creation
if ($page === 'manage-admins' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];
    $role = clean_input($_POST['role']);
    
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $error_message = "Please fill all fields";
    } else {
        // Check if email already exists
        $check_sql = "SELECT * FROM admins WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error_message = "Admin email already exists";
        } else {
            // Hash password
            $hashed_password = hash_password($password);
            
            // Insert new admin
            $insert_sql = "INSERT INTO admins (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";
            if (mysqli_query($conn, $insert_sql)) {
                $success_message = "New admin created successfully";
            } else {
                $error_message = "Error creating admin: " . mysqli_error($conn);
            }
        }
    }
}

// Get data for tables
if ($page === 'manage-users') {
    $users_sql = "SELECT * FROM users ORDER BY id DESC";
    $users_result = mysqli_query($conn, $users_sql);
    $users = [];
    if ($users_result && mysqli_num_rows($users_result) > 0) {
        while ($row = mysqli_fetch_assoc($users_result)) {
            $users[] = $row;
        }
    }
}

if ($page === 'manage-admins') {
    $admins_sql = "SELECT * FROM admins ORDER BY id DESC";
    $admins_result = mysqli_query($conn, $admins_sql);
    $admins = [];
    if ($admins_result && mysqli_num_rows($admins_result) > 0) {
        while ($row = mysqli_fetch_assoc($admins_result)) {
            $admins[] = $row;
        }
    }
}

if ($page === 'manage-bookings') {
    $bookings_sql = "SELECT b.*, u.name as user_name, u.email as user_email 
                    FROM bookings b 
                    JOIN users u ON b.user_id = u.id 
                    ORDER BY b.id DESC";
    $bookings_result = mysqli_query($conn, $bookings_sql);
    $bookings = [];
    if ($bookings_result && mysqli_num_rows($bookings_result) > 0) {
        while ($row = mysqli_fetch_assoc($bookings_result)) {
            $bookings[] = $row;
        }
    }
}

if ($page === 'manage-feedback') {
    $feedback_sql = "SELECT f.*, u.name as user_name, u.email as user_email 
                    FROM feedback f 
                    JOIN users u ON f.user_id = u.id 
                    ORDER BY f.id DESC";
    $feedback_result = mysqli_query($conn, $feedback_sql);
    $feedbacks = [];
    if ($feedback_result && mysqli_num_rows($feedback_result) > 0) {
        while ($row = mysqli_fetch_assoc($feedback_result)) {
            $feedbacks[] = $row;
        }
    }
}

// Include header
include 'includes/admin-header.php';
?>

<div class="admin-container">
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="admin-logo">
            <img src="assets/images/logo/logo.png" alt="RoyalEvent Admin" style="height: 40px;">
            <span>RoyalEvent Admin</span>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="admin-dashboard.php" class="<?php echo $page === 'dashboard' ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="admin-dashboard.php?page=manage-users" class="<?php echo $page === 'manage-users' ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i>
                        <span>Manage Users</span>
                    </a>
                </li>
                <li>
                    <a href="admin-dashboard.php?page=manage-admins" class="<?php echo $page === 'manage-admins' ? 'active' : ''; ?>">
                        <i class="fas fa-user-shield"></i>
                        <span>Manage Admins</span>
                    </a>
                </li>
                <li>
                    <a href="admin-dashboard.php?page=manage-bookings" class="<?php echo $page === 'manage-bookings' ? 'active' : ''; ?>">
                        <i class="fas fa-calendar-check"></i>
                        <span>Manage Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="admin-dashboard.php?page=manage-feedback" class="<?php echo $page === 'manage-feedback' ? 'active' : ''; ?>">
                        <i class="fas fa-comments"></i>
                        <span>Manage Feedback</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="admin-content">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <div class="admin-search">
                <input type="text" placeholder="Search..." disabled>
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="admin-profile">
                <span>Welcome, <?php echo $admin['name']; ?></span>
                <div class="admin-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="admin-main">
            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <?php
            // Include appropriate content based on current page
            switch ($page) {
                case 'manage-users':
                    include 'includes/admin/manage-users.php';
                    break;
                case 'manage-admins':
                    include 'includes/admin/manage-admins.php';
                    break;
                case 'manage-bookings':
                    include 'includes/admin/manage-bookings.php';
                    break;
                case 'manage-feedback':
                    include 'includes/admin/manage-feedback.php';
                    break;
                default:
                    include 'includes/admin/dashboard.php';
                    break;
            }
            ?>
        </div>
    </div>
</div>

<style>
/* Admin Dashboard Styles */
.admin-container {
    display: flex;
    min-height: 100vh;
}

.admin-sidebar {
    width: 250px;
    background-color: var(--primary-color);
    color: var(--light-color);
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    z-index: 1000;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
}

.admin-logo {
    padding: 20px;
    text-align: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.admin-logo span {
    display: block;
    font-size: 1.2rem;
    font-weight: 600;
    margin-top: 10px;
    color: var(--secondary-color);
}

.sidebar-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-nav li {
    margin-bottom: 5px;
}

.sidebar-nav a {
    display: block;
    padding: 12px 20px;
    color: var(--light-color);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.sidebar-nav a i {
    margin-right: 10px;
    font-size: 1.1rem;
    width: 20px;
    text-align: center;
}

.sidebar-nav a:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.sidebar-nav a.active {
    background-color: var(--secondary-color);
    color: var(--primary-color);
    font-weight: 600;
}

.admin-content {
    flex: 1;
    margin-left: 250px;
    display: flex;
    flex-direction: column;
}

.admin-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 30px;
    background-color: var(--light-color);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 100;
}

.admin-search {
    display: flex;
    align-items: center;
    background-color: #f5f5f5;
    border-radius: 30px;
    padding: 5px 15px;
}

.admin-search input {
    border: none;
    background: none;
    padding: 8px 10px;
    outline: none;
    min-width: 250px;
}

.admin-search button {
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
}

.admin-profile {
    display: flex;
    align-items: center;
}

.admin-profile span {
    margin-right: 15px;
    font-weight: 500;
}

.admin-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: var(--primary-color);
    color: var(--light-color);
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.5rem;
}

.admin-main {
    padding: 30px;
    background-color: #f5f5f5;
    flex: 1;
}

/* Dashboard Cards */
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.dashboard-card {
    background-color: var(--light-color);
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
}

.card-icon {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.8rem;
    margin-right: 15px;
}

.card-icon.purple {
    background-color: rgba(75, 0, 130, 0.1);
    color: var(--primary-color);
}

.card-icon.gold {
    background-color: rgba(255, 215, 0, 0.1);
    color: var(--secondary-color);
}

.card-icon.blue {
    background-color: rgba(33, 150, 243, 0.1);
    color: #2196F3;
}

.card-icon.green {
    background-color: rgba(76, 175, 80, 0.1);
    color: #4CAF50;
}

.card-icon.red {
    background-color: rgba(244, 67, 54, 0.1);
    color: #F44336;
}

.card-info {
    flex: 1;
}

.card-value {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.card-label {
    color: #777;
    font-size: 0.9rem;
}

/* Dashboard Tables */
.dashboard-section {
    background-color: var(--light-color);
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border-color);
}

.section-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--primary-color);
}

.view-all {
    color: var(--primary-color);
    font-weight: 500;
    font-size: 0.9rem;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th, 
.admin-table td {
    padding: 12px 15px;
    text-align: left;
}

.admin-table th {
    background-color: #f9f9f9;
    font-weight: 600;
    color: var(--primary-color);
}

.admin-table tr {
    border-bottom: 1px solid var(--border-color);
}

.admin-table tr:last-child {
    border-bottom: none;
}

.admin-table .status {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 500;
}

.admin-table .status.paid {
    background-color: rgba(76, 175, 80, 0.1);
    color: #4CAF50;
}

.admin-table .status.pending {
    background-color: rgba(255, 152, 0, 0.1);
    color: #FF9800;
}

.admin-table .status.canceled {
    background-color: rgba(244, 67, 54, 0.1);
    color: #F44336;
}

.action-btn {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.8rem;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
}

.action-btn.view {
    background-color: rgba(33, 150, 243, 0.1);
    color: #2196F3;
}

.action-btn.view:hover {
    background-color: #2196F3;
    color: var(--light-color);
}

.action-btn.edit {
    background-color: rgba(255, 152, 0, 0.1);
    color: #FF9800;
}

.action-btn.edit:hover {
    background-color: #FF9800;
    color: var(--light-color);
}

.action-btn.delete {
    background-color: rgba(244, 67, 54, 0.1);
    color: #F44336;
}

.action-btn.delete:hover {
    background-color: #F44336;
    color: var(--light-color);
}

/* Form Styles */
.admin-form {
    background-color: var(--light-color);
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

/* Media Queries */
@media (max-width: 768px) {
    .admin-sidebar {
        width: 70px;
        overflow: hidden;
    }
    
    .admin-logo span,
    .sidebar-nav a span {
        display: none;
    }
    
    .admin-content {
        margin-left: 70px;
    }
    
    .admin-search input {
        min-width: 150px;
    }
}
</style>

<script>
// Handle delete and view actions
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    const deleteLinks = document.querySelectorAll('.delete-confirm');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // Handle booking status update form
    const statusForms = document.querySelectorAll('.booking-status-form');
    statusForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const bookingId = formData.get('booking_id');
            const newStatus = formData.get('booking_status');
            
            // Show loading state
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            submitButton.disabled = true;
            
            // Send AJAX request
            fetch('admin-dashboard.php?page=manage-bookings', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                // Check if the response contains success message
                if (html.includes('Booking status updated successfully')) {
                    // Update the status display
                    const statusSpan = document.querySelector(`tr[data-booking-id="${bookingId}"] .status`);
                    if (statusSpan) {
                        statusSpan.className = `status ${newStatus.toLowerCase()}`;
                        statusSpan.textContent = newStatus;
                    }
                    
                    // Show success message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success';
                    alertDiv.textContent = 'Booking status updated successfully';
                    form.parentNode.insertBefore(alertDiv, form);
                    
                    // Remove success message after 3 seconds
                    setTimeout(() => alertDiv.remove(), 3000);
                } else {
                    throw new Error('Failed to update status');
                }
            })
            .catch(error => {
                // Show error message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger';
                alertDiv.textContent = 'Error updating booking status. Please try again.';
                form.parentNode.insertBefore(alertDiv, form);
                
                // Remove error message after 3 seconds
                setTimeout(() => alertDiv.remove(), 3000);
            })
            .finally(() => {
                // Reset button state
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        });
    });

    // View action handling
    const viewLinks = document.querySelectorAll('.action-btn.view');
    viewLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // The view action is handled by the server-side code
            // No need for additional JavaScript handling
        });
    });

    // Close view details
    const closeButtons = document.querySelectorAll('.btn-back');
    closeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // The close action is handled by the server-side code
            // No need for additional JavaScript handling
        });
    });
});
</script>

