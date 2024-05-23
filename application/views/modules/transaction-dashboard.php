<style>
  #bar-chart {
    width: 800px;
    height: 300px;
    position: relative;
  }

  #line-chart {
    width: 800px;
    height: 300px;
    position: relative;
  }

  #bar-chart::before,
  #line-chart::before {
    content: "";
    position: absolute;
    display: block;
    width: 240px;
    height: 30px;
    left: 305px;
    top: 254px;
    background: #FAFAFA;
    box-shadow: 2px 2px 5px 0 #DDD;
  }
</style>


<div class="dashboard-container d-flex flex-direction-row">
  <div class="card w-100 p-3 pb-5">
    <section>
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="d-sm-flex align-items-baseline report-summary-header">
                    <h5 class="font-weight-semibold">Value - amount</h5> <span class="ml-auto">Updated Report</span>
                    <button class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></button>
                  </div>
                </div>
              </div>


              <div class="row report-inner-cards-wrapper bg-secondary" style="height:120px;">
                <div class="col-md-6 col-xl report-inner-card bg-warning">
                  <div class="inner-card-text">
                    <span class="report-title">YTD Total Amount</span>
                    <h4 id='total-txn-amount'></h4>
                    <span class="report-count">2 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-success">
                    <i class="icon-rocket"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card bg-primary">
                  <div class="inner-card-text">
                    <span class="report-title">Daily Total Amount</span>
                    <h4 id='total_txn_amount_today'></h4>
                    <span class="report-count">3 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-danger">
                    <i class="icon-briefcase"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card bg-success">
                  <div class="inner-card-text">
                    <span class="report-title">Yesterday Total Amonut</span>
                    <h4 id='total_txn_amount_yesterday'></h4>
                    <span class="report-count">5 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-warning">
                    <i class="icon-globe-alt"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="row">
        <div class="col-md-6">
          <h5>Daily Page Hits</h5>
          <div id="bar-chart-daily"></div>
        </div>
        <div class="col-md-6">
          <h5>Monthly Page Hits</h5>
          <div id="line-chart-monthly"></div>
        </div>
      </div>
    </section>

    <section>
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="d-sm-flex align-items-baseline report-summary-header">
                    <h5 class="font-weight-semibold">Value - No. of transactions per status (Success, Failed, etc.)</h5>
                    <button class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></button>
                  </div>
                </div>
              </div>
              <div class="row report-inner-cards-wrapper bg-secondary" style="height:120px;">
                <div class="col-md-6 col-xl report-inner-card bg-warning">
                  <div class="inner-card-text">
                    <span class="report-title">YTD Total No. of Transactions</span>
                    <h4 id='totalCount'></h4>
                    <span class="report-count">2 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-success">
                    <i class="icon-rocket"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card bg-primary">
                  <div class="inner-card-text">
                    <span class="report-title">Daily Total No. of Transactions</span>
                    <h4 id='totalCount_today'></h4>
                    <span class="report-count">3 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-danger">
                    <i class="icon-briefcase"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card bg-success">
                  <div class="inner-card-text">
                    <span class="report-title">Yesterday Total No. of Transactions</span>
                    <h4 id='totalCount_yesterday'>totalCount_yesterday</h4>
                    <span class="report-count">5 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-warning">
                    <i class="icon-globe-alt"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
</div>
<script src="https://www.gstatic.com/charts/loader.js"></script>



<script>
  document.addEventListener('DOMContentLoaded', function() {
    // URL to your CodeIgniter controller method
    const url = '<?php echo base_url()?>/TransactionReport/dasboardReportData';

    // Fetch data from the controller
    fetch(url)
      .then(response => response.json()) // Parse the JSON from the response
      .then(responseData => {
        // Handle the JSON data here
        // console.log(data);


        console.log(responseData);

        var totalTxnAmount = responseData.alltransaction.total_txn_amount != null ? responseData.alltransaction.total_txn_amount : 0;
        var total_txn_amount_today = responseData.today_transaction.total_txn_amount_today != null ? responseData.today_transaction.total_txn_amount_today : 0;
        var total_txn_amount_yesterday = responseData.yesterday_transaction.total_txn_amount_yesterday != null ? responseData.yesterday_transaction.total_txn_amount_yesterday : 0;

        var totalCount = responseData.alltransaction.total_count;
        var totalCount_today = responseData.today_transaction.total_count_today;
        var totalCount_yesterday = responseData.yesterday_transaction.total_count_transaction

        // Display in HTML
        document.getElementById('total-txn-amount').textContent = '₱' + totalTxnAmount;
        document.getElementById('total_txn_amount_today').textContent = '₱' + total_txn_amount_today;
        document.getElementById('total_txn_amount_yesterday').textContent = '₱' + total_txn_amount_yesterday;

        document.getElementById('totalCount').textContent = totalCount;
        document.getElementById('totalCount_today').textContent = totalCount_today;
        document.getElementById('totalCount_yesterday').textContent = totalCount_yesterday;

        google.charts.load('current', {
          'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
          // Static data for daily page hits

          function getSafeValue(data, defaultValue) {
            return data != null ? data : defaultValue;
          }
          var dailyData = google.visualization.arrayToDataTable([
            ['Day', 'Success', 'Failed'],

            ['Mon', responseData.all_transaction_this_week.Monday?.total_count ?? 0, responseData.all_transaction_this_week.Monday?.total_count_failed] ?? 0,
            ['Tue', responseData.all_transaction_this_week.Tuesday?.total_count ?? 0, responseData.all_transaction_this_week.Tuesday?.total_count_failed ?? 0],
            ['Wed', responseData.all_transaction_this_week.Wednesday?.total_count ?? 0, responseData.all_transaction_this_week.Wednesday?.total_count_failed ?? 0],
            ['Thu', responseData.all_transaction_this_week.Thursday?.total_count ?? 0, responseData.all_transaction_this_week.Thursday?.total_count_failed ?? 0],
            ['Fri', responseData.all_transaction_this_week.Friday?.total_count ?? 0, responseData.all_transaction_this_week.Friday?.total_count_failed ?? 0],
            ['Sat', responseData.all_transaction_this_week.Saturday?.total_count ?? 0, responseData.all_transaction_this_week.Saturday?.total_count_failed ?? 0],
            ['Sun', responseData.all_transaction_this_week.Sunday?.total_count ?? 0, responseData.all_transaction_this_week.Sunday?.total_count_failed ?? 0]
          ]);

          // Static data for monthly page hits
          var monthlyDataArray = [
            ['Month', 'Success', 'Failed'],
            ['Jan', responseData.monthly_transaction.January?.total_count ?? 0, responseData.monthly_transaction.January?.total_count_failed ?? 0],
            ['Feb', responseData.monthly_transaction.February?.total_count ?? 0, responseData.monthly_transaction.February?.total_count_failed ?? 0],
            ['Mar', responseData.monthly_transaction.March?.total_count ?? 0, responseData.monthly_transaction.March?.total_count_failed ?? 0],
            ['Apr', responseData.monthly_transaction.April?.total_count ?? 0, responseData.monthly_transaction.April?.total_count_failed ?? 0],
            ['May', responseData.monthly_transaction.May?.total_count ?? 0, responseData.monthly_transaction.May?.total_count_failed ?? 0],
            ['Jun', responseData.monthly_transaction.June?.total_count ?? 0, responseData.monthly_transaction.June?.total_count_failed ?? 0],
            ['Jul', responseData.monthly_transaction.July?.total_count ?? 0, responseData.monthly_transaction.July?.total_count_failed ?? 0],
            ['Aug', responseData.monthly_transaction.August?.total_count ?? 0, responseData.monthly_transaction.August?.total_count_failed ?? 0],
            ['Sep', responseData.monthly_transaction.September?.total_count ?? 0, responseData.monthly_transaction.September?.total_count_failed ?? 0],
            ['Oct', responseData.monthly_transaction.October?.total_count ?? 0, responseData.monthly_transaction.October?.total_count_failed ?? 0],
            ['Nov', responseData.monthly_transaction.November?.total_count ?? 0, responseData.monthly_transaction.November?.total_count_failed ?? 0],
            ['Dec', responseData.monthly_transaction.December?.total_count ?? 0, responseData.monthly_transaction.December?.total_count_failed ?? 0]
          ];

          // Filter out months with zero values
          var filteredMonthlyDataArray = monthlyDataArray.filter(function(row) {
            return row[1] !== 0 || row[2] !== 0;
          });

          var monthlyData = google.visualization.arrayToDataTable(filteredMonthlyDataArray);

          // Options for bar charts
          var barOptions = {
            backgroundColor: 'transparent',
            colors: ['#4285F4', '#EA4335'], // Use Google brand colors
            fontName: 'Open Sans',
            chartArea: {
              left: 50,
              top: 10,
              width: '100%',
              height: '70%'
            },
            bar: {
              groupWidth: '70%'
            },
            hAxis: {
              textStyle: {
                fontSize: 11
              }
            },
            vAxis: {
              minValue: 0,
              baselineColor: '#6ad4cd',
              gridlines: {
                color: '#6ad4cd',
                count: 4
              },
              textStyle: {
                fontSize: 11
              }
            },
            legend: {
              position: 'bottom',
              textStyle: {
                fontSize: 12
              }
            },
            animation: {
              duration: 1200,
              easing: 'out'
            }
          };

          // Options for line chart
          var lineOptions = {
            backgroundColor: 'transparent',
            colors: ['#4285F4', '#EA4335'], // Use Google brand colors
            fontName: 'Open Sans',
            chartArea: {
              left: 50,
              top: 10,
              width: '100%',
              height: '70%'
            },
            hAxis: {
              textStyle: {
                fontSize: 11
              }
            },
            vAxis: {
              minValue: 0,
              baselineColor: '#6ad4cd',
              gridlines: {
                color: '#6ad4cd',
                count: 4
              },
              textStyle: {
                fontSize: 11
              }
            },
            legend: {
              position: 'bottom',
              textStyle: {
                fontSize: 12
              }
            },
            animation: {
              duration: 1200,
              easing: 'out'
            },
            lineWidth: 2,
            pointSize: 5
          };

          // Draw the daily page hits bar chart
          var dailyChart = new google.visualization.ColumnChart(document.getElementById('bar-chart-daily'));
          dailyChart.draw(dailyData, barOptions);

          // Draw the monthly page hits line chart
          var monthlyChart = new google.visualization.LineChart(document.getElementById('line-chart-monthly'));
          monthlyChart.draw(monthlyData, lineOptions);
        }


      })
      .catch(error => {
        console.error('Error fetching the report data:', error);
      });
  });
</script>