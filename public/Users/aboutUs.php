<?php include 'header.php' ?>

    <style>
        :root {
            --primary-color: #d4342c;
            
            --text-dark: #2c3e50;
            --text-light: #6c757d;
        }

       

        .page-header {
            background: var(--primary-color);
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

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 3rem;
        }

        .story-card {
            background: white;
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 3rem;
        }

        .story-card h3 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }

        .story-card p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-light);
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .value-card {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-10px);
        }

        .value-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .value-card h4 {
            color: var(--text-dark);
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .team-member {
            text-align: center;
            margin-bottom: 3rem;
        }

        .team-photo {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), #e74c3c);
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .team-member h5 {
            color: var(--text-dark);
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .team-role {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .stats-section {
            /* background: var(--secondary-color); */
            padding: 60px 0;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-light);
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

       
    </style>
</head>
<body>
<?php include 'navbar.php' ?>
<?php include 'alert.php' ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>About MeatFresh</h1>
            <p>Your trusted partner in delivering premium quality chicken, meat, and fresh eggs since our founding</p>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Our Story</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="story-card">
                        <h3>From Farm to Your Table</h3>
                        <p>Founded in the heart of Arusha, Tanzania, MeatFresh began with a simple mission: to provide families with access to premium quality, certified chicken, meat, and fresh eggs. What started as a small family business has grown into a trusted name in the region, serving hundreds of satisfied customers who value quality, freshness, and ethical farming practices.</p>
                        
                        <p>Our journey began when our founder recognized the need for reliable, high-quality meat products in the local market. We partnered with carefully selected local farmers who share our commitment to sustainable farming practices and animal welfare. Today, we continue to honor that original vision by maintaining the highest standards in everything we do.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values Section -->
    <section class="section" >
        <div class="container">
            <h2 class="section-title">Our Values</h2>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4>Quality First</h4>
                    <p>We never compromise on quality. Every product undergoes strict quality checks to ensure you receive only the finest meat and eggs.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h4>Sustainability</h4>
                    <p>We're committed to sustainable farming practices that protect our environment while delivering exceptional products.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h4>Certified</h4>
                    <p>All our products are certified, ensuring they meet the highest religious and ethical standards.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Community Focus</h4>
                    <p>We support local farmers and contribute to the economic growth of our community through fair partnerships.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h4>Reliable Delivery</h4>
                    <p>Our cold-chain delivery system ensures your products arrive fresh, safe, and ready to enjoy.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4>Customer Trust</h4>
                    <p>We build lasting relationships with our customers through transparency, reliability, and exceptional service.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">3</div>
                        <div class="stat-label">Years of Service</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Partner Farms</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Customer Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Meet Our Team</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="team-member">
                        <div class="team-photo">
                            <i class="fas fa-user"></i>
                        </div>
                        <h5>Eng Harryson</h5>
                        <div class="team-role">Founder & CEO</div>
                        <p>Passionate about delivering quality products and building a sustainable business that serves our community.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-member">
                        <div class="team-photo">
                            <i class="fas fa-user"></i>
                        </div>
                        <h5>Sarah Mwanga</h5>
                        <div class="team-role">Manager</div>
                        <p>Ensures every product meets our strict quality standards before reaching your table.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-member">
                        <div class="team-photo">
                            <i class="fas fa-user"></i>
                        </div>
                        <h5>David Mushi</h5>
                        <div class="team-role">Accountant</div>
                        <p>Oversees our delivery operations to ensure your orders arrive fresh and on time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="footer-title"><i class="fas fa-drumstick-bite"></i> MeatFresh</h4>
                    <p>Your trusted source for premium quality chicken, meat, and fresh eggs. We deliver farm-fresh products with guaranteed quality.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="cart.php">Cart</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="footer-title">Categories</h4>
                    <ul class="footer-links">
                        <li><a href="#">Fresh Chicken</a></li>
                        <li><a href="#">Fresh Eggs</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="footer-title">Contact Info</h4>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> Arusha, Tanzania</li>
                        <li><i class="fas fa-phone"></i> +255676887277</li>
                        <li><i class="fas fa-envelope"></i> heavenlyamuya45@gmail.com</li>
                        <li><i class="fas fa-clock"></i> Mon-Sat: 7AM-8PM</li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>© 2025 MeatFresh. All rights reserved. | Quality you can trust <i class="fas fa-heart" style="color: var(--primary-color);"></i> | Certified</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize cart badge
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        document.getElementById('cart-count').textContent = cart.reduce((total, item) => total + item.quantity, 0);

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
</body>
</html>