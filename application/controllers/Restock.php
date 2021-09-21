<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restock extends CI_Controller {

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

    public function restock_list(){
        $rows= $this->super_model->count_rows("restock_head");
        if($rows!=0){
            foreach($this->super_model->select_all('restock_head') AS $res){
                $department = $this->super_model->select_column_where("department", "department_name", "department_id", $res->department_id);
                $enduse = $this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $res->enduse_id);
                $purpose = $this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $res->purpose_id);
                /*if($res->excess!=1){
                    $returned_by = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $res->returned_by);
                }else{
                    $returned_by = $this->super_model->select_column_where("users", "fullname", "user_id", $res->returned_by);
                }*/
               /* $returned_by = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $res->returned_by);
                $noted_by = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $res->noted_by);
                $acknowledge_by = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $res->acknowledge_by);
                if($res->excess!=1){
                    $received_by = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $res->received_by);
                }else{
                    $received_by = $this->super_model->select_column_where("users", "fullname", "user_id", $res->received_by);
                }
                }*/
                $data['restock'][] = array(
                    'rhead_id'=>$res->rhead_id,
                    'date'=>$res->restock_date,
                    'from_pr'=>$res->from_pr,
                    'department'=>$department,
                    'enduse'=>$enduse,
                    'purpose'=>$purpose,
                    'mrwf_no'=>$res->mrwf_no,
                    'excess'=>$res->excess,
                );
            }
        } else {
            $data['restock']=array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('restock/restock_list',$data);
        $this->load->view('template/footer');
    }

    public function add_restock(){
        $data['enduse'] = $this->super_model->select_all("enduse");
        $data['purpose'] = $this->super_model->select_all("purpose");
        $data['department'] = $this->super_model->select_all("department");
        $data['employee'] = $this->super_model->select_all_order_by('employees', 'employee_name', 'ASC');
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('restock/add_restock',$data);
        $this->load->view('template/footer');
    }

    public function deleteResItem(){
        $rdetails_id = $this->input->post('rdetails_id');
        $this->super_model->delete_where("restock_details", "rdetails_id", $rdetails_id);
    }

    public function add_restock_second(){
        $id=$this->uri->segment(3);
        $data['rhead_id']= $id;
        $data['supplier'] = $this->super_model->select_all_order_by("supplier", "supplier_name", "ASC");
        $data['brand'] = $this->super_model->select_custom_where("brand", "brand_name!='' ORDER BY brand_name ASC");
        $data['items'] = $this->super_model->select_all_order_by("items", "item_name", "ASC");
        $data['reasonlist']=$this->super_model->select_custom_where("restock_details", "reason != '' GROUP BY reason");
        foreach($this->super_model->select_row_where("restock_details", "rhead_id", $id) AS $rit){
            foreach($this->super_model->select_custom_where("items", "item_id = '$rit->item_id'") AS $itema){
                $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
            }
            $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $rit->item_id);
            $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $rit->supplier_id);
            $brand = $this->super_model->select_column_where('brand', 'brand_name', 'brand_id', $rit->brand_id);
            $serial = $this->super_model->select_column_where('serial_number', 'serial_no', 'serial_id', $rit->serial_id);
            $data['rdetails_id'] = $this->super_model->select_column_where('restock_details', 'rdetails_id', 'rhead_id', $id);
            $total= $rit->quantity*$rit->item_cost;
            $data['details'][] = array(
                    'rdetails_id'=>$rit->rdetails_id,
                    'rhead_id'=>$rit->rhead_id,
                    'supplier'=>$supplier,
                    'item'=>$item,
                    'brand'=>$brand,
                    'catalog_no'=>$rit->catalog_no,
                    'reason'=>$rit->reason,
                    'remarks'=>$rit->remarks,
                    'item_cost'=>$rit->item_cost,
                    'qty'=>$rit->quantity,
                    'total'=>$total,
                    'serial'=>$serial
                );
        }
        $this->load->view('template/header');
        $this->load->view('restock/add_restock_second',$data);
        $this->load->view('template/footer');
    }

    public function edit_endpurp(){  
        $this->load->view('template/header');
        $data['id']=$this->input->post('id');
        $id=$this->input->post('id');
        $data['end'] = $this->super_model->select_all_order_by('enduse', 'enduse_name', 'ASC');
        $data['purp'] = $this->super_model->select_all_order_by('purpose', 'purpose_desc', 'ASC');
        $data['dept'] = $this->super_model->select_all_order_by('department', 'department_name', 'ASC');
        $data['pr_list']=$this->super_model->custom_query("SELECT pr_no, enduse_id, purpose_id,department_id FROM receive_head INNER JOIN receive_details WHERE saved='1' GROUP BY pr_no");
        foreach($this->super_model->select_row_where('restock_head', 'rhead_id', $id) AS $i){
            $data['restock_list'][]=array(
                'from_pr'=>$i->from_pr,
                'purpose_id'=>$i->purpose_id,
                'enduse_id'=>$i->enduse_id,
                'department_id'=>$i->department_id,
            );
        }
        $this->load->view('restock/edit_endpurp',$data);
    }

    public function update_purend(){
        $data = array(
            'from_pr'=>$this->input->post('pr_no'),
            'purpose_id'=>$this->input->post('purpose'),
            'enduse_id'=>$this->input->post('enduse'),
            'department_id'=>$this->input->post('department'),
        );
        $rhead_id = $this->input->post('rhead_id');
        if($this->super_model->update_where('restock_head', $data, 'rhead_id', $rhead_id)){
            echo "<script>alert('Successfully Updated!'); 
                window.location ='".base_url()."index.php/restock/restock_list'; </script>";
        }
    }

    public function getIteminformation(){
        $item = $this->input->post('item');
        foreach($this->super_model->select_custom_where("items", "item_id='$item'") AS $itm){ 
            $return = array('item_id' => $itm->item_id,'item_name' => $itm->item_name, 'unit' => $itm->unit_id, 'pn' => $itm->original_pn); 
            echo json_encode($return);   
        }
    }

    public function getSupplierinformation(){
        $supplier = $this->input->post('supplier');
        foreach($this->super_model->select_custom_where("supplier", "supplier_id='$supplier'") AS $sup){ 
            $return = array('supplier_id' => $sup->supplier_id,'supplier_name' => $sup->supplier_name); 
            echo json_encode($return);   
        }
    }

    public function getPRinformation(){
        $prno = $this->input->post('prno');
        foreach($this->super_model->custom_query("SELECT pr_no, enduse_id, purpose_id,department_id FROM receive_head INNER JOIN receive_details WHERE pr_no LIKE '%$prno%' AND saved='1' GROUP BY pr_no") AS $pr){ 
            $return = array('pr_no' => $pr->pr_no,'enduse' => $pr->enduse_id, 'purpose' => $pr->purpose_id, 'department' => $pr->department_id); 
            echo json_encode($return);   
        }
    }

    public function add_restock_first(){
        $id=$this->uri->segment(3);
        $data['rhead_id']=$id;
        $data['saved']= $this->super_model->select_column_where("restock_head", "saved", "rhead_id", $id);
        /*$data['enduse'] = $this->super_model->select_all("enduse");
        $data['purpose'] = $this->super_model->select_all("purpose");
        $data['department'] = $this->super_model->select_all("department");
        $data['employee'] = $this->super_model->select_all_order_by('employees', 'employee_name', 'ASC');*/
        //$data['restock'] = $this->super_model->select_row_where("restock_head", "rhead_id", $id);
        foreach($this->super_model->select_row_where("restock_head", "rhead_id", $id) AS $res){
            $department = $this->super_model->select_column_where("department", "department_name", "department_id", $res->department_id);
            $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $res->purpose_id);
            $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $res->enduse_id);
            $data['restock'][] = array(
                'rhead_id'=>$res->rhead_id,
                'date'=>$res->restock_date,
                'pr_no'=>$res->pr_no,
                'department'=>$department,
                'purpose'=>$purpose,
                'enduse'=>$enduse,
                'saved'=>$res->saved,
                
            );
        }
        foreach($this->super_model->select_row_where("restock_details", "rhead_id", $id) AS $det){
            $serial = $this->super_model->select_column_where("serial_number", "serial_no", "serial_id", $det->serial_id);
            $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $det->item_id);
            $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $det->supplier_id);
            $brand = $this->super_model->select_column_where('brand', 'brand_name', 'brand_id', $det->brand_id);
            $data['rdetails_id'] = $this->super_model->select_column_where('restock_details', 'rdetails_id', 'rhead_id', $id);
            $total=$det->quantity*$det->item_cost;
            $data['details'][] = array(
                'rhead_id'=>$det->rhead_id,
                'serial'=>$serial,
                'item'=>$item,
                'supplier'=>$supplier,
                'brand'=>$brand,
                'qty'=>$det->quantity,
                'catalog_no'=>$det->catalog_no,
                'item_cost'=>$det->item_cost,
                'total'=>$total,
                'reason'=>$det->reason,
                'remarks'=>$det->remarks
            );
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('restock/add_restock_first',$data);
        $this->load->view('template/footer');
    }

    public function view_restock(){
        $id=$this->uri->segment(3);
        $data['rhead_id']=$id;
        $data['saved']= $this->super_model->select_column_where("restock_head", "saved", "rhead_id", $id);
        /*$data['enduse'] = $this->super_model->select_all("enduse");
        $data['purpose'] = $this->super_model->select_all("purpose");
        $data['department'] = $this->super_model->select_all("department");
        $data['employee'] = $this->super_model->select_all_order_by('employees', 'employee_name', 'ASC');*/
        //$data['restock'] = $this->super_model->select_row_where("restock_head", "rhead_id", $id);
        foreach($this->super_model->select_row_where("restock_head", "rhead_id", $id) AS $res){
            $department = $this->super_model->select_column_where("department", "department_name", "department_id", $res->department_id);
            $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $res->purpose_id);
            $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $res->enduse_id);
            $data['restock'][] = array(
                'rhead_id'=>$res->rhead_id,
                'date'=>$res->restock_date,
                'from_pr'=>$res->from_pr,
                'department'=>$department,
                'purpose'=>$purpose,
                'enduse'=>$enduse,
                'saved'=>$res->saved
            );
        }
        foreach($this->super_model->select_row_where("restock_details", "rhead_id", $id) AS $det){
            $serial = $this->super_model->select_column_where("serial_number", "serial_no", "serial_id", $det->serial_id);
            $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $det->item_id);
            $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $det->supplier_id);
            $brand = $this->super_model->select_column_where('brand', 'brand_name', 'brand_id', $det->brand_id);
            $data['details'][] = array(
                'rdetails_id'=>$det->rdetails_id,
                'rhead_id'=>$det->rhead_id,
                'serial'=>$serial,
                'item'=>$item,
                'supplier'=>$supplier,
                'brand'=>$brand,
                'qty'=>$det->quantity,
                'catalog_no'=>$det->catalog_no,
                'reason'=>$det->reason,
                'remarks'=>$det->remarks
            );
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('restock/view_restock',$data);
        $this->load->view('template/footer');
    }

     public function insertrestock_Item(){
        $counter = $this->input->post('counter');
        for($a=0;$a<$counter;$a++){
            if(empty($this->input->post('brand_id['.$a.']'))){
                $maxid=$this->super_model->get_max("brand", "brand_id");
                $bid=$maxid+1;
                $brand_data = array(
                    'brand_id' => $bid,
                    'brand_name' => $this->input->post('brand['.$a.']')
                );
                $this->super_model->insert_into("brand", $brand_data);
            } else {
                $bid = $this->input->post('brand_id['.$a.']');
            }
            if(empty($this->input->post('serial_id['.$a.']'))){

               $maxid=$this->super_model->get_max("serial_number", "serial_id");
               $serialid=$maxid+1;

               $serial_data = array(
                    'serial_id' => $serialid,
                    'serial_no' => $this->input->post('serial['.$a.']')
               );

                 $this->super_model->insert_into("serial_number", $serial_data);
            }  else {
                $serialid = $this->input->post('serial_id['.$a.']');
            }
            if(!empty($this->input->post('supplier_id['.$a.']'))){
                $details = array(
                    'rhead_id'=> $this->input->post('rhead_id'),
                    'user_id'=> $this->input->post('userid'),
                    'item_id'=> $this->input->post('item_id['.$a.']'),
                    'supplier_id'=> $this->input->post('supplier_id['.$a.']'),
                    'brand_id'=> $this->input->post('brand_id['.$a.']'),
                    'serial_id'=> $this->input->post('serial_id['.$a.']'),
                    'catalog_no'=> $this->input->post('catalog_no['.$a.']'),
                    'item_cost'=> $this->input->post('item_cost['.$a.']'),
                    'reason'=> $this->input->post('reason['.$a.']'),
                    'remarks'=> $this->input->post('remarks['.$a.']'),
                    'quantity'=> $this->input->post('quantity['.$a.']')
                );
            $this->super_model->insert_into("restock_details", $details);
            }
        }
        echo $this->input->post('rhead_id');
    }

    public function saveRestock(){
        $rhead_id=$this->input->post('restockID');
        foreach($this->super_model->select_row_where("restock_details", "rhead_id", $rhead_id) AS $itm){
            $count_exist = $this->super_model->count_custom_where("supplier_items","item_id = '$itm->item_id' AND supplier_id = '$itm->supplier_id' AND catalog_no = '$itm->catalog_no' AND brand_id = '$itm->brand_id'");
            if($count_exist==0){
                $data = array(
                    'item_id'=>$itm->item_id,
                    'supplier_id'=>$itm->supplier_id,
                    'catalog_no'=>$itm->catalog_no,
                    'brand_id'=>$itm->brand_id,
                    'quantity'=>$itm->quantity
                );
                $this->super_model->insert_into("supplier_items", $data);
            } else {
                $qty = $this->super_model->select_column_custom_where("supplier_items","quantity","item_id = '$itm->item_id' AND supplier_id = '$itm->supplier_id' AND catalog_no = '$itm->catalog_no' AND brand_id = '$itm->brand_id'");

                $siid = $this->super_model->select_column_custom_where("supplier_items","si_id","item_id = '$itm->item_id' AND supplier_id = '$itm->supplier_id' AND catalog_no = '$itm->catalog_no' AND brand_id = '$itm->brand_id'");

                $stock_qty = $itm->quantity;

                $newqty= $qty + $stock_qty;

                $data = array(
                    'quantity'=>$newqty
                );
                $this->super_model->update_where("supplier_items", $data, "si_id", $siid);
            }  
            
            $data2 = array(
                'saved'=>1
            );
            $this->super_model->update_where("restock_head", $data2, "rhead_id", $rhead_id);
        }
        /*$restock_rows = $this->super_model->count_rows("restock_head");
        if($restock_rows==0){
            $restock_id=1;
        } else {
            $maxid=$this->super_model->get_max("restock_head", "rhead_id");
            $restock_id=$maxid;
        }
        echo $restock_id;*/
    }

    public function getitem(){
        $item_id=$this->input->post('itemid');
        $supplier_id=$this->input->post('supplierid');
        $brand_id=$this->input->post('brandid');
        $cat_no=$this->input->post('catno');
        $count = $this->super_model->count_custom_where("receive_items", "item_id='$item_id' AND supplier_id='$supplier_id'");
        if($count!=0){ 
            foreach($this->super_model->select_custom_where("receive_items", "item_id='$item_id' AND supplier_id='$supplier_id'") AS $itm){
                $item_cost=$itm->item_cost; 
            }
        }else {
            $item_cost='';
        }
        $totalcost=$this->input->post('quantity')*$item_cost;
        $data['list'] = array(
            'supplier'=>$this->input->post('supplier'),
            'supplierid'=>$supplier_id,
            'supplier_name'=>$this->input->post('suppliername'),
            'itemid'=>$item_id,
            'brandid'=>$brand_id,
            'brand'=>$this->input->post('brandname'),
            'serialid'=>$this->input->post('serialid'),
            'serial'=>$this->input->post('serial'),
            'catno'=>$cat_no,
            'reason'=>$this->input->post('reason'),
            'remarks'=>$this->input->post('remarks'),
            'item'=>$this->input->post('itemname'),
            'quantity'=>$this->input->post('quantity'),
            'item_cost'=>$item_cost,
            'total'=>$totalcost,
            'count'=>$this->input->post('count')
        );   
        $this->load->view('restock/row_item',$data);
    }

     

    public function prnolist(){
        $prno=$this->input->post('prres');
      /*  $rows=$this->super_model->custom_query("SELECT pr_no,saved FROM issuance_head WHERE pr_no LIKE '%$prno%' AND saved='1'  GROUP BY pr_no");*/
      $rows=$this->super_model->custom_query("SELECT rd.pr_no, rh.saved FROM receive_head rh INNER JOIN receive_details rd WHERE rd.pr_no LIKE '%$prno%' AND rh.saved='1'  GROUP BY rd.pr_no");
        if($rows!=0){
             echo "<ul id='name-item'>";
            /*foreach($this->super_model->custom_query("SELECT pr_no, enduse_id, purpose_id,department_id,saved FROM issuance_head WHERE pr_no LIKE '%$prno%' AND saved='1' GROUP BY pr_no") AS $pr){ */
                foreach($this->super_model->custom_query("SELECT pr_no, enduse_id, purpose_id,department_id FROM receive_head INNER JOIN receive_details WHERE pr_no LIKE '%$prno%' AND saved='1' GROUP BY pr_no") AS $pr){ 
                    ?>
                   <li onClick="selectPrRestock('<?php echo $pr->pr_no; ?>','<?php echo $pr->enduse_id; ?>','<?php echo $pr->purpose_id; ?>','<?php echo $pr->department_id; ?>')"><?php echo $pr->pr_no; ?></li>
                <?php 
            }
            echo "<ul>";
        }
    }
    
    public function mrsf(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $this->load->model('super_model');
        foreach($this->super_model->select_row_where('restock_head','rhead_id', $id) AS $stock){
            if($stock->excess!=1){
                $received = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $stock->received_by);
                $receive_id = $stock->received_by;
            }else {
                $received = $this->super_model->select_column_where("users", "fullname", "user_id", $stock->received_by);
                $receive_id = '';
            }
            /*if($stock->excess!=1){
                $returned = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $stock->returned_by);
            }else{
                $returned = $this->super_model->select_column_where("users", "fullname", "user_id", $stock->returned_by);
            }*/
            $returned = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $stock->returned_by);
            $acknowledge = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $stock->acknowledge_by);
            $department = $this->super_model->select_column_where("department", "department_name", "department_id", $stock->department_id);
            $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $stock->purpose_id);
            $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $stock->enduse_id);
            $noted_by = $this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $stock->noted_by);
            if(!empty($receive_id)){
                $positionrec=$this->super_model->select_column_where('employees', 'position', 'employee_id', $stock->received_by);
            }else{
                $positionrec='Warehouse Personnel';
            }   
            $positionret=$this->super_model->select_column_where('employees', 'position', 'employee_id', $stock->returned_by);
            $positionack=$this->super_model->select_column_where('employees', 'position', 'employee_id', $stock->acknowledge_by);
            $positionnoted=$this->super_model->select_column_where('employees', 'position', 'employee_id', $stock->noted_by);
            $data['restock'][] = array(
                'date'=>$stock->restock_date,
                'prno'=>$stock->from_pr,
                'returned'=>$returned,
                'received'=>$received,
                'department'=>$department,
                'purpose'=>$purpose,
                'enduse'=>$enduse,
                'acknowledge'=>$acknowledge,
                'noted_by'=>$noted_by,
                'mrwf_no'=>$stock->mrwf_no,
                'positionrec'=>$positionrec,
                'positionret'=>$positionret,
                'positionack'=>$positionack,
                'positionnoted'=>$positionnoted,
            );
        }
        foreach($this->super_model->select_row_where('restock_details','rhead_id', $id) AS $det){
            $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $det->item_id);
            $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $det->supplier_id);
            $brand = $this->super_model->select_column_where('brand', 'brand_name', 'brand_id', $det->brand_id);
            $pno = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $det->item_id);
            $unit = $this->super_model->select_column_custom_where('items', 'unit_id', "item_id = '$det->item_id'");
            $un = $this->super_model->select_column_custom_where('uom', 'unit_name', "unit_id = '$unit'");
            $serial = $this->super_model->select_column_where("serial_number", "serial_no", "serial_id", $det->serial_id);
            $data['details'][] = array(
                'serial'=>$serial,
                'item'=>$item,
                'supplier'=>$supplier,
                'brand'=>$brand,
                'catno'=>$det->catalog_no,
                'qty'=>$det->quantity,
                'returned'=>$returned,
                'received'=>$received,
                'department'=>$department,
                'purpose'=>$purpose,
                'enduse'=>$enduse,
                'acknowledge'=>$acknowledge,
                'noted_by'=>$noted_by,
                'pno'=>$pno,
                'unit'=>$un,
                'reason'=>$det->reason,
                'remarks'=>$det->remarks
            );
        }
        $this->load->view('template/header');
        $this->load->view('template/print_head');
        $this->load->view('restock/mrsf',$data);
    }


    public function itemlist(){
        $item=$this->input->post('item');
        $rows=$this->super_model->count_custom_where("items","item_name LIKE '%$item%'");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("items", "item_name LIKE '%$item%'") AS $itm){ 
                    $name = str_replace('"', '', $itm->item_name);
                    ?>
                   <li onClick="selectItem('<?php echo $itm->item_id; ?>','<?php echo $name; ?>')"><strong><?php echo $itm->original_pn;?> - </strong> <?php echo $name; ?></li>
                <?php 
            }
             echo "<ul>";
        }
    }

     public function supplierlist(){
        $supplier=$this->input->post('supplier');
        $rows=$this->super_model->count_custom_where("supplier","supplier_name LIKE '%$supplier%'");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("supplier", "supplier_name LIKE '%$supplier%'") AS $sup){ 
                    $name = str_replace('"', '', $sup->supplier_name);
                    ?>
                   <li onClick="selectSupplier('<?php echo $sup->supplier_id; ?>','<?php echo $name; ?>')"><?php echo $name; ?></li>
                <?php 
            }
             echo "<ul>";
        }
    }


    public function brandlist(){
        $brand=$this->input->post('brand');
        $rows=$this->super_model->count_custom_where("brand","brand_name LIKE '%$brand%'");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("brand", "brand_name LIKE '%$brand%'") AS $brnd){ 
                   
                    ?>
                   <li onClick="selectBrand('<?php echo $brnd->brand_id; ?>','<?php echo $brnd->brand_name; ?>')"><?php echo $brnd->brand_name; ?></li>
                <?php 
            }
             echo "<ul>";
        }
    }

    public function getBrandinformation(){
        $brand = $this->input->post('brand');
        foreach($this->super_model->select_custom_where("brand", "brand_id='$brand'") AS $brnd){  
            $return = array('brand_id' => $brnd->brand_id,'brand_name' => $brnd->brand_name); 
            echo json_encode($return);   
        }
    }

    public function reasonlist(){
        $reason=$this->input->post('reason');
        $rows=$this->super_model->count_custom_where("restock_details","reason LIKE '%$reason%'");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("restock_details", "reason LIKE '%$reason%' AND reason != '' GROUP BY reason") AS $re){ 
                   
                    ?>
                   <li onClick="selectReason('<?php echo $re->reason; ?>')"><?php echo $re->reason; ?></li>
                <?php 
            }
             echo "<ul>";
        }
    }

    public function insert_restock_head(){
        $date=date('Y-m-d');
        $year=date('Y-m');
        $year_series=date('Y');
        $rows=$this->super_model->count_custom_where("restock_head","restock_date LIKE '$year_series%'");
        if($rows==0){
             $mrwfno = "MRWF-".$year."-0001";
        } else {
            $maxrecno=$this->super_model->get_max_where("restock_head", "mrwf_no","restock_date LIKE '$year_series%'");
            $recno = explode('-',$maxrecno);
            $series = $recno[3]+1;
            if(strlen($series)==1){
                $mrwfno = "MRWF-".$year."-000".$series;
            } else if(strlen($series)==2){
                 $mrwfno = "MRWF-".$year."-00".$series;
            } else if(strlen($series)==3){
                 $mrwfno = "MRWF-".$year."-0".$series;
            } else if(strlen($series)==4){
                 $mrwfno = "MRWF-".$year."-".$series;
            }
        }
        $data = array(
           'restock_date'=>$date,
           'from_pr'=> $this->input->post('prno'),
           'returned_by'=> $this->input->post('returned'),
           'received_by'=> $this->input->post('received'),
           'acknowledge_by'=> $this->input->post('acknowledge'),
           'purpose_id'=> $this->input->post('purpose'),
           'enduse_id'=> $this->input->post('enduse'),
           'department_id'=> $this->input->post('department'),
           'noted_by'=> $this->input->post('noted_by'),
           'mrwf_no'=>$mrwfno
        );

        if($this->super_model->insert_into("restock_head", $data)){
            $restock_rows = $this->super_model->count_rows("restock_head");
            if($restock_rows==0){
                $restock_id=1;
            } else {
                $maxid=$this->super_model->get_max("restock_head", "rhead_id");
                $restock_id=$maxid;
            }
            echo $restock_id;
        }
    }


    public function insertrestock(){

        $date=date('Y-m-d');
        $itemid=$this->input->post('item_id');
        $supplierid=$this->input->post('supplier_id');
        $brandid=$this->input->post('brand_id');
        $catalog=$this->input->post('catalog_no');
        $stock_qty=$this->input->post('quantity');
        $year=date('Y-m');
        $year_series=date('Y');
        $rows=$this->super_model->count_custom_where("restock","restock_date LIKE '$year_series%'");
        if($rows==0){
            $mrwfno = "MRWF-".$year."-0001";
        } else {
            $maxrecno=$this->super_model->get_max_where("restock", "mrwf_no","restock_date LIKE '$year_series%'");
            $recno = explode('-',$maxrecno);
            $series = $recno[3]+1;
            if(strlen($series)==1){
                $mrwfno = "MRWF-".$year."-000".$series;
            } else if(strlen($series)==2){
                 $mrwfno = "MRWF-".$year."-00".$series;
            } else if(strlen($series)==3){
                 $mrwfno = "MRWF-".$year."-0".$series;
            } else if(strlen($series)==4){
                 $mrwfno = "MRWF-".$year."-".$series;
            }
        }
        if(!empty($this->input->post('reason'))){
            $data = array(
               'restock_date'=>$date,
               'pr_no'=> $this->input->post('prno'),
               'serial_no'=> $this->input->post('serial'),
               'item_id'=> $this->input->post('item_id'),
               'supplier_id'=> $this->input->post('supplier_id'),
               'brand_id'=> $this->input->post('brand_id'),
               'catalog_no'=> $this->input->post('catalog_no'),
               'quantity'=> $this->input->post('quantity'),
               'returned_by'=> $this->input->post('returned'),
               'received_by'=> $this->input->post('received'),
               'acknowledge_by'=> $this->input->post('acknowledge'),
               'user_id'=> $this->input->post('userid'),
               'remarks'=> $this->input->post('remarks'),
               'purpose_id'=> $this->input->post('purpose'),
               'enduse_id'=> $this->input->post('enduse'),
               'department_id'=> $this->input->post('department'),
               'noted_by'=> $this->input->post('noted_by'),
               'reason'=> $this->input->post('reason'),
               'mrwf_no'=>$mrwfno
            );
        }else {
            $data = array(
               'restock_date'=>$date,
               'pr_no'=> $this->input->post('prno'),
               'serial_no'=> $this->input->post('serial'),
               'item_id'=> $this->input->post('item_id'),
               'supplier_id'=> $this->input->post('supplier_id'),
               'brand_id'=> $this->input->post('brand_id'),
               'catalog_no'=> $this->input->post('catalog_no'),
               'quantity'=> $this->input->post('quantity'),
               'returned_by'=> $this->input->post('returned'),
               'received_by'=> $this->input->post('received'),
               'acknowledge_by'=> $this->input->post('acknowledge'),
               'user_id'=> $this->input->post('userid'),
               'remarks'=> $this->input->post('remarks'),
               'purpose_id'=> $this->input->post('purpose'),
               'enduse_id'=> $this->input->post('enduse'),
               'department_id'=> $this->input->post('department'),
               'noted_by'=> $this->input->post('noted_by'),
               'mrwf_no'=>$mrwfno
            );
        }

        if($this->super_model->insert_into("restock", $data)){
            $count_exist = $this->super_model->count_custom_where("supplier_items","item_id = '$itemid' AND supplier_id = '$supplierid' AND catalog_no = '$catalog' AND brand_id = '$brandid'");

            if($count_exist==0){
                $data = array(
                    'item_id'=>$itemid,
                    'supplier_id'=>$supplierid,
                    'catalog_no'=>$catalog,
                    'brand_id'=>$brandid,
                    'quantity'=>$stock_qty
                );
                $this->super_model->insert_into("supplier_items", $data);
            } else {
               $qty = $this->super_model->select_column_custom_where("supplier_items","quantity","item_id = '$itemid' AND supplier_id = '$supplierid' AND catalog_no = '$catalog' AND brand_id = '$brandid'");
               
               $siid = $this->super_model->select_column_custom_where("supplier_items","si_id","item_id = '$itemid' AND supplier_id = '$supplierid' AND catalog_no = '$catalog' AND brand_id = '$brandid'");

               $newqty=$qty + $stock_qty;

                $data = array(
                    'quantity'=>$newqty
                );

                $this->super_model->update_where("supplier_items", $data, "si_id", $siid);
                
            }

            $restock_rows = $this->super_model->count_rows("restock");
            if($restock_rows==0){
                $restock_id=1;
            } else {
                $maxid=$this->super_model->get_max("restock", "restock_id");
                $restock_id=$maxid;
            }

            echo $restock_id;
        }
    }
    
}
?>
