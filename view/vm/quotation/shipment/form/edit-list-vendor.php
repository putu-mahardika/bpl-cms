<?php 
    $isDisabled = '';
    if($data['status_id'] == 10) {
        $isDisabled = 'disabled';
    }
?>
<div class="row mt-5">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold">List Vendor</h5>
        <?php if($data['status_id'] != 10) {?>
            <div class="d-flex">
                <?php if($data['total_pricing'] > 0) {?>
                    <button type="button" class="btn btn-secondary d-flex align-items-center justify-content-center mr-2" data-toggle="modal" data-target="#modal_add_vendor">
                        <i class="fas fa-plus mr-2"></i>
                        <div>Tambah Vendor</div>
                    </button>
                <?php }?>
                <?php include '../modal/modal-form-vendor.php' ?>
                <?php if(count($dataDtlQuoShipment) <= 0) {?>
                    <button class="btn btn-primary" onclick="addRow()"><i class="fas fa-plus"></i></button>
                <?php }?>
            </div>
        <?php }?>
    </div>
    <div class="col-md-12 mb-3">
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-costing-tab" data-toggle="pill" data-target="#pills-costing" type="button" role="tab" aria-controls="pills-costing" aria-selected="true">
                    Costing
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-budgeting-tab" data-toggle="pill" data-target="#pills-budgeting" type="button" role="tab" aria-controls="pills-budgeting" aria-selected="true">
                    Budgeting
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="pills-costing" role="tabpanel" aria-labelledby="costing-tab">
                <div class="row">
                    <?php if ($data['status_id'] != 10) { ?>
                        <div class="col-md-6">
                            <label for="">Costing 1ST</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-right inputmask_currency" id="apply_costing_first" placeholder="0" <?php echo $isDisabled ?>>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Costing Next</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-right inputmask_currency" id="apply_costing_next" placeholder="0" <?php echo $isDisabled ?>>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="calcApplyAllCosting()" <?php echo $isDisabled ?>>
                                        Apply All
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    <div class="col-md-12 mt-3">
                        <div class="table-responsive">
                            <table class="table align-items-center table-bordered table_list_vendor" id="table_list_vendor">
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
                                            <?php include 'edit-list-vendor-create.php' ?>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="pills-budgeting" role="tabpanel" aria-labelledby="budgeting-tab">
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
                                        <?php if (count($dataDtlQuoShipment) > 0) { ?>
                                            <?php foreach ($dataDtlQuoShipment as $key => $value) { ?>
                                                <?php include 'edit-list-vendor-budgeting-edit.php' ?>
                                            <?php } ?>
                                        <?php } else {?>
                                            <tr>
                                                <td colspan="<?php if (count($dataDtlQuoShipment) < 1) { ?>6<?php } else {?>5<?php }?>" class="text-center">Belum ada Budgeting</td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>