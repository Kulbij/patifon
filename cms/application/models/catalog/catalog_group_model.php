<?php
class Catalog_group_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    
    public function setVisible($id) {
        $this->db->set('visible', 1);
        $this->db->where("id = '{$id}'")->update('site_lookbook');
    }
    
    public function setUnVisible($id) {
        $this->db->set('visible', 0);
        $this->db->where("id = '{$id}'")->update('site_lookbook');
    }
    
    //position page
    public function setUp($id) {
     $res = $this->db->select('catid, position')->from('site_lookbook')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $pos = $res[0];
     
     $res = $this->db->select('id, position')->from('site_lookbook')->where("position < '{$pos['position']}' AND catid = '{$pos['catid']}'")->limit(1)->order_by('position', 'DESC')->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_lookbook');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_lookbook');
    }
    
    public function setDown($id) {
     $res = $this->db->select('catid, position')->from('site_lookbook')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $pos = $res[0];
     
     $res = $this->db->select('id, position')->from('site_lookbook')->where("position > '{$pos['position']}' AND catid = '{$pos['catid']}'")->limit(1)->order_by('position', 'ASC')->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_lookbook');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_lookbook');
    }
    
    public function getCats() {
     $this->load->model('catalog/catalog_brand_model');
     return $this->catalog_brand_model->selectPreviewAll();
    }
    
    //other functions
    public function selectPreviewAll($category = 0) {
        
        $this->db->select('id, name'.$this->config->item('config_default_lang').' as name, name2'.$this->config->item('config_default_lang').' as name2, visible, position');        
        $this->db->from('site_lookbook');
        
        if ($category > 0) $this->db->where('catid = '.$this->db->escape($category));
        
        $res = $this->db->order_by('position', 'ASC')->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        return $res;
        
    }
    
    public function selectPage($id) {

        if ($id <= 0) return array();
        
        $this->db->select('*');
        $this->db->from('site_lookbook');
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
         $this->db->set('name2'.$value, $array['name2'.$value]);
        }
        
        if (isset($array['catid'])) $this->db->set('catid', $array['catid']);
        if (isset($array['object_1'])) $this->db->set('object_1', $array['object_1']);
        if (isset($array['object_2'])) $this->db->set('object_2', $array['object_2']);
        
        if (isset($array['id']) && is_numeric($array['id'])) {
         $this->db->set('visible', $array['visible']);
         $this->db->where("id = '{$array['id']}'")->update('site_lookbook');
         $objectid = $array['id'];
        } else {
         $this->db->set('visible', 1);
         $this->db->insert('site_lookbook');
         $objectid = $this->db->insert_id();
         
         $this->db->set('position', $objectid)->where('id = '.$this->db->escape($objectid))->update('site_lookbook');
         
        }
        
        $this->load->library('image_my_lib');
        
        if (isset($array['image']) && !empty($array['image'])) {
         $res = $this->db->select('image, image_big')->from('site_lookbook')->where("id = '{$objectid}'")->limit(1)->get();
         
         if ($res->num_rows() > 0) {
          $res = $res->row_array();
          
          if (isset($res['image']) && !empty($res['image'])) {
           $this->image_my_lib->delImage($res['image']);
          }
          if (isset($res['image_big']) && !empty($res['image_big'])) {
           $this->image_my_lib->delImage($res['image_big']);
          }
         }
         
         $this->db->set('image', $array['image']['image'])->set('image_big', $array['image']['image_big'])->where('id = '.$this->db->escape($objectid))->update('site_lookbook');
        }
        
        if (isset($array['image2']) && !empty($array['image2'])) {
         $res = $this->db->select('image2, image2_big')->from('site_lookbook')->where("id = '{$objectid}'")->limit(1)->get();
         
         if ($res->num_rows() > 0) {
          $res = $res->row_array();
          
          if (isset($res['image2']) && !empty($res['image2'])) {
           $this->image_my_lib->delImage($res['image2']);
          }
          if (isset($res['image2_big']) && !empty($res['image2_big'])) {
           $this->image_my_lib->delImage($res['image2_big']);
          }
         }
         
         $this->db->set('image2', $array['image2']['image'])->set('image2_big', $array['image2']['image_big'])->where('id = '.$this->db->escape($objectid))->update('site_lookbook');
        }
        
        return $objectid;
        
    }
    //---end SAVE PAGE
    
    public function deleteV($id) {
     
     $id = (int)$id;
     if ($id <= 0) return false;
     
     $this->load->library('image_my_lib');
 
     $res = $this->db->select('image, image_big, image2, image2_big')->from('site_lookbook')->where("id = '{$id}'")->limit(1)->get();
     
     if ($res->num_rows() > 0) {
      $res = $res->row_array();
      
      if (isset($res['image']) && !empty($res['image'])) {
       $this->image_my_lib->delImage($res['image']);
      }
      if (isset($res['image_big']) && !empty($res['image_big'])) {
       $this->image_my_lib->delImage($res['image_big']);
      }
      if (isset($res['image2']) && !empty($res['image2'])) {
       $this->image_my_lib->delImage($res['image2']);
      }
      if (isset($res['image2_big']) && !empty($res['image2_big'])) {
       $this->image_my_lib->delImage($res['image2_big']);
      }
     }
 
     $this->db->where('id = '.$this->db->escape($id))->limit(1)->delete('site_lookbook');
    }
    
    public function delPImage($lb = 0, $image = 1) {
     $lb = (int)$lb;
     if ($lb <= 0) return false;
     $image = (int)$image;
     
     $res = $this->db->select('image, image_big, image2, image2_big')->from('site_lookbook')->where("id = '{$lb}'")->limit(1)->get();
     
     if ($res->num_rows() > 0) {
      $res = $res->row_array();
      
      $this->load->library('image_my_lib');
      
      if ($image == 1) {
       if (isset($res['image']) && !empty($res['image'])) {
        $this->image_my_lib->delImage($res['image']);
       }
       if (isset($res['image_big']) && !empty($res['image_big'])) {
        $this->image_my_lib->delImage($res['image_big']);
       }
       
       $this->db->set('image', '')->set('image_big', '')->where("id = '{$lb}'")->limit(1)->update('site_lookbook');
       
      } else {
       if (isset($res['image2']) && !empty($res['image2'])) {
        $this->image_my_lib->delImage($res['image2']);
       }
       if (isset($res['image2_big']) && !empty($res['image2_big'])) {
        $this->image_my_lib->delImage($res['image2_big']);
       }
       
       $this->db->set('image2', '')->set('image2_big', '')->where("id = '{$lb}'")->limit(1)->update('site_lookbook');
       
      }
      
      return true;
      
     }
     
     return false;
     
    }
    
}