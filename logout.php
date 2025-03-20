<?php
// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';

// Start session if not already started
session_start_if_not_started();

// Check if user is logged in
if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
    // Set logout message based on user type
    if (isset($_SESSION['user_id'])) {
        $message = "You have been logged out successfully.";
    } else {
        $message = "Admin has been logged out successfully.";
    }
    
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy the session
    session_destroy();
    
    // Set a flash message with session data erased
    session_start();
    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => $message
    ];
    
    // Redirect to home page
    header("Location: index.php");
    exit;
} else {
    // User not logged in, redirect to home page
    header("Location: index.php");
    exit;
}
?> 