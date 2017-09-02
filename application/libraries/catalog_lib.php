<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Catalog_lib {
 private $CI;
 
 #Catalog
 private $enableParametter;
 private $simpleParametter;
 private $unsortParametter;
 private $canonicalParametter;
 private $defaultParametter;
 private $databaseParametter;
 #end Catalog
 
 #Object
 private $enableParametter_object;
 private $enableParametter_object_tab;
 private $defaultParametter_object;
 private $simpleParametter_object;
 #end Object
 
 public function __construct() {
  $this->CI = &get_instance();
  
  #Catalog
  $this->enableParametter = array('view', 'sort', 'style', 'min-price', 'max-price', 'min-width', 'max-width', 'min-height', 'max-height', 'page');
  $this->simpleParametter = array('view', 'sort', 'min-price', 'max-price', 'min-width', 'max-width', 'min-height', 'max-height', 'page');
  $this->unsortParametter = array('view', 'sort', 'page');
  $this->canonicalParametter = array('sort');
  $this->defaultParametter = array(
   'sort' => array(
    0 => 'rate'
   ),
   'view' => array(
    0 => 'tile'
   ),
   'page' => array(
    0 => 1
   )
  );
  $this->databaseParametter = array(
   'style' => array(
    'table' => 'site_catalog_style',
    'selectfield' => 'id',
    'wherefield' => 'link'
   )
  );
  #end Catalog
  
  #Object
  $this->enableParametter_object = array();
  $this->enableParametter_object_tab = array();
  $this->defaultParametter_object = array();
  $this->simpleParametter_object = array();
  #end Object
 }
 
 public function generateLeftFilter($array = array(), $parametter_array = array()) {
  if (!isset($array['cat_id'])) $array['cat_id'] = 0;
  $return = array();
  
  #unlink page to 0
  unset($parametter_array['page']);
  #end
  
  $this->CI->load->model('catalog_model');
  #$return['manufacturer'] = $this->CI->catalog_model->getManufacturerLF($array['cat_id'], false, $parametter_array);
  
  $return['style'] = $this->CI->catalog_model->getCatalogStyleLF($array['cat_id'], false, $parametter_array);
  /*
  $return['shade'] = $this->CI->catalog_model->getCatalogShadeLF($array['cat_id'], false, $parametter_array);
  $return['material'] = $this->CI->catalog_model->getCatalogMaterialLF($array['cat_id'], false, $parametter_array);
  */
  //$return['more'] = $this->CI->catalog_model->getMoreLF($array['cat_id'], false, $parametter_array);
  
  #echo '<pre>'; print_r($return); echo '</pre>';
  
  return $return;
 }
 
 public function generateLeftPrices($array = array()) {
  if (!isset($array['categoryid'])) $array['categoryid'] = 0;
  $return = array();
  $this->CI->load->model('catalog_model');
  $return['price'] = $this->CI->catalog_model->getMaxPrice($array['categoryid']);
  $return['width'] = $this->CI->catalog_model->getMaxWidth($array['categoryid']);
  $return['height'] = $this->CI->catalog_model->getMaxHeight($array['categoryid']);
  
  return $return;
 }
 
 public function generateLeftSlidersLink($parametter_array = array()) {
  $return = array();
  
  #unlink page to 0
  unset($parametter_array['page']);
  #end
  
  $return['price_linker'] = $this->changeCatalogParametter($parametter_array, array('key' => 'min-price', 'link' => '%_minp'));
  $return['price_linker'] = $this->changeCatalogParametter($this->parseCatalogParametter($return['price_linker'], false), array('key' => 'max-price', 'link' => '%_maxp'));
  
  $return['width_linker'] = $this->changeCatalogParametter($parametter_array, array('key' => 'min-width', 'link' => '%_minw'));
  $return['width_linker'] = $this->changeCatalogParametter($this->parseCatalogParametter($return['width_linker'], false), array('key' => 'max-width', 'link' => '%_maxw'));
  
  $return['height_linker'] = $this->changeCatalogParametter($parametter_array, array('key' => 'min-height', 'link' => '%_minh'));
  $return['height_linker'] = $this->changeCatalogParametter($this->parseCatalogParametter($return['height_linker'], false), array('key' => 'max-height', 'link' => '%_maxh'));
  
  return $return;
 }
 
 
 #Catalog region
 public function parseCatalogParametter($parametterString = '', $_check = true) {
  $parametterString = rtrim($parametterString, '/');
  if (empty($parametterString)) return false;
  $return = array();
  
  $parametterList = explode(';', $parametterString);
  if (!is_array($parametterList) || empty($parametterList)) return false;
  
  foreach ($parametterList as $one) {
   $temp = explode('=', $one);
   if (count($temp) == 2 && in_array($temp[0], $this->enableParametter)) {
    $param = array();
    if (($pos = strpos($temp[1], ',')) === false) {
     if ($_check) {
      if ($this->checkCatalogParametter($temp[0], array($temp[1]))) $param = array($temp[1]);
      else return false;
     } else $param = array($temp[1]);
    } else {
     $subparam = explode(',', $temp[1]);
     if ($_check) {
      if ($this->checkCatalogParametter($temp[0], $subparam)) $param = $subparam;
      else return false;
     } else $param = $subparam;
    }
    $return[$temp[0]] = $param;
   } else return false;
  }
  
  return $return;
 }
 
 public function reparseCatalogParametter($parametterArray = array()) {
  if (!is_array($parametterArray) || empty($parametterArray)) return '';
  $return = '';
  
  foreach ($parametterArray as $key => $value) {
   if (!in_array($key, $this->enableParametter)) unset($parametterArray[$key]);
  }
  
  $parametterArray = $this->unsetCatalogDefaultParammetter($parametterArray, $this->defaultParametter);
  $parametterArray = $this->sortParametter($parametterArray, $this->enableParametter);
  
  foreach ($parametterArray as $key => $value) {
   if (!empty($key) && is_array($value) && !empty($value)) {
    $return .= $key.'=';
    foreach ($value as $one) {
     if (end($value) == $one) {
      if (end($parametterArray) == $value) $return .= $one;
      else $return .= $one.';';
     } else $return .= $one.',';
    }
   }
  }
  $return = rtrim($return, ';');
  if (!empty($return)) $return .= '/';
  return $return;
 }
 
 public function checkCatalogParametter($parametter = '', $array = array()) {
  if (empty($parametter) || !is_array($array) || empty($array) || !in_array($parametter, $this->enableParametter)) return false;
  $this->CI->load->model('catalog_model');
  $validArray = array();
  $checker = 'one';
  switch($parametter) {
   case 'view': {
    $validArray = $this->CI->catalog_model->getCatalogViewLF(true);
   } break;
   case 'sort': {
    $validArray = $this->CI->catalog_model->getCatalogSortLF(true);
   } break;
   case 'sort-price': {
    $validArray = $this->CI->catalog_model->getCatalogSortPriceLF(true);
   } break;
   case 'manufacturer': {
    $validArray = $this->CI->catalog_model->getManufacturerLF(0, true);
    $checker = 'array';
   } break;
   case 'max-price':
   case 'min-price':
   case 'min-width': 
   case 'max-width':
   case 'min-height':
   case 'max-height': {
    $checker = 'numeric';
   } break;
   case 'style': {
    $validArray = $this->CI->catalog_model->getCatalogStyleLF(0, true);
    $checker = 'array';
   } break;
   case 'shade': {
    $validArray = $this->CI->catalog_model->getCatalogShadeLF(0, true);
    $checker = 'array';
   } break;
   case 'material': {
    $validArray = $this->CI->catalog_model->getCatalogMaterialLF(0, true);
    $checker = 'array';
   } break;
   case 'more': {
    $validArray = $this->CI->catalog_model->getMoreLF(0, true);
    $checker = 'array';
   } break;
   case 'page': {
    $checker = 'int';
   } break;
   default: return false;
  }
  
  if ($checker == 'one') {
   if (count($array) > 1) return false;
   $temp = $array[0];
   if (!in_array($temp, $validArray)) return false;
  } elseif ($checker == 'array') {
   if (empty($validArray)) return false;
   foreach ($array as $one) {
    if (!in_array($one, $validArray)) return false;
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
 
 public function prepareCatalogParametter($parametterArray = array()) {
  #if (!is_array($parametterArray) || empty($parametterArray)) return array();
  $numericArray = array('max-price', 'min-price', 'min-width', 'max-width', 'min-height', 'max-height', 'page');
  $unbuttonArray = array('view', 'sort', 'sort-price', 'page');
  
  $parametterArray = $this->setCatalogDefaultParammetter($parametterArray, $this->defaultParametter);
  
  $temper = array();
  foreach ($parametterArray as $key => $value) {
   if (!isset($temper['reset_button']) && !in_array($key, $unbuttonArray)) $temper['reset_button'] = true;
   if (in_array($key, $numericArray) && $value[0] < 0) $temper[$key] = array('0' => 0);
   else $temper[$key] = $value;
  }
  return $temper;
 }
 public function prepareCatalogParametterForDatabase($parametter_array = array()) {
  if (!is_array($parametter_array) || empty($parametter_array) || !is_array($this->databaseParametter) || empty($this->databaseParametter)) return $parametter_array;
  $this->CI->load->model('base_model');
  $return = array();
  
  foreach ($parametter_array as $key => $value) {
   if (isset($this->databaseParametter[$key])) {
    $temp = $this->CI->base_model->getOnlyOneField($this->databaseParametter[$key], $value);
    $return[$key] = $temp;
   } else $return[$key] = $value;
  }
  return $return;
 }
 
 public function changeCatalogParametter($parametter_array = array(), $array = array(), $one_value = false) {
  if (!is_array($array) || empty($array) || !isset($array['key']) || !isset($array['link']) || !is_array($parametter_array)) return false;
  $linker = '';
  $didit = false;
  $simple = false;
  if (in_array($array['key'], $this->simpleParametter)) $simple = true;
  
  foreach ($parametter_array as $key => &$value) {
   if ($key == $array['key']) {
    if ($simple) {
     $value[0] = $array['link'];
     $didit = true;
    } else {
     if ($one_value) {
      unset($parametter_array[$key]);
     } else {
      foreach ($value as $key2 => $value2) {
       if ($value2 == $array['link']) {
        unset($value[$key2]);
        $didit = true;
       }
      }
      if (!$didit) {
       $value[] = $array['link'];
       $didit = true;
      }
     }
    }
    break;
   }
  } unset($value);
  
  if (!$didit) {
   $temp = array($array['key'] => array($array['link']));
   $parametter_array = array_merge($parametter_array, $temp);
   $didit = true;
  }
  
  $linker = $this->reparseCatalogParametter($parametter_array);
  return $linker;
 }
 
 public function prepareCatalogResetButtonLink($parametter_array = array()) {
  if (!is_array($parametter_array) || empty($parametter_array)) return '';
  $return = '';
  
  foreach ($parametter_array as $key => $value) {
   if (!in_array($key, $this->unsortParametter)) unset($parametter_array[$key]);
  }
  
  $return = $this->reparseCatalogParametter($parametter_array);
  return $return;
 }
 
 public function prepareCanonicalParametter($parametter_array = array()) {
  if (!is_array($parametter_array) || empty($parametter_array)) return false;
  $return = '';
  
  foreach ($parametter_array as $key => $value) {
   if (in_array($key, $this->canonicalParametter)) unset($parametter_array[$key]);
  }
  
  $return = $this->reparseCatalogParametter($parametter_array);
  return $return;
 }
 
 public function setCatalogDefaultParammetter($parametter_array = array(), $default_array = array()) {
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
 public function unsetCatalogDefaultParammetter($parametter_array = array(), $default_array = array()) {
  if (!is_array($parametter_array) || empty($parametter_array) || !is_array($default_array) || empty($default_array)) return $parametter_array;
  
  $keys = array_keys($parametter_array);
  foreach ($default_array as $key => $value) {
   if (in_array($key, $keys) && $parametter_array[$key] == $value) {
    unset($parametter_array[$key]);
   }
  }
  return $parametter_array;
 }
 
 public function getCatalogObject($cat_idis = array(), $parametter_array = array(), $count = 30, $return_count = false) {
  $return_default = array();
  if ($return_count) $return_default = 0;
  
  if (empty($cat_idis)) return array();
  
  $count = (int)$count;
  
  $idis = $this->prepareCatalogParametterForDatabase($parametter_array);
  
  $this->CI->load->model('catalog_model');
  $res = $return_default;
  if ($return_count) $res = $this->CI->catalog_model->getCatalogObjectCount($cat_idis, $idis);
  else $res = $this->CI->catalog_model->getCatalogObject($cat_idis, $idis, $count);
  
  return $res;
 }
 
 public function getCatalogObjectCountByParametter($cat_idis = array(), $parametter_array = array(), $parametter = array()) {
  if (!is_array($parametter) || empty($parametter)) return 0;
  
  if (empty($cat_idis)) return array();
  
  $changer = $this->changeCatalogParametter($parametter_array, $parametter, true);
  $idis = $this->prepareCatalogParametterForDatabase($this->parseCatalogParametter($changer));
  
  $this->CI->load->model('catalog_model');
  $res = $this->CI->catalog_model->getCatalogObjectCount($cat_idis, $idis);
  return $res;
 }
 #end Catalog region
 
 
 #Object region
 public function parseObjectParametter($parametterString = '') {
  if (empty($parametterString)) return false;
  $return = array();
  
  $parametterList = explode(';', $parametterString);
  if (!is_array($parametterList) || empty($parametterList)) return false;
  
  foreach ($parametterList as $one) {
   $temp = explode('=', $one);
   if (count($temp) == 2 && in_array($temp[0], $this->enableParametter_object)) {
    $param = array();
    if (($pos = strpos($temp[1], ',')) === false) {
     if ($this->checkObjectParametter($temp[0], array($temp[1]))) $param = array($temp[1]);
     else return false;
    } else {
     $subparam = explode(',', $temp[1]);
     if ($this->checkObjectParametter($temp[0], $subparam)) $param = $subparam;
     else return false;
    }
    $return[$temp[0]] = $param;
   } else return false;
  }
  
  return $return;
 }
 
 public function checkObjectParametter($parametter = '', $array = array()) {
  if (empty($parametter) || !is_array($array) || empty($array) || !in_array($parametter, $this->enableParametter_object)) return false;
  $validArray = array();
  $checker = 'one';
  switch($parametter) {
   case 'view': {
    $validArray = $this->enableParametter_object_tab;
    $checker = 'array';
   } break;
   case 'page': {
    $checker = 'int';
   } break;
   default: return false;
  }
  
  if ($checker == 'one') {
   if (count($array) > 1) return false;
   $temp = $array[0];
   if (!in_array($temp, $validArray)) return false;
  } elseif ($checker == 'array') {
   if (empty($validArray)) return false;
   foreach ($array as $one) {
    if (!in_array($one, $validArray)) return false;
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
 
  public function reparseObjectParametter($parametterArray = array()) {
  if (!is_array($parametterArray) || empty($parametterArray)) return '';
  $return = '';
  
  foreach ($parametterArray as $key => $value) {
   if (!in_array($key, $this->enableParametter_object)) unset($parametterArray[$key]);
  }
  
  $parametterArray = $this->unsetCatalogDefaultParammetter($parametterArray, $this->defaultParametter_object);
  $parametterArray = $this->sortParametter($parametterArray, $this->enableParametter_object);
  
  foreach ($parametterArray as $key => $value) {
   if (!empty($key) && is_array($value) && !empty($value)) {
    $return .= $key.'=';
    foreach ($value as $one) {
     if (end($value) == $one) {
      if (end($parametterArray) == $value) $return .= $one;
      else $return .= $one.';';
     } else $return .= $one.',';
    }
   }
  }
  $return = rtrim($return, ';');
  if (!empty($return)) $return .= '/';
  return $return;
 }
 
 public function changeObjectParametter($parametter_array = array(), $array = array()) {
  if (!is_array($array) || empty($array) || !isset($array['key']) || !isset($array['link'])) return false;
  $linker = '';
  $didit = false;
  $simple = false;
  if (in_array($array['key'], $this->simpleParametter_object)) $simple = true;
  
  foreach ($parametter_array as $key => &$value) {
   if ($key == $array['key']) {
    if ($simple) {
     $value[0] = $array['link'];
     $didit = true;
    } else {
     foreach ($value as $key2 => $value2) {
      if ($value2 == $array['link']) {
       unset($value[$key2]);
       $didit = true;
      }
     }
     if (!$didit) {
      $value[] = $array['link'];
      $didit = true;
     }
    }
    break;
   }
  } unset($value);
  
  if (!$didit) {
   $temp = array($array['key'] => array($array['link']));
   $parametter_array = array_merge($parametter_array, $temp);
   $didit = true;
  }
  
  $linker = $this->reparseObjectParametter($parametter_array);
  return $linker;
 }
 
 public function prepareObjectParametter($parametterArray = array()) {
  $numericArray = array('page');
  $unbuttonArray = array('view', 'page');
  
  $parametterArray = $this->setCatalogDefaultParammetter($parametterArray, $this->defaultParametter_object);
  
  $temper = array();
  foreach ($parametterArray as $key => $value) {
   if (in_array($key, $numericArray) && $value[0] < 0) $temper[$key] = array('0' => 0);
   else $temper[$key] = $value;
  }
  return $temper;
 }
 #end Object region
 
 
 #function return array if parametter more than one and value if one || false
 public function getParametter($parametter_array = array(), $parametter = '', $default_return = false) {
  if (!is_array($parametter_array) || empty($parametter_array) || empty($parametter)) return $default_return;
  if (!isset($parametter_array[$parametter])) return $default_return;
  if (count($parametter_array[$parametter]) > 1) return $parametter_array[$parametter];
  else return $parametter_array[$parametter][0];
  return $default_return;
 }
 public function sortParametter($parametter_array = array(), $sorting_array = array()) {
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
}