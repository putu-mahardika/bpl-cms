<?php
  session_save_path('../../tmp');

  session_start();
  date_default_timezone_set("Asia/Jakarta");

  $datetime = date('Y');
  

  if ($_SESSION['hak_akses'] == "" || $_SESSION['hak_akses'] != "Admin") {

    header("location:../../index.php?pesan=belum_login");

  }

  include '../../config/koneksi.php';
	$tahun = $_GET['tahun'];
	
	$query = "select * from trans_hd where atr1=0 and create_date between '".$tahun."-01-01 00:00:00' and '".$tahun."-12-31 23:59:59'";
	$fetch = mysqli_query($koneksi,$query);

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

  <title>Transaksi - PT Berkah Permata Logistik</title>

  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">

  <link href="../../css/ruang-admin.min.css" rel="stylesheet">

  <link href="../../vendor/datatables1/datatables.min.css" rel="stylesheet">

  <link href="../../css/style.css" rel="stylesheet">

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
      <li class="nav-item active">
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

          <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800"> List Transaksi</h1>

			<a class="btn btn-info btn-lg " target="_blank" href="../../export/exporttransaksi.php"><i class="fas fa-print"></i></a>

            <!--<ol class="breadcrumb">

              <li class="breadcrumb-item"><a href="./">Home</a></li>

              <li class="breadcrumb-item">Tables</li>

              <li class="breadcrumb-item active" aria-current="page">Simple Tables</li>

            </ol>-->

          </div>



          <div class="row">



            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <!--<h6 class="m-0 font-weight-bold text-primary">DataTables with Hover</h6>-->
                  <a href="inputTransaksi.php" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Transaksi</span>
                  </a>
                  <div>
                    <label>Tahun: </label>
                    <input type="number" style="width:125px;" id="tahun" value="<?php echo $tahun?>" onchange="tahunUbah()">
                    <a id="tahunGo" href="" class="btn btn-primary btn-sm mb-1">GO</a>
                  </div>

                </div>

                <div class="table-responsive p-3">

				  <?php if(isset($_SESSION['pesan'])){?><?php echo $_SESSION['pesan']; unset($_SESSION['pesan']);}?>

                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">

                    <thead class="thead-light">
                      <tr>
                        <th style="padding-left:16px;">Tgl</th>
                        <th style="padding-left:16px;">Customer</th>
                        <th style="padding-left:16px;">Kode Shipment</th>
                        <th style="padding-left:16px;">PIB</th>
                        <th style="padding-left:16px;">No. PO</th>
                        <!--<th>Tgl PO</th>-->
                        <th style="padding-left:16px;">No. SPK</th>
                        <!--<th>tgl SPK</th>-->
                        <th style="padding-left:16px;">Kota Asal</th>
                        <th style="padding-left:16px;">Kota Tujuan</th>
                        <th style="padding-left:16px;">Jumlah Armada</th>
                        <!--<th>Barang</th>
                        <th>Keterangan</th>-->
                        <th style="padding-left:16px;">On Close</th>
                        <!--<th>Tgl On Close</th>-->
                        <th style="padding-left:16px;">action</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                    <?php
                      while($data = mysqli_fetch_array($fetch)){
                        $id = $data['HdId'];
                        $tgl = $data['create_date'];
                        $cancel = $data['atr1'];
                        $tgl1 = date('d-M-Y H:i:s', strtotime($tgl));
                      ?>
                      <tr>
                        <td style="font-size:13px;padding-left:16px;"><?php echo $tgl1?></td>
                        <?php
                          $query_temp = "select nama from master_customer where CustId='$data[CustId]'";
                          $fetch_temp = mysqli_query($koneksi, $query_temp);
                          $data_temp = mysqli_fetch_array($fetch_temp);
                        ?>
                        <td style="font-size:13px;padding-left:16px;"><?php echo $data_temp['nama'] ?? '-'?></td>


                        <?php if (is_null($data['id_shipment'])) { ?>
                          <td style="font-size:13px;padding-left:16px;">-</td>
                          <td style="font-size:13px;padding-left:16px;">-</td>
                        <?php } else { ?>
                        <?php 
                          $queryShipment = "select shipment_order, pib from trans_shipment where id='$data[id_shipment]'";
                          $fetchShipment = mysqli_query($koneksi, $queryShipment);
                          $dataShipment = mysqli_fetch_array($fetchShipment);
                        ?>
                          <td style="font-size:13px;padding-left:16px;"><?php echo $dataShipment['shipment_order']?></td>
                          <td style="font-size:13px;padding-left:16px;"><?php echo $dataShipment['pib']?></td>
                        <?php } ?>

                        <?php
                          if($cancel==1){
                        ?>
                        <td style="font-size:13px;padding-left:16px;"><?php echo $data['NoPO'] ?? '-'?> <p style="color:red;">(Canceled)</p> </td>
                        <?php } else { ?>
                          <td style="font-size:13px;padding-left:16px;"><?php echo $data['NoPO'] ?? '-'?></td>
                        <?php } ?>

                        <!--<td><?php echo $data['tgl_po']?></td>-->
                        <?php
                          if($cancel==1){
                        ?>
                          <td style="font-size:13px;padding-left:16px;"><?php echo $data['NoSPK'] ?? '-'?> <p style="color:red;">(Canceled)</p> </td>
                        <?php } else {?>
                          <td style="font-size:13px;padding-left:16px;"><?php echo $data['NoSPK'] ?? '-'?></td>
                        <?php } ?>

                        <!--<td><?php echo $data['tgl_spk']?></td>-->

                        <?php
                          $query_k_temp = "select Nama from master_kota where Id='$data[kota_kirim_id]'";
                          $fetch_k_temp = mysqli_query($koneksi, $query_k_temp);
                          $data_k_temp = mysqli_fetch_array($fetch_k_temp);
                        ?>
                        <td style="font-size:13px;padding-left:16px;"><?php echo $data_k_temp['Nama'] ?? '-' ?></td>

                        <?php
                          $query_k1_temp = "select Nama from master_kota where Id='$data[kota_tujuan_id]'";
                          $fetch_k1_temp = mysqli_query($koneksi, $query_k1_temp);
                          $data_k1_temp = mysqli_fetch_array($fetch_k1_temp);
                        ?>
                        <td style="font-size:13px;padding-left:16px;"><?php echo $data_k1_temp['Nama'] ?? '-' ?></td>

                        <td style="font-size:13px;padding-left:16px;"><?php echo $data['total_armada'] ?? '-'?></td>

                        <!--<td><?php echo $data['Barang']?></td>-->

                        <!--<td><?php echo $data['keterangan']?></td>-->

                      <?php 

                        if($data['OnClose'] == 1){

                      ?>

                        <td style="padding-left:16px;"><span class="badge badge-success">Close</span></td>

                      <?php } else{ ?>

                        <td style="padding-left:16px;"><span class="badge badge-info">Open</span></td>

                      <?php } ?>

                        <!--<td><?php echo $data['OnClose']?></td>-->

                        <!--<td><?php echo $data['DateOnClose']?></td>-->

                        <td style="padding-left:10px; padding-right:10px;">

                          <a title="edit" href="editTransaksi.php?id=<?php echo $id?>" class="btn btn-sm btn-warning" style="margin-bottom:0.25rem; width:33px;"><i class="fas fa-edit"></i></a>

                          <!--<button title="detail" data-id="<?php echo $id?>" class="btn btn-info btn-sm transinfo" style="margin-bottom:0.25rem;width:33px;"><i class="fas fa-search"></i></button>-->
                          <button title="detail" onclick="transinfo(<?php echo $id?>)" class="btn btn-info btn-sm" style="margin-bottom:0.25rem;width:33px;"><i class="fas fa-search"></i></button>
                          <?php 
                            if($data['OnClose'] == 0){
                          ?>
                          <button title="delete" data-id="<?php echo $id?>" class="btn btn-danger btn-sm transdel"style="margin-bottom:0.25rem;width:33px;"><i class="fas fa-trash"></i></button>
                          <?php } ?>
                        </td>

                      </tr>

                    <?php } ?>

                    </tbody>

                  </table>

                </div>

              </div>

            </div>

          </div>

          <!--Row-->



		  

		  <!-- Modal Delete -->

          <div class="modal fade bd-example-modal-xl" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"

            aria-hidden="true">

            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">

              <div class="modal-content">

                <div class="modal-header">

                  <h5 class="modal-title" id="exampleModalLabelLogout">Apakah anda ingin menghapus transaksi?</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                  </button>

                </div>

                <div class="modal-body detail-body">

                  

                </div>

                <div class="modal-footer">

                  <a type="button" href="" id="del" class="btn btn-outline-primary">Ya</a>

				  <button type="button" class="btn btn-primary" data-dismiss="modal">Tidak</button>

                </div>

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



  <!-- Page level plugins -->

  <script src="../../vendor/datatables1/jquery.dataTables.min.js"></script>

  <script src="../../vendor/datatables1/datatables.min.js"></script>



  <!-- Page level custom scripts -->

  <script>

    $(document).ready(function () {

      $('#dataTable').DataTable(); // ID From dataTable 

      $('#dataTableHover').DataTable({

        "columnDefs": [ { type: 'date', 'targets': [0] } ],
        "scrollX": true,
        "order": [[0, "desc"]]

	  }); // ID From dataTable with Hover



      $('.transinfo').click(function(){

        var hdid = $(this).data('id');



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

      });

	  

	  $('.transdel').click(function(){

        var hdid = $(this).data('id');



        // AJAX request\

        $.ajax({

          url: '../../config/viewTransaksi.php',

          type: 'post',

          data: {hdid: hdid},

          success: function(response){

            // Add response in Modal body

            $('.detail-body').html(response);

			$("#del").attr("href", "../../config/process.php?cancelId="+hdid);

            // Display Modal

            $('#deleteModal').modal('show');

          }

        });

      });  

    });

  </script>
  
  <script>
	function tahunUbah(){
		var tahun = document.getElementById("tahun").value;
		$('#tahunGo').attr("href", "transaksi.php?tahun="+tahun);
	}
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