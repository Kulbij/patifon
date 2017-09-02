<?php

class Catalog_color_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function setVisible($id) {
        $this->db->set('visible', 1);
        $this->db->where("id = '{$id}'")->update('site_files');
    }
    
    public function setUnVisible($id) {
        $this->db->set('visible', 0);
        $this->db->where("id = '{$id}'")->update('site_files');
    }
    
    //position page
    public function setUp($id) {
     $res = $this->db->select('pageid, position')->from('site_files')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $pos = $res[0];
     
     $res = $this->db->select('id, position')->from('site_files')->where("position < '{$pos['position']}' AND pageid = '{$pos['pageid']}'")->limit(1)->order_by('position', 'DESC')->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_files');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_files');
    }
    
    public function setDown($id) {
     $res = $this->db->select('pageid, position')->from('site_files')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $pos = $res[0];
     
     $res = $this->db->select('id, position')->from('site_files')->where("position > '{$pos['position']}' AND pageid = '{$pos['pageid']}'")->limit(1)->order_by('position', 'ASC')->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_files');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_files');
    }
    
    //other functions
    public function selectPreviewAll($from, $count, $pageid = 0) {
        
        if ($from == 1 || $from == 0) $from = 0;
        else {
            $from = ($count * $from) - $count;
        }
        
        $this->db->select('id, name_ru as name, visible, position');
        
        if ($pageid > 0) $this->db->where('pageid = '.$this->db->escape($pageid));
        
        $this->db->from('site_files');
        $res = $this->db->order_by('position', 'ASC')->limit($count, $from)->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        return $res;
        
    }
    
    public function getCount($pageid = 0) {
        
        $this->db->select('COUNT(*) as count')->from('site_files');
        
        if ($pageid > 0) $this->db->where('pageid = '.$this->db->escape($pageid));
        
        $res =$this->db->get();
        if ($res->num_rows() <= 0) return 0;
        
        $res = $res->result_array();
        
        return $res[0]['count'];
        
    }
    
    public function selectPage($id) {

        if ($id <= 0) return array();
        
        $this->db->select('*');
        $this->db->from('site_files');
        $this->db->where("id = '{$id}'");
        $res = $this->db->limit(1)->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        return $res;
        
    }
    
    //---SAVE PAGE region
    
    public function savePage($array) {
        
        $objectid = 0;
        
        if (isset($array['pageid'])) $this->db->set('pageid', $array['pageid']);
        
        foreach ($this->config->item('config_languages') as $value) {
         $this->db->set('name'.$value, $array['name'.$value]);
        }
        
        if (isset($array['id']) && is_numeric($array['id'])) {
            
            if (isset($array['file']) && !empty($array['file'])) {
                
                $this->load->library('image_my_lib');
                
                $res = $this->db->select('file')->from('site_files')->where("id = '{$array['id']}'")->limit(1)->get();
        
                if ($res->num_rows() > 0) {

                    $res = $res->row_array();
                    
                    if (isset($res['file']) && !empty($res['file'])) {

                        
                        $this->image_my_lib->delImage('public/files/'.$res['file']);
                    
                    }
                    /*
                    if (isset($res['image_big']) && !empty($res['image_big'])) {
                        $this->image_my_lib->delImage($res['image_big']);
                    
                    }*/
                
                }
            
                $this->db->set('file', $array['file']);
                #if (isset($array['img']['image_big']) && !empty($array['img']['image_big'])) $this->db->set('image_big', $array['img']['image_big']);
            
            }
            
            $this->db->where("id = '{$array['id']}'")->update('site_files');
            $objectid = $array['id'];
            
        } else {
            
            if (isset($array['file']) && !empty($array['file'])) $this->db->set('file', $array['file']);
            #if (isset($array['img']['image_big']) && !empty($array['img']['image_big'])) $this->db->set('image_big', $array['img']['image_big']);
            $this->db->insert('site_files');
            $objectid = $this->db->insert_id();
            
            $this->db->set('position', $objectid)->where('id = '.$this->db->escape($objectid))->limit(1)->update('site_files');
            
        }
        
        return $objectid;
        
    }
    //---end SAVE PAGE
    
    public function deleteV($id) {
        
        $res = $this->db->select('file')->from('site_files')->where("id = '{$id}'")->limit(1)->get();
        
        if ($res->num_rows() <= 0) return false;
        
        $res = $res->row_array();
        
        $this->load->library('image_my_lib');
        $this->image_my_lib->delImage($res['file']);
        
        $this->db->where("id = '{$id}'")->limit(1)->delete('site_files');
        
    }
    
    public function getFID() {
     $this->load->model('page/page_page_model');
     return $this->page_page_model->selectPreviewAll(0, 0, false);
    }
    public function getSID() {
     return array();
     $res = $this->db->select('id, name')->from('site_catalog_shade')->order_by('name', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    
}