<?php

class Clients_clients_model extends CI_Model {

 function __construct() {
  parent::__construct();
 }
 
 public function set_visible($id, $visible) {
  $id = (int)$id;
  $visible = (bool)$visible;
  if ($id <= 0) return false;

  $this->db
          ->set('active', $visible)
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ->update('auth_users')
          ;

  return true;
 }

 public function get($page = 1, $count = 0, $cat = 0) {
  $page = (int)$page;
  $count = (int)$count;
  $cat = (int)$cat;
  if ($page < 0 || $count <= 0) return array();

  if ($page == 0 || $page == 1) $page = 0;
  else $page = ($page * $count) - $count;

  $this->db
          ->select('id, identity, username, active')
          ->from('auth_users')
          ->where('id > 1')
          ->limit($count, $page)
          ->order_by('created_on', 'DESC')
          ;

  if ($cat > 0) {
   #i don't know what i'm doing now
  }

  if ($this->input->post('username') !== false) {

   $search_this = $this->db->escape('%'.$this->input->post('username').'%');

   $this->db
           ->where(
            "(
              username LIKE ".$search_this."
              OR identity LIKE ".$search_this."
             )
            ",
            null,
            false
            );

  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function get_count($cat = 0) {
  $cat = (int)$cat;

  $this->db
          ->select('COUNT(*) as count')
          ->from('auth_users')
          ->where('id > 1')
          ;

  if ($cat > 0) {
   #i don't know what i'm doing now encore... parle en francais
  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['count'];
 }
 
 public function get_one($id) {
  $id = (int)$id;
  if ($id <= 1) return array();

  $this->db
          ->select('*')
          ->from('auth_users')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  #get order by'
  
  $this->db
          ->select('id, datetime, name, check, canceled')
          ->from('site_order')
          ->where('user_id = '.$this->db->escape($id))
          ->order_by('datetime', 'DESC')->order_by('id', 'DESC')
          ;

  $temp = $this->db->get();
  if ($temp->num_rows() > 0) {

   $res[0]['orders'] = $temp->result_array();

  } else $res[0]['orders'] = array();

  #this is the end... */

  return $res;
 }

 public function save($array = array()) {
  if (empty($array)) return false;

  #start here

  return true;
 }

 public function remove($id) {
  $id = (int)$id;
  if ($id <= 1) return false;

  $this->db
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ->delete('auth_users')
          ;

  $this->db
          ->where('user_id = '.$this->db->escape($id))
          ->delete('auth_users_catalog_favorite')
          ;
  
  $this->db
          ->where('user_id = '.$this->db->escape($id))
          ->delete('auth_users_catalog_last_see')
          ;     

  $this->db
          ->where('user_id = '.$this->db->escape($id))
          ->delete('site_order')
          ;

  return true;
 }
    
}