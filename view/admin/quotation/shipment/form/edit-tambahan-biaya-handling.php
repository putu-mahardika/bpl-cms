<div class="row mt-5">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold">Tambahan Biaya Handling</h5>
    </div>
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
                            Harga Costing Handling<div>First</div>
                        </th>
                        <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                            Total Costing Handling<div>First</div>
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
                    <?php if (count($dataDtlQuoShipmentHandlingCosts) > 0) { ?>
                        <?php foreach ($dataDtlQuoShipmentHandlingCosts as $key => $val) { ?>
                            <?php if ($val['handling_turunan'] == 1) { ?>
                                <tr>
                                    <td class="px-3">
                                        <input type="hidden" class="form-control" id="handling_id_1" name="handling_id_1" placeholder="Masukkan nama biaya handling..." value="<?php echo $val['id'] ?>">
                                        <input type="text" class="form-control" id="handling_name_1" name="handling_name_1" placeholder="Masukkan nama biaya handling..." value="<?php echo $val['handling_description'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_qty_1" name="handling_qty_1" placeholder="0">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_cost_1" name="handling_unit_cost_1" placeholder="0" value="<?php echo $val['unit_cost'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_total_cost_1" name="handling_total_cost_1" placeholder="0" disabled value="<?php echo $val['total_cost'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_budgeting_1" name="handling_unit_budgeting_1" placeholder="0" value="<?php echo $val['unit_budgeting'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_total_budgeting_1" name="handling_total_budgeting_1" placeholder="0" disabled value="<?php echo $val['total_budgeting'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_price_1" name="handling_unit_price_1" placeholder="0" value="<?php echo $val['unit_price'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_total_price_1" name="handling_total_price_1" placeholder="0" disabled value="<?php echo $val['total_price'] ?>">
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    <?php } else {?>
                        <tr>
                            <td class="px-3">
                                <input type="hidden" class="form-control" id="handling_id_1" name="handling_id_1" placeholder="Masukkan nama biaya handling..." value="<?php echo $val['id'] ?>">
                                <input type="text" class="form-control" id="handling_name_1" name="handling_name_1" placeholder="Masukkan nama biaya handling..." value="<?php echo $val['handling_description'] ?>">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_qty_1" name="handling_qty_1" placeholder="0">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_cost_1" name="handling_unit_cost_1" placeholder="0" value="<?php echo $val['unit_cost'] ?>">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_total_cost_1" name="handling_total_cost_1" placeholder="0" disabled value="<?php echo $val['total_cost'] ?>">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_budgeting_1" name="handling_unit_budgeting_1" placeholder="0" value="<?php echo $val['unit_budgeting'] ?>">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_total_budgeting_1" name="handling_total_budgeting_1" placeholder="0" disabled value="<?php echo $val['total_budgeting'] ?>">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_price_1" name="handling_unit_price_1" placeholder="0" value="<?php echo $val['unit_price'] ?>">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_total_price_1" name="handling_total_price_1" placeholder="0" disabled value="<?php echo $val['total_price'] ?>">
                            </td>
                        </tr>
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
                            Harga Costing Handling<div>Next</div>
                        </th>
                        <th class="text-nowrap px-3" style="font-size: 14px; width: 175px">
                            Total Costing Handling<div>Next</div>
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
                    <?php if (count($dataDtlQuoShipmentHandlingCosts) > 0) { ?>
                        <?php foreach ($dataDtlQuoShipmentHandlingCosts as $key => $val) { ?>
                            <?php $total_unit_cost += $val['unit_cost'];
                            $total_cost += $val['total_cost'] ?>
                            <?php if ($val['handling_turunan'] == 2) { ?>
                                <tr>
                                    <td class="px-3">
                                        <input type="hidden" class="form-control" id="handling_id_next" name="handling_id_next" placeholder="Masukkan nama biaya handling..." value="<?php echo $val['id'] ?>">
                                        <input type="text" class="form-control" id="handling_name_next" name="handling_name_next" placeholder="Masukkan nama biaya handling..." value="<?php echo $val['handling_description'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_qty_next" name="handling_qty_next" placeholder="0">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_cost_next" name="handling_unit_cost_next" placeholder="0" value="<?php echo $val['unit_cost'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_total_cost_next" name="handling_total_cost_next" placeholder="0" disabled value="<?php echo $val['total_cost'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_budgeting_next" name="handling_unit_budgeting_next" placeholder="0" value="<?php echo $val['unit_budgeting'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_total_budgeting_next" name="handling_total_budgeting_next" placeholder="0" disabled value="<?php echo $val['total_budgeting'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_price_next" name="handling_unit_price_next" placeholder="0" value="<?php echo $val['unit_price'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right inputmask_currency" id="handling_total_price_next" name="handling_total_price_next" placeholder="0" disabled value="<?php echo $val['total_price'] ?>">
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    <?php } else {?>
                        <tr>
                            <td class="px-3">
                                <input type="hidden" class="form-control" id="handling_id_next" name="handling_id_next" placeholder="Masukkan nama biaya handling..." value="<?php echo $val['id'] ?>">
                                <input type="text" class="form-control" id="handling_name_next" name="handling_name_next" placeholder="Masukkan nama biaya handling..." value="<?php echo $val['handling_description'] ?>">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_qty_next" name="handling_qty_next" placeholder="0">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_cost_next" name="handling_unit_cost_next" placeholder="0" value="<?php echo $val['unit_cost'] ?>">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_total_cost_next" name="handling_total_cost_next" placeholder="0" disabled value="<?php echo $val['total_cost'] ?>">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_budgeting_next" name="handling_unit_budgeting_next" placeholder="0" value="<?php echo $val['unit_budgeting'] ?>">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_total_budgeting_next" name="handling_total_budgeting_next" placeholder="0" disabled value="<?php echo $val['total_budgeting'] ?>">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_price_next" name="handling_unit_price_next" placeholder="0" value="<?php echo $val['unit_price'] ?>">
                            </td>
                            <td class="px-3">
                                <input type="text" class="form-control text-right inputmask_currency" id="handling_total_price_next" name="handling_total_price_next" placeholder="0" disabled value="<?php echo $val['total_price'] ?>">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <!-- <tfoot>
                    <td class="px-3" colspan="2"></td>
                    <td class="px-3">
                        <input type="text" class="form-control text-right inputmask_currency" id="total_handling_unit_cost" name="total_handling_unit_cost" placeholder="0" disabled value="<?php echo $total_unit_cost ?>">
                    </td>
                    <td class="px-3">
                        <input type="text" class="form-control text-right inputmask_currency" id="total_handling_cost" name="total_handling_cost" placeholder="0" disabled value="<?php echo $total_cost ?>">
                    </td>
                </tfoot> -->
            </table>
        </div>
    </div>
</div>