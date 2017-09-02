<?php

class Catalog_wr_size_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setVis($id) {
        
        $this->ci->load->model('catalog/catalog_wr_size_model', 'model');
        $this->ci->model->setVisible($id);
        
    }
    
    public function setUnVis($id) {
        
        $this->ci->load->model('catalog/catalog_wr_size_model', 'model');
        $this->ci->model->setUnVisible($id);
        
    }
    
    public function setPos($where, $id) {
     
     $this->ci->load->model('catalog/catalog_wr_size_model', 'model');
     if ($where == 'up') $this->ci->model->setUp($id);
     if ($where == 'down') $this->ci->model->setDown($id);
     
     return true;
     
    }
    
    public function deleteV($id) {
        
        $this->ci->load->model('catalog/catalog_wr_size_model', 'model');
        $this->ci->model->deleteV($id);
        
    }
    
    public function saveV($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->library('security/data_lib');
            
            if (isset($array['name_ua']) && !empty($array['name_ua'])) $array['name_ua'] = $this->ci->data_lib->tryData($array['name_ua'], 510);
            
            if (isset($array['name_ru']) && !empty($array['name_ru'])) $array['name_ru'] = $this->ci->data_lib->tryData($array['name_ru'], 510);
            
            if (isset($array['name_en']) && !empty($array['name_en'])) $array['name_en'] = $this->ci->data_lib->tryData($array['name_en'], 510);
            
            $this->ci->load->library('image_my_lib');
            $array['image'] = $this->ci->image_my_lib->createDImage(
             array(
              'file' => 'image',
              'width' => 150,
              'height' => 150,
              'where' => 'wr-size'
             )
            );
            
            $this->ci->load->model('catalog/catalog_wr_size_model', 'model');
            return $this->ci->model->savePage($array);
            
        }
        
    }
    
}