<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Region_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }

 public function is_delivery_cat($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return false;

  $this->db
          ->select('id')
          ->from('site_delivery_cat')
          ->where('id = '.$this->db->escape($id))
          ->where('visible = 1')
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 public function get_delivery_cat_name($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return '';

  parent::select_lang('name');
  $this->db
          ->from('site_delivery_cat')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }

 public function get_delivery_cat() {
  parent::select_lang('name');
  $this->db
          ->select('id, is_samo')
          ->from('site_delivery_cat')
          ->where('visible = 1')
          ->order_by('position', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function is_delivery_type($id = 0, $cat_id = 0) {
  $id = (int)$id;
  $cat_id = (int)$cat_id;
  if ($id <= 0) return false;

  $this->db
          ->select('id')
          ->from('site_delivery_type')
          ->where('id = '.$this->db->escape($id))
          ->where('visible = 1')
          ->limit(1)
          ;

  if ($cat_id > 0) {
   $this->db->where('cat_id = '.$this->db->escape($cat_id));
  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 public function get_delivery_type_name($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return '';

  parent::select_lang('name');
  $this->db
          ->from('site_delivery_type')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }

 public function get_delivery_type($catid = 0) {
  $catid = (int)$catid;
  if ($catid < 0) return array();

  parent::select_lang('name');
  $this->db
          ->select('id, cat_id')
          ->from('site_delivery_type')
          ->where('visible = 1')
          ->order_by('position', 'ASC')
          ;

  if ($catid > 0) $this->db->where('cat_id = '.$this->db->escape($catid));

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function is_region($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return array();

  $this->db
          ->select('id')
          ->from('site_region')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function get_region_name($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return '';

  parent::select_lang('name');
  $this->db
          ->from('site_region')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }

 public function get_region() {
  parent::select_lang('name');
  $this->db
          ->select('id')
          ->from('site_region')
          ->order_by('name', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function is_region_city($cityid = 0, $regionid = 0) {
  $cityid = (int)$cityid;
  $regionid = (int)$regionid;
  if ($cityid <= 0 || $regionid <= 0) return false;

  $this->db
          ->select('id')
          ->from('site_region_city')
          ->where('visible = 1')
          ->where('id = '.$this->db->escape($cityid))
          ->limit(1)
          ;

  if ($regionid > 0) $this->db->where('region_id = '.$this->db->escape($regionid));

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 public function get_region_city_name($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return '';

  parent::select_lang('name');
  $this->db
          ->from('site_region_city')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }

 public function get_region_city($regionid = 0) {
  $regionid = (int)$regionid;
  if ($regionid < 0) return array();

  parent::select_lang('name');
  $this->db
          ->select('id, region_id')
          ->from('site_region_city')
          ->where('visible = 1')
          ->order_by('name', 'ASC')
          ;

  if ($regionid > 0) $this->db->where('region_id = '.$this->db->escape($regionid));

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 #NEW POST region

 function new_post_sort($a, $b) {
  if (!isset($a['name']) || !isset($b['name'])) return false;

  return strcmp($a['name'], $b['name']);
 }

 public function get_new_post_region() {
  $return = array();

  $xml = '<?xml version="1.0" encoding="utf-8"?>
   <file>
    <auth>'.$this->config->item('new_post_api_key').'</auth>
    <citywarehouses />
   </file>
  ';

  $xml = simplexml_load_string($this->input->curl_init($this->config->item('new_post_link'), $xml), 'SimpleXMLElement', LIBXML_COMPACT | LIBXML_PARSEHUGE);

  if (isset($xml->result->cities->city)) {

   foreach ($xml->result->cities->city as $node) {

    $temp = array(
     'id' => (string)$node->nameRu, #(int)$node->id,
     'name' => (string)$node->nameRu
    );
    array_push($return, $temp);

   }

  }

  uasort($return, array($this, 'new_post_sort'));

  return $return;
 }

 public function get_new_post_city($region_name) {
  if (empty($region_name)) return array();

  $return = array();

  $xml = '<?xml version="1.0" encoding="utf-8"?>
   <file>
    <auth>'.$this->config->item('new_post_api_key').'</auth>
    <warenhouse />
    <filter>'.$region_name.'</filter>
   </file>
  ';

  $xml = simplexml_load_string($this->input->curl_init($this->config->item('new_post_link'), $xml), 'SimpleXMLElement', LIBXML_COMPACT | LIBXML_PARSEHUGE);

  if (isset($xml->result->whs->warenhouse)) {

   foreach ($xml->result->whs->warenhouse as $node) {

    $temp = array(
     'id' => (string)$node->addressRu, #(int)$node->cityId,
     'name' => (string)$node->addressRu
    );
    array_push($return, $temp);

   }

  }

  return $return;
 }

 #END - NEW POST region

}