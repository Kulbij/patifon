<?php

class Password_lib {
    
    public function createPass($password) {
        return md5($password);
    }
    
    public function tryPass($password) {
        return !empty($password);
    }
    
}