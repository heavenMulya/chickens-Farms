  <!-- Include your existing navigation and sidebar -->
    <?php include 'navigation_bar.php' ?>
    <?php include 'sidebar.php' ?>

<style>
    :root {
        --primary-color: #4f46e5;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --light-bg: #f8fafc;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --card-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6366f1 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 1.5rem 1.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
        border: 0;
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-hover-shadow);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-color);
        transition: width 0.3s ease;
    }

    .stat-card:hover::before {
        width: 6px;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .stat-primary {
        background: linear-gradient(135deg, var(--primary-color), #6366f1);
    }

    .stat-success {
        background: linear-gradient(135deg, var(--success-color), #059669);
    }

    .stat-warning {
        background: linear-gradient(135deg, var(--warning-color), #d97706);
    }

    .stat-danger {
        background: linear-gradient(135deg, var(--danger-color), #dc2626);
    }

    .stat-info {
        background: linear-gradient(135deg, var(--info-color), #2563eb);
    }

    .stat-number {
        font-size: 1rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .stat-label {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        margin: 0;
    }

    .stat-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 1rem 0;
    }

    .table-card {
        background: white;
        border-radius: 1rem;
        box-shadow: var(--card-shadow);
        border: 0;
        overflow: hidden;
    }

    .table-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: #f8fafc;
        color: #374151;
        font-weight: 600;
        border: none;
        padding: 1rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table tbody td {
        padding: 1rem;
        border-color: #f1f5f9;
        color: #374151;
        font-weight: 500;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    .loader-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem;
    }

    .custom-spinner {
        width: 3rem;
        height: 3rem;
        border: 3px solid #e2e8f0;
        border-top: 3px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .no-data-container {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }

    .no-data-icon {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .pagination {
        --bs-pagination-color: var(--primary-color);
        --bs-pagination-hover-color: white;
        --bs-pagination-hover-bg: var(--primary-color);
        --bs-pagination-active-bg: var(--primary-color);
        --bs-pagination-active-border-color: var(--primary-color);
    }

    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .badge-outline {
        border: 2px solid currentColor;
        background: transparent;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem 0;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            margin-bottom: 1rem;
        }
    }
</style>


    <div class="page-wrapper">

        <div class="container mb-4">
            <div class="row align-items-end">
                <div class="col-md-auto mb-2">
                    <button class="btn btn-outline-primary filter-btn" data-filter="daily">Daily</button>
                    <button class="btn btn-outline-primary filter-btn" data-filter="weekly">Weekly</button>
                    <button class="btn btn-outline-primary filter-btn" data-filter="monthly">Monthly</button>
                </div>
                <div class="col-md-auto mb-2">
                    <input type="date" id="from-date" class="form-control" placeholder="From date">
                </div>
                <div class="col-md-auto mb-2">
                    <input type="date" id="to-date" class="form-control" placeholder="To date">
                </div>
                <div class="col-md-auto mb-2">
                    <button class="btn btn-success" id="custom-filter-btn">Apply</button>
                    <button class="btn btn-secondary" id="reset-filter-btn">Reset</button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div id="summary-loader" class="text-center my-4" style="display: none;">
                <div class="custom-spinner mx-auto"></div>
                <p class="text-muted mt-2">Loading summary data...</p>
            </div>

            <div class="row mb-4" id="chicken-summary">
                <!-- Cards will be inserted here by JavaScript -->
            </div>
            <!-- Chicken Summary Cards -->
            <div class="row mb-4" id="chicken-summary">
                <!-- Cards will be inserted here by JavaScript -->
            </div>

            <!-- Other Summary Cards -->
            <div class="row mb-4" id="other-summary">
                <!-- Cards will be inserted here by JavaScript -->
            </div>


        </div>
    </div>

  
    <script>
        function fetchSummary(params = {}) {
            let url = '/api/reports/business-summary';
            const query = new URLSearchParams(params).toString();
            if (query) url += '?' + query;

            $('#summary-loader').show();
            $('#chicken-summary').empty();
            $('#other-summary').empty();

            $.ajax({
                url: url,
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('admin_api_token') // Or sessionStorage
                },
                success: function(response) {
                    $('#summary-loader').hide();

                    const chickens = response.chickens;
                    const eggs = response.eggs;
                    const expenses = response.expenses;
                    const profit = response.profit;
                    const inventory = response.inventory;
                    const revenue = response.revenue;

                    const combinedChickenCards = [{
                            label1: 'Total Chickens',
                            value1: chickens.total_chickens,
                            label2: 'Sold Chickens',
                            value2: chickens.sold_chickens,
                            icon: 'fas fa-drumstick-bite',
                            colorClass: 'stat-primary'
                        },
                        {
                            label1: 'Slaughtered Chickens',
                            value1: chickens.slaughtered_chickens,
                            label2: 'Dead Chickens',
                            value2: chickens.dead_chickens,
                            icon: 'fas fa-exclamation-triangle',
                            colorClass: 'stat-warning'
                        },
                        {
                            label1: 'Remaining Chickens',
                            value1: inventory.chickens,
                            label2: 'Current Profit',
                            value2: profit,
                            icon: 'fas fa-chart-line',
                            colorClass: 'stat-success'
                        }
                    ];

                    const combinedOtherCards = [{
                            label1: 'Total Eggs',
                            value1: eggs.total_eggs,
                            label2: 'Good Eggs',
                            value2: eggs.good_eggs,
                            icon: 'fas fa-egg',
                            colorClass: 'stat-info'
                        },
                        {
                            label1: 'Broken Eggs',
                            value1: eggs.broken_eggs,
                            label2: 'Sold Eggs',
                            value2: eggs.sold_eggs,
                            icon: 'fas fa-shopping-cart',
                            colorClass: 'stat-warning'
                        },
                        {
                            label1: 'Remaining Eggs',
                            value1: eggs.remaining_eggs,
                            label2: 'Total Expenses',
                            value2: expenses,
                            icon: 'fas fa-wallet',
                            colorClass: 'stat-danger'
                        }
                    ];

                    let chickenHtml = '';
                    combinedChickenCards.forEach(card => {
                        chickenHtml += `
                    <div class="col-xl-4 col-md-6 col-12 mb-3">
                        <div class="stat-card fade-in">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="stat-icon ${card.colorClass} text-white">
                                        <i class="${card.icon}"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <h3 class="stat-number">
                                            <span class="counters" data-count="${card.value1}">0</span>
                                        </h3>
                                        <p class="stat-label">${card.label1}</p>
                                    </div>
                                </div>
                            </div>
                            ${card.label2 ? `
                            <div class="stat-divider"></div>
                            <div class="row align-items-center">
                                <div class="col-6"></div>
                                <div class="col-6">
                                    <div>
                                        <h4 class="stat-number" style="font-size: 1.5rem;">
                                            <span class="counters" data-count="${card.value2}">0</span>
                                        </h4>
                                        <p class="stat-label">${card.label2}</p>
                                    </div>
                                </div>
                            </div>` : ''}
                        </div>
                    </div>`;
                    });

                    let otherHtml = '';
                    combinedOtherCards.forEach(card => {
                        otherHtml += `
                    <div class="col-xl-4 col-md-6 col-12 mb-3">
                        <div class="stat-card fade-in">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="stat-icon ${card.colorClass} text-white">
                                        <i class="${card.icon}"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <h3 class="stat-number">
                                            <span class="counters" data-count="${card.value1}">0</span>
                                        </h3>
                                        <p class="stat-label">${card.label1}</p>
                                    </div>
                                </div>
                            </div>
                            ${card.label2 ? `
                            <div class="stat-divider"></div>
                            <div class="row align-items-center">
                                <div class="col-6"></div>
                                <div class="col-6">
                                    <div>
                                        <h4 class="stat-number" style="font-size: 1.5rem;">
                                            <span class="counters" data-count="${card.value2}">0</span>
                                        </h4>
                                        <p class="stat-label">${card.label2}</p>
                                    </div>
                                </div>
                            </div>` : ''}
                        </div>
                    </div>`;
                    });

                    $('#chicken-summary').html(chickenHtml);
                    $('#other-summary').html(otherHtml);

                    $('.counters').each(function() {
                        const $this = $(this);
                        const countTo = parseInt($this.attr('data-count'));

                        $({
                            countNum: 0
                        }).animate({
                            countNum: countTo
                        }, {
                            duration: 2000,
                            easing: 'swing',
                            step: function() {
                                $this.text(Math.floor(this.countNum).toLocaleString());
                            },
                            complete: function() {
                                $this.text(countTo.toLocaleString());
                            }
                        });
                    });
                },
                error: function(xhr) {
                    $('#summary-loader').hide();
                    if (xhr.status === 401) {
                        window.location.href = '/Users/login.php'; // redirect to login if unauthorized
                    } else {
                        $('#chicken-summary').html('<div class="text-danger text-center">Failed to load chicken data.</div>');
                        $('#other-summary').html('<div class="text-danger text-center">Failed to load egg/finance data.</div>');
                    }
                }
            });
        }


        $(document).ready(function() {
           

            fetchSummary(); // Load default (all data)

            $('.filter-btn').on('click', function() {
                const filter = $(this).data('filter');
                $('#from-date').val('');
                $('#to-date').val('');
                fetchSummary({
                    filter
                });
            });

            $('#custom-filter-btn').on('click', function() {
                const from = $('#from-date').val();
                const to = $('#to-date').val();
                if (from && to) {
                    fetchSummary({
                        from,
                        to
                    });
                } else {
                    alert('Please select both From and To dates');
                }
            });

            $('#reset-filter-btn').on('click', function() {
                $('#from-date').val('');
                $('#to-date').val('');
                fetchSummary();
            });
        });
    </script>

</body>

</html>