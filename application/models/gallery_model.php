<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Gallery_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }

 public function is($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return false;
  
  $res = $this->db->select('id')->from('site_gallerycat')->where('id = '.$this->db->escape($id))->limit(1)->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }
 
 public function getGalleries() {
  $res = $this->db->select('id, name_'.SITELANG.' as name, image')->from('site_gallerycat')->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }
 
 public function getImages($galid = 0) {
  $galid = (int)$galid;
  if ($galid <= 0) return array();
  
  $res = $this->db->select('id, image, image_big')->from('site_gallery')->where('visible = 1')->where('catid = '.$this->db->escape($galid))->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }
 
 public function getGalleryName($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return '';
  
  $res = $this->db->select('name_'.SITELANG.' as name')->from('site_gallerycat')->where('id = '.$this->db->escape($id))->where('visible = 1')->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }
 
 public function getTKD($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return array();
  
  $res = $this->db->select('title_'.SITELANG.' as title, keyword_'.SITELANG.' as keyword, description_'.SITELANG.' as description')->from('site_gallerycat')->where('id = '.$this->db->escape($id))->where('visible = 1')->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }
 
}