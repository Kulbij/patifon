<?php

class Catalog_brand_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	   
    public function getCats() {
        $this->db->select('id, parent_id, name'.$this->config->item('config_default_lang').' as name, visible, position');        
        $this->db->from('site_catalog_filters');
        $this->db->where('parent_id = 0');
        $res = $this->db->order_by('position', 'ASC')->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();

        return $res;
    }
    
    public function setVisible($id) {
        $this->db->set('visible', 1);
        $this->db->where("id = '{$id}'")->update('site_catalog_filters');
    }
    
    public function setUnVisible($id) {
        $this->db->set('visible', 0);
        $this->db->where("id = '{$id}'")->update('site_catalog_filters');
    }
	
    //position page
    public function setUp($id) {
     $res = $this->db->select('parent_id, position')->from('site_catalog_filters')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $pos = $res[0];
     
     $res = $this->db->select('id, position')->from('site_catalog_filters')->where("parent_id = '{$pos['parent_id']}' AND position < '{$pos['position']}'")->limit(1)->order_by('position', 'DESC')->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_catalog_filters');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_catalog_filters');
    }
    
    public function setDown($id) {
     $res = $this->db->select('parent_id, position')->from('site_catalog_filters')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $pos = $res[0];
     
     $res = $this->db->select('id, position')->from('site_catalog_filters')->where("parent_id = '{$pos['parent_id']}' AND position > '{$pos['position']}'")->limit(1)->order_by('position', 'ASC')->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_catalog_filters');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_catalog_filters');
    }
    
    //other functions
    public function selectPreviewAll($parent_id = 0, $output = false, $for_cats = false) {
        
        $parent_id = (int)$parent_id;

        $this->db->select('id, parent_id, image, filter-vis, name'.$this->config->item('config_default_lang').' as name, visible, position');        
        $this->db->from('site_catalog_filters');

        if ($parent_id > 0) $this->db->where('parent_id = '.$this->db->escape($parent_id));
        else {
         $this->db->where('parent_id = 0');

         if ($for_cats) {
          $f_array = array(
            'price', 'sort', 'promo', 'page'
           );

          $this->db->where_not_in('field', $f_array);
         }

        }

        if ($output) $this->db->where('visible = 1');

        $res = $this->db->order_by('position', 'ASC')->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        foreach ($res as &$one) {
            $one['children'] = $this->selectPreviewAll($one['id']);
        } unset($one);

        return $res;
        
    }
    
    public function selectPage($id) {

        $this->db->select('*');
        $this->db->from('site_catalog_filters');
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
         $this->db->set('name_short'.$value, $array['name_short'.$value]);
        }
        
        if (isset($array['parent_id'])) $this->db->set('parent_id', $array['parent_id']);
        if (isset($array['field'])) $this->db->set('field', $array['field']);
        if (isset($array['color'])) $this->db->set('color', $array['color']);
        if (isset($array['default'])) $this->db->set('default', $array['default']);
        if (isset($array['type'])) $this->db->set('type', $array['type']);
        if(isset($array['name_icon'])) $this->db->set('name_icon', $array['name_icon']);


        if (isset($array['link'])) $this->db->set('link', $array['link']);
        $this->db->set('manual', $array['manual']);
        
        
        if (isset($array['id']) && is_numeric($array['id'])) {
            
            if ($array['manual']) $this->db->set('link', $array['link']);
            else {
             /*if (isset($array['link']) && !empty($array['link'])) {
              $pos = strrpos($array['link'], '-'.$array['id']);
              if ($pos !== false) $array['link'] = substr($array['link'], 0, $pos);
             }*/
             $this->db->set('link', rtrim($array['link'], '-')); #.'-'.$array['id']);
            }
            $this->db->set('manual', $array['manual']);
            
            if (isset($array['visible'])) $this->db->set('visible', $array['visible']);

            $this->db->where("id = '{$array['id']}'")->update('site_catalog_filters');
            $objectid = $array['id'];
            
        } else {
            
            if ($array['manual']) $this->db->set('link', $array['link']);
            $this->db->set('manual', $array['manual']);
            
            $this->db->set('visible', 1);

            $this->db->insert('site_catalog_filters');
            $objectid = $this->db->insert_id();
            
            if (!$array['manual']) $this->db->set('link', rtrim($array['link'], '-')); #.'-'.$objectid);
            $this->db->set('position', $objectid)->where('id = '.$this->db->escape($objectid))->update('site_catalog_filters');
            
        }
        if (isset($array['filter-vis'])) {
            $this->db->set('filter-vis', $array['filter-vis']);
            $this->db->where('id', $array['id'])->update('site_catalog_filters');
        }

        if (isset($array['img']) && !empty($array['img'])) {
         $res = $this->db->select('image')->from('site_catalog_filters')->where('id = '.$this->db->escape($objectid))->limit(1)->get();
         if ($res->num_rows() > 0) {
          $res = $res->row_array();
          $this->load->library('image_my_lib');
          $this->image_my_lib->delImage($res['image']);
         }

         $res = $this->db->select('*')->where('site_catalog_filters.id', $objectid)->from('site_catalog_filters')->limit(1)->get();
         if($res->num_rows() <= 0) $res = array();
         $res = $res->row_array();

         $this->db->set('image', $array['img'])->where('id = '.$this->db->escape($objectid))->limit(1)->update('site_catalog_filters');

         if(isset($res['parent_id'])){
            if($res['parent_id'] == 0){
                $this->db->set('image', $array['img'])->where('parent_id = '.$this->db->escape($objectid))->update('site_catalog_filters');         
            }
         }
        }
        
        return $objectid;
        
    }
    //---end SAVE PAGE
    
    public function deleteV($id) {
        
        $id = (int)$id;
        if ($id <= 0) return false;
        
        $res = $this->db->select('id')->from('site_catalog_filters')->where('parent_id = '.$this->db->escape($id))->get();
        if ($res->num_rows() > 0) {
          $res = $res->result_array();
          foreach ($res as $one) {
            $this->deleteV($one['id']);
          }
        }

        $this->db->where("filter_id = '{$id}'")->delete('site_catalog_filters_catalog');
        $this->db->where("filter_id = '{$id}'")->delete('site_catalog_filters_category');
        $this->db->where("parent_id = '{$id}'")->delete('site_catalog_filters');
        $this->db->where("id = '{$id}'")->limit(1)->delete('site_catalog_filters');
        
    }

    public function getImage($id){
        if(!isset($id) && empty($id) && $id <= 0) return false;
        $id = (int)$id;

        $res = $this->db->select('site_catalog_filters.image')->where('site_catalog_filters.id', $id)->from('site_catalog_filters')->limit(1)->get();

        if($res->num_rows() <= 0) return false;
        $res = $res->result_array();

        return $res[0]['image'];
    }
    
}