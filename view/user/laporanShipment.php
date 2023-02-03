<?php
  session_save_path('../../tmp');
  session_start();
  date_default_timezone_set("Asia/Jakarta");
  $datetime = date('Y');
  
  if ($_SESSION['hak_akses'] == "" || $_SESSION['hak_akses'] != "User") {
    header("location:../../index.php?pesan=belum_login");
  }
  $s_id = $_SESSION['id'];


  include '../../config/koneksi.php';
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
  <title>Laporan Shipment - PT Berkah Permata Logistik</title>
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../../vendor/datatables1/datatables.min.css" rel="stylesheet">
  <link href="../../vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" >
  <link href="../../css/style.css" rel="stylesheet">

  <!-- DevExtreme theme -->
  <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.1.6/css/dx.light.css">
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
        <a class="nav-link" href="laporanbarang.php">
          <i class="fas fa-fw fa-file-invoice"></i>
          <span>Laporan Detail</span>
        </a>
      </li>
      <li class="nav-item active">
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
            <h1 class="h3 mb-0 text-gray-800"> Laporan Shipment</h1>
            <!-- <?php if($fill == 1){?>
            <a class="btn btn-info btn-lg " target="_blank" href="../../export/exportlaporantransaksi.php?start=<?php echo $start?>&end=<?php echo $end?>"><i class="fas fa-print"></i></a>
            <?php }else{?>
            <a class="btn btn-info btn-lg disabled" target="_blank" href="#"><i class="fas fa-print"></i></a>
            <?php }?> -->
            <!--<ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item">Tables</li>
              <li class="breadcrumb-item active" aria-current="page">Simple Tables</li>
            </ol>-->
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="py-3 d-flex flex-row align-items-center justify-content-start">
                <button type="button" class="btn btn-outline-primary" style="margin-right:10px;" onclick="rangespk()" id="btnspk">
                  <span class="text">Range Tanggal Detail</span>
                </button>
                
              </div>

              <div class="card mb-4 col-12 hidden" id="card-spk">
                <div class="card-header">
                  <h6>Masukkan range tanggal detail yang ingin ditampilkan : </h6>
                </div>
                <div class="card-body col-12">
                  <!-- <form method="post" action="laporanbarang.php"> -->
                    <div class="form-group" >
                      <div class=" input-group" id="simple-date4">
                        <div class="input-daterange" style="width:190px;">
                          <input type="text" class="input-sm form-control form-control-sm" name="start" id="dateStart" />
                        </div>
                        <div class="input-group-prepend" style="height:31px;">
                          <span class="input-group-text">to</span>
                        </div>
                        <div class="input-daterange" style="width:190px;">
                          <input type="text" class="input-sm form-control form-control-sm" name="end" id="dateEnd" />
                        </div>
                      </div>
                    </div>
                    <!-- <input type="submit" value="Submit" name="range" class="btn btn-md btn-primary"> -->
                    <button type="button" class="btn btn-md btn-primary" onclick="getDataSource()">Cari</button>
                  <!-- </form> -->
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="card mb-4 p-4">
                <div id="gridContainer"></div> 
              </div>
            </div>
            
          </div>

          <!--Row-->



		  
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


          <!-- Modal Range SPK -->
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

  <!-- Page level plugins -->
  <script src="../../vendor/datatables1/jquery.dataTables.min.js"></script>
  <script src="../../vendor/datatables1/datatables.min.js"></script>

  <script src="../../vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

  <!-- DevExtreme library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.12.1/polyfill.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/3.8.0/exceljs.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
  <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/22.1.6/js/dx.all.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable({
        "columnDefs": [ { type: 'date', 'targets': [0] } ],
        "order": [[0, "desc"]]
	  }); // ID From dataTable with Hover

      
      $('#simple-date4 .input-daterange').datepicker({        
        format: 'dd/mm/yyyy',        
        autoclose: true,     
        todayHighlight: true,   
        todayBtn: 'linked',
      });
	    
    });
  </script>
 
  <script>
    function rangespk(){
      var a = document.getElementById("btnspk");
      var a1 = document.getElementById("card-spk");

      if(a.classList.contains("btn-primary")){
        a.classList.remove("btn-primary");
        a.classList.add("btn-outline-primary");
        a1.classList.add("hidden");
      }else{
        a.classList.remove("btn-outline-primary");
        a.classList.add("btn-primary");
        a1.classList.remove("hidden");
      }
    }; 
  </script>

  <script>
    let dateStartInputTemp = document.getElementById('dateStart')
    let dateEndInputTemp = document.getElementById('dateEnd')
    let dataGrid = null;
    let dataSourceTemp = null;

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

    function getDataSource(){
      dateStartInput = dateStartInputTemp.value;
      dateEndInput = dateEndInputTemp.value;
      console.log('start', dateStartInput);
      $.ajax({
        url: '../../config/controller/shipmentController.php',
        type: 'get',
        data: {
          reportShipment: true,
          start: dateStartInput,
          end: dateEndInput
        },
        dataType: 'json',
        timeout: 3600000,
        success: function(response){
          dataSourceTemp = response;
          // console.log('res', dataSourceTemp);
          dataGrid.option('dataSource', response);
          dataGrid.refresh();
        }
      });
    }
  </script>

  <script>
    $(document).ready(() => {
      // console.log('aaa');
      var borderStylePattern = { style: 'thin', color: { argb: 'FF7E7E7E' } };
      dataGrid = $('#gridContainer').dxDataGrid({
        // dataSource: generateData(100000),
        dataSource: dataSourceTemp,
        // keyExpr: 'id',
        // allowColumnReordering: true,
        allowColumnResizing: true,
        selection: {
          mode: 'single',
        },
        showBorders: true,
        showRowLines: true,
        showColumnLines: true,
        stateStoring: {
          enabled: true,
          type: 'localStorage',
          storageKey: 'storage',
        },
        groupPanel: {
          visible: true,
        },
        filterRow: {
          visible: true,
          applyFilter: 'auto',
        },
        searchPanel: {
          visible: true,
          width: 240,
          placeholder: 'Search...',
        },
        headerFilter: {
          visible: true,
        },
        columnChooser: {
          enabled: true,
          mode: 'select',
        },
        columnAutoWidth: true,
        export: {
          enabled: true,
        },
        onExporting(e) {
          const workbook = new ExcelJS.Workbook();
          const worksheet = workbook.addWorksheet('CountriesPopulation');

          DevExpress.excelExporter.exportDataGrid({
            component: e.component,
            worksheet,
            topLeftCell: { row: 5, column: 1 },
            customizeCell: function(options) {
              const { gridCell, excelCell } = options;

              // if(gridCell.rowType === 'group' || gridCell.rowType === 'totalFooter' || gridCell.rowType === 'groupFooter') {
              //   specialRowIndexes.push(excelCell.fullAddress.row);
              // }
            }
          }).then(function(dataGridRange) {
            // See border - https://github.com/exceljs/exceljs#borders for more details
            setBorders(e.component, worksheet, dataGridRange);
            return Promise.resolve();
          }).then((cellRange) => {
            // header
            const headerRow = worksheet.getRow(2);
            headerRow.height = 30;
            worksheet.mergeCells(2, 1, 2, 19);

            headerRow.getCell(1).value = 'Laporan Detail Pergerakan Truck - PT Berkah Permata Logistik';
            headerRow.getCell(1).font = { name: 'Segoe UI Light', size: 20 };
            headerRow.getCell(1).alignment = { horizontal: 'center' };
            
            const subHeaderRow = worksheet.getRow(3);
            subHeaderRow.height = 24;
            worksheet.mergeCells(3, 1, 3, 19);

            subHeaderRow.getCell(1).value = `Periode : ${dateStartInputTemp.value} s/d ${dateEndInputTemp.value}`;
            subHeaderRow.getCell(1).font = { name: 'Segoe UI Light', size: 14 };
            subHeaderRow.getCell(1).alignment = { horizontal: 'center' };

          }).then(() => {
            workbook.xlsx.writeBuffer().then((buffer) => {
              saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Laporan Pergerakan Truck - PT Berkah Permata Logistik.xlsx');
            });
          });
          e.cancel = true;
        },
        columns: [
          {
            caption: 'Tgl',
            dataField: 'create_order',
          },
          {
            caption: 'Kode',
            dataField: 'kode_shipment'
          },
          {
            caption: 'Customer',
            dataField: 'customer'
          },
          {
            caption: 'Sales',
            dataField: 'sales'
          },
          {
            caption: 'PIB',
            dataField: 'pib'
          },
          {
            caption: 'BL',
            dataField: 'bl'
          },
          {
            caption: 'Shipment Term',
            dataField: 'shipment_term'
          },
          {
            caption: 'Load Type',
            dataField: 'load_type'
          },
          {
            caption: 'QTY',
            dataField: 'qty'
          },
          {
            caption: 'Unit',
            dataField: 'unit'
          },
          {
            caption: 'Status',
            dataField: 'status'
          },
          {
            caption: 'Freight',
            dataField: 'freight'
          },
          {
            caption: 'Total Freight',
            dataField: 'total_freight'
          },
          {
            caption: 'Total Handling',
            dataField: 'totalHandling'
          },
          // {
          //   caption: 'Action',
          //   dataField: 'id',
          //   cellTemplate: function(container, options) {
          //       container.html(`
          //       <button title="detail" onclick="transinfo(${options.value})" class="btn btn-info btn-sm" style="margin-bottom:0.25rem;width:33px;"><i class="fas fa-search"></i></button>
          //   `)},
          //   allowExporting: false,
          //   allowFiltering: false,
          //   allowSearching: false,
          //   allowSorting: false,
          //   showInColumnChooser: false
          // }
        ],
        scrolling: {
          rowRenderingMode: 'virtual',
        },
        paging: {
          pageSize: 10,
        },
        pager: {
          visible: true,
          allowedPageSizes: [5, 10, 'all'],
          showPageSizeSelector: true,
          showInfo: true,
          showNavigationButtons: true,
        },
      }).dxDataGrid('instance');

      function setBorders(dataGrid, worksheet, cellsRange) {
        const { showRowLines, showColumnLines, showBorders } = dataGrid.option();
        // rowLines
        // console.log(cellsRange);
        // if(showRowLines) {
          for(let i = cellsRange.from.row; i < cellsRange.to.row; i++) {
            for(let j = cellsRange.from.column; j <= cellsRange.to.column; j++) {
              setBorderCell(worksheet, i, j, { bottom: borderStylePattern });
            }
          }
        // }
        // if(showColumnLines) {
            // columnLines
            for(let i = cellsRange.from.row; i <= cellsRange.to.row; i++) {
              for(let j = cellsRange.from.column; j < cellsRange.to.column; j++) {
                setBorderCell(worksheet, i, j, { right: borderStylePattern }); 
              }
            }
        // }
        // if(showBorders) {
          // borders
          // top
          for(let i = cellsRange.from.column; i <= cellsRange.to.column; i++) {
            setBorderCell(worksheet, cellsRange.from.row, i, { top: borderStylePattern });
          }
          // left
          for(let i = cellsRange.from.row; i <= cellsRange.to.row; i++) {
            setBorderCell(worksheet, i, cellsRange.from.column, { left: borderStylePattern });
          }

          // right
          for(let i = cellsRange.from.row; i <= cellsRange.to.row; i++) {
            setBorderCell(worksheet, i, cellsRange.to.column, { right: borderStylePattern });
          }
          // bottom
          for(let i = cellsRange.from.column; i <= cellsRange.to.column; i++) {
            setBorderCell(worksheet, cellsRange.to.row, i, { bottom: borderStylePattern });
          }
        // }
      }

      function setBorderCell(worksheet, row, column, borderValue) {
        const excelCell = worksheet.getCell(row, column);

        if(!excelCell.border) {
          excelCell.border = {};
        }

        Object.assign(excelCell.border, borderValue);
      }

      
    });

  </script>



</body>



</html>