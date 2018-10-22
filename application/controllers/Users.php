
<?php

/***
	Controller : UsersController
	CreatedBy : Ankita
	CreatedDate : 26-09-2018
***/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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
		if( isset( $this->session->userdata['logged_in'] ) ) {
			redirect('DashBoards');
		}
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
						'error_message' => 'Invalid Username or Password',
						"class" => "text-danger"
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
		redirect('DashBoards');
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

	public function ChangePassword() {
		$data = array();
		if( $this->input->method() == 'post') {
			$Password = $this->input->post()['Password'];
			$ConfirmPassword = $this->input->post()['ConfirmPassword'];	
			if( $Password == $ConfirmPassword ) {
				$flag = $this->User->UpdatePassword( $Password, $_SESSION["Email"], $_SESSION["UserName"] );
			
				unset($_SESSION["UserName"]);
				unset($_SESSION["Email"]);
				redirect('users');
			} else {
				$data = array(
						'error_message' => 'Password and confirm password does not match.',
						"class" => "text-danger"
				);
			}
		}
		$this->template->load('template','users/change_password', $data );
	}

	public function ResetPassword() {
		$data = array();
		if( $this->input->method() == 'post') {
			$Email = $this->input->post()["Email"];
			$UserName = $this->input->post()["UserName"];
		
			$ReturnCount = $this->MatchEmailUserData($Email, $UserName);
			if($ReturnCount->Cnt == 0) {
				$data = array(
						'error_message' => 'User Name and Email does not match',
						"class" => "text-danger"
				);
			} 
			else {
				$_SESSION["Email"] = $Email;
				$_SESSION["UserName"] = $UserName;
				redirect("users/ChangePassword");
				// 
			}
			// if( $this->sendMail( $this->input->post() ) ) {
			// 	$data = array(
			// 			'error_message' => 'Check email to get reset password.',
			// 			"class" => "text-danger"
			// 		);
			// } else {
			// 	$data = array(
			// 			'error_message' => 'server error please try after sometime.',
			// 			"class" => "text-danger"
			// 		);
			// }			
				
		}
		$this->template->load('template','users/reset', $data);
	}

	public function MatchEmailUserData( $Email, $UserName ) {
		$fields = array( "Count(ID) Cnt" );
		$whereCondition = array(
			"Email" => $Email,
			"LOWER(Name)" => strtolower( $UserName ),
			"Status" => 1 
		);
		$result = $this->SelectQuery('users', $fields, $whereCondition, 1);
		
		return $result[0];
	}


	 // public function sendMail( $data ) {	
		// require FCPATH.'assests/PHPMailer/src/Exception.php';
		// require FCPATH.'assests/PHPMailer/src/PHPMailer.php';
		// require FCPATH.'assests/PHPMailer/src/SMTP.php';


		// $mail = new PHPMailer;
		// try {
		// 	$mail->isSMTP();                                      // Set mailer to use SMTP
		// 	$mail->SMTPDebug = SMTP::DEBUG_SERVER;
		// 	$mail->SMTPDebug = 2; //Alternative to above constant
		// 	$mail->Host = '18.214.233.21';  // Specify main and backup SMTP servers
		// 	$mail->SMTPAuth = true;                               // Enable SMTP authentication
		// 	$mail->Username = 'ankitad@solacetechnologies.co.in';                 // SMTP username
		// 	$mail->Password = 'Ankit@*123';                           // SMTP password
		// 	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		// 	$mail->Port = 587;      

		// 	$email = $data['Email'];
			
		// 	$passwordplain = "";
		// 	$passwordplain  = rand(999999999,9999999999);
		// 	$newpass['password'] = md5($passwordplain);

		// 	$mail_message='Dear Customer,'. "\r\n";
		// 	$mail_message.='Thanks for contacting regarding to forgot password,<br> Your <b>Password</b> is <b>'.$passwordplain.'</b>'."\r\n";
		// 	$mail_message.='<br>Please Update your password.';
		// 	$mail_message.='<br>Thanks & Regards';
		// 	$mail_message.='<br>Your company name';        
		// 	date_default_timezone_set('Etc/UTC');

		// 	$mail->isHTML(true);   
		// 	$mail->addAddress($email);
		// 	$mail->Subject = 'OTP from company';
		// 	$mail->Body    = $mail_message;
		// 	$mail->AltBody = $mail_message;

		// 	if (!$mail->send()) {
		// 		$this->session->set_flashdata('msg','Failed to send password, please try again!');
		// 		echo "string";exit();
		// 		return false;
		// 	} else {
		// 		$this->session->set_flashdata('msg','Password sent to your email!');
		// 		echo "s232";exit();
		// 		return true;
		// 	}
		// } catch (Exception $e) {
		// 	print_r($e);exit();
		// 	echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		// }
	
		// 	// redirect(base_url().'user/Login','refresh');        
		// }
	

	
}
