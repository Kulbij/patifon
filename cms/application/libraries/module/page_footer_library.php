<?php

class Page_footer_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function saveFooter($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->model('page/page_footer_model', 'model');
            $this->ci->model->saveFooter($array);
            
        }
        
    }
    
    public function setPageFooterPosition($array) {
        
        if (isset($array['idis']) && is_array($array['idis']) &&
            isset($array['posis']) && is_array($array['posis']) &&
            count($array['idis']) == count($array['posis'])) {
            
            $this->ci->load->model('page/page_footer_model', 'model');
            
            $idis = $array['idis'];
            $posis = $array['posis'];
            
            $count__ = count($idis);
            
            for ($i = 0; $i < $count__; ++$i) {
                $this->ci->model->setPageFooterPos($idis[$i], $posis[$i]);
            }
            
        }
        
    }
    
}