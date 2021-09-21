<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/issue.js"></script>
<style type="text/css">
	#name-item{
		width:57%!important;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active">Issue</li>
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
						<table width="100%" >
							<tr>
								<td width="20%"><label class="pull-right">Search MReqF No.:</label></td>
								<td width="60%"><input type = "type" name="mreqf" id="mreqf" class = "form-control" style="margin:4px" autocomplete="off">
									<span id="suggestion-mreqf"></span>
									<input type='hidden' name='request_id' id='request_id'></td>
								<td ><input type='submit' class="btn btn-warning" value="Load" onclick="loadIssuance()"></td>					
							</tr>
						</table>
						<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
						<hr>
						<form id='issueform'>
						<?php 
						$today= date('Y-m-d');
						$time = date('H:i:s');
						if(!empty($id)){ 
							$h=count($head);

						  for($x=0;$x<$h;$x++){
						  	
							
							$saved= $head[$x]['saved']; 

							echo $saved;?>
							<div style="margin: 10px 10px"> 
								<div class="row border-class shadow">
									<div style="padding:0px 15px!important">
										<table width="100%">
											<tr>
												<td ><p class="nomarg">Department:</p></td>
												<td ><label class="labelStyle"><?php echo $head[$x]['department']; ?></label></td>
												<td ><p class="nomarg pull-right">MIF No:</p></td>
												<td colspan="3"><label class="labelStyle"><?php echo $head[$x]['mif']; ?></label></td>
												<td width="15%">
												</td>
											</tr>
											<tr>
												<td width="10%"><p class="nomarg">Purpose:</p></td>
												<td width="30%"> <h5 class="nomarg"><?php echo $head[$x]['purpose']; ?></h5></td>
												<td ><p class="nomarg pull-right">MReqf No:</p></td>
												<td colspan="3"><label class="labelStyle"><?php echo $head[$x]['mreqf_no']; ?></label></td>
												<td width="15%">
												</td>
											</tr>
										
											<tr>
												<td><p class="nomarg">End Use:</p></td>
												<td> <h5 class="nomarg"><?php echo $head[$x]['enduse']; ?></h5></td>
												<td width="10%"><p class="nomarg pull-right">Date:</p></td>
												<td width="10%"><h5 class="nomarg"> <input type='date' name='issue_date' id='issue_date' class='form-control' value='<?php echo $today; ?>'></td>
												<td width="10%"><p class="nomarg">&nbsp; Time:</p></td>
												<td > <h5 class="nomarg"><input type='text' name='issue_time' id='issue_time' class='form-control' value='<?php echo $time; ?>'></td>
											</tr>
											<tr>
												<td><p class="nomarg">JO / PR #:</p></td>
												<td> <h5 class="nomarg"><?php echo $head[$x]['prno']; ?></h5></td>
											</tr>
										</table>
										<input type="hidden" name="request_id" id="request_id" value="<?php echo $head[$x]['requestid']; ?>">
										
										<hr>
										
										<div class="row">
											<div class="col-lg-12">
												<table class="table table-bordered table-hover">
													<tr>
														<th style='text-align: center;'>Issue Qty</th>
														<th style='text-align: center;'>Req Qty </th>
														<th style='text-align: center;'>UOM</th>
														<th style='text-align: center;'>Part No.</th>
														<th style='text-align: center;'>Cat No.</th>
														<th style='text-align: center;'>Supplier</th>
														<th style='text-align: center;'>Item Description</th>
														<th style='text-align: center;'>Brand</th>
														<th style='text-align: center;'>Serial No.</th>
														
														<th style='text-align: center;'>Remarks</th>
													</tr>
													<tbody id="item_body">
														<?php 
														
														$ct=0;
														// /print_r($items);
														if(!empty($items)){
															//echo $items[$x]['quantity'];
															//print_r($items);
														foreach($items AS $it) {
															//echo "head=".$head[$x]['issueid'] . ", it=" . $it['issueid'];
															//if($head[$x]['issueid'] == $it['issueid']){
														// /	echo 
															//echo $it['quantity'];
														
															//$citems=count($items);
															//echo $citems;
														//for($a=0;$a<$citems;$a++) {
																
															?>
														<tr>
															
															<td>
																<?php if($saved==0){ ?>
																<input type='text' onkeypress="return isNumberKey(event)" name='quantity[]' value="<?php echo $it['quantity']; ?>" style='width:50px' max="<?php echo $it['quantity']; ?>">
																<?php } else { 
																	echo $it['issue_qty'];

																 } ?>

															</td>
															<td><center><?php echo $it['quantity']; ?></center></td>
															<td><?php echo $it['uom']; ?></td>
															<td><?php echo $it['pn_no']; ?></td>
															<td><?php echo $it['catalog_no']; ?></td>
															<td><?php echo $it['supplier']; ?></td>
															<td><?php echo $it['item']; ?></td>
															<td><?php echo $it['brand']; ?></td>
															<td><?php if($saved==0){ ?>
																<select name='serial[]'>
																	<option value='' selected>-Serial No-</option>
																	<?php foreach($serial[$ct] AS $ser){ ?>
																	<option value='<?php echo $ser->serial_id; ?>'><?php echo $ser->serial_no; ?></option>
																	<?php } ?>
																</select>
																<?php } else { 
																	echo $it['serial'];

																 } ?>
															</td>

															<td>
																<?php if($saved==0){ ?>
																<textarea name='remarks[]' id='remarks[]'></textarea>
																<?php } else { 
																	echo $it['remarks'];

																 } ?>
															</td>
															
														</tr>
														 <input type='hidden' name='rqid[]' value="<?php echo $it['rqid']; ?>">
														<!--<input type='hidden' name='uom[]' value="<?php echo $it['uom']; ?>">
														<input type='hidden' name='itemid[]' value="<?php echo $it['item_id']; ?>">
														<input type='hidden' name='supplierid[]' value="<?php echo $it['supplier_id']; ?>">
														<input type='hidden' name='brandid[]' value="<?php echo $it['brand_id']; ?>">
														<input type='hidden' name='pn_no[]' value="<?php echo $it['pn_no']; ?>">
														<input type='hidden' name='catalog_no[]' value="<?php echo $it['catalog_no']; ?>">  -->
														<?php 
														$ct++;
														//}
														}
													//} 
													?>
													</tbody>
												</table>
												<input type="hidden" name="count" id="count" value="<?php echo $ct; ?>">
											<!-- 	<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>"> -->
												<input type="hidden" name="userid" id="userid" value="<?php echo $_SESSION['user_id']; ?>">
												<?php if($saved==0){ ?>
												<input type='button' class="btn btn-md btn-warning"  onclick='saveIssue()' style="width:100%;background: #ff5d00" value='Save and Print'>
												<?php } else { ?>
												
												<input type='button' class="btn btn-md btn-warning"  onclick='reprintIssue(<?php echo $head[$x]['issueid']; ?>)' style="width:100%;background: #ff5d00" value='Re-Print MIF'>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php }
						
							}
						}
							 ?>
						</form>
						</div>
					</div>

			</div>
		</div>
	</div>
