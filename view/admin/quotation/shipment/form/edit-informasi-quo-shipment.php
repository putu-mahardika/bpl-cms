<?php 
    $isDisabled = '';
    if($data['status_id'] == 10) {
        $isDisabled = 'disabled';
    }
?>
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
                <label for="sales_id">Sales</label>
                <input type="hidden" class="form-control" id="sales_id" name="sales_id" placeholder="Masukkan nama sales..." disabled value="<?php echo $_SESSION['id']; ?>">
                <input type="text" class="form-control" id="sales_name" name="sales_name" placeholder="Masukkan nama sales..." disabled value="<?php echo $_SESSION['nama']; ?>">
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
                <input type="text" class="form-control text-right inputmask_qty" id="total_container" name="total_container" placeholder="0" maxlength="4" <?php echo $isDisabled ?>>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="border border-gray-300 px-3 rounded d-flex align-items-center position-relative" style="height: 44px; margin-top: 31px; border-color: #d1d3e2 !important">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkboxNewCustomer" value="option1" <?php if($data['customer_id'] == null) {?>checked<?php }?>>
                                <label class="custom-control-label" for="checkboxNewCustomer">Customer Baru</label>
                            </div>
                            <?php if($data['status_id'] == 10) {?>
                                <div style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; background-color: rgba(255, 255, 255, 0.5)"></div>
                            <?php }?>
                        </div>
                    </div>
                    <div id="customer_select" class="col-md-12 mt-3">
                        <label for="jumlahContainer">Customer</label>
                        <select name="" id="customer_id" class="form-control">
                            <?php foreach ($customers as $val) { ?>
                                <option value="<?php echo $val['CustId'] ?>" <?php if($val['CustId'] == $data['customer_id']) {?>selected<?php }?>><?php echo $val['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div id="customer_form" class="col-md-12 mt-3" style="display: none">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="customer_name_temp">Nama</label>
                                <input type="text" class="form-control" id="customer_name_temp" name="customer_name_temp" placeholder="Masukkan nama customer..." <?php echo $isDisabled ?>>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="customer_address_temp">Alamat</label>
                                <input type="text" class="form-control" id="customer_address_temp" name="customer_address_temp" placeholder="Masukkan alamat customer..." <?php echo $isDisabled ?>>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="pic_name_temp">PIC</label>
                                <input type="text" class="form-control" id="pic_name_temp" name="pic_name_temp" placeholder="Masukkan nama pic..." <?php echo $isDisabled ?>>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="pic_phone_temp">Telp</label>
                                <input type="text" class="form-control inputmask_phone" id="pic_phone_temp" name="pic_phone_temp" placeholder="Masukkan no telp..." <?php echo $isDisabled ?>>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="customer_terms_payment_temp">Customer Term Payment</label>
                                <input type="text" class="form-control inputmask_qty" id="customer_terms_payment_temp" name="customer_terms_payment_temp" placeholder="0" maxlength="3" value="7" <?php echo $isDisabled ?>>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <label for="item_description">Jenis Barang Bawaan (Opsional)</label>
                        <input type="text" class="form-control" id="item_description" name="item_description" placeholder="Masukkan jenis barang bawaan..." <?php echo $isDisabled ?>>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check form-check-inline mt-3">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="is_need_trucking">
                                <label class="custom-control-label" for="is_need_trucking">Membutuhkan Trucking</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>