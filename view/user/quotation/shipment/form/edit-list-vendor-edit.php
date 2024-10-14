<tr>
    <td class="px-2 text-nowrap align-middle" style="font-size: 14px; width: 50px !important">
        <div class="custom-control custom-radio" style="padding-left: 2rem">
            <input type="radio" class="custom-control-input" disabled>
            <label class="custom-control-label"></label>
        </div>
    </td>
    <td class="px-2">
        <select name="vendor_id" class="form-control vendor_id" disabled>
            <?php foreach ($vendors as $val) { ?>
                <option value="<?php echo $val['Id'] ?>" <?php if ($val['Id'] == $value['vendor_id']) { ?> selected <?php } ?>><?php echo $val['nama'] ?></option>
            <?php } ?>
        </select>
    </td>
    <td class="px-2">
        <input type="hidden" class="form-control text-right dtl_quo_shipment_id inputmask_currency" placeholder="0" value="<?php echo $value['id'] ?>">
        <input type="hidden" class="form-control text-right costing_first_price inputmask_currency" placeholder="0" value="<?php echo $value['costing_first_price'] ?>" <?php echo $isDisabled ?>>
        <input type="hidden" class="form-control text-right budgeting_first_price inputmask_currency" placeholder="0" value="<?php echo $value['budgeting_first_price'] ?>">
        <input type="text" class="form-control text-right pricing_first_price inputmask_currency" placeholder="0" value="<?php echo $value['pricing_first_price'] ?>">
    </td>
    <td class="px-2">
        <input type="hidden" class="form-control text-right costing_next_price inputmask_currency" placeholder="0" value="<?php echo $value['costing_next_price'] ?>" <?php echo $isDisabled ?>>
        <input type="hidden" class="form-control text-right budgeting_next_price inputmask_currency" placeholder="0" value="<?php echo $value['budgeting_next_price'] ?>">
        <input type="text" class="form-control text-right pricing_next_price inputmask_currency" placeholder="0" value="<?php echo $value['pricing_next_price'] ?>">
    </td>
    <td class="px-2">
        <input type="hidden" class="form-control text-right costing_total_price inputmask_currency" placeholder="0" value="<?php echo $value['costing_total_price'] ?>" disabled>
        <input type="hidden" class="form-control text-right budgeting_total_price inputmask_currency" disabled placeholder="0" value="<?php echo $value['budgeting_total_price'] ?>">
        <input type="text" class="form-control text-right pricing_total_price inputmask_currency" placeholder="0" value="<?php echo $value['pricing_total_price'] ?>" disabled>
    </td>
</tr>