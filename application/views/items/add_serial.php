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
				<form method = "POST" action = "<?php echo base_url(); ?>index.php/items/insert_serial">
					<input type="text" name="serial_no" id = "serial" class="form-control" placeholder="Serial Number" autocomplete="off">
					<span id="suggestion-serial"></span>
					<br>
					<input type="submit" name="submit" class="btn btn-warning btn-block" value="Add Serial">
					<?php foreach($test as $t){ ?>
						<input type="hidden" name="id" value="<?php echo $t->si_id;?>">
					<?php } ?>
					<input type="hidden" name="serial_id" id="serial_id">
					<input type="hidden" name="item_id" id="item_id" value="<?php echo $item_id; ?>">
					<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
				</form>	
			</div>
		</div>
	</div>
</div>
