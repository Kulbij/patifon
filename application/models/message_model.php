<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Message_model extends Base_model {
  public function __construct() {
  parent::__construct();
  }

  public function sendMSG($array = array()) {
    if(!isset($array) && empty($array) && !is_array($array)) return false;

    $this->db->insert('site_message', $array);
  }




}