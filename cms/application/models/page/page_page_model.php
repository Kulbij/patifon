<?php
class Page_page_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    //other functions
    public function selectPreviewAll($parentid = 0, $id = 0, $ii = true) {
     $ind = array();
     if ($parentid == 0 && $ii) {
      $ind = $this->db->select('name'.$this->config->item('config_default_lang').' as name, link')->from('site_indexpage')->limit(1)->get();
      $ind = $ind->result_array();
      $ind[0]['id'] = 0;
     }
     
     $this->db->select('id, parentid, link, name'.$this->config->item('config_default_lang').' as name, position, visible');
     $this->db->from('site_page');
     $this->db->where('parentid = '.$this->db->escape($parentid));
     $this->db->where('id <> '.$this->db->escape($id));
     $res = $this->db->order_by('position' ,'ASC')->get();
     $res = $res->result_array();
     
     if (!empty($res)) {
      foreach ($res as &$one) {
       $one['children'] = $this->selectPreviewAll($one['id'], $id, false);
      } unset($one);
     }
     
     return array_merge($ind, $res);
    }
    
    public function selectPage($link) {
        
        if ($link == 0) {
            
            $this->db->select('*');
            $this->db->from('site_indexpage');
            $res = $this->db->limit(1)->get();
            $res = $res->result_array();
            
            if (count($res) <= 0) return array();
            
            return $res;
            
        } else {
            
            $this->db->select('*');        
            $this->db->from('site_page');
            $this->db->where("id = '$link'");
            $res = $this->db->limit(1)->get();
            $res = $res->result_array();
            
            if (count($res) <= 0) return array();
            
            if ($link == 'price') {
             $res2 = $this->db->select('id, date, file, weight')->from('site_price')->limit(1)->get();
             if ($res2->num_rows() > 0) {
              $res2 = $res2->row_array();
              $res[0]['_price'] = $res2;
             }
            }
            
            if ($link == 'contact') {
                
                $rees = $this->db->select('*')->from('site_contact')->get();
                
                if ($rees->num_rows() > 0) {
                    
                    $rees = $rees->result_array();
                    
                    $res[0]['cts'] = $rees;
                    
                }
                
                
                $res_temp = $this->db->select('*')->from('site_shopdaywork')->get();
                
                if ($res_temp->num_rows() > 0) {
                 
                 $res_temp = $res_temp->result_array();
                 
                 $res[0]['graph'] = $res_temp;
                 
                }
                
            }
            
            if (isset($SDS) && $link == 'payment') {
                
                $temper = $this->db->select('name_')->from('site_statictext')->limit(1)->get();
                
                if ($temper->num_rows() > 0) {
                    
                    $temper = $temper->result_array();
                    $res[0]['payment_text'] = $temper[0]['name'];
                    
                }
                
            }
            
            return $res;
            
        }
        
        return array();
        
    }
    
    //visible page
    public function setVisible($id) {
        $this->db->set('visible', 1);
        $this->db->where("id = '{$id}'")->update('site_page');
    }
    
    public function setUnVisible($id) {
        $this->db->set('visible', 0);
        $this->db->where("id = '{$id}'")->update('site_page');
    }
    
    //position page
    public function setUp($id) {
        
        $res = $this->db->select('parentid, position')->from('site_page')->where("id = '$id'")->limit(1)->get();
        $res = $res->row_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res;
        
        $res = $this->db->select('id, position')->from('site_page')->where("position < '{$pos['position']}' AND parentid= '{$pos['parentid']}'")->limit(1)->order_by('position', 'DESC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '$id'")->update('site_page');
        $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_page');
        
    }
    
    public function setDown($id) {
        
        $res = $this->db->select('parentid, position')->from('site_page')->where("id = '$id'")->limit(1)->get();
        $res = $res->row_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res;
        
        $res = $this->db->select('id, position')->from('site_page')->where("position > '{$pos['position']}' AND parentid= '{$pos['parentid']}'")->limit(1)->order_by('position', 'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '$id'")->update('site_page');
        $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_page');
        
    }
    
    //---SAVE PAGE region
    
    public function savePage($array) {
     
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
      
      if (isset($array['text2'.$value]))
       $this->db->set('text2'.$value, $array['text2'.$value]);
      
      if (isset($array['dir'.$value]))
       $this->db->set('dir'.$value, $array['dir'.$value]);
      
     }
     
     if ($array['id'] == 0) {
      $this->db->where("link = 'index'")->limit(1)->update('site_indexpage');
      $return = 0;
     } elseif ($array['id'] > 0) {
      if (isset($array['parentid'])) $this->db->set('parentid', $array['parentid']);
      if (isset($array['isdoc'])) $this->db->set('isdoc', $array['isdoc']);
      
      if (isset($array['email']))
       $this->db->set('email', $array['email']);
      
      if ($array['manual']) $this->db->set('link', $array['link']);
      else {
       if (isset($array['link']) && !empty($array['link'])) {
        $pos = strrpos($array['link'], '-'.$array['id']);
        if ($pos !== false) $array['link'] = substr($array['link'], 0, $pos);
       }
       $this->db->set('link', rtrim($array['link'], '-').'-'.$array['id']);
      }
      $this->db->set('manual', $array['manual']);
      
      $this->db->set('visible', $array['visible']);
      $this->db->set('visible_ontop', 1);
      $this->db->where("id = '{$array['id']}'")->update('site_page');
      $return = $array['id'];
     } else {
      
      if (isset($array['parentid'])) $this->db->set('parentid', $array['parentid']);
      if (isset($array['isdoc'])) $this->db->set('isdoc', $array['isdoc']);
      
      if (isset($array['email']))
       $this->db->set('email', $array['email']);
      
      if ($array['manual']) $this->db->set('link', $array['link']);
      $this->db->set('manual', $array['manual']);
      
      $this->db->set('visible', 1);
      $this->db->set('visible_ontop', 1);
      $this->db->insert('site_page');
      $return = $this->db->insert_id();
      
      if (!$array['manual']) {
       $this->db->set('link', rtrim($array['link'], '-').'-'.$return);
      }
      $this->db->set('position', $return);
      $this->db->where("id = '{$return}'")->update('site_page');
      
     }
     
     
     $this->load->library('image_my_lib');
     
     if (isset($array['image']) && !empty($array['image'])) {
      $res = $this->db->select('image, image_big')->from('site_page')->where("id = '{$return}'")->limit(1)->get();
      
      if ($res->num_rows() > 0) {
       $res = $res->row_array();
       
       if (isset($res['image']) && !empty($res['image'])) {
        $this->image_my_lib->delImage($res['image']);
       }
       if (isset($res['image_big']) && !empty($res['image_big'])) {
        $this->image_my_lib->delImage($res['image_big']);
       }
      }
      
      $this->db->set('image', $array['image']['image'])->set('image_big', $array['image']['image_big'])->where('id = '.$this->db->escape($return))->update('site_page');
     }
     
     if (isset($array['image2']) && !empty($array['image2'])) {
      $res = $this->db->select('image2, image2_big')->from('site_page')->where("id = '{$return}'")->limit(1)->get();
      
      if ($res->num_rows() > 0) {
       $res = $res->row_array();
       
       if (isset($res['image2']) && !empty($res['image2'])) {
        $this->image_my_lib->delImage($res['image2']);
       }
       if (isset($res['image2_big']) && !empty($res['image2_big'])) {
        $this->image_my_lib->delImage($res['image2_big']);
       }
      }
      
      $this->db->set('image2', $array['image2']['image'])->set('image2_big', $array['image2']['image_big'])->where('id = '.$this->db->escape($return))->update('site_page');
     }
     
     return $return;
    }
    //---end SAVE PAGE
    
    public function remove($id = 0) {
     $id = (int)$id;
     if ($id <= 0) return false;
     
     $res = $this->db->select('id')->from('site_page')->where('parentid = '.$this->db->escape($id))->get();
     if ($res->num_rows() > 0) {
      $res = $res->result_array();
      foreach($res as $one) {
       $this->remove($one['id']);
      }
     }
     
     $this->db->where('pageid = '.$this->db->escape($id))->delete('site_files');
     $this->db->where('id = '.$this->db->escape($id))->limit(1)->delete('site_page');
     
    }
    
    public function delPImage($pageid = 0, $image = 1) {
     $pageid = (int)$pageid;
     if ($pageid <= 0) return false;
     $image = (int)$image;
     
     $res = $this->db->select('image, image_big, image2, image2_big')->from('site_page')->where("id = '{$pageid}'")->limit(1)->get();
     
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
       
       $this->db->set('image', '')->set('image_big', '')->where("id = '{$pageid}'")->limit(1)->update('site_page');
       
      } else {
       if (isset($res['image2']) && !empty($res['image2'])) {
        $this->image_my_lib->delImage($res['image2']);
       }
       if (isset($res['image2_big']) && !empty($res['image2_big'])) {
        $this->image_my_lib->delImage($res['image2_big']);
       }
       
       $this->db->set('image2', '')->set('image2_big', '')->where("id = '{$pageid}'")->limit(1)->update('site_page');
       
      }
      
      return true;
      
     }
     
     return false;
     
    }
    
}