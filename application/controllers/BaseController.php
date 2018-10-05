<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {

	 public function __construct() {
    	parent::__construct();     
		$this->load->helper(array('url','html','form'));
		$this->load->library('template');

    }
	

	public function index() {}
		
	// Select statemtnt with feilds, wherecondition and limit	
	  public function SelectQuery($table, $fields, $whereCondition = null, $limit = null, $orderBy = null ) {
			$this->db->select( $fields );
			$this->db->from( $table );
			if( !empty( $whereCondition ) ) $this->db->where( $whereCondition );  
			if( !empty( $orderBy ) ) $this->db->order_by($orderBy['field'], $orderBy['Type']);  
			
			if( !empty( $limit ) )  $this->db->limit($limit);   
			

			$query = $this->db->get();
			$query = $query->result();
			return $query;
    }

		public function getBrandList() {
			$BrandData = $this->SelectQuery('brands',"ID,Name");
			$BrandList = array();
			$whereCondition = array( 'Status' => 1);
			$BrandList[0] = " -- select -- ";
			foreach ($BrandData as $BrandKey => $BrandValue) {
				$BrandList[$BrandValue->ID] =  $BrandValue->Name;
			}
			return $BrandList;
		}

		
		public function getSellerList() {
			$SellerData = $this->SelectQuery('sellers',"ID,Name");
			$SellerList = array();
			// $whereCondition = array( 'Status' => 1);
			foreach ($SellerData as $SellerKey => $SellerValue) {
				$SellerList[$SellerValue->ID] =  $SellerValue->Name;
			}
			return $SellerList;
		}

		// sema class list for dro down
		public function getSemaClassList() {
			$SemaClassData = $this->SelectQuery('sema_class',"ID,Name");
			$SemaClassList = array();
			foreach ($SemaClassData as $ClassKey => $ClassValue) {
				$SemaClassList[$ClassValue->ID] =  $ClassValue->Name;
			}
			return $SemaClassList;
	}

	// generate code 
	public function GenerateCode($table,$prefix) {
		$orderBy = array('field' => "ID",'Type' => "DESC");
		$CodeID = $this->SelectQuery($table, "ID",'', "1", $orderBy ) ;
		$Count = (isset( $CodeID ) && !empty( $CodeID ) ) ? $CodeID[0]->ID + 1 :  1;
		$GeneratedCode = $prefix."-0".$Count;

		return $GeneratedCode;
	}

	// create date common for the all transaction
	public function getTransactionDetails() {
		$TrasactionArray = array();
		$TrasactionArray['CreatedDate'] = date("Y-m-d H:i:s");   
		$TrasactionArray['ModifiedDate'] = date("Y-m-d H:i:s");   
		$TrasactionArray['Status'] = 1;   
		$TrasactionArray['CreatedBy'] = $this->session->userdata['logged_in']['ID'];
		$TrasactionArray['ModifiedBy'] = $this->session->userdata['logged_in']['ID'];
		return $TrasactionArray;
	}

	public function updateInsert( $data,$parent, $child, $id ) {
		$this->db->trans_begin();
		$this->db->trans_strict( FALSE );	

		$where = array( "ID" => $id );
		$this->db->where( $where );
		$flag = $this->db->update( $parent , $data[$parent] );

		if( $flag ) {
			$flag =  $this->db->insert_batch( $child , $data[$child] );
		}

		if ( $this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return $flag;
	}

	public function SaveAll( $data,$parent, $child, $key ) {
		$this->db->trans_begin();
		$this->db->trans_strict( FALSE );
	
		if( $this->db->insert($parent, $data[$parent]) ) {
			if( !empty( $child ) && !empty( $data[$child]) ) {
				$LastInsertID = $this->db->insert_id();

			$data[$child] =	array_map( function( $ArrayValue) use($key, $LastInsertID ) {
					$ArrayValue[$key] = $LastInsertID;
					return $ArrayValue;
				}, array_values( $data[$child]));

				$flag =  $this->db->insert_batch( $child , $data[$child] ); 
			}		
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}

		return true;
	}
}
