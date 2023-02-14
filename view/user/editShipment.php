<?php
  session_save_path('../../tmp');
  session_start();
  if ($_SESSION['hak_akses'] == "" || $_SESSION['hak_akses'] != "User") {
    header("location:../../index.php?pesan=belum_login");
  }
  include '../../config/koneksi.php';
  date_default_timezone_set("Asia/Jakarta");

  $datetime = date('Y');
  $id = $_GET['id'];
  $s_id = $_SESSION['id'];

  $queryMasterCustomer = 'select * from master_customer where aktif=1 and userId='.$s_id;
  $fetchMasterCustomer = mysqli_query($koneksi, $queryMasterCustomer);

  $queryMasterShipmentTerms = 'select * from master_shipment_terms where aktif=1 order by atr1 asc';
  $fetchMasterShipmentTerms = mysqli_query($koneksi, $queryMasterShipmentTerms);

  $queryMasterLoadType = 'select * from master_load_type where aktif=1 order by atr1 asc';
  $fetchMasterLoadType = mysqli_query($koneksi, $queryMasterLoadType);

  $queryMasterUnit = 'select * from master_unit where aktif=1 order by atr1 asc';
  $fetchMasterUnit = mysqli_query($koneksi, $queryMasterUnit);

  $queryShipment = "select * from trans_shipment where id='$id'";
  $fetchShipment = mysqli_query($koneksi,$queryShipment);
  $dataShipment = mysqli_fetch_array($fetchShipment);

  $shipmentId = $dataShipment['id'];
  $shipmentUser = $dataShipment['UserId'];
  $shipmentKursDate = is_null($dataShipment['kurs_date'])||$dataShipment['kurs_date'] == '' ? '' : date('d/m/Y', strtotime($dataShipment['kurs_date']));
  // print_r($dataShipment);
  // echo $shipmentId;

  $queryGetUserShipment = "select * from master_user where UserId=$shipmentUser";
  $fetchGetUserShipment = mysqli_query($koneksi, $queryGetUserShipment);
  $dataGetUserShipment = mysqli_fetch_array($fetchGetUserShipment);

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

  $totalHandling = array_sum(array_column($dataShipmentHandling, 'nominal'))

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
  <title>Tambah Shipment - PT Berkah Permata Logistik</title>
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../../vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <link href="../../vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="../../css/ruang-admin.min.css" rel="stylesheet">
  <style>
    .bg-lightGrey {
      background-color: #f1f1f1;
      color: black;
    }
  </style>
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
      <li class="nav-item">
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUnit" aria-expanded="true"
          aria-controls="collapseUnit">
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
          <div class="d-md-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center justify-content-start">
              <a href="shipment.php?tahun=<?php echo $datetime ?>" style="margin-right:20px;"><i class="far fa-arrow-alt-circle-left fa-2x" title="kembali"></i></a>
              <h1 class="h3 mb-0 text-gray-800">Edit Shipment</h1>
            </div>
            <div>
              <a style="font-weight: 600;" href="detailShipment.php?id=<?php echo $shipmentId ?>"> <i class="fas fa-search"></i> Lihat Detail</a>
            </div>
            <!--<ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item">Pages</li>
              <li class="breadcrumb-item active" aria-current="page">Blank Page</li>
            </ol>-->
          </div>

          <div class="col-xl-12">
            <div class="card mb-4">
              <div class="card-body">
                <?php if(isset($_SESSION['pesan'])){?><?php echo $_SESSION['pesan']; unset($_SESSION['pesan']);}?>
                <form class="form group" id="shipmentForm" method="post" action="../../config/controller/shipmentController.php">
                  <input type="hidden" name="shipmentId" value="<?php echo $shipmentId ?>">
                  <div class="col-12">
                    <div class="d-md-flex align-items-center justify-content-between mb-3">
                      <h5 class="font-weight-bold">Informasi Shipment</h5>
                      <div>
                        <span class="font-weight-bold">User :</span> <?php echo $dataGetUserShipment['nama'] ?>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12 col-lg-6">
                      <label for="customer">Customer</label>
                      <select id="customer" class="select2-single-placeholder form-control form-control-sm" name="customer" readonly>
                        <option value="" disabled>Pilih</option>
                        <?php
                          while($data = mysqli_fetch_array($fetchMasterCustomer)){
                            if($data['aktif']==1){
                              if($data['CustId'] == $dataShipment['CustId']){
                        ?>
                        <option value="<?php echo $data['CustId'];?>" selected><?php echo $data['nama'];?></option>
                          <?php } } else {
                            continue;
                            }
                          }
                        ?>
                      </select>
                      </div>
                      <div class="form-group col-md-12 col-lg-6">
                        <label for="kodeShipment">Kode Shipment</label>
                        <input type="text" class="form-control form-control-sm" id="kodeShipment" name="kodeShipment" minlength="3" maxlength="50" value="<?php echo $dataShipment['shipment_order']?>" required>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12 col-lg-6">
                      <label for="pib">Pemberitahuan Impor Barang (PIB)</label>
                      <input type="text" class="form-control form-control-sm" id="pib" name="pib" minlength="3" maxlength="50" value="<?php echo $dataShipment['pib']?>" required>
                      </div>
                      <div class="form-group col-md-12 col-lg-6">
                        <label for="billLanding">Bill of Landing (BL)</label>
                        <input type="text" class="form-control form-control-sm" id="billLanding" minlength="3" maxlength="50" name="billLanding" value="<?php echo $dataShipment['bl']?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <h5 class="font-weight-bold">Informasi Muatan</h5>
                    <div class="form-row">
                      <div class="form-group col-md-12 col-lg-6">
                        <label for="shipmentTerm">Shipment Term</label>
                        <select id="shipmentTerm" class="select2-single-placeholder1 form-control form-control-sm" name="shipmentTerm" required>
                          <option value="" disabled>Pilih</option>
                          <?php
                            while($data = mysqli_fetch_array($fetchMasterShipmentTerms)){
                              if($data['aktif']==1){
                                if($data['id'] == $dataShipment['id_shipment_term']){
                          ?>
                          <option value="<?php echo $data['id'];?>" selected><?php echo $data['kode'];?></option>
                              <?php }else{?>
                          <option value="<?php echo $data['id'];?>"><?php echo $data['kode'];?></option>
                            <?php } } else {
                              continue;
                              }
                            }
                          ?>
                        </select>
                      </div>
                      <div class="form-group col-md-12 col-lg-6">
                        <label for="ShipmentLoadType">Shipment Load Type</label>
                        <select id="ShipmentLoadType" class="select2-single-placeholder2 form-control form-control-sm" name="loadType" required>
                          <option value="" selected disabled>Pilih</option>
                          <?php
                            while($data = mysqli_fetch_array($fetchMasterLoadType)){
                              if($data['aktif']==1){
                                if($data['id'] == $dataShipment['id_shipment_load_type']){
                          ?>
                          <option value="<?php echo $data['id'];?>" selected><?php echo $data['nama'];?></option>
                              <?php }else{?>
                          <option value="<?php echo $data['id'];?>"><?php echo $data['nama'];?></option>
                            <?php } } else {
                              continue;
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12 col-lg-6">
                        <label for="qty">Quantity</label>
                        <input type="number" min=1 class="form-control form-control-sm" id="qty" name="qty" value="<?php echo $dataShipment['quantity'] ?>">
                        </div>
                      <div class="form-group col-md-12 col-lg-6">
                        <label for="unit">Unit</label>
                        <select id="unit" class="select2-single-placeholder3 form-control form-control-sm" name="unit" required>
                          <option value="" disabled>Pilih</option>
                          <?php
                            while($data = mysqli_fetch_array($fetchMasterUnit)){
                              if($data['aktif']==1){
                                if($data['id'] == $dataShipment['unit']){
                          ?>
                          <option value="<?php echo $data['id'];?>" selected><?php echo $data['nama'];?></option>
                              <?php }else{?>
                          <option value="<?php echo $data['id'];?>"><?php echo $data['nama'];?></option>
                            <?php } } else {
                              continue;
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <h5 class="font-weight-bold">Informasi Biaya</h5>
                    <div class="form-row">
                      <div class="form-group col-md-12 col-lg-6">
                        <label for="biayaFreight">Biaya Freight</label>
                        <div class="input-group input-group-sm mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">US$</span>
                          </div>
                          <input type="text" class="form-control" placeholder="0.00" onkeypress="return isNumberKey(event)" aria-label="biayaFreight" id="biayaFreight" name="biayaFreight" aria-describedby="basic-addon1" value="<?php echo $dataShipment['freight'] ?>">
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12 col-lg-6">
                          <label for="kurs">Kurs USD - IDR (saat ini)</label>
                          <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">IDR</span>
                            </div>
                            <input type="text" name="kurs" class="form-control" placeholder="0.00" aria-label="kurs" onkeypress="return isNumberKey(event)" id="kurs" aria-describedby="basic-addon1" value="<?php echo $dataShipment['nilai_kurs'] ?>">
                          </div>
                          </div>
                          <div class="form-group col-md-12 col-lg-6" id="simple-date1">
                            <label for="tglKurs">Tgl Kurs (saat ini)</label>
                            <div class="input-group input-group-sm mb-3 date">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                              </div>
                              <input type="text" class="form-control" name="tglKurs" id="tglKurs" value="<?php echo $shipmentKursDate ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 col-lg-6">
                        <div class="form-group col-12 py-3 rounded bg-lightGrey">
                          <h5 class="font-weight-bold">Total Biaya Freight</h5>
                          <h5 class="font-weight-bold">(dengan kurs)</h5>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="mb-0 text-primary">
                              IDR <span style="font-size: 36px;font-weight:700;" id="countBiayaFreight"><?php echo $dataShipment['total_freight'] ?></span>
                            </div>
                            <div>
                            <button type="button" class="btn btn-primary" id="actionCountBiayaFreight"><i class="fas fa-redo-alt"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-12 mb-5">
                    <h5 class="font-weight-bold">Informasi Biaya Handling</h5>
                    <div class="form-row">
                      <div class="form-group col-md-12 col-lg-6">
                        <div class="listBiayaHandling" id="listBiayaHandling">
                          <?php if (count($dataShipmentHandling) < 1) { ?>
                            <?php for ($i=0; $i < 2; $i++) { ?>
                              <?php if ($i==0) { ?>
                                <div class="form-row" id="parentInputBiayaHandling">
                                  <input type="hidden" id="biayaHandlingId" name="biayaHandlingId[]" value="">
                                  <div class="form-group col-md-12 col-lg-5 mb-0">
                                    <label>Nama Biaya Handling 1</label>
                                    <input type="text" class="form-control form-control-sm" id="parentNameInputBiayaHandling" name="namaBiayaHandling[]" minlength="3" maxlength="50" value="">
                                  </div>
                                  <div class="form-group col-md-6 col-lg-2 mb-0">
                                    <label>Qty</label>
                                    <input type="number" class="form-control form-control-sm qtyBiayaHandling" name="qtyBiayaHandling[]" min="0" placeholder="0" value="">
                                  </div>
                                  <div class="form-group col-md-6 col-lg-5 mb-0">
                                    <label>Biaya</label>
                                    <div class="input-group input-group-sm mb-3">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">IDR</span>
                                      </div>
                                      <input type="number" class="form-control inputBiayaHandling" id="parentCostInputBiayaHandling" min="0" onkeypress="return isNumberKey(event)" placeholder="0.00" name="biayaHandling[]" value="">
                                    </div>
                                  </div>
                                </div>
                              <?php } else { ?>
                                <div class="form-row">
                                  <input type="hidden" name="biayaHandlingId[]" value="<?php echo $datas['id']?>">
                                  <div class="form-group col-md-12 col-lg-5 mb-0">
                                    <label>Nama Biaya Handling Next</label>
                                    <input type="text" class="form-control form-control-sm" name="namaBiayaHandling[]" minlength="3" maxlength="50" value="">
                                  </div>
                                  <div class="form-group col-md-6 col-lg-2 mb-0">
                                    <label>Qty</label>
                                    <input type="number" class="form-control form-control-sm qtyBiayaHandling" name="qtyBiayaHandling[]" min="0" placeholder="0" value="">
                                  </div>
                                  <div class="form-group col-md-6 col-lg-5 mb-0">
                                    <label>Biaya</label>
                                    <div class="input-group input-group-sm mb-3">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">IDR</span>
                                      </div>
                                      <input type="number" class="form-control inputBiayaHandling" min="0" onkeypress="return isNumberKey(event)" placeholder="0.00" name="biayaHandling[]" value="">
                                    </div>
                                  </div>
                                </div>
                              <?php } ?>
                            <?php } ?>

                          <?php } elseif (count($dataShipmentHandling) < 2 && count($dataShipmentHandling) == 1) {?>
                            <?php for ($i=0; $i < 2; $i++) { ?>
                              <?php if ($i==0) { ?>
                                <?php foreach ($dataShipmentHandling as $datas) { ?>
                                  <?php if ($datas['handling_turunan'] == $i+1) { ?>
                                    <div class="form-row" id="parentInputBiayaHandling">
                                      <input type="hidden" id="biayaHandlingId" name="biayaHandlingId[]" value="<?php echo $datas['id']?>">
                                      <div class="form-group col-md-12 col-lg-5 mb-0">
                                        <label>Nama Biaya Handling 1</label>
                                        <input type="text" class="form-control form-control-sm" id="parentNameInputBiayaHandling" name="namaBiayaHandling[]" minlength="3" maxlength="50" value="<?php echo $datas['keterangan_biaya']?>">
                                      </div>
                                      <div class="form-group col-md-6 col-lg-2 mb-0">
                                        <label>Qty</label>
                                        <input type="number" class="form-control form-control-sm qtyBiayaHandling" name="qtyBiayaHandling[]" min="0" placeholder="0" value="<?php echo $datas['qty'] ?>">
                                      </div>
                                      <div class="form-group col-md-6 col-lg-5 mb-0">
                                        <label>Biaya</label>
                                        <div class="input-group input-group-sm mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">IDR</span>
                                          </div>
                                          <input type="number" class="form-control inputBiayaHandling" id="parentCostInputBiayaHandling" min="0" onkeypress="return isNumberKey(event)" placeholder="0.00" name="biayaHandling[]" value="<?php echo $datas['nominal_satuan'] ?>">
                                        </div>
                                      </div>
                                    </div>
                                  <?php } else { ?>
                                    <div class="form-row" id="parentInputBiayaHandling">
                                      <input type="hidden" id="biayaHandlingId" name="biayaHandlingId[]" value="">
                                      <div class="form-group col-md-12 col-lg-5 mb-0">
                                        <label>Nama Biaya Handling 1</label>
                                        <input type="text" class="form-control form-control-sm" id="parentNameInputBiayaHandling" name="namaBiayaHandling[]" minlength="3" maxlength="50" value="">
                                      </div>
                                      <div class="form-group col-md-6 col-lg-2 mb-0">
                                        <label>Qty</label>
                                        <input type="number" class="form-control form-control-sm qtyBiayaHandling" name="qtyBiayaHandling[]" min="0" placeholder="0" value="">
                                      </div>
                                      <div class="form-group col-md-6 col-lg-5 mb-0">
                                        <label>Biaya</label>
                                        <div class="input-group input-group-sm mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">IDR</span>
                                          </div>
                                          <input type="number" class="form-control inputBiayaHandling" id="parentCostInputBiayaHandling" min="0" onkeypress="return isNumberKey(event)" placeholder="0.00" name="biayaHandling[]" value="">
                                        </div>
                                      </div>
                                    </div>
                                  <?php } ?>
                                <?php } ?>
   
                              <?php } else { ?>
                                <?php foreach ($dataShipmentHandling as $datas) { ?>
                                  <?php if ($datas['handling_turunan'] == $i+1) { ?>
                                    <div class="form-row" id="parentInputBiayaHandling">
                                      <input type="hidden" id="biayaHandlingId" name="biayaHandlingId[]" value="<?php echo $datas['id']?>">
                                      <div class="form-group col-md-12 col-lg-5 mb-0">
                                        <label>Nama Biaya Handling Next</label>
                                        <input type="text" class="form-control form-control-sm" id="parentNameInputBiayaHandling" name="namaBiayaHandling[]" minlength="3" maxlength="50" value="<?php echo $datas['keterangan_biaya']?>">
                                      </div>
                                      <div class="form-group col-md-6 col-lg-2 mb-0">
                                        <label>Qty</label>
                                        <input type="number" class="form-control form-control-sm qtyBiayaHandling" name="qtyBiayaHandling[]" min="0" placeholder="0" value="<?php echo $datas['qty'] ?>">
                                      </div>
                                      <div class="form-group col-md-6 col-lg-5 mb-0">
                                        <label>Biaya</label>
                                        <div class="input-group input-group-sm mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">IDR</span>
                                          </div>
                                          <input type="number" class="form-control inputBiayaHandling" id="parentCostInputBiayaHandling" min="0" onkeypress="return isNumberKey(event)" placeholder="0.00" name="biayaHandling[]" value="<?php echo $datas['nominal_satuan'] ?>">
                                        </div>
                                      </div>
                                    </div>
                                  <?php } else { ?>
                                    <div class="form-row" id="parentInputBiayaHandling">
                                      <input type="hidden" id="biayaHandlingId" name="biayaHandlingId[]" value="">
                                      <div class="form-group col-md-12 col-lg-5 mb-0">
                                        <label>Nama Biaya Handling Next</label>
                                        <input type="text" class="form-control form-control-sm" id="parentNameInputBiayaHandling" name="namaBiayaHandling[]" minlength="3" maxlength="50" value="">
                                      </div>
                                      <div class="form-group col-md-6 col-lg-2 mb-0">
                                        <label>Qty</label>
                                        <input type="number" class="form-control form-control-sm qtyBiayaHandling" name="qtyBiayaHandling[]" min="0" placeholder="0" value="">
                                      </div>
                                      <div class="form-group col-md-6 col-lg-5 mb-0">
                                        <label>Biaya</label>
                                        <div class="input-group input-group-sm mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">IDR</span>
                                          </div>
                                          <input type="number" class="form-control inputBiayaHandling" id="parentCostInputBiayaHandling" min="0" onkeypress="return isNumberKey(event)" placeholder="0.00" name="biayaHandling[]" value="">
                                        </div>
                                      </div>
                                    </div>
                                  <?php } ?>
                                <?php } ?>
                              <?php } ?>
                            <?php } ?>

                          <?php } else { ?>
                            <?php for ($i=0; $i < count($dataShipmentHandling); $i++) { ?>
                              <?php if ($i == 0) { ?>
                                <?php foreach ($dataShipmentHandling as $index => $datas) {?>
                                  <?php if ($datas['handling_turunan'] == 1) { ?>
                                    <div class="form-row" id="parentInputBiayaHandling">
                                      <input type="hidden" id="biayaHandlingId" name="biayaHandlingId[]" value="<?php echo $datas['id']?>">
                                      <div class="form-group col-md-12 col-lg-5 mb-0">
                                        <label>Nama Biaya Handling 1</label>
                                        <input type="text" class="form-control form-control-sm" id="parentNameInputBiayaHandling" name="namaBiayaHandling[]" minlength="3" maxlength="50" value="<?php echo $datas['keterangan_biaya']?>">
                                      </div>
                                      <div class="form-group col-md-6 col-lg-2 mb-0">
                                        <label>Qty</label>
                                        <input type="number" class="form-control form-control-sm qtyBiayaHandling" name="qtyBiayaHandling[]" min="0" placeholder="0" value="<?php echo $datas['qty'] ?>">
                                      </div>
                                      <div class="form-group col-md-6 col-lg-5 mb-0">
                                        <label>Biaya</label>
                                        <div class="input-group input-group-sm mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">IDR</span>
                                          </div>
                                          <input type="number" class="form-control inputBiayaHandling" id="parentCostInputBiayaHandling" min="0" onkeypress="return isNumberKey(event)" placeholder="0.00" name="biayaHandling[]" value="<?php echo $datas['nominal_satuan'] ?>">
                                        </div>
                                      </div>
                                    </div>
                                  <?php } ?>
                                <?php } ?>
                              <?php } else { ?>
                                <?php foreach ($dataShipmentHandling as $index => $datas) {?>
                                  <?php if ($datas['handling_turunan'] == 2) { ?>
                                    <div class="form-row" id="parentInputBiayaHandling">
                                      <input type="hidden" id="biayaHandlingId" name="biayaHandlingId[]" value="<?php echo $datas['id']?>">
                                      <div class="form-group col-md-12 col-lg-5 mb-0">
                                        <label>Nama Biaya Handling Next</label>
                                        <input type="text" class="form-control form-control-sm" id="parentNameInputBiayaHandling" name="namaBiayaHandling[]" minlength="3" maxlength="50" value="<?php echo $datas['keterangan_biaya']?>">
                                      </div>
                                      <div class="form-group col-md-6 col-lg-2 mb-0">
                                        <label>Qty</label>
                                        <input type="number" class="form-control form-control-sm qtyBiayaHandling" name="qtyBiayaHandling[]" min="0" placeholder="0" value="<?php echo $datas['qty'] ?>">
                                      </div>
                                      <div class="form-group col-md-6 col-lg-5 mb-0">
                                        <label>Biaya</label>
                                        <div class="input-group input-group-sm mb-3">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">IDR</span>
                                          </div>
                                          <input type="number" class="form-control inputBiayaHandling" id="parentCostInputBiayaHandling" min="0" onkeypress="return isNumberKey(event)" placeholder="0.00" name="biayaHandling[]" value="<?php echo $datas['nominal_satuan'] ?>">
                                        </div>
                                      </div>
                                    </div>
                                  <?php } ?>
                                <?php } ?>
                              <?php } ?>

                            <?php } ?>

                          <?php } ?>
                            
                        </div>
                        <!-- <div class="text-primary font-weight-bold"><span class="addRowHandling" style="cursor: pointer;"><i class="fas fa-plus"></i> Tambah Biaya Handling</span></div> -->
                      </div>
                      <div class="col-md-12 col-lg-6">
                        <div class="form-group col-12 py-3 rounded bg-lightGrey">
                          <h5 class="font-weight-bold">Total Biaya Handling</h5>
                          <!-- <h5 class="font-weight-bold">(dengan kurs)</h5> -->
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="mb-0 text-primary">
                              IDR <span style="font-size: 36px;font-weight:700;" id="countBiayaHandling"><?php echo $totalHandling ?></span>
                            </div>
                            <div>
                            <button type="button" class="btn btn-primary" id="actionCountBiayaHandling"><i class="fas fa-redo-alt"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <input type="reset" value="Reset" class="btn  btn-danger " style="width:22%;">
                  <?php if ($dataShipment['close'] == 1) {?>
                    <button type="button" class="btn btn-md btn-primary " style="width:77%;" disabled>Submit</button>
                    <div>
                      <p class="mb-0">Ditutup Oleh <b><?php echo $dataGetUserShipment['nama'] ?></b> tanggal <b><?php echo $dataShipment['close_date'] ?></b></p>
                    </div>
                  <?php } else {?>
                    <input type="submit" value="Submit" name="editShipment" class="btn btn-md btn-primary " style="width:77%;">
                  <?php } ?>
                </form>
              </div>
            </div>
          </div>
		  <!--<div class="text-center">
            <img src="img/think.svg" style="max-height: 90px">
            <h4 class="pt-3">save your <b>imagination</b> here!</h4>
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
  <script src="../../vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <script src="../../vendor/select2/dist/js/select2.min.js"></script>

  <script>
    $('.addRowHandling').click(function() {
      // var node = document.getElementById('listBiayaHandling')
      // var clone = document.getElementById('parentInputBiayaHandling')
      // clonex = clone.cloneNode(true);

      // clonex.setAttribute('id', ' ');
      // clonex.querySelector('#biayaHandlingId').value = ' ';
      // clonex.querySelector('#parentNameInputBiayaHandling').value = ' ';
      // clonex.querySelector('#parentCostInputBiayaHandling').value = ' ';
      
      // // clonex.insertBefore($('.addRowHandling'))
      // node.appendChild(clonex);

      var node = document.getElementById('listBiayaHandling')
      var actionBtn = $('.listBiayaHandling').last();
      var clone = $('#parentInputBiayaHandling').clone().find('input').val('').end().insertAfter(actionBtn)
    });
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
    $('.select2-single-placeholder3').select2({
  		placeholder: "Pilih",
	  	allowClear: true
	  });

    $('#simple-date1 .input-group.date').datepicker({
      format: 'dd/mm/yyyy',
      todayBtn: 'linked',
      todayHighlight: true,
      autoclose: true,        
    });

    $('#actionCountBiayaHandling').click(function() {
      var l = $('.inputBiayaHandling').length;
      //Initialize default array
      // var arrResult = [];
      var result = 0;
      for (i = 0; i < l; i++) { 
        //Push each element to the array
        var temp = $('.inputBiayaHandling').eq(i).val() == '' ? 0 : $('.inputBiayaHandling').eq(i).val();
        var qtyTemp = $('.qtyBiayaHandling').eq(i).val() == '' ? 0 : $('.qtyBiayaHandling').eq(i).val()
        console.log(temp);
        var resultTemp = parseFloat(qtyTemp) * parseFloat(temp);
        result += parseFloat(resultTemp)
      }
      //print the array or use it for your further logic
      console.log(result);

      $('#countBiayaHandling').html(new Intl.NumberFormat('id-ID').format(result));
    })

    $('#actionCountBiayaFreight').click(function() {
      var result = 0;
      var kursTemp = $('#kurs').val() == '' ? 0 : $('#kurs').val()
      var biayaFreightTemp = $('#biayaFreight').val() == '' ? 0 : $('#biayaFreight').val()
      result = kursTemp * biayaFreightTemp
      console.log(result);

      $('#countBiayaFreight').html(new Intl.NumberFormat('id-ID').format(result));
    })

    function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : evt.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
          return false;
      return true;
    }

    $('#countBiayaFreight').html(new Intl.NumberFormat('id-ID').format(<?php echo $dataShipment['total_freight']?>));
    $('#countBiayaHandling').html(new Intl.NumberFormat('id-ID').format(<?php echo $totalHandling ?>));
  </script>

</body>

</html>