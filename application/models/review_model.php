<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Review_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }

 public function get($object_id = 0, $page = 1, $count = 0) {
  $object_id = (int)$object_id;
  $page = (int)$page;
  $count = (int)$count;
  if ($object_id <= 0 || $page < 0 || $count <= 0) return array();

  if ($page == 1) $page = 0;
  else $page = ($page * $count) - $count;

  $this->db
          ->select('site_catalog_review.id, site_catalog_review.name, site_catalog_review.email,
             site_catalog_review.text, site_catalog_review.datetime
             ')

          ->from('site_catalog_review')

          ->where('site_catalog_review.objectid = '.$this->db->escape($object_id))
          ->where('site_catalog_review.check = 1')

          ->order_by('site_catalog_review.datetime', 'DESC')
          ->limit($count, $page)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function get_count($object_id = 0) {
  $object_id = (int)$object_id;
  if ($object_id <= 0) return 0;

  $this->db
          ->select('COUNT(*) as count')
          
          ->from('site_catalog_review')

          ->where('site_catalog_review.objectid = '.$this->db->escape($object_id))
          ->where('site_catalog_review.check = 1')

          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['count'];
 }

 public function ip_frequency($ip = '', $object_id = 0) {
  $object_id = (int)$object_id;
  if (empty($ip)) return 0;
  $ip = ip2long($ip);

  $this->db
          ->select('COUNT(*) as count')
          ->from('site_catalog_review')
          ->where('ip = '.$this->db->escape($ip))
          ->where('datetime BETWEEN '.$this->db->escape(date('Y-m-d', strtotime('-1 day'))).' AND '.$this->db->escape(date('Y-m-d', strtotime('+1 day'))), null, false)
          ;

  if ($object_id > 0) {
   $this->db->where('objectid = '.$this->db->escape($object_id));
  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['count'];
 }
 
}