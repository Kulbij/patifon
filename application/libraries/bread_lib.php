<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bread_lib {

 public function __construct() {
 }

 public function __get($variable) {
  return get_instance()->$variable;
 }

 public function getBread($page = '', $inarray = array()) {
  $return = array();
  $return['breadcrumbs'] = array();
  $return['breadname'] = '';

  $index = 0;
  $this->load->model('bread_model');

  $return['breadcrumbs'][$index] = $this->bread_model->getIndexBread();
  ++$index;

  $popravka = 0;
  if (in_array($this->uri->segment(1), $this->config->item('site_lang_all')))
   $popravka = 1;

  switch($page) {
   case 'category':
   case 'catalog':
   case 'object': {

    $array = array();

    $categoryid = 0;
    $object_temp = array();
    if ($page == 'object') {
     $this->load->model('catalog_model');

     $objectid = (isset($inarray['obj_id']) ? $inarray['obj_id'] : 0);

     $obj_parent = $this->catalog_model->getParentID($objectid);
     if ($obj_parent <= 0) $obj_parent = $objectid;
     else {
      $object_temp['name'] = $this->catalog_model->getName($obj_parent);
      $object_temp['link'] = 'product/'.$this->catalog_model->getLink($obj_parent);
     }

     $categoryid = $this->catalog_model->getCategoryID($obj_parent);
    } else $categoryid = (isset($inarray['cat_id']) ? $inarray['cat_id'] : 0);

    $parentid = 0;
    if ($page == 'object') {
     $parentid = $categoryid;
    } else {
     $parentid = $this->menu_model->getParent($categoryid);
    }

    if (!empty($object_temp)) {
     $array[$index] = $object_temp;
     ++$index;
    }

    while($parentid > 0) {
     $temp = $this->menu_model->getOne($parentid);
     if (!is_array($temp) || empty($temp)) $parentid = 0;
     if (isset($temp['id']) && isset($temp['name'])) {
       $array[$index]['link'] = 'catalog/'.$temp['link'];
       $array[$index]['name'] = $temp['name'];
       ++$index;
     }
     if (isset($temp['parentid'])) $parentid = $temp['parentid'];
     else $parentid = 0;
    }

    if ((isset($inarray['cat_id']) && $inarray['cat_id'] > 0) || (isset($inarray['obj_id']) && $inarray['obj_id'] > 0)) {
     $catalog_page = $this->bread_model->getPageBread('catalog');
     if (!empty($catalog_page)) {
      $array[$index] = $catalog_page;
      ++$index;
     }
    }

    if (!empty($array)) {
     $return['breadcrumbs'] = array_merge($return['breadcrumbs'], array_reverse($array));
    } elseif (isset($inarray['parametter_array']['sort'][0]) && $inarray['parametter_array']['sort'][0] == 'new') {
     $array[$index]['link'] = 'catalog';
     $array[$index]['name'] = $this->page_model->getPageName('catalog');
     ++$index;

     $return['breadcrumbs'] = array_merge($return['breadcrumbs'], array_reverse($array));

     $return['breadname'] = 'новинки';
    }

    if (isset($inarray['cat_id']) && $inarray['cat_id'] > 0) {
     $return['breadname'] = $this->menu_model->getName($inarray['cat_id']);
    }

    if (isset($inarray['obj_id']) && $inarray['obj_id'] > 0) {
     $return['breadname'] = $this->catalog_model->getName($inarray['obj_id']);
    }

    if (empty($return['breadname'])) {
     $return['breadname'] = $this->page_model->getPageName('catalog');
    }

   } break;

   case 'promotions': {

    if (isset($inarray['breadid']) && $inarray['breadid'] > 0) {

     $this->load->model('page_model');
     $temp = array();
     $temp['link'] = $page;
     $temp['name'] = $this->page_model->getPageName($page);

     array_push($return['breadcrumbs'], $temp);

     $this->load->model('promo_model');
     $return['breadname'] = $this->promo_model->getName($inarray['breadid']);

    } else {

     $this->load->model('page_model');
     $return['breadname'] = $this->page_model->getPageName($page);

    }

   } break;

   case 'articles': {

    if (isset($inarray['breadid']) && $inarray['breadid'] > 0) {

     $this->load->model('page_model');
     $temp = array();
     $temp['link'] = $page;
     $temp['name'] = $this->page_model->getPageName($page);

     array_push($return['breadcrumbs'], $temp);

     $this->load->model('article_model');
     $return['breadname'] = $this->article_model->getName($inarray['breadid']);

    } else {

     $this->load->model('page_model');
     $return['breadname'] = $this->page_model->getPageName($page);

    }

   } break;

   case 'gallery': {

    $this->load->model('page_model');
    $temp = array();
    $temp['link'] = 'catalog';
    $temp['name'] = $this->page_model->getPageName('catalog');
    $return['breadcrumbs'][] = $temp;
    ++$index;

    if (isset($inarray['page_link'])) {
     $temp = $this->bread_model->getPageBread($inarray['page_link'],
                                              (isset($inarray['page_other']) ? $inarray['page_other'] : false)
                                             );

     if (isset($inarray['galleryid']) && $inarray['galleryid'] > 0) {
      if (isset($temp['link']) && isset($temp['name'])) {
       $return['breadcrumbs'][$index] = $temp;
       ++$index;
      }
     } else {
      if (isset($temp['link']) && isset($temp['name'])) {
       $return['breadname'] = $temp['name'];
      }
     }

    }

    if (isset($inarray['galleryid']) && $inarray['galleryid'] > 0) {
     $this->load->model('page_model');
     $return['breadname'] = $this->page_model->lb_getName($inarray['galleryid']);
    }
   } break;

   case 'user': {

    if (isset($inarray['page_link'])) {

     $this->load->model('user_model');
     $return['breadname'] = $this->user_model->page_get_name($inarray['page_link']);

    }

   } break;

   default: {

    $this->load->model('page_model');

    if ($page == 'order' || $page == 'invoice') {

     $this->load->model('page_model');
     $temp = array();
     $temp['link'] = 'cart';
     $temp['name'] = $this->page_model->getPageName($temp['link'], true);
     $return['breadcrumbs'][] = $temp;
     ++$index;

     if ($page == 'invoice') {
      $temp = array();
      $temp['link'] = 'cart/order';
      $temp['name'] = $this->page_model->getPageName('order', true);
      $return['breadcrumbs'][] = $temp;
      ++$index;
     }

    }

    if (isset($inarray['page_link'])) {
     $return['breadname']
      = $this->page_model->getPageName($inarray['page_link'],
                                       (isset($inarray['page_other']) ? $inarray['page_other'] : false)
                                      );

    }

   } break;
  }

  return $return;
 }
}