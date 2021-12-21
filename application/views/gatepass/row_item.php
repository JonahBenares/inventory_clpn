<tr id='item_row<?php echo $list['count']; ?>'> 
    <td style="padding: 0px "><center><?php echo $list['count']; ?></center></td>
    <td style="padding: 0px "><textarea  type = "text" name = "item[]" style = "text-align:center;width:100%;border:1px transparent;" readonly><?php echo $list['item']?></textarea></td>
    <td style="padding: 0px; width:50px; "><input type = "text" name = "quantity[]" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['quantity']; ?>" readonly></td>
    <td style="padding: 0px; width:80px;"><input type = "hidden"  name = "unit[]" value="<?php echo $list['unit']; ?>"><input type = "text" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['unit']?>" readonly></td>
    <td style="padding: 0px; width:50px; "><input type = "text" name = "remarks[]" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['remarks']; ?>" readonly></td>
    <td style="padding: 0px; width:50px; "><input type = "text" name = "type[]" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['type']; ?>" readonly></td>
   
    <td style="padding: 0px width: 50px;">
        <center>
            <div class="popover__wrapper">
                <img id="images<?php echo $list['count']; ?>" width="100%" height="100%"/>
                <div class="popover__content">
                    <img id="images_hov<?php echo $list['count']; ?>"style="width: 500px"/>
                </div>
            </div>
        <center>
    </td>

      <!-- <div class="popover__wrapper">
          <img src="<?php if(!empty($gp['image'])) { 
        echo base_url(); ?>uploads/<?php echo $gp['image']; 
         } else { echo base_url(); ?>assets/default/default-img.jpg<?php } ?>" width="100%" height="100%" />
            <div class="popover__content">
              <img style="width: 500px" src="<?php if(!empty($gp['image'])) { 
                echo base_url(); ?>uploads/<?php echo $gp['image']; 
            } else { echo base_url(); ?>assets/default/default-img.jpg<?php } ?>">
            </div>
        </div>   -->
    <td ><center>
        <a class="btn btn-danger table-remove btn-xs" onclick="remove_item(<?php echo $list['count']; ?>)"><span class=" fa fa-times"></span></a></center>
        <input type="hidden" name="image[]" value="<?php echo $list['image']; ?>">
    </td>
    
    <!--<input type="hidden" name="item_id[]" value="<?php echo $list['item_id']; ?>">-->
    <!--<input type="hidden" name="unit_id[]" value="<?php echo $list['unit_id']; ?>">-->
</tr>