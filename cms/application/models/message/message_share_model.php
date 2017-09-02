<?php

class Message_share_model extends CI_Model
{
    function __construct() {
     parent::__construct();
    }
    
    public function selectPreviewAll($id) {
        
        $this->db->select('id, id_catalog, name, datetime, check,visible')
        ->where('id_catalog', $id)
        ->order_by('datetime', 'desc')
        ->from('site_comment');
        $result = $this->db->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return array();
        
        return $result;
        
    }
    public function selectProduct($id){
      $res = $this->db->select('name'.$this->config->item('config_default_lang').' as name_obj')->where('id', $id)->from('site_catalog')->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      return $res[0]['name_obj'];
    }
    public function set_Unvis($id){
    $this->db->where('id',$id)
        ->set('visible',0)
        ->update('site_comment');
    }
    public function selectObject($id){
      if(empty($id)) return false;
      $id = (int)$id;
      $this->db->select('name'.$this->config->item('config_default_lang').' as name')->where('id', $id)->from('site_catalog');
      $res = $this->db->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();

      return $res[0]['name'];
    }
    public function set_review_har($id){
        $set = $this->scan_filter($id);

        if($set[0]['parent_id'] == 0){
          $security = $this->select_filter_obj($set);
          $full_filters_obj = $this->full_filters_obj_func($security);
        }else{
        $this->db->set('filter-vis', 0);
        $this->db->where('id', $id)->update('site_catalog_filters');
      }
      $this->db->set('filter-vis', 0);
        $this->db->where('id', $id)->update('site_catalog_filters');
    }

    public function scan_filter($id){
      $res = $this->db->select('id, parent_id')->from('site_catalog_filters')->where('id', $id)->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      return $res;
    }

    public function select_filter_obj($array = array()){
      
      $res = $this->db->select('id, parent_id')->from('site_catalog_filters')->where('parent_id', $array[0]['id'])->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      return $res;
    }

    public function full_filters_obj_func($array){

      $idis = array();
      foreach ($array as $key => $value) {
        $idis[] = $value['id'];
      }unset($value);
      //echo "<pre>"; print_r($idis); die();


      $this->db->set('filter-vis', 0)->where_in('id', $idis);

      $this->db->update('site_catalog_filters');
      
    }

    public function set_review_harvis($id){
      $set = $this->scan_filter($id);

      if($set[0]['parent_id'] == 0){
          $security = $this->select_filter_obj($set);
          $full_filters_obj = $this->full_filters_obj_func_remove($security);
        }else{

        $this->db->where('id', $id)
        ->set('filter-vis', 1)
        ->update('site_catalog_filters');
      }
      $this->db->where('id', $id)
        ->set('filter-vis', 1)
        ->update('site_catalog_filters');
    }

    public function full_filters_obj_func_remove($array){
      $idis = array();
      foreach ($array as $key => $value) {
        $idis[] = $value['id'];
      }unset($value);
      //echo "<pre>"; print_r($idis); die();


      $this->db->set('filter-vis', 1)->where_in('id', $idis);

      $this->db->update('site_catalog_filters');
    }


    public function set_vis($id){
    $this->db->where('id',$id)
        ->set('visible',1)
        ->update('site_comment');
    }
    public function countOrder() {
        $result = $this->db->select('COUNT(*) as count')->from('site_comment')->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return 0;
        
        return $result[0]['count'];
    }
    
    public function getOrder($id) {
        
        if (!$this->ifIsOrder($id)) redirect(base_url());
        
        $res = $this->db->select('*')
        ->from('site_comment')
        ->where("site_comment.id = '{$id}'")
        ->limit(1)
        ->get();
        if ($res->num_rows() <= 0) 
        return array();
        $res = $res->row_array();

        if (isset($res['id_catalog'])) {
         $temp = $this->db->select('name'.$this->config->item('config_default_lang').' as name, link')->from('site_catalog')->where('id = '.$this->db->escape($res['id_catalog']))->limit(1)->get();
         if ($temp->num_rows() > 0) {
          $res['object'] = $temp->row_array();
         }
        }
        
        return $res;
        
    }
    
    public function ifIsOrder($id) {
        $res = $this->db->select("id")->from('site_comment')->where("id = '{$id}'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        return true;
        
    }

    public function save($array) {
     if (empty($array)) return false;

     if (isset($array['text']) && isset($array['id'])) {

      if (isset($array['name'])) $this->db->set('name', $array['name']);
      if (isset($array['email'])) $this->db->set('email', $array['email']);
      if (isset($array['datetime'])) $this->db->set('datetime', $array['datetime']);

      $this->db
              ->set('text', $array['text'])
              ->where('id = '.$this->db->escape($array['id']))
              ->limit(1)
              ->update('site_comment')
              ;

     }

     return true;
    }    

    public function delOrder($id) {
     $id = (int)$id;
     if ($id <= 0) return false;
     
     $this->db->where('id = '.$this->db->escape($id))->limit(1)->delete('site_comment');
    }
    
    public function setCheck($id) {
     $this->db->set('check', 1);
     $this->db->where("id = '{$id}'")->update('site_comment');
    }
    
    public function setUnCheck($id) {
     $this->db->set('check', 0);
     $this->db->where("id = '{$id}'")->update('site_comment');
    }
    
}