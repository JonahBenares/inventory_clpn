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
		<li class="active">Request</li>
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
					Issuance List
					<!-- <div class="pull-right">
						<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#search">
							<span class="fa fa-search"></span>
						</a>
						<a class="clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#requestModal">
							<span class="fa fa-plus"></span></span>
						</a>
					</div> -->
				</div>
				
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="row" style="padding:0px 10px 0px 10px">
						</div>
						<table class="table-bordered table-hover" id="received" width="100%" style="font-size: 15px">
							<thead>
								<tr>
									<td width="29%" align="center"><strong>MIF No.</strong></td>
									<td width="29%" align="center"><strong>MReqF No.</strong></td>
									<td width="15%" align="center"><strong>PR / JO #</strong></td>
									<td width="15%" align="center"><strong>Date / Time</strong></td>

									<td width="15%" align="center"><strong>Department</strong></td>
									<td width="15%" align="center"><strong>Purpose</strong></td>
									<td width="15%" align="center"><strong>End Use</strong></td>
									<td width="1%" 	align="center" ><strong>Action</strong></td>
								</tr>
							
							</thead>
							<tbody>								
								<?php 
								if(!empty($issue_list)){
								foreach($issue_list as $list){ ?>
								<tr>
									<td align="center"><?php echo $list['mifno'];?></td>
									<td align="center"><?php echo $list['mreqf'];?></td>
									<td align="center"><?php echo $list['prno'];?></td>
									<td align="center"><?php echo $list['date'];?> / <?php echo $list['time'];?></td>

									<td align="center"><?php echo $list['department'];?></td>
									<td align="center"><?php echo $list['purpose'];?></td>
									<td align="center"><?php echo $list['enduse'];?></td>
									<td align="center">
										<a href="<?php echo base_url();?>index.php/issue/mif/<?php echo $list['issuance_id'];?>"  class="btn btn-warning btn-xs" target="_blank" title="VIEW" alt='VIEW'><span class="fa fa-eye"></span></a>
									</td>
								</tr>
								<?php } 
							}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>