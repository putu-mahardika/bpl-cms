<?php
  session_save_path('../../tmp');

  session_start();

  if ($_SESSION['hak_akses'] == "" || $_SESSION['hak_akses'] != "User") {

    header("location:../../index.php?pesan=belum_login");

  }

  include '../../config/koneksi.php';
  date_default_timezone_set("Asia/Jakarta");

  $datetime = date('Y');

	$query = 'select * from master_customer';

	$fetch = mysqli_query($koneksi,$query);


  $query_k = "select * from master_kota where aktif = 1";
  $fetch_k = mysqli_query($koneksi, $query_k);
  $fetch_k1 = mysqli_query($koneksi, $query_k);

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

  <link href="../../vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">

  <link href="../../css/ruang-admin.min.css" rel="stylesheet">

</head>



<body id="page-top">

  <div id="wrapper">

    <!-- Sidebar -->

    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">

      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php?tahun=<?php echo $datetime?>">

        <div class="sidebar-brand-icon">

          <img src="../../img/logo-BPL-white-min.png" style="height:130px;">

        </div>

        
      </a>

      <hr class="sidebar-divider my-0">

      <li class="nav-item active">

        <a class="nav-link" href="dashboard.php?tahun=<?php echo $datetime?>">

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

      <!--<hr class="sidebar-divider">

      <div class="sidebar-heading">

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

      </li>-->

      <!--<li class="nav-item">

        <a class="nav-link" href="ui-colors.html">

          <i class="fas fa-fw fa-palette"></i>

          <span>UI Colors</span>

        </a>

      </li>-->

      <hr class="sidebar-divider">

      <div class="sidebar-heading">

        TRANSAKSI

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

          <a href="transaksi.php?tahun=<?php echo $datetime?>" style="margin-right:20px;"><i class="far fa-arrow-alt-circle-left fa-2x" title="kembali"></i></a>

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

            <div class="col-xl-12 col-lg-11">

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
                <?php if(isset($_SESSION['id_pesan1'])){
                    //echo $_SESSION['id_pesan1'][1];
                    $save = $_SESSION['id_pesan1'];
                ?>
                <div class="card-body">
                <?php if(isset($_SESSION['pesan'])){?><?php echo $_SESSION['pesan']; unset($_SESSION['pesan']);}?>
                  <form role="form" method="post" action="../../config/process.php">
                    <div class="form-group">
                      <label>Customer :</label>
                      <select class="select2-single-placeholder form-control" name="customer" id="customer" required>
                      <option value="" disabled>Pilih</option>
                      <?php
                        while($data = mysqli_fetch_array($fetch)){
							            if($data['aktif']==1){
                            if($data['CustId'] == $save[0]){
                      ?>
                      <option value="<?php echo $data['CustId'];?>" selected><?php echo $data['nama'];?></option>
                          <?php }else{?>
                      <option value="<?php echo $data['CustId'];?>"><?php echo $data['nama'];?></option>
                        <?php } } else {
                          continue;
                          }
                        }
                      ?>
                      </select>
                    </div>	
                    <div class="row" style="height: 70px;">
                      <div class="form-group col-sm-7">
                        <label>No. PO Customer :</label>
                        <input type="text" class="form-control form-control-sm mb-3" name="nopo" id="nopo" value="<?php echo $save[1]?>" required>
                      </div>
                      <div class="form-group col-sm-5" id="simple-date1">
                        <label>Tgl PO :</label>
                        <div class="input-group input-group-sm mb-3 date">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                          </div>
                          <input type="text" class="form-control" id="simpleDataInput" name="tglpo" id="tglpo" value="<?php echo $save[2]?>" required>
                          </div>
                      </div>
                    </div>
                    <div class="row" style="height: 70px;">
                      <div class="form-group col-sm-7">
                        <label>No. SPK :</label>
                        <input type="text" class="form-control form-control-sm mb-3" name="nospk" id="nospk" value="<?php echo $save[3]?>" required>
                      </div>
                      <div class="form-group col-sm-5" id="simple-date1">
                        <label>Tgl SPK :</label>
                        <div class="input-group input-group-sm mb-3 date">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                          </div>
                          <input type="text" class="form-control" id="simpleDataInput" name="tglspk" id="tglspk" value="<?php echo $save[4]?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="height: 70px;">
                      <div class="form-group col-sm-4">
                        <label>Jumlah Armada :</label>
                        <input type="number" min="1" class="form-control form-control-sm mb-3" name="armada" id="armada" value="<?php echo $save[5]?>" required>
                      </div>
                      <div class="form-group col-sm-3">

                      </div>
                      <div class="form-group col-sm-5">
                        <label>Status Pengiriman :</label>
                        <input type="text" class="form-control form-control-sm mb-3" name="status" value="OPEN" readonly>
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
                              <option value="" disabled>Pilih</option>
                              <?php
                                while($dataKotaAsal = mysqli_fetch_array($fetch_k)){
                                  // print_r($dataUser);
                                  if($dataKotaAsal['aktif']==1){
                              ?>
                              <option value="<?php echo $dataKotaAsal['Id'];?>"><?php echo $dataKotaAsal['Kode'] . " - " . $dataKotaAsal['Nama'];?></option>
                              <?php
                                  }
                                }
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Detail Kota Asal :</label>  
                            <!-- <input type="text" class="form-control form-control-sm mb-3" value="" name="detailKotaAsal" id="detailKotaAsal"> -->
      					            <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaAsal" id="detailKotaAsal" required></textarea>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Kota Tujuan :</label>
                            <!-- <select class="select2-single-placeholder form-control" name="kotaTujuan" id="kotaTujuan" style="width:100% !important;" required>
                              <option value="<?php echo $c_custid?>" selected><?php echo $c_nama?></option>
                            </select> -->
                            <select class="select2-single-placeholder form-control" name="kotaTujuan" id="kotaTujuan" required>
                              <option value="" disabled>Pilih</option>
                              <?php
                                while($dataKotaTujuan = mysqli_fetch_array($fetch_k1)){
                                  // print_r($dataUser);
                                  if($dataKotaTujuan['aktif']==1){
                              ?>
                              <option value="<?php echo $dataKotaTujuan['Id'];?>"><?php echo $dataKotaTujuan['Kode'] . " - " . $dataKotaTujuan['Nama'];?></option>
                              <?php
                                  }
                                }
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Detail Kota Tujuan :</label>
                            <!-- <input type="text" class="form-control form-control-sm mb-3" value="<?php echo $t_tujuan ?>" name="detailKotaTujuan" id="detailKotaTujuan"> -->
      					            <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaTujuan" id="detailKotaTujuan" required></textarea>
                          </div>
                        </div>
                      <!-- <div class="form-group col-sm-4"> -->
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Barang :</label>
                      <textarea type="text" class="form-control form-control-sm mb-3" name="barang" id="barang"  required><?php echo $save[8]?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Keterangan :</label>
                      <textarea type="text" class="form-control form-control-sm mb-3" name="keterangan" id="keterangan" ><?php echo $save[9]?></textarea>
                    </div>
                    
                    <!--<select name="aktif" class="form-control form-control-sm mb-3" required>
                      <option disabled> Pilih </option>
                      <option value=1 selected> Ya </option>
                      <option value=0> Tidak </option>
                    </select>-->
                    <br>
                    <input type="reset" value="Reset" class="btn btn-danger " style="width:22%;">
                    <input type="submit" value="Submit" name="inputTransaksi" class="btn btn-md btn-primary " style="width:77%;">
                  </form>
                </div>

                <?php } else { ?>
                 
                <div class="card-body">
                <?php if(isset($_SESSION['pesan'])){?><?php echo $_SESSION['pesan']; unset($_SESSION['pesan']);}?>
                  <form role="form" method="post" action="../../config/process.php">
                    <div class="form-group">
                      <label>Customer :</label>
                      <select class="select2-single-placeholder form-control" name="customer" id="customer" required>
                      <option value="" disabled selected>Pilih</option>
                      <?php
                        while($data = mysqli_fetch_array($fetch)){
							            if($data['aktif']==1){
                      ?>
                      <option value="<?php echo $data['CustId'];?>"><?php echo $data['nama'];?></option>
                        <?php } else {
                        continue;
                        }
                      }
                      ?>
                      </select>
                    </div>	
                    <div class="row" style="height: 70px;">
                      <div class="form-group col-sm-7">
                        <label>No. PO Customer :</label>
                        <input type="text" class="form-control form-control-sm mb-3" name="nopo" id="nopo" required>
                      </div>
                      <div class="form-group col-sm-5" id="simple-date1">
                        <label>Tgl PO :</label>
                        <div class="input-group input-group-sm mb-3 date">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                          </div>
                          <input type="text" class="form-control" id="simpleDataInput" name="tglpo" id="tglpo" required>
                          </div>
                      </div>
                    </div>
                    <div class="row" style="height: 70px;">
                      <div class="form-group col-sm-7">
                        <label>No. SPK :</label>
                        <input type="text" class="form-control form-control-sm mb-3" name="nospk" id="nospk" required>
                      </div>
                      <div class="form-group col-sm-5" id="simple-date1">
                        <label>Tgl SPK :</label>
                        <div class="input-group input-group-sm mb-3 date">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                          </div>
                          <input type="text" class="form-control" id="simpleDataInput" name="tglspk" id="tglspk" required>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="height: 70px;">
                      <div class="form-group col-sm-4">
                        <label>Jumlah Armada :</label>
                        <input type="number" min="1" class="form-control form-control-sm mb-3" name="armada" id="armada" required>
                      </div>
                      <div class="form-group col-sm-3">

                      </div>
                      <div class="form-group col-sm-5">
                        <label>Status Pengiriman :</label>
                        <input type="text" class="form-control form-control-sm mb-3" name="status" value="OPEN" readonly>
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
                            <select class="select2-single-placeholder1 form-control" name="kotaAsal" id="kotaAsal" required>
                              <option value="" selected disabled>Pilih</option>
                              <?php
                                while($dataKotaAsal = mysqli_fetch_array($fetch_k)){
                                  // print_r($dataUser);
                                  if($dataKotaAsal['aktif']==1){
                              ?>
                              <option value="<?php echo $dataKotaAsal['Id'];?>"><?php echo $dataKotaAsal['Kode'] . " - " . $dataKotaAsal['Nama'];?></option>
                              <?php
                                  } else {
                                    continue;
                                  }
                                }
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Detail Kota Asal :</label>
                            <!-- <input type="text" class="form-control form-control-sm mb-3" value="" name="detailKotaAsal" id="detailKotaAsal"> -->
      					            <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaAsal" id="detailKotaAsal" required></textarea>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Kota Tujuan :</label>
                            <!-- <select class="select2-single-placeholder form-control" name="kotaTujuan" id="kotaTujuan" style="width:100% !important;" required>
                              <option value="<?php echo $c_custid?>" selected><?php echo $c_nama?></option>
                            </select> -->
                            <select class="select2-single-placeholder2 form-control" name="kotaTujuan" id="kotaTujuan" required>
                              <option value="" selected disabled>Pilih</option>
                              <?php
                                while($dataKotaTujuan = mysqli_fetch_array($fetch_k1)){
                                  // print_r($dataUser);
                                  if($dataKotaTujuan['aktif']==1){
                              ?>
                              <option value="<?php echo $dataKotaTujuan['Id'];?>"><?php echo $dataKotaTujuan['Kode'] . " - " . $dataKotaTujuan['Nama'];?></option>
                              <?php
                                  } else {
                                    continue;
                                  }
                                }
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Detail Kota Tujuan :</label>
                            <!-- <input type="text" class="form-control form-control-sm mb-3" value="<?php echo $t_tujuan ?>" name="detailKotaTujuan" id="detailKotaTujuan"> -->
      					            <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaTujuan" id="detailKotaTujuan" required></textarea>
                          </div>
                        </div>
                      <!-- <div class="form-group col-sm-4"> -->
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Barang :</label>
                      <textarea type="text" class="form-control form-control-sm mb-3" name="barang" id="barang" required></textarea>
                    </div>
                    <div class="form-group">
                      <label>Keterangan :</label>
                      <textarea type="text" class="form-control form-control-sm mb-3" name="keterangan" id="keterangan"></textarea>
                    </div>
                    
                    <!--<select name="aktif" class="form-control form-control-sm mb-3" required>
                      <option disabled> Pilih </option>
                      <option value=1 selected> Ya </option>
                      <option value=0> Tidak </option>
                    </select>-->
                    <br>
                    <input type="reset" value="Reset" class="btn btn-danger " style="width:22%;">
                    <input type="submit" value="Submit" name="inputTransaksi" class="btn btn-md btn-primary " style="width:77%;">
                  </form>
                </div>
                <?php }?>
              </div>
            </div>

            <!-- Pie Chart -->

          

            

            <!-- Message From Customer-->

            



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

    <script src="../../vendor/select2/dist/js/select2.min.js"></script>



  <script>

	$(document).ready(function () {
	  $('.select2-single').select2();

	  // Select2 Single  with Placeholder
    $('.select2-single-placeholder').select2({
  		placeholder: "Pilih",
	  	allowClear: true
	  });

    $('.select2-single-placeholder1').select2({
  		placeholder: "Pilih",
	  	allowClear: true
	  });

    $('.select2-single-placeholder2').select2({
  		placeholder: "Pilih",
	  	allowClear: true
	  });

	  $('#simple-date1 .input-group.date').datepicker({
      format: 'dd/mm/yyyy',
      todayBtn: 'linked',
      todayHighlight: true,
      autoclose: true,        
    });

    document.getElementById("cmtx_comment").value = localStorage.getItem("comment");
	});

  </script>

  

</body>



</html>