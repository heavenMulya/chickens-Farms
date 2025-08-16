<?php include 'navigation_bar.php'; ?>
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="page-wrapper">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1><i class="fas fa-chart-line"></i> Farm Dashboard</h1>
        <p>Monitor your chicken farm operations, track egg production, and manage your inventory efficiently.</p>
    </div>

    <!-- Filter Controls -->
    <div class="filter-controls">
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

    <!-- Loading Indicator -->
    <div id="summary-loader" class="text-center my-4" style="display: none;">
        <div class="custom-spinner mx-auto"></div>
        <p class="text-muted mt-2">Loading summary data...</p>
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
<?php include 'footer.php'; ?>

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

</div