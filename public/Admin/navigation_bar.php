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

    
</head>

<body>
    <div id="global-loader">
        <div class="whirly-loader"></div>
    </div>

    <div class="main-wrapper">
        <div class="header">
            <div class="header-left active">
                <a href="index.html" class="logo">
                    <img src="assets/img/logo.png" alt="" />
                </a>
                <a href="index.html" class="logo-small">
                    <img src="assets/img/logo-small.png" alt="" />
                </a>
                <a id="toggle_btn" href="javascript:void(0);"> </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">




                <li class="nav-item dropdown has-arrow main-drop">
                    <a
                        href="javascript:void(0);"
                        class="dropdown-toggle nav-link userset"
                        data-bs-toggle="dropdown">
                        <span class="user-img"><img src="assets/img/profiles/avator1.jpg" alt="" />
                           <i class="fa fa-user"></i> <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img">
                                    <span></span></span>
                                <div class="profilesets">
                                    <h6 id="navbar-username"></h6>
                                </div>
                            </div>

                            <hr class="m-0" />
                            <a class="dropdown-item logout pb-0" id="logout-btn"><img
                                    src="assets/img/icons/log-out.svg"
                                    class="me-2"
                                    alt="img" />Logout</a>
                        </div>
                    </div>
                </li>
            </ul>


        </div>

        <!-- Scripts -->
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