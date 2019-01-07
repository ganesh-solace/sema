
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
		$this->childCode = "brand_code_bridge";
		$this->parent = 'brands';
	}

	public function index() {
		parent::index();		
	}

	public function View() {				
		$this->load->library('pagination');	
		$data['PageTitle'] = 'View All Brands';	
		$limit = 3;

		$BrandData = $this->Brand->GetbrandCodeViewData();
				$data['BrandData'] = $BrandData["BrandCodeData"];
				$data["TotalRecords"] = $BrandData["Count"];
				$total_pages = ceil($BrandData["Count"] / $limit); 
				// $data["TotalRecords"] = $total_pages;
		$this->load->view ('brands/view', $data );
	}

	// form action: edit post to display data for pop up
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

	// editPost: get the brand details from ID
	public function getBrandsData( $id ) {	
		$whereCondition = array( 'B.ID' => $id ,"BB.Status" => 1,"SB.Status"=>1 );
		$this->db->select(' B.ID, B.Name BrandName,B.SemaBrandAlias,B.ShortName,B.Description, GROUP_CONCAT(DISTINCT(BB.BrandCode)) BrandCode,GROUP_CONCAT(DISTINCT(SB.ClassID)) ClassID');    
		$this->db->distinct();
		$this->db->from('brands B');
		$this->db->join('brand_code_bridge BB', 'BB.BrandID = B.ID ',"inner");	
		$this->db->join('sema_brand_class_bridge SB', 'SB.BrandID = B.ID AND SB.BrandID = BB.BrandID AND SB.BrandCodeID = BB.ID ',"inner");	
		 $this->db->where( $whereCondition );  	
		$this->db->order_by('B.ID', 'desc'); 
		$query = $this->db->get();
		$BrandsData = $query->result();
		return $BrandsData;
	}


	//editPost: edit brand details
	public function edit(){
		$id = $this->input->post()['ID'];
		$flag = $this->deleteRecords( $id );		  
	
		if( $flag ) {		
		   $BrandData = $this->input->post();
		   $this->Brand->EditDataPostDB( $BrandData );
		   $this->CreateBrandFloderFTP( $BrandData );
		   redirect("DashBoards");
		}		
	}

	//edit: update the status in edit case
	public function deleteRecords( $id ) {
		$data = array('Status'=>  0 );
		$where = array("BrandID"=> $id );
		$this->db->where($where);
		$flag = $this->db->update('sema_brand_class_bridge', $data);
		// exit;
		return $flag;
	}


	//form action: add  brand data
	public function add() {	
		 if($this->input->method() == 'post') {
			 $BrandData = $this->input->post();
			 $BrandPostArr = $this->GenerateBrandPostData( $BrandData,"add" );
			
			 $this->saveAll( $BrandPostArr,$this->parent, $this->child, "$this->childCode",'BrandID',"BrandCodeID" );
			 redirect("DashBoards");
		 }
		
		$SemaClassList = $this->getSemaClassList();
		$data['SemaClassList'] = $SemaClassList;		
		$data['PageTitle'] = 'Add Brand';
		$this->load->view ('brands/add',$data );
	}
	
	//add,edit: generate brands post data
	public function GenerateBrandPostData( $BrandData, $action ) {		
		$this->CreateBrandFloderFTP( $BrandData );
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
		$BrandPostArr['ShortName'] = $BrandData['ShortName'];
		$BrandPostArr['SemaBrandAlias'] = $BrandData['SemaBrandAlias'];
		$BrandPostArr['Description'] = $BrandData['Description'];
		$BrandPostArr['Status'] = 1;
		$BrandPostArr['CreatedDate'] = (isset( $BrandData['CreatedDate'] ) && !empty( $BrandData['CreatedDate'] )) ? $BrandData['CreatedDate'] :  $TransactionDetails['CreatedDate'];
		$BrandPostArr['ModifiedDate'] = $TransactionDetails['ModifiedDate'];
		
		$BrandCodeArr = $this->GenerateBrandCodePostData( $BrandData['BrandCode'], $BrandData['Name'],$TransactionDetails, $this->id, $action );
		$BrandClassArr = $this->GenerateBrandClassPostData( $BrandData['ClassID'], $TransactionDetails, $this->id );
		$BrandArr = array();
		$BrandArr[$this->parent] = $BrandPostArr;		
		$BrandArr[$this->child] = $BrandClassArr;		
		$BrandArr[$this->childCode] = $BrandCodeArr;
		return $BrandArr;
	}

	//GenerateBrandPostData: generate brands class post database for associated table
	public function GenerateBrandClassPostData($BrandClassData, $TransactionDetails, $id) {
		$BrandClassArr = array();
		foreach ($BrandClassData as $BrandDatakey => $BrandDatavalue) {			 
			$BrandClassArr[$BrandDatakey]['BrandID'] = $id;
			$BrandClassArr[$BrandDatakey]['ClassID'] = $BrandDatavalue;
			$BrandClassArr[$BrandDatakey]['BrandCodeID'] = 0;
			$BrandClassArr[$BrandDatakey]['CreatedDate'] = $TransactionDetails['CreatedDate'];
			$BrandClassArr[$BrandDatakey]['ModifiedDate'] = $TransactionDetails['ModifiedDate'];
			$BrandClassArr[$BrandDatakey]['Status'] = $TransactionDetails['Status'];	
		}
			return $BrandClassArr;
	}

	public function GenerateBrandCodePostData( $BrandCodeData, $BrandName, $TransactionDetails, $id, $action ) {
		$BrandCodeArray = array();
		foreach ($BrandCodeData as $CodeKey => $CodeValue) {			
			$BrandCodeArray[$CodeKey]['BrandID'] = $id;
			$BrandCodeArray[$CodeKey]['BrandCode'] = $CodeValue;
			$BrandCodeArray[$CodeKey]['AppendBrandCode'] = $BrandName."-".$CodeValue;
			$BrandCodeArray[$CodeKey]['CreatedDate'] = $TransactionDetails['CreatedDate'];
			$BrandCodeArray[$CodeKey]['ModifiedDate'] = $TransactionDetails['ModifiedDate'];
			$BrandCodeArray[$CodeKey]['Status'] = $TransactionDetails['Status'];
		}
		
		return $BrandCodeArray;
	}

	//Form poup Add & edit Ajax Name :  on submit of brands popup form set validation
	public function ajaxValidation() {
		$config = $this->Brand->GetTheValidationFields();
		$this->form_validation->set_rules( $config );
		if( $this->form_validation->run() ==  false ) {
			$errors =  $this->form_validation->error_array();
			$errorsArr = [];
			$i = 0;
			foreach ($errors as $ErrorKey => $ErrorValue) {

				$errorsArr[$i]["key"] = $ErrorKey;
				$errorsArr[$i]["value"] = $ErrorValue;
				$i ++;
			}
				echo json_encode(['error'=>$errorsArr]);
		} else {
			echo json_encode("");exit;
		}
	}

		public function ajaxGetData(){
		$BrandID = $this->input->post()["BrandID"];
		$whereCondition = array("BrandID"=> $BrandID, "Status" => 1);
		$ResponseData = $this->SelectQuery("brand_code_bridge", "ID, BrandCode", $whereCondition);
		$data = json_encode((array) $ResponseData);
		echo $data; exit;
	}

	public function CreateBrandFloderFTP( $FtpRequiredData ) {
		$this->load->library('ftp');
		$config = unserialize(CONFIG);
		$conn =  $this->ftp->connect($config);
		

		$BrandFolderName = strtolower( $FtpRequiredData["Name"] );
		$BrandFolderName = str_replace(" ", "_", $BrandFolderName);

		$CheckBrandDirPath = EXCEL_FILE_PATH.$BrandFolderName."/";

		if(!is_dir($CheckBrandDirPath)) {
			$this->ftp->mkdir($CheckBrandDirPath, 0777);
			$this->ftp->chmod($CheckBrandDirPath, 0777);
		}
		foreach ($FtpRequiredData["BrandCode"] as $BrandKey => $BrandValue) {
			$BrandValue = strtolower( $BrandValue );
			$BrandValue = str_replace(" ", "_", $BrandValue);
			$BrandValueFolderPath = $CheckBrandDirPath.$BrandValue."/";
			if(!is_dir($BrandValueFolderPath)) {
				$this->ftp->mkdir($BrandValueFolderPath, 0777);
				$this->ftp->chmod($BrandValueFolderPath, 0777);
				$WithFitmentDir = $BrandValueFolderPath."with_fitment/";
				$WithoutFitmentDir = $BrandValueFolderPath."without_fitment/";
				$ImagesDir = $BrandValueFolderPath."images/";
				$this->ftp->mkdir($WithFitmentDir, 0777);
				$this->ftp->chmod($WithFitmentDir, 0777);
				$this->ftp->mkdir($WithoutFitmentDir, 0777);
				$this->ftp->chmod($WithoutFitmentDir, 0777);
				$this->ftp->mkdir($ImagesDir, 0777);
				$this->ftp->chmod($ImagesDir, 0777);
			}
		}
	}

}
