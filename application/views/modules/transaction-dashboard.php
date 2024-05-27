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
  .dashboard-container {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
  }
/*  */

  .report-inner-cards-wrapper {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }
  span.report-title{
    color: #FFF!important;
    margin-bottom: 20px;
    font-size: 16px !important;
  }
  /* .h4{
    margin-top: -22px !important;
  } */
  .report-inner-card {
    background: #00507A;
    height:130px;
    flex: 1;
    margin: 0.5rem;
    padding: 1rem;
    border-radius: 8px;
    color: #FFF;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .inner-card-text {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .inner-card-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem;
    border-radius: 50%;
    font-size: 35px !important;
  }

  .bg-warning {
    background-color: #FFC107;
  }

  .bg-primary {
    background-color: #007BFF;
  }

  .bg-success {
    background-color: #28A745;
  }

  .bg-danger {
    background-color: #DC3545;
  }

  #bar-chart-daily, #line-chart-monthly {
    width: 100%;
    height: 300px;
  }

  .chart-container {
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>
<div class="dashboard-container d-flex flex-direction-row">
  <div class="card w-100 p-3 pb-5">
    <section>
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="row report-inner-cards-wrapper">
                <div class="col-md-6 col-xl report-inner-card ">
                  <div class="inner-card-text">
                    <span class="report-title">YTD Total Amount</span>
                    <h4 id='total-txn-amount'></h4>

                  </div>
                  <div class="inner-card-icon ">
                    <i class="icon-rocket"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">Daily Total Amount</span>
                    <h4 id='total_txn_amount_today'></h4>

                  </div>
                  <div class="inner-card-icon ">
                    <i class="icon-briefcase"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card ">
                  <div class="inner-card-text">
                    <span class="report-title">Yesterday Total Amount</span>
                    <h4 id='total_txn_amount_yesterday'></h4>

                  </div>
                  <div class="inner-card-icon">
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
          <h5 style="margin-left: 30px;">Daily Amount Hits</h5>
          <div id="bar-chart-daily"></div>
        </div>
        <div class="col-md-6">
          <h5>Monthly Amount Hits</h5>
          <div id="line-chart-monthly"></div>
        </div>
      </div>
    </section>
    <section>
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="row report-inner-cards-wrapper">
                <div class="col-md-6 col-xl report-inner-card ">
                  <div class="inner-card-text">
                    <span class="report-title">YTD Total No. of Transactions</span>
                    <h4 id='totalCount'></h4>
                  </div>
                  <div class="inner-card-icon ">
                    <i class="icon-rocket"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card ">
                  <div class="inner-card-text">
                    <span class="report-title">Daily Total No. of Transactions</span>
                    <h4 id='totalCount_today'></h4>
                  </div>
                  <div class="inner-card-icon ">
                    <i class="icon-briefcase"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">Yesterday Total No. of Transactions</span>
                    <h4 id='totalCount_yesterday'>totalCount_yesterday</h4>
                  </div>
                  <div class="inner-card-icon ">
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
          <div id="bar-chart-daily1"></div>
        </div>
        <div class="col-md-6">
          <h5>Monthly Page Hits</h5>
          <div id="line-chart-monthly1"></div>
        </div>
      </div>
    </section>
  </div>
</div>
<script src="https://www.gstatic.com/charts/loader.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // URL to your CodeIgniter controller method
    const url = '<?php echo base_url() ?>/TransactionReport/dasboardReportData';

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
        var totalCount_yesterday = responseData.yesterday_transaction.total_count_transaction;

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
          var dailyData = google.visualization.arrayToDataTable([
            ['Day', 'LRF  ','DSF', 'PCAB Fees'],
            ['Mon', 50,30,20],
            ['Tue', 100,11,50],
            ['Wed', 13,15,30],
            ['Thu', 32,50,30],
            ['Fri', 45,70,10],
            ['Sat', 56,10,40],
            ['Sun', 76,50,56]
          ]);

          // Static data for monthly page hits
          var monthlyData = google.visualization.arrayToDataTable([
            ['Month', 'LRF', 'DSF', 'PCAB Fees'],
            ['Jan', responseData.monthly_transaction.January?.total_count ?? 0, responseData.monthly_transaction.January?.total_count_failed ?? 0,100],
            ['Feb', responseData.monthly_transaction.February?.total_count ?? 0, responseData.monthly_transaction.February?.total_count_failed ?? 0,100],
            ['Mar', responseData.monthly_transaction.March?.total_count ?? 0, responseData.monthly_transaction.March?.total_count_failed ?? 0,100],
            ['Apr', responseData.monthly_transaction.April?.total_count ?? 0, responseData.monthly_transaction.April?.total_count_failed ?? 0,100],
            ['May', responseData.monthly_transaction.May?.total_count ?? 0, responseData.monthly_transaction.May?.total_count_failed ?? 0,100],
            ['Jun', responseData.monthly_transaction.June?.total_count ?? 0, responseData.monthly_transaction.June?.total_count_failed ?? 0,100],
            ['Jul', responseData.monthly_transaction.July?.total_count ?? 0, responseData.monthly_transaction.July?.total_count_failed ?? 0,100],
            ['Aug', responseData.monthly_transaction.August?.total_count ?? 0, responseData.monthly_transaction.August?.total_count_failed ?? 0,100],
            ['Sep', responseData.monthly_transaction.September?.total_count ?? 0, responseData.monthly_transaction.September?.total_count_failed ?? 0,100],
            ['Oct', responseData.monthly_transaction.October?.total_count ?? 0, responseData.monthly_transaction.October?.total_count_failed ?? 0,100],
            ['Nov', responseData.monthly_transaction.November?.total_count ?? 0, responseData.monthly_transaction.November?.total_count_failed ?? 0,100],
            ['Dec', responseData.monthly_transaction.December?.total_count ?? 0, responseData.monthly_transaction.December?.total_count_failed ?? 0,100]
          ]);

          // Options for bar charts
          var barOptions = {
            backgroundColor: 'transparent',
            colors: ['#00507A', '#f08078','#B7FFC0'], // Use Google brand colors
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
            colors: ['#00507A', '#f08078'], // Use Google brand colors
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

          // var dailyChart = new google.visualization.ColumnChart(document.getElementById('bar-chart-daily1'));
          // dailyChart.draw(dailyData, barOptions);

          // // Draw the monthly page hits line chart
          // var monthlyChart = new google.visualization.LineChart(document.getElementById('line-chart-monthly1'));
          // monthlyChart.draw(monthlyData, lineOptions);
        }

      })
      .catch(error => {
        console.error('Error fetching the report data:', error);
      });
  });
</script>