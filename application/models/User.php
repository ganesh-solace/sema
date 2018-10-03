<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Model{

   function __construct(){
      parent::__construct();
       $this->userTbl = 'users';
    }

        // set the rules for the complusory fields
        public function GetTheValidationFields() {
            $config = array(
                array(
                        'field' => 'Name',
                        'label' => 'Name',
                        'rules' => 'required',
                        'errors' => array(
                                'required' => 'You must provide a %s.',
                        ),
                ),
                array(
                        'field' => 'password',
                        'label' => 'password',
                        'rules' => 'required',
                        'errors' => array(
                                'required' => 'You must provide a %s.',
                        ),
                )
            );
            
            return $config;
        }

        // check the password for the same user
    public function processLogin( $UserName, $Password ) {
        $whereCondition = array( 'Name' => $UserName,'password'=>$Password);    
        $this->db->select( "ID, Name" );
        $this->db->from( $this->userTbl );              
        $this->db->where( $whereCondition );
        $UserResult = $this->db->get();

        if ($UserResult->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
    
}