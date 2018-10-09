<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('BaseController.php');
class Sellers extends BaseController {

	 public function __construct() {
        parent::__construct();
        $this->load->model("SellerModel", "Seller");
        $this->load->model("SummaryModel", "Summary");
    }

    public function index() {
        parent::index();
        $data = $this->Seller->getPriceAdjustmentEnumData();        
        $id = ( isset( $_SESSION["seller"] ) && !empty( $_SESSION["seller"] )) ? $_SESSION["seller"]["SellerID"] : $this->input->post()['id'];
        $BrandID = ( isset( $_SESSION["seller"] ) && !empty( $_SESSION["seller"] )) ? $_SESSION["seller"]["BrandID"] : $this->input->post()['BrandID'];
        $data["BrandName"] = ( isset( $_SESSION["seller"] ) && !empty( $_SESSION["seller"] )) ? $_SESSION["seller"]["BrandName"] : $this->input->post()['BrandName'];

        // unset($_SESSION["seller"]);
        $data["ExistingData"] = $this->getExistingPriceAdjustmentData( $id, $BrandID);
        $data["BrandData"] = $this->Summary->getBrandSummaryByID( $BrandID );
        $data['SellerData'] = $this->GetSellerData( $id );   

		$this->template->load('template','sellers/seller',$data);        
    }

    // Index: get existing data from adjustment table
     public function getExistingPriceAdjustmentData( $SellerID, $BrandID ) {
        $whereCondition = array("BrandID" => $BrandID, "SellerID" => $SellerID, "Status" => 1);
        $BridgeDataResult = $this->SelectQuery('brand_price_adjustment_bridge', "*",$whereCondition);

        return $BridgeDataResult;
    }

    //Index: get seller data for seller dashboard
    public function GetSellerData( $id ) {
        $whereCondition = array("ID" => $id );
        $SellerData = $this->SelectQuery('sellers', "*", $whereCondition ) ;

        return $SellerData;
    }

    //Post action: pop up for price adjustment 
    public function PriceAdjustment() {
        $AdjustmentData = $this->input->post();       
        $DataCount = $this->CheckDataExistsInAdjustment( $AdjustmentData['BrandID'],$AdjustmentData['SellerID'] );        
        if($DataCount > 0 ) {
            $this->deleteAdjustmentRecords( $AdjustmentData['BrandID'],$AdjustmentData['SellerID'] );
        }

        $PriceAdjustmentArr = $this->GeneratePriceAdjustmentData( $AdjustmentData ); 
        unset($_SESSION["seller"]);       
        $_SESSION["seller"]["BrandName"] = $PriceAdjustmentArr["BrandName"];
        unset( $PriceAdjustmentArr["BrandName"] );

        $flag = $this->Seller->InsertPriceAdjustmentData( $PriceAdjustmentArr );
        if( $flag ) {
            $_SESSION["seller"]["SellerID"] = $PriceAdjustmentArr["SellerID"];
            $_SESSION["seller"]["BrandID"] = $PriceAdjustmentArr["BrandID"];
            redirect("sellers");
        } 
    }

     //PriceAdjustment:  check count if data exists in adjustment table for current combination of brandID and sellerID
    public function CheckDataExistsInAdjustment( $BrandID, $SellerID ) {
        $whereCondition = array( "BrandID" => $BrandID, "SellerID" => $SellerID,"Status" => 1 );
        $DataCount = $this->SelectQuery('brand_price_adjustment_bridge', "COUNT(ID) DataCount", $whereCondition ) ;

        return $DataCount[0]->DataCount;
    }

    // PriceAdjustment: update the records in adjustment table before insert a new row
    public function deleteAdjustmentRecords( $BrandID, $SellerID ) {
        $data = array('Status'=>  0 );
        $where = array("BrandID"=> $BrandID, "SellerID"=> $SellerID, 'Status'=>  1 );
        $this->db->where($where);
        $flag = $this->db->update('brand_price_adjustment_bridge', $data);

        return true;
    }

    // PriceAdjustment: generate the data for price adjustment seller brand bridge table
    public function GeneratePriceAdjustmentData( $AdjustmentData ) {
        $PriceAdjustmentArr = array();        
        $TransactionDetails = $this->getTransactionDetails();
        $PriceAdjustmentArr = $AdjustmentData;
        $PriceAdjustmentArr['CreatedDate'] = $TransactionDetails['CreatedDate'];
        $PriceAdjustmentArr['ModifiedDate'] = $TransactionDetails['ModifiedDate'];
        $PriceAdjustmentArr['Status'] = $TransactionDetails['Status'];
        unset($PriceAdjustmentArr['Submit']);

        return $PriceAdjustmentArr;
    }

    //Ajax Associate Seller :get seller ID for the multi-check in associate seller page
    public function AjaxgetSellerID() {
        $BrandID = $this->input->post()['BrandID'];
        $whereCondition = array("BrandID" => $BrandID, "Status" => 1);
        $data["SellerID"] = $this->SelectQuery('brand_seller_bridge', 'GROUP_CONCAT(SellerID) SellerID', $whereCondition );
        echo json_encode( $data );exit;
    }

    //Form action Associate seller page: display associate seller pop up form on dashboard and save functionality
    public function AssociateSellerDashboard() {
         if( $this->input->method() == 'post' && ( !isset( $this->input->post()['action'] ) ) ) {
            $this->AssociateSellerSave( $this->input->post() );
             redirect("DashBoards");          
         }
          $data = $this->loadAssociateSellerTemplateData( 'AssociateSellerDashboard' );
       $this->load->view ( 'sellers/associate_seller',$data );
        
    }

    //Form action Associate seller page : display associate seller pop up form on summary page and save functionality
       public function AssociateSellerSummary() {
         if( $this->input->method() == 'post' && ( !isset( $this->input->post()['action'] ) ) ) {
            $this->AssociateSellerSave( $this->input->post() );
            $_SESSION["summary"]["BrandID"] = $this->input->post()["BrandID"];
             redirect("summary");          
         }
         $data = $this->loadAssociateSellerTemplateData( "AssociateSellerSummary" );

        $data["BrandID"] = ($this->input->method() == 'post' ) ? $this->input->post()["BrandID"] : 0 ;
       $this->load->view ( 'sellers/associate_seller',$data );
        
    }

    public function loadAssociateSellerTemplateData( $action ) {
         $BrandList = $this->getBrandList();
        $SellerList = $this->getSellerList();
        $data["BrandList"] = $BrandList;
        $data["SellerList"] = $SellerList;
        $data["action"] = $action;
        return $data;
    }

    public function AssociateSellerSave( $SellerData ) {           
        $this->deleteRecordsForBrandID( $SellerData["BrandID"] );            
        $SellerPostDataArr = $this->GenerateBrandSellerBridgeData( $SellerData );
        $flag= $this->db->insert_batch( 'brand_seller_bridge' , $SellerPostDataArr );
        return true;
    }

    //AssociateSeller: if alreay brandID is in database then update the status of previous records
    public function deleteRecordsForBrandID( $BrandID ) {
       $BrandCount =  $this->Seller->BrandRecordsExistsCheck( $BrandID );
       $flag = false;
       if( $BrandCount > 0 ) {
            $data = array('Status'=>  0 );
            $where = array("BrandID"=> $BrandID );
            $this->db->where($where);
            $flag = $this->db->update('brand_seller_bridge', $data);
       }
       return $flag;
    }

    // AssociateSeller: generate the Brand seller brdige table data
    public function GenerateBrandSellerBridgeData( $SellerData ) { 
        $PostArr = array();   
        $TransactionDetails = $this->getTransactionDetails();
        foreach ($SellerData['SellerID'] as $SellerKey => $SellerValue) {
            $PostArr[$SellerKey]['SellerID'] = $SellerValue;
            $PostArr[$SellerKey]['BrandID'] = $SellerData["BrandID"];
            $PostArr[$SellerKey]['CreatedDate'] = $TransactionDetails["CreatedDate"];
            $PostArr[$SellerKey]['ModifiedDate'] = $TransactionDetails["ModifiedDate"];
            $PostArr[$SellerKey]['Status'] =  $TransactionDetails["Status"];
            $PostArr[$SellerKey]['CreatedBy'] =  $TransactionDetails["CreatedBy"];
            $PostArr[$SellerKey]['ModifiedBy'] =  $TransactionDetails["ModifiedBy"];
        }
        return $PostArr;
    }
    
}
