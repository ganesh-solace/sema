
<?php

/***
	Controller : BrandsController
	CreatedBy : Ankita
	CreatedDate : 28-09-2018
***/


if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include('BaseController.php');

class Brands extends BaseController {

	public function __construct(){		
		parent::__construct();
		$this->load->model('Brand');
		$this->child = 'sema_brand_class_bridge';
		$this->parent = 'brands';
	}

	public function index() {
		parent::index();		
	}

	// add  brand data
	public function add() {	
		 if($this->input->method() == 'post') {
			 $BrandData = $this->input->post();
			 $BrandPostArr = $this->GenerateBrandPostData( $BrandData );
			 $this->saveAll($BrandPostArr,$this->parent, $this->child,'BrandID');
			 redirect("dashboards");
		 }
		
		$SemaClassList = $this->getSemaClassList();
		$data['SemaClassList'] = $SemaClassList;		
		$data['PageTitle'] = 'Add Brand';
		$this->load->view ('brands/add',$data );
	}
	
	// edit brand details
	public function edit(){
		$id = $this->input->post()['ID'];
		$flag = $this->deleteRecords( $id );		
		if( $flag ) {		
		   $BrandData = $this->input->post();
		   $BrandPostArr = $this->GenerateBrandPostData( $BrandData );
		   $this->updateInsert($BrandPostArr,$this->parent, $this->child, $id );
		   redirect("dashboards");
		}		
	}
	
	// update the status in edit case
	public function deleteRecords( $id ) {
		$data = array('Status'=>  0 );
		$where = array("BrandID"=> $id );
		$this->db->where($where);
		$flag = $this->db->update('sema_brand_class_bridge', $data);
		return $flag;
	}

	// edit post to display data for pop up
	public function editPost() {	
		if( !empty( $this->input->post() ) ) {
			$ID = $this->input->post()['ID'];
			$BrandsData = $this->getBrandsData( $ID );
		}
		$BrandList = $this->getBrandList();
		$SemaClassList = $this->getSemaClassList();
		$data['SemaClassList'] = $SemaClassList;		
		$data['PageTitle'] = 'Edit Brand';						
		$data['BrandData'] = $BrandsData;					
		$data['action'] = 'edit';
		$this->load->view ('brands/add',$data );
	}

	public function getBrandsData( $id ) {		
		$whereCondition = array( 'B.Status' => 1,'B.ID' => $id);
		$this->db->select('GROUP_CONCAT(SCB.ClassID) ClassID,B.*');    
		$this->db->from('brands B');
		$this->db->join('sema_brand_class_bridge SCB', 'B.ID = SCB.BrandID');	
		 $this->db->where( $whereCondition );  	
		$this->db->group_by('B.ID'); 
		$this->db->order_by('B.ID', 'desc'); 
		$query = $this->db->get();
		$BrandsData = $query->result();
		return $BrandsData;
	} 

	// on submit of brands popup form set validation
	public function ajaxValidation() {
		$config = $this->Brand->GetTheValidationFields();
		$this->form_validation->set_rules($config);
		if( $this->form_validation->run() ==  false ) {
			$errors = validation_errors();
				echo json_encode(['error'=>$errors]);
		} else {
			echo json_encode("");exit;
		}
	}

	// generate brands post data
	public function GenerateBrandPostData( $BrandData ) {
		$BrandPostArr = array();		
		if( isset( $BrandData['Code'] ) && !empty( $BrandData['Code'] )) {
			$Code = $BrandData['Code'];
		} else {
			$Code = $this->GenerateCode('brands',"B");
		} 
		
		$TransactionDetails = $this->getTransactionDetails();
		$BrandPostArr['ID'] = ( isset( $BrandData['ID'] ) && !empty( $BrandData['ID'] )) ? $BrandData['ID'] : 0;
		$this->id = $BrandPostArr['ID'];
		$BrandPostArr['Code'] = $Code;
		$BrandPostArr['Name'] = $BrandData['Name'];
		$BrandPostArr['Description'] = $BrandData['Description'];
		$BrandPostArr['Status'] = 1;
		$BrandPostArr['CreatedDate'] = isset( $BrandData['CreatedDate'] ) ? $BrandData['CreatedDate'] :  $TransactionDetails['CreatedDate'];
		$BrandPostArr['ModifiedDate'] = $TransactionDetails['ModifiedDate'];
		$BrandClassArr = $this->GenerateBrandClassPostData($BrandData['ClassID'], $TransactionDetails, $this->id );
		$BrandArr = array();
		$BrandArr[$this->parent] = $BrandPostArr;		
		$BrandArr[$this->child] = $BrandClassArr;

	
		return $BrandArr;
	}

	// generate brands class post database for associated table
	public function GenerateBrandClassPostData($BrandClassData, $TransactionDetails, $id) {
		$BrandClassArr = array();
		foreach ($BrandClassData as $BrandDatakey => $BrandDatavalue) {			 
			$BrandClassArr[$BrandDatakey]['BrandID'] = $id;
			$BrandClassArr[$BrandDatakey]['ClassID'] = $BrandDatavalue;
			$BrandClassArr[$BrandDatakey]['CreatedDate'] = $TransactionDetails['CreatedDate'];
			$BrandClassArr[$BrandDatakey]['ModifiedDate'] = $TransactionDetails['ModifiedDate'];	
			$BrandClassArr[$BrandDatakey]['Status'] = $TransactionDetails['Status'];	
		}
			return $BrandClassArr;
	}


}
