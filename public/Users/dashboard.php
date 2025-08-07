<?php include 'navbar.php' ?>
<?php include 'alert.php' ?>
    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content animate-fadeInUp">
                        <h1 class="hero-title text-dark">Premium Quality Chicken, Meat & Fresh Eggs</h1>
                        <p class="hero-subtitle text-danger">Farm-fresh chicken, premium cuts of meat, and fresh eggs delivered straight to your door. Experience the finest quality with our halal-certified products and sustainable farming practices.</p>
                        <a href="#products" class="btn btn-primary-custom">Shop Now</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image text-center">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3Ccircle cx='200' cy='150' r='80' fill='%23d4342c'/%3E%3Ctext x='200' y='160' text-anchor='middle' fill='%23ffffff' font-size='16' font-family='Arial'%3EPremium Quality%3C/text%3E%3C/svg%3E" 
                             alt="Premium Meat Products" 
                             class="img-fluid" 
                             style="max-width: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-truck-fast"></i>
                        </div>
                        <h3 class="feature-title">Cold Chain Delivery</h3>
                        <p>Temperature-controlled delivery ensuring your meat and dairy products arrive fresh and safe. Free delivery on orders over $75.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h3 class="feature-title">Halal Certified</h3>
                        <p>All our products are halal-certified and sourced from trusted farms that follow strict quality and ethical standards.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Quality Guarantee</h3>
                        <p>100% satisfaction guarantee. If you're not completely satisfied with your purchase, we'll make it right.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="products-section">
        <div class="container">
            <h2 class="section-title">Our Premium Products</h2>
            <p class="section-subtitle">Discover our selection of fresh chicken, premium meats, and farm-fresh eggs</p>
            
            <div class="row" id="table_body"></div>

            
            <div class="text-center mt-5">
                <a href="cart.php" class="btn btn-primary-custom">View Cart</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="footer-title"><i class="fas fa-drumstick-bite"></i> MeatFresh</h4>
                    <p>Your trusted source for premium quality chicken, meat, and fresh eggs. We deliver farm-fresh products with guaranteed quality</p>
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
                        <li><a href="#home">Home</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
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
                    <h4 class="footer-title">Contact Info for Supports</h4>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i>Arusha,Tanazania</li>
                        <li><i class="fas fa-phone"></i>+255676887277</li>
                        <li><i class="fas fa-envelope"></i>heavenlyamuya45@gmail.com</li>
                        <li><i class="fas fa-clock"></i> Mon-Sat: 7AM-8PM</li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>© 2025 MeatFresh. All rights reserved. | Quality you can trust <i class="fas fa-heart" style="color: var(--secondary-color);"></i> | Certified</p>
            </div>
        </div>
    </footer>


    <script>
//console.log()
        // Initialize cart from localStorage
        //let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let cart;
try {
    const cartData = localStorage.getItem('cart');
    cart = Array.isArray(JSON.parse(cartData)) ? JSON.parse(cartData) : [];
} catch (e) {
    cart = [];
}


        // Update cart badge
        function updateCartBadge() {
            const cartBadge = document.getElementById('cart-count');
            cartBadge.textContent = cart.reduce((total, item) => total + item.quantity, 0);
        }

        // Save cart to localStorage
        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartBadge();
        }

        // Smooth scrolling for navigation links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const href = this.getAttribute('href');

        // Ignore if href is just "#" or empty string
        if (href === '#' || href === '') return;

        const target = document.querySelector(href);
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});


        // Add to cart functionality
      document.addEventListener('click', function(event) {
    if (event.target.matches('.btn-add-cart')) {
        const button = event.target;
        const productCard = button.closest('.product-card');
        const productId = productCard.dataset.productId;
        const productTitle = productCard.querySelector('.product-title').textContent;
        const productPrice = parseFloat(productCard.querySelector('.product-price').childNodes[0].textContent.replace(/[^\d.]/g, ''));
        // productPrice = parseFloat(productCard.querySelector('.product-price').childNodes[0].textContent.replace(/[^\d.]/g, ''));

        const productImage = productCard.querySelector('.product-image').src;

        // Check if item already exists in cart
        const existingItem = cart.find(item => item.id === productId);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: productId,
                title: productTitle,
                price: productPrice,
                image: productImage,
                quantity: 1
            });
        }

        // Save cart and update badge
        saveCart();

        // Visual feedback
        button.textContent = 'Added!';
        button.style.background = '#4caf50';

        setTimeout(() => {
            button.textContent = 'Add to Cart';
            button.style.background = '';
        }, 2000);
    }
});


        // Initialize cart badge on page load
        updateCartBadge();

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

        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                }
            });
        }, observerOptions);

        // Observe product cards and feature cards
        document.querySelectorAll('.product-card, .feature-card').forEach(card => {
            observer.observe(card);
        });


        function dynamicGet({
    url,
    renderRow,
    tableBodySelector = '#table_body',
    pagination = true,
    totalSelector = '#total_list',
    entryInfoSelector = '#entry-info',
    onSuccess = null,
    onError = null
}) {
    // 🟡 Show loader before request
    $('#loader').show();
    $('#table-container').hide();
    $('#pagination-container').hide();
    $('#no-data').hide();

    $.ajax({
        method: 'GET',
        url: url,
        dataType: 'json',
        success: function (response) {
         
            const data = response.data.data;
        $('#no-data').hide();
    $('#table-container').hide();
    $('#pagination-container').hide();
    
            const tbody = $(tableBodySelector).empty();
            if (data.length === 0) {
                $('#no-data').show();
                  $('#loader').hide();
            } else {
                data.forEach(item => tbody.append(renderRow(item)));
                $('#table-container').show();
                $('#pagination-container').show();
                 $('#loader').hide();

                if (pagination) {
                    const { current_page, per_page, total } = response.data;
                    const start = (current_page - 1) * per_page + 1;
                    const end = Math.min(total, current_page * per_page);

                    $(totalSelector).text(`( ${total} ) Records`);
                    $(entryInfoSelector).text(`Showing ${start} to ${end} of ${total} entries`);

                    if (typeof renderPagination === 'function') {
                        renderPagination(response.data);
                    }
                }
            }

            if (typeof onSuccess === 'function') onSuccess(response);

            // ✅ Hide loader when data is ready
            $('#loader').hide();
        },
        error: function (error) {
            if (typeof onError === 'function') onError(error);
            else console.error('Fetch error:', error);

            $('#loader').hide();
            $('#no-data').show();
        }
    });
}


          dynamicGet({
    url: `/api/products`,
    renderRow: renderRowTemplate
  });

 function renderRowTemplate(details) {
  return `
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="product-card" data-product-id="${details.id}">
        <div style="position: relative;">
          <img src="${details.image}" alt="${details.name}" class="product-image">
          <div class="quality-badge fresh-badge">FRESH</div>
        </div>
        <div class="product-info">
          <h4 class="product-title">${details.name}</h4>
          <p class="product-weight">${details.Description || '1.2 - 1.5 kg per piece'}</p>
          <div class="product-price">
            ${details.price} TZS <span class="old-price">${details.Discount ? details.Discount + ' TZS' : ''}</span>
          </div>
          <button class="btn-add-cart" data-id="${details.id}" data-name="${details.name}" data-price="${details.price}">Add to Cart</button>
        </div>
      </div>
    </div>
  `;
}


    </script>
</body>
</html>