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

  span.report-title {
    color: #FFF !important;
    margin-bottom: 20px;
    font-size: 16px !important;
  }

  /* .h4{
    margin-top: -22px !important;
  } */
  .report-inner-card {
    background: #00507A;
    height: 130px;
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

  #bar-chart-daily,
  #line-chart-monthly,
  #bar-chart-daily-count,
  #line-chart-monthly-count {
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
              <H4>Total Transaction Amount</H4>
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

        <div class="card-deck">
          <div class="card">
            <div class="card-body">
              <h5>Daily Page Hits</h5>
              <div id="bar-chart-daily"></div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5>Monthly Page Hits</h5>
              <div id="line-chart-monthly"></div>
            </div>
          </div>
        </div>
      </section>
    </section>

    <section>
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <H4>Total Transaction Count (Success, Failed)</H4>
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

    <section>
      <div class="card-deck">
        <div class="card">
          <div class="card-body">
            <h5>Daily Page Hits</h5>
            <div id="bar-chart-daily-count" style="margin-left: -20px;"></div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5>Monthly Page Hits</h5>
            <div id="line-chart-monthly-count"></div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<!-- <script language="javascript">
  setTimeout(function() {
    window.location.reload(1);
  }, 30000);
</script> -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const url = '<?php echo base_url() ?>/TransactionReport/dasboardReportData';

    fetch(url)
      .then(response => response.json())
      .then(responseData => {

        // console.log(responseData);
        var totalTxnAmount = responseData.alltransaction.total_txn_amount != null ? responseData.alltransaction.total_txn_amount : 0;
        var total_txn_amount_today = responseData.today_transaction.total_txn_amount_today != null ? responseData.today_transaction.total_txn_amount_today : 0;
        var total_txn_amount_yesterday = responseData.yesterday_transaction.total_txn_amount_yesterday != null ? responseData.yesterday_transaction.total_txn_amount_yesterday : 0;

        var totalCount = responseData.alltransaction.total_count_success;
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

          // Bar graph for Daily Total Txn Amount
          const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
          const dailyDataArray = [
            ['Day', 'Success', {
              role: 'tooltip',
              'p': {
                'html': true
              }
            }]
          ];

          daysOfWeek.forEach(day => {
            dailyDataArray.push([
              day.slice(0, 3),
              parseFloat((responseData.all_transaction_this_week[day]?.total_txn_amount ?? '0').replace(/,/g, '')),
              createCustomTooltip(responseData.all_transaction_this_week[day])
            ]);
          });

          var dailyData = google.visualization.arrayToDataTable(dailyDataArray);

          // Line graph for Monthly Total Txn Amount
          const monthOfYear = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
          const monthlyDataArray = [
            ['Day', 'Success', {
              role: 'tooltip',
              'p': {
                'html': true
              }
            }]
          ];

          monthOfYear.forEach(month => {
            monthlyDataArray.push([
              month.slice(0, 3),
              parseFloat((responseData.monthly_transaction[month]?.total_txn_amount ?? '0').replace(/,/g, '')),
              createCustomTooltip(responseData.monthly_transaction[month])
            ]);
          });

          var monthlyData = google.visualization.arrayToDataTable(monthlyDataArray);



          // Bar graph for Daily Total Txn Count Success & Failed
          const daysOfWeekCount = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
          const dailyDataArrayCount = [
            ['Day', 'Success', {
              role: 'tooltip',
              'p': {
                'html': true
              }
            }]
          ];

          daysOfWeekCount.forEach(day => {
            dailyDataArrayCount.push([
              day.slice(0, 3),
              responseData.all_transaction_this_week[day]?.total_count_success ?? '0',
              createCustomTooltipCount(responseData.all_transaction_this_week[day])
            ]);
          });

          var dailyData_count = google.visualization.arrayToDataTable(dailyDataArrayCount);

          // Line graph for Daily Total Txn Count Success & Failed
          const monthOfYearCount = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
          const monthlyDataArrayCount = [
            ['Day', 'Success', {
              role: 'tooltip',
              'p': {
                'html': true
              }
            }]
          ];

          monthOfYearCount.forEach(month => {
            monthlyDataArrayCount.push([
              month.slice(0, 3),
              responseData.monthly_transaction[month]?.total_count_success ?? '0',
              createCustomTooltipCount(responseData.monthly_transaction[month])

            ]);
          });

          var monthlyData_count = google.visualization.arrayToDataTable(monthlyDataArrayCount);




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
            tooltip: {
              isHtml: true
            }
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
            tooltip: {
              isHtml: true
            }
          };

          var dailyChart = new google.visualization.ColumnChart(document.getElementById('bar-chart-daily'));
          dailyChart.draw(dailyData, barOptions);

          var monthlyChart = new google.visualization.ColumnChart(document.getElementById('line-chart-monthly'));
          monthlyChart.draw(monthlyData, lineOptions);

          var dailyChart_count = new google.visualization.ColumnChart(document.getElementById('bar-chart-daily-count'));
          dailyChart_count.draw(dailyData_count, barOptions);

          var monthlyChart_count = new google.visualization.ColumnChart(document.getElementById('line-chart-monthly-count'));
          monthlyChart_count.draw(monthlyData_count, lineOptions);

        }

        function createCustomTooltip(data) {
          if (!data) {
            return '<div>No data available</div>';
          }

          var date_now = data.date ?? '';
          var formatted_date = '';

          if (date_now) {
            var date_parts = date_now.split("-");
            formatted_date = date_parts[1] + "-" + date_parts[2] + "-" + date_parts[0];
          }

          return '<div style="padding:10px;">' +
            '<strong>' + formatted_date + '</strong><br><br>' +
            'Total Txn Amount: ₱' + data.total_txn_amount + '<br><br>' +
            'Pcab Fee: ₱' + data.pcab_fee + '<br>' +
            'LRF: ₱' + data.lrf + '<br>' +
            'Doc Stamp: ₱' + data.ds_tax + '<br>' +
            'NGSI Fee: ₱' + data.ngsi_convenience_fee + '<br><br>' +
            
          '</div>';
        }

        function createCustomTooltipCount(data) {
          if (!data) {
            return '<div>No data available</div>';
          }
          var date_now = data.date ?? '';
          var formatted_date = '';

          if (date_now) {
            var date_parts = date_now.split("-");
            formatted_date = date_parts[1] + "-" + date_parts[2] + "-" + date_parts[0];
          }

          return '<div style="padding:15px;">' +
            '<strong>' + formatted_date + '</strong><br><br>'+
            'Total Count: ' + data.total_count + '<br><br>' +
            'Success: ' + data.total_count_success + '<br>' +
            'Failed: ' + data.total_count_failed + '<br>' +
            'Created: ' + data.total_count_created + '<br><br>' +
            

          '</div>';
        }

      })
      .catch(error => {
        console.error('Error fetching the report data:', error);
      });
  });
</script>