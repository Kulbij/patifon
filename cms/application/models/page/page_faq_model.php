<?php

class Page_faq_model extends CI_Model {
    function __construct() {
     parent::__construct();
    }
    
    //other functions
    public function selectPreviewAll($page = 0, $count = 0, $cat = 0) {
     if ($page == 0 || $page == 1) $page = 0;
     else $page = ($page * $count) - $count;
     
     $this->db->select('id, question, visible');
     $this->db->from('site_faq');
     
     $this->db->order_by('position', 'ASC');
     
     if ($count > 0) $this->db->limit($count, $page);
     
     $res = $this->db->get();
     
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    
    public function countProduct($cat = 0) {
     $this->db->select('COUNT(*) as count')->from('site_faq');
     $res = $this->db->get();
     if ($res->num_rows() <= 0) return 0;
     $res = $res->row_array();
     return $res['count'];
    }
    
    public function selectPage($id) {
     $this->db->select('*');
     $this->db->from('site_faq');
     $this->db->where("id = '$id'")->limit(1);
     $res = $this->db->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    
    public function saveArtical($array) {
     
     foreach ($this->config->item('config_languages') as $value) {
      if (isset($array['question'.$value]))
       $this->db->set('question'.$value, $array['question'.$value]);
      
      if (isset($array['answer'.$value]))
       $this->db->set('answer'.$value, $array['answer'.$value]);
      
     }
     
     if (isset($array['visible'])) $this->db->set('visible', $array['visible']);
     
     $objectid = 0;
     
     if (isset($array['id']) && is_numeric($array['id'])) {
      $objectid = $array['id'];
      $this->db->where('id = '.$this->db->escape($objectid))->update('site_faq');
     } else {
      $this->db->insert('site_faq');
      $objectid = $this->db->insert_id();
      
      $this->db->set('position', $objectid)->where('id = '.$this->db->escape($objectid))->limit(1)->update('site_faq');
      
     }
     
     return $objectid;
    }
    
    public function deleteArt($id) {
     $this->db->where('id = '.$this->db->escape($id))->limit(1)->delete('site_faq');
    }
    
    public function setVis($id) {
     $this->db->set('visible', 1)->where("id = '$id'")->limit(1)->update('site_faq');
    }
    
    public function setUnVis($id) {
     $this->db->set('visible', 0)->where("id = '$id'")->limit(1)->update('site_faq');
    }
    
    public function setUp($id) {
     $res = $this->db->select('position')->from('site_faq')->where('id = '.$this->db->escape($id))->limit(1)->get();
     if ($res->num_rows() <= 0) return false;
     $pos = $res->row_array();
     
     $res = $this->db->select('id, position')->from('site_faq')->where("position < '{$pos['position']}'")->limit(1)->order_by('position', 'DESC')->get();
     if ($res->num_rows() <= 0) return false;
     $res = $res->row_array();
     
     $this->db->set('position', $res['position'])->where('id = '.$this->db->escape($id))->update('site_faq');
     $this->db->set('position', $pos['position'])->where('id = '.$this->db->escape($res['id']))->update('site_faq');
    }
    
    public function setDown($id) {
     $res = $this->db->select('position')->from('site_faq')->where('id = '.$this->db->escape($id))->limit(1)->get();
     if ($res->num_rows() <= 0) return false;
     $pos = $res->row_array();
     
     $res = $this->db->select('id, position')->from('site_faq')->where('position > '.$this->db->escape($pos['position']))->limit(1)->order_by('position', 'ASC')->get();
     if ($res->num_rows() <= 0) return false;
     $res = $res->row_array();
     
     $this->db->set('position', $res['position'])->where('id = '.$this->db->escape($id))->update('site_faq');
     $this->db->set('position', $pos['position'])->where('id = '.$this->db->escape($res['id']))->update('site_faq');
    }
    
}