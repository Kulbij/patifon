<?php

class Page_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setPageVisible($id) {
        
        $this->ci->load->model('page/page_page_model', 'model');
        $this->ci->model->setVisible($id);
        
    }
    
    public function setPageUnVisible($id) {
        
        $this->ci->load->model('page/page_page_model', 'model');
        $this->ci->model->setUnVisible($id);
        
    }
    
    public function setPagePosition($where, $id) {
        
        $this->ci->load->model('page/page_page_model', 'model');
        if ($where == 'up') $this->ci->model->setUp($id);
        if ($where == 'down') $this->ci->model->setDown($id);
        
        return true;
        
    }
    
    public function savePage($array) {
    
        if (count($array) > 0) {
            
            $this->ci->load->library('security/data_lib');
            
            if (isset($array['name_ua']) && !empty($array['name_ua'])) $array['name_ua'] = $this->ci->data_lib->tryData($array['name_ua'], 500);
            if (isset($array['title_ua']) && !empty($array['title_ua'])) $array['title_ua'] = $this->ci->data_lib->tryData($array['title_ua'], 500);
            if (isset($array['keyword_ua']) && !empty($array['keyword_ua'])) $array['keyword_ua'] = $this->ci->data_lib->tryData($array['keyword_ua'], 500);
            if (isset($array['description_ua']) && !empty($array['description_ua'])) $array['description_ua'] = $this->ci->data_lib->tryData($array['description_ua'], 10000);
            if (isset($array['shorttext_ua']) && !empty($array['shorttext_ua'])) $array['shorttext_ua'] = $this->ci->data_lib->tryData($array['shorttext_ua'], 100000);
            if (isset($array['text_ua']) && !empty($array['text_ua'])) $array['text_ua'] = $this->ci->data_lib->tryData($array['text_ua'], 100000);
            
            if (isset($array['name_ru']) && !empty($array['name_ru'])) $array['name_ru'] = $this->ci->data_lib->tryData($array['name_ru'], 500);
            if (isset($array['title_ru']) && !empty($array['title_ru'])) $array['title_ru'] = $this->ci->data_lib->tryData($array['title_ru'], 500);
            if (isset($array['keyword_ru']) && !empty($array['keyword_ru'])) $array['keyword_ru'] = $this->ci->data_lib->tryData($array['keyword_ru'], 500);
            if (isset($array['description_ru']) && !empty($array['description_ru'])) $array['description_ru'] = $this->ci->data_lib->tryData($array['description_ru'], 10000);
            if (isset($array['shorttext_ru']) && !empty($array['shorttext_ru'])) $array['shorttext_ru'] = $this->ci->data_lib->tryData($array['shorttext_ru'], 100000);
            if (isset($array['text_ru']) && !empty($array['text_ru'])) $array['text_ru'] = $this->ci->data_lib->tryData($array['text_ru'], 100000);
            
            if (isset($array['visible']) && is_numeric($array['visible']) && in_array($array['visible'], array(0, 1))) $array['visible'] = $array['visible'];
            
            if (isset($array['cts_address_ua']) && !empty($array['cts_address_ua'])) $array['cts_address_ua'] = $this->ci->data_lib->tryData($array['cts_address_ua'], 1000);
            if (isset($array['cts_location_ua']) && !empty($array['cts_location_ua'])) $array['cts_location_ua'] = $this->ci->data_lib->tryData($array['cts_location_ua'], 1000);
            
            if (isset($array['cts_address_ru']) && !empty($array['cts_address_ru'])) $array['cts_address_ru'] = $this->ci->data_lib->tryData($array['cts_address_ru'], 1000);
            if (isset($array['cts_location_ru']) && !empty($array['cts_location_ru'])) $array['cts_location_ru'] = $this->ci->data_lib->tryData($array['cts_location_ru'], 1000);
            
            if (isset($array['name1']) && !empty($array['name1'])) $array['name1'] = $this->ci->data_lib->tryData($array['name1'], 500);
            if (isset($array['text1']) && !empty($array['text1'])) $array['text1'] = $this->ci->data_lib->tryData($array['text1'], 1000);
            if (isset($array['name2']) && !empty($array['name2'])) $array['name2'] = $this->ci->data_lib->tryData($array['name2'], 500);
            #if (isset($array['text2']) && !empty($array['text2'])) $array['text2'] = $this->ci->data_lib->tryData($array['text2'], 1000);
            if (isset($array['name3']) && !empty($array['name3'])) $array['name3'] = $this->ci->data_lib->tryData($array['name3'], 500);
            if (isset($array['text3']) && !empty($array['text3'])) $array['text3'] = $this->ci->data_lib->tryData($array['text3'], 1000);
            
            if (isset($array['payment_text_ua'])) $array['payment_text_ua'] = mb_substr($array['payment_text_ua'], 0 , 100000);
            if (isset($array['payment_text_ru'])) $array['payment_text_ru'] = mb_substr($array['payment_text_ru'], 0 , 100000);
            /*
            if (isset($array['link']) && $array['link'] == 'price') {
             $this->ci->load->library('image_my_lib');
             $array['file_price'] = $this->ci->image_my_lib->updatePrice();
            }
            */
            
            $this->ci->load->library('image_my_lib');
            $array['image'] = $this->ci->image_my_lib->createPageImage('image');
            $array['image2'] = $this->ci->image_my_lib->createPageImage('image2');
            
            $this->ci->load->model('page/page_page_model', 'model');
            
            return $this->ci->model->savePage($array);
            
        }
        
        
    }
    
}