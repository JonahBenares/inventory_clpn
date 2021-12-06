<table class="table table-bordered" width="100%">
	<tr>
		<td align="center"><label>Date Returned</label></td>							
		<td align="center"><label>Qty</label></td>							
	</tr>
	<?php 
		if(!empty($returned)){
		foreach($returned as $gp_itms){ ?>
	<tr>
		<td align="center"><?php echo date("F d, Y",strtotime($gp_itms->date_returned));?></td>
		<td align="center"><?php echo $gp_itms->qty;?></td>
	</tr>
	<?php } } else { ?>
	<tr>
		<td align="center" colspan='9'><center>No Data Available.</center></td>
	</tr>
	<?php } ?>
</table>