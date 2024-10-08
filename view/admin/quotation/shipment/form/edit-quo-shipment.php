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
                <input type="text" class="form-control text-right inputmask_qty" id="total_container" name="total_container" placeholder="0" maxlength="4" disabled>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <label for="customer_name">Customer</label>
                        <input type="hidden" class="form-control" id="customer_id" name="customer_id">
                        <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Masukkan jenis barang bawaan..." disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <label for="item_description">Jenis Barang Bawaan (Opsional)</label>
                        <input type="text" class="form-control" id="item_description" name="item_description" placeholder="Masukkan jenis barang bawaan..." disabled>
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