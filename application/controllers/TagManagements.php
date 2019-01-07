<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include('BaseController.php');

class TagManagements extends BaseController {

	public function __construct(){		
		parent::__construct();
		$this->load->model('TagManagement', 'tag');
	}

	public function index() {
		parent::index();	
		$data['data'] = $this->tag->selectTags();
		$this->template->load('template','TagManagements/tag',$data);
	}

	public function ajaxViewAllTagsData() {
		$data['data'] = $this->tag->selectTags($_POST["BrandID"]);
		echo json_encode($data);exit();
	}

	public function submitForm() {
		$PostData = $this->input->post();
		if(isset($PostData['action']) && !empty($PostData['action'])){
			$action = $PostData['action'];	
			$CodeID = $PostData['CodeID'];	
			unset($PostData['action']);
			unset($PostData['Submit']);
			unset($PostData['CodeID']);
		}
		
		$insertid = $this->tag->insertTags( $PostData );
		if(isset($action) && !empty($action)) {			
       	  $_SESSION["summary"]["BrandID"] = $PostData["BrandID"];
          $_SESSION["summary"]["CodeID"] = $CodeID;
          redirect("summary");
		}
		echo $insertid;
	}

	public function delete(){
		$id = $this->input->post('id');
		$data = $this->tag->deleteTag( $id );
		echo $data;

	}

	public function edit(){
		$id = $this->input->post('id');
		$data = $this->tag->editTag( $id );
		echo json_encode($data);
	}

	public function updateform(){
		$updateid = $this->tag->updateTags( $_POST );
		echo $updateid;
	}

	public function DisplayTagPopUp() {
		$data["BrandID"] = $this->input->post()["BrandID"];
		$data["BrandName"] = $this->input->post()["BrandName"];
		$data["CodeID"] = $this->input->post()["CodeID"];
		$this->load->view('TagManagements/pop_up_tag', $data);
	}

	public function ViewAllTagsPopUp() {
		$TagData = $this->input->post();
		$data["BrandID"] = $TagData["BrandID"];
		$data["BrandName"] = $TagData["BrandName"];
		$data["CodeID"] = $TagData["CodeID"];
		$data['data'] = $this->tag->selectTags($TagData["BrandID"]);
		$this->load->view('TagManagements/view_all', $data);	
	}
}