<?php 
if(!empty($stockcard)){
	foreach ($stockcard as $key => $row) {
	    $date[$key]  = $row['date'];
	    $series[$key] = $row['series'];
	    $cdate[$key] = $row['create_date'];
	}


array_multisort($date, SORT_ASC, $cdate, SORT_ASC,$stockcard);
}
if(!empty($stockcard)){
	foreach ($balance as $key => $row) {
	    $date[$key]  = $row['date'];
	    $series[$key] = $row['series'];
	     $cdate[$key] = $row['create_date'];
	}

	array_multisort($date, SORT_ASC, $cdate, SORT_ASC,$balance);

	$total_bal=0;
	foreach($balance AS $sc){
		if($sc['method']== 'Beginning Balance' || $sc['method'] == 'Receive' || $sc['method'] == 'Restock'){ 
				$total_bal += $sc['quantity'];
		} else if($sc['method'] == 'Issuance') {
				$total_bal -= $sc['quantity'];
		} 
	}
}else {
	$total_bal=0;
}
?>
<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script>
<style type="text/css">
	#name-item{
		width: 35%!important;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active"> Stock Card</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<br>
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading" style="height:20px">
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="col-lg-12">
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateStkcrdNew">
								<table width="100%">
									<tr>
										<td width="20%"><p>Item Description:</p></td>
										<td width="30%">
											<!-- <input type="text" class="form-control" name="item" id = "item" autocomplete="off">
											<span id="suggestion-item"></span> -->
											<select name="item" id='item' style="width:80%" class="form-control select2" onchange="chooseItem()">
												<option value = ""></option>
												<?php foreach($item_list AS $itm){ ?>
												<option value = "<?php echo $itm->item_id;?>"><?php echo $itm->original_pn." - ".$itm->item_name;?></option>
												<?php } ?>
											</select>
										</td>
										<td width="15%"><p class="pull-right">Catalog No.:</p></td>
										<td width="30%"><input type="text" class="form-control" name="catalog_no" id = "catalog_no"></td>
										<td width="10%" rowspan="2">
											<input style="margin:10px" type="submit" name="search_stockcard" id="submit" value='Generate Report' class="btn btn-warning btn-sm" >
											<!-- <a  href="" class="btn btn-warning ">Generate Report</a> -->
										</td>
									</tr>
									<tr>
										<td><p>Supplier:</p></td>
										<td>
											<!-- <input type="text" class="form-control" name="supplier" id = "supplier" autocomplete="off">
											<span id="suggestion-supplier"></span> -->
											<select name="supplier" id='supplier' style="width:80%" class="form-control select2" onchange="chooseSupplier()" >
												<option value = ""></option>
												<?php foreach($supplier_list AS $sup){ ?>
												<option value = "<?php echo $sup->supplier_id;?>"><?php echo $sup->supplier_name;?></option>
												<?php } ?>
											</select>
										</td>
										<td><p class="pull-right">Brand:</p></td>
										<td>
											<input type="text" class="form-control" name="brand" id = "brand" autocomplete="off">
											<span id="suggestion-brand"></span>
										</td>
									</tr>
									<tr>
										<td colspan="5" align="center"><div id='alrt' style="font-weight:bold"></div></td>
									</tr>
								</table>
								<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
								<input type="hidden" name="item_id" id="item_id">
								<input type="hidden" name="supplier_id" id="supplier_id">
								<input type="hidden" name="brand_id" id="brand_id">
							</form>
							<br>
							<div id="printableArea">
								<p class="pname"><?php echo $itemdesc; ?>
									<a href="" class="btn btn-info pull-right">Running Balance: <span style="font-size: 25px" class="badge animated rubberBand "><?php echo $total_bal; ?></span></a>
									<button title="Print This Page" id="printReport" class="btn btn-primary btn-sm pull-right " onclick="printDiv('printableArea')" style="margin-top: 7px!important;margin-right: 5px!important">
										<span  class="fa fa-print"></span>
									</button>
									<!--  <a href="<?php echo base_url(); ?>index.php/reports/stock_card_preview/<?php echo $id; ?>/<?php echo $sup; ?>/<?php echo $cat; ?>/<?php echo $brand; ?>" target="_blank" class="btn btn-primary btn-sm pull-right" style="margin-top: 7px!important;margin-right: 5px!important">Print Stock Card (A4)</a>  -->
									
								</p>
								<?php 
								
								if(!empty($stockcard)){
								$run_bal=0;

									foreach($balance AS $s){
											if($s['method'] == 'Beginning Balance' || $s['method'] == 'Receive' || $s['method'] == 'Restock'){ 
														$run_bal += $s['quantity'];
												} else if($s['method'] == 'Issuance') {
														$run_bal -= $s['quantity'];
												} 

										$bal[] = $run_bal;
									}
								}

?>
								<table class="table table-hover table-bordered">
									<thead>
										<tr>
											<th style="text-align: center" width="12%">Date</th>
											<th style="text-align: center" width="12%">PR #</th>
											<th style="text-align: center" width="12%">PO #</th>
											<th style="text-align: center" width="30%">Supplier</th>
											<th style="text-align: center" width="16%">Catalog No.</th>
											<th style="text-align: center" width="16%">Brand</th>
											<th style="text-align: center" width="6%">Total Unit Cost</th>
											<th style="text-align: center" width="0%">Method</th>
											<th style="text-align: center" width="0%">Quantity</th>
											<th style="text-align: center" width="0%">Notes</th>
											<th style="text-align: center" width="0%">Running Balance</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if(!empty($stockcard)){
										$count = count($stockcard)-1;
										//echo "count".$count;
										$run_bal=0;
											for($x=$count; $x>=0;$x--){ 
										
											/*if($stockcard[$x]['method']== 'Beginning Balance' || $stockcard[$x]['method'] == 'Receive' || $stockcard[$x]['method'] == 'Restock'){ 
															$run_bal += $stockcard[$x]['quantity'];
													} else if($stockcard[$x]['method'] == 'Issuance') {
															$run_bal -= $stockcard[$x]['quantity'];
													} */
											//echo $x . " - ".  $stockcard[$x]['date']."<br>"; 
											 ?>
											 <tr>
												<td><?php echo (!empty($stockcard[$x]['date']) ? date('Y-m-d', strtotime($stockcard[$x]['date'])) : ''); ?></td>
												<td><?php echo $stockcard[$x]['pr_no']; ?></td>
												<td><?php echo $stockcard[$x]['po_no']; ?></td>
												<td><?php echo $stockcard[$x]['supplier']; ?></td>
												<td><?php echo $stockcard[$x]['catalog_no']; ?></td>
												<td><?php echo $stockcard[$x]['brand']; ?></td>
												<td><?php echo number_format($stockcard[$x]['total_cost'],2); ?></td>
												<td><?php echo $stockcard[$x]['method']; ?></td>
												<td><?php echo (($stockcard[$x]['method']== 'Issuance') ? "-" : "") . $stockcard[$x]['quantity']; ?></td>
												<td><?php echo (($stockcard[$x]['method']== 'Issuance') ? $stockcard[$x]['remarks'] : "") ?></td>
												<td><?php echo $bal[$x]; ?></td>
												
											</tr>
										<?php
									}
										/*foreach($stockcard AS $sc){
											if($sc['method']== 'Beginning Balance' || $sc['method'] == 'Receive' || $sc['method'] == 'Restock'){ 
															$run_bal += $sc['quantity'];
													} else if($sc['method'] == 'Issuance') {
															$run_bal -= $sc['quantity'];
													} 
											
											
											 ?>
											 <tr>
												<td><?php echo (!empty($sc['date']) ? date('Y-m-d', strtotime($sc['date'])) : ''); ?></td>
												<td><?php echo $sc['supplier']; ?></td>
												<td><?php echo $sc['catalog_no']; ?></td>
												<td><?php echo $sc['brand']; ?></td>
												<td><?php echo $sc['unit_cost']; ?></td>
												<td><?php echo $sc['method']; ?></td>
												<td><?php echo (($sc['method']== 'Issuance') ? "-" : "") . $sc['quantity']; ?></td>
												<td><?php echo $run_bal; ?></td>
												
											</tr>
											*/

											
										
										
										//echo $count . "<br>";
										//$count--;
										
										} ?>
									</tbody>
								</table>
								<table width="100%" id="prntby">
					                <tr>
					                    <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td>
					                </tr>
					            </table> 
							</div>
							<!-- <a href="" class="btn btn-link btn-sm">Print Stock Card</a> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript"></script>
