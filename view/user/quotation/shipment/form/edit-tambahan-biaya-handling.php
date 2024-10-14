<div class="row mt-5">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold">Tambahan Biaya Handling</h5>
    </div>
    <?php if(count($dataDtlQuoShipmentHandlingCosts) > 0) {?>
        <div class="col-md-12 mb-3">
            <div class="table-responsive">
                <table class="table align-items-center table-bordered" id="table_handling_1">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 250px">
                                Nama Biaya Handling <div>First</div>
                            </th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 125px">
                                Qty (dari <div>Jumlah Container)</div>
                            </th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                                Harga Budgeting Handling<div>First</div>
                            </th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                                Total Budgeting Handling<div>First</div>
                            </th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                                Harga Pricing Handling<div>First</div>
                            </th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                                Total Pricing Handling<div>First</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data['status_id'] == 10) { ?>
                            <?php include 'edit-tambahan-biaya-handling-first-disabled.php' ?>
                        <?php } else {?>
                            <?php if (count($dataDtlQuoShipmentHandlingCosts) > 0) { ?>
                                <?php include 'edit-tambahan-biaya-handling-first-edit.php' ?>
                            <?php } else {?>
                                <?php include 'edit-tambahan-biaya-handling-first-create.php' ?>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="table-responsive">
                <table class="table align-items-center table-bordered" id="table_handling_next">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 250px">
                                Nama Biaya Handling <div>Next</div>
                            </th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 125px">
                                Qty (dari <div>Jumlah Container)</div>
                            </th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                                Harga Budgeting Handling<div>Next</div>
                            </th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                                Total Budgeting Handling<div>Next</div>
                            </th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                                Harga Pricing Handling<div>Next</div>
                            </th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                                Total Pricing Handling<div>Next</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data['status_id'] == 10) { ?>
                            <?php include 'edit-tambahan-biaya-handling-next-disabled.php' ?>
                        <?php } else {?>
                            <?php if (count($dataDtlQuoShipmentHandlingCosts) > 0) { ?>
                                <?php include 'edit-tambahan-biaya-handling-next-edit.php' ?>
                            <?php } else {?>
                                <?php include 'edit-tambahan-biaya-handling-next-create.php' ?>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } else {?>
        <div class="col-md-12 mb-3">
            <div class="text-center p-4 border">Belum ada Tambahan Biaya Handling</div>
        </div>
    <?php }?>
</div>