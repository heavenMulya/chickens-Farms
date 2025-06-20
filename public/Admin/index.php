<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #16a085 0%, #f4d03f 100%);
            min-height: 100vh;
            padding: 10px;
        }

        .dashboard {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 20px;
            min-height: calc(100vh - 20px);
        }

        .sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: slideInLeft 0.8s ease-out;
        }

        .main-content {
            display: grid;
            grid-template-rows: auto 1fr;
            gap: 20px;
            animation: slideInRight 0.8s ease-out;
        }

        .top-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .bottom-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .stats-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .table-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .table th {
            background: rgba(22, 160, 133, 0.1);
            font-weight: 600;
            color: #148f77;
        }

        .table tbody tr:hover {
            background: rgba(22, 160, 133, 0.05);
            transition: background 0.3s ease;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .card:hover::before {
            left: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 40px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #148f77, #16a085);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            margin: 5px 0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-item:hover {
            background: linear-gradient(135deg, #148f77, #16a085);
            color: white;
            transform: translateX(5px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #148f77, #16a085);
            color: white;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #148f77, #16a085);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .stat-card {
            text-align: center;
            position: relative;
        }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #148f77, #16a085);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: countUp 2s ease-out;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .stat-change {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
        }

        .stat-change.positive {
            color: #10b981;
        }

        .stat-change.negative {
            color: #ef4444;
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin-top: 20px;
        }

        .chart-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            margin: 10px 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #148f77, #16a085);
            border-radius: 4px;
            transition: width 2s ease-out;
            animation: progressAnimation 2s ease-out;
        }

        .metric-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .metric-row:last-child {
            border-bottom: none;
        }

        .metric-label {
            font-weight: 500;
            color: #374151;
        }

        .metric-value {
            font-weight: 600;
            color: #148f77;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            background: #ef4444;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: white;
            animation: pulse 2s infinite;
        }

        @keyframes slideInLeft {
            from { transform: translateX(-100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideInRight {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes countUp {
            from { transform: scale(0.5); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        @keyframes progressAnimation {
            from { width: 0; }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .floating-circle:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-circle:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-circle:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .search-box {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 10px 15px;
            margin-bottom: 20px;
        }

        .search-box input {
            background: none;
            border: none;
            outline: none;
            color: #333;
            flex: 1;
            margin-left: 10px;
        }

        .search-box input::placeholder {
            color: #999;
        }

        @media (max-width: 1200px) {
            .dashboard {
                max-width: 100%;
                padding: 0 10px;
            }
            
            .top-section {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .dashboard {
                grid-template-columns: 1fr;
                height: auto;
                gap: 15px;
            }
            
            .sidebar {
                order: 2;
                padding: 20px;
            }
            
            .bottom-section {
                grid-template-columns: 1fr;
            }
            
            .stats-section {
                grid-template-columns: 1fr;
            }
            
            .top-section {
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 5px;
            }
            
            .dashboard {
                gap: 10px;
                min-height: calc(100vh - 10px);
            }
            
            .sidebar {
                padding: 15px;
            }
            
            .card {
                padding: 15px;
            }
            
            .header {
                padding: 15px;
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .header-title {
                font-size: 24px;
            }
            
            .top-section {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .stat-value {
                font-size: 28px;
            }
            
            .table-container {
                overflow-x: auto;
            }
            
            .table {
                min-width: 600px;
            }
            
            .table th,
            .table td {
                padding: 10px 8px;
                font-size: 14px;
            }
            
            .nav-item {
                padding: 12px;
                font-size: 14px;
            }
            
            .logo-text {
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            .dashboard {
                gap: 8px;
            }
            
            .card {
                padding: 12px;
                border-radius: 15px;
            }
            
            .sidebar {
                padding: 12px;
            }
            
            .header {
                padding: 12px;
            }
            
            .header-title {
                font-size: 20px;
            }
            
            .stat-value {
                font-size: 24px;
            }
            
            .chart-title {
                font-size: 16px;
            }
            
            .nav-item {
                padding: 10px;
                font-size: 13px;
            }
            
            .logo {
                margin-bottom: 20px;
            }
            
            .logo-text {
                font-size: 18px;
            }
            
            .user-profile {
                flex-direction: column;
                gap: 10px;
            }
            
            .table th,
            .table td {
                padding: 8px 6px;
                font-size: 12px;
            }
            
            .status-badge {
                padding: 2px 8px;
                font-size: 10px;
            }
            
            .metric-row {
                padding: 10px 0;
            }
        }

        @media (max-width: 360px) {
            .stat-value {
                font-size: 20px;
            }
            
            .chart-container {
                height: 250px;
            }
            
            .table {
                min-width: 500px;
            }
            
            .nav-item span {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo">
                <div class="logo-icon">A</div>
                <div class="logo-text">Analytics</div>
            </div>

            <div class="search-box">
                <span>🔍</span>
                <input type="text" placeholder="Search...">
            </div>

            <nav>
                <div class="nav-item active">
                    <div class="nav-icon">📊</div>
                    <span>Dashboard</span>
                </div>
                <div class="nav-item">
                   
                    <div class="nav-icon">📈</div>
                    <a href="chickensBatch.php"> <span>Chickens</span>
    </a>
                </div>

                <div class="nav-item">
                    <div class="nav-icon">👥</div>
                    <span>Users</span>
                    <div class="notification-badge">3</div>
                </div>
                <div class="nav-item">
                    <div class="nav-icon">💰</div>
                    <span>Revenue</span>
                </div>
                <div class="nav-item">
                    <div class="nav-icon">📱</div>
                    <span>Products</span>
                </div>
                <div class="nav-item">
                    <div class="nav-icon">📋</div>
                    <span>Orders</span>
                    <div class="notification-badge">12</div>
                </div>
                <div class="nav-item">
                    <div class="nav-icon">⚙️</div>
                    <span>Settings</span>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <div>
                    <h1 class="header-title">Dashboard Overview</h1>
                    <p style="color: #666; margin-top: 5px;">Welcome back! Here's what's happening with your business today.</p>
                </div>
                <div class="user-profile">
                    <div style="text-align: right; margin-right: 10px;">
                        <div style="font-weight: 600; color: #333;">John Doe</div>
                        <div style="font-size: 12px; color: #666;">Administrator</div>
                    </div>
                    <div class="user-avatar">JD</div>
                </div>
            </header>

            <div class="top-section">
                <div class="card stat-card">
                    <div class="stat-value" data-target="24,586">0</div>
                    <div class="stat-label">Total Users</div>
                    <div class="stat-change positive">
                        <span>↗</span>
                        <span>+12.5%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 85%"></div>
                    </div>
                </div>

                <div class="card stat-card">
                    <div class="stat-value" data-target="4,892">0</div>
                    <div class="stat-label">Active Sessions</div>
                    <div class="stat-change positive">
                        <span>↗</span>
                        <span>+8.2%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 72%"></div>
                    </div>
                </div>

                <div class="card stat-card">
                    <div class="stat-value" data-target="156,249">0</div>
                    <div class="stat-label">Page Views</div>
                    <div class="stat-change negative">
                        <span>↘</span>
                        <span>-2.1%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 91%"></div>
                    </div>
                </div>

                <div class="card stat-card">
                    <div class="stat-value" data-target="98.7">0</div>
                    <div class="stat-label">Uptime %</div>
                    <div class="stat-change positive">
                        <span>↗</span>
                        <span>+0.3%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 98.7%"></div>
                    </div>
                </div>
            </div>

            <div class="stats-section">
                <div class="card">
                    <h3 class="chart-title">Today's Statistics</h3>
                    <div style="margin-top: 20px;">
                        <div class="metric-row">
                            <span class="metric-label">📊 Total Sales</span>
                            <span class="metric-value">$12,847</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">👥 New Customers</span>
                            <span class="metric-value">247</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">📦 Orders Processed</span>
                            <span class="metric-value">89</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">💰 Revenue Growth</span>
                            <span class="metric-value">+15.8%</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">🎯 Conversion Rate</span>
                            <span class="metric-value">4.2%</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h3 class="chart-title">Performance Metrics</h3>
                    <div style="margin-top: 20px;">
                        <div class="metric-row">
                            <span class="metric-label">⚡ Server Response</span>
                            <span class="metric-value">142ms</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">🔄 Cache Hit Rate</span>
                            <span class="metric-value">97.3%</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">📱 Mobile Users</span>
                            <span class="metric-value">68.4%</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">🌍 Global Reach</span>
                            <span class="metric-value">45 Countries</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">⭐ User Rating</span>
                            <span class="metric-value">4.8/5.0</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <h3 class="chart-title">Recent Order History</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ORD-001</td>
                            <td>Alice Johnson</td>
                            <td>Premium Headphones</td>
                            <td>$299.99</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                            <td>2025-06-20</td>
                        </tr>
                        <tr>
                            <td>#ORD-002</td>
                            <td>Bob Smith</td>
                            <td>Gaming Mouse</td>
                            <td>$79.99</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>2025-06-20</td>
                        </tr>
                        <tr>
                            <td>#ORD-003</td>
                            <td>Carol Davis</td>
                            <td>Wireless Keyboard</td>
                            <td>$149.99</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                            <td>2025-06-19</td>
                        </tr>
                        <tr>
                            <td>#ORD-004</td>
                            <td>David Wilson</td>
                            <td>4K Monitor</td>
                            <td>$599.99</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>2025-06-19</td>
                        </tr>
                        <tr>
                            <td>#ORD-005</td>
                            <td>Emma Brown</td>
                            <td>Laptop Stand</td>
                            <td>$89.99</td>
                            <td><span class="status-badge status-cancelled">Cancelled</span></td>
                            <td>2025-06-18</td>
                        </tr>
                        <tr>
                            <td>#ORD-006</td>
                            <td>Frank Miller</td>
                            <td>USB-C Hub</td>
                            <td>$49.99</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                            <td>2025-06-18</td>
                        </tr>
                        <tr>
                            <td>#ORD-007</td>
                            <td>Grace Lee</td>
                            <td>Smart Watch</td>
                            <td>$399.99</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>2025-06-17</td>
                        </tr>
                        <tr>
                            <td>#ORD-008</td>
                            <td>Henry Clark</td>
                            <td>Bluetooth Speaker</td>
                            <td>$129.99</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                            <td>2025-06-17</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bottom-section">
                <div class="card">
                    <h3 class="chart-title">Revenue Analytics</h3>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="card">
                    <h3 class="chart-title">Key Metrics</h3>
                    <div style="margin-top: 20px;">
                        <div class="metric-row">
                            <span class="metric-label">Conversion Rate</span>
                            <span class="metric-value">3.24%</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">Avg. Session Duration</span>
                            <span class="metric-value">4m 32s</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">Bounce Rate</span>
                            <span class="metric-value">42.8%</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">New vs Returning</span>
                            <span class="metric-value">68% / 32%</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">Mobile Traffic</span>
                            <span class="metric-value">76.4%</span>
                        </div>
                        <div class="metric-row">
                            <span class="metric-label">Top Source</span>
                            <span class="metric-value">Google</span>
                        </div>
                    </div>

                    <div style="margin-top: 30px;">
                        <h4 style="margin-bottom: 15px; color: #333;">Traffic Sources</h4>
                        <div style="margin-bottom: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span style="font-size: 14px;">Organic Search</span>
                                <span style="font-size: 14px; font-weight: 600;">54%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 54%; animation-delay: 0.5s;"></div>
                            </div>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span style="font-size: 14px;">Direct</span>
                                <span style="font-size: 14px; font-weight: 600;">28%</span>
                            </div>
                            <div class="progress-bar">
 <div class="progress-fill" style="width: 28%; animation-delay: 1s;">