<?php

class Page_indexban_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    //other functions
    public function selectPreviewAll() {
        
        $ind = $this->db->select('id, image, position')->from('site_indexban')->order_by('position', 'ASC')->get();
        
        if ($ind->num_rows() <= 0) return array();
        
        $ind = $ind->result_array();
        
        return $ind;
        
    }
    
    public function selectPage($id) {
        
        if (is_null($id)) return array();

        $this->db->select('id, image, link, position');
        $this->db->from('site_indexban');
        $this->db->where("id = '$id'");
        $res = $this->db->limit(1)->get();

        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        return $res;
        
    }
    
    //position page
    public function setUp($id) {
        
        $res = $this->db->select('position')->from('site_indexban')->where("id = '$id'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res[0]['position'];
        
        $res = $this->db->select('id, position')->from('site_indexban')->where("position < '$pos'")->limit(1)->order_by('position', 'DESC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '$id'")->update('site_indexban');
        $this->db->set('position', $pos)->where("id = '{$res[0]['id']}'")->update('site_indexban');
        
    }
    
    public function setDown($id) {
        
        $res = $this->db->select('position')->from('site_indexban')->where("id = '$id'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res[0]['position'];
        
        $res = $this->db->select('id, position')->from('site_indexban')->where("position > '$pos'")->limit(1)->order_by('position', 'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '$id'")->update('site_indexban');
        $this->db->set('position', $pos)->where("id = '{$res[0]['id']}'")->update('site_indexban');
        
    }
    
    public function saveIndexImg($array) {
        
        $this->db->set('link', $array['link']);
        
        if (isset($array['id']) && is_numeric($array['id']) && !empty($array['image']) && !is_null($array['image'])) {
            
            $res = $this->db->select('image')->from('site_indexban')->where("id = '{$array['id']}'")->limit(1)->get();
            if ($res->num_rows() <= 0) return false;
            
            $res = $res->row_array();
            
            $this->load->library('image_my_lib');
            $this->image_my_lib->delImage($res['image']);
            
        }
        
        if (!empty($array['image']) && !is_null($array['image'])) {
            
            $this->db->set('image', $array['image']);
            
        }
        
        $objectid = 'http';
        
        if (isset($array['id'])) {
            
            $this->db->where("id = '{$array['id']}'")->update('site_indexban');
            
            $objectid = $array['id'];
            
        } else {
            
            $this->db->insert('site_indexban');
            $objectid = $this->db->insert_id();
            
            $this->db->set('position', $objectid)->where("id = '{$objectid}'")->update('site_indexban');
            
        }
        
        return $objectid;
        
    }
    //---end SAVE PAGE
    
    function delImage($id) {
        
        $image = $this->db->select('image')->from('site_indexban')->where("id = '$id'")->limit(1)->get();
        
        if ($image->num_rows() <= 0) return false;
        
        $image = $image->result_array();
        
        $image = $image[0]['image'];
        
        $this->db->where("id = '$id'")->delete('site_indexban');
        
        $this->load->library('image_my_lib');
        $this->image_my_lib->delImage($image);
        
    }
    
}