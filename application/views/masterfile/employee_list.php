<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Employee</li>
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
					<div class="panel-heading">
						EMPLOYEE LIST
						<div class="pull-right">
							<?php if($access['masterfile_add'] == 1){ ?>
							<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#myModal">
								<span class="fa fa-plus"></span>
							</a>
							<?php } ?>
						</div>
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<table class="table table-bordered table-hover" id="item_table">
								<thead>
									<tr>
										<th>Employee Name</th>
										<th>Position</th>
										<th>Department</th>
										<th>Contact No.</th>
										<th>Email</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										foreach($employee AS $emp){
									?>
									<tr>
										<td><?php echo $emp['employee']?></td>
										<td><?php echo $emp['position']?></td>
										<td><?php echo $emp['department'];?></td>
										<td><?php echo $emp['contact_no']?></td>
										<td><?php echo $emp['email']?></td>
										<td>
											<?php if($access['masterfile_edit'] == 1){ ?>
											<a href = "<?php echo base_url(); ?>index.php/masterfile/update_employee/<?php echo $emp['employee_id'];?>" class = "btn btn-primary btn-sm" title="UPDATE"><span class="fa fa-pencil-square-o"></span></a>
											<?php } //if($access['masterfile_delete'] == 1){ ?>
											<!-- <a href = "<?php echo base_url(); ?>index.php/masterfile/delete_employee/<?php echo $emp['employee_id'];?>" onclick="confirmationDelete(this);return false;" class = "btn btn-danger btn-sm" title="DELETE"><span class="fa fa-trash"></span></a> -->
											<?php //} ?>
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

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add New Employee</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action = "<?php echo base_url();?>index.php/masterfile/add_employee">
							<label>Employee Name</label>
							<input type = "text" name = "employee_name" class = "form-control">
							<label>Position</label>
							<input type = "text" name = "position" class = "form-control">
							<label>Deparment</label>
							<select name = "department" class = "form-control">
								<option value = "">--Select Department--</option>
								<?php 
									foreach($department AS $dep){
								?>
								<option value = "<?php echo $dep->department_id;?>"><?php echo $dep->department_name;?></option>
								<?php } ?>	
							</select>
							<label>Contact Number</label>
							<input type = "number" name = "contact_no" class = "form-control">

							<label>Email Address</label>
							<input type = "text" name = "em" class = "form-control">

							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-warning">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
