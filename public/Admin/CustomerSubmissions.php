
<?php include 'navigation_bar.php' ?>
<?php include 'sidebar.php' ?>
<div class="page-wrapper">
    <!-- Success Alert -->
     <div class="row">
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

    <div class="content">
        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center">
            <div class="page-title">
                <h4>Customer  Submissions</h4>
                <h6>Manage customer  submissions and inquiries</h6>
            </div>
            <div class="page-btn">
                <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-added">
                    <i class="fas fa-plus me-2"></i>Add New Order
                </a> -->
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="search-container">
                    <input type="text" class="search-box" id="searchInput" placeholder="Search by name, email, or subject...">
                   
                </div>
            </div>
            <div class="col-md-3">
                <select id="subjectFilter" class="form-select">
                    <option value="">All Subjects</option>
                    <option value="general">General Inquiry</option>
                    <option value="order">Order Related</option>
                    <option value="complaint">Complaint</option>
                    <option value="feedback">Feedback</option>
                    <option value="wholesale">Wholesale Inquiry</option>
                    <option value="delivery">Delivery Issue</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="dateFilter" class="form-select">
                    <option value="">All Dates</option>
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="this_week">This Week</option>
                    <option value="this_month">This Month</option>
                </select>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card">
            <div class="card-body">
                <!-- Loader -->
                <div id="loader" class="loader-container">
                    <div class="loader"></div>
                    <div class="loader-text">Loading Order Submissions...</div>
                </div>

                <!-- No Data -->
                <div id="no-data" class="no-data-container" style="display: none;">
                    <i class="fas fa-envelope-open no-data-icon"></i>
                    <div class="no-data-title">No Order Submissions Found</div>
                    <div class="no-data-text">There are no customer order submissions available at the moment. New submissions will appear here automatically.</div>
                </div>

                <!-- Table -->
                <div id="table-container" style="display: none;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Phone</th>
                                    <th>Date Submitted</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id='table_body'>
                                <!-- Dynamic content will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div id="pagination-container" class="pagination-container" style="display: none;">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="pagination-info">
                    Showing <span id="showing-start">0</span> to <span id="showing-end">0</span> of <span id="total-records">0</span> entries
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="entries-per-page d-none d-md-block">
                        <label for="entriesPerPage" class="form-label mb-0">Show:</label>
                        <select id="entriesPerPage" class="form-select form-select-sm">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm" id="pagination">
                            <!-- Pagination buttons will be generated here -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Order Modal -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLabel">
                    <i class="fas fa-plus-circle me-2" style="color: #ff9f43;"></i>Add New Order Submission
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-user me-2"></i>First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-user me-2"></i>Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-envelope me-2"></i>Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-phone me-2"></i>Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-tag me-2"></i>Subject</label>
                            <select name="subject" id="subject" class="form-select" required>
                                <option value="" disabled selected>Choose Subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="order">Order Related</option>
                                <option value="complaint">Complaint</option>
                                <option value="feedback">Feedback</option>
                                <option value="wholesale">Wholesale Inquiry</option>
                                <option value="delivery">Delivery Issue</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-comment me-2"></i>Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Enter Message" required></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn" style="background-color: #ff9f43; color: white;" id="save">
                    <i class="fas fa-save me-2"></i>Save Order
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Edit Order Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLabel">
                    <i class="fas fa-edit me-2" style="color: #ff9f43;"></i>Edit Order Submission
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-user me-2"></i>First Name</label>
                            <input type="text" class="form-control" id="edit_first_name" name="first_name" placeholder="Enter First Name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-user me-2"></i>Last Name</label>
                            <input type="text" class="form-control" id="edit_last_name" name="last_name" placeholder="Enter Last Name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-envelope me-2"></i>Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" placeholder="Enter Email Address" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-phone me-2"></i>Phone</label>
                            <input type="tel" class="form-control" id="edit_phone" name="phone" placeholder="Enter Phone Number">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-tag me-2"></i>Subject</label>
                            <select name="subject" id="edit_subject" class="form-select" required>
                                <option value="" disabled>Choose Subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="order">Order Related</option>
                                <option value="complaint">Complaint</option>
                                <option value="feedback">Feedback</option>
                                <option value="wholesale">Wholesale Inquiry</option>
                                <option value="delivery">Delivery Issue</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-comment me-2"></i>Message</label>
                            <textarea class="form-control" id="edit_message" name="message" rows="4" placeholder="Enter Message" required></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn" style="background-color: #ff9f43; color: white;" id="edit_btn">
                    <i class="fas fa-save me-2"></i>Update Order
                </button>
            </div>

        </div>
    </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">
                    <i class="fas fa-eye me-2" style="color: #ff9f43;"></i>Order Submission Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Customer Name:</strong>
                        <p id="view_customer_name"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong>
                        <p id="view_email"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Phone:</strong>
                        <p id="view_phone"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Subject:</strong>
                        <p id="view_subject"></p>
                    </div>
                    <div class="col-12">
                        <strong>Message:</strong>
                        <p id="view_message" style="background: #f8f9fa; padding: 15px; border-radius: 8px;"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Submitted Date:</strong>
                        <p id="view_created_at"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Last Updated:</strong>
                        <p id="view_updated_at"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php';?>

<script>
$(document).ready(function () {
    
  let currentSearch = '';
  let currentSubject = '';
  let currentDateFilter = '';
  let currentPage = 1;
  let perPage = $('#entriesPerPage').val();

 function fetchOrders(search = '', subject = '', dateFilter = '', page = 1, perPage = 10) {
  $('#loader').show();
  $('#table-container').hide();
  $('#pagination-container').hide();
  $('#no-data').hide();

  $.ajax({
    url: `/api/contact-submissions/search`,
    method: 'GET',
    data: { search, subject, date_filter: dateFilter, page, per_page: perPage },
    success: function (response) {
      const data = response.data.data;

      const tbody = $('#table_body').empty();
      if (data.length === 0) {
        $('#no-data').show();
      } else {
        data.forEach(details => {
          tbody.append(renderRowTemplate(details));
        });

        $('#table-container').show();
        $('#pagination-container').show();

        renderPagination(response.data);

        const { current_page, per_page, total } = response.data;
        const start = (current_page - 1) * per_page + 1;
        const end = Math.min(total, current_page * per_page);
        $('#showing-start').text(start);
        $('#showing-end').text(end);
        $('#total-records').text(total);
      }

      $('#loader').hide();
    },
    error: function (err) {
      console.error(err);
      $('#loader').hide();
      $('#no-data').show();
      showAlert('error', 'Failed to load order submissions');
    }
  });
}

  // Search functionality
  $('#searchInput').on('keyup', function () {
    currentSearch = $(this).val().trim();
    currentPage = 1;
    fetchOrders(currentSearch, currentSubject, currentDateFilter, currentPage, perPage);
  });

  // Subject filter
  $('#subjectFilter').on('change', function () {
    currentSubject = $(this).val();
    currentPage = 1;
    fetchOrders(currentSearch, currentSubject, currentDateFilter, currentPage, perPage);
  });

  // Date filter
  $('#dateFilter').on('change', function () {
    currentDateFilter = $(this).val();
    currentPage = 1;
    fetchOrders(currentSearch, currentSubject, currentDateFilter, currentPage, perPage);
  });

  // Entries per page change
  $('#entriesPerPage').on('change', function () {
    perPage = $(this).val();
    currentPage = 1;
    fetchOrders(currentSearch, currentSubject, currentDateFilter, currentPage, perPage);
  });

  // Initial load
  dynamicGet({
    url: `/api/contact-submissions`,
    renderRow: renderRowTemplate
  });

    function renderRowTemplate(details) {
        const subjectLabels = {
            'general': 'General Inquiry',
            'order': 'Order Related',
            'complaint': 'Complaint',
            'feedback': 'Feedback',
            'wholesale': 'Wholesale Inquiry',
            'delivery': 'Delivery Issue'
        };
        
        const subjectColors = {
            'general': 'primary',
            'order': 'success',
            'complaint': 'danger',
            'feedback': 'info',
            'wholesale': 'warning',
            'delivery': 'dark'
        };
        
        const formatDate = (dateString) => {
            return new Date(dateString).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        };
        
        return `
        <tr id="row-${details.id}">
            <td class="productimgname">
                <div>
                    <strong>${details.first_name} ${details.last_name}</strong>
                </div>
            </td>
            <td>${details.email}</td>
            <td>
                <span class="badge bg-${subjectColors[details.subject]} text-white">
                    ${subjectLabels[details.subject] || details.subject}
                </span>
            </td>
            <td>${details.phone || 'N/A'}</td>
            <td>${formatDate(details.created_at)}</td>
            <td>
                <span class="badge bg-success">New</span>
            </td>
            <td>
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a href="javascript:void(0);" class="px-2 openViewModal" data-id="${details.id}" title="View Details">
                            <img src="assets/img/icons/eye.svg" alt="view">
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript:void(0);" class="px-2 openEditModal" 
                           data-id="${details.id}" 
                           data-first_name="${details.first_name}"
                           data-last_name="${details.last_name}"
                           data-email="${details.email}"
                           data-phone="${details.phone || ''}"
                           data-subject="${details.subject}"
                           data-message="${details.message}" title="Edit">
                            <img src="assets/img/icons/edit.svg" alt="edit">
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript:void(0);" class="px-2 openDeleteModal" data-id="${details.id}" id="confirm-color" title="Delete">
                            <img src="assets/img/icons/delete.svg" alt="delete">
                        </a>
                    </li>
                </ul>
            </td>
        </tr>`;
    }

  // Pagination click handler
  $(document).on('click', '#pagination .page-link', function (e) {
    e.preventDefault();
    const page = $(this).data('page');
    if (!page || $(this).parent().hasClass('disabled') || $(this).parent().hasClass('active')) return;
    currentPage = page;
    fetchOrders(currentSearch, currentSubject, currentDateFilter, currentPage, perPage);
  });

  // View modal handler
  $(document).on('click', '.openViewModal', function() {
    const id = $(this).data('id');
    
    $.ajax({
      url: `/api/contact-submissions/${id}`,
      method: 'GET',
      success: function(response) {
        const data = response.data;
        const subjectLabels = {
            'general': 'General Inquiry',
            'order': 'Order Related',
            'complaint': 'Complaint',
            'feedback': 'Feedback',
            'wholesale': 'Wholesale Inquiry',
            'delivery': 'Delivery Issue'
        };
        
        $('#view_customer_name').text(`${data.first_name} ${data.last_name}`);
        $('#view_email').text(data.email);
        $('#view_phone').text(data.phone || 'N/A');
        $('#view_subject').text(subjectLabels[data.subject] || data.subject);
        $('#view_message').text(data.message);
        $('#view_created_at').text(new Date(data.created_at).toLocaleString());
        $('#view_updated_at').text(new Date(data.updated_at).toLocaleString());
        
        $('#viewModal').modal('show');
      },
      error: function() {
        showAlert('error', 'Failed to load order details');
      }
    });
  });

  // Create handler
  handleCreatewithnoimage({
    buttonSelector: '#save',
    containerSelector: '#add',
    url: '/api/contact-submissions'
  });

  // Edit modal handler
  handleEditModalOpen({
    triggerSelector: '.openEditModal',
    containerSelector: '#edit',
    modalId: 'edit'
  });

  // Edit submit handler
  handleEditSubmit({
    buttonSelector: '#edit_btn',
    containerSelector: '#edit',
    idFieldName: 'id',
    urlPrefix: '/api/contact-submissions'
  });

  // Delete handler
  handleDelete({
    triggerSelector: '.openDeleteModal',
    urlPrefix: '/api/contact-submissions'
  });

  // Utility functions (assuming these exist in your main JS file)
  function showAlert(type, message) {
    const alertId = type === 'error' ? 'error-alert' : 'success-alert';
    const messageId = type === 'error' ? 'error-message' : 'success-message';
    
    $(`#${messageId}`).text(message);
    $(`#${alertId}`).show();
    
    setTimeout(() => {
      $(`#${alertId}`).hide();
    }, 5000);
  }

  function renderPagination(data) {
    const pagination = $('#pagination');
    pagination.empty();
    
    const currentPage = data.current_page;
    const lastPage = data.last_page;
    
    // Previous button
    if (currentPage > 1) {
      pagination.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a></li>`);
    }
    
    // Page numbers
    for (let i = Math.max(1, currentPage - 2); i <= Math.min(lastPage, currentPage + 2); i++) {
      const activeClass = i === currentPage ? 'active' : '';
      pagination.append(`<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`);
    }
    
    // Next button
    if (currentPage < lastPage) {
      pagination.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}">Next</a></li>`);
    }
  }
  
});
</script>

</body>
</html>