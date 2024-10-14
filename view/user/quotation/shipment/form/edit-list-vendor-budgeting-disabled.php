<tr>
    <td class="px-2 text-nowrap align-middle" style="font-size: 14px; width: 50px !important">
        <div class="custom-control custom-radio" style="padding-left: 2rem">
            <input type="radio" class="custom-control-input" checked disabled>
            <label class="custom-control-label"></label>
        </div>
    </td>
    <td class="px-2">
        <select name="vendor_id" class="form-control vendor_id" <?php echo $isDisabled ?>>
            <?php foreach ($vendors as $val) { ?>
                <option value="<?php echo $val['Id'] ?>" <?php if ($val['Id'] == $data['selected_quo_vendor_id']) { ?> selected <?php } ?>><?php echo $val['nama'] ?></option>
            <?php } ?>
        </select>
    </td>
    <td class="px-2">
        <input type="hidden" class="form-control text-right inputmask_currency" placeholder="0" value="<?php echo $data['dtl_quo_shipment_id'] ?>">
        <input type="text" class="form-control text-right inputmask_currency" placeholder="0" value="<?php echo $data['dtl_quo_shipment_budgeting_first_price'] ?>" disabled>
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right inputmask_currency" placeholder="0" value="<?php echo $data['dtl_quo_shipment_budgeting_next_price'] ?>" disabled>
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right inputmask_currency" disabled placeholder="0" value="<?php echo $data['dtl_quo_shipment_budgeting_total_price'] ?>" disabled>
    </td>
</tr>