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
require_once('assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        /*$startdate = date('Y-m-d', strtotime("-7 days"));
        $now=date('Y-m-d');*/
        $startdate = '2018-08-28';
        $now = '2018-09-01';
       /* $startday=date('d', strtotime($startdate));
        $daynow=date('d');
        $monthnow=date('M');
        $yearnow=date('Y');*/
        $objPHPExcel = new PHPExcel();
        //$exportfilename="Receive_".$monthnow."_".$daynow."-".$startday."_".$yearnow.".xlsx";
     $exportfilename="Issuance.xlsx";
     
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
        $getIssue=mysqli_query($con,"SELECT * FROM issuance_head WHERE issue_date BETWEEN '$startdate' AND '$now'");
       // foreach($this->super_model->custom_query("SELECT * FROM receive_head WHERE receive_date  BETWEEN '$startdate' AND '$now' AND saved = '1'") as $head){ 
        while($head = mysqli_fetch_array($getIssue)){
            $department = select_column_where("department", "department_name", "department_id", $head['department_id']);
            $purpose = select_column_where("purpose", "purpose_desc", "purpose_id", $head['purpose_id']);
            $enduse = select_column_where("enduse", "enduse_name", "enduse_id", $head['enduse_id']); 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Department: ".$department)->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "MIF No.: ".$head['mif_no'])->getColumnDimension('B')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray1);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray3);
            $col1++;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Purpose: ".$purpose)->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "MReqF No.: ".$head['mreqf_no'])->getColumnDimension('B')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray3);
            $col1++; 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "End Use: ".$enduse)->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "Date: ".$head['issue_date'])->getColumnDimension('B')->setWidth(40);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$col1, "Time: ".$head['issue_time'])->getColumnDimension('C')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray3);
            $col1++;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "JO/PR #: ".$head['pr_no'])->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, " ")->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, " ")->getColumnDimension('B')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray3);
            $col1++;

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Item No")->getColumnDimension('A')->setWidth(40); 
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "Quantity")->getColumnDimension('B')->setWidth(30); 
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$col1, "UoM")->getColumnDimension('C')->setWidth(30); 
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$col1, "Part No.")->getColumnDimension('D')->setWidth(30); 
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$col1, "Item Description")->getColumnDimension('E')->setWidth(80);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$col1, "Brand")->getColumnDimension('F')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$col1, "Serial No.")->getColumnDimension('G')->setWidth(12);  
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$col1, "Remarks")->getColumnDimension('H')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->getFont()->setBold(true);
            $styleArray = array(
              'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray3);
            $col1++;
            $x = 1;
            $getItems = mysqli_query($con,"SELECT * FROM issuance_details WHERE issuance_id = '$head[issuance_id]'");
            while($q = mysqli_fetch_array($getItems)){
            $serial = select_column_where("serial_number", "serial_no", "serial_id", $q['serial_id']);
            $supplier = select_column_where("supplier", "supplier_name", "supplier_id", $q['supplier_id']);
            $item = select_column_where('items', 'item_name', 'item_id', $q['item_id']);
            $unitid = select_column_where('items', 'unit_id', 'item_id', $q['item_id']);
            $brand = select_column_where("brand", "brand_name", "brand_id", $q['brand_id']);
            $qty = $q['quantity'];
            $remarks = $q['remarks'];
            $pn_no = $q['pn_no'];
            $unit = select_column_where('uom', 'unit_name', 'unit_id', $unitid);
            $part = select_column_where('items', 'original_pn', 'item_id', $q['item_id']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, $x)->getColumnDimension('A')->setWidth(40); 
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, $qty)->getColumnDimension('B')->setWidth(30); 
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$col1, $unit)->getColumnDimension('C')->setWidth(20); 
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$col1, $part)->getColumnDimension('D')->setWidth(30);  
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$col1, $item)->getColumnDimension('E')->setWidth(80); 
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$col1, $brand)->getColumnDimension('F')->setWidth(12); 
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$col1, $serial)->getColumnDimension('G')->setWidth(12);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$col1, $remarks)->getColumnDimension('H')->setWidth(30);

                $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":C".$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('K'.$col1.":M".$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->protectCells('A'.$col1.":H".$col1,'admin');
                $objPHPExcel->getActiveSheet()->getStyle('B'.$col1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $styleArray = array(
                  'borders' => array(
                        'allborders' => array(
                          'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray2);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray3);
                $x++; 
                $col1++;
                /*$objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK); */
            } 
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray3); 
            $col1++;

            $getUser = mysqli_query($con,"SELECT * FROM issuance_head WHERE issuance_id = '$head[issuance_id]'");
                    while($qq = mysqli_fetch_array($getUser)){
                        $user = select_column_where('users', 'fullname', 'user_id', $qq['user_id']);
                        $released = select_column_where('employees', 'employee_name', 'employee_id', $qq['released_by']);
                        $noted = select_column_where('employees', 'employee_name', 'employee_id', $qq['noted_by']);
                        $received = select_column_where('employees', 'employee_name', 'employee_id', $qq['received_by']);

                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Prepared By: ".$user)->getColumnDimension('A')->setWidth(40);
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "Released By: ".$released)->getColumnDimension('B')->setWidth(40);
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray2);
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray3);
                        $col1++;

                        $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Receive By: ".$received)->getColumnDimension('A')->setWidth(40);
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "Noted By: ".$noted)->getColumnDimension('B')->setWidth(40);
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray2);
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->applyFromArray($styleArray3);
                        $col1++;
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":H".$col1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                    }
            $col1++; 

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