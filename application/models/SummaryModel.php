<?php


if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SummaryModel extends CI_Model{

    function __construct(){
      parent::__construct();
    }    

    function get_brand_summary_by_id($id){
        $this->db->select("b.*, GROUP_CONCAT(sc.Name) as sema_class, count(bsc.BrandId) as associate_seller_count");
        $this->db->from("brands b");
        $this->db->where("b.ID", $id);
        $this->db->where("sbcb.Status", 1);
        $this->db->join('sema_brand_class_bridge sbcb', 'b.ID = sbcb.BrandID', 'inner');
        $this->db->join('sema_class sc', 'sc.ID = sbcb.ClassID', 'inner');
        $a = $this->db->join('brand_seller_bridge bsc', 'b.ID = bsc.BrandID', 'inner');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_associte_seller_list($id){
        $this->db->select("s.*");
        $this->db->where("bsb.BrandID", $id);
        $this->db->from("sellers s");
        $a = $this->db->join('brand_seller_bridge bsb', 's.ID = bsb.SellerID', 'inner');
        $query = $this->db->get();
        return $query->result_array();
    }
}