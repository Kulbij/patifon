<?php

class Date_lib {
    
    public function dateToOur($date) {
        
        $date = explode(' ', $date);
        $date = explode('-', $date[0]);
        return $date[2].'.'.$date[1].'.'.$date[0];
        
    }
    
}