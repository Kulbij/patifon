<?php

class Gallery_gallery_library {
    
    private $ci;
    
    private $model;
    
    function __construct() {
        
        $this->ci = &get_instance();
        
        $this->ci->load->model('gallery/gallery_gallery_model', 'model');
        
    }
    
    public function save($array, $catid = 0) {
        
        $catid = (int)$catid;
        
        if (isset($array['filearray']) && !empty($array['filearray'])) {
            
            $this->ci->load->library('image_my_lib');
            $images = $this->ci->image_my_lib->createGalleryImage($array['filearray'], $catid);
            
            $data = array();
            $data['img'] = $this->ci->model->save($images, $catid);
            $this->ci->load->view('gallery/gallery_ajax_view', $data);
            
        }
        
    }
    
    public function remove($id) {
        
        $id = (int)$id;
        if ($id <= 0) return false;
        
        $this->ci->model->remove($id);
        
        return true;
        
    }
    
    public function setVis($id) {
        
        $id = (int)$id;
        if ($id <= 0) return false;
        
        $this->ci->model->setVis($id);
        
        return true;
        
    }
    
    public function setUnVis($id) {
        
        $id = (int)$id;
        if ($id <= 0) return false;
        
        $this->ci->model->setUnVis($id);
        
        return true;
        
    }
    
    public function setPos($where, $id) {
        
        $id = (int)$id;
        if ($id <= 0) return false;
        
        if ($where == 'up') $this->ci->model->setUp($id);
        elseif ($where == 'down') $this->ci->model->setDown($id);
        
        return true;
        
    }
    
}