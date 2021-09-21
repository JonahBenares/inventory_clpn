<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/request.js"></script>
<link href="<?php echo base_url(); ?>assets/Styles/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/request/request_list">Request </a></li>
			<li class="active"> Add Request</li>
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
					<form id='Requestfrm' method = "POST">
					<div class="canvas-wrapper">
						<?php foreach($head AS $h){
							$dept=$h['department'];
							$mreqf=$h['mreqf_no'];
							$date=$h['request_date'];
							$time=$h['request_time'];
							$purpose=$h['purpose'];
							$enduse=$h['enduse'];
							$prno=$h['prno'];
							$remarks=$h['remarks'];
							$saved=$h['saved'];
							$type=$h['type'];
						} ?>
						<table width="100%" >
							<tr>
								<td ><p class="nomarg">Department:</p></td>
								<td ><label class="labelStyle"><?php echo $dept; ?></label></td>
								<td ><p class="nomarg pull-right">MReqf No:</p></td>
								<td colspan="3"><label class="labelStyle">&nbsp<?php echo $mreqf; ?></label></td>
								<td width="15%"></td>
							</tr>
							<tr>
								<td width="10%"><p class="nomarg">Purpose:</p></td>
								<td width="30%"> <h5 class="nomarg"><?php echo $purpose; ?></h5></td>
								<td width="10%"><p class="nomarg pull-right">Date:</p></td>
								<td width="10%"><h5 class="nomarg">&nbsp <?php echo $date; ?></h5></td>
								<td width="5%"><p class="nomarg">Time:</p></td>
								<td > <h5 class="nomarg"><?php echo $time; ?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">End Use:</p></td>
								<td> <h5 class="nomarg"><?php echo $enduse; ?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">JO / PR #:</p></td>
								<td> <h5 class="nomarg"><?php echo $prno; ?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">Type:</p></td>
								<td> <h5 class="nomarg"><?php echo $type; ?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">Remarks:</p></td>
								<td> <h5 class="nomarg"><?php echo $remarks; ?></h5></td>
							</tr>
						</table>
						<hr>
						<div class="row">

							<div class="col-lg-4">							
								<p>
									<!-- <input placeholder="Item Description" type="text" name="item" id="item" class="form-control" autocomplete="off">
									<span id="suggestion-item"></span> -->
									<select name="item" id='item' class="form-control select2" onchange="chooseItem('<?php echo $prno; ?>')">
										<option value = ""></option>
										<?php foreach($item_list AS $itm){ ?>
										<option value = "<?php echo $itm->item_id;?>"><?php echo $itm->original_pn." - ".$itm->item_name;?></option>
										<?php } ?>
									</select>
									<input type='hidden' name='item_id' id='item_id'>
									<input type='hidden' name='item_name' id='item_name'>
									<input type='hidden' name='original_pn' id='original_pn'>
									<input type='hidden' name='unit' id='unit'>
									<input type='hidden' name='invqty' id='invqty'>
									<input type='hidden' name='reqpr' id='reqpr' value='<?php echo $prno; ?>'>
								</p>
							</div>
							<div class="col-lg-3">
								<p>				
									<span id='crossreference_list'>Please choose item.</span>
									<input type="hidden" name="unit_cost" id="unit_cost" >
								</p>
							</div>
							<div class="col-lg-2">
								<p>				
									<input placeholder="Borrow From PR" type="text" name="borrowfrom" id="borrowfrom" class="form-control" >
								</p>
							</div>
							<div class="col-lg-2">
								<p>				
									<input placeholder="Quantity" type="text" name="quantity" id="quantity" class="form-control" onkeypress="return isNumberKey(event)">
									<input type='hidden' name='maxqty' id = "maxqty">

								</p>
							</div>
							<div class="col-lg-1">
								<div id='alrt' style="font-weight:bold"></div>
								<p>				
									<a type="button" onclick='add_item()' class="btn btn-warning btn-md" id = "submit"><span class="fa fa-plus"></span></a>
								</p>
							</div>
							<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
						</div>
						<div class="row">
							<div class="col-lg-12">
								<table class="table table-bordered table-hover">
									<tr>
										<th style='text-align: center;'>Qty</th>
										<th style='text-align: center;'>UOM</th>
										<th style='text-align: center;'>Part No.</th>
										<th style='text-align: center;'>Item Description</th>
										<th style='text-align: center;'>Cross Reference</th>
										<th style='text-align: center;'>Unit Cost</th>
										<th style='text-align: center;'>Total Cost</th>
										<th style='text-align: center;'>Inv. Balance</th>
										<th style='text-align: center;'>Borrow from PR</th>
										<th style='text-align: center;' width="1%">Action</th>
									</tr>
									<?php 
										if(!isset($request)){
									?>
									<tbody id="item_body"></tbody>
									<?php } else { ?>
									<tbody id="item_body">
										<?php 
											foreach($req_itm AS $rq) { 
										?>	
										<tr>
											<td><center><?php echo $rq['qty'];?></center></td>
											<td><center><?php echo $rq['uom'];?></center></td>
											<td><center><?php echo $rq['pn'];?></center></td>
											<td><center><?php echo $rq['item'];?></center></td>
											<td><center><?php echo $rq['cross']; ?></center></td>
											<td><center><?php echo $rq['unitcost']; ?></center></td>
											<td><center><?php echo $rq['totalcost']; ?></center></td>
											<td><center><?php echo $rq['invqty']; ?></center></td>
											<td><center><?php echo $rq['borrowfrom_pr']; ?></center></td>
											<td><center></center></td>
										</tr>
										<?php } ?>
									</tbody>
									<?php } ?>
								</table>
								<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
								<input type='hidden' name='requestid' id='requestid' value='<?php echo $requestid; ?>'>
								<input type='hidden' name='counter' id='counter'>
								<input type='hidden' name='userid' id='userid' value="<?php echo $_SESSION['user_id']; ?>">
								<?php if($saved==0){ ?>
								<center><div id='alt' style="font-weight:bold"></div></center>
								<input type='button' class="btn btn-md btn-warning" id='savebutton' onclick='saveRequest()' style="width:100%;background: #ff5d00" value='Save and Print'>
								<?php } ?>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
    $('.select2').select2();
</script>