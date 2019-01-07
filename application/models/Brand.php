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

    public function UpdateBrandCodeStatus($BrandID, $CodeID) {
       
       $CodeID =  explode(",",$CodeID);
        if(!empty($CodeID)){
            foreach ($CodeID as $key => $value) {
                $this->db->set('Status', '0');
                $Where = array("BrandID" => $BrandID,"ID"=>$value);
                $this->db->where($Where);
                $this->db->update('brand_code_bridge');
            }
        }
     
    return true;
    }

    public function GetCodeBridgeData( $id ) {
            $this->db->select("*");       
            $this->db->from("brand_code_bridge BB");
            $WhereCondition = array("BB.Status"=>1, "BB.Status" =>1);
            $this->db->where($WhereCondition); 
            $query = $this->db->get();
            $BrandCodeData = $query->result_array();
           
            return $BrandCodeData;
    }

    public function EditDataPostDB($data) {
        
        $BrandCodeDBData = $this->GetCodeBridgeData($data["ID"]);
        $BrandDataArr  = array();        
        $this->BrandDataUpDate($data);
        $ArrayStatus = array_combine ($data["BrandCode"], $data["CodeID"]);
        foreach ($ArrayStatus as $key => $value) {
            if($value == 0 ) {
                $BrandDataArr[$key]["ID"] = 0;
                $BrandDataArr[$key]["BrandID"] =$data["ID"];
                $BrandDataArr[$key]["BrandCode"] = $key;
                $BrandDataArr[$key]["AppendBrandCode"] = $key."-".$data["Name"];
                $BrandDataArr[$key]['CreatedDate'] = date("Y-m-d H:i:s");   
                $BrandDataArr[$key]['ModifiedDate'] = date("Y-m-d H:i:s");   
                $BrandDataArr[$key]['Status'] = 1;   
                $BrandDataArr = array_values($BrandDataArr);
           
                $this->db->insert_batch( "brand_code_bridge" , $BrandDataArr );
                $LastInsertID  = $this->db->insert_id();
                foreach ($data["ClassID"] as $Ckey => $Cvalue) {
                    $BrandClassDataArr  = array();
                    $BrandClassDataArr[$Ckey]["ID"] = 0;
                    $BrandClassDataArr[$Ckey]["BrandID"] =$data["ID"];
                    $BrandClassDataArr[$Ckey]["ClassID"] = $Cvalue;
                    $BrandClassDataArr[$Ckey]["BrandCodeID"] = $LastInsertID;
                    $BrandClassDataArr[$Ckey]['CreatedDate'] = date("Y-m-d H:i:s");   
                    $BrandClassDataArr[$Ckey]['ModifiedDate'] = date("Y-m-d H:i:s");   
                    $BrandClassDataArr[$Ckey]['Status'] = 1;
                    $this->db->insert_batch( "sema_brand_class_bridge" , $BrandClassDataArr ); 
                    unset($BrandClassDataArr);  
                }
            }
            
            // else {
            //     foreach ($BrandCodeDBData as $Brandkey => $Brandvalue) {
            //         //  echo "<-->";
            //         $BrandDataArrs = array();
            //         if (in_array($value, $Brandvalue)) {
            //             print_r($value);
            //             $BrandDataArrs["ID"] = $value;
            //             $BrandDataArrs["BrandID"] =$data["ID"];
            //             $BrandDataArrs["BrandCode"] = $key;
            //             $BrandDataArrs["AppendBrandCode"] = $key."-".$data["Name"];
            //             $BrandDataArrs['CreatedDate'] = date("Y-m-d H:i:s");   
            //             $BrandDataArrs['ModifiedDate'] = date("Y-m-d H:i:s");   
            //             $BrandDataArrs['Status'] = 1;  
            //             $this->db->set($BrandDataArrs);
            //             $Where = array("BrandID" => $data["ID"],"ID"=>$value);
            //             $this->db->where($Where);
            //             $this->db->update('brand_code_bridge');
            //             unset($BrandDataArrs);  

            //             foreach ($data["ClassID"] as $Ckey => $Cvalue) {
            //                 $BrandClassDataArr  = array();
            //                 $BrandClassDataArr[$Ckey]["ID"] = 0;
            //                 $BrandClassDataArr[$Ckey]["BrandID"] =$data["ID"];
            //                 $BrandClassDataArr[$Ckey]["ClassID"] = $Cvalue;
            //                 $BrandClassDataArr[$Ckey]["BrandCodeID"] = $value;
            //                 $BrandClassDataArr[$Ckey]['CreatedDate'] = date("Y-m-d H:i:s");   
            //                 $BrandClassDataArr[$Ckey]['ModifiedDate'] = date("Y-m-d H:i:s");   
            //                 $BrandClassDataArr[$Ckey]['Status'] = 1;
            //                 // $this->db->insert_batch( "sema_brand_class_bridge" , $BrandClassDataArr ); 
            //                 unset($BrandClassDataArr);  
            //             }
            //         } else {
            //           echo "<-->";  print_r($value);
            //             $this->db->set('Status', '0');
            //             $Where = array("BrandID" => $data["ID"],"ID"=>$value);
            //             $this->db->where($Where);
            //             $this->db->update('brand_code_bridge');
            //         }                   
            //     }
            // }exit;
        }

    }

    public function BrandDataUpDate( $data ) {
        $setData = array(
            "Name" =>$data["Name"],
            "SemaBrandAlias"=> $data["SemaBrandAlias"],
            'Description'=>$data["Description"],
            'ModifiedDate'=>date("Y-m-d H:i:s") 
        );
        $Where = array("ID" => $data["ID"]);
        $this->db->where($Where);
        $this->db->set($setData);
        $this->db->update('brands');
    }
}