<?php 
	$connection = mysqli_connect('localhost','root','','db_inventory');
	$tables = array();
	$result = mysqli_query($connection,"SHOW TABLES");
	while($row = mysqli_fetch_row($result)){
		$tables[] = $row[0];
	}

	$return ='';
	foreach($tables as $table) {
	
		$result = mysqli_query($connection,"SELECT * FROM `".$table."`");
		//echo "SELECT * FROM ".$table."<br>";
		$num_fields = mysqli_num_fields($result);

		mysqli_query($connection,"DROP TABLE `".$table."`");
		
	}

	$filename = 'backup1.sql';
	$handle = fopen($filename,"r+");
	$contents = fread($handle,filesize($filename));

	$sql = explode(';',$contents);
	foreach ($sql as $query) {
		$result=mysqli_query($connection,$query);
		if($result){
			echo '<tr><td>'.$query.'</td></tr>';
		}
	}
	fclose($handle);
	echo 'successfully imported';
?>