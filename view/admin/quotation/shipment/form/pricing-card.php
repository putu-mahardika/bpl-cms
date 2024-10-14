<?php 
    $color = '';

    if ($data['total_pricing'] > $data['total_budgeting']) {
        $color = 'success';
    }

    if ($data['total_pricing'] > 0 && $data['total_pricing'] < $data['total_budgeting']) {
        $color = 'warning';
    }

    if ($data['total_pricing'] > 0 && $data['total_pricing'] < $data['total_costing']) {
        $color = 'danger';
    }

    if ($data['total_pricing'] == 0) {
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
                <div class="text-left">
                    <small>IDR</small>
                    <span style="font-size: 1.5rem;" class="inputmask_currency" id="total_costing"><?php echo $data['total_costing'] ?></span>
                </div>
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
                    <span style="font-size: 1.5rem;" class="inputmask_currency" id="total_budgeting"><?php echo $data['total_budgeting'] ?></span>
                </div>
            </div>
        </div>
        <button class="btn btn-warning mt-4 w-100" <?php if($data['total_pricing'] == 0) {?>disabled<?php }?>>Customer PO</button>
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
                    <span style="font-size: 1.5rem;" class="inputmask_currency" id="total_pricing"><?php echo $data['total_pricing'] ?></span>
                </div>
            </div>
        </div>
        <button class="btn btn-secondary mt-4 w-100" disabled>Repeat Order</button>
    </div>
</div>