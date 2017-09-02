<?php

class Page_questiontheme_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function remove($id) {
        
        $id = (int)$id;
        
        if ($id > 0) {
            
            $this->ci->load->model('page/page_questiontheme_model', 'model');
            $this->ci->model->remove($id);
            
        }
        
    }
    
    public function save($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->model('page/page_questiontheme_model', 'model');
            return $this->ci->model->save($array);
            
        }
        
    }
    
}