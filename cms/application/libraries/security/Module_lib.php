<?php

class Module_lib {
    
    //code igniter
    private $ci;
    
    //path to controllers folder from root
    private $controllers = '/application/controllers/';
    //path to models folder
    private $model = '/application/models/';
    //path to views folder
    private $view = '/application/views/';
    //path to libraries folder
    private $library = '/application/libraries/';
    
    //error message
    private $errmess = 'Пошкоджений модуль ';
    
    function __construct() {
        $this->ci = &get_instance();
    }
    
    //setters
    public function setPathToControllerFolder($path) {
        $this->controllers = $path;
        return true;
    }
    
    public function setPathToModelFolder($path) {
        $this->model = $path;
        return true;
    }
    
    public function setPathToViewrFolder($path) {
        $this->view = $path;
        return true;
    }
    
    public function setPathToLibraryFolder($path) {
        $this->library = $path;
        return true;
    }
    
    //--end setters
    
    //getters
    public function getPathToControllerFolder() {
        return $this->controllers;
    }
    
    public function getPathToModelFolder() {
        return $this->model;
    }
    
    public function getPathToViewFolder() {
        return $this->view;
    }
    
    public function getPathToLibraryFolder() {
        return $this->library;
    }
    //--end getters
    
    //context
    public function checkModule() {
        $this->ci->load->model('security/Module_model');
        $modules = $this->ci->Module_model->selectLinkModule(null, true);
        
        $errors = '';
        
        foreach ($modules as $value) {
            $subes = $this->ci->Module_model->selectChildLinkModule($value['id']);
            if ($this->checkFolder($value['link']) === false || $this->checkFile($value['link'], $subes) === false) $errors .= $this->errmess.$value['link'].'<br />';
        }
        
        if (empty($errors)) return $errors;
        
        return true;
        
    }
    
    public function checkFolder($folder) {
        return @opendir($this->controllers.$folder) & @opendir($this->model.$folder) & @opendir($this->library.$folder) & @opendir($this->view.$folder);
    }
    
    public function checkFile($folder, $files) {
        $crazy = file_exists($this->controllers.$folder.'/'.$folder.'.php') & file_exists($this->model.$folder.'/'.$folder.'.php') & file_exists($this->library.$folder.'/'.$folder.'.php') & file_exists($this->view.$folder.'/'.$folder.'.php');
        foreach ($files as $one) {
            $crazy = $crazy & file_exists($this->model.$folder.'/'.$folder.'_'.$one['link'].'_model.php') & file_exists($this->library.$folder.'/'.$folder.'_'.$one['link'].'_lib.php') & file_exists($this->view.$folder.'/'.$folder.'_'.$one['link'].'_view.php');
        }
        
        return $crazy;
    }
    //--end context
}