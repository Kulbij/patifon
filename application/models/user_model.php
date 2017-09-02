<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class User_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }

 #user region
 
 #is by identity
 public function is($identity, $user_id = 0) {
  $user_id = (int)$user_id;
  if (empty($identity)) return false;

  $this->db
          ->select('id')
          ->from('auth_users')
          ->where('identity = '.$this->db->escape($identity))
          ->limit(1)
          ;
  
  if ($user_id > 0) {
   $this->db->where('id = '.$this->db->escape($user_id));
  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res['id'];
 }

 public function is_dod($identity, $user_id = 0) {
  $user_id = (int)$user_id;
  if (empty($identity)) return false;

  $this->db
          ->select('id')
          ->from('auth_users_phones')
          ->where('phone = '.$this->db->escape($identity))
          ->limit(1)
          ;
  
  if ($user_id > 0) {
   $this->db->where('user_id = '.$this->db->escape($user_id));
  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res['id'];
 }

 public function is_idenitity_not_user($identity, $user_id) {
  $user_id = (int)$user_id;
  if (empty($identity) || $user_id <= 0) return true;

  #check main identity
  $this->db
          ->select('id')
          ->from('auth_users')
          ->where('identity = '.$this->db->escape($identity))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() > 0) {
   return true;
   // $res = $res->row_array();
   // if ($res['id'] == $user_id) return false;
   // else return true;
  }

  #check add identity
  $this->db
          ->select('user_id')
          ->from('auth_users_phones')
          ->where('phone = '.$this->db->escape($identity))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() > 0) {
   $res = $res->row_array();
   if ($res['user_id'] == $user_id) return false;
   else return true;
  }

  return false;
 }

 public function user_get_info($user_id = 0) {
  $user_id = (int)$user_id;
  if ($user_id <= 0) return array();

  $this->db
          ->select('identity, username, email, phone, subscribe, share_50, is_social_from')
          ->from('auth_users')
          ->where('id = '.$this->db->escape($user_id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function user_up_info($user_id, $data, $phones = array()) {
  $user_id = (int)$user_id;
  $data = parent::prepareDataString($data);
  if ($user_id <= 0 || empty($data)) return false;

  $this->db
          ->where('id = '.$this->db->escape($user_id))
          ->limit(1)
          ->update('auth_users', $data)
          ;

  if (isset($data['email']) && !empty($data['email'])) $this->session->set_userdata('email', $data['email']);
  
  if (is_array($phones) && !empty($phones) && 
      count($phones) <= $this->config->item('auth_user_phone_max_count')
     ) {

   foreach ($phones as $key => $value) {

    $identity = strtolower($this->input->prepare_user_identity_phone($value));

    $this->db
            ->select('id')
            ->from('auth_users_phones')
            ->where('id = '.$this->db->escape($key))
            ->where('user_id = '.$this->db->escape($user_id))
            ->limit(1)
            ;
    
    $_is = $this->db->get();

    $this->db
            ->set('user_id', $user_id)
            ->set('phone', $identity)
            ;

    if ($_is->num_rows() > 0) {

     $this->db
             ->where('id = '.$this->db->escape($key))
             ->update('auth_users_phones')
             ;

    } else {

     $this->db
             ->insert('auth_users_phones')
             ;

    }

   }

  }

  return true;
 }

 public function user_set_subscribe($user_id, $value) {
  $user_id = (int)$user_id;
  $value = (bool)$value;
  if ($user_id <= 0) return false;

  $this->db
          ->set('subscribe', $value)
          ->where('id = '.$this->db->escape($user_id))
          ->limit(1)
          ->update('auth_users')
          ;

  $this->session->set_userdata('user_subscribe', $value);

  return true;
 }

 public function user_set_promo($user_id, $value) {
  $user_id = (int)$user_id;
  $value = (bool)$value;
  if ($user_id <= 0) return false;

  $this->db
          ->set('share_50', $value)
          ->where('id = '.$this->db->escape($user_id))
          ->limit(1)
          ->update('auth_users')
          ;

  $this->session->set_userdata('user_share_50', $value);

  return true;
 }

 public function user_set_discount($user_id, $value) {
  $user_id = (int)$user_id;
  $value = (bool)$value;
  if ($user_id <= 0) return false;

  $this->db->set('share_50', $value)->where('id = '.$this->db->escape($user_id))->limit(1)->update('auth_users');
  return true;
 }

 public function add_phone_count($user_id) {
  $user_id = (int)$user_id;
  if ($user_id <= 0) return false;

  $this->db
          ->select('COUNT(*) as count')
          ->from('auth_users_phones')
          ->where('user_id = '.$this->db->escape($user_id))
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['count'];
 }

 public function add_phone($user_id, $phone) {
  $user_id = (int)$user_id;
  if ($user_id <= 0 || empty($phone)) return false;

  if ($this->user_model->add_phone_count($this->session->userdata('user_id')) >= $this->config->item('auth_user_phone_max_count')) return false;

  $this->db
          ->select('id')
          ->from('auth_users_phones')
          ->where('user_id = '.$this->db->escape($user_id))
          ->where('phone = '.$this->db->escape($phone))
          ->limit(1)
          ;

  $is = $this->db->get();
  if ($is->num_rows() > 0) return false;

  $this->db
          ->set('user_id', $user_id)
          ->set('phone', $phone)
          ->insert('auth_users_phones')
          ;

  return (int)$this->db->insert_id();
 }

 public function remove_phone($user_id, $phone_id) {
  $user_id = (int)$user_id;
  $phone_id = (int)$phone_id;
  if ($user_id <= 0 || $phone_id <= 0) return false;

  $this->db
          ->where('id = '.$this->db->escape($phone_id))
          ->where('user_id = '.$this->db->escape($user_id))
          ->limit(1)
          ->delete('auth_users_phones')
          ;

  return true;
 }

 public function phone_get_list($user_id) {
  $user_id = (int)$user_id;
  if ($user_id <= 0) return array();

  $this->db
          ->select('id, phone')
          ->from('auth_users_phones')
          ->where('user_id = '.$this->db->escape($user_id))
          ->order_by('id', 'ASC')
          ;
  
  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function has_email($user_id) {
  $user_id = (int)$user_id;
  if ($user_id <= 0) return false;

  $this->db
          ->select('email')
          ->from('auth_users')
          ->where('id = '.$this->db->escape($user_id))
          ->limit(1)
          ;
  
  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();

  if (empty($res['email'])) return false;

  return true;
 }

 public function set_email($user_id, $email) {
  $user_id = (int)$user_id;
  $email = parent::prepareDataString($email);
  if ($user_id <= 0) return false;

  $this->db
          ->set('email', $email)
          ->where('id = '.$this->db->escape($user_id))
          ->limit(1)
          ->update('auth_users')
          ;
  
  $this->session->set_userdata('email', $email);

  return true;
 }

 public function user_get_orders($user_id = 0) {
  $user_id = (int)$user_id;
  if ($user_id <= 0) return array();

  $query = "

   SELECT site_order.id, site_order.datetime, site_order.check, site_order.canceled
   FROM (site_order)
   WHERE site_order.user_id = ".$this->db->escape($user_id)."
   ORDER BY site_order.datetime DESC

  ";

  $res = $this->db->query($query);
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $idis = array();
  $return = array();
  foreach ($res as $one) {

   $return[$one['id']] = $one;
   $return[$one['id']]['quantity'] = 0;
   $return[$one['id']]['sum'] = 0;

   array_push($idis, $one['id']);

  }

  $cart = $this->db->select('orderid, quantity, sum')->from('site_order_cart')->where_in('orderid', $idis)->order_by('orderid')->get();
  if ($cart->num_rows() > 0) {
   $cart = $cart->result_array();
   
   $temp = array();
   foreach ($cart as $one) {

    if (isset($return[$one['orderid']])) {

     $return[$one['orderid']]['quantity'] += $one['quantity'];
     $return[$one['orderid']]['sum'] += ($one['quantity'] * $one['sum']);

    }

   }

  }

  return $return;
 }

 public function user_is_order($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return false;

  $this->db
          ->select('id')
          ->from('site_order_cart')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->row_array() <= 0) return false;
  return true;
 }

 public function user_get_order($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return array();

  parent::select_lang('site_catalog.name');
  $this->db
          ->select('site_order_cart.id, site_order_cart.quantity, site_order_cart.sum, site_order_cart.catalogid,
            site_catalog.link, site_catalog.image, site_order.discount as order_discount
           ')
          ->from('site_order')->from('site_order_cart')->from('site_catalog')
          ->where('site_order.id = site_order_cart.orderid')
          ->where('site_order_cart.catalogid = site_catalog.id')
          ->where('site_order_cart.orderid = '.$this->db->escape($id))
          ;

  parent::select_lang('site_catalog_filters.name as color_name');
  $this->db
          ->select('site_catalog_filters.color')
          ->join('site_catalog_filters', 'site_order_cart.colorid = site_catalog_filters.id', 'left')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  foreach ($res as &$one) {

   $one['image'] = 'images/'.$one['catalogid'].'/mainimg/'.parent::image_to_ext($one['image'], '_cat');

  } unset($one);

  return $res;
 }

 #this is the end... */

 #page region
 
 public function page_is($link = '') {
  $link = parent::prepareDataString($link);
  if (empty($link)) return false;

  $this->db
          ->select('id')
          ->from('site_page_user')
          ->where('link = '.$this->db->escape($link))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res['id'];
 }

 public function page_get_view($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return '';

  $this->db
          ->select('page_view')
          ->from('site_page_user')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['page_view'];
 }

 public function page_get_name($link = '') {
  $link = parent::prepareDataString($link);
  if (empty($link)) return '';

  parent::select_lang('name');
  $this->db
          ->from('site_page_user')
          ->where('link = '.$this->db->escape($link))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }

 public function page_get_list($parent_id = 0) {
  $parent_id = (int)$parent_id;
  if ($parent_id < 0) return array();
  
  parent::select_lang('name');
  $this->db
          ->select('id, link')
          ->from('site_page_user')
          ->where('visible = 1')
          ->order_by('position', 'ASC')
          ;
  
  if ($parent_id > 0) $this->db->where('parent_id = '.$this->db->escape($parent_id));
  else $this->db->where('parent_id = 0');

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 #this is the end... */
 
 #know region
 
 public function know_is($idis = array()) {
  $idis = parent::prepareDataString($idis);
  if (!is_array($idis) || empty($idis)) return array();

  $this->db
          ->select('id')
          ->from('auth_know_about_site')
          ->where_in('id', $idis)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $idis = array();
  foreach ($res as $one) array_push($idis, $one['id']);
  return $idis;
 }

 public function know_to_user($idis = array(), $user_id = 0) {
  $user_id = (int)$user_id;
  $idis = parent::prepareDataString($idis);
  if ($user_id <= 0 || !is_array($idis) || empty($idis)) return false;

  foreach ($idis as $one) $this->db->set('about_id', $one)->set('user_id', $user_id)->insert('auth_know_about_site_to_user');

  return true;
 }

 public function know_get() {
  parent::select_lang('name');
  $res = $this->db->select('id')->from('auth_know_about_site')->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 #this is the end... */
 
 #comments
 
 public function comm_get_count($user_id = 0) {
  $user_id = (int)$user_id;
  if ($user_id <= 0) return 0;

  $query = "

   SELECT COUNT(*) as count
   FROM (site_catalog)
   WHERE site_catalog.id IN (
     SELECT site_catalog_review.objectid
     FROM (site_catalog_review)
     WHERE site_catalog_review.userid = ".$this->db->escape($user_id)."
      AND site_catalog_review.check = 1
     GROUP BY site_catalog_review.objectid
    )

  ";

  $res = $this->db->query($query);
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['count'];
 }

 public function comm_get($user_id = 0, $page = 1, $count = 0) {
  $user_id = (int)$user_id;
  $page = (int)$page;
  $count = (int)$count;
  if ($user_id <= 0 || $page <= 0 || $count <= 0) return array();

  if ($page == 1) $page = 0;
  else $page = ($page * $count) - $count;

  $query = "

   SELECT site_catalog.id, site_catalog.name_".SITELANG." as name, site_catalog.link
   FROM (site_catalog, site_catalog_review)
   WHERE site_catalog.id = site_catalog_review.objectid
    AND site_catalog_review.userid = ".$this->db->escape($user_id)."
    AND site_catalog_review.check = 1
   GROUP BY site_catalog.id
   ORDER BY site_catalog_review.datetime DESC
   LIMIT ".$page.", ".$count."

  ";
  $res = $this->db->query($query);
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $query = "

   SELECT site_catalog_review.id, site_catalog_review.datetime, site_catalog_review.text, site_catalog_review.objectid
   FROM (site_catalog_review)
   WHERE site_catalog_review.userid = ".$this->db->escape($user_id)."
    AND site_catalog_review.check = 1
   ORDER BY site_catalog_review.objectid ASC

  ";
  $comm = $this->db->query($query);
  if ($comm->num_rows() <= 0) return array();
  $comm = $comm->result_array();

  $return = array();

  foreach ($res as $one) {
   $one['comments'] = array();

   foreach ($comm as $two) {
    if ($one['id'] == $two['objectid']) array_push($one['comments'], $two);
   }

   array_push($return, $one);
  }

  return $return;
 }

 #this is the end... */
 
 #catalog
 
 public function add_to_visited($user_id, $object_id) {
  $user_id = (int)$user_id;
  $object_id = (int)$object_id;
  if ($user_id <= 0 || $object_id <= 0) return false;

  $this->db
          ->where('user_id = '.$this->db->escape($user_id))
          ->where('catalog_id = '.$this->db->escape($object_id))
          ->delete('auth_users_catalog_last_see')
          ;

  $count = 0;

  $this->db
          ->select('COUNT(*) as count')
          ->from('auth_users_catalog_last_see')
          ->where('user_id = '.$this->db->escape($user_id))
          ;
  
  $count = $this->db->get();
  if ($count->num_rows() > 0) {
   $count = $count->row_array();
   $count = $count['count'];
  } else $count = 0;

  if ($count >= $this->config->item('auth_user_catalog_max_last_see')) {

   $this->db
           ->select('id')
           ->from('auth_users_catalog_last_see')
           ->where('user_id = '.$this->db->escape($user_id))
           ->order_by('datetime', 'ASC')
           ->limit(1)
           ;

   $res = $this->db->get();
   if ($res->num_rows() > 0) {
    $res = $res->row_array();

    $this->db
            ->where('id = '.$this->db->escape($res['id']))
            ->limit(1)
            ->delete('auth_users_catalog_last_see')
            ;

   }

  }

  $this->db
          ->set('user_id', $user_id)
          ->set('catalog_id', $object_id)
          ->set('datetime', date('Y-m-d H:i:s'))
          ->insert('auth_users_catalog_last_see')
          ;

  return true;
 }

 public function user_favorite($user_id, $object_id) {
  $user_id = (int)$user_id;
  $object_id = (int)$object_id;
  if ($user_id <= 0 || $object_id <= 0) return false;

  $this->db
          ->select('id')
          ->from('auth_users_catalog_favorite')
          ->where('user_id = '.$this->db->escape($user_id))
          ->where('catalog_id = '.$this->db->escape($object_id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() > 0) {
   $res = $res->row_array();

   $this->db
           ->where('id = '.$this->db->escape($res['id']))
           ->limit(1)
           ->delete('auth_users_catalog_favorite')
           ;

   return 'fav_rem';

  } else {

   $this->db
           ->set('datetime', date('Y-m-d H:i:s'))
           ->set('user_id', $user_id)
           ->set('catalog_id', $object_id)
           ->limit(1)
           ->insert('auth_users_catalog_favorite')
           ;

   return 'fav_add';

  }

  return false;
 }

 #this is the end... */

}