<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Filter_lib {

 private $all_param;

 private $default_param;

 private $canonical_param;

 private $unsort_param;

 private $simple_param;

 private $db_param;
 private $db_not_change_param;
 private $db_not_in_param;

 #PRIVATE region

 private function prepare_parametter($array = array()) {
  unset($array['page']);
  unset($array['view']);
  return $array;
 }

 private function get_default_param() {
  return $this->catalog_model->filters_get_default();
 }

 #end

 #SYSTEM

 public function __get($variable) {
  return get_instance()->$variable;
 }

 public function __construct() {
  $this->load->model('catalog_model');

  $this->all_param = $this->catalog_model->filters_get_parent(true);

  $this->default_param = $this->get_default_param();

  $this->canonical_param = array('page');

  $this->unsort_param = array('sort');

  $this->simple_param = $this->catalog_model->filter_get_parent_field_by_type('array'); #array('sort', 'min-price', 'max-price', 'page');

  $this->db_not_in_param = array('price', 'reset_button');
  $this->db_not_change_param = array('promo', 'page', 'sort');
  $this->db_param = $this->catalog_model->filters_get_all_for_db($this->db_not_in_param);

  return true;
 }

 #end

 public function get($array = array(), $parametter_array = array()) {
  if (!isset($array['cat_idis'])) $array['cat_idis'] = array();

  $parametter_array = $this->prepare_parametter($parametter_array);

  return $this->catalog_model->filters_get_all_for_view($array['cat_idis'], $parametter_array);
 }

 public function getCatThis($id = 0){
  if(!isset($id) && empty($id)) return false;
  //$cats['this'] = $this->catalog_model->select_cat_id($cat);
  $cats = $this->catalog_model->get_all_cats();
  return $cats;
 }

 public function get_one($parametter = '', $parametter_array = array()) {
  if (empty($parametter) || !in_array($parametter, $this->all_param)) return array();

  $parametter_array = $this->prepare_parametter($parametter_array);

  return $this->catalog_model->filters_get_one_for_view($parametter, $parametter_array);
 }

 public function get_prices($array = array()) {
  if (!isset($array['cat_idis'])) $array['cat_idis'] = array();
  $return = array();

  $return['price'] = $this->catalog_model->getMaxPrice($array['cat_idis']);

  return $return;
 }

 public function get_links($parametter_array = array()) {
  $return = array();

  $parametter_array = $this->prepare_parametter($parametter_array);

  $return['price_linker'] = $this->change($parametter_array, array('key' => 'min-price', 'link' => '%_minp'));
  $return['price_linker'] = $this->change($this->parse($return['price_linker'], false), array('key' => 'max-price', 'link' => '%_maxp'));

  return $return;
 }


 public function parse($parametter_string = '', $_check = true) {
  $parametter_string = rtrim($parametter_string, '/');
  if (empty($parametter_string)) return false;
  $return = array();

  $parametter_list = explode(';', $parametter_string);
  if (!is_array($parametter_list) || empty($parametter_list)) return false;

  foreach ($parametter_list as $one) {
   $temp = explode('=', $one);
   if (count($temp) == 2 && in_array($temp[0], $this->all_param)) {

    $param = array();
    if (($pos = strpos($temp[1], ',')) === false) {

     if ($_check) {
      if ($this->check($temp[0], array($temp[1]))) $param = array($temp[1]);
      else return false;
     } else $param = array($temp[1]);

    } else {

     $subparam = explode(',', $temp[1]);
     if ($_check) {
      if ($this->check($temp[0], $subparam)) $param = $subparam;
      else return false;
     } else $param = $subparam;

    }

    $return[$temp[0]] = $param;

   } else return false;

  }

  return $return;
 }

 public function reparse($parametter_array = array()) {
  if (!is_array($parametter_array) || empty($parametter_array)) return '';
  $return = '';

  foreach ($parametter_array as $key => $value) {
   if (!in_array($key, $this->all_param)) unset($parametter_array[$key]);
  }

  $parametter_array = $this->unset_default($parametter_array, $this->default_param);
  $parametter_array = $this->sort_parametters($parametter_array, $this->all_param);

  foreach ($parametter_array as $key => $value) {
   if (!empty($key) && is_array($value) && !empty($value)) {
    $return .= $key.'=';
    foreach ($value as $one) {
     if (end($value) == $one) {
      if (end($parametter_array) == $value) $return .= $one;
      else $return .= $one.';';
     } else $return .= $one.',';
    }
   }
  }
  $return = rtrim($return, ';');
  if (!empty($return)) $return .= '/';
  return $return;
 }

 public function check($parametter = '', $array = array()) {
  if (empty($parametter) || !is_array($array) || empty($array) || !in_array($parametter, $this->all_param)) return false;

  $valid_array = $this->catalog_model->filters_get_valid_array($parametter);
  $checker = $this->catalog_model->filters_get_valid_type($parametter);

  if ($checker == 'one') {
   if (count($array) > 1) return false;
   $temp = $array[0];
   if (!in_array($temp, $valid_array)) return false;
  } elseif ($checker == 'array') {
   if (empty($valid_array)) return false;
   foreach ($array as $one) {
    if (!in_array($one, $valid_array)) return false;
   }
  } elseif($checker == 'numeric') {
   if (count($array) > 1) return false;
   $temp = $array[0];
   if (!is_numeric($temp)) return false;
  } elseif($checker == 'int') {
   if (count($array) > 1) return false;
   $temp = $array[0];
   if (is_int($temp + 0) && $temp > 0) return true;
   else return false;
  } else return false;

  return true;
 }

 public function prepare($parametter_array = array()) {
  $numeric_array = array('max-price', 'min-price', 'min-width', 'max-width', 'min-height', 'max-height', 'page');
  $unbutton_array = array('view', 'sort', 'page');

  $parametter_array = $this->set_default($parametter_array, $this->default_param);

  $temper = array();
  foreach ($parametter_array as $key => $value) {
   if (!isset($temper['reset_button']) && !in_array($key, $unbutton_array)) $temper['reset_button'] = true;
   if (in_array($key, $numeric_array) && $value[0] < 0) $temper[$key] = array('0' => 0);
   else $temper[$key] = $value;
  }
  return $temper;
 }

 public function prepare_for_db($parametter_array = array()) {
  if (!is_array($parametter_array) || empty($parametter_array) || !is_array($this->db_param) || empty($this->db_param)) return $parametter_array;

  $return = array();

  foreach ($parametter_array as $key => $value) {

   if (isset($this->db_param[$key])) {

    foreach ($value as $subvalue) {
     if (isset($this->db_param[$key][$subvalue]) && !in_array($key, $this->db_not_change_param)) {
      if (!isset($return[$key])) $return[$key] = array();
      array_push($return[$key], $this->db_param[$key][$subvalue]);
     } elseif (!in_array($key, $this->db_not_in_param)) $return[$key] = $value;
    }

   }

  }

  return $return;
 }

 public function change($parametter_array = array(), $array = array(), $one_value = false) {
  if (!is_array($array) || empty($array) || !isset($array['key']) || !isset($array['link']) || !is_array($parametter_array)) return false;

  $linker = '';
  $did_it = false;
  $simple = false;
  if (in_array($array['key'], $this->simple_param)) $simple = true;

  foreach ($parametter_array as $key => &$value) {
   if ($key == $array['key']) {
    if ($simple) {
     $value[0] = $array['link'];
     $did_it = true;
    } else {
     if ($one_value) {
      unset($parametter_array[$key]);
     } else {
      foreach ($value as $key2 => $value2) {
       if ($value2 == $array['link']) {
        unset($value[$key2]);
        $did_it = true;
       }
      }
      if (!$did_it) {
       $value[] = $array['link'];
       $did_it = true;
      }
     }
    }
    break;
   }
  } unset($value);

  if (!$did_it) {
   $temp = array($array['key'] => array($array['link']));
   $parametter_array = array_merge($parametter_array, $temp);
   $did_it = true;
  }

  $linker = $this->reparse($parametter_array);

  return $linker;
 }

 public function reset_button($parametter_array = array()) {
  if (!is_array($parametter_array) || empty($parametter_array)) return '';
  $return = '';

  foreach ($parametter_array as $key => $value) {
   if (!in_array($key, $this->unsort_param)) unset($parametter_array[$key]);
  }

  $return = $this->reparse($parametter_array);
  return $return;
 }

 public function canonical($parametter_array = array()) {
  if (!is_array($parametter_array) || empty($parametter_array)) return false;
  $return = '';

  foreach ($parametter_array as $key => $value) {
   if (!in_array($key, $this->canonical_param)) unset($parametter_array[$key]);
  }

  $return = $this->reparse($parametter_array);
  return $return;
 }

 public function set_default($parametter_array = array(), $default_array = array()) {
  if (empty($parametter_array)) $parametter_array = $default_array;
  if (!is_array($parametter_array) || !is_array($default_array) || empty($default_array)) return $parametter_array;

  $keys = array_keys($parametter_array);
  foreach ($default_array as $key => $value) {
   if (!in_array($key, $keys)) {
    $parametter_array[$key] = $value;
   }
  }
  return $parametter_array;
 }

 public function unset_default($parametter_array = array(), $default_array = array()) {
  if (!is_array($parametter_array) || empty($parametter_array) || !is_array($default_array) || empty($default_array)) return $parametter_array;

  $keys = array_keys($parametter_array);
  foreach ($default_array as $key => $value) {
   if (in_array($key, $keys) && $parametter_array[$key] == $value) {
    unset($parametter_array[$key]);
   }
  }
  return $parametter_array;
 }

 #function return array if parametter more than one and value if one || false
 public function get_parametter($parametter_array = array(), $parametter = '', $default_return = false) {
  if (!is_array($parametter_array) || empty($parametter_array) || empty($parametter)) return $default_return;
  if (!isset($parametter_array[$parametter])) return $default_return;
  if (count($parametter_array[$parametter]) > 1) return $parametter_array[$parametter];
  else return $parametter_array[$parametter][0];
  return $default_return;
 }

 public function sort_parametters($parametter_array = array(), $sorting_array = array()) {
  if (empty($parametter_array) || empty($sorting_array)) return array();

  $return = array();
  foreach ($sorting_array as $value) {
   if (array_key_exists($value, $parametter_array)) {
    $return[$value] = $parametter_array[$value];
   }
  }

  #$ret_keys = array_keys($return);
  #$pa_keys = array_keys($parametter_array);
  $merge = array_diff_key($parametter_array, $return);
  $return = array_merge($return, $merge);

  return $return;
 }

 #CATALOG region

 public function get_objects($cat_idis = array(), $parametter_array = array(), $count = 30, $all = array(), $ajax = array()) {
  #if (empty($cat_idis)) return array();

  $count = (int)$count;
  if ($count <= 0) return array();
  $idis = $this->prepare_for_db($parametter_array);
  if($all == 'all'){
    $res = $this->catalog_model->getCatalogObject($cat_idis, $idis, $count, $all, $ajax);
  } else {
    $res = $this->catalog_model->getCatalogObject($cat_idis, $idis, $count);
  }

  return $res;
 }

  public function get_objects_all($cat_idis = array(), $parametter_array = array(), $count = 30) {
  #if (empty($cat_idis)) return array();

  $count = (int)$count;
  if ($count <= 0) return array();
  $idis = $this->prepare_for_db($parametter_array);

  $required = 'all';

  $res = $this->catalog_model->getCatalogObject($cat_idis, $idis, $count, $required);

  return $res;
 }


 public function get_object_count($cat_idis = array(), $parametter_array = array(), $parametter = array()) {

  #if (empty($cat_idis)) return 0;

  $count = 0;

  if (is_array($parametter) && !empty($parametter)) {
   $changer = $this->change($parametter_array, $parametter, true);
   $idis = $this->prepare_for_db($this->parse($changer));

   $count = $this->catalog_model->getCatalogObjectCount($cat_idis, $idis);
  } else {
   $idis = $this->prepare_for_db($parametter_array);
   if(isset($parametter) && !empty($parametter) && $parametter == 'all'){
    $count = $this->catalog_model->getCatalogObjectCount($cat_idis, $idis, $parametter);
   } else {
    $count = $this->catalog_model->getCatalogObjectCount($cat_idis, $idis);
   }
  }

  return $count;
 }

 #end

}