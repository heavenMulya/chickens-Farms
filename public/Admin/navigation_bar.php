<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>CMS</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
  <style>
      

        /* Navbar Styles */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            /* background: linear-gradient(135deg, rgb(255, 159, 67) 0%, rgb(255, 140, 40) 100%); */
            background-color: transparent;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: rgb(255, 140, 40);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-brand i {
            font-size: 2rem;
             background: linear-gradient(45deg, rgb(255, 140, 40)), rgb(255, 140, 40);
            -webkit-text-fill-color: transparent;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-search {
            position: relative;
        }

        .search-input {
            background: rgb(255, 140, 40);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            color: white;
            width: 300px;
            transition: all 0.3s ease;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.25);
            width: 350px;
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .user-menu {
            position: relative;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, rgb(255, 140, 40)), rgb(255, 140, 40);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .user-avatar:hover {
            transform: scale(1.1);
          background: linear-gradient(45deg, rgb(255, 140, 40)), rgb(255, 140, 40);
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid #e2e8f0;
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1001;
            margin-top: 8px;
        }

        .user-dropdown::before {
            content: '';
            position: absolute;
            top: -6px;
            right: 20px;
            width: 12px;
            height: 12px;
            background: white;
            border: 1px solid #e2e8f0;
            border-bottom: none;
            border-right: none;
            transform: rotate(45deg);
        }

        .user-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-info {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .user-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .user-email {
            font-size: 0.8rem;
            color: #64748b;
        }

        .dropdown-menu {
            padding: 0.5rem 0;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #475569;
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .dropdown-item:hover {
            background: #f8fafc;
            color: #1e293b;
        }

        .dropdown-item.logout:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        .dropdown-item i {
            width: 16px;
            margin-right: 0.75rem;
            font-size: 0.85rem;
        }

        .dropdown-item.logout i {
            color: #dc2626;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 280px;
            height: calc(100vh - 70px);
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar-menu {
            padding: 1.5rem 0;
        }

        .menu-item {
            margin-bottom: 0.5rem;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            font-weight: 500;
        }

        .menu-link:hover {
            background: linear-gradient(90deg, rgba(255, 159, 67, 0.15), transparent);
            color: #ffffff;
            transform: translateX(4px);
        }

        .menu-link.active {
            background: linear-gradient(90deg, rgba(255, 159, 67, 0.25), transparent);
            color: #ffffff;
            border-right: 3px solid rgb(255, 159, 67);
        }

        .menu-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, rgb(255, 159, 67), rgb(255, 140, 40));
        }

        .menu-icon {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
            text-align: center;
        }

        .menu-text {
            flex: 1;
            font-size: 0.9rem;
        }

        .menu-badge {
            background: linear-gradient(45deg, rgb(255, 159, 67), rgb(255, 140, 40));
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-weight: 600;
            min-width: 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(255, 159, 67, 0.3);
        }

        .menu-arrow {
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }

        /* Submenu Styles */
        .submenu {
            max-height: 0;
            overflow: hidden;
            background: rgba(0, 0, 0, 0.2);
            transition: max-height 0.3s ease;
        }

        .submenu.active {
            max-height: 200px;
        }

        .submenu-link {
            display: block;
            padding: 0.75rem 1.5rem 0.75rem 3.5rem;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .submenu-link:hover {
            background: rgba(255, 159, 67, 0.15);
            color: #e2e8f0;
            padding-left: 4rem;
        }

        .submenu-link::before {
            content: '•';
            position: absolute;
            left: 2.5rem;
            color: #64748b;
        }

        .submenu-link:hover::before {
            color: rgb(255, 159, 67);
        }


        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .search-input {
                width: 200px;
            }

            .search-input:focus {
                width: 220px;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }
        }

        /* Animation for menu items */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .menu-item {
            animation: slideIn 0.3s ease forwards;
        }

        .menu-item:nth-child(1) { animation-delay: 0.1s; }
        .menu-item:nth-child(2) { animation-delay: 0.2s; }
        .menu-item:nth-child(3) { animation-delay: 0.3s; }
        .menu-item:nth-child(4) { animation-delay: 0.4s; }
        .menu-item:nth-child(5) { animation-delay: 0.5s; }
        .menu-item:nth-child(6) { animation-delay: 0.6s; }
        .menu-item:nth-child(7) { animation-delay: 0.7s; }
        .menu-item:nth-child(8) { animation-delay: 0.8s; }
        .menu-item:nth-child(9) { animation-delay: 0.9s; }

        /* Hover effects */
        .menu-link:hover .menu-icon {
            transform: scale(1.2);
            color: rgb(255, 159, 67);
        }

        .menu-link.has-submenu.active .menu-arrow {
            transform: rotate(180deg);
        }
    </style>
</head>

<body>
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>

    <div class="main-wrapper">
  
    <nav class="navbar">
        <div class="navbar-brand">
            <!-- <img src="" alt="" style="width: 40px; height: 40px; object-fit: contain; margin-right: 0.5rem;"> -->
            Chicken Farms Admin Dashboard
        </div>
        
        <div class="navbar-search">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Search anything...">
        </div>
        
        <div class="navbar-actions">
            <div class="user-menu">
                <div class="user-avatar" onclick="toggleUserDropdown()">JD</div>
                <div class="user-dropdown" id="userDropdown">
                    <div class="user-info">
                        <div class="user-name" id="navbar-username">Heaven</div>
                    </div>
                        <button class="dropdown-item logout" id="logout-btn" >
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>

                </div>
            </div>
        </div>
    </nav>
   

        <script src="assets/js/jquery-3.6.0.min.js"></script>

        <script src="assets/js/feather.min.js"></script>

        <script src="assets/js/jquery.slimscroll.min.js"></script>

        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/dataTables.bootstrap4.min.js"></script>

        <script src="assets/js/bootstrap.bundle.min.js"></script>

        <script src="assets/plugins/select2/js/select2.min.js"></script>

        <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
        <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

        <script src="assets/plugins/apexchart/apexcharts.min.js"></script>
        <script src="assets/plugins/apexchart/chart-data.js"></script>

        <script src="assets/js/script.js"></script>
        <script src="assets/js/commonJs.js"></script>
        <script>
            $(document).ready(function() {
                const now = new Date();
                $('#current-date').text(now.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }));
                const token = localStorage.getItem('admin_api_token');
                const userName = localStorage.getItem('admin_user_name');
                $('#navbar-username').text(userName)
                if (!token) {
                    // No token found, redirect to login
                    window.location.href = '/Users/login.php';
                }

                $('#logout-btn').on('click', function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: '/api/logout',
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token
                        },
                        success: function(res) {
                            localStorage.clear(); // Clear all localStorage data
                            Swal.fire({
                                icon: 'success',
                                title: 'Signed Out',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '/Users/login.php';
                            });
                        },
                        error: function(xhr) {
                            localStorage.clear(); // Clear localStorage on error
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'Something went wrong during logout.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '/Users/login.php';
                            });
                        }
                    });
                });
            });
        </script>