<?php

class Page_catalogtype_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setPageCatTypeVisible($id) {
        
        $this->ci->load->model('catalog/catalog_catalogtype_model', 'model');
        $this->ci->model->setVisible($id);
        
    }
    
    public function setPageCatTypeUnVisible($id) {
        
        $this->ci->load->model('catalog/catalog_catalogtype_model', 'model');
        $this->ci->model->setUnVisible($id);
        
    }
    
    public function setPageCatTypePosition($array) {
        
        if (isset($array['idis']) && is_array($array['idis']) &&
            isset($array['posis']) && is_array($array['posis']) &&
            count($array['idis']) == count($array['posis'])) {
            
            $this->ci->load->model('catalog/catalog_catalogtype_model', 'model');
            
            $idis = $array['idis'];
            $posis = $array['posis'];
            
            $count__ = count($idis);
            
            for ($i = 0; $i < $count__; ++$i) {
                $this->ci->model->setCatTypePos($idis[$i], $posis[$i]);
            }
            
        }
        
    }
    
    public function savePageCatType($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->library('security/data_lib.php');
            
            if (isset($array['name_ua']) && !empty($array['name_ua'])) $array['name_ua'] = $this->ci->data_lib->tryData($array['name_ua'], 500);
            if (isset($array['name_ru']) && !empty($array['name_ru'])) $array['name_ru'] = $this->ci->data_lib->tryData($array['name_ru'], 500);
            if (isset($array['name_en']) && !empty($array['name_en'])) $array['name_en'] = $this->ci->data_lib->tryData($array['name_en'], 500);
            
            $this->ci->load->model('catalog/catalog_catalogtype_model', 'model');
            
            return $this->ci->model->saveCatType($array);
            
        }
    }
        
    public function delCatType($id) {

        $this->ci->load->model('catalog/catalog_catalogtype_model', 'model');
        $this->ci->model->deleteCatType($id);

    }
    
    public function getLink($array) {
        
        if (isset($array['link'])) {
            
            $array['link'] = trim($array['link']);
            
            if (!empty($array['link'])) {
            
                $this->ci->load->model('catalog/catalog_catalogtype_model', 'model');
                if (isset($array['id'])) return $this->ci->model->getLink($array['link'], $array['id']);
                else return $this->ci->model->getLink($array['link']);
            
            }
            
        }
        
        return true;
        
    }
    
}