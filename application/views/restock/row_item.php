 
 <tr id='item_row<?php echo $list['count']; ?>'>  
    <td style="padding: 0px "><center><?php echo $list['count']; ?></center></td>
    <td style="padding: 0px "><input type = "text" name = "quantity[]" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['quantity']; ?>" ></td>
    <td style="padding: 0px "><input type = "text" name = "supplier[]" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['supplier_name']; ?>" ></td>
    <td style="padding: 0px "><textarea  rows="3" type = "text" name = "item[]" style = "text-align:center;width:100%;border:1px transparent;"><?php echo $list['item']; ?></textarea></td>
     <td style="padding: 0px "><input type = "text" name = "brand[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['brand']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "catalog_no[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['catno']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "item_cost[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['item_cost']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "total[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['total']; ?>"></td>
     <td style="padding: 0px "><input type = "text" name = "serial[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['serial']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "reason[]" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['reason']; ?>" ></td>
    <td style="padding: 0px "><textarea rows="3" wrap="soft" name = "remarks[]"  style = "width:100%;border:1px transparent;" ><?php echo $list['remarks']; ?></textarea></td>
    <td ><center>
        <a class="btn btn-danger table-remove btn-xs" onclick="remove_item(<?php echo $list['count']; ?>)"><span class=" fa fa-times"></span></a></center>
        
    </td>
    <input type="hidden" name="item_id[]" value="<?php echo $list['itemid']; ?>">
    <input type="hidden" name="supplier_id[]" value="<?php echo $list['supplierid']; ?>">
    <input type="hidden" name="brand_id[]" value="<?php echo $list['brandid']; ?>">
    <input type="hidden" name="serial_id[]" value="<?php echo $list['serialid']; ?>">
</tr>