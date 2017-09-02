<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Footer_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }
 
 public function getFooter() {
  $res = $this->db->select('id, text_'.SITELANG.' as text')->from('site_footer')->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }
 
}