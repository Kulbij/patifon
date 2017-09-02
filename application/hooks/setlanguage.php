<?php 
(defined('BASEPATH')) OR exit('No direct script access allowed');

function setlang() {
 $uri = &load_class('URI');
 
 $lang = $uri->segment(1);
 /*
 if ($lang == 'ua') define('SITELANG', 'ua');
 elseif ($lang == 'en') define('SITELANG', 'en');
 elseif ($lang == 'pl') define('SITELANG', 'pl');
 else*/ define('SITELANG', 'ru');
}