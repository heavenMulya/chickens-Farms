<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
   
</head>
<body>
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
                <h4>User Management List</h4>
                <h6>Manage your Users with style</h6>
            </div>
            <div class="page-btn">
                <a href="#" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-added">
                    <i class="fas fa-plus me-2"></i>Add New Users
                </a>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" class="search-box" id="searchInput" placeholder="Search Users...">
            <i class="fas fa-search search-icon"></i>
        </div>

        <!-- Main Card -->
        <div class="card">
            <div class="card-body">
                <!-- Loader -->
                <div id="loader" class="loader-container">
                    <div class="loader"></div>
                    <div class="loader-text">Loading Users...</div>
                </div>

                <!-- No Data -->
                <div id="no-data" class="no-data-container" style="display: none;">
                    <i class="fas fa-box-open no-data-icon"></i>
                    <div class="no-data-title">No Users Found</div>
                    <div class="no-data-text">There are no Users available at the moment. Click "Add New Users" to get started.</div>
                </div>

                <!-- Table -->
                <div id="table-container" style="display: none;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>email</th>
                                    <th>Created At</th>
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

<!-- Add Product Modal -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLabel">
                    <i class="fas fa-plus-circle me-2" style="color: #ff9f43;"></i>Add New Users
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
        
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-align-left me-2"></i>Name</label>
                            <input type="text"  id="name" name="name"  placeholder="Enter Name" />
                        </div>
                    </div>
                     <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-align-left me-2"></i>Email</label>
                            <input type="text"  id="email" name="email"  placeholder="Enter Email" />
                        </div>
                    </div>
                     <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-align-left me-2"></i>Password</label>
                            <input type="text"  id="password" name="password"  placeholder="Enter password" />
                        </div>
                    </div>
                     <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-align-left me-2"></i>Confirm Password</label>
                            <input type="text"  id="confirm_password" name="confirm_password"  placeholder="Enter Confirm Password" />
                        </div>
                    </div>
    </div>
    </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn" style="background-color: #ff9f43; color: white;" id="save">
                    <i class="fas fa-save me-2"></i>Save User
                </button>
            </div>

        </div>
    </div>
</div>


<!-- Edit Product Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLabel">
                    <i class="fas fa-edit me-2" style="color: #ff9f43;"></i>Edit Users
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                    <div class="row">
                    <input type="hidden" id="edit_id" name="id">

                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-align-left me-2"></i>Name</label>
                            <input type="text"  id="edit_name" name="name"  placeholder="Enter Name" />
                        </div>
                    </div>
                     <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-align-left me-2"></i>Email</label>
                            <input type="text"  id="email" name="email"  placeholder="Enter Email" />
                        </div>
                    </div>
                     <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-align-left me-2"></i>Password</label>
                            <input type="text"  id="edit_password" name="password"  placeholder="Enter password" />
                        </div>
                    </div>
                     <div class="col-12">
                        <div class="form-group">
                            <label><i class="fas fa-align-left me-2"></i>Confirm Password</label>
                            <input type="text"  id="edit_confirm_password" name="confirm_password"  placeholder="Enter Confirm Password" />
                        </div>
                    </div>
    </div>
    </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn" style="background-color: #ff9f43; color: white;" id="edit_btn">
                    <i class="fas fa-save me-2"></i>Update Users
                </button>
            </div>

        </div>
    </div>
    
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>

  
$(document).ready(function () {
    
  let currentSearch = '';
  let currentPage = 1;
  let perPage = $('#entriesPerPage').val();

 function fetchProducts(search = '', page = 1, perPage = 10) {
  $('#loader').show();
  $('#table-container').hide();
  $('#pagination-container').hide();
  $('#no-data').hide();

  $.ajax({
    url: `http://localhost:8000/api/users/search`,
    method: 'GET',
    data: { search, page, per_page: perPage },
    success: function (response) {
      const data = response.data.data;

      const tbody = $('#table_body').empty();
      if (data.length === 0) {
        $('#no-data').show();
      } else {
        data.forEach(details => {
          tbody.append(renderRowTemplate(details)); // ✅ render each row
        });

        $('#table-container').show();
        $('#pagination-container').show();

        // ✅ Show pagination
        renderPagination(response.data);

        // ✅ Update entry info
        const { current_page, per_page, total } = response.data;
        const start = (current_page - 1) * per_page + 1;
        const end = Math.min(total, current_page * per_page);
        $('#total_list').text(`( ${total} ) Records`);
        $('#entry-info').text(`Showing ${start} to ${end} of ${total} entries`);
      }

      $('#loader').hide();
    },
    error: function (err) {
      console.error(err);
      $('#loader').hide();
      $('#no-data').show();
    }
  });
}


  $('#searchInput').on('keyup', function () {
    currentSearch = $(this).val().trim();
    currentPage = 1;
    fetchProducts(currentSearch, currentPage, perPage);
  });

  $(document).on('click', '#pagination .page-link', function (e) {
    e.preventDefault();
    const page = $(this).data('page');
    if (!page) return;
    currentPage = page;
    fetchProducts(currentSearch, currentPage, perPage);
  });


  dynamicGet({
    url: `http://localhost:8000/api/users`,
    renderRow: renderRowTemplate
  });

    function renderRowTemplate(details) {
    return `
      <tr id="row-${details.id}">
        <td>${details.name}</td>
        <td>${details.email}</td>
        <td>${details.created_at}</td>
        <td>
          <ul class="list-inline mb-0">
            <li class="list-inline-item">
              <a href="javascript:void(0);" class="px-2 openEditModal" data-id="${details.id}" data-created_at="${details.created_at}" data-name="${details.name}"  data-email="${details.email}">
                <img src="assets/img/icons/edit.svg" alt="edit">
              </a>
            </li>
            <li class="list-inline-item">
              <a href="javascript:void(0);" class="px-2 openDeleteModal" data-id="${details.id}" id="confirm-color">
                <img src="assets/img/icons/delete.svg" alt="delete">
              </a>
            </li>
          </ul>
        </td>
      </tr>`;
  }


  $(document).on('click', '#pagination .page-link', function (e) {
    e.preventDefault();
    const page = $(this).data('page');
    if (!page || $(this).parent().hasClass('disabled') || $(this).parent().hasClass('active')) return;
    const perPage = $('#entriesPerPage').val() || 10;
    dynamicGet({
      url: `http://localhost:8000/api/users?page=${page}&per_page=${perPage}`,
      renderRow: renderRowTemplate
    });
  });

  $(document).on('change', '#entriesPerPage', function () {
    const perPage = $(this).val();
    dynamicGet({
      url: `http://localhost:8000/api/users?page=1&per_page=${perPage}`,
      renderRow: renderRowTemplate
    });
  });

  handleCreatewithnoimage({
    buttonSelector: '#save',
    containerSelector: '#add',
    url: 'http://localhost:8000/api/users'
  });

  handleEditModalOpen({
    triggerSelector: '.openEditModal',
    containerSelector: '#edit',
    modalId: 'edit'
  });

  handleEditSubmit({
    buttonSelector: '#edit_btn',
    containerSelector: '#edit',
    idFieldName: 'id',
    urlPrefix: 'http://localhost:8000/api/users'
  });

  handleDelete({
    triggerSelector: '.openDeleteModal',
    urlPrefix: 'http://localhost:8000/api/users'
  });
  
})

</script>

</body>
</html>