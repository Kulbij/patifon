<?php

class Catalog_object_library {
    
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

    public function setAction() {
        
        $arr_opt = array('vis', 'unvis', 'move', 'price', 'del', 'up_stock', 'down_stock', 'admin_rate', 'sizer_weight');
        
        if (isset($_POST['chord']) && is_array($_POST['chord']) &&
            isset($_POST['idis']) && is_array($_POST['idis']) &&
            #isset($_POST['price']) && is_array($_POST['price']) &&
            isset($_POST['option_']) && in_array($_POST['option_'], $arr_opt) /*&&
            isset($_POST['where_']) && is_numeric($_POST['where_'])*/) {
            
            $this->ci->load->model('catalog/catalog_object_model', 'model');
            
            $chord = $_POST['chord'];
            $idids = $_POST['idis'];
            $option_ = $_POST['option_'];
            $price = $_POST['price'];
            #$where_ = $_POST['where_'];
            
            $width = array();
            if (isset($_POST['width']) && !empty($_POST['width'])) $width = $_POST['width'];
            $height = array();
            if (isset($_POST['height']) && !empty($_POST['height'])) $height = $_POST['height'];
            $depth = array();
            if (isset($_POST['depth']) && !empty($_POST['depth'])) $depth = $_POST['depth'];
            
            $count__ = count($chord);
            
            for ($i = 0; $i < $count__; ++$i) {
                if ($chord[$i] == 1) {
                    if ($option_ == 'vis') {
                        $this->ci->model->setVisible($idids[$i]);
                    }
                    if ($option_ == 'unvis') {
                        $this->ci->model->setUnVisible($idids[$i]);
                    }
                    if ($option_ == 'move') {
                        $this->ci->model->moveObj($idids[$i], $where_);
                    }
                    if ($option_ == 'price') {
                        $this->ci->model->setPriceObj($idids[$i], $price[$i]);
                    }
                    
                    if ($option_ == 'sizer_weight') {
                     if (isset($width[$i]) && isset($height[$i]) && isset($depth[$i])) $this->ci->model->setWHDW($idids[$i], $width[$i], $height[$i], $depth[$i]);
                    }
                    
                    if ($option_ == 'del') {
                        $this->ci->model->removeObj($idids[$i]);
                    }
                }
            }       
           
            
            return true;
            
        }
        
        return false;
        
    }
    
    public function delImage($id) {
        
        if (is_numeric($id) && $id > 0) {
            
            $this->ci->load->model('catalog/catalog_object_model');
            $this->ci->catalog_object_model->delImage($id);
            
            return true;
            
        }
        
        return false;
        
    }
    
    public function saveGarag($array) {

        if (count($array) > 0) {
            
            $this->ci->load->library('security/data_lib');
            
            if (isset($array['name_ua']) && !empty($array['name_ua'])) $array['name_ua'] = $this->ci->data_lib->tryData($array['name_ua'], 500);
            if (isset($array['title_ua']) && !empty($array['title_ua'])) $array['title_ua'] = $this->ci->data_lib->tryData($array['title_ua'], 500);
            if (isset($array['keyword_ua']) && !empty($array['keyword_ua'])) $array['keyword_ua'] = $this->ci->data_lib->tryData($array['keyword_ua'], 500);
            if (isset($array['description_ua']) && !empty($array['description_ua'])) $array['description_ua'] = $this->ci->data_lib->tryData($array['description_ua'], 1000000);
            if (isset($array['text_ua']) && !empty($array['text_ua'])) $array['text_ua'] = $this->ci->data_lib->tryData($array['text_ua'], 5000);
            if (isset($array['alert_ua']) && !empty($array['alert_ua'])) $array['alert_ua'] = $this->ci->data_lib->tryData($array['alert_ua'], 5000);
            if (isset($array['stuff_ua']) && !empty($array['stuff_ua'])) $array['stuff_ua'] = $this->ci->data_lib->tryData($array['stuff_ua'], 500);
            if (isset($array['size_ua']) && !empty($array['size_ua'])) $array['size_ua'] = $this->ci->data_lib->tryData($array['size_ua'], 500);
            
            if (isset($array['name_ru']) && !empty($array['name_ru'])) $array['name_ru'] = $this->ci->data_lib->tryData($array['name_ru'], 500);
            if (isset($array['title_ru']) && !empty($array['title_ru'])) $array['title_ru'] = $this->ci->data_lib->tryData($array['title_ru'], 500);
            if (isset($array['keyword_ru']) && !empty($array['keyword_ru'])) $array['keyword_ru'] = $this->ci->data_lib->tryData($array['keyword_ru'], 500);
            if (isset($array['description_ru']) && !empty($array['description_ru'])) $array['description_ru'] = $this->ci->data_lib->tryData($array['description_ru'], 1000000);
            if (isset($array['text_ru']) && !empty($array['text_ru'])) $array['text_ru'] = $this->ci->data_lib->tryData($array['text_ru'], 5000);
            if (isset($array['alert_ru']) && !empty($array['alert_ru'])) $array['alert_ru'] = $this->ci->data_lib->tryData($array['alert_ru'], 5000);
            if (isset($array['stuff_ru']) && !empty($array['stuff_ru'])) $array['stuff_ru'] = $this->ci->data_lib->tryData($array['stuff_ru'], 500);
            if (isset($array['size_ru']) && !empty($array['size_ru'])) $array['size_ru'] = $this->ci->data_lib->tryData($array['size_ru'], 500);
            
            if (!isset($array['visible']) || !is_numeric($array['visible']) || !in_array($array['visible'], array(0, 1))) $array['visible'] = 1;
            if (!isset($array['warning']) || !is_numeric($array['warning']) || !in_array($array['warning'], array(0, 1))) $array['warning'] = 1;
            if (!isset($array['idcat']) || !is_numeric($array['idcat']) || $array['idcat'] <= 0) $array['idcat'] = 0;
            if (!isset($array['idcomponent']) || !is_numeric($array['idcomponent']) || $array['idcomponent'] <= 0) $array['idcomponent'] = 0;
            if (!isset($array['manufacturer']) || !is_numeric($array['manufacturer']) || $array['manufacturer'] <= 0) $array['manufacturer'] = 0;
            if (!isset($array['margin']) || !is_numeric($array['margin']) || $array['margin'] <= 0) $array['margin'] = 0;
            if (!isset($array['options']) || !is_numeric($array['options']) || $array['options'] <= 0) $array['options'] = 0;
            
            if (!isset($array['price']) || !is_numeric($array['price'])) $array['price'] = 1;
            
            if (!isset($array['items']) || !is_array($array['items'])) $array['items'] = array();
            
            if (!isset($array['items_colf']) || !is_array($array['items_colf'])) $array['items_colf'] = array();
            
            if (!isset($array['comp']) || !is_array($array['comp'])) $array['comp'] = array();
            
            $this->ci->load->model('catalog/catalog_object_model');
            
            $id = 'http';
            
            if (isset($array['id']) && is_numeric($array['id']) && $this->ci->catalog_object_model->ifIs($array['id'])) {
                $this->ci->catalog_object_model->upObj($array);
                $id = $array['id'];
            } else {
             $id = $this->ci->catalog_object_model->insObj($array);
            }
            
            return $id;
            
        }
        
        return 'http';
        
    }
    
    public function removeObj($objid) {
        
        if (is_numeric($objid) && $objid > 0) {
            
            $this->ci->load->model('catalog/catalog_object_model', 'model');
            return $this->ci->model->removeObj($objid);
            
        }
        
        return false;
        
    }
    
}