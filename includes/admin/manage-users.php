<!-- Manage Users Content -->
<h1 class="page-title">Manage Users</h1>

<!-- Users Table -->
<div class="dashboard-section">
    <div class="section-header">
        <div class="section-title">All Users</div>
        <div class="section-actions">
            <input type="text" id="userSearch" placeholder="Search users..." class="search-input">
        </div>
    </div>
    
    <?php if (empty($users)): ?>
        <p>No users found.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="admin-table" id="usersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Registration Date</th>
                        <th>Bookings</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <?php
                        // Get booking count for this user
                        $user_id = $user['id'];
                        $booking_count_query = "SELECT COUNT(*) as count FROM bookings WHERE user_id = $user_id";
                        $booking_count_result = mysqli_query($conn, $booking_count_query);
                        $booking_count = mysqli_fetch_assoc($booking_count_result)['count'];
                        ?>
                        <tr>
                            <td>#<?php echo $user['id']; ?></td>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['phone']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                            <td><?php echo $booking_count; ?></td>
                            <td>
                                <a href="admin-dashboard.php?page=manage-users&view=<?php echo $user['id']; ?>" class="action-btn view" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="admin-dashboard.php?page=manage-users&delete=<?php echo $user['id']; ?>" class="action-btn delete delete-confirm" title="Delete User">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php if (isset($_GET['view']) && isset($user_detail)): ?>
    <!-- User Details -->
    <div class="dashboard-section">
        <div class="section-header">
            <div class="section-title">User Details</div>
            <a href="admin-dashboard.php?page=manage-users" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
        
        <div class="user-details">
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info">
                    <h2><?php echo $user_detail['name']; ?></h2>
                    <p><i class="fas fa-envelope"></i> <?php echo $user_detail['email']; ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo $user_detail['phone']; ?></p>
                    <p><i class="fas fa-calendar"></i> Joined: <?php echo date('F d, Y', strtotime($user_detail['created_at'])); ?></p>
                </div>
            </div>
            
            <!-- User Bookings -->
            <div class="user-bookings">
                <h3>Bookings</h3>
                
                <?php if (empty($user_bookings)): ?>
                    <p>No bookings found for this user.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Event Type</th>
                                    <th>Plan</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_bookings as $booking): ?>
                                    <tr>
                                        <td>#<?php echo $booking['id']; ?></td>
                                        <td><?php echo $booking['event_type']; ?></td>
                                        <td><?php echo $booking['plan']; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($booking['event_date'])); ?></td>
                                        <td><?php echo format_price($booking['total_amount']); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo strtolower($booking['status']); ?>">
                                                <?php echo $booking['status']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="admin-dashboard.php?page=manage-bookings&view=<?php echo $booking['id']; ?>" class="action-btn view">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- User Feedback -->
            <?php if (!empty($user_feedback)): ?>
                <div class="dashboard-section">
                    <div class="section-header">
                        <div class="section-title">User Feedback</div>
                    </div>
                    <div class="feedback-grid">
                        <?php foreach ($user_feedback as $feedback): ?>
                            <div class="feedback-box">
                                <div class="feedback-header">
                                    <div class="feedback-date">
                                        <i class="fas fa-calendar"></i>
                                        <?php echo date('M d, Y', strtotime($feedback['date'])); ?>
                                    </div>
                                    <div class="feedback-rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?php echo $i <= $feedback['rating'] ? 'filled' : ''; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="feedback-content">
                                    <?php echo htmlspecialchars($feedback['feedback_text']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<style>
.search-input {
    padding: 8px 15px;
    border: 1px solid var(--border-color);
    border-radius: 5px;
    width: 250px;
}

.user-details {
    padding: 20px;
}

.user-profile {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border-color);
}

.user-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: var(--primary-color);
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 2.5rem;
    margin-right: 20px;
}
.user-info{
    background-color: white;
    color: black;
    padding: 10px;
    border-radius: 10px;
}   

.user-info h2 {
    margin-top: 0;
    margin-bottom: 10px;
    color: var(--primary-color);
}

.user-info p {
    margin: 5px 0;
    color: #555;
}

.user-info p i {
    width: 20px;
    color: var(--primary-color);
}

.user-bookings,
.user-feedback {
    margin-bottom: 30px;
}

.user-bookings h3,
.user-feedback h3 {
    color: var(--primary-color);
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border-color);
}

.feedback-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.feedback-item {
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.feedback-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.feedback-date {
    color: #777;
    font-size: 0.9rem;
}

.feedback-rating {
    color: var(--secondary-color);
}

.feedback-text {
    font-style: italic;
    margin-bottom: 10px;
}

.feedback-booking {
    font-size: 0.9rem;
    color: #555;
}

.feedback-booking a {
    color: var(--primary-color);
    text-decoration: none;
}

.feedback-booking a:hover {
    text-decoration: underline;
}

.btn-back {
    background-color: transparent;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
    border-radius: 5px;
    padding: 5px 15px;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background-color: var(--primary-color);
    color: white;
}

/* Status Badge Styles */
.status-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
    text-transform: capitalize;
}

.status-badge.pending {
    background-color: #fff3cd;
    color: #856404;
}

.status-badge.confirmed {
    background-color: #cce5ff;
    color: #004085;
}

.status-badge.completed {
    background-color: #d4edda;
    color: #155724;
}

.status-badge.canceled {
    background-color: #f8d7da;
    color: #721c24;
}

/* Rating Stars */
.rating {
    color: #ffc107;
}

.rating .fa-star {
    color: #ddd;
}

.rating .fa-star.filled {
    color: #ffc107;
}

/* Table Responsive */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Action Buttons */
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 4px;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease;
}

.action-btn.view {
    background-color: #17a2b8;
}

.action-btn.view:hover {
    background-color: #138496;
}

/* Feedback Box Styles */
.feedback-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px 0;
}

.feedback-box {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.feedback-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
}

.feedback-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.feedback-date {
    color: #666;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

.feedback-date i {
    color: var(--primary-color);
}

.feedback-rating {
    color: #ffc107;
}

.feedback-rating .fa-star {
    color: #ddd;
    margin-left: 2px;
}

.feedback-rating .fa-star.filled {
    color: #ffc107;
}

.feedback-content {
    color: #333;
    line-height: 1.6;
    font-size: 0.95rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .feedback-grid {
        grid-template-columns: 1fr;
    }
    
    .feedback-box {
        margin-bottom: 15px;
    }
}
</style>

<script>
// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('userSearch');
    const table = document.getElementById('usersTable');
    
    if (searchInput && table) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});
</script> 