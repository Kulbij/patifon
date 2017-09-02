<?php

class Catalog_wr_corpus_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	   
    public function getCats() {
     $this->load->model('catalog/catalog_wr_fasade_model');
     return $this->catalog_wr_fasade_model->selectPreviewAll();
    }
    
    public function setVisible($id) {
        $this->db->set('visible', 1);
        $this->db->where("id = '{$id}'")->update('site_delivery_type');
    }
    
    public function setUnVisible($id) {
        $this->db->set('visible', 0);
        $this->db->where("id = '{$id}'")->update('site_delivery_type');
    }
	
    //position page
    public function setUp($id) {
     $res = $this->db->select('cat_id, position')->from('site_delivery_type')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $pos = $res[0];
     
     $res = $this->db->select('id, position')->from('site_delivery_type')->where("position < '{$pos['position']}' AND cat_id = '{$pos['cat_id']}'")->limit(1)->order_by('position', 'DESC')->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_delivery_type');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_delivery_type');
    }
    
    public function setDown($id) {
     $res = $this->db->select('cat_id, position')->from('site_delivery_type')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $pos = $res[0];
     
     $res = $this->db->select('id, position')->from('site_delivery_type')->where("position > '{$pos['position']}' AND cat_id = '{$pos['cat_id']}'")->limit(1)->order_by('position', 'ASC')->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_delivery_type');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_delivery_type');
     
    }
    
    //other functions
    public function selectPreviewAll($catid = 0) {
        
        $catid = (int)$catid;

        $this->db->select('id, name'.$this->config->item('config_default_lang').' as name, visible, position');        
        $this->db->from('site_delivery_type');

        if ($catid > 0) $this->db->where('cat_id = '.$this->db->escape($catid));

        $res = $this->db->order_by('position', 'ASC')->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        return $res;
        
    }
    
    public function selectPage($id) {

        $this->db->select('*');
        $this->db->from('site_delivery_type');
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
        }
        
        if (isset($array['cat_id'])) $this->db->set('cat_id', $array['cat_id']);
        if (isset($array['price'])) $this->db->set('price', $array['price']);
        
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
            
            if (isset($array['visible'])) $this->db->set('visible', $array['visible']);

            $this->db->where("id = '{$array['id']}'")->update('site_delivery_type');
            $objectid = $array['id'];
            
        } else {
            
            #if ($array['manual']) $this->db->set('link', $array['link']);
            #$this->db->set('manual', $array['manual']);
            
            #$this->db->set('image', $array['img']);
            
            $this->db->set('visible', 1);
            
            $this->db->insert('site_delivery_type');
            $objectid = $this->db->insert_id();
            
            #if (!$array['manual']) $this->db->set('link', rtrim($array['link'], '-').'-'.$objectid);
            $this->db->set('position', $objectid)->where('id = '.$this->db->escape($objectid))->update('site_delivery_type');
            
        }
        
        if (isset($array['image']['image']) && !empty($array['image']['image'])) {
         $this->load->library('image_my_lib');
         $res = $this->db->select('image')->from('site_delivery_type')->where("id = '{$objectid}'")->limit(1)->get();
 
         if ($res->num_rows() > 0) {
          $res = $res->row_array();
          
          $this->image_my_lib->delImage($res['image']);
         }
     
         $this->db->set('image', $array['image']['image'])->where('id = '.$this->db->escape($objectid))->update('site_delivery_type');
        }
        
        if (isset($array['image']['image_big']) && !empty($array['image']['image_big'])) {
         $this->load->library('image_my_lib');
         $res = $this->db->select('image_big')->from('site_delivery_type')->where("id = '{$objectid}'")->limit(1)->get();
 
         if ($res->num_rows() > 0) {
          $res = $res->row_array();
          
          $this->image_my_lib->delImage($res['image_big']);
         }
     
         $this->db->set('image_big', $array['image']['image_big'])->where('id = '.$this->db->escape($objectid))->update('site_delivery_type');
        }
        
        return $objectid;
        
    }
    //---end SAVE PAGE
    
    public function deleteV($id) {
     
     $id = (int)$id;
     if ($id <= 0) return false;
     
     // $this->load->library('image_my_lib');
     // $res = $this->db->select('image, image_big')->from('site_delivery_type')->where("id = '{$id}'")->limit(1)->get();

     // if ($res->num_rows() > 0) {
     //  $res = $res->row_array();
      
     //  $this->image_my_lib->delImage($res['image']);
     //  $this->image_my_lib->delImage($res['image_big']);
     // }
     
     $this->db->where("id = '{$id}'")->limit(1)->delete('site_delivery_type');
     
    }
    
}