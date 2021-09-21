<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');

class Damage extends CI_Controller {

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

    /*public function activity_log($activity){
        $timestamp = date('Y-m-d H:i:s');
        $data = array(
            "activity_time"=>$timestamp,
            "activity_name"=>$activity,
            "user_id"=>$_SESSION['user_id']
        );

        $this->super_model->insert_into("activity_logs", $data);
    }*/


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

    public function damage_item_export(){
        $this->load->view('template/header');
        $data['subcat'] = $this->super_model->select_all_order_by('item_subcat', 'subcat_name', 'ASC');
        $data['category'] = $this->super_model->select_all_order_by('item_categories', 'cat_name', 'ASC');
        $this->load->view('damage/damage_list',$data);
    }

    public function damage_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        
        $data['category'] = $this->super_model->select_all('item_categories');
        $data['subcat'] = $this->super_model->select_all('item_subcat');
        $data['group'] = $this->super_model->select_all('group');
        $data['location'] = $this->super_model->select_all('location');
        $data['warehouse'] = $this->super_model->select_all('warehouse');
        $data['bin'] = $this->super_model->select_all('bin');
        $data['rack'] = $this->super_model->select_all('rack');
        $row=$this->super_model->count_rows("damage_items");
        if($row!=0){
            foreach($this->super_model->select_all('damage_items') AS $itm){
                $bin = $this->super_model->select_column_where('bin', 'bin_name', 'bin_id', $itm->bin_id);
                $rack = $this->super_model->select_column_where('rack', 'rack_name', 'rack_id', $itm->rack_id);
                $warehouse = $this->super_model->select_column_where('warehouse', 'warehouse_name', 
                    'warehouse_id', $itm->warehouse_id);
                $location = $this->super_model->select_column_where('location', 'location_name', 
                    'location_id', $itm->location_id);
                $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itm->unit_id);

                $data['items'][] = array(
                    'damage_id'=>$itm->damage_id,
                    'original_pn'=>$itm->original_pn,
                    'item_description'=>$itm->item_description,
                    'category'=>$this->super_model->select_column_where('item_categories', 'cat_name', 
                    'cat_id', $itm->category_id),
                    'subcategory'=>$this->super_model->select_column_where('item_subcat', 'subcat_name', 
                    'subcat_id', $itm->subcat_id),
                    'bin'=>$bin,
                    'rack'=>$rack,
                    'warehouse'=>$warehouse,
                    'location'=>$location,                
                    'quantity'=>$itm->quantity,
                    //'damage'=>$itm->damage,
                    'item_cost'=>$itm->item_cost,
                    'uom'=>$unit
                );
            }
        }else{
            $data['items'] = array();
        }
        $data['access']=$this->access;
        $this->load->view('damage/damage_list',$data);
        $this->load->view('template/footer');
    }

     public function add_dmg_item(){
        $id=$this->uri->segment(3);
        $data['id'] = $id;
        $data['subcat'] = $this->super_model->select_all_order_by('item_subcat', 'subcat_name', 'ASC');
        $data['group'] = $this->super_model->select_all_order_by('group','group_name','ASC');
        $data['location'] = $this->super_model->select_all_order_by('location','location_name','ASC');
        $data['warehouse'] = $this->super_model->select_all_order_by('warehouse','warehouse_name','ASC');
        $data['unit'] = $this->super_model->select_all_order_by('uom','unit_name','ASC');
        $data['rack'] = $this->super_model->select_all_order_by('rack','rack_name','ASC');
        $data['supplier'] = $this->super_model->select_all_order_by('supplier','supplier_name','ASC');
        $data['serial_number'] = $this->super_model->select_all_order_by('serial_number','serial_no','ASC');
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('damage/add_dmg_item',$data);
        $this->load->view('template/footer');
    }


    public function getCat(){
        $cat = $this->input->post('category');
        echo '<option value="">-Select Sub Category-</option>';
        foreach($this->super_model->select_row_where('item_subcat', 'cat_id', $cat) AS $row){
            echo '<option value="'. $row->subcat_id .'">'. $row->subcat_name .'</option>';
            
        }
      
    }

    public function update_dmg_item(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['damage_items'] = $this->super_model->select_row_where('damage_items', 'damage_id', $id);

        $catid=$this->super_model->select_column_where("damage_items", "category_id", "damage_id", $id);
        $data['cat_name'] = $this->super_model->select_column_where("item_categories", "cat_name", "cat_id", $catid);

        $binid=$this->super_model->select_column_where("damage_items", "bin_id", "damage_id", $id);
        $data['bin_name'] = $this->super_model->select_column_where("bin", "bin_name", "bin_id", $binid);

        $brandid=$this->super_model->select_column_where("damage_items", "brand_id", "damage_id", $id);
        $data['brand_name'] = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $brandid);

        $serialid=$this->super_model->select_column_where("damage_items", "serial_id", "damage_id", $id);
        $data['serial_no'] = $this->super_model->select_column_where("serial_number", "serial_no", "serial_id", $serialid);


        $orig_pn=$this->super_model->select_column_where("damage_items", "original_pn", "damage_id", $id);
        $pn_details=explode("_",$orig_pn);
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
        $data['supplier'] = $this->super_model->select_all_order_by('supplier','supplier_name','ASC');
        $data['serial_number'] = $this->super_model->select_all_order_by('serial_number','serial_no','ASC');
        $this->load->view('damage/update_dmg_item',$data);
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


    public function view_dmg_item(){
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $row=$this->super_model->count_rows("damage_items");
        
        
        if($row!=0){
            foreach($this->super_model->select_row_where('damage_items', 'damage_id', $id) AS $det){
                $data['details'][] = array(
                    'damage_id'=>$det->damage_id,
                    'original_pn'=>$det->original_pn,
                    'item_description'=>$det->item_description,
                    'picture1'=>$det->picture1,
                    'picture2'=>$det->picture2,
                    'picture3'=>$det->picture3,
                    'unit'=>$this->super_model->select_column_where('uom', 'unit_name','unit_id', $det->unit_id),
                    'category'=>$this->super_model->select_column_where('item_categories', 'cat_name','cat_id', $det->category_id),
                    'subcategory'=>$this->super_model->select_column_where('item_subcat', 'subcat_name','subcat_id', $det->subcat_id),
                    'group'=>$this->super_model->select_column_where('group', 'group_name','group_id', $det->group_id),
                    'location'=>$this->super_model->select_column_where('location', 'location_name', 'location_id', $det->location_id),
                    'bin'=>$this->super_model->select_column_where('bin', 'bin_name', 'bin_id', $det->bin_id),
                    'warehouse'=>$this->super_model->select_column_where('warehouse', 'warehouse_name', 'warehouse_id', $det->warehouse_id),
                    'rack'=>$this->super_model->select_column_where('rack', 'rack_name','rack_id', $det->rack_id),
                    'serial'=>$this->super_model->select_column_where('serial_number', 'serial_no','serial_id', $det->serial_id),
                    'brand'=>$this->super_model->select_column_where('brand', 'brand_name','brand_id', $det->brand_id),
                    'supplier'=>$this->super_model->select_column_where('supplier', 'supplier_name','supplier_id', $det->supplier_id),
                    'barcode'=>$det->barcode,
                    'quantity'=>$det->quantity,
                    'item_cost'=>$det->item_cost,
                    'catalog'=>$det->catalog_no,
                    'weight'=>$det->weight,
                    'local_mnl'=>$det->local_mnl,
                    'remarks'=>$det->remarks,
                    //'damage'=>$det->damage
                );
            }
        }else{
            $data['details'] = array();
        }
        $this->load->view('damage/view_dmg_item',$data);
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
        } else if($type=='serial'){
            $serial=$this->input->post('serial');   
            $this->load->model('item_model');
            return $this->item_model->select_serial('serial_number', "serial_no LIKE '%$serial%'");
        }
    }

    public function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function insert_damage_item(){
        $timestamp = date('Y-m-d H:i:s');
        $itemdesc=$this->clean($this->input->post('item_description'));
        $error_ext=0;
        $dest= realpath(APPPATH . '../uploads/');
        if(!empty($_FILES['img1']['name'])){
             $img1= basename($_FILES['img1']['name']);
             $img1=explode('.',$img1);
             $ext1=$img1[1];
            
            if($ext1=='php' || ($ext1!='png' && $ext1 != 'jpg' && $ext1!='jpeg')){
                $error_ext++;
            } else {
                 $filename1=$itemdesc.'1.'.$ext1;
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
                $filename2=$itemdesc.'2.'.$ext2;
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
                $filename3=$itemdesc.'3.'.$ext3;
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
      
            $row_damage=$this->super_model->count_rows("damage_items");
            if($row_damage==0){
                $damage_id=1;
            } else {
                 $maxid=$this->super_model->get_max("damage_items", "damage_id");
                 $damage_id=$maxid+1;
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

            $brandid=$this->input->post('brandid');
            $brand=$this->input->post('brand');
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

                $serial=$this->input->post('serial');
                $serialid=$this->input->post('serial_id');

                if(empty($serialid)){
                $maxid=$this->super_model->get_max("serial_number", "serial_id");
                $sid=$maxid+1;

                $serial_data = array(
                    'serial_id' => $sid,
                    'serial_no' => $serial
                );

                $this->super_model->insert_into("serial_number", $serial_data);

         } else {
           $sid = $serialid;
                }

              $data = array(
                    'damage_id' => $damage_id,
                    'category_id' => $this->input->post('cat'),
                    'subcat_id' => $this->input->post('subcat'),
                    'original_pn' => $pn_no,
                    //'original_pn' => $this->input->post('pn'),
                    'item_description' => $this->input->post('item_description'),
                    'unit_id' => $this->input->post('unit'),
                    'group_id' => $this->input->post('group'),
                    'location_id' => $this->input->post('location'),
                    'warehouse_id' => $this->input->post('warehouse'),
                    'rack_id' => $this->input->post('rack'),
                    'barcode' => $this->input->post('barcode'),
                    //'expiration' => $this->input->post('expiration'),
                    //'damage' => $this->input->post('damage'),
                    'quantity' => $this->input->post('quantity'),
                    'weight' => $this->input->post('weight'),
                    'supplier_id' => $this->input->post('supplier'),
                    'local_mnl' => $this->input->post('local_mnl'),
                    'item_cost' => $this->input->post('item_cost'),
                    'catalog_no' => $this->input->post('catalog'),
                    'remarks' => $this->input->post('remarks'),
                    'bin_id' => $bin,
                    'brand_id' => $bid,
                    'serial_id' => $sid,
                    'picture1' => $filename1,
                    'picture2' => $filename2,
                    'picture3' => $filename3,
                    'date_added'=>$timestamp,
                    'added_by'=>$_SESSION['user_id']
             );


              if($this->super_model->insert_into("damage_items", $data)){
                echo $damage_id;
              }
        }
    }

    public function savechanges_item(){
        $itemdesc=$this->clean($this->input->post('item_description'));
        $damage_id=$this->input->post('damage_id');
        $error_ext=0;
        $dest= realpath(APPPATH . '../uploads/');
        if(!empty($_FILES['img1']['name'])){
             $img1= basename($_FILES['img1']['name']);
             $img1=explode('.',$img1);
             $ext1=$img1[1];
            
            if($ext1=='php' || ($ext1!='png' && $ext1 != 'jpg' && $ext1!='jpeg')){
                $error_ext++;
            } else {
                 $filename1=$damage_id.'1.'.$ext1;
                 move_uploaded_file($_FILES["img1"]['tmp_name'], $dest.'\/'.$filename1);
                 $data_pic1 = array(
                    'picture1'=>$filename1
                 );
                 $this->super_model->update_where("damage_items", $data_pic1, "damage_id", $damage_id);
            }

        }

        if(!empty($_FILES['img2']['name'])){
             $img2= basename($_FILES['img2']['name']);
             $img2=explode('.',$img2);
             $ext2=$img2[1];
             
            if($ext2=='php' || ($ext2!='png' && $ext2 != 'jpg' && $ext2!='jpeg')){
                $error_ext++;
            } else {
                $filename2=$damage_id.'2.'.$ext2;
                move_uploaded_file($_FILES["img2"]['tmp_name'], $dest.'\/'.$filename2);
                 $data_pic2 = array(
                    'picture2'=>$filename2
                 );
                 $this->super_model->update_where("damage_items", $data_pic2, "damage_id", $damage_id);
            }
        } 

        if(!empty($_FILES['img3']['name'])){
             $img3= basename($_FILES['img3']['name']);
             $img3=explode('.',$img3);
             $ext3=$img3[1];
            
            if($ext3=='php' || ($ext3!='png' && $ext3 != 'jpg' && $ext3!='jpeg')){
                $error_ext++;
            } else {
                $filename3=$damage_id.'3.'.$ext3;
                move_uploaded_file($_FILES["img3"]['tmp_name'], $dest.'\/'.$filename3);
                $data_pic3 = array(
                    'picture3'=>$filename3
                 );
                 $this->super_model->update_where("damage_items", $data_pic3, "damage_id", $damage_id);
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
            
            $orig_pn=$this->super_model->select_column_where("damage_items", "original_pn", "damage_id", $damage_id);

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
                }

            }else {
                $pn_no=$this->input->post('pn');
            }

            $brandid=$this->input->post('brandid');
            $brand=$this->input->post('brand');
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

                $serial=$this->input->post('serial');
                $serialid=$this->input->post('serial_id');

                if(empty($serialid)){
                $maxid=$this->super_model->get_max("serial_number", "serial_id");
                $sid=$maxid+1;

                $serial_data = array(
                    'serial_id' => $sid,
                    'serial_no' => $serial
                );

                $this->super_model->insert_into("serial_number", $serial_data);

         } else {
           $sid = $serialid;
                }

              $data = array(
                    'category_id' => $this->input->post('cat'),
                    'subcat_id' => $this->input->post('subcat'),
                    'original_pn' => $pn_no,
                    //'original_pn' => $this->input->post('pn'),
                    'item_description' => $this->input->post('item_description'),
                    'unit_id' => $this->input->post('unit'),
                    'group_id' => $this->input->post('group'),
                    'location_id' => $this->input->post('location'),
                    'warehouse_id' => $this->input->post('warehouse'),
                    'rack_id' => $this->input->post('rack'),
                    'barcode' => $this->input->post('barcode'),
                    //'expiration' => $this->input->post('expiration'),
                    //'damage' => $this->input->post('damage'),
                    'quantity' => $this->input->post('quantity'),
                    'weight' => $this->input->post('weight'),
                    'supplier_id' => $this->input->post('supplier'),
                    'local_mnl' => $this->input->post('local_mnl'),
                    'item_cost' => $this->input->post('item_cost'),
                    'catalog_no' => $this->input->post('catalog'),
                    'remarks' => $this->input->post('remarks'),
                    'bin_id' => $bin,
                    'brand_id' => $bid,
                    'serial_id' => $sid,
             );
        
              if($this->super_model->update_where("damage_items", $data, "damage_id", $damage_id)){
                echo $damage_id;
              }
        }
    }

    public function delete_damage_item(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('damage_items', 'damage_id', $id)){
            echo "<script>alert('Damage Item Succesfully Deleted'); 
                window.location ='".base_url()."index.php/damage/damage_list'; </script>";
        }
    }

    public function count_damage_item(){
        $item=$this->input->post('item');
        $supplier=$this->input->post('supplier');
        $catalog=$this->input->post('catalog');
        $brand=$this->input->post('brand');

        $row_items=$this->super_model->count_custom_where("damage_items","item_id = '$item' AND supplier_id = '$supplier' AND catalog_no = '$catalog' AND brand_id = '$brand'");
        echo $row_items;
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
        window.location.href ='<?php echo base_url(); ?>index.php/damage/export_damage_item/<?php echo $cat; ?>/<?php echo $subcat; ?>/<?php echo $local; ?>/<?php echo $manila; ?>/<?php echo $date; ?>'</script> <?php
    }

    public function export_damage_item(){
        $cat=$this->uri->segment(3);
        $subcat=$this->uri->segment(4);
        $local=$this->uri->segment(5);
        $mnl=$this->uri->segment(6);
        $date=$this->uri->segment(7); 
         $sql="";
        if($cat!='null'){
           $sql.= " category_id = '$cat' AND";
        }

        if($subcat!='null'){
            $sql.= " subcat_id = '$subcat' AND";
        }

        if($date!='null'){
            $sql.= " date_added LIKE '%$date%' AND";
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

        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="DamageItems.xlsx";
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
            $date_needed = $date;
        }else{
            $date_needed = date("Y-m-d");
        }
        $catname=$this->super_model->select_column_where("item_categories", "cat_name", "cat_id", $cat);
        $subcatname=$this->super_model->select_column_where("item_subcat", "subcat_name", "subcat_id", $subcat);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B6', $date_needed);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', $catname);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I8', $subcatname);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', "Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "Main Category");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G8', "Sub-Category");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "CENTRAL NEGROS POWER RELIABILITY, INC.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Purok San Jose, Brgy. Calumangan, Bago City");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Tel. No. 476 - 7382");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "DAMAGE INVENTORY REPORT TO DATE");




        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10', "No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B10', "Local/Manila");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E10', "Item Part No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G10', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L10', "Quantity");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N10', "Price");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P10', "Weight");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R10', "Uom");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T10', "Location");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V10', "Warehouse Location");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X10', "Rack");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z10', "Bin");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA10', "Supplier");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB10', "Date Added");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC10', "Remarks");
        $num=11;
        $x=1;
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        if(!empty($sql) || !empty($query2)){
             $q=" WHERE " .$sql . " " . $query2;
             $sql_query = "SELECT * FROM damage_items " .$q." GROUP BY damage_id ORDER BY original_pn ASC";
        } else {
             $sql_query = "SELECT * from damage_items";
        }

        //echo $sql_query;

        foreach($this->super_model->custom_query($sql_query) AS $items){

        //foreach($this->super_model->custom_query("SELECT * FROM damage_items ".$query2." ORDER BY date_added ASC") AS $items){

            $unit =$this->super_model->select_column_where("uom","unit_name", "unit_id", $items->unit_id);
            $rack =$this->super_model->select_column_where("rack","rack_name", "rack_id", $items->rack_id);
            $group =$this->super_model->select_column_where("group","group_name", "group_id", $items->group_id);
            $wh =$this->super_model->select_column_where("warehouse","warehouse_name", "warehouse_id", $items->warehouse_id);
            $location =$this->super_model->select_column_where("location","location_name", "location_id", $items->location_id);
            $bin =$this->super_model->select_column_where("bin","bin_name", "bin_id", $items->bin_id);
            $supplier =$this->super_model->select_column_where("supplier","supplier_name", "supplier_id", $items->supplier_id);
            if($items->local_mnl=='1'){
                $sup = 'Local';
            } else if($items->local_mnl=='2'){
                 $sup = 'Manila';
            } else {
                $sup='';
            }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $sup);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $items->original_pn);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $items->item_description);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$num, $items->quantity);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$num, $items->item_cost);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $items->weight);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $unit);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$num, $location);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$num, $wh);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$num, $rack);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$num, $bin);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$num, $supplier);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$num, $items->date_added);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$num, $items->remarks);
            
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":AC".$num,'admin');
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
                $objPHPExcel->getActiveSheet()->getStyle('A'.$num.":AC".$num)->applyFromArray($styleArray);
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
        $objPHPExcel->getActiveSheet()->getStyle('A10:AC10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A10:AC10')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AC2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AC3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A4:AC4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AC2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AC3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A4:AC4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->getStyle('A4:AC4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
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
        $objPHPExcel->getActiveSheet()->getStyle('AC1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AC2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AC3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AC4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
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
        header('Content-Disposition: attachment; filename="DamageItems.xlsx"');
        readfile($exportfilename);
        /*echo "<script>window.location = 'item_list';</script>";*/
    }

    public function search_item(){
        $category=$this->input->post('category');
        $subcat=$this->input->post('subcat');
        $item_desc=$this->input->post('item_desc');
        $pn=$this->input->post('pn');
        $group=$this->input->post('group');
        $location=$this->input->post('location');
        $bin=$this->input->post('bin');
        $warehouse=$this->input->post('warehouse');
        $rack=$this->input->post('rack');
        $barcode=$this->input->post('barcode');
        $location=$this->input->post('location');
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
            $sql.= " damage_items.category_id = '$category' AND";
            $filter.="Category = " . $this->super_model->select_column_where('item_categories', 'cat_name', 
                        'cat_id', $category). ", ";
        }

        if(!empty($subcat)){
            $sql.= " damage_items.subcat_id = '$subcat' AND";
            $filter.="Sub Category = " . $this->super_model->select_column_where('item_subcat', 'subcat_name', 
                        'subcat_id', $subcat) . ", ";
        }

        if(!empty($item_desc)){
            $sql.= " damage_items.item_description LIKE '%$item_desc%' AND";
            $filter.="Item Desc = " .$item_desc. ", ";
        }

        if(!empty($pn)){
            $sql.= " damage_items.original_pn LIKE '%$pn%' OR supplier_items.catalog_no LIKE '%$pn%' AND";
            $filter.="PN No. = " .$pn. ", ";
        }

        if(!empty($group)){
            $sql.= " damage_items.group_id = '$group' AND";
            $filter.="Group = " . $this->super_model->select_column_where('group', 'group_name', 
                        'group_id', $group). ", ";
        }

        if(!empty($location)){
            $sql.= " damage_items.location_id = '$location' AND";
            $filter.="Section = " . $this->super_model->select_column_where('location', 'location_name', 
                        'location_id', $location). ", ";
        }

        if(!empty($bin)){
            $sql.= " damage_items.bin_id = '$bin' AND";
            $filter.="Bin = " . $this->super_model->select_column_where('bin', 'bin_name', 'bin_id', $bin). ", ";
        }

        if(!empty($warehouse)){
            $sql.= " damage_items.warehouse_id = '$warehouse' AND";
            $filter.="Warehouse = " . $this->super_model->select_column_where('warehouse', 'warehouse_name', 
                        'warehouse_id', $warehouse). ", ";
        }

        if(!empty($rack)){
            $sql.= " damage_items.rack_id = '$rack' AND";
            $filter.="Rack = " . $this->super_model->select_column_where('rack', 'rack_name', 'rack_id', $rack) . ", ";
        }

        if(!empty($barcode)){
            $sql.= " damage_items.barcode = '$barcode' AND";
            $filter.="Barcode = " .  $barcode . ", ";
        }

        $query=substr($sql,0,-3);
        $filter=substr($filter,0,-2);
        $count=$this->super_model->count_custom_where("damage_items", $query);
       
        $data['filter']=$filter;
        if($count!=0){
            $data['count_query'] = 1;
            foreach($this->super_model->select_custom_where("damage_items", $query) AS $itm){
                foreach($this->super_model->select_custom_where("damage_items", "damage_id = '$itm->damage_id'") AS $item){
                    $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $item->unit_id);
                }
                 $data['items'][] = array(
                    'damage_id'=>$itm->damage_id,
                    'original_pn'=>$itm->original_pn,
                    'item_description'=>$itm->item_description,
                    'category'=>$this->super_model->select_column_where('item_categories', 'cat_name', 'cat_id', $itm->category_id),
                    'subcategory'=>$this->super_model->select_column_where('item_subcat', 'subcat_name','subcat_id', $itm->subcat_id),
                    'quantity'=>$itm->quantity,
                    'item_cost'=>$itm->item_cost,
                    'uom'=>$unit,
                    'location'=>$this->super_model->select_column_where('location', 'location_name','location_id', $itm->location_id),
                    'bin'=>$this->super_model->select_column_where('bin', 'bin_name', 'bin_id', $itm->bin_id),
                    'rack'=>$this->super_model->select_column_where('rack', 'rack_name', 'rack_id', $itm->rack_id),
                );
            }
        } else {
            $data['count_query'] = 0;
             $data['items']=array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('damage/damage_list',$data);
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

