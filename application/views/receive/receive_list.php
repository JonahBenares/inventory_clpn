<!-- <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/item.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<style type="text/css">
	.label-info {
    background-color: #5bc0de;
}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#">
			<em class="fa fa-home"></em>
		</a></li>
		<li class="active">Receive</li>
	</ol>
</div><!--/.row-->
<div class="row">
	<div class="col-lg-12">
		<br>
	</div>
</div><!--/.row-->
<!-- Modal -->		
<div id="loader">
  	<figure class="one"></figure>
  	<figure class="two">loading</figure>
</div>
<di id="itemslist" style="display: none">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading">
					RECEIVE
					<div class="pull-right">
						<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#search">
							<span class="fa fa-search"></span>
						</a>
						<a class="clickable panel-toggle panel-button-tab-right shadow"   data-toggle="modal" data-target="#receiveModal">
							<span class="fa fa-plus"></span></span>
						</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="row" style="padding:0px 10px 0px 10px">
							<?php 
								if(!empty($_POST)){
								
									?>
									
									<div class='alert alert-warning alert-shake'>
										<center>
											<strong>Filters applied:</strong> <?php echo  $filter; ?>.
											<a href='<?php echo base_url(); ?>index.php/receive/receive_list' class='remove_filter alert-link'>Remove Filters</a>. 
										</center>
									</div>
							<?php  }?>
						</div>
						<table class="table-bordered table-hover" id="received" width="100%" style="font-size: 15px">
							<thead>
								<tr>
									<td width="1%" >#</td>
									<td align="center"><strong>Receive Date</strong></td>
									<td align="center"><strong>DR No.</strong></td>
									<td align="center"><strong>MRecF_No</strong></td>
									<!-- <td align="center"><strong>PO No.</strong></td>
									<td align="center"><strong>SI NO.</strong></td> -->
									<td width="20%" align="center"><strong>PR NO.</strong></td>									
									<td width="5%" align="center" ><strong>Action</strong></td>
								</tr>
							</thead>
							<tbody>
								<?php 
									$x = 1;
									foreach($receive AS $rec) {
								?>
								<tr>
									<td style="padding:3px" align="center"><?php echo $x; ?></td>
									<td style="padding:3px" align="center"><?php echo date('Y-m-d',strtotime($rec['receive_date'])); ?></td>
									<td style="padding:3px" align="center"><?php echo $rec['dr_no']; ?></td>
									<td style="padding:3px" align="center"><?php echo $rec['mrecf_no']; ?></td>
									<!-- <td style="padding:3px" align="center"><?php echo $rec['po_no']; ?></td>
									<td style="padding:3px" align="center"><?php echo $rec['si_no']; ?></td> -->
									<td style="padding:3px">
										<?php
											foreach($details AS $det){ 
										 		switch($det){
										 			case($rec['receive_id'] == $det['receive_id']):

										 			
										?>
											<li class="dropdown" style="list-style:none;margin:0px;width:100%">
												<!-- <p style="background: #f5e4c5;color:black;font-weight: 400;margin-bottom: 2px; font-size: 15px;width:100%"> -->
														
														
														<a class="btn btn-default btn-sm " style="width:100%;text-align: left; letter-spacing: 1px;font-size: 13px; font-weight: 700" data-toggle="dropdown" href="#">
															<?php if($det['closed'] == '0'){ ?>
															<p class="btn btn-default disabled btn-xs"><span style="width:10px" class="fa fa-unlock"></span></p><span class="fa fa-caret-right "></span>
														<?php } else { ?>
															<p class="btn btn-gold disabled btn-xs"><span style="width:10px" class="fa fa-lock"></span></p><span class="fa fa-caret-right "></span>
														<?php } ?>
															&nbsp<?php echo $det['prno'];?>
																
															</a>
													<!-- </p> -->
												<ul class="dropdown-menu dropdown-alerts animated fadeInLeft" style="width:350px;top:30px;border:1px solid #e66614;left:-170px;">
													<span class="arrow-top2"></span>
													<li style="padding:5px">
														<table class="table table-hover table-bordered" style="margin:0px">
															
															<!-- <tr>
																<td class="pad-t-4"><strong>MRecF_No:</strong></td>
																<td class="pad-t-4">
																	<label style="color:#555;font-weight: 600"><?php echo $rec['mrecf_no']; ?></label >
																</td>
															</tr> -->
															<tr>
																<td width="35%" class="pad-t-4"><strong>Department:</strong></td>
																<td class="pad-t-4">
																	<label style="color:#555;font-weight: 600"><?php echo $det['department']; ?></label >
																</td>
															</tr>
															<tr>
																<td class="pad-t-4"><strong>Purpose:</strong></td>
																<td class="pad-t-4">
																	<label style="color:#555;font-weight: 600"><?php echo $det['purpose']; ?></label >
																</td>
															</tr>
															<tr>
																<td class="pad-t-4"><strong>End Use:</strong></td>
																<td class="pad-t-4">
																	<label style="color:#555;font-weight: 600"><?php echo $det['enduse']; ?></label >
																</td>
															</tr>
														</table>
													</li>
												</ul>
											</li>																				
										 <?php	
									 		break;
									 		default: 
									 		} } 
								 		?> 

									</td>
									<td style="padding:3px" align="center">
										<a  href="<?php echo base_url();?>index.php/receive/view_receive/<?php echo $rec['receive_id'];?>" target = "_blank" class="btn btn-warning btn-xs" title="VIEW" alt='VIEW'><span class="fa fa-eye"></span></a>
									</td>
									<?php 
										$x++;
										} 
									?>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!---MO-D-A-L-->
	<div class="modal fade" id="receiveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Receive</h4>
				</div>
				<div class="modal-body" style="padding:30px 50px 30px 50px">
					<form method="POST" action = "<?php echo base_url();?>index.php/Receive/insert_receive_head">
						<table width="100%">
							<tr>
								<td width="10%"><label>Date:</label></td>
								<td width="90%"><input type = "date" name = "receive_date" class = "form-control"><br></td>
							</tr>
							<tr>
								<td width="10%"><label>DR#:</label></td>
								<td width="90%"><input type = "text" name = "dr_no" class = "form-control"><br></td>
							</tr>
							<tr>
								<td width="10%"><label>PO#:</label></td>
								<td width="90%"><input type = "text" name = "po_no" class = "form-control"><br></td>
							</tr>
							<tr>
								<td width="10%"><label>JO#:</label></td>
								<td width="90%"><input type = "text" name = "jo_no" class = "form-control"><br></td>
							</tr>
							<tr>
								<td width="10%"><label>SI#:</label></td>
								<td width="90%"><input type = "text" name = "si_no" class = "form-control"><br></td>
							</tr>
						</table>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

							<input type='submit' class="btn btn-warning" value='Proceed '> 
							<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		<div class="modal-dialog" role="document">
			<div class="modal-content modbod">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Search</h4>
				</div>
				<form method="POST" action = "<?php echo base_url(); ?>index.php/receive/search_receive" role="search">
					<div class="modal-body">
						<table style="width:100%">
							<tr>
								<td class="td-sclass"><label for="rdate">Receive Date:</label></td>
								<td class="td-sclass">
									<input type="date" name="rdate" class="form-control">
								</td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="dr">DR No.:</label></td>
								<td class="td-sclass">
									<input type="text" name="dr" class="form-control">
								</td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="po">PO No.:</label></td>
								<td class="td-sclass">
									<input type="text" name="po" class="form-control">
								</td>
							</tr>
							<!-- <tr>
								<td class="td-sclass"><label for="jo">JO No.:</label></td>
								<td class="td-sclass">
									<input type="text" name="jo" class="form-control">
								</td>
							</tr> -->
							<tr>
								<td class="td-sclass"><label for="si">SI No.:</label></td>
								<td class="td-sclass">
									<input type="text" name="si" class="form-control">
								</td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="pr">PR No.:</label></td>
								<td class="td-sclass">
									<input type="text" name="pr" class="form-control">
								</td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="enduse">End Use:</label></td>
								<td class="td-sclass">
									<select name="enduse" class="form-control">
										<option value='' selected>-Choose End Use-</option>
										<?php 
											foreach($enduse AS $end){
										?>
										<option value = "<?php echo $end->enduse_id;?>"><?php echo $end->enduse_name;?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="purpose">Purpose:</label></td>
								<td class="td-sclass">
									<select name="purpose" class="form-control">
										<option value='' selected>-Choose Purpose-</option>
										<?php 
											foreach($purpose AS $pur){
										?>
										<option value = "<?php echo $pur->purpose_id?>"><?php echo $pur->purpose_desc?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
						</table>					
					</div>
					<div class="modal-footer">
						<input type="submit" name="searchbtn" class="search-btn btn btn-default shadow" value="Search">
					</div>
					<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_delete_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="alert alert-danger">
				<center>
				  	<h2 class="alert-link"><strong><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> DANGER!</strong></h2>
				  	<hr>
				  	Are you sure you want to delete this?
				  	<br>
				  	<br>					  	
				  	<a href="#" class="btn btn-default " data-dismiss="modal">NO</a>&nbsp<a href="#" class="btn btn-danger">YES</a>.
			  	</center>
			</div>
		</div>
	</div>
