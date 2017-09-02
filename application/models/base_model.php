<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base_model extends CI_Model {
 private $rep_array;
 
 #image site exstension
 protected $catalog_ext = array();
 #end
 
 #mounth array
 protected $mounth_array = array();
 
 public function __construct() {
  parent::__construct();
  $this->rep_array = array("/<[\/\!]*?[^<>]*?>/si" /*, '/\s+/mu'*/);
  $this->catalog_ext = array(
   'default' => '', 'pop' => '_pop', 'top' => '_top',
   'obj' => '_obj', 'cat' => '_cat', 'dis' => '_dis',
   'big' => '_big', 'sm' => '_sm'
  );
  
  $this->mounth_array = array(
   'ua' => array(
    1 => 'січня',
    'лютого',
    'березня',
    'квітня',
    'травня',
    'червня',
    'липня',
    'серпня',
    'вересня',
    'жовтня',
    'листопада',
    'грудня'
   ),
   'ru' => array(
    1 => 'января',
    'февраля',
    'марта',
    'апреля',
    'мая',
    'июня',
    'июля',
    'августа',
    'сентября',
    'октября',
    'ноября',
    'декабря'
   )
  );
 }
 
 protected function replacer($string = '', $lower = false) {
  $string = preg_replace($this->rep_array, '', $string);
  if ($lower) $string = mb_strtolower($string);
  $string = addslashes(htmlspecialchars($string));
  return $string;
 }
 
 public function prepareDataString($data = '') {
  $return = '';
  if (is_null($data)) return $return;
  if (is_array($data)) {
   foreach ($data as $key => $value) {
    if (is_string($value)) $return[$key] = $this->replacer($value);
    else $return[$key] = $value;
   }
  } else {
   $return = $this->replacer($data);
  }
  return $return;
 }
 
 public function prepareDataStringSearch($data = '') {
  $return = array();
  if (is_null($data) || empty($data)) return $return;
  $data = explode(' ', $data);
  if (is_array($data) && !empty($data)) {
   foreach ($data as $value) {
    $temp = $this->replacer($value);
    if (!empty($temp)) $return[] = $temp;
   }
  }
  return $return;
 }
 
 public function int2ip($i) {
  $d[0] = (int)($i / 256 / 256 / 256);
  $d[1] = (int)(($i - $d[0]*256*256*256) / 256 / 256);
  $d[2] = (int)(($i - $d[0]*256*256*256 - $d[1]*256*256) / 256);
  $d[3] = $i - $d[0]*256*256*256 - $d[1]*256*256 - $d[2]*256;
  return "$d[0].$d[1].$d[2].$d[3]";
 }

 public function ip2int($ip) {
  $a = explode(".", $ip);
  return $a[0]*256*256*256 + $a[1]*256*256 + $a[2]*256 + $a[3];
 }
 
 public function image_to_ext($img = '', $ext = '') {
  if (empty($img)) return '';
  $pos = strrpos($img, '.');
  if ($pos === false) return '';
  $return = substr($img, 0, $pos);
  $return .= $ext.'.'.substr($img, ($pos + 1), strlen($img));
  return $return;
 }
 
 public function PHPArrayToJSArray($array = array(), $limiter = false) {
  if (!is_array($array)) return false;
  
  if (!$limiter) return '"'.join("\", \"", $array).'"';
  else return '["'.join("\", \"", $array).'"]';
  
  return false;
 }
 
 public function pluralForm($n, $langitem = '') {
  if (empty($langitem)) return false;
  
  $this->lang->load(SITELANG, SITELANG);
  $form1 = $this->lang->line($langitem.'_1');
  $form2 = $this->lang->line($langitem.'_2');
  $form5 = $this->lang->line($langitem.'_5');
  
  return $n % 10 == 1 && $n % 100 != 11 ? $form1 : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $form2 : $form5);
 }
 
 public function formedActionDate($array = array()) {
  if (!is_array($array) || empty($array)) return array();
  foreach ($array as &$temp_one) {
   $temp_one['action_date'] = '';
   if (isset($temp_one['fromdate']) && isset($temp_one['todate'])) {
    $temp_one['action_date'] = $this->lang->line('action_fromto').': '.date('d', strtotime($temp_one['fromdate'])).' '.$this->mounth_array[SITELANG][(int)date('m', strtotime($temp_one['fromdate']))].' &mdash; '.date('d', strtotime($temp_one['todate'])).' '.$this->mounth_array[SITELANG][(int)date('m', strtotime($temp_one['todate']))].' '.date('Y', strtotime($temp_one['todate'])).$this->lang->line('site_year');
   }
  } unset($temp_one);
  return $array;
 }
 
 #database function
 public function getOnlyOneField($input_array = array(), $where_array = array()) {
  if (!is_array($input_array) || empty($input_array) || !is_array($where_array) || empty($where_array)
   || !isset($input_array['selectfield']) || !isset($input_array['table'])
   || !isset($input_array['wherefield'])
  ) return array();
  
  $res = $this->db->select($input_array['selectfield'])->from($input_array['table'])->where_in($input_array['wherefield'], $where_array)->get();
  if ($this->db->_error_message()) return array();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  $temp = array();
  foreach ($res as $one) {
   $temp[] = $one[$input_array['selectfield']];
  }
  return $temp;
 }
 #end database function
 
 protected function select_lang($string = '') {
  $param = explode(',', $string);
  if (empty($param)) return false;
  
  foreach ($param as $one) {
   $one = explode(' as ', $one);
   
   if (!isset($one[0])) continue;
   
   $_as = $one[0];
   if (isset($one[1]) && !empty($one[1])) $_as = $one[1];
   
   $_as = explode('.', $_as);
   if (isset($_as[1]) && !empty($_as[1])) $_as = $_as[1];
   else if (isset($_as[0]) && !empty($_as[0])) $_as = $_as[0];
   else continue;
   
   $this->db->select(trim($one[0]).'_'.SITELANG.' as '.trim($_as));
  }
  
  return true;
 }
 
}