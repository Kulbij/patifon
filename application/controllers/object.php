<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'main.php';

class Object extends Main {
 public function __construct() {
  parent::__construct();
 }
 public function index($objectlink = '', $subpage = 'description', $page = 1) {    
    
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
            //$option = $this->catalog_model->getOptionObject($id_object);
            $option = $content['object']['product-visible'];
            if(empty($option) && $option == 0) unset($content['views'][$key]);
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
            if($content['object']['product-visible'] == 1){
              $config_acc = $this->catalog_model->selectAcc($id_object);
              if(empty($config_acc)) unset($content['views'][$key]);
            } else {
              if($content['object']['product-visible'] == 0) unset($content['views'][$key]);
            }
          }
          //---------------------------- Comments--------------------------
          if($value['id'] == '3'){
            $config_comments = $this->catalog_model->selectComments($id_object);
            if(empty($config_comments)) unset($content['views'][$key]);
          }
        } unset($value);
      }
    //---------------------------------- and delete views object ------------------------------

      $content['filter_object'] = $content['object']['features_text'];

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

      //============================================ end ================================================================

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
  $content{'count_comments'} = round(count($content['comments_all']) / 12);
  if($content{'count_comments'} == 0) {
    $content{'count_comments'} = 1;
  }
  $content['night_comment'] = $this->catalog_model->getProductComments($object_id, $page, 9);

  $count_all = $this->catalog_model->getCommentsCount($object_id);
  
  $content['comments_count'] = $count_all. ' ' . parent::pluralForm($count_all, 'отзыв', "отзыва", "отзывов");  
  #$content['components'] = $this->catalog_model->comps_get($object_id);

  $this->load->model('index_model');
  //$content['product_info']['delivery'] = $this->index_model->getVar('delivery');
  $content['product_info']['payment'] = $this->index_model->getVar('payment');
  //$content['product_info']['packej'] = $this->index_model->getVar('packej');

  $content['indormer'] = $this->index_model->getInformerProduct();

  // ======================== mobile version
      $this->load->library('user_agent');

      if($this->agent->is_mobile()) $content['mobile'] = 1;
      else $content['mobile'] = 0;
    // ============================= end mobile

  $this->data['SITE_CONTENT'] = $content;

  
  
  $this->display_lib->object($this->data, $this->view);
 }
}