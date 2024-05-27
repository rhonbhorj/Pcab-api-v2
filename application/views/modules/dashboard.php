<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <!-- plugins:css -->
    
    <link rel="stylesheet" href="<?php echo base_url('/assets/css/main.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('/assets/vendors/simple-line-icons/css/simple-line-icons.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('/assets/vendors/flag-icon-css/css/flag-icon.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('/assets/vendors/css/vendor.bundle.base.css'); ?>" />

    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="<?php echo base_url('/assets/vendors/daterangepicker/daterangepicker.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('/assets/vendors/chartist/chartist.min.css'); ?>" />

    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?php echo base_url('/assets/css/style.css'); ?>" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?php echo base_url('/assets/images/pcab_logo.png'); ?>" />

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.6/purify.min.js" integrity="sha512-H+rglffZ6f5gF7UJgvH4Naa+fGCgjrHKMgoFOGmcPTRwR6oILo5R+gtzNrpDp7iMV3udbymBVjkeZGNz1Em4rQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
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
#bar-chart::before, #line-chart::before {
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
                    <h4 id = 'totalCount'></h4>
                    <span class="report-count">2 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-success">
                    <i class="icon-rocket"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card bg-primary">
                  <div class="inner-card-text">
                    <span class="report-title">Daily Total No. of Transactions</span>
                    <h4 id= 'totalCount_today'></h4>
                    <span class="report-count">3 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-danger">
                    <i class="icon-briefcase"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card bg-success">
                  <div class="inner-card-text">
                    <span class="report-title">Yesterday Total No. of Transactions</span>
                    <h4 id= 'totalCount_yesterday'>totalCount_yesterday</h4>
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
            
            var responseData = <?php echo $json_data; ?>;
            
            console.log(responseData);
          
            var totalTxnAmount = responseData.alltransaction.total_txn_amount != null ? responseData.alltransaction.total_txn_amount : 0;
            var total_txn_amount_today = responseData.today_transaction.total_txn_amount_total != null ? responseData.today_transaction.total_txn_amount_total : 0.00;
            var total_txn_amount_yesterday = responseData.yesterday_transaction.total_txn_amount_total != null ? responseData.yesterday_transaction.total_txn_amount_total : 0.00;

            var totalCount= responseData.alltransaction.total_count ;
            var totalCount_today = responseData.today_transaction.total_count_today;
            var totalCount_yesterday = responseData.yesterday_transaction.total_count_transaction           
            
            // Display in HTML
            document.getElementById('total-txn-amount').textContent = '₱' + totalTxnAmount;
            document.getElementById('total_txn_amount_today').textContent = '₱'+ total_txn_amount_today;
            document.getElementById('total_txn_amount_yesterday').textContent = '₱'+ total_txn_amount_yesterday;

            document.getElementById('totalCount').textContent = totalCount;
            document.getElementById('totalCount_today').textContent = totalCount_today;
            document.getElementById('totalCount_yesterday').textContent = totalCount_yesterday;




            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawCharts);

function drawCharts() {
  // Static data for daily page hits
  var dailyData = google.visualization.arrayToDataTable([
    ['Day', 'Success', 'Failed'],
    ['Sun', 1050, 600],
    ['Mon', 1370, 910],
    ['Tue', 660, 400],
    ['Wed', 1030, 540],
    ['Thu', 1000, 480],
    ['Fri', 0, 0],
    ['Sat', 0, 0],
    ['Sun', 0, 0]
  ]);

  // Static data for monthly page hits
  var monthlyDataArray = [
    ['Month', 'Success', 'Failed'],
    ['Jan', 22000, 15000],
    ['Feb', 24000, 16000],
    ['Mar', 0, 0],
    ['Apr', 0, 0],
    ['May', 0, 0],
    ['Jun', 0, 0],
    ['Jul', 0, 0],
    ['Aug', 0, 0],
    ['Sep', 0, 0],
    ['Oct', 0, 0],
    ['Nov', 0, 0],
    ['Dec', 0, 0]
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



        });

</script>



<script>

</script>
</body>
</html>
