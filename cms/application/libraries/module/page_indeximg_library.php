<?php

class Page_indeximg_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setPageIndexImgVisible($id) {
        
        $this->ci->load->model('page/page_indeximg_model', 'model');
        $this->ci->model->setVisible($id);
        
    }
    
    public function setPageIndexImgUnVisible($id) {
        
        $this->ci->load->model('page/page_indeximg_model', 'model');
        $this->ci->model->setUnVisible($id);
        
    }
    
    public function setPageIndexImgPos($array) {
        
        if (isset($array['idis']) && is_array($array['idis']) &&
            isset($array['posis']) && is_array($array['posis']) &&
            count($array['idis']) == count($array['posis'])) {
            
            $this->ci->load->model('page/page_indeximg_model', 'model');
            
            $idis = $array['idis'];
            $posis = $array['posis'];
            
            $count__ = count($idis);
            
            for ($i = 0; $i < $count__; ++$i) {
                $this->ci->model->setIndexImgPos($idis[$i], $posis[$i]);
            }
            
        }
        
    }
    
    public function saveIndexImg($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->library('security/data_lib.php');
            
            if (isset($array['name_ua']) && !empty($array['name_ua'])) $array['name_ua'] = $this->ci->data_lib->tryData($array['name_ua'], 500);
            if (isset($array['name_ru']) && !empty($array['name_ru'])) $array['name_ru'] = $this->ci->data_lib->tryData($array['name_ru'], 500);
            if (isset($array['name_en']) && !empty($array['name_en'])) $array['name_en'] = $this->ci->data_lib->tryData($array['name_en'], 500);
            
            if (isset($array['text_ua']) && !empty($array['text_ua'])) $array['text_ua'] = $this->ci->data_lib->tryData($array['text_ua'], 1000);
            if (isset($array['text_ru']) && !empty($array['text_ru'])) $array['text_ru'] = $this->ci->data_lib->tryData($array['text_ru'], 1000);
            if (isset($array['text_en']) && !empty($array['text_en'])) $array['text_en'] = $this->ci->data_lib->tryData($array['text_en'], 1000);
            
            if (!isset($array['visible']) || !is_numeric($array['visible'])) $array['visible'] = 1;
            
            $this->ci->load->library('image_my_lib');
            $array['image'] = $this->ci->image_my_lib->createIndexImage();
            
            $this->ci->load->model('page/page_indeximg_model', 'model');
            
            return $this->ci->model->saveIndexImg($array);
            
        }
    }
    
    protected function remImage($path) {
        @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$path);
    }
    
}