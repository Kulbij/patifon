<?php

class Page_share_cat_model extends CI_Model {
    function __construct() {
     parent::__construct();
    }
    
    //other functions
    public function selectPreviewAll($page = 0, $count = 0, $cat = 0) {
     if ($page == 0 || $page == 1) $page = 0;
     else $page = ($page * $count) - $count;
     
     $this->db->select('id, link, name'.$this->config->item('config_default_lang').' as name, visible');
     $this->db->from('site_share_cat');
     
     $this->db->order_by('position', 'ASC');
     
     if ($count > 0) $this->db->limit($count, $page);
     
     $res = $this->db->get();
     
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    
    public function countProduct($cat = 0) {
     $this->db->select('COUNT(*) as count')->from('site_share_cat');
     $res = $this->db->get();
     if ($res->num_rows() <= 0) return 0;
     $res = $res->row_array();
     return $res['count'];
    }
    
    public function selectPage($id) {
     $this->db->select('*');
     $this->db->from('site_share_cat');
     $this->db->where("id = '$id'")->limit(1);
     $res = $this->db->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    
    public function saveArtical($array) {
     
     if (isset($array['art_img']['image']) && !empty($array['art_img']['image'])) {
      if (isset($array['id'])) {
       $res = $this->db->select('image')->from('site_share_cat')->where('id = '.$this->db->escape($array['id']))->limit(1)->get();
       if ($res->num_rows() > 0) {
        $res = $res->row_array();
        $this->load->library('image_my_lib');
        $this->image_my_lib->delImage($res['image']);
       }
      }
      
      $this->db->set('image', $array['art_img']['image']);
     }
     
     foreach ($this->config->item('config_languages') as $value) {
      if (isset($array['name'.$value]))
       $this->db->set('name'.$value, $array['name'.$value]);
      
     }
     
     $objectid = 0;
     
     if (isset($array['id']) && is_numeric($array['id'])) {
      
      if (isset($array['visible'])) $this->db->set('visible', $array['visible']);
      
      if ($array['manual']) $this->db->set('link', $array['link']);
      else {
       if (isset($array['link']) && !empty($array['link'])) {
        $pos = strrpos($array['link'], '-'.$array['id']);
        if ($pos !== false) $array['link'] = substr($array['link'], 0, $pos);
       }
       $this->db->set('link', rtrim($array['link'], '-').'-'.$array['id']);
      }
      $this->db->set('manual', $array['manual']);
      
      $objectid = $array['id'];
      $this->db->where('id = '.$this->db->escape($objectid))->update('site_share_cat');
     } else {
      
      if ($array['manual']) $this->db->set('link', $array['link']);
      $this->db->set('manual', $array['manual']);
      
      $this->db->set('visible', 1);
      
      $this->db->insert('site_share_cat');
      $objectid = $this->db->insert_id();
      
      if (!$array['manual']) $this->db->set('link', rtrim($array['link'], '-').'-'.$objectid);
      $this->db->set('position', $objectid)->where('id = '.$this->db->escape($objectid))->limit(1)->update('site_share_cat');
      
     }
     
     return $objectid;
    }
    
    public function deleteArt($id) {
     
     $id = (int)$id;
     if ($id <= 0) return false;
     
     $res = $this->db->select('id')->from('site_share')->where('catid = '.$this->db->escape($id))->get();
     if ($res->num_rows() > 0) {
      $res = $res->result_array();
      
      $this->load->model('page/page_share_model');
      foreach ($res as $value) $this->page_share_model->deleteArt($value['id']);
     }
     
     $res = $this->db->select('image')->from('site_share_cat')->where('id = '.$this->db->escape($id))->limit(1)->get();
     if ($res->num_rows() <= 0) return false;
     $res = $res->row_array();
     $this->load->library('image_my_lib');
     $this->image_my_lib->delImage($res['image']);
     
     $this->db->where('id = '.$this->db->escape($id))->limit(1)->delete('site_share_cat');
    }
    
    public function setVis($id) {
     $this->db->set('visible', 1)->where("id = '$id'")->limit(1)->update('site_share_cat');
    }
    
    public function setUnVis($id) {
     $this->db->set('visible', 0)->where("id = '$id'")->limit(1)->update('site_share_cat');
    }
    
    public function setUp($id) {
     $res = $this->db->select('position')->from('site_share_cat')->where('id = '.$this->db->escape($id))->limit(1)->get();
     if ($res->num_rows() <= 0) return false;
     $pos = $res->row_array();
     
     $res = $this->db->select('id, position')->from('site_share_cat')->where("position < '{$pos['position']}'")->limit(1)->order_by('position', 'DESC')->get();
     if ($res->num_rows() <= 0) return false;
     $res = $res->row_array();
     
     $this->db->set('position', $res['position'])->where('id = '.$this->db->escape($id))->update('site_share_cat');
     $this->db->set('position', $pos['position'])->where('id = '.$this->db->escape($res['id']))->update('site_share_cat');
    }
    
    public function setDown($id) {
     $res = $this->db->select('position')->from('site_share_cat')->where('id = '.$this->db->escape($id))->limit(1)->get();
     if ($res->num_rows() <= 0) return false;
     $pos = $res->row_array();
     
     $res = $this->db->select('id, position')->from('site_share_cat')->where('position > '.$this->db->escape($pos['position']))->limit(1)->order_by('position', 'ASC')->get();
     if ($res->num_rows() <= 0) return false;
     $res = $res->row_array();
     
     $this->db->set('position', $res['position'])->where('id = '.$this->db->escape($id))->update('site_share_cat');
     $this->db->set('position', $pos['position'])->where('id = '.$this->db->escape($res['id']))->update('site_share_cat');
    }
    
}