<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Chicken Management Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      background-color: white;
      min-height: 100vh;
      border-right: 1px solid #e0e0e0;
    }

    .sidebar .nav-link {
      color: #333;
      border-left: 4px solid transparent;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      color: #16a085;
      background-color: #f0fdf9;
      border-left: 4px solid #16a085;
    }

    .header {
      padding: 20px;
      background-color: white;
      border-bottom: 1px solid #e0e0e0;
    }

    .card {
      border-radius: 10px;
    }

    .form-section {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar p-3">
      <h4 class="text-center text-success">🐔 Farm Admin</h4>
      <nav class="nav flex-column mt-4">
        <a class="nav-link active" href="#">Dashboard</a>
        <a class="nav-link" href="#">Add Batch</a>
        <a class="nav-link" href="#">Daily Entries</a>
        <a class="nav-link" href="#">Sales</a>
        <a class="nav-link" href="#">Customer Orders</a>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="col-md-10">
      <div class="header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Chicken Management</h5>
        <button class="btn btn-success">+ Add New Batch</button>
      </div>

      <div class="container mt-4">
        <div class="row g-4">

          <!-- Batch Arrival Form -->
          <div class="col-md-6">
            <div class="form-section">
              <h6 class="mb-3">Add Chicken Arrival (Batch)</h6>
              <form>
                <div class="mb-2">
                  <label class="form-label">Arrival Date</label>
                  <input type="date" class="form-control" required>
                </div>
                <div class="mb-2">
                  <label class="form-label">Quantity</label>
                  <input type="number" class="form-control" min="1" required>
                </div>
                <div class="mb-2">
                  <label class="form-label">Supplier</label>
                  <input type="text" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary w-100">Save Batch</button>
              </form>
            </div>
          </div>

          <!-- Daily Entries -->
          <div class="col-md-6">
            <div class="form-section">
              <h6 class="mb-3">Daily Chicken Entries</h6>
              <form>
                <div class="mb-2">
                  <label class="form-label">Entry Type</label>
                  <select class="form-select" required>
                    <option value="slaughtered">Slaughtered</option>
                    <option value="dead">Dead</option>
                    <option value="sold">Sold</option>
                  </select>
                </div>
                <div class="mb-2">
                  <label class="form-label">Batch Code</label>
                  <input type="text" class="form-control" placeholder="e.g. BATCH-22062025" required>
                </div>
                <div class="mb-2">
                  <label class="form-label">Quantity</label>
                  <input type="number" class="form-control" required>
                </div>
                <div class="mb-2">
                  <label class="form-label">Remarks</label>
                  <input type="text" class="form-control">
                </div>
                <button type="submit" class="btn btn-warning w-100">Submit Entry</button>
              </form>
            </div>
          </div>

          <!-- Orders Table -->
          <div class="col-md-12">
            <div class="form-section">
              <h6 class="mb-3">Online Customer Orders</h6>
              <table class="table table-bordered table-hover">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>#1024</td>
                    <td>Jane Doe</td>
                    <td>Whole Chicken</td>
                    <td>3</td>
                    <td><span class="badge bg-success">Delivered</span></td>
                    <td>2025-06-22</td>
                  </tr>
                  <tr>
                    <td>#1025</td>
                    <td>John Smith</td>
                    <td>Half Chicken</td>
                    <td>5</td>
                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                    <td>2025-06-22</td>
                  </tr>
                  <!-- More rows dynamically -->
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<!-- Bootstrap JS (Optional for dropdowns, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
