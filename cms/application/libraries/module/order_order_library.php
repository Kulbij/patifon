<?php

class Order_order_library {
    
    private $ci;
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    public function setCheck($id) {
        
        $this->ci->load->model('order/order_order_model', 'model');
        $this->ci->model->setCheck($id);
        
    }
    
    public function setUnCheck($id) {
        
        $this->ci->load->model('order/order_order_model', 'model');
        $this->ci->model->setUnCheck($id);
        
    }
    
    public function setAction() {
        
        $arr_opt = array('check', 'uncheck', 'del', 'sendmail', 'check_1', 'uncheck_1', 'del_1', 'sendmail_1');
        
        if (isset($_POST['chord']) && is_array($_POST['chord']) &&
            isset($_POST['idis']) && is_array($_POST['idis']) &&
            isset($_POST['option_']) && in_array($_POST['option_'], $arr_opt) ||
            isset($_POST['option_1']) && in_array($_POST['option_1'], $arr_opt)) {
            
            $this->ci->load->model('order/order_order_model', 'model');
            
            $chord = $_POST['chord'];
            $idids = $_POST['idis'];
            if(isset($_POST['option_1']) && !empty($_POST['option_1']) && $_POST['option_1'] != 'check') $option_ = $_POST['option_1'];
            else $option_ = $_POST['option_'];
            
            $count__ = count($chord);
            
            for ($i = 0; $i < $count__; ++$i) {
                if ($chord[$i] == 1) {
                    if ($option_ == 'check' || $option_ == 'check_1') {
                        $this->ci->model->setCheck($idids[$i]);
                    }
                    if ($option_ == 'uncheck' || $option_ == 'uncheck_1') {
                        $this->ci->model->setUnCheck($idids[$i]);
                    }
                    if ($option_ == 'del' || $option_ == 'del_1') {
                        $this->ci->model->delOrder($idids[$i]);
                    }
                    if ($option_ == 'sendmail' || $option_ == 'sendmail_1') {
                        $email = $this->ci->model->getEmailOrder($idids[$i]);
                        if(isset($email) && !empty($email))
                            $this->ci->model->sendmailOrder($idids[$i], $email);
                    }
                }
            }
            
            return true;
            
        }
        
        return false;
        
    }
    
    public function delOrder($id) {
        
        $this->ci->load->model('order/order_order_model', 'model');
        $this->ci->model->delOrder($id);
        
    }
    
}