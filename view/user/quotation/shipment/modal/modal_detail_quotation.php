<div class="modal fade" id="modal_detail_quotation" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="mb-0" id="no_quotation"></h4>
                <a href="javascript:;" data-dismiss="modal" class="close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
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
                                    <span style="font-size: 1.5rem;" class="inputmask_currency" id="total_budgeting"></span>
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
                                    <span style="font-size: 1.5rem;" class="inputmask_currency" id="total_pricing"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>