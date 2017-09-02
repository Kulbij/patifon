<?php

class Gallery_gallerycat_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setVis($id) {
        
        $this->ci->load->model('gallery/gallery_gallerycat_model', 'model');
        $this->ci->model->setVisible($id);
        
    }
    
    public function setUnVis($id) {
        
        $this->ci->load->model('gallery/gallery_gallerycat_model', 'model');
        $this->ci->model->setUnVisible($id);
        
    }
    
    public function setPos($where, $id) {
        
        $this->ci->load->model('gallery/gallery_gallerycat_model', 'model');
        if ($where == 'up') $this->ci->model->setUp($id);
        if ($where == 'down') $this->ci->model->setDown($id);
        
        return true;
        
    }
    
    public function save($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->library('security/data_lib');
            
            if (isset($array['name_ua']) && !empty($array['name_ua'])) $array['name_ua'] = $this->ci->data_lib->tryData($array['name_ua'], 510);
            if (isset($array['name_ru']) && !empty($array['name_ru'])) $array['name_ru'] = $this->ci->data_lib->tryData($array['name_ru'], 510);
            if (isset($array['name_pl']) && !empty($array['name_pl'])) $array['name_pl'] = $this->ci->data_lib->tryData($array['name_pl'], 510);
            
            if (isset($array['text_ua']) && !empty($array['text_ua'])) $array['text_ua'] = $this->ci->data_lib->tryData($array['text_ua'], 10000);
            if (isset($array['text_ru']) && !empty($array['text_ru'])) $array['text_ru'] = $this->ci->data_lib->tryData($array['text_ru'], 10000);
            if (isset($array['text_pl']) && !empty($array['text_pl'])) $array['text_pl'] = $this->ci->data_lib->tryData($array['text_pl'], 10000);
            
            if (!isset($array['visible']) || !in_array($array['visible'], array(0, 1))) $array['visible'] = 1;
            
            $this->ci->load->model('gallery/gallery_gallerycat_model', 'model');
            
            $this->ci->load->library('image_my_lib');
            $falser = false;
            if (isset($array['id']) && $array['id'] == 1) $falser = true;
            $array['image'] = $this->ci->image_my_lib->createGalleryCatImage($falser);
            
            return $this->ci->model->save($array);
            
        }
        
    }
    
    public function remove($id) {
        
        $id = (int)$id;
        if ($id > 0) {
            
            $this->ci->load->model('gallery/gallery_gallerycat_model', 'model');
            $this->ci->model->remove($id);
            
        }
        
    }
    
}