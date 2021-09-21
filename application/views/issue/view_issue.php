<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/issue.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
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
		<li class="active">Issuance</li>
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
					<div class="pull-right">
						<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#search">
							<span class="fa fa-search"></span>
						</a>
						<!-- <a class="clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#requestModal">
							<span class="fa fa-plus"></span></span>
						</a> -->
					</div>
				</div>
				<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
					<div class="modal-dialog" role="document">
						<div class="modal-content modbod">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Search</h4>
							</div>
							<form method="POST" action = "<?php echo base_url(); ?>index.php/issue/search_issue" role="search">
								<div class="modal-body">

									<table style="width:100%">
										<tr>
											<td class="td-sclass" width="35%"><label for="idate">Issue Date:</label></td>
											<td class="td-sclass">
												<input type="date" name="idate" class="form-control">
											</td>
										</tr>
										<tr>
											<td class="td-sclass"><label for="mif_no">MIF No.:</label></td>
											<td class="td-sclass">
												<input type="text" name="mif_no" class="form-control">
											</td>
										</tr>
										<tr>
											<td class="td-sclass"><label for="mreqf_no">MReqF No.:</label></td>
											<td class="td-sclass">
												<input type="text" name="mreqf_no" class="form-control">
											</td>
										</tr>
										
										<tr>
											<td class="td-sclass"><label for="pr">PR/Warehouse Stock:</label></td>
											<td class="td-sclass">
												<select class="form-control" name="type">
													<option value="">--Select Type--</option>
													<option value="JO / PR">JO / PR</option>
													<option value="Warehouse Stocks">Warehouse Stocks</option>
												</select>
											</td>
										</tr>
										<tr>
											<td class="td-sclass"><label for="pr">PR No:</label></td>
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
								<input type="hidden" name="baseurl" id="baseurl" value="">
							</form>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
					<div class="row" style="padding:0px 10px 0px 10px">
							<?php 
								if(!empty($_POST)){
								
									?>
									
									<div class='alert alert-warning alert-shake'>
										<center>
											<strong>Filters applied:</strong> <?php echo  $filter; ?>.
											<a href='<?php echo base_url(); ?>index.php/issue/view_issue' class='remove_filter alert-link'>Remove Filters</a>. 
										</center>
									</div>
							<?php  }?>
						</div>
						<div class="row" style="padding:0px 10px 0px 10px">
						</div>
						<table class="table-bordered table-hover" id="received" width="100%" style="font-size: 15px">
							<thead>
								<tr>
									<td width="15%" align="center"><strong>Date / Time</strong></td>
									<td width="29%" align="center"><strong>MIF No.</strong></td>
									<td width="29%" align="center"><strong>MReqF No.</strong></td>
									<td width="15%" align="center"><strong>PR / JO #</strong></td>
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
									<td align="center"><?php echo $list['date'];?> / <?php echo $list['time'];?></td>
									<td align="center"><?php echo $list['mifno'];?></td>
									<td align="center"><?php echo $list['mreqf'];?></td>
									<td align="center"><?php echo (($list['type'] == 'JO / PR') ? $list['prno'] :  $list['type']); ?></td>
									<td align="center"><?php echo $list['department'];?></td>
									<td align="center"><?php echo $list['purpose'];?></td>
									<td align="center"><?php echo $list['enduse'];?></td>
									<td align="center">
										<!-- <?php if($_SESSION['user_id'] == '5'){ ?>
										<a class="btn btn-info btn-xs" data-toggle="modal" data-target="#updatePR" id = 'getEP' data-id="<?php echo $list['issuance_id']; ?>" title="Update Purpose & Enduse">
											<span class="fa fa-pencil"></span>
										</a>	
										<?php } ?> -->									
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