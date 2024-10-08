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
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkboxNewCustomer" value="option1">
                            <label class="custom-control-label" for="checkboxNewCustomer">Customer Baru</label>
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
                            <div class="col-md-12 mb-3">
                                <label for="customer_terms_payment_temp">Customer Term Payment</label>
                                <input type="text" class="form-control inputmask_qty" id="customer_terms_payment_temp" name="customer_terms_payment_temp" placeholder="0" maxlength="3" value="7">
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