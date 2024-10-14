<?php 
    $isDisabled = '';
    if($data['status_id'] == 10) {
        $isDisabled = 'disabled';
    }
?>
<div class="row mt-5">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold">Informasi Biaya Freight</h5>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="freight_cost">Biaya Freight</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-primary text-white px-2">US$</div>
                    </div>
                    <input type="text" class="form-control text-right inputmask_currency" id="freight_cost" name="freight_cost" placeholder="0" <?php echo $isDisabled ?>>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <label for="currency_date">Tanggal Kurs (Saat ini)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-primary text-white"><i class="far fa-calendar fa-fw"></i></div>
                    </div>
                    <input type="date" class="form-control date_single" id="currency_date" name="currency_date" placeholder="<?php echo date('d-m-Y') ?>" readonly>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <label for="currency_rate">Kurs USD - IDR (Saat ini)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-primary text-white px-2">IDR</div>
                    </div>
                    <input type="text" class="form-control text-right inputmask_currency" id="currency_rate" name="currency_rate" placeholder="0" <?php echo $isDisabled ?>>
                </div>
            </div>
        </div>
    </div>
</div>