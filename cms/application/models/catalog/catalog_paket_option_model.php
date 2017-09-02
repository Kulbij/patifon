<?php

class catalog_paket_option_model extends CI_Model
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

        if($page == 0) {
            $this->db->select('site_paket_option.id, site_paket_option.name_ru as name, site_paket_option.text_ru as tezt,
                site_paket_option.price, site_paket_option.visible, site_paket_option.position');
            
            $this->db->from('site_paket_option');
            $res = $this->db->order_by('site_paket_option.position', 'ASC')->get();
            
            if ($res->num_rows() <= 0) return array();
            
            $res = $res->result_array();
        } else {
            $query = $this->db->select('*')->where('site_paket_option_category_catalog.catalogid', (int)$page)
            ->from('site_paket_option_category_catalog')->get();

            if($query->num_rows() <= 0) return false;
            $query = $query->result_array();

            $idis = [];
            foreach($query as $value){
                $idis[] = $value['mainid'];
            } unset($value);

            $query2 = $this->db->select('site_paket_option.id, site_paket_option.name_ru as name,
                site_paket_option.visible, site_paket_option.position')
            ->where_in('site_paket_option.id', $idis)
            ->order_by('site_paket_option.position', 'ASC')
            ->from('site_paket_option')->get();

            if($query2->num_rows() <= 0) return false;
            $res = $query2->result_array();
        }
        
        return $res;
        
    }

    public function getOneCategory($id){
        $id = (int)$id;
        if($id <= 0) return false;

        $res = $this->db->select('site_paket_option_category_catalog.catalogid')
        ->where('site_paket_option_category_catalog.mainid', $id)
        ->from('site_paket_option_category_catalog')->get();

        if($res->num_rows() <= 0) return false;
        $res = $res->result_array()[0]['catalogid'];

        return $res;
    }

    public function inOption($array = array()){
        if(!isset($array) && empty($array) && count($array) <= 0) return false;

        foreach ($this->config->item('config_languages') as $value) {
            $this->db->set('name'.$value, $array['name'.$value]);
            $this->db->set('text'.$value, $array['text'.$value]);
        }

        $this->db->set('price', $array['price']);

        $this->db->insert('site_paket_option');

        $id = $this->db->insert_id();

        $this->db->set('site_catalog.paket_option', $id)->set('site_catalog.price', $array['price'])
        ->set('site_catalog.name_ru', $array['name_ru'])->set('site_catalog.text_ru', $array['text_ru'])
        ->insert('site_catalog');
        $category_id = $this->db->insert_id();

        // catalog category
        $this->db->set('catalogid', $category_id)->set('categoryid', 1)->set('main', 1)->insert('site_catalog_category');
        // =================================================================================

        if(isset($array['cat_option']) && !empty($array['cat_option'])){
            $this->db->where('site_paket_option_category_catalog.mainid', $id)->delete('site_paket_option_category_catalog');
            
            $this->db->set('site_paket_option_category_catalog.mainid', $id)
            ->set('site_paket_option_category_catalog.catalogid', $array['cat_option']);

            $this->db->insert('site_paket_option_category_catalog');
        }

        return $id;
    }

    public function upOption($array = array()){
        if(!isset($array) && empty($array) && count($array) <= 0) return false;

        foreach ($this->config->item('config_languages') as $value) {
            $this->db->set('name'.$value, $array['name'.$value]);
            // $this->db->set('text'.$value, $array['text'.$value]);
        } unset($value);

        $this->db->set('price', $array['price']);

        if(isset($array['id']) && !empty($array['id'])){
            $this->db->where('site_paket_option.id', $array['id']);
            $this->db->update('site_paket_option');
            $return = $array['id'];
            $id = (int)$array['id'];
        } else {
            $this->db->insert('site_paket_option');
            $id = (int)$this->db->insert_id();
        }
        // catalog update
        // ---------------------- get catalog -------------
          $catalog_object = $this->db->select('site_catalog.paket_option, site_catalog.id')
          ->where('site_catalog.paket_option', $id)->from('site_catalog')->limit(1)->get();
          if($catalog_object->num_rows() <= 0) return false;
          $catalog_object = $catalog_object->row_array();
          $new_id_object = $catalog_object['id'];
        // ------------------------------ end ----------------

        $this->db->set('site_catalog.paket_option', $id)->set('site_catalog.price', $array['price'])
        ->set('site_catalog.name_ru', $array['name_ru'])//->set('site_catalog.text_ru', $array['text_ru'])
        ->where('site_catalog.id', (int)$new_id_object)->update('site_catalog');

        // catalog category
        $this->db->where('site_catalog_category.catalogid', $new_id_object)->delete('site_catalog_category');

        $this->db->set('catalogid', $new_id_object)->set('categoryid', 1)->set('main', 1)->insert('site_catalog_category');
        // =================================================================================

        if(isset($array['cat_option']) && !empty($array['cat_option'])){
            $this->db->where('site_paket_option_category_catalog.mainid', $array['id'])->delete('site_paket_option_category_catalog');
            
            $this->db->set('site_paket_option_category_catalog.mainid', $array['id'])
            ->set('site_paket_option_category_catalog.catalogid', $array['cat_option']);

            $this->db->insert('site_paket_option_category_catalog');

        }

        if(isset($array['option']) && !empty($array['option']) && count($array['option']) > 0){
          $this->db->where('site_pakets_ccatalog.main_id', $array['id'])->delete('site_pakets_ccatalog');

          foreach($array['option'] as $key => $value){
            $this->db->set('site_pakets_ccatalog.catalog_id', $value)->set('site_pakets_ccatalog.main_id', $array['id']);
            $this->db->insert('site_pakets_ccatalog');
          } unset($value);

        } else $this->db->where('site_pakets_ccatalog.main_id', $array['id'])->delete('site_pakets_ccatalog');

        if(isset($array['sort']) && !empty($array['sort'])) {
          foreach($array['sort'] as $key => $value) {
              $this->db->set('position',$value)
                      ->where('catalog_id',$key)
                      ->where('main_id', $id)
                      ->update('site_pakets_ccatalog');
          }
        }

        return $id;
    }

    public function gererateIDOpttion($id = 0){
        $id = (int)$id;
        if($id <= 0) return false;

        $res = $this->db->select('site_paket_option.id')->where('site_paket_option.id', $id)->from('site_paket_option')->get();

        if($res->num_rows() <= 0) return false;
        $res = $res->result_array();

        return true;
    }

    public function getOne($id = 0){
        $id = (int)$id;
        if(!isset($id) && empty($id) && $id <= 0) return false;

        $res = $this->db->select('*')->where('site_paket_option.id', $id)->from('site_paket_option')->get();

        if($res->num_rows() <= 0) return false;
        $res = $res->result_array();

        return $res[0];
    }
    
    public function remove($id){
        $id = (int)$id;
        if($id <= 0) return false;

        $this->db->where('site_paket_option.id', $id)->delete('site_paket_option');
        $this->db->where('site_paket_option_catalog.mainid', $id)->delete('site_paket_option_catalog');
        $this->db->where('site_catalog.paket_option.mainid', $id)->delete('site_catalog');
        $this->db->where('site_paket_option_category_catalog.mainid', $id)->delete('site_paket_option_category_catalog');
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

    public function getCategory(){
        $res = $this->db->select('site_paket_option_category.name_ru as name, site_paket_option_category.id')
        ->from('site_paket_option_category')->get();

        if($res->num_rows() <= 0) return false;
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

    public function getOptions(){
      $res = $this->db
                    ->select('site_pakets.id, site_pakets.name_'.SITELANG.' as name, site_pakets.position, site_pakets.image')
                    ->where('site_pakets.visible', 1)
                    ->order_by('site_pakets.position', 'ASC')
                    ->from('site_pakets')
                    ->get();

      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();

      return $res;
    }

    public function getOptionID($id){
      if(!isset($id) && empty($id)) return false;
        $id = (int)$id;

      $res = $this->db
                      ->select('site_pakets.id, site_pakets.name_'.SITELANG.' as name, site_pakets.image,
                        site_pakets_ccatalog.catalog_id, site_pakets_ccatalog.main_id, site_pakets_ccatalog.position')
                      ->where('site_pakets_ccatalog.main_id', $id)
                      ->where('site_pakets_ccatalog.catalog_id = site_pakets.id')
                      ->where('site_pakets.visible', 1)
                      ->from('site_pakets_ccatalog')->from('site_pakets')
                      ->order_by('site_pakets_ccatalog.position', 'ASC')
                      ->get();

      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();

      return $res;
    }

    public function getThisID($id){
      if(!isset($id) && empty($id) && $id <= 0) return array();
      $id = (int)$id;

      $res = $this->db
                      ->select('site_pakets_ccatalog.catalog_id')
                      ->where('site_pakets_ccatalog.main_id', $id)
                      ->from('site_pakets_ccatalog')
                      ->get();

      if($res->num_rows() <= 0) return array();
      $res = $res->result_array();

      $idis = [];
      foreach($res as $value){
        $idis[] = $value['catalog_id'];
      } unset($value);

      return $idis;
    }

    public function sortablePaketAjax($data, $id) {
        foreach($data['sort'] as $key => $value) {       
            $this->db->set('position',$value)
                    ->where('catalog_id',$key)
                    ->where('main_id', $id)
                    ->update('site_pakets_ccatalog');
        }
    }
    
}