<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/masterfile/supplier_list">Supplier </a></li>
			<li class="active"> Update</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<br>
		</div>
	</div><!--/.row-->
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Modal title</h4>
				</div>
				<div class="modal-body">
				...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading panel-heading-update" style="height:20px">
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="col-lg-12">
							<form method='POST' action="<?php echo base_url(); ?>index.php/masterfile/update_list">
								<?php foreach($list AS $li){ ?>	
								<div class="col-lg-6">
									<div class="form-group"></div>
									<label>Supplier Code</label>
									<input class="form-control" type="text" name="supplier_code" 
									value="<?php echo $li->supplier_code; ?>">
									<label>Supplier Name</label>
									<input class="form-control" type="" name="supplier_name" value="<?php echo $li->supplier_name; ?>">
									<label>Address</label>
									<input class="form-control" type="" name="address" value="<?php echo $li->address; ?>">
									<label>Contact Number</label>
									<input class="form-control" type="" name="contact_number" value="<?php echo $li->contact_number; ?>">
									<label>Terms</label>
									<input class="form-control" type="" name="terms" value="<?php echo $li->terms; ?>">
									<label>Status</label>
									<div class = "row">
										<div class = "col-md-6">
											<label class="btn btn-primary"><input type="radio" name = "active" value="1" <?php echo (isset($li->supplier_id) ? (($li->active=='1') ? ' checked' : '') : ''); ?>> Active</label>
											<label class="btn btn-danger"><input type="radio" name = "active" value="0" <?php echo (isset($li->supplier_id) ? (($li->active=='0') ? ' checked' : '') : ''); ?>> Inactive</label>
										</div>
									</div>
									<br>
									<input type='hidden' name='supplier_id' value='<?php echo $id; ?>'>
									<input class="btn btn-primary btn-md" type="submit" name="add_item" value="Submit">			
								</div>
								<?php } ?>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


