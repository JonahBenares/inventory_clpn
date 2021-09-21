<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url();?>assets/jquery.min.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/masterfile/import_items">Import Items </a></li>
		</ol>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<br>
		</div>
	</div>
<div>	
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default shadow">
			<div class="panel-heading" style="height:20px"></div>
			<div class="panel-body">
				<div class="canvas-wrapper">
					<div style="padding: 20px 50px 20px 50px">
						<div class="col-lg-12">
							<div class="row" style="padding: 0px 0px 10px 0px">
								<div class="col-lg-12">
									<label>Upload Excel Files:</label>
								</div>
							</div>
							<div class="row" style="padding: 0px 0px 10px 0px">
								<div class="col-lg-3">
									<strong>File to Upload</strong>
								</div>
								<div class="col-lg-3">
									<strong>Format</strong>
								</div>
								<div class="col-lg-4">
									<strong>Upload Files</strong>
								</div>
								<div class="col-lg-2"></div>
							</div>
							<form method='POST' action='upload_excel' enctype="multipart/form-data">
								<div class="row" style="padding: 0px 0px 10px 0px">
									<div class="col-lg-3">
										Item Inventory
									</div>
									<div class="col-lg-3">
										<a href='<?php echo base_url(); ?>index.php/masterfile/export_inventory' title = "Download">Download Inventory Format</a>
									</div>
									<div class="col-lg-4">
										<input type='file' name='excelfile' id = "file" required>
									</div>
									<div class = "cont">
									<div class="col-lg-2">
										<?php if($access['masterfile_add'] == 1){ ?>
										<button type = "submit" style="background: #ff5d00" class="btn btn-warning form-control"  name='uploadexcel' id="submitButton" >Upload</button>
										<?php } ?>
									</div></div>
									<div class="modal fade " tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" id="loda">
    									<div class="modal-dialog" role="document">
									    	<div style="margin-top:50%">
										    	<div id="loading">
												  	<figure class="one"></figure>
												  	<figure class="two">Uploading</figure>
												</div>
									        </div>
									    </div>
									</div>
								</div>
							</form>
							<form method='POST' action='upload_excel_begbal' enctype="multipart/form-data">
								<div class="row" style="padding: 0px 0px 10px 0px">
									<div class="col-lg-3">
										Beginning Balance
									</div>
									<div class="col-lg-3">
										<a href='<?php echo base_url(); ?>index.php/masterfile/export_begbal' title = "Download">Download Beg. Bal. Format</a>
									</div>
									<div class="col-lg-4">
										<input type='file' name='excelfile_begbal' id = "file1" required>
									</div>
									<div class="col-lg-2">
										<?php if($access['masterfile_add'] == 1){ ?>
										<button type = "submit" style="background: #ff5d00" class="btn btn-warning form-control"  name='uploadexcel' id="submit" >Upload</button>
										<?php } ?>
									</div>
									<div class="modal fade " tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" id="loads">
    									<div class="modal-dialog" role="document">
									    	<div style="margin-top:50%">
										    	<div id="loading">
												  	<figure class="one"></figure>
												  	<figure class="two">Uploading</figure>
												</div>
									        </div>
									    </div>
									</div>
								</div>
							</form>
							<form method='POST' action='upload_excel_current' enctype="multipart/form-data">
								<div class="row" style="padding: 0px 0px 10px 0px">
									<div class="col-lg-3">
										Update Item Info
									</div>
									<div class="col-lg-3">
										<a href='<?php echo base_url(); ?>index.php/masterfile/export_current' title = "Download">Download Current Inventory Format</a>
									</div>
									<div class="col-lg-4">
										<input type='file' name='excelfile_cur' id = "file2" required>
									</div>
									<div class="col-lg-2">
										<?php if($access['masterfile_add'] == 1){ ?>
										<button type = "submit" style="background: #ff5d00" class="btn btn-warning form-control"  name='uploadexcel' id="submit" >Upload</button>
										<?php } ?>
									</div>
									<div class="modal fade " tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" id="loads">
    									<div class="modal-dialog" role="document">
									    	<div style="margin-top:50%">
										    	<div id="loading">
												  	<figure class="one"></figure>
												  	<figure class="two">Uploading</figure>
												</div>
									        </div>
									    </div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
