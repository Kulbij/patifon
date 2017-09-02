<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Article_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }
 
 public function is($link = '') {
  if (empty($link)) return false;
  $link = parent::prepareDataString($link);
  $res = $this->db->select('id')->from('site_article')->where('link = '.$this->db->escape($link))->where('visible = 1')->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res['id'];
 }

 public function get($categoryid = 0, $page = 1, $count = 3) {
  $categoryid = (int)$categoryid;

  $count = (int)$count;
  if ($count <= 0) return array();

  if ($page == 0 || $page == 1) $page = 0;
  else $page = ($page * $count) - $count;

  parent::select_lang('name, shorttext');
  $this->db
          ->select('id, link, catid, date, image')
          ->from('site_article')
          ->where('visible = 1')
          ->limit($count, $page)
          ->order_by('date', 'DESC')
          ;

  if ($categoryid > 0) {
   $this->db->where('catid = '.$this->db->escape($categoryid));
  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function getName($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return '';

  parent::select_lang('name');
  $this->db
          ->from('site_article')
          ->where('visible = 1')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }
 
 public function getOne($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return array();

  parent::select_lang('text');
  $this->db
          ->select('id')
          ->from('site_article')
          ->where('visible = 1')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function getCount($categoryid = 0) {
  $categoryid = (int)$categoryid;

  $this->db
          ->select('COUNT(*) as count')
          ->from('site_article')
          ->where('visible = 1')
          ;

  if ($categoryid > 0) {
   $this->db->where('catid = '.$this->db->escape($categoryid));
  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['count'];
 }
 
}