<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/item.js"></script>
<style type="text/css">
	body{
		padding-top: 20px;
	}
</style>

<div class="col-md-12">
	<div class="panel panel-default shadow">
		<div class="panel-heading" style="height:20px">
		</div>
		<div class="panel-body">
			<div class="canvas-wrapper">
				<form method = "POST" action = "<?php echo base_url(); ?>index.php/items/edit_brand">
					<?php foreach($supplier as $sup){ ?>
					<input type="text" name="catno" class="form-control" placeholder="Catalog No." value = "<?php echo $sup['cat_no'];?>" autocomplete="off">
					<br>
					<input type="text" name="brand" id = "brand" class="form-control" placeholder="Brand" value = "<?php echo $sup['brand'];?>" autocomplete="off">
					<span id="suggestion-brand"></span>
					<br> 
					<?php } ?>
					<input type="hidden" name="brand_id" id="brandid">
					<input type="hidden" name="siid" value = "<?php echo $siid;?>">
					<input type="hidden" name="item_id" value = "<?php echo $item_id;?>">
					<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
					<input type="submit" name="submit" class="btn btn-info btn-block" value="Update">
				</form>	
			</div>
		</div>
	</div>
</div>
