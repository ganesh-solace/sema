<?php 
/***
    Model : Brand 
    CreatedBy : Ankita
    CreatedDate : 28-09-2018
***/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends CI_Model{

   function __construct(){
      parent::__construct();
       $this->userTbl = 'brands';
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
                )
            );
            
            return $config;
        }
}