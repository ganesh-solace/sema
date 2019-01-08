<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TagManagement extends CI_Model{

    function __construct(){
        parent::__construct();
        // $this->userTbl = 'brands';
    }

    public function insertTags($data){
        $this->db->insert( 'tag_management', $data );
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    public function selectTags($BrandID){
        
        $this->db->select();
        $this->db->from('tag_management');
        $this->db->where('BrandID', $BrandID);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();

    }


    public function deleteTag($id){
        $this->db->where('id', $id);
        return $this->db->delete('tag_management');
    }

    public function editTag($id){
        $this->db->select();
        $this->db->where('id', $id);
        $this->db->from('tag_management');
        $query = $this->db->get();
        return $query->result();
    }

    public function updateTags(){
        $id = $this->input->post('id');
        unset( $_POST['id'] );
        $this->db->where('id',$id);
        return $this->db->update('tag_management', $_POST);
    }
}