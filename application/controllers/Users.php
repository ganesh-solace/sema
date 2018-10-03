
<?php

/***
	Controller : UsersController
	CreatedBy : Ankita
	CreatedDate : 26-09-2018
***/


if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include('BaseController.php');

class Users extends BaseController {

	public function __construct(){
		parent::__construct();
		$this->load->model('User');
	}

	public function index() {
		parent::index();		
		$this->template->load('template','users/login');
	}

	public function login() {
		if($this->input->method() == 'post') {
		 	$this->signIn();
		 } 
	}	  

	public function signIn() {

		$UserName = trim( $this->input->post( 'Name' ) );
		$Password = md5( trim( $this->input->post( 'password' ) ) );	

		$config = $this->User->GetTheValidationFields();
		$this->form_validation->set_rules($config);

		if( $this->form_validation->run() == false ) {			
			$this->template->load('template','users/login');
		} else {
			$result = $this->User->processLogin( $UserName, $Password );
			if( $result ) {				
				$this->SessionData(  $UserName, $Password );
				
			} else {
				$data = array(
						'error_message' => 'Invalid Username or Password'
				);
				$this->template->load('template','users/login', $data);

			}
		}
	}

	public function SessionData( $UserName, $Password ) {
	
		$whereCondition = array( 'Name' => $UserName,'password'=> $Password, 'Status'=> 1);
		$UserData = $this->SelectQuery($this->User->userTbl, '*', $whereCondition);
	    
		if( $UserData ) {
			$SessionData = array(
				'ID' => $UserData[0]->ID,
				'UserName' => $UserData[0]->Name,
				'Email' => $UserData[0]->Email
			);
		}

		$this->session->set_userdata('logged_in', $SessionData);
		redirect('dashboards');
	}

}
