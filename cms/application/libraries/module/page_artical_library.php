<?php

class Page_artical_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function saveArtical($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->library('security/data_lib');
            
            if (isset($array['name']) && !empty($array['name'])) $array['name'] = $this->ci->data_lib->tryData($array['name'], 500);
            if (isset($array['title']) && !empty($array['title'])) $array['title'] = $this->ci->data_lib->tryData($array['title'], 500);
            if (isset($array['keyword']) && !empty($array['keyword'])) $array['keyword'] = $this->ci->data_lib->tryData($array['keyword'], 500);
            if (isset($array['description']) && !empty($array['description'])) $array['description'] = $this->ci->data_lib->tryData($array['description'], 5000);
            if (isset($array['shortdesc']) && !empty($array['shortdesc'])) $array['shortdesc'] = $this->ci->data_lib->tryData($array['shortdesc'], 100000);
            if (isset($array['desc']) && !empty($array['desc'])) $array['desc'] = $this->ci->data_lib->tryData($array['desc'], 100000);
            
            if (isset($array['visible']) && is_numeric($array['visible']) && in_array($array['visible'], array(0, 1))) $array['visible'] = $array['visible'];
            
            if (isset($array['menuid']) && is_numeric($array['menuid'])) $array['menuid'] = $array['menuid'];
            
            $this->ci->load->model('page/page_artical_model', 'model');
            $this->ci->load->library('image_my_lib');
            $array['art_img'] = $this->ci->image_my_lib->createArticalImage();
            
            #$array['image'] = $this->ci->image_my_lib->createPageImage('image', 'articles');
            #$array['image2'] = $this->ci->image_my_lib->createPageImage('image2', 'articles');
            
            return $this->ci->model->saveArtical($array);
            
        }
        
    }
    
    public function deleteArt($id) {
        
        $this->ci->load->model('page/page_artical_model', 'model');
        $this->ci->model->deleteArt($id);
        
    }
    
    public function setVis($id) {
        
        $this->ci->load->model('page/page_artical_model', 'model');
        $this->ci->model->setVis($id);
        
    }
    
    public function setUnVis($id) {
        
        $this->ci->load->model('page/page_artical_model', 'model');
        $this->ci->model->setUnVis($id);
        
    }
    
}