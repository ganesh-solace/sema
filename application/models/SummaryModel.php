<?php


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SummaryModel extends CI_Model{

    function __construct(){
      parent::__construct();
    }    

    public function lastDataRefresh( $id ) {
        $whereCondition = array( "Status" => 1, "ID" => $id );
        $this->db->select( "LastDataRefresh" );  
        $this->db->from( "brands" );
        $this->db->where( $whereCondition );
        $query = $this->db->get();
        
        return $query->result_array();
    }

    // Seller Index, Summary Index: generate the brands data 
    public function getBrandSummaryByID( $id ){
        $this->db->distinct();
        $this->db->select("B.*, GROUP_CONCAT(SC.Name) ClassName");
        $this->db->from("sema_brand_class_bridge SBC");
        $this->db->join('sema_class SC', 'SC.ID = SBC.ClassID', 'INNER');
        $this->db->join('brands B', 'SBC.BrandID = B.ID', 'INNER');
        $this->db->where("SBC.BrandID", $id);
        $this->db->where("SBC.Status", 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Seller Index, Summary Index: generate the brands wiht code data 
    public function getBrandCodeSummaryByID($id, $CodeID) {
        $this->db->distinct();
        $this->db->select("B.*, GROUP_CONCAT(SC.Name) ClassName, BCB.ID CodeID, BCB.AppendBrandCode, BCB.BrandCode");
        $this->db->from("sema_brand_class_bridge SBC");
        $this->db->join('sema_class SC', 'SC.ID = SBC.ClassID', 'INNER');
        $this->db->join('brands B', 'SBC.BrandID = B.ID', 'INNER');
        $this->db->join('brand_code_bridge BCB', 'BCB.BrandID = B.ID AND BCB.ID = SBC.BrandCodeID', 'INNER');
        $this->db->where("SBC.BrandID", $id);
        $whereCondition = array("SBC.BrandID"=>$id, "BCB.ID"=>$CodeID);
        $this->db->where($whereCondition);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    //not in use
    public function NumberOfAssociateSeller( $id ) {
        $this->db->distinct();        
        $this->db->select("COUNT(BSB.SellerID) AssociateSeller");        
        $this->db->from("brands B");
        $a = $this->db->join('`brand_seller_bridge` BSB', 'B.ID = BSB.BrandID', 'inner');
        $whereCondition = array("B.ID" => $id,"BSB.Status" => 1);
        $this->db->where($whereCondition);
         $query = $this->db->get();
        return $query->result_array();
    }

   public function NumberOfAssociateSellerCode( $id, $CodeID ) {
        $this->db->distinct();        
        $this->db->select("COUNT(BSB.SellerID) AssociateSeller");        
        $this->db->from("brands B");
        $a = $this->db->join('`brand_seller_bridge` BSB', 'B.ID = BSB.BrandID', 'inner');
        $whereCondition = array("B.ID" => $id,"BSB.Status" => 1);
        $this->db->where($whereCondition);
         $query = $this->db->get();
        return $query->result_array();
    }
    
    // not in use 
       function getAssociateSellerList( $id ){
        $this->db->select('s.*, REPLACE(s.LastName,"-","") LastName');
        $whereCondition = array("bsb.BrandID" => $id,"bsb.Status" => 1);
        // $this->db->where("bsb.BrandID", $id);
        $this->db->where( $whereCondition );
        $this->db->from("sellers s");
        $a = $this->db->join('brand_seller_bridge bsb', 's.ID = bsb.SellerID', 'inner');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get the Seller list associated to particular brand code
    function getAssociateSellerListCode( $id, $CodeID ){
        $this->db->select('s.*, REPLACE(s.LastName,"-","") LastName');
        $whereCondition = array("bsb.BrandID" => $id,"BrandCodeID" => $CodeID, "bsb.Status" => 1);
        // $this->db->where("bsb.BrandID", $id);
        $this->db->where( $whereCondition );
        $this->db->from("sellers s");
        $a = $this->db->join('brand_seller_bridge bsb', 's.ID = bsb.SellerID', 'inner');
        $query = $this->db->get();
        $query =  $query->result_array();
        // print_r($query);exit;
         return $query;
    }

    public function GetTitleFieldsArray() {
     
         $this->db->select(' text,jp_fields');
        //  $this->db->where("FIND_IN_SET(`text`, '".$Title."') !=", 0); 
         $this->db->where("Status", 1);         
         $this->db->from("title_configuration");
        $query = $this->db->get();
         $TitleConfigurationArr =  $query->result_array();
         $TitleConfArr = array();
        foreach ($TitleConfigurationArr as $ConfKey => $ConfValue) {
            $TitleConfArr[$ConfValue["text"]] =  $ConfValue["jp_fields"];
            
        }
     return $TitleConfArr;
    }

    public function GetPostTitleValues($MainTitleArr, $TitleStr, $TitleSeprator) {
        $TitleArray = explode($TitleSeprator,$TitleStr);
        $ExplodeArr = array();
        foreach ($TitleArray as $TitleKey => $TitleValue) {
            $TitleValue =trim($TitleValue);
            if(isset($MainTitleArr[$TitleValue]) && !empty($MainTitleArr[$TitleValue])){
                $ExplodeArr[] = $MainTitleArr[$TitleValue];
            }
        }
        
        $JpFeildsStr = implode($TitleSeprator, $ExplodeArr);

        return $JpFeildsStr;
    }
    
}