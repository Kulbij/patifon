<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Index_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }

 public function get_banners() {
  $this->db
          ->select('id, image, link, obj_id')
          ->from('site_indexbanner')
          ->where('visible', 1)
          ->order_by('position', 'ASC')
          ;
  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  $this->load->model('catalog_model');
  $this->load->model('menu_model');
  foreach($res as &$one){
      if((int)$one['obj_id'] > 0){
          $one['object'] = $this->catalog_model->getOne($one['obj_id']);
          $one['object']['links'] = $this->menu_model->getObjectCategories($one['object']['id']);
      }
  }
  return $res;
 }

  public function getInformerProduct() {

  $res = $this->db
                  ->select('site_var.name_'.SITELANG.' as name, site_var.shorttext_'.SITELANG.' as shorttext, site_var.text_'.SITELANG.' as text, site_var.key')
                  ->from('site_var')
                  ->where('site_var.visible', 1)
                  ->get();

    if($res->num_rows() <= 0) return false;
    $res = $res->result_array();

    return $res;
 }

 public function getVar($key = '') {
  if (empty($key)) return array();

  parent::select_lang('name, shorttext, text');
  $this->db
          ->select('id, key')
          ->from('site_var')
          ->where('key = '.$this->db->escape($key))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

}