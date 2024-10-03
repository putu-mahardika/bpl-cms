<?php
  session_save_path('../../tmp');

  session_start();

  include "../../config/koneksi.php";
  date_default_timezone_set("Asia/Jakarta");

  $datetime = date('Y');
  $month = date('m');
  // $prevdatetime = $datetime-1;
  $tahun = $_GET['tahun'];
  $prevdatetime = (int)$tahun-1;


  if ($_SESSION['hak_akses'] == "" || $_SESSION['hak_akses'] != "User") {

    header("location:../../index.php?pesan=belum_login");

  }

  $s_id = $_SESSION['id'];

?>

<!DOCTYPE html>

<html lang="en">



<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="description" content="">

  <meta name="author" content="">

  <!--<link href="img/logo/logo.png" rel="icon">-->

  <title>Dashboard - PT Berkah Permata Logistik</title>

  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">

  <link href="../../css/ruang-admin.min.css" rel="stylesheet">

</head>



<body id="page-top">

  <div id="wrapper">

    <!-- Sidebar -->

    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">

      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php?tahun=<?php echo $tahun?>">

        <div class="sidebar-brand-icon">

          <img src="../../img/logo-BPL-white.png" style="height:130px;">

        </div>

        

      </a>

      <hr class="sidebar-divider my-0">

      <li class="nav-item active">

        <a class="nav-link" href="dashboard.php?tahun=<?php echo $tahun?>">

          <i class="fas fa-fw fa-tachometer-alt"></i>

          <span>Dashboard</span></a>

      </li>

      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Master
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
          aria-controls="collapseForm">
          <i class="fas fa-fw fa-database"></i>
          <span>Database</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Customer</h6> -->
            <a class="collapse-item" href="customer.php">List Customer</a>
          </div>
        </div>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Transaksi
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseQuoTrucking" aria-expanded="true"
          aria-controls="collapseQuoTrucking">
          <i class="fas fa-fw fa-table"></i>
          <span>Quotation</span> 
        </a>
        <div id="collapseQuoTrucking" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Quo Trucking</h6>
            <a class="collapse-item" href="quotation/trucking/index.php">List Quo Trucking</a>
            <h6 class="collapse-header">Quo Shipment</h6>
            <a class="collapse-item" href="quotation/shipment/index.php">List Quo Shipment</a>
            <!--<a class="collapse-item" href="datatables.html">DataTables</a>-->
          </div>
        </div>
      </li>
	    <li class="nav-item">
        <a class="nav-link" href="shipment.php?tahun=<?php echo $datetime?>">
          <i class="fas fa-fw fa-ship"></i>
          <span>Shipment</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="transaksi.php?tahun=<?php echo $datetime?>">
          <i class="fas fa-fw fa-truck"></i>
          <span>Pergerakan Truck</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Laporan
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportTruck" aria-expanded="true"
          aria-controls="collapseReportTruck">
          <i class="fas fa-fw fa-table"></i>
          <span>Laporan Trucking</span> 
        </a> 
        <div id="collapseReportTruck" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Laporan Trucking</h6>
            <a class="collapse-item" href="laporanbarang.php">Laporan Detail</a>
            <a class="collapse-item" href="laporanbarangbiaya.php">Laporan Biaya</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="laporanShipment.php">
          <i class="fas fa-fw fa-file-invoice"></i>
          <span>Laporan Shipment</span>
        </a>
      </li>
      <!--<li class="nav-item">
        <a class="nav-link" href="laporanbarang.php">
          <div class="row">
            <div style="padding-left:12px;">
              <i class="fas fa-fw fa-file-invoice"></i>
            </div>
            <div>
              <span>Laporan Pergerakan Truck</span>
            </div>
          </div>
        </a>
      </li>-->

      <!--<li class="nav-item">

        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"

          aria-controls="collapsePage">

          <i class="fas fa-fw fa-columns"></i>

          <span>Pages</span>

        </a>

        <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">

          <div class="bg-white py-2 collapse-inner rounded">

            <h6 class="collapse-header">Example Pages</h6>

            <a class="collapse-item" href="login.html">Login</a>

            <a class="collapse-item" href="register.html">Register</a>

            <a class="collapse-item" href="404.html">404 Page</a>

            <a class="collapse-item" href="blank.html">Blank Page</a>

          </div>

        </div>

      </li>

      <li class="nav-item">

        <a class="nav-link" href="charts.html">

          <i class="fas fa-fw fa-chart-area"></i>

          <span>Charts</span>

        </a>

      </li>-->
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Bantuan
      </div>
      <li class="nav-item">
        <a class="nav-link" href="http://www.berkahpermatalogistik.com/Howto/index.htm" target="_blank">
          <i class="fas fa-fw fa-question"></i>
          <span>Bantuan</span>
        </a>
      </li>

      <hr class="sidebar-divider">

      <!--<div class="version" id="version-ruangadmin"></div>-->

	  <li class="nav-item">

        <a class="nav-link" type="button" data-toggle="modal" data-target="#logoutModal">

          <i class="fas fa-fw fa-sign-out-alt"></i>

          <span>Logout</span>

        </a>

      </li>

    </ul>

    <!-- Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">

      <div id="content">

        <!-- TopBar -->

        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">

          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">

            <i class="fa fa-bars"></i>

          </button>

          <ul class="navbar-nav ml-auto">

            <!--<li class="nav-item dropdown no-arrow">

              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"

                aria-haspopup="true" aria-expanded="false">

                <i class="fas fa-search fa-fw"></i>

              </a>

              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"

                aria-labelledby="searchDropdown">

                <form class="navbar-search">

                  <div class="input-group">

                    <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"

                      aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">

                    <div class="input-group-append">

                      <button class="btn btn-primary" type="button">

                        <i class="fas fa-search fa-sm"></i>

                      </button>

                    </div>

                  </div>

                </form>

              </div>

            </li>-->

            <!--<li class="nav-item dropdown no-arrow mx-1">

              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"

                aria-haspopup="true" aria-expanded="false">

                <i class="fas fa-bell fa-fw"></i>

                <span class="badge badge-danger badge-counter">3+</span>

              </a>

              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"

                aria-labelledby="alertsDropdown">

                <h6 class="dropdown-header">

                  Alerts Center

                </h6>

                <a class="dropdown-item d-flex align-items-center" href="#">

                  <div class="mr-3">

                    <div class="icon-circle bg-primary">

                      <i class="fas fa-file-alt text-white"></i>

                    </div>

                  </div>

                  <div>

                    <div class="small text-gray-500">December 12, 2019</div>

                    <span class="font-weight-bold">A new monthly report is ready to download!</span>

                  </div>

                </a>

                <a class="dropdown-item d-flex align-items-center" href="#">

                  <div class="mr-3">

                    <div class="icon-circle bg-success">

                      <i class="fas fa-donate text-white"></i>

                    </div>

                  </div>

                  <div>

                    <div class="small text-gray-500">December 7, 2019</div>

                    $290.29 has been deposited into your account!

                  </div>

                </a>

                <a class="dropdown-item d-flex align-items-center" href="#">

                  <div class="mr-3">

                    <div class="icon-circle bg-warning">

                      <i class="fas fa-exclamation-triangle text-white"></i>

                    </div>

                  </div>

                  <div>

                    <div class="small text-gray-500">December 2, 2019</div>

                    Spending Alert: We've noticed unusually high spending for your account.

                  </div>

                </a>

                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>

              </div>

            </li>-->

            <!--<li class="nav-item dropdown no-arrow mx-1">

              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"

                aria-haspopup="true" aria-expanded="false">

                <i class="fas fa-envelope fa-fw"></i>

                <span class="badge badge-warning badge-counter">2</span>

              </a>

              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"

                aria-labelledby="messagesDropdown">

                <h6 class="dropdown-header">

                  Message Center

                </h6>

                <a class="dropdown-item d-flex align-items-center" href="#">

                  <div class="dropdown-list-image mr-3">

                    <img class="rounded-circle" src="img/man.png" style="max-width: 60px" alt="">

                    <div class="status-indicator bg-success"></div>

                  </div>

                  <div class="font-weight-bold">

                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been

                      having.</div>

                    <div class="small text-gray-500">Udin Cilok · 58m</div>

                  </div>

                </a>

                <a class="dropdown-item d-flex align-items-center" href="#">

                  <div class="dropdown-list-image mr-3">

                    <img class="rounded-circle" src="img/girl.png" style="max-width: 60px" alt="">

                    <div class="status-indicator bg-default"></div>

                  </div>

                  <div>

                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people

                      say this to all dogs, even if they aren't good...</div>

                    <div class="small text-gray-500">Jaenab · 2w</div>

                  </div>

                </a>

                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>

              </div>

            </li>-->

            <!--<li class="nav-item dropdown no-arrow mx-1">

              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"

                aria-haspopup="true" aria-expanded="false">

                <i class="fas fa-tasks fa-fw"></i>

                <span class="badge badge-success badge-counter">3</span>

              </a>

              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"

                aria-labelledby="messagesDropdown">

                <h6 class="dropdown-header">

                  Task

                </h6>

                <a class="dropdown-item align-items-center" href="#">

                  <div class="mb-3">

                    <div class="small text-gray-500">Design Button

                      <div class="small float-right"><b>50%</b></div>

                    </div>

                    <div class="progress" style="height: 12px;">

                      <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50"

                        aria-valuemin="0" aria-valuemax="100"></div>

                    </div>

                  </div>

                </a>

                <a class="dropdown-item align-items-center" href="#">

                  <div class="mb-3">

                    <div class="small text-gray-500">Make Beautiful Transitions

                      <div class="small float-right"><b>30%</b></div>

                    </div>

                    <div class="progress" style="height: 12px;">

                      <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30"

                        aria-valuemin="0" aria-valuemax="100"></div>

                    </div>

                  </div>

                </a>

                <a class="dropdown-item align-items-center" href="#">

                  <div class="mb-3">

                    <div class="small text-gray-500">Create Pie Chart

                      <div class="small float-right"><b>75%</b></div>

                    </div>

                    <div class="progress" style="height: 12px;">

                      <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75"

                        aria-valuemin="0" aria-valuemax="100"></div>

                    </div>

                  </div>

                </a>

                <a class="dropdown-item text-center small text-gray-500" href="#">View All Taks</a>

              </div>

            </li>-->

            <div class="topbar-divider d-none d-sm-block"></div>

            <li class="nav-item dropdown no-arrow">

              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"

                aria-haspopup="true" aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-white small"><?php echo $_SESSION['nama']?></span>

                <img class="img-profile rounded-circle" src="../../img/boy.png" style="max-width: 60px">

                

              </a>

              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                <!--<a class="dropdown-item" href="#">

                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>

                  Profile

                </a>

                <a class="dropdown-item" href="#">

                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>

                  Settings

                </a>-->

                <a class="dropdown-item" href="editPassword.php">

                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>

                  Ubah Password

                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">

                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>

                  Logout

                </a>

              </div>

            </li>

          </ul>

        </nav>

        <!-- Topbar -->



        <!-- Container Fluid-->

        <div class="container-fluid" id="container-wrapper">

          <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <!--<h5>Tahun : <?php echo $datetime?></h5>-->

            <div>
              <label>Tahun: </label>
              <input type="number" style="width:125px;" id="tahun" value="<?php echo $tahun?>" onchange="tahunUbah()">
              <a id="tahunGo" href="" class="btn btn-primary btn-sm mb-1">GO</a>
            </div>

            <!--<ol class="breadcrumb">

              <li class="breadcrumb-item"><a href="./">Home</a></li>

              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>

            </ol>-->

          </div>



          <?php

          $query_c = mysqli_query($koneksi, "select count(CustId) as jmlCust from master_customer where UserId='".$s_id."' and create_date between '$tahun-01-01 00:00:00' and '$tahun-12-31 23:59:59'");

          $query_t = mysqli_query($koneksi, "select count(HdId) as jmlHd from trans_hd where atr1=0 and UserId='".$s_id."' and create_date between '$tahun-01-01 00:00:00' and '$tahun-12-31 23:59:59'");

          $query_to = mysqli_query($koneksi, "select count(HdId) as Hdopen from trans_hd where OnClose='0' and UserId='".$s_id."' and create_date between '$tahun-01-01 00:00:00' and '$tahun-12-31 23:59:59'");

          $query_tc = mysqli_query($koneksi, "select count(HdId) as Hdclose from trans_hd where OnClose='1' and UserId='".$s_id."' and atr1=0 and DateOnClose between '$tahun-01-01 00:00:00' and '$tahun-12-31 23:59:59'");

          

          $data_c = mysqli_fetch_array($query_c);

          $data_t = mysqli_fetch_array($query_t);

          $data_to = mysqli_fetch_array($query_to);

          $data_tc = mysqli_fetch_array($query_tc);



          if($data_to['Hdopen'] == null){

            $data_to['Hdopen'] = 0;

          }

          if($data_tc['Hdclose'] == null){

            $data_tc['Hdclose'] = 0;

          }

          

          ?>



          <div class="row mb-3">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Customer</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data_c['jmlCust']?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!--<span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                        <span>Since last month</span>-->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Transaksi</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data_t['jmlHd']?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!--<span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                        <span>Since last years</span>-->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-file-invoice fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Transaksi Open</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $data_to['Hdopen']?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!--<span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>
                        <span>Since last month</span>-->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-shipping-fast fa-2x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Transaksi Closed</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data_tc['Hdclose']?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!--<span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                        <span>Since yesterday</span>-->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-people-carry fa-2x text-success"></i>
                    </div>
                  </div>
                  <div class="text-xs">
                    Keterangan : Terhitung dari <strong><?php echo $prevdatetime ?></strong> sampai <strong><?php echo $tahun ?></strong>
                  </div>
                </div>
              </div>
            </div>


            <!-- <div class="col-12">
              <div class="row">
                <div class="col-lg-6 col-md-12 mb-4">
                  <div class="card" style="height: 100%;">
                    <div class="card-body">
                      <p class="font-weight-bold">
                        <?php if ($_SESSION['hak_akses'] == "Admin") {
                          echo 'Accumulate Shipment This Year : ';
                        } else {
                          echo 'Total Shipment This Year : ';
                        } ?>
                        <span id="acumulateShipmentThisYear"></span>
                          / 
                        <span id="shipmentThisYear"></span> Shipment
                      </p>
                      <p class="font-weight-bold">
                        <?php if ($_SESSION['hak_akses'] == "Admin") {
                          echo 'Accumulate Shipment This Month : ';
                        } else {
                          echo 'Total Shipment This Month : ';
                        } ?>
                        <span id="acumulateShipmentThisMonth"></span>
                          / 
                        <span id="shipmentThisMonth"></span> Shipment
                      </p>
                      <div class="text-xs">
                        note : terhitung berdasarkan Shipment dengan Status <strong>Close</strong> dari <strong><?php echo $prevdatetime ?></strong> sampai <strong><?php echo $tahun ?></strong> 
                      </div>
                    </div>
                  </div>
                </div>
  
                <div class="col-lg-6 col-md-12 mb-4">
                  <div class="card" style="height: 100%;">
                    <div class="card-body">
                      <p class="font-weight-bold">
                        <?php if ($_SESSION['hak_akses'] == "Admin") {
                          echo 'Accumulate Sales This Year : ';
                        } else {
                          echo 'Total Sales This Year : ';
                        } ?>
                        <span id="acumulateThisYear"></span>
                          / 
                        <span id="ritThisYear"></span> Rit
                      </p>
                      <p class="font-weight-bold">
                        <?php if ($_SESSION['hak_akses'] == "Admin") {
                          echo 'Accumulate Sales This Month : ';
                        } else {
                          echo 'Total Sales This Month : ';
                        } ?>
                        <span id="acumulateThisMonth"></span>
                          / 
                        <span id="ritThisMonth"></span> Rit
                      </p>
                      <div class="text-xs">
                        note : terhitung berdasarkan Transaksi dengan Status <strong>Close</strong> dari <strong><?php echo $prevdatetime ?></strong> sampai <strong><?php echo $tahun ?></strong> 
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

            <div class="col-12">
              <div class="row">
                <div class="col-lg-6 col-md-12 mb-4">
                  <div class="card" style="height:100%;">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-6 col-md-12 mb-lg-0 mb-4 pl-2 pr-2 pr-lg-3 border-md-0 border-right">
                          <p class="font-weight-bold" style="font-size: 14px;">Accumulate Shipment This Year</p>
                          <p id="acumulateShipmentThisYear" class="text-right text-primary mb-0 font-weight-bold" style="font-size: 22px;"></p>
                          <p class="text-right" style="font-size: 14px;">/ <span id="shipmentThisYear"></span> Shipment</p>
                          <p class="text-xs mb-0"><em>Keterangan : Terhitung berdasarkan Shipment dengan Status <strong>Close</strong> di tahun <strong><?php echo $tahun ?></strong></em></p>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-lg-0 mb-4 pl-2 pl-lg-3 pr-2">
                          <p class="font-weight-bold" style="font-size: 14px;">Accumulate Shipment This Month</p>
                          <p id="acumulateShipmentThisMonth" class="text-right text-primary mb-0 font-weight-bold" style="font-size: 22px;"></p>
                          <p class="text-right" style="font-size: 14px;">/ <span id="shipmentThisMonth"></span> Shipment</p>
                          <!--<p class="text-xs mb-0"><em>Keterangan : Terhitung berdasarkan Shipment dengan Status <strong>Close</strong> pada bulan <strong><?php echo $month.'-'.$tahun ?></strong></em></p>-->
                          <p class="text-xs mb-0"><em>Keterangan : Terhitung berdasarkan Shipment dengan Status <strong>Close</strong> di bulan <strong><?php echo $month.'-'.$tahun ?></strong></em></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-4">
                  <div class="card" style="height:100%;">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-6 col-md-12 mb-lg-0 mb-4 pl-2 pr-2 pr-lg-3 border-right">
                          <p class="font-weight-bold" style="font-size: 14px;">Accumulate Sales This Year</p>
                          <p id="acumulateThisYear" class="text-right text-primary mb-0 font-weight-bold" style="font-size: 22px;"></p>
                          <p class="text-right" style="font-size: 14px;">/ <span id="ritThisYear"></span> Rit</p>
                          <p class="text-xs mb-0"><em>Keterangan : Terhitung berdasarkan <strong>Tgl SPK</strong> dengan Status <strong>Close</strong> di tahun <strong><?php echo $tahun ?></strong></em></p>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-lg-0 mb-4 pl-2 pl-lg-3 pr-2">
                          <p class="font-weight-bold" style="font-size: 14px;">Accumulate Sales This Month</p>
                          <p id="acumulateThisMonth" class="text-right text-primary mb-0 font-weight-bold" style="font-size: 22px;"></p>
                          <p class="text-right" style="font-size: 14px;">/ <span id="ritThisMonth"></span> Rit</p>
                          <p class="text-xs mb-0"><em>Keterangan : Terhitung berdasarkan <strong>tgl SPK</strong> dengan Status <strong>Close</strong> pada bulan <strong><?php echo $month.'-'.$tahun ?></strong></em></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Area Chart -->
            <!-- <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Pergerakan Penjualan</h6>
                </div>
                <div class="card-body pt-0">
                  <div class="chart-area">
                    <canvas id="Chart1"></canvas>
                  </div>
                </div>
              </div>
            </div> -->

            <!-- <div class="col-12">
              <div class="card mb-4">
                <div class="card-body">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="shipmentChart1-tab" data-toggle="tab" href="#shipmentChart1" role="tab" aria-controls="shipmentChart1" aria-selected="true">Shipment</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="truckingChart1-tab" data-toggle="tab" href="#truckingChart1" role="tab" aria-controls="truckingChart1" aria-selected="false">Trucking</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="shipmentChart1" role="tabpanel" aria-labelledby="shipmentChart1-tab">
                    <div class="p-3">
                      <h6 class="m-0 font-weight-bold text-primary">Pergerakan Shipment</h6>
                      <div class="chart-area">
                        <canvas id="ChartShipment1"></canvas>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="truckingChart1" role="tabpanel" aria-labelledby="truckingChart1-tab">
                    <div class="p-3">
                      <h6 class="m-0 font-weight-bold text-primary">Pergerakan Penjualan</h6>
                        <div class="chart-area">
                        <canvas id="Chart1"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div> -->

            <div class="col-12">
              <div class="card mb-4">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary">Pergerakan Transaksi Tiap Bulan</h6>
                </div>
                <div class="card-body pt-0">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="shipmentChart1-tab" data-toggle="tab" href="#shipmentChart1" role="tab" aria-controls="shipmentChart1" aria-selected="true">Shipment</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="truckingChart1-tab" data-toggle="tab" href="#truckingChart1" role="tab" aria-controls="truckingChart1" aria-selected="false">Trucking</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="shipmentChart1" role="tabpanel" aria-labelledby="shipmentChart1-tab">
                    <div class="p-3">
                      <h6 class="m-0 font-weight-bold text-primary">Pergerakan Shipment</h6>
                      <p class="text-xs mb-0"><em>Keterangan : </em></p>
                      <p class="text-xs mb-0"><em>- Terhitung berdasarkan Shipment di tahun <strong><?php echo $tahun ?></strong></em></p>
                      <p class="text-xs mb-0"><em>- Shipment yang ditutup pada tahun yang berbeda dengan tahun pembuatan, akan terhitung sebagai transaksi di tahun pembuatan</em></p>
                      <div class="chart-area">
                        <canvas id="ChartShipment1"></canvas>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="truckingChart1" role="tabpanel" aria-labelledby="truckingChart1-tab">
                    <div class="p-3">
                      <h6 class="m-0 font-weight-bold text-primary">Pergerakan Trucking</h6>
                        <p class="text-xs mb-0"><em>Keterangan : </em></p>
                        <p class="text-xs mb-0"><em>- Terhitung berdasarkan <strong>tgl SPK</strong> di tahun <strong><?php echo $tahun ?></strong></em></p>
                        <p class="text-xs mb-0"><em>- Trucking yang ditutup pada tahun yang berbeda dengan tahun pembuatan, akan terhitung sebagai transaksi di tahun pembuatan</em></p>
                        <div class="chart-area">
                        <canvas id="Chart1"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>

            <!-- <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Pergerakan Total Biaya</h6>
                </div>
                <div class="card-body pt-0">
                  <div class="chart-area">
                    <canvas id="Chart2"></canvas>
                  </div>
                </div>
              </div>
            </div> -->

            <!-- <div class="col-12">
              <div class="card mb-4">
                <div class="card-body">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="shipmentChart2-tab" data-toggle="tab" href="#shipmentChart2" role="tab" aria-controls="shipmentChart2" aria-selected="true">Shipment</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="truckingChart2-tab" data-toggle="tab" href="#truckingChart2" role="tab" aria-controls="truckingChart2" aria-selected="false">Trucking</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="shipmentChart2" role="tabpanel" aria-labelledby="shipmentChart2-tab">
                    <div class="p-3">
                      <h6 class="m-0 font-weight-bold text-primary">Pergerakan Total Biaya Shipment</h6>
                      <div class="chart-area">
                        <canvas id="ChartShipment2"></canvas>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="truckingChart2" role="tabpanel" aria-labelledby="truckingChart2-tab">
                    <div class="p-3">
                      <h6 class="m-0 font-weight-bold text-primary">Pergerakan Total Biaya</h6>
                        <div class="chart-area">
                        <canvas id="Chart2"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div> -->

            <div class="col-12">
              <div class="card mb-4">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary">Pergerakan Total Biaya Transaksi Tiap Bulan</h6>
                </div>
                <div class="card-body pt-0">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="shipmentChart2-tab" data-toggle="tab" href="#shipmentChart2" role="tab" aria-controls="shipmentChart2" aria-selected="true">Shipment</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="truckingChart2-tab" data-toggle="tab" href="#truckingChart2" role="tab" aria-controls="truckingChart2" aria-selected="false">Trucking</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="allChart2-tab" data-toggle="tab" href="#allChart2" role="tab" aria-controls="allChart2" aria-selected="false">All</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="shipmentChart2" role="tabpanel" aria-labelledby="shipmentChart2-tab">
                    <div class="p-3">
                      <h6 class="m-0 font-weight-bold text-primary">Pergerakan Total Biaya Shipment</h6>
                      <p class="text-xs mb-0"><em>Keterangan : </em></p>
                      <p class="text-xs mb-0"><em>- Terhitung berdasarkan Shipment di tahun <strong><?php echo $tahun ?></strong></em></p>
                      <p class="text-xs mb-0"><em>- Shipment yang ditutup pada tahun yang berbeda dengan tahun pembuatan, akan terhitung sebagai transaksi di tahun pembuatan</em></p>
                      <div class="chart-area">
                        <canvas id="ChartShipment2"></canvas>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="truckingChart2" role="tabpanel" aria-labelledby="truckingChart2-tab">
                    <div class="p-3">
                      <h6 class="m-0 font-weight-bold text-primary">Pergerakan Total Biaya Trucking</h6>
                        <p class="text-xs mb-0"><em>Keterangan : </em></p>
                        <p class="text-xs mb-0"><em>- Terhitung berdasarkan <strong>tgl SPK</strong> di tahun <strong><?php echo $tahun ?></strong></em></p>
                        <p class="text-xs mb-0"><em>- Trucking yang ditutup pada tahun yang berbeda dengan tahun pembuatan, akan terhitung sebagai transaksi di tahun pembuatan</strong></em></p>
                        <div class="chart-area">
                        <canvas id="Chart2"></canvas>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="allChart2" role="tabpanel" aria-labelledby="allChart2-tab">
                    <div class="p-3">
                      <h6 class="m-0 font-weight-bold text-primary">
                        Pergerakan Total Biaya Keseluruhan
                        <span data-toggle="tooltip" title="Menampilkan jumlah biaya Shipment dan biaya Trucking tiap bulan"><i class="fa fa-info-circle"></i></span>
                      </h6>
                      <p class="text-xs mb-0"><em>Keterangan :</em></p>
                      <p class="text-xs mb-0"><em>- Biaya Shipment terhitung berdasarkan Shipment di tahun <strong><?php echo $tahun ?></strong></em></p>
                      <p class="text-xs mb-0"><em>- Biaya Trucking terhitung berdasarkan <strong>tgl SPK</strong> di tahun <strong><?php echo $tahun ?></strong></em></p>
                      <p class="text-xs mb-0"><em>- Shipment yang ditutup pada tahun yang berbeda dengan tahun pembuatan, akan terhitung sebagai transaksi di tahun pembuatan</em></p>
                      <p class="text-xs mb-0"><em>- Trucking yang ditutup pada tahun yang berbeda dengan tahun pembuatan, akan terhitung sebagai transaksi di tahun pembuatan</em></p>
                      <div class="chart-area">
                        <canvas id="ChartAll2"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>

            <!--<div class="col-xl-8 col-lg-7">

              <div class="card mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                  <h6 class="m-0 font-weight-bold text-primary">Monthly Recap Report</h6>

                  <div class="dropdown no-arrow">

                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"

                      aria-haspopup="true" aria-expanded="false">

                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>

                    </a>

                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"

                      aria-labelledby="dropdownMenuLink">

                      <div class="dropdown-header">Dropdown Header:</div>

                      <a class="dropdown-item" href="#">Action</a>

                      <a class="dropdown-item" href="#">Another action</a>

                      <div class="dropdown-divider"></div>

                      <a class="dropdown-item" href="#">Something else here</a>

                    </div>

                  </div>

                </div>

                <div class="card-body">

                  <div class="chart-area">

                    <canvas id="myAreaChart"></canvas>

                  </div>

                </div>

              </div>

            </div>-->

            <!-- Pie Chart -->

            <!--<div class="col-xl-4 col-lg-5">

              <div class="card mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                  <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>

                  <div class="dropdown no-arrow">

                    <a class="dropdown-toggle btn btn-primary btn-sm" href="#" role="button" id="dropdownMenuLink"

                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                      Month <i class="fas fa-chevron-down"></i>

                    </a>

                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"

                      aria-labelledby="dropdownMenuLink">

                      <div class="dropdown-header">Select Periode</div>

                      <a class="dropdown-item" href="#">Today</a>

                      <a class="dropdown-item" href="#">Week</a>

                      <a class="dropdown-item active" href="#">Month</a>

                      <a class="dropdown-item" href="#">This Year</a>

                    </div>

                  </div>

                </div>

                <div class="card-body">

                  <div class="mb-3">

                    <div class="small text-gray-500">Oblong T-Shirt

                      <div class="small float-right"><b>600 of 800 Items</b></div>

                    </div>

                    <div class="progress" style="height: 12px;">

                      <div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="80"

                        aria-valuemin="0" aria-valuemax="100"></div>

                    </div>

                  </div>

                  <div class="mb-3">

                    <div class="small text-gray-500">Gundam 90'Editions

                      <div class="small float-right"><b>500 of 800 Items</b></div>

                    </div>

                    <div class="progress" style="height: 12px;">

                      <div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="70"

                        aria-valuemin="0" aria-valuemax="100"></div>

                    </div>

                  </div>

                  <div class="mb-3">

                    <div class="small text-gray-500">Rounded Hat

                      <div class="small float-right"><b>455 of 800 Items</b></div>

                    </div>

                    <div class="progress" style="height: 12px;">

                      <div class="progress-bar bg-danger" role="progressbar" style="width: 55%" aria-valuenow="55"

                        aria-valuemin="0" aria-valuemax="100"></div>

                    </div>

                  </div>

                  <div class="mb-3">

                    <div class="small text-gray-500">Indomie Goreng

                      <div class="small float-right"><b>400 of 800 Items</b></div>

                    </div>

                    <div class="progress" style="height: 12px;">

                      <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"

                        aria-valuemin="0" aria-valuemax="100"></div>

                    </div>

                  </div>

                  <div class="mb-3">

                    <div class="small text-gray-500">Remote Control Car Racing

                      <div class="small float-right"><b>200 of 800 Items</b></div>

                    </div>

                    <div class="progress" style="height: 12px;">

                      <div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30"

                        aria-valuemin="0" aria-valuemax="100"></div>

                    </div>

                  </div>

                </div>

                <div class="card-footer text-center">

                  <a class="m-0 small text-primary card-link" href="#">View More <i

                      class="fas fa-chevron-right"></i></a>

                </div>

              </div>

            </div>-->

            <!-- Invoice Example -->

            <!--<div class="col-xl-8 col-lg-7 mb-4">

              <div class="card">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                  <h6 class="m-0 font-weight-bold text-primary">Invoice</h6>

                  <a class="m-0 float-right btn btn-danger btn-sm" href="#">View More <i

                      class="fas fa-chevron-right"></i></a>

                </div>

                <div class="table-responsive">

                  <table class="table align-items-center table-flush">

                    <thead class="thead-light">

                      <tr>

                        <th>Order ID</th>

                        <th>Customer</th>

                        <th>Item</th>

                        <th>Status</th>

                        <th>Action</th>

                      </tr>

                    </thead>

                    <tbody>

                      <tr>

                        <td><a href="#">RA0449</a></td>

                        <td>Udin Wayang</td>

                        <td>Nasi Padang</td>

                        <td><span class="badge badge-success">Delivered</span></td>

                        <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>

                      </tr>

                      <tr>

                        <td><a href="#">RA5324</a></td>

                        <td>Jaenab Bajigur</td>

                        <td>Gundam 90' Edition</td>

                        <td><span class="badge badge-warning">Shipping</span></td>

                        <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>

                      </tr>

                      <tr>

                        <td><a href="#">RA8568</a></td>

                        <td>Rivat Mahesa</td>

                        <td>Oblong T-Shirt</td>

                        <td><span class="badge badge-danger">Pending</span></td>

                        <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>

                      </tr>

                      <tr>

                        <td><a href="#">RA1453</a></td>

                        <td>Indri Junanda</td>

                        <td>Hat Rounded</td>

                        <td><span class="badge badge-info">Processing</span></td>

                        <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>

                      </tr>

                      <tr>

                        <td><a href="#">RA1998</a></td>

                        <td>Udin Cilok</td>

                        <td>Baby Powder</td>

                        <td><span class="badge badge-success">Delivered</span></td>

                        <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>

                      </tr>

                    </tbody>

                  </table>

                </div>

                <div class="card-footer"></div>

              </div>

            </div>-->

            <!-- Message From Customer-->

            <!--<div class="col-xl-4 col-lg-5 ">

              <div class="card">

                <div class="card-header py-4 bg-primary d-flex flex-row align-items-center justify-content-between">

                  <h6 class="m-0 font-weight-bold text-light">Message From Customer</h6>

                </div>

                <div>

                  <div class="customer-message align-items-center">

                    <a class="font-weight-bold" href="#">

                      <div class="text-truncate message-title">Hi there! I am wondering if you can help me with a

                        problem I've been having.</div>

                      <div class="small text-gray-500 message-time font-weight-bold">Udin Cilok · 58m</div>

                    </a>

                  </div>

                  <div class="customer-message align-items-center">

                    <a href="#">

                      <div class="text-truncate message-title">But I must explain to you how all this mistaken idea

                      </div>

                      <div class="small text-gray-500 message-time">Nana Haminah · 58m</div>

                    </a>

                  </div>

                  <div class="customer-message align-items-center">

                    <a class="font-weight-bold" href="#">

                      <div class="text-truncate message-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit

                      </div>

                      <div class="small text-gray-500 message-time font-weight-bold">Jajang Cincau · 25m</div>

                    </a>

                  </div>

                  <div class="customer-message align-items-center">

                    <a class="font-weight-bold" href="#">

                      <div class="text-truncate message-title">At vero eos et accusamus et iusto odio dignissimos

                        ducimus qui blanditiis

                      </div>

                      <div class="small text-gray-500 message-time font-weight-bold">Udin Wayang · 54m</div>

                    </a>

                  </div>

                  <div class="card-footer text-center">

                    <a class="m-0 small text-primary card-link" href="#">View More <i

                        class="fas fa-chevron-right"></i></a>

                  </div>

                </div>

              </div>

            </div>

          </div>-->

          <!--Row-->



          <!--<div class="row">

            <div class="col-lg-12 text-center">

              <p>Do you like this template ? you can download from <a href="https://github.com/indrijunanda/RuangAdmin"

                  class="btn btn-primary btn-sm" target="_blank"><i class="fab fa-fw fa-github"></i>&nbsp;GitHub</a></p>

            </div>

          </div>-->



          <!-- Modal Logout -->

          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Logout</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Apakah Anda yakin ingin logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                  <a href="../../config/logout.php" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>



        </div>

        <!---Container Fluid-->

      </div>

      <!-- Footer -->
      <footer class="sticky-footer bg-white" style="padding:10px 0 10px 0;">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>&copy; <script> document.write(new Date().getFullYear()); </script>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->

    </div>

  </div>



  <!-- Scroll to top -->

  <a class="scroll-to-top rounded" href="#page-top">

    <i class="fas fa-angle-up"></i>

  </a>



  <script src="../../vendor/jquery/jquery.min.js"></script>

  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

  <script src="../../js/ruang-admin.min.js"></script>

  <script src="../../vendor/chart.js/Chart.min.js"></script>

  <script src="../../js/demo/chart-area-demo.js"></script>  

  <script>
    function tahunUbah(){
      var tahun = document.getElementById("tahun").value;
      $('#tahunGo').attr("href", "dashboard.php?tahun="+tahun);
    }
  </script>

  <script>
    var dataChart1 = [];
    var openChart1 = [];
    var closeChart1 = [];
    var labelChart1 = [];

    // get data chart 1
    $.ajax({
      url: '../../config/dashboardController.php',
      type: 'get',
      data: {
        getDataChart1: true,
        tahun: <?php echo $tahun ?>
      },
      dataType: 'json',
      success: function(response){
        // console.log('res', response[0].length);
        dataChart1 = response;
        for(let i=0;i<dataChart1[0].length;i++) {
          openChart1.push(Number(dataChart1[0][i]))
        }
        for(let i=0;i<dataChart1[1].length;i++) {
          closeChart1.push(Number(dataChart1[1][i]))
        }
        for(let i=0;i<dataChart1[2].length;i++) {
          labelChart1.push((dataChart1[2][i]))
        }
        // console.log('open', labelChart1);

        // Chart 1
        var ctx = document.getElementById("Chart1");
        var myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: labelChart1,
            datasets: [
              {
                label: "Rit Open",
                lineTension: 0.3,
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: openChart1,
                fill: false,
                backgroundColor: "rgba(78, 115, 223, 1)",
              },
              {
                label: "Rit Close",
                lineTension: 0.3,
                borderColor: "rgba(255, 51, 51, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(255, 51, 51, 1)",
                pointBorderColor: "rgba(255, 51, 51, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(255, 51, 51, 1)",
                pointHoverBorderColor: "rgba(255, 51, 51, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: closeChart1,
                fill: false,
                backgroundColor: "rgba(255, 51, 51, 1)",
              }
            ],
          },
          options: {
            tooltips: {
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': ' + new Intl.NumberFormat('id-ID').format(tooltipItem.yLabel);
                }
              }
            },
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
              }
            },
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                ticks: {
                  // maxTicksLimit: 7
                }
              }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  // stepSize: 1,
                  suggestedMax: 5,
                  callback: function(value, index, values) {
                    return new Intl.NumberFormat('id-ID').format(value)
                  }
                }
              }],
            },
            legend: {
              display: true,
              labels: {
                  boxWidth: 20,
                  boxHeight: 2,
              },
            },
          }
        });
      }
    });
  </script>



  <script>
    var dataChart2 = [];
    var openChart2 = [];
    var closeChart2 = [];
    var labelChart2 = [];

    // get data chart 2
    $.ajax({
      url: '../../config/dashboardController.php',
      type: 'get',
      data: {
        getDataChart2: true,
        tahun: <?php echo $tahun ?>
      },
      dataType: 'json',
      success: function(response){
        // console.log('res', response);
        dataChart2 = response;
        for(let i=0;i<dataChart2[0].length;i++) {
          openChart2.push(Number(dataChart2[0][i]))
        }
        for(let i=0;i<dataChart2[1].length;i++) {
          closeChart2.push(Number(dataChart2[1][i]))
        }
        for(let i=0;i<dataChart2[2].length;i++) {
          labelChart2.push((dataChart2[2][i]))
        }
        // console.log('open', labelChart2);

        // Chart 2
        var ctx1 = document.getElementById("Chart2");
        var myLineChart = new Chart(ctx1, {
          type: 'line',
          data: {
            labels: labelChart2,
            datasets: [
              {
                label: "Transaksi Open",
                lineTension: 0.3,
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: openChart2,
                fill: false,
                backgroundColor: "rgba(78, 115, 223, 1)",
              },
              {
                label: "Transaksi Close",
                lineTension: 0.3,
                borderColor: "rgba(255, 51, 51, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(255, 51, 51, 1)",
                pointBorderColor: "rgba(255, 51, 51, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(255, 51, 51, 1)",
                pointHoverBorderColor: "rgba(255, 51, 51, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: closeChart2,
                fill: false,
                backgroundColor: "rgba(255, 51, 51, 1)",
              }
            ],
          },
          options: {
            tooltips: {
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp ' + new Intl.NumberFormat('id-ID').format(tooltipItem.yLabel);
                }
              }
            },
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
              }
            },
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                ticks: {
                  // maxTicksLimit: 7
                }
              }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  // stepSize: 1,
                  suggestedMax: 1000,
                  callback: function(value, index, values) {
                    return 'Rp '+new Intl.NumberFormat('id-ID').format(value)
                  }
                }
              }],
            },
            legend: {
              display: true,
              labels: {
                  boxWidth: 20,
                  boxHeight: 2,
              },
            },
          }
        });
      },
      error: function(response) {
        console.log('err', response);
      }
    });
  </script>

<script>
    $acumulateThisYear = document.getElementById('acumulateThisYear');
    $ritThisYear = document.getElementById('ritThisYear');
    $acumulateThisMonth = document.getElementById('acumulateThisMonth');
    $ritThisMonth = document.getElementById('ritThisMonth');
    $.ajax({
      url: '../../config/dashboardController.php',
      type: 'get',
      data: {
        getAccumulateData: true,
        tahun: <?php echo $tahun ?>
      },
      dataType: 'json',
      success: function(response){
        // console.log(response);
        $acumulateThisYear.innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(response[0]['Total'])
        $ritThisYear.innerHTML = new Intl.NumberFormat('id-ID').format(response[0]['totalDetail'])
        $acumulateThisMonth.innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(response[1]['Total'])
        $ritThisMonth.innerHTML = new Intl.NumberFormat('id-ID').format(response[1]['totalDetail'])
      }
    })
  </script>

  <script>
    $acumulateShipmentThisYear = document.getElementById('acumulateShipmentThisYear');
    $shipmentThisYear = document.getElementById('shipmentThisYear');
    $acumulateShipmentThisMonth = document.getElementById('acumulateShipmentThisMonth');
    $shipmentThisMonth = document.getElementById('shipmentThisMonth');
    $.ajax({
      url: '../../config/dashboardController.php',
      type: 'get',
      data: {
        getAccumulateShipmentData: true,
        tahun: <?php echo $tahun ?>
      },
      dataType: 'json',
      success: function(response){
        // console.log(response);
        $acumulateShipmentThisYear.innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(response[0][0])
        $shipmentThisYear.innerHTML = new Intl.NumberFormat('id-ID').format(response[0][1])
        $acumulateShipmentThisMonth.innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(response[1][0])
        $shipmentThisMonth.innerHTML = new Intl.NumberFormat('id-ID').format(response[1][1])
      }
    })
  </script>

  <script>
    var dataChartShipment1 = [];
    var openChartShipment1 = [];
    var closeChartShipment1 = [];
    var labelChartShipment1 = [];

    // get data chart shipment 1
    $.ajax({
      url: '../../config/dashboardController.php',
      type: 'get',
      data: {
        getShipmentDataChart1: true,
        tahun: <?php echo $tahun ?>
      },
      dataType: 'json',
      success: function(response){
        // console.log('res', response);
        dataChartShipment1 = response;
        for(let i=0;i<dataChartShipment1[0].length;i++) {
          openChartShipment1.push(Number(dataChartShipment1[0][i]))
        }
        for(let i=0;i<dataChartShipment1[1].length;i++) {
          closeChartShipment1.push(Number(dataChartShipment1[1][i]))
        }
        for(let i=0;i<dataChartShipment1[2].length;i++) {
          labelChartShipment1.push((dataChartShipment1[2][i]))
        }
        // console.log('open', labelChartShipment1);

        // Chart 1
        var ctx = document.getElementById("ChartShipment1");
        var myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: labelChartShipment1,
            datasets: [
              {
                label: "Shipment Open",
                lineTension: 0.3,
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: openChartShipment1,
                fill: false,
                backgroundColor: "rgba(78, 115, 223, 1)",
              },
              {
                label: "Shipment Close",
                lineTension: 0.3,
                borderColor: "rgba(255, 51, 51, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(255, 51, 51, 1)",
                pointBorderColor: "rgba(255, 51, 51, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(255, 51, 51, 1)",
                pointHoverBorderColor: "rgba(255, 51, 51, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: closeChartShipment1,
                fill: false,
                backgroundColor: "rgba(255, 51, 51, 1)",
              }
            ],
          },
          options: {
            tooltips: {
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': ' + new Intl.NumberFormat('id-ID').format(tooltipItem.yLabel);
                }
              }
            },
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
              }
            },
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                ticks: {
                  // maxTicksLimit: 7
                }
              }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  // stepSize: 1,
                  suggestedMax: 5,
                  callback: function(value, index, values) {
                    return new Intl.NumberFormat('id-ID').format(value)
                  }
                },
              }],
            },
            legend: {
              display: true,
              labels: {
                  boxWidth: 20,
                  boxHeight: 2,
              },
            },
          }
        });
      }
    });
  </script>

  <script>
    var dataChartShipment2 = [];
    var openChartShipment2 = [];
    var closeChartShipment2 = [];
    var labelChartShipment2 = [];

    // get data chart shipment 2
    $.ajax({
      url: '../../config/dashboardController.php',
      type: 'get',
      data: {
        getShipmentDataChart2: true,
        tahun: <?php echo $tahun ?>
      },
      dataType: 'json',
      success: function(response){
        // console.log('res', response);
        dataChartShipment2 = response;
        for(let i=0;i<dataChartShipment2[0].length;i++) {
          openChartShipment2.push(Number(dataChartShipment2[0][i]))
        }
        for(let i=0;i<dataChartShipment2[1].length;i++) {
          closeChartShipment2.push(Number(dataChartShipment2[1][i]))
        }
        for(let i=0;i<dataChartShipment2[2].length;i++) {
          labelChartShipment2.push((dataChartShipment2[2][i]))
        }
        // console.log('open', labelChartShipment2);

        // Chart 2
        var ctx1 = document.getElementById("ChartShipment2");
        var myLineChart = new Chart(ctx1, {
          type: 'line',
          data: {
            labels: labelChartShipment2,
            datasets: [
              {
                label: "Shipment Open",
                lineTension: 0.3,
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: openChartShipment2,
                fill: false,
                backgroundColor: "rgba(78, 115, 223, 1)",
              },
              {
                label: "Shipment Close",
                lineTension: 0.3,
                borderColor: "rgba(255, 51, 51, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(255, 51, 51, 1)",
                pointBorderColor: "rgba(255, 51, 51, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(255, 51, 51, 1)",
                pointHoverBorderColor: "rgba(255, 51, 51, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: closeChartShipment2,
                fill: false,
                backgroundColor: "rgba(255, 51, 51, 1)",
              }
            ],
          },
          options: {
            tooltips: {
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp ' + new Intl.NumberFormat('id-ID').format(tooltipItem.yLabel);
                }
              }
            },
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
              }
            },
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                ticks: {
                  // maxTicksLimit: 7
                }
              }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  // stepSize: 1,
                  suggestedMax: 5,
                  callback: function(value, index, values) {
                    return 'Rp '+new Intl.NumberFormat('id-ID').format(value)
                  }
                },
              }],
            },
            legend: {
              display: true,
              labels: {
                  boxWidth: 20,
                  boxHeight: 2,
              },
            },
          }
        });
      },
      error: function(response) {
        console.log('err', response);
      }
    });
  </script>

  <script>
    var dataChartAll2 = [];
    var openChartAll2 = [];
    var closeChartAll2 = [];
    var labelChartAll2 = [];

    // get data chart All 2
    $.ajax({
      url: '../../config/dashboardController.php',
      type: 'get',
      data: {
        getAllDataChart2: true,
        tahun: <?php echo $tahun ?>
      },
      dataType: 'json',
      success: function(response){
        // console.log('res', response);
        dataChartAll2 = response;
        for(let i=0;i<dataChartAll2[0].length;i++) {
          openChartAll2.push(Number(dataChartAll2[0][i]))
        }
        for(let i=0;i<dataChartAll2[1].length;i++) {
          closeChartAll2.push(Number(dataChartAll2[1][i]))
        }
        for(let i=0;i<dataChartAll2[2].length;i++) {
          labelChartAll2.push((dataChartAll2[2][i]))
        }
        // console.log('open', labelChartShipment2);

        // Chart 2
        var ctx1 = document.getElementById("ChartAll2");
        var myLineChart = new Chart(ctx1, {
          type: 'line',
          data: {
            labels: labelChartAll2,
            datasets: [
              {
                label: "Open",
                lineTension: 0.3,
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: openChartAll2,
                fill: false,
                backgroundColor: "rgba(78, 115, 223, 1)",
              },
              {
                label: "Close",
                lineTension: 0.3,
                borderColor: "rgba(255, 51, 51, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(255, 51, 51, 1)",
                pointBorderColor: "rgba(255, 51, 51, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(255, 51, 51, 1)",
                pointHoverBorderColor: "rgba(255, 51, 51, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: closeChartAll2,
                fill: false,
                backgroundColor: "rgba(255, 51, 51, 1)",
              }
            ],
          },
          options: {
            tooltips: {
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp ' + new Intl.NumberFormat('id-ID').format(tooltipItem.yLabel);
                }
              }
            },
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
              }
            },
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                ticks: {
                  // maxTicksLimit: 7
                }
              }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  // stepSize: 1,
                  suggestedMax: 5,
                  callback: function(value, index, values) {
                    return 'Rp '+new Intl.NumberFormat('id-ID').format(value)
                  }
                },
              }],
            },
            legend: {
              display: true,
              labels: {
                  boxWidth: 20,
                  boxHeight: 2,
              },
            },
          }
        });
      },
      error: function(response) {
        console.log('err', response);
      }
    });
  </script>

  <!-- <script>
    var dataChartShipment3 = [];
    var openChartShipment3 = [];
    var closeChartShipment3 = [];
    var labelChartShipment3 = [];

    // get data chart 3
    $.ajax({
      url: '../../config/dashboardController.php',
      type: 'get',
      data: {
        getShipmentDataChart3: true,
        tahun: <?php echo $tahun ?>
      },
      dataType: 'json',
      success: function(response){
        console.log('res', response);
        dataChartShipment3 = response;
        for(let i=0;i<dataChartShipment3[0].length;i++) {
          openChartShipment3.push(Number(dataChartShipment3[0][i]))
        }
        for(let i=0;i<dataChartShipment3[1].length;i++) {
          closeChartShipment3.push(Number(dataChartShipment3[1][i]))
        }
        for(let i=0;i<dataChartShipment3[2].length;i++) {
          labelChartShipment3.push((dataChartShipment3[2][i]))
        }
        console.log('open', labelChartShipment3);

        // Chart 3
        var ctx2 = document.getElementById("ChartShipment3");
        var myLineChart = new Chart(ctx2, {
          type: 'bar',
          data: {
            labels: labelChartShipment3,
            datasets: [
              {
                label: "Transaksi Open",
                borderColor: "rgba(78, 115, 223, 1)",
                backgroundColor: "rgba(78, 115, 223, 1)",
                data: openChartShipment3,
              },
              {
                label: "Transaksi Close",
                borderColor: "rgba(255, 51, 51, 1)",
                backgroundColor: "rgba(255, 51, 51, 1)",
                data: closeChartShipment3,
              }
            ],
          },
          options: {
            tooltips: {
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp ' + new Intl.NumberFormat('id-ID').format(tooltipItem.yLabel);
                }
              }
            },
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
              }
            },
            scaleShowValues: true,
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                ticks: {
                  // maxTicksLimit: 7,
                  // autoSkip: false
                }
              }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  // stepSize: 1,
                  suggestedMax: 5,
                  callback: function(value, index, values) {
                    return 'Rp '+new Intl.NumberFormat('id-ID').format(value)
                  }
                },
              }],
            },
            legend: {
              display: true,
              labels: {
                  boxWidth: 20,
                  boxHeight: 2,
              },
            },
          }
        });
      },
      error: function(response) {
        console.log('err', response);
      }
    });
  </script> -->

</body>
 


</html>