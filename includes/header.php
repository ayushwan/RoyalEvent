<?php
// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';

// Start session if not already started
session_start_if_not_started();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoyalEvent - Luxury Event Management</title>
    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Header Section -->
    <header class="site-header">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="index.php">
                        <img src="assets/images/logo/logo.png" alt="RoyalEvent Logo" style="height: 40px; margin-right: 10px;">
                        <span class="logo-text">Royal<span class="highlight">Event</span></span>
                    </a>
                </div>
                <nav class="main-navigation">
                    <ul class="nav-menu">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="plans.php">Pricing</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <?php if(is_user_logged_in()): ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle">
                                    <i class="fas fa-user"></i> <?php echo $_SESSION['user_name']; ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="user-dashboard.php">Dashboard</a></li>
                                    <li><a href="user-dashboard.php?page=profile">My Profile</a></li>
                                    <li><a href="user-dashboard.php?page=bookings">My Bookings</a></li>
                                    <li><a href="user-dashboard.php?page=feedback">My Feedback</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li><a href="login.php" class="btn btn-primary btn-sm">Login</a></li>
                            <li><a href="signup.php" class="btn btn-secondary btn-sm">Sign Up</a></li>
                        <?php endif; ?>
                    </ul>
                    <div class="mobile-menu-toggle">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="plans.php">Pricing</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if(is_user_logged_in()): ?>
                <li><a href="user-dashboard.php">Dashboard</a></li>
                <li><a href="user-dashboard.php?page=profile">My Profile</a></li>
                <li><a href="user-dashboard.php?page=bookings">My Bookings</a></li>
                <li><a href="user-dashboard.php?page=feedback">My Feedback</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </div>
    
    <!-- Main Content -->
    <main>
        <!-- Flash Messages -->
        <div class="container">
            <?php display_flash_message(); ?>
        </div> 