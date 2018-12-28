<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {

	 public function __construct() {
    	parent::__construct();     
		$this->load->helper(array('url','html','form'));
		$this->load->library('template');
		$this->load->library(array('form_validation','session'));;
		if( !isset( $this->session->userdata['logged_in'] ) && empty( $this->session->userdata['logged_in'] )) {
			redirect(base_url());
		}
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
			$whereCondition = array( 'Status' => 1);
			$BrandData = $this->SelectQuery('brands',"ID,Name",$whereCondition);
			$BrandList = array();
			
			$BrandList[0] = " -- select -- ";
			foreach ($BrandData as $BrandKey => $BrandValue) {
				$BrandList[$BrandValue->ID] =  $BrandValue->Name;
			}
			return $BrandList;
		}

		
		public function getRecentBrandList() {			
			$BrandList = array();
			$whereCondition = array( 'Status' => 1);
			$orderBy = array( "field" => "LastDataRefresh",  "Type" => "DESC");
			$BrandData = $this->SelectQuery('brands',"ID,Name", $whereCondition, "", $orderBy);
			$BrandList[0] = " -- select -- ";
			foreach ($BrandData as $BrandKey => $BrandValue) {
				$BrandList[$BrandValue->ID] =  $BrandValue->Name;
			}
			return $BrandList;
		}
		
		public function getSellerList() {
			$SellerData = $this->SelectQuery('sellers',"ID,CONCAT(FirstName,' ',LastName) Name ");
			$SellerList = array();
			// $whereCondition = array( 'Status' => 1);
			foreach ($SellerData as $SellerKey => $SellerValue) {
				$SellerList[$SellerValue->ID] =  $SellerValue->Name;
			}
			return $SellerList;
		}

			public function getJPSellerList() {
			$whereCondition = array( 'Status' => 1);
			$orderBy = array("field" => "JPSellerName", "Type" => "ASC");
			$SellerData = $this->SelectQuery('sellers','ID,CONCAT(JPSellerName,"( ",CONCAT(FirstName," ", REPLACE(LastName,"-","")), ")" ) Name', $whereCondition, "", $orderBy);

			$SellerList = array();
		
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

	public function updateInsert( $data,$parent, $child,$childCode, $id, $key, $key2, $CodeIDStatus ) {
		$this->db->trans_begin();
		$this->db->trans_strict( FALSE );
		$where = array( "ID" => $id );
		$this->db->where( $where );
		$flag = $this->db->update( $parent , $data[$parent] );
		if($flag) {
			$this->update_batch_code($childCode, $data[$childCode]);
			 $this->update_batch_codeClass($child, $data[$child]);
		
		}
		
		if ( $this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return $flag;
	}

	public function update_batch_code($childCode, $data) {
		
		foreach ($data as $key => $value) {
			$where = array();
			$where = array( "ID" => $value["ID"],"BrandID" => $value["BrandID"] );
			$this->db->where( $where );
			$this->db->update($childCode, $value);
		}
	}

	public function update_batch_codeClass($child, $data) {
		foreach ($data as $key => $value) {
			$this->db->insert_batch( $child , $value ); 			
		}
	}

	public function getLastBrandCodeIDsUpdate() {
		$whereCondition = array($key => $LastInsertID, "Status"=> 1);
		$CodeID = 	$this->SelectQuery($tableName, "ID", $whereCondition );
	}

	 /* public function SaveParentChildUpdate( $data,$parent, $child, $childCode, $key,$key2,$id ) {
		
		$LastInsertID = $this->db->insert_id();
			$data[$childCode] =	array_map( function( $ArrayValue) use($key, $LastInsertID ) {
					$ArrayValue[$key] = $LastInsertID;
					return $ArrayValue;
				}, array_values( $data[$childCode]));

			$flag =  $this->db->insert_batch( $childCode , $data[$childCode] ); 
			$CodeIDarr = $this->getLastBrandCodeIDsUpdate($data,$child,$LastInsertID, $childCode, $key, $key2, $id);
		//  return flase;
	}*/

	/* public function getLastBrandCodeIDsUpdsate($data,$child,$LastInsertID, $tableName, $key, $key2, $id) {
		$whereCondition = array($key => $LastInsertID, "Status"=> 1);
		$CodeID = 	$this->SelectQuery($tableName, "ID", $whereCondition );
		$dataChildArr = array();
		// echo $key;
		// 	print_r($CodeID);
			
			foreach ($CodeID as $BrandCodekey => $BrandCodevalue) {
				$dataChildArr =	array_merge($dataChildArr, array_map( function( $ArrayValues) use($key2,$key,$LastInsertID, $BrandCodevalue, $id ) {
					$ArrayValues[$key2] = $BrandCodevalue->ID;
					$ArrayValues[$key] = $id;
					return $ArrayValues;
				},  $data[$child]));
			}
		$data[$child] = $dataChildArr;
		// print_r($dataChildArr);exit;
		$flag =  $this->db->insert_batch( $child , $data[$child] ); 

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}*/



	public function SaveAll( $data,$parent, $child, $childCode, $key, $key2 ) {
		$this->db->trans_begin();
		$this->db->trans_strict( FALSE );

		if( $this->db->insert($parent, $data[$parent]) ) {
			if(!empty( $childCode ) && !empty( $data[$child]) ) {
				$this->SaveParentChild( $data,$parent, $child, $childCode, $key,$key2 );
			} elseif( !empty( $child ) && !empty( $data[$child]) ) {
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

	public function SaveParentChild( $data,$parent, $child, $childCode, $key,$key2 ) {
		
		$LastInsertID = $this->db->insert_id();
			$data[$childCode] =	array_map( function( $ArrayValue) use($key, $LastInsertID ) {
					$ArrayValue[$key] = $LastInsertID;
					return $ArrayValue;
				}, array_values( $data[$childCode]));

			$flag =  $this->db->insert_batch( $childCode , $data[$childCode] ); 
			$CodeIDarr = $this->getLastBrandCodeIDs($data,$child,$LastInsertID, $childCode, $key, $key2);
		 return flase;
	}

	public function getLastBrandCodeIDs($data,$child,$LastInsertID, $tableName, $key, $key2) {
		$whereCondition = array($key => $LastInsertID, "Status"=> 1);
		
		$CodeID = 	$this->SelectQuery($tableName, "ID", $whereCondition,count($data[$tableName]) );
		$dataChildArr = array();

			foreach ($CodeID as $BrandCodekey => $BrandCodevalue) {
				$dataChildArr =	array_merge($dataChildArr, array_map( function( $ArrayValues) use($key2,$key,$LastInsertID, $BrandCodevalue ) {
					$ArrayValues[$key2] = $BrandCodevalue->ID;
					$ArrayValues[$key] = $LastInsertID;
					return $ArrayValues;
				},  $data[$child]));
			}
		$data[$child] = $dataChildArr;
		
		$flag =  $this->db->insert_batch( $child , $data[$child] ); 

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}
}
