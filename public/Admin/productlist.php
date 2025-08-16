<?php include 'navigation_bar.php';?>

<?php include 'sidebar.php';?>
    <!-- Main Content -->
    <div class="page-wrapper">
        <!-- Success/Error Alerts -->
        <div class="row">
            <div class="col-md-6 offset-md-6">
                <div class="alert alert-success alert-dismissible fade show pulse" role="alert" style="display: none;" id="success-alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Success!</strong> <span id="success-message">Operation completed successfully.</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show pulse" role="alert" style="display: none;" id="error-alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Error!</strong> <span id="error-message">Something went wrong.</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title">
                <h4><i class="fas fa-box me-3"></i>Product Management</h4>
                <h6>Manage your products with style and efficiency</h6>
            </div>
            <div class="page-btn">
                <a href="#" data-bs-toggle="modal" data-bs-target="#add" class="btn-added">
                    <i class="fas fa-plus"></i>Add New Product
                </a>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" class="search-box" id="searchInput" placeholder="Search products by name, price, or status...">
           
        </div>

        <!-- Main Card -->
        <div class="card fade-in">
            <div class="card-body">
                <!-- Loader -->
                <div id="loader" class="loader-container">
                    <div class="loader"></div>
                    <div class="loader-text">Loading products...</div>
                </div>

                <!-- No Data -->
                <div id="no-data" class="no-data-container" style="display: none;">
                    <i class="fas fa-box-open no-data-icon"></i>
                    <div class="no-data-title">No Products Found</div>
                    <div class="no-data-text">There are no products available at the moment. Click "Add New Product" to get started.</div>
                </div>

                <!-- Table -->
                <div id="table-container" style="display: none;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-box me-2"></i>Product Details</th>
                                    <th><i class="fas fa-dollar-sign me-2"></i>Price</th>
                                    <th><i class="fas fa-calendar me-2"></i>Created</th>
                                    <th><i class="fas fa-cogs me-2"></i>Actions</th>
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

    <!-- Add Product Modal -->
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">
                        <i class="fas fa-plus-circle me-2"></i>Add New Product
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label><i class="fas fa-tag me-2"></i>Product Name</label>
                                <input type="text" id="name" name="name" placeholder="Enter product name" class="form-control">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label><i class="fas fa-align-left me-2"></i>Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter product description"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-dollar-sign me-2"></i>Product Price</label>
                                <input type="text" id="price" name="price" placeholder="0.00" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-percent me-2"></i>Discount Type</label>
                                <select id="discount" name="discount" class="form-select">
                                    <option selected disabled>Select a discount</option>
                                    <option value="">No Discount</option>
                                    <option value="10">10%</option>
                                    <option value="20">20%</option>
                                    <option value="30">30%</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-info-circle me-2"></i>Status</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="Available">Available</option>
                                    <option value="Out Of Stock">Out Of Stock</option>
                                </select>
                            </div>
                        </div>

                         <div class="col-md-6">
            <div class="form-group">
              <label><i class="fas fa-info-circle me-2"></i>Product Type</label>
              <select id="batch_type" name="batch_type" class="form-select">
                <option value="">Choose Product Type</option>
                <option value="meat">Meet</option>
                <option value="eggs">Eggs</option>
              </select>
            </div>
          </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label><i class="fas fa-image me-2"></i>Product Image</label>
                                <div class="image-upload">
                                    <input type="file" id="image" name="image" style="display: none;">
                                    <div class="image-uploads" onclick="document.getElementById('image').click()">
                                        <i class="fas fa-cloud-upload-alt fa-3x floating" style="color: #ff9f43;"></i>
                                        <h4>Click to upload or drag and drop</h4>
                                        <p class="text-muted">PNG, JPG, GIF up to 5MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn" style="background-color: #ff9f43; color: white;" id="save">
                        <i class="fas fa-save me-2"></i>Save Product
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
                        <i class="fas fa-edit me-2"></i>Edit Product
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label><i class="fas fa-tag me-2"></i>Product Name</label>
                                <input type="text" id="edit_name" name="name" class="form-control">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label><i class="fas fa-align-left me-2"></i>Description</label>
                                <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-dollar-sign me-2"></i>Product Price</label>
                                <input type="text" id="edit_price" name="price" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-percent me-2"></i>Discount Type</label>
                                <select id="edit_discount" name="discount" class="form-select">
                                    <option selected disabled>Select a discount</option>
                                    <option value="">No Discount</option>
                                    <option value="10">10%</option>
                                    <option value="20">20%</option>
                                    <option value="30">30%</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-info-circle me-2"></i>Status</label>
                                <select id="edit_status" name="status" class="form-select">
                                    <option value="Available">Available</option>
                                    <option value="Out Of Stock">Out Of Stock</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label><i class="fas fa-image me-2"></i>Product Image</label>
                                <div class="image-upload">
                                    <input type="file" id="edit_image" name="image" style="display: none;">
                                    <div class="image-preview mb-2">
                                        <img id="edit_image_preview" src="" alt="Current Image" width="100" style="display: none; border-radius: 8px;">
                                        <input type="hidden" name="existing_image" id="edit_existing_image">
                                    </div>
                                    <div class="image-uploads" onclick="document.getElementById('edit_image').click()">
                                        <i class="fas fa-cloud-upload-alt fa-3x floating" style="color: #ff9f43;"></i>
                                        <h4>Click to upload new image</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn" style="background-color: #ff9f43; color: white;" id="edit_btn">
                        <i class="fas fa-save me-2"></i>Update Product
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php include 'footer.php';?>
   <script>
    $(document).ready(function() {
        let currentSearch = '';
        let currentPage = 1;
        let perPage = $('#entriesPerPage').val();

        function fetchProducts(search = '', page = 1, perPage = 10) {
            $('#loader').show();
            $('#table-container').hide();
            $('#pagination-container').hide();
            $('#no-data').hide();

            $.ajax({
                url: `/api/products/search`,
                method: 'GET',
                data: {
                    search,
                    page,
                    per_page: perPage
                },
                  headers: {
            Authorization: "Bearer " + localStorage.getItem("admin_api_token"),
        },
                success: function(response) {
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
                        const {
                            current_page,
                            per_page,
                            total
                        } = response.data;
                        const start = (current_page - 1) * per_page + 1;
                        const end = Math.min(total, current_page * per_page);
                        $('#total_list').text(`( ${total} ) Records`);
                        $('#entry-info').text(`Showing ${start} to ${end} of ${total} entries`);
                    }

                    $('#loader').hide();
                },
                error: function(err) {
                    console.error(err);
                    $('#loader').hide();
                    $('#no-data').show();
                }
            });
        }


        $('#searchInput').on('keyup', function() {
            currentSearch = $(this).val().trim();
            currentPage = 1;
            fetchProducts(currentSearch, currentPage, perPage);
        });

        $(document).on('click', '#pagination .page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (!page) return;
            currentPage = page;
            fetchProducts(currentSearch, currentPage, perPage);
        });


        dynamicGet({
            url: `/api/products`,
            renderRow: renderRowTemplate
        });

        function renderRowTemplate(details) {
            return `
      <tr id="row-${details.id}">
        <td class="productimgname">
          <a href="javascript:void(0);" class="product-img">
            <img src="${details.image}" alt="product" />
          </a>
          <a href="javascript:void(0);">${details.name}</a>
        </td>
        <td>${details.price}</td>
        <td>${details.created_at}</td>
        <td>
          <ul class="list-inline mb-0">
            <li class="list-inline-item">
              <a href="javascript:void(0);" class="px-2 openEditModal" data-id="${details.id}" data-name="${details.name}" data-price="${details.price}" data-status="${details.status}" data-discount="${details.Discount}" data-image="${details.image}" data-description="${details.Description}">
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


        $(document).on('click', '#pagination .page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (!page || $(this).parent().hasClass('disabled') || $(this).parent().hasClass('active')) return;
            const perPage = $('#entriesPerPage').val() || 10;
            dynamicGet({
                url: `/api/products?page=${page}&per_page=${perPage}`,
                renderRow: renderRowTemplate
            });
        });

        $(document).on('change', '#entriesPerPage', function() {
            const perPage = $(this).val();
            dynamicGet({
                url: `/api/products?page=1&per_page=${perPage}`,
                renderRow: renderRowTemplate
            });
        });

        handleCreate({
            buttonSelector: '#save',
            containerSelector: '#add',
            url: '/api/products'
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
            urlPrefix: '/api/products'
        });

        handleDelete({
            triggerSelector: '.openDeleteModal',
            urlPrefix: '/api/products'
        });
    })
</script>

</body>
</html>