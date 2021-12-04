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
        // $this->dropdown['prno'] = $this->super_model->select_join_where("receive_details","receive_head", "saved='1' AND create_date BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE()","receive_id");
        //$this->dropdown['prno'] = $this->super_model->select_join_where_order("receive_details","receive_head", "saved='1'","receive_id", "receive_date", "DESC");
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

        public function filter_gatepass_items(){
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
            window.location.href ='<?php echo base_url(); ?>index.php/gatepass/gatepass_items_list/<?php echo $from; ?>/<?php echo $to; ?>/'</script> <?php
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
        $total_quantity = $this->super_model->select_sum_where("gatepass_details", "quantity", "gatepass_id='$gatepass->gatepass_id'" AND "type='Returnable'");
        $total_returned = $this->super_model->select_sum_where("gp_returned_history", "qty", "gatepass_id='$gatepass->gatepass_id'");
        if($total_returned==$total_quantity){
            $status = "Completed";
            } else {
            $status = "Incomplete";
            }
            //$supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $gatepass->supplier_id);
            //$prepared = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $gatepass->prepared_by);
            //$noted = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $gatepass->noted_by);
            //$approved = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $gatepass->approved_by);
            $type = $this->super_model->select_column_where("gatepass_details", "type", "gd_id", $gatepass->gatepass_id);
            $data['gatepass'][] = array(
                'gatepassid'=>$gatepass->gatepass_id,
                'mgp_no'=>$gatepass->mgp_no,
                'destination'=>$gatepass->destination,
                'vehicle_no'=>$gatepass->vehicle_no,
                'date_issued'=>$gatepass->date_issued,
                //'date_returned'=>$gatepass->date_returned,
                'company'=>$gatepass->company,
                'type'=>$type,
                'status'=>$status,
                //'supplier'=>$supplier,
                //'prepared_by'=>$prepared,
                //'noted_by'=>$noted,
                //'approved_by'=>$approved,
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

        public function gatepass_items_list(){
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
        //foreach($this->super_model->custom_query("SELECT * FROM gatepass_details ".$query) AS $gatepass_items){
        foreach($this->super_model->custom_query("SELECT gh.*, gd.* FROM gatepass_head gh INNER JOIN gatepass_details gd ON gh.gatepass_id = gd.gatepass_id ".$query) AS $gatepass_items){
            //$mgp_no = $this->super_model->select_column_where("gatepass_head", "mgp_no", "gatepass_id", $gatepass_items->gatepass_id);
            //$destination = $this->super_model->select_column_where("gatepass_head", "destination", "gatepass_id", $gatepass_items->gatepass_id);
            //$date_issued = $this->super_model->select_column_where("gatepass_head", "date_issued", "gatepass_id", $gatepass_items->gatepass_id);
            //$prepared = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $gatepass->prepared_by);
            //$noted = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $gatepass->noted_by);
            //$approved = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $gatepass->approved_by);
            $returned_date = $this->super_model->select_column_where("gp_returned_history", "date_returned", "gd_id", $gatepass_items->gd_id);
            $returned_qty = $this->super_model->select_column_where("gp_returned_history", "qty", "gd_id", $gatepass_items->gd_id);
            $sum_qty = $this->super_model->select_sum_where("gp_returned_history", "qty", "gd_id='$gatepass_items->gd_id'");
            if($sum_qty== $gatepass_items->quantity){
             $status = "Completed";
            } else {
            $status = "Incomplete";
             }
            $balance=$gatepass_items->quantity-$sum_qty;
            $data['gatepass_items'][] = array(
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
                'balance'=>$balance,

            );
        }
 
        } else {
            $data['gatepass_items']=array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('gatepass/gatepass_items_list',$data);
        $this->load->view('template/footer');
    }

     public function view_history(){  
        $this->load->view('template/header');
        $data['gd_id']=$this->input->post('gd_id');
        $gd_id=$this->input->post('gd_id');
        $data['returned'] = $this->super_model->select_row_where('gp_returned_history', 'gd_id', $gd_id);
        $this->load->view('gatepass/view_history',$data);
    }

        public function export_gatepass(){
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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "U/M");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "Quantity");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', "Remarks");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "Type");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', "MGP No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "Destination");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', "Returned History");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', "Status");
        $num=11;

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
            $sum_qty = $this->super_model->select_sum_where("gp_returned_history", "qty", "gd_id='$gatepass_items->gd_id'");
            if($sum_qty== $gatepass_items->quantity){
             $status = "Completed";
            } else {
            $status = "Incomplete";
             }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $gatepass_items->date_issued);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $gatepass_items->item_name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num, $gatepass_items->unit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $gatepass_items->quantity);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $gatepass_items->remarks);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $gatepass_items->type);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $gatepass_items->mgp_no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $gatepass_items->destination);
            if($gatepass_items->type=='Non-Returnable'){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$num, $gatepass_items->type);
            }else{
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$num);
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$num, $status);

            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
            $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":O".$num)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('R'.$num.":S".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $num++;
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":C".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('F11:G11');
            $objPHPExcel->getActiveSheet()->mergeCells('F'.$num.":G".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('H11:I11');
            $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":I".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('J11:K11');
            $objPHPExcel->getActiveSheet()->mergeCells('J'.$num.":K".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('L11:O11');
            $objPHPExcel->getActiveSheet()->mergeCells('L'.$num.":O".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('T11:W11');
            $objPHPExcel->getActiveSheet()->mergeCells('T'.$num.":W".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('X11:Y11');
            $objPHPExcel->getActiveSheet()->mergeCells('X'.$num.":Y".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('Z11:AB11');
            $objPHPExcel->getActiveSheet()->mergeCells('Z'.$num.":AB".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('AC11:AE11');
            $objPHPExcel->getActiveSheet()->mergeCells('AC'.$num.":AE".$num);
            $objPHPExcel->getActiveSheet()->getStyle('B11:E11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$num.":E".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('P11:S11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('P'.$num.":S".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }


        $objPHPExcel->getActiveSheet()->mergeCells('N2:T2');
        $objPHPExcel->getActiveSheet()->mergeCells('B10:C10');
        $objPHPExcel->getActiveSheet()->mergeCells('F10:G10');
        $objPHPExcel->getActiveSheet()->mergeCells('H10:I10');
        $objPHPExcel->getActiveSheet()->mergeCells('J10:K10');
        $objPHPExcel->getActiveSheet()->mergeCells('L10:O10');
        $objPHPExcel->getActiveSheet()->mergeCells('T10:W10');
        $objPHPExcel->getActiveSheet()->mergeCells('X10:Y10');
        $objPHPExcel->getActiveSheet()->mergeCells('Z10:AB10');
        $objPHPExcel->getActiveSheet()->mergeCells('AC10:AE10');
        $objPHPExcel->getActiveSheet()->mergeCells('B11:C11');
        $objPHPExcel->getActiveSheet()->getStyle('A10:AE10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A10:AE10')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AE3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AE1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AE1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AE2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AE3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AE1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AE2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AE3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AE1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AE2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AE3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("N2")->getFont()->setBold(true)->setName('Arial Black');
        $objPHPExcel->getActiveSheet()->getStyle('N2:T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Materials Gatepass Report.xlsx"');
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
           //'date_returned'=> $this->input->post('date_returned'),
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
        //$data['item_list']=$this->super_model->select_all_order_by("items","item_name","ASC");
        //$data['unit']=$this->super_model->select_all_order_by("uom","unit_name","ASC");
        foreach($this->super_model->select_row_where("gatepass_head", "gatepass_id", $id) AS $pass){
            $data['head'][]=array(
                "mgp_no"=>$pass->mgp_no,
                "company"=>$pass->company,
                //"to_company"=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $pass->supplier_id),
                "destination"=>$pass->destination,
                "vehicle_no"=>$pass->vehicle_no,
                "date_issued"=>$pass->date_issued,
                //"date_returned"=>$pass->date_returned,
                "prepared_by"=>$this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->prepared_by),
                "noted_by"=>$this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->noted_by),
                "approved_by"=>$this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->approved_by),
                "saved"=>$pass->saved,
            );
        }
        $row1=$this->super_model->count_rows_where("gatepass_details","gd_id",$id);
        if($row1!=0){
            foreach($this->super_model->select_row_where('gatepass_details','gatepass_id', $id) AS $gp){
                //$item = $this->super_model->select_column_where("items", "item_name", "item_id", $gp->item_id);
                //$unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $gp->unit_id);
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
        //$unit=$this->input->post('unit');
        //$unit_name = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $unit);
        //$item=$this->input->post('item');
        //$item_name = $this->super_model->select_column_where("items", "item_name", "item_id", $item);

       $data['list'] = array(
            //'unit_id'=>$unit,
            //'unit'=>$unit_name,
            'unit'=>$this->input->post('unit'),
            'quantity'=>$this->input->post('quantity'),
            //'item_id'=>$item,
            //'item'=>$item_name,
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
        //$rows = $this->super_model->custom_query("SELECT COUNT(image) FROM gatepass_details where gatepass_id='$id'");
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
                //$item = $this->super_model->select_column_where("items", "item_name", "item_id", $gp->item_id);
                //$unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $gp->unit_id);
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
            //$company = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $pass->supplier_id);
            $data['pass'][] = array(
                'gatepassid'=>$pass->gatepass_id,
                'mgp_no'=>$pass->mgp_no,
                'destination'=>$pass->destination,
                'vehicle_no'=>$pass->vehicle_no,
                'date_issued'=>$pass->date_issued,
                'date_issued'=>$pass->date_issued,
                //'date_returned'=>$pass->date_returned,
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
        );
        if($this->super_model->insert_into("gp_returned_history", $data)){; 
        redirect(base_url().'index.php/gatepass/gatepass_items_list', 'refresh');
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
                $data['gatepass_itm'][] = array(
                    'gd_id'=>$gp->gd_id,
                    'item'=>$gp->item_name,
                    'quantity'=>$gp->quantity,
                    'unit'=>$gp->unit,
                    'remarks'=>$gp->remarks,
                    'type'=>$gp->type,
                    //'date_returned'=>$gp->date_returned,
                    'image'=>$gp->image,
                    'returned_date'=>$returned_date,
                    'returned_qty'=>$returned_qty,

                );
            }
            //$company = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $pass->supplier_id);
            //$prepared = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->prepared_by);
            //$noted = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->noted_by);
            //$approved = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->approved_by);
            $data['pass'][] = array(
                'gatepassid'=>$pass->gatepass_id,
                'mgp_no'=>$pass->mgp_no,
                'destination'=>$pass->destination,
                'vehicle_no'=>$pass->vehicle_no,
                'date_issued'=>$pass->date_issued,
                //'date_returned'=>$pass->date_returned,
                'company'=>$pass->company,
                //'prepared'=>$prepared,
                //'noted'=>$noted,
                //'approved'=>$approved,


            );
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('gatepass/view_gatepass',$data);
        $this->load->view('template/footer');
    }


}
?>

