<!-- Manage Feedback Content -->
<h1 class="page-title">Manage Feedback</h1>

<!-- Feedback Table -->
<div class="dashboard-section">
    <div class="section-header">
        <div class="section-title">User Feedback</div>
    </div>
    
    <?php if (empty($feedbacks)): ?>
        <p>No feedback found.</p>
    <?php else: ?>
        <div class="feedback-grid">
            <?php foreach ($feedbacks as $feedback): ?>
                <div class="feedback-card">
                    <div class="feedback-header">
                        <div class="feedback-user">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-info">
                                <h3><?php echo $feedback['user_name']; ?></h3>
                                <p><?php echo $feedback['user_email']; ?></p>
                            </div>
                        </div>
                        <div class="feedback-date">
                            <?php echo date('M d, Y', strtotime($feedback['date'])); ?>
                        </div>
                    </div>
                    
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
                    
                    <div class="feedback-body">
                        <p class="feedback-text">
                            "<?php echo htmlspecialchars($feedback['feedback_text']); ?>"
                        </p>
                    </div>
                    
                    <?php if ($feedback['booking_id']): ?>
                        <?php
                        // Get booking details
                        $booking_id = $feedback['booking_id'];
                        $booking_sql = "SELECT * FROM bookings WHERE id = $booking_id";
                        $booking_result = mysqli_query($conn, $booking_sql);
                        $booking = mysqli_fetch_assoc($booking_result);
                        ?>
                        <?php if ($booking): ?>
                            <div class="feedback-booking">
                                <p><strong>Related Booking:</strong> 
                                    <?php echo $booking['event_type']; ?> - 
                                    <?php echo $booking['plan']; ?> (
                                    <?php echo date('M d, Y', strtotime($booking['event_date'])); ?>)
                                </p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Feedback Analytics -->
<div class="dashboard-section">
    <div class="section-header">
        <div class="section-title">Feedback Analytics</div>
    </div>
    
    <?php
    // Calculate average rating
    $average_rating = 0;
    $total_ratings = 0;
    $rating_counts = [0, 0, 0, 0, 0];
    
    if (!empty($feedbacks)) {
        foreach ($feedbacks as $feedback) {
            $rating = $feedback['rating'];
            $total_ratings += $rating;
            $rating_counts[$rating - 1]++;
        }
        $average_rating = $total_ratings / count($feedbacks);
    }
    ?>
    
    <div class="analytics-container">
        <div class="analytics-summary">
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="summary-details">
                    <div class="summary-value"><?php echo number_format($average_rating, 1); ?></div>
                    <div class="summary-label">Average Rating</div>
                </div>
            </div>
            
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fas fa-comment"></i>
                </div>
                <div class="summary-details">
                    <div class="summary-value"><?php echo count($feedbacks); ?></div>
                    <div class="summary-label">Total Feedback</div>
                </div>
            </div>
        </div>
        
        <div class="rating-breakdown">
            <h3>Rating Breakdown</h3>
            
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <?php
                $count = $rating_counts[$i - 1];
                $percentage = !empty($feedbacks) ? ($count / count($feedbacks) * 100) : 0;
                ?>
                <div class="rating-row">
                    <div class="rating-label"><?php echo $i; ?> star</div>
                    <div class="rating-bar-container">
                        <div class="rating-bar" style="width: <?php echo $percentage; ?>%"></div>
                    </div>
                    <div class="rating-count"><?php echo $count; ?></div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>

<style>
.feedback-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.feedback-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    transition: transform 0.3s ease;
}

.feedback-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
}

.feedback-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
}

.feedback-user {
    display: flex;
    align-items: center;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: var(--primary-color);
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 10px;
}
.user-info{
    background-color: white;
}

.user-info h3 {
    margin: 0;
    font-size: 1rem;
}

.user-info p {
    margin: 0;
    font-size: 0.8rem;
    color: #777;
}

.feedback-date {
    font-size: 0.8rem;
    color: #777;
}

.feedback-rating {
    color: var(--secondary-color);
    font-size: 1.2rem;
    margin-bottom: 15px;
}

.feedback-text {
    font-style: italic;
    margin-bottom: 15px;
}

.feedback-booking {
    font-size: 0.9rem;
    color: #666;
    border-top: 1px solid var(--border-color);
    padding-top: 10px;
    margin-top: 10px;
}

/* Analytics Styles */
.analytics-container {
    margin-top: 20px;
}

.analytics-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.summary-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    display: flex;
    align-items: center;
}

.summary-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background-color: rgba(75, 0, 130, 0.1);
    color: var(--primary-color);
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.5rem;
    margin-right: 15px;
}

.summary-details {
    flex: 1;
}

.summary-value {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 5px;
    color: var(--primary-color);
}

.summary-label {
    font-size: 0.9rem;
    color: #777;
}

.rating-breakdown {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.rating-breakdown h3 {
    margin-top: 0;
    margin-bottom: 20px;
    color: var(--primary-color);
}

.rating-row {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.rating-label {
    width: 60px;
}

.rating-bar-container {
    flex: 1;
    height: 10px;
    background-color: #f1f1f1;
    border-radius: 5px;
    margin: 0 15px;
}

.rating-bar {
    height: 100%;
    background-color: var(--secondary-color);
    border-radius: 5px;
}

.rating-count {
    width: 30px;
    text-align: right;
}
</style> 