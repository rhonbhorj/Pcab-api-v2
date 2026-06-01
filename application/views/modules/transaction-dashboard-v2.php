<?php
/**
 * Transaction Dashboard V2
 * 
 * Clean separation of concerns with external CSS and JavaScript
 * 
 * @see assets/css/transaction-dashboard.css
 * @see assets/js/transaction-dashboard.js
 */
?>

<link rel="stylesheet" href="<?php echo base_url('assets/css/transaction-dashboard.css'); ?>">

<div class="dashboard-container d-flex flex-direction-row">
  <div class="card w-100 p-3 pb-5">
    
    <!-- Total Transaction Amount Section -->
    <section>
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="card">
            <div class="card-body px-0">
              <h4>Total Transaction Amount</h4>
              <div class="row report-inner-cards-wrapper">
                
                <!-- YTD Total Amount Card -->
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">YTD Total Amount</span>
                    <h4 id="total-txn-amount"></h4>
                  </div>
                  <div class="inner-card-icon">
                    <i class="icon-rocket"></i>
                  </div>
                </div>
                
                <!-- Daily Total Amount Card -->
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">Daily Total Amount</span>
                    <h4 id="total_txn_amount_today"></h4>
                  </div>
                  <div class="inner-card-icon">
                    <i class="icon-briefcase"></i>
                  </div>
                </div>
                
                <!-- Yesterday Total Amount Card -->
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">Yesterday Total Amount</span>
                    <h4 id="total_txn_amount_yesterday"></h4>
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
    
    <!-- Daily and Monthly Amount Charts Section -->
    <section>
      <div class="card-deck">
        
        <!-- Daily Page Hits Chart -->
        <div class="card" style="border: 1px solid #e0e0e0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">
          <div class="card-body" style="padding: 20px;">
            <div style="font-weight: normal; color: #fff; background-color: #00507A; padding: 8px; border-radius: 5px;">
              <h5>Daily Page Hits</h5>
              <h6>Total Amount (Weekly): <span id="weeklyTotalTxnAmount"></span></h6>
            </div>
            <div id="bar-chart-daily" style="margin-top: 20px;"></div>
          </div>
        </div>
        
        <!-- Monthly Page Hits Chart -->
        <div class="card" style="border: 1px solid #e0e0e0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">
          <div class="card-body" style="padding: 20px;">
            <div style="font-weight: normal; color: #fff; background-color: #00507A; padding: 8px; border-radius: 5px;">
              <h5>Monthly Page Hits</h5>
              <h5>-</h5>
            </div>
            <div id="line-chart-monthly" style="margin-top: 20px;"></div>
          </div>
        </div>
        
      </div>
    </section>
    
    <!-- Total Transaction Count Section -->
    <section>
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="card">
            <div class="card-body px-0">
              <h4>Total Transaction Count (Success, Failed)</h4>
              <div class="row report-inner-cards-wrapper">
                
                <!-- YTD Total Count Card -->
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">YTD Total No. of Transactions</span>
                    <h4 id="totalCount"></h4>
                  </div>
                  <div class="inner-card-icon">
                    <i class="icon-rocket"></i>
                  </div>
                </div>
                
                <!-- Daily Total Count Card -->
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">Daily Total No. of Transactions</span>
                    <h4 id="totalCount_today"></h4>
                  </div>
                  <div class="inner-card-icon">
                    <i class="icon-briefcase"></i>
                  </div>
                </div>
                
                <!-- Yesterday Total Count Card -->
                <div class="col-md-6 col-xl report-inner-card">
                  <div class="inner-card-text">
                    <span class="report-title">Yesterday Total No. of Transactions</span>
                    <h4 id="totalCount_yesterday"></h4>
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
    
    <!-- Daily and Monthly Count Charts Section -->
    <section>
      <div class="card-deck mb-5">
        
        <!-- Daily Count Chart -->
        <div class="card" style="border: 1px solid #e0e0e0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">
          <div class="card-body" style="padding: 20px;">
            <div style="font-weight: normal; color: #fff; background-color: #00507A; padding: 8px; border-radius: 5px;">
              <h5>Daily Page Hits</h5>
              <h5>Total Successful Transactions This Week: <span id="weeklyTotalCount"></span></h5>
            </div>
            <div id="bar-chart-daily-count" style="margin-top: 20px;"></div>
          </div>
        </div>
        
        <!-- Monthly Count Chart -->
        <div class="card" style="border: 1px solid #e0e0e0; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">
          <div class="card-body" style="padding: 20px;">
            <div style="font-weight: normal; color: #fff; background-color: #00507A; padding: 8px; border-radius: 5px;">
              <h5>Monthly Page Hits</h5>
              <h5>-</h5>
            </div>
            <div id="line-chart-monthly-count" style="margin-top: 20px;"></div>
          </div>
        </div>
        
      </div>
    </section>
    
  </div>
</div>

<!-- External Scripts -->
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="<?php echo base_url('assets/js/transaction-dashboard.js'); ?>"></script>
