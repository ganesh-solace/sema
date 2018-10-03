<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary extends CI_Controller {

	 public function __construct() {
    	parent::__construct();     
		$this->load->helper(array('url','html','form'));
    }


    public function index() {
        $this->load->view("summary");
    }

}
