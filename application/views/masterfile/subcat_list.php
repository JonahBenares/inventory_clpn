<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Dashboard</li>
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
						SUB CATEGORY LIST
						<div class="pull-right">
							<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#addCategory">
								<span class="fa fa-plus"></span>
							</a>
						</div>
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<table class="table table-bordered table-hover" id="item_table">
								<thead>
									<tr>
										<th>Category Name</th>
										<th>Sub Category Prefix</th>
										<th>Sub Category Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($subcat AS $sub){ ?>
									<tr>
										<td><?php echo $sub->subcat_code; ?></td>
										<td><?php echo $sub->subcat_prefix; ?></td>
										<td><?php echo $sub->subcat_name;?></td>
										<td>
											<a href = "" class = "btn btn-success btn-sm" title="ADD NEW SUB CATEGORY" data-toggle="modal" data-target="#addSubCat"><span class="fa fa-plus"></span></a>
											<a href = "" class = "btn btn-primary btn-sm" title="UPDATE"><span class="fa fa-pencil-square-o"></span></a>
											<!-- <a href = "" class = "btn btn-danger btn-sm" title="DELETE"><span class="fa fa-trash"></span></a> -->
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

		<!-- ----------------------MODAL------------------------- -->
		<!-- Modal -->
		<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add New Category</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action = "<?php echo base_url();?>index.php/masterfile/add_category">
							<label>Prefix</label>
							<input type = "text" name = "prefix" class = "form-control">
							<label>Category Name</label>
							<input type = "text" name = "category_name" class = "form-control">
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-warning">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="addSubCat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add <strong>Sub</strong> Category</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action = "<?php echo base_url();?>index.php/masterfile/add_subcat">
							<label>Category Name</label>
							<input type = "text" name = "category_name" class = "form-control">
							<label>Sub Category Prefix</label>
							<input type = "text" name = "prefix" class = "form-control">
							<label>Sub Category Name</label>
							<input type = "text" name = "subcategory_name" class = "form-control">
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-warning">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

