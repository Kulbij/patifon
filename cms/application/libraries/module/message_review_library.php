<?php
class Message_review_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setCheck($id) {
        
        $this->ci->load->model('message/message_review_model', 'model');
        $this->ci->model->setCheck($id);
        
    }
    
    public function setUnCheck($id) {
        
        $this->ci->load->model('message/message_review_model', 'model');
        $this->ci->model->setUnCheck($id);
        
    }
    
    public function setAction() {
     
        $arr_opt = array('check', 'uncheck', 'del');
        
        if (isset($_POST['chord']) && is_array($_POST['chord']) &&
            isset($_POST['idis']) && is_array($_POST['idis']) &&
            isset($_POST['option_']) && in_array($_POST['option_'], $arr_opt)) {
            
            $this->ci->load->model('message/message_review_model', 'model');
            
            $chord = $_POST['chord'];
            $idids = $_POST['idis'];
            $option_ = $_POST['option_'];
            
            $count__ = count($chord);
            
            for ($i = 0; $i < $count__; ++$i) {
                if ($chord[$i] == 1) {
                    if ($option_ == 'check') {
                        $this->ci->model->setCheck($idids[$i]);
                    }
                    if ($option_ == 'uncheck') {
                        $this->ci->model->setUnCheck($idids[$i]);
                    }
                    if ($option_ == 'del') {
                        $this->ci->model->delOrder($idids[$i]);
                    }
                }
            }
            
            return true;
            
        }
        
        return false;
        
    }
    
    public function delOrder($id) {
        
        $this->ci->load->model('message/message_review_model', 'model');
        $this->ci->model->delOrder($id);
        
    }
    
}