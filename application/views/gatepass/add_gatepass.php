<style type="text/css">
	.popover__title {
	  font-size: 12px;
	  text-decoration: none;
	  color: rgb(228, 68, 68);
	  text-align: center;
	}

	.popover__wrapper {
	  position: relative;
	  display: inline-block;
	}
	.popover__content {
	  opacity: 0;
	  visibility: hidden;
	  position: absolute;
	  right: 55px;
      top: -150px;
	  transform: translate(0, 10px);
	  background-color: #dbdbdb;
	  padding: 1.5rem;
	  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
	  width: auto;
	}
	.popover__content:before {
		position: absolute;
	    z-index: -1;
	    content: "";
	    right: calc(-1% - 10px);
	    top: 35%;
	    transform: rotate(90deg);
	    border-style: solid;
	    border-width: 0 10px 10px 10px;
	    border-color: transparent transparent #dbdbdb transparent;
	    transition-duration: 0.3s;
	    transition-property: transform;
	}
	.popover__wrapper:hover .popover__content {
	  z-index: 10;
	  opacity: 1;
	  visibility: visible;
	  transform: translate(0, -20px);
	  transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
	}
	.popover__message {
	  text-align: center;
	}
</style>
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
			<li class=""><a href="<?php echo base_url(); ?>index.php/gatepass/gatepass_list">Material Gatepass List </a></li>
			<li class="active"> Add Gatepass Item</li>
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
					<form id='gatepassfrm' method = "POST" enctype="multipart/form-data">
						<div class="canvas-wrapper">
						<?php foreach($head AS $g){
							$mgpno=$g['mgp_no'];
							$company=$g['company'];
							$destination=$g['destination'];
							$issued=$g['date_issued'];
							//$returned=$g['date_returned'];
							$vehicle_no=$g['vehicle_no'];
							$prepared_by=$g['prepared_by'];
							$noted_by=$g['noted_by'];
							$approved_by=$g['approved_by'];
							$saved=$g['saved'];
							$gatepassid=$g['gatepass_id'];
						} ?>
							<table width="100%" >

								<tr>
									<td style="vertical-align: top;"><p class="nomarg">To Company:</p></td>
									<td colspan="4" ><label class="labelStyle"><?php echo $company; ?></label></td>
									<?php if($saved=='1'){ ?>
									<td width="5%" ><a href="<?php echo base_url();?>index.php/gatepass/gatepass_print/<?php echo $gatepassid;?>" class="btn btn-warning btn-sm"><span class="fa fa-print"></span> Print</a></td>
									<?php } ?>
								</tr>
								<tr>
									<td width="10%" ><p class="nomarg">Destination: </p></td>
									<td width="30%" ><h5 class="nomarg"><?php echo $destination; ?></h5></td>
									<td width="13%" ><p class="nomarg">Date Issued:</p></td>
									<td width="42%" colspan="3"><h5 class="nomarg"><?php echo date('F d, Y', strtotime($issued)); ?></h5></td>
									<!--<td width="5%" ><a href="<?php echo base_url();?>index.php/gatepass/gatepass_print" class="btn btn-warning btn-sm"><span class="fa fa-print"></span> Print</a></td>-->
								</tr>
								<tr>
									<td><p class="nomarg">Vehicle No:</p></td>
									<td><h5 class="nomarg"><?php echo $vehicle_no; ?></h5></td>
									<td><p class="nomarg">MGP No.:</p></td>
									<td><h5 class="nomarg"><?php echo $mgpno; ?></h5></td>
								</tr>
								
							</table>
							<br>
							<div style="box-shadow: -1px 2px 10px 3px #eeeff5; padding:10px;border-radius:5px">
								<?php if($saved=='0'){ ?>
									<table class="table table-bordesred" style="margin-bottom:0px;color: #fff;" >
										
										<tr>
											<td colspan="2">
												<input placeholder="Item Name" type="text" name="item" id="items" class="form-control" >
											</td>
											<td>
												<input placeholder="Qty" type="text" name="quantity" id="quantity" class="form-control" style="padding-right: 0px;" >
											</td>
											<td>
												<input placeholder="Unit" type="text" name="unit" id="unit" class="form-control" style="padding-right: 0px;">
											</td>
											<td>
												<input placeholder="Remarks" type="text" name="remarks" id="remarks" class="form-control" style="padding-right: 0px;">
											</td>
											<td>
												<select class="form-control" name="type" id="type">
													<option>--- Select Type ---</option>
													<option value = "Returnable">Returnable</option>
													<option value = "Non-Returnable">Non-Returnable</option>
												</select>
											</td>
											<td>
												<input class="form-control"  type="file" name="image" id="image" onchange="readImage(this);">
												<span id="img1-check" class='img-check'></span></td>
											<td>
												<div id='alrt' style="font-weight:bold"></div>		
												<a type="button" onclick='add_item()' class="btn btn-warning btn-md" id = "submit"><span class="fa fa-plus"></span></a>
												<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
											</td>
										</tr>
										<tr>
											<th width="2%" style='padding-top: 0px;padding-bottom: 0px;text-align: center;'>#</th>
											<th width="30%" style='padding-top: 0px;padding-bottom: 0px;text-align: center;'>Item Description</th>
											<th width="10%" style='padding-top: 0px;padding-bottom: 0px;text-align: center;'>Qty</th>
											<th width="10%" style='padding-top: 0px;padding-bottom: 0px;text-align: center;'>UOM</th>
											<th width="25%" style='padding-top: 0px;padding-bottom: 0px;text-align: center;'>Remarks</th>
											<th width="18%" style='padding-top: 0px;padding-bottom: 0px;text-align: center;'>Type</th>
											<th width="18%" style='padding-top: 0px;padding-bottom: 0px;text-align: center;'>Image</th>
											<th width="5%" style='padding-top: 0px;padding-bottom: 0px;text-align: center;' width="1%">Action</th>
										</tr>
									</table>
								<?php } ?>					
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-bordered table-hover" style="margin-bottom:0px">
											<tr>
												<th width="2%" style='text-align: center;'>#</th>
												<th width="30%">Item Description</th>
												<th width="10%" style='text-align: center;'>Qty</th>
												<th width="10%" style='text-align: center;'>UOM</th>
												<th width="25%" style='text-align: center;'>Remarks</th>
												<th width="18%" style='text-align: center;'>Type</th>
												<th width="18%" style='text-align: center;'>Image</th>
												<?php if($saved=='0'){ ?>
												<th width="5%" style='text-align: center;' width="1%">Action</th>
												<?php } ?>
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
													<td><?php echo $gp['item'];?></td>
													<td><center><?php echo $gp['quantity'];?></center></td>
													<td><center><?php echo $gp['unit'];?></center></td>
													<td><center><?php echo $gp['remarks'];?></center></td>
													<td><center><?php echo $gp['type'];?></center></td>
   													<td style="width: 100px !important; height: 100px !important;"><center>
   														<div style="padding:10px">
															<div class="popover__wrapper">
																<img src="<?php if(!empty($gp['image'])) { 
															echo base_url(); ?>uploads/<?php echo $gp['image']; 
															 } else { echo base_url(); ?>assets/default/default-img.jpg<?php } ?>" width="100%" height="100%" />
															  	<div class="popover__content">
															    	<img style="width: 500px" src="<?php if(!empty($gp['image'])) { echo base_url(); ?>uploads/<?php echo $gp['image']; 
											 						} else { echo base_url(); ?>assets/default/default-img.jpg<?php } ?>">
															  	</div>
															</div>	
   													</td><center>
   													<?php if($saved=='0'){ ?>
														<td><center><a href="" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a></center></td>
													<?php } ?>
												</tr>
											<?php } ?>
										</tbody>
											<?php $x++; } ?>
										</table>
									
									</div>
								</div>	
							</div>	
							<br>
							<br>
							<div class="row">
								<div class="col-lg-12">
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