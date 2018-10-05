<?php


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SummaryModel extends CI_Model{

    function __construct(){
      parent::__construct();
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

    function getAssociateSellerList( $id ){
        $this->db->select("s.*");
        $this->db->where("bsb.BrandID", $id);
        $this->db->from("sellers s");
        $a = $this->db->join('brand_seller_bridge bsb', 's.ID = bsb.SellerID', 'inner');
        $query = $this->db->get();
        return $query->result_array();
    }
    
}