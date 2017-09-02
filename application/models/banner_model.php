<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Banner_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }

 public function get($left = true, $limit = 0) {
  $limit = (int)$limit;
  $this->db->select('id, image, link, name')->from('site_indexbanner')->where('visible = 1')->order_by('position', 'ASC');
  
  if ($left) {
   $this->db->where('isleft = 1');
  } else {
   $this->db->where('isleft = 0');
  }
  
  if ($limit > 0) $this->db->limit($limit);
  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }
 
}