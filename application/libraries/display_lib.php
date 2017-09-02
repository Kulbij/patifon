<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Display_lib {
 
 public function __construct() {
 }
 
 public function __get($variable) {
  return get_instance()->$variable;
 }
 
 public function index($data, $page) {
  $this->load->view('general/header_view', $data);
  $this->load->view('general/top_view');
  $this->load->view('pages/'.$page);
  $this->load->view('general/footer_view');
 }
 
 #404 page
 public function page_404($data, $page) {
  $this->load->view($page, $data);
 }
 #end 404 page
 
 #Catalog region
 public function catalog($data, $page) {
  $this->load->view('general/header_view', $data);
  $this->load->view('general/top_view');
  $this->load->view('pages/'.$page);
  $this->load->view('general/footer_view');
 }
 #end Catalog region

 //--podcatalog
 public function podcatalog ($data, $page) {
  $this->load->view('general/header_view', $data);
  $this->load->view('general/top_view');
  $this->load->view('pages/'.$page);
  $this->load->view('general/footer_view');
 }
 // -- end podcatalog
 
 #Object region
 public function object($data, $page) {
  // $this->load->view('general/header_view', $data);
  // $this->load->view('general/top_view');
  $this->load->view('general/header_new_view', $data);
  $this->load->view('general/top_new_view');
  $this->load->view('pages/object/object_new_view');
  //$this->load->view('general/footer_view');
  $this->load->view('general/footer_new_view');
 }

 public function object_new($data, $page) {
  $this->load->view('general/header_new_view', $data);
  $this->load->view('general/top_new_view');
  $this->load->view('pages/object/object_new_view');
  $this->load->view('general/footer_new_view');
 }
 #end Object region
 
 public function page($data, $page) {     
  $this->load->view('general/header_view', $data);
  $this->load->view('general/top_view');
  $this->load->view('pages/'.$page);
  $this->load->view('general/footer_view');
 }

 public function user($data, $page) {
  $this->load->view('general/header_view', $data);
  $this->load->view('general/top_view');
  $this->load->view('auth/page/'.$data);
  $this->load->view('general/footer_view');
 }

 public function msg_send($data, $page) {
  $this->load->view('general/header_new_view', $data);
  $this->load->view('auth/msg/'.$page);
 }
}