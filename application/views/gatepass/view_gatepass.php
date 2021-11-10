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
			<li class="active"> View Details</li>
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
							<?php 
							foreach($head AS $h){
								$saved=$h->saved;
							}
							foreach($pass as $p){ ?>
							<table width="100%" >
								<tr>
									<td style="vertical-align: top;"><p class="nomarg">To Company:</p></td>
									<td colspan="3"><label class="labelStyle"><?php echo $p['company'];?></label></td>
									<?php if($saved=='0'){ ?>
									<td width="5%" ><a href="<?php echo base_url(); ?>index.php/gatepass/add_gatepass/<?php echo $p['gatepassid'];?>" class="btn btn-info btn-sm"><span class="fa fa-pencil"></span></a></td>
									<?php } ?>
									<td width="5%" ><a href="<?php echo base_url();?>index.php/gatepass/gatepass_print/<?php echo $p['gatepassid'];?>" class="btn btn-warning btn-sm"><span class="fa fa-print"></span> Print</a></td>
								</tr>
								<tr>
									<td width="10%"><p class="nomarg">Destination: </p></td>
									<td width="30%"><h5 class="nomarg"><?php echo $p['destination'];?></h5></td>
									<td width="13%"><p class="nomarg">Date Issued:</p></td>
									<td width="42%" colspan="3"><h5 class="nomarg"><?php echo date('F d, Y', strtotime($p['date_issued'])); ?></h5></td>
									
								</tr>
								<tr>
									<td><p class="nomarg">Vehicle No:</p></td>
									<td><h5 class="nomarg"><?php echo $p['vehicle_no'];?></h5></td>
									<td><p class="nomarg">Date Returned:</p></td>
									<td><h5 class="nomarg"><?php echo date('F d, Y', strtotime($p['date_returned'])); ?></h5></td>
								</tr>
								<tr>
									<td><p class="nomarg ">MGP No.:</p></td>
									<td><h5 class="nomarg"><?php echo $p['mgp_no'];?></h5></td>
									<td></td>
									<td></td>
								</tr>
								<?php } ?>
							</table>
							<br>
							<!--<div class="row">
								<div class="col-lg-4">							
									<p>
									<select name="item" id='item' class="form-control select2">
										<option value = ""></option>
										<?php foreach($item_list AS $itm){ ?>
										<option value = "<?php echo $itm->item_id;?>"><?php echo $itm->item_name;?></option>
										<?php } ?>
									</select>
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
										<textarea placeholder="Remarks" type="text" name="borrowfrom" id="borrowfrom" class="form-control" rows="1" ></textarea> 
									</p>
								</div>
								<div class="col-lg-1">
									<div id='alrt' style="font-weight:bold"></div>
									<p>				
										<a type="button" onclick='add_item()' class="btn btn-warning btn-md" id = "submit"><span class="fa fa-plus"></span></a>
									</p>
								</div>
								<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
							</div>-->
							<div style="box-shadow: -1px 2px 10px 3px #eeeff5; padding:10px;border-radius:5px">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-bordered table-hover">
											<tr>
												<th width="2%" style='text-align: center;'>#</th>
												<th width="48%">Item Description</th>
												<th width="10%" style='text-align: center;'>Qty</th>
												<th width="10%" style='text-align: center;'>UOM</th>
												<th width="25%" style='text-align: center;'>Remarks</th>
												<!-- <th width="25%" style='text-align: center;'>Image</th> -->
												<!--<th width="5%" style='text-align: center;' width="1%">Action</th>-->
											</tr>
										<tbody id="item_body">
											<?php 
											 $x=1; if(!empty($gatepass_itm)){
												foreach($gatepass_itm as $gp){ ?>
												<tr>
													<td><center><?php echo $x; ?></center></td>
													<td><?php echo $gp['item'];?></td>
													<td><center><?php echo $gp['quantity'];?></center></td>
													<td><center><?php echo $gp['unit'];?></center></td>
													<td><center><?php echo $gp['remarks'];?></center></td>
													<td>
   														<div style="padding:10px">
															<img class="pictures" src="<?php if(!empty($gp['image'])) { 
																echo base_url(); ?>uploads/<?php echo $gp['image']; 
																 } else { echo base_url(); ?>assets/default/default-img.jpg<?php } ?>" width="100%" height="100%" />
															</div>
													</td>
													<!--<td><center><a href="" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a></center></td>-->
												</tr>
											<?php $x++; } } else { ?>
											<tr>
												<td align="center" colspan='9'><center>No Data Available.</center></td>
											</tr>
											<?php } ?>
										</table>
									</div>
								</div>
							</div>
							<br>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>