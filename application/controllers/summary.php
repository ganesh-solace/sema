<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('BaseController.php');
class Summary extends BaseController {

	public function __construct() {
        parent::__construct();
        $this->load->model("SummaryModel", "summary");
    }

    public function index() {
        $id = $this->input->post()["id"];
        $data["BrandData"] = $this->summary->getBrandSummaryByID( $id );
        $data["seller_list"] = $this->summary->getAssociateSellerList( $id );        
        $data["NumberOfAssociateSeller"] = $this->summary->NumberOfAssociateSeller( $id );
        $this->template->load('template','summary',$data);	
        
    }
}
