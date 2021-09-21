<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');

class Items extends CI_Controller {

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
      //  $this->dropdown['prno'] = $this->super_model->select_join_where_order("receive_details","receive_head", "saved='1'","receive_id", "receive_date", "DESC");
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

    public function activity_log($activity){
        $timestamp = date('Y-m-d H:i:s');
        $data = array(
            "activity_time"=>$timestamp,
            "activity_name"=>$activity,
            "user_id"=>$_SESSION['user_id']
        );

        $this->super_model->insert_into("activity_logs", $data);
    }


    public function index(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('items/login');
        $this->load->view('template/footer');
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

    public function item_export(){
        $this->load->view('template/header');
        $data['subcat'] = $this->super_model->select_all_order_by('item_subcat', 'subcat_name', 'ASC');
        $data['category'] = $this->super_model->select_all_order_by('item_categories', 'cat_name', 'ASC');
        $this->load->view('items/item_export',$data);
    }

    public function item_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        
        $data['category'] = $this->super_model->select_all('item_categories');
        $data['subcat'] = $this->super_model->select_all('item_subcat');
        $data['group'] = $this->super_model->select_all('group');
        $data['location'] = $this->super_model->select_all('location');
        $data['warehouse'] = $this->super_model->select_all('warehouse');
        $data['bin'] = $this->super_model->select_all('bin');
        $data['rack'] = $this->super_model->select_all('rack');
        $row=$this->super_model->count_rows("items");
        if($row!=0){
            foreach($this->super_model->select_all('items') AS $itm){
                $bin = $this->super_model->select_column_where('bin', 'bin_name', 'bin_id', $itm->bin_id);
                $rack = $this->super_model->select_column_where('rack', 'rack_name', 'rack_id', $itm->rack_id);
                $warehouse = $this->super_model->select_column_where('warehouse', 'warehouse_name', 
                    'warehouse_id', $itm->warehouse_id);
                $location = $this->super_model->select_column_where('location', 'location_name', 
                    'location_id', $itm->location_id);
                $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itm->unit_id);
                $unit_price = $this->super_model->select_column_custom_where('receive_items', 'item_cost', "item_id='$itm->item_id' ORDER BY receive_id DESC");
               // $totalqty=$this->super_model->select_sum("supplier_items", "quantity", "item_id", $itm->item_id);
                $totalqty=$this->inventory_balance($itm->item_id);
                $data['items'][] = array(
                    'item_id'=>$itm->item_id,
                    'original_pn'=>$itm->original_pn,
                    'item_name'=>$itm->item_name,
                    'category'=>$this->super_model->select_column_where('item_categories', 'cat_name', 
                    'cat_id', $itm->category_id),
                    'subcategory'=>$this->super_model->select_column_where('item_subcat', 'subcat_name', 
                    'subcat_id', $itm->subcat_id),
                    'quantity'=>$totalqty,
                    'bin'=>$bin,
                    'rack'=>$rack,
                    'warehouse'=>$warehouse,
                    'location'=>$location,                
                    'minimum'=>$itm->min_qty,
                    'damage'=>$itm->damage,
                    'unit_price'=>$unit_price,
                    'uom'=>$unit
                );
            }
        }else{
            $data['items'] = array();
        }
        $data['access']=$this->access;
        $this->load->view('items/item_list',$data);
        $this->load->view('template/footer');
    }

     public function add_item_first(){

        $data['subcat'] = $this->super_model->select_all_order_by('item_subcat', 'subcat_name', 'ASC');
        $data['group'] = $this->super_model->select_all_order_by('group','group_name','ASC');
        $data['location'] = $this->super_model->select_all_order_by('location','location_name','ASC');
        $data['warehouse'] = $this->super_model->select_all_order_by('warehouse','warehouse_name','ASC');
        $data['unit'] = $this->super_model->select_all_order_by('uom','unit_name','ASC');
        $data['rack'] = $this->super_model->select_all_order_by('rack','rack_name','ASC');
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('items/add_item_first',$data);
        $this->load->view('template/footer');
    }
    public function add_item_second(){

        $id=$this->uri->segment(3);
        $data['id'] = $id;
        $data['item'] = $this->super_model->select_row_where("items", "item_id", $id);

        $row_sup=$this->super_model->count_rows_where("supplier_items","item_id", $id);
        $serial='';
        if($row_sup!=0){


            foreach($this->super_model->select_row_where_order_by("supplier_items", "item_id", $id, "supplier_id", "ASC") AS $i){

                foreach($this->super_model->select_row_where("serial_number", "si_id", $i->si_id) AS $ser){

                     $serial.=$ser->serial_no.", ";
                 }  

               // $serial.=$this->super_model->select_column_where("serial_number", "serial_no", "si_id", $i->si_id).", ";
                $data['supplier_item'][] = array(
                    "si_id"=>$i->si_id,
                    "item_id"=>$i->item_id,
                    "supplier"=> $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $i->supplier_id),
                    "catalog"=>$i->catalog_no,
                    "brand"=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $i->brand_id),
                    "item_cost"=>$i->item_cost,
                    "quantity"=>$i->quantity,
                    "serial"=>$serial
                );
                $serial='';
                /*foreach($this->super_model->select_row_where("serial_number", "si_id", $i->si_id) AS $ser){

                     $data['serial'][] = array(
                        "serial"=>$this->super_model->select_column_where("serial_number", "serial_no", "si_id", $i->si_id)
                     );
                 }  
                */
            }
        } else {
             $data['supplier_item'] = array();
        }

        $data['supplier'] = $this->super_model->select_all_order_by("supplier", "supplier_name", "ASC");
        
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('items/add_item_second',$data);
        $this->load->view('template/footer');
    }

    public function add_serial(){
        $data['id']=$this->uri->segment(3);
        $data['item_id']=$this->uri->segment(4);
        $id=$this->uri->segment(3);
        $data['test'] = $this->super_model->select_row_where("supplier_items", "si_id",$id);
        $this->load->view('template/header');
        $this->load->view('items/add_serial',$data);
    }

    public function insert_serial(){
        $id=$this->input->post('id');
        $serial_no=$this->input->post('serial_no');
        $serial_id=$this->input->post('serial_id');
        $item_id=$this->input->post('item_id');
        $insertdata = array(
            'si_id'=>$id,
            'serial_no'=>$serial_no
        );
        $count =$this->super_model->count_rows_where("serial_number","serial_id",$serial_id);
        if($count!=0){
            echo "<script>alert('$serial_no serial number is already in the system!');window.location = '".base_url()."index.php/items/add_serial/$id';</script>";
        }
        else{
            $this->super_model->insert_into("serial_number", $insertdata);
           
            echo "<script>alert('Successfully Added!');window.close();window.opener.location.href= '".base_url()."index.php/items/add_item_second/$item_id'</script>";
        }
    }

    public function update_brand(){
        $data['siid']=$this->uri->segment(3);
        $siid=$this->uri->segment(3);
        $data['item_id']=$this->uri->segment(4);
        foreach($this->super_model->select_row_where('supplier_items','si_id', $siid) as $sup){
            $brand = $this->super_model->select_column_where('brand', 'brand_name', 'brand_id', $sup->brand_id);
            $data['supplier'][] = array(
                'cat_no'=>$sup->catalog_no,
                'brand'=>$brand
            );
        }
        $this->load->view('template/header');
        $this->load->view('items/update_brand',$data);
    }

    public function edit_brand(){
        if(empty($this->input->post('brand_id'))){
            $maxid=$this->super_model->get_max("brand", "brand_id");
            $brand=$maxid+1;
            $brand_data = array(
                'brand_id' => $brand,
                'brand_name' => $this->input->post('brand['.$a.']')
            );
            $this->super_model->insert_into("brand", $brand_data);
        }else {
            $brand = $this->input->post('brand_id');
        }

        $data = array(
            'catalog_no'=>$this->input->post('catno'),
            'brand_id'=>$brand
        );
        $item_id=$this->input->post('item_id');
        $siid=$this->input->post('siid');
        if($this->super_model->update_where('supplier_items', $data, 'si_id', $siid)){
            echo "<script>alert('Successfully Updated'); 
            window.close();window.opener.location.href= '".base_url()."index.php/items/add_item_second/$item_id';</script>";
        }
    }


    public function insert_supplier_item(){
        $item=$this->input->post('item');
        $supplier=$this->input->post('supplier');
        $catalog=$this->input->post('catalog');
        $brandid=$this->input->post('brandid');
        $brand=$this->input->post('brand');
        $cost=$this->input->post('cost');

        if(empty($brandid)){
           $maxid=$this->super_model->get_max("brand", "brand_id");
           $bid=$maxid+1;

           $brand_data = array(
                'brand_id' => $bid,
                'brand_name' => $brand
           );

           $this->super_model->insert_into("brand", $brand_data);

        } else {
           $bid = $brandid;
        }

        $item_data = array(
            'item_id'=> $item,
            'supplier_id'=>$supplier,
            'catalog_no'=>$catalog,
            'brand_id'=>$bid,
            'item_cost'=>$cost
        );
        if($this->super_model->insert_into("supplier_items", $item_data)){
            echo "success";
        } else {
            echo "error";
        }
       
    }

    public function getCat(){
        $cat = $this->input->post('category');
        echo '<option value="">-Select Sub Category-</option>';
        foreach($this->super_model->select_row_where('item_subcat', 'cat_id', $cat) AS $row){
            echo '<option value="'. $row->subcat_id .'">'. $row->subcat_name .'</option>';
            
        }
      
    }

    public function filter_export(){
        if(!empty($this->input->post('category_exp'))){
            $cat = $this->input->post('category_exp');
        } else {
            $cat='null';
        }

        if(!empty($this->input->post('subcat_exp'))){
            $subcat = $this->input->post('subcat_exp');
        } else {
            $subcat='null';
        }
        
        if(!empty($this->input->post('qtyselect'))){
            $qtyselect = $this->input->post('qtyselect');
        } else {
            $qtyselect='null';
        }

        if(!empty($this->input->post('local'))){
            $local = $this->input->post('local');
        } else {
            $local='null';
        }

        if(!empty($this->input->post('manila'))){
            $manila = $this->input->post('manila');
        } else {
            $manila='null';
        }

        if(!empty($this->input->post('date'))){
            $date = $this->input->post('date');
        } else {
            $date='null';
        }

         ?>
       <script>
        window.location.href ='<?php echo base_url(); ?>index.php/items/export_item/<?php echo $cat; ?>/<?php echo $subcat; ?>/<?php echo $local; ?>/<?php echo $manila; ?>/<?php echo $date; ?>/<?php echo $qtyselect; ?>'</script> <?php
    }
    public function update_item(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['items'] = $this->super_model->select_row_where('items', 'item_id', $id);

        $catid=$this->super_model->select_column_where("items", "category_id", "item_id", $id);
        $data['cat_name'] = $this->super_model->select_column_where("item_categories", "cat_name", "cat_id", $catid);

        $binid=$this->super_model->select_column_where("items", "bin_id", "item_id", $id);
        $data['bin_name'] = $this->super_model->select_column_where("bin", "bin_name", "bin_id", $binid);


        $orig_pn=$this->super_model->select_column_where("items", "original_pn", "item_id", $id);
        //echo "**".$orig_pn;
        $pn_details=explode("_",$orig_pn);
        //echo "count=".count($pn_details);
        if(count($pn_details)<2){
            $prefix=0;
            $series=0;
        } else {
            $prefix=$pn_details[0];
            $series=$pn_details[1];
        }

       //  echo "prefix=".$prefix. ", series=" . $series;
        $row_count = $this->super_model->count_custom_where("pn_series","subcat_prefix='$prefix' AND series = '$series'");
        if($row_count!=0){
            $data['pn_format']=1;
        } else {
            $data['pn_format']=0;
        }


        $data['subcat'] = $this->super_model->select_all_order_by('item_subcat', 'subcat_name', 'ASC');
        $data['group'] = $this->super_model->select_all_order_by('group','group_name','ASC');
        $data['location'] = $this->super_model->select_all_order_by('location','location_name','ASC');
        $data['warehouse'] = $this->super_model->select_all_order_by('warehouse','warehouse_name','ASC');
        $data['unit'] = $this->super_model->select_all_order_by('uom','unit_name','ASC');
        $data['rack'] = $this->super_model->select_all_order_by('rack','rack_name','ASC');
        $this->load->view('items/update_item',$data);
        $this->load->view('template/footer');
    }

    public function edit_item(){
        $data = array(
            'category_id'=>$this->input->post('category'),
            'subcat_id'=>$this->input->post('subcat'),
            'original_pn'=>$this->input->post('pn'),
            'item_name'=>$this->input->post('item_name'),
        );
        $itemid = $this->input->post('item_id');
            if($this->super_model->update_where('items', $data, 'item_id', $itemid)){
            echo "<script>alert('Successfully Updated'); 
                window.location ='".base_url()."index.php/items/item_list';</script>";
        }
    }

    /*public function view_item(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $this->load->model('super_model');
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $data['items'] = $this->super_model->select_row_where('items', 'item_id', $id);
        $this->load->view('items/view_item',$data);
        $this->load->view('template/footer');
    }*/

    public function inventory_balance($itemid){
       /*  $recqty= $this->super_model->select_sum("supplier_items", "quantity", "item_id", $itemid);
         $issueqty= $this->super_model->select_sum("issuance_details","quantity", "item_id",$itemid);*/
        $begbal= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id='$itemid' AND catalog_no = 'begbal'");
         $recqty= $this->super_model->select_sum_join("received_qty","receive_items","receive_head", "item_id='$itemid' AND saved='1'","receive_id");
         //return $recqty;
        $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND saved='1'","issuance_id");
        //return $issueqty;
         $restockqty= $this->super_model->select_sum_join("quantity","restock_details","restock_head", "item_id='$itemid' AND excess = '0' AND saved='1'","rhead_id");
          //return $restockqty;
          $balance=($recqty+$begbal+$restockqty)-$issueqty;
         return $balance;
    }


    public function inventory_balance_date($itemid,$end_date){
       /*  $recqty= $this->super_model->select_sum("supplier_items", "quantity", "item_id", $itemid);
         $issueqty= $this->super_model->select_sum("issuance_details","quantity", "item_id",$itemid);*/
        $begbal= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id='$itemid' AND catalog_no = 'begbal'");
         $recqty= $this->super_model->select_sum_join("received_qty","receive_items","receive_head", "item_id='$itemid' AND saved='1' AND receive_date <='$end_date'","receive_id");
         //return $recqty;
        $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND saved='1' AND issue_date <='$end_date'","issuance_id");
        //return $issueqty;
         $restockqty= $this->super_model->select_sum_join("quantity","restock_details","restock_head", "item_id='$itemid' AND excess = '0' AND saved='1' AND restock_date <='$end_date'","rhead_id");
          //return $restockqty;
          $balance=($recqty+$begbal+$restockqty)-$issueqty;
         return $balance;
    }

    public function crossref_balance($itemid,$supplierid,$brandid,$catalogno){
      /*  $recqty= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no ='$catalogno'");*/

        /*$begbal= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id='$itemid' AND catalog_no = 'begbal'");
         $recqty= $this->super_model->select_sum_join("received_qty","receive_items","receive_head", "item_id='$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no = '$catalogno' AND saved='1'","receive_id");*/

        //$recqty= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id='$itemid' AND catalog_no = '$catalogno' AND supplier_id = '$supplierid' AND brand_id = '$brandid'");

        //return "item_id='$itemid' AND catalog_no = '$catalogno' AND supplier_id = '$supplierid' AND brand_id = '$brandid'";
        // $recqty= $this->super_model->select_sum_join("received_qty","receive_items","receive_head", "item_id='$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no = '$catalogno' AND saved='1'","receive_id");
        $begbal= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id='$itemid' AND catalog_no = 'begbal'");
        $recqty= $this->super_model->select_sum_join("received_qty","receive_items","receive_head", "item_id='$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no = '$catalogno' AND saved='1'","receive_id");
        $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no = '$catalogno' AND saved='1'","issuance_id");

         $restockqty= $this->super_model->select_sum_join("quantity","restock_details","restock_head", "item_id='$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no = '$catalogno' AND excess = '0' AND saved='1'","rhead_id");

         //$balance=($recqty+$begbal+$restockqty)-$issueqty;

        // $balance=($recqty+$begbal+$restockqty)-$issueqty;
         $balance=($recqty+$restockqty)-$issueqty;
        // echo "item_id='$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no = '$catalogno' AND saved='1'";
         
         //return "item_id='$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no = '$catalogno' AND saved='1'". $issueqty;
         //return "(" .$recqty . " + " . $restockqty ." )- ". $issueqty;

         return $balance;
    }


    public function view_item_detail(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $serial='';
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $row=$this->super_model->count_rows("items");
        $row1=$this->super_model->count_rows_where("supplier_items","item_id",$id);
        if($row1!=0){
          
            $data['total_qty']=$this->inventory_balance($id);

            foreach($this->super_model->select_custom_where('supplier_items',"item_id='$id' ORDER BY si_id DESC") AS $sup){
                $count = $this->super_model->count_custom_where("supplier_items","item_id = '$id' AND supplier_id = '$sup->supplier_id' AND catalog_no = '$sup->catalog_no' AND brand_id = '$sup->brand_id'");
               
                if($count!=0){
                        $row=$this->super_model->count_rows("items");
                        unset($daterec);
                       // echo "item_id = ".$sup->item_id." AND supplier_id = ".$sup->supplier_id. "AND catalog_no = ".$sup->catalog_no." AND brand_id = ".$sup->brand_id;
                        $count_ri = $this->super_model->count_custom_where("receive_items","item_id = '$id' AND supplier_id = '$sup->supplier_id' AND catalog_no = '$sup->catalog_no' AND brand_id = '$sup->brand_id'");
                        if($count_ri!=0){
                            foreach($this->super_model->select_custom_where("receive_items","item_id = '$sup->item_id' AND supplier_id = '$sup->supplier_id' AND catalog_no = '$sup->catalog_no' AND brand_id = '$sup->brand_id'") AS $rec){
                                $receivedate=$this->super_model->select_column_where("receive_head", "receive_date", "receive_id", $rec->receive_id);
                                $daterec[]=$receivedate;
                            }
                              $date = max($daterec);
                        } else {
                            $date = "";
                        }
                       // print_r($daterec);
                        if($sup->catalog_no == 'begbal'){
                            $begbal_start= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id='$sup->item_id' AND catalog_no = 'begbal'");
                            $begbal_issue= $this->super_model->select_sum_where("issuance_details", "quantity", "item_id='$sup->item_id' AND catalog_no = 'begbal'");
                             $begbal_restock= $this->super_model->select_sum_where("restock_details", "quantity", "item_id='$sup->item_id' AND catalog_no = 'begbal'");
                            $balance = ($begbal_start+$begbal_restock)-$begbal_issue;
                            //echo "item_id='$sup->itemid' AND catalog_no = 'begbal'";
                        } else {
                        $balance= $this->crossref_balance($id,$sup->supplier_id,$sup->brand_id,$sup->catalog_no);
                        }
                      
                        foreach($this->super_model->select_row_where("serial_number", "si_id", $sup->si_id) AS $ser){

                         $serial.=$ser->serial_no.", ";
                         }  

                        $data['supplier'][] = array( 
                            'item_id'=>$sup->item_id,
                            'supplier_id'=>$sup->supplier_id,
                            'brand_id'=>$sup->brand_id,
                            'catalog_no'=>$sup->catalog_no,
                            'item_cost'=>$sup->item_cost,
                            'quantity'=>$balance,
                            'supplier'=>$this->super_model->select_column_where('supplier', 'supplier_name','supplier_id', $sup->supplier_id),
                            'brand'=>$this->super_model->select_column_where('brand', 'brand_name','brand_id', $sup->brand_id),
                            'date'=>$date,
                            'serial'=>$serial
                        );
                    $serial='';
                } 
            } 
        }
        else{
        	$data['supplier'] = array();
        }
        
        if($row!=0){
            foreach($this->super_model->select_row_where('items', 'item_id', $id) AS $det){
                $nominal=$this->super_model->select_ave("supplier_items", "item_cost", "item_id", $det->item_id);
                $data['details'][] = array(
                    'item_id'=>$det->item_id,
                    'original_pn'=>$det->original_pn,
                    'item_name'=>$det->item_name,
                    'picture1'=>$det->picture1,
                    'picture2'=>$det->picture2,
                    'picture3'=>$det->picture3,
                    'unit'=>$this->super_model->select_column_where('uom', 'unit_name','unit_id', $det->unit_id),
                    'nominal'=>$nominal,
                    'category'=>$this->super_model->select_column_where('item_categories', 'cat_name', 
                    'cat_id', $det->category_id),
                    'subcategory'=>$this->super_model->select_column_where('item_subcat', 'subcat_name', 
                    'subcat_id', $det->subcat_id),
                    'group'=>$this->super_model->select_column_where('group', 'group_name', 
                    'group_id', $det->group_id),
                    'location'=>$this->super_model->select_column_where('location', 'location_name', 
                    'location_id', $det->location_id),
                    'bin'=>$this->super_model->select_column_where('bin', 'bin_name', 
                    'bin_id', $det->bin_id),
                    'warehouse'=>$this->super_model->select_column_where('warehouse', 'warehouse_name', 
                    'warehouse_id', $det->warehouse_id),
                    'rack'=>$this->super_model->select_column_where('rack', 'rack_name','rack_id', $det->rack_id),
                    'barcode'=>$det->barcode,
                    'expiration'=>$det->expiration,
                    'minimum'=>$det->min_qty,
                    'damage'=>$det->damage
                );
            }
        }else{
            $data['details'] = array();
        }
        $data['access']=$this->access;
        $this->load->view('items/view_item_detail',$data);
        $this->load->view('template/footer');
    }

    public function getcategory(){
        $subcat = $this->input->post('subcat');
        $cat_id= $this->super_model->select_column_where('item_subcat', 'cat_id', 'subcat_id', $subcat);

        $subcat_prefix= $this->super_model->select_column_where('item_subcat', 'subcat_prefix', 'subcat_id', $subcat);
        $cat = $this->super_model->select_column_where('item_categories', 'cat_name', 'cat_id', $cat_id);

        $rows=$this->super_model->count_custom_where("pn_series","subcat_prefix = '$subcat_prefix'");

        if($rows==0){
            $pn_no= $subcat_prefix."_1001";
        } else {
            $series = $this->super_model->get_max_where("pn_series", "series","subcat_prefix = '$subcat_prefix'");
            $next=$series+1;
            $pn_no = $subcat_prefix."_".$next;
        }
        
        
        $return = array('catid' => $cat_id, 'cat' => $cat, 'pn' => $pn_no);
        echo json_encode($return);
    }

    public function getsubcat(){  
        $postData = $this->input->post();
        $data = $this->super_model->getsubcat($postData);
        echo json_encode($data); 
    }
    

    public function search(){
        $type=$this->input->post('type');
        //echo "hi";
        if($type=='item'){
            $item_name=$this->input->post('itemname');   
            $this->load->model('item_model');
            return $this->item_model->select_item('items', "item_name = '$item_name'");
            //return 0;
        } else if($type=='bin'){
            $bin_name=$this->input->post('binname');   
            $this->load->model('item_model');
            return $this->item_model->select_bin('bin', "bin_name LIKE '%$bin_name%'");
        } else if($type=='brand'){
            $brand_name=$this->input->post('brandname');   
           // echo $brand_name;
            $this->load->model('item_model');
            return $this->item_model->select_brand('brand', "brand_name LIKE '%$brand_name%'");
        }
        else if($type=='serial'){
            $serial=$this->input->post('serial');   
            $this->load->model('item_model');
            return $this->item_model->select_serial('serial_number', "serial_no LIKE '%$serial%'");
        }
    }

    public function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function insert_item(){
        $itemname=$this->clean($this->input->post('item_name'));
        $error_ext=0;
        $dest= realpath(APPPATH . '../uploads/');
        if(!empty($_FILES['img1']['name'])){
             $img1= basename($_FILES['img1']['name']);
             $img1=explode('.',$img1);
             $ext1=$img1[1];
            
            if($ext1=='php' || ($ext1!='png' && $ext1 != 'jpg' && $ext1!='jpeg')){
                $error_ext++;
            } else {
                 $filename1=$itemname.'1.'.$ext1;
                 move_uploaded_file($_FILES["img1"]['tmp_name'], $dest.'/'.$filename1);
            }

        } else {
            $filename1="";
        }

        if(!empty($_FILES['img2']['name'])){
             $img2= basename($_FILES['img2']['name']);
             $img2=explode('.',$img2);
             $ext2=$img2[1];
             
            if($ext2=='php' || ($ext2!='png' && $ext2 != 'jpg' && $ext2!='jpeg')){
                $error_ext++;
            } else {
                $filename2=$itemname.'2.'.$ext2;
                move_uploaded_file($_FILES["img2"]['tmp_name'], $dest.'/'.$filename2);
            }
        } else {
            $filename2="";
        }

        if(!empty($_FILES['img3']['name'])){
             $img3= basename($_FILES['img3']['name']);
             $img3=explode('.',$img3);
             $ext3=$img3[1];
            
            if($ext3=='php' || ($ext3!='png' && $ext3 != 'jpg' && $ext3!='jpeg')){
                $error_ext++;
            } else {
                $filename3=$itemname.'3.'.$ext3;
                move_uploaded_file($_FILES["img3"]['tmp_name'], $dest.'/'.$filename3);
            }
        } else {
            $filename3="";
        }

        if($error_ext!=0){
            echo "ext";
        } else {
             $binid= $this->input->post('binid');
             if(empty($binid)){
                $bin_name= $this->input->post('bin');

                
                $rows=$this->super_model->count_rows("bin");
                if($rows==0){
                    $bin = 1;
                } else {
                    $max=$this->super_model->get_max("bin", "bin_id");
                    $bin=$max+1;
                }

                $bindata = array(
                    'bin_id' => $bin,
                    'bin_name' => $bin_name
                );

                $this->super_model->insert_into("bin", $bindata);

             } else {
                $bin= $this->input->post('binid');
             }
      
            $row_items=$this->super_model->count_rows("items");
            if($row_items==0){
                $item_id=1;
            } else {
                 $maxid=$this->super_model->get_max("items", "item_id");
                 $item_id=$maxid+1;
            }

            $pnformat=$this->input->post('pnformat');

            if($pnformat==1){
                $pndetails=explode("_", $this->input->post('pn'));
                $subcat_prefix=$pndetails[0];
                $series = $pndetails[1];

                $rows=$this->super_model->count_custom_where("pn_series","subcat_prefix = '$subcat_prefix'");
                if($rows==0){
                    $next= "1001";
                    $pn_no= $subcat_prefix."_1001";
                } else {
                    $series = $this->super_model->get_max_where("pn_series", "series","subcat_prefix = '$subcat_prefix'");
                    $next=$series+1;
                    $pn_no = $subcat_prefix."_".$next;
                }

                $pn_data= array(
                    'subcat_prefix'=>$subcat_prefix,
                    'series'=>$next
                );
                $this->super_model->insert_into("pn_series", $pn_data);
            } else {
                $pn_no = $this->input->post('pn');
            }

              $data = array(
                    'item_id' => $item_id,
                    'category_id' => $this->input->post('cat'),
                    'subcat_id' => $this->input->post('subcat'),
                    'original_pn' => $pn_no,
                    //'original_pn' => $this->input->post('pn'),
                    'item_name' => $this->input->post('item_name'),
                    'unit_id' => $this->input->post('unit'),
                    'group_id' => $this->input->post('group'),
                    'location_id' => $this->input->post('location'),
                    'warehouse_id' => $this->input->post('warehouse'),
                    'rack_id' => $this->input->post('rack'),
                    'barcode' => $this->input->post('barcode'),
                    'expiration' => $this->input->post('expiration'),
                    'damage' => $this->input->post('damage'),
                    'min_qty' => $this->input->post('minimum'),
                    'weight' => $this->input->post('weight'),
                    'bin_id' => $bin,
                    'picture1' => $filename1,
                    'picture2' => $filename2,
                    'picture3' => $filename3
             );

              if($this->super_model->insert_into("items", $data)){
                echo $item_id;
              }
        }
    }

    public function savechanges_item(){
        $itemname=$this->input->post('item_name');
        $item_id=$this->input->post('item_id');
        $error_ext=0;
        $dest= realpath(APPPATH . '../uploads/');
        if(!empty($_FILES['img1']['name'])){
             $img1= basename($_FILES['img1']['name']);
             $img1=explode('.',$img1);
             $ext1=$img1[1];
            
            if($ext1=='php' || ($ext1!='png' && $ext1 != 'jpg' && $ext1!='jpeg')){
                $error_ext++;
            } else {
                 $filename1=$item_id.'1.'.$ext1;
                 move_uploaded_file($_FILES["img1"]['tmp_name'], $dest.'\/'.$filename1);
                 $data_pic1 = array(
                    'picture1'=>$filename1
                 );
                 $this->super_model->update_where("items", $data_pic1, "item_id", $item_id);
            }

        }

        if(!empty($_FILES['img2']['name'])){
             $img2= basename($_FILES['img2']['name']);
             $img2=explode('.',$img2);
             $ext2=$img2[1];
             
            if($ext2=='php' || ($ext2!='png' && $ext2 != 'jpg' && $ext2!='jpeg')){
                $error_ext++;
            } else {
                $filename2=$item_id.'2.'.$ext2;
                move_uploaded_file($_FILES["img2"]['tmp_name'], $dest.'\/'.$filename2);
                 $data_pic2 = array(
                    'picture2'=>$filename2
                 );
                 $this->super_model->update_where("items", $data_pic2, "item_id", $item_id);
            }
        } 

        if(!empty($_FILES['img3']['name'])){
             $img3= basename($_FILES['img3']['name']);
             $img3=explode('.',$img3);
             $ext3=$img3[1];
            
            if($ext3=='php' || ($ext3!='png' && $ext3 != 'jpg' && $ext3!='jpeg')){
                $error_ext++;
            } else {
                $filename3=$item_id.'3.'.$ext3;
                move_uploaded_file($_FILES["img3"]['tmp_name'], $dest.'\/'.$filename3);
                $data_pic3 = array(
                    'picture3'=>$filename3
                 );
                 $this->super_model->update_where("items", $data_pic3, "item_id", $item_id);
            }
        } 
       
        if($error_ext!=0){
            echo "ext";
        } else {
            
             $binid= $this->input->post('binid');
             if(empty($binid)){
                $bin_name= $this->input->post('bin');

                
                $rows=$this->super_model->count_rows("bin");
                if($rows==0){
                    $bin = 1;
                } else {
                    $max=$this->super_model->get_max("bin", "bin_id");
                    $bin=$max+1;
                }

                $bindata = array(
                    'bin_id' => $bin,
                    'bin_name' => $bin_name
                );

                $this->super_model->insert_into("bin", $bindata);

             } else {
                $bin= $this->input->post('binid');
             }

            $orig_pn=$this->super_model->select_column_where("items", "original_pn", "item_id", $item_id);
        /*    $pn_details=explode("_",$this->input->post('pn'));
            if(count($pn_details)<2){
                $prefix=0;
                $series1=0;
            } else {
                $prefix=$pn_details[0];
                $series1=$pn_details[1];
            }

            $row_count = $this->super_model->count_custom_where("pn_series","subcat_prefix='$prefix' AND series = '$series1'");
            if($row_count==1){
                $pnformat=1;
            } else {
                $pnformat=0;
            }
*/
            $pnformat=$this->input->post('pnformat');

            if($pnformat==1){
                $pndetails=explode("_", $this->input->post('pn'));
                $subcat_prefix=$pndetails[0];
                $series = $pndetails[1];

                $rows=$this->super_model->count_custom_where("pn_series","subcat_prefix = '$subcat_prefix'");
                if($rows==0){
                    $next= "1001";
                    $pn_no= $subcat_prefix."_1001";
                } else {
                    $pn_no=$this->input->post('pn');
                   /* $series = $this->super_model->get_max_where("pn_series", "series","subcat_prefix = '$subcat_prefix'");
                    $next=$series+1;
                    $pn_no = $subcat_prefix."_".$next;*/
                }

               /* $pn_data= array(
                    'subcat_prefix'=>$subcat_prefix,
                    'series'=>$next
                );
                $row_count = $this->super_model->count_custom_where("pn_series","subcat_prefix='$subcat_prefix' AND series = '$next'");
                if($row_count==0){
                    $this->super_model->insert_into("pn_series", $pn_data);
                }*/
            }else {
                $pn_no=$this->input->post('pn');
            }


              $data = array(
                    'category_id' => $this->input->post('cat'),
                    'subcat_id' => $this->input->post('subcat'),
                    //'original_pn' => $this->input->post('pn'),
                    'original_pn' => $pn_no,
                    'item_name' => $this->input->post('item_name'),
                    'unit_id' => $this->input->post('unit'),
                    'group_id' => $this->input->post('group'),
                    'location_id' => $this->input->post('location'),
                    'bin_id' => $bin,
                    'warehouse_id' => $this->input->post('warehouse'),
                    'rack_id' => $this->input->post('rack'),
                    'barcode' => $this->input->post('barcode'),
                    'expiration' => $this->input->post('expiration'),
                    'damage' => $this->input->post('damage'),
                    'min_qty' => $this->input->post('minimum'),
                    'weight' => $this->input->post('weight'),
             );
              $act = "Updated item details of item_id ". $item_id;
                $this->activity_log($act);
        
              if($this->super_model->update_where("items", $data, "item_id", $item_id)){
                echo $item_id;
              }
        }
    }

    public function delete_supp_item(){
        $siid=$this->uri->segment(3);
        $id=$this->uri->segment(4);
        if($this->super_model->delete_where("supplier_items", "si_id", $siid)){
             redirect(base_url().'index.php/items/add_item_second/'.$id);
        }
        
        
    }

    public function count_supplier_item(){
        $item=$this->input->post('item');
        $supplier=$this->input->post('supplier');
        $catalog=$this->input->post('catalog');
        $brand=$this->input->post('brand');

        $row_items=$this->super_model->count_custom_where("supplier_items","item_id = '$item' AND supplier_id = '$supplier' AND catalog_no = '$catalog' AND brand_id = '$brand'");
        echo $row_items;
    }

    public function delete_item(){
        $id=$this->uri->segment(3);
        $this->load->model('super_model');
        $act = 'Deleted item id '. $id;
        $this->activity_log($act);
        if($this->super_model->delete_data($id)){
            echo "<script>alert('Succesfully Deleted'); 
                window.location ='".base_url()."index.php/items/item_list'; </script>";
        }
    }

    public function export_item(){
        $cat=$this->uri->segment(3);
        $subcat=$this->uri->segment(4);
        $local=$this->uri->segment(5);
        $mnl=$this->uri->segment(6);
        $date=$this->uri->segment(7); 
        $qtyselect=$this->uri->segment(8);
         $sql="";
        if($cat!='null'){
           $sql.= " category_id = '$cat' AND";
        }

        if($subcat!='null'){
            $sql.= " subcat_id = '$subcat' AND";
        }

        if($date!='null'){
            $sql.= " (receive_date <= '$date' OR restock_date <= '$date') AND";
        }

        if($qtyselect!='null' && $qtyselect==1){
            $sql.= " (ri.received_qty!='0' OR rd.quantity!='0') AND";
        }else{
            $sql.="";
        }

        if($local!='null' || $mnl != 'null'){
            $sql2='(';
            if($local!='null'){
               $sql2.= " local_mnl = '1' OR";
            }

            if($mnl!='null'){
                $sql2.= " local_mnl = '2' OR";
            }
            $query2=substr($sql2,0,-2);
            $query2.=')';
        } else {
            $sql= substr($sql,0,-3);
            $query2='';
        }

/*
        if(!empty($sql)){
             $q=" WHERE " .$sql . " " . $query2;
        } else {
            $q=$sql . " " . $query2;
        }*/

        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="items.xlsx";
        $objPHPExcel = new PHPExcel();
        $gdImage = imagecreatefrompng('assets/default/logo_cenpri.png');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
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
        if($date!='null'){
            $date_rec = $date;
        }else{
            $date_rec = date("Y-m-d");
        }
        $catname=$this->super_model->select_column_where("item_categories", "cat_name", "cat_id", $cat);
        $subcatname=$this->super_model->select_column_where("item_subcat", "subcat_name", "subcat_id", $subcat);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B6', $date_rec);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', $catname);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I8', $subcatname);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', "Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "Main Category");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G8', "Sub-Category");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "CENTRAL NEGROS POWER RELIABILITY, INC.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Purok San Jose, Brgy. Calumangan, Bago City");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Tel. No. 476 - 7382");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "MATERIAL INVENTORY REPORT TO DATE");




        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10', "No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B10', "Local/Manila");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E10', "Item Part No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G10', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L10', "Nominal Cost");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N10', "Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P10', "Price");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R10', "Uom");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T10', "Location");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V10', "Warehouse Location");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X10', "Rack");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z10', "Bin");
        $num=11;
        $x=1;
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );

        //echo "SELECT i.*, ri.local_mnl FROM items i LEFT JOIN receive_items ri ON i.item_id = ri.item_id LEFT JOIN receive_head rh ON ri.receive_id = rh.receive_id " .$q." GROUP BY i.item_id ORDER BY i.original_pn ASC";
        //"SELECT i.*, ri.local_mnl FROM items i LEFT JOIN receive_items ri ON i.item_id = ri.item_id LEFT JOIN receive_head rh ON ri.receive_id = rh.receive_id LEFT JOIN supplier_items si ON si.item_id = i.item_id LEFT JOIN restock_details rd ON rd.item_id = i.item_id " .$q." GROUP BY i.item_id ORDER BY i.original_pn ASC"
        if(!empty($sql)){
             $q=" WHERE " .$sql . " " . $query2;
             $sql_query = "SELECT i.*, ri.local_mnl FROM items i LEFT JOIN receive_items ri ON i.item_id = ri.item_id LEFT JOIN receive_head rh ON ri.receive_id = rh.receive_id LEFT JOIN restock_details rd ON rd.item_id = i.item_id LEFT JOIN restock_head r ON rd.rhead_id = r.rhead_id " .$q." GROUP BY i.item_id ORDER BY i.original_pn ASC";

             $sql_begbal = "SELECT i.* FROM supplier_items si INNER JOIN items i ON i.item_id = si.item_id WHERE si.catalog_no = 'begbal' AND si.item_id NOT IN (SELECT item_id FROM receive_items) AND si.item_id NOT IN (SELECT item_id FROM restock_details)";

             $sql_notransact = "SELECT * FROM items WHERE item_id NOT IN (SELECT item_id FROM receive_items) AND item_id NOT IN (SELECT item_id FROM restock_details) AND item_id NOT IN (SELECT item_id FROM supplier_items)";

             $sql_notransact_wsi = "SELECT * FROM items i INNER JOIN supplier_items si ON i.item_id = si.item_id WHERE i.item_id NOT IN (SELECT item_id FROM receive_items) AND i.item_id NOT IN (SELECT item_id FROM restock_details) AND si.catalog_no !='begbal' GROUP BY si.item_id";
        } else {
           // $q=$sql . " " . $query2;
             $sql_query = "SELECT * from items";
        }

        foreach($this->super_model->custom_query($sql_query) AS $items){

            $unit =$this->super_model->select_column_where("uom","unit_name", "unit_id", $items->unit_id);
            $rack =$this->super_model->select_column_where("rack","rack_name", "rack_id", $items->rack_id);
            $group =$this->super_model->select_column_where("group","group_name", "group_id", $items->group_id);
            $wh =$this->super_model->select_column_where("warehouse","warehouse_name", "warehouse_id", $items->warehouse_id);
            $location =$this->super_model->select_column_where("location","location_name", "location_id", $items->location_id);
            $bin =$this->super_model->select_column_where("bin","bin_name", "bin_id", $items->bin_id);
            $nominal=$this->super_model->select_ave("supplier_items", "item_cost", "item_id", $items->item_id);
            $unit_price = $this->super_model->select_column_custom_where('receive_items', 'item_cost', "item_id='$items->item_id' ORDER BY receive_id DESC");
             $local_mnl = $this->super_model->select_column_custom_where('receive_items', 'local_mnl', "item_id='$items->item_id'");
            if($local_mnl=='1'){
                $sup = 'Local';
            } else if($local_mnl=='2'){
                 $sup = 'Manila';
            } else {
                $sup='';
            }
            $totalqty=$this->inventory_balance_date($items->item_id,$date);
            if($totalqty!=0 && $qtyselect==1){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $sup);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $items->original_pn);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $items->item_name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$num, $nominal);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$num, $totalqty);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $unit_price);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $unit);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$num, $location);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$num, $wh);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$num, $rack);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$num, $bin);
            
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":Z".$num,'admin');
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":D".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('E'.$num.":F".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('G'.$num.":K".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('L'.$num.":M".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$num.":O".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$num.":Q".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":S".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('T'.$num.":U".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('V'.$num.":W".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('X'.$num.":Y".$num);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":Z".$num)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":Q".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":P".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                //$objPHPExcel->getActiveSheet()->getStyle('X'.$num.":Y".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $num++;
                $x++;
            }else if($qtyselect==0){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $sup);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $items->original_pn);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $items->item_name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$num, $nominal);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$num, $totalqty);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $unit_price);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $unit);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$num, $location);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$num, $wh);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$num, $rack);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$num, $bin);
            
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":Z".$num,'admin');
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":D".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('E'.$num.":F".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('G'.$num.":K".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('L'.$num.":M".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$num.":O".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$num.":Q".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":S".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('T'.$num.":U".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('V'.$num.":W".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('X'.$num.":Y".$num);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":Z".$num)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":Q".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":P".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                //$objPHPExcel->getActiveSheet()->getStyle('X'.$num.":Y".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $num++;
                $x++;
            }
        }
         foreach($this->super_model->custom_query($sql_begbal) AS $begbal){

            $unit =$this->super_model->select_column_where("uom","unit_name", "unit_id", $begbal->unit_id);
            $rack =$this->super_model->select_column_where("rack","rack_name", "rack_id", $begbal->rack_id);
            $group =$this->super_model->select_column_where("group","group_name", "group_id", $begbal->group_id);
            $wh =$this->super_model->select_column_where("warehouse","warehouse_name", "warehouse_id", $begbal->warehouse_id);
            $location =$this->super_model->select_column_where("location","location_name", "location_id", $begbal->location_id);
            $bin =$this->super_model->select_column_where("bin","bin_name", "bin_id", $begbal->bin_id);
            $nominal=$this->super_model->select_ave("supplier_items", "item_cost", "item_id", $begbal->item_id);
            $unit_price = 0;
             $local_mnl = 1;
            if($local_mnl=='1'){
                $sup = 'Local';
            } else if($local_mnl=='2'){
                 $sup = 'Manila';
            } else {
                $sup='';
            }
            $totalqty=$this->inventory_balance_date($begbal->item_id,$date);
         
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $sup);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $begbal->original_pn);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $begbal->item_name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$num, $nominal);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$num, $totalqty);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $unit_price);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $unit);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$num, $location);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$num, $wh);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$num, $rack);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$num, $bin);
            
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":Z".$num,'admin');
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":D".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('E'.$num.":F".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('G'.$num.":K".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('L'.$num.":M".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$num.":O".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$num.":Q".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":S".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('T'.$num.":U".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('V'.$num.":W".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('X'.$num.":Y".$num);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":Z".$num)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":Q".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":P".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                //$objPHPExcel->getActiveSheet()->getStyle('X'.$num.":Y".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $num++;
                $x++;
         }

          foreach($this->super_model->custom_query($sql_notransact) AS $not){

            $unit =$this->super_model->select_column_where("uom","unit_name", "unit_id", $not->unit_id);
            $rack =$this->super_model->select_column_where("rack","rack_name", "rack_id", $not->rack_id);
            $group =$this->super_model->select_column_where("group","group_name", "group_id", $not->group_id);
            $wh =$this->super_model->select_column_where("warehouse","warehouse_name", "warehouse_id", $not->warehouse_id);
            $location =$this->super_model->select_column_where("location","location_name", "location_id", $not->location_id);
            $bin =$this->super_model->select_column_where("bin","bin_name", "bin_id", $not->bin_id);
            $nominal=$this->super_model->select_ave("supplier_items", "item_cost", "item_id", $not->item_id);
            $unit_price = 0;
             $local_mnl = 1;
            if($local_mnl=='1'){
                $sup = 'Local';
            } else if($local_mnl=='2'){
                 $sup = 'Manila';
            } else {
                $sup='';
            }
            $totalqty=$this->inventory_balance_date($not->item_id,$date);
         
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $sup);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $not->original_pn);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $not->item_name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$num, $nominal);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$num, $totalqty);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $unit_price);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $unit);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$num, $location);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$num, $wh);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$num, $rack);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$num, $bin);
            
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":Z".$num,'admin');
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":D".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('E'.$num.":F".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('G'.$num.":K".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('L'.$num.":M".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$num.":O".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$num.":Q".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":S".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('T'.$num.":U".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('V'.$num.":W".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('X'.$num.":Y".$num);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":Z".$num)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":Q".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":P".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                //$objPHPExcel->getActiveSheet()->getStyle('X'.$num.":Y".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $num++;
                $x++;
         }

        foreach($this->super_model->custom_query($sql_notransact_wsi) AS $si){

            $unit =$this->super_model->select_column_where("uom","unit_name", "unit_id", $si->unit_id);
            $rack =$this->super_model->select_column_where("rack","rack_name", "rack_id", $si->rack_id);
            $group =$this->super_model->select_column_where("group","group_name", "group_id", $si->group_id);
            $wh =$this->super_model->select_column_where("warehouse","warehouse_name", "warehouse_id", $si->warehouse_id);
            $location =$this->super_model->select_column_where("location","location_name", "location_id", $si->location_id);
            $bin =$this->super_model->select_column_where("bin","bin_name", "bin_id", $si->bin_id);
            $nominal=$this->super_model->select_ave("supplier_items", "item_cost", "item_id", $si->item_id);
            $unit_price = 0;
             $local_mnl = 1;
            if($local_mnl=='1'){
                $sup = 'Local';
            } else if($local_mnl=='2'){
                 $sup = 'Manila';
            } else {
                $sup='';
            }
            $totalqty=$this->inventory_balance_date($si->item_id,$date);
         
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $sup);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $si->original_pn);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $si->item_name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$num, $nominal);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$num, $totalqty);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $unit_price);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $unit);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$num, $location);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$num, $wh);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$num, $rack);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$num, $bin);
            
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":Z".$num,'admin');
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":D".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('E'.$num.":F".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('G'.$num.":K".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('L'.$num.":M".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$num.":O".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$num.":Q".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":S".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('T'.$num.":U".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('V'.$num.":W".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('X'.$num.":Y".$num);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":Z".$num)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":Q".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":P".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                //$objPHPExcel->getActiveSheet()->getStyle('X'.$num.":Y".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $num++;
                $x++;
         }
        $a = $num+2;
        $b = $num+5;
        $c = $num+4;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "Prepared By: ");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$b, "Warehouse Personnel ");
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$a, "Checked By: ");
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$b, "Warehouse Supervisor ");
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$a, "Approved By: ");
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$b, "Plant Director/Plant Manager ");
        $objPHPExcel->getActiveSheet()->protectCells('A'.$a.":Y".$a,'admin');
        $objPHPExcel->getActiveSheet()->protectCells('A'.$c.":Y".$c,'admin');
        $objPHPExcel->getActiveSheet()->mergeCells('B10:D10');
        $objPHPExcel->getActiveSheet()->mergeCells('E10:F10');
        $objPHPExcel->getActiveSheet()->mergeCells('G10:K10');
        $objPHPExcel->getActiveSheet()->mergeCells('L10:M10');
        $objPHPExcel->getActiveSheet()->mergeCells('N10:O10');
        $objPHPExcel->getActiveSheet()->mergeCells('P10:Q10');
        $objPHPExcel->getActiveSheet()->mergeCells('R10:S10');
        $objPHPExcel->getActiveSheet()->mergeCells('T10:U10');
        $objPHPExcel->getActiveSheet()->mergeCells('V10:W10');
        $objPHPExcel->getActiveSheet()->mergeCells('X10:Y10');
        $objPHPExcel->getActiveSheet()->getStyle('A10:Z10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A10:Z10')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:Z2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:Z3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A4:Z4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:Z2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:Z3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A4:Z4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->getStyle('A4:Z4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('B6:D6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C8:E8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('I8:K8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('Z1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('Z2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('Z3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('Z4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("N2")->getFont()->setBold(true)->setName('Arial Black');
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="items.xlsx"');
        readfile($exportfilename);
        /*echo "<script>window.location = 'item_list';</script>";*/
    }

    public function search_item(){
        $category=$this->input->post('category');
        $subcat=$this->input->post('subcat');
        $item_desc=$this->input->post('item_desc');
        $pn=$this->input->post('pn');
        $group=$this->input->post('group');
        $section=$this->input->post('section');
        $bin=$this->input->post('bin');
        $warehouse=$this->input->post('warehouse');
        $rack=$this->input->post('rack');
        $barcode=$this->input->post('barcode');
        $expiration=$this->input->post('expiration');
        $data['category'] = $this->super_model->select_all('item_categories');
        $data['subcat'] = $this->super_model->select_all('item_subcat');
        $data['group'] = $this->super_model->select_all('group');
        $data['location'] = $this->super_model->select_all('location');
        $data['warehouse'] = $this->super_model->select_all('warehouse');
        $data['bin'] = $this->super_model->select_all('bin');
        $data['rack'] = $this->super_model->select_all('rack');

        $sql="";
        $filter ="";
        if(!empty($category)){
            $sql.= " items.category_id = '$category' AND";
            $filter.="Category = " . $this->super_model->select_column_where('item_categories', 'cat_name', 
                        'cat_id', $category). ", ";
        }

        if(!empty($subcat)){
            $sql.= " items.subcat_id = '$subcat' AND";
            $filter.="Sub Category = " . $this->super_model->select_column_where('item_subcat', 'subcat_name', 
                        'subcat_id', $subcat) . ", ";
        }

        if(!empty($item_desc)){
            $sql.= " items.item_name LIKE '%$item_desc%' AND";
            $filter.="Item Desc = " .$item_desc. ", ";
        }

        if(!empty($pn)){
            $sql.= " items.original_pn LIKE '%$pn%' OR supplier_items.catalog_no LIKE '%$pn%' AND";
            $filter.="PN No. = " .$pn. ", ";
        }

        if(!empty($group)){
            $sql.= " items.group_id = '$group' AND";
            $filter.="Group = " . $this->super_model->select_column_where('group', 'group_name', 
                        'group_id', $group). ", ";
        }

        if(!empty($section)){
            $sql.= " items.location_id = '$section' AND";
            $filter.="Section = " . $this->super_model->select_column_where('location', 'location_name', 
                        'location_id', $section). ", ";
        }

        if(!empty($bin)){
            $sql.= " items.bin_id = '$bin' AND";
            $filter.="Bin = " . $this->super_model->select_column_where('bin', 'bin_name', 'bin_id', $bin). ", ";
        }

        if(!empty($warehouse)){
            $sql.= " items.warehouse_id = '$warehouse' AND";
            $filter.="Warehouse = " . $this->super_model->select_column_where('warehouse', 'warehouse_name', 
                        'warehouse_id', $warehouse). ", ";
        }

        if(!empty($rack)){
            $sql.= " items.rack_id = '$rack' AND";
            $filter.="Rack = " . $this->super_model->select_column_where('rack', 'rack_name', 'rack_id', $rack) . ", ";
        }

        if(!empty($barcode)){
            $sql.= " items.barcode = '$barcode' AND";
            $filter.="Barcode = " .  $barcode . ", ";
        }

        if(!empty($expiration)){
            $sql.= " items.expiration = '$expiration' AND";
            $filter.="Expiration = " .  $expiration . ", ";
        }

        $query=substr($sql,0,-3);
        $filter=substr($filter,0,-2);
        $data['access']=$this->access;
        $count=$this->super_model->count_join_where("items","supplier_items", $query, 'item_id');
       
        $data['filter']=$filter;
        if($count!=0){
            $data['count_query'] = 1;
            foreach($this->super_model->select_join_where("items", "supplier_items", $query, "item_id") AS $itm){
                //$totalqty=$this->super_model->select_sum("supplier_items", "quantity", "item_id", $itm->item_id);
                foreach($this->super_model->select_custom_where("items", "item_id = '$itm->item_id'") AS $itema){
                    $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
                }
                $totalqty=$this->inventory_balance($itm->item_id);
                 $data['items'][] = array(
                    'item_id'=>$itm->item_id,
                    'original_pn'=>$itm->original_pn,
                    'item_name'=>$itm->item_name,
                    'category'=>$this->super_model->select_column_where('item_categories', 'cat_name', 
                    'cat_id', $itm->category_id),
                    'subcategory'=>$this->super_model->select_column_where('item_subcat', 'subcat_name', 
                    'subcat_id', $itm->subcat_id),
                    'quantity'=>$totalqty,
                    'damage'=>$itm->damage,
                    'uom'=>$unit,
                    'location'=>$this->super_model->select_column_where('location', 'location_name', 
                    'location_id', $itm->location_id),
                    'bin'=>$this->super_model->select_column_where('bin', 'bin_name', 'bin_id', $itm->bin_id),
                    'rack'=>$this->super_model->select_column_where('rack', 'rack_name', 'rack_id', $itm->rack_id),
                    'minimum'=>$itm->min_qty,
                );
            }
        } else {
            $data['count_query'] = 0;
             $data['items']=array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('items/item_list',$data);
        $this->load->view('template/footer');
    }

    public function reportItem(){

        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('items/report_items');
        $this->load->view('template/footer');
    }

    public function deleteImage(){
         $dest= realpath(APPPATH . '../uploads/');
         $id=$this->input->post('id');
         $pic=$this->input->post('pic');
            
         if($pic=='picture1'){
          
            $pic=$dest."/".$this->super_model->select_column_where('items', 'picture1', 'item_id', $id);
             if(unlink($pic)){
                $data = array(
                    'picture1'=>""
                );
                if($this->super_model->update_where("items", $data, "item_id", $id)){
                    echo $id;
                }
             }
         } else if($pic=='picture2'){
             $pic=$dest.$this->super_model->select_column_where('items', 'picture2', 'item_id', $id);
             if(unlink($pic)){
                $data = array(
                    'picture2'=>""
                );
                 if($this->super_model->update_where("items", $data, "item_id", $id)){
                    echo $id;
                }
             }
         } else if($pic=='picture3'){
            $pic=$dest.$this->super_model->select_column_where('items', 'picture3', 'item_id', $id);
             if(unlink($pic)){
                $data = array(
                    'picture3'=>""
                );
                 if($this->super_model->update_where("items", $data, "item_id", $id)){
                    echo $id;
                }
             }
         }



    }
}




?>

