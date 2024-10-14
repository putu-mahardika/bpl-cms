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
                    <span style="font-size: 1.5rem;" class="inputmask_currency"><?php echo $data['total_costing'] ?? 0 ?></span>
                </div>
            </div>
        </div>
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
                    <span style="font-size: 1.5rem;" class="inputmask_currency"><?php echo $data['total_budgeting'] ?? 0 ?></span>
                </div>
            </div>
        </div>
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
                <p class="text-gray text-center mb-0">Anda tidak punya hak untuk melihat</p>
            </div>
        </div>
    </div>
</div>