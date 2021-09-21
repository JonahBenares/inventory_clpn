<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterfile extends CI_Controller {

  function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('super_model');
        date_default_timezone_set("Asia/Manila");
        $this->dropdown['department'] = $this->super_model->select_all_order_by('department', 'department_name', 'ASC');
        $this->dropdown['purpose'] = $this->super_model->select_all_order_by('purpose', 'purpose_desc', 'ASC');
        $this->dropdown['enduse'] = $this->super_model->select_all_order_by('enduse', 'enduse_name', 'ASC');
        $this->dropdown['employee'] = $this->super_model->select_all_order_by('employees', 'employee_name', 'ASC');
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
            } 
            else {
                return false;
            }
        }
    }

    public function index(){ 
        $this->load->view('template/header_login');
        $this->load->view('masterfile/login');
        $this->load->view('template/footer');
    }

    public function dateDifference($date_1 , $date_2){
        $datetime2 = date_create($date_2);
        $datetime1 = date_create($date_1 );
        $interval = date_diff($datetime2, $datetime1);
        return $interval->format('%R%a');
    }

     /*public function inventory_balance($itemid){
         $recqty= $this->super_model->select_sum("supplier_items", "quantity", "item_id", $itemid);
         $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND saved='1'","issuance_id");
         $balance=$recqty-$issueqty;
         return $balance;
    }*/

       public function inventory_balance($itemid){
       /*  $recqty= $this->super_model->select_sum("supplier_items", "quantity", "item_id", $itemid);
         $issueqty= $this->super_model->select_sum("issuance_details","quantity", "item_id",$itemid);*/
        $begbal= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id='$itemid' AND catalog_no = 'begbal'");
         $recqty= $this->super_model->select_sum_join("received_qty","receive_items","receive_head", "item_id='$itemid' AND saved='1'","receive_id");
         //return $recqty;
        $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND saved='1'","issuance_id");
        //return $issueqty;
         $restockqty= $this->super_model->select_sum_join("quantity","restock_details","restock_head", "item_id='$itemid' AND saved='1'","rhead_id");
          //return $restockqty;
          $balance=($recqty+$begbal+$restockqty)-$issueqty;
         return $balance;
    }
    
    public function backorder_qty($riid){

        $expectedqty = $this->super_model->select_sum("receive_items", "expected_qty", "ri_id", $riid);
        $recqty = $this->super_model->select_column_where("receive_items", "received_qty", "ri_id", $riid);
        $bo_qty = $expectedqty-$recqty;
        return $bo_qty;
    }

    public function get_expected_qty($pr,$item){
        $expected_qty = $this->super_model->custom_query_single("expected_qty","SELECT expected_qty FROM receive_items ri INNER JOIN receive_details rd ON ri.rd_id = rd.rd_id WHERE rd.pr_no = '$pr' AND ri.item_id='$item' ORDER BY ri.rd_id ASC LIMIT 1");
        //$expected_qty = $this->super_model->select_sum_join("expected_qty","receive_items","receive_details", "pr_no = '$pr' AND item_id='$item'","rd_id");
        return $expected_qty;
    }

     public function get_received_qty($pr,$item){
        $received_qty = $this->super_model->select_sum_join("received_qty","receive_items","receive_details", "pr_no = '$pr' AND item_id='$item'","rd_id");
          // $received_qty =  $this->super_model->custom_query_single("total_received", "SELECT SUM(received_qty) AS total_received FROM receive_items ri INNER JOIN receive_details rd ON rd.rd_id = ri.rd_id WHERE pr_no = '$pr' AND item_id='$item'");
        return $received_qty;
    }

      public function get_rdid($pr,$item){
        $rd_id = $this->super_model->custom_query_single("rd_id","SELECT ri.rd_id FROM receive_items ri INNER JOIN receive_details rd ON ri.rd_id = rd.rd_id WHERE rd.pr_no = '$pr' AND ri.item_id='$item' ORDER BY ri_id DESC LIMIT 1");
        return $rd_id;
    }

    public function home(){
        $data[]=array();
     
        $x=0;
       
        foreach($this->super_model->custom_query("SELECT DISTINCT pr_no, item_id FROM receive_details rd INNER JOIN receive_head rh ON rh.receive_id = rd.receive_id INNER JOIN receive_items ri ON rd.rd_id = ri.rd_id WHERE saved='1'") AS $prlist){
            
            $expected_qty= $this->get_expected_qty($prlist->pr_no,$prlist->item_id);
            $received_qty= $this->get_received_qty($prlist->pr_no,$prlist->item_id);
            $balance = $expected_qty - $received_qty;
            $rd_id= $this->get_rdid($prlist->pr_no,$prlist->item_id);
            $item=$this->super_model->select_column_where("items", "item_name", "item_id", $prlist->item_id);

            if($expected_qty>$received_qty){
                //echo $item . " = " . $expected_qty . " > " . $received_qty . "<br>";
                $data['list'][] = array(
                    "rdid"=>$rd_id,
                    "pr_no"=>$prlist->pr_no,
                    "item"=>$item,
                    "expected"=>$expected_qty,
                    "received"=>$received_qty,
                    "balance"=>$balance
                );
            }
        }

    
        foreach($this->super_model->select_custom_where("items", "min_qty!='0'") AS $items){
            $current_inv=$this->inventory_balance($items->item_id);
            $moq=$items->min_qty;
            

            if($current_inv<=$moq){
                $item=$this->super_model->select_column_where("items", "item_name", "item_id", $items->item_id);
          
                $data['nto'][] = array(
                    "item"=>$item,
                    "moq"=>$moq,
                    "currentinv"=>$current_inv
                );

            }
        }
        $data['employee'] = $this->super_model->select_all_order_by('employees', 'employee_name', 'ASC');
        foreach($this->super_model->select_row_where_order_by("reminders", "done", "0", "reminder_date", "DESC") AS $rem){
            $data['reminders'][]=array(
                "reminder_id"=>$rem->reminder_id,
                "reminder_date"=>$rem->reminder_date,
                "title"=>$rem->reminder_title,
                "notes"=>$rem->notes,
                "remind_employee"=>$rem->remind_employee,
                "employee"=>$this->super_model->select_column_where("employees", "employee_name", "employee_id", $rem->remind_employee)
            );
        }

         $count=$this->super_model->select_count_join_inner("request_items","issuance_head", "request_items.borrowfrom_pr !='' AND replenished='0'","request_id");
        if($count!=0){
            foreach($this->super_model->select_inner_join("request_items","issuance_head", "request_items.borrowfrom_pr !='' AND replenished='0'","request_id") AS $itms){
               
                $data['borrow'][]=array(
                    'rqid'=>$itms->rq_id,
                    'mif_no'=>$this->super_model->select_column_where("issuance_head", "mif_no", "request_id", $itms->request_id),
                    'original_pr'=>$this->super_model->select_column_where("request_head", "pr_no", "request_id", $itms->request_id),
                    'borrowfrom'=>$itms->borrowfrom_pr,
                    'quantity'=>$itms->quantity,
                    'item'=>$this->super_model->select_column_where("items", "item_name", "item_id", $itms->item_id),
                    'brand'=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $itms->brand_id),
                    'catalog'=>$itms->catalog_no


                );
            } 
        } else {
            $data['borrow']=array();
        }

        /*foreach($this->super_model->select_inner_join("receive_items","receive_details", "receive_items.expiration_date !='' ORDER BY expiration_date DESC","rd_id") AS $itms){
            $pr_no=$this->super_model->select_column_where("receive_details", "pr_no", "rd_id", $itms->rd_id);
            $item=$this->super_model->select_column_where("items", "item_name", "item_id", $itms->item_id);
            //$issuance_id = $this->super_model->select_column_join_where_order_limit("issuance_id", "issuance_head","issuance_details", "item_id='$itms->item_id' AND pr_no='$pr_no'","issuance_id","DESC","1");
            //$issue_pr = $this->super_model->select_column_where("issuance_head", "pr_no","issuance_id", $issuance_id);
            //$issue_item = $this->super_model->select_column_where("issuance_details", "item_id","is_id", $issuance_id); 
            $issue_qty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itms->item_id' AND pr_no='$pr_no'","issuance_id");
            $remaining_qty = ($itms->received_qty - $issue_qty);
            $now=date('Y-m-d');
            $expiry=$this->dateDifference($itms->expiration_date , $now);
            if($expiry>=90 || $expiry>0 || $remaining_qty>0){
                $data['expiry'][]=array(
                    'riid'=>$itms->ri_id,
                    'pr_no'=>$pr_no,
                    'item'=>$item,
                    'brand'=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $itms->brand_id),
                    'catalog'=>$itms->catalog_no,
                    'received_qty'=>$itms->received_qty,
                    'expiration_date'=>$itms->expiration_date,
                    'remaining_qty'=>$remaining_qty


                );
            } else {
                $data['expiry']=array();
            }
        }*/

        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/index',$data);
        $this->load->view('template/footer');
    }


    public function login_process(){
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        $count=$this->super_model->login_user($username,$password);
        if($count>0){   
            $password1 =md5($this->input->post('password'));
            $fetch=$this->super_model->select_custom_where("users", "username = '$username' AND (password = '$password' OR password = '$password1')");
            foreach($fetch AS $d){
                $userid = $d->user_id;
                $usertype = $d->usertype_id;
                $username = $d->username;
            }
            $newdata = array(
               'user_id'=> $userid,
               'usertype'=> $usertype,
               'username'=> $username,
               'logged_in'=> TRUE
            );
            $this->session->set_userdata($newdata);
            redirect(base_url().'index.php/masterfile/home/');
        }
        else{
            $this->session->set_flashdata('error_msg', 'Username And Password Do not Exist!');
            $this->load->view('template/header_login');
            $this->load->view('masterfile/login');
            $this->load->view('template/footer');       
        }
    }

    public function uom_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['unit'] = $this->super_model->select_all('uom');
        $data['access']=$this->access;
        $this->load->view('masterfile/uom_list',$data);
        $this->load->view('template/footer');
    }

    public function rack_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['rack'] = $this->super_model->select_all('rack');
        $data['access']=$this->access;
        $this->load->view('masterfile/rack_list',$data);
        $this->load->view('template/footer');
    }

    public function user_logout(){
        $this->session->sess_destroy();
        $this->load->view('template/header');
        $this->load->view('masterfile/login');
        $this->load->view('template/footer');
        echo "<script>alert('You have successfully logged out.'); 
        window.location ='".base_url()."index.php/masterfile/index'; </script>";
    }

    public function supplier_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['list'] = $this->super_model->select_all('supplier');
        $data['access']=$this->access;
        $this->load->view('masterfile/supplier_list',$data);
        $this->load->view('template/footer');
    }

    public function category_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['category'] = $this->super_model->select_all('item_categories'); 
        $data['subcat'] = $this->super_model->select_all('item_subcat'); 
        $data['access']=$this->access;
        $this->load->view('masterfile/category_list',$data);
        $this->load->view('template/footer');
    }

    public function update_subcategory(){
        $data = array(
            'subcat_name'=>$this->input->post('subcat_name'),
            'subcat_prefix'=>$this->input->post('subcat_pref'),
        );
        $subid = $this->input->post('subcat_id');
            if($this->super_model->update_where('item_subcat', $data, 'subcat_id', $subid)){
            echo "<script>alert('Successfully Updated!'); 
                window.location ='".base_url()."index.php/masterfile/category_list'; </script>";
        }
    }

    public function department_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['department'] = $this->super_model->select_all('department');
        $data['access']=$this->access;
        $this->load->view('masterfile/department_list',$data);
        $this->load->view('template/footer');
    }

    public function location_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['location'] = $this->super_model->select_all('location');
        $data['access']=$this->access;
        $this->load->view('masterfile/location_list',$data);
        $this->load->view('template/footer');
    }

    public function endUse_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['enduse'] = $this->super_model->select_all('enduse');
        $data['access']=$this->access;
        $this->load->view('masterfile/endUse_list', $data);
        $this->load->view('template/footer');
    }

    public function export_enduse(){
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="Enduse List.xlsx";
        foreach(range('A','B') as $columnID){
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "ENDUSE LIST");
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setName('Arial Black')->setSize(12);
        $num=3;
        $x=1;
        $styleArray1 = array(
            'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "#");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "Enduse Name");
        $objPHPExcel->getActiveSheet()->getStyle("A2:B2".$num)->applyFromArray($styleArray1);
        $objPHPExcel->getActiveSheet()->getStyle("A2:B2")->getFont()->setBold(true)->setName('Arial Black')->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        foreach($this->super_model->select_all_order_by("enduse","enduse_name","ASC") AS $end){
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, "$x");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, "$end->enduse_name");
            $objPHPExcel->getActiveSheet()->getStyle('A'.$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":B".$num)->applyFromArray($styleArray);
            $num++;
            $x++;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Enduse List.xlsx"');
        readfile($exportfilename);
    }

    public function warehouse_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['warehouse'] = $this->super_model->select_all('warehouse');
        $data['access']=$this->access;
        $this->load->view('masterfile/warehouse_list',$data);
        $this->load->view('template/footer');
    }

    public function employee_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        /*$data['employee'] = $this->super_model->select_all('employees');*/
        $data['department'] = $this->super_model->select_all('department');
        foreach($this->super_model->select_all_order_by('employees','employee_name','ASC') AS $emp){
            /*$department =$this->super_model->select_column_where("department", "department_name", "department_id", $emp->department_id);*/
            $data['employee'][] = array(
                'employee_id'=>$emp->employee_id,
                'employee'=>$emp->employee_name,
                'department'=>$emp->department,
                'position'=>$emp->position,
                'contact_no'=>$emp->contact_no,
                'email'=>$emp->email
            );
        }
        $data['access']=$this->access;
        $this->load->view('masterfile/employee_list',$data);
        $this->load->view('template/footer');
    }

    public function purpose_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['purpose'] = $this->super_model->select_all('purpose');
        $data['access']=$this->access;
        $this->load->view('masterfile/purpose_list',$data);
        $this->load->view('template/footer');
    }

    public function export_purpose(){
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="Purpose List.xlsx";
        foreach(range('A','B') as $columnID){
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "PURPOSE LIST");
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setName('Arial Black')->setSize(12);
        $num=3;
        $x=1;
        $styleArray1 = array(
            'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "#");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "Purpose");
        $objPHPExcel->getActiveSheet()->getStyle("A2:B2".$num)->applyFromArray($styleArray1);
        $objPHPExcel->getActiveSheet()->getStyle("A2:B2")->getFont()->setBold(true)->setName('Arial Black')->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        foreach($this->super_model->select_all_order_by("purpose","purpose_desc","ASC") AS $purp){
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, "$x");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, "$purp->purpose_desc");
            $objPHPExcel->getActiveSheet()->getStyle('A'.$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":B".$num)->applyFromArray($styleArray);
            $num++;
            $x++;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Purpose List.xlsx"');
        readfile($exportfilename);
    }

    public function view_cat(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['cat'] = $this->super_model->select_row_where('item_categories', 'cat_id', $id);
        $data['access']=$this->access;
        $this->load->view('template/header');
       /* $data['category'] = $this->super_model->select_all('item_categories');*/
        $this->load->view('masterfile/view_cat',$data);
    }

    public function group_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['group'] = $this->super_model->select_all('group');
        $data['access']=$this->access;
        $this->load->view('masterfile/group_list',$data);
        $this->load->view('template/footer');
    }

    public function subcat_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['subcat'] = $this->super_model->select_all('item_subcat');
        $data['access']=$this->access;
        $this->load->view('masterfile/subcat_list',$data);
        $this->load->view('template/footer');
    }

    public function signatory(){
        $row=$this->super_model->count_rows("employees");
        if($row != 0){
            foreach($this->super_model->select_all_order_by('employees','employee_name','ASC') AS $sig){
                $employee = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $sig->employee_id);
                $requested =$this->super_model->select_column_where("signatories", "requested", "employee_id", $sig->employee_id);
                $noted =$this->super_model->select_column_where("signatories", "noted", "employee_id", $sig->employee_id);
                $inspected =$this->super_model->select_column_where("signatories", "inspected", "employee_id", $sig->employee_id);
                $delivered =$this->super_model->select_column_where("signatories", "delivered", "employee_id", $sig->employee_id);
                $reviewed =$this->super_model->select_column_where("signatories", "reviewed", "employee_id", $sig->employee_id);
                $received =$this->super_model->select_column_where("signatories", "received", "employee_id", $sig->employee_id);
                $released =$this->super_model->select_column_where("signatories", "released", "employee_id", $sig->employee_id);
                $approved =$this->super_model->select_column_where("signatories", "approved", "employee_id", $sig->employee_id);
                $acknowledged =$this->super_model->select_column_where("signatories", "acknowledged", "employee_id", $sig->employee_id);
                $data['signatory'][] = array(
                    'employee'=>$employee,
                    'requested'=>$requested,
                    'noted'=>$noted,
                    'inspected'=>$inspected,
                    'delivered'=>$delivered,
                    'reviewed'=>$reviewed,
                    'received'=>$received,
                    'released'=>$released,
                    'approved'=>$approved,
                    'acknowledged'=>$acknowledged
                );
            }
        }else{
            $data['signatory'] = array();
        }
        $data['access']=$this->access;
            $this->load->view('template/header');
            $this->load->view('template/sidebar',$this->dropdown);
            $this->load->view('masterfile/signatory',$data);
            $this->load->view('template/footer');
        
    }

     public function user_reslist(){
        foreach($this->super_model->select_all_order_by('users','fullname','ASC') AS $users){
            $rec_add =$this->super_model->select_column_where("access_rights", "receive_add", "user_id", $users->user_id);
            $rec_edit =$this->super_model->select_column_where("access_rights", "receive_edit", "user_id", $users->user_id);
            $rec_delete =$this->super_model->select_column_where("access_rights", "receive_delete", "user_id", $users->user_id);

            $req_add =$this->super_model->select_column_where("access_rights", "request_add", "user_id", $users->user_id);
            $req_edit =$this->super_model->select_column_where("access_rights", "request_edit", "user_id", $users->user_id);
            $req_delete =$this->super_model->select_column_where("access_rights", "request_delete", "user_id", $users->user_id);

            $iss_add =$this->super_model->select_column_where("access_rights", "issue_add", "user_id", $users->user_id);
            $iss_edit =$this->super_model->select_column_where("access_rights", "issue_edit", "user_id", $users->user_id);
            $iss_delete =$this->super_model->select_column_where("access_rights", "issue_delete", "user_id", $users->user_id);

            $itm_add =$this->super_model->select_column_where("access_rights", "item_add", "user_id", $users->user_id);
            $itm_edit =$this->super_model->select_column_where("access_rights", "item_edit", "user_id", $users->user_id);
            $itm_delete =$this->super_model->select_column_where("access_rights", "item_delete", "user_id", $users->user_id);

            $sig_add =$this->super_model->select_column_where("access_rights", "signatories_add", "user_id", $users->user_id);
            $sig_edit =$this->super_model->select_column_where("access_rights", "signatories_edit", "user_id", $users->user_id);
            $sig_delete =$this->super_model->select_column_where("access_rights", "signatories_delete", "user_id", $users->user_id);

            $mas_add =$this->super_model->select_column_where("access_rights", "masterfile_add", "user_id", $users->user_id);
            $mas_edit =$this->super_model->select_column_where("access_rights", "masterfile_edit", "user_id", $users->user_id);
            $mas_delete =$this->super_model->select_column_where("access_rights", "masterfile_delete", "user_id", $users->user_id);

            $res_add =$this->super_model->select_column_where("access_rights", "restock_add", "user_id", $users->user_id);
            $res_edit =$this->super_model->select_column_where("access_rights", "restock_edit", "user_id", $users->user_id);
            $res_delete =$this->super_model->select_column_where("access_rights", "restock_delete", "user_id", $users->user_id);

            $user_add =$this->super_model->select_column_where("access_rights", "user_add", "user_id", $users->user_id);
            $user_edit =$this->super_model->select_column_where("access_rights", "user_edit", "user_id", $users->user_id);
            $user_delete =$this->super_model->select_column_where("access_rights", "user_delete", "user_id", $users->user_id);

            $data['users'][] = array(
                'userid'=>$users->user_id,
                'fullname'=>$users->fullname,
                'rec_add'=>$rec_add,
                'rec_edit'=>$rec_edit,
                'rec_delete'=>$rec_delete,
                'req_add'=>$req_add,
                'req_edit'=>$req_edit,
                'req_delete'=>$req_delete,
                'iss_add'=>$iss_add,
                'iss_edit'=>$iss_edit,
                'iss_delete'=>$iss_delete,
                'itm_add'=>$itm_add,
                'itm_edit'=>$itm_edit,
                'itm_delete'=>$itm_delete,
                'sig_add'=>$sig_add,
                'sig_edit'=>$sig_edit,
                'sig_delete'=>$sig_delete,
                'mas_add'=>$mas_add,
                'mas_edit'=>$mas_edit,
                'mas_delete'=>$mas_delete,
                'res_add'=>$res_add,
                'res_edit'=>$res_edit,
                'res_delete'=>$res_delete,
                'user_add'=>$user_add,
                'user_edit'=>$user_edit,
                'user_delete'=>$user_delete
            );
        }
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/user_reslist',$data);
        $this->load->view('template/footer');
    }

    public function update_user_reslist(){
        foreach($this->super_model->select_all_order_by('users','fullname','ASC') AS $users){
            $rec_add =$this->super_model->select_column_where("access_rights", "receive_add", "user_id", $users->user_id);
            $rec_edit =$this->super_model->select_column_where("access_rights", "receive_edit", "user_id", $users->user_id);
            $rec_delete =$this->super_model->select_column_where("access_rights", "receive_delete", "user_id", $users->user_id);

            $req_add =$this->super_model->select_column_where("access_rights", "request_add", "user_id", $users->user_id);
            $req_edit =$this->super_model->select_column_where("access_rights", "request_edit", "user_id", $users->user_id);
            $req_delete =$this->super_model->select_column_where("access_rights", "request_delete", "user_id", $users->user_id);

            $iss_add =$this->super_model->select_column_where("access_rights", "issue_add", "user_id", $users->user_id);
            $iss_edit =$this->super_model->select_column_where("access_rights", "issue_edit", "user_id", $users->user_id);
            $iss_delete =$this->super_model->select_column_where("access_rights", "issue_delete", "user_id", $users->user_id);

            $itm_add =$this->super_model->select_column_where("access_rights", "item_add", "user_id", $users->user_id);
            $itm_edit =$this->super_model->select_column_where("access_rights", "item_edit", "user_id", $users->user_id);
            $itm_delete =$this->super_model->select_column_where("access_rights", "item_delete", "user_id", $users->user_id);

            $sig_add =$this->super_model->select_column_where("access_rights", "signatories_add", "user_id", $users->user_id);
            $sig_edit =$this->super_model->select_column_where("access_rights", "signatories_edit", "user_id", $users->user_id);
            $sig_delete =$this->super_model->select_column_where("access_rights", "signatories_delete", "user_id", $users->user_id);

            $mas_add =$this->super_model->select_column_where("access_rights", "masterfile_add", "user_id", $users->user_id);
            $mas_edit =$this->super_model->select_column_where("access_rights", "masterfile_edit", "user_id", $users->user_id);
            $mas_delete =$this->super_model->select_column_where("access_rights", "masterfile_delete", "user_id", $users->user_id);

            $res_add =$this->super_model->select_column_where("access_rights", "restock_add", "user_id", $users->user_id);
            $res_edit =$this->super_model->select_column_where("access_rights", "restock_edit", "user_id", $users->user_id);
            $res_delete =$this->super_model->select_column_where("access_rights", "restock_delete", "user_id", $users->user_id);

            $user_add =$this->super_model->select_column_where("access_rights", "user_add", "user_id", $users->user_id);
            $user_edit =$this->super_model->select_column_where("access_rights", "user_edit", "user_id", $users->user_id);
            $user_delete =$this->super_model->select_column_where("access_rights", "user_delete", "user_id", $users->user_id);

            $data['users'][] = array(
                'userid'=>$users->user_id,
                'username'=>$users->username,
                'fullname'=>$users->fullname,
                'rec_add'=>$rec_add,
                'rec_edit'=>$rec_edit,
                'rec_delete'=>$rec_delete,
                'req_add'=>$req_add,
                'req_edit'=>$req_edit,
                'req_delete'=>$req_delete,
                'iss_add'=>$iss_add,
                'iss_edit'=>$iss_edit,
                'iss_delete'=>$iss_delete,
                'itm_add'=>$itm_add,
                'itm_edit'=>$itm_edit,
                'itm_delete'=>$itm_delete,
                'sig_add'=>$sig_add,
                'sig_edit'=>$sig_edit,
                'sig_delete'=>$sig_delete,
                'mas_add'=>$mas_add,
                'mas_edit'=>$mas_edit,
                'mas_delete'=>$mas_delete,
                'res_add'=>$res_add,
                'res_edit'=>$res_edit,
                'res_delete'=>$res_delete,
                'user_add'=>$user_add,
                'user_edit'=>$user_edit,
                'user_delete'=>$user_delete
            );
        }
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/update_user_reslist',$data);
        $this->load->view('template/footer');
    }

    public function insert_update_user(){
        $count = $this->input->post('count');
        for($x=1;$x<$count;$x++){
            $userid = $this->input->post('userid'.$x);

            $rec_add = $this->input->post('rec_add'.$x);
            $rec_edit = $this->input->post('rec_edit'.$x);
            $rec_delete = $this->input->post('rec_delete'.$x);
            $req_add = $this->input->post('req_add'.$x);
            $req_edit = $this->input->post('req_edit'.$x);
            $req_delete = $this->input->post('req_delete'.$x);

            $iss_add = $this->input->post('iss_add'.$x);
            $iss_edit = $this->input->post('iss_edit'.$x);
            $iss_delete = $this->input->post('iss_delete'.$x);

            $itm_add = $this->input->post('itm_add'.$x);
            $itm_edit = $this->input->post('itm_edit'.$x);
            $itm_delete = $this->input->post('itm_delete'.$x);

            $sig_add = $this->input->post('sig_add'.$x);
            $sig_edit = $this->input->post('sig_edit'.$x);
            $sig_delete = $this->input->post('sig_delete'.$x);

            $mas_add = $this->input->post('mas_add'.$x);
            $mas_edit = $this->input->post('mas_edit'.$x);
            $mas_delete = $this->input->post('mas_delete'.$x);

            $res_add = $this->input->post('res_add'.$x);
            $res_edit = $this->input->post('res_edit'.$x);
            $res_delete = $this->input->post('res_delete'.$x);

            $user_add = $this->input->post('user_add'.$x);
            $user_edit = $this->input->post('user_edit'.$x);
            $user_delete = $this->input->post('user_delete'.$x);

            //if(!empty($rec_add) || !empty($rec_edit) || !empty($rec_delete) || !empty($req_add) || !empty($req_edit) || !empty($req_delete) || !empty($iss_add) || !empty($iss_edit) || !empty($iss_delete) || !empty($itm_add) || !empty($itm_edit) || !empty($itm_delete) || !empty($sig_add) || !empty($sig_edit) || !empty($sig_delete) || !empty($mas_add) || !empty($mas_edit) || !empty($mas_delete) || !empty($res_add) || !empty($res_edit) || !empty($res_delete) || !empty($user_add) || !empty($user_edit) || !empty($user_delete)){
                if(empty($rec_add)) $reca = 0;
                else $reca=1;
                if(empty($rec_edit)) $rece = 0;
                else $rece=1;
                if(empty($rec_delete)) $recd = 0;
                else $recd=1;

                if(empty($req_add)) $reqa = 0;
                else $reqa=1;
                if(empty($req_edit)) $reqe = 0;
                else $reqe=1;
                if(empty($req_delete)) $reqd = 0;
                else $reqd=1;

                if(empty($iss_add)) $issa = 0;
                else $issa=1;
                if(empty($iss_edit)) $isse = 0;
                else $isse=1; 
                if(empty($iss_delete)) $issd = 0;
                else $issd=1;

                if(empty($itm_add)) $itma = 0;
                else $itma=1;
                if(empty($itm_edit)) $itme = 0;
                else $itme=1; 
                if(empty($itm_delete)) $itmd = 0;
                else $itmd=1;

                if(empty($sig_add)) $siga = 0;
                else $siga=1;
                if(empty($sig_edit)) $sige = 0;
                else $sige=1; 
                if(empty($sig_delete)) $sigd = 0;
                else $sigd=1;

                if(empty($mas_add)) $masa = 0;
                else $masa=1;
                if(empty($mas_edit)) $mase = 0;
                else $mase=1; 
                if(empty($mas_delete)) $masd = 0;
                else $masd=1;

                if(empty($res_add)) $resa = 0;
                else $resa=1;
                if(empty($res_edit)) $rese = 0;
                else $rese=1; 
                if(empty($res_delete)) $resd = 0;
                else $resd=1; 

                if(empty($user_add)) $usera = 0;
                else $usera=1;
                if(empty($user_edit)) $usere = 0;
                else $usere=1; 
                if(empty($user_delete)) $userd = 0;
                else $userd=1;
                $data = array(
                    'user_id' => $userid, 
                    'receive_add' => $reca,
                    'receive_edit' => $rece,
                    'receive_delete' => $recd,
                    'request_add' => $reqa,
                    'request_edit' => $reqe,
                    'request_delete' => $reqd,
                    'issue_add' => $issa,
                    'issue_edit' => $isse,
                    'issue_delete' => $issd,
                    'item_add' => $itma,
                    'item_edit' => $itme,
                    'item_delete' => $itmd,
                    'signatories_add' => $siga,
                    'signatories_edit' => $sige,
                    'signatories_delete' => $sigd,
                    'masterfile_add' => $masa,
                    'masterfile_edit' => $mase,
                    'masterfile_delete' => $masd,
                    'restock_add' => $resa,
                    'restock_edit' => $rese,
                    'restock_delete' => $resd,
                    'user_add' => $usera,
                    'user_edit' => $usere,
                    'user_delete' => $userd
                );
                foreach($this->super_model->select_row_where('users', 'user_id', $userid) AS $use){   
                    $row=$this->super_model->count_custom_where('access_rights',"user_id = '$use->user_id'"); 
                    if($row>0){
                       if($this->super_model->update_where("access_rights", $data,'user_id',$userid)){
                            echo "<script>alert('Successfully Updated!'); 
                                window.location ='".base_url()."index.php/masterfile/update_user_reslist'; </script>"; 
                        }
                    }else{
                        if($this->super_model->insert_into("access_rights", $data)){
                           echo "<script>alert('Successfully Added!'); 
                                window.location ='".base_url()."index.php/masterfile/update_user_reslist'; </script>";
                        }
                    }
                }
            //}
        }
    } 

    public function insert_user(){
        $password = md5($this->input->post('password'));
        $data = array(
            'fullname'=>$this->input->post('fullname'),
            'username'=>$this->input->post('username'),
            'password'=>$password
        );
        if($this->super_model->insert_into("users", $data)){
           echo "<script>alert('User successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/user_reslist'; </script>";
         }
    }

    public function change_pass(){
        $newpassword = md5($this->input->post('newpass'));
        $data = array(
            'password'=> $newpassword
        );
        $userid = $this->input->post('userid');

        $password = $this->super_model->select_column_where("users", "password", "user_id", $userid);

        $oldpassword = ($this->input->post('oldpass'));
        $oldpasswordmd5 = md5($this->input->post('oldpass'));

        if($oldpassword == $password){
            $this->super_model->update_where("users", $data, "user_id" , $userid );echo "<script>alert('Successfully Updated'); location.replace(document.referrer); </script>"; 
        }else if(md5($oldpasswordmd5) == md5($password)) {
            $this->super_model->update_where("users", $data,"user_id" , $userid  );echo "<script>alert('Successfully Updated'); location.replace(document.referrer); </script>";
        }
        else{
            echo "<script>alert('Incorrect Old Password!'); location.replace(document.referrer); </script>";
        }
    }

    public function add_signatory(){

        foreach($this->super_model->select_all_order_by('employees','employee_name','ASC') AS $emp){
            $requested =$this->super_model->select_column_where("signatories", "requested", "employee_id", $emp->employee_id);
            $noted =$this->super_model->select_column_where("signatories", "noted", "employee_id", $emp->employee_id);
            $inspected =$this->super_model->select_column_where("signatories", "inspected", "employee_id", $emp->employee_id);
            $delivered =$this->super_model->select_column_where("signatories", "delivered", "employee_id", $emp->employee_id);
            $reviewed =$this->super_model->select_column_where("signatories", "reviewed", "employee_id", $emp->employee_id);
            $received =$this->super_model->select_column_where("signatories", "received", "employee_id", $emp->employee_id);
            $released =$this->super_model->select_column_where("signatories", "released", "employee_id", $emp->employee_id);
            $approved =$this->super_model->select_column_where("signatories", "approved", "employee_id", $emp->employee_id);
            $acknowledged =$this->super_model->select_column_where("signatories", "acknowledged", "employee_id", $emp->employee_id);
            
            $data['employee'][] = array(
                'employeeid'=>$emp->employee_id,
                'employee'=>$emp->employee_name,
                'requested'=>$requested,
                'noted'=>$noted,
                'inspected'=>$inspected,
                'delivered'=>$delivered,
                'reviewed'=>$reviewed,
                'received'=>$received,
                'released'=>$released,
                'approved'=>$approved,
                'acknowledged'=>$acknowledged
            );
        }
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/add_signatory',$data);
        $this->load->view('template/footer');
    }

    public function insert_signatory(){
        $count = $this->input->post('count');
        for($x=1;$x<$count;$x++){
            $employee_id = $this->input->post('employee_id'.$x);
            $requested = $this->input->post('requested'.$x);
            $noted = $this->input->post('noted'.$x);
            $inspected = $this->input->post('inspected'.$x);
            $delivered = $this->input->post('delivered'.$x);
            $reviewed = $this->input->post('reviewed'.$x);
            $received = $this->input->post('received'.$x);
            $released = $this->input->post('released'.$x);
            $approved = $this->input->post('approved'.$x);
            $acknowledged = $this->input->post('acknowledged'.$x);
            if(!empty($requested) || !empty($noted) || !empty($inspected) || !empty($delivered) || !empty($reviewed) || !empty($received) || !empty($released) || !empty($approved) || !empty($acknowledged)){
                if(empty($noted)) $nt = 0;
                else $nt=1;
                if(empty($inspected)) $ins = 0;
                else $ins=1;
                if(empty($delivered)) $del = 0;
                else $del=1;
                if(empty($reviewed)) $rev = 0;
                else $rev=1;
                if(empty($received)) $rec = 0;
                else $rec=1;
                if(empty($released)) $rel = 0;
                else $rel=1;
                if(empty($requested)) $req = 0;
                else $req=1;
                if(empty($approved)) $app = 0;
                else $app=1; 
                if(empty($acknowledged)) $ack = 0;
                else $ack=1; 
                $data = array(
                    'employee_id' => $employee_id, 
                    'requested' => $req,
                    'noted' => $nt,
                    'inspected' => $ins,
                    'delivered' => $del,
                    'reviewed' => $rev,
                    'received' => $rec,
                    'released' => $rel,
                    'approved' => $app,
                    'acknowledged' => $ack
                );
                foreach($this->super_model->select_row_where('employees', 'employee_id', $employee_id) AS $empa){   
                    $row=$this->super_model->count_custom_where('signatories',"employee_id = '$empa->employee_id'"); 
                    if($row>0){
                       if($this->super_model->update_where("signatories", $data,'employee_id',$employee_id)){
                            echo "<script>alert('Successfully Updated!'); 
                                window.location ='".base_url()."index.php/masterfile/signatory'; </script>"; 
                        }
                    }else{
                        if($this->super_model->insert_into("signatories", $data)){
                           echo "<script>alert('Successfully Added!'); 
                                window.location ='".base_url()."index.php/masterfile/signatory'; </script>";
                        }
                    }
                }
            }
        }
    } 

    public function addSignatory(){
        $data = array(
            'form'=>$this->input->post('form'),
            'action'=>$this->input->post('action'),
            'employee_id'=>$this->input->post('employee')
        );
        if($this->super_model->insert_into("signatories", $data)){
           echo "<script>alert('Signatory successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/signatory'; </script>";
         }
    }

    public function add_list(){
        $supplier_code = trim($this->input->post('supplier_code'), " ");
        $supplier_name = trim($this->input->post('supplier_name'), " ");
        $address = trim($this->input->post('address'), " ");
        $contact_number = trim($this->input->post('contact_number'), " ");
        $terms = trim($this->input->post('terms'), " ");
        $data = array(
            'supplier_code'=>$supplier_code,
            'supplier_name'=>$supplier_name,
            'address'=>$address,
            'contact_number'=>$contact_number,
            'terms'=>$terms,
            'active'=>$this->input->post('active')
        );
       if($this->super_model->insert_into("supplier", $data)){
           echo "<script>alert('Successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/supplier_list'; </script>";
       }
    }

    public function add_department(){
        $trim = trim($this->input->post('department')," ");
        $data = array(
            'department_name'=>$trim
        );
       if($this->super_model->insert_into("department", $data)){
           echo "<script>alert('Successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/department_list'; </script>";
       }
    }

    public function add_rack(){
        $trim = trim($this->input->post('rack')," ");
        $data = array(
            'rack_name'=>$trim
        );
       if($this->super_model->insert_into("rack", $data)){
           echo "<script>alert('Successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/rack_list'; </script>";
       }
    }

    public function add_employee(){
        $trim = trim($this->input->post('employee_name')," ");
        $trim1 = trim($this->input->post('department')," ");
        $trim2 = trim($this->input->post('position')," ");
        $trim3 = trim($this->input->post('contact_no')," ");
        $trim4 = trim($this->input->post('em')," ");
        $data = array(
            'employee_name'=>$trim,
            'department'=>$trim1,
            'position'=>$trim2,
            'contact_no'=>$trim3,
            'email'=>$trim4
        );
        if($this->super_model->insert_into("employees", $data)){
            echo "<script>alert('Successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/employee_list'; </script>";
        }
    }

    public function add_warehouse(){
        $warehouse_name = trim($this->input->post('warehouse_name')," ");
        $data = array(
            'warehouse_name'=>$warehouse_name
        );
       if($this->super_model->insert_into("warehouse", $data)){
           echo "<script>alert('Successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/warehouse_list'; </script>";
       }
    }

    public function add_location(){
        $location = trim($this->input->post('location')," ");
        $data = array(
            'location_name'=>$location
        );
       if($this->super_model->insert_into("location", $data)){
           echo "<script>alert('Successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/location_list'; </script>";
       }
    }

    public function add_group(){
        $group = trim($this->input->post('group_name')," ");
        $data = array(
            'group_name'=>$group
        );
       if($this->super_model->insert_into("group", $data)){
           echo "<script>alert('Successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/group_list'; </script>";
       }
    }

    public function add_enduse(){
        $endc = trim($this->input->post('end_code')," ");
        $endn = trim($this->input->post('end_name')," ");
        $data = array(
            'enduse_code'=>$endc,
            'enduse_name'=>$endn
        );
       if($this->super_model->insert_into("enduse", $data)){
           echo "<script>alert('Successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/endUse_list'; </script>";
       }
    }

    public function add_purpose(){
        $purpose = trim($this->input->post('purpose')," ");
        $data = array(
            'purpose_desc'=>$purpose
        );
       if($this->super_model->insert_into("purpose", $data)){
           echo "<script>alert('Successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/purpose_list'; </script>";
       }
    }

     public function add_unit(){
        $unit = trim($this->input->post('unit_name')," ");
        $data = array(
            'unit_name'=>$unit
        );
       if($this->super_model->insert_into("uom", $data)){
           echo "<script>alert('Successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/uom_list'; </script>";
       }
    }

    public function add_category(){
        $rows = $this->super_model->count_rows("item_categories");
        if($rows==0) {
            $cat_code = 'A';
            for ($n=0; $n<0; $n++) {
                echo $cat_code++;
            }
        }
        else{
             $cat_code = $this->super_model->get_max('item_categories', 'cat_code');
             $cat_code++;
        }
        $prefix = trim($this->input->post('prefix')," ");
        $cat_name = trim($this->input->post('category_name')," ");
        $data = array(
            'cat_code'=> $cat_code,
            'cat_prefix'=>$prefix,
            'cat_name'=>$cat_name
        );
        if($this->super_model->insert_into("item_categories", $data)){
           echo "<script>alert('Successfully Added!'); 
                window.location ='".base_url()."index.php/masterfile/category_list'; </script>";
        }
    }

    public function add_subcat(){
        $post = $this->input->post('id');
        $row = $this->super_model->count_rows_where("item_subcat", "cat_id", $post);
        if(empty($row)){
            $add = 1;
            $subcat_code = $this->input->post('cat_code')."-".$add;
        }   
        else {
            $subcat_code = $this->super_model->select_column_where("item_subcat", "subcat_code","cat_id = '$post' ORDER BY subcat_id DESC LIMIT 1");
            /*$subcat_id = $this->super_model->get_max_where("item_subcat", "subcat_id","cat_id = '$post' ORDER BY subcat_id DESC LIMIT 1");*/
            $array = explode("-", $subcat_code);
            $inc = $array[1]+1;
            /*$sub = $subcat_id + 1;*/
            $subcat_code = $array[0]."-".$inc;
        }
        $prefix = trim($this->input->post('prefix')," ");
        $sub_name = trim($this->input->post('subcategory_name')," ");
        $data = array(
            'cat_id'=>$this->input->post('id'),
            'subcat_code'=>$subcat_code,
            'subcat_prefix'=>$prefix,
            'subcat_name'=> $sub_name
        );
        if($this->super_model->insert_into("item_subcat", $data)){
           echo "<script>alert('Successfully Added!'); window.opener.location.reload(); window.close();</script>";
        }
    }

    public function update_uom(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['unit'] = $this->super_model->select_row_where('uom', 'unit_id', $id);
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/update_uom',$data);
        $this->load->view('template/footer');
    }

    public function edit_unit(){
        $data = array(
            'unit_name'=>$this->input->post('unit_name')
        );
        $unit_id = $this->input->post('unit_id');
            if($this->super_model->update_where('uom', $data, 'unit_id', $unit_id)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/masterfile/uom_list'; </script>";
        }
    }

    public function update_rack(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['rack'] = $this->super_model->select_row_where('rack', 'rack_id', $id);
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/update_rack',$data);
        $this->load->view('template/footer');
    }

    public function edit_rack(){
        $data = array(
            'rack_name'=>$this->input->post('rack')
        );
        $rack_id = $this->input->post('rack_id');
            if($this->super_model->update_where('rack', $data, 'rack_id', $rack_id)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/masterfile/rack_list'; </script>";
        }
    }

    public function update_signatory(){
         $data = array(
            'form'=>$this->input->post('form'),
            'action'=>$this->input->post('action'),
            'employee_id'=>$this->input->post('employee'),
        );
        $signid = $this->input->post('signid');
            if($this->super_model->update_where('signatories', $data, 'signatory_id', $signid)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/masterfile/signatory'; </script>";
        }
    }

    public function update_supplier(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['list'] = $this->super_model->select_row_where('supplier', 'supplier_id', $id);
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/update_supplier',$data);
        $this->load->view('template/footer');
    }

    public function update_warehouse(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['warehouse'] = $this->super_model->select_row_where('warehouse', 'warehouse_id', $id);
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/update_warehouse',$data);
        $this->load->view('template/footer');
    }

    public function edit_warehouse(){
        $data = array(
            'warehouse_name'=>$this->input->post('warehouse')
        );
        $warehouse_id = $this->input->post('warehouse_id');
            if($this->super_model->update_where('warehouse', $data, 'warehouse_id', $warehouse_id)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/masterfile/warehouse_list'; </script>";
        }
    }

    public function update_employee(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        /*$data['employee'] = $this->super_model->select_row_where('employees', 'employee_id', $id);*/
        foreach($this->super_model->select_row_where('employees', 'employee_id', $id) AS $emp){
            
            $data['employee'][] = array(
                'employee_id'=>$emp->employee_id,
                'employee'=>$emp->employee_name,
                'department'=>$emp->department,
                'position'=>$emp->position,
                'contact_no'=>$emp->contact_no,
                'email'=>$emp->email
            );
        }
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/update_employee',$data);
        $this->load->view('template/footer');
    }

    public function edit_employee(){
        $data = array(
            'employee_name'=>$this->input->post('employee'),
            'position'=>$this->input->post('position'),
            'department'=>$this->input->post('department'),
            'contact_no'=>$this->input->post('contact_no'),
            'email'=>$this->input->post('email')
        );
        $employee_id = $this->input->post('employee_id');
            if($this->super_model->update_where('employees', $data, 'employee_id', $employee_id)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/masterfile/employee_list'; </script>";
        }
    }

    public function update_list(){
        $data = array(
            'supplier_code'=>$this->input->post('supplier_code'),
            'supplier_name'=>$this->input->post('supplier_name'),
            'address'=>$this->input->post('address'),
            'contact_number'=>$this->input->post('contact_number'),
            'terms'=>$this->input->post('terms'),
            'active'=>$this->input->post('active')
        );
        $supid = $this->input->post('supplier_id');
            if($this->super_model->update_where('supplier', $data, 'supplier_id', $supid)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/masterfile/supplier_list'; </script>";
        }
    }

    public function update_category(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['category'] = $this->super_model->select_row_where('item_categories', 'cat_id', $id);
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/update_category',$data);
        $this->load->view('template/footer');
    }

    public function edit_category(){
        $data = array(
            'cat_prefix'=>$this->input->post('prefix'),
            'cat_name'=>$this->input->post('cat_name')
        );
        $catid = $this->input->post('cat_id');
            if($this->super_model->update_where('item_categories', $data, 'cat_id', $catid)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/masterfile/category_list'; </script>";
        }
    }

    public function update_department(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['department'] = $this->super_model->select_row_where('department', 'department_id', $id);
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/update_department',$data);
        $this->load->view('template/footer');
    }

    public function edit_department(){
        $data = array(
            'department_name'=>$this->input->post('department')
        );
        $depid = $this->input->post('department_id');
            if($this->super_model->update_where('department', $data, 'department_id', $depid)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/masterfile/department_list'; </script>";
        }
    }

    public function update_location(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['location'] = $this->super_model->select_row_where('location', 'location_id', $id);
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/update_location',$data);
        $this->load->view('template/footer');
    }

    public function edit_location(){
        $data = array(
            'location_name'=>$this->input->post('location')
        );
        $locid = $this->input->post('location_id');
            if($this->super_model->update_where('location', $data, 'location_id', $locid)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/masterfile/location_list'; </script>";
        }
    }


    public function update_group(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['group'] = $this->super_model->select_row_where('group', 'group_id', $id);
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/update_group',$data);
        $this->load->view('template/footer');
    }

    public function edit_group(){
        $data = array(
            'group_name'=>$this->input->post('group_name')
        );
        $grpid = $this->input->post('group_id');
            if($this->super_model->update_where('group', $data, 'group_id', $grpid)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/masterfile/group_list'; </script>";
        }
    }

    public function update_end(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['enduse'] = $this->super_model->select_row_where('enduse', 'enduse_id', $id);
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/update_end',$data);
        $this->load->view('template/footer');
    }

    public function edit_end(){
        $data = array(
            'enduse_code'=>$this->input->post('end_code'),
            'enduse_name'=>$this->input->post('end_name')
        );
        $endid = $this->input->post('enduse_id');
            if($this->super_model->update_where('enduse', $data, 'enduse_id', $endid)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/masterfile/endUse_list'; </script>";
        }
    }

    public function update_purpose(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['purpose'] = $this->super_model->select_row_where('purpose', 'purpose_id', $id);
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/update_purpose',$data);
        $this->load->view('template/footer');
    }

    public function edit_purpose(){
        $data = array(
            'purpose_desc'=>$this->input->post('purpose'),
        );
        $purid = $this->input->post('purpose_id');
            if($this->super_model->update_where('purpose', $data, 'purpose_id', $purid)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/masterfile/purpose_list'; </script>";
        }
    }

    public function delete_category(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('item_categories', 'cat_id', $id)){
            echo "<script>alert('Succesfully Deleted'); 
                window.location ='".base_url()."index.php/masterfile/category_list'; </script>";
        }
    }

    public function delete_list(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('supplier', 'supplier_id', $id)){
            echo "<script>alert('Succesfully deleted'); 
                window.location ='".base_url()."index.php/masterfile/supplier_list'; </script>";
        }
    }

    public function delete_department(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('department', 'department_id', $id)){
            echo "<script>alert('Succesfully Deleted'); 
                window.location ='".base_url()."index.php/masterfile/department_list'; </script>";
        }
    }
    public function delete_employee(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('employees', 'employee_id', $id)){
            echo "<script>alert('Succesfully Deleted'); 
                window.location ='".base_url()."index.php/masterfile/employee_list'; </script>";
        }
    }

    public function delete_uom(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('uom', 'unit_id', $id)){
            echo "<script>alert('Succesfully Deleted'); 
                window.location ='".base_url()."index.php/masterfile/uom_list'; </script>";
        }
    }

    public function delete_rack(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('rack', 'rack_id', $id)){
            echo "<script>alert('Succesfully Deleted'); 
                window.location ='".base_url()."index.php/masterfile/rack_list'; </script>";
        }
    }

    public function delete_warehouse(){
        $id=$this->uri->segment(3);
     
        if($this->super_model->delete_where('warehouse', 'warehouse_id', $id)){
            echo "<script>alert('Succesfully Deleted'); 
                window.location ='".base_url()."index.php/masterfile/warehouse_list'; </script>";
        }
    }

    public function delete_location(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('location', 'location_id', $id)){
            echo "<script>alert('Succesfully Deleted'); 
                window.location ='".base_url()."index.php/masterfile/location_list'; </script>";
        }
    }

    public function delete_group(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('group', 'group_id', $id)){
            echo "<script>alert('Succesfully Deleted'); 
                window.location ='".base_url()."index.php/masterfile/group_list'; </script>";
        }
    }

    public function delete_end(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('enduse', 'enduse_id', $id)){
            echo "<script>alert('Succesfully Deleted'); 
                window.location ='".base_url()."index.php/masterfile/endUse_list'; </script>";
        }
    }

    public function delete_purpose(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('purpose', 'purpose_id', $id)){
            echo "<script>alert('Succesfully Deleted'); 
                window.location ='".base_url()."index.php/masterfile/purpose_list'; </script>";
        }
    }

    public function delete_sign(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('signatories', 'signatory_id', $id)){
            echo "<script>alert('Succesfully deleted'); 
                window.location ='".base_url()."index.php/masterfile/signatory'; </script>";
        }
    }


     public function import_items(){
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/import_items',$data);
        $this->load->view('template/footer');
    }

    public function upload_excel(){
         $dest= realpath(APPPATH . '../uploads/excel/');
         $error_ext=0;
        if(!empty($_FILES['excelfile']['name'])){
            $exc= basename($_FILES['excelfile']['name']);
            $exc=explode('.',$exc);
            $ext1=$exc[1];
            if($ext1=='php' || $ext1!='xlsx'){
                $error_ext++;
            } 
            else {
                $filename1='item_inventory.'.$ext1;
               /* echo $dest."\/".$filename1;*/
                if(move_uploaded_file($_FILES["excelfile"]['tmp_name'], $dest.'/'.$filename1)){
                    $this->readExcel_inv();
                }        
            }
        }
    }

    public function readExcel_inv(){
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $inputFileName =realpath(APPPATH.'../uploads/excel/item_inventory.xlsx');

       // echo $inputFileName;
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } 
        catch(Exception $e) {
            die('Error loading file"'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
        $highestRow = $objPHPExcel->getActiveSheet()->getHighestRow(); 
        for($x=2;$x<=$highestRow;$x++){
            $desc = $objPHPExcel->getActiveSheet()->getCell('A'.$x)->getValue();
            $cat_id = trim($objPHPExcel->getActiveSheet()->getCell('B'.$x)->getValue());
            $subcat_id = trim($objPHPExcel->getActiveSheet()->getCell('C'.$x)->getValue());
            $prefix = trim($objPHPExcel->getActiveSheet()->getCell('D'.$x)->getValue());
            $unit = trim($objPHPExcel->getActiveSheet()->getCell('E'.$x)->getValue());
            $pn = trim($objPHPExcel->getActiveSheet()->getCell('F'.$x)->getValue());
            $rack_id = trim($objPHPExcel->getActiveSheet()->getCell('G'.$x)->getValue());
            $group_id = trim($objPHPExcel->getActiveSheet()->getCell('H'.$x)->getValue());
            $wh_id = trim($objPHPExcel->getActiveSheet()->getCell('I'.$x)->getValue());
            $location_id = trim($objPHPExcel->getActiveSheet()->getCell('J'.$x)->getValue());
            if(empty($pn)){
                $count=$this->super_model->count_rows_where("pn_series","subcat_prefix",$prefix);
                if($count==0){
                    $newpn='1001';
                    $orig_pn = $prefix."_".$newpn;
                } else {
                    $maxid=$this->super_model->get_max_where("pn_series", "series", "subcat_prefix = '$prefix'");
                    $newpn=$maxid+1;
                    $orig_pn = $prefix."_".$newpn;
                }
                $data_pn = array(
                    'subcat_prefix'=>$prefix,
                    'series'=>$newpn
                );
                $this->super_model->insert_into("pn_series", $data_pn);
                $data_items = array(
                    'item_name'=>$desc,
                    'category_id'=>$cat_id,
                    'subcat_id'=>$subcat_id,
                    'unit_id'=>$unit,
                    'original_pn'=>$orig_pn,
                    'rack_id'=>$rack_id,
                    'group_id'=>$group_id,
                    'warehouse_id'=>$wh_id,
                    'location_id'=>$location_id,
                );

                //print_r($data_items);
                $this->super_model->insert_into("items", $data_items);
            } 
            else {
                $data_items = array(
                    'item_name'=>$desc,
                    'category_id'=>$cat_id,
                    'subcat_id'=>$subcat_id,
                    'unit_id'=>$unit,
                    'original_pn'=>$pn,
                    'rack_id'=>$rack_id,
                    'group_id'=>$group_id,
                    'warehouse_id'=>$wh_id,
                    'location_id'=>$location_id,
                );
                //print_r($data_items);
                $this->super_model->insert_into("items", $data_items);
            }
        }
        echo "<script>alert('Successfully uploaded!'); window.location = 'import_items';</script>";
    }

    public function export_inventory(){
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="inventory_format.xlsx";
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Cat ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "Subcat ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "Subcat Prefix");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', "UOM ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "PN No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', "Rack ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "Group ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', "WH ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', "Location ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', "Instructions:");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', "Get Cat ID, Subcat ID, Subcat Prefix, UOM ID, Rack ID, Group ID, WH ID and Location ID in the reference sheet");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "Leave PN No. column blank if there's none, system will generate pn no. if empty");
        $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);

        $Category = $objPHPExcel->createSheet();
        $Category->setTitle("Category");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', "Cat/Subcat ID");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B1', "Category/Subcategory Name");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C1', "Subcategory Prefix");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G1', "Instructions:");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G2', "Highlighted in yellow are the categories");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G3', "Below are its subcategories");
        $num = 2;
       // $num1=3;
        foreach($this->super_model->select_all("item_categories") AS $cat){
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":C".$num)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$num, $cat->cat_id);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$num, $cat->cat_name);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":C".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$num)->getFont()->setBold(true);
            foreach($this->super_model->select_row_where("item_subcat","cat_id",$cat->cat_id) AS $sub){
                $num++;
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$num, $sub->subcat_id);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$num, $sub->subcat_name);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$num, $sub->subcat_prefix);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            } 
            $num++;
        }
        $Rack = $objPHPExcel->createSheet();
        $Rack->setTitle("Rack");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A1', "Rack ID");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B1', "Rack Name");
        $num=2;
        foreach($this->super_model->select_all("rack") AS $rack){
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A'.$num, $rack->rack_id);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B'.$num, $rack->rack_name);
            $num++;
        }

        $Group = $objPHPExcel->createSheet();
        $Group->setTitle("Group");
            $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A1', "Group ID");
            $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B1', "Group Name");
            $num=2;
            foreach($this->super_model->select_all("group") AS $group){
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A'.$num, $group->group_id);
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B'.$num, $group->group_name);
                $num++;
            }
        $location = $objPHPExcel->createSheet();
        $location->setTitle("Location");
            $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A1', "Location ID");
            $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B1', "Location Name");
            $num=2;
            foreach($this->super_model->select_all("location") AS $location){
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A'.$num, $location->location_id);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B'.$num, $location->location_name);
                $num++;
            }
        $warehouse = $objPHPExcel->createSheet();
        $warehouse->setTitle("Warehouse");
            $objPHPExcel->setActiveSheetIndex(5)->setCellValue('A1', "Warehouse ID");
            $objPHPExcel->setActiveSheetIndex(5)->setCellValue('B1', "Warehouse Name");
            $num=2;
            foreach($this->super_model->select_all("warehouse") AS $warehouse){
                $objPHPExcel->setActiveSheetIndex(5)->setCellValue('A'.$num, $warehouse->warehouse_id);
                $objPHPExcel->setActiveSheetIndex(5)->setCellValue('B'.$num, $warehouse->warehouse_name);
                $num++;
            }
        $uom = $objPHPExcel->createSheet();
        $uom->setTitle("UOM");
            $objPHPExcel->setActiveSheetIndex(6)->setCellValue('A1', "UOM ID");
            $objPHPExcel->setActiveSheetIndex(6)->setCellValue('B1', "UOM Name");
            $num=2;
            foreach($this->super_model->select_all("uom") AS $uom){
                $objPHPExcel->setActiveSheetIndex(6)->setCellValue('A'.$num, $uom->unit_id);
                $objPHPExcel->setActiveSheetIndex(6)->setCellValue('B'.$num, $uom->unit_name);
                $num++;
            }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="inventory_format.xlsx"');
        readfile($exportfilename);
        echo "<script>window.location = 'import_items';</script>";
    }

    public function upload_excel_current(){
         $dest= realpath(APPPATH . '../uploads/excel/');
         $error_ext=0;
        if(!empty($_FILES['excelfile_cur']['name'])){
             $exc= basename($_FILES['excelfile_cur']['name']);
             $exc=explode('.',$exc);
             $ext1=$exc[1];
            if($ext1=='php' || $ext1!='xlsx'){
                $error_ext++;
            } 
            else {
                 $filename1='current_inventory.'.$ext1;
                if(move_uploaded_file($_FILES["excelfile_cur"]['tmp_name'], $dest.'/'.$filename1)){
                    $this->readExcel_cur();
                }   
            }
        }
    }

    public function readExcel_cur(){
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $inputFileName =realpath(APPPATH.'../uploads/excel/current_inventory.xlsx');
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch(Exception $e) {
            die('Error loading file"'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }

        $highestRow = $objPHPExcel->getActiveSheet()->getHighestRow(); 
        for($x=2;$x<=$highestRow;$x++){
            $itemid = trim($objPHPExcel->getActiveSheet()->getCell('A'.$x)->getValue());
            $itemdesc = trim($objPHPExcel->getActiveSheet()->getCell('B'.$x)->getValue());
            $cat = trim($objPHPExcel->getActiveSheet()->getCell('C'.$x)->getValue());
            $subcat = trim($objPHPExcel->getActiveSheet()->getCell('D'.$x)->getValue());
            $prefix = trim($objPHPExcel->getActiveSheet()->getCell('E'.$x)->getValue());
            $unit = trim($objPHPExcel->getActiveSheet()->getCell('F'.$x)->getValue());
            $pn = trim($objPHPExcel->getActiveSheet()->getCell('G'.$x)->getValue());
            $rack = trim($objPHPExcel->getActiveSheet()->getCell('H'.$x)->getValue());
            $group = trim($objPHPExcel->getActiveSheet()->getCell('I'.$x)->getValue());
            $wh = trim($objPHPExcel->getActiveSheet()->getCell('J'.$x)->getValue());
            $location = trim($objPHPExcel->getActiveSheet()->getCell('K'.$x)->getValue());
            $data_items = array(
                'item_name'=>$itemdesc,
                'category_id'=>$cat,
                'subcat_id'=>$subcat,
                'unit_id'=>$unit,
                'original_pn'=>$pn,
                'rack_id'=>$rack,
                'group_id'=>$group,
                'warehouse_id'=>$wh,
                'location_id'=>$location
            );
            $this->super_model->update_where("items", $data_items, "item_id", $itemid);
        }
        echo "<script>alert('Successfully Updated!'); window.location = 'import_items';</script>";
    }

    public function export_current(){
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="current_inventory_format.xlsx";
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "Cat ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "Subcat ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', "Subcat Prefix");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "Unit");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', "PN No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "Rack ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', "Group ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', "WH ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', "Location ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', "Instructions:");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', "Get Cat ID, Subcat CatID and Subcat Prefix in the reference sheet");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "Leave PN No. column blank if there's none, system will generate if empty");
        $num=2;
        foreach($this->super_model->select_all("items") AS $items){
            $prefix =$this->super_model->select_column_where("item_subcat","subcat_prefix", "subcat_id", $items->subcat_id);
            $unit =$this->super_model->select_column_where("uom","unit_name", "unit_id", $items->unit_id);
            $rack =$this->super_model->select_column_where("rack","rack_name", "rack_id", $items->rack_id);
            $group =$this->super_model->select_column_where("group","group_name", "group_id", $items->group_id);
            $wh =$this->super_model->select_column_where("warehouse","warehouse_name", "warehouse_id", $items->warehouse_id);
            $location =$this->super_model->select_column_where("location","location_name", "location_id", $items->location_id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $items->item_id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $items->item_name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num, $items->category_id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $items->subcat_id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $prefix);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $unit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $items->original_pn);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $rack);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$num, $group);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$num, $wh);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$num, $location);
            $num++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);

        $Category = $objPHPExcel->createSheet();
        $Category->setTitle("Category");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', "Cat/Subcat ID");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B1', "Category/Subcategory Name");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C1', "Subcategory Prefix");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G1', "Instructions:");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G2', "Highlighted in yellow are the categories");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G3', "Below are its subcategories");
        $num = 2;
       // $num1=3;
        foreach($this->super_model->select_all("item_categories") AS $cat){
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":C".$num)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$num, $cat->cat_id);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$num, $cat->cat_name);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":C".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$num)->getFont()->setBold(true);
            foreach($this->super_model->select_row_where("item_subcat","cat_id",$cat->cat_id) AS $sub){
                $num++;
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$num, $sub->subcat_id);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$num, $sub->subcat_name);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$num, $sub->subcat_prefix);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            } 
            $num++;
        }
        $Rack = $objPHPExcel->createSheet();
        $Rack->setTitle("Rack");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A1', "Rack ID");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B1', "Rack Name");
        $num=2;
        foreach($this->super_model->select_all("rack") AS $rack){
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A'.$num, $rack->rack_id);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B'.$num, $rack->rack_name);
            $num++;
        }

        $Group = $objPHPExcel->createSheet();
        $Group->setTitle("Group");
            $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A1', "Group ID");
            $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B1', "Group Name");
            $num=2;
            foreach($this->super_model->select_all("group") AS $group){
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A'.$num, $group->group_id);
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B'.$num, $group->group_name);
                $num++;
            }
        $location = $objPHPExcel->createSheet();
        $location->setTitle("Location");
            $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A1', "Location ID");
            $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B1', "Location Name");
            $num=2;
            foreach($this->super_model->select_all("location") AS $location){
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A'.$num, $location->location_id);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B'.$num, $location->location_name);
                $num++;
            }
        $warehouse = $objPHPExcel->createSheet();
        $warehouse->setTitle("Warehouse");
            $objPHPExcel->setActiveSheetIndex(5)->setCellValue('A1', "Warehouse ID");
            $objPHPExcel->setActiveSheetIndex(5)->setCellValue('B1', "Warehouse Name");
            $num=2;
            foreach($this->super_model->select_all("warehouse") AS $warehouse){
                $objPHPExcel->setActiveSheetIndex(5)->setCellValue('A'.$num, $warehouse->warehouse_id);
                $objPHPExcel->setActiveSheetIndex(5)->setCellValue('B'.$num, $warehouse->warehouse_name);
                $num++;
            }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="current_inventory_format.xlsx"');
        readfile($exportfilename);
        echo "<script>window.location = 'import_items';</script>";
    }
     
    public function export_begbal(){
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="begbal_format.xlsx";
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Item ID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "Remarks");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "Quantity");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', "Instructions:");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', "Just fill out quantity column. Do not edit other columns.");
        $num=2;
        foreach($this->super_model->select_all("items") AS $items){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $items->item_id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $items->item_name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num, 'begbal');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, '');
            $num++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="begbal_format.xlsx"');
        readfile($exportfilename);
        echo "<script>window.location = 'import_items';</script>";
    }

    public function upload_excel_begbal(){
         $dest= realpath(APPPATH . '../uploads/excel/');
         $error_ext=0;
        if(!empty($_FILES['excelfile_begbal']['name'])){
             $exc= basename($_FILES['excelfile_begbal']['name']);
             $exc=explode('.',$exc);
             $ext1=$exc[1];
            if($ext1=='php' || $ext1!='xlsx'){
                $error_ext++;
            } 
            else {
                 $filename1='beginning_bal.'.$ext1;
                if(move_uploaded_file($_FILES["excelfile_begbal"]['tmp_name'], $dest.'/'.$filename1)){
                    $this->readExcel_begbal();
                }   
            }
        }
    }

    public function readExcel_begbal(){
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $inputFileName =realpath(APPPATH.'../uploads/excel/beginning_bal.xlsx');
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch(Exception $e) {
            die('Error loading file"'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }

        $highestRow = $objPHPExcel->getActiveSheet()->getHighestRow(); 
        for($x=2;$x<=$highestRow;$x++){
            $itemid = trim($objPHPExcel->getActiveSheet()->getCell('A'.$x)->getValue());
            $catalog = trim($objPHPExcel->getActiveSheet()->getCell('C'.$x)->getValue());
            $qty = trim($objPHPExcel->getActiveSheet()->getCell('D'.$x)->getValue());
            $count=$this->super_model->count_rows_where("supplier_items","item_id",$itemid);
            if($count!=0){
                $this->super_model->delete_where("supplier_items", "item_id",$itemid);
            }
            $data_items = array(
                'item_id'=>$itemid,
                'catalog_no'=>$catalog,
                'quantity'=>$qty
            );
            $this->super_model->insert_into("supplier_items", $data_items);
        }
        echo "<script>alert('Successfully uploaded!'); window.location = 'import_items';</script>";
    }

       public function reminder_list(){
        foreach($this->super_model->select_row_where_order_by("reminders", "done", "1", "reminder_date", "DESC") AS $rem){
            $data['reminders'][]=array(
                "reminder_id"=>$rem->reminder_id,
                "reminder_date"=>$rem->reminder_date,
                "title"=>$rem->reminder_title,
                "notes"=>$rem->notes,
                "employee"=>$this->super_model->select_column_where("employees", "employee_name", "employee_id", $rem->remind_employee),
                "done_date"=>$rem->date_done,
                "done_by"=>$this->super_model->select_column_where("users", "username", "user_id", $rem->done_by)
            );
        }
        $data['employee'] = $this->super_model->select_all_order_by('employees', 'employee_name', 'ASC');
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('masterfile/reminder_list',$data);
        $this->load->view('template/footer');
    }

    public function addreminder(){
        $data = array(
            "reminder_date"=>$this->input->post('reminder_date'),
            "reminder_title"=>$this->input->post('reminder_title'),
            "notes"=>$this->input->post('reminder_notes'),
            "remind_employee"=>$this->input->post('remind_person'),
            "user_id"=>$this->input->post('userid')
        );
         if($this->super_model->insert_into("reminders", $data)){
            ?>
            <script>alert('Reminder added!'); window.location= '<?php echo base_url(); ?>index.php/masterfile/home'; </script>
            <?php
         }
    }

    public function update_reminder(){
        $reminder_id=$this->input->post('reminder_id');
        $data = array(
            "reminder_date"=>$this->input->post('reminder_date'),
            "reminder_title"=>$this->input->post('reminder_title'),
            "notes"=>$this->input->post('reminder_notes'),
            "remind_employee"=>$this->input->post('remind_person'),
        );
         if($this->super_model->update_where("reminders", $data, "reminder_id", $reminder_id)){
            ?>
            <script>alert('Reminder Updated!'); window.location= '<?php echo base_url(); ?>index.php/masterfile/home'; </script>
            <?php
         }
    }

    public function reminderdone(){
        $id=$this->uri->segment(3);
        $userid=$_SESSION['user_id'];
        $date=date('Y-m-d H:i:s');
        $data = array(
            "done"=>'1',
            "date_done"=>$date,
            "done_by"=>$userid
        );

        if($this->super_model->update_where("reminders", $data, "reminder_id", $id)){
            ?><script>alert('Reminder tagged as done.'); window.location = '<?php echo base_url(); ?>index.php/masterfile/home'; </script>
            <?php
        }
    }
}
?>
