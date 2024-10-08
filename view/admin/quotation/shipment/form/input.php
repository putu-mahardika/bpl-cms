<?php
session_save_path('../../../../../tmp');
session_start();

if ($_SESSION['hak_akses'] == "") {
    header("location:../../../../../index.php?pesan=belum_login");
}
include '../../../../../config/koneksi.php';
include '../../../../../config/controller/quotationShipments/quotationShipmentController.php';
date_default_timezone_set("Asia/Jakarta");

$s_id = $_SESSION['id'];
$vendors = getVendors($koneksi);
$sales = getSales($koneksi);
$vm = getVm($koneksi);
$customers = getCustomers($koneksi, $s_id);
$shipmentTerms = getShipmentTerms($koneksi);
$shipmentLoadTypes = getShipmentLoadTypes($koneksi);
$shipmentContainers = getShipmentContainers($koneksi);
$countries = getCountries($koneksi);

$totalCosting = 0;
$totalBudgeting = 0;
$totalPricing = 0;

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
    </style>
</head>

<body id="page-top">
<<<<<<< HEAD
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php?tahun=<?php echo $datetime ?>">
                <div class="sidebar-brand-icon">
                    <img src="../../../../../img/logo-BPL-white-min.png" style="height:130px;">
=======
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
            <a class="collapse-item" href="../../../quotation/trucking/index.php?tahun=<?php echo $datetime?>">List Quo Trucking</a>
            <h6 class="collapse-header">Quo Shipment</h6>
            <a class="collapse-item" href="../../../quotation/shipment/index.php">List Quo Shipment</a>
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
        <?php include '../../../../layouts/topbar.php' ?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <a href="../index.php?php echo $datetime ?>" style="margin-right:20px;"><i class="far fa-arrow-alt-circle-left fa-2x" title="kembali"></i></a>
            <h1 class="h3 mb-0 text-gray-800">Form Quotation Shipment</h1>
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
                          <p class="text-primary text-center mb-0">Anda tidak punya hak untuk melihat</p>
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
                          <div class="text-left">
                            <small>IDR</small>
                            <span style="font-size: 1.5rem;">0</span>
                          </div>
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
                          <div class="text-left">
                            <small>IDR</small>
                            <span style="font-size: 1.5rem;">0</span>
                          </div>
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
                          <label for="nomorQuoShipment">Nomor QUO Shipment</label>
                          <input type="text" class="form-control" id="nomorQuoShipment" name="nomorQuoShipment" placeholder="-" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="total_container">Jumlah Container</label>
                          <input type="text" class="form-control text-right inputmask_qty" id="total_container" name="total_container" placeholder="0" maxlength="4">
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
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
                        </div>
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-12">
                              <label for="item_description">Jenis Barang Bawaan (Opsional)</label>
                              <input type="text" class="form-control" id="item_description" name="item_description" placeholder="Masukkan jenis barang bawaan...">
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
                  <div class="row mt-5">
                    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                      <h5 class="font-weight-bold">Informasi Muatan</h5>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <label for="master_unit_id">Jenis Container</label>
                          <select name="" id="master_unit_id" class="form-control">
                            <?php foreach ($shipmentContainers as $val) { ?>
                              <option value="<?php echo $val['id'] ?>"><?php echo strtoupper($val['nama']) ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-12 mb-3">
                          <label for="shipment_terms_id">Shipment Terms</label>
                          <select name="" id="shipment_terms_id" class="form-control">
                            <?php foreach ($shipmentTerms as $val) { ?>
                              <option value="<?php echo $val['id'] ?>"><?php echo $val['kode'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-12 mb-3">
                          <label for="shipment_load_type_id">Shipment Load Type</label>
                          <select name="" id="shipment_load_type_id" class="form-control">
                            <?php foreach ($shipmentLoadTypes as $val) { ?>
                              <option value="<?php echo $val['id'] ?>"><?php echo $val['nama'] ?></option>
                            <?php } ?>
                          </select>
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
                              <select name="" id="origin_country_id" class="form-control select2">
                                <?php foreach ($countries as $val) { ?>
                                  <option value="<?php echo $val['Id'] ?>"><?php echo $val['Nama'] ?></option>
                                <?php } ?>
                              </select>
                            </td>
                            <td class="px-3">
                              <select name="" id="destination_country_id" class="form-control select2">
                                <?php foreach ($countries as $val) { ?>
                                  <option value="<?php echo $val['Id'] ?>"><?php echo $val['Nama'] ?></option>
                                <?php } ?>
                              </select>
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control" id="pickup_note" name="pickup_note" placeholder="Masukkan keterangan pickup...">
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control" id="destination_note" name="destination_note" placeholder="Masukkan keterangan destination...">
                            </td>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-5">
                    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                      <h5 class="font-weight-bold">Tambahan Biaya Handling</h5>
                    </div>
                    <div class="col-md-12 mb-3">
                      <div class="table-responsive">
                        <table class="table align-items-center table-bordered" id="dataTableInfoMuatan">
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
                              <input type="text" class="form-control" id="handling1Name" name="handling1Name" placeholder="Masukkan nama biaya handling..." disabled>
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="handling1Qty" name="handling1Qty" placeholder="0" disabled>
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="handling1Budgeting" name="handling1Budgeting" placeholder="0" disabled>
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="handling1Pricing" name="handling1Pricing" placeholder="0" disabled>
                            </td>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-12 mb-3">
                      <div class="table-responsive">
                        <table class="table align-items-center table-bordered" id="dataTableInfoMuatan">
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
                              <input type="text" class="form-control" id="handlingNextName" name="handlingNextName" placeholder="Masukkan nama biaya handling..." disabled>
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="handlingNextQty" name="handlingNextQty" placeholder="0" disabled>
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="handlingNextBudgeting" name="handlingNextBudgeting" placeholder="0" disabled>
                            </td>
                            <td class="px-3">
                              <input type="text" class="form-control text-right inputmask_currency" id="handlingNextPricing" name="handlingNextPricing" placeholder="0" disabled>
                            </td>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-12 mt-3">
                      <div class="row">
                        <div class="col-md-4">
                          <button class="btn btn-success w-100" disabled>Reset</button>
                        </div>
                        <div class="col-md-4">
                          <button class="btn btn-danger w-100" disabled>Pembatalan</button>
                        </div>
                        <div class="col-md-4">
                          <button id="btn_save" class="btn btn-primary w-100" onclick="createHdQuoShipments()">Simpan</button>
                        </div>
                      </div>
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
>>>>>>> c3e73cb624809f1190c412eec99fa355ebcabaac
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
                        <h6 class="collapse-header">Quo Shipment</h6>
                        <a class="collapse-item" href="../../../quotation/shipment/index.php">List Quo Shipment</a>
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
                <?php include '../../../../layouts/topbar.php' ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-start mb-4">
                        <a href="../index.php?php echo $datetime ?>" style="margin-right:20px;"><i class="far fa-arrow-alt-circle-left fa-2x" title="kembali"></i></a>
                        <h1 class="h3 mb-0 text-gray-800">Form Quotation Shipment</h1>
                    </div>
                    <div class="row mb-3">
                        <div class="col-xl-8 col-lg-8">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <?php include 'pricing-card.php' ?>
                                    <?php include 'input-quo-shipment.php' ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php include 'input-informasi-muatan.php' ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php include 'input-informasi-biaya-freight.php' ?>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="note">Note</label>
                                            <textarea name="" id="note" class="form-control" rows="5" placeholder="note"></textarea>
                                        </div>
                                    </div>
                                    <?php include 'input-permintaan-customer.php' ?>
                                    <?php include 'input-list-vendor.php' ?>
                                    <?php include 'input-tambahan-biaya-handling.php' ?>
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <button id="btn_save" class="btn btn-primary w-100" onclick="createHdQuoShipments()">Simpan</button>
                                        </div>
                                        <div class="col-md-12 mt-5">
                                            <?php include 'riwayat-perubahan.php' ?>
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
                                <div class="col-md-12 d-none" id="form_cancel_quotation">
                                    <div class="card mb-4">
                                        <?php include 'input-form-cancel-quotation.php' ?>
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

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('.inputmask_currency').inputmask('numeric', {
                digits: 0,
                groupSeparator: '.',
                autoUnmask: true,
                stripLeadingZeroes: false,
            });

            $('.inputmask_qty').inputmask('numeric', {
                digits: 0,
                autoUnmask: true,
                stripLeadingZeroes: false,
            });

            $('.inputmask_phone').inputmask({
                'mask': '9999-9999-9999',
                'autoUnmask': true
            });

            $('#checkboxNewCustomer').change(function() {
                if ($(this).is(':checked')) {
                    $('#customer_select').hide();
                    $('#customer_form').show();
                    $('#customer_id').val(null).trigger('change');
                } else {
                    $('#customer_select').show();
                    $('#customer_form').hide();
                    $('#customer_name_temp').val(null);
                    $('#customer_address_temp').val(null);
                    $('#pic_name_temp').val(null);
                    $('#pic_phone_temp').val(null);
                }
            });

            $('#customer_id').select2({
                placeholder: 'Pilih Customer',
                width: '100%',
            }).val(null).trigger('change');

            $('#master_unit_id').select2({
                placeholder: 'Pilih Shipment Container',
                width: '100%',
            }).val(null).trigger('change');

            $('#shipment_terms_id').select2({
                placeholder: 'Pilih Shipment Terms',
                width: '100%',
            }).val(null).trigger('change');

            $('#shipment_load_type_id').select2({
                placeholder: 'Pilih Shipment Load Types',
                width: '100%',
            }).val(null).trigger('change');

            $('#origin_country_id').select2({
                placeholder: 'Pilih Country Origin',
                width: '130px',
            }).val(null).trigger('change').on('change', function() {
                if ($('#destination_country_id').val() == $('#origin_country_id').val()) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops!",
                        html: `<b>Country Origin</b> dan <b>Country Destination</b><br> tidak boleh sama`,
                    });
                    $(this).val(null).trigger('change');
                }
            });

            $('#destination_country_id').select2({
                placeholder: 'Pilih Country Destination',
                width: '130px',
            }).val(null).trigger('change').on('change', function() {
                if ($('#destination_country_id').val() == $('#origin_country_id').val()) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops!",
                        html: `<b>Country Origin</b> dan <b>Country Destination</b><br> tidak boleh sama`,
                    });
                    $(this).val(null).trigger('change');
                }
            });

            $('.date_single').flatpickr({
                defaultDate: new Date(),
            });
    
            $('.select2_vendor').select2({
                placeholder: 'Pilih Vendor',
                width: '100%',
            });
    
            let row = $(this).closest('tr');
            $('#table_handling_1').on('keyup', '#handling_unit_cost_1', function() {
                let row = $(this).closest('tr');
                let handling_unit_cost_1 = parseFloat(row.find('#handling_unit_cost_1').val()) || 0;
                let handling_qty_1 = parseFloat(row.find('#handling_qty_1').val()) || 0;
                let total = handling_unit_cost_1 * handling_qty_1;
                row.find('#handling_total_cost_1').val(total);
                calcTotalHandling();
            });
    
            $('#table_handling_next').on('keyup', '#handling_unit_cost_next', function() {
                let row = $(this).closest('tr');
                let handling_unit_cost_next = parseFloat(row.find('#handling_unit_cost_next').val()) || 0;
                let handling_qty_next = parseFloat(row.find('#handling_qty_next').val()) || 0;
                let total = handling_unit_cost_next * handling_qty_next;
                row.find('#handling_total_cost_next').val(total);
                calcTotalHandling();
            });
    
            $('#table_list_vendor').on('keyup', '.costing_first_price, .costing_next_price', function() {
                let row = $(this).closest('tr');
                let total_container = parseFloat($('#total_container').val());
                let costing_first_price = parseFloat(row.find('.costing_first_price').val()) || 0;
                let costing_next_price = parseFloat(row.find('.costing_next_price').val()) || 0;
                let total = (total_container - 1) * (costing_first_price + costing_next_price);
                row.find('.costing_total_price').val(total);
            });
    
            $('#table_list_vendor').on('keyup', '.budgeting_first_price, .budgeting_next_price', function() {
                let row = $(this).closest('tr');
                let total_container = parseFloat($('#total_container').val());
                let budgeting_first_price = parseFloat(row.find('.budgeting_first_price').val()) || 0;
                let budgeting_next_price = parseFloat(row.find('.budgeting_next_price').val()) || 0;
                let total = (total_container - 1) * (budgeting_first_price + budgeting_next_price);
                row.find('.budgeting_total_price').val(total);
            });
    
            $('#table_list_vendor').on('keyup', '.pricing_first_price, .pricing_next_price', function() {
                let row = $(this).closest('tr');
                let total_container = parseFloat($('#total_container').val());
                let pricing_first_price = parseFloat(row.find('.pricing_first_price').val()) || 0;
                let pricing_next_price = parseFloat(row.find('.pricing_next_price').val()) || 0;
                let total = (total_container - 1) * (pricing_first_price + pricing_next_price);
                row.find('.pricing_total_price').val(total);
            });

            $('#total_container').on('keyup', function() {
                $('#handling_qty_1').val($(this).val());
                $('#handling_qty_next').val($(this).val());
            });
    
        });
        // Function to add a new row to the table
        addRow = () => {
            let lastIndex = $('#table_list_vendor tbody tr').length;

            let newRow = `
                <tr>
                    <td class="px-3 text-nowrap align-middle" style="font-size: 14px; width: 50px !important">
                        <div class="custom-control custom-checkbox" style="padding-left: 2rem">
                        <input type="checkbox" class="custom-control-input" id="customCheck${lastIndex}">
                        <label class="custom-control-label" for="customCheck${lastIndex}"></label>
                        </div>
                    </td>
                    <td class="px-3 text-nowrap" style="font-size: 14px; width: 50px !important">
                        <select name="vendor_id" class="form-control vendor_id">
                        <?php foreach ($vendors as $val) { ?>
                            <option value="<?php echo $val['Id'] ?>"><?php echo $val['nama'] ?></option>
                        <?php } ?>
                        </select>
                    </td>
                    <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                        <input type="text" class="form-control text-right costing_first_price inputmask_currency" placeholder="0">
                    </td>
                    <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                        <input type="text" class="form-control text-right costing_next_price inputmask_currency" placeholder="0">
                    </td>
                    <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                        <input type="text" class="form-control text-right costing_total_price inputmask_currency" disabled placeholder="0">
                    </td>
                    <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                        <input type="text" class="form-control text-right budgeting_first_price inputmask_currency" placeholder="0">
                    </td>
                    <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                        <input type="text" class="form-control text-right budgeting_next_price inputmask_currency" placeholder="0">
                    </td>
                    <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                        <input type="text" class="form-control text-right budgeting_total_price inputmask_currency" disabled placeholder="0">
                    </td>
                    <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                        <input type="text" class="form-control text-right pricing_first_price inputmask_currency" placeholder="0">
                    </td>
                    <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                        <input type="text" class="form-control text-right pricing_next_price inputmask_currency" placeholder="0">
                    </td>
                    <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                        <input type="text" class="form-control text-right pricing_total_price inputmask_currency" disabled placeholder="0">
                    </td>
                    <td class="text-center"><button type="button" class="btn btn-danger remove-row" onclick="removeRow()"><i class="fas fa-trash"></i></button></td>
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
            let handling_total_cost_1 = parseFloat($('#handling_total_cost_1').val())
            let handling_unit_cost_1 = parseFloat($('#handling_unit_cost_1').val())
            let handling_unit_cost_next = parseFloat($('#handling_unit_cost_next').val())
            let handling_total_cost_next = parseFloat($('#handling_total_cost_next').val())
            $('#total_handling_cost').val(handling_total_cost_1 + handling_total_cost_next);
            $('#total_handling_unit_cost').val(handling_unit_cost_1 + handling_unit_cost_next);
        }
        
        getValidate = () => {
            if ($('#total_container').val() == '' || $('#total_container').val() == 0) {
                toastr.error('Jumlah Container tidak boleh 0', 'Required!')
                return true;
            }

            if (!$('#checkboxNewCustomer').is(':checked')) {
                if ($('#customer_id').val() == '' || $('#customer_id').val() == null) {
                    toastr.error('Customer harus dipilih', 'Required!')
                    return true;
                }
            } else {
                if ($('#customer_name_temp').val() == '') {
                    toastr.error('Nama Customer harus diisi', 'Required!')
                    return true;
                }
                if ($('#customer_address_temp').val() == '') {
                    toastr.error('Alamat Customer harus diisi', 'Required!')
                    return true;
                }
                if ($('#pic_name_temp').val() == '') {
                    toastr.error('PIC Customer harus diisi', 'Required!')
                    return true;
                }
                if ($('#pic_phone_temp').val() == '') {
                    toastr.error('Telp PIC Customer harus diisi', 'Required!')
                    return true;
                }
            }

            if ($('#master_unit_id').val() == '' || $('#master_unit_id').val() == null) {
                toastr.error('Jenis Container harus diisi', 'Required!')
                return true;
            }

            if ($('#shipment_terms_id').val() == '' || $('#shipment_terms_id').val() == null) {
                toastr.error('Shipment Terms harus diisi', 'Required!')
                return true;
            }

            if ($('#shipment_load_type_id').val() == '' || $('#shipment_load_type_id').val() == null) {
                toastr.error('Shipment Load Type harus diisi', 'Required!')
                return true;
            }

            if ($('#origin_country_id').val() == '' || $('#origin_country_id').val() == null) {
                toastr.error('Country Origin harus dipilih', 'Required!')
                return true;
            }

            if ($('#destination_country_id').val() == '' || $('#destination_country_id').val() == null) {
                toastr.error('Country Origin harus dipilih', 'Required!')
                return true;
            }

            return false;
        };

        calcApplyAllCosting = (state) => {
            let apply_costing_first = parseFloat($('#apply_costing_first').val()) || 0;
            $('.costing_first_price').val(apply_costing_first);
            let apply_costing_next = parseFloat($('#apply_costing_next').val()) || 0;
            $('.costing_next_price').val(apply_costing_next);

            let total_container = parseFloat($('#total_container').val()) || 0;
            let costing_first_price = parseFloat($('.costing_first_price').val()) || 0;
            let costing_next_price = parseFloat($('.costing_next_price').val()) || 0;
            let total = (total_container - 1) * (costing_first_price + costing_next_price);
            $('.costing_total_price').val(total);
        }

        calcApplyAllBudgeting = () => {
            let apply_budgeting_first = parseFloat($('#apply_budgeting_first').val()) || 0;
            $('.budgeting_first_price').val(apply_budgeting_first);
            let apply_budgeting_next = parseFloat($('#apply_budgeting_next').val()) || 0;
            $('.budgeting_next_price').val(apply_budgeting_next);

            let total_container = parseFloat($('#total_container').val()) || 0;
            let budgeting_first_price = parseFloat($('.budgeting_first_price').val()) || 0;
            let budgeting_next_price = parseFloat($('.budgeting_next_price').val()) || 0;
            let total = (total_container - 1) * (budgeting_first_price + budgeting_next_price);
            $('.budgeting_total_price').val(total);
        }

        calcApplyAllPricing = (state) => {
            let apply_pricing_first = parseFloat($('#apply_pricing_first').val()) || 0;
            $('.pricing_first_price').val(apply_pricing_first);
            let apply_pricing_next = parseFloat($('#apply_pricing_next').val()) || 0;
            $('.pricing_next_price').val(apply_pricing_next);

            let total_container = parseFloat($('#total_container').val()) || 0;
            let pricing_first_price = parseFloat($('.pricing_first_price').val()) || 0;
            let pricing_next_price = parseFloat($('.pricing_next_price').val()) || 0;
            let total = (total_container - 1) * (pricing_first_price + pricing_next_price);
            $('.pricing_total_price').val(total);
        }

        calcTotalHandling = () => {
            let handling_total_cost_1 = parseFloat($('#handling_total_cost_1').val())
            let handling_unit_cost_1 = parseFloat($('#handling_unit_cost_1').val())
            let handling_unit_cost_next = parseFloat($('#handling_unit_cost_next').val())
            let handling_total_cost_next = parseFloat($('#handling_total_cost_next').val())
            $('#total_handling_cost').val(handling_total_cost_1 + handling_total_cost_next);
            $('#total_handling_unit_cost').val(handling_unit_cost_1 + handling_unit_cost_next);
        }

        createHdQuoShipments = () => {
            if (getValidate()) {
                return;
            }

            let selected_quo_vendor_id = null;
            let selected_quo_vendor_costing = 0;
            let selected_quo_vendor_budgeting = 0;
            let selected_quo_vendor_pricing = 0;
            let vendor_data = [];

            $('#table_list_vendor tbody tr').each(function() {
                if ($(this).find('input[type="checkbox"]').is(':checked')) {
                    let vendor_id = $(this).find('select.vendor_id option:selected').val();
                    let costing_first_price = $(this).find('.costing_first_price').val();
                    let costing_next_price = $(this).find('.costing_next_price').val();
                    let costing_total_price = $(this).find('.costing_total_price').val();
                    let budgeting_first_price = $(this).find('.budgeting_first_price').val();
                    let budgeting_next_price = $(this).find('.budgeting_next_price').val();
                    let budgeting_total_price = $(this).find('.budgeting_total_price').val();
                    let pricing_first_price = $(this).find('.pricing_first_price').val();
                    let pricing_next_price = $(this).find('.pricing_next_price').val();
                    let pricing_total_price = $(this).find('.pricing_total_price').val();
                    selected_quo_vendor_id = vendor_id;
                    selected_quo_vendor_costing = costing_total_price;
                    selected_quo_vendor_budgeting = budgeting_total_price;
                    selected_quo_vendor_pricing = pricing_total_price;
                }
                vendor_data.push({
                    vendor_id: $(this).find('select.vendor_id option:selected').val(),
                    costing_first_price: $(this).find('.costing_first_price').val() || 0,
                    costing_next_price: $(this).find('.costing_next_price').val() || 0,
                    costing_total_price: $(this).find('.costing_total_price').val() || 0,
                    budgeting_first_price: $(this).find('.budgeting_first_price').val() || 0,
                    budgeting_next_price: $(this).find('.budgeting_next_price').val() || 0,
                    budgeting_total_price: $(this).find('.budgeting_total_price').val() || 0,
                    pricing_first_price: $(this).find('.pricing_first_price').val() || 0,
                    pricing_next_price: $(this).find('.pricing_next_price').val() || 0,
                    pricing_total_price: $(this).find('.pricing_total_price').val() || 0,
                });
            });

            let data = {
                method: 'createHdQuoShipments',
                // hdQuoShipment
                customer_id: $('#customer_id').val(),
                sales_id: <?php echo $s_id ?>,
                total_container: $('#total_container').val(),
                item_description: $('#item_description').val(),
                vm_id: <?php echo $s_id ?>,
                freight_cost: $('#freight_cost').val(),
                currency_date: $('#currency_date').val(),
                currency_rate: $('#currency_rate').val(),
                quo_status_id: 1,
                customer_name_temp: $('#customer_name_temp').val(),
                customer_address_temp: $('#customer_address_temp').val(),
                pic_name_temp: $('#pic_name_temp').val(),
                pic_phone_temp: $('#pic_phone_temp').val(),
                master_unit_id: $('#master_unit_id').val(),
                shipment_terms_id: $('#shipment_terms_id').val(),
                shipment_load_type_id: $('#shipment_load_type_id').val(),
                note: $('#note').val(),
                is_need_trucking: $('#is_need_trucking').is(':checked') ? 1 : 0,
                link_trans_trucking_id: null,
                link_trans_shipment_id: null,
                origin_country_id: $('#origin_country_id').val(),
                destination_country_id: $('#destination_country_id').val(),
                pickup_note: $('#pickup_note').val(),
                destination_note: $('#destination_note').val(),
                handling_name_1: $('#handling_name_1').val(),
                handling_qty_1: $('#handling_qty_1').val(),
                handling_unit_cost_1: $('#handling_unit_cost_1').val(),
                handling_total_cost_1: $('#handling_total_cost_1').val(),
                handling_name_next: $('#handling_name_next').val(),
                handling_qty_next: $('#handling_qty_next').val(),
                handling_unit_cost_next: $('#handling_unit_cost_next').val(),
                handling_total_cost_next: $('#handling_total_cost_next').val(),
                total_handling_unit_cost: $('#total_handling_unit_cost').val(),
                total_handling_cost: $('#total_handling_cost').val(),
                selected_quo_vendor_id: selected_quo_vendor_id,
                selected_quo_vendor_costing: selected_quo_vendor_costing,
                selected_quo_vendor_budgeting: selected_quo_vendor_budgeting,
                selected_quo_vendor_pricing: selected_quo_vendor_pricing,
                vendor_data: vendor_data,
            };

            console.log(`DATA: ${JSON.stringify(data)}`);

            // Swal.fire({
            //     title: "Loading...",
            //     html: "Sedang menyimpan data",
            //     timerProgressBar: true,
            //     allowOutsideClick: false,
            //     allowEscapeKey: false,
            //     didOpen: () => {
            //         Swal.showLoading();
            //     },
            // });

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
                            window.location.href = '<?php echo $base_url; ?>/view/admin/quotation/shipment/index.php';
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


    </script>
</body>

</html>