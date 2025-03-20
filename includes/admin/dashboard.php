<!-- Dashboard Content -->
<h1 class="page-title">Dashboard</h1>

<!-- Statistics Cards -->
<div class="dashboard-cards">
    <div class="dashboard-card">
        <div class="card-icon purple">
            <i class="fas fa-users"></i>
        </div>
        <div class="card-info">
            <div class="card-value"><?php echo $stats['total_users']; ?></div>
            <div class="card-label">Total Users</div>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-icon gold">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="card-info">
            <div class="card-value"><?php echo $stats['total_bookings']; ?></div>
            <div class="card-label">Total Bookings</div>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-icon blue">
            <i class="fas fa-clock"></i>
        </div>
        <div class="card-info">
            <div class="card-value"><?php echo $stats['pending_bookings']; ?></div>
            <div class="card-label">Pending Bookings</div>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-icon green">
            <i class="fas fa-comments"></i>
        </div>
        <div class="card-info">
            <div class="card-value"><?php echo $stats['total_feedback']; ?></div>
            <div class="card-label">User Feedback</div>
        </div>
    </div>
</div>

<!-- Recent Bookings Section -->
<div class="dashboard-section">
    <div class="section-header">
        <div class="section-title">Recent Bookings</div>
        <a href="admin-dashboard.php?page=manage-bookings" class="view-all">View All</a>
    </div>
    
    <?php if (empty($recent_bookings)): ?>
        <p>No bookings found.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Event Type</th>
                        <th>Plan</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_bookings as $booking): ?>
                        <tr>
                            <td>#<?php echo $booking['id']; ?></td>
                            <td><?php echo $booking['user_name']; ?></td>
                            <td><?php echo $booking['event_type']; ?></td>
                            <td><?php echo $booking['plan']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($booking['event_date'])); ?></td>
                            <td>
                                <span class="status <?php echo strtolower($booking['status']); ?>">
                                    <?php echo $booking['status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="admin-dashboard.php?page=manage-bookings&view=<?php echo $booking['id']; ?>" class="action-btn view">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Recent Users Section -->
<div class="dashboard-section">
    <div class="section-header">
        <div class="section-title">Recent Users</div>
        <a href="admin-dashboard.php?page=manage-users" class="view-all">View All</a>
    </div>
    
    <?php if (empty($recent_users)): ?>
        <p>No users found.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_users as $user): ?>
                        <tr>
                            <td>#<?php echo $user['id']; ?></td>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <a href="admin-dashboard.php?page=manage-users&view=<?php echo $user['id']; ?>" class="action-btn view">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- <style>
.page-title {
    margin-bottom: 30px;
    color: var(--primary-color);
    font-size: 2rem;
}
</style>  -->