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
   $this->data['categorylink'] = $categorylink; 
  #if (empty($categorylink)) $categorylink = $this->menu_model->getFirstCatLink();
  $categoryid = (int)$this->menu_model->isParentLink($categorylink);
  if (/*$categorylink !== 'all' &&*/ $categoryid <= 0) site_404_url();

  /*if ($categorylink == 'all') $child = array();
  else*/ 
//$child = $this->menu_model->haveChildren($categoryid);

  /*if ($child && !empty($parametter))
   site_404_url();
  elseif ($child && $categoryid > 0) $this->action_catcatalog($categoryid);
  else*/ $this->action_catalog($categoryid, $categorylink, $parametter);
 }

 public function pidcatalog($categorylink = 'all', $parametter = '') {
  $parametter = urldecode($parametter);
  $this->load->model('menu_model');
   $this->data['categorylink'] = $categorylink; 
  $categoryid = (int)$this->menu_model->isParentLink($categorylink);

  //--select category
  $this->data = array();
  $this->data['__LINK'] = 'podcatalog';

  $this->data['__GEN'] = array(
   
   
  );


  parent::generateInData($this->data['__GEN'], 'catalog/catalog_podcatalog_view', $this->data['__LINK']);
  $content['selectcat'] = $this->menu_model->selectCategory($categorylink, $categoryid);
  $content['prevcat'] = $this->menu_model->selectprevcat($categoryid);
  $content['thiscat'] = $this->menu_model->selectthiscat($categoryid);
  $content['urlcat'] = $categorylink;
  $content['id'] = $categoryid;

  if(empty($content['selectcat'])) $this->index($categorylink, $parametter);

  if ($categoryid <= 0) site_404_url();
  $this->data['SITE_CONTENT'] = $content;
  $this->display_lib->podcatalog($this->data, $this->view);
 }

 public function sub_or_object($categorylink = 'all', $second = '', $parametter =''){

     $this->load->model('menu_model');

       $this->data['categorylink'] = $categorylink; 
       $categoryid = (int)$this->menu_model->isParentLink($categorylink);       
       if ($categoryid <= 0) site_404_url();
       $subcategoryid = (int) $this->menu_model->isSubLink($categorylink, $second);             
       if($subcategoryid <= 0){
           $this->load->model('catalog_model');
           $objid = (int)$this->catalog_model->checkObject($second);
           if($objid <= 0){
               site_404_url();
           }
           $this->action_object($second,'description', $parametter);
       }else{
           $this->action_catalog($subcategoryid, $second, $parametter);
       }
 }
 public function action_object($objectlink = '',$subpage = 'description', $page = 1){

     $this->load->model('catalog_model');

  $object_id = (int)$this->catalog_model->is($objectlink);
  if (!$object_id) site_404_url();
  $views = $this->catalog_model->get_product_view();


  $views_keys = array();
  foreach ($views as $one){
      array_push($views_keys, $one['link']);
  }    
  
  if (!in_array($subpage, $views_keys))
    site_404_url();

//echo 'ok';
//die();
  $this->load->model('menu_model');
  $category_id = $this->catalog_model->getCategoryID($object_id);
  $parent_cat_id = $this->menu_model->getParentFirst($category_id);

  $this->data = array();
  $this->data['__LINK'] = 'object';

  $this->data['__GEN'] = array(
   'obj_id' => $object_id,
   'obj_link' => $objectlink
  );


  parent::generateInData($this->data['__GEN'], 'object/object_view', $this->data['__LINK']);
  

  #page parametter
  $this->data['PAGE'] = $this->page;
  $this->data['THISPAGE'] = $page;
  $this->data['OBJECT_ID'] = $object_id;
  $this->data['OBJECT_LINK'] = $objectlink;
  $this->data['PAR_CAT_ID'] = $parent_cat_id;
  $this->data['OBJ_SUBPAGE'] = $subpage;
  $this->data['OBJ_SUBPAGE_DATA'] = $this->catalog_model->get_product_on_view($subpage);
  $_tmp = $this->menu_model->getObjectCategories($object_id);
    $this->data['PARENTCATEGORYLINK'] = $_tmp['parentcategorylink'];
  $this->data['CATEGORYLINK'] =$_tmp['categorylink'];
  #end

  $content = array();

  $content['object'] = $this->catalog_model->getOne($object_id);
  $content['object']['avg_mark'] = $this->catalog_model->getObjectAvgMark($object_id);
//  echo '<pre>';
//  print_r($content['object']);
//  die();

  $content['images'] = $this->catalog_model->getImages($object_id);

  $content['product_url'] = $this->catalog_model->getCategoryForProduct($object_id);

  $content['colors'] = $this->catalog_model->get_color_products($object_id);

  $content['similar'] = $this->catalog_model->getSimilar($object_id);

  $content['video'] = $this->catalog_model->getVideo($object_id);

  $content['category_url'] = $this->catalog_model->get_catalog_category($object_id);
 
  foreach($content['similar'] as &$one){
      $one['comm_count'] = $one['comm_count'] . ' ' . parent::pluralForm($one['comm_count'], 'отзыв', "отзыва", "отзывов");
  }
  $content['accesories'] = $this->catalog_model->getAccesories($object_id);
  /*
  foreach($content['accesories'] as &$one){
      $one['comm_count'] = $one['comm_count'] . ' ' . parent::pluralForm($one['comm_count'], 'отзыв', "отзыва", "отзывов");
  }
  */

  $content['views'] = $views;

  // -----------------------   count cokies -------------------------
    $cokies = explode(',', $this->input->cookie('compare'));
    foreach ($cokies as $key => $value) {
      $cokies_count[] = $value;
    }
    $content['object']['count_copy'] = count($cokies_count);
  // ------------------------------------------------------------------ end count cokies -------------

    // ------------------------------- delete views object ---------------------------------------------
      if(isset($content['views']) && !empty($content['views'])) {
        $id_object = 18;
        foreach($content['views'] as $key => $value){
          //----------------------------------- paket option ------------------------
          if($value['id'] == '7'){
            if($content['object']['product-visible'] == 1) $option = $this->catalog_model->getOptionObject($id_object);
            else $option = array();
            if(empty($option)) unset($content['views'][$key]);
          }
          // ---------------------  Photo -------------------
          if($value['id'] == '4'){
            //$config_photo = $this->catalog_model->selectThisPtoho($id_object);
            $config_photo = $content['images'];
            if(empty($config_photo)) unset($content['views'][$key]);
          }
          // ----------------------------video--------------------
          if($value['id'] == '5'){
            //$config_video = $this->catalog_model->get_video($id_object);
            $config_video = $content['object']['video'];
            if(empty($config_video)) unset($content['views'][$key]);
          }
          // ---------------------  Characteristics -------------------
          if($value['id'] == '2'){
            //$config_char = $this->catalog_model->selectThisChar($id_object);
            $config_char = $content['object']['features_text'];
            if(empty($config_char)) unset($content['views'][$key]);
          }
          //----------------------------Accsesuaries ----------------
          if($value['id'] == '6'){
            //$config_acc = $this->catalog_model->selectAcc($id_object);
            $config_acc = $content['accesories'];
            if(empty($config_acc)) unset($content['views'][$key]);
          }
          //---------------------------- Comments--------------------------
          if($value['id'] == '3'){
            $config_comments = $this->catalog_model->selectComments($id_object);
            if(empty($config_comments)) unset($content['views'][$key]);
          }
        } unset($value);
      }
    //---------------------------------- and delete views object ------------------------------

    // ------------- Parse array folyrs --------------------------------------
    $count_filter = count($content['object']['filters']);
    $i = 1;
    $name = [];
    foreach($content['object']['filters'] as $key => $value){
      if($count_filter == $i) $name[] = $value['parent_name'].' '.$value['name'];
      else $name[] = $value['parent_name'].' '.$value['name'].' / ';
      $i++;
    } unset($value);
    $content['all_info'] = $name;
    // --------- end ---------------------------------------------------

    $content['cat_option'] = $this->catalog_model->updatePaket('4', $object_id);
    $content['more_option'] = $this->catalog_model->updatePaket('5', $object_id);

  //$content['warranty'] = $this->catalog_model->get_product_warranty();
  //PAGINATION
    //$contentproduct_pages = array();
    if(empty($page)) $content['product_pages']['this_page']= 1;
    else $content['product_pages']['this_page'] = $page;
    $content['product_pages']['count_show_page'] = 3;
    $content['product_pages']['count_on_page'] = 12;
    $content['product_pages']['count_page'] = ceil($this->catalog_model->getCommentsCount($object_id)/$content['product_pages']['count_on_page']);
    $content['product_pages']['page_prev'] = ($content['product_pages']['this_page'] - 1);
    $content['product_pages']['page_next'] = ($content['product_pages']['this_page'] + 1);

    //END PAGINATION
  $content['comments'] = $this->catalog_model->getProductComments($object_id, $page, $content['product_pages']['count_on_page']);
  $content['comments_all'] = $this->catalog_model->getProductCommentsAll($object_id, $page, $content['product_pages']['count_on_page']);
  $content{'count_comments'} = ceil(count($content['comments_all']) / 12);
  if($content{'count_comments'} == 0) {
    $content{'count_comments'} = 1;
  }
  $content['night_comment'] = $this->catalog_model->getProductComments($object_id, $page, 9);

  $count_all = $this->catalog_model->getCommentsCount($object_id);
  
  $content['comments_count'] = $count_all. ' ' . parent::pluralForm($count_all, 'отзыв', "отзыва", "отзывов");  
  
  #$content['components'] = $this->catalog_model->comps_get($object_id);

  $this->load->model('index_model');
  
  // $content['product_info']['delivery'] = $this->index_model->getVar('delivery');
  $content['product_info']['payment'] = $this->index_model->getVar('payment');
  //$content['product_info']['packej'] = $this->index_model->getVar('packej');

  $content['indormer'] = $this->index_model->getInformerProduct();

  // ================================= create array for procesor and camera for filters products and display on site icon ==========

  foreach($content['object']['filters'] as $key => $value){
      if(isset($value['class']) && !empty($value['class']) && $value['class'] == 'icpc'){
        $procesor = explode('(', $value['name']);
        if(isset($procesor[0]) && !empty($procesor[0]))
          $procesor2 = explode(' ', $procesor[0]);
          if(isset($procesor2[0]) && !empty($procesor2[0]) && isset($procesor2[1]) && !empty($procesor2[1]))
            $content['object']['filters'][$key]['procesor_count'] = $procesor2[0];
            $content['object']['filters'][$key]['procesor_value'] = $procesor2[1];
      } elseif(isset($value['class']) && !empty($value['class']) && $value['class'] == 'iccam'){
        $camera = explode('+', $value['name']);
        if(isset($camera[1]) && !empty($camera[1])){
          if(isset($camera[0]) && !empty($camera[0]))
            $content['object']['filters'][$key]['camara_count'] = $camera[0];
        } else {
            $content['object']['filters'][$key]['camara_count'] = $value['name'];
        }
      }
    } unset($value);

    $content['object']['3G'] = $this->catalog_model->get3G($object_id);

    $str_3g = $content['object']['features_text'];
    $array_search = strripos($str_3g, '3G');

    if(isset($array_search) && !empty($array_search)){
      if($array_search >= 1){
        $content['object']['3g'][0]['id'] = 1;
        $content['object']['3g'][0]['images'] = 'public/images/3g.png';
      }
    }

    //============================================ end ================================================================

    //echo "<pre>"; print_r($content); die();рно 127 000 (0,30 сек.) 

    $content['more_text'] = (int)strlen($content['object']['text']);

    //============================================ end ================================================================

    // ======================== mobile version
      $this->load->library('user_agent');

      if($this->agent->is_mobile()) $content['mobile'] = 1;
      else $content['mobile'] = 0;
    // ============================= end mobile

//  $content['filter_object'] = $this->getFiltersTable($content['object']['features_text']);
    $content['filter_object'] = $content['object']['features_text'];
    //echo "<pre>"; print_r($content['filter_object']); die();
  
  $this->data['SITE_CONTENT'] = $content;
  
 
  $this->display_lib->object_new($this->data, $this->view);
 }
 private function getFiltersTable($table){
  if(!isset($table) && empty($table)) return false;

    
    $data['name'] = $this->parseTable($table, 185);
    $data['value'] = $this->parseTable($table, 435);

    foreach($data['name'] as $key => $value){
      //$data['filters_object'][$key]['main'] = $data['main'][$key];
      $data['filters_object'][$key]['name'] = $data['name'][$key];
      $data['filters_object'][$key]['value'] = $data['value'][$key];
      
    } unset($value);

    

    return $data['filters_object'];
  }
  private function parseTable($table, $id){
    //echo "<pre>"; print_r($table); die();
  if(empty($table))
      return [];
  $matches = [];
  preg_match_all("/".$id."\">\s*[<\s*p.*>]*<\s*span.*>([^<]*)<\s*\/\s*span\s*>[<\s*\/\s*p\s*>]*/", $table, $matches);
  
  if(isset($matches[1]) && is_array($matches[1])){
      $matches = $matches[1];
  }else{
      $matches = [];
  }
  
  foreach($matches as $key => $one){      
      if(strlen($one) == 2){    
        unset($matches[$key]);
      }
  }
  return $matches;
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

   $this->load->library('filter_lib');
   $upd = $this->filter_lib->getCatThis($categoryid);

   $cat_idis = array_unique($this->menu_model->formedCategoryIdis($categoryid));
   if(in_array(1,$cat_idis)){
      $_tmp = $this->db->select('id')
              ->from('site_category')
              ->where('visible',1)
              ->where('id != 6')
              ->where_not_in('id', $upd)
              ->order_by('position','ASC')
              ->get()
              ->result_array();    
      foreach($_tmp as $one){
          $cat_idis[] = $one['id'];
      }
  }
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
   if($categoryid == '1') {
    $all = [];
    $all = 'all';
      $pagination['COUNTALL'] = $this->filter_lib->get_object_count($cat_idis, $parametterArray, $all);
    } else {
      $pagination['COUNTALL'] = $this->filter_lib->get_object_count($cat_idis, $parametterArray);
    }

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
   

   // if($categoryid == '1') {
    $temp_catalog = $this->filter_lib->get_objects($cat_idis, $parametterArray, $pagination['COUNTONPAGE'], 'all', 'ajax');
   // }

   $_move_cart_idis = array();
   $temp_cart = $this->cart->contents();
   if (!empty($temp_cart)) {
    foreach ($temp_cart as $one_cart) {
     if (isset($one_cart['id'])) array_push($_move_cart_idis, $one_cart['id']);
    }
   }

   $temp_data['view'] = $this->load->view('inside/catalog/catalog_item_01_view', array('catalog' => $temp_catalog, '_move_cart_idis' => $_move_cart_idis, '_list' => $_list), true);
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

  // --------- new update 07.09.2015--------
  $this->load->library('filter_lib');
  $upd = $this->filter_lib->getCatThis($categoryid);

  $cat_idis = array_unique($this->menu_model->formedCategoryIdis($categoryid));
  if(in_array(1,$cat_idis)){
      $_tmp = $this->db->select('id')
              ->from('site_category')
              ->where('visible',1)
              ->where('id != 6')
              ->where_not_in('id', $upd)
              ->order_by('position','ASC')
              ->get()
              ->result_array();
      foreach($_tmp as $one){
          $cat_idis[] = $one['id'];
      }
  }

  #if (empty($cat_idis)) site_404_url();

  $this->load->library('filter_lib');

  $parametterArray = $this->filter_lib->parse($parametter);
  if ($parametterArray === false) $parametterArray = array();

  if (!empty($parametter) && (empty($parametterArray) || $parametterArray === false)) site_404_url();

  $parametterArray = $this->filter_lib->prepare($parametterArray);

  $pagination = array();
  $pagination['COUNTONPAGE'] = 12;
  if (isset($parametterArray['view'][0]) && $parametterArray['view'][0] == 'list') $pagination['COUNTONPAGE'] = 6;

  if($categoryid == '1') {
    $all = [];
    $all = 'all';
    $pagination['COUNTALL'] = $this->filter_lib->get_object_count($cat_idis, $parametterArray, $all);
  } else {
    $pagination['COUNTALL'] = $this->filter_lib->get_object_count($cat_idis, $parametterArray);
  }

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
  $this->data['PARENTCATEGORYLINK'] = $this->menu_model->getParentLink($categoryid);
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

  if ($pagination['COUNTALL'] > 0){
    if($categoryid == '1') {
      $content['catalog'] = $this->filter_lib->get_objects_all($cat_idis, $parametterArray, $pagination['COUNTONPAGE']);
    } else {
      $content['catalog'] = $this->filter_lib->get_objects($cat_idis, $parametterArray, $pagination['COUNTONPAGE']);
    }
  }
  else $content['catalog'] = array();

  // if(isset($content['catalog']) && !empty($content['catalog'])){
  //   foreach($content['catalog'] as $key => $value){
  //     if((int)$value['paket_option'] >= 1) unset($content['catalog'][$key]);
  //   } unset($value);
  // }

  //echo "<pre>"; print_r($content['catalog']); die();
  
  foreach($content['catalog'] as &$one){
      $one['comm_count'] = $one['comm_count'] . ' ' . parent::pluralForm($one['comm_count'], "отзыв", "отзыва", "отзывов");
  }

  // -----------------------   count cokies -------------------------
    $cokies = explode(',', $this->input->cookie('compare'));
    $cokies_count = [];
    foreach ($cokies as $key => $value) {
      $cokies_count[] = $value;
    }
    $content['catalog']['count_copy'] = count($cokies_count);
  // ------------------------------------------------------------------ end count cokies -------------

  $content['FILTER'] = $parametterArray;
  $this->data['SITE_CONTENT'] = $content;
  $this->display_lib->catalog($this->data, $this->view);
 }

 public function action_search($page = 1) {
  if (!isset($_GET['search'])) site_404_url();

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
//  echo $pagination['COUNTALL'];
//  die();
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
