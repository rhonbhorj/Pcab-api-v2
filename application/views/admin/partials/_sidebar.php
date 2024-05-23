<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav nav-container">
    <!-- <li class="nav-item">
      <a class="nav-link" href="dashboard">
        <span class="menu-title text-capitalize">Dashboard</span>
        <i class="icon-screen-desktop menu-icon"></i>
      </a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" href="dashboard">
        <span class="menu-title text-capitalize">Dashboard</span>
        <i class=" icon-screen-desktop  menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="acknowledgement-receipt">
        <span class="menu-title text-capitalize">Acknowledgements</span>
        <i class="icon-grid  menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="deposit">
        <span class="menu-title text-capitalize">Deposits</span>
        <i class="icon-grid  menu-icon"></i>
      </a>
    </li>

    <?php if ($_SESSION['usertype'] == "SUPERADMIN") 
      echo 
    '<li class="nav-item">
      <a class="nav-link" href="transaction-table">
        <span class="menu-title text-capitalize"> Transactions</span>
        <i class=" icon-list    menu-icon"></i>
      </a>
    </li> '
    
  ?>
  
    
    <!-- <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title text-capitalize">Data Table</span>
        <i class="icon-layers menu-icon"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="acknowledgement-receipt">Ack.
              Receipt</a></li>
          <li class="nav-item"> <a class="nav-link" href="deposit"> Deposit</a></li>
        </ul>
      </div>
    </li> -->
  </ul>
  <div class="footer-powered-by text-center d-flex flex-column align-content-center justify-content-start p-1">
    <span class="mr-1">Powered by:</span>
    <div class="company-row">
      <a href="https://netglobalsolutions.net/" target="_blank">
        <img width="25" height="25" src='<?php echo base_url("assets/images/ngsi-no-label.png") ?>' alt="logo"
          class="logo-dark" />
      </a>
    </div>
  </div>
</nav>