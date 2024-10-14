<?php 
    $isDisabled = '';
    if($data['status_id'] == 10) {
        $isDisabled = 'disabled';
    }
?>
<div class="row mt-5">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold">List Vendor</h5>
    </div>
    <div class="col-md-12 mb-3">
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-budgeting-tab" data-toggle="pill" data-target="#pills-budgeting" type="button" role="tab" aria-controls="pills-budgeting" aria-selected="true">
                    Budgeting
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-pricing-tab" data-toggle="pill" data-target="#pills-pricing" type="button" role="tab" aria-controls="pills-pricing" aria-selected="true">
                    Pricing
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" id="pills-budgeting" role="tabpanel" aria-labelledby="budgeting-tab">
                <?php if (count($dataDtlQuoShipment) > 0) { ?>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive">
                                <table class="table align-items-center table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-nowrap px-3" style="font-size: 14px;">&nbsp;</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px;">Vendor</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">1ST</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">Next</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">Total</th>
                                            <?php if (count($dataDtlQuoShipment) < 1) { ?>
                                                <th class="text-nowrap" style="font-size: 14px;">&nbsp;</th>
                                            <?php }?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($data['status_id'] == 10) { ?>
                                            <?php include 'edit-list-vendor-budgeting-disabled.php' ?>
                                        <?php } else {?>
                                            <?php if (count($dataDtlQuoShipment) > 0 && $data['total_budgeting'] == 0) { ?>
                                                <?php foreach ($dataDtlQuoShipment as $key => $value) { ?>
                                                    <?php include 'edit-list-vendor-budgeting-edit.php' ?>
                                                <?php } ?>
                                            <?php } else {?>
                                                <?php if ($data['unselect_budgeting_total_price'] > 0) { ?>
                                                    <?php foreach ($dataDtlQuoShipment as $key => $value) { ?>
                                                        <?php include 'edit-list-vendor-budgeting-edit.php' ?>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td colspan="5">Belum ada Budgeting</td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } else {?>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive">
                                <table class="table align-items-center table-bordered" id="table_list_vendor">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-nowrap px-3" style="font-size: 14px;">&nbsp;</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px;">Vendor</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">1ST</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">Next</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada Budgeting</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="tab-pane fade show active" id="pills-pricing" role="tabpanel" aria-labelledby="pricing-tab">
                <div class="row">
                    <?php if ($data['unselect_budgeting_total_price'] > 0) { ?>
                        <?php if ($data['status_id'] != 10) { ?>
                            <div class="col-md-6">
                                <label for="">Pricing 1ST</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-right inputmask_currency" id="apply_pricing_first" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Pricing Next</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-right inputmask_currency" id="apply_pricing_next" placeholder="0">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick="calcApplyAllPricing()">
                                            Apply All
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive">
                                <table class="table align-items-center table-bordered" id="table_list_vendor">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-nowrap px-3" style="font-size: 14px;">&nbsp;</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px;">Vendor</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">1ST</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">Next</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">Total</th>
                                            <?php if (count($dataDtlQuoShipment) < 1) { ?>
                                                <th class="text-nowrap" style="font-size: 14px;">&nbsp;</th>
                                            <?php }?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($data['status_id'] == 10) { ?>
                                            <?php include 'edit-list-vendor-disabled.php' ?>
                                        <?php } else {?>
                                            <?php if (count($dataDtlQuoShipment) > 0) { ?>
                                                <?php foreach ($dataDtlQuoShipment as $key => $value) { ?>
                                                    <?php include 'edit-list-vendor-edit.php' ?>
                                                <?php } ?>
                                            <?php } else {?>
                                                <tr>
                                                    <td colspan="5">Belum ada Budgeting</td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } else {?>
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive">
                                <table class="table align-items-center table-bordered" id="table_list_vendor">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-nowrap px-3" style="font-size: 14px;">&nbsp;</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px;">Vendor</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">1ST</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">Next</th>
                                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada Budgeting</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>