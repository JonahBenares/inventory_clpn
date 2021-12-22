<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gatepass extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');

        date_default_timezone_set("Asia/Manila");
        $this->load->model('super_model');
        $this->dropdown['department'] = $this->super_model->select_all_order_by('department', 'department_name', 'ASC');
        $this->dropdown['purpose'] = $this->super_model->select_all_order_by('purpose', 'purpose_desc', 'ASC');
        $this->dropdown['enduse'] = $this->super_model->select_all_order_by('enduse', 'enduse_name', 'ASC');
        $this->dropdown['employee'] = $this->super_model->select_all_order_by('employees', 'employee_name', 'ASC');
         $this->dropdown['supplier'] = $this->super_model->select_all_order_by('supplier', 'supplier_name', 'ASC');
        $this->dropdown['pr_list']=$this->super_model->custom_query("SELECT pr_no, enduse_id, purpose_id,department_id FROM receive_head INNER JOIN receive_details WHERE saved='1' GROUP BY pr_no");
        if(isset($_SESSION['user_id'])){
            $sessionid= $_SESSION['user_id'];
          
            foreach($this->super_model->get_table_columns("access_rights") AS $col){
                $this->access[$col]=$this->super_model->select_column_where("access_rights",$col, "user_id", $sessionid);
                $this->dropdown[$col]=$this->super_model->select_column_where("access_rights",$col, "user_id", $sessionid);
            }
        }
      
        foreach($this->super_model->select_custom_where_group("receive_details", "closed=0", "pr_no") AS $dtls){
            foreach($this->super_model->select_custom_where("receive_head", "receive_id = '$dtls->receive_id'") AS $gt){
               if($gt->saved=='1'){
                    $this->dropdown['prno'][] = $dtls->pr_no;
               }
            }  
        }
       
        function arrayToObject($array){
            if(!is_array($array)) { return $array; }
            $object = new stdClass();
            if (is_array($array) && count($array) > 0) {
                foreach ($array as $name=>$value) {
                    $name = strtolower(trim($name));
                    if (!empty($name)) { $object->$name = arrayToObject($value); }
                }
                return $object;
            } else {
                return false;
            }
        }
    }

    public function slash_replace($query){
        $search = ["/", " / "];
        $replace   = ["_"];
        return str_replace($search, $replace, $query);
    }

    public function slash_unreplace($query){
        $search = ["_"];
        $replace   = ["/", " / "];
        return str_replace($search, $replace, $query);
    }

    public function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

        

        public function filter_gatepass(){
           if(!empty($this->input->post('from'))){
                $from = $this->input->post('from');
           } else {
                $from = "null";
           }

           if(!empty($this->input->post('to'))){
                $to = $this->input->post('to');
           } else {
                $to = "null";
           }
           ?>
           <script>
            window.location.href ='<?php echo base_url(); ?>index.php/gatepass/gatepass_list/<?php echo $from; ?>/<?php echo $to; ?>/'</script> <?php
    }

        public function filter_completed_gatepass_items(){
           if(!empty($this->input->post('from'))){
                $from = $this->input->post('from');
           } else {
                $from = "null";
           }

           if(!empty($this->input->post('to'))){
                $to = $this->input->post('to');
           } else {
                $to = "null";
           }
           ?>
           <script>
            window.location.href ='<?php echo base_url(); ?>index.php/gatepass/completed_gatepass_items/<?php echo $from; ?>/<?php echo $to; ?>/'</script> <?php
    }

        public function filter_incomplete_gatepass_items(){
           if(!empty($this->input->post('from'))){
                $from = $this->input->post('from');
           } else {
                $from = "null";
           }

           if(!empty($this->input->post('to'))){
                $to = $this->input->post('to');
           } else {
                $to = "null";
           }
           ?>
           <script>
            window.location.href ='<?php echo base_url(); ?>index.php/gatepass/incomplete_gatepass_items/<?php echo $from; ?>/<?php echo $to; ?>/'</script> <?php
    }

    public function gatepass_list(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $data['from']=$this->uri->segment(3);
        $data['to']=$this->uri->segment(4);
        $sql="";
        if($from!='null' && $to!='null' || $from!='' && $to!=''){
           $sql.= " WHERE date_issued BETWEEN '$from' AND '$to' AND";
        }

        if($from!='' && $to!=''){
            $query=substr($sql,0,-3);
        }else{
            $query='';
        }

        $rows= $this->super_model->count_custom_query("SELECT * FROM gatepass_head ".$query);
        if($rows!=0){
        foreach($this->super_model->custom_query("SELECT * FROM gatepass_head ".$query) AS $gatepass){
        $gd_id = $this->super_model->select_column_where("gatepass_details", "gd_id", "gatepass_id", $gatepass->gatepass_id);
        $total_quantity = $this->super_model->select_sum_where("gatepass_details", "quantity","gatepass_id='$gatepass->gatepass_id' AND type!='Non-Returnable'");
        $total_returned = $this->super_model->select_sum_where("gp_returned_history", "qty", "gatepass_id='$gatepass->gatepass_id'");
        $type = $this->super_model->select_column_where("gatepass_details", "type", "gd_id", $gatepass->gatepass_id);
        if($total_returned==$total_quantity){
            $status = "Completed";
            } else {
            $status = "Incomplete";
            }

            $data['gatepass'][] = array(
                'gatepassid'=>$gatepass->gatepass_id,
                'mgp_no'=>$gatepass->mgp_no,
                'destination'=>$gatepass->destination,
                'vehicle_no'=>$gatepass->vehicle_no,
                'date_issued'=>$gatepass->date_issued,
                'company'=>$gatepass->company,
                'type'=>$type,
                'status'=>$status,
            );
        }
        } else {
            $data['gatepass']=array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('gatepass/gatepass_list',$data);
        $this->load->view('template/footer');
    }

    public function completed_gatepass_items(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $data['from']=$this->uri->segment(3);
        $data['to']=$this->uri->segment(4);
        $data['filt']='';
        $sql="";
        if($from!='null' && $to!='null' || $from!='' && $to!=''){
           $sql.= " WHERE gh.date_issued BETWEEN '$from' AND '$to' AND";
        }

        if($from!='' && $to!=''){
            $query=substr($sql,0,-3);
        }else{
            $query='';
        }
        
        $rows= $this->super_model->count_custom_query("SELECT gh.*, gd.* FROM gatepass_head gh INNER JOIN gatepass_details gd ON gh.gatepass_id = gd.gatepass_id ".$query);
        if($rows!=0){
        foreach($this->super_model->custom_query("SELECT gh.*, gd.* FROM gatepass_head gh INNER JOIN gatepass_details gd ON gh.gatepass_id = gd.gatepass_id ".$query) AS $gatepass_items){
            $returned_date = $this->super_model->select_column_where("gp_returned_history", "date_returned", "gd_id", $gatepass_items->gd_id);
            $returned_qty = $this->super_model->select_column_where("gp_returned_history", "qty", "gd_id", $gatepass_items->gd_id);
            $returned_remarks = $this->super_model->select_column_where("gp_returned_history", "remarks", "gd_id", $gatepass_items->gd_id);
            $sum_qty = $this->super_model->select_sum_where("gp_returned_history", "qty", "gd_id='$gatepass_items->gd_id'");
             if($sum_qty==$gatepass_items->quantity){
                 $status = "Completed";
            } else {
                $status = "Incomplete";
            }

            $history='';
            foreach($this->super_model->select_row_where("gp_returned_history","gd_id",$gatepass_items->gd_id) AS $ret){
                if($gatepass_items->type=='Non-Returnable'){
                    $history.=$gatepass_items->type;
                } else if($gatepass_items->type=='Returnable' &&  $sum_qty==0 ){
                    $history.='';
                } else if($gatepass_items->type=='Returnable' &&  $sum_qty!=0){
                    $history.="Date: ".$returned_date."<br>Qty: ".$returned_qty."<br><br>";
                }
            }
            if($status=='Completed' OR $gatepass_items->type=='Non-Returnable'){
                $data['completed_items'][] = array(
                    'gd_id'=>$gatepass_items->gd_id,
                    'gatepass_id'=>$gatepass_items->gatepass_id,
                    'item_name'=>$gatepass_items->item_name,
                    'quantity'=>$gatepass_items->quantity,
                    'unit'=>$gatepass_items->unit,
                    'type'=>$gatepass_items->type,
                    'remarks'=>$gatepass_items->remarks,
                    'type'=>$gatepass_items->type,
                    'mgp_no'=>$gatepass_items->mgp_no,
                    'destination'=>$gatepass_items->destination,
                    'date_issued'=>$gatepass_items->date_issued,
                    'sum_qty'=>$sum_qty,
                    'status'=>$status,
                    'returned_date'=>$returned_date,
                    'returned_qty'=>$returned_qty,
                    'returned_remarks'=>$returned_remarks,
                    'history'=>$history,

                );
            }
        }
 
        } else {
            $data['completed_items']=array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('gatepass/completed_gatepass_items',$data);
        $this->load->view('template/footer');
    }

    public function incomplete_gatepass_items(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $data['from']=$this->uri->segment(3);
        $data['to']=$this->uri->segment(4);
        $data['filt']='';
        $sql="";
        if($from!='null' && $to!='null' || $from!='' && $to!=''){
           $sql.= " WHERE gh.date_issued BETWEEN '$from' AND '$to' AND";
        }

        if($from!='' && $to!=''){
            $query=substr($sql,0,-3);
        }else{
            $query='';
        }
        
        $rows= $this->super_model->count_custom_query("SELECT gh.*, gd.* FROM gatepass_head gh INNER JOIN gatepass_details gd ON gh.gatepass_id = gd.gatepass_id ".$query);
        if($rows!=0){
        foreach($this->super_model->custom_query("SELECT gh.*, gd.* FROM gatepass_head gh INNER JOIN gatepass_details gd ON gh.gatepass_id = gd.gatepass_id ".$query) AS $gatepass_items){
            $returned_date = $this->super_model->select_column_where("gp_returned_history", "date_returned", "gd_id", $gatepass_items->gd_id);
            $returned_qty = $this->super_model->select_column_where("gp_returned_history", "qty", "gd_id", $gatepass_items->gd_id);
            $returned_remarks = $this->super_model->select_column_where("gp_returned_history", "remarks", "gd_id", $gatepass_items->gd_id);
            $sum_qty = $this->super_model->select_sum_where("gp_returned_history", "qty", "gd_id='$gatepass_items->gd_id'");
            $balance=$gatepass_items->quantity-$sum_qty;
            if($sum_qty==$gatepass_items->quantity){
             $status = "Completed";
            } else {
            $status = "Incomplete";
             }

            $history='';
            foreach($this->super_model->select_row_where("gp_returned_history","gd_id",$gatepass_items->gd_id) AS $ret){
                if($gatepass_items->type=='Non-Returnable'){
                    $history.=$gatepass_items->type;
                } else if($gatepass_items->type=='Returnable' &&  $sum_qty==0 ){
                    $history.='';
                } else if($gatepass_items->type=='Returnable' &&  $sum_qty!=0){
                    $history.="Date: ".$returned_date."<br>Qty: ".$returned_qty."<br><br>";
                }
            }
            if($status=="Incomplete" AND $gatepass_items->type!='Non-Returnable'){
                $data['incomplete_items'][] = array(
                    'gd_id'=>$gatepass_items->gd_id,
                    'gatepass_id'=>$gatepass_items->gatepass_id,
                    'item_name'=>$gatepass_items->item_name,
                    'quantity'=>$gatepass_items->quantity,
                    'unit'=>$gatepass_items->unit,
                    'type'=>$gatepass_items->type,
                    'remarks'=>$gatepass_items->remarks,
                    'type'=>$gatepass_items->type,
                    'mgp_no'=>$gatepass_items->mgp_no,
                    'destination'=>$gatepass_items->destination,
                    'date_issued'=>$gatepass_items->date_issued,
                    'sum_qty'=>$sum_qty,
                    'status'=>$status,
                    'returned_date'=>$returned_date,
                    'returned_qty'=>$returned_qty,
                    'returned_remarks'=>$returned_remarks,
                    'balance'=>$balance,
                    'history'=>$history,

                );
            }
        }
 
        } else {
            $data['incomplete_items']=array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('gatepass/incomplete_gatepass_items',$data);
        $this->load->view('template/footer');
    }

    public function view_history(){  
        $id=$this->uri->segment(3);
      
        $data['returned'] = $this->super_model->select_row_where("gp_returned_history","gd_id",$id);
        $this->load->view('template/header');
        $this->load->view('gatepass/view_history',$data);
    }

        public function export_completed_gatepass(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $data['from']=$this->uri->segment(3);
        $data['to']=$this->uri->segment(4);
        $sql="";
        if($from!='null' && $to!='null' || $from!='' && $to!=''){
           $sql.= " WHERE gh.date_issued BETWEEN '$from' AND '$to' AND";
        }

        if($from!='' && $to!=''){
            $query=substr($sql,0,-3);
        }else{
            $query='';
        }
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="Materials Gatepass Report.xlsx";

        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(35);
        $objDrawing->setCoordinates('A2');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Date Issued");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "U/M");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', "Quantity");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "Remaining Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', "Total Returned Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', "Remarks");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', "Type");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', "MGP No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', "Destination");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', "Returned History");
        $num=2;

        $x = 1;
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        foreach($this->super_model->custom_query("SELECT gh.*, gd.* FROM gatepass_head gh INNER JOIN gatepass_details gd ON gh.gatepass_id = gd.gatepass_id ".$query) AS $gatepass_items){
            $returned_date = $this->super_model->select_column_where("gp_returned_history", "date_returned", "gp_rh_id", $gatepass_items->gatepass_id);
            $returned_qty = $this->super_model->select_column_where("gp_returned_history", "qty", "gp_rh_id", $gatepass_items->gatepass_id);
            $total_qty = $this->super_model->select_sum_where("gatepass_details", "quantity", "gd_id='$gatepass_items->gd_id'");
            $sum_qty = $this->super_model->select_sum_where("gp_returned_history", "qty", "gd_id='$gatepass_items->gd_id'");
            $balance=$total_qty-$sum_qty;
            if($sum_qty==$gatepass_items->quantity){
             $status = "Completed";
            } else {
            $status = "Incomplete";
             }

            if($status=="Completed"){
            $history='';
            foreach($this->super_model->select_row_where("gp_returned_history","gd_id",$gatepass_items->gd_id) AS $ret){
                if($gatepass_items->type=='Non-Returnable'){
                    $history.=$gatepass_items->type;
                } else if($gatepass_items->type=='Returnable' &&  $sum_qty==0 ){
                    $history.='';
                } else if($gatepass_items->type=='Returnable' &&  $sum_qty!=0){
                    $history.="Date: ".$ret->date_returned." \n\n Qty: ".$ret->qty."\n\n";
                }
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $gatepass_items->date_issued);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num, $gatepass_items->item_name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $gatepass_items->unit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $gatepass_items->quantity);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $balance);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$num, $sum_qty);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$num, $gatepass_items->remarks);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $gatepass_items->type);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $gatepass_items->mgp_no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$num, $gatepass_items->destination);
            if($gatepass_items->type=='Non-Returnable'){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$num, $gatepass_items->type);
            }else{
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$num, $history);
            }
            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
            $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":W".$num)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$num.":J".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$num.":L".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $num++;
            $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$num.":B".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('C1:E1');
            $objPHPExcel->getActiveSheet()->mergeCells('C'.$num.":E".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('H1:J1');
            $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":J".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('K1:L1');
            $objPHPExcel->getActiveSheet()->mergeCells('K'.$num.":L".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('M1:O1');
            $objPHPExcel->getActiveSheet()->mergeCells('M'.$num.":O".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('P1:Q1');
            $objPHPExcel->getActiveSheet()->mergeCells('P'.$num.":Q".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('S1:T1');
            $objPHPExcel->getActiveSheet()->mergeCells('S'.$num.":T".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('U1:W1');
            $objPHPExcel->getActiveSheet()->mergeCells('U'.$num.":W".$num);
            $objPHPExcel->getActiveSheet()->getStyle('U'.$num.":W".$num)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A2:W2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":T".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }


        $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->mergeCells('C2:E2');
        $objPHPExcel->getActiveSheet()->mergeCells('H2:J2');
        $objPHPExcel->getActiveSheet()->mergeCells('K2:L2');
        $objPHPExcel->getActiveSheet()->mergeCells('M2:O2');
        $objPHPExcel->getActiveSheet()->mergeCells('P2:Q2');
        $objPHPExcel->getActiveSheet()->mergeCells('S2:T2');
        $objPHPExcel->getActiveSheet()->mergeCells('U2:W2');
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Materials Gatepass Report(Completed).xlsx"');
        readfile($exportfilename);
    }

    public function export_incomplete_gatepass(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $data['from']=$this->uri->segment(3);
        $data['to']=$this->uri->segment(4);
        $sql="";
        if($from!='null' && $to!='null' || $from!='' && $to!=''){
           $sql.= " WHERE gh.date_issued BETWEEN '$from' AND '$to' AND";
        }

        if($from!='' && $to!=''){
            $query=substr($sql,0,-3);
        }else{
            $query='';
        }
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="Incomplete Materials Gatepass Report(Incomplete).xlsx";

        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(35);
        $objDrawing->setCoordinates('A2');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Date Issued");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "U/M");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', "Quantity");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "Remaining Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', "Total Returned Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', "Remarks");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', "Type");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', "MGP No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', "Destination");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', "Returned History");
        $num=2;

        $x = 1;
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        foreach($this->super_model->custom_query("SELECT gh.*, gd.* FROM gatepass_head gh INNER JOIN gatepass_details gd ON gh.gatepass_id = gd.gatepass_id ".$query) AS $gatepass_items){
            $returned_date = $this->super_model->select_column_where("gp_returned_history", "date_returned", "gp_rh_id", $gatepass_items->gatepass_id);
            $returned_qty = $this->super_model->select_column_where("gp_returned_history", "qty", "gp_rh_id", $gatepass_items->gatepass_id);
            $total_qty = $this->super_model->select_sum_where("gatepass_details", "quantity", "gd_id='$gatepass_items->gd_id'");
            $sum_qty = $this->super_model->select_sum_where("gp_returned_history", "qty", "gd_id='$gatepass_items->gd_id'");
            $balance=$total_qty-$sum_qty;
            if($sum_qty==$gatepass_items->quantity){
             $status = "Completed";
            } else {
            $status = "Incomplete";
             }

            if($status=="Incomplete"){
            $history='';
            foreach($this->super_model->select_row_where("gp_returned_history","gd_id",$gatepass_items->gd_id) AS $ret){
                if($gatepass_items->type=='Non-Returnable'){
                    $history.=$gatepass_items->type;
                } else if($gatepass_items->type=='Returnable' &&  $sum_qty==0 ){
                    $history.='';
                } else if($gatepass_items->type=='Returnable' &&  $sum_qty!=0){
                    $history.="Date: ".$ret->date_returned." \n\n Qty: ".$ret->qty."\n\n";
                }
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $gatepass_items->date_issued);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num, $gatepass_items->item_name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $gatepass_items->unit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $gatepass_items->quantity);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $balance);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$num, $sum_qty);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$num, $gatepass_items->remarks);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $gatepass_items->type);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $gatepass_items->mgp_no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$num, $gatepass_items->destination);
            if($gatepass_items->type=='Non-Returnable'){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$num, $gatepass_items->type);
            }else{
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$num, $history);
            }
            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
            $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":W".$num)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$num.":J".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$num.":L".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $num++;
            $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$num.":B".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('C1:E1');
            $objPHPExcel->getActiveSheet()->mergeCells('C'.$num.":E".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('H1:J1');
            $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":J".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('K1:L1');
            $objPHPExcel->getActiveSheet()->mergeCells('K'.$num.":L".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('M1:O1');
            $objPHPExcel->getActiveSheet()->mergeCells('M'.$num.":O".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('P1:Q1');
            $objPHPExcel->getActiveSheet()->mergeCells('P'.$num.":Q".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('S1:T1');
            $objPHPExcel->getActiveSheet()->mergeCells('S'.$num.":T".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('U1:W1');
            $objPHPExcel->getActiveSheet()->mergeCells('U'.$num.":W".$num);
            $objPHPExcel->getActiveSheet()->getStyle('U'.$num.":W".$num)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A2:W2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":T".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }


        $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->mergeCells('C2:E2');
        $objPHPExcel->getActiveSheet()->mergeCells('H2:J2');
        $objPHPExcel->getActiveSheet()->mergeCells('K2:L2');
        $objPHPExcel->getActiveSheet()->mergeCells('M2:O2');
        $objPHPExcel->getActiveSheet()->mergeCells('P2:Q2');
        $objPHPExcel->getActiveSheet()->mergeCells('S2:T2');
        $objPHPExcel->getActiveSheet()->mergeCells('U2:W2');
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Materials Gatepass Report(Incomplete).xlsx"');
        readfile($exportfilename);
    }

    public function insert_gatepass_head(){

        $head_rows = $this->super_model->count_rows("gatepass_head");
        if($head_rows==0){
            $gatepassid=1;
        } else {
            $maxid=$this->super_model->get_max("gatepass_head", "gatepass_id");
            $gatepassid=$maxid+1;
        }

        $now=date('Y-m-d H:i:s');
        $data = array(
           'gatepass_id'=>$gatepassid,
           'mgp_no'=> $this->input->post('mgp_no'),
           'company'=> $this->input->post('company'),
           'destination'=> $this->input->post('destination'),
           'vehicle_no'=> $this->input->post('vehicle_no'),
           'date_issued'=> $this->input->post('date_issued'),
           'prepared_by'=> $this->input->post('prepared'),
           'noted_by'=> $this->input->post('noted'),
           'approved_by'=> $this->input->post('approved'),
           'date_created'=> $now,
           'created_by'=> $this->input->post('userid')
        );

      
        if($this->super_model->insert_into("gatepass_head", $data)){
             redirect(base_url().'index.php/gatepass/add_gatepass/'.$gatepassid);
        } else {
            $url=base_url()."index.php/gatepass/gatepass_list/";
            echo "Due to slow connectivity. Please <a href='".$url."' >Try Again.</a>"; ?>
          
            <?php 
        }
    }

    public function add_gatepass(){
        $id=$this->uri->segment(3);
        $data['gatepassid']= $id;
        $data['gatepass']= $id;
        foreach($this->super_model->select_row_where("gatepass_head", "gatepass_id", $id) AS $pass){
            $data['head'][]=array(
                "gatepass_id"=>$pass->gatepass_id,
                "mgp_no"=>$pass->mgp_no,
                "company"=>$pass->company,
                "destination"=>$pass->destination,
                "vehicle_no"=>$pass->vehicle_no,
                "date_issued"=>$pass->date_issued,
                "prepared_by"=>$this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->prepared_by),
                "noted_by"=>$this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->noted_by),
                "approved_by"=>$this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->approved_by),
                "saved"=>$pass->saved,
            );
        }
        $row1=$this->super_model->count_rows_where("gatepass_details","gd_id",$id);
        if($row1!=0){
            foreach($this->super_model->select_row_where('gatepass_details','gatepass_id', $id) AS $gp){
                $data['gatepass_itm'][] = array(
                    'item'=>$gp->item_name,
                    'quantity'=>$gp->quantity,
                    'remarks'=>$gp->remarks,
                    'type'=>$gp->type,
                    'image'=>$gp->image,
                    'unit'=>$gp->unit,
                );
            }
        }else{
            $data['gatepass_itm'] = array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('gatepass/add_gatepass',$data);
        $this->load->view('template/footer');
    }

    public function getitem(){
       $data['list'] = array(
            'unit'=>$this->input->post('unit'),
            'quantity'=>$this->input->post('quantity'),
            'item'=>$this->input->post('item'),
            'count'=>$this->input->post('count'),
            'remarks'=>$this->input->post('remarks'),
            'type'=>$this->input->post('type'),
            'image'=>$this->input->post('image'),
        );
            
        $this->load->view('gatepass/row_item',$data);
     }

     public function insertimage(){
        $item=$this->input->post('items');
        $gatepass_id=$this->input->post('gatepassid');
        $error_ext=0;
        $dest= realpath(APPPATH . '../uploads/');
        if(!empty($_FILES['image']['name'])){
             $image= basename($_FILES['image']['name']);
             $image=explode('.',$image);
             $ext=$image[1];
            if($ext=='php' || ($ext!='png' && $ext!= 'jpg' && $ext!='jpeg')){
                $error_ext++;
            } else {
                $filename=$item."-".$gatepass_id.'.'.$ext;
                move_uploaded_file($_FILES["image"]['tmp_name'], $dest.'/'.$filename);
           }

        } else {
            $filename="";
        }
     }

    public function insertGatepass(){
        $counter = $this->input->post('counter');
        $id=$this->input->post('gatepassid');
        for($a=0;$a<$counter;$a++){
            $item=$this->input->post('item['.$a.']');
            if(!empty($this->input->post('image['.$a.']'))){
                 $image= basename($this->input->post('image['.$a.']'));
                 $image=explode('.',$image);
                 $ext=$image[1];
                $filename=$item."-".$id.'.'.$ext;
            } else {
                $filename="";
            }

            if(!empty($this->input->post('item['.$a.']'))){
                $data = array(
                    'gatepass_id'=>$this->input->post('gatepassid'),
                    'item_name'=>$this->input->post('item['.$a.']'),
                    'quantity'=>$this->input->post('quantity['.$a.']'),
                    'unit'=>$this->input->post('unit['.$a.']'),
                    'remarks'=>$this->input->post('remarks['.$a.']'),
                    'type'=>$this->input->post('type['.$a.']'),
                    'image'=>$filename,
                );
                $this->super_model->insert_into("gatepass_details", $data); 
            }
        }

        $saved=array(
            'saved'=>1
        );
        $this->super_model->update_where("gatepass_head", $saved, "gatepass_id", $id);
        echo $id;
    }

    public function gatepass_print(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $this->load->model('super_model');
        $rows = $this->super_model->count_custom_query("SELECT * FROM gatepass_details where gatepass_id='$id' AND image!=''");
        $data['heads'] = $this->super_model->select_row_where('gatepass_head', 'gatepass_id', $id);
        foreach($this->super_model->select_row_where('gatepass_head', 'gatepass_id', $id) AS $us){
            $data['signs'][] = array( 
                'prepared'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $us->prepared_by),
                'noted'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $us->noted_by),
                'posnoted'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->noted_by),
                'approved'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $us->approved_by),
                'posapproved'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->approved_by),
            );
        }
        foreach($this->super_model->select_row_where('gatepass_head','gatepass_id', $id) AS $pass){
            foreach($this->super_model->select_row_where('gatepass_details','gatepass_id', $pass->gatepass_id) AS $gp){
                $data['gatepass_itm'][] = array(
                    'item'=>$gp->item_name,
                    'quantity'=>$gp->quantity,
                    'remarks'=>$gp->remarks,
                    'image'=>$gp->image,
                    'unit'=>$gp->unit,
                    'type'=>$gp->type,
                    'rows'=>$rows,
                );
            }
            $data['pass'][] = array(
                'gatepassid'=>$pass->gatepass_id,
                'mgp_no'=>$pass->mgp_no,
                'destination'=>$pass->destination,
                'vehicle_no'=>$pass->vehicle_no,
                'date_issued'=>$pass->date_issued,
                'date_issued'=>$pass->date_issued,
                'company'=>$pass->company,
            );
        }

        $data['printed']=$this->super_model->select_column_where('users', 'fullname', 'user_id', $_SESSION['user_id']);
        $this->load->view('template/header');
        $this->load->view('gatepass/gatepass_print',$data);
        $this->load->view('template/footer');
    }

    public function add_date_returned(){
        $id = $this->input->post('gp_rh_id');
        $gd_id = $this->input->post('gd_id');
        $data = array(
            'gd_id'=>$this->input->post('gd_id'),
            'gatepass_id'=>$this->input->post('gatepass_id'),
            'date_returned'=>$this->input->post('date_returned'),
            'qty'=>$this->input->post('qty'),
            'remarks'=>$this->input->post('remarks'),
        );
        if($this->super_model->insert_into("gp_returned_history", $data)){; 
        redirect(base_url().'index.php/gatepass/incomplete_gatepass_items', 'refresh');
        }
    }


    public function view_gatepass(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $this->load->model('super_model');
        $data['head'] = $this->super_model->select_row_where('gatepass_head', 'gatepass_id', $id);
        
        foreach($this->super_model->select_row_where('gatepass_head','gatepass_id', $id) AS $pass){
            foreach($this->super_model->select_row_where('gatepass_details','gatepass_id', $pass->gatepass_id) AS $gp){
                $returned_date = $this->super_model->select_column_where("gp_returned_history", "date_returned", "gp_rh_id", $gp->gatepass_id);
                $returned_qty = $this->super_model->select_column_where("gp_returned_history", "qty", "gp_rh_id", $gp->gatepass_id);
                $returned_remarks = $this->super_model->select_column_where("gp_returned_history", "remarks", "gp_rh_id", $gp->gatepass_id);
                $total_quantity = $this->super_model->select_sum_where("gatepass_details", "quantity", "gd_id='$gp->gd_id' AND type!='Non-Returnable'");
                $total_returned = $this->super_model->select_sum_where("gp_returned_history", "qty", "gd_id='$gp->gd_id'");
                $remaining_qty=$total_quantity-$total_returned;
                $data['gatepass_itm'][] = array(
                    'gd_id'=>$gp->gd_id,
                    'item'=>$gp->item_name,
                    'quantity'=>$gp->quantity,
                    'unit'=>$gp->unit,
                    'remarks'=>$gp->remarks,
                    'type'=>$gp->type,
                    'image'=>$gp->image,
                    'returned_date'=>$returned_date,
                    'returned_qty'=>$returned_qty,
                    'returned_remarks'=>$returned_remarks,
                    'total_returned'=>$total_returned,
                    'remaining_qty'=>$remaining_qty,

                );
            }
            $data['pass'][] = array(
                'gatepassid'=>$pass->gatepass_id,
                'mgp_no'=>$pass->mgp_no,
                'destination'=>$pass->destination,
                'vehicle_no'=>$pass->vehicle_no,
                'date_issued'=>$pass->date_issued,
                'company'=>$pass->company,


            );
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('gatepass/view_gatepass',$data);
        $this->load->view('template/footer');
    }


}
?>

