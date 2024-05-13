<?php
// $dash_report = array_slice($data, 0, 5) 
?>
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
                    <h5 class="font-weight-semibold">Report Summary</h5> <span class="ml-auto">Updated Report</span>
                    <button class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></button>
                  </div>
                </div>
              </div>
              <div class="row report-inner-cards-wrapper">
                <div class=" col-md -6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">EXPENSE</span>
                    <h4>$32123</h4>
                    <span class="report-count"> 2 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-success">
                    <i class="icon-rocket"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">PURCHASE</span>
                    <h4>95,458</h4>
                    <span class="report-count"> 3 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-danger">
                    <i class="icon-briefcase"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">QUANTITY</span>
                    <h4>2650</h4>
                    <span class="report-count"> 5 Reports</span>
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
    <section>
      <div class="row">
        <div class="col-md-6">
          <h5>Daily Page Hits</h5>
          <div id="bar-chart-daily"></div>
        </div>
        <div class="col-md-6">
          <h5>Monthly Page Hits</h5>
          <div id="bar-chart-monthly"></div>
        </div>
      </div>
    </section>

    </section>
    <section>
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="d-sm-flex align-items-baseline report-summary-header">
                    <h5 class="font-weight-semibold">Report Summary</h5> <span class="ml-auto">Updated Report</span>
                    <button class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></button>
                  </div>
                </div>
              </div>
              <div class="row report-inner-cards-wrapper">
                <div class=" col-md -6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">EXPENSE</span>
                    <h4>$32123</h4>
                    <span class="report-count"> 2 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-success">
                    <i class="icon-rocket"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">PURCHASE</span>
                    <h4>95,458</h4>
                    <span class="report-count"> 3 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-danger">
                    <i class="icon-briefcase"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">QUANTITY</span>
                    <h4>2650</h4>
                    <span class="report-count"> 5 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-warning">
                    <i class="icon-globe-alt"></i>
                  </div>
                </div>
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">RETURN</span>
                    <h4>25,542</h4>
                    <span class="report-count"> 9 Reports</span>
                  </div>
                  <div class="inner-card-icon bg-primary">
                    <i class="icon-diamond"></i>
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
    ['Fri', 1170, 960],
    ['Sat', 660, 320]
  ]);

  // Static data for monthly page hits
  var monthlyData = google.visualization.arrayToDataTable([
    ['Month', 'Success', 'Failed'],
    ['Jan', 22000, 15000],
    ['Feb', 24000, 16000],
    ['Mar', 28000, 18000],
    ['Apr', 25000, 16000],
    ['May', 26000, 17000],
    ['Jun', 29000, 19000]
  ]);

  // Options for bar charts
  var barOptions = {
    backgroundColor: 'transparent',
    colors: ['#24f211', '#fc0303'],
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

  // Draw the daily page hits bar chart
  var dailyChart = new google.visualization.ColumnChart(document.getElementById('bar-chart-daily'));
  dailyChart.draw(dailyData, barOptions);

  // Draw the monthly page hits bar chart
  var monthlyChart = new google.visualization.ColumnChart(document.getElementById('bar-chart-monthly'));
  monthlyChart.draw(monthlyData, barOptions);
}
</script>

</script>