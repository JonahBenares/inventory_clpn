<body class="body-login">
	<div class="container-fluid">
		<div style="margin-top: 50px">
			<div class = "row">
				<div class="col-lg-4 col-md-3 col-sm-2"></div>
				<div class="col-lg-4 col-md-3 col-sm-2">
					<?php
		              	$error_msg= $this->session->flashdata('error_msg');  
		            ?>
		           	<?php 
		              	if($error_msg){
		            ?>
		                <div class="alert alert-danger alert-shake">
		                	<center><?php echo $error_msg; ?></center>	                  
		                </div>
					<?php } ?>
				</div>
				<div class="col-lg-4 col-md-3 col-sm-2"></div>				
			</div>	
			<div class="row">
				<div class="col-lg-4 col-md-3 col-sm-2"></div>
				<div class="col-lg-4 col-md-6 col-sm-8">
					<div class="panel-login panel-default">					
							<div class="panel-body">
								<div class="canvas-wrapper">
								<center>
									<label>WAREHOUSE INVENTORY SYSTEM</label>
								</center>
								<hr style="margin:0px">								
								<form method = "POST" action="<?php echo base_url(); ?>index.php/masterfile/login_process">
									<h3 class="h3-login" >USERNAME:</h3>
									<input class="form-control form-control-login" type="text" name="username" >
									<h3 class="h3-login">PASSWORD:</h3>
									<input class="form-control form-control-login" type="password" name="password">
									<center>
										<br>
										<button type = "submit" class="btn btn-warning " style="width:50%">LOGIN</button>
									</center>
								</form>
								
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-3 col-sm-2"></div>
			</div>
		</div>
	</div>
	<br>
	<br>