<?php

class Page_topphones_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setVis($id) {
        
        $id = (int)$id;
        
        if ($id > 0) {
            
            $this->ci->load->model('page/page_topphones_model', 'model');
            $this->ci->model->setVis($id);
            
        }
        
    }
    
    public function setUnVis($id) {
        
        $id = (int)$id;
        
        if ($id > 0) {
            
            $this->ci->load->model('page/page_topphones_model', 'model');
            $this->ci->model->setUnVis($id);
            
        }
        
    }
    
    public function remove($id) {
        
        $id = (int)$id;
        
        if ($id > 0) {
            
            $this->ci->load->model('page/page_topphones_model', 'model');
            $this->ci->model->remove($id);
            
        }
        
    }
    
    public function saveFooter($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->library('image_my_lib');
            $array['image'] = $this->ci->image_my_lib->createPhoneImage();
            
            $this->ci->load->model('page/page_topphones_model', 'model');
            return $this->ci->model->saveFooter($array);
            
        }
        
    }
    
    public function setPosition($where, $id) {
        
        $this->ci->load->model('page/page_topphones_model', 'model');
        if ($where == 'up') $this->ci->model->setUp($id);
        if ($where == 'down') $this->ci->model->setDown($id);
        
        return true;
        
    }
    
    public function setPageFooterPosition($array) {
        
        if (isset($array['idis']) && is_array($array['idis']) &&
            isset($array['posis']) && is_array($array['posis']) &&
            count($array['idis']) == count($array['posis'])) {
            
            $this->ci->load->model('page/page_topphones_model', 'model');
            
            $idis = $array['idis'];
            $posis = $array['posis'];
            
            $count__ = count($idis);
            
            for ($i = 0; $i < $count__; ++$i) {
                $this->ci->model->setPageFooterPos($idis[$i], $posis[$i]);
            }
            
        }
        
    }
    
}