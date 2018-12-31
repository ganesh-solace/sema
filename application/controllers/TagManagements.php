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

	public function submitForm(){
		$insertid = $this->tag->insertTags( $_POST );
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
}