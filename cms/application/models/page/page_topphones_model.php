<?php

class Page_topphones_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }
    
    //other functions
    public function selectPreviewAll() {
        
        $this->db->select('id, phone, visible');
        $this->db->from('site_phone');
        $res = $this->db->order_by('position', 'ASC')->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        return $res;
        
    }
    
    public function selectPage($id) {
            
        $this->db->select('*');
        $this->db->from('site_phone');
        $this->db->where("id = '{$id}'")->limit(1);
        $res = $this->db->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        return $res;
        
    }
    
    public function saveFooter($array) {
        
        foreach ($this->config->item('config_languages') as $value) {
         if (isset($array['name'.$value]))
          $this->db->set('name'.$value, $array['name'.$value]);
         
        }
         
        if (isset($array['visible_onhead'])) $this->db->set('visible_onhead', $array['visible_onhead']);
        else $this->db->set('visible_onhead', 1);
        
        if (isset($array['visible_ontop'])) $this->db->set('visible_ontop', $array['visible_ontop']);
        else $this->db->set('visible_ontop', 1);
        
        if (isset($array['visible_onfoot'])) $this->db->set('visible_onfoot', $array['visible_onfoot']);
        else $this->db->set('visible_onfoot', 1);
        
        if (isset($array['mobile'])) $this->db->set('mobile', $array['mobile']);
        else $this->db->set('mobile', 1);
        
        if (isset($array['id']) && $array['id'] > 0) {
            
            $this->db->set('phone', $array['phone']);
            $this->db->set('paket', $array['phones_packet']);
            $this->db->where('id', $array['id']);
            $this->db->update('site_phone');
            
            if (isset($array['image']) && !empty($array['image'])) {
             
             $res = $this->db->select('image')->from('site_phone')->where("id = '{$array['id']}'")->limit(1)->get();
             
             if ($res->num_rows() > 0) {
              
              $res = $res->row_array();
              
              $this->load->library('image_my_lib');
              if (isset($res['image']) && !empty($res['image'])) {
               
               $this->image_my_lib->delImage($res['image']);
               
              }
             }
             
             $this->db->set('image', $array['image']);
             $this->db->where('id', $array['id']);
             $this->db->update('site_phone');
             
            }
            
            return $array['id'];
            
        } else {
            
            if (isset($array['image'])) $this->db->set('image', $array['image']);
            $this->db->set('phone', $array['phone']);
            $this->db->set('visible', 1);
            $this->db->insert('site_phone');
            
            $objid = $this->db->insert_id();
            
            $this->db->set('position', $objid)->where("id = '{$objid}'")->update('site_phone');
            
            return $objid;
            
        }
        
        return false;
        
    }
    
    public function setVis($id) {
        
        $id = (int)$id;
        
        if ($id > 0) {
            
            $this->db->set('visible', 1)->where("id = '{$id}'")->update('site_phone');
            
        }
        
    }
    
    public function setUnVis($id) {
        
        $id = (int)$id;
        
        if ($id > 0) {
            
            $this->db->set('visible', 0)->where("id = '{$id}'")->update('site_phone');
            
        }
        
    }
    
    public function setUp($id) {
        
        $res = $this->db->select('position')->from('site_phone')->where("id = '$id'")->limit(1)->get();
        $res = $res->row_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res;
        
        $res = $this->db->select('id, position')->from('site_phone')->where("position < '{$pos['position']}'")->limit(1)->order_by('position', 'DESC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '$id'")->update('site_phone');
        $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_phone');
        
    }
    
    public function setDown($id) {
        
        $res = $this->db->select('position')->from('site_phone')->where("id = '$id'")->limit(1)->get();
        $res = $res->row_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res;
        
        $res = $this->db->select('id, position')->from('site_phone')->where("position > '{$pos['position']}'")->limit(1)->order_by('position', 'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '$id'")->update('site_phone');
        $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_phone');
        
    }
    
    public function remove($id) {
        
        $id = (int)$id;
        
        if ($id > 0) {
            
            $image = $this->db->select('image')->from('site_phone')->where('id = '.$this->db->escape($id))->limit(1)->get();
            if ($image->num_rows() <= 0) return false;
            $image = $image->row_array();
            
            $this->load->library('image_my_lib');
            $this->image_my_lib->delImage($image['image']);
            
            $this->db->where("id = '{$id}'")->limit(1)->delete('site_phone');
            
        }
        
    }
    
}