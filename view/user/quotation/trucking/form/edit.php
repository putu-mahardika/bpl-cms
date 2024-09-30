<?php
  session_save_path('../../../../../tmp');
  session_start();

  if ($_SESSION['hak_akses'] == "" || $_SESSION['hak_akses'] != "User") {
    header("location:../../../../../index.php?pesan=belum_login");
  }
  include '../../../../../config/koneksi.php';
  date_default_timezone_set("Asia/Jakarta");

  $s_id = $_SESSION['id'];
  $datetime = date('Y');
  $cityArray= [];
  $kendaraanArray= [];
  $customerArray=[];
  $vendorArray=[];
  $detailArray=[];
  $logArray=[];

  $queryMasterCustomer = 'select * from master_customer where aktif=1';
  $fetchMasterCustomer = mysqli_query($koneksi, $queryMasterCustomer);

  $queryMasterKendaraan = 'select * from master_kendaraan where IsActive=1 and IsDelete=0';
  $fetchMasterKendaraan = mysqli_query($koneksi, $queryMasterKendaraan);

  $queryMasterKota = 'select * from master_kota where aktif=1';
  $fetchMasterKota = mysqli_query($koneksi, $queryMasterKota);

  $queryMasterVendor = 'select * from master_vendor where isActive=1 and isDelete=0';
  $fetchMasterVendor = mysqli_query($koneksi, $queryMasterVendor);

  while($row = $fetchMasterKota->fetch_assoc()) {
    $cityArray[] = $row;
  }

  while($row = $fetchMasterKendaraan->fetch_assoc()) {
    $kendaraanArray[] = $row;
  }

  while($row = $fetchMasterCustomer->fetch_assoc()) {
    $customerArray[] = $row;
  }

  while($row = $fetchMasterVendor->fetch_assoc()) {
    $vendorArray[] = $row;
  }

  $id = $_GET['id'];
  $fetch = mysqli_query($koneksi, "select * from master_quotation_trucking where Id='$id'");
  $dataForm = mysqli_fetch_array($fetch);

  $salesId = $dataForm['IdSales'];
  $statusId = $dataForm['IdQuoStatus'];
  $quoId = $dataForm['Id'];

  $fetchSales = mysqli_query($koneksi, "select * from master_user where UserId='$salesId'");
  $dataSales = mysqli_fetch_array($fetchSales);

  if (isset($dataForm['IdVM']) && $dataForm['IdVM'] !== '' && $dataForm['IdVM'] !== 0 && $dataForm['IdVM'] !== null) {
    $vmId = $dataForm['IdVM'];
    $fetchVM = mysqli_query($koneksi, "select * from master_user where UserId='$vmId'");
    $dataVM = mysqli_fetch_array($fetchVM);
  }

  if (isset($dataForm['IdSales']) && $dataForm['IdSales'] != '' && $dataForm['IdSales'] != 0 && $dataForm['IdSales'] != null) {
    $salesId = $dataForm['IdSales'];
    $fetchSales = mysqli_query($koneksi, "select * from master_user where UserId='$salesId'");
    $dataSales = mysqli_fetch_array($fetchSales);
  }

  if (isset($dataForm['quoDetailVendorId'])) {
    $detailId = $dataForm['quoDetailVendorId'];
    $fetchVendor = mysqli_query($koneksi, "select qdt.*, mv.nama as nama from master_vendor mv, quotation_detail_trucking qdt where qdt.IdVendor=mv.Id and qdt.Id='$detailId' LIMIT 1");
    $dataVendor = mysqli_fetch_assoc($fetchVendor);
  }

  if (isset($dataForm['IdCustomer'])) {
    $customerId = $dataForm['IdCustomer'];
    $fetchCustomer = mysqli_query($koneksi, "select * from master_customer where CustId='$customerId'");
    $dataCustomer = mysqli_fetch_assoc($fetchCustomer);
  }

  $fetchStatus = mysqli_query($koneksi, "select * from master_quo_status where Id='$statusId'");
  $dataStatus = mysqli_fetch_array($fetchStatus);

  $fetchDetailQuo = mysqli_query($koneksi, "select * from quotation_detail_trucking where IdQuotation='$quoId'");
  while($row = $fetchDetailQuo->fetch_assoc()) {
    $detailArray[] = $row;
  }

  // $fetchLog = mysqli_query($koneksi, "select * from quotation_log where IdQuoTrucking='$quoId' order by created_date desc limit 20");
  $queryLog = "select ql.created_date,
       ql.IdQuoTrucking,
       ql.IdQuoShipment,
       ql.NoQuotation,
       ql.IdUser,
       case
           when mu2.isAdmin = 1 then
               ql.Note
           else
               CONCAT('[ ', mu.nama, ' ] ', ql.Action)
           end as Action
from quotation_log ql
inner join master_user mu on ql.IdUser = mu.UserId
left join master_user mu2 on mu2.UserId = '".$s_id."'
where (ql.IdQuoTrucking = '".$quoId."')
order by ql.created_date desc
limit 20;";
  $fetchLog = mysqli_query($koneksi, $queryLog);
  while($row = $fetchLog->fetch_assoc()) {
    $logArray[] = $row;
  }

  if ($dataForm['IdQuoStatus'] == 14) {
    $quoId = $dataForm['Id'];
    $fetchTrucking = mysqli_query($koneksi, "select * from trans_hd where IdQuotation='$quoId'");
    $dataTrucking = mysqli_fetch_assoc($fetchTrucking);
  }

  // print_r($logArray);
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
  <link rel="stylesheet" href="./infocard.css">
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
    ul.logList {
      display: flex;
      flex-direction: column;
      list-style: none;
      padding-left: 10px;
      
    }

    .logList li {
      display: block;
      border-left: 2px solid #bbb;
      padding-left: 11px;
      padding-bottom: 10px;
      font-size: 13px;
    }

    .logList li.main {
      font-weight: bold;
      padding-bottom: 20px;
      color: #6777ef;
      font-size: 18px;
    }

    .logList li::before {
      content: "";
      width: 10px;
      height: 10px;
      background-color: #bbb;
      display: inline-block;
      border-radius: 6px;
      position: relative;
      margin-left: -17px;
      margin-right: 10px;
      margin-top: 3px;
    }

    .logList li.main::before {
      content: "";
      width: 14px;
      height: 14px;
      background-color: #6777ef;
      display: inline-block;
      border-radius: 15px;
      position: relative;
      top: 3px;
      margin-left: -19px;
      margin-right: 10px;
      border: 1px solid #6777ef;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php?tahun=<?php echo $datetime?>">
        <div class="sidebar-brand-icon">
          <img src="../../../../../img/logo-BPL-white-min.png" style="height:130px;">
        </div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item">
        <a class="nav-link" href="../../../dashboard.php?tahun=<?php echo $datetime?>">
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
            <div class="col-xl-8 col-lg-8">
              <div class="card mb-4">
                <div class="card-body">
                  <?php if(isset($_SESSION['pesan'])){?><?php echo $_SESSION['pesan']; unset($_SESSION['pesan']);}?>
                  <form role="form" id="quoTruckForm" method="post" action="../../../../../config/controller/quotationTruckingController.php">
                    <!-- <?php if ($dataForm['IdQuoStatus'] >= 10) { ?>
                    <div class="mb-3" style="color: #6E6E6E; font-size: 18px; font-weight: 700;">Vendor Terpilih : <?php isset($dataForm['quoDetailVendorId']) || $dataForm['quoDetailVendorId'] != 0 ? printf($dataVendor['nama']) : printf('-') ?></div>
                    <?php } ?> -->
                    <div class="mb-3">
                      <div class="row">
                        <!-- <div class="col-lg-4">
                          <div class="p-3" style="background-color: #C8CEF4; border-radius: 10px;">
                            <div class="d-flex align-items-center mb-3">
                              <div class="mr-3" style="background-color: #4C60DA; border-radius: 10px; padding: 5px 7px;">
                                <img src="../../../../../img/Icon.png" alt="cycle">
                              </div>
                              <div style="font-size: 16px; font-weight: 700; color: #4557C6;">Total Costing</div>
                            </div>
                            <div style="font-size: 12px; color: #4557C6;">IDR <span style="font-size: 20px; font-weight: 600;" id="nominalCosting"><?php isset($dataForm['quoDetailVendorId']) && $dataForm['quoDetailVendorId'] != '' && $dataForm['quoDetailVendorId'] != 0 && $dataForm['quoDetailVendorId'] != null ? printf($dataVendor['CostingTotalPrice']) : printf('0') ?></span></div>
                          </div>
                        </div> -->
                        <div class="col-lg-6">
                          <div class="p-3" style="background-color: #D6E8EE; border-radius: 10px;">
                            <div class="d-flex align-items-center mb-3">
                              <div class="mr-3" style="background-color: #7CB5C7; border-radius: 10px; padding: 5px 7px;">
                                <img src="../../../../../img/Icon.png" alt="cycle">
                              </div>
                              <div style="font-size: 16px; font-weight: 700; color: #71A5B5;">Total Budgeting</div>
                            </div>
                            <div style="font-size: 12px; color: #71A5B5;">IDR <span style="font-size: 20px; font-weight: 600;" id="nominalBudgeting"><?php isset($dataForm['quoDetailVendorId']) && $dataForm['quoDetailVendorId'] != '' && $dataForm['quoDetailVendorId'] != 0 && $dataForm['quoDetailVendorId'] != null ? printf($dataVendor['BudgetingTotalPrice']) : printf('0') ?></span></div>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          
                          <?php if (isset($dataForm['quoDetailVendorId']) && $dataForm['quoDetailVendorId'] != '' && $dataForm['quoDetailVendorId'] != 0 && $dataForm['quoDetailVendorId'] != null) { ?>
                            <?php if ($dataVendor['PricingTotalPrice'] < $dataVendor['CostingTotalPrice']) { ?>
                              <div class="p-3 pricing-card below-costing" id="pricing-card" style="border-radius: 10px;">
                            <?php } elseif ($dataVendor['PricingTotalPrice'] < $dataVendor['BudgetingTotalPrice']) { ?>
                              <div class="p-3 pricing-card below-budget" id="pricing-card" style="border-radius: 10px;">
                            <?php } elseif ($dataVendor['PricingTotalPrice'] > $dataVendor['CostingTotalPrice']) { ?>
                              <div class="p-3 pricing-card above" id="pricing-card" style="border-radius: 10px;">
                            <?php } else { ?>
                              <div class="p-3 pricing-card" id="pricing-card" style="border-radius: 10px;">
                            <?php } ?>
                          <?php } else {?>
                          <div class="p-3 pricing-card" id="pricing-card" style="border-radius: 10px;">
                          <?php } ?>
                            <div class="d-flex align-items-center mb-3">
                              <div class="icon mr-3" style="border-radius: 10px; padding: 5px 7px;">
                                <img src="../../../../../img/Icon.png" alt="cycle">
                              </div>
                              <div class="title" style="font-size: 16px; font-weight: 700;">Total Pricing</div>
                            </div>
                            <div class="nominal" style="font-size: 12px;">IDR <span style="font-size: 20px; font-weight: 600;" id="nominalPricing"><?php isset($dataForm['quoDetailVendorId']) && $dataForm['quoDetailVendorId'] != '' && $dataForm['quoDetailVendorId'] != 0 && $dataForm['quoDetailVendorId'] !== null ? printf($dataVendor['PricingTotalPrice']) : printf('0') ?></span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mb-3">
                      <div class="row">
                        <div class="col-lg-4">
                          <?php if ($dataForm['IdQuoStatus'] >= 10) { ?>
                            <a class="btn btn-info" style="width: 100%;" type="button" target="_blank" href="../../../../generateQuo/trucking/quo.php?quo=<?php echo $dataForm['NoQuotation'] ?>">Cetak Quo</a>
                          <?php } else { ?>
                            <button class="btn btn-info" style="width: 100%;" type="button" disabled>Cetak Quo</button>
                          <?php } ?>
                        </div>
                        <div class="col-lg-4">
                          <button class="btn btn-warning" style="width: 100%;" type="button" data-toggle="modal" <?php isset($dataForm['IdCustomer']) ? printf('data-target="#SubmitPOFormModal"') : printf('data-target="#SubmitNewCustomer"') ?> data-target="#SubmitPOFormModal" <?php $dataForm['IdQuoStatus'] == 10 ? printf('') : printf('disabled') ?>>Customer PO</button>
                        </div>
                        <div class="col-lg-4">
                          <button class="btn btn-success" style="width: 100%;" type="button" <?php $dataForm['IdQuoStatus'] == 14 ? printf('') : printf('disabled') ?>>Repeat Order</button>
                        </div>
                      </div>
                    </div>
                    <div class="mb-5">
                      <div class="mb-5">
                        <p class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Informasi Quotation Trucking</p>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="row">
                              <div class="col-4">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="" id="customerCheck" <?php isset($dataForm['IdCustomer']) && $dataForm['IdCustomer'] !== 0 ? printf('') : printf('checked') ?>>
                                  <label class="form-check-label" for="customerCheck">
                                    Customer Baru
                                  </label>
                                </div>
                              </div>
                              <div class="col-8">
                                <div id="customerField" class="<?php $dataForm['IdCustomer'] ? printf('') : printf('hidden') ?>">
                                  <div class="form-group">
                                    <label>Customer :</label>
                                    <select class="select2-single-placeholder form-control" name="customer" id="customer">
                                      <option value="" disabled selected>Pilih</option>
                                      <?php
                                        foreach($customerArray as $data){
                                          if($data['aktif']==1){
                                            if ($data['CustId'] == $dataForm['IdCustomer']){
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
                                <div id="customerTempField" class="<?php $dataForm['CustomerNameTemp'] ? print('') : printf('hidden') ?>">
                                  <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerTempName" id="customerTempName" placeholder="Masukkan nama customer" value="<?php echo $dataForm['CustomerNameTemp'] ?>">
                                  </div>
                                  <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerAddressTemp" id="customerAddressTemp" placeholder="Masukkan alamat customer" value="<?php echo $dataForm['CustomerAddressTemp'] ?>">
                                  </div>
                                  <div class="form-group">
                                    <label>PIC</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerPicTemp" id="customerPicTemp" placeholder="Masukkan nama PIC customer" value="<?php echo $dataForm['PICNameTemp'] ?>">
                                  </div>
                                  <div class="form-group">
                                    <label>Telp</label>
                                    <input type="text" class="form-control form-control-sm mb-3" name="customerPicPhoneTemp" id="customerPicPhoneTemp" placeholder="Masukkan telepon PIC customer" value="<?php echo $dataForm['PICPhoneTemp'] ?>">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>Jumlah Armada</label>
                              <input type="number" class="form-control form-control-sm mb-3" id="totalArmada" name="totalArmada" placeholder="Masukkan jumlah armada" min="1" value="<?php echo $dataForm['TotalArmada'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label>Jenis Barang Bawaan</label>
                              <input type="text" class="form-control form-control-sm mb-3" name="itemType" placeholder="Masukkan jenis barang bawaan" value="<?php echo $dataForm['ItemType'] ?>" required>
                            </div>
                            <div class="form-group">
                              <label>Total Berat (Kg) KGM/CBM</label>
                              <input type="number" class="form-control form-control-sm mb-3" id="weight" name="weight" placeholder="Masukkan total berat" min="1" value="<?php echo $dataForm['Weight'] ?>" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Keterangan :</label>
                          <textarea type="text" class="form-control form-control-sm mb-3" name="keterangan" minlength="10" maxlength="100"><?php echo $dataForm['note'] ?></textarea>
                        </div>
                        <div class="form-group">
                          <input type="hidden" class="form-control form-control-sm mb-3" id="selectedTab" name="selectedTab" value="<?php if($dataForm['TripType'] == 'multiTrip') { printf('1'); } else if ($dataForm['TripType'] == 'kgm' || $dataForm['TripType'] == 'cbm') { printf('2'); } else { printf('0'); } ?>">
                        </div>
                      </div>
                      <div class="mb-5">
                        <div class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Jenis Trip : <?php if ($dataForm['TripType'] == 'singleTrip') { printf('Single Trip'); } else if ($dataForm['TripType'] == 'multiTrip') { printf('Multi Trip'); } else { printf('KGM/CBM'); } ?></div>
                        <div class="table-responsive">
                          <?php if ($dataForm['TripType'] == 'singleTrip') { ?>
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
                                    <select class="form-control" name="kendaraan" id="kendaraan" style="width: 200px;">
                                      <option value="" disabled>Pilih</option>
                                      <?php
                                        foreach($kendaraanArray as $data){
                                          if($data['IsActive']==1){
                                            if ($data['Id'] == $dataForm['IdKendaraan']) {
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
                                    <select class="form-control" name="kotaAsal" id="kotaAsal" style="width: 200px;">
                                      <option value="" disabled>Pilih</option>
                                      <?php
                                        foreach($cityArray as $data){
                                          if($data['aktif']==1){
                                            if ($data['Id'] == $dataForm['IdPickupCity']) {
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
                                    <select class="form-control" name="kotaTujuan1" id="kotaTujuan1" style="width: 200px;">
                                      <option value="" disabled>Pilih</option>
                                      <?php
                                        foreach($cityArray as $data){
                                          if($data['aktif']==1){
                                            if($data['Id'] == $dataForm['IdDestinationCity1']){
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
                                    <textarea type="text" class="form-control form-control-sm mb-3" style="width: 150px;" name="detailKotaAsal0" id="detailKotaAsal0" minlength="3" maxlength="100"><?php echo $dataForm['PickupNote'] ?></textarea>    
                                  </td>
                                  <td>
                                    <textarea type="text" class="form-control form-control-sm mb-3" style="width: 150px;" name="detailKotaTujuan0" id="detailKotaTujuan0" minlength="3" maxlength="100"><?php echo $dataForm['DestinationNote'] ?></textarea>    
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          <?php } else if ($dataForm['TripType'] == 'multiTrip') { ?>
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
                                    <select class="form-control" name="kendaraan" id="kendaraan" style="width: 200px;">
                                      <option value="" disabled>Pilih</option>
                                      <?php
                                        foreach($kendaraanArray as $data){
                                          if($data['IsActive']==1){
                                            if($data['Id'] == $dataForm['IdKendaraan']) {
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
                                    <select class="form-control" name="kotaAsal" id="kotaAsal" style="width: 200px;">
                                      <option value="" disabled>Pilih</option>
                                      <?php
                                        foreach($cityArray as $data){
                                          if($data['aktif']==1){
                                            if($data['Id'] == $dataForm['IdPickupCity']){
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
                                    <select class="form-control" name="kotaTujuan1" id="kotaTujuan1" style="width: 200px;">
                                      <option value="" disabled <?php !isset($dataFrom ['IdDestinationCity1']) ? printf('selected') : printf('') ?>>Pilih</option>
                                      <?php
                                        foreach($cityArray as $data){
                                          if($data['aktif']==1){
                                            if($data['Id'] == $dataForm['IdDestinationCity1']){
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
                                    <select class="form-control" name="kotaTujuan2" id="kotaTujuan2" style="width: 200px;">
                                      <option value="" disabled <?php !isset($dataFrom ['IdDestinationCity2']) ? printf('selected') : printf('') ?>>Pilih</option>
                                      <?php
                                        foreach($cityArray as $data){
                                          if($data['aktif']==1){
                                            if($data['Id'] == $dataForm['IdDestinationCity2']){
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
                                    <select class="form-control" name="kotaTujuan3" id="kotaTujuan3" style="width: 200px;">
                                      <option value="" disabled <?php !isset($dataFrom ['IdDestinationCity3']) ? printf('selected') : printf('') ?>>Pilih</option>
                                      <?php
                                        foreach($cityArray as $data){
                                          if($data['aktif']==1){
                                            if($data['Id'] == $dataForm['IddestinationCity3']){
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
                                    <textarea type="text" class="form-control form-control-sm mb-3" style="width: 150px;" name="detailKotaAsal1" id="detailKotaAsal1" minlength="3" maxlength="100"><?php echo $dataForm['PickupNote'] ?></textarea>    
                                  </td>
                                  <td>
                                    <textarea type="text" class="form-control form-control-sm mb-3" style="width: 150px;" name="detailKotaTujuan1" id="detailKotaTujuan1" minlength="3" maxlength="100"><?php echo $dataForm['DestinationNote'] ?></textarea>    
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          <?php } else { ?>
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
                                      <option value="" disabled <?php !isset($dataFrom ['deliveryTypeName']) ? printf('selected') : printf('') ?>>Pilih</option>
                                      <option value="kgm" <?php $dataForm['TripType'] == 'kgm' ? printf('selected') : printf('') ?>>KGM</option>
                                      <option value="cbm" <?php $dataForm['TripType'] == 'cbm' ? printf('selected') : printf('') ?>>CBM</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm mb-3" style="width: 100px;" name="qty" id="qty" placeholder="masukkan jumlah barang" min="0" value="<?php echo $dataForm[36] ?>">
                                  </td>
                                  <td>
                                    <select class="form-control" name="kotaAsal" id="kotaAsal" style="width: 200px;">
                                      <option value="" disabled selected>Pilih</option>
                                      <?php
                                        foreach($cityArray as $data){
                                          if($data['aktif']==1){
                                            if($data['Id'] == $dataForm['IdPickupCity']){
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
                                    <select class="form-control" name="kotaTujuan1" id="kotaTujuan1" style="width: 200px;">
                                      <option value="" disabled>Pilih</option>
                                      <?php
                                        foreach($cityArray as $data){
                                          if($data['aktif']==1){
                                            if($data['Id'] == $dataForm['IdDestinationCity1']){
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
                                    <textarea type="text" class="form-control form-control-sm mb-3" style="width: 150px;" name="detailKotaAsal2" id="detailKotaAsal2" minlength="3" maxlength="100"><?php echo $dataForm['PickupNote'] ?></textarea>    
                                  </td>
                                  <td>
                                    <textarea type="text" class="form-control form-control-sm mb-3" style="width: 150px;" name="detailKotaTujuan2" id="detailKotaTujuan2" minlength="3" maxlength="100"><?php echo $dataForm['DestinationNote'] ?></textarea>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          <?php } ?>
                        </div>
                      </div>
                      
                      <div class="" style="margin-bottom: 60px;">
                        <div>
                          <?php if ($dataForm['budgeting_date']) { ?>
                          <div class="mb-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="pricing-tab" data-toggle="tab" href="#pricing" role="tab" aria-controls="pricing" aria-selected="false">Pricing</a>
                              </li>
                            </ul>
                            <div class="tab-content mt-3" id="myTabContent">
                              <div class="tab-pane fade show active" id="pricing" role="tabpanel" aria-labelledby="pricing-tab">
                                <div class="d-flex align-items-end gap-3 ">
                                  <?php if ($dataForm['TripType'] !== 'singleTrip') { ?>
                                  <div class="form-group">
                                    <label>Harga Pricing First</label>
                                    <input type="number" class="form-control form-control-sm" placeholder="Masukkan harga pricing first" id="allPricingFirst" min="0" value="0">
                                  </div>
                                  <div class="form-group" style="margin-bottom: 16px;">
                                    <label>Harga Pricing Next</label>
                                    <input type="number" class="form-control form-control-sm ml-2" placeholder="Masukkan harga pricing next" id="allPricingNext" min="0" value="0">
                                  </div>
                                  <?php } else { ?>
                                    <div class="form-group">
                                    <label>Harga Pricing</label>
                                    <input type="number" class="form-control form-control-sm" placeholder="Masukkan harga pricing" id="allPricingFirst" min="0" value="0">
                                  </div>
                                  <?php } ?>
                                  <div style="margin-bottom: 16px; margin-left: 16px;">
                                    <button type="button" class="btn btn-primary btn-icon-split" id="xxx">
                                      <span class="icon text-white-50">
                                        <i class="fas fa-plus"></i>
                                      </span>
                                      <span class="text">Apply All</span>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php } ?>
                          <div class="mb-1 d-flex justify-content-between">
                            <p class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">List Rekomendasi Vendor</p>
                          </div>
                          <?php if ($dataForm['TripType'] === 'singleTrip') { ?>
                          <div class="table-responsive">
                            <table class="table align-items-center table-flush table-hover vendorTable">
                              <thead class="thead-light">
                                <tr>
                                  <th colspan="2">Budgeting</th>
                                  <th colspan="2">Pricing</th>
                                  <th rowspan="2">Action</th>
                                </tr>
                                <tr>
                                  <th>Price</th>
                                  <th>Total</th>
                                  <th>Price</th>
                                  <th>Total</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php if (count($detailArray) > 0) {
                                    foreach ($detailArray as $dataDetail) {
                                ?>
                                <tr>
                                  <td>
                                    <div style="display: none;">
                                      <input class="form-check-input" type="checkbox" style="position: relative; margin-left: revert;" name="checkboxVendor" value="<?php echo $dataDetail['Id']?>" id="vendorCheck" <?php $dataForm['quoDetailVendorId'] == $dataDetail['Id'] ? printf('checked') : '' ?> disabled>
                                      <input name="idDetailQuo[]" type="hidden" value="<?php echo $dataDetail['Id']?>" id="idDetailQuo-<?php echo $key ?>" readonly>
                                      <select class="form-control" id="vendor-0" style="width: 200px;" disabled>
                                        <option value="" <?php isset($dataDetail['IdVendor']) ? printf('') : printf('selected') ?> disabled> Pilih </option>
                                        <?php
                                          foreach($vendorArray as $key => $data){
                                            if($data['isActive']==1){
                                              if($data['Id'] == $dataDetail['IdVendor']){
                                        ?>
                                        <option value="<?php echo $data['Id'];?>" selected><?php echo $data['nama'];?></option>
                                            <?php } else { ?>
                                        <option value="<?php echo $data['Id'];?>"><?php echo $data['nama'];?></option>
                                          <?php }} else {
                                          continue;
                                          }
                                        }
                                        ?>
                                      </select>
                                      <input type="hidden" name="vendor[]" value="<?php echo $dataDetail['IdVendor'] ?>">
                                      <input type="number" class="form-control form-control-sm costing-first" style="width: 150px;" name="costingFirst[]" id="costingFirst-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['CostingFirstPrice'] ?>" readonly>
                                      <input type="hidden" class="form-control form-control-sm costing-next" style="width: 150px;" name="costingNext[]" id="costingNext-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="0">
                                      <input type="number" class="form-control form-control-sm costing-total" style="width: 150px;" name="costingTotal[]" id="costingTotal-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['CostingTotalPrice'] ?>" readonly>
                                    </div>
                                    <input type="number" class="form-control form-control-sm budgeting-first" style="width: 150px;" name="budgetingFirst[]" id="budgetingFirst-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['BudgetingFirstPrice'] ?>" readonly>
                                    <input type="hidden" class="form-control form-control-sm budgeting-next" style="width: 150px;" name="budgetingNext[]" id="budgetingNext-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="0">
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm budgeting-total" style="width: 150px;" name="budgetingTotal[]" id="budgetingTotal-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['BudgetingTotalPrice'] ?>" readonly>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm pricing-first" style="width: 150px;" name="pricingFirst[]" id="pricingFirst-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['PricingFirstPrice'] ?>" <?php $dataForm['budgeting_date'] ? '' : printf('readonly') ?>>
                                    <input type="hidden" class="form-control form-control-sm pricing-next" style="width: 150px;" name="pricingNext[]" id="pricingNext-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="0">
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm pricing-total" style="width: 150px;" name="pricingTotal[]" id="pricingTotal-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['PricingTotalPrice'] ?>" readonly>
                                  </td>
                                  <td>
                                  <!-- <a type="button" class="btn btn-md btn-danger deleteVendor" title="Delete" data-toggle="tooltip"><i class="fas fa-trash" style="color: white;"></i></a> -->
                                  </td>
                                </tr>
                                <?php } } else {?>
                                <tr>
                                  <td>
                                    <div style="display: none;">
                                      <input class="form-check-input" type="checkbox" style="position: relative; margin-left: revert;" name="checkboxVendor-0" value="" id="customerCheck" disabled>
                                      <input name="idDetailQuo[]" type="hidden" value="" id="idDetailQuo-0" readonly>
                                      <select class="form-control" id="vendor-0" style="width: 200px;" disabled>
                                        <option value="" disabled selected>Pilih</option>
                                        <?php
                                          foreach($vendorArray as $data){
                                            if($data['isActive']==1){
                                        ?>
                                        <option value="<?php echo $data['Id'];?>"><?php echo $data['nama'];?></option>
                                        <?php } else {
                                          continue;
                                        }}
                                        ?>
                                      </select>
                                      <input type="hidden" name="vendor[]" value="">
                                      <input type="number" class="form-control form-control-sm costing-first" style="width: 150px;" name="costingFirst[]" id="costingFirst-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                      <input type="hidden" class="form-control form-control-sm costing-next" style="width: 150px;" name="costingNext[]" id="costingNext-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                      <input type="number" class="form-control form-control-sm costing-total" style="width: 150px;" name="costingTotal[]" id="costingTotal-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                    </div>
                                    <input type="number" class="form-control form-control-sm budgeting-first" style="width: 150px;" name="budgetingFirst[]" id="budgetingFirst-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                    <input type="hidden" class="form-control form-control-sm budgeting-next" style="width: 150px;" name="budgetingNext[]" id="budgetingNext-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm budgeting-total" style="width: 150px;" name="budgetingTotal[]" id="budgetingTotal-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm pricing-first" style="width: 150px;" name="pricingFirst[]" id="pricingFirst-0" placeholder="masukkan nominal" min="0" value="0" <?php $dataForm['budgeting_date'] ? '' : printf('readonly') ?>>
                                    <input type="hidden" class="form-control form-control-sm prising-next" style="width: 150px;" name="pricingNext[]" id="pricingNext-0" placeholder="masukkan nominal" min="0" value="0" <?php $dataForm['budgeting_date'] ? '' : printf('readonly') ?>>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm pricing-total" style="width: 150px;" name="pricingTotal[]" id="pricingTotal-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                  </td>
                                  <td>
                                  <!-- <a type="button" class="btn btn-md btn-danger deleteVendor" title="Delete" data-toggle="tooltip"><i class="fas fa-trash" style="color: white;"></i></a> -->
                                  </td>
                                </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                          <?php } else { ?>
                          <div class="table-responsive">
                            <table class="table align-items-center table-flush table-hover vendorTable">
                              <thead class="thead-light">
                                <tr>
                                  <th colspan="3">Budgeting</th>
                                  <th colspan="3">Pricing</th>
                                  <th rowspan="2">Action</th>
                                </tr>
                                <tr>
                                  <th>1st</th>
                                  <th>Next</th>
                                  <th>Total</th>
                                  <th>1st</th>
                                  <th>Next</th>
                                  <th>Total</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php if (count($detailArray) > 0) {
                                    foreach ($detailArray as $dataDetail) {
                                ?>
                                <tr>
                                  <td>
                                    <div style="display: none;">
                                      <input class="form-check-input" type="checkbox" style="position: relative; margin-left: revert;" name="checkboxVendor" value="<?php echo $dataDetail['Id']?>" id="vendorCheck" <?php $dataForm['quoDetailVendorId'] == $dataDetail['Id'] ? printf('checked') : '' ?> readonly>
                                      <input name="idDetailQuo[]" type="hidden" value="<?php echo $dataDetail['Id']?>" id="idDetailQuo-<?php echo $key ?>" readonly>
                                      <select class="form-control" id="vendor-0" style="width: 200px;" disabled>
                                        <option value="" <?php isset($dataDetail['IdVendor']) ? printf('') : printf('selected') ?> disabled> Pilih </option>
                                        <?php
                                          foreach($vendorArray as $key => $data){
                                            if($data['isActive']==1){
                                              if($data['Id'] == $dataDetail['IdVendor']){
                                        ?>
                                        <option value="<?php echo $data['Id'];?>" selected><?php echo $data['nama'];?></option>
                                            <?php } else { ?>
                                        <option value="<?php echo $data['Id'];?>"><?php echo $data['nama'];?></option>
                                          <?php }} else {
                                          continue;
                                          }
                                        }
                                        ?>
                                      </select>
                                      <input type="hidden" name="vendor[]" value="<?php echo $dataDetail['IdVendor'] ?>">
                                      <input type="hidden" class="form-control form-control-sm costing-first" style="width: 150px;" name="costingFirst[]" id="costingFirst-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['CostingFirstPrice'] ?>" readonly>
                                      <input type="hidden" class="form-control form-control-sm costing-next" style="width: 150px;" name="costingNext[]" id="costingNext-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['CostingNextPrice'] ?>" readonly>
                                      <input type="hidden" class="form-control form-control-sm costing-total" style="width: 150px;" name="costingTotal[]" id="costingTotal-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['CostingTotalPrice'] ?>" readonly>
                                    </div>
                                    <input type="number" class="form-control form-control-sm budgeting-first" style="width: 150px;" name="budgetingFirst[]" id="budgetingFirst-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['BudgetingFirstPrice'] ?>" readonly>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm budgeting-next" style="width: 150px;" name="budgetingNext[]" id="budgetingNext-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['BudgetingNextPrice'] ?>" readonly>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm budgeting-total" style="width: 150px;" name="budgetingTotal[]" id="budgetingTotal-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['BudgetingTotalPrice'] ?>" readonly>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm pricing-first" style="width: 150px;" name="pricingFirst[]" id="pricingFirst-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['PricingFirstPrice'] ?>">
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm pricing-next" style="width: 150px;" name="pricingNext[]" id="pricingNext-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['PricingNextPrice']?>">
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm pricing-total" style="width: 150px;" name="pricingTotal[]" id="pricingTotal-<?php echo $key ?>" placeholder="masukkan nominal" min="0" value="<?php echo $dataDetail['PricingTotalPrice'] ?>" readonly>
                                  </td>
                                  <td>
                                  <!-- <a type="button" class="btn btn-md btn-danger deleteVendor" title="Delete" data-toggle="tooltip"><i class="fas fa-trash" style="color: white;"></i></a> -->
                                  </td>
                                </tr>
                                <?php } } else {?>
                                <tr>
                                  <td>
                                    <div style="display: none;">
                                      <input class="form-check-input" type="checkbox" style="position: relative; margin-left: revert;" name="checkboxVendor-0" value="" id="customerCheck" disabled>
                                      <input name="idDetailQuo[]" type="hidden" value="" id="idDetailQuo-0" readonly>
                                      <select class="form-control" id="vendor-0" style="width: 200px;" disabled>
                                        <option value="" disabled selected>Pilih</option>
                                        <?php
                                          foreach($vendorArray as $data){
                                            if($data['isActive']==1){
                                        ?>
                                        <option value="<?php echo $data['Id'];?>"><?php echo $data['nama'];?></option>
                                        <?php } else {
                                          continue;
                                        }}
                                        ?>
                                      </select>
                                      <input type="hidden" name="vendor[]" value="">
                                      <input type="hidden" class="form-control form-control-sm costing-first" style="width: 150px;" name="costingFirst[]" id="costingFirst-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                      <input type="hidden" class="form-control form-control-sm costing-next" style="width: 150px;" name="costingNext[]" id="costingNext-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                      <input type="hidden" class="form-control form-control-sm costing-total" style="width: 150px;" name="costingTotal[]" id="costingTotal-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                    </div>
                                    <input type="number" class="form-control form-control-sm budgeting-first" style="width: 150px;" name="budgetingFirst[]" id="budgetingFirst-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm budgeting-next" style="width: 150px;" name="budgetingNext[]" id="budgetingNext-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm budgeting-total" style="width: 150px;" name="budgetingTotal[]" id="budgetingTotal-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm pricing-first" style="width: 150px;" name="pricingFirst[]" id="pricingFirst-0" placeholder="masukkan nominal" min="0" value="0">
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm prising-next" style="width: 150px;" name="pricingNext[]" id="pricingNext-0" placeholder="masukkan nominal" min="0" value="0">
                                  </td>
                                  <td>
                                    <input type="number" class="form-control form-control-sm pricing-total" style="width: 150px;" name="pricingTotal[]" id="pricingTotal-0" placeholder="masukkan nominal" min="0" value="0" readonly>
                                  </td>
                                  <td>
                                  <!-- <a type="button" class="btn btn-md btn-danger deleteVendor" title="Delete" data-toggle="tooltip"><i class="fas fa-trash" style="color: white;"></i></a> -->
                                  </td>
                                </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                          <?php } ?>
                        </div>
                      </div>
                      <input type="hidden" class="form-control form-control-sm" style="width: 150px;" name="statusId" value="<?php echo $dataForm['IdQuoStatus']?>" readonly>
                      <input type="hidden" class="form-control form-control-sm" style="width: 150px;" name="quoTruckingId" value="<?php echo $dataForm['Id']?>" readonly>
                      <input type="hidden" class="form-control form-control-sm" style="width: 150px;" name="counterTableVendor" id="counterTableVendor" value="1" readonly>
                      <input type="hidden" class="form-control form-control-sm" style="width: 150px;" name="vmIdOld" id="counterTableVendor" value="<?php echo $dataForm['IdVM'] ?>" readonly>
                      <?php if (($dataSales['isAdmin'] == 1 || $dataSales['UserId'] == $s_id) && $dataForm['IdQuoStatus'] < 10) { ?>
                      <div class="mb-3">
                        <div class="row">
                          <div class="col-lg-4">
                            <button class="btn btn-success mb-3" style="width: 100%;" type="button" <?php if($dataForm['IdQuoStatus'] == 13 || $dataForm['IdQuoStatus'] == 14 ? printf('disabled') : '') ?> >Reset</button>
                            <button class="btn btn-danger" style="width: 100%;" type="button" <?php if($dataForm['IdQuoStatus'] == 13 || $dataForm['IdQuoStatus'] == 14 ? printf('disabled') : '') ?> >Delete</button>
                          </div>
                          <div class="col-lg-8">
                            <div class="row" style="height: 100%;">
                              <div class="col-lg-5">
                                <button class="btn btn-primary" style="width: 100%; height:100%; background-color:#EA8E8E; border-color:#EA8E8E;" type="button" <?php if($dataForm['IdQuoStatus'] == 13 || $dataForm['IdQuoStatus'] == 14 ? printf('disabled') : '') ?> >Batal</button>
                              </div>
                              <div class="col-lg-7">
                                <input class="btn btn-primary" style="width: 100%; height:100%;" type="submit" value="Simpan" name="editQuoTruckingAdmin" id="editQuoTruckingAdmin" <?php if($dataForm['IdQuoStatus'] == 13 || $dataForm['IdQuoStatus'] == 14 ? printf('disabled') : '') ?> >
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </form>
                  <div class="mb-3">
                    <p class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Riwayat Perubahan</p>
                    <div class="mt-4">
                      <?php if (count($logArray) > 0) {
                          printf('<ul class="logList">');
                          foreach ($logArray as $key => $row) {
                            if ($key == 0) {
                              echo '<li class="main">';
                              echo $row['Action'] .' - ';
                              echo '<em>' . date('d-m-Y, H:i', strtotime($row['created_date'])) . '</em>';
                              echo '</li>';
                            } else {
                              echo '<li>';
                              echo $row['Action'] .' - ';
                              echo '<em>' . date('d-m-Y, H:i', strtotime($row['created_date'])) . '</em>';
                              echo '</li>';
                            }
                          }
                          echo '</ul>';
                      } else {
                          echo 'No log entries found.';
                      } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4">
              <div class="card mb-4">
                <div class="card-body">
                  <div class="mb-2" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Status</div>
                  <div class="coloredSideInfoStatus">
                    <?php echo $dataStatus['name']?>
                  </div>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-body">
                  <div class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Informasi Quo</div>
                  <div class="mb-3">
                    <div class="mb-1">Tanggal Create Quo</div>
                    <div class="sideInfo"><?php isset($dataForm['create_date']) ? printf(date("d M Y", strtotime($dataForm['create_date']))) : printf('-') ?></div>
                  </div>
                  <div class="mb-3">
                    <div class="form-group">
                      <div class="mb-1">Nama Sales</div>
                      <div class="sideInfo"><?php echo $dataSales['nama']?></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-body">
                  <div class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Informasi VM</div>
                  <div class="mb-3">
                    <div class="mb-1">Tanggal Proses VM</div>
                    <div class="sideInfo"><?php isset($dataForm['CostingDate']) ? printf(date("d M Y", strtotime($dataForm['CostingDate']))) : printf('-') ?></div>
                  </div>
                  <div class="mb-3">
                    <div class="mb-1">Nama VM</div>
                    <div class="sideInfo"><?php isset($dataForm['IdVM']) && $dataForm['IdVM'] != 0 && $dataForm['IdVM'] != '' && $dataForm['IdVM'] != null ? printf($dataVM['nama']) : printf('-') ?></div>
                  </div>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-body">
                  <div class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Informasi PO</div>
                  <div class="mb-3">
                    <div class="mb-1">Link SPK Trucking</div>
                    <?php if ($dataForm['IdQuoStatus'] == 14) { ?>
                      <a href="../../../editTransaksi.php?id=<?php echo $dataTrucking['HdId'] ?>" class="btn btn-primary" style="width: 100%;"><?php echo $dataTrucking['NoSPK'] ?></a>
                    <?php } else { ?>
                      Tidak Ada
                    <?php } ?>
                  </div>
                  <div class="mb-3">
                    <div class="mb-1">Tanggal PO</div>
                    <div class="sideInfo"><?php $dataForm['IdQuoStatus'] == 14 ? printf(date("d M Y", strtotime($dataTrucking['tgl_po']))) : printf('-') ?></div>
                  </div>
                  <div class="mb-3">
                    <div class="mb-1">Nomor PO</div>
                    <div class="sideInfo"><?php $dataForm['IdQuoStatus'] == 14 ? printf($dataTrucking['NoPO']) : printf('-') ?></div>
                  </div>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-body">
                  <div class="mb-3" style="font-size: 18px; font-weight: 700; color: #6E6E6E;">Informasi Quo Shipment</div>
                  <div class="mb-3">
                    <div class="mb-1">Link Quo Shipment</div>
                    Tidak Ada
                    <!-- <a href="#" class="btn btn-primary" style="width: 100%;">BG - S001 - 13082024</a> -->
                  </div>
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
                          <button type="button" class="btn btn-primary col-12" id="submitCustomerCodeBtn" >Simpan</button>
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
            <span>&copy; <script> document.write(new Date().getFullYear()); </script>
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

      $('#log-table').DataTable({
        dom: 'ti',
        order: [[0, "desc"]]
      });

      $('#tripTypeTab a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
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

      var table = $('.vendorTable').DataTable({
        "dom": 'rt',
        "autoWidth": true,
        "paging": false,
        "searching": false,
        "ordering": false 
      });
      let counterRow = <?php echo count($detailArray) ?>

      function getDataVendor(callback) {
        $.ajax({
          url: '../../../../../config/controller/vendorController.php',  // Endpoint to get pelanggan data
          type: 'get',
          data: {
            allData: true
          },
          dataType: 'json',
          success: function(data) {
            callback(data);
          }
        });
      }
      
      $('#addRow').on('click', function() {
        addRow();
      });
      
      function addRow() {
        counterRow++;
        getDataVendor(function(vendor) {
        <?php if ($dataForm['TripType'] !== 'singleTrip') { ?>
          var dropdown = '<select class="form-control" style="width: 200px;" name="vendor[]" id="vendor-'+counterRow+'">';
          dropdown += '<option value="" disabled selected>Pilih</option>';
          vendor.forEach(function(p) {
            dropdown += '<option value="' + p.Id + '">' + p.nama + '</option>';
          });
          dropdown += '</select>';

          var checkbox = '<input class="form-check-input" style="position: relative; margin-left: revert;" name="checkboxVendor[]" type="checkbox" value="" id="customerCheck" disabled><input name="idDetailQuo[]" type="hidden" value="" id="idDetailQuo-'+counterRow+'">';
          var actionButton = '<a type="button" class="btn btn-md btn-danger deleteVendor" title="Delete" data-toggle="tooltip"><i class="fas fa-trash" style="color: white;"></i></a>';
          var costingFirst = '<input type="number" class="form-control form-control-sm costing-first" style="width: 150px;" name="costingFirst[]" id="costingFirst-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0">';
          var costingNext = '<input type="number" class="form-control form-control-sm costing-next" style="width: 150px;" name="costingNext[]" id="costingNext-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0">';
          var costingTotal = '<input type="number" class="form-control form-control-sm costing-total" style="width: 150px;" name="costingTotal[]" id="costingTotal-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0" readonly>';
          var budgetingFirst = '<input type="number" class="form-control form-control-sm budgeting-first" style="width: 150px;" name="budgetingFirst[]" id="budgetingFirst-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0">';
          var budgetingNext = '<input type="number" class="form-control form-control-sm budgeting-next" style="width: 150px;" name="budgetingNext[]" id="budgetingNext-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0">';
          var budgetingTotal = '<input type="number" class="form-control form-control-sm budgeting-total" style="width: 150px;" name="budgetingTotal[]" id="budgetingTotal-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0" readonly>';
          var pricingFirst = '<input type="number" class="form-control form-control-sm pricing-first" style="width: 150px;" name="pricingFirst[]" id="pricingFirst-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0">';
          var pricingNext = '<input type="number" class="form-control form-control-sm pricing-next" style="width: 150px;" name="pricingNext[]" id="pricingNext-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0">';
          var pricingTotal = '<input type="number" class="form-control form-control-sm pricing-total" style="width: 150px;" name="pricingTotal[]" id="pricingTotal-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0" readonly>';

          // Add new row to the DataTable
          table.row.add([
            checkbox, dropdown,
            costingFirst, costingNext, costingTotal,
            budgetingFirst, budgetingNext, budgetingTotal,
            pricingFirst, pricingNext, pricingTotal,
            actionButton
          ]).draw(false);
        <?php } else { ?>
          var dropdown = '<select class="form-control" style="width: 200px;" name="vendor[]" id="vendor-'+counterRow+'">';
          dropdown += '<option value="" disabled selected>Pilih</option>';
          vendor.forEach(function(p) {
            dropdown += '<option value="' + p.Id + '">' + p.nama + '</option>';
          });
          dropdown += '</select>';

          var checkbox = '<input class="form-check-input" style="position: relative; margin-left: revert;" name="checkboxVendor[]" type="checkbox" value="" id="customerCheck" disabled><input name="idDetailQuo[]" type="hidden" value="" id="idDetailQuo-'+counterRow+'">';
          var actionButton = '<a type="button" class="btn btn-md btn-danger deleteVendor" title="Delete" data-toggle="tooltip"><i class="fas fa-trash" style="color: white;"></i></a>';
          var costingFirst = '<input type="number" class="form-control form-control-sm costing-first" style="width: 150px;" name="costingFirst[]" id="costingFirst-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0"><input type="hidden" class="form-control form-control-sm costing-next" style="width: 150px;" name="costingNext[]" id="costingNext-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0">';
          var costingTotal = '<input type="number" class="form-control form-control-sm costing-total" style="width: 150px;" name="costingTotal[]" id="costingTotal-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0" readonly>';
          var budgetingFirst = '<input type="number" class="form-control form-control-sm budgeting-first" style="width: 150px;" name="budgetingFirst[]" id="budgetingFirst-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0"><input type="hidden" class="form-control form-control-sm budgeting-next" style="width: 150px;" name="budgetingNext[]" id="budgetingNext-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0">';
          var budgetingTotal = '<input type="number" class="form-control form-control-sm budgeting-total" style="width: 150px;" name="budgetingTotal[]" id="budgetingTotal-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0" readonly>';
          var pricingFirst = '<input type="number" class="form-control form-control-sm pricing-first" style="width: 150px;" name="pricingFirst[]" id="pricingFirst-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0"><input type="hidden" class="form-control form-control-sm pricing-next" style="width: 150px;" name="pricingNext[]" id="pricingNext-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0">';
          var pricingTotal = '<input type="number" class="form-control form-control-sm pricing-total" style="width: 150px;" name="pricingTotal[]" id="pricingTotal-'+counterRow+'" placeholder="masukkan nominal" min="0" value="0" readonly>';

          // Add new row to the DataTable
          table.row.add([
            checkbox, dropdown,
            costingFirst, costingTotal,
            budgetingFirst, budgetingTotal,
            pricingFirst, pricingTotal,
            actionButton
          ]).draw(false);
        <?php } ?>
        });
      }

      $(document).on("click", ".deleteVendor", function(){
        $(this).parents("tr").remove();
      });



      $("table.vendorTable tbody").on('input', '.costing-first, .costing-next', function(){
        var row = $(this).closest("tr");
        calculateRowSumCosting(row);
        sumColumnCosting()
      });

      function calculateRowSumCosting(row) {
        var selectedTab = parseFloat($("#selectedTab").val()) || 0;
        var totalArmada = parseFloat($("#totalArmada").val()) || 0;
        var weight = parseFloat($("#weight").val()) || 0;
        var costingFirst = parseFloat(row.find(".costing-first").val()) || 0;
        var costingNext = parseFloat(row.find(".costing-next").val()) || 0;
        let sumCosting = 0;
        if (selectedTab == 1) {
          sumCosting = costingFirst + (costingNext * totalArmada-1);
        } else if (selectedTab == 2) {
          var qty = parseFloat($("#qty").val()) || 0;
          sumCosting = costingFirst + (costingNext * (weight-qty)); 
        } else {
          sumCosting = costingFirst * totalArmada;
        }
        // var sumCosting = costingFirst + costingNext;
        row.find(".costing-total").val(sumCosting);
      }



      $("table.vendorTable tbody").on('input', '.budgeting-first, .budgeting-next', function(){
        var row = $(this).closest("tr");
        calculateRowSumBudgeting(row);
        sumColumnBudgeting()
      });

      function calculateRowSumBudgeting(row) {
        var selectedTab = parseFloat($("#selectedTab").val()) || 0;
        var totalArmada = parseFloat($("#totalArmada").val()) || 0;
        var weight = parseFloat($("#weight").val()) || 0;
        var budgetingFirst = parseFloat(row.find(".budgeting-first").val()) || 0;
        var budgetingNext = parseFloat(row.find(".budgeting-next").val()) || 0;
        let sumBudgeting = 0;
        if (selectedTab == 1) {
          sumBudgeting = budgetingFirst + (budgetingNext * totalArmada-1);
        } else if (selectedTab == 2) {
          var qty = parseFloat($("#qty").val()) || 0;
          sumBudgeting = budgetingFirst + (budgetingNext * (weight-qty)); 
        } else {
          sumBudgeting = budgetingFirst * totalArmada;
        }
        // var sumBudgeting = budgetingFirst + budgetingNext;
        row.find(".budgeting-total").val(sumBudgeting);
      }


      $("table.vendorTable tbody").on('input', '.pricing-first, .pricing-next', function(){
        var row = $(this).closest("tr");
        calculateRowSumPricing(row);
        sumColumnPricing()
      });

      function calculateRowSumPricing(row) {
        var selectedTab = parseFloat($("#selectedTab").val()) || 0;
        var totalArmada = parseFloat($("#totalArmada").val()) || 0;
        var weight = parseFloat($("#weight").val()) || 0;
        var pricingFirst = parseFloat(row.find(".pricing-first").val()) || 0;
        var pricingNext = parseFloat(row.find(".pricing-next").val()) || 0;
        let sumPricing = 0;
        if (selectedTab == 1) {
          sumPricing = pricingFirst + (pricingNext * totalArmada-1);
        } else if (selectedTab == 2) {
          var qty = parseFloat($("#qty").val()) || 0;
          sumPricing = pricingFirst + (pricingNext * (weight-qty)); 
        } else {
          sumPricing = pricingFirst * totalArmada;
        }
        // var sumPricing = pricingFirst + pricingNext;
        row.find(".pricing-total").val(sumPricing);
      }


      let sumTotalCosting = 0;
      let sumTotalBudgeting = 0;
      let sumTotalPricing = 0;

      function sumColumnCosting() {
        var total = 0;
        
        // Iterasi setiap input di kolom tertentu berdasarkan index kolom (colIndex)
        $('table.vendorTable tbody tr').each(function() {
            var value = parseFloat($(this).find('td:eq(4) input').val()) || 0;
            total += value;
        });

        sumTotalCosting = total;
        console.log('totalCosting', sumTotalCosting);
      }

      function sumColumnBudgeting() {
        var total = 0;
        
        // Iterasi setiap input di kolom tertentu berdasarkan index kolom (colIndex)
        $('table.vendorTable tbody tr').each(function() {
            var value = parseFloat($(this).find('td:eq(7) input').val()) || 0;
            total += value;
        });

        sumTotalBudgeting = total;
        console.log('totalBudgeting', sumTotalBudgeting);
      }

      function sumColumnPricing() {
        var total = 0;
        
        // Iterasi setiap input di kolom tertentu berdasarkan index kolom (colIndex)
        $('table.vendorTable tbody tr').each(function() {
            var value = parseFloat($(this).find('td:eq(10) input').val()) || 0;
            total += value;
        });

        sumTotalPricing = total;
        console.log('totalPricing', sumTotalPricing);
      }


      $('#vendorCheck').click(function (e) {
        var row = $(this).closest("tr");
      });

      const checkboxes = document.querySelectorAll('input[type="checkbox"]#vendorCheck');

      // Tambahkan event listener ke setiap checkbox
      checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
          
          var row = $(this).closest("tr");
          var costingTotal = parseFloat(row.find(".costing-total").val()) || 0;
          var budgetingTotal = parseFloat(row.find(".budgeting-total").val()) || 0;
          var pricingTotal = parseFloat(row.find(".pricing-total").val()) || 0;

          $('#nominalCosting').html(new Intl.NumberFormat('id-ID').format(costingTotal))
          $('#nominalBudgeting').html(new Intl.NumberFormat('id-ID').format(budgetingTotal))
          $('#nominalPricing').html(new Intl.NumberFormat('id-ID').format(pricingTotal))

          if (pricingTotal < costingTotal) {
            $('#pricing-card').toggleClass('below-costing');
            if ($('#pricing-card').hasClass('below-budget')) {
              $('#pricing-card').toggleClass('below-budget');
            }
            if ($('#pricing-card').hasClass('above')) {
              $('#pricing-card').toggleClass('above');
            }
          } else if (pricingTotal < budgetingTotal) {
            $('#pricing-card').toggleClass(' below-budget');
            if ($('#pricing-card').hasClass('below-costing')) {
              $('#pricing-card').toggleClass('below-costing');
            }
            if ($('#pricing-card').hasClass('above')) {
              $('#pricing-card').toggleClass('above');
            }
          } else if (pricingTotal > costingTotal) {
            $('#pricing-card').toggleClass('above');
            if ($('#pricing-card').hasClass('below-budget')) {
              $('#pricing-card').toggleClass('below-budget');
            }
            if ($('#pricing-card').hasClass('below-costing')) {
              $('#pricing-card').toggleClass('below-costing');
            }
          } else {
            if ($('#pricing-card').hasClass('above')) {
              $('#pricing-card').toggleClass('above');
            }
            if ($('#pricing-card').hasClass('below-budget')) {
              $('#pricing-card').toggleClass('below-budget');
            }
            if ($('#pricing-card').hasClass('below-costing')) {
              $('#pricing-card').toggleClass('below-costing');
            }
          }
          
          // Jika checkbox ini di-check
          if (this.checked) {
            // Uncheck semua checkbox lainnya
            checkboxes.forEach((cb) => {
              if (cb !== this) {
                cb.checked = false;
              }
            });
          } else {
            $('#nominalCosting').html(new Intl.NumberFormat('id-ID').format(0))
            $('#nominalBudgeting').html(new Intl.NumberFormat('id-ID').format(0))
            $('#nominalPricing').html(new Intl.NumberFormat('id-ID').format(0))

            if ($('#pricing-card').hasClass('below-budget')) {
              $('#pricing-card').toggleClass('below-budget');
            }
            if ($('#pricing-card').hasClass('below-costing')) {
              $('#pricing-card').toggleClass('below-costing');
            }
            if ($('#pricing-card').hasClass('above')) {
              $('#pricing-card').toggleClass('above');
            }
          }
        });
      });

      $('#submitCustomerCodeBtn').click(function (e) {
        var x = $('#poCustomerCodeTemp').val()
        console.log('cust', x);
        console.log('sales', <?php echo $s_id; ?>);
        
        
        $.ajax({
          url: '../../../../../config/controller/customerController.php',
          type: 'get',
          data: {
            getSingleCustomerById: true,
            customerCode: x,
            salesId: <?php echo $s_id; ?>
          },
          success: function(response){
            // location.reload();
            console.log('res', response > 0);
            if (response > 0) {
              $('#poCustomerCode').val(x);
              $('#SubmitNewCustomer').modal('hide');
              $('#SubmitPOFormModal').modal('show');
            } else {
              $('#CustomerSearchAlertToast').toast('show')
            }
          }
        });
      });

      $('#xxx').click(function (e) {
        console.log('xxx');
        var selectedTab = parseFloat($("#selectedTab").val()) || 0;
        var totalArmada = parseFloat($("#totalArmada").val()) || 0;
        var weight = parseFloat($("#weight").val()) || 0;
        var pricingFirst = parseFloat($('#allPricingFirst').val()) || 0;
        var pricingNext = parseFloat($('#allPricingNext').val()) || 0;
        let sumPricing = 0;
        if (selectedTab == 1) {
          $(".pricing-first").val(pricingFirst);
          $(".pricing-next").val(pricingNext);
          sumPricing = pricingFirst + (pricingNext * (totalArmada-1));
          $(".pricing-total").val(sumPricing);
        } else if (selectedTab == 2) {
          var qty = parseFloat($("#qty").val()) || 0;
          $(".pricing-first").val(pricingFirst);
          $(".pricing-next").val(pricingNext);
          sumPricing = pricingFirst + (pricingNext * (weight-qty));
          $(".pricing-total").val(sumPricing);
        } else {
          $(".pricing-first").val(pricingFirst);
          sumPricing = pricingFirst * totalArmada;
          $(".pricing-total").val(sumPricing);
        }
      })

      if (parseFloat($("#selectedTab").val()) == 1) {
        const totalCostings = document.querySelectorAll('.costing-total');
        var values = Array.from(totalCostings).map(val => parseFloat(val.value));
        var maxCosting = Math.max(...values);
        console.log('arrayCosting', values);
        console.log('maxCosting', maxCosting);
        console.log('afterCount', maxCosting * 0.15);
        sumBudgeting = maxCosting + (maxCosting*0.15);
        $(".budgeting-first").val(sumBudgeting);
        $(".budgeting-total").val(sumBudgeting);
      }

    });

  </script>

</body>

</html>