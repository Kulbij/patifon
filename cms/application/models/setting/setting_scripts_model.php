<?php
require_once APPPATH.'models/base_model.php';
class Setting_scripts_model extends CI_Model implements Base_model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    //CRUD
    public function selectAll() {
        return false;
    }
    
    public function selectById($id) {
        return false;
    }
    
    public function removeById($id) {
        return false;
    }
    
    public function updateById($id, $data) {
        return false;
    }
    
    public function insert($data) {
        return false;
    }
    //--end CRUD
    
    //formed data
    public function FormData($data) {
        $data = $data->result_array();
        
        $out = array();
        
        $count_ = count($data);
        for ($i = 0; $i < $count_; ++$i) {
            if (isset($data[$i]['id'])) $out[$i]['id'] = $data[$i]['id'];
            if (isset($data[$i]['script'])) $out[$i]['option'] = $data[$i]['script'];
            
        }
        return $out;
        
    }
    
    //other functions
    public function selectPreviewAll() {
        
        $this->db->select('*');        
        $this->db->from('site_script');
        $res = $this->db->get();
        return $this->FormData($res);
        
    }
    
    public function selectScript($id) {
            
        $this->db->select('*');        
        $this->db->from('site_script');
        $this->db->where("id = '$id'")->limit(1);
        $res = $this->db->get();
        return $this->FormData($res);
        
    }
    
    public function saveOption($array) {
        
        $id = 0;
        
        $this->db->set('script', $array['option']);
        
        if (isset($array['id']) && is_numeric($array['id'])) {
            $this->db->where("id = '{$array['id']}'")->update('site_script');
            $id = 'http';
        }
        else {
            $this->db->insert('site_script');
            $id = $this->db->insert_id();
        }
        
        return $id;
        
    }
    
    public function delOption($id) {
        
        $this->db->where("id = '$id'")->delete('site_script');
        
    }
    
}