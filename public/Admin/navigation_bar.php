<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>CMS</title>
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css"> -->

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


    <style>
        :root {
            --primary-color: #ff9f43;
            --secondary-color: #ff6b35;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --light-bg: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            color: #334155;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Header/Navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 159, 67, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .nav-container {
            padding: 1rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-right {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ff9f43 0%, #ff6b35 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }

        .logo i {
            margin-right: 0.5rem;
            color: #ff9f43;
        }

        .mobile-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 4px;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .mobile-toggle:hover {
            background: rgba(255, 159, 67, 0.1);
        }

        .mobile-toggle span {
            width: 25px;
            height: 3px;
            background: #64748b;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .mobile-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .mobile-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* User Profile Dropdown */
        .user-profile {
            position: relative;
            display: flex;
            align-items: center;
        }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: rgba(255, 159, 67, 0.1);
            border: 1px solid rgba(255, 159, 67, 0.2);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .profile-trigger:hover {
            background: rgba(255, 159, 67, 0.15);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(255, 159, 67, 0.2);
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff9f43 0%, #ff6b35 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
        }

        .profile-role {
            font-size: 0.8rem;
            color: #64748b;
        }

        .profile-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 159, 67, 0.1);
            border-radius: 15px;
            padding: 1rem 0;
            min-width: 200px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .profile-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #64748b;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: rgba(255, 159, 67, 0.1);
            color: #ff9f43;
        }

        .dropdown-item.logout {
            border-top: 1px solid rgba(255, 159, 67, 0.1);
            margin-top: 0.5rem;
            color: #ef4444;
        }

        .dropdown-item.logout:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        

        .menu-link {
            display: flex;
            align-items: center;
            padding: 1rem;
            color: #64748b;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            gap: 1rem;
        }

        .menu-link:hover {
            background: rgba(255, 159, 67, 0.1);
            color: #ff9f43;
            transform: translateX(5px);
        }

        .menu-link.active {
            background: linear-gradient(135deg, rgba(255, 159, 67, 0.15) 0%, rgba(255, 107, 53, 0.1) 100%);
            color: #ff9f43;
            border-left: 4px solid #ff9f43;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
            opacity: 0.7;
            transition: opacity 0.3s ease;
            flex-shrink: 0;
        }

        .menu-link:hover .menu-icon,
        .menu-link.active .menu-icon {
            opacity: 1;
        }

        .menu-text {
            flex: 1;
        }

        /* Submenu styles */
        .submenu>a {
            display: flex;
            align-items: center;
            padding: 1rem;
            color: #64748b;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            gap: 1rem;
            cursor: pointer;
        }

        .submenu>a:hover {
            background: rgba(255, 159, 67, 0.1);
            color: #ff9f43;
            transform: translateX(5px);
        }

        .menu-arrow {
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }

        .menu-arrow::before {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
        }

        .submenu.active .menu-arrow {
            transform: rotate(180deg);
        }

        .submenu ul {
            list-style: none;
            padding-left: 0;
            margin-top: 0.5rem;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .submenu.active ul {
            max-height: 200px;
        }

        .submenu-link {
            display: block;
            padding: 0.75rem 1rem 0.75rem 3.5rem;
            color: #64748b;
            text-decoration: none;
            border-radius: 8px;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            position: relative;
        }

        .submenu-link::before {
            content: '';
            position: absolute;
            left: 2.5rem;
            top: 50%;
            width: 6px;
            height: 6px;
            background: #cbd5e1;
            border-radius: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }

        .submenu-link:hover {
            background: rgba(255, 159, 67, 0.08);
            color: #ff9f43;
            transform: translateX(5px);
        }

        .submenu-link:hover::before {
            background: #ff9f43;
            transform: translateY(-50%) scale(1.2);
        }

        /* Page wrapper - matches your existing structure */
        .page-wrapper {
            margin-left: 280px;
            margin-top: 150px;
            padding: 2rem;
            min-height: calc(100vh - 80px);
            transition: all 0.3s ease;
        }

        /* Dashboard Header */
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(255, 159, 67, 0.2);
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .dashboard-header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        /* Filter Controls */
        .filter-controls {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
        }

        .filter-btn {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 0;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }

        .stat-card:hover::before {
            width: 6px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: white;
        }

        .stat-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .stat-success {
            background: linear-gradient(135deg, var(--success-color), #059669);
        }

        .stat-warning {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
        }

        .stat-danger {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
        }

        .stat-info {
            background: linear-gradient(135deg, var(--info-color), #2563eb);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0;
        }

        .stat-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 1rem 0;
        }

        /* Loader */
        .custom-spinner {
            width: 3rem;
            height: 3rem;
            border: 3px solid #e2e8f0;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
            padding: 4rem 0 2rem;
            margin-left: 280px;
            margin-top: 4rem;
            transition: all 0.3s ease;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }

        .footer-section h4 {
            color: #ff9f43;
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #ff9f43;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 159, 67, 0.2);
            margin-top: 3rem;
            padding-top: 2rem;
            text-align: center;
            color: #94a3b8;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .page-wrapper,
            .footer {
                margin-left: 0;
            }

            .mobile-toggle {
                display: flex;
            }

            .nav-container {
                padding: 1rem;
            }

            .profile-info {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .page-wrapper {
                padding: 1rem;
            }

            .dashboard-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .dashboard-header h1 {
                font-size: 2rem;
            }

            .filter-controls {
                padding: 1rem;
            }

            .nav-container {
                padding: 1rem;
            }

            .logo {
                font-size: 1.5rem;
            }

            .profile-trigger {
                padding: 0.5rem;
            }

            .footer-content {
                padding: 0 1rem;
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Custom scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 159, 67, 0.3);
            border-radius: 2px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 159, 67, 0.5);
        }
   


        .page-title h6 {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .page-btn .btn-added {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .page-btn .btn-added:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Search Container */
        .search-container {
            position: relative;
            margin-bottom: 2rem;
        }

        .search-box {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 1px solid rgba(255, 159, 67, 0.2);
            border-radius: 12px;
            font-size: 1rem;
            background: white;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .search-box:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 159, 67, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
            color: #059669;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.05) 100%);
            color: #dc2626;
            border-left: 4px solid #ef4444;
        }

        /* Card Styling */
        .card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: var(--card-shadow);
            border: none;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--card-hover-shadow);
        }

        .card-body {
            padding: 2rem;
        }



        /* Action Buttons */
        .list-inline {
            display: flex;
            gap: 0.5rem;
            margin: 0;
        }

        .list-inline-item {
            list-style: none;
        }

        .list-inline-item a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .list-inline-item a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .list-inline-item a img {
            width: 18px;
            height: 18px;
            filter: brightness(0.7);
            transition: filter 0.3s ease;
        }

        .list-inline-item a:hover img {
            filter: brightness(1);
        }

        .list-inline-item:first-child a {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
        }

        .list-inline-item:first-child a:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(37, 99, 235, 0.1) 100%);
        }

        .list-inline-item:last-child a {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.05) 100%);
        }

        .list-inline-item:last-child a:hover {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(220, 38, 38, 0.1) 100%);
        }

        /* Loader */
        .loader-container {
            text-align: center;
            padding: 3rem;
        }

        .loader {
            width: 3rem;
            height: 3rem;
            border: 3px solid #e2e8f0;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loader-text {
            color: #64748b;
            font-weight: 500;
        }

        /* No Data */
        .no-data-container {
            text-align: center;
            padding: 4rem 2rem;
        }

        .no-data-icon {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
            opacity: 0.7;
        }

        .no-data-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .no-data-text {
            color: #94a3b8;
            font-size: 1rem;
        }

        /* Pagination */
        .pagination-container {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 1.5rem;
            box-shadow: var(--card-shadow);
        }

        .pagination-info {
            color: #64748b;
            font-weight: 500;
        }

        .entries-per-page label {
            color: #64748b;
            font-weight: 500;
            margin-right: 0.5rem;
        }

        .form-select-sm {
            border: 1px solid rgba(255, 159, 67, 0.2);
            border-radius: 8px;
            padding: 0.375rem 2rem 0.375rem 0.75rem;
        }

        .form-select-sm:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 159, 67, 0.1);
        }

        .pagination .page-link {
            border: 1px solid rgba(255, 159, 67, 0.2);
            color: #64748b;
            padding: 0.75rem 1rem;
            margin: 0 0.125rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            padding: 2rem;
            border-radius: 1.5rem 1.5rem 0 0;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .btn-close {
            background: none;
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            color: #374151;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .form-control, .form-select, input[type="text"], textarea {
            border: 1px solid rgba(255, 159, 67, 0.2);
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus, .form-select:focus, input[type="text"]:focus, textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 159, 67, 0.1);
        }

        /* Image Upload */
        .image-upload {
            text-align: center;
        }

        .image-uploads {
            border: 2px dashed rgba(255, 159, 67, 0.3);
            border-radius: 12px;
            padding: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(255, 159, 67, 0.02);
        }

        .image-uploads:hover {
            border-color: var(--primary-color);
            background: rgba(255, 159, 67, 0.05);
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .image-preview img {
            max-width: 100px;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border: none;
            gap: 1rem;
        }

        .modal-footer .btn {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .modal-footer .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .page-wrapper {
                margin-left: 0;
            }

            .mobile-toggle {
                display: flex;
            }

            .profile-info {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .page-wrapper {
                padding: 1rem;
                margin-top: 100px;
            }

            .page-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
                padding: 1.5rem;
            }

            .page-title h4 {
                font-size: 2rem;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .productimgname {
                flex-direction: column;
                gap: 0.5rem;
            }

            .pagination-container {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .entries-per-page {
                display: none !important;
            }
        }


        :root {
            --primary-color: #ff9f43;
            --secondary-color: #ff6b35;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --light-bg: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            color: #334155;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Header/Navbar - Same as index */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 159, 67, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .nav-container {
            padding: 1rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-right {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ff9f43 0%, #ff6b35 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }

        .logo i {
            margin-right: 0.5rem;
            color: #ff9f43;
        }

        .mobile-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 4px;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .mobile-toggle:hover {
            background: rgba(255, 159, 67, 0.1);
        }

        .mobile-toggle span {
            width: 25px;
            height: 3px;
            background: #64748b;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .mobile-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .mobile-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* User Profile Dropdown - Same as index */
        .user-profile {
            position: relative;
            display: flex;
            align-items: center;
        }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: rgba(255, 159, 67, 0.1);
            border: 1px solid rgba(255, 159, 67, 0.2);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .profile-trigger:hover {
            background: rgba(255, 159, 67, 0.15);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(255, 159, 67, 0.2);
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff9f43 0%, #ff6b35 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
        }

        .profile-role {
            font-size: 0.8rem;
            color: #64748b;
        }

        .profile-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 159, 67, 0.1);
            border-radius: 15px;
            padding: 1rem 0;
            min-width: 200px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .profile-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #64748b;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: rgba(255, 159, 67, 0.1);
            color: #ff9f43;
        }

        .dropdown-item.logout {
            border-top: 1px solid rgba(255, 159, 67, 0.1);
            margin-top: 0.5rem;
            color: #ef4444;
        }

        .dropdown-item.logout:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 115px;
            width: 290px;
            height: calc(100vh - 80px);
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 159, 67, 0.1);
            padding: 1.5rem 0;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);
        }

        .sidebar-header {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid rgba(255, 159, 67, 0.1);
            margin-bottom: 2rem;
        }

        .sidebar-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-subtitle {
            font-size: 0.9rem;
            color: #64748b;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0 1rem;
        }

        .sidebar-nav>li {
            margin-bottom: 0.5rem;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 1rem;
            color: #64748b;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            gap: 1rem;
        }

        .menu-link:hover {
            background: rgba(255, 159, 67, 0.1);
            color: #ff9f43;
            transform: translateX(5px);
        }

        .menu-link.active {
            background: linear-gradient(135deg, rgba(255, 159, 67, 0.15) 0%, rgba(255, 107, 53, 0.1) 100%);
            color: #ff9f43;
            border-left: 4px solid #ff9f43;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
            opacity: 0.7;
            transition: opacity 0.3s ease;
            flex-shrink: 0;
        }

        .menu-link:hover .menu-icon,
        .menu-link.active .menu-icon {
            opacity: 1;
        }

        .menu-text {
            flex: 1;
        }

        /* Page wrapper - Same layout */
        .page-wrapper {
            margin-left: 280px;
            margin-top: 100px;
            padding: 2rem;
            min-height: calc(100vh - 80px);
            transition: all 0.3s ease;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(255, 159, 67, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title h4 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-title h6 {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .page-btn .btn-added {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .page-btn .btn-added:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Search Container */
        .search-container {
            position: relative;
            margin-bottom: 2rem;
        }

        .search-box {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 1px solid rgba(255, 159, 67, 0.2);
            border-radius: 12px;
            font-size: 1rem;
            background: white;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .search-box:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 159, 67, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
            color: #059669;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.05) 100%);
            color: #dc2626;
            border-left: 4px solid #ef4444;
        }

        /* Card Styling */
        .card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: var(--card-shadow);
            border: none;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--card-hover-shadow);
        }

        .card-body {
            padding: 2rem;
        }

        /* Modern Table Styling */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background:  var(--primary-color);
            color: white;
            border: none;
            padding: 1.5rem 1rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table tbody tr {
            border: none;
            transition: all 0.3s ease;
        }

        .table tbody tr:nth-child(even) {
            background-color: rgba(248, 250, 252, 0.5);
        }

        .table tbody tr:hover {
            background: linear-gradient(135deg, rgba(255, 159, 67, 0.05) 0%, rgba(255, 107, 53, 0.02) 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .table td {
            padding: 1.25rem 1rem;
            border: none;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Product Image and Name */
        .productimgname {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-img {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .product-img:hover {
            transform: scale(1.05);
        }

        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .productimgname a:last-child {
            color: #1e293b;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .productimgname a:last-child:hover {
            color: var(--primary-color);
        }

        /* Action Buttons */
        .list-inline {
            display: flex;
            gap: 0.5rem;
            margin: 0;
        }

        .list-inline-item {
            list-style: none;
        }

        .list-inline-item a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .list-inline-item a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .list-inline-item a img {
            width: 18px;
            height: 18px;
            filter: brightness(0.7);
            transition: filter 0.3s ease;
        }

        .list-inline-item a:hover img {
            filter: brightness(1);
        }

        .list-inline-item:first-child a {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
        }

        .list-inline-item:first-child a:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(37, 99, 235, 0.1) 100%);
        }

        .list-inline-item:last-child a {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.05) 100%);
        }

        .list-inline-item:last-child a:hover {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(220, 38, 38, 0.1) 100%);
        }

        /* Loader */
        .loader-container {
            text-align: center;
            padding: 3rem;
        }

        .loader {
            width: 3rem;
            height: 3rem;
            border: 3px solid #e2e8f0;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loader-text {
            color: #64748b;
            font-weight: 500;
        }

        /* No Data */
        .no-data-container {
            text-align: center;
            padding: 4rem 2rem;
        }

        .no-data-icon {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
            opacity: 0.7;
        }

        .no-data-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .no-data-text {
            color: #94a3b8;
            font-size: 1rem;
        }

        /* Pagination */
        .pagination-container {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 1.5rem;
            box-shadow: var(--card-shadow);
        }

        .pagination-info {
            color: #64748b;
            font-weight: 500;
        }

        .entries-per-page label {
            color: #64748b;
            font-weight: 500;
            margin-right: 0.5rem;
        }

        .form-select-sm {
            border: 1px solid rgba(255, 159, 67, 0.2);
            border-radius: 8px;
            padding: 0.375rem 2rem 0.375rem 0.75rem;
        }

        .form-select-sm:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 159, 67, 0.1);
        }

        .pagination .page-link {
            border: 1px solid rgba(255, 159, 67, 0.2);
            color: #64748b;
            padding: 0.75rem 1rem;
            margin: 0 0.125rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            padding: 2rem;
            border-radius: 1.5rem 1.5rem 0 0;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .btn-close {
            background: none;
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            color: #374151;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .form-control, .form-select, input[type="text"], textarea {
            border: 1px solid rgba(255, 159, 67, 0.2);
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus, .form-select:focus, input[type="text"]:focus, textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 159, 67, 0.1);
        }

        /* Image Upload */
        .image-upload {
            text-align: center;
        }

        .image-uploads {
            border: 2px dashed rgba(255, 159, 67, 0.3);
            border-radius: 12px;
            padding: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(255, 159, 67, 0.02);
        }

        .image-uploads:hover {
            border-color: var(--primary-color);
            background: rgba(255, 159, 67, 0.05);
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .image-preview img {
            max-width: 100px;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border: none;
            gap: 1rem;
        }

        .modal-footer .btn {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .modal-footer .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .page-wrapper {
                margin-left: 0;
            }

            .mobile-toggle {
                display: flex;
            }

            .profile-info {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .page-wrapper {
                padding: 1rem;
                margin-top: 100px;
            }

            .page-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
                padding: 1.5rem;
            }

            .page-title h4 {
                font-size: 2rem;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .productimgname {
                flex-direction: column;
                gap: 0.5rem;
            }

            .pagination-container {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .entries-per-page {
                display: none !important;
            }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Animation */
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 768px) {
    /* Additional font size adjustments for medium screens */
    .logo {
        font-size: 1.3rem;
    }
    
    .logo i {
        font-size: 1.1rem;
    }
}/* Fix for small screen layout issues */
@media (max-width: 1024px) {
    .navbar {
        height: 90px; /* Ensure proper navbar height */
    }
    
    .sidebar {
        transform: translateX(-100%);
        top: 90px; /* Match navbar height exactly */
        height: calc(100vh - 90px);
        padding-top: 2rem; /* Add top padding to prevent content cutoff */
    }

    .sidebar.active {
        transform: translateX(0);
    }

    .page-wrapper {
        margin-left: 0;
        margin-top: 90px; /* Match navbar height exactly */
        padding-top: 2rem; /* Add top padding to prevent content cutoff */
    }

    .mobile-toggle {
        display: flex;
    }

    .profile-info {
        display: none;
    }
}

@media (max-width: 768px) {
    /* Navbar adjustments */
    .navbar {
        height: 90px; /* Consistent height */
        min-height: 90px;
    }
    
    .nav-container {
        padding: 1rem;
        height: 90px; /* Match navbar height */
        align-items: center;
    }

    /* Sidebar adjustments */
    .sidebar {
        top: 90px; /* Match navbar height */
        height: calc(100vh - 90px);
        width: 280px;
        padding-top: 2rem; /* Prevent content cutoff */
    }

    /* Page wrapper adjustments */
    .page-wrapper {
        margin-left: 0;
        margin-top: 90px; /* Match navbar height */
        padding: 2rem 1rem; /* More top padding */
        min-height: calc(100vh - 90px);
    }

    /* Page header responsive */
    .page-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
        padding: 1.5rem;
        margin-bottom: 2rem; /* Ensure spacing */
    }

    .page-title h4 {
        font-size: 1.5rem;
    }

    .page-title h6 {
        font-size: 0.9rem;
    }

    /* Responsive table improvements */
    .table-responsive {
        font-size: 0.875rem;
        border-radius: 8px;
        max-height: 70vh;
        overflow-y: auto;
    }

    /* Stack table cells on very small screens - CENTERED CONTENT */
    .table thead {
        display: none;
    }

    .table tbody tr {
        display: block;
        background: white;
        margin-bottom: 1rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        text-align: center; /* CENTER ALL CONTENT */
        max-width: 100%;
    }

    .table tbody tr:nth-child(even) {
        background-color: white;
    }

    .table tbody tr:hover {
        background: white;
        transform: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .table td {
        display: block;
        padding: 0.75rem 0;
        border: none;
        border-bottom: 1px solid #f1f5f9;
        position: relative;
        text-align: center; /* CENTER CONTENT */
        width: 100%;
    }

    .table td:last-child {
        border-bottom: none;
    }

    /* Add labels for table data - CENTERED */
    .table td:before {
        content: attr(data-label);
        display: block;
        font-weight: 600;
        color: #374151;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        text-align: center; /* CENTER LABELS */
    }

    /* Product image and name adjustments - CENTERED */
    .productimgname {
        flex-direction: column;
        gap: 0.75rem;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .product-img {
        width: 50px;
        height: 50px;
        margin: 0 auto;
    }

    /* Action buttons responsive - CENTERED */
    .list-inline {
        justify-content: center;
        gap: 0.5rem;
    }

    .list-inline-item a {
        width: 36px;
        height: 36px;
    }

    .list-inline-item a img {
        width: 18px;
        height: 18px;
    }

    /* Pagination responsive */
    .pagination-container {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
        padding: 1rem;
    }

    .pagination-container .d-flex {
        flex-direction: column;
        gap: 1rem;
    }

    .entries-per-page {
        display: none !important;
    }

    .pagination {
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.25rem;
    }

    .pagination .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }

    /* Search box responsive */
    .search-container {
        margin-bottom: 1rem;
    }

    .search-box {
        padding: 0.75rem 0.75rem 0.75rem 2.5rem;
        font-size: 0.9rem;
    }

    .search-icon {
        left: 0.75rem;
    }

    /* Cards responsive */
    .card {
        border-radius: 12px;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Modal responsive */
    .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
    }

    .modal-header,
    .modal-body,
    .modal-footer {
        padding: 1.5rem;
    }

    .modal-title {
        font-size: 1.25rem;
    }

    /* Form elements responsive */
    .form-group {
        margin-bottom: 1rem;
    }

    .form-control,
    .form-select {
        padding: 0.75rem;
        font-size: 0.9rem;
    }

    /* Image upload responsive */
    .image-uploads {
        padding: 1.5rem;
    }

    /* Alert responsive */
    .alert {
        padding: 1rem;
        font-size: 0.9rem;
        border-radius: 8px;
    }

    /* Stats cards responsive (if you have them) */
    .stat-card {
        padding: 1.25rem;
        border-radius: 12px;
    }

    .stat-number {
        font-size: 1.5rem;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    /* Extra small screens */
    .navbar {
        height: 80px;
        min-height: 80px;
    }
    
    .nav-container {
        height: 80px;
        padding: 0.75rem 1rem;
    }
    
    .sidebar {
        top: 80px;
        height: calc(100vh - 80px);
        padding-top: 2rem;
    }
    
    .page-wrapper {
        margin-top: 80px;
        padding: 2rem 0.75rem;
        min-height: calc(100vh - 80px);
    }

    .page-header {
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .page-title h4 {
        font-size: 1.2rem;
    }

    .page-title h6 {
        font-size: 0.85rem;
    }

    .logo {
        font-size: 1rem;
    }
    
    .logo i {
        font-size: 0.9rem;
        margin-right: 0.3rem;
    }

    /* Table content - FULLY CENTERED */
    .table td {
        text-align: center;
        font-size: 0.85rem;
        padding: 1rem 0;
    }

    .table td:before {
        font-size: 0.7rem;
        margin-bottom: 0.75rem;
        text-align: center;
        display: block;
    }

    .productimgname {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
        align-items: center;
    }

    .product-img {
        width: 45px;
        height: 45px;
        margin: 0 auto;
    }

    .search-box {
        padding: 0.75rem 0.75rem 0.75rem 2.5rem;
        font-size: 0.9rem;
    }

    .btn-added {
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
    }

    .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
    }

    .modal-header,
    .modal-body,
    .modal-footer {
        padding: 1rem;
    }

    /* Ensure content doesn't overflow */
    body {
        overflow-x: hidden;
    }

    .container,
    .container-fluid {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
}

/* Alternative table layout for very small screens */
@media (max-width: 576px) {
    /* Horizontal scroll table option */
    .table-responsive-alt {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 8px;
    }

    .table-responsive-alt .table {
        min-width: 700px;
        margin-bottom: 0;
    }

    .table-responsive-alt .table thead th {
        white-space: nowrap;
        padding: 1rem 0.75rem;
        font-size: 0.8rem;
    }

    .table-responsive-alt .table td {
        white-space: nowrap;
        padding: 1rem 0.75rem;
        font-size: 0.85rem;
    }

    .table-responsive-alt .productimgname {
        min-width: 150px;
    }

    .table-responsive-alt .list-inline {
        min-width: 80px;
    }
}

/* Ensure proper spacing and prevent content from going under navbar */
.page-content {
    padding-top: 1rem;
}

/* Fix for overlapping content - CRITICAL FIXES */
@media (max-width: 768px) {
    .navbar {
        position: fixed;
        z-index: 1030;
        height: 90px; /* Consistent height */
        width: 100%;
        top: 0;
    }

    .sidebar {
        z-index: 1020;
        position: fixed;
        top: 90px; /* Start below navbar */
        left: 0;
        transform: translateX(-100%);
    }

    .sidebar.active {
        transform: translateX(0);
    }

    .page-wrapper {
        z-index: 1;
        position: relative;
        margin-top: 90px; /* Space for fixed navbar */
        padding-top: 2rem; /* Additional top padding */
        margin-left: 0;
    }
    
    /* Ensure sidebar content is visible from top */
    .sidebar-nav {
        padding-top: 0;
        margin-top: 0;
    }
    
    .sidebar-header {
        padding-top: 1rem;
        margin-bottom: 1rem;
    }
}

@media (max-width: 480px) {
    .navbar {
        height: 80px;
        z-index: 1030;
    }
    
    .sidebar {
        top: 80px;
        z-index: 1020;
    }
    
    .page-wrapper {
        margin-top: 80px;
        padding-top: 2rem;
    }
}

/* Custom scrollbar for small screens */
@media (max-width: 768px) {
    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: rgba(255, 159, 67, 0.4);
        border-radius: 3px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 159, 67, 0.6);
    }
}
    </style>  
</head>

<body>
    <!-- Header/Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <div class="mobile-toggle" id="mobileToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <a href="#" class="logo">
                    <i class="fas fa-drumstick-bite"></i>
                    Rwahumbiza Chicken Farm Management
                </a>
            </div>

            <div class="user-profile">
                <div class="profile-trigger" id="profileTrigger">
                    <div class="profile-avatar">JD</div>
                    <div class="profile-info">
                        <div class="profile-name" id="navbar-username"></div>
                        <div class="profile-role">Admin</div>
                    </div>
                    <i class="fas fa-chevron-down" style="color: #64748b; font-size: 0.8rem;"></i>
                </div>
                <div class="profile-dropdown" id="profileDropdown">
                    <a href="#" class="dropdown-item logout" id="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
<script>

    // Dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
    const profileTrigger = document.getElementById('profileTrigger');
    const profileDropdown = document.getElementById('profileDropdown');
    const mobileToggle = document.getElementById('mobileToggle');
    const sidebar = document.querySelector('.sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    // Profile dropdown toggle
    if (profileTrigger && profileDropdown) {
        profileTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            profileDropdown.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileTrigger.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.remove('active');
            }
        });

        // Prevent dropdown from closing when clicking inside it
        profileDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Mobile toggle functionality
    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', function() {
            mobileToggle.classList.toggle('active');
            sidebar.classList.toggle('active');
            if (sidebarOverlay) {
                sidebarOverlay.classList.toggle('active');
            }
        });

        // Close sidebar when clicking overlay
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                mobileToggle.classList.remove('active');
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });
        }
    }

    // Submenu functionality (if you have submenus)
    const submenuTriggers = document.querySelectorAll('.submenu > a');
    submenuTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const submenu = this.parentElement;
            submenu.classList.toggle('active');
        });
    });
});
</script>

 <script>
 

        // Your existing jQuery code
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
            $('#navbar-username').text(userName);
            
            if (!token) {
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
                        localStorage.clear();
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
                        localStorage.clear();
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