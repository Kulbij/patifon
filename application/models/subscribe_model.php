<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Subscribe_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }

 public function is($email = '') {
  $email = parent::prepareDataString($email);
  if (empty($email)) return false;

  $this->db
          ->select('id')
          ->from('site_subscribe')
          ->where('email = '.$this->db->escape($email))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res['id'];
 }

 public function get_one_by_user($user_id = 0) {
  $user_id = (int)$user_id;
  if ($user_id <= 0) return array();

  $this->db
          ->select('id, user_id, email')
          ->from('site_subscribe')
          ->where('user_id = '.$this->db->escape($user_id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function get_one($email = '') {
  $email = parent::prepareDataString($email);
  if (empty($email)) return array();

  $this->db
          ->select('id, user_id, email')
          ->from('site_subscribe')
          ->where('email = '.$this->db->escape($email))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function insert($array = array()) {
  if (!is_array($array) || empty($array)) return false;

  $this->db->insert('site_subscribe', $array);

  return (int)$this->db->insert_id();
 }

 public function remove($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return false;

  $this->db->where('id = '.$this->db->escape($id))->limit(1)->delete('site_subscribe');

  return true;
 }
 
}