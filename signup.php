<?php
// Include header
include 'includes/header.php';

// Check if user is already logged in
if (is_user_logged_in()) {
    redirect('user-dashboard.php');
}

// Process registration form
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Please fill in all fields";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (email_exists($email)) {
        $error = "Email already exists. Please use a different email or login";
    } else {
        // Hash password
        $hashed_password = hash_password($password);
        
        // Insert user into database
        $sql = "INSERT INTO users (name, email, password, user_type) VALUES ('$name', '$email', '$hashed_password', 'user')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Registration successful! You can now login.";
            // Redirect to login page after 5 secondsz  
        } else {
            $error = "Error registering account: " . mysqli_error($conn);
        }
    }
}
?>

<!-- Signup Section -->
<section class="section">
    <div class="container">
        <div class="form-container">
            <div class="form-title">
                <h2>Create an Account</h2>
                <p>Join RoyalEvent to book your perfect event!</p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                    <p>Redirecting to login page in <span id="countdown">5</span> seconds...</p>
                    <script>
                        let count = 5;
                        const countdown = setInterval(function() {
                            count--;
                            document.getElementById('countdown').textContent = count;
                            if (count <= 0) {
                                clearInterval(countdown);
                                window.location.href = 'login.php';
                            }
                        }, 1000);
                    </script>
                </div>
            <?php endif; ?>
            
            <?php if (empty($success)): ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="needs-validation">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div style="position: relative;">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Create a password" required minlength="6">
                            <button type="button" class="password-toggle" data-target="#password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="form-text text-muted">Password must be at least 6 characters long</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <div style="position: relative;">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your password" required minlength="6">
                            <button type="button" class="password-toggle" data-target="#confirm_password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <input type="checkbox" name="terms" id="terms" required>
                        <label for="terms">I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a></label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                </form>
            <?php endif; ?>
            
            <div class="form-footer">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?> 