<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receive extends CI_Controller {
   
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
       // $this->dropdown['prno'] = $this->super_model->select_join_where_order("receive_details","receive_head", "saved='1'","receive_id", "receive_date", "DESC");

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

    public function view_receive(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $this->load->model('super_model');
        $data['head'] = $this->super_model->select_row_where('receive_head', 'receive_id', $id);
        $data['saved']=$this->super_model->select_column_where("receive_head",'saved','receive_id',$id);
        foreach($this->super_model->select_row_where('receive_details', 'receive_id', $id) AS $det){
            $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $det->purpose_id);
            $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $det->enduse_id);            
            $deparment = $this->super_model->select_column_where('department', 'department_name', 'department_id', $det->department_id);
            $data['details'][] = array(
                'rdid'=>$det->rd_id,
                'prno'=>$det->pr_no,
                'enduse'=>$enduse,
                'purpose'=>$purpose,
                'purpose_id'=>$det->purpose_id,
                'enduse_id'=>$det->enduse_id,
                'department'=>$deparment,
                'closed'=>$det->closed
            );
            foreach($this->super_model->select_row_where("receive_items", "rd_id", $det->rd_id) AS $items){
                foreach($this->super_model->select_custom_where("items", "item_id = '$items->item_id'") AS $itema){
                    $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
                }
                $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $items->supplier_id);
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $items->item_id);
                /*$unit = $this->super_model->select_column_where('items', 'unit_id', 'item_id', $items->item_id);*/
                $brand = $this->super_model->select_column_where('brand', 'brand_name', 'brand_id', $items->brand_id);
                $inspected = $this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $items->inspected_by);
                $serial = $this->super_model->select_column_where('serial_number', 'serial_no', 'serial_id', $items->serial_id);
                $total = $items->shipping_fee + $items->item_cost;
                $total_net_cost = $items->received_qty * $total;
                $data['items'][] = array(
                    'riid'=>$items->ri_id,
                    'rdid'=>$items->rd_id,
                    'supplier'=>$supplier,
                    'recid'=>$items->receive_id,
                    'supid'=>$items->supplier_id,
                    'item'=>$item,
                    'brand'=>$brand,
                    'unit_cost'=>$items->item_cost,
                    'catalog_no'=>$items->catalog_no,
                    'serial'=>$serial,
                    'unit'=>$unit,
                    'expqty'=>$items->expected_qty,
                    'recqty'=>$items->received_qty,
                    'inspected'=>$inspected,
                    'shipping_fee'=>$items->shipping_fee,
                    'currency'=>$items->currency,
                    'remarks'=>$items->remarks,
                    //'expiration_date'=>$items->expiration_date,
                    'total'=>$total,
                    'total_net_cost'=>$total_net_cost,
                    
                );
            }
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('receive/view_receive',$data);
        $this->load->view('template/footer');
    }

    public function edit_endpurp(){  
        $this->load->view('template/header');
        $data['id']=$this->input->post('id');
        $id=$this->input->post('id');
        $data['rec_id']=$this->input->post('recid');
        $rec_id=$this->input->post('recid');
        $data['pr_list']=$this->super_model->custom_query("SELECT pr_no, enduse_id, purpose_id,department_id FROM receive_head INNER JOIN receive_details WHERE saved='1' GROUP BY pr_no");
        $data['end'] = $this->super_model->select_all_order_by('enduse', 'enduse_name', 'ASC');
        $data['purp'] = $this->super_model->select_all_order_by('purpose', 'purpose_desc', 'ASC');
        $data['dept'] = $this->super_model->select_all_order_by('department', 'department_name', 'ASC');
        $this->load->model('super_model');
        foreach($this->super_model->select_row_where('receive_details', 'rd_id', $id) AS $det){
            $data['details'][] = array(
                'pr_no'=>$det->pr_no,
                'department_id'=>$det->department_id,
                'purpose_id'=>$det->purpose_id,
                'enduse_id'=>$det->enduse_id,
            );
        }
        $this->load->view('receive/edit_endpurp',$data);
    }

    public function update_purend(){
        $data = array(
            'pr_no'=>$this->input->post('pr_no'),
            'purpose_id'=>$this->input->post('purpose'),
            'enduse_id'=>$this->input->post('enduse'),
            'department_id'=>$this->input->post('department'),
        );
        $rd_id = $this->input->post('rd_id');
        $rec_id = $this->input->post('rec_id');
        if($this->super_model->update_where('receive_details', $data, 'rd_id', $rd_id)){
            echo "<script>alert('Successfully Updated!'); 
                window.location ='".base_url()."index.php/receive/view_receive/$rec_id'; </script>";
        }
    }

     public function mrf(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $this->load->model('super_model');
        $data['heads'] = $this->super_model->select_row_where('receive_head', 'receive_id', $id);
        foreach($this->super_model->select_row_where('receive_head', 'receive_id', $id) AS $us){
            $data['username'][] = array( 
                'user'=>$this->super_model->select_column_where('users', 'fullname', 'user_id', $us->user_id),
                'positionrec'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->received_by),
                'positionack'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->acknowledged_by),
                'positionnote'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->noted_by),
                'user_id'=>$us->user_id
            );
        }
        foreach($this->super_model->select_row_where('receive_details', 'receive_id', $id) AS $d){
            $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $d->enduse_id);
            $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $d->purpose_id);
            $deparment = $this->super_model->select_column_where('department', 'department_name', 'department_id', $d->department_id);
            $inspected = $this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $d->inspected_by);
            $data['details'][] = array(
                'rdid'=>$d->rd_id,
                'prno'=>$d->pr_no,
                'enduse'=>$enduse,
                'purpose'=>$purpose,
                'department'=>$deparment,
                'inspected'=>$inspected
            );
            foreach($this->super_model->select_row_where("receive_items", "rd_id", $d->rd_id) AS $items){
                foreach($this->super_model->select_custom_where("items", "item_id = '$items->item_id'") AS $itema){
                    $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
                }
                $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $items->supplier_id);
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $items->item_id);
                $part = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $items->item_id);
                /*$unit = $this->super_model->select_column_where('items', 'unit', 'item_id', $items->item_id);*/
                $brand = $this->super_model->select_column_where('brand', 'brand_name', 'brand_id', $items->brand_id);
              /*  $inspected = $this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $items->inspected_by);*/
                $total=$items->received_qty*$items->item_cost;
                //$count1 = $this->super_model->select_column_where('receive_details', 'pr_no', 'rd_id', $d->rd_id);
                //$count2 = $this->super_model->count_custom_where("receive_items","rd_id = '$d->rd_id'");
                $data['items'][] = array(
                    'rdid'=>$items->rd_id,
                    'supplier'=>$supplier,
                    'item'=>$item,
                    'part'=>$part,
                    'unit'=>$unit,
                    'expqty'=>$items->expected_qty,
                    'recqty'=>$items->received_qty,
                    'remarks'=>$items->remarks,
                    'shipping_fee'=>$items->shipping_fee,
                    'currency'=>$items->currency,
                    'catno'=>$items->catalog_no,
                    'brand'=>$brand,
                    'unitcost'=>$items->item_cost,
                   /* 'inspected'=>$inspected,*/
                    'total'=>$total
                );
            }
            foreach($this->super_model->select_row_where("receive_items", "rd_id", $d->rd_id) AS $itm_rem){
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $itm_rem->item_id);
                $data['remarks_it'][] = array(
                    'rdid'=>$items->rd_id,
                    'item'=>$item,
                    'remarks'=>$itm_rem->remarks
                );
            }
        }
        foreach($this->super_model->select_row_where("signatories", "delivered", "1") AS $deli){
            $data['delivered_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $deli->employee_id),
                'empid'=>$deli->employee_id
            );
        }
        foreach($this->super_model->select_row_where("signatories", "received", "1") AS $recei){
            $data['received_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $recei->employee_id),
                'empid'=>$recei->employee_id
            );
        }
        foreach($this->super_model->select_row_where("signatories", "acknowledged", "1") AS $acknow){
            $data['acknowledged_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $acknow->employee_id),
                'empid'=>$acknow->employee_id
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
        $this->load->view('receive/mrf',$data);
    }

    public function receive_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        // $data['enduse'] = $this->super_model->select_all('enduse');
        // $data['purpose'] = $this->super_model->select_all('purpose');
        // $data['receive'] = $this->super_model->select_all('receive_head');
        // $data['details'] = $this->super_model->select_all('receive_details');
        foreach($this->super_model->select_all("receive_head") AS $h){
            $data['receive'][] = array(
                'receive_id' => $h->receive_id,
                'receive_date'=> $h->receive_date,
                'dr_no'=> $h->dr_no,
                'po_no'=> $h->po_no,
                'si_no'=> $h->si_no,
                'mrecf_no'=>$h->mrecf_no
            );
            foreach($this->super_model->select_row_where("receive_details", "receive_id", $h->receive_id) AS $det){
                $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $det->enduse_id);
                $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $det->purpose_id);
                $department = $this->super_model->select_column_where('department', 'department_name', 'department_id', $det->department_id);
                $data['details'][] = array(
                    'receive_id' => $det->receive_id,
                    'closed'=>$det->closed,
                    'rdid'=>$det->rd_id,
                    'prno'=>$det->pr_no,
                    'enduse'=>$enduse,
                    'purpose'=>$purpose,
                    'department'=>$department
                ); 
            }
        }
        $this->load->view('receive/receive_list',$data);
        $this->load->view('template/footer');
    }  


    public function add_receive_first(){
        $id=$this->uri->segment(3);
        $data['receiveid']=$id;
        $data['saved']= $this->super_model->select_column_where("receive_head", "saved", "receive_id", $id);
        $data['list'] = $this->super_model->select_row_where("receive_head", "receive_id", $id);

        foreach($this->super_model->select_row_where("receive_details", "receive_id", $id) AS $details){
            $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $details->enduse_id);
            $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $details->purpose_id);
            $department = $this->super_model->select_column_where('department', 'department_name', 'department_id', $details->department_id);
            $inspected = $this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $details->inspected_by);
            $data['details'][] = array(
                'rdid'=>$details->rd_id,
                'prno'=>$details->pr_no,
                'enduse'=>$enduse,
                'purpose'=>$purpose,
                'department'=>$department,
                'inspected'=>$inspected
            ); 

            foreach($this->super_model->select_row_where("receive_items", "rd_id", $details->rd_id) AS $items){
                foreach($this->super_model->select_custom_where("items","item_id = '$items->item_id'") AS $it){
                     $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $it->unit_id);
                }
                $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $items->supplier_id);
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $items->item_id);
                /*$unit = $this->super_model->select_column_where('items', 'unit', 'item_id', $items->item_id);*/
                $brand = $this->super_model->select_column_where('brand', 'brand_name', 'brand_id', $items->brand_id);  
                $inspected = $this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $items->inspected_by);  
                $serial = $this->super_model->select_column_where('serial_number', 'serial_no', 'serial_id', $items->serial_id);  
                $total=$items->item_cost+$items->shipping_fee;
                $total_net_cost=$items->received_qty*$total;
                $data['items'][] = array(
                    'rdid'=>$items->rd_id,
                    'supplier'=>$supplier,
                    'item'=>$item,
                    'brand'=>$brand,
                    'catalog_no'=>$items->catalog_no,
                    'serial'=>$serial,
                    'unit_cost'=>$items->item_cost,
                    'unit'=>$unit,
                    'expqty'=>$items->expected_qty,
                    'recqty'=>$items->received_qty,
                    'inspected_by'=>$inspected,
                    'remarks'=>$items->remarks,
                    'total'=>$total,
                    'total_net_cost'=>$total_net_cost,
                    'local_mnl'=>$items->local_mnl,
                    'shipping_fee'=>$items->shipping_fee,
                    'currency'=>$items->currency,
                    //'expiration_date'=>$items->expiration_date,
                );
            }
        }

        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('receive/add_receive_first',$data);
        $this->load->view('template/footer');
    } 

    public function add_receive_second(){
        $id=$this->uri->segment(3);
        $rdid=$this->uri->segment(4);
        $data['receiveid']=$id;
        $data['rdid']=$rdid;
        $data['supplier'] = $this->super_model->select_all_order_by("supplier", "supplier_name", "ASC");
        $data['brand'] = $this->super_model->select_custom_where("brand", "brand_name!='' ORDER BY brand_name ASC");
        $data['items'] = $this->super_model->select_all_order_by("items", "item_name", "ASC");
        $data['pr_list'] = $this->super_model->custom_query("SELECT pr_no, department_id, enduse_id, purpose_id FROM receive_details rd INNER JOIN receive_head rh ON rd.receive_id = rh.receive_id WHERE rh.saved='1' AND rd.closed='0' GROUP BY rd.pr_no");
        foreach($this->super_model->select_row_where("receive_details", "rd_id", $rdid) AS $d){
            $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $d->enduse_id);
            $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $d->purpose_id);
            $department = $this->super_model->select_column_where('department', 'department_name', 'department_id', $d->department_id);
            $data['details'][] = array(
                'rdid'=>$d->rd_id,
                'prno'=>$d->pr_no,
                'enduse'=>$enduse,
                'purpose'=>$purpose,
                'department'=>$department,
                'department_id'=>$d->department_id,
                'enduse_id'=>$d->enduse_id,
                'purpose_id'=>$d->purpose_id,
                'inspected'=>$d->inspected_by,
            );
        }
        $data['enduse'] = $this->super_model->select_all_order_by("enduse",'enduse_name','ASC');
        $data['purpose'] = $this->super_model->select_all_order_by("purpose",'purpose_desc','ASC');
        $data['department'] = $this->super_model->select_all_order_by('department', 'department_name', 'ASC');
        foreach($this->super_model->select_row_where("signatories", "inspected", "1") AS $sign){
            $data['employee'][] = array( 
                    'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $sign->employee_id),
                    'empid'=>$sign->employee_id
                );
        }
        $count_ri = $this->super_model->count_rows_where("receive_items", "rd_id", $rdid);
        if($count_ri!=0){
        foreach($this->super_model->select_row_where("receive_items", "rd_id", $rdid) AS $rit){
            foreach($this->super_model->select_custom_where("items", "item_id = '$rit->item_id'") AS $itema){
                $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
            }
            $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $rit->item_id);
            $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $rit->supplier_id);
            /*$unit = $this->super_model->select_column_where('items', 'unit', 'item_id', $rit->item_id);*/
            $brand = $this->super_model->select_column_where('brand', 'brand_name', 'brand_id', $rit->brand_id);
            $inspected = $this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $rit->inspected_by);
            $total=$rit->item_cost+$rit->shipping_fee;
            $total_net_cost=$rit->received_qty*$total;
            $serial = $this->super_model->select_column_where('serial_number', 'serial_no', 'serial_id', $rit->serial_id);
            $data['receive_items'][] = array(
                    'riid'=>$rit->ri_id,
                    'rdid'=>$rdid,
                    'supplier'=>$supplier,
                    'item'=>$item,
                    'brand'=>$brand,
                    'catalog_no'=>$rit->catalog_no,
                    'unit_cost'=>$rit->item_cost,
                    'unit'=>$unit,
                    'expqty'=>$rit->expected_qty,
                    'recqty'=>$rit->received_qty,
                    'remarks'=>$rit->remarks,
                    'inspected'=>$inspected,
                    'total'=>$total,
                    'total_net_cost'=>$total_net_cost,
                    'serial'=>$serial,
                    'local_mnl'=>$rit->local_mnl,
                    'shipping_fee'=>$rit->shipping_fee,
                    'currency'=>$rit->currency,
                    //'expiration_date'=>$rit->expiration_date,
                );
        }
    } else {
          $data['receive_items'] = array();
    }
        $this->load->view('template/header');
        $this->load->view('receive/add_receive_second',$data);
        $this->load->view('template/footer');
    } 

    public function getIteminformation(){
        $item = $this->input->post('item');
        foreach($this->super_model->custom_query("SELECT item_id, item_name, unit_id, original_pn FROM items WHERE item_id='$item'") AS $itm){ 
            $return = array('item_id' => $itm->item_id,'item_name' => $itm->item_name, 'unit' => $itm->unit_id, 'pn' => $itm->original_pn); 
            echo json_encode($return);   
        }
    }

    public function getSupplierinformation(){
        $supplier = $this->input->post('supplier');
        foreach($this->super_model->custom_query("SELECT supplier_id, supplier_name FROM supplier WHERE supplier_id='$supplier'") AS $sup){ 
            $return = array('supplier_id' => $sup->supplier_id,'supplier_name' => $sup->supplier_name); 
            echo json_encode($return);   
        }
    }

    public function tag_receive(){
        $this->load->view('template/header');
        $this->load->view('receive/tag_receive');
        $this->load->view('template/footer');
    } 

    public function update_headr(){
        $id=$this->uri->segment(3);
        $data['id']=$id;
        $data['head'] = $this->super_model->select_custom_where("receive_head","receive_id = '$id'");
        $this->load->view('template/header');
        $this->load->view('receive/update_headr',$data);
        $this->load->view('template/footer');
    } 

    public function edit_head(){
        $data = array(
            'dr_no'=>$this->input->post('dr_no'),
            'po_no'=>$this->input->post('po_no'),
            'si_no'=>$this->input->post('si_no'),
            'pcf'=>$this->input->post('pcf'),
        );
        $id = $this->input->post('id');
        $receiveid = $this->super_model->select_column_where("receive_head", "receive_id", "receive_id", $id);

            if($this->super_model->update_custom_where("receive_head",$data,"receive_id = '$id'")){
            ?> 
            <script>
                alert('Successfully Updated'); 
                window.opener.location.href ='<?php echo base_url(); ?>index.php/receive/view_receive/<?php echo $receiveid; ?>'; 
                window.close();
            </script>
            <?php
        }
    } 

    public function insert_receive_head(){
        $receivedate=$this->input->post('receive_date');
        $pcf=$this->input->post('pcf');
        $drno=$this->input->post('dr_no');
        $pono=$this->input->post('po_no');
        /*$jono=$this->input->post('jo_no');*/
        $sino=$this->input->post('si_no');
        $userid=$this->input->post('userid');

        $year=date('Y-m');
        $year_series=date('Y');
        $now=date('Y-m-d H:i:s');
        //$rows=$this->super_model->count_rows("receive_head");
        $rows=$this->super_model->count_custom_where("receive_head","create_date LIKE '$year_series%'");
        if($rows==0){
             $newrec_no = "MRIF-".$year."-0001";
        } else {
            //$maxrecno=$this->super_model->get_max("receive_head", "mrecf_no");
            $maxrecno=$this->super_model->get_max_where("receive_head", "mrecf_no","create_date LIKE '$year_series%'");
            $recno = explode('-',$maxrecno);
            $series = $recno[3]+1;
            if(strlen($series)==1){
                $newrec_no = "MRIF-".$year."-000".$series;
            } else if(strlen($series)==2){
                 $newrec_no = "MRIF-".$year."-00".$series;
            } else if(strlen($series)==3){
                 $newrec_no = "MRIF-".$year."-0".$series;
            } else if(strlen($series)==4){
                 $newrec_no = "MRIF-".$year."-".$series;
            }
        }

        $head_rows = $this->super_model->count_rows("receive_head");
        if($head_rows==0){
            $receiveid=1;
        } else {
            $maxid=$this->super_model->get_max("receive_head", "receive_id");
            $receiveid=$maxid+1;
        }
        $data = array(
           'receive_id'=>$receiveid,
           'pcf'=>$pcf,
           'create_date'=> $now,
           'receive_date'=> $receivedate,
           'mrecf_no'=> $newrec_no,
           'dr_no'=> $drno,
           /*'jo_no'=> $jono,*/
           'po_no'=> $pono,
           'si_no'=> $sino,
           'user_id'=> $userid
        );
        if($this->super_model->insert_into("receive_head", $data)){
             redirect(base_url().'index.php/receive/add_receive_first/'.$receiveid);
        }
    }


    public function itemlist(){
        $item=$this->input->post('item');
        $original_pn=$this->input->post('original_pn');
        $rows=$this->super_model->count_custom_where("items","item_name LIKE '%$item%'");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("items", "item_name LIKE '%$item%'") AS $itm){ 
                    $name = str_replace('"', '', $itm->item_name);
                    ?>
                   <li onClick="selectItem('<?php echo $itm->item_id; ?>','<?php echo $name; ?>','<?php echo $itm->unit_id; ?>','<?php echo $itm->original_pn;?>')"><strong><?php echo $itm->original_pn;?> - </strong> <?php echo $name; ?></li>
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

     public function prnolist(){
        $prno=$this->input->post('prno');
        $rows=$this->super_model->custom_query("SELECT pr_no FROM receive_details rd INNER JOIN receive_head rh ON rd.receive_id = rh.receive_id WHERE rd.pr_no LIKE '%$prno%' AND rh.saved='1' AND rd.closed='0' GROUP BY rd.pr_no");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->custom_query("SELECT pr_no, department_id, enduse_id, purpose_id, inspected_by FROM receive_details rd INNER JOIN receive_head rh ON rd.receive_id = rh.receive_id WHERE rd.pr_no LIKE '%$prno%' AND rh.saved='1' AND rd.closed='0' GROUP BY rd.pr_no") AS $pr){ 
                    $purpose = $this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id",$pr->purpose_id);
                    ?>
                   <li onClick="selectPRNO('<?php echo $pr->pr_no; ?>','<?php echo $pr->department_id; ?>','<?php echo $pr->enduse_id; ?>','<?php echo $pr->purpose_id; ?>','<?php echo $pr->inspected_by; ?>')"><?php echo $pr->pr_no; ?></li>
                <?php 
            }
           

             echo "<ul>";
        }
    }

    public function getPRinformation(){
        $prno = $this->input->post('prno');
        foreach($this->super_model->custom_query("SELECT pr_no, department_id, enduse_id, purpose_id, inspected_by FROM receive_details rd INNER JOIN receive_head rh ON rd.receive_id = rh.receive_id WHERE rd.pr_no='$prno' AND rh.saved='1' AND rd.closed='0' GROUP BY rd.pr_no") AS $pr){   
            $return = array('pr_no' => $pr->pr_no,'department_id' => $pr->department_id,'enduse_id' => $pr->enduse_id,'purpose_id' => $pr->purpose_id,'inspected_by' => $pr->inspected_by); 
            echo json_encode($return);   
        }
    }

    /*public function purposelist(){
        $purpose=$this->input->post('purpose');
        $rows=$this->super_model->count_custom_where("purpose","purpose_desc LIKE '%$purpose%'");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("purpose", "purpose_desc LIKE '%$purpose%'") AS $pur){ 
                    $name = str_replace('"', '', $pur->purpose_desc);
                    ?>
                   <li onClick="selectPurpose('<?php echo $pur->purpose_id; ?>','<?php echo $name; ?>')"><?php echo $name; ?></li>
                <?php 
            }
             echo "<ul>";
        }
    }*/


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
        foreach($this->super_model->custom_query("SELECT brand_id, brand_name FROM brand WHERE brand_id='$brand'") AS $brnd){  
            $return = array('brand_id' => $brnd->brand_id,'brand_name' => $brnd->brand_name); 
            echo json_encode($return);   
        }
    }

    public function insertbrand(){
        $brand = $this->input->post('brandname');
        $brnd = array(
           'brand_name'=>$brand,
        );
        $this->super_model->insert_into("brand", $brnd);
    }

    public function seriallist(){
        $serial=$this->input->post('serial');
        $item=$this->input->post('item');
        $brand=$this->input->post('brand');
        $brandl=$this->input->post('brandl');
        $iteml=$this->input->post('iteml');
        $seriall=$this->input->post('seriall');
        $count_exist=0;
      //  print_r($seriall);
        if(empty($seriall)){
            $s = array();
        } else {
            $s =  array($seriall);
        }

        if(empty($iteml)){
            $i = array();
        } else {
            $i =  array($iteml);
        }

         if(empty($brandl)){
            $b = array();
        } else {
            $b =  array($brandl);
        }

       if(in_array($item, $i)){
        $count_exist++;
       }

       if(in_array($brand, $b)){
        $count_exist++;
       }

       if(in_array($serial, $s)){
        $count_exist++;
       }


       if($count_exist==3){
           echo "error";
        } else {
             $rows=$this->super_model->count_custom_where("serial_number","serial_no LIKE '%$serial%'");
            if($rows!=0){
                 echo "<ul id='name-item'>";
                foreach($this->super_model->select_custom_where("serial_number", "serial_no LIKE '%$serial%'") AS $srl){ 
                       
                        ?>
                       <li onClick="selectSerial('<?php echo $srl->serial_id; ?>','<?php echo $srl->serial_no; ?>')"><?php echo $srl->serial_no; ?></li>
                    <?php 
                }
                 echo "<ul>";
            } 
        }
    }
    
    public function getitem(){
     
        foreach($this->super_model->select_row_where("items", "item_id", $this->input->post('itemid')) AS $ins){
            $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id",$ins->unit_id);
        }
        $total=$this->input->post('unitcost') + $this->input->post('shipping_fee');
        $total_net_cost=$this->input->post('recqty') * $total;
        $serial =  $this->input->post('serialid');
        $item =  $this->input->post('itemid');
        $itemname =  $this->input->post('itemname');
        $suppliername =  $this->input->post('suppliername');
        $brandid =  $this->input->post('brandid');
        if(!empty($brandid)){
            $brandname=$this->input->post('brandname');
        }else{
            $brandname=$this->input->post('brand');
        }
        $data['list'] = array(
            'supplier'=>$this->input->post('suppliername'),
            'supplierid'=>$this->input->post('supplierid'),
            'itemid'=>$this->input->post('itemid'),
            'brandid'=>$this->input->post('brandid'),
            'brand'=>$brandname,
            'serialid'=>$this->input->post('serialid'),
            'serial'=>$this->input->post('serial'),
            'catno'=>trim($this->input->post('catno'), " "),
            'unitcost'=>$this->input->post('unitcost'),
            'unit'=>$this->input->post('unit'),
            'unit_name'=>$unit,
            'expqty'=>$this->input->post('expqty'),
            'recqty'=>$this->input->post('recqty'),
            'remarks'=>$this->input->post('remarks'),
            'shipping_fee'=>$this->input->post('shipping_fee'),
            'currency'=>$this->input->post('currency'),
            'item'=>$this->input->post('itemname'),
            'local_mnl'=>$this->input->post('local_mnl'),
            //'expiration_date'=>$this->input->post('expiration_date'),
            'count'=>$this->input->post('count'),
            'total'=>$total,
            'total_net_cost'=>$total_net_cost,
        );  
        $this->load->view('receive/row_item',$data);
    }

     public function insertReceivePR(){

        $rid = $this->input->post('rdid');
       
        if($rid==0){
            $rows=$this->super_model->count_rows("receive_details");
              
            if($rows==0){
                $rdid=1;
            } else {
                $maxid= $this->super_model->get_max("receive_details", "rd_id");
                $rdid=$maxid+1;
            }


            /*if(empty($this->input->post('purpose_id'))){

               $pmaxid=$this->super_model->get_max("purpose", "purpose_id");
               $purid=$pmaxid+1;

               $purpose_data = array(
                    'purpose_id' => $purid,
                    'purpose_desc' =>$this->input->post('purpose')
               );

                 $this->super_model->insert_into("purpose", $purpose_data);
            }  else {
                $purid = $this->input->post('purpose_id');
            }*/


               $details = array(
                   'rd_id'=>$rdid,
                   'receive_id'=> $this->input->post('receiveid'),
                   'pr_no'=> $this->input->post('prno'),
                   'enduse_id'=> $this->input->post('enduse'),
                   'purpose_id'=> $this->input->post('purpose'),
                   'inspected_by'=> $this->input->post('inspected'),
                   'department_id'=> $this->input->post('department')
                );

        
                $this->super_model->insert_into("receive_details", $details);
        } else {
            $rdid=$this->input->post('rdid');

             $details = array(
                   'pr_no'=> $this->input->post('prno'),
                   'enduse_id'=> $this->input->post('enduse'),
                   'purpose_id'=> $this->input->post('purpose'),
                   'inspected_by'=> $this->input->post('inspected'),
                   'department_id'=> $this->input->post('department')
                );

            $this->super_model->update_where("receive_details", $details, "rd_id", $rdid);
        }
        
        
        //echo $rdid;
        $counter = $this->input->post('counter');
       
        $pono=$this->super_model->select_column_where("receive_head", "po_no", "receive_id", $this->input->post('receiveid'));
        for($a=0;$a<$counter;$a++){

            if(empty($this->input->post('brand_id['.$a.']'))){

               $maxid=$this->super_model->get_max("brand", "brand_id");
               $bid=$maxid+1;

               $brand_data = array(
                    'brand_id' => $bid,
                    'brand_name' => $this->input->post('brand['.$a.']')
               );

                 $this->super_model->insert_into("brand", $brand_data);
            }  else {
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
            $items = array(
                'rd_id'=>$rdid,
                'receive_id'=> $this->input->post('receiveid'),
                'po_no'=>$pono,
                'supplier_id'=> $this->input->post('supplier_id['.$a.']'),
                'item_id'=> $this->input->post('item_id['.$a.']'),
                'brand_id'=> $bid,
                'catalog_no'=> str_replace(" ", "", $this->input->post('catalog_no['.$a.']')),
                'serial_id'=> $serialid,
                'item_cost'=> $this->input->post('unit_cost['.$a.']'),
                'expected_qty'=> $this->input->post('expqty['.$a.']'),
                'received_qty'=> $this->input->post('recqty['.$a.']'),
                'remarks'=> $this->input->post('remarks['.$a.']'),
                'shipping_fee'=> $this->input->post('shipping_fee['.$a.']'),
                'currency'=> $this->input->post('currency['.$a.']'),
                'local_mnl'=> $this->input->post('local_mnl['.$a.']'),
                //'expiration_date'=> $this->input->post('expiration_date['.$a.']')
                /*'inspected_by'=> $this->input->post('inspected_name['.$a.']')*/
            );
            //print_r($items);
            $this->super_model->insert_into("receive_items", $items);      
            }
        }
        
        echo $this->input->post('receiveid');
     }

     public function deleteRecDetails(){
        $rdid = $this->input->post('rdid');

        $this->super_model->delete_where("receive_details", "rd_id", $rdid);
        $this->super_model->delete_where("receive_items", "rd_id", $rdid);
     }

      public function deleteRecItem(){
        $riid = $this->input->post('riid');

        $this->super_model->delete_where("receive_items", "ri_id", $riid);
     }

     public function saveReceive(){
        $receiveID = $this->input->post('receiveID');

        foreach($this->super_model->select_row_where("receive_items", "receive_id", $receiveID) AS $itm){
            $count_exist = $this->super_model->count_custom_where("supplier_items","item_id = '$itm->item_id' AND supplier_id = '$itm->supplier_id' AND catalog_no = '$itm->catalog_no' AND brand_id = '$itm->brand_id'");

            $sumcost = $this->super_model->select_sum_where("receive_items", "item_cost", "item_id = '$itm->item_id'  AND supplier_id = '$itm->supplier_id' AND catalog_no = '$itm->catalog_no' AND brand_id = '$itm->brand_id'");
            //$sumcost = $this->super_model->select_sum_join("item_cost","receive_items","receive_head", "saved='1' AND ","receive_id");
          //  echo $sumcost . "+" . $itm->item_cost;
           // $totalsum=$sumcost+$itm->item_cost;

         //   $rowcount=$this->super_model->select_count_join("receive_items","receive_head", "saved='1' AND item_id = '$itm->item_id' AND supplier_id = '$itm->supplier_id' AND catalog_no = '$itm->catalog_no' AND brand_id = '$itm->brand_id'","receive_id");
            $rowcount=$this->super_model->count_custom_where("receive_items","item_id = '$itm->item_id' AND supplier_id = '$itm->supplier_id' AND catalog_no = '$itm->catalog_no' AND brand_id = '$itm->brand_id'");
            $count_item=$rowcount;
          
          //echo $itm->item_id . " = " .$sumcost . " / " . $count_item . "<br>";
            $ave = $sumcost/$count_item;


            if($count_exist==0){

             $rows_supp=$this->super_model->count_rows("supplier_items");
              
            if($rows_supp==0){
                $suppid=1;
            } else {
                $maxid= $this->super_model->get_max("supplier_items", "si_id");
                $suppid=$maxid+1;
            }

                $data = array(
                    'si_id'=>$suppid,
                    'item_id'=>$itm->item_id,
                    'supplier_id'=>$itm->supplier_id,
                    'catalog_no'=>$itm->catalog_no,
                    'brand_id'=>$itm->brand_id,
                    'item_cost'=>$ave,
                    'quantity'=>$itm->received_qty
                );

                 $this->super_model->insert_into("supplier_items", $data);

                 $data3 = array(
                    "si_id"=>$suppid
                );

                $this->super_model->update_where("serial_number", $data3, "serial_id", $itm->serial_id);

            } else {
               $qty = $this->super_model->select_column_custom_where("supplier_items","quantity","item_id = '$itm->item_id' AND supplier_id = '$itm->supplier_id' AND catalog_no = '$itm->catalog_no' AND brand_id = '$itm->brand_id'");
               
               $siid = $this->super_model->select_column_custom_where("supplier_items","si_id","item_id = '$itm->item_id' AND supplier_id = '$itm->supplier_id' AND catalog_no = '$itm->catalog_no' AND brand_id = '$itm->brand_id'");

               $newqty=$qty + $itm->received_qty;

                $data = array(
                    'quantity'=>$newqty,
                    'item_cost'=>$ave
                );

                $this->super_model->update_where("supplier_items", $data, "si_id", $siid);
                
                 $data3 = array(
                    "si_id"=>$siid
                );

                $this->super_model->update_where("serial_number", $data3, "serial_id", $itm->serial_id);

            }

               $data2 = array(
                    'saved'=>1
                );

                $this->super_model->update_where("receive_head", $data2, "receive_id", $receiveID);

               
        }
     }

     public function search_receive(){
        $rdate=$this->input->post('rdate');
        $dr=$this->input->post('dr');
        $po=$this->input->post('po');
        /*$jo=$this->input->post('jo');*/
        $si=$this->input->post('si');
        $pr=$this->input->post('pr');
        $enduse=$this->input->post('enduse');
        $purpose=$this->input->post('purpose');
        $this->load->model('super_model');
        $data['receive_head'] = $this->super_model->select_all('receive_head');
        $data['receive_details'] = $this->super_model->select_all('receive_details');
        $data['enduse'] = $this->super_model->select_all('enduse');
        $data['purpose'] = $this->super_model->select_all('purpose');
        $sql="";
        $filter ="";
        if(!empty($rdate)){
            $sql.= " receive_head.receive_date LIKE '%$rdate%' AND";
            $filter.="Receive Date = ".$rdate.", ";
        }

        if(!empty($dr)){
            $sql.= " receive_head.dr_no LIKE '%$dr%' AND";
            $filter.="DR No. = " .$dr. ", ";
        }

        if(!empty($po)){
            $sql.= " receive_head.po_no LIKE '%$po%' AND";
            $filter.="PO No. = " .$po. ", ";
        }

        if(!empty($si)){
            $sql.= " receive_head.si_no LIKE '%$si%' AND";
            $filter.="SI No. = " .$si.", ";
        }

        if(!empty($pr)){
            $sql.= " receive_details.pr_no LIKE '%$pr%' AND";
            $filter.="PR No. = " .$pr. ", ";
        }

        if(!empty($enduse)){
            $sql.= " receive_details.enduse_id = '$enduse' AND";
            $filter.="End-Use = " . $this->super_model->select_column_where('enduse', 'enduse_name', 
                        'enduse_id', $enduse). ", ";
        }

        if(!empty($purpose)){
            $sql.= " receive_details.purpose_id = '$purpose' AND";
            $filter.="Purpose = " . $this->super_model->select_column_where('purpose', 'purpose_desc', 
                        'purpose_id', $purpose). ", ";
        }

        $query=substr($sql,0,-3);
        $filter=substr($filter,0,-2);
      
        $count=$this->super_model->count_join_where("receive_head","receive_details", $query, 'receive_id');
       
        $data['filter']=$filter;
        if($count!=0){
            $data['count_query'] = 1;
            foreach ($this->super_model->select_join_where("receive_head", "receive_details", $query, "receive_id") AS $itm){
                $data['receive'][] = array(
                    'receive_id' => $itm->receive_id,
                    'receive_date'=> $itm->receive_date,
                    'dr_no'=> $itm->dr_no,
                    'po_no'=> $itm->po_no,
                    'si_no'=> $itm->si_no,
                    'mrecf_no'=>$itm->mrecf_no
                );
            } 
            foreach($this->super_model->select_all('receive_details') as $det){
                $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $det->enduse_id);
                $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $det->purpose_id);
                $department = $this->super_model->select_column_where('department', 'department_name', 'department_id', $det->department_id);
                $data['details'][] = array(
                    'receive_id' => $det->receive_id,
                    'closed'=>$det->closed,
                    'rdid'=>$det->rd_id,
                    'prno'=>$det->pr_no,
                    'enduse'=>$enduse,
                    'purpose'=>$purpose,
                    'department'=>$department
                );
            }
           /* $data['receive'][] = $this->super_model->select_join_where("receive_head", "receive_details", $query, "receive_id");*/
            /*$data['details'] = $this->super_model->select_all('receive_details');*/
        }else {
                $data['count_query'] = 0;
                 $data['receive']=array();
            }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('receive/receive_list',$data);
        $this->load->view('template/footer');
    }

    public function update_prc_mrk(){
        $id=$this->uri->segment(3);
        $data['id']=$id;
        $data['rem'] = $this->super_model->select_custom_where("receive_items","ri_id = '$id'");


        $this->load->view('template/header');
        $this->load->view('receive/update_prc_mrk',$data);
        $this->load->view('template/footer');
    }

    public function edit_prc_mrk(){
        $data = array(
            //'item_cost'=>$this->input->post('price'),
            'remarks'=>$this->input->post('remarks'),
        );
        $id = $this->input->post('id');

        $itemid = $this->super_model->select_column_where("receive_items", "item_id", "ri_id", $id);
        $supplierid = $this->super_model->select_column_where("receive_items", "supplier_Id", "ri_id", $id);
        $brandid = $this->super_model->select_column_where("receive_items", "brand_id", "ri_id", $id);
        $catalog = $this->super_model->select_column_where("receive_items", "catalog_no", "ri_id", $id);
        $receiveid = $this->super_model->select_column_where("receive_items", "receive_id", "ri_id", $id);

        /*$price = array(
            'item_cost'=>$this->input->post('price')
        );*/
            if($this->super_model->update_custom_where("receive_items",$data,"ri_id = '$id'")){
                  //$this->super_model->update_custom_where("supplier_items",$price,"item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id='$brandid' AND catalog_no = '$catalog'");
            ?> 
            <script>
                alert('Successfully Updated'); 
                window.opener.location.href ='<?php echo base_url(); ?>index.php/receive/view_receive/<?php echo $receiveid; ?>'; 
                window.close();
            </script>
            <?php
        }
    } 

    public function update_close(){
       // $id=$this->uri->segment(3);
       
        $prno=$this->input->post('prno');
       // echo $prno;
       // $saved=$this->uri->segment(5);
        //$prno;
        foreach($this->super_model->select_row_where("receive_details", "pr_no", $prno) AS $rec){
            foreach($this->super_model->select_row_where("receive_items", "receive_id", $rec->receive_id) AS $ri){

                 $expected[] =$this->super_model->select_column_custom_where("receive_items","expected_qty", "po_no='$ri->po_no' AND item_id = '$ri->item_id' AND supplier_id = '$ri->supplier_id' AND brand_id = '$ri->brand_id' AND catalog_no = '$ri->catalog_no'","receive_id");
            
                 $received[]=$this->super_model->select_sum_where_group5("receive_items", "received_qty", "po_no='$ri->po_no' AND item_id = '$ri->item_id' AND supplier_id = '$ri->supplier_id' AND brand_id = '$ri->brand_id' AND catalog_no = '$ri->catalog_no'", "po_no","item_id","supplier_id","brand_id","catalog_no");

                
            }
        }

        $sum_expect=array_sum($expected);
        $sum_receive=array_sum($received);


        if($sum_receive < $sum_expect){
            echo "x";
        } else if($sum_receive == $sum_expect){
           $data2 = array(
            'closed'=>1
           );

            if($this->super_model->update_where("receive_details", $data2, "pr_no", $prno)){
                echo "ok";
            }

           
        }
      
    }

    public function printMRF(){
        $id=$this->input->post('recid');

        $data = array(
            "delivered_by"=>$this->input->post('delivered'),
            "received_by"=>$this->input->post('received'),
            "acknowledged_by"=>$this->input->post('acknowledged'),
            "noted_by"=>$this->input->post('noted')
        );

        $this->super_model->update_where("receive_head", $data, "receive_id", $id);
        echo "success";
    }

    public function close_remarks(){
        $data['prno']=$this->uri->segment(3);
        $data['recid']=$this->uri->segment(4);
        $this->load->view('template/header');
        $this->load->view('receive/close_remarks',$data);
    }

    public function closePR(){
        $prno=$this->input->post('prno');
        $remarks=$this->input->post('remarks');

         $data = array(
            "closed"=>'1',
            "close_remarks"=>$remarks
        );

         $this->super_model->update_where("receive_details", $data, "pr_no", $prno);

         foreach($this->super_model->select_row_where("receive_details", "pr_no", $prno) AS $rec){

             foreach($this->super_model->select_row_where("receive_items", "rd_id", $rec->rd_id) AS $ri){
                  $data2 = array(
                        "expected_qty"=>$ri->received_qty
                  );

                $this->super_model->update_where("receive_items", $data2, "ri_id", $ri->ri_id);
             }
         }

    
    }

    public function getEmpinfo(){
        $employee_id = $this->input->post('employee_id');
        foreach($this->super_model->custom_query("SELECT employee_id, position, employee_name FROM employees WHERE employee_id='$employee_id'") AS $emp){   
            $return = array('position' => $emp->position); 
            echo json_encode($return);   
        }
    }

    public function getEmpack(){
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