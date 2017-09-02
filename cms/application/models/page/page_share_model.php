<?php

class Page_share_model extends CI_Model {
    function __construct() {
     parent::__construct();
    }
    
    //other functions
    public function selectPreviewAll($page, $count, $cat = 0) {
     if ($page == 0 || $page == 1) $page = 0;
     else $page = ($page * $count) - $count;
     
     $this->db->select('site_share.id, site_share.link, site_share.date, site_share.name'.$this->config->item('config_default_lang').' as name, site_share.visible');
     $this->db->from('site_share');
     
     if ($cat > 0) $this->db->where('catid = '.$this->db->escape($cat));
     
     $res = $this->db->order_by('site_share.date', 'DESC')->limit($count, $page)->get();
     
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    
    public function getCats() {
     
     $this->load->model('page/page_share_cat_model');
     $res = $this->page_share_cat_model->selectPreviewAll();
     return $res;
    }
    
    public function countProduct($cat = 0) {
     $this->db->select('COUNT(*) as count')->from('site_share');
     
     if ($cat > 0) $this->db->where('catid = '.$this->db->escape($cat));
     
     $res = $this->db->get();
     if ($res->num_rows() <= 0) return 0;
     $res = $res->row_array();
     return $res['count'];
    }
    
    public function selectPage($id) {
     $this->db->select('*');
     $this->db->from('site_share');
     $this->db->where("id = '$id'")->limit(1);
     $res = $this->db->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    
    public function saveArtical($array) {
     
     if (isset($array['art_img']['image']) && !empty($array['art_img']['image'])) {
      if (isset($array['id'])) {
       $res = $this->db->select('image, image_big')->from('site_share')->where('id = '.$this->db->escape($array['id']))->limit(1)->get();
       if ($res->num_rows() > 0) {
        $res = $res->row_array();
        $this->load->library('image_my_lib');
        $this->image_my_lib->delImage($res['image']);
        #$this->image_my_lib->delImage($res['image_big']);
       }
      }
      
      $this->db->set('image', $array['art_img']['image']);
      #if (isset($array['art_img']['image_big']) && !empty($array['art_img']['image_big'])) $this->db->set('image_big', $array['art_img']['image_big']);
     }
     
     if (isset($array['catid'])) $this->db->set('catid', $array['catid']);
     
     foreach ($this->config->item('config_languages') as $value) {
      if (isset($array['name'.$value]))
       $this->db->set('name'.$value, $array['name'.$value]);
      
      if (isset($array['title'.$value]))
       $this->db->set('title'.$value, $array['title'.$value]);
      
      if (isset($array['keyword'.$value]))
       $this->db->set('keyword'.$value, $array['keyword'.$value]);
      
      if (isset($array['description'.$value]))
       $this->db->set('description'.$value, $array['description'.$value]);
      
      if (isset($array['shorttext'.$value]))
       $this->db->set('shorttext'.$value, $array['shorttext'.$value]);
      
      if (isset($array['text'.$value]))
       $this->db->set('text'.$value, $array['text'.$value]);
      
     }
     
     $this->db->set('date', $array['date']);
     
     $objectid = 0;
     
     if (isset($array['id']) && is_numeric($array['id'])) {
      $objectid = $array['id'];
      
      if ($array['manual']) $this->db->set('link', $array['link']);
      else {
       if (isset($array['link']) && !empty($array['link'])) {
        $pos = strrpos($array['link'], '-'.$array['id']);
        if ($pos !== false) $array['link'] = substr($array['link'], 0, $pos);
       }
       $this->db->set('link', rtrim($array['link'], '-').'-'.$array['id']);
      }
      $this->db->set('manual', $array['manual']);
      
      if (isset($array['visible'])) $this->db->set('visible', $array['visible']);
      
      $this->db->where('id = '.$this->db->escape($objectid))->update('site_share');
     } else {
      
      if ($array['manual']) $this->db->set('link', $array['link']);
      $this->db->set('manual', $array['manual']);
      
      $this->db->set('visible', 1);
      
      $this->db->insert('site_share');
      $objectid = $this->db->insert_id();
      
      if (!$array['manual']) {
       $this->db->set('link', rtrim($array['link'], '-').'-'.$objectid);
       $this->db->where("id = '{$objectid}'")->update('site_share');
      }
      
     }
     
     return $objectid;
    }
    
    public function deleteArt($id) {
     
     $id = (int)$id;
     if ($id <= 0) return false;
     
     $res = $this->db->select('image, image_big')->from('site_share')->where('id = '.$this->db->escape($id))->limit(1)->get();
     if ($res->num_rows() <= 0) return false;
     $res = $res->row_array();
     $this->load->library('image_my_lib');
     $this->image_my_lib->delImage($res['image']);
     $this->image_my_lib->delImage($res['image_big']);
     $this->db->where('id = '.$this->db->escape($id))->delete('site_share');
    }
    
    public function setVis($id) {
     $this->db->set('visible', 1)->where("id = '$id'")->update('site_share');
    }
    
    public function setUnVis($id) {
     $this->db->set('visible', 0)->where("id = '$id'")->update('site_share');
    }
    
}