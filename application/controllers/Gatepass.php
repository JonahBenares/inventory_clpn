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

    public function gatepass_list(){
    $rows= $this->super_model->count_rows("gatepass_head");
        if($rows!=0){
        foreach($this->super_model->select_all("gatepass_head") AS $gatepass){
            $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $gatepass->supplier_id);
            //$prepared = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $gatepass->prepared_by);
            //$noted = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $gatepass->noted_by);
            //$approved = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $gatepass->approved_by);
            $data['gatepass'][] = array(
                'gatepassid'=>$gatepass->gatepass_id,
                'mgp_no'=>$gatepass->mgp_no,
                'destination'=>$gatepass->destination,
                'vehicle_no'=>$gatepass->vehicle_no,
                'date_issued'=>$gatepass->date_issued,
                'date_returned'=>$gatepass->date_returned,
                'supplier'=>$supplier,
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
           'supplier_id'=> $this->input->post('company'),
           'destination'=> $this->input->post('destination'),
           'vehicle_no'=> $this->input->post('vehicle_no'),
           'date_issued'=> $this->input->post('date_issued'),
           'date_returned'=> $this->input->post('date_returned'),
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
        $data['item_list']=$this->super_model->select_all_order_by("items","item_name","ASC");
        $data['unit']=$this->super_model->select_all_order_by("uom","unit_name","ASC");
        foreach($this->super_model->select_row_where("gatepass_head", "gatepass_id", $id) AS $pass){
            $data['head'][]=array(
                "mgp_no"=>$pass->mgp_no,
                "to_company"=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $pass->supplier_id),
                "destination"=>$pass->destination,
                "vehicle_no"=>$pass->vehicle_no,
                "date_issued"=>$pass->date_issued,
                "date_returned"=>$pass->date_returned,
                "prepared_by"=>$this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->prepared_by),
                "noted_by"=>$this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->noted_by),
                "approved_by"=>$this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->approved_by),
                "saved"=>$pass->saved,
            );
        }
        $row1=$this->super_model->count_rows_where("gatepass_details","gd_id",$id);
        if($row1!=0){
            foreach($this->super_model->select_row_where('gatepass_details','gatepass_id', $id) AS $gp){
                $item = $this->super_model->select_column_where("items", "item_name", "item_id", $gp->item_id);
                $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $gp->unit_id);
                $data['gatepass_itm'][] = array(
                    'item_name'=>$item,
                    'quantity'=>$gp->quantity,
                    'remarks'=>$gp->remarks,
                    'image'=>$gp->image,
                    'unit'=>$unit,
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
        $unit=$this->input->post('unit');
        $unit_name = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $unit);
        $item=$this->input->post('item');
        $item_name = $this->super_model->select_column_where("items", "item_name", "item_id", $item);
        
       $data['list'] = array(
            'unit_id'=>$unit,
            'unit'=>$unit_name,
            'quantity'=>$this->input->post('quantity'),
            'item_id'=>$item,
            'item'=>$item_name,
            'count'=>$this->input->post('count'),
            'remarks'=>$this->input->post('remarks'),
            'image'=>$this->input->post('image'),
        );
            
        $this->load->view('gatepass/row_item',$data);
     }

    public function insertGatepass(){
        $counter = $this->input->post('counter');
        $id=$this->input->post('gatepassid');
        for($a=0;$a<$counter;$a++){
            if(!empty($this->input->post('item['.$a.']'))){
                $data = array(
                    'gatepass_id'=>$this->input->post('gatepassid'),
                    'item_id'=>$this->input->post('item_id['.$a.']'),
                    'quantity'=>$this->input->post('quantity['.$a.']'),
                    'unit_id'=>$this->input->post('unit_id['.$a.']'),
                    'remarks'=>$this->input->post('remarks['.$a.']'),
                    'image'=>$this->input->post('image['.$a.']'),
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
                $item = $this->super_model->select_column_where("items", "item_name", "item_id", $gp->item_id);
                $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $gp->unit_id);
                $data['gatepass_itm'][] = array(
                    'item'=>$item,
                    'quantity'=>$gp->quantity,
                    'remarks'=>$gp->remarks,
                    'unit'=>$unit,
                );
            }
            $company = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $pass->supplier_id);
            $data['pass'][] = array(
                'gatepassid'=>$pass->gatepass_id,
                'mgp_no'=>$pass->mgp_no,
                'destination'=>$pass->destination,
                'vehicle_no'=>$pass->vehicle_no,
                'date_issued'=>$pass->date_issued,
                'date_issued'=>$pass->date_issued,
                'date_returned'=>$pass->date_returned,
                'to_company'=>$company,
            );
        }

        $data['printed']=$this->super_model->select_column_where('users', 'fullname', 'user_id', $_SESSION['user_id']);
        $this->load->view('template/header');
        $this->load->view('gatepass/gatepass_print',$data);
        $this->load->view('template/footer');
    }

    public function view_gatepass(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $this->load->model('super_model');
        $data['head'] = $this->super_model->select_row_where('gatepass_head', 'gatepass_id', $id);
        
        foreach($this->super_model->select_row_where('gatepass_head','gatepass_id', $id) AS $pass){
            foreach($this->super_model->select_row_where('gatepass_details','gatepass_id', $pass->gatepass_id) AS $gp){
                $item = $this->super_model->select_column_where("items", "item_name", "item_id", $gp->item_id);
                $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $gp->unit_id);
                $data['gatepass_itm'][] = array(
                    'item'=>$item,
                    'quantity'=>$gp->quantity,
                    'unit'=>$unit,
                    'remarks'=>$gp->remarks,

                );
            }
            $company = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $pass->supplier_id);
            //$prepared = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->prepared_by);
            //$noted = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->noted_by);
            //$approved = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $pass->approved_by);
            $data['pass'][] = array(
                'gatepassid'=>$pass->gatepass_id,
                'mgp_no'=>$pass->mgp_no,
                'destination'=>$pass->destination,
                'vehicle_no'=>$pass->vehicle_no,
                'date_issued'=>$pass->date_issued,
                'date_returned'=>$pass->date_returned,
                'company'=>$company,
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

