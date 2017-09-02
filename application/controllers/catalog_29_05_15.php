<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'main.php';

class Catalog extends Main {
 public function __construct() {
  parent::__construct();
 }

 public function index($categorylink = 'all', $parametter = '') {
   
  $parametter = urldecode($parametter);

  $this->load->model('menu_model');
  #if (empty($categorylink)) $categorylink = $this->menu_model->getFirstCatLink();
  $categoryid = (int)$this->menu_model->isLink($categorylink);
  if (/*$categorylink !== 'all' &&*/ $categoryid <= 0) site_404_url();

  /*if ($categorylink == 'all') $child = array();
  else*/ $child = $this->menu_model->haveChildren($categoryid);

  /*if ($child && !empty($parametter))
   site_404_url();
  elseif ($child && $categoryid > 0) $this->action_catcatalog($categoryid);
  else*/ $this->action_catalog($categoryid, $categorylink, $parametter);
 }

 public function action_catcatalog($categoryid = 0) {
  $this->load->model('menu_model');

  if (!$this->menu_model->is($categoryid)) site_404_url();

  $all_categories = $this->menu_model->getChildren($categoryid);

  $cats = array_unique($this->menu_model->formedCategoryIdis($categoryid));

  $this->data = array();
  $this->data['__LINK'] = 'category';

  $this->data['__GEN'] = array(
   'cat_id' => $categoryid,
   'all_cats_id' => $cats
  );

  parent::generateInData($this->data['__GEN'],
                         'catalog/catalog_category_view',
                         $this->data['__LINK']);


  $content = array();

  $content['categoryname'] = $this->menu_model->getName($categoryid);
  $content['seotext'] = $this->menu_model->getText($categoryid);
  $content['category'] = $all_categories;

  $this->load->model('article_model');
  $content['articles'] = $this->article_model->get($categoryid, 1, 3);

  $this->data['SITE_CONTENT'] = $content;

  $this->display_lib->catalog($this->data, $this->view);
 }

 public function action_catalog($categoryid = 0, $categorylink = 'all', $parametter = '') {

  #if ($categorylink == 'all') $categoryid = 0;

  #AJAX region
  if (
     $this->input->post('ajax') == 'true' &&
     strtolower($this->input->server('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest'
    ) {

   $temp_data = array();

   $this->lang->load(SITELANG, SITELANG);

   $parametter = urldecode($parametter);
   $this->load->model('menu_model');

   $categoryid = (int)$categoryid;
   if ($categoryid !== 0 && !$this->menu_model->is($categoryid)) site_404_url();

   if ($categoryid === 0 && empty($categorylink)) $categorylink = 'all';

   $cat_idis = array_unique($this->menu_model->formedCategoryIdis($categoryid));

   $this->load->library('filter_lib');

   $parametterArray = $this->filter_lib->parse($parametter);
   if ($parametterArray === false) $parametterArray = array();

   if (!empty($parametter) && (empty($parametterArray) || $parametterArray === false)) site_404_url();

   $parametterArray = $this->filter_lib->prepare($parametterArray);

   $pagination = array();
   $pagination['COUNTONPAGE'] = 12;

   $_list = false;
   if (isset($parametterArray['view'][0]) && $parametterArray['view'][0] == 'list') {
    $pagination['COUNTONPAGE'] = 6;
    $_list = true;
   }

   $pagination['COUNTALL'] = $this->filter_lib->get_object_count($cat_idis, $parametterArray);

   $pagination['THISPAGE'] = $this->filter_lib->get_parametter($parametterArray, 'page', 1);
   $pagination['COUNTPAGE'] = ceil($pagination['COUNTALL']/$pagination['COUNTONPAGE']);

   if ($pagination['COUNTPAGE'] > 0 && isset($parametterArray['page'][0]) && $parametterArray['page'][0] > $pagination['COUNTPAGE']) site_404_url();

   $pagination['COUNT_TO_THIS_PAGE'] = ceil($pagination['COUNTONPAGE'] * $pagination['THISPAGE']);

   $temp_data['product_now_count'] = 0;
   if ($pagination['COUNTPAGE'] <= $pagination['THISPAGE']) $temp_data['product_now_count'] = $pagination['COUNTALL'];
   else $temp_data['product_now_count'] = $pagination['COUNT_TO_THIS_PAGE'];

   $temp_data['page_next_true'] = false;
   if ($pagination['COUNT_TO_THIS_PAGE'] < $pagination['COUNTALL']) $temp_data['page_next_true'] = true;

   $temp_data['page_next_link'] = rtrim($this->filter_lib->change($parametterArray, array('key' => 'page', 'link' => ($pagination['THISPAGE'] + 1) ) ), '/');

   $temp_data['page_current'] = (int)$pagination['THISPAGE'];

   $temp_catalog = $this->filter_lib->get_objects($cat_idis, $parametterArray, $pagination['COUNTONPAGE']);

   $_move_cart_idis = array();
   $temp_cart = $this->cart->contents();
   if (!empty($temp_cart)) {
    foreach ($temp_cart as $one_cart) {
     if (isset($one_cart['id'])) array_push($_move_cart_idis, $one_cart['id']);
    }
   }

   $temp_data['view'] = $this->load->view('inside/catalog/catalog_item_view', array('catalog' => $temp_catalog, '_move_cart_idis' => $_move_cart_idis, '_list' => $_list), true);

   if (empty($temp_data)) echo false;
   else echo json_encode($temp_data);

   die();

  }
  #end AJAX region

  $this->data = array();

  $parametter = urldecode($parametter);
  $this->load->model('menu_model');

  $categoryid = (int)$categoryid;
  if ($categoryid !== 0 && !$this->menu_model->is($categoryid)) site_404_url();

  if ($categoryid === 0 && empty($categorylink)) $categorylink = 'all';

  $cat_idis = array_unique($this->menu_model->formedCategoryIdis($categoryid));

  #if (empty($cat_idis)) site_404_url();

  $this->load->library('filter_lib');

  $parametterArray = $this->filter_lib->parse($parametter);
  if ($parametterArray === false) $parametterArray = array();

  if (!empty($parametter) && (empty($parametterArray) || $parametterArray === false)) site_404_url();

  $parametterArray = $this->filter_lib->prepare($parametterArray);

  $pagination = array();
  $pagination['COUNTONPAGE'] = 12;
  if (isset($parametterArray['view'][0]) && $parametterArray['view'][0] == 'list') $pagination['COUNTONPAGE'] = 6;

  $pagination['COUNTALL'] = $this->filter_lib->get_object_count($cat_idis, $parametterArray);

  $pagination['THISPAGE'] = $this->filter_lib->get_parametter($parametterArray, 'page', 1);
  $pagination['COUNTPAGE'] = ceil($pagination['COUNTALL']/$pagination['COUNTONPAGE']);

  if ($pagination['COUNTPAGE'] > 0 && isset($parametterArray['page'][0]) && $parametterArray['page'][0] > $pagination['COUNTPAGE']) site_404_url();

  if ($pagination['COUNTALL'] < $pagination['COUNTONPAGE']) $pagination['COUNTSHOWNOW'] = $pagination['COUNTALL'];
  else $pagination['COUNTSHOWNOW'] = $pagination['COUNTONPAGE'] * $pagination['THISPAGE'];

  $pagination['COUNTSHOWPAGE'] = 4;
  if ($pagination['THISPAGE'] == 1 || $pagination['THISPAGE'] == $pagination['COUNTPAGE']) $pagination['COUNTSHOWPAGE'] = 10;
  if ($pagination['COUNTPAGE'] <= 10) $pagination['COUNTSHOWPAGE'] = 10;

  $pagination['COUNT_TO_THIS_PAGE'] = ceil($pagination['COUNTONPAGE'] * $pagination['THISPAGE']);

  $pagination['PAGE_NEXT_LINK'] = rtrim($this->filter_lib->change($parametterArray, array('key' => 'page', 'link' => ($pagination['THISPAGE'] + 1) ) ), '/');

  $page_array = array();
  if ($pagination['COUNTPAGE'] > 1) {
   #first page
   /*
   $temp = array();
   $temp['name'] = 1;
   $temp['linker'] = $this->filter_lib->change($parametterArray, array('key' => 'page', 'link' => 1));
   if ($pagination['THISPAGE'] == 1) {
    $temp['selected'] = true;
   }
   $page_array[] = $temp;

   #first ...
   if ($pagination['THISPAGE'] - $pagination['COUNTSHOWPAGE'] >= 3) {
    $temp = array();
    $temp['ellipsis'] = true;
    $page_array[] = $temp;
   }
   */
   #center pages
   $start_ = $pagination['THISPAGE'] - $pagination['COUNTSHOWPAGE'];
   if ($start_ < 1) $start_ = 1;

   $finish_ = $pagination['THISPAGE'] + $pagination['COUNTSHOWPAGE'];
   if ($finish_ > $pagination['COUNTPAGE']) $finish_ = $pagination['COUNTPAGE'];

   for ($i = $start_; $i <= $finish_; ++$i) {
    $temp = array();
    $temp['name'] = $i;
    $temp['linker'] = $this->filter_lib->change($parametterArray, array('key' => 'page', 'link' => $i));
    if ($pagination['THISPAGE'] == $i) $temp['selected'] = true;
    $page_array[] = $temp;
   }
   /*
   #last ...
   if ($pagination['THISPAGE'] + $pagination['COUNTSHOWPAGE'] <= $pagination['COUNTPAGE'] - 2) {
    $temp = array();
    $temp['ellipsis'] = true;
    $page_array[] = $temp;
   }

   #last page
   $temp = array();
   $temp['name'] = $pagination['COUNTPAGE'];
   $temp['linker'] = $this->filter_lib->change($parametterArray, array('key' => 'page', 'link' => $pagination['COUNTPAGE']));
   if ($pagination['THISPAGE'] == $pagination['COUNTPAGE']) {
    $temp['selected'] = true;
   }
   $page_array[] = $temp;
   */
   $pagination['prev_page'] = $this->filter_lib->change($parametterArray, array('key' => 'page', 'link' => ($pagination['THISPAGE'] - 1)));
   $pagination['next_page'] = $this->filter_lib->change($parametterArray, array('key' => 'page', 'link' => ($pagination['THISPAGE'] + 1)));

   $pagination['first_page'] = $this->filter_lib->change($parametterArray, array('key' => 'page', 'link' => 1));
   $pagination['last_page'] = $this->filter_lib->change($parametterArray, array('key' => 'page', 'link' => $pagination['COUNTPAGE']));

  }
  $pagination['PAGES'] = $page_array;

  $this->data['__LINK'] = 'catalog';

  $this->data['__GEN'] = array(
   'cat_id' => $categoryid,
   'cat_idis' => $cat_idis,
   'all_cats_id' => $cat_idis,
   'parametter_array' => $parametterArray
  );

  parent::generateInData($this->data['__GEN'],
                         'catalog/catalog_catalog_view',
                         $this->data['__LINK']);

  #page parametter
  $this->data['PAGE'] = $this->page;
  $this->data['CATEGORYID'] = $categoryid;
  $this->data['CATEGORYLINK'] = $categorylink;
  $this->data['CATEGORY_IDIS'] = $cat_idis;
  $this->data['CATEGORY_PAR'] = $this->menu_model->getParentFirst($categoryid);
  $this->data['CANONICAL'] = $this->filter_lib->canonical($parametterArray);
  $this->data['PARAMETTER_STRING'] = $parametter;
  $this->data['PLUS'] = '';
  #if (!empty($this->data['PARAMETTER_STRING'])) $this->data['PLUS'] = '+';

  $this->data['PAGINATION'] = $pagination;
  #end
  $content = array();

  $content['categoryname'] = $this->menu_model->getName($categoryid);
  $content['seotext'] = $this->menu_model->getText($categoryid);
  $content['cattext'] = $this->menu_model->getText2($categoryid);

  $content['catalogcount'] = $pagination['COUNTALL']; #$this->filter_lib->get_object_count($cat_idis); #$this->menu_model->getCategoryCatalogCount($categoryid);

  $this->load->model('catalog_model');
  #$content['sorting'] = $this->catalog_model->getCatalogSortLF(false, $parametterArray);
  #$content['sorting_price'] = $this->catalog_model->getCatalogSortPriceLF(false, $parametterArray);
  #$content['view'] = $this->catalog_model->getCatalogViewLF(false, $parametterArray);

  if ($pagination['COUNTALL'] > 0) 
      $content['catalog'] = $this->filter_lib->get_objects($cat_idis, $parametterArray, $pagination['COUNTONPAGE']);
  else $content['catalog'] = array();
  foreach($content['catalog'] as &$one){
      $one['comm_count'] = $one['comm_count'] . ' ' . parent::pluralForm($one['comm_count'], "отзыв", "отзыва", "отзывов");
  }
  $content['FILTER'] = $parametterArray;  
  $this->data['SITE_CONTENT'] = $content;

  $this->display_lib->catalog($this->data, $this->view);
 }

 public function action_search($page = 1) {
  if (!isset($_GET['search']) || empty($_GET['search'])) site_404_url();

  $this->session->set_userdata('main_search', urldecode($this->input->get('search')));

  #$search = array(addslashes(substr($this->session->userdata('main_search'), 0, 100)));
  $search[0] = $this->base_model->prepareDataString(mb_substr($this->session->userdata('main_search'), 0, 100));

  if (!is_array($search) || empty($search)) site_404_url();

  $this->load->model('catalog_model');

  if ($page <= 0) site_404_url();

  $pagination = array();
  $pagination['COUNTONPAGE'] = 12;
  $pagination['COUNTALL'] = $this->catalog_model->getCatalogObjectCountSearch($search);
  $pagination['THISPAGE'] = $page;
  $pagination['COUNTPAGE'] = ceil($pagination['COUNTALL']/$pagination['COUNTONPAGE']);

  if ($pagination['COUNTPAGE'] > 0 && $page > $pagination['COUNTPAGE']) site_404_url();

  $pagination['COUNTSHOWPAGE'] = 6;
  if ($pagination['THISPAGE'] == 1 || $pagination['THISPAGE'] == $pagination['COUNTPAGE']) $pagination['COUNTSHOWPAGE'] = 10;
  if ($pagination['COUNTPAGE'] <= 10) $pagination['COUNTSHOWPAGE'] = 10;

  $link = 'search';

  $this->data = array();
  $this->data['__LINK'] = 'search';
  $this->data['OTHER'] = true;

  $this->data['__GEN'] = array(
   'page_link' => $this->data['__LINK'],
   'page_other' => $this->data['OTHER']
  );

  parent::generateInData(
                         $this->data['__GEN'],
                         'catalog/catalog_search_view',
                         'otherpage'
                        );

  #page parametter
  $this->data['PAGE'] = $this->page;

  $this->data['PAGINATION'] = $pagination;
  #end

  $content = array();

  $this->load->model('page_model');
  $content['categoryname'] = $this->page_model->getPageName($this->data['__LINK'], $this->data['OTHER']);
  $content['PAGENAME'] = $content['categoryname'];

  $content['catalog'] = $this->catalog_model->getCatalogObjectSearch($search, $pagination['THISPAGE'], $pagination['COUNTONPAGE']);

  $this->data['SITE_CONTENT'] = $content;

  $this->display_lib->catalog($this->data, $this->view);
 }

}
