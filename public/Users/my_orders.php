<?php include 'navbar.php' ?>
    <div class="header">
        
        <div class="container">
            <div class="header-content text-center">
                <i class="fas fa-shopping-bag fa-3x mb-3"></i>
                <h1 class="display-5 fw-bold">My Orders</h1>
                <p class="lead">Track and manage your order history</p>
            </div>
        </div>
    </div>

    <div class="orders-container">
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
        <!-- Filter Section -->
        <div class="filter-section mt-5">
            <h5><i class="fas fa-filter me-2"></i>Filter Orders</h5>
            <div class="row">
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">All Status</option>
                        <option value="Paid">Paid</option>
                        <option value="Unpaid">Unpaid</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" placeholder="From Date">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" placeholder="To Date">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search orders...">
                </div>
            </div>
        </div>

       <div id="orders-list" class="mt-4"></div>
    </div>


    <!-- Contact Support Modal -->
<div class="modal fade" id="contactSupportModal" tabindex="-1" aria-labelledby="contactSupportLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="contactSupportLabel">Contact Support</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Phone: <a href="tel:+255676887277">+255 676 887 277</a></p>
        <p>Email: <a href="mailto:heavenlyamuya45@gmail.com">heavenlyamuya45@gmail.com</a></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Cancel Reason Modal -->
<div class="modal fade" id="cancelReasonModal" tabindex="-1" aria-labelledby="cancelReasonLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="cancelReasonForm">
        <div class="modal-header">
          <h5 class="modal-title" id="cancelReasonLabel">Order Cancellation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Input mode -->
          <div id="cancel-input-section">
            <label for="cancel-reason-textarea" class="form-label">Please enter cancellation reason:</label>
            <textarea class="form-control" id="cancelReasonInput" rows="3"></textarea>
          </div>

          <!-- View mode -->
          <div id="cancel-view-section" style="display:none;">
            <label class="form-label">Cancellation Reason:</label>
            <p id="cancel-reason-display" style="white-space: pre-wrap;"></p>
          </div>
          <input type="hidden" id="cancelOrderId" />
          <div id="cancelReasonAlert" class="alert" style="display:none;"></div>
        </div>

        <!-- Input footer -->
        <div class="modal-footer" id="cancel-input-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger" id="confirm-cancel-btn">Submit Cancellation</button>
        </div>

        <!-- View footer -->
        <div class="modal-footer" id="cancel-view-footer" style="display:none;">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple JavaScript for interactive features
        document.addEventListener('DOMContentLoaded', function() {
            // Filter functionality
            const statusFilter = document.querySelector('.form-select');
            const searchInput = document.querySelector('input[placeholder="Search orders..."]');
            
            // Add event listeners for filtering (basic implementation)
            statusFilter.addEventListener('change', function() {
                console.log('Filter by status:', this.value);
                // Add filtering logic here
            });
            
            searchInput.addEventListener('input', function() {
                console.log('Search:', this.value);
                // Add search logic here
            });
            
            // Order action buttons
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (this.textContent.includes('Track Order')) {
                        e.preventDefault();
                        alert('Redirecting to order tracking...');
                    } else if (this.textContent.includes('Reorder')) {
                        e.preventDefault();
                        alert('Adding items to cart...');
                    } else if (this.textContent.includes('Cancel Order')) {
                        e.preventDefault();
                        if (confirm('Are you sure you want to cancel this order?')) {
                            alert('Order cancellation requested.');
                        }
                    }
                });
            });
        });
    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>
<script>
$(document).ready(function () {
  const token = localStorage.getItem('api_token');
console.log('token is'+token)
  if (!token) {
    $('#orders-list').html('<div class="alert alert-danger text-center">You must be logged in to view your orders.</div>');
   console.log('token is');
    return;
  }
  else{
    console.log('token is not');
  }

  // Cache filter elements
  const $statusFilter = $('.form-select');
  const $fromDate = $('input[placeholder="From Date"]');
  const $toDate = $('input[placeholder="To Date"]');
  const $searchInput = $('input[placeholder="Search orders..."]');

  function fetchOrders() {
    // Build query params based on filter values
    const params = {};

    if ($statusFilter.val()) {
      params.status = $statusFilter.val().toLowerCase();
    }
    if ($fromDate.val()) {
      params.from_date = $fromDate.val();
    }
    if ($toDate.val()) {
      params.to_date = $toDate.val();
    }
    if ($searchInput.val()) {
      params.search = $searchInput.val();
    }

    // Build query string
    const queryString = $.param(params);

    $.ajax({
      url: 'https://chickens-farms-production-6aa9.up.railway.app/api/view-orders' + (queryString ? '?' + queryString : ''),
      method: 'GET',
      headers: {
        'Authorization': 'Bearer ' + token
      },
      success: function (response) {
        const orders = response.orders;

        if (orders.length === 0) {
          $('#orders-list').html('<div class="alert alert-warning text-center">No orders found for your filter criteria.</div>');
          return;
        }

        $('#orders-list').empty();

        orders.forEach(order => {
          const date = new Date(order.created_at).toLocaleString();

          let statusClass = '';
          if (order.status === 'paid') {
            statusClass = 'status-delivered';
          } else if (order.status === 'cancelled') {
            statusClass = 'status-cancelled';
          } else {
            statusClass = 'status-preparing'; // unpaid or others
          }

          let itemsHtml = '';
          if (order.items.length > 0) {
            order.items.forEach(item => {
                console.log(order);
              itemsHtml += `
                <div class="item-row">
                  <img src="https://via.placeholder.com/60x60/d4342c/ffffff?text=🍗" class="item-image" alt="${item.title}">
                  <div class="item-details">
                    <div class="item-name">${item.title}</div>
                    <div class="item-description">Product ID: ${item.product_id}</div>
                    <div class="item-quantity">Qty: ${item.quantity}</div>
                  </div>
                  <div class="item-price">${item.price} ${order.currency}</div>
                </div>
              `;
            });
          } else {
            itemsHtml = `<div class="text-muted">No items found in this order.</div>`;
          }

          let buttons = '';
          if (order.status === 'paid') {
            buttons = `
              <button class="btn btn-outline-primary"><i class="fas fa-receipt me-2"></i>View Receipt</button>
              <button class="btn btn-warning"><i class="fas fa-star me-2"></i>Rate Order</button>
            `;
          } else if (order.status === 'unpaid') {
            buttons = `
              <button  class="btn btn-primary btn-reorder" data-order-id="${order.id}">
  <i class="fas fa-redo me-2"></i>Reorder
</button>
              <button class="btn btn-outline-primary contact-support-btn" type="button" data-bs-toggle="modal" data-bs-target="#contactSupportModal">
  <i class="fas fa-phone me-2"></i>Contact Support
</button>

              <button type="button"  class="btn btn-warning cancel-btn" data-order-id="${order.id}" id="cancel-btn">Cancel Order</button>
            `;
          } else if (order.status === 'cancelled') {
            buttons = `
                   <button  class="btn btn-primary btn-reorder" data-order-id="${order.id}">
  <i class="fas fa-redo me-2"></i>Reorder
</button>
             <button class="btn btn-outline-primary btn-why-cancelled"
            data-cancel-reason="${order.cancel_reason ? order.cancel_reason.replace(/"/g, '&quot;') : 'No reason provided.'}">
      <i class="fas fa-question-circle me-2"></i>Why Cancelled?
    </button>
            `;
          }

          const cardHtml = `
            <div class="order-card">
              <div class="order-header">
                <div>
                  <h4 class="order-number">Order #${order.id}</h4>
                  <div class="order-date">${date}</div>
                </div>
                <span class="order-status ${statusClass}">${order.status}</span>
              </div>
              <div class="order-body">
                <div class="order-items">
                  ${itemsHtml}
                </div>
                <div class="order-summary">
                  <div class="summary-row">
                    <span>Total:</span>
                    <span>${order.amount} ${order.currency}</span>
                  </div>
                </div>
                <div class="order-actions">
                  ${buttons}
                </div>
              </div>
            </div>
          `;

          $('#orders-list').append(cardHtml);
        });
      },
      error: function (err) {
        console.log(err)
        $('#orders-list').html('<div class="alert alert-danger text-center">Failed to fetch your orders. Please try Login First</a>.</div>');
      }
    });
  }

  // Initial fetch on page load
  fetchOrders();

  // Attach event listeners to filters to re-fetch orders on change/input
  $statusFilter.on('change', fetchOrders);
  $fromDate.on('change', fetchOrders);
  $toDate.on('change', fetchOrders);
  $searchInput.on('input', fetchOrders);

  // Handle cancel order button click

 $(document).on('click', '.btn-why-cancelled', function (e) {
  e.preventDefault();
  const reason = $(this).data('cancel-reason') || 'No reason provided.';

  // Toggle modal to view mode
  $('#cancel-input-section').hide();
  $('#cancel-input-footer').hide();
  $('#cancel-view-section').show();
  $('#cancel-view-footer').show();
  $('#cancel-reason-display').text(reason);

  const cancelModal = new bootstrap.Modal(document.getElementById('cancelReasonModal'));
  cancelModal.show();
});

  const cancelModalEl = document.getElementById('cancelReasonModal');
  const cancelModal = new bootstrap.Modal(cancelModalEl);

  // When Cancel Order button clicked, first show SweetAlert confirm
  $(document).on('click', '#cancel-btn', function (e) {
    e.preventDefault();
    const orderId = $(this).data('order-id');

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, cancel it!"
    }).then(result => {
      if (result.isConfirmed) {
        // Store order ID in hidden input and open modal for reason
   // Ensure modal is reset to input mode before showing
$('#cancel-view-section').hide();
$('#cancel-view-footer').hide();
$('#cancel-input-section').show();
$('#cancel-input-footer').show();

$('#cancel-reason-textarea').val('');
$('#cancelReasonAlert').hide();
$('#cancelOrderId').val(orderId); // if using hidden input


        cancelModal.show();
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: "Cancelled",
          text: "Your order is safe 🙂",
          icon: "info"
        });
      }
    });
  });

  // Handle reason form submit inside modal
  $('#cancelReasonForm').on('submit', function (e) {
    e.preventDefault();
    const orderId = $('#cancelOrderId').val();
    const reason = $('#cancelReasonInput').val().trim();
    const token = localStorage.getItem('api_token');

    if (!reason) {
      $('#cancelReasonAlert').removeClass().addClass('alert alert-danger').text('Please enter a cancellation reason.').show();
      return;
    }

    $('#cancelReasonAlert').hide();
    $('#cancelReasonForm button[type="submit"]').prop('disabled', true);

    $.ajax({
      url: `/api/orders/${orderId}/status`,
      method: 'PUT',
      headers: {
        Authorization: 'Bearer ' + token,
        'Content-Type': 'application/json',
      },
      data: JSON.stringify({
        status: 'cancelled',
        cancel_reason: reason
      }),
      success: function (response) {
        cancelModal.hide();
        Swal.fire({
          title: "Order Cancelled",
          text: response.message || "Your order has been cancelled successfully.",
          icon: "success"
        }).then(() => {
          location.reload();
        });
      },
      error: function (xhr) {
        const msg = xhr.responseJSON?.message || "Failed to cancel the order.";
        $('#cancelReasonAlert').removeClass().addClass('alert alert-danger').text(msg).show();
        $('#cancelReasonForm button[type="submit"]').prop('disabled', false);
      }
    });
  });


  // Global cart variable
  let cart = JSON.parse(localStorage.getItem('cart')) || [];



  // Update cart badge
  function updateCartCount() {
    const cartBadge = document.getElementById('cart-count');
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    cartBadge.textContent = totalItems;
  }

  // Save cart to localStorage
  function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
  }

  // Render cart on the cart page
  function renderCart() {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartContainer = document.getElementById('cart-container');

    if (!cartContainer || !cartItemsContainer) return; // skip if not on cart page

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
            <img src="${item.image}" alt="${item.title}" class="cart-item-image me-3" 
              onerror="this.src='https://via.placeholder.com/80x80?text=No+Image'">
            <span class="cart-item-title">${item.title}</span>
          </div>
        </td>
        <td class="cart-item-price">${item.price.toFixed(2)} TZS</td>
        <td class="quantity-controls">
          <button class="qty-btn" onclick="updateQuantity('${item.id}', -1)">−</button>
          <span class="qty-display">${item.quantity}</span>
          <button class="qty-btn" onclick="updateQuantity('${item.id}', 1)">+</button>
        </td>
        <td>${(item.price * item.quantity).toFixed(2)} TZS</td>
        <td><button class="btn-remove" onclick="removeItem('${item.id}')">Remove</button></td>
      </tr>
    `).join('');

    updateSummary();
  }

  // Update quantity
  function updateQuantity(id, change) {
    const item = cart.find(item => item.id === id);
    if (item) {
      item.quantity = Math.max(1, item.quantity + change);
      saveCart();
      renderCart();
    }
  }

  // Remove item
  function removeItem(id) {
    cart = cart.filter(item => item.id !== id);
    saveCart();
    renderCart();
  }

  // Update total
  function updateSummary() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const total = subtotal;

    const subtotalElem = document.getElementById('subtotal');
    const totalElem = document.getElementById('total');

    if (subtotalElem && totalElem) {
      subtotalElem.textContent = `${subtotal.toFixed(2)} TZS`;
      totalElem.textContent = `${total.toFixed(2)} TZS`;
    }
  }

  // Reorder functionality
  $(document).on('click', '.btn-reorder', function (e) {
    e.preventDefault();

    const orderId = $(this).data('order-id');

    if (!token) {
      Swal.fire({ icon: 'warning', title: 'Login Required', text: 'You must be logged in to reorder.' });
      return;
    }

    $.ajax({
      url: `https://chickens-farms-production-6aa9.up.railway.app/api/orders/${orderId}/reorder`,
      type: 'PUT',
      headers: { Authorization: 'Bearer ' + token },
      success: function (response) {
        if (response.items && Array.isArray(response.items)) {
          cart = response.items; // overwrite cart with reordered items
          saveCart();
          Swal.fire({
            icon: 'success',
            title: 'Reordered!',
            text: 'Items have been added to your cart.'
          }).then(() => {
            window.location.href = 'cart.php';
          });
        } else {
          Swal.fire({ icon: 'error', title: 'No Items', text: 'No items returned in reorder response.' });
        }
      },
      error: function (xhr) {
        const msg = xhr.responseJSON?.message || 'Reorder failed';
        Swal.fire({ icon: 'error', title: 'Oops!', text: msg });
      }
    });
  });

  // Run on page load
  document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    renderCart();
  });

  // Optional: Clear cart from browser console
  window.clearCart = function () {
    cart = [];
    saveCart();
    renderCart();
  };


function showSuccess(msg) {

  $('#success-message').text(msg);
  $('#success-alert').show().delay(10000).fadeOut();
}

function showError(msg) {

  $('#error-message').text(msg);
  $('#error-alert').show().delay(10000).fadeOut();
}
});

</script>

</body>
</html>