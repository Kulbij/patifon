<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'main.php';

class Message extends Main {
 public function __construct() {
  parent::__construct();
 }

 public function send($id = 0) {
  if(!is_numeric($id) && !(int)$id && !isset($id) && empty($id)) site_404_url();

  $data['id'] = '1243';
  $view = 'send_view';

  $this->load->library('display_lib');
  $this->display_lib->msg_send($data, $view);
 }

 public function SendMessagesForUser($id = 0) {
    if(!isset($id) && empty($id) && !(int)$id && !is_numeric($id)) site_404_url();

    $array = array(
                    'text' => $this->input->post('message'),
                    'my_id' => $this->input->post('id'),
                    'user_id' => $this->input->post('send-user-id')
                  );

    $this->load->model('message_model', 'model');
    $this->model->sendMSG($array);
 }

 
 }