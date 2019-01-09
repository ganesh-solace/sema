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
                    ),
                array(
                'field' => 'BrandCode[]',
                'label' => 'Brand Code',
                'rules' => 'required',
                'errors' => array(
                        'required' => 'You must provide a %s.',
                ),
        )
            );
            
            return $config;
        }


    // fetch the index data for all brands for listing
    public function GetbrandCodeViewData() {
        $this->db->select("BB.BrandCode, B.Name BrandName, B.ID, BB.ID CodeID,B.Description");
       
        $this->db->from("brands B");
        $this->db->join('brand_code_bridge BB', "B.ID = BB.BrandID","inner"); 
        $WhereCondition = array("BB.Status"=>1, "B.Status" =>1);
        $this->db->where($WhereCondition); 
        $query = $this->db->get();
        $BrandCodeData = $query->result_array();
        $num_rows = $query->num_rows();
       $ReturnCodeArr["BrandCodeData"] = $BrandCodeData;
       $ReturnCodeArr["Count"] = $num_rows;
       
       return $ReturnCodeArr;
    }

    // public function UpdateBrandCodeStatus($BrandID, $CodeID) {
       
    //    $CodeID =  explode(",",$CodeID);
    //     if(!empty($CodeID)){
    //         foreach ($CodeID as $key => $value) {
    //             $this->db->set('Status', '0');
    //             $Where = array("BrandID" => $BrandID,"ID"=>$value);
    //             $this->db->where($Where);
    //             $this->db->update('brand_code_bridge');
    //         }
    //     }
     
    // return true;
    // }

    // generarte the common brands array for edit delete and add
    public function GetCommonArray( $BrandData ) {
        $CommonData = array(
            "Name" => $BrandData["Name"],
            "ID" => $BrandData["ID"],
            "ShortName" => isset($BrandData["ShortName"])? $BrandData["ShortName"] : "",
            "SemaBrandAlias" => isset($BrandData["SemaBrandAlias"]) ? $BrandData["SemaBrandAlias"] : "",
            "Description" => isset($BrandData["Description"]) ? $BrandData["Description"] : "",
            "ClassID" => isset($BrandData["ClassID"]) ?$BrandData["ClassID"] : ""
        );

        return $CommonData;
    }

    //called from edit: post the data in edit case
    public function SaveData( $BrandData ) {
        $BrandCodeData = $BrandData["Brand"];
        
        $CommonData = $this->GetCommonArray($BrandData);       

        $this->UpdateBrand($CommonData);
        foreach ($BrandCodeData as $key => $value) {
            if($value["RowState"] == "435") {
                $this->addBrand($value, $CommonData,$CommonData["ID"]  );
            } else if($value["RowState"] == "437") { 
                if($value["CodeID"] != 0 ) {
                   $this->DeleteBrand($value["CodeID"], $CommonData );
                }
            } else if($value["RowState"] == "436") { 
                if($value["CodeID"] != 0 ) {
                   $this->UpdateEditBrand($value, $CommonData,$value["CodeID"],$CommonData["ID"]  );
                }
            } 

        }
    }

    // update the sema class bridge data
    public function UpdateEditBrand($NewData, $data, $CodeID, $BrandID) {
       
           $this->GenerateClassBrideData($NewData,$data,$CodeID,$BrandID );
    }

    // insert the brand code data 
    public function addBrand($NewData, $data, $BrandID) {
        $BrandID = (isset($data["ID"]) && !empty($data["ID"])) ? $data["ID"] : $BrandID;
        $InsertBrandArr = array(
            "BrandID" =>$BrandID,
            "BrandCode" =>$NewData["BrandCode"],
            "AppendBrandCode" =>$NewData["BrandCode"]."-".$data["Name"],
            "AppendBrandCode" =>$NewData["BrandCode"]."-".$data["Name"],
            "CreatedDate" =>date("Y-m-d H:i:s"),
            "ModifiedDate" =>date("Y-m-d H:i:s"),
            "Status" =>1
        );
        $this->db->insert('brand_code_bridge', $InsertBrandArr);
        $LastInsertID = $this->db->insert_id();

        $this->GenerateClassBrideData($NewData,$data,$LastInsertID,$BrandID );
       
    }

    // generate a brand class bridge data
    public function GenerateClassBrideData($NewData,$data,$LastInsertID, $BrandID )
    {
        $ClassArr =[];
        if(isset($data["ClassID"]) && !empty($data["ClassID"])){
            foreach ($data["ClassID"] as $key => $value) {
                $ClassArr[$key]["BrandID"] = $BrandID;
                $ClassArr[$key]["ClassID"] = $value;
                $ClassArr[$key]["BrandCodeID"] = $LastInsertID;
                $ClassArr[$key]["CreatedDate"] = date("Y-m-d H:i:s");
                $ClassArr[$key]["ModifiedDate"] =date("Y-m-d H:i:s");
                $ClassArr[$key]["Status"] = 1;
            }
            $this->db->insert_batch('sema_brand_class_bridge', $ClassArr);
        }
        

    }

    // delete brand set status to zero
    public function DeleteBrand($CodeID, $data) {
        $setData = array( "Status" => 0 );
        $Where = array("BrandID" => $data["ID"], "ID" => $CodeID);
        $this->db->where($Where);
        $this->db->set($setData);
        $this->db->update('brand_code_bridge');
    }

    // update brands data common for add, edit and delete case if change
    public  function UpdateBrand($data) {
        $setData = array(
            "Name" =>$data["Name"],
            "SemaBrandAlias"=> $data["SemaBrandAlias"],
            'Description'=>$data["Description"],
            'ShortName'=>$data["ShortName"],
            'ModifiedDate'=>date("Y-m-d H:i:s") 
        );
        $Where = array("ID" => $data["ID"]);
        $this->db->where($Where);
        $this->db->set($setData);
        $this->db->update('brands');
    }

    // add New brand this is add brand case
    public function AddNewBrand($data) {
        $CommonData = $CommonInsertData = $this->GetCommonArray($data);
        unset($CommonInsertData["ClassID"]);
        $CommonInsertData["CreatedDate"] = date("Y-m-d H:i:s"); 
        $CommonInsertData["ModifiedDate"] = date("Y-m-d H:i:s"); 
        $CommonInsertData["Status"] =1; 

        $this->db->insert('brands', $CommonInsertData);
        $LastInsertID = $this->db->insert_id();


        foreach ($data["Brand"] as $key => $value) {
            $this->addBrand($value, $CommonData, $LastInsertID );
        }
    }
  
}