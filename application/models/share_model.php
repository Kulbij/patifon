<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Share_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }
 
 public function is($table = '', $link = '') {
  if (empty($table) || empty($link)) return false;
  $link = parent::prepareDataString($link);
  $res = $this->db->select('id')->from($table)->where('link = '.$this->db->escape($link))->where('visible = 1')->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res['id'];
 }
 
 public function isCat($table = '', $link = '') {
  if (empty($table) || empty($link)) return false;
  $link = parent::prepareDataString($link);
  $res = $this->db->select('id')->from($table)->where('link = '.$this->db->escape($link))->where('visible = 1')->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res['id'];
 }
 
 public function getCats($table = '') {
  if (empty($table)) return false;
  $res = $this->db->select('id, name_'.SITELANG.' as name, link, image')->from($table)->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }
 
 public function getCat($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return array();
  $res = $this->db->select('id, link, name_'.SITELANG.' as name')->from('site_share_cat')->where('id = '.$this->db->escape($id))->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }
 
 public function getCatByShareID($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return array();
  
  $res = $this->db->select('catid')->from('site_share')->where('id = '.$this->db->escape($id))->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  
  $res = $this->db->select('id, link, name_'.SITELANG.' as name')->from('site_share_cat')->where('id = '.$this->db->escape($res['catid']))->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }
 
 public function get($table = '', $page = 0, $count = 0, $categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid < 0) return false;
  if (empty($table)) return array();
  
  if ($page == 0 || $page == 1) $page = 0;
  else $page = ($page * $count) - $count;
  
  $this->db->select('id, link, date, image, name_'.SITELANG.' as name, shorttext_'.SITELANG.' as shorttext')->from($table);
  
  if ($categoryid > 0) $this->db->where('site_share.catid = '.$this->db->escape($categoryid));
  
  $this->db->where('visible = 1');
  $res = $this->db->order_by('date', 'DESC')->limit($count, $page)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }
 
 public function getLast($categoryid = 0, $count = 2) {
  $categoryid = (int)$categoryid;
  if ($categoryid < 0) return array();
  $count = (int)$count;
  if ($count <= 0) return array();
  
  $this->db->select('site_share.id, site_share.link, site_share.date, site_share.image, site_share.name_'.SITELANG.' as name, site_share.shorttext_'.SITELANG.' as shorttext')->from('site_share');
  
  if ($categoryid > 0) $this->db->where('site_share.catid = '.$this->db->escape($categoryid));
  
  $this->db->where('site_share.visible = 1');
  $res = $this->db->order_by('site_share.date', 'DESC')->limit($count)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }
 
 public function getCount($table = '', $categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid < 0) return false;
  if (empty($table)) return array();
  
  $this->db->select('COUNT(*) as count')->from($table);
  
  if ($categoryid > 0) $this->db->where('site_share.catid = '.$this->db->escape($categoryid));
  
  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['count'];
 }
 
 public function getOne($table = '', $id = 0) {
  if (empty($table)) return array();
  $id = (int)$id;
  if ($id <= 0) return array();
  $res = $this->db->select('id, link, name_'.SITELANG.' as name, image, text_'.SITELANG.' as text')->from($table)->where('id = '.$this->db->escape($id))->where('visible = 1')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }
 
 public function getOneName($table = '', $id = 0) {
  if (empty($table)) return '';
  $id = (int)$id;
  if ($id <= 0) return array();
  $res = $this->db->select('name_'.SITELANG.' as name')->from($table)->where('id = '.$this->db->escape($id))->where('visible = 1')->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }
 
 public function getOneImages($table = '', $id = 0) {
  if (empty($table)) return '';
  $id = (int)$id;
  if ($id <= 0) return array();
  $res = $this->db->select('top_image, top_image_big, top_image2, top_image2_big')->from($table)->where('id = '.$this->db->escape($id))->where('visible = 1')->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res;
 }
 
 public function getTKD($table = '', $id = 0) {
  if (empty($table)) return array();
  $id = (int)$id;
  if ($id <= 0) return array();
  $res = $this->db->select('title_'.SITELANG.' as title, keyword_'.SITELANG.' as keyword, description_'.SITELANG.' as description')->from($table)->where('id = '.$this->db->escape($id))->where('visible = 1')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }
}