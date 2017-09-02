<?php

class Setting_scripts_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function saveOption($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->model('setting/setting_scripts_model', 'model');
            return $this->ci->model->saveOption($array);
            
        }
        
    }
    
    public function delOption($id) {
        
        $this->ci->load->model('setting/setting_scripts_model', 'model');
        $this->ci->model->delOption($id);
        
    }
    
}