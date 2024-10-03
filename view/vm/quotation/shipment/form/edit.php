<?php
session_save_path('../../../../../tmp');
session_start();

if ($_SESSION['hak_akses'] == "" || ($_SESSION['hak_akses'] != "VmTrucking" && $_SESSION['hak_akses'] != "VmShipment")) {
  header("location:../../../../../index.php?pesan=belum_login");
}
include '../../../../../config/koneksi.php';
include '../../../../../config/controller/quotationShipments/quotationShipmentController.php';
date_default_timezone_set("Asia/Jakarta");

$s_id = $_SESSION['id'];
$vendors = getVendors($koneksi);

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
  <link href="../../../../../vendor/sweetalert2/dist/sweetalert2.all.min.css" rel="stylesheet" type="text/css">
  <link href="../../../../../vendor/toastr/build/toastr.min.css" rel="stylesheet" type="text/css">
  <link href="../../../../../vendor/flatpickr/dist/flatpickr.min.css" rel="stylesheet" type="text/css">
  <link href="../../../../../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../../../../../css/new-style.css" rel="stylesheet">
  <style>
    .bg-lightGrey {
      background-color: #f1f1f1;
      color: black;
    }

    .hidden {
      visibility: hidden;
      height: 0;
    }

    .sideInfo {
      padding: 5px 15px 2px 15px;
      border: 1px solid #BCBCBC;
      border-radius: 7px;
      background-color: #EDEFFB;
    }

    .coloredSideInfoStatus {
      padding: 5px 15px 2px 15px;
      /* border: 1px solid #BCBCBC; */
      border-radius: 7px;
      background-color: <?php echo $dataStatus['color'] ?>;
      color: white;
    }

    .pagination {
      justify-content: end !important;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php?tahun=<?php echo $datetime ?>">
        <div class="sidebar-brand-icon">
          <img src="../../../../../img/logo-BPL-white-min.png" style="height:130px;">
        </div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item">
        <a class="nav-link" href="../../../dashboard.php?tahun=<?php echo $datetime ?>">
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
            <a class="collapse-item" href="../../../customer.php">List Customer</a>
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
            <a class="collapse-item" href="../../../quotation/trucking/index.php">List Quo Trucking</a>
            <!--<a class="collapse-item" href="datatables.html">DataTables</a>-->
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../../shipment.php?tahun=<?php echo $datetime ?>">
          <i class="fas fa-fw fa-ship"></i>
          <span>Shipment</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../../transaksi.php?tahun=<?php echo $datetime ?>">
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
                <span class="mr-2 d-none d-lg-inline text-white small"><?php echo $_SESSION['nama'] ?></span>
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
            <h1 class="h3 mb-0 text-gray-800">Form Quotation Shipment</h1>
            <!--<ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item">Pages</li>
              <li class="breadcrumb-item active" aria-current="page">Blank Page</li>
            </ol>-->
          </div>
          <div class="row mb-3">
            <div class="col-xl-8 col-lg-8">
              <div class="card mb-4">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="p-3 card-pricing rounded w-100" style="height: 120px;">
                        <div class="card-pricing-title d-flex align-items-center mb-3">
                          <div class="bg-primary rounded d-flex align-items-center justify-content-center mr-2" style="width: 28px; height: 28px">
                            <i class="fas fa-sync text-white"></i>
                          </div>
                          <h6 class="font-weight-bold title mb-0">Total Costing</h6>
                        </div>
                        <div class="card-pricing-body">
                          <div class="text-left">
                            <small>IDR</small>
                            <span style="font-size: 1.5rem;">0</span>
                          </div>
                        </div>
                      </div>
                      <button class="btn btn-secondary mt-4 w-100" disabled>Cetak PO</button>
                    </div>
                    <div class="col-md-4">
                      <div class="p-3 card-pricing default rounded w-100" style="height: 120px;">
                        <div class="card-pricing-title d-flex align-items-center mb-3">
                          <div class="icon rounded d-flex align-items-center justify-content-center mr-2" style="width: 28px; height: 28px">
                            <i class="fas fa-sync text-white"></i>
                          </div>
                          <h6 class="font-weight-bold title mb-0">Total Budgeting</h6>
                        </div>
                        <div class="card-pricing-body">
                          <p class="text-primary text-center mb-0">Anda tidak punya hak untuk melihat</p>
                        </div>
                      </div>
                      <button class="btn btn-secondary mt-4 w-100" disabled>Customer PO</button>
                    </div>
                    <div class="col-md-4">
                      <div class="p-3 card-pricing neutral rounded w-100" style="height: 120px;">
                        <div class="card-pricing-title d-flex align-items-center mb-3">
                          <div class="icon rounded d-flex align-items-center justify-content-center mr-2" style="width: 28px; height: 28px">
                            <i class="fas fa-sync"></i>
                          </div>
                          <h6 class="font-weight-bold title mb-0">Total Pricing</h6>
                        </div>
                        <div class="card-pricing-body">
                          <p class="text-primary text-center mb-0">Anda tidak punya hak untuk melihat</p>
                        </div>
                      </div>
                      <button class="btn btn-secondary mt-4 w-100" disabled>Repeat Order</button>
                    </div>
                  </div>
                  <div class="row mt-5">
                    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                      <h5 class="font-weight-bold">Informasi Quotation Shipment</h5>
                    </div>
                    <div class="col-md-12 mb-3">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="tanggal">Tanggal</label>
                          <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="1 Agustus 2024" disabled value="<?php echo date('d M Y') ?>">
                        </div>
                        <div class="col-md-6">
                          <label for="sales">Sales</label>
                          <input type="hidden" class="form-control" id="sales_id" name="sales_id" placeholder="Masukkan nama sales..." disabled value="<?php echo $_SESSION['id']; ?>">
                          <input type="text" class="form-control" id="sales" name="sales" placeholder="Masukkan nama sales..." disabled value="<?php echo $_SESSION['nama']; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label for="no_quo_shipment">Nomor QUO Shipment</label>
                          <input type="text" class="form-control" id="no_quo_shipment" name="no_quo_shipment" placeholder="-" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="total_container">Jumlah Container</label>
                          <input type="text" class="form-control text-right inputmask_qty" id="total_container" name="total_container" placeholder="0" maxlength="4" disabled>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <!-- <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-6 pt-4">
                              <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="checkboxNewCustomer" value="option1">
                                <label class="form-check-label" for="checkboxNewCustomer">Customer Baru</label>
                              </div>
                            </div>
                            <div id="customer_select" class="col-md-6">
                              <label for="jumlahContainer">Customer</label>
                              <select name="" id="customer_id" class="form-control">
                                <?php foreach ($customers as $val) { ?>
                                  <option value="<?php echo $val['CustId'] ?>"><?php echo $val['nama'] ?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div id="customer_form" class="col-md-12 mt-3" style="display: none">
                              <div class="row">
                                <div class="col-md-12 mb-3">
                                  <label for="customer_name_temp">Nama</label>
                                  <input type="text" class="form-control" id="customer_name_temp" name="customer_name_temp" placeholder="Masukkan nama customer...">
                                </div>
                                <div class="col-md-12 mb-3">
                                  <label for="customer_address_temp">Alamat</label>
                                  <input type="text" class="form-control" id="customer_address_temp" name="customer_address_temp" placeholder="Masukkan alamat customer...">
                                </div>
                                <div class="col-md-12 mb-3">
                                  <label for="pic_name_temp">PIC</label>
                                  <input type="text" class="form-control" id="pic_name_temp" name="pic_name_temp" placeholder="Masukkan nama pic...">
                                </div>
                                <div class="col-md-12 mb-3">
                                  <label for="pic_phone_temp">Telp</label>
                                  <input type="text" class="form-control inputmask_phone" id="pic_phone_temp" name="pic_phone_temp" placeholder="Masukkan no telp...">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div> -->
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-12">
                              <label for="customer_name">Customer</label>
                              <input type="hidden" class="form-control" id="customer_id" name="customer_id">
                              <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Masukkan jenis barang bawaan..." disabled>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-12">
                              <label for="item_cescription">Jenis Barang Bawaan (Opsional)</label>
                              <input type="text" class="form-control" id="item_cescription" name="item_cescription" placeholder="Masukkan jenis barang bawaan..." disabled>
                            </div>
                            <div class="col-md-12">
                              <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="is_need_trucking">
                                <label class="form-check-label" for="is_need_trucking">Membutuhkan Trucking</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="row mt-5">
                        <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                          <h5 class="font-weight-bold">Informasi Muatan</h5>
                        </div>
                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-12 mb-3">
                              <label for="master_unit_id">Jenis Container</label>
                              <input type="hidden" class="form-control" id="master_unit_id" name="master_unit_id">
                              <input type="text" class="form-control" id="master_unit_name" name="master_unit_name" placeholder="Masukkan jenis container..." disabled>
                            </div>
                            <div class="col-md-12 mb-3">
                              <label for="shipment_terms_id">Shipment Terms</label>
                              <input type="hidden" class="form-control" id="shipment_terms_id" name="shipment_terms_id">
                              <input type="text" class="form-control" id="shipment_terms_name" name="shipment_terms_name" placeholder="Masukkan shipment terms..." disabled>
                            </div>
                            <div class="col-md-12 mb-3">
                              <label for="shipment_load_type_id">Shipment Load Type</label>
                              <input type="hidden" class="form-control" id="shipment_load_type_id" name="shipment_load_type_id">
                              <input type="text" class="form-control" id="shipment_load_type_name" name="shipment_load_type_name" placeholder="Masukkan shipment load type..." disabled>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row mt-5">
                        <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                          <h5 class="font-weight-bold">Informasi Biaya Freight</h5>
                        </div>
                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-12 mb-3">
                              <label for="freight_cost">Biaya Freight</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text bg-primary text-white px-2">US$</div>
                                </div>
                                <input type="text" class="form-control text-right inputmask_currency" id="freight_cost" name="freight_cost" placeholder="0" disabled>
                              </div>
                            </div>
                            <div class="col-md-12 mb-3">
                              <label for="currency_date">Tanggal Kurs (Saat ini)</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text bg-primary text-white"><i class="far fa-calendar fa-fw"></i></div>
                                </div>
                                <input type="date" class="form-control date_single" id="currency_date" name="currency_date" placeholder="<?php echo date('d-m-Y') ?>" disabled>
                              </div>
                            </div>
                            <div class="col-md-12 mb-3">
                              <label for="currency_rate">Kurs USD - IDR (Saat ini)</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text bg-primary text-white px-2">IDR</div>
                                </div>
                                <input type="text" class="form-control text-right inputmask_currency" id="currency_rate" name="currency_rate" placeholder="0" disabled>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 mb-3">
                      <label for="note">Note</label>
                      <textarea name="" id="note" class="form-control" rows="5" placeholder="note"></textarea>
                    </div>
                  </div>
                  <div class="row mt-5">
                    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                      <h5 class="font-weight-bold">Permintaan Customer</h5>
                    </div>
                    <div class="col-md-12 mb-3">
                      <div class="table-responsive">
                        <table class="table align-items-center table-bordered" id="dataTableInfoMuatan">
                          <thead class="thead-light">
                            <tr>
                              <th class="text-nowrap px-3" style="font-size: 14px; width: 130px !important">Country Origin</th>
                              <th class="text-nowrap px-3" style="font-size: 14px; width: 130px !important">Country Destination</th>
                              <th class="text-nowrap px-3" style="font-size: 14px">Keterangan Pickup</th>
                              <th class="text-nowrap px-3" style="font-size: 14px">Keterangan Destination</th>
                            </tr>
                          </thead>
                          <tbody>
                            <td class="px-3">
                              <input type="hidden" class="form-control" id="origin_country_id" name="origin_country_id" placeholder="Masukkan origin country..." disabled>
                              <input type="text" class="form-control" id="origin_country_name" name="origin_country_name" placeholder="Masukkan origin country..." disabled>
                            </td>
                            <td class="px-3">
                              <input type="hidden" class="form-control" id="destination_country_id" name="destination_country_id" placeholder="Masukkan destination country..." disabled>
                              <input type="text" class="form-control" id="destination_country_name" name="destination_country_name" placeholder="Masukkan destination country..." disabled>
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control" id="pickup_note" name="pickup_note" placeholder="Masukkan keterangan pickup..." disabled>
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control" id="destination_note" name="destination_note" placeholder="Masukkan keterangan destination..." disabled>
                            </td>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-5">
                    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                      <h5 class="font-weight-bold">List Vendor</h5>
                      <button class="btn btn-primary" onclick="addRow()"><i class="fas fa-plus"></i></button>
                    </div>
                    <div class="col-md-12 mb-3">
                      <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-costing" type="button" role="tab" aria-controls="pills-costing" aria-selected="true">
                            Costing
                          </button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-budgeting-tab">
                            Budgeting
                          </button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-pricing-tab">
                            Pricing
                          </button>
                        </li>
                      </ul>
                      <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-costing" role="tabpanel" aria-labelledby="pills-home-tab">
                          <div class="table-responsive">
                            <table class="table align-items-center table-bordered" id="table_list_vendor">
                              <thead class="thead-light">
                                <tr>
                                  <th class="text-nowrap px-3" style="font-size: 14px;">Vendor</th>
                                  <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">1ST</th>
                                  <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">Next</th>
                                  <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">Total</th>
                                  <th class="text-nowrap" style="font-size: 14px;">&nbsp;</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td class="px-3">
                                    <select name="vendor_id" class="form-control vendor_id">
                                      <?php foreach ($vendors as $val) { ?>
                                        <option value="<?php echo $val['Id'] ?>"><?php echo $val['nama'] ?></option>
                                      <?php } ?>
                                    </select>
                                  </td>
                                  <td class="px-3">
                                    <input type="text" class="form-control text-right vendor_price_1st inputmask_currency" placeholder="0">
                                  </td>
                                  <td class="px-3">
                                    <input type="text" class="form-control text-right vendor_price_next inputmask_currency" placeholder="0">
                                  </td>
                                  <td class="px-3">
                                    <input type="text" class="form-control text-right vendor_price_total inputmask_currency" placeholder="0" disabled>
                                  </td>
                                  <td class="text-center"><button type="button" class="btn btn-danger remove-row" onclick="removeRow()"><i class="fas fa-trash"></i></button></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-5">
                    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                      <h5 class="font-weight-bold">Tambahan Biaya Handling</h5>
                    </div>
                    <div class="col-md-12 mb-3">
                      <div class="table-responsive">
                        <table class="table align-items-center table-bordered" id="table_handling_1">
                          <thead class="thead-light">
                            <tr>
                              <th class="text-nowrap px-3" style="font-size: 14px; width: 250px">
                                Nama Biaya <div> Handling 1</div>
                              </th>
                              <th class="text-nowrap px-3" style="font-size: 14px; width: 125px">
                                Qty (dari <div>Jumlah Container)</div>
                              </th>
                              <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                                Harga Budgeting <div>Handling 1</div>
                              </th>
                              <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                                Harga Pricing <div>Handling 1</div>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <td class="px-3">
                              <input type="text" class="form-control" id="handling_name_1" name="handling_name_1" placeholder="Masukkan nama biaya handling...">
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="handling_qty_1" name="handling_qty_1" placeholder="0" disabled>
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="handling_budgeting_1" name="handling_budgeting_1" placeholder="0">
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="handling_pricing_1" name="handling_pricing_1" placeholder="0" disabled>
                            </td>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-12 mb-3">
                      <div class="table-responsive">
                        <table class="table align-items-center table-bordered" id="table_handling_next">
                          <thead class="thead-light">
                            <tr>
                              <th class="text-nowrap px-3" style="font-size: 14px; width: 250px">
                                Nama Biaya
                                <div>Handling Next</div>
                              </th>
                              <th class="text-nowrap px-3" style="font-size: 14px; width: 125px">
                                Qty (dari Jumlah
                                <div> Container)</div>
                              </th>
                              <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                                Harga Budgeting
                                <div> Handling Next</div>
                              </th>
                              <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                                Harga Pricing
                                <div> Handling Next</div>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <td class="px-3">
                              <input type="text" class="form-control" id="handling_name_next" name="handling_name_next" placeholder="Masukkan nama biaya handling...">
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="handling_qty_next" name="handling_qty_next" placeholder="0" disabled>
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="handling_budgeting_next" name="handling_budgeting_next" placeholder="0">
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="handling_pricing_next" name="handling_pricing_next" placeholder="0" disabled>
                            </td>
                          </tbody>
                          <tfoot>
                            <td class="px-3" colspan="2"></td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="total_handling_budgeting" name="total_handling_budgeting" placeholder="0" disabled>
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="total_handling_pricing" name="total_handling_pricing" placeholder="0" disabled>
                            </td>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-12 mt-3">
                      <button id="btn_save" class="btn btn-primary w-100" onclick="updateHdQuoShipments(<?php echo $_GET['id'] ?>)">Simpan</button>
                    </div>
                    <div class="col-md-12 mt-5">
                      <div class="row">
                        <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                          <h5 class="font-weight-bold">Riwayat Perubahan</h5>
                        </div>
                        <div class="col-md-12 mb-3">
                          <table class="table align-items-center table-flush table-hover" id="dataTableInfoMuatan">
                            <thead class="thead-light">
                              <tr>
                                <th class="text-nowrap" style="font-size: 14px; width: 150px">
                                  Tanggal
                                </th>
                                <th class="text-nowrap" style="font-size: 14px">
                                  Keterangan
                                </th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <?php include 'input-status.php' ?>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="card mb-4">
                    <?php include 'input-informasi-po.php' ?>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="card mb-4">
                    <?php include 'input-perubahan-data-user.php' ?>
                  </div>
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
                    <a href="../../../../../config/logout.php" class="btn btn-primary">Logout</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Submit PO Form -->
            <div class="modal fade" id="SubmitPOFormModal" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabelSubmitPOForm" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form action="../../../../../config/controller/quotationTruckingController.php" method="post">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabelSubmitPOForm">Input PO Customer ke sistem</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Kode Customer</label>
                        <input type="text" class="form-control form-control-sm mb-3" name="customerCode" id="poCustomerCode" value="<?php isset($dataForm['IdCustomer']) ? printf($dataCustomer['kode_customer']) : '' ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label>PO Customer</label>
                        <input type="text" class="form-control form-control-sm mb-3" placeholder="Masukkan PO Customer" name="poNumber" value="" required>
                      </div>
                      <div class="form-group">
                        <label>Tanggal PO</label>
                        <input type="date" class="form-control form-control-sm mb-3" placeholder="Pilih tanggal PO" name="poDate" value="" required>
                      </div>
                      <div class="form-group">
                        <label>No SPK</label>
                        <input type="text" class="form-control form-control-sm mb-3" placeholder="Masukkan No SPK" name="spkNumber" value="" required>
                      </div>
                      <div class="form-group">
                        <label>Tanggal SPK</label>
                        <input type="date" class="form-control form-control-sm mb-3" placeholder="Pilih tanggal No SPK" name="spkDate" value="" required>
                      </div>
                      <input type="hidden" class="form-control form-control-sm mb-3" name="totalArmada" value="<?php echo $dataForm['TotalArmada'] ?>">
                      <input type="hidden" class="form-control form-control-sm mb-3" name="originCity" value="<?php echo $dataForm['IdPickupCity'] ?>">
                      <input type="hidden" class="form-control form-control-sm mb-3" name="destinationCity" value="<?php echo $dataForm['IdDestinationCity1'] ?>">
                      <input type="hidden" class="form-control form-control-sm mb-3" name="destinationCity2" value="<?php echo $dataForm['IdDestinationCity2'] ?>">
                      <input type="hidden" class="form-control form-control-sm mb-3" name="destinationCity3" value="<?php echo $dataForm['IdDestinationCity3'] ?>">
                      <input type="hidden" class="form-control form-control-sm mb-3" name="originCityDesc" value="<?php echo $dataForm['PickupNote'] ?>">
                      <input type="hidden" class="form-control form-control-sm mb-3" name="destinationCityDesc" value="<?php echo $dataForm['DestinationNote'] ?>">
                      <input type="hidden" class="form-control form-control-sm mb-3" name="item" value="<?php echo $dataForm['ItemType'] ?>">
                      <input type="hidden" class="form-control form-control-sm mb-3" name="qty" value="<?php echo $dataForm['qty'] ?>">
                      <input type="hidden" class="form-control form-control-sm mb-3" name="idQuo" value="<?php echo $dataForm['Id'] ?>">
                    </div>
                    <div class="modal-footer">
                      <div class="col-12">
                        <div class="row">
                          <div class="col-12 col-lg-6">
                            <button type="button" class="btn btn-danger col-12" data-dismiss="modal">Batal</button>
                          </div>
                          <div class="col-12 col-lg-6">
                            <button type="submit" class="btn btn-primary col-12" name="generateTrucking" id="generateTrucking">Simpan</button>
                          </div>
                        </div>
                      </div>
                      <!-- <a href="../../config/logout.php" class="btn btn-primary">Logout</a> -->
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Modal Submit CustomerCode Form -->
            <div class="modal fade" id="SubmitNewCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelSubmitPOForm" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelSubmitPOForm">Input Kode Customer ke sistem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label>Kode Customer</label>
                      <input type="text" class="form-control form-control-sm mb-3" name="customerCode" id="poCustomerCodeTemp" value="">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <div class="col-12">
                      <div class="row">
                        <div class="col-12 col-lg-6">
                          <button type="button" class="btn btn-danger col-12" data-dismiss="modal">Batal</button>
                        </div>
                        <div class="col-12 col-lg-6">
                          <button type="button" class="btn btn-primary col-12" id="submitCustomerCodeBtn">Simpan</button>
                        </div>
                      </div>
                    </div>
                    <!-- <a href="../../config/logout.php" class="btn btn-primary">Logout</a> -->
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
              <span>&copy; <script>
                  document.write(new Date().getFullYear());
                </script>
              </span>
            </div>
          </div>
        </footer>
        <!-- Footer -->
      </div>
    </div>

    <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 1060; right: 0; top: 0;">
      <div id="CustomerSearchAlertToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
        <div class="toast-body">
          Kode Customer tidak ditemukan
        </div>
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
    <script src="../../../../../vendor/inputmask/dist/jquery.inputmask.js"></script>
    <!-- Page level plugins -->
    <script src="../../../../../vendor/datatables1/jquery.dataTables.min.js"></script>
    <script src="../../../../../vendor/datatables1/datatables.min.js"></script>
    <script src="../../../../../vendor/select2/dist/js/select2.min.js"></script>
    <script src="../../../../../vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="../../../../../vendor/toastr/build/toastr.min.js"></script>
    <script src="../../../../../vendor/flatpickr/dist/flatpickr.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>-->

    <!-- Page level custom scripts -->
    <script>
      $(document).ready(function() {
        $('.inputmask_currency').inputmask('numeric', {
          digits: 0,
          groupSeparator: '.',
          autoUnmask: true,
          stripLeadingZeroes: false,
        });

        $('.date_single').flatpickr({
          defaultDate: new Date(),
        });

        $('.select2_vendor').select2({
          placeholder: 'Pilih Vendor',
          width: '100%',
        });

        $('#table_handling_1').on('keyup', '#handling_budgeting_1', function() {
          let row = $(this).closest('tr');
          let handling_budgeting_1 = parseFloat(row.find('#handling_budgeting_1').val()) || 0;
          let handling_qty_1 = parseFloat(row.find('#handling_qty_1').val()) || 0;
          let total = handling_budgeting_1 * (handling_qty_1-1);
          row.find('#handling_pricing_1').val(total);
          setCalcTotalHandling();
        });

        $('#table_handling_next').on('keyup', '#handling_budgeting_next', function() {
          let row = $(this).closest('tr');
          let handling_budgeting_next = parseFloat(row.find('#handling_budgeting_next').val()) || 0;
          let handling_qty_next = parseFloat(row.find('#handling_qty_next').val()) || 0;
          let total = handling_budgeting_next * (handling_qty_next-1);
          row.find('#handling_pricing_next').val(total);
          setCalcTotalHandling();
        });

        $('#table_list_vendor').on('keyup', '.vendor_price_1st, .vendor_price_next', function() {
          let row = $(this).closest('tr');
          let vendor_price_1st = parseFloat(row.find('.vendor_price_1st').val()) || 0;
          let vendor_price_next = parseFloat(row.find('.vendor_price_next').val()) || 0;
          let total = vendor_price_1st + vendor_price_next;
          row.find('.vendor_price_total').val(total);
        });

        let id = '<?php echo $_GET['id']; ?>';

        getHdQuoShipmentDetails(id);

        function getHdQuoShipmentDetails(id) {
          $.ajax({
            url: '<?php echo $base_url; ?>/config/controller/quotationShipments/quotationShipmentController.php',
            type: 'GET',
            data: {
              method: 'getHdQuoShipmentDetails',
              id: id,
            },
            success: function(response) {
              console.log(`RESP: ${response}`);
              let resp = JSON.parse(response);
              $('#sales').val(resp.sales_name);
              $('#sales_id').val(resp.sales_id);
              $('#no_quo_shipment').val(resp.no_quotation);
              $('#total_container').val(resp.total_container);
              $('#item_cescription').val(resp.item_cescription);
              $('#customer_name').val(resp.customer_name);
              $('#customer_id').val(resp.customer_id);
              // $('#customer_name_temp').val();
              // $('#customer_address_temp').val();
              // $('#pic_name_temp').val();
              // $('#pic_phone_temp').val();
              $('#master_unit_id').val(resp.master_unit_id);
              $('#master_unit_name').val(resp.master_unit_name);
              $('#shipment_terms_id').val(resp.shipment_terms_id);
              $('#shipment_terms_name').val(resp.shipment_terms_name);
              $('#shipment_load_type_id').val(resp.shipment_load_type_id);
              $('#shipment_load_type_name').val(resp.shipment_load_type_name);
              $('#note').val();
              $('#origin_country_id').val(resp.origin_country_id);
              $('#origin_country_name').val(resp.origin_country_name);
              $('#destination_country_id').val(resp.destination_country_id);
              $('#destination_country_name').val(resp.destination_country_name);
              $('#pickup_note').val(resp.pickup_note);
              $('#destination_note').val(resp.destination_note);
              $('#handling_qty_1').val(resp.total_container);
              $('#handling_qty_next').val(resp.total_container);
            },
            error: function(xhr, status, error) {

            }
          });
        }

        getValidate = () => {
          if ($('#freight_cost').val() == '' || $('#freight_cost').val() == 0) {
            toastr.error('Freight tidak boleh 0', 'Required!')
            return true;
          }

          if ($('#currency_rate').val() == '' || $('#currency_rate').val() == 0) {
            toastr.error('Kurs tidak boleh 0', 'Required!')
            return true;
          }

          return false;
        };
        // Function to add a new row to the table
        addRow = () => {
          let newRow = `
            <tr>
              <td>
                <select name="vendor_id" class="form-control vendor_id">
                  <?php foreach ($vendors as $val) { ?>
                    <option value="<?php echo $val['Id'] ?>"><?php echo $val['nama'] ?></option>
                  <?php } ?>
                </select>
              </td>
              <td class="px-3">
                <input type="text" class="form-control text-right vendor_price_1st inputmask_currency" name="vendor_price_1st" placeholder="0">
              </td>
              <td class="px-3">
                <input type="text" class="form-control text-right vendor_price_next inputmask_currency" name="vendor_price_next" placeholder="0">
              </td>
              <td class="px-3">
                <input type="text" class="form-control text-right vendor_price_total inputmask_currency" name="vendor_price_total" placeholder="0" disabled>
              </td>
              <td class="text-center">
                <button type="button" class="btn btn-danger remove-row" onclick="removeRow()"><i class="fas fa-trash"></i></button>
              </td>
            </tr>
          `;
          $('#table_list_vendor tbody').append(newRow);
          // Hide the remove button for the first row
          $('.inputmask_currency').inputmask('numeric', {
            digits: 0,
            groupSeparator: '.',
            autoUnmask: true,
            stripLeadingZeroes: false,
          });
        }

        // Function to remove a row from the table
        removeRow = () => {
          $(document).on('click', '.remove-row', function() {
            if ($('#table_list_vendor tbody tr').length > 1) {
              $(this).closest('tr').remove();
            }
          });
        }

        setCalcTotalHandling = () => {
          let handling_budgeting_1 = parseFloat($('#handling_budgeting_1').val())
          let handling_pricing_1 = parseFloat($('#handling_pricing_1').val())
          let handling_budgeting_next = parseFloat($('#handling_budgeting_next').val())
          let handling_pricing_next = parseFloat($('#handling_pricing_next').val())
          $('#total_handling_budgeting').val(handling_budgeting_1+handling_budgeting_next);
          $('#total_handling_pricing').val(handling_pricing_1+handling_pricing_next);
        }

        updateHdQuoShipments = (id) => {
          // if (getValidate()) {
          //   return;
          // }

          let vendor_data = [];
          
          $('#table_list_vendor tbody tr').each(function() {
            let vendor_id = $(this).find('select.vendor_id option:selected').val();
            let vendor_price_1st = $(this).find('.vendor_price_1st').val();
            let vendor_price_next = $(this).find('.vendor_price_next').val();
            let vendor_price_total = $(this).find('.vendor_price_total').val();
            vendor_data.push({
              vendor_id: vendor_id,
              vendor_price_1st: vendor_price_1st,
              vendor_price_next: vendor_price_next,
              vendor_price_total: vendor_price_total
            });
          });

          let data = {
            method: 'updateHdQuoShipments',
            // hdQuoShipment
            id: id,
            handling_name_1: $('#handling_name_1').val(),
            handling_budgeting_1: $('#handling_budgeting_1').val(),
            handling_qty_1: $('#handling_qty_1').val(),
            handling_pricing_1: $('#handling_pricing_1').val(),
            handling_name_next: $('#handling_name_next').val(),
            handling_budgeting_next: $('#handling_budgeting_next').val(),
            handling_qty_next: $('#handling_qty_next').val(),
            handling_pricing_next: $('#handling_pricing_next').val(),
            total_handling_budgeting: $('#total_handling_budgeting').val(),
            total_handling_pricing: $('#total_handling_pricing').val(),
            vendor_data: vendor_data
          };

          console.log(`DATA: ${JSON.stringify(data)}`);

          Swal.fire({
            title: "Loading...",
            html: "Sedang menyimpan data",
            timerProgressBar: true,
            allowOutsideClick: false, // Tidak bisa ditutup dengan mengklik di luar
            allowEscapeKey: false, // Tidak bisa ditutup dengan tombol Escape
            didOpen: () => {
              Swal.showLoading();
            },
          });

          $.ajax({
            url: '<?php echo $base_url; ?>/config/controller/quotationShipments/quotationShipmentController.php',
            type: 'POST',
            data: data,
            success: function(response) {
              console.log(`RESP: ${response}`);
              let resp = JSON.parse(response);
              console.log(`RESP: ${resp.data}`);
              if (resp.status == 200) {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: 'Data berhasil disimpan',
                }).then(() => {
                  window.location.href = '<?php echo $base_url; ?>/view/vm/quotation/shipment/index.php';
                });
              }
            },
            error: function(xhr, status, error) {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat menyimpan data',
              });
            }
          });
        }
      });
    </script>
</body>

</html>