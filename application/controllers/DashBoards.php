
<?php

/***
	Controller : SemaDataDashBoardsController
	CreatedBy : Ankita
	CreatedDate : 27-09-2018
***/


if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include('BaseController.php');

class DashBoards extends BaseController {

	public function __construct(){		
		parent::__construct();
		$this->load->model('DashBoard');
	}

	public function index() {
		parent::index();	
		// $BrandList = $this->getBrandList();	
		$BrandList = $this->getRecentBrandListWithCode();	
		$RecentBrandList = $this->getRecentBrandList();
		$data['BrandListWithCode'] =  $this->getRecentBrandListWithCode();
		$data['BrandList'] = $BrandList;
		$data['RecentBrandList'] = $RecentBrandList;
		if(isset($_SESSION["summary"]) && !empty($_SESSION["summary"])) unset($_SESSION["summary"]);
		$this->template->load('template','dashboards/dashboard',$data);
	}

	public function getRecentBrandListWithCode() {
			$whereCondition = array("BCB.Status" => 1);
			$this->db->select( "B.ID, B.Name BrandName, BCB.ID BrandCodeID, BCB.AppendBrandCode" );
			$this->db->from( "brands B" );
			$this->db->join('`brand_code_bridge` BCB', 'B.ID = BCB.BrandID', 'inner');
			$this->db->where( $whereCondition ); 
			$this->db->order_by("B.ID", "DESC");
			$query = $this->db->get();
			$BrandData = $query->result();
			$BrandDataArr =array();
			foreach ($BrandData as $BrandKey => $BrandValue) {
				$BrandDataArr[$BrandValue->ID]["BrandName"]["value"] = $BrandValue->ID;
				$BrandDataArr[$BrandValue->ID]["BrandName"]["text"] = $BrandValue->BrandName;
				$BrandDataArr[$BrandValue->ID]["BrandCode"][$BrandKey]["value"] = $BrandValue->BrandCodeID;
				$BrandDataArr[$BrandValue->ID]["BrandCode"][$BrandKey]["text"] = $BrandValue->AppendBrandCode;
				
			}
			$BrandDataArr = array_values($BrandDataArr);
			return $BrandDataArr;
		}

}
