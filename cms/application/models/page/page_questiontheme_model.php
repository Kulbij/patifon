<?php
require_once APPPATH.'models/base_model.php';
class Page_questiontheme_model extends CI_Model implements Base_model 
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
        return array();
    }
    
    //other functions
    public function selectPreviewAll() {
        
        $this->db->select('id, name_ru as name');
        $this->db->from('site_feedback_name');
        $res = $this->db->order_by('id', 'ASC')->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        return $res;
        
    }
    
    public function selectPage($id) {
            
        $this->db->select('*');
        $this->db->from('site_feedback_name');
        $this->db->where("id = '$id'")->limit(1);
        $res = $this->db->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        return $res;
        
    }
    
    public function save($array) {
        
        $this->db->set('name_ua', mb_substr($array['name_ua'], 0, 510));
        $this->db->set('name_ru', mb_substr($array['name_ru'], 0, 510));
        $this->db->set('name_en', mb_substr($array['name_en'], 0, 510));
        $this->db->set('name_pl', mb_substr($array['name_pl'], 0, 510));
        
        if (isset($array['id']) && is_numeric($array['id'])) {
            
            
            $this->db->where('id', $array['id']);
            $this->db->update('site_feedback_name');
            
            return $array['id'];
            
        } else {
            
            $this->db->insert('site_feedback_name');
            
            $objid = $this->db->insert_id();
            
            return $objid;
            
        }
        
        return false;
        
    }
    
    public function remove($id) {
        
        $id = (int)$id;
        
        if ($id > 0) {
            
            $this->db->where("id = '{$id}'")->limit(1)->delete('site_feedback_name');
            
        }
        
    }
    
}