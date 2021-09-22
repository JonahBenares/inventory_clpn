<!-- <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/item.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/request.js"></script>
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
		<li class="active">Gatepass</li>
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
					Gatepass
					<div class="pull-right">
						<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#search">
							<span class="fa fa-search"></span>
						</a>
						<a class="clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#requestModal">
							<span class="fa fa-plus"></span></span>
						</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="row" style="padding:0px 10px 0px 10px">
						</div>
						<table class="table-bordered table-hover" id="request_datatable" width="100%" style="font-size: 15px">
							<thead>
								<tr>
									<td width="1%" align="center">#</td>
									<td width="29%" align="center"><strong>To Company</strong></td>
									<td width="15%" align="center"><strong>Destination</strong></td>
									<td width="15%" align="center"><strong>Vehicle No.</strong></td>
									<td width="15%" align="center"><strong>Date Issued</strong></td>
									<td width="15%" align="center"><strong>Date Returned</strong></td>
									<td width="1%" 	align="center" ><strong><span class="fa fa-bars"></span></strong></td>
								</tr>
							
							</thead>
							<tbody>
								<?php $x=1; foreach($gatepass as $gp){ ?>
								<tr>
									<td align="center"><?php echo $x; ?></td>
									<td align="center"><?php echo $gp['supplier'];?></td>
									<td align="center"><?php echo $gp['destination'];?></td>
									<td align="center"><?php echo $gp['vehicle_no'];?></td>
									<td align="center"><?php echo $gp['date_issued'];?></td>
									<td align="center"><?php echo $gp['date_returned'];?></td>
									<td align="center">
										<a  href="<?php echo base_url();?>index.php/gatepass/view_gatepass" class="btn btn-warning btn-xs" title="VIEW" alt='VIEW'><span class="fa fa-eye"></span></a>
									</td>
								</tr>
								<?php $x++; } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!---MO-D-A-L-->
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
