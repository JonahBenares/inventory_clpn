<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Signatory</li>
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
						Signatories
						<div class="pull-right">
							<?php if($access['masterfile_add'] == 1){ ?>
							<a class=" clickable panel-toggle panel-button-tab-right shadow"  href="<?php echo base_url(); ?>index.php/masterfile/add_signatory">
								<span class="fa fa-plus"></span>
							</a>
							<?php } ?>
						</div>	
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<table class="table table-bordered table-hover" id="item_table">
								<thead>
									<tr style="font-size: 13px">
										<th style="padding:10px;" width="30%">Employee Name</th>
										<th style="padding:10px;text-align: center">Noted By</th>
										<th style="padding:10px;text-align: center">Inspected By</th>
										<th style="padding:10px;text-align: center">Delivered By</th>
										<th style="padding:10px;text-align: center">Reviewed By</th>
										<th style="padding:10px;text-align: center">Received By</th>
										<th style="padding:10px;text-align: center">Released By</th>
										<th style="padding:10px;text-align: center">Requested By</th>
										<th style="padding:10px;text-align: center">Approved By</th>		
										<th style="padding:10px;text-align: center">Acknowledge By</th>										
									</tr>
								</thead>
								<tbody>
									<?php foreach($signatory AS $sig){ ?>
									<tr>
										<td><?php echo $sig['employee']; ?></td>
										<?php if($sig['noted'] == '1'){ ?>
										<td align="center"><p style="font-size: 19px;color:green;"><span class="fa fa-check"></span></p></td>
										<?php } else { ?>
										<td align="center"><p style="font-size: 19px;color:red;"><span class=""></span></p></td>
										<?php } ?>
										<?php if($sig['inspected'] == '1'){ ?>
										<td align="center"><p style="font-size: 19px;color:green;"><span class="fa fa-check"></span></p></td>
										<?php }else{ ?>
										<td align="center"><p style="font-size: 19px;color:red;"><span class=""></span></p></td>
										<?php } ?>
										<?php if($sig['delivered'] == '1'){ ?>
										<td align="center"><p style="font-size: 19px;color:green;"><span class="fa fa-check"></span></p></td>
										<?php }else{ ?>
										<td align="center"><p style="font-size: 19px;color:red;"><span class=""></span></p></td>
										<?php } ?>
										<?php if($sig['reviewed'] == '1'){ ?>
										<td align="center"><p style="font-size: 19px;color:green;"><span class="fa fa-check"></span></p></td>
										<?php }else{ ?>
										<td align="center"><p style="font-size: 19px;color:red;"><span class=""></span></p></td>	
										<?php } ?>
										<?php if($sig['received'] == '1'){ ?>
										<td align="center"><p style="font-size: 19px;color:green;"><span class="fa fa-check"></span></p></td>
										<?php }else{ ?>
										<td align="center"><p style="font-size: 19px;color:red;"><span class=""></span></p></td>	
										<?php } ?>
										<?php if($sig['released'] == '1'){ ?>
										<td align="center"><p style="font-size: 19px;color:green;"><span class="fa fa-check"></span></p></td>
										<?php } else{ ?>
										<td align="center"><p style="font-size: 19px;color:red;"><span class=""></span></p></td>	
										<?php } ?>
										<?php if($sig['requested'] == '1'){ ?>
										<td align="center"><p style="font-size: 19px;color:green;"><span class="fa fa-check"></span></p></td>
										<?php } else{ ?>
										<td align="center"><p style="font-size: 19px;color:red;"><span class=""></span></p></td>	
										<?php } ?>
										<?php if($sig['approved'] == '1'){ ?>
										<td align="center"><p style="font-size: 19px;color:green;"><span class="fa fa-check"></span></p></td>
										<?php } else { ?>
										<td align="center"><p style="font-size: 19px;color:red;"><span class=""></span></p></td>	
										<?php } ?>
										<?php if($sig['acknowledged'] == '1'){ ?>
										<td align="center"><p style="font-size: 19px;color:green;"><span class="fa fa-check"></span></p></td>
										<?php } else { ?>
										<td align="center"><p style="font-size: 19px;color:red;"><span class=""></span></p></td>	
										<?php } ?>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>