<?php 
$con=mysqli_connect("localhost","root","","db_inventory");
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL:".mysqli_connect_error();
}

$getEmptyBrand=mysqli_query($con,"SELECT * FROM brand WHERE brand_name = '' OR brand_name IS NULL");
while($fetchEmpty = mysqli_fetch_array($getEmptyBrand)){
	$brandid= $fetchEmpty['brand_id'];
	echo $brandid."<br>";
	$update_receive = mysqli_query($con, "UPDATE receive_items SET brand_id = '' WHERE brand_id = '$brandid'");
	$update_issuance = mysqli_query($con, "UPDATE issuance_details SET brand_id = '' WHERE brand_id = '$brandid'");
	$update_request = mysqli_query($con, "UPDATE issuance_details SET brand_id = '' WHERE brand_id = '$brandid'");
	$update_request = mysqli_query($con, "UPDATE supplier_items SET brand_id = '' WHERE brand_id = '$brandid'");
}