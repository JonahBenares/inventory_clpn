<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/gatepass.js"></script>
<link href="<?php echo base_url(); ?>assets/Styles/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/request/request_list">Gatepass </a></li>
			<li class="active"> Add Gatepass</li>
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
					<form id='gatepassfrm' method = "POST">
						<div class="canvas-wrapper">
						<?php foreach($head AS $g){
							$mgpno=$g['mgp_no'];
							$company=$g['to_company'];
							$destination=$g['destination'];
							$issued=$g['date_issued'];
							$returned=$g['date_returned'];
							$vehicle_no=$g['vehicle_no'];
							$prepared_by=$g['prepared_by'];
							$noted_by=$g['noted_by'];
							$approved_by=$g['approved_by'];
							$saved=$g['saved'];
						} ?>
							<table width="100%" >
								<tr>
									<td width="10%" ><p class="nomarg">To Company:</p></td>
									<td width="40%" ><label class="labelStyle"><?php echo $company; ?></label></td>
									<td width="15%" ><p class="nomarg pull-right">Date Issued:</p></td>
									<td width="50%" colspan="3"><label class="labelStyle">&nbsp; <?php echo date('F d, Y', strtotime($issued)); ?></label></td>
									<!--<td width="5%" ><a href="<?php echo base_url();?>index.php/gatepass/gatepass_print" class="btn btn-warning btn-sm"><span class="fa fa-print"></span> Print</a></td>-->
								</tr>
								<tr>
									<td><p class="nomarg">Destination: </p></td>
									<td><h5 class="nomarg"><?php echo $destination; ?></h5></td>
									<td><p class="nomarg pull-right">Date Returned:</p></td>
									<td><h5 class="nomarg">&nbsp; <?php echo date('F d, Y', strtotime($returned)); ?></h5></td>
								</tr>
								<tr>
									<td><p class="nomarg">Vehicle No:</p></td>
									<td> <h5 class="nomarg"><?php echo $vehicle_no; ?></h5></td>
									<td><p class="nomarg pull-right">MGP No.:</p></td>
									<td><h5 class="nomarg">&nbsp; <?php echo $mgpno; ?></h5></td>
								</tr>
							</table>
							<hr>
							<div class="row">
								<div class="col-lg-4">							
									<p>
									<select name="item" id='item' class="form-control select2"">
										<option value = ""></option>
										<?php foreach($item_list AS $itm){ ?>
										<option value = "<?php echo $itm->item_id;?>"><?php echo $itm->item_name;?></option>
										<?php } ?>
									</select>
									<!-- <input type='hidden' name='item' id='item'> -->
									</p>
								</div>
								<div class="col-lg-2">
									<p>				
										<input placeholder="Quantity" type="text" name="quantity" id="quantity" class="form-control" >
									</p>
								</div>
								<div class="col-lg-2">
									<p>				
									<select name="unit" id='unit' class="form-control select2">
										<option value = ""></option>
										<?php foreach($unit AS $unit){ ?>
										<option value = "<?php echo $unit->unit_id;?>"><?php echo $unit->unit_name;?></option>
										<?php } ?>
									</select>
									</p>
								</div>
								<div class="col-lg-3">
									<p>				
										<textarea placeholder="Remarks" type="text" name="remarks" id="remarks" class="form-control" rows="1" ></textarea> 
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
											<th width="2%" style='text-align: center;'>#</th>
											<th width="48%">Item Description</th>
											<th width="10%" style='text-align: center;'>Qty</th>
											<th width="10%" style='text-align: center;'>UOM</th>
											<th width="25%" style='text-align: center;'>Remarks</th>
											<th width="5%" style='text-align: center;' width="1%">Action</th>
										</tr>
									<?php 
									 if(!isset($gatepass_itm)){
									?>
									<tbody id="item_body"></tbody>
									<?php } else { ?>
									<tbody id="item_body">
										<?php 
											$x=1; foreach($gatepass_itm AS $gp) { 
										?>
											<tr>
												<td><center><?php echo $x; ?></center></td>
												<td><?php echo $gp['item_name'];?></td>
												<td><center><?php echo $gp['quantity'];?></center></td>
												<td><center><?php echo $gp['unit'];?></center></td>
												<td><center><?php echo $gp['remarks'];?></center></td>
												<td><center><a href="" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a></center></td>
											</tr>
										<?php } ?>
									</tbody>
										<?php $x++; } ?>
									</table>
								<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
								<input type='hidden' name='gatepassid' id='gatepassid' value='<?php echo $gatepassid; ?>'>
								<input type='hidden' name='counter' id='counter'>
								<input type='hidden' name='userid' id='userid' value="<?php echo $_SESSION['user_id']; ?>">
								<?php if($saved==0){ ?>
								<center><div id='alt' style="font-weight:bold"></div></center>
								<input type='button' class="btn btn-md btn-warning" id='savebutton' onclick='saveGatepass()' style="width:100%;background: #ff5d00" value='Save and Print'>
								<?php } ?>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<script>
    $('.select2').select2();
</script>