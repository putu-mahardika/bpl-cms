<?php
  session_save_path('../../tmp');
  session_start();
  if ($_SESSION['hak_akses'] == "" || $_SESSION['hak_akses'] != "Admin") {
    header("location:../../index.php?pesan=belum_login");
  }
  include '../../config/koneksi.php';
  date_default_timezone_set("Asia/Jakarta");

  $datetime = date('Y');
  $id = $_GET['id'];
  
  $queryShipment = "select * from trans_shipment where id='$id'";
  $fetchShipment = mysqli_query($koneksi,$queryShipment);
  $dataShipment = mysqli_fetch_array($fetchShipment);

  $shipmentId = $dataShipment['id'];
  $shipmentCustId = $dataShipment['CustId'];
  $shipmentTerm = $dataShipment['id_shipment_term'];
  $shipmentLoadType = $dataShipment['id_shipment_load_type'];
  $shipmentUnit = $dataShipment['unit'];
  $shipmentUser = $dataShipment['UserId'];
  $shipmentStatus = $dataShipment['id_status_shipment'];

  $queryMasterUser = "select * from master_user where UserId='$shipmentUser'";
  $fetchMasterUser = mysqli_query($koneksi, $queryMasterUser);
  $dataUser = mysqli_fetch_array($fetchMasterUser);

  $queryMasterCustomer = "select * from master_customer where aktif=1 and CustId='$shipmentCustId'";
  $fetchMasterCustomer = mysqli_query($koneksi, $queryMasterCustomer);
  $dataCustomer = mysqli_fetch_array($fetchMasterCustomer);
  // echo $dataCustomer['nama'];

  $queryMasterShipmentTerms = "select * from master_shipment_terms where aktif=1 and id='$shipmentTerm' order by atr1";
  $fetchMasterShipmentTerms = mysqli_query($koneksi, $queryMasterShipmentTerms);
  $dataShipmentTerms = mysqli_fetch_array($fetchMasterShipmentTerms);

  $queryMasterLoadType = "select * from master_load_type where aktif=1 and id='$shipmentLoadType'";
  $fetchMasterLoadType = mysqli_query($koneksi, $queryMasterLoadType);
  $dataLoadType = mysqli_fetch_array($fetchMasterLoadType);

  $queryMasterUnit = "select * from master_unit where aktif=1 and id='$shipmentUnit' order by atr1";
  $fetchMasterUnit = mysqli_query($koneksi, $queryMasterUnit);
  $dataUnit = mysqli_fetch_array($fetchMasterUnit);

  // $queryTransHd = "select * from trans_hd where id_shipment='$shipmentId'";
  $queryTransHd = "SELECT 
      th.*,
      ts.shipment_order,
      ts.pib 
    from 
      trans_hd th,
      trans_shipment ts 
    where  
      th.id_shipment = ts.id and 
      th.id_shipment = '$shipmentId'";
  $fetchTransHd = mysqli_query($koneksi, $queryTransHd);
  // $dataTranshd = mysqli_fetch_array($fetchTransHd);
  $dataTransHd = array();
  while ($data = mysqli_fetch_array($fetchTransHd)) {
    $dataTransHd[] = $data;
  }

  $queryShipmentHandling = "select * from trans_shipment_handling where id_shipment='$id'";
  $fetchShipmentHandling = mysqli_query($koneksi,$queryShipmentHandling);
  // $dataShipmentHandling = mysqli_fetch_array($fetchShipmentHandling);
  $dataShipmentHandling = array();
  while ($data = mysqli_fetch_array($fetchShipmentHandling)) {
    $dataShipmentHandling[] = array(
      'id' => $data['id'],
      'id_shipment' => $data['id_shipment'],
      'create_date' => $data['create_date'],
      'handling_turunan' => $data['handling_turunan'],
      'keterangan_biaya' => $data['keterangan_biaya'],
      'qty' => $data['qty'],
      'nominal_satuan' => $data['nominal_satuan'],
      'nominal' => $data['nominal'] 
    );
  }

  $totalHandling = array_sum(array_column($dataShipmentHandling, 'nominal'));

  $queryCountOpenTrucking = "select count(*) as total from trans_hd th where atr1=0 and OnClose=0 and id_shipment='$id'";
  $fetchCountOpenTrucking = mysqli_query($koneksi, $queryCountOpenTrucking);
  $countOpenTrucking = mysqli_fetch_array($fetchCountOpenTrucking);
  // print_r($countOpenTrucking);

  $queryMasterShipmentStatus = "select * from master_status_shipment where aktif=1 order by atr1";
  $fetchMasterShipmentStatus = mysqli_query($koneksi, $queryMasterShipmentStatus);
  // $dataMasterShipmentStatus = mysqli_fetch_array($fetchMasterShipmentStatus);

  $querySpecificMasterShipmentStatus = "select * from master_status_shipment where id='$shipmentStatus'";
  $fetchSpesificMasterShipmentStatus = mysqli_query($koneksi, $querySpecificMasterShipmentStatus);
  $dataSpesificMasterShipmentStatus = mysqli_fetch_array($fetchSpesificMasterShipmentStatus);
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
  <title>Detail Shipment - PT Berkah Permata Logistik</title>
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../../css/ruang-admin.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/style.css">
  <style>
.dropdown-submenu {
  position: relative;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
}

@media (max-width: 991px) {
    .dropdown-shipment .dropdown-submenu .dropdown-menu {
        left: -100% !important;
    }
}
</style>
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
      <li class="nav-item">
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
            <!--<a class="collapse-item" href="buttons.html">Buttons</a>
            <a class="collapse-item" href="dropdowns.html">Dropdowns</a>
            <a class="collapse-item" href="modals.html">Modals</a>
            <a class="collapse-item" href="popovers.html">Popovers</a>
            <a class="collapse-item" href="progress-bar.html">Progress Bars</a>-->
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
            <!--<a class="collapse-item" href="form_advanceds.html">Form Advanceds</a>-->
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
            <a class="collapse-item" href="statusShipment.php">Status Shipment</a>
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
      <!--<li class="nav-item">
        <a class="nav-link" href="ui-colors.html">
          <i class="fas fa-fw fa-palette"></i>
          <span>UI Colors</span>
        </a>
      </li>-->
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Transaksi
      </div>
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
        <div id="collapseUnit" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
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
      <!--<li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"
          aria-controls="collapsePage">
          <i class="fas fa-fw fa-columns"></i>
          <span>Pages</span>
        </a>
        <div id="collapsePage" class="collapse show" aria-labelledby="headingPage" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Example Pages</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item active" href="blank.html">Blank Page</a>
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
	  <li class="nav-item">
        
        <a class="nav-link" type="button" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span>
        </a>
      </li>
      <!--<div class="version" id="version-ruangadmin"></div>-->
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
          <div class="d-md-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center justify-content-start">
              <a href="shipment.php?tahun=<?php echo $datetime ?>" style="margin-right:20px;"><i class="far fa-arrow-alt-circle-left fa-2x" title="kembali"></i></a>
              <h1 class="h3 mb-0 text-gray-800">Detail Shipment</h1>
            </div>
            <div>
              <p class="text-right mb-0">Last Edit</p>
              <p class="text-right mb-0" style="color: black;"><strong><?php echo $dataUser['nama']?></strong></p>
            </div>
          </div>
          <?php if(isset($_SESSION['pesan'])){?><?php echo $_SESSION['pesan']; unset($_SESSION['pesan']);}?>
          
          <div class="row">
            <div class="col-md-12 col-lg-3">
              <div class="card mb-4">
                <div class="card-body">
                  <div>
                    <div class="d-flex justify-content-between">
                      <div class="" style="color:black;font-size:18px;word-wrap: break-word;width:90%;">
                        <?php echo $dataShipment['shipment_order'] ?>
                      </div>
                      <div class="dropdown dropdown-shipment">
                        <div class="" id="dropdown-shipment" style="color: black;cursor:pointer;" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></div>
                        <!-- <span class="caret"></span></button> -->
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item" tabindex="-1" href="editShipment.php?id=<?php echo $shipmentId?>" style="cursor: pointer;color:black;">
                              <i class="fas fa-edit fa-sm fa-fw mr-2"></i>
                              Edit
                            </a>
                          </li>
                          <li class="dropdown-submenu">
                            <?php if ($shipmentStatus != 3) { ?>
                              <a class="test dropdown-item" style="cursor: pointer;color:black;" tabindex="-1" href="">
                                <i class="fas fa-list fa-sm fa-fw mr-2"></i>
                                Ubah Status
                              </a>
                              <ul class="dropdown-menu" id="statusShipmentMenu">
                                <?php while ($data = mysqli_fetch_array($fetchMasterShipmentStatus)) { ?>
                                  <?php 
                                    if ($data['id'] == 3) {
                                      if ($countOpenTrucking['total'] != 0) { ?>
                                        <li>
                                          <p class="dropdown-item mb-0" style="cursor: pointer;color:black;" data-toggle="modal" data-target="#alertCloseShipmentModal">
                                            <?php echo $data['nama']?>
                                          </p>
                                        </li>
                                      <?php } else { ?>
                                        <li>
                                          <p class="dropdown-item mb-0" style="cursor: pointer;color:black;" data-toggle="modal" data-target="#alertAllowCloseShipmentModal">
                                            <?php echo $data['nama']?>
                                          </p>
                                        </li>
                                    <?php  }
                                    } else { ?>
                                      <li>
                                        <p class="dropdown-item mb-0" style="cursor: pointer;color:black;" onclick="changeStatusAct(<?php echo $data['id'] ?>)">
                                          <?php echo $data['nama']?>
                                        </p>
                                      </li>
                                  <?php }
                                  ?>
                                  <!-- <li>
                                    <p class="dropdown-item mb-0" style="cursor: pointer;" onclick="changeStatusAct(<?php echo $data['id'] ?>)">
                                      <?php echo $data['nama']?>
                                    </p>
                                  </li> -->
                                <?php } ?>
                              </ul>
                            <?php } ?>
                          </li>
                          <li>
                            <?php if ($shipmentStatus == 2) { ?>
                              <p class="dropdown-item mb-0" style="cursor: pointer;color:red;" data-toggle="modal" data-target="#alertDeleteShipmentModal">
                                <i class="fas fa-trash-alt fa-sm fa-fw mr-2"></i>
                                Hapus / Drop
                              </p>
                            <?php } else { ?>
                              <p class="dropdown-item mb-0" style="cursor: pointer;color:red;" data-toggle="modal" data-target="#alertAllowDeleteShipmentModal">
                                <i class="fas fa-trash-alt fa-sm fa-fw mr-2"></i>
                                Hapus / Drop
                              </p>
                            <?php } ?>
                            <!-- <p class="dropdown-item" tabindex="-1" >
                              <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                              Hapus / Drop
                            </p> -->
                          </li>
                        </ul>
                      </div>
                      <!-- <div>
                        <p class="" style="color: black;"><i class="fa fa-ellipsis-v"></i></p>
                        <ul class="dropdown-menu dropdown-menu-right shadow animated--grow-in shipment-dropdown" aria-labelledby="userDropdown">
                          <li>
                            <a class="dropdown-item" href="editPassword.php">
                              <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                              Ubah Password
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="#">
                              <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                              Ubah Password
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                              <li>
                                <a class="dropdown-item" href="editPassword.php">
                                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                  Ubah Password
                                </a>
                              </li>
                              <li>
                                <a class="dropdown-item" href="editPassword.php">
                                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                  Ubah Password
                                </a>
                              </li>
                              <li>
                                <a class="dropdown-item" href="editPassword.php">
                                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                  Ubah Password
                                </a>
                              </li>
                            </ul>
                          </li>
                          <li>
                            <a class="dropdown-item" href="editPassword.php">
                              <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                              Ubah Password
                            </a>
                          </li>
                        </ul>
                      </div> -->
                    </div>
                    <p><?php echo $dataCustomer['nama']?></p>
                    <?php if ($shipmentStatus == 2) { ?>
                      <span class="badge badge-warning"><?php echo $dataSpesificMasterShipmentStatus['nama']?></span>
                    <?php } elseif ($shipmentStatus == 3) { ?>
                      <span class="badge badge-success"><?php echo $dataSpesificMasterShipmentStatus['nama']?></span>
                    <?php } elseif ($shipmentStatus == 1) { ?>
                      <span class="badge badge-primary"><?php echo $dataSpesificMasterShipmentStatus['nama']?></span>
                    <?php } else {?>
                      <span class="badge badge-primary"><?php echo $dataSpesificMasterShipmentStatus['nama']?></span>
                    <?php } ?>

                  </div>
                  <hr class="sidebar-divider">
                  <div>
                    <p class="" style="color: black;"><strong>Informasi Shipment</strong></p>
                    <div>
                      <p class="mb-0">No. PIB</p>
                      <p class="" style="color: black;"><strong><?php echo $dataShipment['pib'] ?></strong></p>
                    </div>
                    <div>
                      <p class="mb-0">No. BL</p>
                      <p class="" style="color: black;"><strong><?php echo $dataShipment['bl'] ?></strong></p>
                    </div>
                    <div>
                      <p class="mb-0">User</p>
                      <p class="" style="color: black;"><strong><?php echo $dataUser['nama']?></strong></p>
                    </div>
                  </div>

                  <hr class="sidebar-divider">
                  <div>
                    <p class="" style="color: black;"><strong>Informasi Muatan</strong></p>
                    <div>
                      <p class="mb-0">Shipment Term</p>
                      <p class="" style="color: black;"><strong><?php echo $dataShipmentTerms['nama'] ?></strong></p>
                    </div>
                    <div>
                      <p class="mb-0">Shipment Load Type</p>
                      <p class="" style="color: black;"><strong><?php echo $dataLoadType['nama'] ?></strong></p>
                    </div>
                    <div>
                      <p class="mb-0">QTY & Unit</p>
                      <p class="" style="color: black;"><strong><?php echo $dataShipment['quantity'] ." ". $dataUnit['nama'] ?></strong></p>
                    </div>
                  </div>

                  <hr class="sidebar-divider">
                  <div>
                    <p class="" style="color: black;"><strong>Informasi Biaya</strong></p>
                    <div>
                      <p class="mb-0">Biaya Freight</p>
                      <p class="" style="color: black;"><strong><?php echo "US$ ".number_format($dataShipment['freight'],2,",",".")?></strong></p>
                    </div>
                    <div>
                      <p class="mb-0">Kurs Saat Pengiriman</p>
                      <p class="" style="color: black;"><strong><?php echo "Rp ".number_format($dataShipment['nilai_kurs'],2,",",".")." (".date("d F Y", strtotime($dataShipment['kurs_date'])).")"?></strong></p>
                    </div>
                    <div>
                      <p class="mb-0">Total Biaya Freight (IDR)</p>
                      <p class="text-primary"><strong><?php echo "Rp ".number_format($dataShipment['total_freight'],2,",",".") ?></strong></p>
                    </div>
                  </div> 

                  <hr class="sidebar-divider">
                  <div>
                    <p class="" style="color: black;"><strong>Informasi Biaya Handling</strong></p>

                    <?php if (count($dataShipmentHandling) < 1) { ?>
                      <?php for ($i=0; $i < 2; $i++) { ?>
                        <?php if ($i==0) { ?>
                          <p class="mb-0">-</p>
                          <p class="" style="color: black;"><strong><?php echo "Rp 0" ?> </strong></p>
                        <?php } else { ?>
                          <p class="mb-0">-</p>
                          <p class="" style="color: black;"><strong><?php echo "Rp 0"?> </strong></p>
                        <?php } ?>
                      <?php } ?>

                    <?php } elseif (count($dataShipmentHandling) < 2 && count($dataShipmentHandling) == 1) {?>
                      <?php for ($i=0; $i < 2; $i++) { ?>
                        <?php if ($i==0) { ?>
                          <?php foreach ($dataShipmentHandling as $datas) { ?>
                            <?php if ($datas['handling_turunan'] == $i+1) { ?>
                              <p class="mb-0"><?php echo $datas['keterangan_biaya']; ?></p>
                              <p class="" style="color: black;"><strong><?php echo "Rp ".number_format($datas['nominal'],2,",",".")?> </strong></p>
                            <?php } else { ?>
                              <p class="mb-0">-</p>
                              <p class="" style="color: black;"><strong><?php echo "Rp 0" ?> </strong></p>
                            <?php } ?>
                          <?php } ?>

                        <?php } else { ?>
                          <?php foreach ($dataShipmentHandling as $datas) { ?>
                            <?php if ($datas['handling_turunan'] == $i+1) { ?>
                              <p class="mb-0"><?php echo $datas['keterangan_biaya']; ?></p>
                              <p class="" style="color: black;"><strong><?php echo "Rp ".number_format($datas['nominal'],2,",",".")?> </strong></p>
                            <?php } else { ?>
                              <p class="mb-0">-</p>
                              <p class="" style="color: black;"><strong><?php echo "Rp 0" ?> </strong></p>
                            <?php } ?>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>

                    <?php } else { ?>
                      <?php for ($i=0; $i < count($dataShipmentHandling); $i++) { ?>
                        <?php if ($i == 0) { ?>
                          <?php foreach ($dataShipmentHandling as $index => $datas) {?>
                            <?php if ($datas['handling_turunan'] == 1) { ?>
                              <p class="mb-0"><?php echo $datas['keterangan_biaya']; ?></p>
                              <p class="" style="color: black;"><strong><?php echo "Rp ".number_format($datas['nominal'],2,",",".")?> </strong></p>
                            <?php } ?>
                          <?php } ?>
                        <?php } else { ?>
                          <?php foreach ($dataShipmentHandling as $index => $datas) {?>
                            <?php if ($datas['handling_turunan'] == 2) { ?>
                              <p class="mb-0"><?php echo $datas['keterangan_biaya']; ?></p>
                              <p class="" style="color: black;"><strong><?php echo "Rp ".number_format($datas['nominal'],2,",",".")?> </strong></p>
                            <?php } ?>
                          <?php } ?>
                        <?php } ?>

                      <?php } ?>

                    <?php } ?>

                    <div>
                      <p class="mb-0">Total Handling</p>
                      <p class="text-primary"><strong><?php echo "Rp ".number_format($totalHandling,2,",",".")?></strong></p>
                    </div>
                  </div> 
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-9">
              <div class="card mb-4">
                <div class="card-body">
                  <div>
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <div class="mr-2" style="color: black;"><strong>Trucking Order</strong></div>
                        <div class="px-1 rounded" style="background-color: #EAEAEA;color:black;"><?php echo count($dataTransHd) ?></div>
                      </div>
                      <div>
                      <?php if ($shipmentStatus != 2) { ?>
                        <button class="btn btn-primary btn-icon-split" disabled="disabled">
                          <span class="icon text-white-50">
                              <i class="fas fa-plus"></i>
                            </span>
                          <span class="text">Tambah Order Trucking</span>
                        </button>
                      <?php } else {?>
                        <a style="color: white;" class="btn btn-primary btn-icon-split" type="button" data-toggle="modal" data-target="#generateTruckingModal">
                          <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                          </span>
                          <span class="text">Tambah Order Trucking</span>
                        </a>
                      <?php } ?>
                      </div>
                    </div>
                    <?php if (count($dataTransHd) == 0) { ?>
                      <div class="text-center">
                        <img src="../../img/list-grey.png" alt="list-grey">
                        <p>You can add trucking order after shipment status is Delivering</p>
                      </div>

                      <?php } else { ?>
                    
                        <div class="table-responsive p-3">
                          <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                            <thead class="thead-light">
                              <tr>
                                <th>Kode Shipment</th>
                                <th>PIB</th>
                                <th>No. PO</th>
                                <th>Tgl</th>
                                <th>No. SPK</th>
                                <th>Kota Asal</th>
                                <th>Kota Tujuan</th>
                                <th>Jumlah Armada</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($dataTransHd as $id=>$data) {?>
                                <tr>
                                  <td><?php echo $data['shipment_order'] ?></td>
                                  <td><?php echo $data['pib'] ?></td>
                                  <td><?php echo $data['NoPO'] ?? '-' ?></td>
                                  <td><?php echo date('d-M-Y H:i:s', strtotime($data['create_date'])) ?? '-' ?></td>
                                  <td><?php echo $data['NoSPK'] ?? '-' ?></td>

                                  <?php
                                    $query_k_temp = "select Nama from master_kota where Id='$data[kota_kirim_id]'";
                                    $fetch_k_temp = mysqli_query($koneksi, $query_k_temp);
                                    $data_k_temp = mysqli_fetch_array($fetch_k_temp);
                                  ?>
                                  <td><?php echo $data_k_temp['Nama'] ?? '-' ?></td>
                                  
                                  <?php
                                    $query_k1_temp = "select Nama from master_kota where Id='$data[kota_tujuan_id]'";
                                    $fetch_k1_temp = mysqli_query($koneksi, $query_k1_temp);
                                    $data_k1_temp = mysqli_fetch_array($fetch_k1_temp);
                                  ?>
                                  <td style="font-size:13px;padding-left:16px;"><?php echo $data_k1_temp['Nama'] ?? '-' ?></td>

                                  <td><?php echo $data['total_armada'] ?? '-' ?></td>
                                  <?php 
                                    if($data['OnClose'] == 1){
                                  ?>
                                    <td style="padding-left:16px;"><span class="badge badge-success">Close</span></td>
                                  <?php } else{ ?>
                                    <td style="padding-left:16px;"><span class="badge badge-info">Open</span></td>
                                  <?php } ?>
                                  <td>
                                  <a title="edit" href="editTransaksi.php?id=<?php echo $data['HdId']?>" class="btn btn-sm btn-warning" style="margin-bottom:0.25rem; width:33px;"><i class="fas fa-edit"></i></a>
                                  <button title="detail" onclick="transinfo(<?php echo $data['HdId']?>)" class="btn btn-info btn-sm" style="margin-bottom:0.25rem;width:33px;"><i class="fas fa-search"></i></button>
                                  </td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>

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

          <!-- Generate Trucking Modal -->
          <div class="modal fade" id="generateTruckingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelGenerateTrucking" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelGenerateTrucking">Order Trucking</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="../../config/controller/shipmentController.php" method="post">
                  <div class="modal-body">
                    <!-- <p>Jumlah Order Trucking</p> -->
                    <label for="generateTrucking">Jumlah Order Trucking :</label>
                    <input type="hidden" name="id" value="<?php echo $shipmentId ?>">
				            <input type="number" id="generateTrucking" class="form-control form-control-sm mb-3" name="count" min="1" value="0" >
                  </div>
                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button> -->
                    <input type="submit" value="Submit" name="inputGenerateTrucking" class="btn btn-primary">
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal Detail -->
          <div class="modal fade bd-example-modal-xl" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Detail Transaksi</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body detail-body">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Alert Close Shipment -->
          <div class="modal fade bd-example-modal-xl" id="alertCloseShipmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Peringatan !</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Terdapat Transaksi Trucking dengan status <b>OPEN</b>. Anda hanya bisa menutup Shipment ketika semua transaksi Trucking sudah dalam status <b>CLOSE</b>.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Alert Allow Close Shipment -->
          <div class="modal fade bd-example-modal-xl" id="alertAllowCloseShipmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Close Shipment</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="../../config/controller/shipmentController.php" method="post">
                  <div class="modal-body">
                    <p>Anda akan melakukan Close Shipment. Silahkan masukkan kurs terbaru sebelum melanjutkan proses.</p>
                    <label for="lastKurs">Kurs saat ini :</label>
                    <input type="hidden" name="id" value="<?php echo $shipmentId ?>">
				            <input type="number" id="lastKurs" class="form-control form-control-sm mb-3" name="lastKurs" min="1" value="0" >
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                    <input type="submit" value="Submit" name="inputLastKursShipment" class="btn btn-primary">
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal Alert Delete Shipment -->
          <div class="modal fade bd-example-modal-xl" id="alertDeleteShipmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Peringatan !</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Shipment masih dalam status <b>DELIVERING</b>. Silahkan ubah status Shipment terlebih dahulu.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Alert Delete Shipment -->
          <div class="modal fade bd-example-modal-xl" id="alertAllowDeleteShipmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Hapus / Drop Shipment !</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="../../config/controller/shipmentController.php" method="post">
                  <div class="modal-body">
                    <p>Apakah anda ingin menghapus/drop Shipment ?</p>
                    <input type="hidden" name="id" value="<?php echo $shipmentId ?>">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tidak</button>
                    <input type="submit" value="Ya" name="dropShipment" class="btn btn-primary">
                  </div>
                </form>
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

  <script>
  $(document).ready(function(){
    $('.dropdown-submenu a.test').on("click", function(e){
      $(this).next('ul').toggle();
      e.stopPropagation();
      e.preventDefault();
    });

    $('#dropdown-shipment').on('click', function() {
      $('#statusShipmentMenu').css({display: 'none'});
    })
  });

  function changeStatusAct(statusId){
    console.log('xxx');
    // var custid = $(this).data('id');
    var shipmentId = <?php echo $shipmentId ?>

    // AJAX request\
    $.ajax({
      url: '../../config/controller/shipmentController.php',
      type: 'post',
      data: {
        changeStatusShipment: true,
        id: shipmentId,
        statusId: statusId
      },
      success: function(response){
        location.reload();
        // // Add response in Modal body
        // $('.modal-body').html(response);
        // // Display Modal
        // $('#detailModal').modal('show');
      }
    });
  };
  </script>

  <script>
    function transinfo(id){
      var hdid = id;
      // AJAX request\
      $.ajax({
        url: '../../config/viewTransaksi.php',
        type: 'post',
        data: {hdid: hdid},
        success: function(response){
          // Add response in Modal body
          $('.detail-body').html(response);
          // Display Modal
          $('#detailModal').modal('show');
        }
      });
    }
  </script>

</body>

</html>