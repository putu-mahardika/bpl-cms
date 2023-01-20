<?php

  session_save_path('../../tmp');

  session_start();
  // echo session_id();

  include "../../config/koneksi.php";

  // print_r($_SESSION);

  if ($_SESSION['hak_akses'] == "" || $_SESSION['hak_akses'] != "Admin") {

    header("location:../../index.php?pesan=belum_login");

  }
  date_default_timezone_set("Asia/Jakarta");
  $datetime = date('Y');
  $prevdatetime = $datetime-1;
  $tahun = $_GET['tahun'];
  
	

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
  <!-- <link href="../../vendor/datatables1/datatables.min.css" rel="stylesheet"> -->
  <!-- DevExtreme theme -->
  <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.1.6/css/dx.light.css">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard-admin.php?tahun=<?php echo $datetime?>">
        <div class="sidebar-brand-icon">
          <img src="../../img/logo-BPL-white-min.png" style="height:130px;">
        </div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="dashboard-admin.php?tahun=<?php echo $datetime?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Master
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
          aria-expanded="true" aria-controls="collapseBootstrap">
          <i class="fas fa-fw fa-table"></i>
          <span>Akun</span>
        </a>
        <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Akun</h6>
            <a class="collapse-item" href="user.php">User Pengguna</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
          aria-controls="collapseForm">
          <i class="fas fa-fw fa-table"></i>
          <span>Customer</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Customer</h6>
            <a class="collapse-item" href="customer.php">List Customer</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true"
          aria-controls="collapseTable">
          <i class="fas fa-fw fa-table"></i>
          <span>Status</span>
        </a>
        <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Status</h6>
            <a class="collapse-item" href="status.php">Status Trucking</a>
            <a class="collapse-item" href="status.php">Status Shipment</a>
            <!--<a class="collapse-item" href="datatables.html">DataTables</a>-->
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKota" aria-expanded="true"
          aria-controls="collapseKota">
          <i class="fas fa-fw fa-table"></i>
          <span>Kota</span> 
        </a>
        <div id="collapseKota" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Kota</h6>
            <a class="collapse-item" href="kota.php">List Kota</a>
            <!--<a class="collapse-item" href="datatables.html">DataTables</a>-->
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLoadType" aria-expanded="true"
          aria-controls="collapseLoadType">
          <i class="fas fa-fw fa-table"></i>
          <span>Load Type</span> 
        </a> 
        <div id="collapseLoadType" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Load Type</h6>
            <a class="collapse-item" href="loadType.php">List Load Type</a>
            <!--<a class="collapse-item" href="datatables.html">DataTables</a>-->
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseShipmentTerms" aria-expanded="true"
          aria-controls="collapseShipmentTerms">
          <i class="fas fa-fw fa-table"></i>
          <span>Shipment Terms</span> 
        </a> 
        <div id="collapseShipmentTerms" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Shipment Terms</h6>
            <a class="collapse-item" href="shipmentTerms.php">List Shipment Terms</a>
            <!--<a class="collapse-item" href="datatables.html">DataTables</a>-->
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUnit" aria-expanded="true"
          aria-controls="collapseUnit">
          <i class="fas fa-fw fa-table"></i>
          <span>Unit</span> 
        </a> 
        <div id="collapseUnit" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Unit</h6>
            <a class="collapse-item" href="unit.php">List Unit</a>
            <!--<a class="collapse-item" href="datatables.html">DataTables</a>-->
          </div>
        </div>
      </li>

      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Transaksi
      </div>

	    <li class="nav-item">
        <a class="nav-link" href="transaksi.php?tahun=<?php echo $datetime?>">
          <i class="fas fa-fw fa-truck"></i>
          <span>Pergerakan Truck</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="laporanbarang.php">
          <i class="fas fa-fw fa-file-invoice"></i>
          <span>Laporan Detail</span>
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
            $query_c = mysqli_query($koneksi, "select count(CustId) as jmlCust from master_customer where create_date between '$tahun-01-01 00:00:00' and '$tahun-12-31 23:59:59'");
            $query_t = mysqli_query($koneksi, "select count(HdId) as jmlHd from trans_hd where atr1=0 and create_date between '$tahun-01-01 00:00:00' and '$tahun-12-31 23:59:59'");
            $query_to = mysqli_query($koneksi, "select count(HdId) as Hdopen from trans_hd where OnClose='0' and create_date between '$tahun-01-01 00:00:00' and '$tahun-12-31 23:59:59'");
            $query_tc = mysqli_query($koneksi, "select count(HdId) as Hdclose from trans_hd where OnClose='1' and atr1='0' and DateOnClose between '$tahun-01-01 00:00:00' and '$tahun-12-31 23:59:59'");
        
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
                    note : terhitung dari <strong><?php echo $prevdatetime ?></strong> sampai <strong><?php echo $datetime ?></strong>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12 mb-4">
              <div class="card">
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
                    note : terhitung berdasarkan Transaksi dengan Status <strong>Close</strong> dari <strong><?php echo $prevdatetime ?></strong> sampai <strong><?php echo $datetime ?></strong> 
                  </div>
                </div>
              </div>
            </div>

            <!-- Area Chart -->

            <div class="col-lg-12">
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
            </div>

            <div class="col-lg-12">
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
            </div>

            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Pergerakan Total Biaya Transaksi Setiap Sales</h6>
                </div>
                <div class="card-body pt-0">
                  <div class="chart-area">
                    <canvas id="Chart3"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12 mb-4">
              <div class="card">
                <div class="card-header pt-3 pb-0">
                  <h6 class="m-0 font-weight-bold text-primary">Yearly Sales Users</h6>
                  <div class="text-xs">
                    note : terhitung berdasarkan Transaksi dengan Status <strong>Close</strong> dari <strong><?php echo $prevdatetime ?></strong> sampai <strong><?php echo $datetime ?></strong>
                  </div>
                </div>
                <div class="card-body">
                  <div id="userSummaryTable"></div>
                </div>
              </div>
            </div>
            

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
          <!--Row-->



          <!--<div class="row">

            <div class="col-lg-12 text-center">

              <p>Do you like this template ? you can download from <a href="https://github.com/indrijunanda/RuangAdmin"

                  class="btn btn-primary btn-sm" target="_blank"><i class="fab fa-fw fa-github"></i>&nbsp;GitHub</a></p>

            </div>

          </div>-->



          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
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
            <span>&copy; <script> document.write(new Date().getFullYear()); </script> - Supported by
              <img src="../../img/logo-group.png" style="height:45px;">
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
  <script src="../../vendor/datatables1/jquery.dataTables.min.js"></script>
  <!-- <script src="../../vendor/datatables1/datatables.min.js"></script> -->
  <!-- <script src="../../js/demo/chart-area-demo.js"></script>   -->
  <!-- DevExtreme library -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.12.1/polyfill.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/3.8.0/exceljs.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/globalize/1.1.1/globalize.min.js"></script> -->
  <!-- <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/globalize/0.1.1/globalize.min.js"></script> -->
  <script src="https://cdn3.devexpress.com/jslib/22.2.3/js/dx.all.js"></script>

  <script>
    function tahunUbah(){
      var tahun = document.getElementById("tahun").value;
      $('#tahunGo').attr("href", "dashboard-admin.php?tahun="+tahun);
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
        console.log('res', response);
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
        console.log('open', labelChart1);

        // Chart 1
        var ctx = document.getElementById("Chart1");
        var myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: labelChart1,
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
                data: openChart1,
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
        console.log('res', response);
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
        console.log('open', labelChart2);

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
    var dataChart3 = [];
    var openChart3 = [];
    var closeChart3 = [];
    var labelChart3 = [];

    // get data chart 3
    $.ajax({
      url: '../../config/dashboardController.php',
      type: 'get',
      data: {
        getDataChart3: true,
        tahun: <?php echo $tahun ?>
      },
      dataType: 'json',
      success: function(response){
        console.log('res', response);
        dataChart3 = response;
        for(let i=0;i<dataChart3[0].length;i++) {
          openChart3.push(Number(dataChart3[0][i]))
        }
        for(let i=0;i<dataChart3[1].length;i++) {
          closeChart3.push(Number(dataChart3[1][i]))
        }
        for(let i=0;i<dataChart3[2].length;i++) {
          labelChart3.push((dataChart3[2][i]))
        }
        console.log('open', labelChart3);

        // Chart 3
        var ctx2 = document.getElementById("Chart3");
        var myLineChart = new Chart(ctx2, {
          type: 'bar',
          data: {
            labels: labelChart3,
            datasets: [
              {
                label: "Transaksi Open",
                borderColor: "rgba(78, 115, 223, 1)",
                backgroundColor: "rgba(78, 115, 223, 1)",
                data: openChart3,
              },
              {
                label: "Transaksi Close",
                borderColor: "rgba(255, 51, 51, 1)",
                backgroundColor: "rgba(255, 51, 51, 1)",
                data: closeChart3,
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
        console.log(response);
        $acumulateThisYear.innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(response[0]['Total'])
        $ritThisYear.innerHTML = new Intl.NumberFormat('id-ID').format(response[0]['totalDetail'])
        $acumulateThisMonth.innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(response[1]['Total'])
        $ritThisMonth.innerHTML = new Intl.NumberFormat('id-ID').format(response[1]['totalDetail'])
      }
    })
  </script>
  <script>
    let dataGrid = null;
    let dataSourceTemp = null;
    $.ajax({
      url: '../../config/dashboardController.php',
      type: 'get',
      data: {
        getSalesSummary: true,
        tahun: <?php echo $tahun ?>
      },
      dataType: 'json',
      success: function(response){
        console.log('anu', response);
        dataSourceTemp = response;
      }
    })
  </script>

<script>
  $(document).ready(() => {
    // console.log('aaa');
      // Globalize.culture().numberFormat.currency.symbol = "Rp";
      // Globalize.culture().numberFormat.currency[','] = ".";
      // Globalize.culture().numberFormat.currency['.'] = ",";
      var borderStylePattern = { style: 'thin', color: { argb: 'FF7E7E7E' } };
      dataGrid = $('#userSummaryTable').dxDataGrid({
        // dataSource: generateData(100000),
        dataSource: "../../config/dashboardController.php?getSalesSummary=true&tahun=<?php echo $tahun ?>",
        // keyExpr: 'id',
        // allowColumnReordering: true,
        allowColumnResizing: true,
        columnAutoWidth: true,
        selection: {
          mode: 'single',
        },
        showBorders: true,
        showRowLines: true,
        groupPanel: {
          visible: false,
        },
        filterRow: {
          visible: false,
          applyFilter: 'auto',
        },
        searchPanel: {
          visible: false,
          width: 240,
          placeholder: 'Search...',
        },
        headerFilter: {
          visible: false,
        },
        columnChooser: {
          enabled: false,
          mode: 'select',
        },
        columnAutoWidth: true,
        columns: [
          {
            caption: 'Nama',
            dataField: 'Nama'
          },
          {
            // caption: 'Sales/Rit',
            // cellTemplate: function(container, options) {
            //   // container.html(`${options.row.rowIndex + 1}`);
            //   // let datax = options.row.data
            //   container.html(`
            //   <div class="row my-1">
            //       <div class="col-auto">
            //           <div> Rp ${new Intl.NumberFormat('id-ID').format(options.row.data.Total)} / ${new Intl.NumberFormat('id-ID').format(options.row.data.Rit)} Rit</div>
            //       </div>
            //   </div>

            //   `);
            // }
            caption: 'Sales',
            dataField: 'Total',
            dataType: 'number',
            // alignment: 'center',
            format: 'currency',
            customizeText: function(cellInfo) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(cellInfo.value);
            },
            width: 300
          },
          {
              dataField: 'Rit',
              caption: 'Rit',
              // alignment: 'center',
              width: 100
          }
        ],
        scrolling: {
          rowRenderingMode: 'virtual',
        },
        paging: {
          pageSize: 5,
        },
        pager: {
          visible: true,
          allowedPageSizes: [5, 10, 'all'],
          showPageSizeSelector: true,
          showInfo: true,
          showNavigationButtons: true,
        },
      }).dxDataGrid('instance');

      
    });

  </script>

</body>



</html>