
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
	
		$BrandData = $this->input->post();
		   $this->Brand->SaveData($BrandData);
		   $this->CreateBrandFloderFTP( $BrandData );
		   redirect("DashBoards");
			
	}

	//edit: update the status in edit case
	public function deleteRecords( $id ) {
		$data = array('Status'=>  0 );
		$where = array("BrandID"=> $id );
		$this->db->where($where);
		$flag = $this->db->update('sema_brand_class_bridge', $data);
		return $flag;
	}


	//form action: add  brand data
	public function add() {	
		 if($this->input->method() == 'post') {

			 $BrandData = $this->input->post();
			 $Code = $this->GenerateCode('brands',"B");
			 $this->Brand->AddNewBrand($BrandData);
			 $this->CreateBrandFloderFTP( $BrandData );
			 redirect("DashBoards");
		 }
		
		$SemaClassList = $this->getSemaClassList();
		$data['SemaClassList'] = $SemaClassList;		
		$data['PageTitle'] = 'Add Brand';
		$this->load->view ('brands/add',$data );
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
