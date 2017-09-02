<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class File_lib {
 
 public function __construct() {
 }
 
 public function __get($variable) {
  return get_instance()->$variable;
 }
 
 public function show_no_image_our($url, $photo = 'no-photo') {
  if (!empty($url)) {
   if (file_exists($url)) return $url;
  }
  return 'public/images/'.$photo.'.jpg';
 }
 
 public function show_no_image($url, $photo = 'no-photo') {
  if (!empty($url)) {
   $headers = @get_headers($url);
   if (isset($headers[0]) && preg_match('|200|', $headers[0])) return $url;
  }
  return baseurl().'public/images/'.$photo.'.jpg';
 }
 
 public function show_arr_image($array, $field, $our = true) {
  if (!is_array($array)) return false;
  
  foreach ($array as &$one) {
   if ($our) $one[$field] = (isset($one[$field])) ? $this->show_one_image_our($one[$field]) : '';
   else $one[$field] = (isset($one[$field])) ? $this->show_one_image($one[$field]) : '';
  } unset($one);
  
  return $array;
 }
}