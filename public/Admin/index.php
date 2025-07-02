<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChickenDash - Farm Management Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #16a085;
            --secondary-green: #2ecc71;
            --egg-yellow: #f39c12;
            --chicken-orange: #e67e22;
            --meat-red: #e74c3c;
            --success-green: #27ae60;
            --warning-orange: #f39c12;
            --danger-red: #e74c3c;
            --dark-brown: #8b4513;
            --light-cream: whitesmoke;
            --border-tan: #d4b896;
            --pending-blue: #3498db;
            --processing-orange: #e67e22;
            --completed-green: #27ae60;
        }

        body {
            background-color: var(--light-cream);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {

              background-color: white; 
    min-height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    z-index: 1000;
    border-right: 1px solid #f0f0f0;
    transition: all 0.3s ease;
        }

        .sidebar .nav-link {
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.3s ease;
            position: relative;

             color: #333;
    padding: 12px 20px;
    margin: 4px 15px;
    border-left: 4px solid transparent;
    border-radius: 0 8px 8px 0;
    font-weight: 500;
    transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {

            transform: translateX(5px);

               background-color: #f8f9fa;
    color: var(--primary-green);
    border-left: 4px solid var(--primary-green);
        }


     /*   .sidebar {
    background-color: white; 
    min-height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    z-index: 1000;
    border-right: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.sidebar .nav-link {
    color: #333;
    padding: 12px 20px;
    margin: 4px 15px;
    border-left: 4px solid transparent;
    border-radius: 0 8px 8px 0;
    font-weight: 500;
    transition: all 0.3s ease;
}

.sidebar .nav-link:hover {
    background-color: #f8f9fa;
    color: var(--primary-green);
    border-left: 4px solid var(--primary-green);
}

.sidebar .nav-link.active {
    background-color: #f0fdf9;
    color: var(--primary-green);
    border-left: 4px solid var(--primary-green);
}
*/
        .sidebar .nav-link .badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: var(--danger-red);
            color: white;
            font-size: 0.7rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .farm-card {
          
            color: white;
            border-radius: 20px;
            padding: 25px;
            position: relative;
            overflow: hidden;
        }

        .farm-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }

        .farm-card-eggs {
            background-color:#ff9f43;
        }
 .farm-card-chickens {
            background-color:#00cfe8;
        }
        .farm-card-meat {
            background-color:#1b2850;
        }

        .farm-card-orders {
            background-color:#28c76f;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
        }

        .activity-item {
            padding: 15px;
            border-bottom: 1px solid var(--border-tan);
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background-color: #faf7f0;
            transform: translateX(5px);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .progress-custom {
            height: 8px;
            border-radius: 10px;
        }

        .navbar-custom {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid var(--border-tan);
        }

        .search-box {
            background-color: #faf7f0;
            border: 1px solid var(--border-tan);
            border-radius: 25px;
            padding: 8px 20px;
            width: 300px;
        }

        .search-box:focus {
            box-shadow: 0 0 0 0.2rem rgba(22, 160, 133, 0.25);
            border-color: var(--primary-green);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(22, 160, 133, 0.3);
        }

        .production-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .production-color {
            width: 4px;
            height: 30px;
            border-radius: 2px;
            margin-right: 15px;
        }

        .mobile-menu-btn {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1001;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .search-box {
                width: 150px;
            }

            .mobile-menu-btn {
                display: inline-block;
            }
        }

        @media (max-width: 576px) {
            .search-box {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-3">
            <h4 class="text-dark mb-0">
                <i class="fas fa-egg me-2"></i>
                ChickenDash
            </h4>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link active" href="#" data-section="dashboard">
                <i class="fas fa-tachometer-alt me-3"></i>
                Dashboard
            </a>
            <a class="nav-link" href="#" data-section="orders">
                <i class="fas fa-shopping-cart me-3"></i>
                Order Management
                <span class="badge">5</span>
            </a>
            <a class="nav-link" href="#" data-section="chickens">
                <i class="fas fa-drumstick-bite me-3"></i>
                Chickens
            </a>
            <a class="nav-link" href="#" data-section="eggs">
                <i class="fas fa-egg me-3"></i>
                Egg Production
            </a>
            <a class="nav-link" href="#" data-section="sales">
                <i class="fas fa-cash-register me-3"></i>
                Sales
            </a>
            <a class="nav-link" href="#" data-section="customers">
                <i class="fas fa-users me-3"></i>
                Customers
            </a>
            <a class="nav-link" href="#" data-section="inventory">
                <i class="fas fa-boxes me-3"></i>
                Inventory
            </a>
            <a class="nav-link" href="#" data-section="reports">
                <i class="fas fa-chart-bar me-3"></i>
                Reports
            </a>
            <a class="nav-link" href="#" data-section="settings">
                <i class="fas fa-cog me-3"></i>
                Settings
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-lg navbar-custom mb-4">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-secondary mobile-menu-btn me-3" id="mobileMenuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="navbar-brand mb-0 h1" id="pageTitle">Chickens and Eggs Farm Dashboard</span>
                </div>
                <div class="d-flex align-items-center">
                    <input class="form-control search-box me-2" type="search" placeholder="Search records...">
                    <button class="btn btn-outline-secondary me-2 position-relative" type="button">
                        <i class="fas fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Dashboard Section -->
        <div id="dashboard-section" class="content-section">
            <!-- Farm Stats Cards -->
            <div class="row mb-4">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Farm Statistics</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="farm-card farm-card-chickens">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="mb-1 opacity-75">Total Chickens</p>
                                                <h3 class="mb-0">245</h3>
                                            </div>
                                            <i class="fas fa-drumstick-bite fa-2x opacity-50"></i>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1 opacity-75">LAYING</p>
                                                <p class="mb-0 fw-bold">180</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1 opacity-75">MEAT</p>
                                                <p class="mb-0 fw-bold">65</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="farm-card farm-card-eggs">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="mb-1 opacity-75">Today's Eggs</p>
                                                <h3 class="mb-0">156</h3>
                                            </div>
                                            <i class="fas fa-egg fa-2x opacity-50"></i>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1 opacity-75">SOLD</p>
                                                <p class="mb-0 fw-bold">120</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1 opacity-75">STOCK</p>
                                                <p class="mb-0 fw-bold">36</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="farm-card farm-card-meat">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="mb-1 opacity-75">Monthly Revenue</p>
                                                <h3 class="mb-0">$2,450</h3>
                                            </div>
                                            <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1 opacity-75">EGGS</p>
                                                <p class="mb-0 fw-bold">$1,800</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1 opacity-75">MEAT</p>
                                                <p class="mb-0 fw-bold">$650</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="farm-card farm-card-orders">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <p class="mb-1 opacity-75">Active Orders</p>
                                                <h3 class="mb-0">12</h3>
                                            </div>
                                            <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1 opacity-75">PENDING</p>
                                                <p class="mb-0 fw-bold">5</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1 opacity-75">PROCESSING</p>
                                                <p class="mb-0 fw-bold">7</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card h-100">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Recent Activities</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="activity-item">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-success text-white me-3">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 fw-bold">New Order #1234</p>
                                        <small class="text-muted">Mike's Restaurant - 5 dozen eggs</small>
                                    </div>
                                    <span class="text-success fw-bold">$60</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-warning text-white me-3">
                                        <i class="fas fa-egg"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 fw-bold">Egg Collection</p>
                                        <small class="text-muted">156 eggs collected today</small>
                                    </div>
                                    <span class="text-success fw-bold">+156</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-info text-white me-3">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 fw-bold">Payment Received</p>
                                        <small class="text-muted">Order #1230 - Paid via Card</small>
                                    </div>
                                    <span class="text-success fw-bold">$85</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Production Charts -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Weekly Production</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="productionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Revenue Breakdown</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="chart-container mb-3">
                                <canvas id="revenueChart"></canvas>
                            </div>
                            <div>
                                <div class="production-item">
                                    <div class="production-color" style="background-color: #f39c12;"></div>
                                    <div class="flex-grow-1 text-start">
                                        <span class="fw-bold">73%</span>
                                        <span class="ms-2">Egg Sales</span>
                                    </div>
                                    <span class="fw-bold">$1,800</span>
                                </div>
                                <div class="production-item">
                                    <div class="production-color" style="background-color: #e74c3c;"></div>
                                    <div class="flex-grow-1 text-start">
                                        <span class="fw-bold">27%</span>
                                        <span class="ms-2">Meat Sales</span>
                                    </div>
                                    <span class="fw-bold">$650</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
    <script>
        // Initialize Charts
        document.addEventListener('DOMContentLoaded', function() {
            // Weekly Production Chart (Bar Chart)
            const productionCtx = document.getElementById('productionChart').getContext('2d');
            new Chart(productionCtx, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Eggs Collected',
                        data: [145, 156, 142, 138, 165, 159, 148],
                        backgroundColor: '#f39c12',
                        borderColor: '#e67e22',
                        borderWidth: 1,
                        borderRadius: 4,
                        maxBarThickness: 40
                    }, {
                        label: 'Eggs Sold',
                        data: [120, 135, 128, 115, 142, 138, 125],
                        backgroundColor: '#e67e22',
                        borderColor: '#d35400',
                        borderWidth: 1,
                        borderRadius: 4,
                        maxBarThickness: 40
                    }, {
                        label: 'Chickens Processed',
                        data: [2, 3, 1, 2, 4, 3, 2],
                        backgroundColor: '#e74c3c',
                        borderColor: '#c0392b',
                        borderWidth: 1,
                        borderRadius: 4,
                        maxBarThickness: 40,
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Eggs Count'
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        y1: {
                            type: 'linear',
                            position: 'right',
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Chickens Count'
                            },
                            grid: {
                                drawOnChartArea: false
                            },
                            max: 10
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.dataset.label === 'Chickens Processed') {
                                        label += context.parsed.y + ' chickens';
                                    } else {
                                        label += context.parsed.y + ' eggs';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

            // Revenue Breakdown Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Egg Sales', 'Meat Sales'],
                    datasets: [{
                        data: [1800, 650],
                        backgroundColor: ['#f39c12', '#e74c3c'],
                        borderWidth: 0,
                        cutout: '60%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Navigation functionality
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('.content-section');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all links
                    navLinks.forEach(nl => nl.classList.remove('active'));
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Hide all sections
                    sections.forEach(section => section.style.display = 'none');
                    
                    // Show target section
                    const targetSection = this.getAttribute('data-section');
                    const targetElement = document.getElementById(targetSection + '-section');
                    if (targetElement) {
                        targetElement.style.display = 'block';
                    }
                    
                    // Update page title
                    const pageTitle = document.getElementById('pageTitle');
                    switch(targetSection) {
                        case 'dashboard':
                            pageTitle.textContent = 'Farm Overview';
                            break;
                        case 'orders':
                            pageTitle.textContent = 'Order Management';
                            break;
                        case 'chickens':
                            pageTitle.textContent = 'Chicken Management';
                            break;
                        case 'eggs':
                            pageTitle.textContent = 'Egg Production';
                            break;
                        case 'sales':
                            pageTitle.textContent = 'Sales Reports';
                            break;
                        case 'customers':
                            pageTitle.textContent = 'Customer Management';
                            break;
                        case 'inventory':
                            pageTitle.textContent = 'Inventory Management';
                            break;
                        case 'reports':
                            pageTitle.textContent = 'Analytics & Reports';
                            break;
                        case 'settings':
                            pageTitle.textContent = 'Farm Settings';
                            break;
                        default:
                            pageTitle.textContent = 'ChickenDash';
                    }
                });
            });
        });
    </script>
</body>
</html>