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
						<?php foreach($head as $h){ ?>
						<div class="pull-right" style="padding-bottom: 10px">
							<?php if($h->saved==0){ ?> 
							<a href="<?php echo base_url(); ?>index.php/receive/add_receive_first/<?php echo $h->receive_id;?>" class="btn btn-info btn-sm"><span class="fa fa-pencil"></span> Update</a>
							<?php } ?>
							<a href="<?php echo base_url(); ?>index.php/receive/mrf/<?php echo $h->receive_id;?>" class="btn btn-warning btn-sm" target = "_blank"><span class="fa fa-print"></span> Print</a>
						</div>	
						<table style="border-top: 1px solid #dedede" width="100%">	
							<tr>
								<td colspan="5"><br></td>
							</tr>						
							<tr>
								<td width="5%"></td>
								<td width="5%"><p class="nomarg">Date:</p></td>
								<td width="20%"><label class="labelStyle"><?php echo date('F j, Y',strtotime($h->receive_date)); ?></label></td>
								<td width="5%"></td>
								<?php if($h->saved==0){ ?>
								<td><a onclick="update_head('<?php echo $h->receive_id;?>','<?php echo base_url();?>')" class="btn btn-info btn-sm"><span class="fa fa-pencil"></span></a></td>
								<?php }else if($_SESSION['user_id'] == '5' && $h->saved==1){ ?>
								<td><a onclick="update_head('<?php echo $h->receive_id;?>','<?php echo base_url();?>')" class="btn btn-info btn-sm"><span class="fa fa-pencil"></span></a></td>
								<?php }else { ?>
								<td><a onclick="update_head('<?php echo $h->receive_id;?>','<?php echo base_url();?>')" class="btn btn-info btn-sm" style ="pointer-events: none" disabled><span class="fa fa-pencil"></span></a></td>
								<?php } ?>
							</tr>
							<tr>
								<td></td>
								<td><p class="nomarg">DR #:</p></td>
								<td> <h5 class="nomarg"><?php echo $h->dr_no; ?></h5></td>
								<td><p class="nomarg">PO #:</p></td>
								<td> <h5 class="nomarg"><?php echo $h->po_no; ?></h5></td>
							</tr>
							<tr>
								<td></td>
								<td><p class="nomarg">SI #:</p></td>
								<td> <h5 class="nomarg"><?php echo $h->si_no; ?></h5></td>								
								<td><p class="nomarg">PCF:</p></td>
								<td> <h5 class="nomarg"><?php if($h->pcf == '1'){ echo "Yes"; }else { echo ""; } ?></h5></td>
							</tr>
							<?php } ?>
						</table>
						<div class="col-lg-12">
							<?php
							 if(!empty($details)){ ?>
							 	<input type='hidden' name='recid' id='recid' value="<?php echo $id; ?>">
							 <?php foreach($details AS $d){ ?>

							<div class="row border-class shadow">
								<div style="padding:0px 15px">
									<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10"  >
										<h3 class="nomarg">PR/JO#: <?php echo $d['prno']; ?></h3>
										<p class="nomarg"><strong>Department: <?php echo $d['department']; ?></strong></p>
										<p class="nomarg"><strong>End-Use: <?php echo $d['enduse']; ?></strong></p>
										<p ><strong>Purpose: <?php echo $d['purpose']; ?></strong> </p>
									</div>
									<form method = "POST">
									<div class="col-lg-2">
										<div class="pull-right">
											<?php if($_SESSION['user_id'] == '5'){ ?>
												<a class="btn btn-info" data-toggle="modal" data-target="#updatePR" id = 'getEP1' data-id="<?php echo $d['rdid']; ?>" title="Update Purpose & Enduse">
												<span class="fa fa-pencil"></span>
												</a>
												<input type='hidden' name='rec' id='rec' value="<?php echo $id; ?>">
											<?php } ?>
											<?php if($d['closed'] == '0'){ ?>
											<a onclick="confirmClose('<?php echo $d['prno'];?>', '<?php echo base_url(); ?>','<?php echo $id; ?>');" class="btn btn-gold" title="close PR"><span class="fa fa-unlock-alt"></span></a>
											<?php } else { ?>
											<a class="btn disabled btn-gold" title="PR CLOSED"><span class="fa fa-lock"></span></a>
											<?php } ?>
										</div>
									</div>
									</form>		

									<div class="modal fade" id="updatePR" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLongTitle">Update Purpose & Enduse
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</h5>															
												</div>
												<form method="POST" action = "<?php echo base_url(); ?>/index.php/receive/update_purend">
													<div class="modal-body">
														<div id = 'ep'></div>
													</div>
													<input type='hidden' name='rec_id' id='rec_id' value="<?php echo $id; ?>">
													<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
													<div class="modal-footer">
														<button type="submit" class="btn btn-primary btn-block">Save changes</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div class="modal fade" id="PRModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header modal-headback">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title" id="myModalLabel">Add New PR No.</h4>
												</div>
												<div class="modal-body">
													<form method="POST">
														<label>PR No.</label>
														<input type = "text" name = "pr_no" id="pr_no" class = "form-control option">
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<input type="hidden" name="baseurl2" id="baseurl2" value="<?php echo base_url(); ?>">
															<input type="button" id = "btnAddPR"  class="btn btn-warning" value = "Add" onclick = "addPR1()" />
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
									<table width="100%" class="table table-bordered " >
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
											<th class="tr-bottom" width="5%"><center>Total Net Cost</center></th>
											<!--<th class="tr-bottom" width="5%"><center>Expiry</center></th>-->
											<th class="tr-bottom" width="20%"><center>Remarks</center></th>
											<th><a class="btn btn-default" ><span class="fa fa-pencil"></span></a></th>
										</tr>
										<?php $itemno=1; foreach($items AS $it){ 
											if($it['rdid'] == $d['rdid']) { 
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
																	<tr>
																		<td class="pad-t-4"><strong>Inspected By:</strong></td>
																		<td class="pad-t-4">
																			<label style="color:#555;font-weight: 600"><?php echo $it['inspected']; ?></label >
																		</td>
																	</tr>
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
											<td><center><?php echo number_format($it['total_net_cost'],2); ?></center></td>
											<!--<td><?php echo $it['expiration_date']; ?></td>-->
											<td><?php echo $it['remarks']; ?></td>
											<?php if($saved==0){ ?> 
											<td><a onclick="update_prcmrk('<?php echo $it['riid'];?>','<?php echo base_url();?>')" title="Update Price & Remarks" class="btn btn-info "><span class="fa fa-pencil"></span></a></td>
											<?php } else if($_SESSION['user_id']==5 && $saved==1) { ?>
											<td><a onclick="update_prcmrk('<?php echo $it['riid'];?>','<?php echo base_url();?>')" title="Update Price & Remarks" class="btn btn-info "><span class="fa fa-pencil"></span></a></td>
											<?php } else { ?>
											<td><a onclick="update_prcmrk('<?php echo $it['riid'];?>','<?php echo base_url();?>')" title="Update Price & Remarks" class="btn btn-info " style ="pointer-events: none" disabled><span class="fa fa-pencil"></span></a></td>
											<?php } ?>
										</tr>
										<?php
											$itemno++;
												}
									 		} 
									 	?>
									</table>
								</div>
							</div>
							<?php  } 
							} ?>
							<hr>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function confirmClose(prno, baseurl,$recid){
	    	var redirect=baseurl+"index.php/receive/update_close";
	    	var recid= document.getElementById("recid").value;
	    	if(confirm('Are you sure you want to close this PR?')){
		   	$.ajax({
		        type: "POST",
		        url: redirect,
		        data: 'prno='+prno,
		        success: function(output){
		         	if(output=='x'){
		         		popupClose(output,prno,baseurl,recid);
		         	} else {
		         		alert('PR Successfully closed.');
		         		 location.reload();
		         	}

		        }
		    });
		   }
		}

		function popupClose(output,prno,baseurl,recid){
			
			 	var url=baseurl+"index.php/receive/close_remarks/"+prno+"/"+recid;
			 	window.open(url,"_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=110,left=380,width=600,height=380");
		       // confirm('You can not close this PR. You still have pending items to receive. Close anyway?');
		      
		}
	</script>
