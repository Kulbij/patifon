<?php
require_once APPPATH.'models/base_model.php';
class Page_footer_model extends CI_Model implements Base_model 
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
            
            foreach ($this->config->item('config_languages') as $value) {
             if (isset($data[$i]['text'.$value])) $out[$i]['footer'.$value] = $data[$i]['text'.$value];
            }
            
        }
        return $out;
        
    }
    
    //other functions
    public function selectPreviewAll() {
        
        $this->db->select('id');
        $this->db->from('site_footer');
        $res = $this->db->order_by('id', 'ASC')->get();
        return $this->FormData($res);
        
    }
    
    public function selectPage($id) {
            
        $this->db->select('*');        
        $this->db->from('site_footer');
        $this->db->where("id = '$id'")->limit(1);
        $res = $this->db->get();
        return $this->FormData($res);
        
    }
    
    public function saveFooter($array) {
     
     if (isset($array['id']) && is_numeric($array['id'])) {
      
      foreach ($this->config->item('config_languages') as $value) {
       
       if (isset($array['footer'.$value]))
        $this->db->set('text'.$value, $array['footer'.$value]);
       
      }
      
      $this->db->where('id', $array['id']);
      $this->db->update('site_footer');
      
      return true;
     }
     
     return false;
     
    }
    
}