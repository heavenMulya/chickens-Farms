<!DOCTYPE html>
<html lang="en">

<head>
    
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .badge {
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <?php include 'navigation_bar.php' ?>
    <?php include 'sidebar.php' ?>
    <div class="page-wrapper">
        <!-- Success Alert -->
        <div class="row">
            <div class="col-6"></div>
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
            <div class="col-1"></div>
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
                                <option value="batchwise-details">Batchwise Details</option>
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
                            <label for="fromDate" class="form-label">From Date</label>
                            <input type="date" id="fromDate" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <label for="toDate" class="form-label">To Date</label>
                            <input type="date" id="toDate" class="form-control" />
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
                    <div id="pagination-container" style="display: none;" class="mt-3">
                        <p>Showing <span id="showing-start"></span> to <span id="showing-end"></span> of <span id="total-records"></span> records</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_BASE_URL = '/api/reports';

        const apiMap = {
            'sales': `${API_BASE_URL}/sales`,
            'eggs-production': `${API_BASE_URL}/eggs-production`,
            'chicken-management': `${API_BASE_URL}/chicken-management`,
            'profit': `${API_BASE_URL}/profit`,
            'batchwise-details': `${API_BASE_URL}/batchwise-summary`
        };

        function renderRowTemplate(details) {
            return `
        <tr class="fade-in">
            <td><strong>${details.batch_code || 'N/A'}</strong></td>
            <td>${details.chickens.total_chickens || 0}</td>
            <td>${details.chickens.sold_chickens || 0}</td>
            <td>${details.chickens.slaughtered_chickens || 0}</td>
            <td>${details.chickens.dead_chickens || 0}</td>
            <td>${details.eggs.total_eggs || 0}</td>
            <td>${details.eggs.sold_eggs || 0}</td>
            <td>${details.eggs.good_eggs || 0}</td>
            <td>${details.eggs.broken_eggs || 0}</td>
            <td>${details.eggs.remaining_eggs || 0}</td>
        </tr>`;
        }

        $(document).on('click', '#viewReport', function() {
            const report = $('#reportType').val();
            const period = $('#periodType').val();
            const from = $('#fromDate').val();
            const to = $('#toDate').val();

            // Validate date range if both dates are set
            if (from && to && new Date(from) > new Date(to)) {
                $('#error-message').text('From date cannot be after To date.');
                $('#error-alert').show();
                setTimeout(() => $('#error-alert').fadeOut(), 5000);
                return; // Stop execution if invalid
            }

            let url = apiMap[report] + `?period=${period}`;

            if (from && to) {
                url += `&from=${from}&to=${to}`;
            }

            $('#reportTable').hide();
            $('#reportHead').empty();
            $('#reportBody').empty();
            $('#pagination-container').hide();

            $.ajax({
                url: url,
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('admin_api_token') // Or sessionStorage
                },
                dataType: 'json',
                success: function(res) {
                    if (!res.data && !res.batch_wise_summary || (res.batch_wise_summary && res.batch_wise_summary.length === 0)) {
                        $('#reportHead').html('<tr><th>No Data</th></tr>');
                        $('#reportBody').html('<tr><td>No data found for selected report.</td></tr>');
                        $('#reportTable').show();
                        return;
                    }

                    if (report === 'batchwise-details') {
                        const data = res.batch_wise_summary || [];
                        const headers = [
                            'Batch Code', 'Total Chickens', 'Sold Chickens', 'Slaughtered Chickens', 'Dead Chickens',
                            'Total Eggs', 'Sold Eggs', 'Good Eggs', 'Broken Eggs', 'Remaining Eggs'
                        ];
                        let thead = '<tr>';
                        headers.forEach(h => {
                            thead += `<th>${h}</th>`;
                        });
                        thead += '</tr>';

                        let tbody = '';
                        data.forEach(item => {
                            tbody += renderRowTemplate(item);
                        });

                        $('#reportHead').html(thead);
                        $('#reportBody').html(tbody);
                        $('#reportTable').show();

                        // Pagination handling if applicable
                        if (res.data && res.data.current_page !== undefined) {
                            const {
                                current_page,
                                per_page,
                                total
                            } = res.data;
                            const start = (current_page - 1) * per_page + 1;
                            const end = Math.min(total, current_page * per_page);

                            $('#showing-start').text(start);
                            $('#showing-end').text(end);
                            $('#total-records').text(total);
                            $('#pagination-container').show();

                            if (typeof renderPagination === 'function') {
                                renderPagination(res.data);
                            }
                        }
                    } else {
                        // Generic table rendering for other reports
                        const data = res.data || [];
                        if (data.length === 0) {
                            $('#reportHead').html('<tr><th>No Data</th></tr>');
                            $('#reportBody').html('<tr><td>No data found for selected report.</td></tr>');
                            $('#reportTable').show();
                            return;
                        }

                        const headers = Object.keys(data[0]);
                        let thead = '<tr>';
                        headers.forEach(h => {
                            thead += `<th>${h.replace(/_/g, ' ').toUpperCase()}</th>`;
                        });
                        thead += '</tr>';

                        let tbody = '';
                        data.forEach(row => {
                            tbody += '<tr>';
                            headers.forEach(h => {
                                tbody += `<td>${row[h] !== null ? row[h] : ''}</td>`;
                            });
                            tbody += '</tr>';
                        });

                        $('#reportHead').html(thead);
                        $('#reportBody').html(tbody);
                        $('#reportTable').show();
                    }
                },
                error: function(err) {
                    console.error(err);
                    $('#error-message').text('Failed to load report data.');
                    $('#error-alert').show();
                    setTimeout(() => $('#error-alert').fadeOut(), 5000);
                    $('#reportHead').html('<tr><th>Error</th></tr>');
                    $('#reportBody').html('<tr><td>Failed to load report data.</td></tr>');
                    $('#reportTable').show();
                }
            });
        });
    </script>
</body>

</html>