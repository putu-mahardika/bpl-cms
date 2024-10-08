<?php
session_save_path('../../../../../tmp');
session_start();

if ($_SESSION['hak_akses'] == "" || $_SESSION['hak_akses'] != "Admin") {
    header("location:../../../../../index.php?pesan=belum_login");
}
include '../../../../../config/koneksi.php';
include '../../../../../config/controller/quotationShipments/quotationShipmentController.php';
date_default_timezone_set("Asia/Jakarta");

$s_id = $_SESSION['id'];
$vendors = getVendors($koneksi);
$sales = getSales($koneksi);
$vm = getVm($koneksi);
$dataDtlQuoShipment = getDtlQuoShipment($koneksi, $_GET['id']);
$dataDtlQuoShipmentHandlingCosts = getDtlQuoShipmentHandlingCosts($koneksi, $_GET['id']);
$quotationLog = getQuotationLog($koneksi, $_GET['id']);
$pricing = updateBudgetingQuotationDetailShipment($koneksi, $_GET['id']);

$totalCosting = 0;
$totalBudgeting = 0;
$totalPricing = 0;

foreach ($dataDtlQuoShipment as $key => $value) {
    $totalCosting += $value['costing_total_price'];
    $totalBudgeting += $value['budgeting_total_price'];
    $totalPricing += $value['pricing_total_price'];
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
    <link href="../../../../../vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css">
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
                <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-white small"><?php echo $_SESSION['nama'] ?></span>
                                <img class="img-profile rounded-circle" src="../../../../../img/boy.png" style="max-width: 60px">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
                    </div>
                    <div class="row mb-3">
                        <div class="col-xl-8 col-lg-8">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <?php include 'pricing-card.php' ?>
                                    <?php include 'edit-quo-shipment.php' ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php include 'edit-informasi-muatan.php' ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php include 'edit-informasi-biaya-freight.php' ?>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="note">Note</label>
                                            <textarea name="" id="note" class="form-control" rows="5" placeholder="note"></textarea>
                                        </div>
                                    </div>
                                    <?php include 'edit-permintaan-customer.php' ?>
                                    <?php include 'edit-list-vendor.php' ?>
                                    <?php include 'edit-tambahan-biaya-handling.php' ?>
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <button id="btn_save" class="btn btn-primary w-100" onclick="updateHdQuoShipments(<?php echo $_GET['id'] ?>)">Simpan</button>
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
                                        <?php include 'edit-status.php' ?>
                                    </div>
                                </div>
                                <div class="col-md-12 d-none" id="form_cancel_quotation">
                                    <div class="card mb-4">
                                        <?php include 'edit-form-cancel-quotation.php' ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card mb-4">
                                        <?php include 'edit-informasi-po.php' ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card mb-4">
                                        <?php include 'edit-perubahan-data-user.php' ?>
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
                            $('#sales_name').val(resp.sales_name);
                            $('#sales_id').val(resp.sales_id);
                            $('#no_quo_shipment').val(resp.no_quotation);
                            $('#total_container').val(resp.total_container);
                            $('#item_description').val(resp.item_description);
                            $('#customer_name').val(resp.customer_name);
                            $('#customer_id').val(resp.customer_id);
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
                            $('#freight_cost').val(resp.freight_cost);
                            $('#currency_date').val(resp.currency_date);
                            $('#currency_rate').val(resp.currency_rate);
                            $('#status_id').val(resp.status_id);
                            $('#status').text(resp.status);
                            $('#status').css('background-color', resp.status_color);
                            $('#old_sales').val(resp.sales_name);
                            $('#old_vm').val(resp.vm_name);
                            $('#request_cancel_date').text(resp.request_cancel_date);
                            $('#request_cancel_sales_name').text(resp.sales_name);
                            $('#request_cancel_reason').text(resp.reason_request_cancel);
                            $('#new_sales option').each(function() {
                                console.log($(this).val())
                                console.log($(this).val() == resp.sales_id)
                                if ($(this).val() == resp.sales_id) {
                                    $(this).prop('selected', true);
                                }
                            });
                            $('#new_vm option').each(function() {
                                console.log($(this).val())
                                console.log($(this).val() == resp.vm_id)
                                if ($(this).val() == resp.vm_id) {
                                    $(this).prop('selected', true);
                                }
                            });
                            $('#table_list_vendor tbody tr').each(function() {
                                let vendor_id = $(this).find('select.vendor_id option:selected').val();
                                if (vendor_id == resp.selected_quo_vendor_id) {
                                    $(this).find('input[type="checkbox"]').prop('checked', true);
                                }
                            });
                            if (resp.status_id == 12) {
                                $('#form_cancel_quotation').addClass('d-block');
                                $('#btn_save').addClass('d-none');
                            } else {
                                $('#form_cancel_quotation').removeClass('d-block');
                            }
                        },
                        error: function(xhr, status, error) {

                        }
                    });
                }

                getValidate = () => {
                    if ($('#handling_qty_1').val() > 0) {
                        if ($('#handling_name_1').val() == '' || $('#handling_name_1').val() == null) {
                            toastr.error('Nama biaya handling 1 harus diisi', 'Required!')
                            return true;
                        }
                    }

                    if ($('#handling_qty_next').val() > 0) {
                        if ($('#handling_name_next').val() == '' || $('#handling_name_next').val() == null) {
                            toastr.error('Nama biaya handling next harus diisi', 'Required!')
                            return true;
                        }
                    }

                    return false;
                };
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

                calcApplyAllCosting = (state) => {
                    let apply_costing_first = parseFloat($('#apply_costing_first').val()) || 0;
                    $('.costing_first_price').val(apply_costing_first);
                    let apply_costing_next = parseFloat($('#apply_costing_next').val()) || 0;
                    $('.costing_next_price').val(apply_costing_next);

                    let total_container = parseFloat($('#total_container').val());
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

                    let total_container = parseFloat($('#total_container').val());
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

                    let total_container = parseFloat($('#total_container').val());
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

                calcAutomate = () => {
                    Swal.fire({
                        title: "Loading...",
                        html: "Sedang mengkalkulasi Budgeting",
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
                        data: {
                            method: 'updateBudgetingQuotationDetailShipment',
                            hdQuoShipmentId: '<?php $_GET['id'] ?>',
                        },
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
                                    window.location.reload();
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

                updateHdQuoShipments = (id) => {
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
                            dtl_quo_shipment_id: $(this).find('.dtl_quo_shipment_id').val(),
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
                        method: 'updateHdQuoShipmentsAdmin',
                        // hdQuoShipment
                        id: id,
                        quo_status_id: $('#status_id').val() == 3 ? 7 : 3,
                        sales_id: $('#sales_id').val(),
                        sales_name: $('#sales_name').val(),
                        vm_id: <?php echo $s_id ?>,
                        freight_cost: $('#freight_cost').val(),
                        currency_date: $('#currency_date').val(),
                        currency_rate: $('#currency_rate').val(),
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

                setSelectNewSales = () => {
                    if ($('#new_sales').val() != $('#sales_id').val()) {
                        $('#btn_update_sales').prop('disabled', false);
                    } else {
                        $('#btn_update_sales').prop('disabled', true);
                    }
                }

                setSelectNewVM = () => {
                    if ($('#new_vm').val() != $('#vm_id').val()) {
                        $('#btn_update_vm').prop('disabled', false);
                    } else {
                        $('#btn_update_vm').prop('disabled', true);
                    }
                }

                updateSales = (id) => {
                    let data = {
                        method: 'updateHdQuoShipmentsSales',
                        id: id,
                        sales_id: $('#new_sales').val(),
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
                                    text: 'Sales telah diubah',
                                }).then(() => {
                                    window.location.href = '<?php echo $base_url; ?>/view/admin/quotation/shipment/form/edit.php?id=<?php echo $_GET['id']?>';
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

                updateVM = (id) => {
                    let data = {
                        method: 'updateHdQuoShipmentsVM',
                        id: id,
                        vm_id: $('#new_vm').val(),
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
                                    text: 'VM telah diubah',
                                }).then(() => {
                                    window.location.href = '<?php echo $base_url; ?>/view/admin/quotation/shipment/form/edit.php?id=<?php echo $_GET['id']?>';
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

                updateHdQuoShipmentsApproveCancel = (id) => {
                    let data = {
                        method: 'updateHdQuoShipmentsApproveCancel',
                        // hdQuoShipment
                        id: id,
                    };

                    console.log(`DATA: ${JSON.stringify(data)}`);

                    Swal.fire({
                        title: "Loading...",
                        html: "Sedang melakukan approve",
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
                                    text: 'Pembatalan berhasil di-approve',
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

                updateHdQuoShipmentsRejectCancel = (id) => {
                    let data = {
                        method: 'updateHdQuoShipmentsRejectCancel',
                        // hdQuoShipment
                        id: id,
                    };

                    console.log(`DATA: ${JSON.stringify(data)}`);

                    Swal.fire({
                        title: "Loading...",
                        html: "Sedang melakukan reject",
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
                                    text: 'Pembatalan telah di-reject',
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
            });
        </script>
</body>

</html>