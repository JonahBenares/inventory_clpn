 
 <tr id='item_row<?php echo $list['count']; ?>'>  
    <td style="padding: 0px "><center><?php echo $list['count']; ?></center></td>
    <td style="padding: 0px "><input type = "text" name = "supplier[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value = "<?php echo $list['supplier']; ?>" ></td>
    <td style="padding: 0px "><textarea  rows="3" type = "text" name = "item[]" id="itemlist_<?php echo $list['count']; ?>" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none"><?php echo $list['item']; ?></textarea></td>
     <td style="padding: 0px "><input type = "text" name = "brand[]" id="brandlist_<?php echo $list['count']; ?>" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value="<?php echo $list['brand']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "catalog_no[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value="<?php echo $list['catno']; ?>"></td>
     <td style="padding: 0px "><input type = "text" name = "serial[]" id="seriallist_<?php echo $list['count']; ?>" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value="<?php echo $list['serial']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "unit_cost[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value="<?php echo $list['unitcost']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "shipping_fee[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value = "<?php echo $list['shipping_fee']; ?>" ></td>
    <td style="padding: 0px "><input type = "text" name = "total_cost[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value="<?php echo $list['total']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "expqty[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value = "<?php echo $list['expqty']; ?>" ></td>
    <td style="padding: 0px "><input type = "text" name = "recqty[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value = "<?php echo $list['recqty']; ?>" ></td>
   <!--  <td style="padding: 0px "><input type = "text" name = "inspected[]" style = "text-align:center;width:100%;border:0px transparent;pointer-events: none" value = "<?php echo $list['inspected']; ?>" > -->
      <!--   <input type = "hidden" name = "inspected_name[]" style = "text-align:center;width:100%;border:0px transparent;pointer-events: none" value = "<?php echo $list['inspected_name']; ?>" ></td> -->
    <td style="padding: 0px "><input type = "hidden"  name = "unit[]" value="<?php echo $list['unit']; ?>"><input type = "text" style = "text-align:center;width:100%;border:0px transparent;pointer-events: none" value = "<?php echo $list['unit_name']; ?>" ></td>
    <!-- <td style="padding: 0px "><input type = "text" name = "currency[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value = "<?php echo $list['currency']; ?>" ></td> -->
    <td style="padding: 0px "><input type = "text" name = "total_net_cost[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value="<?php echo $list['total_net_cost']; ?>"></td>
    <td style="padding: 0px "><textarea rows="3" wrap="soft" name = "remarks[]"  style = "width:100%;border:1px transparent;pointer-events: none" ><?php echo $list['remarks']; ?></textarea></td>
    <td><?php if($list['local_mnl'] == '1'){ ?>
    <input type = "hidden" name = "local_mnl[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value = "1" ><input type = "text" style = "text-align:center;width:100%;border:0px transparent;pointer-events: none" value = "Local" >
    <?php } else if($list['local_mnl'] == '2') { ?>
    <input type = "hidden" name = "local_mnl[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value = "2" ><input type = "text" style = "text-align:center;width:100%;border:0px transparent;pointer-events: none" value = "Manila" >
    <?php } else { ?>
        <input type = "hidden" name = "local_mnl[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value = "0" ><input type = "text" style = "text-align:center;width:100%;border:0px transparent;pointer-events: none" value = "0" >
    <?php } ?></td>
    <!--<td style="padding: 0px "><input type = "text" name = "expiration_date[]" style = "text-align:center;width:100%;border:1px transparent;pointer-events: none" value="<?php echo $list['expiration_date']; ?>"></td>-->

    <td ><center>
        <a class="btn btn-danger table-remove btn-xs" onclick="remove_item(<?php echo $list['count']; ?>)"><span class=" fa fa-times"></span></a></center>
        
    </td>
    <input type="hidden" name="item_id[]" value="<?php echo $list['itemid']; ?>">
    <input type="hidden" name="supplier_id[]" value="<?php echo $list['supplierid']; ?>">
    <input type="hidden" name="brand_id[]" value="<?php echo $list['brandid']; ?>">
    <input type="hidden" name="serial_id[]" value="<?php echo $list['serialid']; ?>">
</tr>