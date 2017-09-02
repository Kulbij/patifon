<?php

class Catalog_pakets_library {

    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setVis($id, $stock = false) {
        $this->ci->load->model('catalog/catalog_pakets_model', 'model');
        $this->ci->model->setVisible($id, $stock);
    }
    
    public function setUnVis($id, $stock = false) {
        $this->ci->load->model('catalog/catalog_pakets_model', 'model');
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
            $return = $this->ci->catalog_object_model->delImage($id);
            
            return $return;
            
        }
        
        return $return;
        
    }
    
    public function saveGarag($array) {
        if (count($array) > 0) {
            $this->ci->load->library('image_my_lib');
            $this->ci->load->model('catalog/catalog_pakets_model', 'model');

            if(isset($array['id']) && !empty($array['id']) && $this->ci->model->gererateIDOpttion($array['id']) == true){
                $array['image'] = $this->ci->image_my_lib->createPakets();

                $return = $this->ci->model->upOption($array);
                return $return;
            } else {
                $array['image'] = $this->ci->image_my_lib->createPakets();

                 $return = $this->ci->model->inOption($array);
                return $return;
            }
        
        }
        return $return;
        
}
    
    public function remove($objid) {
        
        if (is_numeric($objid) && $objid > 0) {
            
            $this->ci->load->model('catalog/catalog_pakets_model', 'model');
            return $this->ci->model->remove($objid);
            
        }
        
        return false;
        
    }
    
}