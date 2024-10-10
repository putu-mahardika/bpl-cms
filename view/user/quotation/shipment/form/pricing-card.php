<?php 
    $color = '';

    if ($totalPricing > $totalBudgeting) {
        $color = 'success';
    }

    if ($totalPricing > 0 && $totalPricing < $totalBudgeting) {
        $color = 'warning';
    }

    if ($totalPricing > 0 && $totalPricing < $totalCosting) {
        $color = 'danger';
    }

    if ($totalPricing == 0) {
        $color = 'neutral';
    }
?>
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
        <a class="btn btn-primary mt-4 w-100" target="_blank" href="../../../../generateQuo/shipment/quo.php?id=<?php echo $_GET['id'] ?>">Cetak Quotation</a>
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
                    <span style="font-size: 1.5rem;" class="inputmask_currency"><?php echo $totalBudgeting ?></span>
                </div>
            </div>
        </div>
        <button class="btn btn-warning mt-4 w-100" data-toggle="modal" data-target="#modal_form_customer_code" <?php if($totalPricing == 0) {?>disabled<?php }?>>Customer PO</button>
        <!-- Modal Submit CustomerCode Form -->
        <div class="modal fade" id="modal_form_customer_code" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal_form_customer_code" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelSubmitPOForm">Input Kode Customer ke sistem</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Untuk melanjutkan proses PO, customer <br>masih belum terdaftar. Silakan minta admin untuk mendaftarkan<br> customer terlebih dahulu.</p>
                        <div class="alert alert-warning d-flex my-4" role="alert">
                            <i class="fas fa-exclamation-triangle text-white fa-2x mr-3 mt-2"></i>
                            <div>
                                Kode customer akan dilakukan pengecekan berdasarkan sales juga, sehingga tidak bisa masuk sembarangan.
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Kode Customer</label>
                            <input type="text" class="form-control mb-3 inputmask_code" name="customer_code" id="customer_code" placeholder="Masukkan Kode Customer">
                        </div>
                    </div>
                    <div class="modal-footer d-flex">
                        <button type="button" class="btn btn-danger w-100" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary w-100" id="btn_check_customer_code" onclick="getCheckCustomerCode()">Periksa</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Submit PO Form -->
        <div class="modal fade" id="modal_form_customer_po" data-backdrop="static" data-keyboard="false" tabindex="-2" role="dialog" aria-labelledby="modal_form_customer_po" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelSubmitPOForm">Input PO Customer ke Sistem</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode Customer</label>
                            <input type="text" class="form-control inputmask_code" id="po_customer_code" name="po_customer_code" placeholder="Masukkan Kode Customer" disabled>
                        </div>
                        <div class="form-group">
                            <label>Nama Customer</label>
                            <input type="text" class="form-control" id="po_customer_name" name="po_customer_name" placeholder="Masukkan Nama Customer" disabled>
                        </div>
                        <div class="form-group">
                            <label>Kode Shipment</label>
                            <input type="text" class="form-control mb-3" placeholder="Masukkan Kode Shipment" name="shipment_code" value="" required>
                        </div>
                        <div class="form-group">
                            <label>PO Customer</label>
                            <input type="text" class="form-control mb-3" placeholder="Masukkan PO Customer" name="po_number" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal PO</label>
                            <input type="date" class="form-control mb-3" placeholder="Pilih tanggal PO" name="poDate" value="" required>
                        </div>
                        <div class="form-group">
                            <label>No SPK</label>
                            <input type="text" class="form-control mb-3" placeholder="Masukkan No SPK" name="spkNumber" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal SPK</label>
                            <input type="date" class="form-control mb-3" placeholder="Pilih tanggal No SPK" name="spkDate" value="" required>
                        </div>
                        <input type="hidden" class="form-control mb-3" name="totalArmada" value="<?php echo $dataForm['TotalArmada'] ?>">
                        <input type="hidden" class="form-control mb-3" name="originCity" value="<?php echo $dataForm['IdPickupCity'] ?>">
                        <input type="hidden" class="form-control mb-3" name="destinationCity" value="<?php echo $dataForm['IdDestinationCity1'] ?>">
                        <input type="hidden" class="form-control mb-3" name="destinationCity2" value="<?php echo $dataForm['IdDestinationCity2'] ?>">
                        <input type="hidden" class="form-control mb-3" name="destinationCity3" value="<?php echo $dataForm['IdDestinationCity3'] ?>">
                        <input type="hidden" class="form-control mb-3" name="originCityDesc" value="<?php echo $dataForm['PickupNote'] ?>">
                        <input type="hidden" class="form-control mb-3" name="destinationCityDesc" value="<?php echo $dataForm['DestinationNote'] ?>">
                        <input type="hidden" class="form-control mb-3" name="item" value="<?php echo $dataForm['ItemType'] ?>">
                        <input type="hidden" class="form-control mb-3" name="qty" value="<?php echo $dataForm['qty'] ?>">
                        <input type="hidden" class="form-control mb-3" name="idQuo" value="<?php echo $dataForm['Id'] ?>">
                    </div>
                    <div class="modal-footer d-flex">
                        <button type="button" class="btn btn-danger w-100" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary w-100" id="btn_save_po" onclick="">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 card-pricing <?php echo $color ?> rounded w-100" style="height: 120px;">
            <div class="card-pricing-title d-flex align-items-center mb-3">
                <div class="icon rounded d-flex align-items-center justify-content-center mr-2" style="width: 28px; height: 28px">
                    <i class="fas fa-sync"></i>
                </div>
                <h6 class="font-weight-bold title mb-0">Total Pricing</h6>
            </div>
            <div class="card-pricing-body">
                <div class="text-left">
                    <small>IDR</small>
                    <span style="font-size: 1.5rem;" class="inputmask_currency"><?php echo $totalPricing ?></span>
                </div>
            </div>
        </div>
        <button class="btn btn-secondary mt-4 w-100" disabled>Repeat Order</button>
    </div>
</div>