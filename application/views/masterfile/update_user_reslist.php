
<script  type="text/javascript">

		//alert(x);
	function selectAll(x){
		alert(x);
			checkboxes= document.getElementsByClassName(x);
	        for(var i=0, n=checkboxes.length;i<n;i++) {
	            checkboxes[i].checked = source.checked;
	        }
				
	}



</script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li><a href="<?php echo base_url(); ?>index.php/masterfile/user_reslist">User Restriction</a></li>
				<li class="active">Update</li>

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
									<td width="85%"><input type = "text" name = "fullname" class = "form-control" required="" =""><br></td>
								</tr>
								<tr>
									<td width="15%"><label>Username:</label></td>
									<td width="85%"><input type = "text" name = "username" class = "form-control" required="" =""><br></td>
								</tr>
								<tr>
									<td width="15%"><label>Password:</label></td>
									<td width="85%"><input type = "password" name = "password" class = "form-control" required="" =""><br></td>
								</tr>
								<tr>
									<td width="15%"><label>Re-Type Password:</label></td>
									<td width="85%"><input type = "" name = "" class = "form-control" ><br></td>
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
							<a class=" clickable panel-toggle panel-button-tab-right shadow" data-toggle="modal" data-target="#userModal">
								<span class="fa fa-plus"></span>
							</a>
						</div>
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<div class="row">
								<div class="col-lg-1">
									<a href="<?php echo base_url(); ?>index.php/masterfile/update_user_reslist" class="btn btn-warning"> Update User Restriction</a>
								</div>
							</div>
							<br>
							<form method="POST" action = "<?php echo base_url(); ?>index.php/masterfile/insert_update_user">
								<div class="row">
									<div class="col-lg-3" style="padding-right: 1px;padding-bottom: 20px">
										<table class=" table-bordered table-hover" width="100%">
												<thead>
													
													<tr>
														<th width="85%" class="table-sty2"><br></th>
														<!-- <th width="15%" class="table-sty2"><br></th> -->
													</tr>
													<tr>
														<th class="table-sty th-name-sub">Users</th>
														<!-- <th class="table-sty th-name-sub"></th> -->
													</tr>
												</thead>
												<tbody>
													<?php 
														$x = 1;
														foreach($users as $use){ 
													?>
													<tr>
														<td class="table-sty3"><input type = "hidden" name = "userid<?php echo $x;?>" value = "<?php echo $use['userid'];?>"<?php echo set_checkbox('userid', $use['userid']); ?>><?php echo $use['fullname'];?></td>
														<!-- <td><input type="button" name="select" id='select' onclick="selectAll(<?php echo $use['username']; ?>)" value='select'>
															<input type="button" name="deselect" id='deselect' onclick="DeselectAll(<?php echo $x; ?>)" value='Deselect'></td> -->
													</tr>
													<?php $x++; } ?>
													<input type='hidden' name='counter' id='counter' value="<?php echo $x; ?>">
												</tbody>
										</table>
									</div>
									<div  class="col-lg-9" style="overflow-x: scroll;padding-left: 1px;padding-bottom: 20px ">
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
												<?php
													$x = 1; 
													foreach($users as $use){ 
												?>
												<tr>
													
													<td class="td-rec-body table-sty">
														<input type="checkbox" name="rec_add<?php echo $x;?>" value = "1" class="form-control <?php echo $use['username']; ?>" <?php echo ((strpos($use['rec_add'], "1") !== false) ? ' checked' : '');?>>
													</td>													
													<td class="td-rec-body table-sty">
														
														<input type="checkbox"  name="rec_edit<?php echo $x;?>" value = "1" class="form-control <?php echo $use['username']; ?>" <?php echo ((strpos($use['rec_edit'], "1") !== false) ? ' checked' : '');?>>
														
													</td>
													<td class="td-rec-body table-sty">
													
														<input style = "height:30px" type="checkbox"  id='rec_delete<?php echo $x; ?>' name="rec_delete<?php echo $x;?>" value = "1"  <?php echo ((strpos($use['rec_delete'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>

													<!-- -->
													<td class="td-req-body table-sty">
														<input type="checkbox" id='req_add<?php echo $x; ?>' name="req_add<?php echo $x;?>" value = "1" <?php echo ((strpos($use['req_add'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-req-body table-sty">
														<input type="checkbox" id='req_edit<?php echo $x; ?>' name="req_edit<?php echo $x;?>" value = "1" <?php echo ((strpos($use['req_edit'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-req-body table-sty">
													
														<input style = "height:30px" type="checkbox" id='req_delete<?php echo $x; ?>' name="req_delete<?php echo $x;?>" value = "1" <?php echo ((strpos($use['req_delete'], "1") !== false) ? ' checked' : '');?> class="form-control">
													
													</td>

													<!-- -->
													<td class="td-iss-body table-sty">
													
														<input type="checkbox" name="iss_add<?php echo $x;?>" id='iss_add<?php echo $x; ?>' value = "1"<?php echo ((strpos($use['iss_add'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-iss-body table-sty">
														<input type="checkbox" name="iss_edit<?php echo $x;?>" id='iss_edit<?php echo $x; ?>' value = "1"<?php echo ((strpos($use['iss_edit'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-iss-body table-sty">
														<input style = "height:30px" type="checkbox" id='iss_delete<?php echo $x; ?>' name="iss_delete<?php echo $x;?>" value = "1"<?php echo ((strpos($use['iss_delete'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-ite-body table-sty">
														<input type="checkbox" id='itm_add<?php echo $x; ?>' name="itm_add<?php echo $x;?>" value = "1"<?php echo ((strpos($use['itm_add'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-ite-body table-sty">
														<input type="checkbox" id='itm_edit<?php echo $x; ?>' name="itm_edit<?php echo $x;?>" value = "1"<?php echo ((strpos($use['itm_edit'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-ite-body table-sty">
														<input style = "height:30px" type="checkbox" id='itm_delete<?php echo $x; ?>' name="itm_delete<?php echo $x;?>" value = "1"<?php echo ((strpos($use['itm_delete'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>

													<!--  -->
													<td class="td-sig-body table-sty">
														<input type="checkbox" id='sig_add<?php echo $x; ?>' name="sig_add<?php echo $x;?>" value = "1"<?php echo ((strpos($use['sig_add'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-sig-body table-sty">
														<input type="checkbox" id='sig_edit<?php echo $x; ?>' name="sig_edit<?php echo $x;?>" value = "1"<?php echo ((strpos($use['sig_edit'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-sig-body table-sty">
														<input style = "height:30px" type="checkbox" id='sig_delete<?php echo $x; ?>' name="sig_delete<?php echo $x;?>" value = "1"<?php echo ((strpos($use['sig_delete'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>

													<!--  -->
													<td class="td-mas-body table-sty">
														<input type="checkbox" id='mas_add<?php echo $x; ?>' name="mas_add<?php echo $x;?>" value = "1"<?php echo ((strpos($use['mas_add'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-mas-body table-sty">
														<input type="checkbox" id='mas_edit<?php echo $x; ?>' name="mas_edit<?php echo $x;?>" value = "1"<?php echo ((strpos($use['mas_edit'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-mas-body table-sty">
														<input style = "height:30px" type="checkbox" id='mas_delete<?php echo $x; ?>' name="mas_delete<?php echo $x;?>" value = "1"<?php echo ((strpos($use['mas_delete'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>

													<!-- -->
													<td class="td-res-body table-sty">
														<input type="checkbox" id='res_add<?php echo $x; ?>' name="res_add<?php echo $x;?>" value = "1"<?php echo ((strpos($use['res_add'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-res-body table-sty">
														<input type="checkbox" id='res_edit<?php echo $x; ?>' name="res_edit<?php echo $x;?>" value = "1"<?php echo ((strpos($use['res_edit'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-res-body table-sty">
														<input style = "height:30px" type="checkbox" id='res_delete<?php echo $x; ?>' name="res_delete<?php echo $x;?>" value = "1"<?php echo ((strpos($use['res_delete'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>

													<!-- -->
													<td class="td-use-body table-sty">
														<input type="checkbox" id='user_add<?php echo $x; ?>' name="user_add<?php echo $x;?>" value = "1"<?php echo ((strpos($use['user_add'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-use-body table-sty">
														<input type="checkbox" id='user_edit<?php echo $x; ?>' name="user_edit<?php echo $x;?>" value = "1"<?php echo ((strpos($use['user_edit'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
													<td class="td-use-body table-sty">
														<input style = "height:30px" type="checkbox" id='user_delete<?php echo $x; ?>' name="user_delete<?php echo $x;?>" value = "1"<?php echo ((strpos($use['user_delete'], "1") !== false) ? ' checked' : '');?> class="form-control">
														
													</td>
												</tr>
												<?php $x++; } ?>									
											</tbody>
											<input type='hidden' name='count' value='<?php echo $x; ?>'>
										</table>
									</div>
								</div>
								<br>
								<button type="submit" name="submit" class="btn btn-primary btn-md btn-block">Save</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- MODAL -->
		<!-- Modal -->
