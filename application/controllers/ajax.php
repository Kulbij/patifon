<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'main.php';

class Ajax extends Main {
 public function __construct() {
  parent::__construct();
  $this->lang->load(SITELANG, SITELANG);
 }

 public function index($parametter = '', $link = '') {

  if (strtolower($this->input->server('HTTP_X_REQUESTED_WITH')) != 'xmlhttprequest') site_404_url();

  $arr_ajax = array('form', 'form-send', 'data', 'search', 'get-data', 'operation','get-comments', 'comment');

  if (empty($parametter) || !in_array($parametter, $arr_ajax)) {
   echo false;
   die();
  }

  $data = false;

  switch($parametter) {

   case 'operation': {
    $data = $this->operation($link);
   } break;

   case 'comment' : {
    $data['comments'] = $this->comments($link, $_POST['id']);
    echo $this->load->view('inside/object/tab_comments_view', $data, true); die();
   } break;

   case 'form': {
    $data = $this->loadPage($link);
    return true;
   } break;

   case 'form-send': {

    switch($link) {

     case 'feedback': {
      $data = $this->feedbackValidate();
     } break;

     case 'callback': {
      $data = $this->feedphoneValidate();
     } break;
     case 'callbackphone': {
      $data = $this->feedbackPhone();
     } break;

     case 'buyback': {
      $data = $this->buyback_validate();
     } break;
     case 'add_comment': {
      $data = $this->comment_validate();
     } break;

     // case 'review': {
     //  $data = $this->review_validate();
     // } break;

    }

   } break;

   case 'data': {

    $data = array();

    if ($link == 'subscribe') {

     $data = $this->subscriber();

    }

   } break;

   case 'search': {

    $search = (string)$this->input->get('search');

    if (mb_strlen($search) > 3) {

     $this->load->model('catalog_model');
     $search = $this->base_model->prepareDataStringSearch(mb_substr($search, 0, 100));
     $data = $this->catalog_model->getCatalogObjectSearch($search, 1, 7);
     if (!empty($data)) {
      echo $this->load->view('ajax/catalog/search_drop_view', array('products' => $data, '_search' => $this->input->get('search')), true);
     }

    }

    die();

   } break;

   case 'get-data': {

    $this->load->model('region_model');

    $region = $this->input->post('region');
    #if ($this->region_model->is_region($region)) {
     $data['options'] = $this->region_model->get_new_post_city($region);

     echo $this->load->view('ajax/option_view', $data, true);

     die();
    #}

   } break;
   case 'get-comments': {       
    $this->load->model('catalog_model');

    $page = (int)$this->input->post('page');    
    $object_id = (int)$this->input->post('object_id');
    #if ($this->region_model->is_region($region)) {
    
     $data['comments'] = $this->catalog_model->getProductComments($object_id, $page, 6);    
     echo json_encode($this->load->view('ajax/comments_view', $data, true));

     die();
    #}

   } break;

  }

  if (!$data) echo false;
  else echo json_encode($data);

  die();
 }

 private function operation($link) {
  $link_array = array('favorite', 'compare');
  if (!in_array($link, $link_array)) return false;

  $return = array();

  switch ($link) {

   case 'favorite': {

    $cookie = (isset($_COOKIE[$this->config->item('cookie_favorite')])) ? explode(',', $_COOKIE[$this->config->item('cookie_favorite')]) : array();
    $product_id = (int)$this->input->post('product');
    $this->load->model('catalog_model');

    if ($this->catalog_model->isByID($product_id)) {

     if (!in_array($product_id, $cookie)) {
      array_push($cookie, $product_id);
      $return['fav_count'] = $this->catalog_model->up_favorite($product_id);
      $return['add_class'] = 'active';
     } else {
      unset($cookie[array_search($product_id, $cookie)]);
      $return['fav_count'] = $this->catalog_model->up_favorite($product_id, false);
      $return['remove_class'] = 'active';
     }

    }

    setcookie($this->config->item('cookie_favorite'), implode(',', $cookie), time()+3600*24*30, '/', $this->config->item('cookie_dom'));

   } break;

  }

  return $return;
  die();
 }

 private function loadPage($link) {

  switch($link) {

   case 'feedback-form': {
    echo $this->load->view('ajax/feedback_view', null, true);
   } break;

   case 'callback-form': {
    echo $this->load->view('ajax/feedphone_view', null, true);
   } break;

   case 'success': {

    $data = array();

    if ($this->session->userdata($this->config->item('own_box_error_msg'))) {
     $data['class'] = 'bad';
     $data['text'] = $this->lang->line($this->session->userdata($this->config->item('own_box_error_msg')));
     if (empty($data['text'])) $data['text'] = $this->lang->line('site_default_form_error_msg');
    } else {
     $data['class'] = 'gd';
     $data['text'] = $this->lang->line($this->session->userdata($this->config->item('own_box_okey_msg')));
     if (empty($data['text'])) $data['text'] = $this->lang->line('site_default_form_okey_msg');
    }

    $this->session->unset_userdata($this->config->item('own_box_error_msg'));
    $this->session->unset_userdata($this->config->item('own_box_okey_msg'));

    echo $this->load->view('ajax/success_view', $data, true);
   } break;

   case 'size-table': {
    $data = array();

    $category_id = (int)$this->input->post('category');
    $object_id = (int)$this->input->post('object');

    $this->load->model('menu_model');
    $data['category'] = $this->menu_model->getName($category_id);

    $this->load->model('catalog_model');
    $data['size_table'] = $this->catalog_model->get_size_table($category_id, $object_id);

    echo $this->load->view('ajax/ownbox/own_size_table', $data, true);
   } break;

   case 'paket': {

    $data = array();
    $data['id'] = (int)$this->input->post('object');
    $data['active'] = (int)$this->input->post('active');
   
    $this->load->model('catalog_model');
    if ($this->catalog_model->isByID($data['id'])) {
        $this->load->model('menu_model');

       $data['object'] = $this->catalog_model->getOne($data['id']);
       $data['cat_option'] = $this->catalog_model->updatePaket('4', $data['id']);

       echo $this->load->view('ajax/ownbox/own_paket_page_new', array('SITE_CONTENT' => $data), true);
    }

   } break;

   case 'product': {

    $data = array();
    $data['id'] = (int)$this->input->post('object');
    $data['image'] = (int)$this->input->post('image');
   
    $this->load->model('catalog_model');
    if ($this->catalog_model->isByID($data['id'])) {
    $this->load->model('menu_model');
     #$data['data'] = $this->catalog_model->image_get_by_index($data['id'], $data['image']);

     $data['object'] = $this->catalog_model->getOne($data['id']);
     $data['object']['comm_count'] = $this->catalog_model->getCommentsCount($data['id']);
     $data['object']['comm_count'] = $data['object']['comm_count'].' '.parent::pluralForm($data['object']['comm_count'],'отзыв',"отзыва","отзывов");
     $data['object']['mark'] = $this->catalog_model->getObjectAvgMark($data['id']);
     $data['object']['links'] = $this->menu_model->getObjectCategories($data['id']);
     $data['images'] = $this->catalog_model->getImages($data['id']);

     // ------------- Parse array folyrs --------------------------------------
    $count_filter = count($data['object']['filters']);
    $i = 1;
    $name = [];
    foreach($data['object']['filters'] as $key => $value){
      if($count_filter == $i) $name[] = $value['parent_name'].' '.$value['name'];
      else $name[] = $value['parent_name'].' '.$value['name'].' / ';
      $i++;
    } unset($value);
    $data['all_info'] = $name;
    //$data['all_info'] = $this->catalog_model->getImages($data['id']);
    // --------- end ---------------------------------------------------

    // ================================= create array for procesor and camera for filters products and display on site icon ==========

  foreach($data['object']['filters'] as $key => $value){
      if(isset($value['class']) && !empty($value['class']) && $value['class'] == 'icpc'){
        $procesor = explode('(', $value['name']);
        if(isset($procesor[0]) && !empty($procesor[0]))
          $procesor2 = explode(' ', $procesor[0]);
          if(isset($procesor2[0]) && !empty($procesor2[0]) && isset($procesor2[1]) && !empty($procesor2[1]))
            $data['object']['filters'][$key]['procesor_count'] = $procesor2[0];
            $data['object']['filters'][$key]['procesor_value'] = $procesor2[1];
      } elseif(isset($value['class']) && !empty($value['class']) && $value['class'] == 'iccam'){
        $camera = explode('+', $value['name']);
        if(isset($camera[1]) && !empty($camera[1])){
          if(isset($camera[0]) && !empty($camera[0]))
            $data['object']['filters'][$key]['camara_count'] = $camera[0];
        } else {
            $data['object']['filters'][$key]['camara_count'] = $value['name'];
        }
      }
    } unset($value);

    //============================================ end ================================================================

      // ------ add url address for category object
      // $ulr_category = explode('/', $_SERVER['HTTP_REFERER']);

      // if(isset($ulr_category[3]) && !empty($ulr_category[3])){
      //   if($ulr_category[4] == ''){
      //     $data['ulr_category'] = $ulr_category[5];
      //   } else {
      //     $data['ulr_category'] = $ulr_category[4];
      //   }
      // }
    $data['ulr_category'] = $this->catalog_model->get_catalog_category($data['id']);
      // ------------end add url ----------------------

    $data['object']['3G'] = $this->catalog_model->get3G($data['id']);

      $str_3g = $data['object']['features_text'];
      $array_search = strripos($str_3g, '3G');

      if(isset($array_search) && !empty($array_search)){
        if($array_search >= 1){
          $data['object']['3g'][0]['id'] = 1;
          $data['object']['3g'][0]['images'] = 'public/images/3g.png';
        }
      }

    $count_all = $this->catalog_model->getCommentsCount($data['object']['id']);
    $data['comments_count'] = $count_all. ' ' . parent::pluralForm($count_all, 'отзыв', "отзыва", "отзывов");  
     
     $data['colors'] = $this->catalog_model->get_color_products($data['id']);

     $data['warranty'] = $this->catalog_model->get_product_warranty();

     //echo $this->load->view('ajax/ownbox/own_product_page', array('SITE_CONTENT' => $data), true);
     echo $this->load->view('ajax/ownbox/own_product_page_new', array('SITE_CONTENT' => $data), true);
     echo $data['image'];
    }

   } break;

   default: {
    return false;
   } break;

  }

 }

 #validate region
 private function feedbackValidate() {

  if (!isset($_POST['robot']) || !empty($_POST['robot'])) return array('error' => '!');
  if (!isset($_POST['link']) || empty($_POST['link'])) return array('error' => '!');

  $this->load->library('form_validation');

  $this->form_validation->set_rules('name', 'name', 'required|max_length[255]|xss_clean');
  $this->form_validation->set_rules('email', 'email', 'required|valid_email|max_length[255]|xss_clean');
  $this->form_validation->set_rules('text', 'text', 'required|max_length[2000]|xss_clean');
  $this->form_validation->set_rules('link', 'link', 'xss_clean');

  if ($this->form_validation->run() == true) {
   $data_array = array(
    'name' => $this->input->post('name'),
    'email' => $this->input->post('email'),
    'phone' => '',
    'theme' => '',
    'text' => $this->input->post('text'),
    'date' => date('Y-m-d H:i:s'),
    'link' => preg_replace("/<[\/\!]*?[^<>]*?>/si", '', base64_decode($this->input->post('link'))),
    'check' => false
   );

   $this->load->model('form_model');
   $insert = $this->form_model->insert_feedback($data_array);

   if ($insert) {
    $this->load->library('send_lib');
    $this->send_lib->send_feedback($data_array);
   }

   $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'ap_fb_okey_message');

   return array('okey' => 'true');

  } else {

   $arr_valid = array(
    'name' => true,
    'email' => true,
    'text' => true
   );

   foreach ($arr_valid as $key => $one) {
    $err = form_error($key);
    if (empty($err)) unset($arr_valid[$key]);
   }

   $arr_valid['is_err'] = true;

   return $arr_valid;

  }

  return array('error' => '!');
 }
 private function comment_validate(){

  if (!isset($_POST['robot']) || !empty($_POST['robot'])) return array('error' => '!');
$this->load->library('form_validation');

// proverka id comments

    $id_comment = $this->input->post('id_comment');
    if(!isset($id_comment) && empty($id_comment) && $id_comment <= 0) $id_comment = 0;
    else $id_comment = $id_comment;

// end proverka

  $this->form_validation->set_rules('name', 'name', 'required|max_length[255]|xss_clean');
  $this->form_validation->set_rules('mark', 'mark', 'xss_clean|is_natural');
  $this->form_validation->set_rules('text', 'text', 'required|max_length[2000]|xss_clean');
  $this->form_validation->set_rules('product_id', 'product_id', 'required|callback_val_object|xss_clean');

  if ($this->form_validation->run() == true) {
   $data_array = array(
    'name' => $this->input->post('name'),
    'text' => $this->input->post('text'),
    'datetime' => date('Y-m-d H:i:s'),
    'mark' => $this->input->post('mark'),
    'parent_id' => $id_comment,
    'icon' => 0,
    'check' => false,
   'id_catalog' => $this->input->post('product_id'),
    'visible' => TRUE
   );

   $this->load->model('form_model');
   $insert = $this->form_model->insert_comment($data_array);
   
   $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'ap_fb_okey_message');

   return array('refresh' => 'true');

  } else {

   $arr_valid = array(
    'name' => true,    
    'text' => true
   );

   foreach ($arr_valid as $key => $one) {
    $err = form_error($key);
    if (empty($err)) unset($arr_valid[$key]);
   }

   $arr_valid['is_err'] = true;

   return $arr_valid;

  }

  return array('error' => '!');
 }

 private function feedphoneValidate() {

  if (!isset($_POST['robot']) || !empty($_POST['robot'])) return array('error' => '!');
  if (!isset($_POST['link']) || empty($_POST['link'])) return array('error' => '!');

  $this->load->library('form_validation');

  // $this->form_validation->set_rules('name', 'name', 'required|trim|max_length[255]|xss_clean');
  $this->form_validation->set_rules('phone', 'phone', 'required|trim|max_length[255]|xss_clean');
  // $this->form_validation->set_rules('text', 'text', 'required|trim|max_length[2000]|xss_clean');
  $this->form_validation->set_rules('link', 'link', 'trim|xss_clean');

  $this->form_validation->set_message('required', '!');
  $this->form_validation->set_message('max_length', '!');

  if ($this->form_validation->run() == true) {
   $data_array = array(
    'datetime' => date('Y-m-d H:i:s'),
    'name' => $this->input->post('name'),
    'phone' => $this->input->post('phone'),
    'text' => $this->input->post('text'),
    'link' => preg_replace("/<[\/\!]*?[^<>]*?>/si", '', base64_decode($this->input->post('link')))
   );

   $this->load->model('form_model');
   $insert = $this->form_model->insert_feedphone($data_array);

   if ($insert) {
    $this->load->library('send_lib');
    $this->send_lib->send_feedphone($data_array);

    $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'ap_cb_okey_message');

    return array('okey' => 'true');
   }

   return array();
  } else {

   $arr_valid = array(
    'name' => true,
    'phone' => true,
    'text' => true
   );

   foreach ($arr_valid as $key => $one) {
    $err = form_error($key);
    if (empty($err)) unset($arr_valid[$key]);
   }

   $arr_valid['is_err'] = true;

   return $arr_valid;

  }

  return array('error' => '!');

 }

 private function feedbackPhone() {

  if (!isset($_POST['robot']) || !empty($_POST['robot'])) return array('error' => '!');
  if (!isset($_POST['link']) || empty($_POST['link'])) return array('error' => '!');

  $this->load->library('form_validation');

  $this->form_validation->set_rules('phone', 'phone', 'required|trim|max_length[255]|xss_clean');
  $this->form_validation->set_rules('link', 'link', 'trim|xss_clean');

  $this->form_validation->set_message('required', '!');
  $this->form_validation->set_message('max_length', '!');

  if ($this->form_validation->run() == true) {
   $data_array = array(
    'datetime' => date('Y-m-d H:i:s'),
    'phone' => $this->input->post('phone'),
    'link' => preg_replace("/<[\/\!]*?[^<>]*?>/si", '', base64_decode($this->input->post('link')))
   );

   $this->load->model('form_model');
   $insert = $this->form_model->insert_feedphone($data_array);

   if ($insert) {
    $this->load->library('send_lib');
      // $this->send_lib->send_feedphone($data_array);okey

    $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'ap_cb_okey_message');

    return array('okey' => 'true');
   }

   return array();
  } else {

   $arr_valid = array(
    'phone' => true,
   );

   foreach ($arr_valid as $key => $one) {
    $err = form_error($key);
    if (empty($err)) unset($arr_valid[$key]);
   }

   $arr_valid['is_err'] = true;

   return $arr_valid;

  }

  return array('error' => '!');

 }

 public function buyback_validate() {

  if (!isset($_POST['robot']) || !empty($_POST['robot'])) return array('error' => '!');
$this->load->library('form_validation');  

  $this->form_validation->set_rules('link', 'link', 'is_numeric_no_zero|callback_val_object');
  $this->form_validation->set_rules('phone', 'phone', 'required|max_length[255]|xss_clean');

  $this->form_validation->set_message('required', '!');
  $this->form_validation->set_message('max_length', '!');

  if ($this->form_validation->run() == true) {
   $data_array = array(
    'product_id' => (int)$this->input->post('link'),
    'datetime' => date('Y-m-d H:i:s'),
    'phone' => $this->input->post('phone'),
    'ip' => ip2long($this->input->ip_address()),
    'check' => false
   );

   $this->load->model('form_model');
   $insert = $this->form_model->insert_buyback($data_array);

   if ($insert) {
    $this->load->library('send_lib');

    $this->load->model('catalog_model');
    $data_array['product'] = $this->catalog_model->getOne($data_array['product_id']);

    $this->send_lib->send_buyback($data_array);

    $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'ap_bb_okey_message');

    return array('okey' => 'true');
   }

   return array();
  } else {

   $arr_valid = array(
    'product' => true,
    'phone' => true
   );

   foreach ($arr_valid as $key => $one) {
    $err = form_error($key);
    if (empty($err)) unset($arr_valid[$key]);
   }

   $arr_valid['is_err'] = true;

   return $arr_valid;

  }

  return array('error' => '!');

 }

 public function review_validate() {

  if (!isset($_POST['robot']) || !empty($_POST['robot'])) return array('error' => '!');
  if (!isset($_POST['link']) || empty($_POST['link'])) return array('error' => '!');

  $this->load->model('review_model');

  $_ip = $this->input->ip_address();
  if ($this->review_model->ip_frequency($_ip, $this->input->post('object')) > 5) {
   $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'op_review_form_err_ip');

   return array('okey' => 'true');
  }

  $this->load->library('form_validation');

  $this->form_validation->set_rules('object', 'object', 'required|is_numeric_no_zero|callback_val_object');
  $this->form_validation->set_rules('name', 'name', 'required|max_length[255]|xss_clean');
  $this->form_validation->set_rules('email', 'email', 'required|valid_email|max_length[255]|xss_clean');
  $this->form_validation->set_rules('text', 'text', 'required|max_length[5000]|xss_clean');
  $this->form_validation->set_rules('link', 'link', 'xss_clean');

  $this->form_validation->set_message('required', '!');
  $this->form_validation->set_message('max_length', '!');
  $this->form_validation->set_message('valid_email', '!');

  if ($this->form_validation->run() == true) {
   $data_array = array(
    'userid' => (int)$this->session->userdata('user_id'),
    'objectid' => (int)$this->input->post('object'),
    'datetime' => date('Y-m-d H:i:s'),
    'name' => $this->input->post('name'),
    'email' => $this->input->post('email'),
    'text' => $this->input->post('text'),
    'link' => preg_replace("/<[\/\!]*?[^<>]*?>/si", '', base64_decode($this->input->post('link'))),
    'ip' => ip2long($_ip),
    'check' => false
   );

   $this->load->model('form_model');
   $insert = $this->form_model->insert_review($data_array);

   if ($insert) {
    // $this->load->library('send_lib');
    // $this->send_lib->send_feedphone($data_array);

    $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'op_review_form_okey');

    return array('okey' => 'true');
   }

   return array();
  } else {

   $arr_valid = array(
    'name' => true,
    'email' => true,
    'text' => true
   );

   foreach ($arr_valid as $key => $one) {
    $err = form_error($key);
    if (empty($err)) unset($arr_valid[$key]);
   }

   $arr_valid['is_err'] = true;

   return $arr_valid;

  }

  return array('error' => '!');

 }

 #validate callback

 public function val_object($value = 0) {   
  $value = (int)$value;
  $this->load->model('catalog_model');
  return (bool)$this->catalog_model->isByID($value);
 }

 #this is the end... */

 # end validate region

 public function subscriber() {

  $data = array();

  $email = $this->input->post('email');
  if ((bool)$this->input->post('on') === false && empty($email) && (int)$this->session->userdata('user_id') > 0) {
   $email = $_POST['email'] = $this->session->userdata('email');
  }

  if (empty($email)) {

   $data['class'] = 'error';
   $data['message'] = $this->lang->line('f_subs_form_email_error_title');

  } else if (
    (int)$this->session->userdata('user_id') > 0 &&
    $this->session->userdata('email') &&
    $this->session->userdata('email') !== $this->input->post('email')
   ) {

   $data['class'] = 'error';
   $data['message'] = $this->lang->line('f_subs_form_email_user_error_title');

   $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'f_subs_form_email_user_error_title');

   $data['okey'] = 'true';

  } else {

   $this->load->library('form_validation');

   $this->form_validation->set_rules('email', 'email', 'required|valid_email|max_length[255]|xss_clean');
   $this->form_validation->set_rules('on', 'on', 'is_natural|xss_clean');

   if ($this->form_validation->run() == true) {

    $ins_array = array(
     'email' => $this->input->post('email'),
     'user_id' => (int)$this->session->userdata('user_id')
     );

    $_on = (bool)$this->input->post('on');

    $this->load->model('subscribe_model');
    if ($this->session->userdata('user_id') > 0) $_one = $this->subscribe_model->get_one_by_user($this->session->userdata('user_id'));
    else $_one = $this->subscribe_model->get_one($ins_array['email']);

    #SUBSCRIBE ON
    if ($_on) {

     if (!empty($_one)) {

      if ($this->session->userdata('user_id') > 0) {

       $data['class'] = 'alredy';
       $data['message'] = sprintf($this->lang->line('f_subs_form_email_already_user_title'), $_one['email']);

      } else {

       $data['class'] = 'alredy';
       $data['message'] = $this->lang->line('f_subs_form_email_already_title');

      }

     } else {

      $this->subscribe_model->insert($ins_array);

      $this->load->model('user_model');
      if ($this->session->userdata('user_id') > 0) {

       if (!$this->user_model->has_email($this->session->userdata('user_id'))) $this->user_model->set_email($this->session->userdata('user_id'), $this->input->post('email'));

       $this->user_model->user_set_subscribe($this->session->userdata('user_id'), true);

      }

      $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'f_subs_form_okey_msg');

      $data['okey'] = 'true';

     }

    }
    #SUBSCRIBE OFF
    else {

     if (!$this->ion_auth->logged_in()) {

      $data['class'] = 'error';
      $data['message'] = $this->lang->line('f_unsubs_form_error_msg');

     } else {

      if (isset($_one['id']) && isset($_one['user_id']) && $ins_array['user_id'] == $_one['user_id']) {

       $this->subscribe_model->remove($_one['id']);

       $this->load->model('user_model');
       $this->user_model->user_set_subscribe($this->session->userdata('user_id'), false);

       $this->session->set_userdata($this->config->item('own_box_okey_msg'), 'f_unsubs_form_okey_msg');

       $data['okey'] = 'true';

      } else {

       $data['class'] = 'error';
       $data['message'] = $this->lang->line('site_default_form_error_msg');

      }

     }

    }

    if (strpos($this->input->server('HTTP_REFERER'), $this->config->item('auth_user_page_link')) !== false) {
     $data['view'] = $this->load->view('auth/inside/user_subscribe_view', null, true);
    }

   } else {

     $data['class'] = 'error';
     $data['message'] = $this->lang->line('f_subs_form_email_error_title');

   }

  }

  return $data;
 }

 public function comments($page, $id){
      if(!isset($page) && empty($page) && $page <= 0) return false;

    $this->load->model('catalog_model');
    return $data = $this->catalog_model->AjaxGetNextComments($page, $id);
 }

}