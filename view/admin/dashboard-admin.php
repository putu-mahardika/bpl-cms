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
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard-admin.php">
        <div class="sidebar-brand-icon">
          <img src="../../img/logo-BPL-white-min.png" style="height:130px;">
        </div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="dashboard-admin.php">
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
            <a class="collapse-item" href="status.php">List Status</a>
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
        <div class="container-fluid" id="container-wrapper" style="min-height:100%">
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
            $query_c = mysqli_query($koneksi, "select count(CustId) as jmlCust from master_customer where create_date between '$tahun-01-01 00:00:00' and '$tahun-12-31 00:00:00'");
            $query_t = mysqli_query($koneksi, "select count(HdId) as jmlHd from trans_hd where atr1=0 and create_date between '$tahun-01-01 00:00:00' and '$tahun-12-31 00:00:00'");
            $query_to = mysqli_query($koneksi, "select count(HdId) as Hdopen from trans_hd where OnClose='0' and create_date between '$tahun-01-01 00:00:00' and '$tahun-12-31 00:00:00'");
            $query_tc = mysqli_query($koneksi, "select count(HdId) as Hdclose from trans_hd where OnClose='1' and atr1='0' and DateOnClose between '$tahun-01-01 00:00:00' and '$tahun-12-31 00:00:00'");
        
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
                </div>
              </div>
            </div>



            <!-- Area Chart -->

            <div class="col-xl-8 col-lg-7">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Monthly Recap Report</h6>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
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
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
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
  <script src="../../js/demo/chart-area-demo.js"></script>  

  <script>
    function tahunUbah(){
      var tahun = document.getElementById("tahun").value;
      $('#tahunGo').attr("href", "dashboard-admin.php?tahun="+tahun);
    }
  </script>

</body>



</html>