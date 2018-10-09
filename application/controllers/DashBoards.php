
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
		$BrandList = $this->getBrandList();	
		$RecentBrandList = $this->getRecentBrandList();
		$data['BrandList'] = $BrandList;
		$data['RecentBrandList'] = $RecentBrandList;
		$this->template->load('template','dashboards/dashboard',$data);
	}


}
