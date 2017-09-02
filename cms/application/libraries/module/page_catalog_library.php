<?php

class Page_catalog_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setPageCatVisible($id) {
        
        $this->ci->load->model('catalog/catalog_catalog_model', 'model');
        $this->ci->model->setVisible($id);
        
    }
    
    public function setPageCatUnVisible($id) {
        
        $this->ci->load->model('catalog/catalog_catalog_model', 'model');
        $this->ci->model->setUnVisible($id);
        
    }
    
    public function setPageCatPosition($array) {
        
        if (isset($array['idis']) && is_array($array['idis']) &&
            isset($array['posis']) && is_array($array['posis']) &&
            count($array['idis']) == count($array['posis'])) {
            
            $this->ci->load->model('catalog/catalog_catalog_model', 'model');
            
            $idis = $array['idis'];
            $posis = $array['posis'];
            
            $count__ = count($idis);
            
            for ($i = 0; $i < $count__; ++$i) {
                $this->ci->model->setCatPos($idis[$i], $posis[$i]);
            }
            
        }
        
    }
    
    public function savePageCat($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->library('security/data_lib.php');
            
            if (isset($array['name_ua']) && !empty($array['name_ua'])) $array['name_ua'] = $this->ci->data_lib->tryData($array['name_ua'], 500);
            if (isset($array['name_ru']) && !empty($array['name_ru'])) $array['name_ru'] = $this->ci->data_lib->tryData($array['name_ru'], 500);
            
            if (isset($array['title_ua']) && !empty($array['title_ua'])) $array['title_ua'] = $this->ci->data_lib->tryData($array['title_ua'], 500);
            if (isset($array['title_ru']) && !empty($array['title_ru'])) $array['title_ru'] = $this->ci->data_lib->tryData($array['title_ru'], 500);
            
            if (isset($array['keyword_ua']) && !empty($array['keyword_ua'])) $array['keyword_ua'] = $this->ci->data_lib->tryData($array['keyword_ua'], 500);
            if (isset($array['keyword_ru']) && !empty($array['keyword_ru'])) $array['keyword_ru'] = $this->ci->data_lib->tryData($array['keyword_ru'], 500);
            
            if (isset($array['description_ua']) && !empty($array['description_ua'])) $array['description_ua'] = $this->ci->data_lib->tryData($array['description_ua'], 5000);
            if (isset($array['description_ru']) && !empty($array['description_ru'])) $array['description_ru'] = $this->ci->data_lib->tryData($array['description_ru'], 5000);
            
            if (isset($array['text_ua']) && !empty($array['text_ua'])) $array['text_ua'] = $this->ci->data_lib->tryData($array['text_ua'], 100000);
            if (isset($array['text_ru']) && !empty($array['text_ru'])) $array['text_ru'] = $this->ci->data_lib->tryData($array['text_ru'], 100000);
            
            if (isset($array['visible']) && is_numeric($array['visible']) && in_array($array['visible'], array(0, 1))) $array['visible'] = $array['visible'];
            
            $this->ci->load->model('catalog/catalog_catalog_model', 'model');
            
            $this->ci->model->saveCat($array);
            
        }
        
    }
    
}