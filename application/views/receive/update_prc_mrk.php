<body style="padding:0px 10px">	
<form method='POST' action="<?php echo base_url(); ?>index.php/receive/edit_prc_mrk">
<?php foreach($rem as $r){ ?>
	<div class="border-class shadow" style="background-color: #fff">
		<div class="container">
			<div class="row">
				<center><h4 class="pname">Update Price & Remarks</h4></center>
				
				<div class="col-lg-12">
					<!-- <p>Price:
						<input type="text" class="form-control" name="price" value = "<?php echo $r->item_cost; ?>">
					</p> -->
					<p>Remarks:
						<textarea rows="3" name = "remarks" class="form-control"><?php echo $r->remarks?></textarea>
					</p>
				</div>
				
			</div>
		</div>
	</div>
	<input type='hidden' name='id' value='<?php echo $id;?>'>
	<input class="btn btn-primary btn-md" type="submit" name="add_item" value="Submit">
<?php } ?>
</form>
</body>