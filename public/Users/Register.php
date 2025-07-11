<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #d4342c;
            --secondary-color: #8b1a1a;
            --accent-color: #ffa726;
            --dark-color: #2c1810;
            --light-color: #f8f6f3;
            --meat-red: #c62828;
            --chicken-yellow: #ffb74d;
        }

        body {
            background: linear-gradient(135deg, var(--light-color) 0%, #f0ebe4 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            color: var(--dark-color);
        }

        .registration-container {
            max-width: 600px;
            margin: 2rem auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(44, 24, 16, 0.1);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            text-align: center;
            padding: 2rem;
            position: relative;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .form-header h2 {
            position: relative;
            z-index: 1;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .form-header p {
            position: relative;
            z-index: 1;
            margin: 0;
            opacity: 0.9;
        }

        .form-body {
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(212, 52, 44, 0.15);
            background-color: white;
        }

        .input-group {
            position: relative;
        }

        .input-group-text {
            background: var(--accent-color);
            border: 2px solid var(--accent-color);
            color: var(--dark-color);
            border-radius: 12px 0 0 12px;
            font-weight: 600;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        .input-group .form-control:focus {
            border-color: var(--primary-color);
            border-left: 2px solid var(--primary-color);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--meat-red));
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--meat-red), var(--secondary-color));
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 52, 44, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--accent-color), var(--chicken-yellow));
            border: none;
            color: var(--dark-color);
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, var(--chicken-yellow), var(--accent-color));
            color: var(--dark-color);
            transform: translateY(-2px);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(212, 52, 44, 0.15);
        }

        .form-check-label {
            color: var(--dark-color);
            font-size: 0.9rem;
        }

        .form-check-label a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .form-check-label a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            background-color: #fafafa;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(212, 52, 44, 0.15);
            background-color: white;
        }

        .row {
            margin-bottom: 1rem;
        }

        .social-login {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }

        .social-login p {
            color: var(--dark-color);
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 12px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .animated-icon {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @media (max-width: 768px) {
            .registration-container {
                margin: 1rem;
                border-radius: 15px;
            }
            
            .form-body {
                padding: 1.5rem;
            }
            
            .form-header {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="registration-container">
            <div class="form-header">
                <i class="fas fa-user-plus fa-2x animated-icon mb-3"></i>
                <h2>Create Account</h2>
                <p>Join our community today</p>
            </div>
            
            <div class="form-body">
                       <!-- Success Alert -->
     <div class="row mt-5">
        <div class="col-6">

        </div>
          <div class="col-5">
             <div class="alert alert-success alert-dismissible fade show pulse" role="alert" style="display: none;" id="success-alert">
        <i class="fas fa-check-circle me-2"></i>
        <strong>Success!</strong> <span id="success-message">Operation completed successfully.</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Error Alert -->
    <div class="alert alert-danger alert-dismissible fade show pulse" role="alert" style="display: none;" id="error-alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Error!</strong> <span id="error-message">Something went wrong.</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
        </div>

        <div class="col-1">

        </div>
     </div>
<form id="registerForm">
    <div class="form-group">
        <label class="form-label">Name</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" id="name" class="form-control" placeholder="Enter first name" required>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" id="email" class="form-control" placeholder="Enter email address" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" class="form-control" placeholder="Create password" required>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
                </div>
            </div>
        </div>
    </div>
   <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i>Create Account
        </button>
    </div>

     <div class="social-login">
                        <p>Already have an account?</p>
                        <a href="login.php" class="btn btn-outline-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </a>
                    </div>
</form>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  const API_URL = 'http://127.0.0.1:8000/api'; // Replace with your actual API URL

  $('#registerForm').on('submit', function(e) {
    e.preventDefault();

    const name = $('#name').val();
    const email = $('#email').val();
    const password = $('#password').val();
    const confirm = $('#confirm_password').val();

    if (password !== confirm) {
      alert('Passwords do not match.');
      return;
    }

    $.ajax({
      url: API_URL + '/register',
      method: 'POST',
      data: JSON.stringify({
    name: name,
    email: email,
    password: password,
    password_confirmation: confirm
  }),
         dataType: 'json',
        contentType: 'application/json',
      success: function(res) {
        const msg='Registration successful!';
        showSuccess(msg)
        console.log(res);
        // Store token if returned
        if (res.api_token) {
          localStorage.setItem('api_token', res.api_token);
        }
        // Optionally redirect to login/dashboard
      },
      error: function(xhr) {
        if (xhr.status === 422) {
          let errors = xhr.responseJSON.errors;
          let message = '';
          for (let field in errors) {
            message += errors[field].join(', ') + '\n';
          }
          alert('Validation Error:\n' + message);
          showError(message)
        } else {
          const msg='Registration failed!';
          showError(msg)
        }
        console.error(xhr.responseJSON);
      }
    });
  });

  function showSuccess(msg) {

  $('#success-message').text(msg);
  $('#success-alert').show().delay(10000).fadeOut();
}

function showError(msg) {

  $('#error-message').text(msg);
  $('#error-alert').show().delay(10000).fadeOut();
}
</script>


</body>
</html>