<!-- Manage Admins Content -->
<h1 class="page-title">Manage Admins</h1>


<!-- Admins Table -->
<div class="dashboard-section">
    <div class="section-header">
        <div class="section-title">All Admins</div>
    </div>
    
    <?php if (empty($admins)): ?>
        <p>No admins found.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin_row): ?>
                        <tr>
                            <td>#<?php echo $admin_row['id']; ?></td>
                            <td><?php echo $admin_row['name']; ?></td>
                            <td><?php echo $admin_row['username']; ?></td>
                            <td><?php echo $admin_row['email']; ?></td>
                            <td>
                                <?php if (count($admins) > 1 && $admin_row['id'] != $admin_id): ?>
                                    <a href="admin-dashboard.php?page=manage-admins&delete=<?php echo $admin_row['id']; ?>" class="action-btn delete delete-confirm" title="Delete Admin">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="action-btn disabled" title="Cannot delete your own account">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<style>
.form-container {
    padding: 20px;
}

.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    flex: 1;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #555;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--border-color);
    border-radius: 5px;
    font-size: 1rem;
}

.form-group input:focus {
    border-color: var(--primary-color);
    outline: none;
}

.form-actions {
    margin-top: 20px;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #3a0066;
}

.alert {
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.action-btn.disabled {
    background-color: #e9ecef;
    color: #adb5bd;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
        gap: 10px;
    }
}
</style> 