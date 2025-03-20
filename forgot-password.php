<?php
// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';

// Start session if not already started
session_start_if_not_started();

// Initialize variables
$name = '';
$email = '';
$error = '';
$success = '';
$user_type = isset($_GET['type']) ? clean_input($_GET['type']) : 'user';
$user_verified = false;
$user_id = null;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if it's a verification form or password reset form
    if (isset($_POST['verify_user'])) {
        // Get form data for verification
        $name = clean_input($_POST['name']);
        $email = clean_input($_POST['email']);
        $user_type = clean_input($_POST['user_type']);
        
        // Validate inputs
        if (empty($name) || empty($email)) {
            $error = "Please enter both name and email";
        } else {
            // Check if it's a user or admin
            if ($user_type === 'admin') {
                $table = 'admins';
            } else {
                $table = 'users';
            }
            
            // Check if user exists with the given name and email
            $sql = "SELECT * FROM $table WHERE name = '$name' AND email = '$email'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                $user_id = $user['id'];
                $user_verified = true;
            } else {
                $error = "No account found with that name and email combination.";
            }
        }
    } elseif (isset($_POST['reset_password'])) {
        // Get form data for password reset
        $user_id = (int)$_POST['user_id'];
        $user_type = clean_input($_POST['user_type']);
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Validate passwords
        if (empty($new_password) || empty($confirm_password)) {
            $error = "Please enter and confirm your new password";
            $user_verified = true; // Keep the reset form visible
        } elseif ($new_password !== $confirm_password) {
            $error = "Passwords do not match";
            $user_verified = true; // Keep the reset form visible
        } elseif (strlen($new_password) < 6) {
            $error = "Password must be at least 6 characters long";
            $user_verified = true; // Keep the reset form visible
        } else {
            // Hash the new password
            $hashed_password = hash_password($new_password);
            
            // Determine the correct table
            if ($user_type === 'admin') {
                $table = 'admins';
            } else {
                $table = 'users';
            }
            
            // Update user's password
            $update_sql = "UPDATE $table SET password = '$hashed_password' WHERE id = $user_id";
            if (mysqli_query($conn, $update_sql)) {
                $success = "Your password has been successfully reset. You can now login with your new password.";
            } else {
                $error = "An error occurred while resetting your password. Please try again.";
                $user_verified = true; // Keep the reset form visible
            }
        }
    }
}

// Include header
include 'includes/header.php';
?>

<!-- Forgot Password Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Forgot Password</h2>
            <p>Reset your password by verifying your account information</p>
        </div>
        
        <div class="form-container">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <div class="form-footer">
                    <?php if ($user_type === 'admin'): ?>
                        <a href="admin-login.php" class="btn btn-primary btn-block">Go to Admin Login</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary btn-block">Go to Login</a>
                    <?php endif; ?>
                </div>
            <?php elseif ($user_verified): ?>
                <!-- Password Reset Form -->
                <div class="alert alert-success">Account verified! Please set your new password.</div>
                
                <form action="forgot-password.php" method="POST" class="needs-validation">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="user_type" value="<?php echo $user_type; ?>">
                    <input type="hidden" name="reset_password" value="1">
                    
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <div style="position: relative;">
                            <input type="password" id="new_password" name="new_password" class="form-control" required minlength="6">
                            <button type="button" class="password-toggle" data-target="#new_password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Password must be at least 6 characters long</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <div style="position: relative;">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required minlength="6">
                            <button type="button" class="password-toggle" data-target="#confirm_password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                </form>
            <?php else: ?>
                <!-- User Type Tabs -->
                <div class="tabs">
                    <a href="?type=user" class="tab <?php echo $user_type === 'user' ? 'active' : ''; ?>">User</a>
                    <a href="?type=admin" class="tab <?php echo $user_type === 'admin' ? 'active' : ''; ?>">Admin</a>
                </div>
                
                <!-- Account Verification Form -->
                <form action="forgot-password.php" method="POST" class="needs-validation">
                    <input type="hidden" name="user_type" value="<?php echo $user_type; ?>">
                    <input type="hidden" name="verify_user" value="1">
                    
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Verify Account</button>
                </form>
            <?php endif; ?>
            
            <div class="form-footer">
                <p>Remember your password? 
                    <?php if ($user_type === 'admin'): ?>
                        <a href="admin-login.php">Admin Login</a>
                    <?php else: ?>
                        <a href="login.php">Login</a>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</section>

<style>
.tabs {
    display: flex;
    margin-bottom: 20px;
    border-bottom: 1px solid var(--border-color);
}

.tab {
    padding: 10px 20px;
    cursor: pointer;
    flex: 1;
    text-align: center;
    border-bottom: 2px solid transparent;
    transition: all 0.3s ease;
}

.tab.active {
    border-bottom: 2px solid var(--primary-color);
    font-weight: 600;
}

.tab:hover {
    background-color: #f5f5f5;
}
</style>

<script>
// Toggle password visibility
document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.password-toggle');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.querySelector(targetId);
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?> 