<?php

class Page_indexban_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setPageIndexImgVisible($id) {
        
        $this->ci->load->model('page/page_indexban_model', 'model');
        $this->ci->model->setVisible($id);
        
    }
    
    public function setPageIndexImgUnVisible($id) {
        
        $this->ci->load->model('page/page_indexban_model', 'model');
        $this->ci->model->setUnVisible($id);
        
    }
    
    public function setPos($where, $id) {
        
        $this->ci->load->model('page/page_indexban_model', 'model');
        if ($where == 'up') $this->ci->model->setUp($id);
        if ($where == 'down') $this->ci->model->setDown($id);
        
        return true;
        
    }
    
    public function saveIndImg($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->library('security/data_lib.php');
            
            if (isset($array['link']) && !empty($array['link'])) $array['link'] = $this->ci->data_lib->tryData($array['link'], 500);
            
            $this->ci->load->library('image_my_lib');
            $array['image'] = $this->ci->image_my_lib->createBanImage();
            
            $this->ci->load->model('page/page_indexban_model', 'model');
            
            return $this->ci->model->saveIndexImg($array);
            
        }
    }
    
    public function deleteImage($id) {
        
        $this->ci->load->model('page/page_indexban_model', 'model');
        $this->ci->model->delImage($id);
        
    }

}