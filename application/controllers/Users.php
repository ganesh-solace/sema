
<?php

/***
	Controller : UsersController
	CreatedBy : Ankita
	CreatedDate : 26-09-2018
***/


if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// include('BaseController.php');

class Users extends CI_Controller {

	public function __construct(){
		parent::__construct();     
		$this->load->helper(array('url','html','form'));
		$this->load->library('template');
		$this->load->library(array('form_validation','session'));
		$this->load->model('User');
	}

	public function index() {
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
	
	// session logout
	public function logout() {
		if( isset( $this->session->userdata['logged_in'] )) {
			$this->session->sess_destroy();
			redirect("users");
		}
	
	}
}
