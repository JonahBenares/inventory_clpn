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


      /* $startdate = "2019-11-16";
       $now="2019-11-24";*/
        $startdate = date('Y-m-d', strtotime("-7 days"));
        $now=date('Y-m-d');
        $startday=date('d', strtotime($startdate));
        $daynow=date('d');
        $monthnow=date('M');
        $yearnow=date('Y');
        $to='ericjabiniar2015@yahoo.com, mba_energreen2013@gmail.com, maylen_cenpri@yahoo.com.ph, kervic.cenpri@gmail.com, merrydioso.energreen@gmail.com, donna7.cenpri@gmail.com ,jonahbenares.cenpri@gmail.com, hezielaplaon.cenpri@gmail.com, cristycesar.cenpri@gmail.com, rdestacamento.cenpri@gmail.com';
        // $to='jasonflor.cenpri@gmail.com';
        // $to='donna7.cenpri@gmail.com'; 
        // $to='creiramirez.cenpri@gmail.com, ericjabiniar2015@yahoo.com, mba_energreen2013@yahoo.com, maylen_cenpri@yahoo.com.ph, kervic.cenpri@gmail.com, merrydioso.energreen@gmail.com';
        //$to='creiramirez.cenpri@gmail.com';
        // $to='stephineseverino.cenpri@gmail.com';

        //$subject="Inventory Issuance Report: Nov 16-24 2019 (Final)";
         $subject="Inventory Issuance Report: ".$monthnow." ".$startday."-".$daynow." ".$yearnow;
     
        $col1 = 1;
        $row1 = 1;
       
        $message="";
         $message.="Inventory Issuance Report: ".$monthnow." ".$startday."-".$daynow." ".$yearnow."<br><br>";
        //$message.="Inventory Issuance Report: Nov 16-24 2019 <br><br>";
        $getHead=mysqli_query($con,"SELECT * FROM issuance_head WHERE issue_date  BETWEEN '$startdate' AND '$now'");
        while($head = mysqli_fetch_array($getHead)){
            $department = select_column_where("department", "department_name", "department_id", $head['department_id']);
            $purpose = select_column_where("purpose", "purpose_desc", "purpose_id", $head['purpose_id']);
            $enduse = select_column_where("enduse", "enduse_name", "enduse_id", $head['enduse_id']);
            $message.="<div style='border:2px solid;font-size:10px'>";
            $message.="<table style='width:100%; border-collapse:collapse;font-size:10px'>";
            $message.="<tr>";
            $message.="<td style='width:7%'>PR / JO #: </td><td style='width:63%'>".$head['pr_no']."</td>";
            $message.="<td style=''>MIF No.: </td><td style=''>".$head['mif_no']."</td>";
            $message.="</tr>";
            $message.="<tr>";
            $message.="<td style=''>Department: </td><td style=''>".$department."</td>";
            $message.="<td>MreqF No.:</td><td>".$head['mreqf_no']."</td>";
            $message.="</tr>";

            $message.="<tr>";
            $message.="<td>Purpose:</td><td>".$purpose."</td>";
            $message.="<td>Date:</td><td>".$head['issue_date']."</td>";
            $message.="<td style = ''>Time:</td><td>".$head['issue_time']."</td>";
            $message.="</tr>";

            $message.="<tr>";
            $message.="<td>End Use:</td><td>".$enduse."</td>";
            
            
            $message.="</tr><tr>";
            $message.="<tr>";
            $message.="<td colspan='14' style='height:15px'></td>";
            $message.="</tr>";
            $message.="</table>";
            
            $message.="<table style='width:100%; border-collapse:collapse;font-size:10px'>";
            $message.="<td style='border:1px solid'><strong>Item No</strong></td>";
            $message.="<td style='border:1px solid; width:30px'><strong>Quantity</strong></td>";
            /*$message.="<td style='border:1px solid; width:30px'><strong>Unit Cost</strong></td>";
            $message.="<td style='border:1px solid; width:30px'><strong>Total Cost</strong></td>";*/
            $message.="<td style='border:1px solid; width:30px'><strong>UoM</strong></td>";
            $message.="<td style='border:1px solid'><strong>Part No</strong></td>";
            $message.="<td style='border:1px solid'><strong>Item Description</strong></td>";
            $message.="<td style='border:1px solid'><strong>Supplier</strong></td>";
            $message.="<td style='border:1px solid'><strong>Brand</strong></td>";
            $message.="<td style='border:1px solid'><strong>Serial No</strong></td>";
            $message.="<td style='border:1px solid'><strong>Remarks</strong></td>";
            $message.="</tr>";
            $x = 1;
            $getDetails = mysqli_query($con,"SELECT * FROM issuance_details WHERE issuance_id = '$head[issuance_id]'");
            while($q = mysqli_fetch_array($getDetails)){
            $serial = select_column_where("serial_number", "serial_no", "serial_id", $q['serial_id']);
            $supplier = select_column_where("supplier", "supplier_name", "supplier_id", $q['supplier_id']);
            $item = select_column_where('items', 'item_name', 'item_id', $q['item_id']);
            $unitid = select_column_where('items', 'unit_id', 'item_id', $q['item_id']);
            $brand = select_column_where("brand", "brand_name", "brand_id", $q['brand_id']);
            $price = select_column_where("request_items", "unit_cost", "rq_id", $q['rq_id']);
            $qty = $q['quantity'];
            $total_cost = $price * $qty;
            $remarks = $q['remarks'];
            $pn_no = $q['pn_no'];
            $unit = select_column_where('uom', 'unit_name', 'unit_id', $unitid);
            $part = select_column_where('items', 'original_pn', 'item_id', $q['item_id']);
            $message.="<tr>";
            $message.="<td style='border:1px solid'>".$x."</td>";
            $message.="<td style='border:1px solid;'>".$qty."</td>"; 
            /*$message.="<td style='border:1px solid;'>".number_format($price,2)."</td>"; 
            $message.="<td style='border:1px solid;'>".number_format($total_cost,2)."</td>";*/ 
            $message.="<td style='border:1px solid'>".$unit."</td>";
            $message.="<td style='border:1px solid'>".$part."</td>";
            $message.="<td style='border:1px solid'>".$item."</td>";
            $message.="<td style='border:1px solid'>".$supplier."</td>";
            $message.="<td style='border:1px solid'>".$brand."</td>"; 
            $message.="<td style='border:1px solid'>".$serial."</td>"; 
            $message.="<td style='border:1px solid'>".$remarks."</td>";
            $message.="</tr>";
            $x++;   
        }
        $message.="<tr>";
        $message.="<td colspan='14' style='height:15px'></td>";
        $message.="</tr>";
        $message.="</table></div><br>";  
    }
    /*echo $message;*/
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <jonah.narazo@gmail.com>' . "\r\n";
    var_dump(mail($to,$subject,$message,$headers));
?>