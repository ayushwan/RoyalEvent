<!-- Manage Bookings Content -->
<h1 class="page-title">Manage Bookings</h1>

<!-- Filter Controls -->
<div class="filter-controls">
    <div class="filter-group">
        <label for="status-filter">Filter by Status:</label>
        <select id="status-filter" class="form-control">
            <option value="all">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="completed">Completed</option>
            <option value="canceled">Canceled</option>
        </select>
    </div>
    
    <div class="filter-group">
        <label for="event-filter">Filter by Event Type:</label>
        <select id="event-filter" class="form-control">
            <option value="all">All Events</option>
            <option value="wedding">Wedding</option>
            <option value="birthday">Birthday</option>
            <option value="anniversary">Anniversary</option>
            <option value="corporate">Corporate</option>
        </select>
    </div>
    
    <button id="apply-filter" class="btn-primary">Apply Filter</button>
</div>

<!-- Bookings Table -->
<div class="dashboard-section">
    <div class="section-header">
        <div class="section-title">All Bookings</div>
    </div>
    
    <?php if (empty($bookings)): ?>
        <p>No bookings found.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="admin-table booking-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Event Type</th>
                        <th>Plan</th>
                        <th>Date</th>
                        <th>Guest Count</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr class="booking-row" 
                            data-booking-id="<?php echo $booking['id']; ?>"
                            data-status="<?php echo strtolower($booking['status']); ?>"
                            data-event="<?php echo strtolower($booking['event_type']); ?>">
                            <td>#<?php echo $booking['id']; ?></td>
                            <td><?php echo $booking['user_name']; ?></td>
                            <td><?php echo $booking['event_type']; ?></td>
                            <td><?php echo $booking['plan']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($booking['event_date'])); ?></td>
                            <td><?php echo $booking['guest_count']; ?></td>
                            <td><?php echo format_price($booking['total_amount']); ?></td>
                            <td>
                                <span class="status <?php echo strtolower($booking['status']); ?>">
                                    <?php echo $booking['status']; ?>
                                </span>
                            </td>
                            <td>
                                <?php if (isset($_GET['view']) && $_GET['view'] == $booking['id']): ?>
                                    <a href="admin-dashboard.php?page=manage-bookings" class="action-btn view">Close</a>
                                <?php else: ?>
                                    <a href="admin-dashboard.php?page=manage-bookings&view=<?php echo $booking['id']; ?>" class="action-btn view">View</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        
                        <?php if (isset($_GET['view']) && $_GET['view'] == $booking['id']): ?>
                            <tr>
                                <td colspan="9">
                                    <div class="booking-details">
                                        <div class="booking-info">
                                            <h3>Booking Details</h3>
                                            
                                            <div class="booking-grid">
                                                <div class="booking-info-group">
                                                    <h4>Event Information</h4>
                                                    <p><strong>Event Type:</strong> <?php echo $booking['event_type']; ?></p>
                                                    <p><strong>Package:</strong> <?php echo $booking['plan']; ?></p>
                                                    <p><strong>Event Date:</strong> <?php echo date('F d, Y', strtotime($booking['event_date'])); ?></p>
                                                    <p><strong>Guest Count:</strong> <?php echo $booking['guest_count']; ?></p>
                                                    <p><strong>Venue:</strong> <?php echo $booking['venue'] ?: 'To be determined'; ?></p>
                                                </div>
                                                
                                                <div class="booking-info-group">
                                                    <h4>Booking Information</h4>
                                                    <p><strong>Total Amount:</strong> <?php echo format_price($booking['total_amount']); ?></p>
                                                    <p><strong>Booking Status:</strong> 
                                                        <span class="status <?php echo strtolower($booking['status']); ?>">
                                                            <?php echo $booking['status']; ?>
                                                        </span>
                                                    </p>
                                                    <p><strong>Booking Date:</strong> <?php echo date('F d, Y', strtotime($booking['created_at'])); ?></p>
                                                    <p><strong>Reference Number:</strong> <?php echo $booking['reference_number']; ?></p>
                                                </div>
                                                
                                                <div class="booking-info-group">
                                                    <h4>Customer Information</h4>
                                                    <p><strong>Name:</strong> <?php echo $booking['user_name']; ?></p>
                                                    <p><strong>Email:</strong> <?php echo $booking['user_email']; ?></p>
                                                </div>
                                                
                                                <div class="booking-info-group">
                                                    <h4>Additional Information</h4>
                                                    <p><?php echo $booking['message'] ?: 'No additional information provided.'; ?></p>
                                                </div>
                                            </div>
                                            
                                            <div class="booking-actions">
                                                <form action="admin-dashboard.php?page=manage-bookings" method="POST" class="booking-status-form">
                                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                                    <div class="form-group inline">
                                                        <label for="booking_status">Update Status:</label>
                                                        <select name="booking_status" id="booking_status" class="form-control">
                                                            <option value="Pending" <?php echo $booking['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                            <option value="Confirmed" <?php echo $booking['status'] === 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                                            <option value="Completed" <?php echo $booking['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                                            <option value="Canceled" <?php echo $booking['status'] === 'Canceled' ? 'selected' : ''; ?>>Canceled</option>
                                                        </select>
                                                        <button type="submit" name="update_status" class="btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<style>
.filter-controls {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
    align-items: flex-end;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.filter-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.btn-primary{
    font-size: 1.5rem;
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    background-color: var(--primary-color);
    color: white;
}
#apply-filter{
    font-size: 1.5rem;
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    background-color: var(--primary-color);
    color: white;
    
}

.booking-details {
    background-color: #f9f9f9;
    padding: 20px;
    margin: 10px 0;
    border-radius: 5px;
}

.booking-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.booking-info-group h4 {
    color: var(--primary-color);
    margin-top: 0;
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px solid var(--border-color);
}

.booking-actions {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.form-group.inline {
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-group.inline label {
    margin-bottom: 0;
    margin-right: 10px;
}

.form-group.inline .form-control {
    width: auto;
}
</style>

<script>
// Filter bookings
document.addEventListener('DOMContentLoaded', function() {
    const applyFilterBtn = document.getElementById('apply-filter');
    const statusFilter = document.getElementById('status-filter');
    const eventFilter = document.getElementById('event-filter');
    const bookingRows = document.querySelectorAll('.booking-row');
    
    if (applyFilterBtn) {
        applyFilterBtn.addEventListener('click', function() {
            const statusValue = statusFilter.value;
            const eventValue = eventFilter.value;
            
            bookingRows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                const rowEvent = row.getAttribute('data-event');
                
                let showStatus = statusValue === 'all' || rowStatus === statusValue;
                let showEvent = eventValue === 'all' || rowEvent.includes(eventValue);
                
                if (showStatus && showEvent) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script> 