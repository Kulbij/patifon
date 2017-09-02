<?php
require_once APPPATH.'models/base_model.php';
class Page_leftpage_model extends CI_Model implements Base_model 
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
        
        $this->db->select('id, link, name, position, visible');        
        $this->db->from('site_leftpage');
        $res = $this->db->order_by('position' ,'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        return $res;
        
    }
    
    public function selectPage($link) {
            
        $this->db->select('id, link, name, text, title, keyword, description, visible');        
        $this->db->from('site_leftpage');
        $this->db->where("link = '$link'");
        $res = $this->db->limit(1)->get();
        $res = $res->result_array();

        if (count($res) <= 0) return array();

        return $res;
        
    }
    
    //visible page
    public function setVisible($id) {
        $this->db->set('visible', 1);
        $this->db->where("id = '$id'")->update('site_leftpage');
    }
    
    public function setUnVisible($id) {
        $this->db->set('visible', 0);
        $this->db->where("id = '$id'")->update('site_leftpage');
    }
    
    //position page
    public function setUp($id) {
        
        $res = $this->db->select('position')->from('site_leftpage')->where("id = '$id'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res[0]['position'];
        
        $res = $this->db->select('id, position')->from('site_leftpage')->where("position < '$pos'")->limit(1)->order_by('position', 'DESC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '$id'")->update('site_leftpage');
        $this->db->set('position', $pos)->where("id = '{$res[0]['id']}'")->update('site_leftpage');
        
    }
    
    public function setDown($id) {
        
        $res = $this->db->select('position')->from('site_leftpage')->where("id = '$id'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res[0]['position'];
        
        $res = $this->db->select('id, position')->from('site_leftpage')->where("position > '$pos'")->limit(1)->order_by('position', 'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '$id'")->update('site_leftpage');
        $this->db->set('position', $pos)->where("id = '{$res[0]['id']}'")->update('site_leftpage');
        
    }
    
    //---SAVE PAGE region
    
    public function savePage($array) {
            
        $this->db->set('name', $array['name']);
        
        if ($array['link'] != 'bestproposition') $this->db->set('text', $array['text']);
        
        $this->db->set('title', $array['title']);
        $this->db->set('keyword', $array['keyword']);
        $this->db->set('description', $array['description']);
        $this->db->set('visible', $array['visible']);
        $this->db->where("link = '{$array['link']}'")->update('site_leftpage');
        
        return true;
        
    }
    //---end SAVE PAGE
    
}