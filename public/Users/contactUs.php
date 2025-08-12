<?php include 'header.php' ?>

    <style>
        :root {
            --primary-color: #d4342c;
           
            --text-dark: #2c3e50;
            --text-light: #6c757d;
        }

      
        .page-header {
            background:var(--primary-color);
            color: white;
            padding: 100px 0 60px;
            text-align: center;
        }

        .page-header h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .page-header p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .section {
            padding: 80px 0;
        }

        .contact-info-card {
            background: white;
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .contact-info-card:hover {
            transform: translateY(-10px);
        }

        .contact-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .contact-info-card h4 {
            color: var(--text-dark);
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .contact-info-card p {
            color: var(--text-light);
            font-size: 1.1rem;
            margin: 0;
        }

        .contact-form {
            background: white;
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(212, 52, 44, 0.25);
        }

        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background: #b8302a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 52, 44, 0.3);
        }

        .map-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            height: 400px;
            position: relative;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .map-overlay {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .map-overlay h6 {
            color: var(--primary-color);
            margin: 0 0 0.5rem 0;
            font-weight: 600;
        }

        .map-overlay p {
            margin: 0;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .hours-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .hours-card h4 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .hours-list {
            list-style: none;
            padding: 0;
        }

        .hours-list li {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .hours-list li:last-child {
            border-bottom: none;
        }

        .day {
            font-weight: 600;
            color: var(--text-dark);
        }

        .time {
            color: var(--text-light);
        }

        .faq-section {
            background: #f8f9fa;
        }

        .faq-item {
            background: white;
            border-radius: 10px;
            margin-bottom: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .faq-question {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .faq-question:hover {
            background: var(--secondary-color);
        }

        .faq-answer {
            padding: 0 1.5rem 1.5rem;
            color: var(--text-light);
            display: none;
        }

        .faq-answer.show {
            display: block;
        }

     

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            border-radius: 10px;
            display: none;
        }
    </style>
</head>
<body>
 
<?php include 'navbar.php' ?>
<?php include 'alert.php' ?>
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Contact Us</h1>
            <p>Get in touch with us for any questions, orders, or support. We're here to help!</p>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4>Call Us</h4>
                        <p>+255676887277<br>
                        Available Mon-Sat: 7AM-8PM</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="contact-info-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email Us</h4>
                        <p>heavenlyamuya45@gmail.com<br>
                        We'll respond within 24 hours</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form and Map Section -->
    <section class="section" style="background:#f8f9fa;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5">
                    <div class="contact-form">
                        <h3 class="mb-4" style="color: var(--primary-color);">Send Us a Message</h3>
                        
                        <div class="alert alert-success" id="success-alert">
                            <i class="fas fa-check-circle me-2"></i>
                            Thank you for your message! We'll get back to you soon.
                        </div>
<div id="alert-container"></div>
                         <form id="contact-form">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName" class="form-label">First Name *</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName" class="form-label">Last Name *</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject *</label>
                        <select class="form-select" id="subject" name="subject" required>
                            <option value="">Choose a subject...</option>
                            <option value="general">General Inquiry</option>
                            <option value="order">Order Related</option>
                            <option value="complaint">Complaint</option>
                            <option value="feedback">Feedback</option>
                            <option value="wholesale">Wholesale Inquiry</option>
                            <option value="delivery">Delivery Issue</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-4">
                        <label for="message" class="form-label">Message *</label>
                        <textarea class="form-control" id="message" name="message" rows="5" 
                            placeholder="Please describe your inquiry in detail..." required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary-custom" id="submit-btn">
                            <i class="fas fa-paper-plane me-2"></i>
                            <span id="btn-text">Send Message</span>
                        </button>
                    </div>
                </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="hours-card mb-4">
                        <h4><i class="fas fa-clock me-2"></i>Business Hours</h4>
                        <ul class="hours-list">
                            <li>
                                <span class="day">Monday</span>
                                <span class="time">7:00 AM - 8:00 PM</span>
                            </li>
                            <li>
                                <span class="day">Tuesday</span>
                                <span class="time">7:00 AM - 8:00 PM</span>
                            </li>
                            <li>
                                <span class="day">Wednesday</span>
                                <span class="time">7:00 AM - 8:00 PM</span>
                            </li>
                            <li>
                                <span class="day">Thursday</span>
                                <span class="time">7:00 AM - 8:00 PM</span>
                            </li>
                            <li>
                                <span class="day">Friday</span>
                                <span class="time">7:00 AM - 8:00 PM</span>
                            </li>
                            <li>
                                <span class="day">Saturday</span>
                                <span class="time">7:00 AM - 8:00 PM</span>
                            </li>
                            <li>
                                <span class="day">Sunday</span>
                                <span class="time" style="color: var(--primary-color);">Closed</span>
                            </li>
                        </ul>
                    </div>
                    
                    
                    <div class="map-container">
                        <div class="map-overlay">
                            <h6><i class="fas fa-map-marker-alt me-1"></i> MeatFresh Location</h6>
                            <p>Arusha, Tanzania</p>
                            <p><i class="fas fa-directions me-1"></i> Get Directions</p>
                        </div>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127471.14087834827!2d36.6826!3d-3.3869!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x18371b1a17e0ad5b%3A0x8b2ed8d7e3d9c2a0!2sArusha%2C%20Tanzania!5e0!3m2!1sen!2s!4v1704880800000!5m2!1sen!2s"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section faq-section">
        <div class="container">
            <h2 class="text-center mb-5" style="color: var(--text-dark); font-weight: 700;">Frequently Asked Questions</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFAQ(this)">
                            <i class="fas fa-plus me-2"></i>
                            What are your delivery areas?
                        </button>
                        <div class="faq-answer">
                            We currently deliver within Arusha and surrounding areas. Free delivery is available for orders over 75,000 TZS. Contact us to confirm if we deliver to your specific location.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFAQ(this)">
                            <i class="fas fa-plus me-2"></i>
                            How do you ensure product freshness?
                        </button>
                        <div class="faq-answer">
                            We use a cold-chain delivery system that maintains optimal temperatures from our facility to your door. All products are carefully packaged and delivered within 24 hours of processing.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFAQ(this)">
                            <i class="fas fa-plus me-2"></i>
                            Are all your products halal-certified?
                        </button>
                        <div class="faq-answer">
                            Yes, all our chicken and meat products are halal-certified. We work with certified suppliers and follow strict halal guidelines in all our processes.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFAQ(this)">
                            <i class="fas fa-plus me-2"></i>
                            What is your return policy?
                        </button>
                        <div class="faq-answer">
                            We offer a 100% satisfaction guarantee. If you're not completely satisfied with your purchase, contact us within 24 hours of delivery and we'll make it right.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFAQ(this)">
                            <i class="fas fa-plus me-2"></i>
                            Do you offer wholesale prices?
                        </button>
                        <div class="faq-answer">
                            Yes, we offer competitive wholesale prices for restaurants, hotels, and bulk buyers. Contact us directly to discuss your requirements and get a custom quote.
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question" onclick="toggleFAQ(this)">
                            <i class="fas fa-plus me-2"></i>
                            How can I track my order?
                        </button>
                        <div class="faq-answer">
                            Once your order is confirmed, we'll provide you with tracking information via SMS or WhatsApp. You can also call us directly for real-time updates on your delivery.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
      <?php include 'footer.php' ?>


    <script>
        // Initialize cart badge
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        document.getElementById('cart-count').textContent = cart.reduce((total, item) => total + item.quantity, 0);

        // Contact form submission
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simulate form submission
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                document.getElementById('success-alert').style.display = 'block';
                this.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                // Hide success message after 5 seconds
                setTimeout(() => {
                    document.getElementById('success-alert').style.display = 'none';
                }, 5000);
            }, 2000);
        });

        // FAQ toggle functionality
        function toggleFAQ(button) {
            const answer = button.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (answer.classList.contains('show')) {
                answer.classList.remove('show');
                icon.classList.remove('fa-minus');
                icon.classList.add('fa-plus');
            } else {
                // Close all other FAQs
                document.querySelectorAll('.faq-answer.show').forEach(openAnswer => {
                    openAnswer.classList.remove('show');
                    const openIcon = openAnswer.previousElementSibling.querySelector('i');
                    openIcon.classList.remove('fa-minus');
                    openIcon.classList.add('fa-plus');
                });
                
                // Open clicked FAQ
                answer.classList.add('show');
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
        }

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.backdropFilter = 'blur(10px)';
            } else {
                navbar.style.background = '#fff';
                navbar.style.backdropFilter = 'none';
            }
        });
    </script>

     <script>
        // Configuration - Update this URL to match your Laravel API endpoint
        const API_URL = '/api/contact-submissions'; // Change this to your actual API URL
        // For example: const API_URL = 'http://localhost:8000/api/contact-submissions';
        
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contact-form');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const alertContainer = document.getElementById('alert-container');
            
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Clear previous errors
                clearValidationErrors();
                clearAlerts();
                
                // Show loading state
                setLoadingState(true);
                
                // Prepare form data
                const formData = new FormData(form);
                const data = {
                    first_name: formData.get('firstName'),
                    last_name: formData.get('lastName'),
                    email: formData.get('email'),
                    phone: formData.get('phone') || null,
                    subject: formData.get('subject'),
                    message: formData.get('message')
                };
                
                try {
                    const response = await fetch(API_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            // Add CSRF token if needed
                            // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok) {
                        // Success
                        showAlert('success', 'Thank you! Your message has been sent successfully. We\'ll get back to you soon!');
                        form.reset();
                        
                        // Optional: Scroll to top to show success message
                        alertContainer.scrollIntoView({ behavior: 'smooth' });
                        
                    } else {
                        // Handle validation errors
                        if (result.errors) {
                            showValidationErrors(result.errors);
                            showAlert('danger', 'Please correct the errors below and try again.');
                        } else {
                            showAlert('danger', result.message || 'Something went wrong. Please try again.');
                        }
                    }
                    
                } catch (error) {
                    console.error('Error:', error);
                    showAlert('danger', 'Network error. Please check your connection and try again.');
                } finally {
                    setLoadingState(false);
                }
            });
            
            function setLoadingState(loading) {
                submitBtn.disabled = loading;
                if (loading) {
                    btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
                } else {
                    btnText.innerHTML = 'Send Message';
                }
            }
            
            function showAlert(type, message) {
                const alert = document.createElement('div');
                alert.className = `alert alert-${type} alert-dismissible fade show`;
                alert.innerHTML = `
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                `;
                
                alertContainer.appendChild(alert);
                
                // Auto-dismiss after 5 seconds for success messages
                if (type === 'success') {
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 5000);
                }
            }
            
            function clearAlerts() {
                alertContainer.innerHTML = '';
            }
            
            function showValidationErrors(errors) {
                // Map Laravel field names to form field names
                const fieldMapping = {
                    'first_name': 'firstName',
                    'last_name': 'lastName',
                    'email': 'email',
                    'phone': 'phone',
                    'subject': 'subject',
                    'message': 'message'
                };
                
                Object.keys(errors).forEach(field => {
                    const formField = fieldMapping[field] || field;
                    const input = document.querySelector(`[name="${formField}"]`);
                    
                    if (input) {
                        input.classList.add('is-invalid');
                        const feedback = input.parentNode.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.textContent = errors[field][0];
                        }
                    }
                });
            }
            
            function clearValidationErrors() {
                document.querySelectorAll('.is-invalid').forEach(element => {
                    element.classList.remove('is-invalid');
                });
                
                document.querySelectorAll('.invalid-feedback').forEach(element => {
                    element.textContent = '';
                });
            }
            
            // Clear validation errors on input
            form.addEventListener('input', function(e) {
                if (e.target.classList.contains('is-invalid')) {
                    e.target.classList.remove('is-invalid');
                    const feedback = e.target.parentNode.querySelector('.invalid-feedback');
                    if (feedback) {
                        feedback.textContent = '';
                    }
                }
            });
        });
    </script>
</body>
</html> 