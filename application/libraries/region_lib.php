<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 library use standart CI -> session
 variable: SESS_DELIVERYCITY = array('id', 'name', 'markup');
*/

class Region_lib {
 #session variable
 private $VARIABLE;
 
 public function __construct() {
  $this->VARIABLE = 'SESS_DELIVERYCITY';
  $this->load->model('region_model');
 }
 
 public function __get($variable) {
  return get_instance()->$variable;
 }
 
 public function unsetRegion($return_last = false) {
  $return = true;
  if ($this->getRegion()) {
   if ($return_last) $return = $this->getRegion();
   $this->session->unset_userdata($this->VARIABLE);
  }
  return $return;
 }
 
 public function setRegion($data = null, $field = false, $return_last = false) {
  if (is_null($data) || (is_array($data) && empty($data)) || empty($data)) return false;
  $return = true;
  if (!$field) {
   $return = $this->unsetRegion($return_last);
   $this->session->set_userdata($this->VARIABLE, $data);
  } else {
   $return = $this->getRegion();
   $temp = $return;
   if (is_array($temp) && isset($temp[$field])) {
    $temp[$field] = $data;
    $this->unsetRegion();
    $this->session->set_userdata($this->VARIABLE, $temp);
   }
   if (!$return_last) $return = true;
  }
  return $return;
 }
 
 public function getRegion($field = false) {
  $return = false;
  if ($this->session->userdata($this->VARIABLE)) $return = $this->session->userdata($this->VARIABLE);
  if ($field !== false) {
   if (is_array($return) && isset($return[$field])) $return = $return[$field];
  }
  return $return;
 }
 
 public function setDefaultRegion() {
  if ($this->getRegion()) return false;
  $data = $this->region_model->getSESS_DefaultRegion();
  $this->setRegion($data);
  $this->region_model->getSESS_DefaultRegion();
  return $this->getRegion();
 }
 
 public function changeRegion($id) {
  $id = (int)$id;
  if ($id <= 0) return false;
  $return = $this->getRegion();
  #if (isset($return['id']) && $return['id'] != $id) {
   $data = $this->region_model->getSESS_Region($id);
   $data['lang'] = SITELANG;
   $return = $this->setRegion($data, false, true);
  #}
  return $return;
 }
 
 public function updateRegion() {
  $data = $this->session->userdata($this->VARIABLE);
  if (!isset($data['lang']) || $data['lang'] == SITELANG) return false;
  $this->changeRegion($data['id']);
 }
}