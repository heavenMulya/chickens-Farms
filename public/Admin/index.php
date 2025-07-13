
<?php include 'navigation_bar.php' ?>
<?php include 'sidebar.php' ?>

<div class="page-wrapper mt-2">
<div class="content">
<div class="row" id="summary"></div>
<div class="row" id="egg-summary">
  <!-- Egg data cards will be inserted here -->
</div>

   <!-- Main Card -->
      <div class="page-title">
                <h6>Chickens BatchWise Details</h6>
            </div>
        <div class="card">
            <div class="card-body">
                <!-- Loader -->
                <div id="loader" class="loader-container">
                    <div class="loader"></div>
                    <div class="loader-text">Loading BatchWise Details...</div>
                </div>

                <!-- No Data -->
                <div id="no-data" class="no-data-container" style="display: none;">
                    <i class="fas fa-box-open no-data-icon"></i>
                    <div class="no-data-title">No BatchWise Details Found</div>
                </div>

                <!-- Table -->
                <div id="table-container" style="display: none;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Batch Name</th>
                                    <th>total chickens</th>
                                    <th>sold chickens</th>
                                    <th>slaughtered chickens</th>
                                    <th>dead chickens</th>
                                     <th>total eggs</th>
                                    <th>sold eggs</th>
                                    <th>good eggs</th>
                                    <th>good eggs</th>
                                    <th>remaining eggs</th>
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

    

<script>

$(document).ready(function () {

$.get('/api/reports/business-summary', function(response) {
  const chickens = response.chickens;
  const eggs = response.eggs;
  const expenses=response.expenses;
   const profit=response.profit;
    const inventory=response.inventory;
     const revenue=response.revenue;


//console.log(response)
  // Chickens Cards
  const chickenCards = [
    { label: 'Total Chickens', icon: 'assets/img/icons/dash1.svg', value: chickens.total_chickens },
    { label: 'Slaughtered Chickens', icon: 'assets/img/icons/dash2.svg', value: chickens.slaughtered_chickens },
    { label: 'Sold Chickens', icon: 'assets/img/icons/dash3.svg', value: chickens.sold_chickens },
    { label: 'Dead Chickens', icon: 'assets/img/icons/dash4.svg', value: chickens.dead_chickens },
    { label: 'Total Remaining Chickens', icon: 'assets/img/icons/dash4.svg', value: inventory.chickens },
      { label: 'Total Eggs', icon: 'assets/img/icons/dash4.svg', value: eggs.total_eggs },
    { label: 'Good Eggs', icon: 'assets/img/icons/dash4.svg', value: eggs.good_eggs },
    { label: 'Broken Eggs', icon: 'assets/img/icons/dash4.svg', value: eggs.broken_eggs },
    { label: 'Sold Eggs', icon: 'assets/img/icons/dash4.svg', value: eggs.sold_eggs },
    { label: 'Remaining Eggs', icon: 'assets/img/icons/dash4.svg', value: eggs.remaining_eggs },
        { label: 'Total Expenses', icon: 'assets/img/icons/dash4.svg', value: expenses },
        { label: 'profit', icon: 'assets/img/icons/dash4.svg', value: profit }

  ];

  let chickenHtml = '';
  chickenCards.forEach(card => {
    chickenHtml += `
      <div class="col-lg-3 col-sm-6 col-12">
        <div class="dash-widget">
          <div class="dash-widgetimg">
            <span><img src="${card.icon}" alt="img"></span>
          </div>
          <div class="dash-widgetcontent">
            <h5><span class="counters" data-count="${card.value}">0</span></h5>
            <h6>${card.label}</h6>
          </div>
        </div>
      </div>`;
  });

  $('#summary').html(chickenHtml);

  

  
  // Animate all counters
  $('.counters').each(function () {
    const $this = $(this);
    const countTo = $this.attr('data-count');

    $({ countNum: 0 }).animate({
      countNum: countTo
    },
    {
      duration: 1500,
      easing: 'swing',
      step: function () {
        $this.text(Math.floor(this.countNum));
      },
      complete: function () {
        $this.text(this.countNum);
      }
    });
  });
});


$.get('/api/reports/batchwise-summary', function (response) {
    console.log(response.batch_wise_summary)
    const data = response.batch_wise_summary || [];

    const tbody = $('#table_body').empty();
    $('#loader').hide();

    if (data.length === 0) {
        $('#no-data').show();
    } else {
        data.forEach(item => tbody.append(renderRowTemplate(item)));

        $('#table-container').show();
        $('#pagination-container').show();

        // Optional pagination display
        const { current_page, per_page, total } = response.data;
        const start = (current_page - 1) * per_page + 1;
        const end = Math.min(total, current_page * per_page);

        $('#showing-start').text(start);
        $('#showing-end').text(end);
        $('#total-records').text(total);

        if (typeof renderPagination === 'function') {
            renderPagination(response.data);
        }
    }
});



function renderRowTemplate(details) {
  return `
    <tr>
      <td>${details.batch_code || ''}</td>
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
});

</script>





</body>
</html>