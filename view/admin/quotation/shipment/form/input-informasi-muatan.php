<div class="row mt-5">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold">Informasi Muatan</h5>
    </div>
    <div class="col-md-12">
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
</div>