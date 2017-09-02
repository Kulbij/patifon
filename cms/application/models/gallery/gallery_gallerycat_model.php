<?php
class Gallery_gallerycat_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function setVisible($id) {
        $this->db->set('visible', 1);
        $this->db->where("id = '{$id}'")->update('site_gallerycat');
    }
    
    public function setUnVisible($id) {
        $this->db->set('visible', 0);
        $this->db->where("id = '{$id}'")->update('site_gallerycat');
    }
    
    //position page
    public function setUp($id) {
        
        $res = $this->db->select('parentid, position')->from('site_gallerycat')->where("id = '{$id}'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res[0];
        
        $res = $this->db->select('id, position')->from('site_gallerycat')->where("position < '{$pos['position']}' AND parentid = '{$pos['parentid']}'")->limit(1)->order_by('position', 'DESC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_gallerycat');
        $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_gallerycat');
        
    }
    
    public function setDown($id) {
        
        $res = $this->db->select('parentid, position')->from('site_gallerycat')->where("id = '{$id}'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res[0];
        
        $res = $this->db->select('id, position')->from('site_gallerycat')->where("position > '{$pos['position']}' AND parentid = '{$pos['parentid']}'")->limit(1)->order_by('position', 'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_gallerycat');
        $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_gallerycat');
        
    }
    
    //other functions
    public function selectPreviewAll() {
        
        $res = $this->db->select('id, parentid, name_ua as name, position, visible')->from('site_gallerycat')->where('parentid = 0')->order_by('position', 'ASC')->get();
        if ($res->num_rows() <= 0) return array();
        $res = $res->result_array();
        
        $res2 = $this->db->select('id, parentid, name_ua as name, position, visible')->from('site_gallerycat')->where('parentid <> 0')->order_by('position', 'ASC')->get();
        if ($res2->num_rows() <= 0) return $res;
        $res2 = $res2->result_array();
        
        foreach ($res as &$one) {
         $one['children'] = array();
         foreach ($res2 as $key => $two) {
          if ($one['id'] == $two['parentid']) {
           array_push($one['children'], $two);
           unset($res2[$key]);
          }
         }
        } unset($one);
        
        return $res;
        
    }
    
    public function selectObject($id) {
        
        $id = (int)$id;
        if ($id <= 0) return array();
        
        $this->db->select('*');
        $this->db->from('site_gallerycat');
        $this->db->where("id = '{$id}'");
        $res = $this->db->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        return $res[0];
        
    }
    
    //---SAVE PAGE region
    
    public function save($array) {
        
        $return = 'http';
            
        if (isset($array['image']) && !empty($array['image'])) {
            
            if (isset($array['id']) && $array['id'] > 0) {
                
                $res = $this->db->select('image')->from('site_gallerycat')->where("id = '{$array['id']}'")->limit(1)->get();
                
                if ($res->num_rows() > 0) {
                    
                    $res = $res->result_array();
                    
                    $this->load->library('image_my_lib');
                    if (isset($res[0]['image']) && !empty($res[0]['image'])) {
                        
                        $this->image_my_lib->delImage($res[0]['image']);
                        
                    }
                    
                }
                
            }
            
            $this->db->set('image', $array['image']);
            
        }
        
        $this->db->set('parentid', $array['parentid']);
        
        foreach ($this->config->item('config_languages') as $value) {
         if (isset($array['name'.$value]))
          $this->db->set('name'.$value, $array['name'.$value]);
         
         if (isset($array['title'.$value]))
          $this->db->set('title'.$value, $array['title'.$value]);
         
         if (isset($array['keyword'.$value]))
          $this->db->set('keyword'.$value, $array['keyword'.$value]);
         
         if (isset($array['description'.$value]))
          $this->db->set('description'.$value, $array['description'.$value]);
         
         
        }
        
        if (isset($array['id'])) {
            
            $this->db->set('visible', $array['visible']);
            $this->db->where("id = '{$array['id']}'")->update('site_gallerycat');
            
            $return = $array['id'];
            
        } else {
            
            $this->db->set('visible', 1);
            $this->db->insert('site_gallerycat');
            
            $return = $this->db->insert_id();
            
            $this->db->set('position', $return)->where("id = '{$return}'")->update('site_gallerycat');
            
        }
        
        return $return;
        
    }
    //---end SAVE PAGE
    
    public function remove($id) {
        
        $id = (int)$id;
        
        $gal = $this->db->select('id')->from('site_gallery')->where("catid = '{$id}'")->get();
        
        if ($gal->num_rows() > 0) {
            
            $gal = $gal->result_array();
            
            $this->load->model('gallery/gallery_gallery_model', 'ggmodel');
            
            foreach ($gal as $one) {
                
                $this->ggmodel->remove($one['id']);
                
            }
            
        }
        
        $this->load->library('image_my_lib');
        
        $res = $this->db->select('image')->from('site_gallerycat')->where("id = '{$id}'")->limit(1)->get();
        
        if ($res->num_rows() > 0) {
         $res = $res->result_array();
         $res = $res[0]['image'];
         
         $this->image_my_lib->delImage($res);
        }
        
        $this->db->where("id = '{$id}'")->delete('site_gallerycat');
        
    }
    
}