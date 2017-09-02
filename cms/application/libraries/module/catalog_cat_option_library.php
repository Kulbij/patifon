<?php

class Catalog_cat_option_library {

    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setVis($id, $stock = false) {
        
        $this->ci->load->model('catalog/catalog_object_model', 'model');
        $this->ci->model->setVisible($id, $stock);
        
    }
    
    public function setUnVis($id, $stock = false) {
        
        $this->ci->load->model('catalog/catalog_object_model', 'model');
        $this->ci->model->setUnVisible($id, $stock);
        
    }
    
    public function delImage($id) {
        
        if (is_numeric($id) && $id > 0) {

            $this->ci->load->model('catalog/catalog_object_model');
            $return = $this->ci->catalog_object_model->delImage($id);
            
            return $return;
            
        }
        
        return $return;
        
    }
    
    public function saveGarag($array) {

        if (count($array) > 0) {
            $this->ci->load->model('catalog/catalog_cat_option_model', 'model');

            if(isset($array['id']) && !empty($array['id']) && $this->ci->model->gererateIDOpttion($array['id']) == true){
                $return = $this->ci->model->upOption($array);
                return $return;
            } else {
                 $return = $this->ci->model->inOption($array);
                return $return;
            }
        }
        
        
        return $return;    
    }
    

    
}