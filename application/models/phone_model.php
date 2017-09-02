<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Phone_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }

 #param switch 'head' => visible_onhead, 'top' => visible_ontop, 'foot' => visible_onfoot
 public function get($param = '', $mobile = false, $limit = 0) {
  $limit = (int)$limit;
  $this->db->select('id, image, paket, name_'.SITELANG.' as name, phone')->from('site_phone');
  
  if ($param == 'head') $this->db->where('visible_onhead = 1')->order_by('position_onhead', 'ASC');
  elseif ($param == 'top') $this->db->where('visible_ontop = 1')->order_by('position_ontop', 'ASC');
  elseif ($param == 'foot') $this->db->where('visible_onfoot = 1')->order_by('position_onfoot', 'ASC');
  else $this->db->order_by('position', 'ASC');
  
  if ($mobile) $this->db->where('mobile = 1');
  else $this->db->where('mobile = 0');
  
  $this->db->where('visible = 1');
  
  if ($limit > 0) $this->db->limit($limit);
  
  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }
 
}