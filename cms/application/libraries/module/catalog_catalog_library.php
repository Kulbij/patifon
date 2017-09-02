<?php

class Catalog_catalog_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setVis($id) {
        
        $this->ci->load->model('catalog/catalog_catalog_model', 'model');
        $this->ci->model->setVisible($id);
        
    }
    
    public function setUnVis($id) {
        
        $this->ci->load->model('catalog/catalog_catalog_model', 'model');
        $this->ci->model->setUnVisible($id);
        
    }
    
    public function setPos($where, $id) {
        
        $this->ci->load->model('catalog/catalog_catalog_model', 'model');
        if ($where == 'up') $this->ci->model->setUp($id);
        if ($where == 'down') $this->ci->model->setDown($id);
        
        return true;
        
    }
    
    public function saveCatalog($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->library('security/data_lib');
            
            if (isset($array['name_ua']) && !empty($array['name_ua'])) $array['name_ua'] = $this->ci->data_lib->tryData($array['name_ua'], 510);
            if (isset($array['shortname_ua']) && !empty($array['shortname_ua'])) $array['shortname_ua'] = $this->ci->data_lib->tryData($array['shortname_ua'], 510);
            if (isset($array['title_ua']) && !empty($array['title_ua'])) $array['title_ua'] =$this->ci->data_lib->tryData($array['title_ua'], 510);
            if (isset($array['keyword_ua']) && !empty($array['keyword_ua'])) $array['keyword_ua'] = $this->ci->data_lib->tryData($array['keyword_ua'], 510);
            if (isset($array['description_ua']) && !empty($array['description_ua'])) $array['description_ua'] = $this->ci->data_lib->tryData($array['description_ua'], 50000);
            if (isset($array['text_ua']) && !empty($array['text_ua'])) $array['text_ua'] = $this->ci->data_lib->tryData($array['text_ua'], 5000000);
            
            if (isset($array['name_ru']) && !empty($array['name_ru'])) $array['name_ru'] = $this->ci->data_lib->tryData($array['name_ru'], 510);
            if (isset($array['shortname_ru']) && !empty($array['shortname_ru'])) $array['shortname_ru'] = $this->ci->data_lib->tryData($array['shortname_ru'], 510);
            if (isset($array['title_ru']) && !empty($array['title_ru'])) $array['title_ru'] =$this->ci->data_lib->tryData($array['title_ru'], 510);
            if (isset($array['keyword_ru']) && !empty($array['keyword_ru'])) $array['keyword_ru'] = $this->ci->data_lib->tryData($array['keyword_ru'], 510);
            if (isset($array['description_ru']) && !empty($array['description_ru'])) $array['description_ru'] = $this->ci->data_lib->tryData($array['description_ru'], 50000);
            if (isset($array['text_ru']) && !empty($array['text_ru'])) $array['text_ru'] = $this->ci->data_lib->tryData($array['text_ru'], 5000000);
            
            if (!isset($array['parentid']) || !is_numeric($array['parentid']) || $array['parentid'] < 0) $array['parentid'] = 0;
            
            if (!isset($array['visible']) || !in_array($array['visible'], array(0, 1))) $array['visible'] = 1;
            
            $this->ci->load->model('catalog/catalog_catalog_model', 'model');
            
            $this->ci->load->library('image_my_lib');
            $array['cat_image'] = $this->ci->image_my_lib->createCatalogImage();
            $array['cat_image_top'] = $this->ci->image_my_lib->createDImage(
             array(
              'file' => 'cat_image_top',
              'where' => 'menu',
              'set_old_name' => true,
              'width' => 320,
              'height' => 396
             )
            );
            
            return $this->ci->model->savePage($array);
            
        }
        
    }
    
    public function delMenu($id) {
        
        if (is_numeric($id) && $id > 0) {
            
            $this->ci->load->model('catalog/catalog_catalog_model', 'model');
            $this->ci->model->delMenu($id);
            
        }
        
    }
    
}