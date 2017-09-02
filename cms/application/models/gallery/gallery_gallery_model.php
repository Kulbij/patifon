<?php

class Gallery_gallery_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    //other functions
    public function selectPreviewAll($catid = 0) {
        
        $catid = (int)$catid;
        
        $this->db->select('id, image, visible, image_big');
        $this->db->from('site_gallery');
        
        if ($catid > 0) $this->db->where("catid = '{$catid}'");
        
        $res = $this->db->order_by('position', 'ASC')->get();
        
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        return $res;
        
    }
    
    public function countProduct($catid = 0) {
        
        $catid = (int)$catid;
        
        $this->db->select('COUNT(*) as count')->from('site_gallery');
        
        if ($catid > 0) $this->db->where("catid = '{$catid}'");
        
        $res = $this->db->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return 0;
        
        return $res[0]['count'];
        
    }
    
    public function getCategories() {
        
        $this->load->model('gallery/gallery_gallerycat_model');
        return $this->gallery_gallerycat_model->selectPreviewAll();
        
        $res = $this->db->select('id, name_ua as name')->from('site_gallerycat')->order_by('position', 'ASC')->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        return $res;
        
    }
    
    public function save($array, $catid = 0) {
        
        $catid = (int)$catid;
        if ($catid < 0) return $catid = 0;
        
        $return = array();
        
        if (isset($array['image']) && !empty($array['image']) && isset($array['image_big']) && !empty($array['image_big'])) {
            
            $this->db->set('catid', $catid);
            $this->db->set('image', $array['image']);
            $this->db->set('image_big', $array['image_big']);
            $this->db->set('visible', 1);
            $this->db->insert('site_gallery');
            
            $objid = $this->db->insert_id();
            
            $this->db->set('position', $objid);
            $this->db->where("id = '{$objid}'")->update('site_gallery');
            
            $return['id'] = $objid;
            $return['image'] = $array['image'];
            $return['image_big'] = $array['image_big'];
            $return['visible'] = 1;
            $return['position'] = $objid;
            
        }
        
        return $return;
        
    }
    
    public function remove($id) {
        
        $id = (int)$id;
        if ($id <= 0) return false;
        
        $res = $this->db->select('image, image_big')->from('site_gallery')->where("id = '{$id}'")->limit(1)->get();
        
        if ($res->num_rows() == 1) {
            
            $res = $res->result_array();
            
            $this->load->library('image_my_lib');
            $this->image_my_lib->delImage($res[0]['image']);
            $this->image_my_lib->delImage($res[0]['image_big']);
            
        }
        
        $this->db->where("id = '{$id}'")->delete('site_gallery');
        
        return true;
        
    }
    
    public function setVis($id) {
        
        $this->db->set('visible', 1)->where("id = '{$id}'")->update('site_gallery');
        
    }
    
    public function setUnVis($id) {
        
        $this->db->set('visible', 0)->where("id = '{$id}'")->update('site_gallery');
        
    }
    
    //position page
    public function setUp($id) {
        
        $res = $this->db->select('catid, position')->from('site_gallery')->where("id = '{$id}'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res[0];
        
        $res = $this->db->select('id, position')->from('site_gallery')->where("position < '{$pos['position']}' AND catid = '{$pos['catid']}'")->limit(1)->order_by('position', 'DESC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_gallery');
        $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_gallery');
        
    }
    
    public function setDown($id) {
        
        $res = $this->db->select('catid, position')->from('site_gallery')->where("id = '{$id}'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res[0];
        
        $res = $this->db->select('id, position')->from('site_gallery')->where("position > '{$pos['position']}' AND catid = '{$pos['catid']}'")->limit(1)->order_by('position', 'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_gallery');
        $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_gallery');
        
    }
    //end
    
    public function getFirstCatID() {
        
        $res = $this->db->select('id')->from('site_gallerycat')->order_by('position', 'ASC')->limit(1)->get();
        
        if ($res->num_rows() <= 0) return 0;
        
        $res = $res->result_array();
        return $res[0]['id'];
        
    }
    
}