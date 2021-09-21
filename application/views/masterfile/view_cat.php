<div class="container-fluid" > 
	<div class="row" style="margin-top:-50px">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading" style="height:20px">
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div>
							<div class="col-lg-12">
								<form method="POST" action = "<?php echo base_url();?>index.php/masterfile/add_subcat">
									<?php foreach($cat AS $cat) { ?>
									<label>Category Name</label>
										<input type = "hidden" name = "cat_code" class = "form-control" value = "<?php echo $cat->cat_code;?>" readonly>
										<input type = "text" name = "cat_name" class = "form-control" value = "<?php echo $cat->cat_name;?>" readonly>
									<?php } ?>
									<label>Sub Category Prefix</label>
									<input type = "text" name = "prefix" class = "form-control">
									<label>Sub Category Name</label>
									<input type = "text" name = "subcategory_name" class = "form-control">
									<br>
									<button type = "submit" class = "btn btn-primary" style = "width:100%">Save</button>
									<input type = "hidden" name = "id" value = "<?php echo $id; ?>">
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
