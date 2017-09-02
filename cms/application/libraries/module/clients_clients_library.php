<?php

class Clients_clients_library {
 
 private $ci;
 
 function __construct() {
  $this->ci = &get_instance();
  $this->ci->load->model('clients/clients_clients_model', 'model');
 }
 
 public function set_visible($id, $visible) {
  $this->ci->model->set_visible($id, $visible);
 }

 public function save($array) {
  return $this->ci->model->save($array);
 }

 public function remove($id) {
  $id = (int)$id;
  if ($id <= 0) return false;

  return $this->ci->model->remove($id);
 }
 
}