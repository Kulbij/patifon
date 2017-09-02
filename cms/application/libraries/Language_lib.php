<?php

class Language_lib {
    
    private $langArr;
    private $fieldArr;
    private $formArr;
    private $default;
    private $ci;
    
    function __construct() {
        $this->langArr = array('ru', 'en');
        $this->default = 'ru';
        $this->fieldArr = array('Title_', 'Name_', 'Text_', 'Keyword_', 'Description_');
        $this->formArr = array('title', 'name', 'text', 'keyword', 'description');
        $this->ci = &get_instance();
    }
    
    public function generateSelectAll() {
        $countLang = count($this->langArr);
        $countField = count($this->fieldArr);
        for ($i = 0; $i < $countLang; ++$i) {
            for ($j = 0; $j < $countField; ++$j) {
                $this->ci->db->select("{$this->fieldArr[$j]}{$this->langArr[$i]}");
            }
        }
    }
    
    public function generateSelectName() {
        $this->ci->db->select("{$this->fieldArr[1]}$this->default");
    }
    
    public function FormData($in) {
        $out = array();
        
        $countLang = count($this->langArr);
        $countField = count($this->fieldArr);
        for ($i = 0; $i < $countLang; ++$i) {
            for ($j = 0; $j < $countField; ++$j) {
                $key = "{$this->fieldArr[$j]}{$this->langArr[$i]}";
                if (isset($in[$key])) $out["{$this->formArr[$j]}"] = $in[$key];
            }
        }
        
        return $out;
    }
    
    public function FormAllData($in) {
        $out = array();
        
        $countLang = count($this->langArr);
        $countField = count($this->fieldArr);
        for ($i = 0; $i < $countLang; ++$i) {
            for ($j = 0; $j < $countField; ++$j) {
                $key = "{$this->fieldArr[$j]}{$this->langArr[$i]}";
                if (isset($in[$key])) $out["{$this->formArr[$j]}_{$this->langArr[$i]}"] = $in[$key];
            }
        }
        
        return $out;
    }
    
}