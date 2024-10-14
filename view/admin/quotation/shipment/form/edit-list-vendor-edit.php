<tr>
    <td class="px-2 text-nowrap align-middle" style="font-size: 14px; width: 50px !important">
        <div class="custom-control custom-radio" style="padding-left: 2rem">
            <input type="radio" class="custom-control-input selected_quo_vendor_id" name="selected_quo_vendor_id" id="selected_quo_vendor_id<?php echo $key ?>" value="<?php echo $val['vendor_id'] ?>" <?php if ($data['unselect_pricing_total_price'] == 0) { ?> disabled <?php } ?> onclick="setPricingCard()">
            <label class="custom-control-label" for="selected_quo_vendor_id<?php echo $key ?>"></label>
        </div>
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; min-width: 250px !important">
        <input type="hidden" class="form-control text-right dtl_quo_shipment_id" value="<?php echo $val['id'] ?>">
        <select name="vendor_id" class="form-control vendor_id">
            <?php foreach ($vendors as $valVendor) { ?>
                <option value="<?php echo $valVendor['Id'] ?>" <?php if ($valVendor['Id'] == $val['vendor_id']) { ?> selected <?php } ?>><?php echo $valVendor['nama'] ?></option>
            <?php } ?>
        </select>
    </td>
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right costing_first_price inputmask_currency" placeholder="0" value="<?php echo $val['costing_first_price'] ?>">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right costing_next_price inputmask_currency" placeholder="0" value="<?php echo $val['costing_next_price'] ?>">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right costing_total_price inputmask_currency" disabled placeholder="0" value="<?php echo $val['costing_total_price'] ?>">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right budgeting_first_price inputmask_currency" placeholder="0" value="<?php echo $val['budgeting_first_price'] ?>">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right budgeting_next_price inputmask_currency" placeholder="0" value="<?php echo $val['budgeting_next_price'] ?>">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right budgeting_total_price inputmask_currency" disabled placeholder="0" value="<?php echo $val['budgeting_total_price'] ?>">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right pricing_first_price inputmask_currency" placeholder="0" value="<?php echo $val['pricing_first_price'] ?>">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right pricing_next_price inputmask_currency" placeholder="0" value="<?php echo $val['pricing_next_price'] ?>">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right pricing_total_price inputmask_currency" disabled placeholder="0" value="<?php echo $val['pricing_total_price'] ?>">
    </td>
</tr>
<script>
    function setPricingCard(data) {
        $('#total_costing').text("<?php echo $val['costing_total_price']?>");
        $('#total_budgeting').text("<?php echo $val['budgeting_total_price']?>");
        $('#total_pricing').text("<?php echo $val['pricing_total_price']?>");
    }
</script>