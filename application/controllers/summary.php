<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('BaseController.php');
class Summary extends BaseController {

	public function __construct() {
        parent::__construct();
        $this->load->model("SummaryModel", "summary");
    }

    public function index() {
        parent::index();
        $data = array();
        $id = 1;
        $data["brand_data"] = $this->summary->get_brand_summary_by_id($id);
        $data["seller_list"] = $this->summary->get_associte_seller_list($id);
        // $this->template->view("summary", $data);
        
		$this->template->load('template','summary',$data);
    }
}
