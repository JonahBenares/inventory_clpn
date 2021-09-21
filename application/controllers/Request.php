<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {

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

    public function insert_request_head(){

        $year=date('Y-m');
        $year_series=date('Y');
        $now=date('Y-m-d H:i:s');
       // echo $year ."<br>";
        $rows=$this->super_model->count_custom_where("request_head","create_date LIKE '$year_series%'");
        if($rows==0){
             $newreq_no = "MreqF-".$year."-0001";
        } else {
            $maxreqno=$this->super_model->get_max_where("request_head", "mreqf_no","create_date LIKE '$year_series%'");
            $reqno = explode('-',$maxreqno);
            $series = $reqno[3]+1;
            //echo $reqno[3];
            $new_series = str_pad($series, 4, "0", STR_PAD_LEFT);
           
            $newreq_no = "MreqF-".$year."-".$new_series;
          
            
        }
       // $newreq_no = 'MreqF-2018-09-0010';
        $head_rows = $this->super_model->count_rows("request_head");
        if($head_rows==0){
            $requestid=1;
        } else {
            $maxid=$this->super_model->get_max("request_head", "request_id");
            $requestid=$maxid+1;
        }

        $data = array(
           'request_id'=>$requestid,
           'type'=>$this->input->post('type'),
           'create_date'=> $now,
           'request_date'=> $this->input->post('request_date'),
           'request_time'=> $this->input->post('request_time'),
           'mreqf_no'=> $newreq_no,
           'department_id'=> $this->input->post('department'),
           'purpose_id'=> $this->input->post('purpose'),
           'enduse_id'=> $this->input->post('enduse'),
           'pr_no'=> $this->input->post('prno'),
          // 'borrowfrom_pr'=> $this->input->post('borrow_pr'),
           'remarks'=> $this->input->post('remarks'),
           'user_id'=> $this->input->post('userid')
        );

      
        if($this->super_model->insert_into("request_head", $data)){
             redirect(base_url().'index.php/request/add_request/'.$requestid);
        } else {
            $url=base_url()."index.php/request/request_list/";
            echo "Due to slow connectivity. Please <a href='".$url."' >Try Again.</a>"; ?>
          
            <?php 
        }
    }

    public function getPR(){
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

    public function request_list(){
        $rows= $this->super_model->count_rows("request_head");
        if($rows!=0){
        foreach($this->super_model->select_all("request_head") AS $request){
            $department = $this->super_model->select_column_where("department", "department_name", "department_id", $request->department_id);
            $purpose = $this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $request->purpose_id);
            $enduse = $this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $request->enduse_id);
            $data['request'][] = array(
                'requestid'=>$request->request_id,
                'mreqf'=>$request->mreqf_no,
                'type'=>$request->type,
                'prno'=>$request->pr_no,
                'date'=>$request->request_date,
                'department'=>$department,
                'purpose'=>$purpose,
                'enduse'=>$enduse,
                'type'=>$request->type
            );
        }
        } else {
            $data['request']=array();
        }
        $data['access']=$this->access;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('request/request_list',$data);
        $this->load->view('template/footer');
    }

    public function edit_endpurp(){  
        $this->load->view('template/header');
        $data['id']=$this->input->post('id');
        $id=$this->input->post('id');
        $data['pr'] = $this->super_model->custom_query("SELECT pr_no, enduse_id, purpose_id,department_id FROM receive_head INNER JOIN receive_details WHERE saved='1' GROUP BY pr_no");
        $data['end'] = $this->super_model->select_all_order_by('enduse', 'enduse_name', 'ASC');
        $data['purp'] = $this->super_model->select_all_order_by('purpose', 'purpose_desc', 'ASC');
        $data['dept'] = $this->super_model->select_all_order_by('department', 'department_name', 'ASC');
        foreach($this->super_model->select_row_where('request_head', 'request_id', $id) AS $i){
            $data['request_list'][]=array(
                'purpose_id'=>$i->purpose_id,
                'enduse_id'=>$i->enduse_id,
                'department_id'=>$i->department_id,
                'pr_no'=>$i->pr_no,
            );
        }
        $this->load->view('request/edit_endpurp',$data);
    }

    public function update_purend(){
        $data = array(
            'purpose_id'=>$this->input->post('purpose'),
            'enduse_id'=>$this->input->post('enduse'),
            'department_id'=>$this->input->post('department'),
            'pr_no'=>$this->input->post('pr_no'),
        );
        $request_id = $this->input->post('request_id');
        if($this->super_model->update_where('request_head', $data, 'request_id', $request_id)){
            $this->super_model->update_where('issuance_head', $data, 'request_id', $request_id);
            echo "<script>alert('Successfully Updated!'); 
                window.location ='".base_url()."index.php/request/request_list'; </script>";
        }
    }

    public function view_request(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $this->load->model('super_model');
        $data['head'] = $this->super_model->select_row_where('request_head', 'request_id', $id);
        
        foreach($this->super_model->select_row_where('request_head','request_id', $id) AS $req){
            foreach($this->super_model->select_row_where('request_items','request_id', $req->request_id) AS $rt){
                $item = $this->super_model->select_column_where("items", "item_name", "item_id", $rt->item_id);
                $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $rt->unit_id);
                /*$rec_qty = $this->super_model->select_sum("supplier_items", "quantity", "item_id", $rt->item_id);*/
                $rec_qty=$this->inventory_balance($rt->item_id);
                $data['req_itm'][] = array(
                    'item'=>$item,
                    'qty'=>$rt->quantity,
                    'uom'=>$unit,
                    'pn'=>$rt->pn_no,
                    'invqty'=>$rec_qty,
                    'unit_cost'=>$rt->unit_cost,
                    'total_cost'=>$rt->total_cost
                );
            }
            $department = $this->super_model->select_column_where("department", "department_name", "department_id", $req->department_id);
            $purpose = $this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $req->purpose_id);
            $enduse = $this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $req->enduse_id);
            $data['req'][] = array(
                'requestid'=>$req->request_id,
                'mreqf'=>$req->mreqf_no,
                'prno'=>$req->pr_no,
                'date'=>$req->request_date,
                'time'=>$req->request_time,
                'department'=>$department,
                'purpose'=>$purpose,
                'enduse'=>$enduse,
                'remarks'=>$req->remarks,
                'type'=>$req->type
            );
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('request/view_request',$data);
        $this->load->view('template/footer');
    }

    public function mreqf(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $this->load->model('super_model');
        $data['heads'] = $this->super_model->select_row_where('request_head', 'request_id', $id);
        foreach($this->super_model->select_row_where('request_head', 'request_id', $id) AS $us){
            $data['username'][] = array( 
                'user'=>$this->super_model->select_column_where('users', 'fullname', 'user_id', $us->user_id),
                'positionreq'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->requested_by),
                'positionrev'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->reviewed_by),
                'positionapp'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->approved_by),
                'positionnote'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->noted_by),
                'user_id'=>$us->user_id
            );
        }
        foreach($this->super_model->select_row_where('request_head','request_id', $id) AS $req){
            foreach($this->super_model->select_row_where('request_items','request_id', $req->request_id) AS $rt){
                $item = $this->super_model->select_column_where("items", "item_name", "item_id", $rt->item_id);
                $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $rt->unit_id);
                //$rec_qty = $this->super_model->select_sum("supplier_items", "quantity", "item_id", $rt->item_id);
                $qty=$this->inventory_balance($rt->item_id);
                $data['req_itm'][] = array(
                    'item'=>$item,
                    'qty'=>$rt->quantity,
                    'uom'=>$unit,
                    'pn'=>$rt->pn_no,
                    'invqty'=>$qty
                );
            }
            $department = $this->super_model->select_column_where("department", "department_name", "department_id", $req->department_id);
            $purpose = $this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $req->purpose_id);
            $enduse = $this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $req->enduse_id);
            $data['req'][] = array(
                'requestid'=>$req->request_id,
                'mreqf'=>$req->mreqf_no,
                'prno'=>$req->pr_no,
                'date'=>$req->request_date,
                'time'=>$req->request_time,
                'department'=>$department,
                'purpose'=>$purpose,
                'enduse'=>$enduse,
                'remarks'=>$req->remarks
            );
        }

        foreach($this->super_model->select_row_where("signatories", "requested", "1") AS $sign){
            $data['requested_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $sign->employee_id),
                'empid'=>$sign->employee_id
            );
        }
        foreach($this->super_model->select_row_where("signatories", "reviewed", "1") AS $sign){
            $data['reviewed_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $sign->employee_id),
                'empid'=>$sign->employee_id
            );
        }
        foreach($this->super_model->select_row_where("signatories", "approved", "1") AS $sign){
            $data['approved_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $sign->employee_id),
                'empid'=>$sign->employee_id
            );
        }
        foreach($this->super_model->select_row_where("signatories", "noted", "1") AS $sign){
            $data['noted_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $sign->employee_id),
                'empid'=>$sign->employee_id
            );
        }
        $data['printed']=$this->super_model->select_column_where('users', 'fullname', 'user_id', $_SESSION['user_id']);
        $this->load->view('template/header');
        $this->load->view('template/print_head');
        $this->load->view('request/mreqf',$data);
    }


    public function add_request(){
        $id=$this->uri->segment(3);
        $data['requestid']= $id;
        $data['request']= $id;
        $data['item_list']=$this->super_model->select_all_order_by("items","item_name","ASC");
        foreach($this->super_model->select_row_where("request_head", "request_id", $id) AS $req){
            $data['head'][]=array(
                "mreqf_no"=>$req->mreqf_no,
                "request_date"=>$req->request_date,
                "request_time"=>$req->request_time,
                "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $req->department_id),
                "purpose"=>$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $req->purpose_id),
                "enduse"=>$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $req->enduse_id),
                "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $req->department_id),
                "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $req->department_id),
                "prno"=>$req->pr_no,
                "remarks"=>$req->remarks,
                "saved"=>$req->saved,
                'type'=>$req->type
            );
        }
        $row1=$this->super_model->count_rows_where("request_items","request_id",$id);
        if($row1!=0){
            foreach($this->super_model->select_row_where('request_items','request_id', $id) AS $rt){
                $item = $this->super_model->select_column_where("items", "item_name", "item_id", $rt->item_id);
               // $rec_qty = $this->super_model->select_sum("supplier_items", "quantity", "item_id", $rt->item_id);
                //echo "item_id = '$rt->item_id'<br>";
                $inv_qty =$this->inventory_balance($rt->item_id);
                foreach($this->super_model->select_custom_where("supplier_items","item_id = '$rt->item_id' AND quantity != '0'") AS $itm){
                    $brand = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $rt->brand_id);
                    $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $rt->supplier_id);
                    $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $rt->unit_id);
                    $cross = $supplier ." - ". $itm->catalog_no ." - ". $brand . " (".$itm->quantity.")";
                }
                $data['req_itm'][] = array(
                    'itemid'=>$rt->request_id,
                    'item'=>$item,
                    'qty'=>$rt->quantity,
                    'uom'=>$unit,
                    'pn'=>$rt->pn_no,
                    'cross'=>$cross,
                    'unitcost'=>$rt->unit_cost,
                    'totalcost'=>$rt->total_cost,
                    'borrowfrom_pr'=>$rt->borrowfrom_pr,
                    'invqty'=>$inv_qty
                );
            }
        }else{
            $data['req_itm'] = array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('request/add_request',$data);
        $this->load->view('template/footer');
    }

    public function getIteminformation(){
        $item = $this->input->post('item');
        //$item = 691;
        foreach($this->super_model->select_custom_where("items", "item_id='$item'") AS $itm){ 
            $rec_qty = $this->inventory_balance($itm->item_id);
            $return = array('item_id' => $itm->item_id,'item_name' => $itm->item_name, 'unit' => $itm->unit_id, 'pn' => $itm->original_pn, 'recqty' => $rec_qty); 
            echo json_encode($return);   
        }
    }

    public function insertRequest(){
        $counter = $this->input->post('counter');
        $id=$this->input->post('requestid');
        for($a=0;$a<$counter;$a++){
            if(!empty($this->input->post('item_id['.$a.']'))){
                $data = array(
                    'request_id'=>$this->input->post('requestid'),
                    'item_id'=>$this->input->post('item_id['.$a.']'),
                    'quantity'=>$this->input->post('quantity['.$a.']'),
                    'unit_id'=>$this->input->post('unit['.$a.']'),
                    'pn_no'=>$this->input->post('original_pn['.$a.']'),
                    'si_id'=>$this->input->post('siid['.$a.']'),
                    'supplier_id'=>$this->input->post('supplier_id['.$a.']'),
                    'catalog_no'=>$this->input->post('catalog_no['.$a.']'),
                    'brand_id'=>$this->input->post('brand_id['.$a.']'),
                    'unit_cost'=>$this->input->post('unitcost['.$a.']'),
                    'total_cost'=>$this->input->post('totalcost['.$a.']'),
                    'borrowfrom_pr'=>$this->input->post('borrow['.$a.']')
                );
                $this->super_model->insert_into("request_items", $data); 
            }
        }

        $saved=array(
            'saved'=>1
        );
        $this->super_model->update_where("request_head", $saved, "request_id", $id);
        echo $id;
    }

   /*  public function inventory_balance($itemid){
         $recqty= $this->super_model->select_sum("supplier_items", "quantity", "item_id", $itemid);
         $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND saved='1'","issuance_id");
         $balance=$recqty-$issueqty;
         return $balance;
    }*/

       public function inventory_balance($itemid){
        //$itemid='647';
       /*  $recqty= $this->super_model->select_sum("supplier_items", "quantity", "item_id", $itemid);
         $issueqty= $this->super_model->select_sum("issuance_details","quantity", "item_id",$itemid);*/
        $begbal= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id='$itemid' AND catalog_no = 'begbal'");
         $recqty= $this->super_model->select_sum_join("received_qty","receive_items","receive_head", "item_id='$itemid' AND saved='1'","receive_id");
         //return $recqty;
        $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND saved='1'","issuance_id");
        //return $issueqty;
         $restockqty= $this->super_model->select_sum_join("quantity","restock_details","restock_head", "item_id='$itemid' AND saved='1' AND excess = '0'","rhead_id");
          //return $restockqty;
          $balance=($recqty+$begbal+$restockqty)-$issueqty;
         return $balance;
    }

    public function checkpritem(){
        $item = $this->input->post('item');
        $pr = $this->input->post('pr');
      
       // $rdid=$this->super_model->select_column_where("receive_details", "rd_id", "pr_no", $pr);

        //$recqty=$this->super_model->select_column_custom_where("receive_items", "received_qty", "rd_id ='$rdid' AND item_id = '$item'");
        if($pr!=''){
            $recqty = $this->super_model->custom_query_single("sumqty","SELECT SUM(ri.received_qty) as sumqty FROM receive_items ri INNER JOIN receive_details rd ON ri.rd_id = rd.rd_id INNER JOIN receive_head rh ON rd.receive_id = rh.receive_id WHERE rh.saved = '1' AND rd.pr_no = '$pr' AND ri.item_id = '$item'");

           $issue_qty = $this->super_model->custom_query_single("issueqty","SELECT SUM(quantity) AS issueqty FROM issuance_head ih INNER JOIN issuance_details id ON ih.issuance_id = id.issuance_id WHERE pr_no= '$pr' AND item_id='$item'");
        }else{
            $recqty = $this->super_model->custom_query_single("sumqty","SELECT SUM(quantity) as sumqty FROM supplier_items WHERE item_id = '$item' AND catalog_no = 'begbal'");

            $issue_qty = $this->super_model->custom_query_single("issueqty","SELECT SUM(quantity) AS issueqty FROM issuance_head ih INNER JOIN issuance_details id ON ih.issuance_id = id.issuance_id WHERE pr_no= '$pr' AND item_id='$item' AND catalog_no = 'begbal'");
        }

      /*  $qty=array(0);
        foreach($this->super_model->select_row_where("request_head", "pr_no", $pr) AS $req){
            //echo $req->request_id . " - " . $item . "<br>";
                foreach($this->super_model->select_custom_where("request_items", "request_id ='$req->request_id' AND item_id = '$item'") AS $ri){
               // echo $ri->rq_id;
                 $qty[]=$this->super_model->select_column_where("issuance_details", "quantity", "rq_id", $ri->rq_id);
                }
        }*/

        //$issue_qty = array_sum($qty);
        $bal=($recqty-$issue_qty);

        echo $bal;
    }

    public function max_qty_pritem(){

    }

     public function itemlist(){
        $item=$this->input->post('item');

        $original_pn=$this->input->post('original_pn');
        $rows=$this->super_model->count_custom_where("items","item_name LIKE '%$item%'");
        //count_join_where("items",", $where,$group_id);
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("items", "item_name LIKE '%$item%'") AS $itm){ 
                    $name = str_replace('"', '', $itm->item_name);
                    //echo $name;
                    $rec_qty = $this->inventory_balance($itm->item_id);
                    ?>
                    <li onClick="selectItem('<?php echo $itm->item_id; ?>','<?php echo $name; ?>','<?php echo $itm->unit_id; ?>','<?php echo $itm->original_pn;?>','<?php echo $rec_qty;?>')"><strong><?php echo $itm->original_pn;?> - </strong> <?php echo $name; ?></li> 
                <?php 
            }
             echo "<ul>";
        }
        
    }

    public function crossref_balance($itemid,$supplierid,$brandid,$catalogno){
        $recqty= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no ='$catalogno'");

       $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no = '$catalogno' AND saved='1'","issuance_id");
        

        /* $begbal= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no = 'begbal'");

         $recqty= $this->super_model->select_sum_join("received_qty","receive_items","receive_head", "item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no ='$catalogno' AND saved='1'","receive_id");
        
        $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no ='$catalogno' AND saved='1'","issuance_id");
        
         $restockqty= $this->super_model->select_sum_join("quantity","restock_details","restock_head", "item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no ='$catalogno' AND saved='1' AND excess = '0'","rhead_id");
        
          $balance=($recqty+$begbal+$restockqty)-$issueqty;*/

         $balance=$recqty-$issueqty;
         return $balance;
    }

    public function crossreflist(){
        $item=$this->input->post('item');
         $prno=$this->input->post('prno');
        $rows=$this->super_model->count_custom_where("supplier_items","item_id = '$item'");
        if($rows!=0){ ?>
            <select name='siid' id='siid' class='form-control' onchange="getUnitCost('<?php echo $prno; ?>','<?php echo $item; ?>')" >
           <option value=''>-Cross Reference-</option>
            <?php 
            foreach($this->super_model->select_custom_where("supplier_items","item_id = '$item' AND quantity != '0'") AS $itm){ 
                    $brand = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $itm->brand_id);
                    $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $itm->supplier_id);
                   // echo $itm->item_id,$itm->supplier_id, $itm->brand_id, $itm->catalog_no;
                    $balance=$this->crossref_balance($itm->item_id,$itm->supplier_id, $itm->brand_id, $itm->catalog_no);
                    /*$unit = $this->super_model->select_column_where("items", "unit_id", "item_id", $itm->item_id);*/
                    foreach($this->super_model->select_custom_where("items","item_id = '$item'") AS $it){
                    $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $it->unit_id);
                    if($balance>0){
                    ?>
                    <option value="<?php echo $itm->si_id; ?>"><?php echo $supplier . " - " . $itm->catalog_no . " - ". $brand . " (".$balance.")" ." - ". $unit; ?></option>
                   <!--  <option value="<?php echo $itm->si_id; ?>"><?php echo $itm->item_id . " - " . $itm->supplier_id . " - ".  $itm->brand_id . " (".$balance.")" ." - ". $itm->catalog_no; ?></option> -->
                <?php } ?>

           <?php } } 
            echo "</select>";
        }
        
    }

    

    public function getitem(){
        foreach($this->super_model->select_row_where("supplier_items", "si_id", $this->input->post('siid')) AS $si){
             $brand = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $si->brand_id);
             $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $si->supplier_id);
             $supplier_id = $si->supplier_id;
             $brand_id=$si->brand_id;
             $catalog_no = $si->catalog_no;
             $invqty = $this->inventory_balance($si->item_id);
             foreach($this->super_model->select_custom_where("items","item_id = '$si->item_id'") AS $it){
                 $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $it->unit_id);
            }
        }
        $totalcost=$this->input->post('quantity')*$this->input->post('cost');

       $data['list'] = array(
            'original_pn'=>$this->input->post('original_pn'),
            'unit'=>$this->input->post('unit'),
            'unit_name'=>$unit,
            'itemid'=>$this->input->post('itemid'),
            'siid'=>$this->input->post('siid'),
            'brand'=>$brand,
            'brand_id'=>$brand_id,
            'supplier_id'=>$supplier_id,
            'supplier'=>$supplier,
            'catalog_no'=>$catalog_no,
            'invqty'=>$invqty,
            'quantity'=>$this->input->post('quantity'),
            'unit_cost'=>$this->input->post('cost'),
            'total_cost'=>$totalcost,
            'item'=>$this->input->post('itemname'),
            'count'=>$this->input->post('count'),
            'borrow'=>$this->input->post('borrow')
        );
            
        $this->load->view('request/row_item',$data);
     }

     public function printMReqF(){
        $id=$this->input->post('mreqfid');

        $data = array(
            "requested_by"=>$this->input->post('requested'),
            "reviewed_by"=>$this->input->post('reviewed'),
            "approved_by"=>$this->input->post('approved'),
            "noted_by"=>$this->input->post('noted')

        );

        $this->super_model->update_where("request_head", $data, "request_id", $id);
        echo "success";
    }

    public function getSIDetails(){
        $siid=$this->input->post('siid');

       /* $brand=$this->super_model->select_column_where("supplier_items", "brand_id", "si_id", $siid);
        $supplier=$this->super_model->select_column_where("supplier_items", "supplier_id", "si_id", $siid);
        $catalog=$this->super_model->select_column_where("supplier_items", "catalog_no", "si_id", $siid);
        $item=$this->super_model->select_column_where("supplier_items", "item_id", "si_id", $siid);

        $cost = $this->super_model->select_column_join_where_order_limit("item_cost", "receive_items","receive_head", "saved=1 AND supplier_id = '$supplier' AND brand_id = '$brand' AND catalog_no = '$catalog' AND item_id = '$item'","receive_id","DESC","1");*/
        $cost = $this->super_model->select_column_where("supplier_items", "item_cost", "si_id", $siid);
        echo $cost;
    }

      public function getReceiveCost(){
        $itemid=$this->input->post('itemid');
        $prno=$this->input->post('prno');
        if($prno!=''){
            $cost = $this->super_model->custom_query_single("item_cost","SELECT item_cost FROM receive_head rh INNER JOIN receive_details rd ON rh.receive_id = rd.receive_id INNER JOIN receive_items ri ON rd.rd_id = ri.rd_id WHERE rd.pr_no = '$prno' AND item_id = '$itemid'");
        }else{
            $cost = $this->super_model->custom_query_single("item_cost","SELECT item_cost FROM supplier_items WHERE item_id = '$itemid' AND catalog_no='begbal'");
        }
       
        echo $cost;
    }

    public function getMaxqty(){
        $siid=$this->input->post('siid');

        $brand=$this->super_model->select_column_where("supplier_items", "brand_id", "si_id", $siid);
        $supplier=$this->super_model->select_column_where("supplier_items", "supplier_id", "si_id", $siid);
        $catalog=$this->super_model->select_column_where("supplier_items", "catalog_no", "si_id", $siid);
        $itemid=$this->super_model->select_column_where("supplier_items", "item_id", "si_id", $siid);

        $recqty= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id = '$itemid' AND supplier_id = '$supplier' AND brand_id = '$brand' AND catalog_no ='$catalog'");

        $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND supplier_id = '$supplier' AND brand_id = '$brand' AND catalog_no = '$catalog' AND saved='1'","issuance_id");

        $maxqty = $recqty-$issueqty;
        echo $maxqty;
    }

    public function getEmpreq(){
        $employee_id = $this->input->post('employee_id');
        foreach($this->super_model->custom_query("SELECT employee_id, position, employee_name FROM employees WHERE employee_id='$employee_id'") AS $emp){   
            $return = array('position' => $emp->position); 
            echo json_encode($return);   
        }
    }

    public function getEmprev(){
        $employee_id = $this->input->post('employee_id');
        foreach($this->super_model->custom_query("SELECT employee_id, position, employee_name FROM employees WHERE employee_id='$employee_id'") AS $emp){   
            $return = array('position' => $emp->position); 
            echo json_encode($return);   
        }
    }

    public function getEmpapp(){
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
}
?>
