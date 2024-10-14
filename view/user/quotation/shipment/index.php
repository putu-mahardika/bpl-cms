<?php
session_save_path('../../../../tmp');
session_start();

if ($_SESSION['hak_akses'] == "" || $_SESSION['hak_akses'] != "User") {
    header("location:../../../../index.php?pesan=belum_login");
}
include '../../../../config/koneksi.php';
date_default_timezone_set("Asia/Jakarta");

$datetime = date('Y');
$roles = 'user';

$yearNow = date('Y');

$years = [];

for ($i=2020; $i < $yearNow+1; $i++) { 
    array_unshift($years, $i);
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
    <title>Quotation Trucking - PT Berkah Permata Logistik</title>
    <link href="../../../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../../../../css/ruang-admin.min.css" rel="stylesheet">
    <!-- <link href="../../../../vendor/datatables1/datatables.min.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.css">
    <link href="<?php echo $base_url ?>/css/new-style.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php?tahun=<?php echo $datetime ?>">
                <div class="sidebar-brand-icon">
                    <img src="../../../../img/logo-BPL-white-min.png" style="height:130px;">
                </div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="../../dashboard.php?tahun=<?php echo $datetime ?>">
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
                        <a class="collapse-item" href="../../customer.php">List Customer</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Transaksi
            </div>
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseQuoTrucking" aria-expanded="true"
                    aria-controls="collapseQuoTrucking">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quotation</span>
                </a>
                <div id="collapseQuoTrucking" class="collapse show" aria-labelledby="headingTable" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Quo Trucking</h6>
                        <a class="collapse-item active" href="../../quotation/trucking/index.php?tahun=<?php echo $yearNow?>">List Quo Trucking</a>
                        <h6 class="collapse-header">Quo Shipment</h6>
                        <a class="collapse-item active" href="../../quotation/shipment/index.php?tahun=<?php echo $yearNow?>">List Quo Shipment</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../shipment.php?tahun=<?php echo $datetime ?>">
                    <i class="fas fa-fw fa-ship"></i>
                    <span>Shipment</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../transaksi.php?tahun=<?php echo $datetime ?>">
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
                        <a class="collapse-item" href="../../laporanbarang.php">Laporan Detail</a>
                        <a class="collapse-item" href="../../laporanbarangbiaya.php">Laporan Biaya</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../laporanShipment.php">
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
                                <img class="img-profile rounded-circle" src="../../../../img/boy.png" style="max-width: 60px">
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Quotation Shipment</h1>
                    </div>

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <a href="./form/input.php" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text">Tambah Quo Shipment</span>
                                    </a>
                                    <div class="d-flex align-items-center">
                                        <label for="year" class="mt-1 mr-2">Tahun</label>
                                        <select name="year" id="year" class="form-control" style="width: fit-content; height: 38px">
                                            <?php foreach ($years as $key => $value) {?>
                                                <option value="<?php echo $value?>" <?php if($value == $_GET['tahun']) {?>selected<?php }?>><?php echo $value?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive py-3 px-2">
                                    <table class="table align-items-center table-bordered my-3" id="datatable_quo_shipment">
                                        <thead>
                                            <tr>
                                                <th class="bg-gray-200" style="font-size: 14px;">Tanggal Quo</th>
                                                <th class="bg-gray-200" style="font-size: 14px;">No. Quo</th>
                                                <th class="bg-gray-200" style="font-size: 14px;">Nama Perusahaan</th>
                                                <th class="bg-gray-200" style="font-size: 14px;">Telepon</th>
                                                <th class="bg-gray-200" style="font-size: 14px;">Total Container</th>
                                                <th class="bg-gray-200" style="font-size: 14px;">Jenis Container</th>
                                                <th class="bg-gray-200" style="font-size: 14px;">Trucking</th>
                                                <th class="bg-gray-200" style="font-size: 14px;">Sales</th>
                                                <th class="bg-gray-200" style="font-size: 14px;">VM</th>
                                                <th class="bg-gray-200" style="font-size: 14px;">Status</th>
                                                <th class="bg-gray-200" style="font-size: 14px;">Last Update</th>
                                                <th class="bg-gray-200" style="font-size: 14px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Row-->

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
                                    <a href="../../../../config/logout.php" class="btn btn-primary">Logout</a>
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

    <?php include 'modal/modal_detail_quotation.php' ?>

    <script src="../../../../vendor/jquery/jquery.min.js"></script>
    <script src="../../../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../../../js/ruang-admin.min.js"></script>
    <script src="../../../../../vendor/inputmask/dist/jquery.inputmask.js"></script>
    <!-- Page level plugins -->
    <!-- <script src="../../../../vendor/datatables1/jquery.dataTables.min.js"></script>
    <script src="../../../../vendor/datatables1/datatables.min.js"></script> -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('.inputmask_currency').inputmask('numeric', {
                digits: 0,
                groupSeparator: '.',
                autoUnmask: true,
                stripLeadingZeroes: false,
            });
        });
        
        $('#datatable_quo_shipment').DataTable({
            scrollX: true,
            fixedColumns: {
                left: 0,
                right: 3,
            },
            ajax: {
                url: '<?php echo $base_url; ?>/config/controller/quotationShipmentController.php',
                type: 'GET',
                data: {
                    method: 'getHdQuoShipments',
                    tahun: '<?php echo $_GET['tahun'] ?>',
                },
                dataType: 'json',
                dataSrc: ''
            },
            columnDefs: [{
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                className: "text-nowrap"
            }],
            columns: [
                {data: 'created_at'},
                {
                    data: 'no_quotation',
                    render: function(data, type, row, meta) {
                        return `<div style="color:black; font-weight: bold">${row.no_quotation}</div>`;
                    }
                },
                {data: 'customer_name'},
                {data: 'customer_phone'},
                {data: 'total_container'},
                {data: 'master_unit_name'},
                {
                    data: 'is_need_trucking',
                    render: function(data, type, row, meta) {
                        if (row.is_need_trucking == 0) {
                            return `<div class='d-flex justify-content-center mt-1 text-success'><i class='fas fa-check-circle fa-lg'></i></div>`;
                        } else {
                            return `<div class='d-flex justify-content-center mt-1 text-danger'><i class='fas fa-times-circle fa-lg'></i></div>`;
                        };
                    }
                },
                {data: 'sales_name'},
                {data: 'vm_name'},
                {
                    data: 'status',
                    render: function(data, type, row, meta) {
                        return `<div class='badge badge-primary px-2 py-2' style="background:${row.status_color}">${row.status}</div>`;
                    }
                },
                {data: 'updated_at'},
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return `
                            <div class="d-flex">
                                <a href="form/edit.php?id=${row.id}" class="btn btn-primary mr-1"><i class="fas fa-edit"></i></a>
                                <button class="btn btn-secondary ml-1" onclick="getDetailQuotation(${row.id})"><i class="fas fa-eye"></i></button>
                            </div>
                        `;
                    }
                }
            ],
            rowId: 'id',
            stateSave: false,
            order: [
                [10, "desc"]
            ]
        });
        
        let year = $('#year').val();

        $('#year').on('change', function() {
            year = $(this).val();            
            window.location.href = `index.php?tahun=${year}`;
            $('#datatable_quo_shipment').DataTable().ajax.url('<?php echo $base_url; ?>/config/controller/quotationShipmentController.php?method=getHdQuoShipments&year=' + year).load();
        });

        getDetailQuotation = (id) => {
            $.ajax({
                url: '<?php echo $base_url; ?>/config/controller/quotationShipmentController.php',
                type: 'GET',
                data: {
                    method: 'getHdQuoShipmentDetails',
                    id: id,
                },
                success: function(response) {
                    console.log(`RESP: ${response}`);
                    let resp = JSON.parse(response);
                    $('#no_quotation').text(resp.no_quotation);
                    $('#total_costing').text(resp.total_costing);
                    $('#total_budgeting').text(resp.total_budgeting);
                    $('#total_pricing').text(resp.total_pricing);
                    $('#sales_name').val(resp.sales_name);
                    $('#sales_id').val(resp.sales_id);
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
                    $('#old_vm_id').val(resp.vm_id);
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
                            $(this).find('input[type="radio"]').prop('checked', true);
                        }
                    });
                    $('#modal_detail_quotation').modal('show')
                },
                error: function(xhr, status, error) {

                }
            });
        }
    </script>

</body>

</html>