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
                    <span style="font-size: 1.5rem;" class="inputmask_currency"><?php echo $totalCosting ?></span>
                </div>
            </div>
        </div>
        <button class="btn btn-secondary mt-4 w-100" disabled>Cetak Quotation</button>
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
                <p class="text-gray text-center mb-0">Anda tidak punya hak untuk melihat</p>
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
                <p class="text-gray text-center mb-0">Anda tidak punya hak untuk melihat</p>
            </div>
        </div>
        <button class="btn btn-secondary mt-4 w-100" disabled>Repeat Order</button>
    </div>
</div>