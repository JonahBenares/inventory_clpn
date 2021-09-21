<style type="text/css">
	body{padding:0px;}
	@page {
	  size: auto;
	}
	table{
		font-family: sans-serif, Arial;
	}
	.printed{
		padding:20px 100px;text-align: center;
	}
	@media print{
		.printed{
			padding: 0px;
		}
		.printReport{
			display: none!important;
		}
	}
</style>
<?php if(!empty($restock)){ ?>


<div class="printed" id="printReport">
	<p><b>Instructions:</b> When printing Restock Report make sure the following options are set correctly -- <u>Browser</u>: Chrome, <u>Layout</u>: Landscape, <u>Paper Size</u>: Long(Legal) <u>Margin</u> : Custom (top: 0.11" , right:1.25", bottom: 0.11", left: 0.11") <u>Scale</u>: Custom: 90</p>
	<button class="btn btn-success" onclick="goBack()">Go Back</button>
	<button class="btn btn-info" onclick="printDiv('printableArea')">
		<span  class="fa fa-print"></span> Print 
	</button>
</div>
<br>
<div id="printableArea">
	<p class="pname"><?php echo $c; ?> - <small class="main_cat"><?php echo $s; ?></small></p>
	<div style="overflow-x: scroll;padding-bottom: 20px ">
	<table class="table-bordered table-hover table" style="font-size: 11px;">
		<thead>
			<tr>
				<td width="" align="center"><strong>Restock Date</strong></td>
				<td width="" align="center"><strong>PR#.</strong></td>
				<td width="" align="center"><strong>Item Part No.</strong></td>
				<td width="" align="center"><strong>Item Description</strong></td>
				<td width="" align="center"><strong>Total Qty Restocked</strong></td>
				<td width="" align="center"><strong>UoM</strong></td>
				<td width="" align="center"><strong>Unit Cost</strong></td>
				<td width="" align="center"><strong>Total Cost</strong></td>
				<td width="" align="center"><strong>Supplier</strong></td>
				<td width="" align="center"><strong>Department</strong></td>
				<td width="30%" align="center"><strong>End-Use</strong></td>
				<td width="" align="center"><strong>Purpose</strong></td>
				<td  align="center"><strong>Reason</strong></td>
				<td  align="center"><strong>Remarks</strong></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($restock as $rec){ ?>
			<tr>
				<td align="center"><?php echo date('d-M-Y',strtotime($rec['res_date']));?></td>
				<td align="center"><?php echo $rec['pr']?></td>
				<td align="center"><?php echo $rec['pn']?></td>
				<td align="center"><?php echo $rec['item']?></td>
				<td align="center"><?php echo $rec['qty']?></td>
				<td align="center"><?php echo $rec['unit']?></td>
				<td align="center"><?php echo $rec['unit_cost']?></td>
				<td align="center"><?php echo number_format($rec['total_cost'],2); ?></td>
				<td align="center"><?php echo $rec['supplier']?></td>
				<td align="center"><?php echo $rec['department']?></td>
				<td align="center"><?php echo $rec['enduse']?></td>
				<td align="center"><?php echo $rec['purpose']?></td>
				<td align="center"><?php echo $rec['reason']?></td>
				<td align="center"><?php echo $rec['remarks']?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<table width="100%" id="prntby">
        <tr>
            <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td>
        </tr>
    </table> 
</div>
<?php } ?>

<script>
function goBack() {
  window.history.back();
}
</script>