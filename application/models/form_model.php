<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Form_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }
 public function insert_comment(array $array = array()){
     if (!is_array($array) || empty($array)) return false;

    $array = parent::prepareDataString($array);
    $this->db->insert('site_comment', $array);
    $insert_id = $this->db->insert_id();    
    $this->setState('site_comment_stat', (int)$insert_id);
    return $insert_id;
 }
 public function insert_feedback($array = array()) {
  if (!is_array($array) || empty($array)) return false;

  $array = parent::prepareDataString($array);

  $this->db->insert('site_feedback', $array);

  $insert_id = $this->db->insert_id();

  $id = $this->setState('site_feedback_stat', (int)$insert_id);

  return $insert_id;
 }

 public function insert_feedphone($array = array()) {
  if (!is_array($array) || empty($array)) return false;

  $array = parent::prepareDataString($array);

  $this->db->insert('site_feedphone', $array);

  $insert_id = $this->db->insert_id();

  $id = $this->setState('site_feedphone_stat', (int)$insert_id);

  return $insert_id;
 }

 public function insert_buyback($array) {
  
  if (!is_array($array) || empty($array)) return false;

  $array = parent::prepareDataString($array);

  $this->db->insert('site_order_click', $array);

  $insert_id = $this->db->insert_id();

  return $insert_id;
 }

 public function insert_order($array = array()) {
  if (!is_array($array) || empty($array)) return false;

  $cart = $this->cart->contents(); 

  if (empty($cart)) return false;

  $array = parent::prepareDataString($array);

  $this->db->insert('site_order', $array);

  $orderid = $this->db->insert_id();

  $this->setState('site_order_stat', (int)$orderid);

  $this->load->model('catalog_model');

  $idis = array();
  foreach ($cart as $one) {
   if (isset($one['id'])) array_push($idis, $one['id']);
  }
  $objects = $this->catalog_model->getCartObject($idis);  
  

  $ins_array = array();
  foreach ($cart as $one) {
   if (isset($one['id']) && isset($objects[$one['id']]['price'])) {
    $temp = array();
    $temp['orderid'] = $orderid;
    $temp['catalogid'] = $one['id'];
    $temp['sum'] = round($one['price'], 2);
    $temp['quantity'] = $one['qty'];
    array_push($ins_array, $temp);
   }
  }

  $this->db->insert_batch('site_order_cart', $ins_array);

  return $orderid;
 }

 public function order_link_with_user($order_id, $user_id) {
  $order_id = (int)$order_id;
  $user_id = (int)$user_id;
  if ($order_id <= 0 || $user_id <= 0) return false;

  $this->db
          ->set('user_id', $user_id)
          ->where('id = '.$this->db->escape($order_id))
          ->limit(1)
          ->update('site_order');

  return true;
 }

 public function insert_review($array = array()) {
  if (!is_array($array) || empty($array)) return false;

  $array = parent::prepareDataString($array);

  $this->db->insert('site_catalog_review', $array);

  $insert_id = $this->db->insert_id();

  $id = $this->setState('site_feedphone_stat', (int)$insert_id);

  return $insert_id;
 }

 public function setState($table = '', $tableid = 0) {
  if (empty($table)) return false;

  $this->load->library('user_agent');
  $date = date('Y-m-d H:i:s');
  $browser = $this->agent->agent_string();
  $ip = $this->input->ip_address();

  $this->db->set('tableid', (int)$tableid);
  $this->db->set('datetime', $date);
  $this->db->set('browser', $browser);
  $this->db->set('ip', parent::ip2int($ip));
  $this->db->insert($table);

  return $this->db->insert_id();
}

    public function Proverka($array = array()) {
      if(!isset($array) && empty($array) && !is_array($array)) return false;

      $proverka['phone'] = $this->ProverkaParam($array['phone'], 'phone');
      $proverka['email'] = $this->ProverkaParam($array['email'], 'email');

      if($proverka['phone'] == 0 && $proverka['email'] == 0) $count = 0;
      else $count = 1;

      return $count;
    }

   private function ProverkaParam($param = '', $value = '') {
      if(!isset($param) && empty($param)) return false;

      $res = $this->db
                    ->select('COUNT(site_users.'.$value.') as count')
                    ->where('site_users.'.$value, $param)
                    ->limit(1)
                    ->from('site_users')->get();

      if($res->num_rows() <= 0) return false;
      $res = $res->row_array();

      return $res['count'];
   }

   public function insertUser($array = array()) {
      if(!isset($array) && empty($array) && !is_array($array)) return false;

      $this->db->insert('site_users', $array);
   }

   public function getUserFullRegistration($array = array()) {
    if(!isset($array) && empty($array) && !is_array($array)) return false;

    $this->db->select('site_users.id, site_users.phone, site_users.email');

    $this->db->where('site_users.phone', $array['phone'])->where('site_users.email', $array['email']);

    $res = $this->db->from('site_users')->limit(1)->get();

    if($res->num_rows() <= 0) return false;
    $res = $res->row_array();

    return $res['id'];
   }

   public function getIDUser($array = array()) {
      if(!isset($array) && empty($array) && !is_array($array)) return false;

      $res = $this->db->select('site_users.id')
      ->where('site_users.phone', $array['phone'])
      ->where('site_users.email', $array['email'])
      ->from('site_users')
      ->limit(1)
      ->get();

      if($res->num_rows() <= 0) return false;
      $res = $res->row_array();

      return $res['id'];
   }

}