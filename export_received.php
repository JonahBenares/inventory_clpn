<?php 
$con=mysqli_connect("localhost","root","","db_inventory");
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL:".mysqli_connect_error();
}

function select_column_where($table, $column, $where, $value){
    $con=mysqli_connect("localhost","root","","db_inventory");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL:".mysqli_connect_error();
        }
    $getCol = mysqli_query($con, "SELECT $column FROM $table WHERE $where = '$value'");
    $fetchCol = mysqli_fetch_array($getCol);
    return $fetchCol[$column];
}

require_once('C:\Users\Jonah\Dropbox\xampp\htdocs\inventory\assets\js\phpexcel\Classes\PHPExcel\IOFactory.php');
        $startdate = date('Y-m-d', strtotime("-7 days"));
        $now=date('Y-m-d');
       /* $startday=date('d', strtotime($startdate));
        $daynow=date('d');
        $monthnow=date('M');
        $yearnow=date('Y');*/
        $objPHPExcel = new PHPExcel();
        //$exportfilename="Receive_".$monthnow."_".$daynow."-".$startday."_".$yearnow.".xlsx";
        $exportfilename="Receive.xlsx";
     
        $col1 = 1;
        $row1 = 1;
       
       // echo $startdate;
        $styleArray1 = array(
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THICK),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THICK)
            )
        );
        $styleArray2 = array(
            'borders' => array(
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THICK)
            )
        );
        $styleArray3 = array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THICK)
            )
        );
        $getHead=mysqli_query($con,"SELECT * FROM receive_head WHERE receive_date  BETWEEN '$startdate' AND '$now' AND saved = '1'");
       // foreach($this->super_model->custom_query("SELECT * FROM receive_head WHERE receive_date  BETWEEN '$startdate' AND '$now' AND saved = '1'") as $head){ 
        while($head = mysqli_fetch_array($getHead)){
           
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Date: ".$head['receive_date'])->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "PO No.: ".$head['po_no'])->getColumnDimension('B')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray1);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "DR No.: ".$head['dr_no'])->getColumnDimension('A')->setWidth(40);
            if($head['pcf'] == "1"){
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "PCF: Yes")->getColumnDimension('B')->setWidth(30);
            }else {
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "PCF: ")->getColumnDimension('B')->setWidth(30);
            }
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++; 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "SI No.: ".$head['si_no'])->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, " ")->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, " ")->getColumnDimension('B')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++;

            $getDetails=mysqli_query($con,"SELECT * FROM receive_details WHERE receive_id = '$head[receive_id]'");
           /* foreach($this->super_model->custom_query("SELECT * FROM receive_details WHERE receive_id = '$head[receive_id]'") as $det){*/
            while($det = mysqli_fetch_array($getDetails)){
            /*$num1++;*/
            $purpose = select_column_where('purpose', 'purpose_desc', 'purpose_id', $det['purpose_id']);
            $enduse = select_column_where('enduse', 'enduse_name', 'enduse_id', $det['enduse_id']);     
            $department = select_column_where('department', 'department_name', 'department_id', $det['department_id']);
          /*  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row1, $col1, " ");
            $col1++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row, $col, " ");
            $col++;*/
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "PR/JO#: ".$det['pr_no']);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray1);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++; 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Department: ".$department);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++; 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "End-Use: ".$enduse);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++; 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Purpose:".$purpose);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++; 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, " ");
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++;

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Item No")->getColumnDimension('A')->setWidth(40); 
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "UoM")->getColumnDimension('B')->setWidth(30); 
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$col1, "Part No.")->getColumnDimension('C')->setWidth(20); 
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$col1, "Item Description")->getColumnDimension('D')->setWidth(80); 
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$col1, "Expected Qty.")->getColumnDimension('E')->setWidth(15); 
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$col1, "Receive Qty.")->getColumnDimension('F')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$col1, "Supplier")->getColumnDimension('G')->setWidth(30); 
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$col1, "Catalog No.")->getColumnDimension('H')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$col1, "Brand")->getColumnDimension('I')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$col1, "Serial No.")->getColumnDimension('J')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$col1, "Unit Cost")->getColumnDimension('K')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$col1, "Total Cost")->getColumnDimension('L')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$col1, "Inspected By")->getColumnDimension('M')->setWidth(20); 
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$col1, "Remarks")->getColumnDimension('N')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->getFont()->setBold(true);
            $styleArray = array(
              'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++;
            $x = 1;
            $getItems = mysqli_query($con,"SELECT * FROM receive_items WHERE rd_id = '$det[rd_id]'");
            /*foreach($this->super_model->custom_query("SELECT * FROM receive_items WHERE rd_id = '$det[rd_id]'") AS $q){*/
            while($q = mysqli_fetch_array($getItems)){
            
            $inspected_by = select_column_where("employees", "employee_name", "employee_id", $q['inspected_by']);
            $serial = select_column_where("serial_number", "serial_no", "serial_id", $q['serial_id']);
            $supplier = select_column_where("supplier", "supplier_name", "supplier_id", $q['supplier_id']);
            $item = select_column_where('items', 'item_name', 'item_id', $q['item_id']);
            $unitid = select_column_where('items', 'unit_id', 'item_id', $q['item_id']);
            $brand = select_column_where("brand", "brand_name", "brand_id", $q['brand_id']);
            $cat_no = $q['catalog_no'];
            $cost = $q['item_cost'];
            $rec_qty = $q['received_qty'];
            $expected_qty = $q['expected_qty'];
            $remarks = $q['remarks'];
            $unit = select_column_where('uom', 'unit_name', 'unit_id', $unitid);
           /* foreach($this->super_model->select_custom_where("items", "item_id = '$q[item_id]'") AS $itema){
                $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
            }*/
            $total = $rec_qty * $cost;
            $part = select_column_where('items', 'original_pn', 'item_id', $q['item_id']);
                if($q['rd_id'] == $det['rd_id']){ 
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, $x)->getColumnDimension('A')->setWidth(40); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, $unit)->getColumnDimension('B')->setWidth(30); 
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$col1, $part)->getColumnDimension('C')->setWidth(20); 
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$col1, $item)->getColumnDimension('D')->setWidth(80); 
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$col1, $expected_qty)->getColumnDimension('E')->setWidth(15); 
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$col1, $rec_qty)->getColumnDimension('F')->setWidth(12); 
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$col1, $supplier)->getColumnDimension('G')->setWidth(30); 
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$col1, $cat_no)->getColumnDimension('H')->setWidth(12); 
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$col1, $brand)->getColumnDimension('I')->setWidth(12); 
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$col1, $serial)->getColumnDimension('J')->setWidth(12); 
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$col1, $cost)->getColumnDimension('K')->setWidth(12); 
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$col1, $total)->getColumnDimension('L')->setWidth(12); 
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$col1, $inspected_by)->getColumnDimension('M')->setWidth(20); 
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$col1, $remarks)->getColumnDimension('N')->setWidth(30);

                    $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":C".$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$col1.":F".$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('K'.$col1.":M".$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                    $objPHPExcel->getActiveSheet()->protectCells('A'.$col1.":N".$col1,'admin');
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$col1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$col1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('K'.$col1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('L'.$col1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $styleArray = array(
                      'borders' => array(
                            'allborders' => array(
                              'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    );
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
                    $x++;    

                }   

                $col1++;
                 $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK); 
            }

            $col1++;

        }  
    }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$exportfilename.'"');
        readfile($exportfilename);
?>