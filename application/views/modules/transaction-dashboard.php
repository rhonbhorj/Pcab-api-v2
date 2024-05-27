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
<!-- amount graph -->
  </div>
</div>
<script src="https://www.gstatic.com/charts/loader.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const url = '<?php echo base_url() ?>/TransactionReport/dasboardReportData';

    fetch(url)
      .then(response => response.json())
      .then(responseData => {

        console.log(responseData);
        var totalTxnAmount = responseData.alltransaction.total_txn_amount != null ? responseData.alltransaction.total_txn_amount : 0;
        var total_txn_amount_today = responseData.today_transaction.total_txn_amount_today != null ? responseData.today_transaction.total_txn_amount_today : 0;
        var total_txn_amount_yesterday = responseData.yesterday_transaction.total_txn_amount_yesterday != null ? responseData.yesterday_transaction.total_txn_amount_yesterday : 0;

        var totalCount = responseData.alltransaction.total_count;
        var totalCount_today = responseData.today_transaction.total_count_today;
        var totalCount_yesterday = responseData.yesterday_transaction.total_count_transaction;

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
          var dailyData = google.visualization.arrayToDataTable([
            ['Day', 'Success', { role: 'tooltip', 'p': {'html': true}}],
            ['Mon', parseFloat((responseData.all_transaction_this_week.Monday?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.all_transaction_this_week.Monday)],
            ['Tue', parseFloat((responseData.all_transaction_this_week.Tuesday?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.all_transaction_this_week.Tuesday)],
            ['Wed', parseFloat((responseData.all_transaction_this_week.Wednesday?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.all_transaction_this_week.Wednesday)],
            ['Thu', parseFloat((responseData.all_transaction_this_week.Thursday?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.all_transaction_this_week.Thursday)],
            ['Fri', parseFloat((responseData.all_transaction_this_week.Friday?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.all_transaction_this_week.Friday)],
            ['Sat', parseFloat((responseData.all_transaction_this_week.Saturday?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.all_transaction_this_week.Saturday)],
            ['Sun', parseFloat((responseData.all_transaction_this_week.Sunday?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.all_transaction_this_week.Sunday)]
          ]);

          var monthlyData = google.visualization.arrayToDataTable([
            ['Month', 'Success', { role: 'tooltip', 'p': {'html': true}}],
            ['Jan', parseFloat((responseData.monthly_transaction.January?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.monthly_transaction.January)],
            ['Feb', parseFloat((responseData.monthly_transaction.February?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.monthly_transaction.February)],
            ['Mar', parseFloat((responseData.monthly_transaction.March?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.monthly_transaction.March)],
            ['Apr', parseFloat((responseData.monthly_transaction.April?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.monthly_transaction.April)],
            ['May', parseFloat((responseData.monthly_transaction.May?.total_txn_amount ?? '0').replace(/,/g, '')),  createCustomTooltip(responseData.monthly_transaction.May)],
            ['Jun', parseFloat((responseData.monthly_transaction.June?.total_txn_amount ?? '0').replace(/,/g, '')),  createCustomTooltip(responseData.monthly_transaction.June)],
            ['Jul', parseFloat((responseData.monthly_transaction.July?.total_txn_amount ?? '0').replace(/,/g, '')),  createCustomTooltip(responseData.monthly_transaction.July)],
            ['Aug', parseFloat((responseData.monthly_transaction.August?.total_txn_amount ?? '0').replace(/,/g, '')),  createCustomTooltip(responseData.monthly_transaction.August)],
            ['Sep', parseFloat((responseData.monthly_transaction.September?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.monthly_transaction.September)],
            ['Oct', parseFloat((responseData.monthly_transaction.October?.total_txn_amount ?? '0').replace(/,/g, '')), createCustomTooltip(responseData.monthly_transaction.October)],
            ['Nov', parseFloat((responseData.monthly_transaction.November?.total_txn_amount ?? '0').replace(/,/g, '')),  createCustomTooltip(responseData.monthly_transaction.November)],
            ['Dec', parseFloat((responseData.monthly_transaction.December?.total_txn_amount ?? '0').replace(/,/g, '')),  createCustomTooltip(responseData.monthly_transaction.December)]
          ]);

          var barOptions = {
            backgroundColor: 'transparent',
            colors: ['#00507A', '#f08078'],
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
            },
            tooltip: { isHtml: true }
          };

          var lineOptions = {
            backgroundColor: 'transparent',
            colors: ['#00507A', '#f08078'],
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
            pointSize: 5,
            tooltip: { isHtml: true }
          };

          var dailyChart = new google.visualization.ColumnChart(document.getElementById('bar-chart-daily'));
          dailyChart.draw(dailyData, barOptions);

          var monthlyChart = new google.visualization.LineChart(document.getElementById('line-chart-monthly'));
          monthlyChart.draw(monthlyData, lineOptions);

        }

        function createCustomTooltip(data) {
          if (!data) {
            return '<div>No data available</div>';
          }
          return '<div style="padding:10px;"><strong>' + '' + '</strong><br>' +
            'Total Txn Amount: ₱' + data.total_txn_amount + '<br><br>' +
            'Pcab Fee: ₱' + data.pcab_fee + '<br>' +
            'LRF: ₱' + data.lrf + '<br>' +
            'Doc Stamp: ₱' + data.ds_tax + '<br>' +
            'NGSI Fee: ₱' + data.ngsi_convenience_fee + '<br>' +
            '</div>';
        }
      })
      .catch(error => {
        console.error('Error fetching the report data:', error);
      });
  });
  
</script>