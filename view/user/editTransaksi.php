<?php

  include '../../config/koneksi.php';

  date_default_timezone_set("Asia/Jakarta");

	$date = date('d/m/Y');

	$time = date('H:i');

	$year = date('Y');
  
  session_save_path('../../tmp');

  session_start();

  if ($_SESSION['hak_akses'] == "" || $_SESSION['hak_akses'] != "User") {

    header("location:../../index.php?pesan=belum_login");

  }

  

  $t_id = $_GET['id'];

  

  $query_t = "select * from trans_hd where HdId='$t_id'"; 

  $fetch_t = mysqli_query($koneksi, $query_t);

  while($data_t = mysqli_fetch_array($fetch_t)){
    $t_hdid = $data_t['HdId'];
    $t_custid = $data_t['CustId'];
    $t_nopo = $data_t['NoPO'];
    $t_tglpo = $data_t['tgl_po'];
    $t_tglpo1 = date('d/m/Y', strtotime($t_tglpo));
    $t_nospk = $data_t['NoSPK'];
    $t_tglspk = $data_t['tgl_spk'];
    $t_tglspk1 = date('d/m/Y', strtotime($t_tglspk));
    $t_armada = $data_t['total_armada'];
    $t_asal = $data_t['kota_kirim'];
    $t_tujuan = $data_t['kota_tujuan'];
    $t_barang = $data_t['Barang'];
    $t_keterangan = $data_t['keterangan'];
    $t_onclose = $data_t['OnClose'];
    $t_DateOnClose = $data_t['DateOnClose'];
    $t_cancelDate = $data_t['cancel_date'];
    $t_user = $data_t['UserId'];
    $t_closedById = $data_t['closedById'];
  }

  if (!is_null($t_closedById)) {
    $query_u = "select UserId, nama from master_user where UserId = ".$t_closedById;
    $fetch_u = mysqli_query($koneksi, $query_u);
    
    while ($data_u = mysqli_fetch_array($fetch_u)) {
      $u_id = $data_u['UserId'];
      $u_namaUser = $data_u['nama'];
    }
  }

  $query_k = "select * from master_kota where aktif = 1";
  $fetch_k = mysqli_query($koneksi, $query_k);
  $fetch_k1 = mysqli_query($koneksi, $query_k);



  $query_c = "select * from master_customer where CustId='$t_custid'";

  $fetch_c = mysqli_query($koneksi, $query_c);

  while($data_c=mysqli_fetch_array($fetch_c)){

    $c_custid = $data_c['CustId'];

    $c_nama = $data_c['nama'];

  }





  $query_s = "select * from master_status where aktif='1' ORDER by atr1 asc";

  $fetch_s = mysqli_query($koneksi, $query_s);

  $query_b = "select * from trans_biayaturunan where HdId='$t_id'";
  $fetch_b = mysqli_query($koneksi, $query_b);
  $arrayBiayaTambahans = array();
  while($rowbiaya = $fetch_b->fetch_assoc()) {
    $arrayBiayaTambahans[] = $rowbiaya;
  }

  $arrayBiayaTambahanLength = count($arrayBiayaTambahans);

  $queryGetGrandTotal = "select (sum(Biaya_transport)+sum(Biaya_inap)+sum(Biaya_lain)) as totalBiaya from trans_biayaturunan where HdId='$t_id'";
  $fetchGetGrandTotal = mysqli_query($koneksi, $queryGetGrandTotal);
  $arrayGetGrandTotal = mysqli_fetch_array($fetchGetGrandTotal);
  $grandTotal = number_format($arrayGetGrandTotal['totalBiaya'], 2, ',', '.');

  //echo $datetime;

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

  <title>Input Transaksi - PT PT Berkah Permata Logistik</title>

  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">

  <link href="../../vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

  <link href="../../vendor/clock-picker/clockpicker.css" rel="stylesheet">

  <link href="../../vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">

  <link href="../../css/ruang-admin.min.css" rel="stylesheet">

  <link href="../../css/style.css" rel="stylesheet">

</head>



<body id="page-top">

  <div id="wrapper">

    <!-- Sidebar -->

    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">

      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php?tahun=<?php echo $year?>">

        <div class="sidebar-brand-icon">

          <img src="../../img/logo-BPL-white.png" style="height:130px;">

        </div>

        

      </a>

      <hr class="sidebar-divider my-0">

      <li class="nav-item active">

        <a class="nav-link" href="dashboard.php?tahun=<?php echo $year?>">

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
          <i class="fas fa-fw fa-table"></i>
          <span>Customer</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Customer</h6>
            <a class="collapse-item" href="customer.php">List Customer</a>
            <!--<a class="collapse-item" href="form_advanceds.html">Form Advanceds</a>-->
          </div>
        </div>
      </li>
      <hr class="sidebar-divider">

      <!--<div class="sidebar-heading">

        MASTER

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

      <hr class="sidebar-divider">-->

      <div class="sidebar-heading">

        TRANSAKSI

      </div>

      <li class="nav-item">

        <a class="nav-link" href="transaksi.php?tahun=<?php echo $year?>">

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

      <hr class="sidebar-divider">

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

            </li>

            <li class="nav-item dropdown no-arrow mx-1">

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

            </li>

            <li class="nav-item dropdown no-arrow mx-1">

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

            </li>

            <li class="nav-item dropdown no-arrow mx-1">

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

          <div class="d-sm-flex align-items-center justify-content-start mb-4">

            <a href="transaksi.php?tahun=<?php echo $year?>" style="margin-right:20px;"><i class="far fa-arrow-alt-circle-left fa-2x" title="kembali"></i></a>

            <h1 class="h3 mb-0 text-gray-800">Form Pergerakan Truck</h1>

            <!--<ol class="breadcrumb">

              <li class="breadcrumb-item"><a href="./">Home</a></li>

              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>

            </ol>-->

          </div>



          <div class="row mb-3">

            <!-- Earnings (Monthly) Card Example -->

            <!--<div class="col-xl-3 col-md-6 mb-4">

              <div class="card h-100">

                <div class="card-body">

                  <div class="row align-items-center">

                    <div class="col mr-2">

                      <div class="text-xs font-weight-bold text-uppercase mb-1">Earnings (Monthly)</div>

                      <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>

                      <div class="mt-2 mb-0 text-muted text-xs">

                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>

                        <span>Since last month</span>

                      </div>

                    </div>

                    <div class="col-auto">

                      <i class="fas fa-calendar fa-2x text-primary"></i>

                    </div>

                  </div>

                </div>

              </div>

            </div>-->

            <!-- Earnings (Annual) Card Example -->

            <!--<div class="col-xl-3 col-md-6 mb-4">

              <div class="card h-100">

                <div class="card-body">

                  <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                      <div class="text-xs font-weight-bold text-uppercase mb-1">Sales</div>

                      <div class="h5 mb-0 font-weight-bold text-gray-800">650</div>

                      <div class="mt-2 mb-0 text-muted text-xs">

                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>

                        <span>Since last years</span>

                      </div>

                    </div>

                    <div class="col-auto">

                      <i class="fas fa-shopping-cart fa-2x text-success"></i>

                    </div>

                  </div>

                </div>

              </div>

            </div>-->

            <!-- New User Card Example -->

            <!--<div class="col-xl-3 col-md-6 mb-4">

              <div class="card h-100">

                <div class="card-body">

                  <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                      <div class="text-xs font-weight-bold text-uppercase mb-1">New User</div>

                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">366</div>

                      <div class="mt-2 mb-0 text-muted text-xs">

                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>

                        <span>Since last month</span>

                      </div>

                    </div>

                    <div class="col-auto">

                      <i class="fas fa-users fa-2x text-info"></i>

                    </div>

                  </div>

                </div>

              </div>

            </div>-->

            <!-- Pending Requests Card Example -->

            <!--<div class="col-xl-3 col-md-6 mb-4">

              <div class="card h-100">

                <div class="card-body">

                  <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                      <div class="text-xs font-weight-bold text-uppercase mb-1">Pending Requests</div>

                      <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>

                      <div class="mt-2 mb-0 text-muted text-xs">

                        <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>

                        <span>Since yesterday</span>

                      </div>

                    </div>

                    <div class="col-auto">

                      <i class="fas fa-comments fa-2x text-warning"></i>

                    </div>

                  </div>

                </div>

              </div>

            </div>-->



            <!-- Area Chart -->

            <div class="col-xl-9 col-lg-8">

              <div class="card mb-4">

                <!--<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

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

                </div>-->

                <div class="card-body">

                <?php if(isset($_SESSION['pesan'])){?><?php echo $_SESSION['pesan']; unset($_SESSION['pesan']);}?>

                  <form role="form" method="post" action="../../config/process.php">

					<div class="form-group">

						<input type="hidden" class="form-control form-control-sm mb-3" name="id" value="<?php echo $t_id ?>" readonly>

                    </div>

                    <div class="form-group">

                      <label>Customer :</label>

                      <select class="select2-single-placeholder form-control" name="customer" style="width:100% !important;" readonly>

                        <option value="<?php echo $c_custid?>" selected><?php echo $c_nama?></option>

                      </select>

                    </div>	

                    <div class="row" style="height: 70px;">

                      <div class="form-group col-sm-7">

                        <label>No. PO Customer :</label>

                        <input type="text" class="form-control form-control-sm mb-3" name="nopo" value="<?php echo $t_nopo ?>" required>

                      </div>

                      <div class="form-group col-sm-5" id="simple-date1">

                        <label>Tgl PO :</label>

                        <div class="input-group input-group-sm mb-3 date">

                          <div class="input-group-prepend">

                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>

                          </div>

                          <input type="text" class="form-control" value="<?php echo $t_tglpo1 ?>" id="simpleDataInput" name="tglpo" required>

                          </div>

                      </div>

                    </div>

                    <div class="row" style="height: 70px;">

                      <div class="form-group col-sm-7">

                        <label>No. SPK :</label>

                        <input type="text" class="form-control form-control-sm mb-3" value="<?php echo $t_nospk ?>" name="nospk" readonly>

                      </div>

                      <div class="form-group col-sm-5" id="simple-date1">

                        <label>Tgl SPK :</label>

                        <div class="input-group input-group-sm mb-3 date">

                          <div class="input-group-prepend">

                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>

                          </div>

                          <input type="text" class="form-control" value="<?php echo $t_tglspk1 ?>" id="simpleDataInput" name="tglspk" required>

                        </div>

                      </div>

                    </div>

                    <div class="row" style="height: 70px;">

                      <div class="form-group col-sm-4">

                        <label>Jumlah Armada :</label>

                        <input type="number" min="1" class="form-control form-control-sm mb-3" value="<?php echo $t_armada ?>" name="armada" id="armada" onchange="armadaUbah()" required>

                      </div>

                      <div class="form-group col-sm-3">



                      </div>

                      <div class="form-group col-sm-5">

                        <label>Status Pengiriman :</label>

                      <?php if($t_onclose == 0){?>

                                  <input type="text" class="form-control form-control-sm mb-3" name="status" id="statuskirim" value="OPEN" readonly>

                      <?php } else { ?>

                      <input type="text" class="form-control form-control-sm mb-3" name="status" id="statuskirim" value="CLOSE" readonly>

                      <?php } ?>

                      </div>

                    </div>

                    <div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Kota Asal :</label>
                            <!-- <select class="select2-single-placeholder form-control" name="kotaAsal" id="kotaAsal" style="width:100% !important;" required>
                              <option value="<?php echo $c_custid?>" selected><?php echo $c_nama?></option>
                            </select> -->
                            <select class="select2-single-placeholder form-control" name="kotaAsal" id="kotaAsal" required>
                            <?php 
                                if (is_null($t_asalId)) {
                              ?>
                                  <option value="" selected disabled>Pilih</option>
                              <?php
                                } else {
                              ?>
                                  <option value="" disabled>Pilih</option>
                              <?php
                                }
                              ?>
                              <?php
                                while($dataKotaAsal = mysqli_fetch_array($fetch_k)){
                                  // print_r($dataUser);
                                  if($dataKotaAsal['aktif']==1){
                                    if($dataKotaAsal['Id'] == $t_asalId){
                              ?>
                              <option value="<?php echo $dataKotaAsal['Id'];?>" selected><?php echo $dataKotaAsal['Kode'] . " - " . $dataKotaAsal['Nama'];?></option>
                                  <?php }else{?>
                              <option value="<?php echo $dataKotaAsal['Id'];?>"><?php echo $dataKotaAsal['Kode'] . " - " . $dataKotaAsal['Nama'];?></option>
                                <?php } } else {
                                  continue;
                                  }
                                }
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Detail Kota Asal :</label>
                            <!-- <input type="text" class="form-control form-control-sm mb-3" value="<?php echo $t_asal ?>" name="detailKotaAsal" id="detailKotaAsal"> -->
      					            <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaAsal" id="detailKotaAsal" required><?php echo $t_asal ?></textarea>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Kota Tujuan :</label>
                            <!-- <select class="select2-single-placeholder form-control" name="kotaTujuan" id="kotaTujuan" style="width:100% !important;" required>
                              <option value="<?php echo $c_custid?>" selected><?php echo $c_nama?></option>
                            </select> -->
                            <select class="select2-single-placeholder form-control" name="kotaTujuan" id="kotaTujuan" required>
                            <?php 
                                if (is_null($t_tujuanId)) {
                              ?>
                                  <option value="" selected disabled>Pilih</option>
                              <?php
                                } else {
                              ?>
                                  <option value="" disabled>Pilih</option>
                              <?php
                                }
                              ?>
                              <?php
                                while($dataKotaTujuan = mysqli_fetch_array($fetch_k1)){
                                  // print_r($dataUser);
                                  if($dataKotaTujuan['aktif']==1){
                                    if($dataKotaTujuan['Id'] == $t_tujuanId){
                              ?>
                              <option value="<?php echo $dataKotaTujuan['Id'];?>" selected><?php echo $dataKotaTujuan['Kode'] . " - " . $dataKotaTujuan['Nama'];?></option>
                                  <?php }else{?>
                              <option value="<?php echo $dataKotaTujuan['Id'];?>"><?php echo $dataKotaTujuan['Kode'] . " - " . $dataKotaTujuan['Nama'];?></option>
                                <?php } } else {
                                  continue;
                                  }
                                }
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Detail Kota Tujuan :</label>
                            <!-- <input type="text" class="form-control form-control-sm mb-3" value="<?php echo $t_tujuan ?>" name="detailKotaTujuan" id="detailKotaTujuan"> -->
      					            <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaTujuan" id="detailKotaTujuan" required><?php echo $t_asal ?></textarea>
                          </div>
                        </div>
                      <!-- <div class="form-group col-sm-4"> -->
                      </div>
                    </div>

                    <div class="form-group">

                      <label>Barang :</label>

					            <textarea type="text" class="form-control form-control-sm mb-3" name="barang" required><?php echo $t_barang ?></textarea>

                    </div>

                    <div class="form-group">

                      <label>Keterangan :</label>
                      <?php
                        $t_keterangan = str_replace("%%",PHP_EOL, $t_keterangan);
                      ?>
                      <textarea type="text" class="form-control form-control-sm mb-3" name="keterangan"><?php echo $t_keterangan ?></textarea>

                    </div>

                    

                    <!--<select name="aktif" class="form-control form-control-sm mb-3" required>

                      <option disabled> Pilih </option>

                      <option value=1 selected> Ya </option>

                      <option value=0> Tidak </option>

                    </select>-->

                    <br>

                    <div class="row" style="height:70px;">

                      <div class="form-group col-sm-2" >

                        <input type="reset" value="Reset" style="width:100%;" class="btn btn-danger">

                      </div>

                      <!--<div class="form-group col-sm-2" style="padding-left:0px;">

                      <?php if($t_onclose!=1){?>

                        <button type="button" class="btn btn-warning cancel1" style="width:100%;padding-left:11px;padding-right:11px;" data-id="<?php echo $t_hdid?>">Cancel Order</button>

                      <?php } else {?>

                        <button type="button" class="btn btn-warning" style="width:100%;padding-left:11px;padding-right:11px;" data-toggle="modal" data-target="#cancelModal" disabled>Cancel Order</button>

                      <?php } ?>

                      </div>-->

                      <div class="form-group col-sm-2" style="padding-left:0px;">

                      <?php
                        $close=1;
                        for($i=1;$i<=$t_armada;$i++){
                          $query_close = mysqli_query($koneksi, "select OnClose from trans_detail where DtlId in (select max(DtlId) from trans_detail where NoSPK='$t_nospk' and turunan='$i')");
                          $close1=mysqli_fetch_array($query_close);
                          if(!is_null($close1)) {
                            if($close1['OnClose'] == 1){
                              $close = 0;
                            } elseif($close1['OnClose'] == 0){
                              $close = 1;
                              break;
                            }
                          }
                        }
                        // $query_close = mysqli_query($koneksi, "select count(OnClose) as close from trans_detail where NoSPK='$t_nospk' and OnClose=0");

                        // while($close1=mysqli_fetch_array($query_close)){

                        //   $close = $close1['close'];

                        // }

                        if($close == 0 && $t_onclose!=1){

                      ?>

                      <button type="button" class="btn btn-success close1" style="width:100%;padding-left:11px;padding-right:11px;" data-id="<?php echo $t_hdid?>">Close Order</button>

                      <?php

                        }else{

                      ?>

                      <button type="button" class="btn btn-success" style="width:100%;padding-left:11px;padding-right:11px;" data-toggle="modal" data-target="#closeModal" disabled>Close Order</button>

                      <?php } ?>

                      </div>

                      <div class="form-group col-sm-8" style="padding-left:0px;">

                        <input type="submit" value="Submit" name="editTransaksi" style="width:100%;" class="btn btn-md btn-primary" id="submit" >

                      </div>

                    </div>
                    <?php 
                      if($t_onclose == 1 && is_null($t_cancelDate)) {
                    ?>
                      <p>Ditutup Oleh <b><?php echo $u_namaUser?></b> tanggal <b><?php echo $t_DateOnClose?></b></p>
                    <?php    
                      } elseif (!is_null($t_cancelDate)) {
                    ?>
                      <p>Dibatalkan Oleh <b><?php echo $u_namaUser?></b> tanggal <b><?php echo $t_cancelDate?></b></p>
                    <?php
                      }
                    ?>

                  </form>

                </div>

              </div>

            </div>

            <!-- Pie Chart -->

            <div class="col-xl-3 col-lg-4">

              <div class="card mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                  <h6 class="m-0 font-weight-bold text-primary">No. SPK Turunan</h6>          

                </div>

                <!--<div class="card-body">-->

                  <div class="table-responsive p-3">

                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">

                    <thead class="thead-light">

                      <tr>

                      <th style="font-size:16px; padding-right:0px;">No</th>

                      <th style="font-size:16px; padding-left:12px; padding-right:12px;">Status</th>					

                      </tr>

                    </thead>

                    <tbody>

                    <?php
                      if($t_armada == 1){
                        $i=1;
                        $query_tdt1 = "select OnClose from trans_detail where DtlId in (select max(DtlId) from trans_detail where NoSPK='$t_nospk' and turunan='$i')";
                        // $query_tdt1 = "select count(OnClose) as close from trans_detail where NoSPK='$t_nospk' and OnClose=0";
                        $fetch_tdt1 = mysqli_query($koneksi, $query_tdt1);
                        $onclose = mysqli_fetch_array($fetch_tdt1);
                        // while($onclose=mysqli_fetch_array($fetch_tdt1)){
                        //   $onclose1 = $onclose['close'];
                        // }
                      ?>  

                      <tr>

                      <td style="font-size:12px; "><?php echo $t_nospk ?></td>

                            <?php if(isset($onclose)){ 

                              if($onclose['OnClose'] == 0){?>

                                <td style="font-size:16px;padding-left:12px;"><span class="badge badge-info">open</span></td>

                              <?php } else { ?>

                                <td style="font-size:16px;padding-left:12px;"><span class="badge badge-success">close</span></td>

                              <?php } ?>

                            <?php } else { ?>

                              <td style="font-size:16px;padding-left:12px;"><span class="badge badge-info">open</span></td>

                            <?php } ?>

                        </tr>

                      <?php   

                      } else {

                        for($i=1;$i<=$t_armada;$i++){

                          $query_tdt1 = "select OnClose from trans_detail where DtlId in (select max(DtlId) from trans_detail where NoSPK='$t_nospk' and turunan='$i')";

                          $fetch_tdt1 = mysqli_query($koneksi, $query_tdt1);

                          $onclose = mysqli_fetch_array($fetch_tdt1);

                      ?>

                      <tr>

                      <td style="font-size:12px;"><?php echo $t_nospk ?>-<?php echo $i ?></td>

					                  <?php if(isset($onclose)){ 

                              if($onclose['OnClose'] == 0){?>

                                <td style="font-size:16px;padding-left:12px;"><span class="badge badge-info">open</span></td>

                              <?php } else { ?>

                                <td style="font-size:16px;padding-left:12px;"><span class="badge badge-success">close</span></td>

                              <?php } ?>

                            <?php } else { ?>

                              <td style="font-size:16px;padding-left:12px;"><span class="badge badge-info">open</span></td>

                            <?php } ?>

                      </tr>

                    <?php

                        }

                      }

                    ?>

                    </tbody>

                    </table>

                  </div>

                <!--</div>-->

              </div>

              <div class="card mb-4" id="viewUser">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                  <h6 class="m-0 font-weight-bold text-primary">Perubahan User</h6>   
                  <!--<a type="button" href="#" onclick="formUser()" title="ganti user" class="edituser" ><i class="fas fa-edit"></i></a>-->

                </div>

                <!--<div class="card-body">-->
                  <?php
                    $query1 = mysqli_query($koneksi, "select nama from master_user where UserId='$t_user'");
                    $data1 = mysqli_fetch_array($query1);
                  ?>
                  <div class="card-body" style="padding-top:0;">
                    <label><b>User Lama :</b></label> 
                    <input type="text" class="form-control form-control-sm mb-3" name="user" value="<?php echo $data1['nama']?>" readonly>
                  </div>

                <!--</div>-->

              </div>

            </div>

            <!-- Invoice Example -->

            <div class="col-xl-12 col-lg-10 mb-9 sm-8">

              <div class="card">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                  <button onclick="add()" class="btn btn-primary btn-icon-split" id="tambah" >

                    <span class="icon text-white-50">

                      <i class="fas fa-plus"></i>

                    </span>

                    <span class="text">Tambah Detail Transaksi</span>

                    </button>

                  <button onclick="view()" class="btn btn-primary btn-icon-split lihat hidden" id="lihat">

                    <span class="icon text-white-50">

                      <i class="fas fa-plus"></i>

                    </span>

                    <span class="text">Lihat Detail Transaksi</span>

                    </button>

                </div>

                

                

                <div class="card-body" id="tabeldetail">

                <?php for($i=1;$i<=$t_armada;$i++){

                //echo $t_armada;

                $temp_nospk = explode(" ", $t_nospk);

                $t_nospk1 = $temp_nospk[0];

                ?>

                  <div class="table-responsive p-3">

                    <?php if($t_armada == 1){?>

                    <label><b>No. SPK Turunan : <?php echo $t_nospk ?></b></label>

                    <?php } else {?>

                    <label><b>No. SPK Turunan : <?php echo $t_nospk1 ?>-<?php echo $i ?></b></label>

                    <?php } ?>

                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">

                      <thead class="thead-light">

                        <tr>

                          <th style="padding-left:8px;">Tgl</th>

                          <th style="padding-left:8px;">Jenis Kendaraan</th>

                          <th style="padding-left:8px;">Nopol/Nama Kendaraan</th>

                          <th style="padding-left:8px;">Status</th>

                          <th style="padding-left:8px;">Keterangan Pengiriman</th>

                          <th style="padding-left:8px;">Action</th>

                        </tr>

                      </thead>

                      <tbody>

                        <?php 

                        $query_td = "select * from trans_detail where NoSPK='$t_nospk' and turunan='$i'";

                        $fetch_td = mysqli_query($koneksi, $query_td);

                        while($data_td=mysqli_fetch_array($fetch_td)){

						            	$dtlid = $data_td['DtlId'];

                            if($i == $data_td['turunan']){ 

                            $query_stemp = "select status from master_status where stsId='$data_td[StsId]'";

                            $fetch_stemp = mysqli_query($koneksi, $query_stemp);

                            $data_stemp = mysqli_fetch_array($fetch_stemp);

                            $tgl = date("d-M-Y H:i", strtotime($data_td['datetime_status']));

                        ?>

                        <tr>

                          <td style="font-size:13px;padding-left:8px;"><?php echo $tgl?></td>

                          <td style="font-size:13px;padding-left:8px;"><?php echo $data_td['jenis_armada'];?></td>

                          <td style="font-size:13px;padding-left:8px;"><?php echo $data_td['nopol'];?></td>

                          <td style="font-size:13px;padding-left:8px;"><?php echo $data_stemp['status'];?></td>
                          <?php
                            $keterangan_td = $data_td['keterangan_kirim'];
                            $keterangan_td = str_replace("%%",PHP_EOL, $keterangan_td);
                          ?>

                          <td style="font-size:13px;padding-left:8px;white-space:pre"><?php echo $keterangan_td?></td>

                          <td style="padding-right:0.5rem;padding-left:8px;">

                              <button title="detail" data-id="<?php echo $dtlid?>" class="btn btn-info btn-sm tdinfo"><i class="fas fa-search"></i></button>

                              <a href="editTransaksi1.php?id=<?php echo $t_id?>&editId=<?php echo $data_td['DtlId'];?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <?php if($t_onclose == 0){?>
                              <button title="hapus" data-id="<?php echo $dtlid?>" class="btn btn-danger btn-sm tddel"><i class="fas fa-trash"></i></button>
                            <?php } ?>
                          </td>

                        </tr>

                        <?php } } ?>

                      </tbody>

                    </table>  

                  </div>

                  <?php } ?>

                </div>





                <div class="card-body hidden" id="formdetail">

                  <form role="form" method="post" action="../../config/process.php">

					

                    <div class="form-group" >

                      <input type="hidden" class="form-control form-control-sm mb-3" name="hdid" value="<?php echo $t_hdid ?>" readonly>

                      <input type="hidden" class="form-control form-control-sm mb-3" name="nospk" value="<?php echo $t_nospk ?>" readonly>

                      <label style="width:100%">No. SPK :</label>

                      <select class="select2-single-placeholder form-control" style="width:100%" onchange="changeValue()" name="turunan" id="pilihspk" required>

                        <!--<option value="" disabled selected>Pilih</option>-->

						            <option value="" disabled selected>Pilih</option>

                        <?php  

						              $jsArray = "var data = [];\n";

                          for($i=1;$i<=$t_armada;$i++){

							              $query_tdt = "select * from trans_detail where DtlId in (select max(DtlId) from trans_detail where NoSPK='$t_nospk' and turunan='$i')";

							              $fetch_tdt = mysqli_query($koneksi, $query_tdt);

                            if($t_armada == 1){

                                      

                              echo '<option value='.$i.'>'.$t_nospk.'</option>';

                          

                              while($data_tdt = mysqli_fetch_array($fetch_tdt)){

                                $jsArray .= "data[".$i."] = {status:'".addslashes($data_tdt['StsId'])."', jenis:'".addslashes($data_tdt['jenis_armada'])."', nopol:'".addslashes($data_tdt['nopol'])."', keterangan:'".addslashes($data_tdt['keterangan_kirim'])."', onclose:'".addslashes($data_tdt['OnClose'])."'};\n";

                              }



                            } else { 

                              echo '<option value='.$i.'>'.$t_nospk.'-'.$i.'</option>';

                          

                              while($data_tdt = mysqli_fetch_array($fetch_tdt)){

                                $jsArray .= "data[".$i."] = {status:'".addslashes($data_tdt['StsId'])."', jenis:'".addslashes($data_tdt['jenis_armada'])."', nopol:'".addslashes($data_tdt['nopol'])."', keterangan:'".addslashes($data_tdt['keterangan_kirim'])."', onclose:'".addslashes($data_tdt['OnClose'])."'};\n";

                              }

                            }

                          } ?>

                      </select>

                    </div>	

                    <!--<div class="row" style="height: 70px;">

                      <div class="form-group col-sm-5" id="simple-date1">

                        <label>Tgl dan Jam Pergerakan :</label>

                        <div class="input-group input-group-sm mb-3 date">

                          <div class="input-group-prepend">

                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>

                          </div>

                          <input type="text" class="form-control" value="01/06/2020" id="simpleDataInput" required>

                        </div>

                      </div>

                      <div class="form-group col-sm-7">

		                  </div>

						        </div>-->

					<div class="row" style="height: 70px;">

						<div class="form-group col-sm-6" id="simple-date1">

							<label>Tanggal Entry :</label>

							<div class="input-group input-group-sm mb-3 date">

							  <div class="input-group-prepend">

								<span class="input-group-text"><i class="fas fa-calendar"></i></span>

							  </div>

							  <input type="text" class="form-control" value="<?php echo $date ?>" id="simpleDataInput" name="tgl" required>

							</div>

						</div>

						<div class="form-group col-sm-6">

							<label>Jam Entry :</label>

							<div class="input-group input-group-sm mb-3 clockpicker" id="clockPicker2">

							  <input type="text" class="form-control" value=<?php echo $time ?> name="waktu" required>                     

							  <div class="input-group-append">

								<span class="input-group-text"><i class="fas fa-clock"></i></span>

							  </div>                      

							</div>

						</div>

					</div>

                    <div class="row" style="height: 70px;">

                      <div class="form-group col-sm-4">

                      <label>Status Pengiriman :</label>

                        <!--<input type="text" class="form-control form-control-sm mb-3" name="status" required>-->

                        <select class="form-control form-control-sm mb-3" placeholder="Pilih" name="status" id="status">

						              <option value="" disabled selected hidden>Pilih</option>

                          <?php

                            while($data_s = mysqli_fetch_array($fetch_s)){

                          ?>

                          <option value="<?php echo $data_s['stsId'];?>"><?php echo $data_s['status'];?></option>

                          <?php } ?>

                        </select>

                      </div>

                      <div class="form-group col-sm-4">

                        <label>Jenis Kendaraan :</label>

                        <input type="text" class="form-control form-control-sm mb-3" name="jenis" id="jenis" required>

                      </div>

                      <div class="form-group col-sm-4">

                        <label>Nopol/Nama Kendaraan :</label>

                        <input type="text" class="form-control form-control-sm mb-3" name="nopol" id="nopol" required>

                      </div>

                    </div>

					          <div class="row" style="height: 70px;">

                      <div class="form-group col-sm-4">

                        <label>On Close :</label>

                        <select name="onclose" class="form-control form-control-sm mb-3" id="onclose" required>

                          <option value=0 selected> OPEN </option>

                          <option value=1 > CLOSE </option>

                        </select>

                      </div>

                      <div class="form-group col-sm-4">

                      </div>

                      <div class="form-group col-sm-4" >

                        <!--<label>Tanggal :</label>

                        <div class="input-group input-group-sm mb-3 date">

                          <div class="input-group-prepend">

                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>

                          </div>

                          <input type="text" class="form-control" value="<?php echo $datetime ?>" id="simpleDataInput" name="tgl" required>

                        </div>-->

                      </div>

                    </div>

                    <!--<div class="form-group">

                      <label>Barang :</label>

                      <input type="text" class="form-control form-control-sm mb-3" name="status" required>

                    </div>-->

                    <div class="form-group">

                      <label>Keterangan :</label>

                      <textarea type="text" class="form-control form-control-sm mb-3" name="keterangan" id="keterangan"></textarea>

                    </div>		

                    <!--<select name="aktif" class="form-control form-control-sm mb-3" required>

                      <option disabled> Pilih </option>

                      <option value=1 selected> Ya </option>

                      <option value=0> Tidak </option>

                    </select>-->

                    <div class="mb-3">
                      <label>Total Biaya :</label>
                      <h4><b>IDR. <?php echo $grandTotal ?></b></h4>
                    </div>

                    <br>

                    <input type="button" value="Reset" onclick="tmbreset()" class="btn btn- btn-danger " style="width:22%;">

                    <input type="submit" value="Submit" name="inputDetail" class="btn btn-md btn-primary " style="width:77%;">

                  </form>

                </div>

                <div class="card-footer"></div>

              </div>

            </div>

            <!-- Message From Customer-->

            

			<!-- Modal Detail -->

          <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"

            aria-hidden="true">

            <div class="modal-dialog" role="document">

              <div class="modal-content">

                <div class="modal-header">

                  <h5 class="modal-title" id="exampleModalLabelLogout">Detail Transaksi</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                  </button>

                </div>

                <div class="modal-body">

                  

                </div>

                <div class="modal-footer">

                  <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>

                </div>

              </div>

            </div>

          </div>

		  

			<!-- Modal Cancel -->

          <!--<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"

            aria-hidden="true">

            <div class="modal-dialog" role="document">

              <div class="modal-content">

                <div class="modal-header">

                  <h5 class="modal-title" id="exampleModalLabelLogout">Cancel Transaksi</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                  </button>

                </div>

                <div class="modal-body">

                  <p>Apakah anda ingin membatalkan data terpilih ?</p>

                </div>

                <div class="modal-footer">

                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Ya</button>

                  <button onclick="cancel()" href id="ubah" class="btn btn-primary" data-dismiss="modal">Tidak</button>

                </div>

              </div>

            </div>

          </div>-->

			

			<!-- Modal close -->

          <div class="modal fade bd-example-modal-xl" id="closeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"

            aria-hidden="true">

            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">

              <div class="modal-content">

                <div class="modal-header">

                  <h5 class="modal-title" id="exampleModalLabelLogout">Apakah anda ingin menyelesaikan data terpilih ?</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                  </button>

                </div>

                <div class="modal-body">

                  

                </div>

                <div class="modal-footer">

                <a href="../../config/process.php?closeId=<?php echo $t_id?>" id="cancel" class="btn btn-outline-primary">Ya</a>

                  <button type="button" class="btn btn-primary" data-dismiss="modal">Tidak</button>  

                </div>

              </div>

            </div>

          </div>

      

      <!-- Modal cancel -->

          <div class="modal fade bd-example-modal-xl" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"

            aria-hidden="true">

            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">

              <div class="modal-content">

                <div class="modal-header">

                  <h5 class="modal-title" id="exampleModalLabelLogout">Apakah anda ingin membatalkan data terpilih ?</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                  </button>

                </div>

                <div class="modal-body">

                  

                </div>

                <div class="modal-footer">

                  <a href="../../config/process.php?cancelId=<?php echo $t_id?>" id="cancel" class="btn btn-outline-primary">Ya</a>

                  <button type="button" class="btn btn-primary" data-dismiss="modal">Tidak</button>

                </div>

              </div>

            </div>

          </div>

      

      <!-- Modal Hapus -->

          <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"

            aria-hidden="true">

            <div class="modal-dialog" role="document">

              <div class="modal-content">

                <div class="modal-header">

                  <h5 class="modal-title" id="exampleModalLabelLogout">Hapus Data</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                  </button>

                </div>

                <div class="modal-body">

                  <p>Apakah anda ingin menghapus data terpilih ?</p>

                </div>

                <div class="modal-footer">

                  <a href="" id="del" class="btn btn-outline-primary">Ya</a>

                  <button type="button" class="btn btn-primary" data-dismiss="modal">Tidak</button>

                </div>

              </div>

            </div>

          </div>

		  

		  <!-- Modal Ubah Armada -->

          <div class="modal fade" id="armadaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"

            aria-hidden="true">

            <div class="modal-dialog" role="document">

              <div class="modal-content">

                <div class="modal-header">

                  <h5 class="modal-title" id="exampleModalLabelLogout">Ubah Jumlah Armada</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                  </button>

                </div>

                <div class="modal-body">

					        <p>Mengubah jumlah armada akan mempengaruhi jumlah SPK Turunan !</p><br>

                  <p>Apakah anda ingin mengubah data jumlah armada ?</p>

                </div>

                <div class="modal-footer">

                <button type="button" class="btn btn-outline-primary" onclick="afterarmadaUbah()" data-dismiss="modal">Ya</button>

                  <button onclick="backArmada()" href id="ubah" class="btn btn-primary" data-dismiss="modal">Tidak</button>

                </div>

              </div>

            </div>

          </div>


          <!-- Modal Alert After Ubah Armada -->
          <div class="modal fade" id="afterarmadaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Peringatan !</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Jumlah armada telah diubah !</p>
                  <p>Tekan tombol Submit untuk menyimpan perubahan !</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
                  <!--<button onclick="backArmada()" href id="ubah" class="btn btn-primary" data-dismiss="modal">Tidak</button>-->
                </div>
              </div>
            </div>
          </div>

		  

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

                <div class="modal-body logout-modal">

                  <p>Are you sure you want to logout?</p>

                </div>

                <div class="modal-footer">

                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>

                  <a href="../../config/logout.php" class="btn btn-primary">Logout</a>

                </div>

              </div>

            </div>

          </div>

          <!-- Modal Form Ubah Biaya Turunan -->
          <div class="modal fade" id="biayaTurunanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ubah Biaya Turunan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="../../config/process.php" method="post" role="form">
                    <p><b>No. SPK Turunan : <span id="spkturunan"></span></b></p>
                    <input type="hidden" class="form-control" id="biayaTurunanId" name="biayaTurunanId">
                    <input type="hidden" class="form-control" id="biayaTurunanHdid" name="biayaTurunanHdid">
                    <input type="hidden" class="form-control" id="biayaTurunanSPK" name="biayaTurunanSPK">
                    <input type="hidden" class="form-control" id="biayaTurunanTurunan" name="biayaTurunanTurunan">
                    <div class="form-group">
                      <label for="biayaTransport">Biaya Transport</label>
                      <input type="number" min="0" class="form-control" id="biayaTransport" name="biayaTransport">
                    </div>
                    <div class="form-group">
                      <label for="biayaInap">Biaya Inap</label>
                      <input type="number" min="0" class="form-control" id="biayaInap" name="biayaInap">
                    </div>
                    <div class="form-group">
                      <label for="biayaLain">Biaya Lain-lain</label>
                      <input type="number" min="0" class="form-control" id="biayaLain" name="biayaLain">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary" name="editBiayaTurunan">Simpan</button>
                  </form>
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
  <script src="../../vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <script src="../../vendor/clock-picker/clockpicker.js"></script>
  <script src="../../vendor/select2/dist/js/select2.min.js"></script>

  <script>
	$(document).ready(function () {
	  $('.select2-single').select2();

	  // Select2 Single  with Placeholder
      $('.select2-single-placeholder').select2({
		placeholder: "Pilih",
		allowClear: true
	  });
	  $('#simple-date1 .input-group.date').datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: 'linked',
        todayHighlight: true,
        autoclose: true,        
	  });

	  $('#clockPicker2').clockpicker({
        autoclose: true
      });
  	  
	  $('html, body').animate({
      scrollTop: $('#formdetail').offset().top}, 2);
	  
	  $('.tdinfo').click(function(){
        var dtlid = $(this).data('id');

        // AJAX request\
        $.ajax({
          url: '../../config/viewDetailTransaksi.php',
          type: 'post',
          data: {dtlid: dtlid},
          success: function(response){
            // Add response in Modal body
            $('.modal-body').html(response);
            // Display Modal
            $('#detailModal').modal('show');
          }
        });
      });

      $('.cancel1').click(function(){
        var hdid = $(this).data('id');

        // AJAX request\
        $.ajax({
          url: '../../config/viewTransaksi.php',
          type: 'post',
          data: {hdid: hdid},
          success: function(response){
            // Add response in Modal body
            $('.modal-body').html(response);
            // Display Modal
            $('#cancelModal').modal('show');
          }
        });
      });

     $('.close1').click(function(){
        var hdid = $(this).data('id');

        // AJAX request\
        $.ajax({
          url: '../../config/viewTransaksi.php',
          type: 'post',
          data: {hdid: hdid},
          success: function(response){
            // Add response in Modal body
            $('.modal-body').html(response);
            // Display Modal
            $('#closeModal').modal('show');
          }
        });
      });
	  
	  $('.tddel').click(function(){
		var id = $(this).attr('data-id');
		$("#del").attr("href", "../../config/process.php?DtlId="+id);
		$('#deleteModal').modal('show');
	  });
  
	  var status = document.getElementById("statuskirim").value;
	  var cancel = document.getElementById("cancel");
	  var submit = document.getElementById("submit");
	  var tambah = document.getElementById("tambah")
	  
	  if(status != "OPEN"){
		submit.disabled = true;
		cancel.disabled = true;
		tambah.disabled = true;
	  };
 
	});

	var armada = document.getElementById("armada").value;
	function armadaUbah(){
		$('#armadaModal').modal('show');
  };
  function afterarmadaUbah(){
    $('#afterarmadaModal').modal('show');
  };
	
	function backArmada(){
		document.getElementById("armada").value = armada;
	};
  </script>

  <script>
    function view(){
      var a = document.getElementById("tambah");
      var b = document.getElementById("lihat");
      var c = document.getElementById("tabeldetail");
      var d = document.getElementById("formdetail");
      a.classList.remove("hidden");
      b.classList.add("hidden");
      c.classList.remove("hidden");
      d.classList.add("hidden");
    };

    function add(){
      var a = document.getElementById("tambah");
      var b = document.getElementById("lihat");
      var c = document.getElementById("tabeldetail");
      var d = document.getElementById("formdetail");
      a.classList.add("hidden");
      b.classList.remove("hidden");
      c.classList.add("hidden");
      d.classList.remove("hidden");
    };
  </script>

  <script type="text/javascript">
	<?php echo $jsArray; ?>
	function changeValue(){
    var x = document.getElementById('pilihspk').value;
    //alert(x);
		document.getElementById('status').value = data[x].status;
		document.getElementById('jenis').value = data[x].jenis;
		document.getElementById('nopol').value = data[x].nopol;
    var keterangan = data[x].keterangan;
    var keterangan1 = keterangan.replace(/%%/g, "\n");
		document.getElementById('keterangan').value = keterangan1;
    document.getElementById('onclose').value = data[x].onclose;
	};

  function tmbreset(){
    var x = document.getElementById('pilihspk').value;
    //alert(x);
    if(x != ""){
      document.getElementById('status').value = data[x].status;
      document.getElementById('jenis').value = data[x].jenis;
      document.getElementById('nopol').value = data[x].nopol;
      var keterangan = data[x].keterangan;
      var keterangan1 = keterangan.replace(/%%/g, "\n");
      document.getElementById('keterangan').value = keterangan1;
      document.getElementById('onclose').value = data[x].onclose;
    }
	};

  </script>

  <script>
    function openFormBiayaTurunan(id) {
      $biayaId = document.getElementById('biayaTurunanId');
      $biayaHdid = document.getElementById('biayaTurunanHdid');
      $biayaTurunanSPK = document.getElementById('biayaTurunanSPK');
      $biayaTurunanTurunan = document.getElementById('biayaTurunanTurunan');
      $spkTurunan = document.getElementById('spkturunan');
      $biayaTransportInput = document.getElementById('biayaTransport');
      $biayaInapInput = document.getElementById('biayaInap');
      $biayaLainInput = document.getElementById('biayaLain');

      $.ajax({
        url: '../../config/process.php',
        type: 'get',
        data: {
          biayaTurunanId: id
        },
        dataType: 'json',
        success: function(responsetemp) {
          // Add response in Modal body
          console.log('res get biaya', responsetemp);
          $response = responsetemp[0];
          $biayaId.value = $response.Id;
          $biayaHdid.value = $response.HdId;
          $spkTurunan.innerHTML = $response.NoSPK + "-" + $response.Turunan;
          $biayaTransportInput.value = $response.Biaya_transport;
          $biayaInapInput.value = $response.Biaya_inap;
          $biayaLainInput.value = $response.Biaya_lain;
          $biayaTurunanSPK.value = $response.NoSPK;
          $biayaTurunanTurunan.value = $response.Turunan; 
          // Display Modal
          $('#biayaTurunanModal').modal('show');
        }
      });
    }
  </script>

  


  

</body>



</html>