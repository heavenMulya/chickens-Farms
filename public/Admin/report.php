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
      <div class="card mt-4">
  <div class="card-body">
    <h4 class="card-title mb-4"><i class="fas fa-chart-line me-2"></i>Generate Reports</h4>

    <div class="row g-3 align-items-end mb-4">
      <div class="col-md-4">
        <label for="reportType" class="form-label">Select Report</label>
        <select id="reportType" class="form-select">
          <option value="sales">Sales Report</option>
          <option value="eggs-production">Eggs Production Report</option>
          <option value="chicken-management">Chicken Management Report</option>
          <option value="profit">Profit Report</option>
        </select>
      </div>

      <div class="col-md-4">
        <label for="periodType" class="form-label">Select Period</label>
        <select id="periodType" class="form-select">
          <option value="daily">Daily</option>
          <option value="weekly">Weekly</option>
          <option value="monthly" selected>Monthly</option>
        </select>
      </div>

      <div class="col-md-4">
        <button id="viewReport" class="btn btn-primary w-100">
          <i class="fas fa-eye me-2"></i>View Report
        </button>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered" id="reportTable" style="display: none;">
        <thead id="reportHead"></thead>
        <tbody id="reportBody"></tbody>
      </table>
    </div>
  </div>
</div>

<script>
  
   const API_BASE_URL = 'https://chickens-farms-production-6aa9.up.railway.app/api/reports';

  const apiMap = {
    'sales': `${API_BASE_URL}/sales`,
    'eggs-production': `${API_BASE_URL}/eggs-production`,
    'chicken-management': `${API_BASE_URL}/chicken-management`,
    'profit': `${API_BASE_URL}/profit`
  };


$(document).on('click', '#viewReport', function () {
  const report = $('#reportType').val();
  const period = $('#periodType').val();
  const url = apiMap[report] + `?period=${period}`;

  console.log(url)
    console.log(report)
      console.log(period)

  $('#reportTable').hide();
  $('#reportHead').empty();
  $('#reportBody').empty();

  $.ajax({
    url: url,
    method: 'GET',
    dataType: 'json',
    success: function (res) {
      if (!res.data || res.data.length === 0) {
        $('#reportHead').html('<tr><th>No Data</th></tr>');
        $('#reportBody').html('<tr><td>No data found for selected report.</td></tr>');
        $('#reportTable').show();
        return;
      }

      // Dynamically build table headers based on keys in the first object
      const headers = Object.keys(res.data[0]);
      let thead = '<tr>';
      headers.forEach(h => {
        thead += `<th>${h.replace(/_/g, ' ').toUpperCase()}</th>`;
      });
      thead += '</tr>';

      // Build table body rows
      let tbody = '';
      res.data.forEach(row => {
        tbody += '<tr>';
        headers.forEach(h => {
          tbody += `<td>${row[h] !== null ? row[h] : ''}</td>`;
        });
        tbody += '</tr>';
      });

      $('#reportHead').html(thead);
      $('#reportBody').html(tbody);
      $('#reportTable').show();
    },
    error: function (err) {
      console.error(err);
      $('#reportHead').html('<tr><th>Error</th></tr>');
      $('#reportBody').html('<tr><td>Failed to load report data.</td></tr>');
      $('#reportTable').show();
    }
  });
});

</script>
