<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issue extends CI_Controller {

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
        $this->dropdown['pr_list']=$this->super_model->custom_query("SELECT pr_no, enduse_id, purpose_id,department_id FROM receive_head INNER JOIN receive_details WHERE saved='1' GROUP BY pr_no");
       // $this->dropdown['prno'] = $this->super_model->select_join_where("receive_details","receive_head", "saved='1' AND create_date BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE()","receive_id");
        //$this->dropdown['prno'] = $this->super_model->select_join_where_order("receive_details","receive_head", "saved='1'","receive_id", "receive_date", "DESC");

        
       foreach($this->super_model->select_custom_where_group("receive_details", "closed=0", "pr_no") AS $dtls){
            foreach($this->super_model->select_custom_where("receive_head", "receive_id = '$dtls->receive_id'") AS $gt){
               if($gt->saved=='1'){
                    $this->dropdown['prno'][] = $dtls->pr_no;
               }
            }  
        }

        if(isset($_SESSION['user_id'])){
            $sessionid= $_SESSION['user_id'];
          
            foreach($this->super_model->get_table_columns("access_rights") AS $col){
                $this->access[$col]=$this->super_model->select_column_where("access_rights",$col, "user_id", $sessionid);
                $this->dropdown[$col]=$this->super_model->select_column_where("access_rights",$col, "user_id", $sessionid);
                
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

   
    public function load_issue_old(){
        $id=$this->uri->segment(3);
        $data['id']=$id;
        $saved = $this->super_model->select_column_where("issuance_head", "saved", "request_id", $id);
      //  $saved=0;
        echo $saved;
        if($saved==0){
        
         echo 'zero';
            foreach($this->super_model->select_row_where("request_head", "request_id", $id) AS $hd){
                $mif = $this->super_model->select_column_where("issuance_head", "mif_no", "request_id", $id);
                $saved = $this->super_model->select_column_where("issuance_head", "saved", "request_id", $id);
                $issueid = $this->super_model->select_column_where("issuance_head", "issuance_id", "request_id", $id);
                $data['head'][] = array(
                    "issueid"=>$issueid,
                    "requestid"=>$id,
                    "mif"=>$mif,
                    "mreqf_no"=>$hd->mreqf_no,
                    "request_date"=>$hd->request_date,
                    "request_time"=>$hd->request_time,
                    "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $hd->department_id),
                    "purpose"=>$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $hd->purpose_id),
                    "enduse"=>$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $hd->enduse_id),
                    "prno"=>$hd->pr_no,
                    "borrowfrom"=>$hd->borrowfrom_pr,
                    "remarks"=>$hd->remarks,
                    "saved"=>$saved

                );
            }
            $x=0;
            foreach($this->super_model->select_row_where("request_items", "request_id", $id) AS $it){
                //echo $it->rq_id;
                $issue_qty = $this->super_model->select_column_where("issuance_details", "quantity", "rq_id", $it->rq_id);
                $remarks = $this->super_model->select_column_where("issuance_details", "remarks", "rq_id", $it->rq_id);
                $issueid = $this->super_model->select_column_where("issuance_details", "issuance_id", "rq_id", $it->rq_id);
                $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $it->unit_id);
              
                $data['items'][] = array(
                    "rqid"=>$it->rq_id,
                    "catalog_no"=>$it->catalog_no,
                    "uom"=>$unit,
                    "quantity"=>$it->quantity,
                    "pn_no"=>$it->pn_no,
                    "item"=>$this->super_model->select_column_where("items", "item_name", "item_id", $it->item_id),
                    "supplier"=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $it->supplier_id),
                    "brand"=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $it->brand_id),
                  
                    "item_id"=>$it->item_id,
                    "supplier_id"=>$it->supplier_id,
                    "brand_id"=>$it->brand_id,
                    "issue_qty"=>$issue_qty,
                    "remarks"=>$remarks,
                    "issueid"=>$issueid

                );

                 $siid=$this->super_model->select_column_custom_where("supplier_items", "si_id", "item_id = '$it->item_id' AND supplier_id = '$it->supplier_id' AND brand_id ='$it->brand_id' AND catalog_no = '$it->catalog_no'"); 
                 $data['serial'][$x]=$this->super_model->select_row_where("serial_number", "si_id", $siid);
                 $x++;
             }
            
        }  else {
        
            echo "nnot";
             foreach($this->super_model->select_row_where("issuance_head", "request_id", $id) AS $is){

                $deptid = $this->super_model->select_column_where("request_head", "department_id", "request_id", $id);
                $dept=$this->super_model->select_column_where("department", "department_name", "department_id", $deptid);
                $purpid = $this->super_model->select_column_where("request_head", "purpose_id", "request_id", $id);
                $purp=$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $purpid);
                $endid = $this->super_model->select_column_where("request_head", "enduse_id", "request_id", $id);
                $enduse=$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $endid);
                $remarks = $this->super_model->select_column_where("request_head", "remarks", "request_id", $id);
                 $data['head'][] = array(
                        "issueid"=>$is->issuance_id,
                        "requestid"=>$id,
                        "mif"=>$is->mif_no,
                        "mreqf_no"=>$is->mreqf_no,
                        "request_date"=>$is->issue_date,
                        "request_time"=>$is->issue_time,
                        "department"=>$dept,
                        "purpose"=>$purp,
                        "enduse"=>$enduse,
                        "prno"=>$is->pr_no,
                        "remarks"=>$remarks,
                        "saved"=>$is->saved

                    );

                foreach($this->super_model->select_row_where("issuance_details", "issuance_id", $is->issuance_id) AS $it){
                    $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $it->unit_id);
                    $data['items'][] = array(
                        "rqid"=>$it->rq_id,
                        "catalog_no"=>$it->catalog_no,
                        "uom"=>$unit,
                        "quantity"=>$it->quantity,
                        "pn_no"=>$it->pn_no,
                        "item"=>$this->super_model->select_column_where("items", "item_name", "item_id", $it->item_id),
                        "supplier"=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $it->supplier_id),
                        "brand"=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $it->brand_id),
                        "serial"=>$this->super_model->select_column_where("serial_number", "serial_no", "serial_id", $it->serial_id),
                        "item_id"=>$it->item_id,
                        "supplier_id"=>$it->supplier_id,
                        "brand_id"=>$it->brand_id,
                        "issue_qty"=>$it->quantity,
                        "remarks"=>$it->remarks,
                        "issueid"=>$it->issuance_id

                    );

                   $siid=$this->super_model->select_column_custom_where("supplier_items", "si_id", "item_id = '$it->item_id' AND supplier_id = '$it->supplier_id' AND brand_id ='$it->brand_id' AND catalog_no = '$it->catalog_no'"); 
                   $data['serial']=$this->super_model->select_row_where("serial_number", "si_id", $siid);

                }
            }
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('issue/load_issue',$data);
        $this->load->view('template/footer');
    }

    public function inventory_balance($itemid){
        $begbal= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id='$itemid' AND catalog_no = 'begbal'");
        $recqty= $this->super_model->select_sum_join("received_qty","receive_items","receive_head", "item_id='$itemid' AND saved='1'","receive_id");
        $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND saved='1'","issuance_id");
        $restockqty= $this->super_model->select_sum_join("quantity","restock_details","restock_head", "item_id='$itemid' AND saved='1' AND excess='0'","rhead_id");
        $balance=($recqty+$begbal+$restockqty)-$issueqty;
        return $balance;
    }

    public function load_issue(){
        $id=$this->uri->segment(3);
        $data['id']=$id;
    
        $year=date('Y-m');
        $year_series=date('Y');
       
        $data['mreqf_list']=$this->super_model->select_custom_where("request_head","saved = '1'");
        $rows=$this->super_model->count_custom_where("issuance_head","create_date LIKE '$year_series%'");
        if($rows==0){
             $mifno = "MIF-".$year."-0001";
        } else {
            $maxrecno=$this->super_model->get_max_where("issuance_head", "mif_no","create_date LIKE '$year_series%'");
            $recno = explode('-',$maxrecno);
           
            $series = $recno[3]+1;
            if(strlen($series)==1){
                $mifno = "MIF-".$year."-000".$series;
            } else if(strlen($series)==2){
                 $mifno = "MIF-".$year."-00".$series;
            } else if(strlen($series)==3){
                 $mifno = "MIF-".$year."-0".$series;
            } else if(strlen($series)==4){
                 $mifno = "MIF-".$year."-".$series;
            }
        }
        
            foreach($this->super_model->select_row_where("request_head", "request_id", $id) AS $hd){
              
                $saved = $this->super_model->select_column_where("issuance_head", "saved", "request_id", $id);
                $issueid = $this->super_model->select_column_where("issuance_head", "issuance_id", "request_id", $id);
                $data['head'][] = array(
                    "issueid"=>$issueid,
                    "requestid"=>$id,
                    "mif"=>$mifno,
                    "mreqf_no"=>$hd->mreqf_no,
                    "request_date"=>$hd->request_date,
                    "request_time"=>$hd->request_time,
                    "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $hd->department_id),
                    "purpose"=>$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $hd->purpose_id),
                    "enduse"=>$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $hd->enduse_id),
                    "type"=>$hd->type,
                    "prno"=>$hd->pr_no,
                    "borrowfrom"=>$hd->borrowfrom_pr,
                    "remarks"=>$hd->remarks,

                );
            }
            $x=0;
            foreach($this->super_model->select_row_where("request_items", "request_id", $id) AS $it){
                //echo $it->rq_id;
                //$issue_qty = $this->super_model->select_column_where("issuance_details", "quantity", "rq_id", $it->rq_id);
                //$remarks = $this->super_model->select_column_where("issuance_details", "remarks", "rq_id", $it->rq_id);
                $remarks = $this->super_model->select_column_where("request_head", "remarks", "request_id", $it->request_id);
                $issueid = $this->super_model->select_column_where("issuance_details", "issuance_id", "rq_id", $it->rq_id);
                $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $it->unit_id);
                $issued_qty = $this->super_model->select_sum_join("quantity","issuance_head","issuance_details", "request_id = '$id' AND item_id ='$it->item_id' AND rq_id = '$it->rq_id'","issuance_id");

                $rem_qty = $it->quantity - $issued_qty;
                $inv_qty =$this->inventory_balance($it->item_id);
                $data['items'][] = array(
                    "rqid"=>$it->rq_id,
                    "catalog_no"=>$it->catalog_no,
                    "uom"=>$unit,
                    "rem_quantity"=>$rem_qty,
                     "quantity"=>$it->quantity,
                    "pn_no"=>$it->pn_no,
                    "item"=>$this->super_model->select_column_where("items", "item_name", "item_id", $it->item_id),
                    "supplier"=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $it->supplier_id),
                    "brand"=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $it->brand_id),
                  
                    "item_id"=>$it->item_id,
                    "supplier_id"=>$it->supplier_id,
                    "brand_id"=>$it->brand_id,
                    "issue_qty"=>$issued_qty,
                    "remarks"=>$remarks,
                    "inv_qty"=>$inv_qty,
                    "issueid"=>$issueid

                );

                 $siid=$this->super_model->select_column_custom_where("supplier_items", "si_id", "item_id = '$it->item_id' AND supplier_id = '$it->supplier_id' AND brand_id ='$it->brand_id' AND catalog_no = '$it->catalog_no'"); 
                 $data['serial'][$x]=$this->super_model->select_row_where("serial_number", "si_id", $siid);
                 $x++;
             }
            
         
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('issue/load_issue',$data);
        $this->load->view('template/footer');
    }

    public function getMreqfinformation(){
        $mreqf = $this->input->post('mreqf');
        foreach($this->super_model->custom_query("SELECT mreqf_no, request_id FROM request_head WHERE mreqf_no LIKE '%$mreqf%' AND saved = '1'") AS $mr){ 
            $return = array('mreqf' => $mr->mreqf_no, 'request_id' => $mr->request_id); 
            echo json_encode($return);   
        }
    }

    public function mreqflist(){
        $mreqf=$this->input->post('mreqf');

        $rows=$this->super_model->count_custom_where("request_head","mreqf_no LIKE '%$mreqf%' AND saved = '1'");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("request_head","mreqf_no LIKE '%$mreqf%' AND saved = '1'") AS $mr){ 
                    ?>
                   <li onClick="selectMreqF('<?php echo $mr->mreqf_no; ?>','<?php echo $mr->request_id; ?>')"><strong><?php echo $mr->mreqf_no;?> </strong></li>
                <?php 
            }
             echo "<ul>";
        }
    }

   

    public function view_issue(){
        $rows= $this->super_model->count_rows("issuance_head");
        if($rows!=0){
            foreach($this->super_model->select_all("issuance_head") AS $issue){
                $department = $this->super_model->select_column_where("department", "department_name", "department_id", $issue->department_id);
                $purpose = $this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $issue->purpose_id);
                $enduse = $this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $issue->enduse_id);
                 $type=  $this->super_model->select_column_where("request_head", "type", "mreqf_no", $issue->mreqf_no);
                $data['issue_list'][] = array(
                    'issuance_id'=>$issue->issuance_id,
                    'mifno'=>$issue->mif_no,
                    'mreqf'=>$issue->mreqf_no,
                    'prno'=>$issue->pr_no,
                    'date'=>$issue->issue_date,
                    'time'=>$issue->issue_time,
                    'type'=>$type,
                    'department'=>$department,
                    'purpose'=>$purpose,
                    'enduse'=>$enduse
                );
            }
        } else {
            $data['issue_list'] = array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('issue/view_issue',$data);
        $this->load->view('template/footer');
    }

    public function edit_endpurp(){  
        $this->load->view('template/header');
        $data['id']=$this->input->post('id');
        $id=$this->input->post('id');
        $data['end'] = $this->super_model->select_all_order_by('enduse', 'enduse_id', 'ASC');
        $data['purp'] = $this->super_model->select_all_order_by('purpose', 'purpose_id', 'ASC');
        $data['dept'] = $this->super_model->select_all_order_by('department', 'department_id', 'ASC');
        foreach($this->super_model->select_row_where('issuance_head', 'issuance_id', $id) AS $i){
            $data['issue_list'][]=array(
                'purpose_id'=>$i->purpose_id,
                'enduse_id'=>$i->enduse_id,
                'department_id'=>$i->department_id,
            );
        }
        $this->load->view('issue/edit_endpurp',$data);
    }

    public function update_purend(){
        $data = array(
            'purpose_id'=>$this->input->post('purpose'),
            'enduse_id'=>$this->input->post('enduse'),
            'department_id'=>$this->input->post('department'),
        );
        $issuance_id = $this->input->post('issuance_id');
        if($this->super_model->update_where('issuance_head', $data, 'issuance_id', $issuance_id)){
            echo "<script>alert('Successfully Updated!'); 
                window.location ='".base_url()."index.php/issue/view_issue'; </script>";
        }
    }

    public function new_inv_balance($itemid, $pr_no){

       // echo "SELECT SUM(ri.received_qty) AS rqty FROM receive_details rd INNER JOIN receive_items ri ON rd.rd_id = ri.rd_id WHERE ri.item_id = '$itemid' AND rd.pr_no = '$prno'<br>";
        if(empty($pr_no)){
            $prno = "pr_no = ''";
            $frompr = "from_pr = ''";
        } else {
            $prno = "pr_no = '".$pr_no."'";
            $frompr = "from_pr = '".$pr_no."'";
        }
        
     /*   return "SELECT SUM(ri.received_qty) AS rqty FROM receive_details rd INNER JOIN receive_items ri ON rd.rd_id = ri.rd_id WHERE ri.item_id = '$itemid'";*/
     
        /*foreach($this->super_model->custom_query("SELECT SUM(ri.received_qty) AS rqty FROM receive_details rd INNER JOIN receive_items ri ON rd.rd_id = ri.rd_id WHERE ri.item_id = '$itemid'") AS $r){
            $received = $r->rqty;
        }*/

        foreach($this->super_model->custom_query("SELECT SUM(ri.received_qty) AS rqty FROM receive_head rh INNER JOIN  receive_details rd ON rd.receive_id = rh.receive_id INNER JOIN receive_items ri ON rd.rd_id = ri.rd_id WHERE ri.item_id = '$itemid' AND saved ='1'") AS $r){
            $received = $r->rqty;
        }

       foreach($this->super_model->custom_query("SELECT SUM(id.quantity) AS iqty FROM issuance_head ih INNER JOIN issuance_details id ON ih.issuance_id = id.issuance_id WHERE id.item_id = '$itemid' AND saved='1'") AS $i){
            $issued = $i->iqty;
       }

   
         foreach($this->super_model->custom_query("SELECT SUM(rsd.quantity) AS rsqty FROM restock_head rsh INNER JOIN restock_details rsd ON rsh.rhead_id = rsd.rhead_id WHERE rsd.item_id = '$itemid' AND excess = '0' AND saved='1'") AS $rs){
            $restock = $rs->rsqty;
       }

        $wh_stocks = $this->super_model->select_sum_where("supplier_items", "quantity", "item_id ='$itemid' AND supplier_id = '0' AND catalog_no ='begbal'");


      // return "(".$received . " + " .  $restock . "+"  . $wh_stocks.") - ".$issued . $prno;
        $bal = ($received+$restock+$wh_stocks) - $issued;
        return $bal;
    }
    public function mif(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['access']=$this->access;
        $this->load->model('super_model');        
        $data['heads'] = $this->super_model->select_row_where('issuance_head', 'issuance_id', $id);

        foreach($this->super_model->select_row_where('issuance_head', 'issuance_id', $id) AS $us){
            $data['username'][] = array( 
                'user'=>$this->super_model->select_column_where('users', 'fullname', 'user_id', $us->user_id),
                'positionrel'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->released_by),
                'positionrec'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->received_by),
                'positionnote'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->noted_by),
                'user_id'=>$us->user_id
            );
        }
        foreach($this->super_model->select_row_where('issuance_head','issuance_id', $id) AS $issue){
            $department = $this->super_model->select_column_where("department", "department_name", "department_id", $issue->department_id);
            $purpose = $this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $issue->purpose_id);
            $enduse = $this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $issue->enduse_id);       
             $type=  $this->super_model->select_column_where("request_head", "type", "mreqf_no", $issue->mreqf_no);
             $remarks=  $this->super_model->select_column_where("request_head", "remarks", "request_id", $issue->request_id);
             $unit_cost=  $this->super_model->select_column_where("request_items", "unit_cost", "request_id", $issue->request_id);
             $total_cost=  $this->super_model->select_column_where("request_items", "total_cost", "request_id", $issue->request_id);     
            $data['issuance_details'][] = array(
                'milf'=>$issue->mif_no,
                'mreqf'=>$issue->mreqf_no,
                'prno'=>$issue->pr_no,
                'date'=>$issue->issue_date,
                'time'=>$issue->issue_time,
                'type'=>$type,
                'department'=>$department,
                'purpose'=>$purpose,
                'enduse'=>$enduse,
                'remarks'=>$issue->remarks
            );
            foreach($this->super_model->select_row_where('issuance_details','issuance_id', $issue->issuance_id) AS $rt){
               // echo $issue->pr_no;
                $balance = $this->new_inv_balance($rt->item_id, $issue->pr_no);
                $item = $this->super_model->select_column_where("items", "item_name", "item_id", $rt->item_id);
                $serial = $this->super_model->select_column_where("serial_number", "serial_no", "serial_id", $rt->serial_id);
                $uom = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $rt->unit_id);
                $rec_qty = $this->super_model->select_sum("supplier_items", "quantity", "item_id", $rt->item_id);
                $unit_cost = $this->super_model->select_sum("request_items", "unit_cost", "rq_id", $rt->rq_id);
                //$total_cost = $this->super_model->select_sum("request_items", "total_cost", "rq_id", $rt->rq_id);
                $total_cost = $rt->quantity * $unit_cost;
                $data['issue_itm'][] = array(
                    'item'=>$item,
                    'qty'=>$rt->quantity,
                    'serial' => $serial,
                    'uom'=>$uom,
                    'unit_cost'=>$unit_cost,
                    'total_cost'=>$total_cost,
                    'pn'=>$rt->pn_no,
                    'invqty'=>$rec_qty,
                    'brand'=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $rt->brand_id),
                    'remarks'=>$rt->remarks,
                    'balance'=>$balance,
                );
            }

        }
        

        foreach($this->super_model->select_row_where("signatories", "released", "1") AS $notes){
            $data['released_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $notes->employee_id),
                'empid'=>$notes->employee_id
            );
        }
        foreach($this->super_model->select_row_where("signatories", "received", "1") AS $notes){
            $data['received_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $notes->employee_id),
                'empid'=>$notes->employee_id
            );
        }
        foreach($this->super_model->select_row_where("signatories", "noted", "1") AS $notes){
            $data['noted_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $notes->employee_id),
                'empid'=>$notes->employee_id
            );
        }
        $data['printed']=$this->super_model->select_column_where('users', 'fullname', 'user_id', $_SESSION['user_id']);
        $this->load->view('template/header');
        $this->load->view('template/print_head');
        $this->load->view('issue/mif',$data);

    }

    public function gatepass(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $year=date('Y-m');
        $gp= "MGP-".$year;
        $gpdetails=explode("-", $gp);
        $gp_prefix1=$gpdetails[0];
        $gp_prefix2=$gpdetails[1];
        $gp_prefix3=$gpdetails[2];
        $gp_prefix=$gp_prefix1."-".$gp_prefix2."-".$gp_prefix3;
        //$rows=$this->super_model->count_custom_where("issuance_head","issue_date LIKE '$year%' AND gp_no !=''");
        $rows=$this->super_model->count_custom_where("gp_series","gp_prefix='$gp_prefix'");
        if($rows==0){
            $gpno = "MGP-".$year."-0001";
        } else {
            //$maxgpno=$this->super_model->get_max_where("issuance_head", "gp_no","create_date LIKE '$year%'");
            //$gateno = explode('-',$maxgpno);
            //$series = $gateno[3]+1;
            $maxgpno=$this->super_model->get_max_where("gp_series", "series","gp_prefix='$gp_prefix'");
            $series=$maxgpno+1;
            if(strlen($series)==1){
                $gpno = "MGP-".$year."-000".$series;
            } else if(strlen($series)==2){
                $gpno = "MGP-".$year."-00".$series;
            } else if(strlen($series)==3){
                $gpno = "MGP-".$year."-0".$series;
            } else if(strlen($series)==4){
                $gpno = "MGP-".$year."-".$series;
            }
        }
        $data['heads'] = $this->super_model->select_row_where('issuance_head', 'issuance_id', $id);
        foreach($this->super_model->select_row_where('issuance_head', 'issuance_id', $id) AS $us){
            $data['username'][] = array( 
                'user'=>$this->super_model->select_column_where('users', 'fullname', 'user_id', $us->user_id),
                'user_id'=>$us->user_id
            );
        }

        foreach($this->super_model->select_row_where('issuance_head','issuance_id', $id) AS $issue){
            $department = $this->super_model->select_column_where("department", "department_name", "department_id", $issue->department_id);
            $purpose = $this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $issue->purpose_id);
            $enduse = $this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $issue->enduse_id);  
            if($issue->gp_no!=''){
                $gp_no=$issue->gp_no;
            }else {
                $gp_no=$gpno;
            }          
            $data['issuance_details'][] = array(
                'mif'=>$issue->mif_no,
                'gpno'=>$gp_no,
                'prno'=>$issue->pr_no,
                'date'=>$issue->issue_date,
                'time'=>$issue->issue_time,
                'department'=>$department,
                'purpose'=>$purpose,
                'enduse'=>$enduse,
                'remarks'=>$issue->remarks
            );
            foreach($this->super_model->select_row_where('issuance_details','issuance_id', $issue->issuance_id) AS $rt){
                $item = $this->super_model->select_column_where("items", "item_name", "item_id", $rt->item_id);
                $serial = $this->super_model->select_column_where("serial_number", "serial_no", "serial_id", $rt->serial_id);
                $uom = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $rt->unit_id);
                $rec_qty = $this->super_model->select_sum("supplier_items", "quantity", "item_id", $rt->item_id);
                $data['issue_itm'][] = array(
                    'item'=>$item,
                    'qty'=>$rt->quantity,
                    'serial' => $serial,
                    'uom'=>$uom,
                    'pn'=>$rt->pn_no,
                    'invqty'=>$rec_qty,
                    'brand'=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $rt->brand_id),
                    'remarks'=>$rt->remarks
                );
            }

        }
        foreach($this->super_model->select_all_order_by("employees", "employee_name", "ASC") AS $emp){
            $data['employees'][] = array( 
                'empname'=>$emp->employee_name,
                'empid'=>$emp->employee_id
            );
        }

         foreach($this->super_model->select_row_where("signatories", "requested", "1") AS $notes){
            $data['requested_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $notes->employee_id),
                'empid'=>$notes->employee_id
            );
        }

     foreach($this->super_model->select_row_where("signatories", "noted", "1") AS $notes){
            $data['noted_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $notes->employee_id),
                'empid'=>$notes->employee_id
            );
        }


        foreach($this->super_model->select_row_where("signatories", "approved", "1") AS $notes){
            $data['approved_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $notes->employee_id),
                'empid'=>$notes->employee_id
            );
        }
     
        $data['printed']=$this->super_model->select_column_where('users', 'fullname', 'user_id', $_SESSION['user_id']);
        $this->load->view('template/header');
        $this->load->view('template/print_head');        
        $this->load->view('issue/gatepass',$data);
    }

    public function saveIssuance(){
      
       $requestid= $this->input->post('request_id');
       //$requestid=$this->input->post('request_id');
       //$requestid = '4508';
       $type=$this->super_model->select_column_where("request_head", "type", "request_id", $requestid);

       $rqid=$this->input->post('rqid');
     // $rqid = '1';
       $quantity=$this->input->post('quantity');
       //$quantity='3';
       $userid=$this->input->post('userid');
       //$userid='1';
        $serial=$this->input->post('serial');
        //$count=$this->input->post('count');
       // $check=$this->input->post('check');
       // echo $count;
        $remarks = $this->input->post('remarks');
       

       $count = count($quantity);
       
       //echo $count;
       $year=date('Y-m');
       $year_series=date('Y');
       

        $rows=$this->super_model->count_custom_where("issuance_head","create_date LIKE '$year_series%'");
        if($rows==0){
             $mifno = "MIF-".$year."-0001";
        } else {
            $maxrecno=$this->super_model->get_max_where("issuance_head", "mif_no","create_date LIKE '$year_series%'");
            $recno = explode('-',$maxrecno);
           
            $series = $recno[3]+1;
            if(strlen($series)==1){
                $mifno = "MIF-".$year."-000".$series;
            } else if(strlen($series)==2){
                 $mifno = "MIF-".$year."-00".$series;
            } else if(strlen($series)==3){
                 $mifno = "MIF-".$year."-0".$series;
            } else if(strlen($series)==4){
                 $mifno = "MIF-".$year."-".$series;
            }
        }

        $date=date('Y-m-d');
        $time=date('H:i:s');
        $create=date('Y-m-d H:i:s');

        $head_rows = $this->super_model->count_rows("issuance_head");
        if($head_rows==0){
            $issueid=1;
        } else {
            $maxid=$this->super_model->get_max("issuance_head", "issuance_id");
            $issueid=$maxid+1;
        }

       
     // echo $requestid;
        foreach($this->super_model->select_row_where("request_head", "request_id", $requestid) AS $req){
         


            $data = array(
                'issuance_id'=>$issueid,
                'mif_no'=>$mifno,
                'request_id'=>$requestid,
                'mreqf_no'=>$req->mreqf_no,
                'issue_date'=>$this->input->post('issue_date'),
                'issue_time'=>$this->input->post('issue_time'),
                'create_date'=>$create,
                'department_id'=>$req->department_id,
                'purpose_id'=>$req->purpose_id,
                'enduse_id'=>$req->enduse_id,
                'pr_no'=> $req->pr_no,
                'user_id'=>$userid,
                'saved'=>'1'
                
            );
           
           $this->super_model->insert_into("issuance_head", $data);
        }



       for($x=0; $x<$count; $x++){

         $itemid=$this->super_model->select_column_where("request_items", "item_id", "rq_id", $rqid[$x]);

         $supplierid=$this->super_model->select_column_where("request_items", "supplier_id", "rq_id", $rqid[$x]);
         $catalogno=$this->super_model->select_column_where("request_items", "catalog_no", "rq_id", $rqid[$x]);
         $brandid=$this->super_model->select_column_where("request_items", "brand_id", "rq_id", $rqid[$x]);
        
         $pn_no=$this->super_model->select_column_where("request_items", "pn_no", "rq_id", $rqid[$x]);
         $uom=$this->super_model->select_column_where("request_items", "unit_id", "rq_id", $rqid[$x]);
        
         
         if($quantity[$x]!='0' && $quantity[$x]!=""){
          
            $details= array(
                'issuance_id'=>$issueid,
                'rq_id'=>$rqid[$x],
                'item_id'=>$itemid,
                'supplier_id'=>$supplierid,
                'catalog_no'=>$catalogno,
                'brand_id'=>$brandid,
                'serial_id'=>$serial[$x],
                'quantity'=>$quantity[$x],
                'pn_no'=>$pn_no,
                'unit_id'=>$uom,
                'remarks'=>$remarks[$x],
            );
        
             $this->super_model->insert_into("issuance_details", $details);
              //echo $type;
             $description=$this->super_model->select_column_where("items", "item_name", "item_id", $itemid);
             $cat=$this->super_model->select_column_where("items", "category_id", "item_id", $itemid);
             $subcat=$this->super_model->select_column_where("items", "subcat_id", "item_id", $itemid);
             $group=$this->super_model->select_column_where("items", "group_id", "item_id", $itemid);
             $location=$this->super_model->select_column_where("items", "location_id", "item_id", $itemid);
             $bin=$this->super_model->select_column_where("items", "bin_id", "item_id", $itemid);
             $warehouse=$this->super_model->select_column_where("items", "warehouse_id", "item_id", $itemid);
             $rack=$this->super_model->select_column_where("items", "rack_id", "item_id", $itemid);
             $weight=$this->super_model->select_column_where("items", "weight", "item_id", $itemid);
             $picture1=$this->super_model->select_column_where("items", "picture1", "item_id", $itemid);
             $picture2=$this->super_model->select_column_where("items", "picture2", "item_id", $itemid);
             $picture3=$this->super_model->select_column_where("items", "picture3", "item_id", $itemid);

            
            if($type == 'Damage Items'){

                 $damage = array(
                    'request_id'=>$requestid,
                    'issuance_id'=>$issueid,
                    'item_id'=>$itemid,
                    'item_description'=>$description,
                    'category_id'=>$cat,
                    'subcat_id'=>$subcat,
                    'original_pn'=>$pn_no,
                    'unit_id'=>$uom,
                    'group_id'=>$group,
                    'location_id'=>$location,
                    'bin_id'=>$bin,
                    'warehouse_id'=>$warehouse,
                    'rack_id'=>$rack,
                    'picture1'=>$picture1,
                    'picture2'=>$picture2,
                    'picture3'=>$picture3,
                    'weight'=>$weight,
                    'supplier_id'=>$supplierid,
                    'catalog_no'=>$catalogno,
                    'brand_id'=>$brandid,
                    'serial_id'=>$serial[$x],
                    'quantity'=>$quantity[$x],
                    'date_added'=>$create,
                    'added_by'=>$userid,
                    'remarks'=>$remarks[$x]

                 );

                  $this->super_model->insert_into("damage_items", $damage);
             }
        }
       }

       echo $issueid;
    }

    public function printMIF(){
        $id=$this->input->post('mifid');

        $data = array(
            "released_by"=>$this->input->post('released'),
            "received_by"=>$this->input->post('received'),
            "noted_by"=>$this->input->post('noted')
        );

        $this->super_model->update_where("issuance_head", $data, "issuance_id", $id);
        echo "success";
    }

    public function printGP(){
        $id=$this->input->post('issueid');
        $gpdetails=explode("-", $this->input->post('gpno'));
        $gp_prefix1=$gpdetails[0];
        $gp_prefix2=$gpdetails[1];
        $gp_prefix3=$gpdetails[2];
        $gp_prefix=$gp_prefix1."-".$gp_prefix2."-".$gp_prefix3;
        $checkgp=$this->super_model->count_custom_where("issuance_head","issuance_id='$id' AND gp_no!=''");
        $rows=$this->super_model->count_custom_where("gp_series","gp_prefix='$gp_prefix'");
        if($rows==0){
            $nxt= "0001";
            $gpno= $gp_prefix."-0001";
        } else {
            $series = $this->super_model->get_max_where("gp_series", "series","gp_prefix='$gp_prefix'");
            $next=$series+1;
            //$gpno = $gp_prefix."-".$next;
            if(strlen($next)==1){
                $nxt="000".$next;
                $gpno = $gp_prefix."-000".$next;
            } else if(strlen($next)==2){
                $nxt="00".$next;
                $gpno = $gp_prefix."-00".$next;
            } else if(strlen($next)==3){
                $nxt="0".$next;
                $gpno = $gp_prefix."-0".$next;
            } else if(strlen($next)==4){
                $nxt=$next;
                $gpno = $gp_prefix."-".$next;
            }
        }

        if($checkgp==0){
            $data = array(
                "gp_no"=>$gpno,
                "gp_prepared"=>$this->input->post('gp_employee'),
                "gp_employee"=>$this->input->post('gp_employee'),
                "gp_requested"=>$this->input->post('gp_requested'),
                "gp_recommending"=>$this->input->post('gp_recommend'),
                "gp_noted"=>$this->input->post('gp_noted'),
                "gp_approved"=>$this->input->post('gp_approved'),
                "gp_inspected"=>$this->input->post('gp_inspected')
            );
        }else{
            $data = array(
                "gp_prepared"=>$this->input->post('gp_employee'),
                "gp_employee"=>$this->input->post('gp_employee'),
                "gp_requested"=>$this->input->post('gp_requested'),
                "gp_recommending"=>$this->input->post('gp_recommend'),
                "gp_noted"=>$this->input->post('gp_noted'),
                "gp_approved"=>$this->input->post('gp_approved'),
                "gp_inspected"=>$this->input->post('gp_inspected')
            );
        }

        if($this->super_model->update_where("issuance_head", $data, "issuance_id", $id)){
            if($checkgp==0){
                $data_series = array(
                    "gp_prefix"=>$gp_prefix,
                    "series"=>$nxt,
                );
                $this->super_model->insert_into("gp_series", $data_series);
            }
        }
        echo "success";
    }

    public function getEmprel(){
        $employee_id = $this->input->post('employee_id');
        foreach($this->super_model->custom_query("SELECT employee_id, position, employee_name FROM employees WHERE employee_id='$employee_id'") AS $emp){   
            $return = array('position' => $emp->position); 
            echo json_encode($return);   
        }
    }

    public function getEmprec(){
        $employee_id = $this->input->post('employee_id');
        foreach($this->super_model->custom_query("SELECT employee_id, position, employee_name FROM employees WHERE employee_id='$employee_id'") AS $emp){   
            $return = array('position' => $emp->position); 
            echo json_encode($return);   
        }
    }

    public function getEmpnoted(){
        $employee_id = $this->input->post('employee_id');
        foreach($this->super_model->custom_query("SELECT employee_id, position, employee_name FROM employees WHERE employee_id='$employee_id'") AS $emp){   
            $return = array('position' => $emp->position); 
            echo json_encode($return);   
        }
    }
   
    public function editmodal(){
        $data['issue_id'] = $this->uri->segment(3);
        $data['request_id'] = $this->uri->segment(4);
        $data['pr_list']=$this->super_model->custom_query("SELECT pr_no, enduse_id, purpose_id,department_id FROM receive_head INNER JOIN receive_details WHERE saved='1' GROUP BY pr_no");
        $this->load->view('template/header');        
        $this->load->view('issue/editmodal',$data);  
        $this->load->view('template/footer');  
    }

    public function search_issue(){
        $idate=$this->input->post('idate');
        $mif_no=$this->input->post('mif_no');
        $mreqf_no=$this->input->post('mreqf_no');
        $pr=$this->input->post('pr');
        $enduse=$this->input->post('enduse');
        $purpose=$this->input->post('purpose');
        $type=$this->input->post('type');
        $this->load->model('super_model');
        $data['issue_head'] = $this->super_model->select_all('issuance_head');
        $data['issue_details'] = $this->super_model->select_all('issuance_details');
        $data['enduse'] = $this->super_model->select_all('enduse');
        $data['purpose'] = $this->super_model->select_all('purpose');
        $sql="";
        $filter ="";
        if(!empty($idate)){
            $sql.= " ih.issue_date LIKE '%$idate%' AND";
            $filter.="Issue Date = ".$idate.", ";
        }

        if(!empty($mif_no)){
            $sql.= " ih.mif_no LIKE '%$mif_no%' AND";
            $filter.="MIF No. = " .$mif_no. ", ";
        }

        if(!empty($mreqf_no)){
            $sql.= " ih.mreqf_no LIKE '%$mreqf_no%' AND";
            $filter.="MReqF No. = " .$mreqf_no. ", ";
        }

        if(!empty($pr)){
            $sql.= " ih.pr_no LIKE '%$pr%' AND";
            $filter.="PR No. = " .$pr. ", ";
        }

        if(!empty($enduse)){
            $sql.= " ih.enduse_id = '$enduse' AND";
            $filter.="End-Use = " . $this->super_model->select_column_where('enduse', 'enduse_name', 
                        'enduse_id', $enduse). ", ";
        }

        if(!empty($purpose)){
            $sql.= " ih.purpose_id = '$purpose' AND";
            $filter.="Purpose = " . $this->super_model->select_column_where('purpose', 'purpose_desc', 
                        'purpose_id', $purpose). ", ";
        }

        if(!empty($type)){
            $sql.= " rh.type LIKE '%$type%' AND";
            $filter.="Type = ".$type. ", ";
        }

        $query=substr($sql,0,-3);
        $filter=substr($filter,0,-2);
        $count=$this->super_model->count_custom_query("SELECT * FROM issuance_head ih LEFT JOIN request_head rh ON ih.request_id=rh.request_id WHERE ".$query);
       
        $data['filter']=$filter;
        if($count!=0){
            $data['count_query'] = 1;
            foreach ($this->super_model->custom_query("SELECT * FROM issuance_head ih LEFT JOIN request_head rh ON ih.request_id=rh.request_id WHERE ".$query) AS $issue){
            //foreach ($this->super_model->select_join_where("issuance_head", "issuance_details", $query, "issuance_id") AS $itm){
                $department = $this->super_model->select_column_where("department", "department_name", "department_id", $issue->department_id);
                $purpose = $this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $issue->purpose_id);
                $enduse = $this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $issue->enduse_id);
                $type=  $this->super_model->select_column_where("request_head", "type", "mreqf_no", $issue->mreqf_no);
                $data['issue_list'][] = array(
                    'issuance_id'=>$issue->issuance_id,
                    'mifno'=>$issue->mif_no,
                    'mreqf'=>$issue->mreqf_no,
                    'prno'=>$issue->pr_no,
                    'date'=>$issue->issue_date,
                    'time'=>$issue->issue_time,
                    'type'=>$type,
                    'department'=>$department,
                    'purpose'=>$purpose,
                    'enduse'=>$enduse
                );
            } 

        }else {
                $data['count_query'] = 0;
                $data['issue_list']=array();
            }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('issue/view_issue',$data);
        $this->load->view('template/footer');
    }

    public function updatePRIssuance(){
        $id =$this->input->post('issuance_id');
        $request_id =$this->input->post('request_id');
        $department =$this->input->post('department');
        $purpose =$this->input->post('purpose');
        $enduse =$this->input->post('enduse');
        $data = array(
            "pr_no"=>$this->input->post('pr_no'),
            "department_id"=>$this->input->post('department'),
            "purpose_id"=>$this->input->post('purpose'),
            "enduse_id"=>$this->input->post('enduse'),
        ); 

        if($this->super_model->update_where("issuance_head", $data, "issuance_id", $id)){
            $data_req = array(
                "type"=>'JO / PR',
                "pr_no"=>$this->input->post('pr_no'),
                "department_id"=>$this->input->post('department'),
                "purpose_id"=>$this->input->post('purpose'),
                "enduse_id"=>$this->input->post('enduse'),
            );
            $this->super_model->update_where("request_head", $data_req, "request_id", $request_id);
            echo "<script>window.opener.location.reload();window.close()</script>";
        }
    }

    public function getPRmodal(){
        $prno = $this->input->post('prno');
        $dept= $this->super_model->select_column_where('receive_details', 'department_id', 'pr_no', $prno);
        $department= $this->super_model->select_column_where('department', 'department_name', 'department_id', $dept);

        $pur= $this->super_model->select_column_where('receive_details', 'purpose_id', 'pr_no', $prno);
        $purpose= $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $pur);

        $end= $this->super_model->select_column_where('receive_details', 'enduse_id', 'pr_no', $prno);
        $enduse= $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $end);
        $return = array('dept' => $dept, 'pur' => $pur, 'end' => $end, 'department' => $department);
        echo json_encode($return);
    }
}
?>
