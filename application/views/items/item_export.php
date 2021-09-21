<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/item.js"></script>
<style>
/* The contener */
.contener {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 15px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default radio button */
.contener input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.contener:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.contener input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the indicator (dot/circle) when checked */
.contener input:checked ~ .checkmark:after {
    display: block;
}

/* Style the indicator (dot/circle) */
.contener .checkmark:after {
 	top: 9px;
	left: 9px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}
</style>
<body style="padding-top:20px">
	<div class="col-md-12">
		<div class="panel panel-default shadow">
			<div class="panel-body">
				<div class="canvas-wrapper">
					<center>
						<h3 style="margin: 0px">Filter</h3>
					</center>
					<hr>
					<form>
						<table width="100%">
							<tr>
								<td width="20%">Category:</td>
								<td width="80%" colspan="2">
									<select name="category" class="form-control" id="category" onChange="chooseCategory();">
										<option value="" selected="">-Category-</option>
										<?php foreach($category AS $cat){ ?>
											<option value="<?php echo $cat->cat_id; ?>"><?php echo $cat->cat_name; ?></option>
										<?php } ?>
									</select>
								</td>
								<td></td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<td>Sub Cat:</td>
								<td colspan="2">
									<select name="subcat" class="form-control" id="subcat">
									</select>
								</td>
								<td></td>
							</tr>
							<tr><td><br></td></tr>
							<tr>
								<td></td>
								<td>
									<label class="contener">Local
									  <input type="radio" checked="checked" name="local_mnl" value='1'>
									  <span class="checkmark"></span>
									</label>
								</td>
								<td>
									<label class="contener">Manila
									  <input type="radio" name="local_mnl" value='2'>
									  <span class="checkmark"></span>
									</label>
								</td>
							</tr>
						</table>
						<br>
						<button class="btn btn-primary btn-md" style="width: 100%">Export</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
<input type='hidden' name='baseurl' id='baseurl' value="<?php echo base_url(); ?>">
