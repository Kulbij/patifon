<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {
 #variable for data of page
 protected $data;
 #var for set path and name of page view WITHOUT 'pages/'
 protected $view;
 #page identificator
 protected $page;

 public function __construct() {
  parent::__construct();

  $this->lang->load(SITELANG, SITELANG);

  $this->data = array();

  #declare
  $this->data['__GEN'] = array();
  $this->data['__LINK'] = '';
  $this->data['__PAGE'] = '';
  $this->data['__VIEW'] = '';
  #this is the end... */

  $this->view = '';
  $this->page = '';
 }

 public function index() {
  $this->data = array();
  $this->data['__GEN'] = array(

  );
  $this->generateInData(
   $this->data['__GEN'],
   'index/index_view',
   'index'
  );

  $content = array();

  #$content['seotext'] = $this->page_model->getIndexPageText();

  $this->load->model('index_model');
  $content['banners'] = $this->index_model->get_banners();

  $this->load->model('article_model');
  $content['last_articles'] = $this->article_model->get();

  $this->load->model('catalog_model');
  $content['catalog'] = $this->catalog_model->getPopular(array(), 8);
  foreach($content['catalog'] as &$one){
      $one['comm_count'] = $one['comm_count'] . ' ' . $this->pluralForm($one['comm_count'], 'отзыв', "отзыва", "отзывов");
      $one['mark'] = $this->catalog_model->getObjectAvgMark($one['id']);
  }
  


  $this->data['SITE_CONTENT'] = $content;

  $this->display_lib->index($this->data, $this->view);
 }

 #generate functions
 #set standart class variables to start state
 protected function generateInData($data = array(), $view = '', $page = '') {
  $this->view = $view;
  $this->page = $page;

  if (!empty($data)) $this->data = array_merge($this->data, $data);

  $this->data = array_merge($this->data, $this->generate());

  $this->data['__PAGE'] = $this->page;
  $this->data['__VIEW'] = $this->view;
  if (!isset($this->data['__GEN'])) $this->data['__GEN'] = array();
  if (!isset($this->data['__LINK'])) $this->data['__LINK'] = '';

 }

 #set information to data for general views
 protected function generate() {
  $return = array();
  $return['SITE_HEADER'] = $this->generateHeader();
  $return['SITE_TOP'] = $this->generateTop();
  $return['SITE_BREAD'] = $this->generateBreadscrumbs();
  $return['SITE_LEFTPANEL'] = $this->generateLeftPanel();
  $return['SITE_FOOTER'] = $this->generateFooter();
  return $return;
 }

 #to SITE_HEADER
 protected function generateHeader() {
  $return = array();
  $lang_title = $this->lang->line('site_name');

  $this->load->library('formed_lib');
  $tkd = $this->formed_lib->getTKD($this->page, $this->data['__GEN']);

  $return['title'] = ((isset($tkd['title']) && !empty($tkd['title'])) ? $tkd['title'] : $lang_title);
  $return['meta_tkd'] = array(
   array('name' => 'title', 'content' => ((isset($tkd['title']) && !empty($tkd['title'])) ? $tkd['title'] : $return['title']) ),
   array('name' => 'keywords', 'content' => ((isset($tkd['keyword']) && !empty($tkd['keyword'])) ? $tkd['keyword'] : $return['title']) ),
   array('name' => 'description', 'content' => ((isset($tkd['description']) && !empty($tkd['description'])) ? $tkd['description'] : $return['title']) )
  );

  $return['style'] = array(
   array(
    'href' => 'public/style/clear.css',
    'rel' => 'stylesheet',
    'type' => 'text/css'
   )
  );

  if (isset($this->page) && $this->page == '404') {

   $return['style'][] = array(
    'href' => 'public/style/error.css',
    'rel' => 'stylesheet',
    'type' => 'text/css'
   );

  } else {

   $return['style'][] = array(
    'href' => 'public/style/main.css',
    'rel' => 'stylesheet',
    'type' => 'text/css'
   );

  }

  return $return;
 }

 #to SITE_TOP
 protected function generateTop() {
  $return = array();

  $return['cart'] = $this->getTopCartData();
  
  #prepare cart id's
  /*
  $return['CART_IDS'] = array();
  $temp_cart = $this->cart->contents();
  if (!empty($temp_cart)) {
   foreach ($temp_cart as $one_cart) {
    if (isset($one_cart['id'])) array_push($return['CART_IDS'], $one_cart['id']);
   }
  }
  #end */

  $this->load->model('page_model');
  $return['toppage'] = $this->page_model->getPageShortData('top');
  #$return['address'] = $this->page_model->getPageText2('contact');
  #$return['schedule'] = $this->page_model->getSchedule();

  $this->load->model('menu_model');
  $return['menu'] = $this->menu_model->generateTopMenu();

  $this->load->model('phone_model');
  $return['phones'] = $this->phone_model->get(null, true);

  if ($this->page == 'object' && isset($this->data['__GEN']['obj_id'])) {

   #LAST CATALOG
   // $last_array = $this->session->userdata('last_catalog');
   // if (!$last_array) {
   //  $last_array = unserialize($this->input->cookie($this->config->item('cookie_var')));
   //  if (!$last_array) $last_array = array();
   //  else {
   //   $temp = array();
   //   foreach ($last_array as $one) {
   //    $temp[] = (int)$one;
   //   }
   //   $last_array = $temp;
   //  }
   // }
   // $last_array = array_unique($last_array);
   // if (count($last_array) >= $this->config->item('last_catalog_max_elems')) array_shift($last_array);
   // $last_array[] = (int)$this->data['__GEN']['obj_id'];
   // $this->session->set_userdata('last_catalog', $last_array);
   // setcookie($this->config->item('cookie_var'), serialize($last_array), time()+3600*24*30, '/', $this->config->item('cookie_dom'));
   #end LAST CATALOG */

  } else if ($this->page == 'catalog' && isset($this->data['__GEN']['cat_id'])) {


   #$this->load->model('catalog_model');
   #$return['last_catalog'] = $this->catalog_model->getByIDS($this->session->userdata('last_catalog'));


  }

  return $return;
 }

 #to SITE_LEFTPANEL
 protected function generateLeftPanel() {
  $return = array();

  if ($this->page == 'catalog' || $this->page == 'object') {
   if (!isset($this->data['__GEN']['cat_idis'])) $this->data['__GEN']['cat_idis'] = array();

   $this->load->library('filter_lib');
   if (!isset($this->data['__GEN']['parametter_array']))
    $this->data['__GEN']['parametter_array'] = array();

   $return['FILTERS'] = $this->filter_lib->get($this->data['__GEN'], $this->data['__GEN']['parametter_array']);
   $return['SORT'] = $this->filter_lib->get_one('sort', $this->data['__GEN']['parametter_array']);
   $return['VIEW'] = $this->filter_lib->get_one('view', $this->data['__GEN']['parametter_array']);

   $return['PRICES'] = $this->filter_lib->get_prices($this->data['__GEN']);
   $return['SLIDES_LINKER'] = $this->filter_lib->get_links($this->data['__GEN']['parametter_array']);

   $return['RESET_BUTTON'] = false;
   if (isset($this->data['__GEN']['parametter_array']['reset_button']) &&
       $this->data['__GEN']['parametter_array']['reset_button']
      ) {
    $return['RESET_BUTTON'] = $this->filter_lib->reset_button($this->data['__GEN']['parametter_array']);
   }
  }

  return $return;
 }

 #to SITE_FOOTER
 protected function generateFooter($array = array()) {
  $return = array();

  $this->load->model('footer_model');
  $return['footerdata'] = $this->footer_model->getFooter();

  return $return;
 }

 #to SITE_BREAD
 protected function generateBreadscrumbs() {
  $return = array();

  $this->load->library('bread_lib');
  $return = $this->bread_lib->getBread($this->page, $this->data['__GEN']);

  return $return;
 }
 #end generate functions

 #other DATA function
 protected function getTopCartData() {
  #cart region
  $this->cart->updateTotalPrice();
  #end cart region

  $array = array();
  $array['catalogtotalsum'] = $this->input->price_format($this->cart->total(), $this->config->item('nf_decimals'), $this->config->item('nf_dec_point'), $this->config->item('nf_thousands_sep'));
//  echo '<pre>';
//  print_r($array);
//  die();

  $array['catalogcount'] = $this->cart->total_items();
  $array['catalogform'] = $this->pluralForm($this->cart->total_items());

  if ((int)$this->session->userdata('user_id') > 0 && !$this->session->userdata('user_share_50') && $this->cart->total() >= (int)$this->config->item('auth_user_discount_min_limit')) {
   $array['discount'] = true;
  }

  return $array;
 }
 #end otjer DATA function

 #404 page
 public function show404() {
  $this->output->set_status_header('404');

  $this->data['__GEN'] = array();

  $this->generateInData($this->data['__GEN'], 'general/404_view', '404');

  #CONTENT
  $content = array();



  $this->data['SITE_CONTENT'] = $content;
  #this is the end... */

  $this->display_lib->page_404($this->data, $this->view);
 }

 protected function pluralForm($n, $form1 = 'товар', $form2 = 'товара', $form5 = 'товарів') {
  /*
  $this->lang->load(SITELANG, SITELANG);
  $form1 = $this->lang->line('pf_form1');
  $form2 = $this->lang->line('pf_form2');
  $form5 = $this->lang->line('pf_form5');*/

  return $n % 10 == 1 && $n % 100 != 11 ? $form1 : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $form2 : $form5);
 }

 public function watermark($objid = null, $image = null) {
  if (!is_null($objid) && !is_null($image) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/objectimg/' . $objid . '/' . $image)) {

      $sizer = getimagesize($_SERVER['DOCUMENT_ROOT'] . '/images/objectimg/' . $objid . '/' . $image);

      if ($sizer[0] > 300 && $sizer[1] > 200) {

          $logo = 'watermark.png';

          if ($sizer[0] < 500 && $sizer[1] < 400)
              $logo = 'watermark.png';

          $this->load->library('image_lib');
          $config = array();
          $config['source_image'] = $_SERVER['DOCUMENT_ROOT'] . '/images/objectimg/' . $objid . '/' . $image;
          $config['wm_type'] = 'overlay';
          $config['wm_overlay_path'] = $_SERVER['DOCUMENT_ROOT'] . '/public/images/' . $logo;
          $config['wm_opacity'] = '50';
          $config['wm_vrt_alignment'] = 'bottom';
          $config['wm_hor_alignment'] = 'right';
          $config['wm_padding'] = '-15';
          $config['dynamic_output'] = TRUE;
          $this->image_lib->initialize($config);
          $this->image_lib->watermark();
          $this->image_lib->clear();
      } else {

          $this->load->library('image_lib');
          $config = array();
          $config['source_image'] = $_SERVER['DOCUMENT_ROOT'] . '/images/objectimg/' . $objid . '/' . $image;
          $config['wm_type'] = 'overlay';
          $config['wm_opacity'] = '100';
          $config['wm_vrt_alignment'] = 'bottom';
          $config['wm_hor_alignment'] = 'right';
          $config['dynamic_output'] = TRUE;
          $this->image_lib->initialize($config);
          $this->image_lib->watermark();
          $this->image_lib->clear();
      }

      //echo base_url().'images/objectimg/'.$objid.'/'.$image;

  } else {

      $this->load->library('image_lib');
      $config = array();
      $config['source_image'] = $_SERVER['DOCUMENT_ROOT'] . '/public/images/no-photo.jpg';
      $config['wm_type'] = 'overlay';
      $config['wm_opacity'] = '100';
      $config['wm_vrt_alignment'] = 'bottom';
      $config['wm_hor_alignment'] = 'right';
      $config['dynamic_output'] = TRUE;
      $this->image_lib->initialize($config);
      $this->image_lib->watermark();
      $this->image_lib->clear();

  }
 }

}