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
        // unset($_SESSION["seller"]);
        // print_r($this->input->post());exit;
        $data = $this->Seller->getPriceAdjustmentEnumData();        
        $id = ( isset( $_SESSION["seller"] ) && !empty( $_SESSION["seller"] )) ? $_SESSION["seller"]["SellerID"] : $this->input->post()['id'];
        $BrandID = ( isset( $_SESSION["seller"] ) && !empty( $_SESSION["seller"] )) ? $_SESSION["seller"]["BrandID"] : $this->input->post()['BrandID'];
         $CodeID = ( isset( $_SESSION["seller"] ) && !empty( $_SESSION["seller"] )) ? $_SESSION["seller"]["CodeID"] : $this->input->post()['CodeID'];
        $data["BrandName"] = ( isset( $_SESSION["seller"] ) && !empty( $_SESSION["seller"] )) ? $_SESSION["seller"]["BrandName"] : $this->input->post()['BrandName'];
        
        // unset($_SESSION["seller"]);
        $data["ExistingData"] = $this->getExistingPriceAdjustmentData( $id, $BrandID );
        $data["DataFeed"] = $this->JPDataFedd( $id, $BrandID)[0]->DataFeed;
        // $data["BrandData"] = $this->Summary->getBrandSummaryByID( $BrandID );
         $data["BrandData"] = $this->Summary->getBrandCodeSummaryByID( $BrandID, $CodeID );
        $data["LastDataRefresh"] = $this->Summary->lastDataRefresh( $BrandID )[0];
        $data['SellerData'] = $this->GetSellerData( $id ); 
        $data['Last15ImportData'] = $this->GetLastImportHistory15( $id, $BrandID );
         $LastSuccessImportHistory = $this->LastSuccessImportHistory( $id, $BrandID );
         $data['LastSuccessImportHistory'] = ( isset( $LastSuccessImportHistory ) && !empty( $LastSuccessImportHistory )) ? $LastSuccessImportHistory[0] : ""; 
		$this->template->load('template','sellers/seller',$data);        
    }

    public function LastSuccessImportHistory( $SellerID, $BrandID ) {
         $whereCondition = array("BrandID" => $BrandID, "SellerID" => $SellerID, "Status" => 1);
         $orderBy = array('field' => "LastSuccessImport,ID", "Type" => "DESC");
        $LastSuccessImportData = $this->SelectQuery('seller_brands_jp_update_data', "LastSuccessImport",$whereCondition,1, $orderBy);

        return $LastSuccessImportData;    
    }

    public function GetLastImportHistory15( $SellerID, $BrandID ) {
         $whereCondition = array("BrandID" => $BrandID, "SellerID" => $SellerID, "Status" => 1);
         $orderBy = array('field' => "LastSuccessImport,ID", "Type" => "DESC");
        $Last15ImportData = $this->SelectQuery('seller_brands_jp_update_data', "LastSuccessImport",$whereCondition,15, $orderBy);

        return $Last15ImportData;    
    }

    // Index: get existing data from adjustment table
     public function getExistingPriceAdjustmentData( $SellerID, $BrandID ) {
        $whereCondition = array("BrandID" => $BrandID, "SellerID" => $SellerID, "Status" => 1);
        $BridgeDataResult = $this->SelectQuery('brand_price_adjustment_bridge', "*",$whereCondition);

        return $BridgeDataResult;
    }

    // get the DataFeed file name 
    public function JPDataFedd( $SellerID, $BrandID ) {
         $whereCondition = array("SellerID" => $SellerID, "BrandID" => $BrandID, "Status" => 1 );
        $DataFeed = $this->SelectQuery('brand_seller_bridge', "DataFeed", $whereCondition ) ;

        return $DataFeed;
    }

    //Index: get seller data for seller dashboard
    public function GetSellerData( $id ) {
        $whereCondition = array("ID" => $id );
        $SellerData = $this->SelectQuery('sellers', '*, REPLACE(LastName,"-","") LastName', $whereCondition ) ;

        return $SellerData;
    }

    //Post action: pop up for price adjustment 
    public function PriceAdjustment() {
        $AdjustmentData = $this->input->post();   
          
        $DataCount = $this->CheckDataExistsInAdjustment( $AdjustmentData['BrandID'],$AdjustmentData['SellerID'] ,$AdjustmentData['CodeID']  );        
        // print_r($DataCount);exit;
        if($DataCount > 0 ) {
            $this->deleteAdjustmentRecords( $AdjustmentData['BrandID'],$AdjustmentData['SellerID'],$AdjustmentData['CodeID'] );
        }

        $PriceAdjustmentArr = $this->GeneratePriceAdjustmentData( $AdjustmentData ); 
        unset($_SESSION["seller"]);       
        $_SESSION["seller"]["BrandName"] = $PriceAdjustmentArr["BrandName"];
        unset( $PriceAdjustmentArr["BrandName"] );
        unset($PriceAdjustmentArr["CodeID"]);
        $flag = $this->Seller->InsertPriceAdjustmentData( $PriceAdjustmentArr );
        if( $flag ) {
            $_SESSION["seller"]["SellerID"] = $PriceAdjustmentArr["SellerID"];
            $_SESSION["seller"]["BrandID"] = $PriceAdjustmentArr["BrandID"];            
            $_SESSION["seller"]["CodeID"] = $PriceAdjustmentArr["BrandCodeID"];
            redirect("sellers");
        } 
    }

     //PriceAdjustment:  check count if data exists in adjustment table for current combination of brandID and sellerID
    public function CheckDataExistsInAdjustment( $BrandID, $SellerID, $CodeID ) {
        $whereCondition = array( "BrandID" => $BrandID, "SellerID" => $SellerID, "BrandCodeID" => $CodeID,"Status" => 1 );
        $DataCount = $this->SelectQuery('brand_price_adjustment_bridge', "COUNT(ID) DataCount", $whereCondition ) ;

        return $DataCount[0]->DataCount;
    }

    // PriceAdjustment: update the records in adjustment table before insert a new row
    public function deleteAdjustmentRecords( $BrandID, $SellerID, $CodeID ) {
        $data = array('Status'=>  0 );
        $where = array("BrandID"=> $BrandID, "SellerID"=> $SellerID, "BrandCodeID"=> $CodeID, 'Status'=>  1 );
        $this->db->where($where);
        $flag = $this->db->update('brand_price_adjustment_bridge', $data);
        return true;
    }

    // PriceAdjustment: generate the data for price adjustment seller brand bridge table
    public function GeneratePriceAdjustmentData( $AdjustmentData ) {
        $PriceAdjustmentArr = array();        
        $TransactionDetails = $this->getTransactionDetails();
        $PriceAdjustmentArr = $AdjustmentData;
        $PriceAdjustmentArr["BrandCodeID"] = $AdjustmentData["CodeID"];
        $PriceAdjustmentArr['CreatedDate'] = $TransactionDetails['CreatedDate'];
        $PriceAdjustmentArr['ModifiedDate'] = $TransactionDetails['ModifiedDate'];
        $PriceAdjustmentArr['Status'] = $TransactionDetails['Status'];
        
        unset($PriceAdjustmentArr['Submit']);

        return $PriceAdjustmentArr;
    }

    //Ajax Associate Seller :get seller ID for the multi-check in associate seller page
    public function AjaxgetSellerID() {
        $BrandID = $this->input->post()['BrandID'];
        $CodeID = $this->input->post()['CodeID'];
        $whereCondition = array("BrandID" => $BrandID,"BrandCodeID" => $CodeID, "Status" => 1);
        $data["SellerID"] = $this->SelectQuery('brand_seller_bridge', 'GROUP_CONCAT(SellerID) SellerID', $whereCondition );
        echo json_encode( $data );exit;
    }

    //Form action Associate seller page: display associate seller pop up form on dashboard and save functionality
    public function AssociateSellerDashboard() {
        // print_r($this->input->post());exit;
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
             $_SESSION["summary"]["CodeID"] = $this->input->post()["CodeID"];
             redirect("summary");          
         }
         $data = $this->loadAssociateSellerTemplateData( "AssociateSellerSummary" );

        $data["BrandID"] = ($this->input->method() == 'post' ) ? $this->input->post()["BrandID"] : 0 ;
        $data["CodeID"] = ($this->input->method() == 'post' ) ? $this->input->post()["CodeID"] : 0 ;
       $this->load->view ( 'sellers/associate_seller',$data );
        
    }

    public function loadAssociateSellerTemplateData( $action ) {
        //  $BrandList = $this->getBrandList();
        $BrandList = $this->getRecentBrandListWithCode();
        $SellerList = $this->getJPSellerList();
        $data["BrandList"] = $BrandList;
        $data["SellerList"] = $SellerList;
        $data["action"] = $action;
        return $data;
    }

    	public function getRecentBrandListWithCode() {
			$whereCondition = array("BCB.Status" => 1);
			$this->db->select( "B.ID, B.Name BrandName, BCB.ID BrandCodeID, BCB.AppendBrandCode" );
			$this->db->from( "brands B" );
			$this->db->join('`brand_code_bridge` BCB', 'B.ID = BCB.BrandID', 'inner');
			$this->db->where( $whereCondition ); 
			$this->db->order_by("B.ID", "DESC");
			$query = $this->db->get();
			$BrandData = $query->result();
			$BrandDataArr =array();
			foreach ($BrandData as $BrandKey => $BrandValue) {
				$BrandDataArr[$BrandValue->ID]["BrandName"]["value"] = $BrandValue->ID;
				$BrandDataArr[$BrandValue->ID]["BrandName"]["text"] = $BrandValue->BrandName;
				$BrandDataArr[$BrandValue->ID]["BrandCode"][$BrandKey]["value"] = $BrandValue->BrandCodeID;
				$BrandDataArr[$BrandValue->ID]["BrandCode"][$BrandKey]["text"] = $BrandValue->AppendBrandCode;
				
			}
			$BrandDataArr = array_values($BrandDataArr);
			return $BrandDataArr;
		}



    public function AssociateSellerSave( $SellerData ) {   
        // print_r($SellerData["CodeID"]);exit;    
        $this->deleteRecordsForBrandID( $SellerData["BrandID"], $SellerData["CodeID"] );            
        $SellerPostDataArr = $this->GenerateBrandSellerBridgeData( $SellerData );
        $flag= $this->db->insert_batch( 'brand_seller_bridge' , $SellerPostDataArr );
        return true;
    }

    //AssociateSeller: if alreay brandID is in database then update the status of previous records
    public function deleteRecordsForBrandID( $BrandID, $CodeID ) {
       $BrandCount =  $this->Seller->BrandRecordsExistsCheck( $BrandID, $CodeID );
       $flag = false;
       if( $BrandCount > 0 ) {
            $data = array('Status'=>  0 );
            $where = array("BrandID"=> $BrandID, "BrandCodeID"=> $CodeID  );
            $this->db->where($where);
            $flag = $this->db->update('brand_seller_bridge', $data);
       }
       return $flag;
    }

    // AssociateSeller: generate the Brand seller brdige table data
    public function GenerateBrandSellerBridgeData( $SellerData ) { 
        $PostArr = array();   
        $TransactionDetails = $this->getTransactionDetails();
        // $BrandName = $this->Seller->GetBrandName( $SellerData["BrandID"] );
        $DataForDataFeed = $this->Seller->GetBrandNameCode( $SellerData["BrandID"], $SellerData["CodeID"] );
        foreach ($SellerData['SellerID'] as $SellerKey => $SellerValue) {
            $PostArr[$SellerKey]['SellerID'] = $SellerValue;
            $SellerName = $this->Seller->GetSellerName( $SellerValue );
            $PostArr[$SellerKey]['BrandID'] = $SellerData["BrandID"]; 
            $PostArr[$SellerKey]['BrandCodeID'] = $SellerData["CodeID"];           
            $BrandNameDataFeed = str_replace(" ", "_", $DataForDataFeed["AppendBrandCode"]);
            $PostArr[$SellerKey]['DataFeed'] = $DataForDataFeed["AppendBrandCode"]."_".$SellerName.".csv";
            $PostArr[$SellerKey]['CreatedDate'] = $TransactionDetails["CreatedDate"];
            $PostArr[$SellerKey]['ModifiedDate'] = $TransactionDetails["ModifiedDate"];
            $PostArr[$SellerKey]['Status'] =  $TransactionDetails["Status"];
            $PostArr[$SellerKey]['CreatedBy'] =  $TransactionDetails["CreatedBy"];
            $PostArr[$SellerKey]['ModifiedBy'] =  $TransactionDetails["ModifiedBy"];
            $PostArr[$SellerKey]['ModifiedBy'] =  $TransactionDetails["ModifiedBy"];
            
        }
        return $PostArr;
    }

    // ajax call Seller page: update the data feed file
    public function UpdateDataFeedFile() {
        $BrandID = $this->input->post()["BrandID"];
        $SellerID = $this->input->post()["SellerID"];
        $CodeID = $this->input->post()["CodeID"];
        $DataFeed = $this->input->post()["DataFeed"];

        $data = array( 'DataFeed'=> $DataFeed );
        $where = array( "BrandID"=> $BrandID, "SellerID"=> $SellerID, "BrandCodeID"=> $CodeID, 'Status'=>  1 );
        $this->db->where( $where );
        $flag = $this->db->update( 'brand_seller_bridge', $data );
        if($flag) {
           echo json_encode($DataFeed);exit;
        }
        echo json_encode(" ");exit;
        // return $flag;
    }


    // Seller pop up contact form :modal contact form post function 
    public function SellerContactDetails() {
        $SellerID = $this->input->post()['SellerID'];
        $BrandID = $this->input->post()['BrandID'];
        $SellerData = $this->GetSellerData( $SellerID );
        $data = array();
        $data["SellerData"] = $SellerData[0];
        $this->load->view ( 'sellers/seller_contact', $data );
    }
   
}
