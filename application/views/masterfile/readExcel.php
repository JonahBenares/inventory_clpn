<?php
/*require_once 'assets/js/phpexcel/Classes/PHPExcel/IOFactory.php';


$objPHPExcel = new PHPExcel();
$inputFileName ='uploads/excel/item_inventory.xlsx';
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file"'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow(); 

for($x=2;$x<=$highestRow;$x++){
	$desc = $objPHPExcel->getActiveSheet()->getCell('A'.$x)->getValue();
	$cat_id = $objPHPExcel->getActiveSheet()->getCell('B'.$x)->getValue();
	$subcat_id = $objPHPExcel->getActiveSheet()->getCell('C'.$x)->getValue();
	$prefix = $objPHPExcel->getActiveSheet()->getCell('D'.$x)->getValue();
	$unit = $objPHPExcel->getActiveSheet()->getCell('E'.$x)->getValue();
	$pn = $objPHPExcel->getActiveSheet()->getCell('F'.$x)->getValue();


}*/
echo $highestRow;
?>