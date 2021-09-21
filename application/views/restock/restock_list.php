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
		<li class="active">Restock</li>
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
					RESTOCK
					<div class="pull-right">
						<!-- <a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#search">
							<span class="fa fa-search"></span>
						</a> -->
						<a class="clickable panel-toggle panel-button-tab-right shadow"   href="<?php echo base_url(); ?>index.php/restock/add_restock">
							<span class="fa fa-plus"></span></span>
						</a>
					</div>
				</div>
				<div class="modal fade" id="updatePR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header modal-headback">
								<h4 class="modal-title" id="myModalLabel">Update Restock
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</h4>															
							</div>
							<form method="POST" action = "<?php echo base_url(); ?>/index.php/restock/update_purend">
								<div class="modal-body">
									<div id = 'ep'></div>
								</div>
								<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary btn-block">Save changes</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="row" style="padding:0px 10px 0px 10px">
						</div>
						<div style="overflow-x: scroll;padding-bottom: 20px ">
							<table class="table-bordered table-hover table" id="received" style="font-size: 15px;width: 150%">
								<thead>
									<tr>
										<td width="" align="center"><strong>Restock Date</strong></td>
										<td width="" align="center"><strong>From PR</strong></td>
										<td width="" align="center"><strong>MRFW No.</strong></td>
										<td width="" align="center"><strong>Department</strong></td>
										<td width="" align="center"><strong>Purpose</strong></td>
										<td width="30%" align="center"><strong>End-Use</strong></td>
										<td align="center" ><strong>Excess</strong></td>
										<td align="center" ><strong>Action</strong></td>

									</tr>
								</thead>
								<tbody>
									<?php foreach($restock AS $res){ ?>
									<tr>
										<td align="center"><?php echo $res['date'];?></td>
										<td align="center"><?php echo $res['from_pr'];?></td>
										<td align="center"><?php echo $res['mrwf_no'];?></td>
										<td align="center"><?php echo $res['department'];?></td>
										<td align=""><?php echo $res['purpose'];?></td>
										<td align=""><?php echo $res['enduse'];?></td>
										<td align="center"><?php if($res['excess']==1){ echo 'Excess Material'; } ?></td>
										<td style="padding:3px" align="center">
											<?php if($_SESSION['user_id'] == '5'){ ?>
											<a class="btn btn-info btn-xs" data-toggle="modal" data-target="#updatePR" id = 'getR' data-id="<?php echo $res['rhead_id']; ?>" title="Update Restock">
												<span class="fa fa-pencil"></span>
											</a>	
											<?php } ?>
											<a  href="<?php echo base_url();?>index.php/restock/view_restock/<?php echo $res['rhead_id'];?>" target = "_blank" class="btn btn-warning btn-xs" title="VIEW" alt='VIEW'><span class="fa fa-eye"></span></a>
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