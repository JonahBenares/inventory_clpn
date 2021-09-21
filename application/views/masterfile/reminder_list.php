<!-- <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/item.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#">
			<em class="fa fa-home"></em>
		</a></li>
		<li class="active">Reminder</li>
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
<div id="itemslist" style="display: none">
	<div class="row">
		<div class="col-md-12">
			<div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModal">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header modal-headback">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Add Reminder</h4>
								</div>
								<div class="modal-body" style="padding:30px 20px 30px 20px">
									<form method="POST" action="<?php echo base_url() ?>index.php/masterfile/addreminder">
										<table class="table" width="100%">
											<tr>
												<td width="20%" class="td-sclass">Reminder Date</td>
												<td><input type="date" name='reminder_date' class="form-control"></td>
											</tr>
											<tr>
												<td width="20%" class="td-sclass">Title</td>
												<td><input type="text" name='reminder_title' class="form-control"></td>
											</tr>
											<tr>
												<td width="20%" class="td-sclass">Notes</td>
												<td><textarea name='reminder_notes' class="form-control"></textarea></td>
											</tr>
											<tr>
												<td width="20%" class="td-sclass">Remind who?</td>
												<td><select name='remind_person' class="form-control">
													<option value='' selected>-Choose who to remind-</option>
													<?php 
													print_r($employee);
													foreach($employee AS $emp) { ?>
														<option value="<?php echo $emp->employee_id; ?>"><?php echo $emp->employee_name; ?></option>
													<?php } ?>
												</select></td>
											</tr>

											
										</table>
										<div class="modal-footer">
											<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<input type='submit' class="btn btn-warning" value='Proceed '> 					
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
			<div class="panel panel-default shadow">
				<div class="panel-heading">
					REMINDER
					<a class="pull-right clickable panel-toggle panel-button-tab-left"  data-toggle="modal" data-target="#reminderModal">
						<em class="fa fa-plus"></em>
					</a>					
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="row" style="padding:0px 10px 0px 10px">
						</div>
						<table class="table-bordered table-hover" id="received" width="100%" style="font-size: 15px">
							<thead>
								<tr>
									<td width="19%" align="center"><strong>Reminder Date</strong></td>
									<td width="15%" align="center"><strong>Title</strong></td>
									<td width="15%" align="center"><strong>Notes</strong></td>

									<td width="15%" align="center"><strong>Person to remind</strong></td>
									<td align="center" ><strong>Done Details</strong></td>
								</tr>
							</thead>
							<tbody> 
								<?php 
								if(!empty($reminders)){
								foreach($reminders AS $rem) { ?>
								<tr>
									<td align="center"><?php echo date('d-M-Y', strtotime($rem['reminder_date'])); ?></td>
									<td align="center"><?php echo $rem['title']; ?></td>
									<td align="center"><?php echo $rem['notes']; ?></td>
									<td align="center"><?php echo $rem['employee']; ?></td>
									<td align="center">
										<?php echo $rem['done_by'] . " / " . date('d-M-Y H:i:s', strtotime($rem['done_date'])) ; ?>
									</td>
								</tr>
								<?php } 
							} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

