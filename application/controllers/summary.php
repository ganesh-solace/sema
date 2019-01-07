<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('BaseController.php');
class Summary extends BaseController {

	public function __construct() {
        parent::__construct();
        $this->load->model("SummaryModel", "summary");
    }

    public function index() {
        //  unset($_SESSION["summary"]);
        $id = isset( $_SESSION["summary"] ) ? $_SESSION["summary"]["BrandID"] : $this->input->post()["id"];
        $CodeID = isset( $_SESSION["summary"] ) ? $_SESSION["summary"]["CodeID"] : $this->input->post()["CodeID"];
       
        // $data["BrandData"] = $this->summary->getBrandSummaryByID( $id );
        $data["BrandData"] = $this->summary->getBrandCodeSummaryByID( $id, $CodeID );
        $LastDataRefresh = $this->summary->lastDataRefresh( $id )[0];
        if( isset( $LastDataRefresh ) ) {
            $Time = date("h:i:s A", strtotime($LastDataRefresh['LastDataRefresh'] ) );
            $LastDataRefresh = date("F d, Y", strtotime($LastDataRefresh['LastDataRefresh'] ) )." at ".$Time;
            $data["LastDataRefresh"] = $LastDataRefresh;
        }
       
        // $data["seller_list"] = $this->summary->getAssociateSellerListOnly( $id );      
        $data["seller_list"] = $this->summary->getAssociateSellerListCode( $id, $CodeID );        
        // $data["NumberOfAssociateSeller"] = $this->summary->NumberOfAssociateSeller( $id );        
        $data["NumberOfAssociateSeller"] = $this->summary->NumberOfAssociateSellerCode( $id, $CodeID );
        $data["TitleDisplayData"] = $this->GetFieldValues( $id, $CodeID )["TitleDisplayData"];
        // print_r($data);exit;
        $this->template->load('template','summary',$data);	
        
    }

    public function SetDisplayTitle() {
        $data = array();
        $data["TitleData"] = $this->GetFieldValues($this->input->post()["BrandID"], $this->input->post()["CodeID"])["TitleData"];
        $data["TitleDisplayData"] = $this->GetFieldValues($this->input->post()["BrandID"], $this->input->post()["CodeID"])["TitleDisplayData"];
        $data["BrandID"] = $this->input->post()["BrandID"];
        $data["CodeID"] = $this->input->post()["CodeID"];
        $this->load->view ( 'brands/set_title',$data );
    }

    public function PostDisplayTitle() {
        $BrandID = $this->input->post()["BrandID"];
        $ID = $this->input->post()["ID"];
        $Title = $this->input->post()["Title"];
        $TitleValues = $this->summary->GetTitleValues($Title);
        // print_r($Title);exit;
        $WhereCondition = array("BrandID" =>$BrandID, "ID" => $ID, "Status" => 1);

        $this->db->set('BrandTitle', $Title);
        $this->db->set('BrandTitleValues', $TitleValues["jp_fields"]);
        $this->db->where( $WhereCondition );
        $this->db->update('brand_code_bridge');
        $_SESSION["summary"]["BrandID"] = $BrandID;
        $_SESSION["summary"]["CodeID"] = $ID;
        redirect("summary");
    }

    public function GetFieldValues($BrandID, $CodeID) {
        $whereCondition = array("Status" => 1);
       $TitleData = $this->SelectQuery('title_configuration', "value,text", $whereCondition ); 
       $where = array("BrandID" => $BrandID, "ID" => $CodeID, 'Status' => 1 ); 
       $TitleDisplayData = $this->SelectQuery('brand_code_bridge', "BrandTitle", $where );
       $TitleArray["TitleData"] = $TitleData;
       $TitleArray["TitleDisplayData"] = $TitleDisplayData;
       return $TitleArray;
    }
}
