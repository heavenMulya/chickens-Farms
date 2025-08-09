<?php include 'navbar.php' ?>
<?php include 'alert.php' ?>


<section class="cart-section">
    <div class="container">
 

        <h2 class="section-title mt-5">Your Cart</h2>
        <p class="section-subtitle">Review your selected items and proceed to checkout</p>
        <div id="cart-container">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                </tbody>
            </table>
        </div>


        <div class="cart-summary">
            <h3 class="summary-title">Order Summary</h3>
            <div class="summary-row">
                <span>Subtotal:</span>
                <span id="subtotal">0.00 TZS</span>
            </div>
            <div class="summary-row">
                <span>Delivery Fee:</span>
                <span id="delivery">0.00 TZS</span>
            </div>
            <div class="summary-row">
                <span>Tax (5%):</span>
                <span id="tax">0.00 TZS</span>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <span id="total">0.00 TZS</span>
            </div>
            <a href="dashboard.php#products" class="btn-primary-custom mt-3 d-block text-center">Continue Shopping</a>
        </div>

        <div class="mt-5">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control mb-2" name="first_name" placeholder="First Name" required>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control mb-2" name="last_name" placeholder="Last Name" required>
                </div>
                <div class="col-md-4">
                    <input type="email" class="form-control mb-2" name="email" placeholder="Email" required>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control mb-2" name="phone_number" placeholder="Phone Number" required>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control mb-2" name="description" placeholder="Description" value="Order from MeatFresh">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="delivery_option" class="form-label">Delivery Option</label>
                    <select class="form-select" id="delivery_option" name="delivery_option" required>
                        <option value="delivered">Delivered</option>
                        <option value="pickup">Pickup</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        <option value="cash">Cash</option>
                        <option value="online">Pay Online</option>
                    </select>
                </div>


            </div>

            <button type="submit" class="btn-primary-custom mt-3 w-100" id="checkout-submit-btn">
                <span class="btn-text">Proceed with Payment</span>
                <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true" id="btn-loader"></span>
            </button>


        </div>
    </div>

</section>

<script>
    const token = localStorage.getItem('user_api_token'); // Or use sessionStorage

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    // Update cart badge
    function updateCartBadge() {
        const cartBadge = document.getElementById('cart-count');
        cartBadge.textContent = cart.reduce((total, item) => total + item.quantity, 0);
    }

    // Initialize cart badge on page load
    updateCartBadge();

    function renderCart() {
        const cartItemsContainer = document.getElementById('cart-items');
        const cartContainer = document.getElementById('cart-container');

        if (cart.length === 0) {
            cartContainer.innerHTML = `
                    <div class="empty-cart">
                        <div class="empty-cart-icon"><i class="fas fa-shopping-cart"></i></div>
                        <h3>Your cart is empty</h3>
                        <p>Add some delicious items to get started!</p>
                    </div>
                `;
            updateSummary();
            return;
        }

        cartItemsContainer.innerHTML = cart.map(item => `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="${item.image}" alt="${item.title}" class="cart-item-image me-3" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 80 80%27%3E%3Crect width=%2780%27 height=%2780%27 fill=%27%23ddd%27/%3E%3Ctext x=%2740%27 y=%2740%27 text-anchor=%27middle%27 dy=%27.3em%27 fill=%27%23666%27 font-family=%27Arial%27 font-size=%2712%27%3EImage Not Found%3C/text%3E%3C/svg%3E'">
                            <span class="cart-item-title">${item.title}</span>
                        </div>
                    </td>
                    <td class="cart-item-price">${item.price} TZS</td>
                    <td class="quantity-controls">
                        <button class="qty-btn" onclick="updateQuantity('${item.id}', -1)">−</button>
                        <span class="qty-display">${item.quantity}</span>
                        <button class="qty-btn" onclick="updateQuantity('${item.id}', 1)">+</button>
                    </td>
                    <td>${(item.price * item.quantity)} TZS</td>
                    <td><button class="btn-remove" onclick="removeItem('${item.id}')">Remove</button></td>
                </tr>
            `).join('');

        updateSummary();
    }

    
    function updateQuantity(id, change) {
        const item = cart.find(item => item.id === id);
        if (item) {
            item.quantity = Math.max(1, item.quantity + change);
            saveCart();
            renderCart();
        }
    }

    function removeItem(id) {
        cart = cart.filter(item => item.id !== id);
        saveCart();
        renderCart();
    }

    function updateSummary() {
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        // const deliveryFee = cart.length > 0 ? 5 : 0;
        //const tax = subtotal * 0.05;
        // const total = subtotal + deliveryFee + tax;
        const total = subtotal;

        document.getElementById('subtotal').textContent = `${subtotal.toFixed(2)} TZS`;
        // document.getElementById('delivery').textContent = `$${deliveryFee.toFixed(2)}`;
        // document.getElementById('tax').textContent = `$${tax.toFixed(2)}`;
        document.getElementById('total').textContent = `${total.toFixed(2)} TZS`;
    }

    function saveCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
        const cartBadge = document.getElementById('cart-count');
        cartBadge.textContent = cart.reduce((total, item) => total + item.quantity, 0);
    }

    function checkout() {
        if (cart.length === 0) {
            const msg = 'Your cart is empty! Add some items first.';
            showError(msg);
            return;
        }
        const msg = 'Proceeding to checkout...';
        showError(msg);
    }

    renderCart();

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


    $('#checkout-submit-btn').on('click', function(e) {
        e.preventDefault()
        const userIds = localStorage.getItem('user_id');
        console.log('user id is' + userIds)
        if (!userIds) {
            const currentUrl = window.location.href;
            const loginUrl = `login.php?redirect=${encodeURIComponent(currentUrl)}`;

            showError(`You must be logged in to proceed. <a href="${loginUrl}" class="alert-link">Click here to login</a>.`);
            return;
        }


        if (cart.length === 0) {
            const msg = 'Your cart is empty!';
            showError(msg);
            return;
        }

        $(this).attr('disabled', true);
        $('#btn-loader').removeClass('d-none');
        $('.btn-text').text('Processing...');

        const subtotal = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
        const total = subtotal;

        const userId = localStorage.getItem('user_id'); // 👈 get user ID from storage
        console.log(userId)
        const orderPayload = {
            user_id: userId, // 👈 add user_id to payload
            first_name: $('input[name="first_name"]').val(),
            last_name: $('input[name="last_name"]').val(),
            email: $('input[name="email"]').val(),
            phone_number: $('input[name="phone_number"]').val(),
            description: $('input[name="description"]').val() || 'Order from MeatFresh',
            amount: total.toFixed(2),
            currency: 'TZS',
            delivery_option: $('#delivery_option').val(),
            payment_method: $('#payment_method').val(),
            products: cart.map(item => ({
                id: item.id,
                title: item.title,
                price: item.price,
                quantity: item.quantity
            }))
        };


        console.log(orderPayload);

        // 1. Save Order to Laravel API
        $.ajax({
            url: '/api/orders',
            method: 'POST',
            data: JSON.stringify(orderPayload),
            contentType: 'application/json',
            success: function(orderResponse) {

                if (!orderResponse.success) {
                    //showError('Failed to save order.');
                    const msg = 'Failed to save order.'
                    showError(msg);
                    return;
                }

                const orderId = orderResponse.order_id;
                const paymentMethod = $('#payment_method').val();

                if (paymentMethod === 'online') {
                    initiatePayment(orderPayload, orderId);
                } else {
                    // alert();
                    const msg = 'Order placed successfully. Pay on delivery.'
                    showSuccess(msg);
                    localStorage.removeItem('cart');
                    location.reload();
                }
            },
            error: function(err) {

                console.error(err);
                const msg = 'Could not create order.';
                showError(msg);
            }
        });
    });

    // 2. Call Payment API if method is online
    function initiatePayment(payload, orderId) {
        $.ajax({
            url: '/api/payment/initiate',
            method: 'POST',
            data: JSON.stringify(payload),
            contentType: 'application/json',
            success: function(response) {
                $('#checkout-submit-btn').attr('disabled', false);
                $('#btn-loader').addClass('d-none');
                $('.btn-text').text('Proceed with Payment');

                if (response.success && response.redirect_url) {
                    // Store order ID temporarily to update later after payment success
                    localStorage.setItem('last_order_id', orderId);

                    // Redirect to payment gateway
                    window.location.href = response.redirect_url;
                } else {
                    alert(response.message || 'Payment initiation failed.');
                }
            },
            error: function(err) {
                console.error(err);
                showError('Payment initiation failed.');
            }
        });
    }

    // 3. Update order status after successful payment
    function markOrderAsPaid(orderId) {
        $.ajax({
            url: `/api/orders/${orderId}/mark-paid`,
            method: 'PUT',
            success: function(res) {
                alert('Order payment updated successfully!');
                localStorage.removeItem('cart');
                localStorage.removeItem('last_order_id');
                location.href = 'success.html'; // or home page
            },
            error: function(err) {
                console.error(err);
                alert('Payment successful, but failed to update order status.');
            }
        });
    }

    // 4. Optional: If payment provider redirects back to site, call this
    // Example: Call on page load to check & update paid status
    $(document).ready(function() {
        const paid = new URLSearchParams(window.location.search).get('paid');
        const orderId = localStorage.getItem('last_order_id');
        if (paid === 'true' && orderId) {
            markOrderAsPaid(orderId);
        }
    });



</script>
</body>

</html>