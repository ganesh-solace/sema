<?php


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SellerModel extends CI_Model{

    function __construct(){
      parent::__construct();
    }    

 
   public function GetSellerName( $SellerID ) {
        $whereCondition = array("ID" => $SellerID,"Status"=>1);
        // $this->db->select( 'Concat(FirstName,LastName) Name' );
        $this->db->select( 'JPSellerID' );
        $this->db->from( 'sellers' );
        $this->db->where( $whereCondition );
        $query = $this->db->get();
        $query = $query->result();
        
        return $query[0]->JPSellerID;
   }

// fetech the brand name called from GenerateBrandSellerBridgeData function for data feed file name
    public function GetBrandName( $BrandID ) {
        $whereCondition = array("ID" => $BrandID,"Status"=>1);
        $this->db->select( 'Name' );
        $this->db->from( 'brands' );
        $this->db->where( $whereCondition );
        $query = $this->db->get();
        $query = $query->result();
        return $query[0]->Name;
    }


      public function GetBrandNameCode( $BrandID, $CodeID ) {
        $this->db->select('BB.AppendBrandCode, BB.BrandCode, B.Name BrandName');
         $whereCondition = array("B.ID" => $BrandID,"BB.BrandID"=>$BrandID,"BB.ID" => $CodeID,"BB.Status" => 1);
        $this->db->where( $whereCondition );
        $this->db->from("brand_code_bridge BB");
        $a = $this->db->join('brands B', 'B.ID = BB.BrandID', 'inner');
        $query = $this->db->get();
        $query = $query->result_array();

        return $query[0];
    }

    //PriceAdjustment:  insert post data into brand seller price adjustment bridge table
    public function InsertPriceAdjustmentData( $PriceAdjustmentArr ) {
        // echo "<pre> sdfasdf";
        // print_r($PriceAdjustmentArr);exit;
       $flag =  $this->db->insert('brand_price_adjustment_bridge', $PriceAdjustmentArr);
       return $flag;
    }

    // deleteRecordsForBrandID: check the count records exists for particular brandID 
    public function BrandRecordsExistsCheck( $BrandID, $CodeID ) {
        $whereCondition = array("BrandID" => $BrandID,"BrandCodeID"=>$CodeID, "Status"=>1);
        $this->db->select( 'Count(ID) ID' );
        $this->db->from( 'brand_seller_bridge' );
        $this->db->where( $whereCondition );
        $query = $this->db->get();
        $query = $query->result();
        return $query[0]->ID;
    }

    // Index: collect the data for seller price adjustment 
    public function getPriceAdjustmentEnumData() {        
        $table = "brand_price_adjustment_bridge";
        $type_values   = $this->getArrayKeyvaluePair( $this->get_enum_values($table, "TypeID") );
        $amount_values = $this->getArrayKeyvaluePair( $this->get_enum_values($table, "AmountTypeID") );
        $base_values   = $this->getArrayKeyvaluePair( $this->get_enum_values($table, "BaseID") );      
         
        $data["type"] = $type_values;
        $data["amount"] = $amount_values;
        $data["base"] = $base_values;
        return $data;
    }

    // generte key as value for enum fields 
    public function getArrayKeyvaluePair( $key ) {
        $array = array();
        foreach ($key as $Arrkey => $Arrvalue) {
            $array[$Arrvalue] = $Arrvalue;             
        }
       return $array;
    }

   public function get_enum_values($table, $field) {
        $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }
   
}