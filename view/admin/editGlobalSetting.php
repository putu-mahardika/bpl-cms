<?php
session_save_path('../../tmp');
session_start();
if ($_SESSION['hak_akses'] == "" || $_SESSION['hak_akses'] != "Admin") {
    header("location:../../index.php?pesan=belum_login");
}
include '../../config/koneksi.php';
include '../../config/controller/globalSettingController.php';
date_default_timezone_set("Asia/Jakarta");

$data = getData($koneksi, $_GET['code']);

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
    <title>Edit Kota - PT Berkah Permata Logistik</title>
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../../vendor/sweetalert2/dist/sweetalert2.all.min.css" rel="stylesheet" type="text/css">
    <link href="../../vendor/toastr/build/toastr.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard-admin.php?tahun=<?php echo $datetime ?>">
                <div class="sidebar-brand-icon">
                    <img src="../../img/logo-BPL-white-min.png" style="height:130px;">
                </div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="dashboard-admin.php?tahun=<?php echo $datetime ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Master
            </div>
            <li class="nav-item">
                <a class="nav-link" href="user.php">
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
                        <a class="collapse-item" href="customer.php">List Customer</a>
                        <a class="collapse-item" href="vendor.php">List Vendor</a>
                        <a class="collapse-item" href="kota.php">List Kota</a>
                        <a class="collapse-item" href="negara.php">List Negara</a>
                        <a class="collapse-item" href="unit.php">List Unit</a>
                        <a class="collapse-item" href="jenisKendaraan.php">List Jenis Kendaraan</a>
                        <a class="collapse-item" href="loadType.php">List Load Type</a>
                        <a class="collapse-item" href="status.php">List Status Trucking</a>
                        <a class="collapse-item" href="statusShipment.php">List Status Shipment</a>
                        <a class="collapse-item" href="shipmentTerms.php">List Shipment Terms</a>
                        <a class="collapse-item" href="globalSetting.php">List Global Settings</a>
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
                        <a class="collapse-item" href="quotation/trucking/index.php">List Quo Trucking</a>
                        <h6 class="collapse-header">Quo Shipment</h6>
                        <a class="collapse-item" href="quotation/shipment/index.php">List Quo Shipment</a>
                        <!--<a class="collapse-item" href="datatables.html">DataTables</a>-->
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="shipment.php?tahun=<?php echo $datetime ?>">
                    <i class="fas fa-fw fa-ship"></i>
                    <span>Shipment</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="transaksi.php?tahun=<?php echo $datetime ?>">
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
                                <img class="img-profile rounded-circle" src="../../img/boy.png" style="max-width: 60px">
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
                        <a href="globalSetting.php" style="margin-right:20px;"><i class="far fa-arrow-alt-circle-left fa-2x" title="kembali"></i></a>
                        <h1 class="h3 mb-0 text-gray-800">Edit Global Setting</h1>
                    </div>
                    <div class="card-body">
                        <form class="form group" method="post">
                            <label>Code :</label>
                            <input type="text" class="form-control mb-3" id="code" value="<?php echo $data['Code']; ?>" name="code" minlength="3" maxlength="30" pattern="^([a-zA-Z]+\s)*[a-zA-Z]+$" title="Nama Kota hanya boleh diisi huruf" placeholder="Isikan Code..." disabled required>
                            <label>Val :</label>
                            <textarea class="form-control" name="val" id="val" value="<?php echo $data['val'] ?>" rows="10"><?php echo $data['val'] ?></textarea>
                            <label class="mt-3">Description</label>
                            <textarea class="form-control mb-3" name="description" id="description" placeholder="Isikan Description..." value="<?php echo $data['description'] ?>" rows="5"><?php echo $data['description'] ?></textarea>
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="reset" value="Reset" class="btn btn-danger w-100">
                                </div>
                                <div class="col-md-10">
                                    <button type="button" class="btn btn-md btn-primary w-100" onclick="updateData('<?php $data['Code'] ?>')">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Logout -->
                    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
                        aria-hidden="true">
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

    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="../../vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="../../vendor/toastr/build/toastr.min.js"></script>
    <script src="../../js/ruang-admin.min.js"></script>
    <script>
        tinymce.init({
            selector: '#val',
            height: 300
        });

        getValidate = () => {
            if (tinymce.get('val').getContent() == '' || tinymce.get('val').getContent() == null) {
                toastr.error('Val harus diisi', 'Required!')
                return true;
            }

            if ($('#description').val() == '' || $('#description').val() == null) {
                toastr.error('Description harus diisi', 'Required!')
                return true;
            }

            return false;
        };

        updateData = (id) => {
            if (getValidate()) {
                return;
            }

            let data = {
                method: 'updateData',
                code: $('#code').val(),
                val: tinymce.get('val').getContent(),
                description: $('#description').val(),
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
                url: '<?php echo $base_url; ?>/config/controller/globalSettingController.php',
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
                            window.location.href = '<?php echo $base_url; ?>/view/admin/globalSetting.php';
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