<?php

class Data_lib {
    
    public function tryData($data, $length, $regex = null) {
     $data = substr($data, 0, $length);
     if ($regex == null || preg_match($regex, $data)) return $data;
     else return false;
    }
    
}