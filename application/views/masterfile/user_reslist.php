<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">User Restriction</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<br>
			</div>
		</div><!--/.row-->		

		<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add User</h4>
						
					</div>
					<div class="modal-body" style="padding:30px 50px 30px 50px">
						<form method = "POST" action = "<?php echo base_url(); ?>index.php/masterfile/insert_user">
							<table width="100%">
								<tr>
									<td width="15%"><label>Fullname:</label></td>
									<td width="85%"><input type = "text" name = "fullname" class = "form-control" required=""><br></td>
								</tr>
								<tr>
									<td width="15%"><label>Username:</label></td>
									<td width="85%"><input type = "text" name = "username" class = "form-control" required=""><br></td>
								</tr>
								<tr>
									<td width="15%"><label>Password:</label></td>
									<td width="85%"><input type = "password" name = "password" class = "form-control password"><br></td>
								</tr>
								<tr>
									<td width="15%"><label>Re-Type Password:</label></td>
									<td width="85%"><input type = "password" name = "cpassowrd" onchange = "val_cpass()" class = "form-control confirm_password" ><br></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<div class="alert alert-danger alert-shake" id="cpass_msg" style = "display:none;">
                                           <center>Confirm Password not Match!</center>
                                        </div>
									</td>
								</tr>
							</table>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

								<input type='submit' class="btn btn-warning" value='Save '> 
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default shadow">
					<div class="panel-heading">
						USER RESTRICTION LIST
						<div class="pull-right">
							<?php if($access['masterfile_add'] == 1){ ?>
							<a class=" clickable panel-toggle panel-button-tab-right shadow" data-toggle="modal" data-target="#userModal">
								<span class="fa fa-plus"></span>
							</a>
							<?php } ?>
						</div>
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<div class="row">
								<div class="col-lg-1">
									<?php if($access['masterfile_edit'] == 1){ ?>
									<a href="<?php echo base_url(); ?>index.php/masterfile/update_user_reslist" class="btn btn-warning"> Update User Restriction</a>
									<?php } ?>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-lg-3" style="padding-right: 1px;padding-bottom: 20px">
									<table class=" table-bordered table-hover" width="100%">
											<thead>
												<tr>
													<th class="table-sty"><br></th>
												</tr>
												<tr>
													<th class="table-sty th-name-sub">Users</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($users as $u){ ?>
												<tr>
													<td class="table-sty2"><?php echo $u['fullname'];?></td>
												</tr>
												<?php }?>
											</tbody>
									</table>
								</div>
								<div class="col-lg-9" style="overflow-x: scroll;padding-left: 1px;padding-bottom: 20px " >
									<table class=" table-bordered table-hover" width="100%">
										<thead>
											<tr>
												<th colspan="3" class="table-sty th-rec">Receive</th>
												<th colspan="3" class="table-sty th-req">Request</th>
												<th colspan="3" class="table-sty th-iss">Issue</th>
												<th colspan="3" class="table-sty th-ite">Item</th>
												<th colspan="3" class="table-sty th-sig">Signatories</th>
												<th colspan="3" class="table-sty th-mas">Masterfile</th>
												<th colspan="3" class="table-sty th-res">Restock</th>
												<th colspan="3" class="table-sty th-use">Users</th>
											</tr>
											<tr>
												<th class="table-sty th-rec-sub">Add</th>
												<th class="table-sty th-rec-sub">Edit</th>
												<th class="table-sty th-rec-sub">Delete</th>

												<th class="table-sty th-req-sub">Add</th>
												<th class="table-sty th-req-sub">Edit</th>
												<th class="table-sty th-req-sub">Delete</th>

												<th class="table-sty th-iss-sub">Add</th>
												<th class="table-sty th-iss-sub">Edit</th>
												<th class="table-sty th-iss-sub">Delete</th>

												<th class="table-sty th-ite-sub">Add</th>
												<th class="table-sty th-ite-sub">Edit</th>
												<th class="table-sty th-ite-sub">Delete</th>

												<th class="table-sty th-sig-sub">Add</th>
												<th class="table-sty th-sig-sub">Edit</th>
												<th class="table-sty th-sig-sub">Delete</th>

												<th class="table-sty th-mas-sub">Add</th>
												<th class="table-sty th-mas-sub">Edit</th>
												<th class="table-sty th-mas-sub">Delete</th>

												<th class="table-sty th-res-sub">Add</th>
												<th class="table-sty th-res-sub">Edit</th>
												<th class="table-sty th-res-sub">Delete</th>

												<th class="table-sty th-use-sub">Add</th>
												<th class="table-sty th-use-sub">Edit</th>
												<th class="table-sty th-use-sub">Delete</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($users as $us){ ?>
											<tr>
												<td class="td-rec-body table-sty">
												<?php if($us['rec_add'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-rec-body table-sty">
												<?php if($us['rec_edit'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-rec-body table-sty">
												<?php if($us['rec_delete'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>

												<!-- ----- -->
												<td class="td-req-body table-sty">
												<?php if($us['req_add'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-req-body table-sty">
												<?php if($us['req_edit'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-req-body table-sty">
												<?php if($us['req_delete'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>

												<!-- ----- -->
												<td class="td-iss-body table-sty">
												<?php if($us['iss_add'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-iss-body table-sty">
												<?php if($us['iss_edit'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-iss-body table-sty">
												<?php if($us['iss_delete'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>

												<!-- ----- -->
												<td class="td-ite-body table-sty">
												<?php if($us['itm_add'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-ite-body table-sty">
												<?php if($us['itm_edit'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-ite-body table-sty">
												<?php if($us['itm_delete'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>

												<!-- ----- -->
												<td class="td-sig-body table-sty">
												<?php if($us['sig_add'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-sig-body table-sty">
												<?php if($us['sig_edit'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-sig-body table-sty">
												<?php if($us['sig_delete'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>

												<!-- ----- -->
												<td class="td-mas-body table-sty">
												<?php if($us['mas_add'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-mas-body table-sty">
												<?php if($us['mas_edit'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-mas-body table-sty">
												<?php if($us['mas_delete'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>

												<!-- ----- -->
												<td class="td-res-body table-sty">
												<?php if($us['res_add'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-res-body table-sty">
												<?php if($us['res_edit'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-res-body table-sty">
												<?php if($us['res_delete'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>

												<!-- ----- -->
												<td class="td-use-body table-sty">
												<?php if($us['user_add'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-use-body table-sty">
												<?php if($us['user_edit'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
												<td class="td-use-body table-sty">
												<?php if($us['user_delete'] == '1'){ ?>
													<span class="fa fa-check"></span>
												<?php } else { ?>
													<span></span>
												<?php } ?>
												</td>
											</tr>
											<?php } ?>									
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- ----------------------MODAL------------------------- -->
		<!-- Modal -->
