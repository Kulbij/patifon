<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Bread_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }

 public function getIndexBread() {
  $res = $this->db->select('id, name_'.SITELANG.' as name')->from('site_indexpage')->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  $res['link'] = site_url();
  return $res;
 }
 
 public function getPageBread($link = '', $other = false) {
  if (is_null($link)) return false;
  $link = parent::prepareDataString($link);
  
  $this->db->select('link, name_'.SITELANG.' as name');
  if (!$other) $this->db->from('site_page');
  else $this->db->from('site_page_other');
  $res = $this->db->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  $res['link'] = site_url($res['link']);
  return $res;
 }
 
}