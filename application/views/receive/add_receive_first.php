<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/receive.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/receive/receive_list">Receive </a></li>
			<li class="active"> Delivery Receipt</li>
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
						<?php foreach($list AS $li) { ?>
						<div class="pull-right" style="padding-bottom: 10px">
							<?php if($li->saved==0){ ?> 
							<a href="<?php echo base_url(); ?>index.php/receive/add_receive_first/<?php echo $li->receive_id;?>" class="btn btn-info btn-sm"><span class="fa fa-pencil"></span> Update</a>
							<?php } ?>
							<a href="<?php echo base_url(); ?>index.php/receive/mrf/<?php echo $li->receive_id;?>" class="btn btn-warning btn-sm" target = "_blank"><span class="fa fa-print"></span> Print</a>
						</div>	
						<table style="border-top: 1px solid #dedede" width="100%">	
							<tr>
								<td colspan="5"><br></td>
							</tr>
							<tr>
								<td width="5%"></td>
								<td width="5%"><p class="nomarg">Date:</p></td>
								<td width="20%"><label class="labelStyle"><?php echo date('F j, Y',strtotime($li->receive_date)); ?></label></td>
								<td width="5%"></td>
								<?php if($li->saved==0){ ?> 
								<td><a onclick="update_head('<?php echo $li->receive_id;?>','<?php echo base_url();?>')" class="btn btn-info btn-sm"><span class="fa fa-pencil"></span></a></td>
								<?php }else if($_SESSION['user_id']==5 && $li->saved==1){ ?>
								<td><a onclick="update_head('<?php echo $li->receive_id;?>','<?php echo base_url();?>')" class="btn btn-info btn-sm"><span class="fa fa-pencil"></span></a></td>
								<?php }else { ?>
								<td><a onclick="update_head('<?php echo $li->receive_id;?>','<?php echo base_url();?>')" class="btn btn-info btn-sm" style ="pointer-events: none" disabled><span class="fa fa-pencil"></span></a></td>
								<?php } ?>
							</tr>
							<tr>
								<td></td>
								<td><p class="nomarg">DR #:</p></td>
								<td> <h5 class="nomarg"><?php echo $li->dr_no; ?></h5></td>
								<td><p class="nomarg">PO #:</p></td>
								<td> <h5 class="nomarg"><?php echo $li->po_no; ?></h5></td>
							</tr>
							<tr>
								<td></td>
								<td><p class="nomarg">SI #:</p></td>
								<td> <h5 class="nomarg"><?php echo $li->si_no; ?></h5></td>
								<td><p class="nomarg">PCF:</p></td>
								<td> <h5 class="nomarg"><?php if($li->pcf == '1'){ echo "Yes"; }else { echo ""; } ?></h5></td>
							</tr>
							<?php if($li->saved==0){ ?>
							<tr>								
								<td></td>
								<td colspan="2">
								<button onclick="openAddNewPR('<?php echo base_url(); ?>','<?php echo $receiveid; ?>')" class="btn btn-warning btn-md" style="margin-top:10px">Add New PR 
										<span class="animated infinite rubberBand badge"><em class="fa fa-plus"></em></span>
									</button>
								</td>							
							</tr>
							<?php }
							 } ?>
						</table>
						<div class="col-lg-12">
							<?php
							if(!empty($details)) { 
							 foreach($details AS $det){ ?>
							
							
							<div class="row border-class shadow">
								<div style="padding:0px 15px">
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10"  >
										<h3 class="nomarg">PR/JO#: <?php echo $det['prno']; ?></h3>
									<p class="nomarg"><strong>Department: </strong><?php echo $det['department']; ?></p>
									<p class="nomarg"><strong>End-Use: </strong><?php echo $det['enduse']; ?></p>
									<p class="nomarg"><strong>Purpose: </strong> <?php echo $det['purpose']; ?> </p>
									<p ><strong>Inspected By: </strong> <?php echo $det['inspected']; ?> </p>
									</div>
									<?php if($saved==0){ ?>
									<div class="col-lg-2 col-md-2 col-sm-2  col-xs-2">
										<div style="padding-left:50% ">
										<?php if($saved==0){ ?> 
										<a href="javascript:void(0)" onclick="updateReceivePR('<?php echo base_url(); ?>','<?php echo $receiveid; ?>', '<?php echo $det['rdid']; ?>')" class="btn btn-primary btn-sm" title="Update" ><span class="fa fa-pencil"></span></a>
										<a href="javascript:void(0)" onclick="deleteReceiveDetails('<?php echo $det['rdid']; ?>','<?php echo $receiveid; ?>','<?php echo base_url(); ?>')" class="btn btn-danger btn-sm" title="Delete"><span class="fa fa-trash"></span></a></div>
										<?php } else if($_SESSION['user_id']==5 && $saved==1) { ?>
										<a href="javascript:void(0)" onclick="updateReceivePR('<?php echo base_url(); ?>','<?php echo $receiveid; ?>', '<?php echo $det['rdid']; ?>')" class="btn btn-primary btn-sm" title="Update" ><span class="fa fa-pencil"></span></a>
										<a href="javascript:void(0)" onclick="deleteReceiveDetails('<?php echo $det['rdid']; ?>','<?php echo $receiveid; ?>','<?php echo base_url(); ?>')" class="btn btn-danger btn-sm" title="Delete"><span class="fa fa-trash"></span></a></div>
										<?php }else{ ?>
										<a href="javascript:void(0)" style ="pointer-events: none" disabled onclick="updateReceivePR('<?php echo base_url(); ?>','<?php echo $receiveid; ?>', '<?php echo $det['rdid']; ?>')" class="btn btn-primary btn-sm" title="Update" ><span class="fa fa-pencil"></span></a>
										<a href="javascript:void(0)" style ="pointer-events: none" disabled onclick="deleteReceiveDetails('<?php echo $det['rdid']; ?>','<?php echo $receiveid; ?>','<?php echo base_url(); ?>')" class="btn btn-danger btn-sm" title="Delete"><span class="fa fa-trash"></span></a></div>
										<?php } ?>
									</div>
									<?php } ?>
									
									<table width="100%" class="table table-bordered " style="font-size: 15px">
										<tr >
											<th class="tr-bottom" width="5%"><center>Item No.</center></th>
											<th class="tr-bottom" width="15%"><center>Supplier</center></th>
											<th class="tr-bottom" width="15%"><center>Description</center></th>
											<th class="tr-bottom" width="5%"><center>Net Cost/U</center></th>
											<th class="tr-bottom" width="5%"><center>Shipping/U & Other Related Cost</center></th>
											<th class="tr-bottom" width="5%"><center>Total Unit NET Cost</center></th>
											<th class="tr-bottom" width="10%"><center>Expected Qty</center></th>
											<th class="tr-bottom" width="10%"><center>Delivered / Received</center></th>
											<th class="tr-bottom" width="5%"><center>UOM</center></th>
											<th class="tr-bottom" width="20%"><center>Local/Manila</center></th>
											<th class="tr-bottom" width="5%"><center>Total Net Cost</th>
											<!--<th class="tr-bottom" width="5%"><center>Expiry</th>-->
											<th class="tr-bottom" width="20%"><center>Remarks</center></th>
										</tr>
										<?php 
										$itemno=1;
										
										foreach($items AS $it){ 
											if($it['rdid'] == $det['rdid']) { 
												
												?>

										<tr>
											<td>
												<center>
													<li class="dropdown" style="list-style:none;margin-top:0px">
														<a class="btn btn-gold btn-sm  " data-toggle="dropdown" href="#"><?php echo $itemno; ?></a>
														<ul class="dropdown-menu dropdown-alerts animated fadeInLeft" style="width:350px;top:30px;border:1px solid #e66614;left:0px;">
															<span class="arrow-top2"></span>
															<li style="padding:5px">
																<table class="table table-hover table-bordered" style="margin:0px">
																	<tr>
																		<td width="35%" class="pad-t-4"><strong>Brand:</strong></td>
																		<td class="pad-t-4">
																			<label style="color:#555;font-weight: 600"><?php echo $it['brand']; ?></label >
																		</td>
																	</tr>
																	<tr>
																		<td class="pad-t-4"><strong>Catalog No:</strong></td>
																		<td class="pad-t-4">
																			<label style="color:#555;font-weight: 600"><?php echo $it['catalog_no']; ?></label >
																		</td>
																	</tr>
																	<tr>
																		<td class="pad-t-4"><strong>Serial No:</strong></td>
																		<td class="pad-t-4">
																			<label style="color:#555;font-weight: 600"><?php echo $it['serial']; ?></label >
																		</td>
																	</tr>
																	<!-- <tr>
																		<td class="pad-t-4"><strong>Inspected By:</strong></td>
																		<td class="pad-t-4">
																			<label style="color:#555;font-weight: 600"><?php echo $it['inspected_by']; ?></label >
																		</td>
																	</tr> -->
																</table>
															</li>
														</ul>
													</li>
												</center>
											</td>
											<td><?php echo $it['supplier']; ?></td>
											<td><?php echo $it['item']; ?></td>
											<td><?php echo $it['unit_cost']; ?></td>
											<td><center><?php echo $it['shipping_fee']; ?></center></td>
											<td><?php echo number_format($it['total'],2); ?></td>
											<td><center><?php echo $it['expqty']; ?></center></td>
											<td><center><?php echo $it['recqty']; ?></center></td>
											<td><center><?php echo $it['unit']; ?></center></td>
											<td><center><?php if($it['local_mnl'] == '1'){ echo 'Local';} else if($it['local_mnl'] == '2'){ echo 'Manila';} else { echo ''; } ?></center></td>
											<td><center><?php echo number_format($it['total_net_cost'],2); ?></center></td>
											<!--<td><?php echo $it['expiration_date']; ?></td>-->
											<td><?php echo $it['remarks']; ?></td>
										</tr>
										<?php
										$itemno++;
											}

										 } 
										?>
									</table>
								</div>
							</div>
							<?php } 
							?>
							<hr>
							<?php if($saved==0){ ?>
							<center><div id='alt' style="font-weight:bold"></div></center>
							<button onclick="SaveReceive('<?php echo $receiveid; ?>','<?php echo base_url(); ?>')" class="btn btn-warning" style="width:100%;background: #ff5d00" id="savebutton">Save</button>
							<?php }
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
