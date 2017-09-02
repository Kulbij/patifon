<?php

class Page_share_cat_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function saveArtical($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->library('security/data_lib');
            
            if (isset($array['name']) && !empty($array['name'])) $array['name'] = $this->ci->data_lib->tryData($array['name'], 510);
            
            if (isset($array['visible']) && is_numeric($array['visible']) && in_array($array['visible'], array(0, 1))) $array['visible'] = $array['visible'];
            
            $this->ci->load->model('page/page_share_cat_model', 'model');
            $this->ci->load->library('image_my_lib');
            $array['art_img'] = $this->ci->image_my_lib->createShareCatImage();
            return $this->ci->model->saveArtical($array);
            
        }
        
    }
    
    public function deleteArt($id) {
        
        $this->ci->load->model('page/page_share_cat_model', 'model');
        $this->ci->model->deleteArt($id);
        
    }
    
    public function setVis($id) {
        
        $this->ci->load->model('page/page_share_cat_model', 'model');
        $this->ci->model->setVis($id);
        
    }
    
    public function setUnVis($id) {
        
        $this->ci->load->model('page/page_share_cat_model', 'model');
        $this->ci->model->setUnVis($id);
        
    }
    
    public function setPos($where, $id) {
        
        $this->ci->load->model('page/page_share_cat_model', 'model');
        if ($where == 'up') $this->ci->model->setUp($id);
        if ($where == 'down') $this->ci->model->setDown($id);
        
        return true;
        
    }
    
}