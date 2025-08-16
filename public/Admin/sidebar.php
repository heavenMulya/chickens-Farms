<!-- Updated Sidebar HTML with notification badges -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3 class="sidebar-title">
            <i class="fas fa-tachometer-alt" style="color: #ff9f43;"></i>
            Navigation
        </h3>
        <p class="sidebar-subtitle">Farm Management System</p>
    </div>
    <ul class="sidebar-nav">
        <li>
            <a href="index.php" class="menu-link active">
                <i class="fas fa-tachometer-alt menu-icon"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="/Users/dashboard.php" class="menu-link">
                <i class="fas fa-cash-register menu-icon"></i>
                <span class="menu-text">POS</span>
            </a>
        </li>
        <li>
            <a href="customer_order.php" class="menu-link">
                <i class="fas fa-clipboard-list menu-icon"></i>
                <span class="menu-text">Customer Orders</span>
                <span class="notification-badge" id="ordersBadge">5</span>
                
            </a>
        </li>
        <li>
            <a href="productlist.php" class="menu-link">
                <i class="fas fa-box menu-icon"></i>
                <span class="menu-text">Products</span>
            </a>
        </li>
        <li class="submenu">
            <a href="javascript:void(0);">
                <i class="fas fa-drumstick-bite menu-icon"></i>
                <span class="menu-text">Chickens</span>
                <span class="menu-arrow"></span>
            </a>
            <ul>
                <li><a href="chicken_batchwise.php" class="submenu-link">Chickens BatchWise</a></li>
                <li><a href="chicken_entries.php" class="submenu-link">Chickens Daily Entries</a></li>
            </ul>
        </li>
        <li>
            <a href="eggProduction.php" class="menu-link">
                <i class="fas fa-egg menu-icon"></i>
                <span class="menu-text">Egg Production</span>
            </a>
        </li>
        <li>
            <a href="Users.php" class="menu-link">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-text">Users</span>
            </a>
        </li>
        <li>
            <a href="expnsenses.php" class="menu-link">
                <i class="fas fa-receipt menu-icon"></i>
                <span class="menu-text">Expenses</span>
            </a>
        </li>
        <li>
            <a href="CustomerSubmissions.php" class="menu-link">
                <i class="fas fa-clipboard-list menu-icon"></i>
                <span class="menu-text">Customer Submissions</span>
                <span class="notification-badge" id="submissionsBadge">3</span>
            </a>
        </li>
        <li>
            <a href="report.php" class="menu-link">
                <i class="fas fa-chart-bar menu-icon"></i>
                <span class="menu-text">Reports</span>
            </a>
        </li>
    </ul>
</aside>

<style>
/* Notification Badge CSS */
.notification-badge {
 position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: #ef4444;
            color: white;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.2rem 0.4rem;
            border-radius: 6px;
            min-width: 16px;
            text-align: center;
}

.menu-link {
    position: relative;
}

/* Pulse animation for notification badges */
@keyframes pulse {
    0% {
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }
    50% {
        box-shadow: 0 2px 15px rgba(239, 68, 68, 0.6);
        transform: translateY(-50%) scale(1.1);
    }
    100% {
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        transform: translateY(-50%) scale(1);
    }
}

/* Hide badge when count is 0 */
.notification-badge.hidden {
    display: none;
}

/* Different colors for different types of notifications */
.notification-badge.orders {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
}

.notification-badge.submissions {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
}
</style>

<script>
// JavaScript to update notification badges
function updateNotificationBadge(badgeId, count) {
    const badge = document.getElementById(badgeId);
    if (badge) {
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }
}

// Example usage - you can call these functions when you have real data
document.addEventListener('DOMContentLoaded', function() {
    // Example: Update badges with real counts from your backend
    // updateNotificationBadge('ordersBadge', 5);  // 5 new orders
    // updateNotificationBadge('submissionsBadge', 3);  // 3 new submissions
    
    // Add different colors
    const ordersBadge = document.getElementById('ordersBadge');
    const submissionsBadge = document.getElementById('submissionsBadge');
    
    if (ordersBadge) {
        ordersBadge.classList.add('orders');
    }
    
    if (submissionsBadge) {
        submissionsBadge.classList.add('submissions');
    }
});

// Function to fetch and update notification counts (integrate with your backend)
function fetchNotificationCounts() {
    // Example AJAX call to your backend
    /*
    fetch('get_notification_counts.php')
        .then(response => response.json())
        .then(data => {
            updateNotificationBadge('ordersBadge', data.orders_count);
            updateNotificationBadge('submissionsBadge', data.submissions_count);
        })
        .catch(error => console.error('Error fetching notification counts:', error));
    */
}

// Auto-refresh notification counts every 30 seconds
// setInterval(fetchNotificationCounts, 30000);
</script>