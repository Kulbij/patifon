<?php

class Catalog_s_type_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	   
    public function getBrand() {
     $res = $this->db->select('id')->from('site_catalog_filters')->where('field = "brand"')->limit(1)->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->row_array();
     
     $res = $this->db->select('id, name'.$this->config->item('config_default_lang').' as name')->from('site_catalog_filters')->where('parent_id = '.$this->db->escape($res['id']))->order_by('position', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }

    public function getCats() {
     return array();
    }
    
    public function setVisible($id) {
        $this->db->set('visible', 1);
        $this->db->where("id = '{$id}'")->update('site_catalog_share');
    }
    
    public function setUnVisible($id) {
        $this->db->set('visible', 0);
        $this->db->where("id = '{$id}'")->update('site_catalog_share');
    }
	
    //position page
    public function setUp($id) {
     $res = $this->db->select('position')->from('site_catalog_share')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $pos = $res[0];
     
     $res = $this->db->select('id, position')->from('site_catalog_share')->where("position < '{$pos['position']}'")->limit(1)->order_by('position', 'DESC')->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_catalog_share');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_catalog_share');
    }
    
    public function setDown($id) {
     $res = $this->db->select('position')->from('site_catalog_share')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $pos = $res[0];
     
     $res = $this->db->select('id, position')->from('site_catalog_share')->where("position > '{$pos['position']}'")->limit(1)->order_by('position', 'ASC')->get();
     $res = $res->result_array();
     
     if (count($res) <= 0) return false;
     
     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_catalog_share');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_catalog_share');
     
    }
    
    //other functions
    public function selectPreviewAll() {
        
        $this->db->select('id, name'.$this->config->item('config_default_lang').' as name, date_start, date_end, visible, position');        
        $this->db->from('site_catalog_share');
        $res = $this->db->order_by('date_start', 'DESC')->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        return $res;
        
    }
    
    public function selectPage($id) {

        $this->db->select('*');
        $this->db->from('site_catalog_share');
        $this->db->where("id = '{$id}'");
        $res = $this->db->limit(1)->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();

        return $res;
        
    }
    
    //---SAVE PAGE region
    
    public function savePage($array) {
        
        $objectid = 0;

        $same = $this->get_same($array);
        if ($same) {
         $this->session->set_userdata('product_date_error', date('d.m.Y', strtotime($array['date_start'])).'-'.date('d.m.Y', strtotime($array['date_end'])));
         $array['date_start'] = '2010-01-01';
         $array['date_end'] = '2010-01-01';
        }
        
        foreach ($this->config->item('config_languages') as $value) {
         $this->db->set('name'.$value, $array['name'.$value]);
         $this->db->set('shortname'.$value, $array['shortname'.$value]);
         $this->db->set('title'.$value, $array['title'.$value]);
         $this->db->set('keyword'.$value, $array['keyword'.$value]);
         $this->db->set('description'.$value, $array['description'.$value]);
         $this->db->set('text_hover'.$value, $array['text_hover'.$value]);
         $this->db->set('shorttext'.$value, $array['shorttext'.$value]);
         $this->db->set('text'.$value, $array['text'.$value]);
        }
        
        if (isset($array['class'])) $this->db->set('class', $array['class']);
        if (isset($array['discount'])) $this->db->set('discount', $array['discount']);
        if (isset($array['is_uah'])) $this->db->set('is_uah', $array['is_uah']);
        if (isset($array['dis_product_id'])) $this->db->set('dis_product_id', $array['dis_product_id']);
        if (isset($array['date_start'])) $this->db->set('date_start', $array['date_start']);
        if (isset($array['date_end'])) $this->db->set('date_end', $array['date_end']);
        if (isset($array['rel_category_id'])) $this->db->set('rel_category_id', $array['rel_category_id']);
        if (isset($array['rel_brand_id'])) $this->db->set('rel_brand_id', $array['rel_brand_id']);
        if (isset($array['rel_object_id'])) $this->db->set('rel_object_id', $array['rel_object_id']);
        
        if (isset($array['id']) && is_numeric($array['id'])) {
            
            
            if ($array['manual']) $this->db->set('link', $array['link']);
            else {
             if (isset($array['link']) && !empty($array['link'])) {
              $pos = strrpos($array['link'], '-'.$array['id']);
              if ($pos !== false) $array['link'] = substr($array['link'], 0, $pos);
             }
             $this->db->set('link', rtrim($array['link'], '-').'-'.$array['id']);
            }
            $this->db->set('manual', $array['manual']);
            
            
            $this->db->where("id = '{$array['id']}'")->update('site_catalog_share');
            $objectid = $array['id'];
            
        } else {
            
            if ($array['manual']) $this->db->set('link', $array['link']);
            $this->db->set('manual', $array['manual']);
            
            $this->db->insert('site_catalog_share');
            $objectid = $this->db->insert_id();
            
            if (!$array['manual']) $this->db->set('link', rtrim($array['link'], '-').'-'.$objectid);
            $this->db->set('position', $objectid)->where('id = '.$this->db->escape($objectid))->update('site_catalog_share');
            
        }
        
        if (isset($array['image']['image']) && !empty($array['image']['image']) && isset($array['image']['image_big']) && !empty($array['image']['image_big']) && isset($array['image']['image_obj']) && !empty($array['image']['image_obj'])) {
         $this->load->library('image_my_lib');
         $res = $this->db->select('image_hd, image_square, image_obj')->from('site_catalog_share')->where("id = '{$objectid}'")->limit(1)->get();
 
         if ($res->num_rows() > 0) {
          $res = $res->row_array();
          
          $this->image_my_lib->delImage($res['image_hd']);
          $this->image_my_lib->delImage($res['image_square']);
          $this->image_my_lib->delImage($res['image_obj']);
         }
     
         $this->db->set('image_obj', $array['image']['image_obj'])->set('image_square', $array['image']['image'])->set('image_hd', $array['image']['image_big'])->where('id = '.$this->db->escape($objectid))->update('site_catalog_share');
        }
        
        if (!$same) $this->updatus($array, $objectid);

        return $objectid;
        
    }

    public function get_same($array = array()) {
     if (!is_array($array) || empty($array) || !isset($array['date_start']) || empty($array['date_start']) || !isset($array['date_end']) || empty($array['date_end'])) return false;

     if (isset($array['rel_object_id']) && $array['rel_object_id'] > 0) {

      $query = '
       SELECT `site_catalog_share`.`id`
       FROM (`site_catalog_share`)
       WHERE `site_catalog_share`.`rel_object_id` = "'.$array['rel_object_id'].'"
        AND 
         ("'.$array['date_start'].'" BETWEEN `site_catalog_share`.`date_start` AND `site_catalog_share`.`date_end` OR
          "'.$array['date_end'].'" BETWEEN `site_catalog_share`.`date_start` AND `site_catalog_share`.`date_end`
         )
      ';

      if (isset($array['id']) && $array['id'] > 0) $query .= ' AND `site_catalog_share`.`id` <> "'.$array['id'].'" ';

      $shares = $this->db->query($query)->result_array();
      if (empty($shares)) return false;

     } else if (isset($array['rel_brand_id']) && $array['rel_brand_id'] > 0) {

      $query = '
       SELECT `site_catalog_share`.`id`
       FROM (`site_catalog_share`)
       WHERE `site_catalog_share`.`rel_brand_id` = "'.$array['rel_brand_id'].'"
        AND 
         ("'.$array['date_start'].'" BETWEEN `site_catalog_share`.`date_start` AND `site_catalog_share`.`date_end` OR
          "'.$array['date_end'].'" BETWEEN `site_catalog_share`.`date_start` AND `site_catalog_share`.`date_end`
         )
      ';

      if (isset($array['id']) && $array['id'] > 0) $query .= ' AND `site_catalog_share`.`id` <> "'.$array['id'].'" ';

      $shares = $this->db->query($query)->result_array();
      if (empty($shares)) return false;

     } else if (isset($array['rel_category_id']) && $array['rel_category_id'] > 0) {

      $query = '
       SELECT `site_catalog_share`.`id`
       FROM (`site_catalog_share`)
       WHERE `site_catalog_share`.`rel_category_id` = "'.$array['rel_category_id'].'"
        AND 
         ("'.$array['date_start'].'" BETWEEN `site_catalog_share`.`date_start` AND `site_catalog_share`.`date_end` OR
          "'.$array['date_end'].'" BETWEEN `site_catalog_share`.`date_start` AND `site_catalog_share`.`date_end`
         )
      ';

      if (isset($array['id']) && $array['id'] > 0) $query .= ' AND `site_catalog_share`.`id` <> "'.$array['id'].'" ';

      $shares = $this->db->query($query)->result_array();
      if (empty($shares)) return false;

     } else return false;

     return true;
    }

    public function updatus($array = array(), $shareid = 0)  {
     $shareid = (int)$shareid;
     if (!is_array($array) || empty($array) || $shareid <= 0) return false;

     #clear current promo
     $this->db->where('shareid = '.$this->db->escape($shareid))->delete('site_catalog_share_catalog');

     if (isset($array['rel_object_id']) && $array['rel_object_id'] > 0) {

      #remove all current promo by object
      $query = "
       SELECT `site_catalog_share_catalog`.`id`
       FROM (`site_catalog_share_catalog`, `site_catalog_share`)
       WHERE 
        `site_catalog_share_catalog`.`shareid` = `site_catalog_share`.`id`
        AND `site_catalog_share_catalog`.`catalogid` = '".$array['rel_object_id']."'
        AND site_catalog_share.date_start <= '".date('Y-m-d')."' 
        AND site_catalog_share.date_end > '".date('Y-m-d')."'
       
       GROUP BY `site_catalog_share_catalog`.`id`
      ";
      $res = $this->db->query($query)->result_array();
      foreach ($res as $one) 
       $this->db->where('id = '.$this->db->escape($one['id']))->limit(1)->delete('site_catalog_share_catalog');

      #insert new
      $this->db->set('catalogid', $array['rel_object_id'])->set('shareid', $shareid)->insert('site_catalog_share_catalog');

     } else if (isset($array['rel_brand_id']) && $array['rel_brand_id'] > 0) {

      #remove catalog and brand current promo
      $query = "
       SELECT `site_catalog_share_catalog`.`id`
       FROM (`site_catalog_share_catalog`, `site_catalog_share`)
       WHERE 
        `site_catalog_share_catalog`.`shareid` = `site_catalog_share`.`id`
        AND `site_catalog_share_catalog`.`catalogid` <> `site_catalog_share`.`rel_object_id`
        AND site_catalog_share.date_start <= '".date('Y-m-d')."' 
        AND site_catalog_share.date_end > '".date('Y-m-d')."'

        AND `site_catalog_share_catalog`.`catalogid` IN (
         SELECT `site_catalog`.`id`
         FROM (`site_catalog`, `site_catalog_filters_catalog`)

         WHERE 
          `site_catalog`.`id` = `site_catalog_filters_catalog`.`catalog_id`
          AND `site_catalog_filters_catalog`.`filter_id` = '".$array['rel_brand_id']."'

        )
       
       GROUP BY `site_catalog_share_catalog`.`id`
      ";
      $res = $this->db->query($query)->result_array();
      foreach ($res as $one) 
       $this->db->where('id = '.$this->db->escape($one['id']))->limit(1)->delete('site_catalog_share_catalog');

      #insert by brand without by object
      $query = "
       SELECT `site_catalog`.`id`
       FROM (`site_catalog`, `site_catalog_filters_catalog`)

       WHERE 
        `site_catalog`.`id` = `site_catalog_filters_catalog`.`catalog_id`
        AND `site_catalog_filters_catalog`.`filter_id` = '".$array['rel_brand_id']."'

        AND `site_catalog`.`id` NOT IN (
          SELECT `site_catalog_share_catalog`.`catalogid`
          FROM (`site_catalog_share_catalog`, `site_catalog_share`)
          WHERE `site_catalog_share_catalog`.`shareid` = `site_catalog_share`.`id`
           AND `site_catalog_share`.`rel_object_id` = `site_catalog_share_catalog`.`catalogid`
           AND site_catalog_share.date_start <= '".date('Y-m-d')."' 
           AND site_catalog_share.date_end > '".date('Y-m-d')."'
         )

       GROUP BY `site_catalog`.`id`
       ;
      ";

      $objs = $this->db->query($query)->result_array();

      foreach ($objs as $one) {
       $this->db->set('shareid', $shareid)->set('catalogid', $one['id'])->insert('site_catalog_share_catalog');
      }

     } else if (isset($array['rel_category_id']) && $array['rel_category_id'] > 0) {

      #insert by category without by brand and by object
      $query = "
       SELECT `site_catalog`.`id`
       FROM (`site_catalog`, `site_catalog_category`)
       
       WHERE 
        `site_catalog`.`id` = `site_catalog_category`.`catalogid`
        AND `site_catalog_category`.`categoryid` = '".(int)$array['rel_category_id']."'
        AND `site_catalog_category`.`main` = 1

        AND `site_catalog`.`id` NOT IN (
          SELECT `site_catalog_share_catalog`.`catalogid`
          FROM (`site_catalog_share_catalog`, `site_catalog_share`)
          WHERE `site_catalog_share_catalog`.`shareid` = `site_catalog_share`.`id`
           AND 
            (
             `site_catalog_share`.`rel_object_id` = `site_catalog_share_catalog`.`catalogid`
             OR `site_catalog_share`.`rel_brand_id` = `site_catalog_share_catalog`.`catalogid`
            )
           AND site_catalog_share.date_start <= '".date('Y-m-d')."' 
           AND site_catalog_share.date_end > '".date('Y-m-d')."'
         )

       GROUP BY `site_catalog`.`id`
       ;
      ";

      $objs = $this->db->query($query)->result_array();
      
      foreach ($objs as $one) {
       $this->db->set('shareid', $shareid)->set('catalogid', $one['id'])->insert('site_catalog_share_catalog');
      }

     } else return false;
     
     return true;
    }
    //---end SAVE PAGE
    
    public function deleteV($id) {
     
     $id = (int)$id;
     if ($id <= 0) return false;
     
     $this->load->library('image_my_lib');
     $res = $this->db->select('image_hd, image_square, image_obj')->from('site_catalog_share')->where("id = '{$id}'")->limit(1)->get();

     if ($res->num_rows() > 0) {
      $res = $res->row_array();
      
      $this->image_my_lib->delImage($res['image_hd']);
      $this->image_my_lib->delImage($res['image_square']);
      $this->image_my_lib->delImage($res['image_obj']);
     }
     
     $this->db->where('shareid = '.$this->db->escape($id))->delete('site_catalog_share_catalog');
     #$this->db->set('shareid', 0)->where('shareid = '.$this->db->escape($id))->update('site_catalog');

     $this->db->where("id = '{$id}'")->limit(1)->delete('site_catalog_share');
     
    }
    
}