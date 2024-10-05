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

$customers = getCustomers($koneksi, $s_id);
$shipmentTerms = getShipmentTerms($koneksi);
$shipmentLoadTypes = getShipmentLoadTypes($koneksi);
$shipmentContainers = getShipmentContainers($koneksi);
$countries = getCountries($koneksi);
// print_r(json_encode($shipmentTerms));die();

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
										<?php include 'input-informasi-quo-shipment.php' ?>
									</div>
									<div class="row mt-5">
										<?php include 'input-informasi-muatan.php' ?>
									</div>
									<div class="row mt-5">
										<?php include 'input-permintaan-customer.php' ?>
									</div>
									<div class="row mt-5">
										<?php include 'input-tambahan-biaya-handling.php' ?>
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

		});

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
				if ($('#customer_terms_payment_temp').val() == '' || $('#customer_terms_payment_temp').val() < 0) {
					toastr.error('Customer temp payment harus diisi', 'Required!')
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

		createHdQuoShipments = () => {
			if (getValidate()) {
				return;
			}

			let data = {
				method: 'createHdQuoShipments',
				// hdQuoShipment
				customer_id: $('#customer_id').val(),
				sales_id: $('#sales_id').val(),
				total_container: $('#total_container').val(),
				item_description: $('#item_description').val(),
				vm_id: null,
				quo_status_id: 1,
				customer_name_temp: $('#customer_name_temp').val(),
				customer_address_temp: $('#customer_address_temp').val(),
				customer_terms_payment_temp: $('#customer_terms_payment_temp').val(),
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
				// // dtlQuoShipment
				// vendor_id: null,
				// costing_first_price: 0,
				// costing_next_price: 0,
				// costing_total_price: 0,
				// budgeting_first_price: 0,
				// budgeting_next_price: 0,
				// budgeting_total_price: 0,
				// pricing_first_price: 0,
				// pricing_next_price: 0,
				// pricing_total_price: 0,
				// // dtlQuoShipmentHandlingCosts
				// sales_id: null,
				// vm_id: null,
				// handling_turunan: null,
				// handling_description: null,
				// quantity: 0,
				// unit_cost: 0,
				// total_cost: 0,
				// last_updated_unit_at: null,
				// unit_budgeting: 0,
				// total_budgeting: 0,
				// last_updated_budgeting_at: null,
				// unit_price: 0,
				// total_price: 0,
				// last_updated_prices_at: null,
				// last_updated_by_id: null,
				// last_updated_by_name: null,
				// attribute_1: null,
				// attribute_2: null,
				// attribute_3: null,
				// // dtlQuoShipmentHandlingCosts
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
							window.location.href = '<?php echo $base_url; ?>/view/user/quotation/shipment/index.php';
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