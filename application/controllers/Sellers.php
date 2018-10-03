<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('BaseController.php');
class Sellers extends BaseController {

	 public function __construct() {
        parent::__construct();
        // $this->load->model("SellerModel", "seller");
    }

    public function index() {
        parent::index();
        
        $id = 1;
        $table = "brand_price_adjustment_bridge";
        $type_values   = $this->get_enum_values($table, "TypeID");
        $amount_values = $this->get_enum_values($table, "AmountTypeID");
        $base_values   = $this->get_enum_values($table, "BaseID");
        
        $data["type"] = $type_values;
        $data["amount"] = $amount_values;
        $data["base"] = $base_values;
        
		$this->template->load('template','sellers/seller',$data);

        // $this->load->view("seller", $data);
        
    }

    public function AssociateSeller() {
        $BrandList = $this->getBrandList();
       $SellerList = $this->getSellerList();
        $data["BrandList"] = $BrandList;
        $data["SellerList"] = $SellerList;
        $this->load->view ( 'sellers/associate_seller',$data );
        // echo "str";exit;
    }

    function get_enum_values($table, $field)
    {
        $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }
}
