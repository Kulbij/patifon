<?php

class Catalog_cat_option_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	   
    public function getCats() {
     return array();
    }
    
    public function setVisible($id) {
        $this->db->set('visible', 1);
        $this->db->where("id = '{$id}'")->update('site_var');
    }
    
    public function setUnVisible($id) {
        $this->db->set('visible', 0);
        $this->db->where("id = '{$id}'")->update('site_var');
    }
	
    //position page
    public function setUp($id) {
     $res = $this->db->select('position')->from('site_var')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $pos = $res[0];
     
     $res = $this->db->select('id, position')->from('site_var')->where("position < '{$pos['position']}'")->limit(1)->order_by('position', 'DESC')->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_var');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_var');
    }
    
    public function setDown($id) {
     $res = $this->db->select('position')->from('site_var')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $pos = $res[0];
     
     $res = $this->db->select('id, position')->from('site_var')->where("position > '{$pos['position']}'")->limit(1)->order_by('position', 'ASC')->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_var');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_var');
     
    }
    
    //other functions
    public function selectPreviewAll($page = 1, $count = 100, $category = 0) {

        $this->db->select('site_paket_option_category.id, site_paket_option_category.name_ru as name,site_paket_option_category.visible');
        
        $this->db->from('site_paket_option_category');
        $res = $this->db->order_by('site_paket_option_category.createdate', 'ASC')->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        return $res;
        
    }

    public function inOption($array = array()){
        if(!isset($array) && empty($array) && count($array) <= 0) return false;

        foreach ($this->config->item('config_languages') as $value) {
            $this->db->set('name'.$value, $array['name'.$value]);
        }

        $this->db->insert('site_paket_option_category');

        $id = $this->db->insert_id();

        return $id;
    }

    public function upOption($array = array()){
        if(!isset($array) && empty($array) && count($array) <= 0) return false;

        foreach ($this->config->item('config_languages') as $value) {
            $this->db->set('name'.$value, $array['name'.$value]);
        }

        if(isset($array['id']) && !empty($array['id'])){
            $this->db->where('site_paket_option_category.id', $array['id']);
            $this->db->update('site_paket_option_category');
            $return = $array['id'];
        } else {
            $this->db->insert('site_paket_option_category');
            $id = $this->db->insert_id();
        }

        return $id;
    }

    public function gererateIDOpttion($id = 0){
        $id = (int)$id;
        if($id <= 0) return false;

        $res = $this->db->select('site_paket_option_category.id')->where('site_paket_option_category.id', $id)->from('site_paket_option_category')->get();

        if($res->num_rows() <= 0) return false;
        $res = $res->result_array();

        return true;
    }

    public function getOne($id = 0){
        $id = (int)$id;
        if(!isset($id) && empty($id) && $id <= 0) return false;

        $res = $this->db->select('*')->where('site_paket_option_category.id', $id)->from('site_paket_option_category')->get();

        if($res->num_rows() <= 0) return false;
        $res = $res->result_array();

        return $res[0];
    }
    
    public function remove($id){
        $id = (int)$id;
        if($id <= 0) return false;

        $this->db->where('site_paket_option_category.id', $id)->delete('site_paket_option_category');
    }
    public function setUnVis($id){
        $id = (int)$id;
        if($id <= 0) return false;

        $this->db->set('site_paket_option.visible', 0)->where('site_paket_option.id', $id)->update('site_paket_option');
    }
    public function setVis($id){
        $id = (int)$id;
        if($id <= 0) return false;

        $this->db->set('site_paket_option.visible', 1)->where('site_paket_option.id', $id)->update('site_paket_option');
    }

    public function selectPage($id) {

        $this->db->select('*');
        $this->db->from('site_var');
        $this->db->where("id = '{$id}'");
        $res = $this->db->limit(1)->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();

        return $res;
        
    }
    
    //---SAVE PAGE region
    
    public function savePage($array) {
        
        $objectid = 0;
        
        foreach ($this->config->item('config_languages') as $value) {
         $this->db->set('name'.$value, $array['name'.$value]);
         $this->db->set('shorttext'.$value, $array['shorttext'.$value]);
         $this->db->set('text'.$value, $array['text'.$value]);
        }
        
        if (isset($array['key'])) $this->db->set('key', $array['key']);
        
        #if (isset($array['textile_count'])) $this->db->set('textile_count', $array['textile_count']);
        
        /*$this->db->set('city', $array['city']);
        $this->db->set('description', $array['description']);
        $this->db->set('valuta', $array['valuta']);
        */
        
        #if (isset($array['link'])) $this->db->set('link', $array['link']);
        #$this->db->set('manual', $array['manual']);
        
        
        if (isset($array['id']) && is_numeric($array['id'])) {
            
            /*
            if ($array['manual']) $this->db->set('link', $array['link']);
            else {
             if (isset($array['link']) && !empty($array['link'])) {
              $pos = strrpos($array['link'], '-'.$array['id']);
              if ($pos !== false) $array['link'] = substr($array['link'], 0, $pos);
             }
             $this->db->set('link', rtrim($array['link'], '-').'-'.$array['id']);
            }
            $this->db->set('manual', $array['manual']);
            */
            
            $this->db->where("id = '{$array['id']}'")->update('site_var');
            $objectid = $array['id'];
            
        } else {
            
            #if ($array['manual']) $this->db->set('link', $array['link']);
            #$this->db->set('manual', $array['manual']);
            
            #$this->db->set('image', $array['img']);
            
            $this->db->insert('site_var');
            $objectid = $this->db->insert_id();
            
            #if (!$array['manual']) $this->db->set('link', rtrim($array['link'], '-').'-'.$objectid);
            #$this->db->set('position', $objectid)->where('id = '.$this->db->escape($objectid))->update('site_var');
            
        }
        
        if (isset($array['image']['image']) && !empty($array['image']['image'])) {
         $this->load->library('image_my_lib');
         $res = $this->db->select('image')->from('site_var')->where("id = '{$objectid}'")->limit(1)->get();
 
         if ($res->num_rows() > 0) {
          $res = $res->row_array();
          
          $this->image_my_lib->delImage($res['image']);
         }
     
         $this->db->set('image', $array['image']['image'])->where('id = '.$this->db->escape($objectid))->update('site_var');
        }
        
        return $objectid;
        
    }
    //---end SAVE PAGE
    
    public function deleteV($id) {
     
     $id = (int)$id;
     if ($id <= 0) return false;
     
     /*
     $this->load->library('image_my_lib');
     $res = $this->db->select('image')->from('site_var')->where("id = '{$id}'")->limit(1)->get();

     if ($res->num_rows() > 0) {
      $res = $res->row_array();
      
      $this->image_my_lib->delImage($res['image']);
     }
     
     $res = $this->db->select('id')->from('site_sofa_textile')->where('catid = '.$this->db->escape($id))->get();
     if ($res->num_rows() > 0) {
      $res = $res->result_array();
      
      $this->load->model('catalog/catalog_s_textile_model', 'submodel');
      foreach ($res as $one) {
       $this->submodel->deleteV($one['id']);
      }
      
     }
     */
     $this->db->where("id = '{$id}'")->limit(1)->delete('site_var');
     
    }
    
}