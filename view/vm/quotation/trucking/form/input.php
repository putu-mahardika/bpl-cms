<?php
  session_save_path('../../../../../tmp');
  session_start();

  if ($_SESSION['hak_akses'] == "" || ($_SESSION['hak_akses'] != "VmTrucking" && $_SESSION['hak_akses'] != "VmShipment")) {
    // header("location:../../../index.php?pesan=belum_login");
  }
  include '../../../../../config/koneksi.php';
  date_default_timezone_set("Asia/Jakarta");

  $datetime = date('Y');
  $cityArray= [];
  $kendaraanArray= [];
  $customerArray=[];

  $queryMasterCustomer = 'select * from master_customer where aktif=1';
  $fetchMasterCustomer = mysqli_query($koneksi, $queryMasterCustomer);

  $queryMasterKendaraan = 'select * from master_kendaraan where IsActive=1';
  $fetchMasterKendaraan = mysqli_query($koneksi, $queryMasterKendaraan);

  $queryMasterKota = 'select * from master_kota where aktif=1';
  $fetchMasterKota = mysqli_query($koneksi, $queryMasterKota);

  while($row = $fetchMasterKota->fetch_assoc()) {
    $cityArray[] = $row;
  }

  while($row = $fetchMasterKendaraan->fetch_assoc()) {
    $kendaraanArray[] = $row;
  }

  while($row = $fetchMasterCustomer->fetch_assoc()) {
    $customerArray[] = $row;
  }

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
  <title>Form Quotation Trucking - PT Berkah Permata Logistik</title>
  <link href="../../../../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../../../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../../../../../vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <link href="../../../../../vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="../../../../../css/ruang-admin.min.css" rel="stylesheet">
  <style>
    .bg-lightGrey {
      background-color: #f1f1f1;
      color: black;
    }
    .hidden {
      visibility: hidden;
      height: 0;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard-admin.php?tahun=<?php echo $datetime?>">
        <div class="sidebar-brand-icon">
          <img src="../../../../../img/logo-BPL-white-min.png" style="height:130px;">
        </div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item">
        <a class="nav-link" href="../../../dashboard-admin.php?tahun=<?php echo $datetime?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Master
      </div>
      <li class="nav-item">
        <a class="nav-link" href="../../../user.php">
          <i class="fas fa-fw fa-users"></i>
          <span>User Pengguna</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
          aria-controls="collapseForm">
          <i class="fas fa-fw fa-database"></i>
          <span>Database</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Customer</h6> -->
            <a class="collapse-item" href="../../../customer.php">List Customer</a>
            <a class="collapse-item" href="../../../vendor.php">List Vendor</a>
            <a class="collapse-item" href="../../../kota.php">List Kota</a>
            <a class="collapse-item" href="../../../negara.php">List Negara</a>
            <a class="collapse-item" href="../../../unit.php">List Unit</a>
            <a class="collapse-item" href="../../../jenisKendaraan.php">List Jenis Kendaraan</a>
            <a class="collapse-item" href="../../../loadType.php">List Load Type</a>
            <a class="collapse-item" href="../../../status.php">List Status Trucking</a>
            <a class="collapse-item" href="../../../statusShipment.php">List Status Shipment</a>
            <a class="collapse-item" href="../../../shipmentTerms.php">List Shipment Terms</a>
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
            <a class="collapse-item" href="../../../quotation/trucking/index.php?tahun=<?php echo $datetime?>">List Quo Trucking</a>
            <!--<a class="collapse-item" href="datatables.html">DataTables</a>-->
          </div>
        </div>
      </li>
	    <li class="nav-item">
        <a class="nav-link" href="../../../shipment.php?tahun=<?php echo $datetime?>">
          <i class="fas fa-fw fa-ship"></i>
          <span>Shipment</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../../transaksi.php?tahun=<?php echo $datetime?>">
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
            <a class="collapse-item" href="../../../laporanbarang.php">Laporan Detail</a>
            <a class="collapse-item" href="../../../laporanbarangbiaya.php">Laporan Biaya</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../../laporanShipment.php">
          <i class="fas fa-fw fa-file-invoice"></i>
          <span>Laporan Shipment</span>
        </a>
      </li>

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
				        <img class="img-profile rounded-circle" src="../../../../../img/boy.png" style="max-width: 60px"> 
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
            <a href="../index.php?php echo $datetime ?>" style="margin-right:20px;"><i class="far fa-arrow-alt-circle-left fa-2x" title="kembali"></i></a>
            <h1 class="h3 mb-0 text-gray-800">Form Quotation trucking</h1>
            <!--<ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item">Pages</li>
              <li class="breadcrumb-item active" aria-current="page">Blank Page</li>
            </ol>-->
          </div>
          <div class="row mb-3">
            <div class="col-xl-12 col-lg-12">
              <div class="card mb-4">
                <?php if(isset($_SESSION['id_pesan1']) && isset($_SESSION['pesan'])){
                  // echo $_SESSION['id_pesan1'][0];
                  $save = $_SESSION['id_pesan1'];
                ?>
                <div class="card-body">
                  <?php if(isset($_SESSION['pesan'])){?><?php echo $_SESSION['pesan']; unset($_SESSION['pesan']);}?>
                  <form role="form" method="post" action="../../../../../config/controller/quotationTruckingController.php">
                    <!-- <div class="mb-3">field card summary</div> -->
                    <!-- <div class="mb-3">
                      <div class="row">
                        <div class="col-lg-4">
                          <button class="btn btn-primary" style="width: 100%;" type="button" disabled>Cetak Quo</button>
                        </div>
                        <div class="col-lg-4">
                          <button class="btn btn-primary" style="width: 100%;" type="button" disabled>Customer PO</button>
                        </div>
                        <div class="col-lg-4">
                          <button class="btn btn-primary" style="width: 100%;" type="button" disabled>Repeat Order</button>
                        </div>
                      </div>
                    </div> -->
                    <div class="mb-5">
                      <div class="mb-3">
                        <p class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Informasi Quotation Trucking</p>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="row">
                              <div class="col-4">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="" id="customerCheck" <?php $save[0] == '' || $save[0] == null ? printf('checked') : printf('') ?>>
                                  <label class="form-check-label" for="customerCheck">
                                    Customer Baru
                                  </label>
                                </div>
                              </div>
                              <div class="col-8">
                                <div id="customerField" class="<?php $save[0] ? printf('') : printf('hidden') ?>">
                                  <div class="form-group">
                                    <label>Customer :</label>
                                    <select class="select2-single-placeholder form-control" name="customer" id="customer">
                                      <option value="" disabled selected>Pilih</option>
                                      <?php
                                        foreach($customerArray as $data){
                                          if($data['aktif']==1){
                                            if ($data['CustId'] == $save[0]){
                                      ?>
                                      <option value="<?php echo $data['CustId'];?>" selected><?php echo $data['nama'];?></option>
                                          <?php } else { ?>
                                      <option value="<?php echo $data['CustId'];?>"><?php echo $data['nama'];?></option>
                                        <?php }} else {
                                        continue;
                                        }
                                      }
                                      ?>
                                    </select>
                                  </div>
                                </div>
                                <div id="customerTempField" class="<?php $save[1] ? print('') : printf('hidden') ?>">
                                  <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerTempName" id="customerTempName" placeholder="Masukkan nama customer" value="<?php echo $save[1] ?>">
                                  </div>
                                  <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerAddressTemp" id="customerAddressTemp" placeholder="Masukkan alamat customer" value="<?php echo $save[2] ?>">
                                  </div>
                                  <div class="form-group">
                                    <label>PIC</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerPicTemp" id="customerPicTemp" placeholder="Masukkan nama PIC customer" value="<?php echo $save[3] ?>">
                                  </div>
                                  <div class="form-group">
                                    <label>Telp</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerPicPhoneTemp" id="customerPicPhoneTemp" placeholder="Masukkan telepon PIC customer" value="<?php echo $save[4] ?>">
                                  </div>
                                  <div class="form-group">
                                    <label>Payment Term Days</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerPaymentTermsTemp" id="customerPaymentTermsTemp" placeholder="Masukkan payment term days customer" value="<?php echo $save[20] ?>">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>Jumlah Armada</label>
                              <input type="number" class="form-control form-control-sm mb-3" name="totalArmada" placeholder="Masukkan jumlah armada" min="1" value="<?php echo $save[5] ?>" required>
                            </div>
                            <div class="form-group">
                              <label>Jenis Barang Bawaan</label>
                              <input type="text" class="form-control form-control-sm mb-3" name="itemType" placeholder="Masukkan jenis barang bawaan" value="<?php echo $save[6] ?>" required>
                            </div>
                            <div class="form-group">
                              <label>Total Berat (Kg) KGM/CBM</label>
                              <input type="number" class="form-control form-control-sm mb-3" name="weight" placeholder="Masukkan total berat" min="1" value="<?php echo $save[7] ?>" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Keterangan :</label>
                          <textarea type="text" class="form-control form-control-sm mb-3" name="keterangan" minlength="10" maxlength="100"><?php echo $save[8] ?></textarea>
                        </div>
                      </div>
                      <div class="mb-3">
                        <div class="form-group">
                          <input type="hidden" class="form-control form-control-sm mb-3" id="selectedTab" name="selectedTab" value="<?php echo $save[18] ?>">
                        </div>
                        <div>
                          <div class="mb-3">
                            <p class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Jenis Trip</p>
                            <div class="mb-3">
                              <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link <?php $save[18] == 0 ? printf('active') : printf('') ?>" id="singleTrip-tab" data-toggle="tab" href="#singleTrip" role="tab" aria-controls="singleTrip" aria-selected="true">Single Trip</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link <?php $save[18] == 1 ? printf('active') : printf('') ?>" id="multiTrip-tab" data-toggle="tab" href="#multiTrip" role="tab" aria-controls="multiTrip" aria-selected="false">Multi Trip</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link <?php $save[18] == 2 ? printf('active') : printf('') ?>" id="kgmCbm-tab" data-toggle="tab" href="#kgmCbm" role="tab" aria-controls="kgmCbm" aria-selected="false">KGM/CBM</a>
                                </li>
                              </ul>
                              <div class="tab-content mt-3" id="myTabContent">
                                <p class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Permintaan Customer</p>
                                <div class="tab-pane fade <?php if ($save[18] == 0 ? printf('show active') : printf('')) ?>" id="singleTrip" role="tabpanel" aria-labelledby="singleTrip-tab">
                                  <table class="table align-items-center table-flush table-hover">
                                    <thead class="thead-light">
                                      <tr>
                                        <th>Jenis Kendaraan</th>
                                        <th>Pickup</th>
                                        <th>Tujuan</th>
                                        <th>Keterangan Pickup</th>
                                        <th>Keterangan Tujuan</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                          <select class="form-control" name="kendaraan" id="kendaraan">
                                            <option value="" disabled>Pilih</option>
                                            <?php
                                              foreach($kendaraanArray as $data){
                                                if($data['IsActive']==1){
                                                  if ($data['Id'] == $save[10]) {
                                            ?>
                                            <option value="<?php echo $data['Id'];?>" selected><?php echo $data['Nama'];?></option>                                            
                                                <?php } else {?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php }} else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaAsal" id="kotaAsal">
                                            <option value="" disabled>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                                  if ($data['Id'] == $save[12]) {
                                            ?>
                                            <option value="<?php echo $data['Id'];?>" selected><?php echo $data['Nama'];?></option>
                                                <?php } else { ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php }} else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaTujuan1" id="kotaTujuan1">
                                            <option value="" disabled>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                                  if($data['Id'] == $save[13]){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>" selected><?php echo $data['Nama'];?></option>
                                                <?php } else { ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php }} else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaAsal0" id="detailKotaAsal0" minlength="3" maxlength="100"><?php echo $save[16] ?></textarea>    
                                        </td>
                                        <td>
                                          <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaTujuan0" id="detailKotaTujuan0" minlength="3" maxlength="100"><?php echo $save[17] ?></textarea>    
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <div class="tab-pane fade <?php if ($save[18] == 1 ? printf('show active') : printf('')) ?>" id="multiTrip" role="tabpanel" aria-labelledby="multiTrip-tab">
                                  <table class="table align-items-center table-flush table-hover">
                                    <thead class="thead-light">
                                      <tr>
                                        <th rowspan="2">Jenis Kendaraan</th>
                                        <th rowspan="2">Pickup</th>
                                        <th colspan="3">Tujuan</th>
                                        <th rowspan="2">Keterangan Pickup</th>
                                        <th rowspan="2">Keterangan Tujuan</th>
                                      </tr>
                                      <tr>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                          <select class="form-control" name="kendaraan" id="kendaraan">
                                            <option value="" disabled>Pilih</option>
                                            <?php
                                              foreach($kendaraanArray as $data){
                                                if($data['IsActive']==1){
                                                  if($data['Id'] == $save[10]) {
                                            ?>
                                            <option value="<?php echo $data['Id'];?>" selected><?php echo $data['Nama'];?></option>
                                                <?php } else { ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php }} else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaAsal" id="kotaAsal">
                                            <option value="" disabled>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                                  if($data['Id'] == $save[12]){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>" selected><?php echo $data['Nama'];?></option>
                                                <?php } else { ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php }} else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaTujuan1" id="kotaTujuan1">
                                            <option value="" disabled>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                                  if($data['Id'] == $save[13]){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>" selected><?php echo $data['Nama'];?></option>
                                                <?php } else { ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php }} else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaTujuan2" id="kotaTujuan2">
                                            <option value="" disabled>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                                  if($data['Id'] == $save[14]){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>" selected><?php echo $data['Nama'];?></option>
                                                <?php } else { ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php }} else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaTujuan3" id="kotaTujuan3">
                                          <option value="" disabled>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                                  if($data['Id'] == $save[15]){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>" selected><?php echo $data['Nama'];?></option>
                                                <?php } else { ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php }} else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaAsal1" id="detailKotaAsal1" minlength="3" maxlength="100"><?php echo $save[16] ?></textarea>    
                                        </td>
                                        <td>
                                          <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaTujuan1" id="detailKotaTujuan1" minlength="3" maxlength="100"><?php echo $save[17] ?></textarea>    
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <div class="tab-pane fade <?php if ($save[18] == 2 ? printf('show active') : printf('')) ?>" id="kgmCbm" role="tabpanel" aria-labelledby="kgmCbm-tab">
                                  <table class="table align-items-center table-flush table-hover">
                                    <thead class="thead-light">
                                      <tr>
                                        <th>Jenis Kendaraan</th>
                                        <th>Qty First</th>
                                        <th>Pickup</th>
                                        <th>Tujuan</th>
                                        <th>Keterangan Pickup</th>
                                        <th>Keterangan Tujuan</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                          <select class="form-control" name="deliveryType" id="kendaraan">
                                            <option value="" disabled <?php $save[19] == '' ? printf('selected') : printf('') ?>>Pilih</option>
                                            <option value="kgm" <?php $save[19] == 'kgm' ? printf('selected') : printf('') ?>>KGM</option>
                                            <option value="cbm" <?php $save[19] == 'cbm' ? printf('selected') : printf('') ?>>CBM</option>
                                          </select>
                                        </td>
                                        <td>
                                          <input type="number" class="form-control form-control-sm mb-3" name="qty" id="qty" placeholder="masukkan jumlah barang" min="0" value="<?php echo $save[11] ?>">
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaAsal" id="kotaAsal">
                                            <option value="" disabled selected>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                                  if($data['Id'] == $save[14]){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>" selected><?php echo $data['Nama'];?></option>
                                                <?php } else { ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php }} else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaTujuan1" id="kotaTujuan1">
                                            <option value="" disabled>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                                  if($data['Id'] == $save[14]){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>" selected><?php echo $data['Nama'];?></option>
                                                <?php } else { ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php }} else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaAsal2" id="detailKotaAsal2" minlength="3" maxlength="100"><?php echo $save[16] ?></textarea>    
                                        </td>
                                        <td>
                                          <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaTujuan2" id="detailKotaTujuan2" minlength="3" maxlength="100"><?php echo $save[17] ?></textarea>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="mb-3">
                        <div class="row">
                          <div class="col-lg-2">
                            <button class="btn btn-success mb-3" style="width: 100%; height: 100%" type="button">Reset</button>
                            <!-- <button class="btn btn-danger" style="width: 100%;" type="button">Delete</button> -->
                          </div>
                          <div class="col-lg-10">
                            <div class="row" style="height: 100%;">
                              <div class="col-lg-4">
                                <button class="btn btn-primary" style="width: 100%; height:100%; background-color:#EA8E8E; border-color:#EA8E8E;" type="button">Batal</button>
                              </div>
                              <div class="col-lg-8">
                                <input class="btn btn-primary" style="width: 100%; height:100%;" type="submit" value="Simpan" name="inputQuoTrucking" >
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                  <!-- <div class="mb-3">
                    <p class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Riwayat Perubahan</p>
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                      <thead class="thead-light">
                        <tr>
                          <th style="width: 300px;">Tanggal</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                    </table>
                  </div> -->
                </div>
                <?php } else { ?>
                <div class="card-body">
                  <?php if(isset($_SESSION['pesan'])){?><?php echo $_SESSION['pesan']; unset($_SESSION['pesan']);}?>
                  <form role="form" method="post" action="../../../../../config/controller/quotationTruckingController.php">
                    <!-- <div class="mb-3">field card summary</div> -->
                    <!-- <div class="mb-3">
                      <div class="row">
                        <div class="col-lg-4">
                          <button class="btn btn-primary" style="width: 100%;" type="button" disabled>Cetak Quo</button>
                        </div>
                        <div class="col-lg-4">
                          <button class="btn btn-primary" style="width: 100%;" type="button" disabled>Customer PO</button>
                        </div>
                        <div class="col-lg-4">
                          <button class="btn btn-primary" style="width: 100%;" type="button" disabled>Repeat Order</button>
                        </div>
                      </div>
                    </div> -->
                    <div class="mb-5">
                      <div class="mb-3">
                        <p class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Informasi Quotation Trucking</p>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="row">
                              <div class="col-4">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="" id="customerCheck">
                                  <label class="form-check-label" for="customerCheck">
                                    Customer Baru
                                  </label>
                                </div>
                              </div>
                              <div class="col-8">
                                <div id="customerField" class="">
                                  <div class="form-group">
                                    <label>Customer :</label>
                                    <select class="select2-single-placeholder form-control" name="customer" id="customer">
                                      <option value="" disabled selected>Pilih</option>
                                      <?php
                                        foreach($customerArray as $data){
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
                                </div>
                                <div id="customerTempField" class="hidden">
                                  <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerNameTemp" id="customerTempName" placeholder="Masukkan nama customer">
                                  </div>
                                  <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerAddressTemp" id="customerAddressTemp" placeholder="Masukkan alamat customer">
                                  </div>
                                  <div class="form-group">
                                    <label>PIC</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerPicTemp" id="customerPicTemp" placeholder="Masukkan nama PIC customer">
                                  </div>
                                  <div class="form-group">
                                    <label>Telp</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerPicPhoneTemp" id="customerPicPhoneTemp" placeholder="Masukkan telepon PIC customer">
                                  </div>
                                  <div class="form-group">
                                    <label>Payment Term Days</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerPaymentTermsTemp" id="customerPaymentTermsTemp" placeholder="Masukkan payment term days customer">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>Jumlah Armada</label>
                              <input type="number" class="form-control form-control-sm mb-3" name="totalArmada" placeholder="Masukkan jumlah armada" min="1" required>
                            </div>
                            <div class="form-group">
                              <label>Jenis Barang Bawaan</label>
                              <input type="text" class="form-control form-control-sm mb-3" name="itemType" placeholder="Masukkan jenis barang bawaan" required>
                            </div>
                            <div class="form-group">
                              <label>Total Berat (Kg) KGM/CBM</label>
                              <input type="number" class="form-control form-control-sm mb-3" name="weight" placeholder="Masukkan total berat" min="1" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Keterangan :</label>
                          <textarea type="text" class="form-control form-control-sm mb-3" name="keterangan" minlength="10" maxlength="100"></textarea>
                        </div>
                      </div>
                      <div class="mb-3">
                        <div class="form-group">
                          <input type="hidden" class="form-control form-control-sm mb-3" id="selectedTab" name="selectedTab" value="0">
                        </div>
                        <div>
                          <div class="mb-3">
                            <p class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Jenis Trip</p>
                            <div class="mb-3">
                              <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link active" id="singleTrip-tab" data-toggle="tab" href="#singleTrip" role="tab" aria-controls="singleTrip" aria-selected="true">Single Trip</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="multiTrip-tab" data-toggle="tab" href="#multiTrip" role="tab" aria-controls="multiTrip" aria-selected="false">Multi Trip</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="kgmCbm-tab" data-toggle="tab" href="#kgmCbm" role="tab" aria-controls="kgmCbm" aria-selected="false">KGM/CBM</a>
                                </li>
                              </ul>
                              <div class="tab-content mt-3" id="myTabContent">
                                <p class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Permintaan Customer</p>
                                <div class="tab-pane fade show active" id="singleTrip" role="tabpanel" aria-labelledby="singleTrip-tab">
                                  <table class="table align-items-center table-flush table-hover">
                                    <thead class="thead-light">
                                      <tr>
                                        <th>Jenis Kendaraan</th>
                                        <th>Pickup</th>
                                        <th>Tujuan</th>
                                        <th>Keterangan Pickup</th>
                                        <th>Keterangan Tujuan</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                          <select class="form-control" name="kendaraan" id="kendaraan">
                                            <option value="" disabled selected>Pilih</option>
                                            <?php
                                              foreach($kendaraanArray as $data){
                                                if($data['IsActive']==1){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php } else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaAsal" id="kotaAsal">
                                            <option value="" disabled selected>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php } else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaTujuan1" id="kotaTujuan1">
                                            <option value="" disabled selected>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php } else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaAsal0" id="detailKotaAsal0" minlength="3" maxlength="100"></textarea>    
                                        </td>
                                        <td>
                                          <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaTujuan0" id="detailKotaTujuan0" minlength="3" maxlength="100"></textarea>    
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <div class="tab-pane fade" id="multiTrip" role="tabpanel" aria-labelledby="multiTrip-tab">
                                  <table class="table align-items-center table-flush table-hover">
                                    <thead class="thead-light">
                                      <tr>
                                        <th rowspan="2">Jenis Kendaraan</th>
                                        <th rowspan="2">Pickup</th>
                                        <th colspan="3">Tujuan</th>
                                        <th rowspan="2">Keterangan Pickup</th>
                                        <th rowspan="2">Keterangan Tujuan</th>
                                      </tr>
                                      <tr>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                          <select class="form-control" name="kendaraan" id="kendaraan">
                                            <option value="" disabled selected>Pilih</option>
                                            <?php
                                              foreach($kendaraanArray as $data){
                                                if($data['IsActive']==1){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php } else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaAsal" id="kotaAsal">
                                            <option value="" disabled selected>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php } else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaTujuan1" id="kotaTujuan1">
                                            <option value="" disabled selected>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php } else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaTujuan2" id="kotaTujuan2">
                                            <option value="" disabled selected>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php } else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaTujuan3" id="kotaTujuan3">
                                            <option value="" disabled selected>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php } else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaAsal1" id="detailKotaAsal1" minlength="3" maxlength="100"></textarea>    
                                        </td>
                                        <td>
                                          <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaTujuan1" id="detailKotaTujuan1" minlength="3" maxlength="100"></textarea>    
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <div class="tab-pane fade" id="kgmCbm" role="tabpanel" aria-labelledby="kgmCbm-tab">
                                  <table class="table align-items-center table-flush table-hover">
                                    <thead class="thead-light">
                                      <tr>
                                        <th>Jenis Kendaraan</th>
                                        <th>Qty First</th>
                                        <th>Pickup</th>
                                        <th>Tujuan</th>
                                        <th>Keterangan Pickup</th>
                                        <th>Keterangan Tujuan</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                          <select class="form-control" name="deliveryType" id="kendaraan" style="width: 150px;">
                                            <option value="" disabled selected>Pilih</option>
                                            <option value="kgm">KGM</option>
                                            <option value="cbm">CBM</option>
                                          </select>
                                        </td>
                                        <td>
                                          <input type="number" class="form-control form-control-sm mb-3" name="qty" id="qty" placeholder="masukkan jumlah barang" min="0" value="0">
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaAsal" id="kotaAsal">
                                            <option value="" disabled selected>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php } else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select class="form-control" name="kotaTujuan1" id="kotaTujuan1">
                                            <option value="" disabled selected>Pilih</option>
                                            <?php
                                              foreach($cityArray as $data){
                                                if($data['aktif']==1){
                                            ?>
                                            <option value="<?php echo $data['Id'];?>"><?php echo $data['Nama'];?></option>
                                              <?php } else {
                                              continue;
                                              }
                                            }
                                            ?>
                                          </select>
                                        </td>
                                        <td>
                                          <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaAsal2" id="detailKotaAsal2" minlength="3" maxlength="100"></textarea>    
                                        </td>
                                        <td>
                                          <textarea type="text" class="form-control form-control-sm mb-3" name="detailKotaTujuan2" id="detailKotaTujuan2" minlength="3" maxlength="100"></textarea>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="mb-3">
                        <div class="row">
                          <div class="col-lg-2">
                            <button class="btn btn-success mb-3" style="width: 100%; height: 100%" type="button">Reset</button>
                            <!-- <button class="btn btn-danger" style="width: 100%;" type="button">Delete</button> -->
                          </div>
                          <div class="col-lg-10">
                            <div class="row" style="height: 100%;">
                              <div class="col-lg-4">
                                <button class="btn btn-primary" style="width: 100%; height:100%; background-color:#EA8E8E; border-color:#EA8E8E;" type="button">Batal</button>
                              </div>
                              <div class="col-lg-8">
                                <input class="btn btn-primary" style="width: 100%; height:100%;" type="submit" value="Simpan" name="inputQuoTrucking" >
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                  <!-- <div class="mb-3">
                    <p class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Riwayat Perubahan</p>
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                      <thead class="thead-light">
                        <tr>
                          <th style="width: 300px;">Tanggal</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                    </table>
                  </div> -->
                </div>
                <?php } ?>
              </div>
            </div>
            <!-- <div class="col-xl-4 col-lg-4">
              <div class="card mb-4">
                <div class="card-body">
                  <div class="mb-2" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Status</div>
                  <div>
                    Last Update - 1/1/2024 - Follow Up
                  </div>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-body">
                  <div class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Informasi PO</div>
                  <div class="mb-3">
                    <div class="mb-1">Link SPK Trucking</div>
                    <button class="btn btn-primary" style="width: 100%; height:100%;" type="button">SPK MNPI/SHI/24/165</button>
                  </div>
                  <div class="mb-3">
                    <div class="form-group">
                      <label>Tanggal PO</label>
                      <input type="text" class="form-control form-control-sm mb-3" value="1 Agustus 2024">
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="form-group">
                      <label>Nomor PO</label>
                      <input type="text" class="form-control form-control-sm mb-3" value="PO001">
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-body">
                  <div class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Informasi Quo Shipment</div>
                  <div class="mb-3">
                    <div class="mb-1">Link Quo Shipment</div>
                    <button class="btn btn-primary" style="width: 100%; height:100%;" type="button">SPK MNPI/SHI/24/165</button>
                  </div>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-body">
                  Perubahan Sales
                </div>
              </div>
            </div> -->
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
                  <a href="../../../../../config/logout.php" class="btn btn-primary">Logout</a>
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

  <script src="../../../../../vendor/jquery/jquery.min.js"></script>
  <script src="../../../../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../../../../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../../../../../js/ruang-admin.min.js"></script>
  <script src="../../../../../vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <script src="../../../../../vendor/select2/dist/js/select2.min.js"></script>
  <!-- Page level plugins -->
  <script src="../../../../../vendor/datatables1/jquery.dataTables.min.js"></script>
  <script src="../../../../../vendor/datatables1/datatables.min.js"></script>
  <script src="../../../../../vendor/select2/dist/js/select2.min.js"></script>
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>-->

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      //$.fn.table.moment('d-M-Y hh:mm:ss');
      $('.select2-single-placeholder').select2({
        placeholder: "Pilih",
        allowClear: true
      });
      $('#dataTableHover').DataTable({
        "order": [[0, "asc"]]    
      }); // ID From dataTable with Hover 

      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        console.log('e', e);
        var id = e.target.id;
        let selectedTab = '0';
        $('#kendaraan option:eq("")').prop('selected', true);
        $('#kotaAsal option:eq("")').prop('selected', true);
        $('#kotaTujuan1 option:eq("")').prop('selected', true);
        $('#kotaTujuan2 option:eq("")').prop('selected', true);
        $('#kotaTujuan3 option:eq("")').prop('selected', true);

        $('#qty').val('0')
        $('textarea#detailKotaAsal0').val('')
        $('textarea#detailKotaTujuan0').val('')
        $('textarea#detailKotaAsal1').val('')
        $('textarea#detailKotaTujuan1').val('')
        $('textarea#detailKotaAsal2').val('')
        $('textarea#detailKotaTujuan2').val('')
        if (id === 'multiTrip-tab') {
          selectedTab = '1';
        } else if (id === 'kgmCbm-tab') {
          selectedTab = '2';
        } else {
          selectedTab = '0';
        }
        $('#selectedTab').val(selectedTab)
      });
      
      $('#customerCheck').click(function (e) {
        // console.log('e', e);
        var status = e.target.checked
        $('#customer option:eq("")').prop('selected', true);
        $('#customerTempName').val("");
        $('#customerAddressTemp').val("");
        $('#customerPicTemp').val("");
        $('#customerPicPhoneTemp').val("");
        if (status) {
          $('#customerField').addClass('hidden');
          $('#customerTempField').removeClass('hidden');
        } else {
          $('#customerField').removeClass('hidden');
          $('#customerTempField').addClass('hidden')
        }
      })
    });
  </script>

</body>

</html>