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


        $startdate = date('Y-m-d', strtotime("-7 days"));
        $now=date('Y-m-d');
        /*$startdate = "2019-11-16";
        $now="2019-11-24";
*/
        $startday=date('d', strtotime($startdate));
        $daynow=date('d');
        $monthnow=date('M');
        $yearnow=date('Y');
       // $objPHPExcel = new PHPExcel();
        // $to='jasonflor.cenpri@gmail.com';
        $to='ericjabiniar2015@yahoo.com, mba_energreen2013@gmail.com, maylen_cenpri@yahoo.com.ph, kervic.cenpri@gmail.com, merrydioso.energreen@gmail.com, donna7.cenpri@gmail.com ,jonahbenares.cenpri@gmail.com, hezielaplaon.cenpri@gmail.com, cristycesar.cenpri@gmail.com, rdestacamento.cenpri@gmail.com';
        //$to='stephineseverino.cenpri@gmail.com, jonahbenares.cenpri@gmail.com';
        // $to='creiramirez.cenpri@gmail.com, ericjabiniar2015@yahoo.com, mba_energreen2013@yahoo.com, maylen_cenpri@yahoo.com.ph, kervic.cenpri@gmail.com, merrydioso.energreen@gmail.com';
        $subject="Inventory Receive Report: ".$monthnow." ".$startday."-".$daynow." ".$yearnow;
        // .$monthnow." ".$startday."-".$daynow." ".$yearnow;
      
     
        $col1 = 1;
        $row1 = 1;
       
        $message='';
        $message.="Inventory Receive Report: ". $monthnow." ".$startday."-".$daynow." ".$yearnow."<br><br>";
        // .$monthnow." ".$startday."-".$daynow." ".$yearnow."<br><br>";
        $getHead=mysqli_query($con,"SELECT * FROM receive_head WHERE receive_date BETWEEN '$startdate' AND '$now' AND saved = '1' ORDER BY receive_date ASC");
     
        while($head = mysqli_fetch_array($getHead)){
            $message.="<div style='border:2px solid; font-size:10px'>";
            
            $message.="<table style='width:100%; border-collapse:collapse; font-size:10px'>";
            $message.="<tr>";
            $message.="<td style='width:7%'>Date:</td><td style='width:53%'>".$head['receive_date']."</td>";
            $message.="<td style='width:10px'></td>";

            $message.="<td style='width:7%' >PO No.:</td><td>".$head['po_no']."</td>";
            $message.="</tr><tr>";

            $message.="<td>DR No.: </td><td>".$head['dr_no']."</td>";
            $message.="<td style='width:10px'></td>";
            if($head['pcf'] == "1"){
                $message.="<td>PCF:</td><td>Yes</td>";
            }else {
                $message.="<td>PCF:</td><td></td>";
            }
            $message.="</tr><tr>";
            $message.="<td>SI No.: </td><td>".$head['si_no']."</td>";
            $message.="</tr><tr>";
             $message.="<td colspan='4' style='height:10px'></td>";
            $message.="</tr>";
            $message.="</table>";
            $getDetails=mysqli_query($con,"SELECT * FROM receive_details WHERE receive_id = '$head[receive_id]'");
          
            while($det = mysqli_fetch_array($getDetails)){
          
            $purpose = select_column_where('purpose', 'purpose_desc', 'purpose_id', $det['purpose_id']);
            $enduse = select_column_where('enduse', 'enduse_name', 'enduse_id', $det['enduse_id']);     
            $department = select_column_where('department', 'department_name', 'department_id', $det['department_id']);

            $message.="<table style='width:100%; border-collapse:collapse; font-size:10px'>";
            $message.="<td style='width:7%'>PR/JO#: </td><td style='width:53%'>".$det['pr_no']."</td>";
            $message.="<td style='width:10px'></td>";
            $message.="</tr><tr>";
            $message.="<td  style='width:80px'>Department: </td><td style='width:200px'>".$department."</td>";
            $message.="</tr><tr>";
            $message.="<td>Purpose: </td><td>".$purpose."</td>";
            $message.="</tr><tr>";
            $message.="<td style='width:100px'>End-Use: </td><td style='width:300px'>".$enduse."</td>";
            $message.="</tr><tr>";
            $message.="<td colspan='4' style='height:10px'></td>";
            $message.="</tr>";
            $message.="</table>";

            $message.="<table style='border-collapse:collapse; width:100%; font-size:10px'>";
            $message.="<tr>";
            $message.="<td style='border:1px solid;width:1%'><strong>Item No</strong></td>";
            $message.="<td style='border:1px solid;width:7%'><strong>Part No</strong></td>";
            $message.="<td style='border:1px solid;width:21%'><strong>Item Description</strong></td>";
            $message.="<td style='border:1px solid;width:5%'><strong>Expected Qty</strong></td>";
            $message.="<td style='border:1px solid;width:5%'><strong>Receive Qty</strong></td>";
            $message.="<td style='border:1px solid;width:1%'><strong>UoM</strong></td>";            
            $message.="<td style='border:1px solid;width:20%'><strong>Supplier</strong></td>";

            $message.="<td style='border:1px solid;width:5%'><strong>Catalog No</strong></td>";
            $message.="<td style='border:1px solid;width:5%'><strong>Brand</strong></td>";
            $message.="<td style='border:1px solid;width:5%'><strong>Serial No</strong></td>";
            $message.="<td style='border:1px solid;width:5%'><strong>Unit Cost</strong></td>";
            $message.="<td style='border:1px solid;width:5%'><strong>Total Cost</strong></td>"; 
            $message.="<td style='border:1px solid;width:5%'><strong>Inspected By</strong></td>";
            $message.="<td style='border:1px solid;width:10%'><strong>Remarks</strong></td>";
          
            $message.="</tr>";
            $x=1;
            $getItems = mysqli_query($con,"SELECT * FROM receive_items WHERE rd_id = '$det[rd_id]'");
           
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
               
                $total = $rec_qty * $cost;
                $part = select_column_where('items', 'original_pn', 'item_id', $q['item_id']);
                if($q['rd_id'] == $det['rd_id']){ 
                    $message.="<tr>";
                    $message.="<td style='border:1px solid'>".$x."</td>";
                    $message.="<td style='border:1px solid'>".$part."</td>";
                    $message.="<td style='border:1px solid'>".$item."</td>";
                    $message.="<td style='border:1px solid'>".$expected_qty."</td>";
                    $message.="<td style='border:1px solid'>".$rec_qty."</td>";
                    $message.="<td style='border:1px solid;'>".$unit."</td>";                     
                    $message.="<td style='border:1px solid'>".$supplier."</td>";
                    $message.="<td style='border:1px solid'>".$cat_no."</td>"; 
                    $message.="<td style='border:1px solid'>".$brand."</td>";
                    $message.="<td style='border:1px solid'>".$serial."</td>"; 
                    $message.="<td style='border:1px solid'>".$cost."</td>"; 
                    $message.="<td style='border:1px solid'>".$total."</td>"; 
                    $message.="<td style='border:1px solid'>".$inspected_by."</td>"; 
                    $message.="<td style='border:1px solid'>".$remarks."</td>";

                    $message.="</tr>";
                    $x++;    

                }   

               
              /*  $col1++;
                 $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK); */
            }
                $message.="<tr>";
                $message.="<td colspan='14' style='height:15px'></td>";
                $message.="</tr></table>";

                $col1++;

            }  
            $message.="</div><br>";
        }
   
   // echo $message;

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <jonah.narazo@gmail.com>' . "\r\n";
var_dump(mail($to,$subject,$message,$headers));
?>