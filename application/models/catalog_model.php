<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Catalog_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }

 #PRIVATE

 /**
   * formedStandartSelect
   *
   * @param
   *
   * @relation -
   *
   * @return void
   * @author ME
   **/
 private function formedStandartSelect($catid = 0, $count = false, $cart = '') {

  parent::select_lang('site_catalog.name');
  $this->db
          ->select("site_catalog.id, site_catalog.link,
            site_catalog.image, site_catalog.image_hover,
            site_catalog.contact_price, paket_option,
            site_catalog.in_stock, site_catalog.avail,
            site_catalog.price, site_catalog.old_price,
            site_catalog.width, site_catalog.height, site_catalog.depth,
            site_catalog.favorite_count,
            site_catalog.delivery_3_5,
            ", false)
          ;

  $this->db

          ->from('site_catalog')
          ->where('site_catalog.visible = 1')   
          ;

  $this->db
          ->from('site_category')
          ->from('site_catalog_category')
          ->where('site_catalog_category.catalogid = site_catalog.id')
          ->where('site_catalog_category.categoryid = site_category.id')
          ;

//  $this->db
//          ->select('site_catalog_share.class as share_class')
//          ->join('site_catalog_share', 'site_catalog.shareid = site_catalog_share.id', 'left')
//          ;
          if($cart != 'cart') $this->db->where('site_catalog.paket_option', 0);
//  

  if (!empty($catid)) {

   $this->db->where_in('site_category.id', $catid);

  } else {

   $this->db->where('site_catalog_category.main = 1');

  }

  $this->db->group_by('site_catalog.id');

 }

 private function formedCatalogParamatterQuery($parametter_array = array()) {
  if (!is_array($parametter_array) || empty($parametter_array)) return false;

  $temp_array = $parametter_array;

  if (isset($parametter_array['min-price'][0])) {
   $this->db->where("price >= ".$this->db->escape($parametter_array['min-price'][0]));
   unset($parametter_array['min-price']);
  }

  if (isset($parametter_array['max-price'][0])) {
   $this->db->where("price <= ".$this->db->escape($parametter_array['max-price'][0]));
   unset($parametter_array['max-price']);
  }

  unset($parametter_array['sort']);
  unset($parametter_array['view']);

  if (!empty($parametter_array)) {

   foreach ($parametter_array as $key => $one) {
     if (!empty($one)) {
       $this->db->where('`site_catalog`.`id` IN (SELECT `site_catalog_filters_catalog`.`catalog_id` FROM `site_catalog_filters_catalog` WHERE `site_catalog_filters_catalog`.`filter_id` IN (' . implode(',', $one) . '))', null, false);
     }
   }
   $this->db->from('site_catalog_filters_catalog')->where('site_catalog.id = site_catalog_filters_catalog.catalog_id');

  }

 }

 private function formedCatalogParamatterSortQuery($parametter_array = array()) {

  #not available product order to end
  // $this->db->order_by('site_catalog.in_stock', 'DESC');
  // $this->db->order_by('site_catalog.position', 'aSC');

  if (!is_array($parametter_array) || empty($parametter_array)) return false;

  if (isset($parametter_array['sort'][0])) {

   switch($parametter_array['sort'][0]) {

    case 'cheap': {

     $this->db
              ->order_by('site_catalog.in_stock', 'DESC')
              ->order_by('site_catalog.delivery_3_5', 'ASC')
             ->order_by('price', 'ASC')
             ;

    } break;

    case 'news': {

     $this->db
             ->order_by('site_catalog.in_stock', 'DESC')
              ->order_by('site_catalog.delivery_3_5', 'ASC')
             ->order_by('site_catalog.shareid', 'DESC')
             ;

    } break;

    case 'discounts': {

     $this->db
             
              ->order_by('site_catalog.in_stock', 'DESC')
              ->order_by('site_catalog.delivery_3_5', 'ASC')
              ->order_by('site_catalog.old_price', 'ASC')

             ;

    } break;

    case 'popular': {

     $this->db
              ->order_by('site_catalog.in_stock', 'DESC')
              ->order_by('site_catalog.delivery_3_5', 'ASC')
             ->order_by('site_catalog.countwatch', 'DESC')
             ;

    } break;

    case 'expansiv': {

     $this->db
              ->order_by('site_catalog.in_stock', 'DESC')
              ->order_by('site_catalog.delivery_3_5', 'ASC')
             ->order_by('price', 'DESC')
             // ->order_by('site_catalog.countwatch', 'DESC')
             ;

    } break;

    default: {

     $this->db
             ->order_by('site_catalog.product-visible', 'DESC')
          ->order_by('site_catalog.in_stock', 'DESC')
          ->order_by('site_catalog.delivery_3_5', 'ASC')
          ->order_by('site_catalog.position', 'ASC')
             ;

    } break;

   }

  }

 }
 public function getObjectFeatures($id){
    $res = $this->db->select('features_ru as features')
       ->from('site_catalog')
       ->where('id',$id)
       ->get()
       ->row_array();
    return $res['features'];
 }
public function getWarranty($id = 1){
    $res = $this->db->select('name_' . SITELANG . ' as name, id, price')
      ->from('site_catalog_warranty')
      ->where('id',$id)
      ->limit(1)
      ->get()
      ->row_array();
    if(empty($res)){
  return $this->getWarranty();
    }
    return $res;
}
 public function get_product_factory($idis) {
  if (!is_array($idis) || empty($idis)) return array();

  parent::select_lang('site_catalog_filters.name');
  $this->db
          ->select('site_catalog_filters_catalog.catalog_id as id')
          ->from('site_catalog_filters')->from('site_catalog_filters_catalog')
          ->where('site_catalog_filters.id = site_catalog_filters_catalog.filter_id')
          ->where_in('site_catalog_filters_catalog.catalog_id', $idis)
          ->where("site_catalog_filters.parent_id IN (SELECT id FROM site_catalog_filters WHERE field = 'brand') ", null, false)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $return = array();

  foreach ($res as $one) {
   $return[$one['id']][] = $one['name'];
  }

  return $return;
 }

 #this is the end... */

 /**
   * is
   *
   * @param link
   *
   * @relation -
   *
   * @return mixed
   * @author ME
   **/
 public function is($link = '') {
  if (empty($link)) return false;
  $link = parent::prepareDataString($link);

  $this->db
          ->select('id')
          ->from('site_catalog')
          ->where('link = '.$this->db->escape($link))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res['id'];
 }

 public function isByID($id = '') {     
  $id = (int)$id;
  if ($id <= 0) return false;

  $this->db
          ->select('id')
          ->from('site_catalog')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();  
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 /**
   * getCategoryID
   *
   * @param objectid
   *
   * @relation -
   *
   * @return int
   * @author ME
   **/
 public function getCategoryID($objectid = 0) {
  $objectid = (int)$objectid;
  if ($objectid <= 0) return 0;

  $this->db
          ->select('site_catalog_category.categoryid')
          ->from('site_catalog')->from('site_catalog_category')
          ->where('site_catalog.id = '.$this->db->escape($objectid))
          ->where('site_catalog.id = site_catalog_category.catalogid')
          ->where('site_catalog_category.main = 1')
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['categoryid'];
 }

 public function getPrice($objectid = 0) {
  $objectid = (int)$objectid;
  if ($objectid <= 0) return 0;

  $this->db
          ->select('price')
          ->from('site_catalog')
          ->where('id = '.$this->db->escape($objectid))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['price'];
 }

 public function getName($objectid = 0) {
  $objectid = (int)$objectid;
  if ($objectid <= 0) return '';

  $this->db
          ->select('name_'.SITELANG.' as name')
          ->from('site_catalog')
          ->where('id = '.$this->db->escape($objectid))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }

 public function getLink($objectid = 0) {
  $objectid = (int)$objectid;
  if ($objectid <= 0) return '';

  $this->db
          ->select('link')
          ->from('site_catalog')
          ->where('id = '.$this->db->escape($objectid))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['link'];
 }

 public function getTKD($objectid = 0) {
  $objectid = (int)$objectid;
  if ($objectid <= 0) return array();

  $this->db
          ->select('title_'.SITELANG.' as title, keyword_'.SITELANG.' as keyword,
                    description_'.SITELANG.' as description')
          ->from('site_catalog')
          ->where('id = '.$this->db->escape($objectid))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function getOne($objectid = 0) {     
  $objectid = (int)$objectid;
  if ($objectid <= 0) return array();

  parent::select_lang('site_catalog.name, site_catalog.features as features_text, site_catalog.text');
  $this->db
          ->select("site_catalog.id, site_catalog.link, site_catalog.delivery_3_5,
            site_catalog.image,
            site_catalog.in_stock, site_catalog.avail, site_catalog.countwatch,
            site_catalog.price, site_catalog.old_price,
            site_catalog.width, site_catalog.height, site_catalog.depth, site_catalog.video,
            site_catalog.favorite_count, site_catalog.gift, site_catalog.date_gift
            ", false)
          ->select('site_catalog.product-visible')

          ->from('site_catalog')

          ->where('site_catalog.id = '.$this->db->escape($objectid))
          ->limit(1)
          ;
  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();

  $image = $res['image'];
  $res['image_sm'] = 'images/'.$res['id'].'/mainimg/'.parent::image_to_ext($image, '_sm');
  $res['image'] = 'images/'.$res['id'].'/mainimg/'.parent::image_to_ext($image, '_obj');
  $res['image_big'] = 'images/'.$res['id'].'/mainimg/'.parent::image_to_ext($image, '');
  $res['image_zoom'] = 'images/'.$res['id'].'/mainimg/'.parent::image_to_ext($image, '_big');
  $res['share_class'] = $this->getObjectShares($objectid);
  $res['filter_ico'] = $this->getFilterIco($objectid);
  #$temp = $this->get_product_factory(array($res['id']));
  #if (isset($temp[$res['id']])) $res['factoryname'] = implode($temp[$res['id']], ', ');

  $filters = $this->filter_get_by_products(array($res['id']));
  if (isset($filters[$res['id']])) $res['filters'] = $filters[$res['id']];
  

  #UP countwatch
  $this->db
          ->set('countwatch', ($res['countwatch'] + 1))
          ->where('id = '.$this->db->escape($res['id']))
          ->limit(1)
          ->update('site_catalog')
          ;
  #end UP countwatch  

  
  return $res;
 }
 private function getFilterIco($id = 0){
  if($id <= 0) return false;

    $this->db->select('*')
    ->where('site_catalog_filters_catalog.catalog_id', $id);
    $this->db->from('site_catalog_filters_catalog');

    $res = $this->db->get();
    if($res->num_rows() <= 0) return false;
    $res = $res->result_array();

    foreach($res as $key => $val){
      $result[$key]['android'] = $this->getOneFilterIco(68);
      $result[$key]['amd'] = $this->getOneFilterIco(72);
      // $result[$key]['ram'] = $this->getOneFilterIco();
      // $result[$key]['camera'] = $this->getOneFilterIco();
      // $result[$key]['batarry'] = $this->getOneFilterIco();
    } unset($val);
    //echo "<pre>"; print_r($res); die();
 }
 private function getOneFilterIco($id){
  if($id <= 0) return false;

  $res = $this->db->select()->where('site_catalog_filters.id', $id)->from('site_catalog_filters')->get();
  if($res->num_rows() <= 0) return false;
  $res = $res->result_array();
  //echo "<pre>"; print_r($res); die();
 }
 private function getObjectShares($objectid = 0){
   $res = $this->db->select('site_catalog_share.class')
          ->from('site_catalog_share')
          ->join('site_catalog_share_catalog','site_catalog_share_catalog.shareid = site_catalog_share.id')
          ->where('site_catalog_share_catalog.catalogid',$objectid)
          ->order_by('site_catalog_share.position','ASC')
          ->get()
          ->result_array();
  $_tmp = [];
  foreach($res as $one){
      $_tmp[] = $one['class'];
  }
  return $_tmp;
 }
 public function getCommentsCount($object_id = null){

  // $res2 = $this->db->select('*')->where('site_color_catalog.main_id', $object_id)->from('site_color_catalog')->get();
  // if($res2->num_rows() <= 0) $res2 = [];
  // else  $res2 = $res2->result_array();

  // if(isset($res2) && !empty($res2)) {
  //   $idis = [];
  //   foreach($res2 as $k => $one){
  //     $idis[] = $one['catalogid'];
  //   } unset($one);

  //   $idis2 = [];
  //   foreach($res2 as $k => $two){
  //     $idis2[] = $two['main_id'];
  //   } unset($two);

  //   $array = [];
  //   $array = array_merge($idis, $idis2);
  //   $unique_array = [];
  //   $unique_array = array_unique($array);
  // } else $unique_array = $object_id;

  // $result = $this->db->select('site_color_catalog.catalogid')
  // ->where_in('site_color_catalog.main_id', $unique_array)
  // ->from('site_color_catalog')->get()->result_array();

  //   if(isset($result) && !empty($result)){
  //     $idits = [];
  //     foreach($result as $value){
  //       $idits[] = $value['catalogid'];
  //     }unset($value);
  //     $all_result = [];
  //     $all_result = array_unique($idits);
  //   } else $all_result = $object_id;


     $object_id = (int)$object_id;
  if ($object_id <= 0) return array();
  $this->db->select('count(site_comment.id) as count');
    // $this->db->where_in('site_comment.id_catalog',$all_result);
  $this->db->where('site_comment.id_catalog',$object_id);
    $this->db->where('site_comment.visible',1)->from('site_comment');
    $res = $this->db->get()->row_array();
  return $res['count'];
 }
 public function getObjectAvgMark($object_id, $subpage = 'all', $page = 1){
     $object_id = (int)$object_id;
  if ($object_id <= 0) return array();
  
  $res = $this->db->select('AVG(site_comment.mark) as avg')
    ->from('site_comment')
    ->where('site_comment.id_catalog',$object_id)
    ->where('site_comment.visible',1)
    ->where('site_comment.mark > 0')
    ->get()
    ->row_array();
  return $res['avg'];
 }
 public function checkObject($second = ''){
     $second = parent::prepareDataString($second);
     $res = $this->db->select('id')
             ->from('site_catalog')
             ->where('link',$second)
             ->limit(1)
             ->get();
     if($res->num_rows() <= 0){
         return false;
     }     
     return $res->row_array()['id'];
 }
 public function getImages($objectid = 0) {
  $objectid = (int)$objectid;
  if ($objectid <= 0) return array();

  $this->db
          ->select('id, image')
          ->from('site_catalog_image')
          ->where('catalogid = '.$this->db->escape($objectid))
          ->where('visible = 1')
          ->order_by('position', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  foreach ($res as &$one) {
   $image = $one['image'];
   $one['image'] = 'images/'.$objectid.'/moreimg/'.parent::image_to_ext($image, '_sm');
   $one['image_big'] = 'images/'.$objectid.'/moreimg/'.parent::image_to_ext($image, '');
  } unset($one);

  return $res;
 }

 public function image_get_by_index($object, $index) {
  $object = (int)$object;
  $index = (int)$index;
  if ($object <= 0 || $index < 0) return array();

  $return = array();

  $images = $this->getImages($object);

  if ($index == 0) {

   $temp = $this->db->select('image')->from('site_catalog')->where('id = '.$this->db->escape($object))->limit(1)->get()->row_array();
   if (!empty($temp)) $return['image'] = 'images/'.$object.'/mainimg/'.parent::image_to_ext($temp['image'], '_obj');

   $return['is_next'] = (bool)count($images);

  } elseif (!empty($images)) {
   --$index;

   if (isset($images[$index]['image_big'])) $return['image'] = $images[$index]['image_big'];

   if ($index == 0) $return['is_prev'] = true;
   else $return['is_prev'] = isset($images[($index - 1)]['image_big']);

   $return['is_next'] = isset($images[($index + 1)]['image_big']);

  }

  return $return;
 }

 public function getFeatures($objectid = 0) {
  $objectid = (int)$objectid;
  if ($objectid <= 0) return array();

  $this->db
          ->select('id, name_'.SITELANG.' as name, value_'.SITELANG.' as value')
          ->from('site_catalog_item')
          ->where('catalogid = '.$this->db->escape($objectid))
          ->order_by('id', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function getParentID($objid = 0) {
  $objid = (int)$objid;
  if ($objid <= 0) return 0;

  $res = $this->db->select('parentid')->from('site_catalog')->where('id = '.$this->db->escape($objid))->limit(1)->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['parentid'];
 }

 /**
   * getPopular
   *
   * @param popular - shareid
   * @param count
   *
   * @relation - formedStandartSelect
   *
   * @return array
   * @author ME
   **/
 public function getPopular($catid = array(), $count = 4, $link = array()) {
  $count = (int)$count;
  if ($count <= 0) return array();

  $this->formedStandartSelect();
  $this->db->select('site_catalog.product-visible');

  if (!empty($catid)) {
   $this->db
           ->from('site_catalog_category')
           ->where('site_catalog_category.catalogid = site_catalog.id')
           ->where_in('site_catalog_category.categoryid', $catid)
           ;

  }
if(isset($link) && !empty($link) && $link == 'all'){
  $this->db
          ->where('site_catalog.popular = 1')
          ->where('site_catalog.product-visible = 0')
          ->order_by('site_catalog.product-visible', 'DESC')
          ->order_by('site_catalog.in_stock', 'DESC')
          ->order_by('site_catalog.delivery_3_5', 'ASC')
          ->order_by('site_catalog.position', 'ASC')
          //->limit($count)
          ;
  } else {
  $this->db
          ->where('site_catalog.popular = 1')
          ->where('site_catalog.product-visible = 1')
          ->order_by('site_catalog.product-visible', 'DESC')
          ->order_by('site_catalog.in_stock', 'DESC')
          ->order_by('site_catalog.delivery_3_5', 'ASC')
          ->order_by('site_catalog.position', 'ASC')
          //->limit($count)
          ;
  }
  $res = $this->db->group_by('site_catalog.id')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $idis = array();
  foreach ($res as $one) array_push($idis, $one['id']);

  $filters = $this->filter_get_by_products($idis);
  foreach ($res as &$one) {      
      $one['comm_count'] = $this->getCommentsCount($one['id']);
   $image = $one['image'];   
   $one['image'] = $this->file_lib->show_no_image_our('images/'.$one['id'].'/mainimg/'.parent::image_to_ext($image, '_cat'));
   $one['share_class'] = $this->getObjectShares($one['id']);
   if (isset($filters[$one['id']])) $one['filters'] = $filters[$one['id']];

  } unset($one);
  return $res;
 }

 public function getSuper($catid = array(), $count = 8) {
  $count = (int)$count;
  if ($count <= 0) return array();

  $this->formedStandartSelect();

  if (!empty($catid)) {
   $this->db
           ->from('site_catalog_category')
           ->where('site_catalog_category.catalogid = site_catalog.id')
           ->where_in('site_catalog_category.categoryid', $catid)
           ;

  }

  $this->db
          ->where('site_catalog.super = 1')
          ->order_by('site_catalog.position', 'DESC')
          ->limit($count)
          ;

  $res = $this->db->group_by('site_catalog.id')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  foreach ($res as &$one) {
   $one['image'] = $this->file_lib->show_no_image_our('images/'.$one['id'].'/mainimg/'.parent::image_to_ext($one['image'], '_dis'));
  } unset($one);

  return $res;
 }

 /**
   * getCartObject
   *
   * @param idis
   *
   * @relation - formedStandartSelect
   *
   * @return array
   * @author ME
   **/
 public function getCartObject($idis = array(), $id_product = array()) {
  $return = array();
  if (!is_array($idis) || empty($idis)) return $return;
  $idis = array_unique($idis);
  $count_idis = count($idis);

  $this->formedStandartSelect(0, 0, 'cart');
  $this->db
         ->where_in('site_catalog.id', $idis)
         ->order_by('site_catalog.position', 'ASC')
         ;

  if ($count_idis == 1) $this->db->limit(1);

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return $return;
  $res = $res->result_array();

  foreach ($res as $one) {
    if($one['paket_option'] > 0) {
      $one['image'] = '';
      if(isset($id_product) && !empty($id_product) && $id_product > 0){
        $one['product_name'] = $this->db->select('site_catalog.name_'.SITELANG.' as name')->where('site_catalog.id', (int)$id_product)->from('site_catalog')->limit(1)->get()->row_array()['name'];
        if(!empty($one['product_name'])) $one['product_name'] = ' ('.$one['product_name'].')';
      }
    } else {
      $one['image'] = $this->file_lib->show_no_image_our('images/'.$one['id'].'/mainimg/'.parent::image_to_ext($one['image'], '_cat'));
  }

   $return[$one['id']] = $one;
  }

  return $return;
 }

 public function getCatalogObject($catid = 0, $idis = array(), $count = 0, $required = '', $max = 0, $min = 0) {
  #if (empty($catid)) return array();
  $count = (int)$count;

  $page = (isset($idis['page'][0])) ? (int)$idis['page'][0] : 0;
  if ($page == 0 || $page == 1) $page = 0;
  else $page = ($page * $count) - $count;

  unset($idis['page']);

  $this->formedStandartSelect($catid);
  $this->db->select('site_catalog.product-visible');

  $this->formedCatalogParamatterQuery($idis);

  $this->formedCatalogParamatterSortQuery($idis);
  if(isset($required) && $required == 'all'){
    if(isset($max) && !empty($max) && $max == 'ajax') {
      $res = $this->db->group_by('site_catalog.id')->limit($count, $page)->get();
    } else {
      $res = $this->db->where('site_catalog.product-visible = 1')->group_by('site_catalog.id')->limit($count, $page)->get();
    }
  } else {
    $res = $this->db->where('site_catalog.parentid = 0')->group_by('site_catalog.id')->limit($count, $page)->get();
  }

  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $idis = array();
  foreach ($res as $one) array_push($idis, $one['id']);

  #$colors = $this->color_get_by_product($idis);
  #$factories = $this->get_product_factory($idis);

  $filters = $this->filter_get_by_products($idis);

  foreach ($res as &$one) {

   $image = $one['image'];
   $one['image'] = 'images/'.$one['id'].'/mainimg/'.parent::image_to_ext($image, '_cat');
   $one['share_class'] = $this->getObjectShares($one['id']);
   $one['mark'] = $this->getObjectAvgMark($one['id']);
   $one['comm_count'] = $this->getCommentsCount($one['id']);
   if (isset($filters[$one['id']])) $one['filters'] = $filters[$one['id']];

   #if (isset($one['image_hover']) && !empty($one['image_hover'])) $one['image_hover'] = 'images/'.$one['id'].'/mainimg/'.parent::image_to_ext($one['image_hover'], '');

   #if (isset($colors[$one['id']])) $one['colors'] = $colors[$one['id']];

   #if (isset($factories[$one['id']])) $one['factoryname'] = implode($factories[$one['id']], ', ');

  } unset($one);  
  return $res;
 }

 public function getCatalogObjectCount($catid = 0, $idis = array(), $all = array()) {
  #if (empty($catid)) return array();
  unset($idis['page']);

  $this->formedStandartSelect($catid);

  $this->formedCatalogParamatterQuery($idis);

  if(isset($all) && !empty($all) && $all == 'all'){
    $res = $this->db->where('site_catalog.product-visible = 1')->group_by('site_catalog.id')->get();
  } else {
    $res = $this->db->where('site_catalog.parentid = 0')->group_by('site_catalog.id')->get();
  }

  #AAAAAAAAARRRRRRRRRRRRRRRRRRRRGGGGGGGGGGGGGGGGGGGGG!!!
  return (int)$res->num_rows();
  #HARDCODE!!!!!!!!!!!
  echo $this->db->last_query();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['count'];
 }

 public function getCatalogByCatIdis($idis = array()) {
  if (empty($idis)) return array();

  $this->formedStandartSelect();
  $this->db->select('site_catalog_category.categoryid');
  $this->db->from('site_catalog_category')->where('site_catalog_category.catalogid = site_catalog.id')->where_in('site_catalog_category.categoryid', $idis);

  $this->db->where('site_catalog.visible = 1');

  $this->formedCatalogParamatterQuery(array());

  $this->formedCatalogParamatterSortQuery(array());
  $res = $this->db->get();

  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $return = array();

  foreach ($res as $one) {
   if (!isset($return[$one['categoryid']])) $return[$one['categoryid']] = array();

   $one['image'] = 'images/'.$one['id'].'/mainimg/'.parent::image_to_ext($one['image'], '_cat');

   $return[$one['categoryid']][] = $one;

  }

  return $return;
 }

 public function getRand($limit = 4) { return array();
  $limit = (int)$limit;
  if ($limit <= 0) return array();

  $this->formedStandartSelect();
  $this->db
          ->where('site_catalog.visible = 1')
          ->order_by('site_catalog.id', 'RANDOM')
          ->limit($limit)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  foreach ($res as &$one) {
   $one['image'] = 'images/'.$one['id'].'/mainimg/'.parent::image_to_ext($one['image'], '_top');
  } unset($one);

  return $res;
 }

 public function getByIDS($idis = array()) {
  if (empty($idis)) return array();

  $this->formedStandartSelect();
  $this->db
          ->where('site_catalog.visible = 1')
          ->where_in('site_catalog.id', $idis)
          ;

  $this->db->_protect_identifiers = FALSE;
  $this->db->order_by('FIELD(site_catalog.id, '.implode(',', array_reverse($idis)).')');
  $this->db->_protect_identifiers = TRUE;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  foreach ($res as &$one) {
   $one['image'] = 'images/'.$one['id'].'/mainimg/'.parent::image_to_ext($one['image'], '_top');
  } unset($one);

  return $res;
 }

 public function getSimilar($objectid = 0) {
  $objectid = (int)$objectid;
  if ($objectid <= 0) return array();

  $this->formedStandartSelect();
  $this->db
          ->select('site_catalog.product-visible')
          ->from('site_catalog_catalog')
          ->where('site_catalog_catalog.mainid', $this->db->escape($objectid))
          ->where('site_catalog_catalog.catalogid = site_catalog.id')
          ->order_by('site_catalog.product-visible', 'DESC')
          ->order_by('site_catalog.in_stock', 'DESC')
          ->order_by('site_catalog.delivery_3_5', 'ASC')
          ->order_by('site_catalog.position', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $idis = array();
  foreach ($res as $one) array_push($idis, $one['id']);

  #$colors = $this->color_get_by_product($idis);
  #$factories = $this->get_product_factory($idis);

  $filters = $this->filter_get_by_products($idis);
$this->load->model('menu_model');
  foreach ($res as &$one) {
  $one['mark'] = $this->getObjectAvgMark($one['id']);
  $one['comm_count'] = $this->getCommentsCount($one['id']);
   $one['image'] = 'images/'.$one['id'].'/mainimg/'.parent::image_to_ext($one['image'], '_cat');
   $one['share_class'] = $this->getObjectShares($one['id']);
   $one['links'] = $this->menu_model->getObjectCategories($one['id']);
   if (isset($filters[$one['id']])) $one['filters'] = $filters[$one['id']];

   #if (isset($colors[$one['id']])) $one['colors'] = $colors[$one['id']];

   #if (isset($factories[$one['id']])) $one['factoryname'] = implode($factories[$one['id']], ', ');

  } unset($one);
//  echo '<pre>';
//  print_r($res);
//  die();
  return $res;
 }
public function getCompareObjects(array $ids = []){
    if(empty($ids)){
  return [];
    }
    $this->formedStandartSelect();    
    $this->db->where_in('site_catalog.id',$ids);
    $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  foreach ($res as &$one) {
      $one['mark'] = $this->getObjectAvgMark($one['id']);
  $one['comm_count'] = $this->getCommentsCount($one['id']);
   $one['image'] = 'images/'.$one['id'].'/mainimg/'.parent::image_to_ext($one['image'], '_cat');

   if (isset($filters[$one['id']])) $one['filters'] = $filters[$one['id']];

   #if (isset($colors[$one['id']])) $one['colors'] = $colors[$one['id']];

   #if (isset($factories[$one['id']])) $one['factoryname'] = implode($factories[$one['id']], ', ');
   
  } unset($one);
  
  return $res;
}
 public function getAccesories($objectid = 0) {
  $objectid = (int)$objectid;
  if ($objectid <= 0) return array();

  $this->formedStandartSelect();
  $this->db
          ->select('site_catalog.product-visible')
          ->from('site_catalog_accessories')
          ->where('site_catalog_accessories.main_id', $this->db->escape($objectid))
          ->where('site_catalog_accessories.product_id = site_catalog.id')
          ->order_by('site_catalog.product-visible', 'DESC')
          ->order_by('site_catalog.in_stock', 'DESC')
          ->order_by('site_catalog.delivery_3_5', 'ASC')
          ->order_by('site_catalog.position', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $idis = array();
  foreach ($res as $one) array_push($idis, $one['id']);

  #$colors = $this->color_get_by_product($idis);
  #$factories = $this->get_product_factory($idis);

  $filters = $this->filter_get_by_products($idis);
$this->load->model('menu_model');
  foreach ($res as &$one) {
      $one['mark'] = $this->getObjectAvgMark($one['id']);
  $one['comm_count'] = $this->getCommentsCount($one['id']);
   $one['image'] = 'images/'.$one['id'].'/mainimg/'.parent::image_to_ext($one['image'], '_cat');
   $one['share_class'] = $this->getObjectShares($one['id']);
   $one['links'] = $this->menu_model->getObjectCategories($one['id']);
   if (isset($filters[$one['id']])) $one['filters'] = $filters[$one['id']];

   #if (isset($colors[$one['id']])) $one['colors'] = $colors[$one['id']];

   #if (isset($factories[$one['id']])) $one['factoryname'] = implode($factories[$one['id']], ', ');

  } unset($one);

  return $res;
 }
public function getProductComments($objectid, $page=1, $count=2){    

  // $res2 = $this->db->select('*')->where('site_color_catalog.main_id', $objectid)->from('site_color_catalog')->get();
  // if($res2->num_rows() <= 0) $res2 = [];
  // else  $res2 = $res2->result_array();

  // if(isset($res2) && !empty($res2)) {
  //   $idis = [];
  //   foreach($res2 as $k => $one){
  //     $idis[] = $one['catalogid'];
  //   } unset($one);

  //   $idis2 = [];
  //   foreach($res2 as $k => $two){
  //     $idis2[] = $two['main_id'];
  //   } unset($two);

  //   $array = [];
  //   $array = array_merge($idis, $idis2);
  //   $unique_array = [];
  //   $unique_array = array_unique($array);
  // } else $unique_array = $objectid;

  // $result = $this->db->select('site_color_catalog.catalogid')
  // ->where_in('site_color_catalog.main_id', $unique_array)
  // ->from('site_color_catalog')->get()->result_array();

  //   if(isset($result) && !empty($result)){
  //     $idits = [];
  //     foreach($result as $value){
  //       $idits[] = $value['catalogid'];
  //     }unset($value);
  //     $all_result = [];
  //     $all_result = array_unique($idits);
  //   } else $all_result = $objectid;

    $objectid = (int)$objectid;
  if ($objectid <= 0) 
      return array();
  if ($page == 0 || $page == 1)
            $page = 0;
        else
            $page = ($page * $count) - $count;
  
  $res = $this->db->select('site_comment.id, site_comment.parent_id, site_comment.icon, site_comment.name, site_comment.text, site_comment.mark, site_comment.datetime')
    ->from('site_comment')
    // ->where_in('site_comment.id_catalog', $all_result)
    ->where('site_comment.id_catalog', $objectid)
    ->where('site_comment.visible',1)
    ->where('site_comment.parent_id',0)
    ->order_by('datetime','DESC')
    ->limit($count, $page)
    ->get()
    ->result_array();

    foreach($res as $key => $value){
      $res[$key]['children'] = $this->getChildrenCommentsID($value['id']);
      if($value['parent_id'] > 0) unset($res[$key]);

      // new create datetime ============================================ date ============================
      // $res[$key]['datetime'] = date('d.m.Y',time($value['datetime']));
      $res[$key]['datetime'] = $this->rus_date(date('d', strtotime($value['datetime'])), date('m', strtotime($value['datetime'])), date("Y", strtotime($value['datetime'])));
    } unset($value);
  return $res;
}

function rus_date($day, $m, $year) {

  $monthAr = array(
    1 => array('январь', 'января'),
    2 => array('февраль', 'февраля'),
    3 => array('март', 'марта'),
    4 => array('апрель', 'апреля'),
    5 => array('май', 'мая'),
    6 => array('июнь', 'июня'),
    7 => array('июль', 'июля'),
    8 => array('август', 'августа'),
    9 => array('сентябрь', 'сентября'),
    10=> array('октябрь', 'октября'),
    11=> array('ноябрь', 'ноября'),
    12=> array('декабрь', 'декабря')
  );

  return $day.' '.$monthAr[(int)$m][1].' '.$year;

} 

public function getChildrenCommentsID($id = 0){
  if($id <= 0) return false;
  $id = (int)$id;

  $res = $this->db->select('*')->where('site_comment.parent_id', $id)->from('site_comment')->order_by('datetime','DESC')->get();

  if($res->num_rows() <= 0) return false;
  $res = $res->result_array();

  return $res;
}

public function getProductCommentsAll($objectid, $page=1, $count=2){    

  // $res2 = $this->db->select('*')->where('site_color_catalog.main_id', $objectid)->from('site_color_catalog')->get();
  // if($res2->num_rows() <= 0) $res2 = [];
  // else  $res2 = $res2->result_array();

  // if(isset($res2) && !empty($res2)) {
  //   $idis = [];
  //   foreach($res2 as $k => $one){
  //     $idis[] = $one['catalogid'];
  //   } unset($one);

  //   $idis2 = [];
  //   foreach($res2 as $k => $two){
  //     $idis2[] = $two['main_id'];
  //   } unset($two);

  //   $array = [];
  //   $array = array_merge($idis, $idis2);
  //   $unique_array = [];
  //   $unique_array = array_unique($array);
  // } else $unique_array = $objectid;

  // $result = $this->db->select('site_color_catalog.catalogid')
  // ->where_in('site_color_catalog.main_id', $unique_array)
  // ->from('site_color_catalog')->get()->result_array();

  //   if(isset($result) && !empty($result)){
  //     $idits = [];
  //     foreach($result as $value){
  //       $idits[] = $value['catalogid'];
  //     }unset($value);
  //     $all_result = [];
  //     $all_result = array_unique($idits);
  //   } else $all_result = $objectid;

    $objectid = (int)$objectid;
  if ($objectid <= 0) 
      return array();
  if ($page == 0 || $page == 1)
            $page = 0;
        else
            $page = ($page * $count) - $count;
  
  $res = $this->db->select('site_comment.parent_id, site_comment.name, site_comment.text, site_comment.mark, site_comment.datetime')
    ->from('site_comment')
    ->where('site_comment.id_catalog', $objectid)
    ->where('site_comment.visible',1)
    ->order_by('datetime','DESC')
    //->limit($count, $page)
    ->get()
    ->result_array();

    foreach($res as $key => $value){
      if($value['parent_id'] > 0) unset($res[$key]);
    } unset($value);

  return $res;
}
 public function slider_get() {

  $this->formedStandartSelect();
  $this->db
          ->where('site_catalog.is_slader = 1')
          ->where('site_catalog.visible = 1')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  foreach ($res as &$one) {
   $one['image'] = 'images/'.$one['id'].'/mainimg/'.parent::image_to_ext($one['image'], '_obj');
  } unset($one);

  return $res;
 }

 public function shares_by_get() {

  $return = array();

  parent::select_lang('name');
  $res = $this->db->select('id')->from('site_catalog_share')->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $shares = $res->result_array();

  foreach ($shares as $value) {

   $this->formedStandartSelect();
   $this->db
           ->where('site_catalog.shareid = '.$this->db->escape($value['id']))
           ->where('site_catalog.visible = 1')
           ;

   $res = $this->db->get();
   if ($res->num_rows() > 0) {
    $res = $res->result_array();

    $idis = array();
    foreach ($res as $one) array_push($idis, $one['id']);

    #$factories = $this->get_product_factory($idis);

    foreach ($res as &$one) {
     $one['image'] = 'images/'.$one['id'].'/mainimg/'.parent::image_to_ext($one['image'], '_obj');

     #if (isset($factories[$one['id']])) $one['factoryname'] = implode($factories[$one['id']], ', ');

    } unset($one);

    $value['products'] = $res;

    array_push($return, $value);
   }

  }

  return $return;
 }

 #Manufacturer region
 public function getBrandName($objectid = 0, $alt = false) {
  $objectid = (int)$objectid;
  if ($objectid <= 0) return '';

  $res = $this->db->select('factoryid')->from('site_catalog')->where('id = '.$this->db->escape($objectid))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();

  $res = $this->db->select('name_'.SITELANG.' as name, other_name')->from('site_factory')->where('id = '.$this->db->escape($res['factoryid']))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();

  if ($alt && isset($res['other_name']) && !empty($res['other_name'])) return $res['name'].' ('.$res['other_name'].')';
  else return $res['name'];
 }

 public function getManufacturer($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid < 0) return array();
  $this->db->select('site_factory.id, site_factory.name_'.SITELANG.' as name, site_factory.link, site_factory.image')->distinct()->from('site_factory');
  if ($categoryid > 0) $this->db->from('site_catalog')->from('site_catalog_category')->where('site_factory.id = site_catalog.factoryid')->where('site_catalog.id = site_catalog_category.catalogid')->where("site_catalog_category.categoryid = '".$this->db->escape($categoryid)."'")->where('site_catalog.visible = 1');
  $res = $this->db->order_by('site_factory.name_'.SITELANG, 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }
 public function getManufacturerLF($categoryid = 0, $asarray = false, $parametter_array = null) {
  $categoryid = (int)$categoryid;
  $res = $this->getManufacturer($categoryid);
  if (empty($res)) return array();

  if (!is_null($parametter_array) && is_array($parametter_array))
   $this->load->library('catalog_lib');

  $temp = array();
  foreach ($res as &$one) {
   $one['key'] = 'manufacturer';

   if (isset($one['link']) && !empty($one['link'])) $temp[] = $one['link'];
   if (!is_null($parametter_array) && is_array($parametter_array)) {
    $one['catalogcount'] = $this->catalog_lib->getCatalogObjectCountByParametter($categoryid, $parametter_array, $one);
    $one['linker'] = $this->catalog_lib->changeCatalogParametter($parametter_array, $one);
   }
  } unset($one);

  if ($asarray) $res = $temp;

  return $res;
 }
 public function getManufacturerCatalogCount($manufacturerid = 0, $categoryid = 0) {
  $manufacturerid = (int)$manufacturerid;
  if ($manufacturerid <= 0) return 0;
  $categoryid = (int)$categoryid;
  $this->db->select('COUNT(*) as count')->from('site_catalog');
  if ($categoryid > 0) $this->db->from('site_catalog_category')->where('site_catalog.id = site_catalog_category.catalogid')->where("site_catalog_category.categoryid = '".$this->db->escape($categoryid)."'");
  $this->db->where("site_catalog.factoryid = '".$this->db->escape($manufacturerid)."'");
  $this->db->where('site_catalog.visible = 1');
  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['count'];
 }
 public function ZZZNA_getManufacturerCatalogCount($idis = array(), $categoryid = 0) {
  if (!is_array($idis) || empty($idis)) return array();
  $categoryid = (int)$categoryid;

  $res = array();
  $string = '';
  $first = true;
  foreach ($idis as $val) {
   $val = (int)$val;

   if (!$first) $string .= ' UNION ALL ';
   else $first = false;

   if ($categoryid > 0) $string .= "(SELECT IF(`site_catalog`.`id` IS NOT NULL, `site_catalog`.`id`, 0) as `id`, COUNT(*) as count FROM `site_catalog`, `site_catalog_category` WHERE `site_catalog`.`id` = `site_catalog_category`.`catalogid` AND `site_catalog_category`.`categoryid` = '{$categoryid}' AND `site_catalog`.`factoryid` = ".$this->db->escape($val)." AND `site_catalog`.`visible` = 1)";
   else $string .= "(SELECT IF(`site_catalog`.`id` IS NOT NULL, `site_catalog`.`id`, 0) as `id`, COUNT(*) as count FROM `site_catalog` WHERE `site_catalog`.`factoryid` = ".$this->db->escape($val)." AND `site_catalog`.`visible` = 1)";
  }
  if (!empty($string)) {
   $string .= ' ORDER BY `site_catalog`.`id` ';
   $temp = $this->db->query($string);
   if ($temp->num_rows() > 0) {
    $temp = $temp->result_array();
    foreach ($temp as $val) {
     if (isset($val['id']) && $val['id'] > 0 && isset($val['count'])) {
      $res[$val['id']] = $val['count'];
     }
    }
   }
  }
  return $res;
 }
 #end Manufacturer region

 #STYLE region
 public function getCatalogStyle($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid < 0) return array();
  $this->db->select('site_catalog_style.id, site_catalog_style.name_'.SITELANG.' as name, site_catalog_style.link')->distinct()->from('site_catalog_style');

  if ($categoryid > 0) $this->db->from('site_catalog_style_catalog')->from('site_catalog')->from('site_catalog_category')->where('site_catalog_style.id = site_catalog_style_catalog.styleid')->where('site_catalog_style_catalog.catalogid = site_catalog.id')->where('site_catalog.id = site_catalog_category.catalogid')->where("site_catalog_category.categoryid = '".$this->db->escape($categoryid)."'")->where('site_catalog.visible = 1');

  $this->db->where('site_catalog_style.visible = 1');

  $res = $this->db->order_by('site_catalog_style.position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }
 public function getCatalogStyleLF($categoryid = 0, $asarray = false, $parametter_array = null) {
  $categoryid = (int)$categoryid;
  $res = $this->getCatalogStyle($categoryid);
  if (empty($res)) return array();

  if (!is_null($parametter_array) && is_array($parametter_array))
   $this->load->library('catalog_lib');

  $temp = array();
  foreach ($res as &$one) {
   $one['key'] = 'style';

   if (isset($one['link']) && !empty($one['link'])) $temp[] = $one['link'];
   if (!is_null($parametter_array) && is_array($parametter_array)) {
    $one['catalogcount'] = $this->catalog_lib->getCatalogObjectCountByParametter($categoryid, $parametter_array, $one);
    $one['linker'] = $this->catalog_lib->changeCatalogParametter($parametter_array, $one);
   }
  } unset($one);

  if ($asarray) $res = $temp;

  return $res;
 }
 #this is the end... */

 #Sort region
 public function getCatalogSortLF($asarray = false, $parametter_array = null) {

  #unlink page to 0
  unset($parametter_array['page']);
  #end

  $res = $this->db->select('id, name_'.SITELANG.' as name, link')->from('site_catalog_sort')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  if (!is_null($parametter_array) && is_array($parametter_array))
   $this->load->library('catalog_lib');

  $temp = array();
  foreach ($res as &$one) {
   $one['key'] = 'sort';
   if (isset($one['link']) && !empty($one['link'])) $temp[] = $one['link'];
   if (!is_null($parametter_array) && is_array($parametter_array)) {
    $one['linker'] = $this->catalog_lib->changeCatalogParametter($parametter_array, $one);
   }
  } unset($one);

  if ($asarray) return $temp;

  return $res;
 }

 public function getCatalogSortPriceLF($asarray = false, $parametter_array = null) {

  #unlink page to 0
  unset($parametter_array['page']);
  #end

  $res = $this->db->select('id, name_'.SITELANG.' as name, link')->from('site_catalog_sort_price')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  if (!is_null($parametter_array) && is_array($parametter_array))
   $this->load->library('catalog_lib');

  $temp = array();
  foreach ($res as &$one) {
   $one['key'] = 'sort';
   if (isset($one['link']) && !empty($one['link'])) $temp[] = $one['link'];
   if (!is_null($parametter_array) && is_array($parametter_array)) {
    $one['linker'] = $this->catalog_lib->changeCatalogParametter($parametter_array, $one);
   }
  } unset($one);

  if ($asarray) return $temp;

  return $res;
 }
 #end Sort region

 #View region
 public function getCatalogViewLF($asarray = false, $parametter_array = null) {

  #unlink page to 0
  unset($parametter_array['page']);
  #end

  $res = $this->db->select('id, name_'.SITELANG.' as name, link')->from('site_catalog_view')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  if (!is_null($parametter_array) && is_array($parametter_array))
   $this->load->library('catalog_lib');

  $temp = array();
  foreach ($res as &$one) {
   $one['key'] = 'view';
   if (isset($one['link']) && !empty($one['link'])) $temp[] = $one['link'];
   if (!is_null($parametter_array) && is_array($parametter_array)) {
    $one['linker'] = $this->catalog_lib->changeCatalogParametter($parametter_array, $one);
   }
  } unset($one);

  if ($asarray) return $temp;

  return $res;
 }
 #this is the end... */

 #MAX region
 public function getMaxPrice($cat_idis = array()) {

  $this->db->select('MAX(site_catalog.price) as price')->from('site_catalog')->from('site_catalog_category')->where('site_catalog.id = site_catalog_category.catalogid');
  $this->db->where('site_catalog.visible = 1');

  if (is_array($cat_idis) && !empty($cat_idis)) $this->db->where_in('site_catalog_category.categoryid', $cat_idis);

  $res = $this->db->limit(1)->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return ceil($res['price']);
 }

 public function getMaxWidth($categoryid = 0) {
  $categoryid = (int)$categoryid;
  $this->db->select('MAX(site_catalog.width) as width')->from('site_catalog')->from('site_catalog_category')->where('site_catalog.id = site_catalog_category.catalogid');
  $this->db->where('site_catalog.visible = 1');

  if ($categoryid > 0) $this->db->where('site_catalog_category.categoryid = '.$this->db->escape($categoryid));

  $res = $this->db->limit(1)->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return ceil($res['width']);
 }

 public function getMaxHeight($categoryid = 0) {
  $categoryid = (int)$categoryid;
  $this->db->select('MAX(site_catalog.height) as height')->from('site_catalog')->from('site_catalog_category')->where('site_catalog.id = site_catalog_category.catalogid');
  $this->db->where('site_catalog.visible = 1');

  if ($categoryid > 0) $this->db->where('site_catalog_category.categoryid = '.$this->db->escape($categoryid));

  $res = $this->db->limit(1)->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return ceil($res['height']);
 }
 #this is the end... */

 #SEARCH region
 public function getCatalogObjectCountSearch($search = array()) {
  $this->formedStandartSelect();

  $this->formedSearchQuery($search);

  $res = $this->db->where('site_catalog.parentid = 0')->get();
//  echo $this->db->last_query();
//  die();
  
  return (int)$res->num_rows();
 }

 public function getCatalogObjectSearch($search = array(), $page = 1, $count = 10) {
  if ($page == 0 || $page == 1) $page = 0;
  else $page = ($page * $count) - $count;

  $this->formedStandartSelect();

  $this->db
          ->where('site_catalog.parentid = 0')
          ->order_by('site_catalog.product-visible', 'DESC')
          ->order_by('site_catalog.in_stock', 'DESC')
          ->order_by('site_catalog.delivery_3_5', 'ASC')
          ->order_by('site_catalog.position', 'ASC')
          ;

  $this->formedSearchQuery($search);

  $res = $this->db->limit($count, $page)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $idis = array();
  foreach ($res as $one) array_push($idis, $one['id']);

  #$colors = $this->color_get_by_product($idis);
  #$factories = $this->get_product_factory($idis);

  $filters = $this->filter_get_by_products($idis);
    $this->load->model('menu_model');
  foreach ($res as &$one) {
   $one['image'] = 'images/'.$one['id'].'/mainimg/'.parent::image_to_ext($one['image'], '_cat');
   $one['share_class'] = $this->getObjectShares($one['id']);
   $one['mark'] = $this->getObjectAvgMark($one['id']);
   $one['comm_count'] = $this->getCommentsCount($one['id']);
   $one['links'] = $this->menu_model->getObjectCategories($one['id']);
   if (isset($filters[$one['id']])) $one['filters'] = $filters[$one['id']];

   #if (isset($colors[$one['id']])) $one['colors'] = $colors[$one['id']];

   #if (isset($factories[$one['id']])) $one['factoryname'] = implode($factories[$one['id']], ', ');

  } unset($one);

  return $res;
 }

 protected function formedSearchQuery($array = array()){     
  if (isset($array[0]) && is_string($array[0])) {
//   $strlen = mb_strlen($array[0]);
//   if ($strlen > 3){
//    $this->db->from('site_catalog_search')->where('site_catalog_search.catalogid = site_catalog.id');
//    $this->db->where('MATCH(site_catalog_search.name, site_catalog_search.text, site_catalog_search.catalogid_s) AGAINST ("' . $array[0] . '")', null, false);
//   } else {
    $this->db->from('site_catalog_search')->where('site_catalog_search.catalogid = site_catalog.id');
    $this->db->where("( site_catalog_search.name LIKE '%".$array[0]."%' OR site_catalog_search.catalogid = ".$this->db->escape($array[0]).")", null, false)
            ;
//   }
  }
 }

 protected function __formedSearchQuery($array = array()) {
  if (!empty($array) > 0) {
   $str0 = '';

   $count_a = count($array);

   if ($count_a == 1) $this->db->where("(site_catalog.name_ru LIKE '%{$array[0]}%'")->or_where("site_catalog.shorttext_ru LIKE '%{$array[0]}%'")->or_where("site_catalog.text_ru LIKE '%{$array[0]}%')");
   else {
    for ($i = 0; $i < $count_a; ++$i) {
     if ($i == 0) {
      $str0 .= "(site_catalog.name_ru LIKE '%{$array[$i]}%' OR site_catalog.shorttext_ru LIKE '%{$array[$i]}%' OR site_catalog.text_ru LIKE '%{$array[$i]}%'";
     } elseif ($i == $count_a - 1) {
      $str0 .= " OR site_catalog.name_ru LIKE '%{$array[$i]}%' OR site_catalog.shorttext_ru LIKE '%{$array[$i]}%' OR site_catalog.text_ru LIKE '%{$array[$i]}%')";
     } else {
      $str0 .= " OR site_catalog.name_ru LIKE '%{$array[$i]}%' OR site_catalog.shorttext_ru LIKE '%{$array[$i]}%' OR site_catalog.text_ru LIKE '%{$array[$i]}%' ";
     }
    }
    $this->db->where("{$str0}");
   }
  }
 }
 #end SEARCH region

 public function getCurrency($idis = array()) { return array();
  if (empty($idis)) return array();

  $this->db
          ->select('site_catalog.id, site_catalog.currency,
            site_currency.name, site_currency.id as cur_id,
            `site_catalog`.`price`*`site_currency_koef`.`koef` as price')
          ->from('site_catalog')->from('site_currency')->from('site_currency_koef')
          ->where('site_catalog.currency = site_currency_koef.mainid')
          ->where('site_currency.id = site_currency_koef.curid')
          ->where_in('site_catalog.id', $idis)
          ->order_by('site_currency.id', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $return = array();
  foreach ($res as $one) {
   if (!isset($return[$one['id']])) {
    $return[$one['id']] = array();
    $return[$one['id']][0] = array();
   }

   if (isset($one['currency']) && isset($one['cur_id']) && $one['currency'] == $one['cur_id']) $return[$one['id']][0] = $one;
   else array_push($return[$one['id']], $one);

  }

  return $return;
 }

 public function getBanner($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return array();

  $return = array();

  $res = $this->db->select('image_big, lbid')->from('site_category')->where('id = '.$this->db->escape($id))->where('visible = 1')->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();

  if (empty($res['image_big'])) return array();

  $return['image'] = $res['image_big'];

  $res = $this->db->select('link, name_'.SITELANG.' as name')->from('site_lookbook_cat')->where('id = '.$this->db->escape($res['lbid']))->where('visible = 1')->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();

  $return['link'] = $res['link'];
  $return['name'] = $res['name'];

  return $return;

 }


 #OBJECT PROPERTIES

 public function sofa_isType($id = 0, $data = false) {
  $id = (int)$id;
  if ($id <= 0) return false;

  $res = $this->db->select('id, textile_count')->from('site_sofa_textile_type')->where('id = '.$this->db->escape($id))->limit(1)->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();

  if ($data) return $res['textile_count'];

  return $res['id'];
 }

 public function sofa_getType() {

  $this->db
          ->select('id, image, textile_count, name_'.SITELANG.' as name')
          ->from('site_sofa_textile_type')
          ->where('visible = 1')
          ->order_by('position', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function sofa_isTextileCat($id = 0, $objid = 0) {
  $id = (int)$id;
  $objid = (int)$objid;
  if ($id <= 0) return false;

  $this->db
          ->select('site_sofa_textile_cat.id')
          ->from('site_sofa_textile_cat')
          ->where('site_sofa_textile_cat.id = '.$this->db->escape($id))
          ->limit(1)
          ;

  if ($objid > 0) {
   $this->db
           ->from('site_sofa_textile_cat_catalog')
           ->where('site_sofa_textile_cat.id = site_sofa_textile_cat_catalog.sofa_cat_id')
           ->where('site_sofa_textile_cat_catalog.catalogid = '.$this->db->escape($objid))
           ;

  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res['id'];
 }

 public function sofa_getTextileCatOne($id = 0, $objid = 0) {
  $id = (int)$id;
  $objid = (int)$objid;
  if ($id <= 0 || $objid <= 0) return false;

  $this->db
          ->select('site_sofa_textile_cat.id,
           site_sofa_textile_cat.name_'.SITELANG.' as name,
           site_sofa_textile_cat_catalog.price
          ')
          ->from('site_sofa_textile_cat')->from('site_sofa_textile_cat_catalog')
          ->where('site_sofa_textile_cat.id = site_sofa_textile_cat_catalog.sofa_cat_id')
          ->where('site_sofa_textile_cat_catalog.sofa_cat_id = '.$this->db->escape($id))
          ->where('site_sofa_textile_cat_catalog.catalogid = '.$this->db->escape($objid))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res;
 }

 public function sofa_getTextileCats($objid = 0) {

  $objid = (int)$objid;

  $this->db
          ->select('
           site_sofa_textile_cat.id, site_sofa_textile_cat.image,
           site_sofa_textile_cat.name_'.SITELANG.' as name
          ')
          ->from('site_sofa_textile_cat')
          ->where('site_sofa_textile_cat.visible = 1')
          ->order_by('site_sofa_textile_cat.position', 'ASC')
          ;

  if ($objid > 0) {
   $this->db
           ->select('site_sofa_textile_cat_catalog.price')
           ->from('site_sofa_textile_cat_catalog')
           ->where('site_sofa_textile_cat.id = site_sofa_textile_cat_catalog.sofa_cat_id')
           ->where('site_sofa_textile_cat_catalog.catalogid = '.$this->db->escape($objid))
           ;

  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function sofa_getTextileList($catid = 0) {

  $catid = (int)$catid;

  $this->db
          ->select('site_sofa_textile.id, site_sofa_textile.image')
          ->from('site_sofa_textile')
          ->where('site_sofa_textile.visible = 1')
          ->order_by('site_sofa_textile.position', 'ASC')
          ;

  if ($catid > 0) $this->db->where('site_sofa_textile.catid = '.$this->db->escape($catid));

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function sofa_isTextile($idis = array(), $catid = 0) {
  if (!is_array($idis) || empty($idis)) return false;

  $catid = (int)$catid;

  $this->db
          ->select('id')
          ->from('site_sofa_textile')
          ->where_in('id', $idis)
          ->where('visible = 1')
          ;

  if ($catid > 0) {
   $this->db->where('catid = '.$this->db->escape($catid));
  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 public function sofa_getTextileName($idis = array()) {
  if (!is_array($idis) || empty($idis)) return array();

  $this->db
          ->select('id, name_'.SITELANG.' as name')
          ->from('site_sofa_textile')
          ->where_in('id', $idis)
          ->where('visible = 1')
          ->order_by('position', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $temp = array();
  foreach ($res as $one) {
   $temp[$one['id']] = $one;
  }
  $res = $temp;

  return $res;
 }

 public function sofa_getTextileOne($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return false;

  $this->db
          ->select('site_sofa_textile.id, site_sofa_textile.image,
           site_sofa_textile.image_big, site_sofa_textile.name_'.SITELANG.' as name,
           site_sofa_textile.text_'.SITELANG.' as text,
           site_sofa_textile_cat.name_'.SITELANG.' as cat_name
          ')

          ->from('site_sofa_textile')->from('site_sofa_textile_cat')

          ->where('site_sofa_textile.id = '.$this->db->escape($id))
          ->where('site_sofa_textile.visible = 1')

          ->where('site_sofa_textile_cat.id = site_sofa_textile.catid')

          ->order_by('site_sofa_textile.position', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res;
 }

 #this is the end... */

 #WARDROBE region

 public function wr_isSize($id = 0, $data = false) {
  $id = (int)$id;
  if ($id <= 0) return false;
  $this->db
          ->select('id, price')
          ->from('site_wardrobe_size')
          ->where('id = '.$this->db->escape($id))
          ->where('visible = 1')
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();

  if ($data) return $res;
  return true;
 }

 public function wr_getSizeList() {
  $res = $this->db->select('id, name_'.SITELANG.' as name, image, price')->from('site_wardrobe_size')->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function wr_isType($id = 0, $data = false) {
  $id = (int)$id;
  if ($id <= 0) return false;
  $this->db
          ->select('id, fasade_count, mirror_count')
          ->from('site_wardrobe_type')
          ->where('id = '.$this->db->escape($id))
          ->where('visible = 1')
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();

  if ($data) return $res;
  return true;
 }

 public function wr_getTypes() {
  $res = $this->db->select('id, name_'.SITELANG.' as name, image')->from('site_wardrobe_type')->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function wr_isFasades($idis = array(), $data = false) {
  if (!is_array($idis) || empty($idis)) return false;

  $this->db
          ->select('id')
          ->from('site_wardrobe_fasade')
          ->where_in('id', $idis)
          ->where('visible = 1')
          ;

  if ($data) {
   $this->db
           ->select('name_'.SITELANG.' as name, price')
           ->order_by('id', 'ASC')
           ;

  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;

  if ($data) {
   $res = $res->result_array();
   return $res;
  }

  return true;
 }

 public function wr_getFasades() {
  $res = $this->db->select('id, name_'.SITELANG.' as name, image')->from('site_wardrobe_fasade')->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function wr_getFasadeOne($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return false;

  $this->db
          ->select('id, name_'.SITELANG.' as name, image, image_big, price')
          ->from('site_wardrobe_fasade')
          ->where('visible = 1')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res;
 }

 public function wr_isMirrors($idis = array(), $data = false) {
  if (!is_array($idis) || empty($idis)) return false;

  $this->db
          ->select('id')
          ->from('site_wardrobe_mirror')
          ->where_in('id', $idis)
          ->where('visible = 1')
          ;

  if ($data) {
   $this->db
           ->select('name_'.SITELANG.' as name, price')
           ->order_by('id', 'ASC')
           ;

  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;

  if ($data) {
   $res = $res->result_array();
   return $res;
  }

  return true;
 }

 public function wr_getMirrors() {
  $res = $this->db->select('id, name_'.SITELANG.' as name, image')->from('site_wardrobe_mirror')->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function wr_getMirrorsOne($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return false;

  $this->db
          ->select('id, name_'.SITELANG.' as name, image, image_big, price')
          ->from('site_wardrobe_mirror')
          ->where('visible = 1')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res;
 }

 public function wr_isCorpuses($idis = array(), $data = false) {
  if (!is_array($idis) || empty($idis)) return false;

  $this->db
          ->select('id')
          ->from('site_wardrobe_corpus')
          ->where_in('id', $idis)
          ->where('visible = 1')
          ;

  if ($data) {
   $this->db
           ->select('name_'.SITELANG.' as name, price')
           ->order_by('id', 'ASC')
           ;

  }

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;

  if ($data) {
   $res = $res->result_array();
   return $res;
  }

  return true;
 }

 public function wr_getCorpuses() {
  $res = $this->db->select('id, name_'.SITELANG.' as name, image')->from('site_wardrobe_corpus')->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function wr_getCorpusesOne($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return false;

  $this->db
          ->select('id, name_'.SITELANG.' as name, image, image_big, price')
          ->from('site_wardrobe_corpus')
          ->where('visible = 1')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res;
 }


 public function wr_isByID($id = '') {
  $id = (int)$id;
  if ($id <= 0) return false;

  $this->db
          ->select('id')
          ->from('site_wardrobe_size')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 public function wr_getPrice($objectid = 0) {
  $objectid = (int)$objectid;
  if ($objectid <= 0) return 0;

  $this->db
          ->select('price')
          ->from('site_wardrobe_size')
          ->where('id = '.$this->db->escape($objectid))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['price'];
 }

 #this is the end... */

 //*Kithecn region
 public function k_isDesktop($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return false;

  $res = $this->db->select('id')->from('site_kitchen_destop')->where('id = '.$this->db->escape($id))->where('visible = 1')->limit(1)->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 public function k_getDesktop($idis = array()) {
  $this->db
          ->select('id, name_'.SITELANG.' as name, image, price, in_stock')
          ->from('site_kitchen_destop')
          ->where('visible = 1')
          ->where('in_stock = 1')
          ->order_by('position', 'ASC')
          ;

  if (is_array($idis) && !empty($idis)) $this->db->where_in('id', $idis);

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  if (is_array($idis) && !empty($idis)) {
   $return = array();

   foreach ($res as $one) {
    $return[$one['id']] = $one;
   }

   $res = $return;
  }

  return $res;
 }
 #this is the end...
 //*/

 public function is_color($id = 0, $objectid = 0, $field = 'color') {
  $id = (int)$id;
  $objectid = (int)$objectid;
  $field = parent::prepareDataString($field);
  if ($id <= 0 || $objectid <= 0 || empty($field)) return false;

  parent::select_lang('name');
  $this->db
          ->select('id, field, link, image, color')
          ->from('site_catalog_filters')
          ->where('field = '.$this->db->escape($field))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();

  $this->db
          ->select('site_catalog_filters.id')
          ->from('site_catalog_filters')->from('site_catalog_filters_catalog')
          ->where('site_catalog_filters.id = site_catalog_filters_catalog.filter_id')
          ->where('site_catalog_filters.parent_id = '.$this->db->escape($res['id']))
          ->where('site_catalog_filters.visible = 1')
          ->where('site_catalog_filters.id = '.$this->db->escape($id))
          ->where('site_catalog_filters_catalog.catalog_id = '.$this->db->escape($objectid))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 public function get_colors($objectid = 0, $field = 'color') {
  $objectid = (int)$objectid;
  $field = parent::prepareDataString($field);
  if ($objectid <= 0 || empty($field)) return array();

  $return = array();

  parent::select_lang('name');
  $this->db
          ->select('id, field, link, image, color')
          ->from('site_catalog_filters')
          ->where('field = '.$this->db->escape($field))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $return = $res->row_array();

  parent::select_lang('site_catalog_filters.name');
  $this->db
          ->select('site_catalog_filters.id, site_catalog_filters.color')
          ->from('site_catalog_filters')->from('site_catalog_filters_catalog')
          ->where('site_catalog_filters.id = site_catalog_filters_catalog.filter_id')
          ->where('site_catalog_filters.parent_id = '.$this->db->escape($return['id']))
          ->where('site_catalog_filters.visible = 1')
          ->where('site_catalog_filters_catalog.catalog_id = '.$this->db->escape($objectid))
          ->order_by('site_catalog_filters.position', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $return['children'] = $res->result_array();
  return $return;
 }

 #COMPONENTS

 public function comp_isComponent($objectid = 0, $id = 0) {
  $objectid = (int)$objectid;
  $id = (int)$id;
  if ($objectid <= 0 || $id <= 0) return false;

  $this->db
          ->select('id')
          ->from('site_catalog')
          ->where('id = '.$this->db->escape($id))
          ->where('parentid = '.$this->db->escape($objectid))
          ->where('visible = 1')
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 public function comps_get($objectid = 0, $idis = array()) {
  $objectid = (int)$objectid;
  if ($objectid <= 0) return array();

  $this->formedStandartSelect();
  $this->db
          ->where('site_catalog.parentid = '.$this->db->escape($objectid))
          ->where('site_catalog.visible = 1')
          ->where('site_catalog.in_stock = 1')
          ;

  if (is_array($idis) && !empty($idis)) $this->db->where_in('id', $idis);

  $this->formedCatalogParamatterSortQuery(array('sort' => array('default')));

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  if (is_array($idis) && !empty($idis)) {

   $_temp = array();
   foreach ($res as $one) {
    $_temp[$one['id']] = $one;
   }
   $res = $_temp;

  } else {

   foreach ($res as &$one) {
    $image = $one['image'];
    $one['image'] = 'images/'.$one['id'].'/mainimg/'.parent::image_to_ext($image, '_dis');
   } unset($one);

  }

  return $res;
 }

 #this is the end... */

 #FILTERS

 public function filters_get_parent($as_array = false) {
  parent::select_lang('name');
  $this->db
          ->select('id, field, link')
          ->from('site_catalog_filters')
          ->where('field <> ""')
          ->order_by('position', 'ASC')
          ;

  $parent = $this->db->get();
  if ($parent->num_rows() <= 0) return array();
  $parent = $parent->result_array();

  if ($as_array) {
   $temp = array();
   foreach ($parent as $one) array_push($temp, $one['field']);
   return $temp;
  }

  return $parent;
 }

 public function filter_get_parent_field_by_type($type) {
  if (is_null($type) || empty($type)) return array();

  $this->db
          ->select('field')
          ->from('site_catalog_filters')
          ->where('type <> '.$this->db->escape($type))
          ->order_by('position', 'ASC')
          ;

  $parent = $this->db->get();
  if ($parent->num_rows() <= 0) return array();
  $parent = $parent->result_array();

  $return = array();
  foreach ($parent as $one) array_push($return, $one['field']);

  return $return;
 }

 public function filters_get_valid_array($param = '') {
  $this->db
          ->select('id')
          ->from('site_catalog_filters')
          ->where('field = '.$this->db->escape($param))
          ->limit(1)
          ;

  $_id = $this->db->get();
  if ($_id->num_rows() <= 0) return array();
  $_id = $_id->row_array();

  $this->db
          ->select('link')
          ->from('site_catalog_filters')
          ->where('parent_id = '.$this->db->escape($_id['id']))
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $return = array();
  foreach ($res as $one) array_push($return, $one['link']);
  return $return;
 }


 public function filters_get_valid_type($param = '') {
  $this->db
          ->select('type')
          ->from('site_catalog_filters')
          ->where('field = '.$this->db->escape($param))
          ->limit(1)
          ;

  $type = $this->db->get();
  if ($type->num_rows() <= 0) return false;
  $type = $type->row_array();
  return $type['type'];
 }

 public function filters_get_all_for_view($cat_idis = array(), $param_array = array()) {
  


  parent::select_lang('site_catalog_filters.name, site_catalog_filters.name_short');
  $this->db
          ->select('site_catalog_filters.id, site_catalog_filters.field, site_catalog_filters.link')
          ->from('site_catalog_filters')
          ->where('site_catalog_filters.parent_id = 0')
          ->where('site_catalog_filters.visible = 1')
          ->order_by('site_catalog_filters.position', 'ASC')
          ;

  if (is_array($cat_idis) && !empty($cat_idis)) {
   $this->db
           ->from('site_catalog_filters_category')
           ->where('(site_catalog_filters.id = site_catalog_filters_category.filter_id OR site_catalog_filters.field = "price")')
           ->where_in('site_catalog_filters_category.category_id', $cat_idis)
           ->group_by('site_catalog_filters.id')
           ;
  }

  $parent = $this->db->get();
  if ($parent->num_rows() <= 0) return array();
  $parent = $parent->result_array();

  parent::select_lang('site_catalog_filters.name, site_catalog_filters.name_short');
  $this->db
          ->select('site_catalog_filters.id, site_catalog_filters.parent_id, site_catalog_filters.field, site_catalog_filters.link, site_catalog_filters.image, site_catalog_filters.color')
          ->from('site_catalog_filters')->from('site_catalog_filters_catalog')
          ->where('site_catalog_filters.id = site_catalog_filters_catalog.filter_id')
          ->where('site_catalog_filters.parent_id <> 0')
          ->where('site_catalog_filters.visible = 1')
          ->order_by('site_catalog_filters.position', 'ASC')
          ->group_by('site_catalog_filters.id')
          ;

  if (is_array($cat_idis) && !empty($cat_idis)) {
   $this->db
           ->from('site_catalog_category')
           ->where('site_catalog_filters_catalog.catalog_id = site_catalog_category.catalogid')
           ->where_in('site_catalog_category.categoryid', $cat_idis)
           ->group_by('site_catalog_filters.id')
           ;
  }

  $child = $this->db->get();
  if ($child->num_rows() <= 0) return $parent;
  $child = $child->result_array();

  $return = array();

  $this->load->library('filter_lib');

  foreach ($parent as $one) {
   $one['children'] = array();

   foreach ($child as $two) {
    if ($one['id'] == $two['parent_id']) {
     $two['linker'] = $this->filter_lib->change($param_array, array('key' => $one['field'], 'link' => $two['link']));
     array_push($one['children'], $two);
    }
   }

   array_push($return, $one);
  }

  return $return;
 }

 public function select_cat_id($cat){
  $this->db->select('id')->where('link', $cat[0])->from('site_category');
  $res = $this->db->get();
  if($res->num_rows() <= 0) return false;
  $res = $res->result_array();
  return $res[0]['id'];
 }

 public function get_all_cats() {
  $this->db->select('*')->where('parentid', 6)->from('site_category');
  $res = $this->db->get();
  if($res->num_rows() <= 0) return false;
  $res = $res->result_array();
  $idis = [];
  foreach ($res as $value) {
    $idis[] = $value['id'];
  }unset($value);
  return $idis;
 }

 public function filters_get_one_for_view($parametter = '', $param_array = array()) {
  if (empty($parametter)) return array();

  parent::select_lang('site_catalog_filters.name');
  $this->db
          ->select('site_catalog_filters.id, site_catalog_filters.field, site_catalog_filters.link')
          ->from('site_catalog_filters')
          ->where('site_catalog_filters.parent_id = 0')
          ->where('site_catalog_filters.field = '.$this->db->escape($parametter))
          ->limit(1)
          ;

  $parent = $this->db->get();
  if ($parent->num_rows() <= 0) return array();
  $parent = $parent->row_array();

  parent::select_lang('site_catalog_filters.name');
  $this->db
          ->select('site_catalog_filters.id, site_catalog_filters.parent_id, site_catalog_filters.field, site_catalog_filters.link, site_catalog_filters.image, site_catalog_filters.color')
          ->from('site_catalog_filters')
          ->where('site_catalog_filters.parent_id = '.$this->db->escape($parent['id']))
          ->where('site_catalog_filters.visible = 1')
          ->order_by('site_catalog_filters.position', 'ASC')
          ;

  $child = $this->db->get();
  if ($child->num_rows() <= 0) $child = array();
  else $child = $child->result_array();

  foreach ($child as &$one) {
   $one['linker'] = $this->filter_lib->change($param_array, array('key' => $parent['field'], 'link' => $one['link']));
  } unset($one);
  $parent['children'] = $child;

  return $parent;
 }

 public function filters_get_by_id($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return array();

  parent::select_lang('name');
  $this->db
          ->select('id, parent_id, field, link, image, color')
          ->from('site_catalog_filters')
          ->where('id = '.$this->db->escape($id))
          ->where('visible = 1')
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function filters_get_all_for_db($not_array = array()) {

  $this->db
          ->select('id, field')
          ->from('site_catalog_filters')
          ->where('field <> ""')
          ->order_by('position', 'ASC')
          ;

  if (is_array($not_array) && !empty($not_array)) $this->db->where_not_in('field', $not_array);

  $parent = $this->db->get();
  if ($parent->num_rows() <= 0) return array();
  $parent = $parent->result_array();

  $this->db
          ->select('id, parent_id, link')
          ->from('site_catalog_filters')
          ->where('field = ""')
          ->where('visible = 1')
          ->order_by('position', 'ASC')
          ;

  $child = $this->db->get();
  if ($child->num_rows() <= 0) $child = array();
  else $child = $child->result_array();

  $return = array();

  foreach ($parent as $one) {
   $return[$one['field']] = array();

   foreach ($child as $two) {
    if ($one['id'] == $two['parent_id']) {
     $return[$one['field']][$two['link']] = $two['id'];
    }
   }

  }

  return $return;
 }

 public function filters_get_default() {
  $this->db
          ->select('site_catalog_filters.link')
          ->select('scf.field as field')

          ->from('site_catalog_filters')

          ->where('site_catalog_filters.visible = 1')
          ->where('site_catalog_filters.default = 1')

          ->order_by('site_catalog_filters.position', 'ASC')

          ->join('site_catalog_filters as scf', 'site_catalog_filters.parent_id = scf.id', 'left')

          ->group_by('site_catalog_filters.parent_id')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $return = array();
  foreach ($res as $one) {
   $return[$one['field']] = array($one['link']);
  }
  return $return;
 }

 public function filter_get_by_products($idis) {
  if (!is_array($idis) || empty($idis)) return array();

  parent::select_lang('site_catalog_filters.name, scf.name as parent_name');
  $this->db
          ->select('scf.id, site_catalog_filters.filter-vis, scf.class, site_catalog_filters.class as class_new, scf.classid, site_catalog_filters.classid as classid_new, site_catalog_filters_catalog.catalog_id,'
      . ' site_catalog_filters.position,'
      . 'site_catalog_filters.parent_id, site_catalog_filters.image, site_catalog_filters.name_icon')
          ->from('site_catalog_filters')

          ->join('site_catalog_filters_catalog',
                 'site_catalog_filters.id = site_catalog_filters_catalog.filter_id 
                 AND site_catalog_filters_catalog.catalog_id IN ('.implode(',', $idis).')',
                 'left'
                )

          ->join('site_catalog_filters as scf',
                 'site_catalog_filters.parent_id = scf.id AND scf.visible = 1',
                 'left'
                )


          ->where('site_catalog_filters.filter-vis', 1)
          ->where('site_catalog_filters.parent_id > 0')
          ->where('site_catalog_filters.visible', 1)

          ->order_by('site_catalog_filters_catalog.catalog_id', 'DESC')
          //->order_by('site_catalog_filters.parent_id', 'DESC')
          ->order_by('scf.name_ru', 'DESC')
          //->order_by('site_catalog_filters.id', 'ASC')
          //->order_by('site_catalog_filters_catalog.filter_id', 'ASC')
          //->order_by('site_catalog_filters.name_ru', 'ASC')

          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $return = array();

  foreach ($res as $one) {
   if (isset($one['catalog_id']) && $one['catalog_id'] > 0) {
    if (!isset($return[$one['catalog_id']])) $return[$one['catalog_id']] = array();

    if (!isset($return[$one['catalog_id']][$one['id']])) {
     $return[$one['catalog_id']][$one['id']] = $one;
    } else {
     $return[$one['catalog_id']][$one['id']]['name'] .= ', '.$one['name'];
    }
   }
  }  

  return $return;
 }

 #end

 #size table

 public function getFilterObjectOne($id){
  $id = (int)$id;
  if($id <= 0) return false;

  $this->db->select('')
  ->from('site_catalog_filters_catalog')->from('site_catalog_filters')
  ->where('site_catalog_filters_catalog.catalog_id', $id)
  ->where('site_catalog_filters_catalog.filter_id = site_catalog_filters.id')
  ->where('site_catalog_filters.filter-vis', 1) // new filters ===================//////
  ->order_by('site_catalog_filters.position', 'asc')
  ;
    $res = $this->db->get();

    if($res->num_rows() <= 0) return false;
    $res = $res->result_array();

    $idis= [];
    foreach($res as $key => $value){
      $idis[] = $value['parent_id'];
    } unset($value);

    $result = $this->selectObjects($idis);

    // ---------- new

    $i = 0; foreach($result as $key => $value){
      $result[$i] = $this->getAllObjects($value['id'], $id);
      $i++;
    } unset($value);

    // echo "<pre>"; print_r($result); die();

    return $result;
 }
 public function selectObjects($id){
  $res = $this->db->select('name_'.SITELANG.' as name, position, id, parent_id')
  ->where_in('site_catalog_filters.id', $id)
  ->order_by('position', 'asc')
  ->from('site_catalog_filters')->get();

  if($res->num_rows() <= 0) return false;
    $res = $res->result_array();
  return $res;
 }

 public function getAllObjects($id = 0, $id_where = 0){
  if($id <= 0 && $id_where <= 0) return false;

  $this->db->select('')
  ->from('site_catalog_filters_catalog')
                ->from('site_catalog_filters')
                ->where('site_catalog_filters_catalog.catalog_id', $id_where)
                ->where('site_catalog_filters_catalog.filter_id = site_catalog_filters.id')
                ->where('site_catalog_filters.parent_id', $id)
                ;


    $res =  $this->db->get();
    if($res->num_rows() <= 0) return false;
    $res = $res->result_array();
    return $res[0]['name_ru'];
 }

 public function is_size_table_by_cat($catid = 0) {
  $catid = (int)$catid;
  if ($catid <= 0) return false;

  $this->db
          ->select('site_size_table.id')

          ->from('site_size_table')

          ->where('site_size_table.catid = '.$this->db->escape($catid))
          ->where('site_size_table.visible = 1')

          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 public function get_size_table($catid = 0, $objectid = 0) {
  $catid = (int)$catid;
  $objectid = (int)$objectid;
  if ($catid <= 0 || $objectid <= 0) return array();

  $this->db
          ->select('site_size_table.id, site_size_table.eur, site_size_table.uk,
            IF (site_size_object.cm IS NULL, site_size_table.cm, site_size_object.cm) as cm
           ', false)

          ->from('site_size_table')

          ->join('site_size_object', 'site_size_table.id = site_size_object.size_table_id AND site_size_object.object_id = '.$this->db->escape($objectid), 'left')

          ->where('site_size_table.catid = '.$this->db->escape($catid))
          ->where('site_size_table.visible = 1')

          ->order_by('site_size_table.position', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function color_get_by_product($idis) {
  if (!is_array($idis) || empty($idis)) return array();

  parent::select_lang('site_color.name');
  $this->db
          ->select('site_color.id, site_color.image, site_color_catalog.catalogid')

          ->from('site_color')->from('site_color_catalog')

          ->where('site_color.id = site_color_catalog.colorid')
          ->where('site_color.visible = 1')
          ->where_in('site_color_catalog.catalogid', $idis)

          ->order_by('site_color_catalog.catalogid', 'ASC')
          ->order_by('site_color.position', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $return = array();

  foreach ($res as $one) {

   if (!isset($return[$one['catalogid']])) $return[$one['catalogid']] = array();

   array_push($return[$one['catalogid']], $one);

  }

  return $return;
 }

 public function get_color_products($product_id) {
  $product_id = (int)$product_id;
  if ($product_id <= 0) return array();

  parent::select_lang('site_color.name');
  $this->db
          ->select('site_catalog.id, site_catalog.link, site_color.color')
          ->from('site_catalog')->from('site_color')->from('site_color_catalog')
          ->where('site_color_catalog.main_id', $product_id)
          ->where('site_catalog.id = site_color_catalog.catalogid')
          ->where('site_color.id = site_color_catalog.colorid')
          ->order_by('site_color_catalog.id', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  $this->load->model('menu_model');
  foreach($res as &$one){
      $one['links'] = $this->menu_model->getObjectCategories($one['id']);
  }
  return $res;
 }

 #this is the end... */

 #USER-CATALOG region

 public function is_catalog_fav($user_id = 0, $object = 0) {
  $user_id = (int)$user_id;
  $object = (int)$object;
  if ($user_id <= 0 || $object <= 0) return false;

  $this->db
          ->select('id')
          ->from('auth_users_catalog_favorite')
          ->where('user_id = '.$this->db->escape($user_id))
          ->where('catalog_id = '.$this->db->escape($object))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 public function get_catalog_by_user_fav_count($user_id = 0) {
  $user_id = (int)$user_id;
  if ($user_id <= 0) return 0;

  $this->db
          ->select('COUNT(*) as count')
          ->from('auth_users_catalog_favorite')
          ->where('auth_users_catalog_favorite.user_id = '.$this->db->escape($user_id))
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['count'];
 }

 public function get_catalog_by_user_fav($user_id = 0, $page = 1, $count = 0) {
  $user_id = (int)$user_id;
  $page = (int)$page;
  $count = (int)$count;
  if ($user_id <= 0 || $page <= 0 || $count <= 0) return array();

  if ($page == 1) $page = 0;
  else $page = ($page * $count) - $count;

  $this->formedStandartSelect();
  $this->db
          ->from('auth_users_catalog_favorite')
          ->where('auth_users_catalog_favorite.catalog_id = site_catalog.id')
          ->where('auth_users_catalog_favorite.user_id = '.$this->db->escape($user_id))
          ->limit($count, $page)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function get_catalog_by_user_visited($user_id = 0) {
  $user_id = (int)$user_id;
  if ($user_id <= 0) return array();

  $this->formedStandartSelect();
  $this->db
          ->from('auth_users_catalog_last_see')
          ->where('auth_users_catalog_last_see.catalog_id = site_catalog.id')
          ->where('auth_users_catalog_last_see.user_id = '.$this->db->escape($user_id))
          ->order_by('auth_users_catalog_last_see.datetime', 'DESC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 #this is the end... */

 #product view

 public function get_product_view() {
  parent::select_lang('name');
  $res = $this->db->select('id, link, view, position')->from('site_catalog_view')->where('visible', 1)->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function get_product_on_view($link) {
  $link = parent::prepareDataString($link);
  parent::select_lang('name');
  $res = $this->db->select('id, link, view')->from('site_catalog_view')->where('link', $link)->where('visible', 1)->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function get_video($id){
  $res = $this->db->select('id, video')->from('site_catalog')->where('id', $id)->get();
  if($res->num_rows() <= 0) return false;
  $res = $res->result_array();
  return $res;
 }

 public function get_product_warranty() {
  parent::select_lang('name');
  $res = $this->db->select('id')->from('site_catalog_warranty')->where('visible', 1)->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 #end - product view

 #favorite

 public function up_favorite($product_id, $up = true) {
  $product_id = (int)$product_id;
  $up = (bool)$up;
  if ($product_id <= 0) return false;

  $res = $this->db->select('favorite_count')->from('site_catalog')->where('id', $product_id)->where('visible', 1)->limit(1)->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();

  $count = (int)$res['favorite_count'];
  if ($up && $count < PHP_INT_MAX - 10) {
   ++$count;
  } elseif ($count > 0) {
   --$count;
  }

  $this->db->set('favorite_count', $count)->where('id', $product_id)->update('site_catalog');

  return $count;
 }

 public function selectThisPtoho($id){
  $this->db->select('*')->where('catalogid', $id)->from('site_catalog_image');
  $res = $this->db->get();
  if($res->num_rows() <= 0) return false;
  $res = $res->result_array();
  return $res;
 }

  public function selectThisChar($id){
  $this->db->select('id, features_ru')->where('id', $id)->from('site_catalog');
  $res = $this->db->get();
  if($res->num_rows() <= 0) return false;
  $res = $res->result_array();
  return $res;
 }

 public function selectAcc($id = 0) {
  $res = $this->db->select('*')->from(' site_catalog_accessories')->where('main_id', $id)->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->result_array();
  return $res;

}

  // ++ ----------------------- paket ---------

  public function updatePaket($cat = 0, $id = 0){
    if(!isset($cat) && empty($cat) && $cat <= 0) return false;
    if(!isset($id) && empty($id) && $id <= 0) return false;
    $cat = (int)$cat;
    $id = (int)$id;

    $res = $this->db->select('')
    ->where('site_paket_option_catalog.categoryid', $cat)
    ->where('site_paket_option_catalog.mainid', $id)
    // ->order_by('site_paket_option_catalog.position', 'ASC')
    ->from('site_paket_option_catalog')->get();

    if($res->num_rows() <= 0) return false;
    $res = $res->result_array();

    foreach($res as $key => $value){
      $idis[] = $value['catalogid'];
    } unset($value);

    $result_idis_array = $this->selectPaketOptionID($idis);

    foreach($result_idis_array as $key => $value){
      $return['name'] = $this->getThisPaketName($cat, $id);
      $return['share'][$key] = $this->getUpdatePaketQuery($value['id']);
      $return['share'][$key]['children'] = $this->getChildrenPaketsID($value['id']);
    } unset($value);
    
    return $return;
  }
  public function getThisPaketName($cat, $id) {
    if(!isset($cat) && empty($cat) && $cat <= 0) return false;
    if(!isset($id) && empty($id) && $id <= 0) return false;
    $cat = (int)$cat;
    $id = (int)$id;

    $res = $this->db->select('site_paket_option_category.name_'.SITELANG.' as name')
    ->where('site_paket_option_category.id', $cat)
    ->from('site_paket_option_category')->limit(1)->get();

    if($res->num_rows() <= 0) return false;
    $res = $res->row_array();

    return $res['name'];
  }
  public function selectPaketOptionID($array = array()){
    if($array <= 0) return false;

    $res = $this->db->select('*')->where_in('site_paket_option.id', $array)
    ->order_by('site_paket_option.position', 'ASC')
    ->from('site_paket_option')->get();

    if($res->num_rows() <= 0) return false;
    $res = $res->result_array();

    return $res;
  }
  private function getUpdatePaketQuery($id){
    if($id <= 0) return false;

    $res = $this->db->select('site_paket_option.id, site_paket_option.name_ru as name, site_paket_option.price, site_paket_option.position')
    ->where('site_paket_option.id', $id)
    ->order_by('site_paket_option.position', 'ASC')
    ->from('site_paket_option')->limit(1)->get();

    if($res->num_rows() <= 0) return false;
    $res = $res->row_array();

    $res2 = $this->db->select('site_catalog.id')->where('site_catalog.paket_option', $id)
    ->order_by('site_catalog.position', 'ASC')
    ->from('site_catalog')->limit(1)->get();

    //if($res2->num_rows() <= 0) return $res[0];
    if($res2->num_rows() <= 0) return false;
    $res['ID'] = $res2->row_array()['id'];

    return $res;
  }
  private function getChildrenPaketsID($id){
    if(!isset($id) && empty($id)) return false;
    $id = (int)$id;

    $res = $this->db
                    ->select('site_pakets.id, site_pakets.name_'.SITELANG.' as name, site_pakets.image,
                      site_pakets_ccatalog.position')
                    ->where('site_pakets_ccatalog.main_id', $id)
                    ->where('site_pakets_ccatalog.catalog_id = site_pakets.id')
                    ->where('site_pakets.visible', 1)
                    ->order_by('site_pakets_ccatalog.position', 'ASC')
                    ->from('site_pakets_ccatalog')->from('site_pakets')
                    ->get();

    if($res->num_rows() <= 0) return false;
    $res = $res->result_array();

    return $res;
  }

  // =========================== AJAX ================

  public function getOneOption($id){
    if($id <= 0) return false;

    $res = $this->db->select('*')->where('site_paket_option.id', $id)->limit(1)
    ->from('site_paket_option')->get();

    if($res->num_rows() <= 0) return false;
    $res = $res->row_array();

    $result = $this->db->select('*')->where('site_catalog.paket_option', $res['id'])->limit(1)
    ->from('site_catalog')->get();

    if($result->num_rows() <= 0) return false;
    $result = $result->row_array();
    $res['option'] = $result['id'];

    return $res;
  }

  public function getOptionObject($id){
    if(!isset($id) && empty($id) && $id <= 0) return false;
    $id = (int)$id;

    $res = $this->db->select('site_paket_option_catalog.id')->where('site_paket_option_catalog.mainid', $id)->from('site_paket_option_catalog')->get();
    
    if($res->num_rows() <= 0) return false;
    $res = $res->result_array();

    return $res;
  }

  public function selectComments($id){
    if(!isset($id) && empty($id) && $id <= 0) return false;
    $id = (int)$id;

    $res = $this->db->select('site_comment.id')->where('site_comment.id_catalog', $id)->from('site_comment')->get();
  
    if($res->num_rows() <= 0) return false;
    $res = $res->result_array();

    return $res;
  }

  public function AjaxGetNextComments($page, $id){
    if(!isset($id) && empty($id)) return false;
    $id = (int)$id;
    if($id <= 0) return false;

    return $data = $this->getProductComments($id, $page, $count = 12);
  }

  public function getCategoryForProduct($id){
    $res = $this->db->select('*')->where('site_catalog_category.catalogid', $id)->from('site_catalog_category')
    ->limit(1)
    ->get();

    if($res->num_rows() <= 0) return false;
    $res = $res->result_array();

    foreach($res as $key => $value){
        $res['link'] = $this->db->select('*')->where('id', $value['categoryid'])->from('site_category')->limit(1)->get()->row_array()['link'];
    } unset($value);

    return $res['link'];
  }

  public function get_catalog_category($id){
        if(!isset($id) && empty($id) && $id <= 0) return false;
        $id = (int)$id;

        $res = $this->db->select('*')->where('site_catalog_category.catalogid', $id)
        ->where('site_category.id = site_catalog_category.categoryid')
        ->from('site_catalog_category')->from('site_category')->get();

        if($res->num_rows() <= 0) return false;
        $res = $res->row_array();

        return $res['link'];
       }

       public function get3G($id){
        if(!isset($id) && empty($id) && $id <= 0) return false;
        $id = (int)$id;

        $res = $this->db->select('site_catalog.3g')->where('site_catalog.id', $id)->from('site_catalog')->limit(1)->get();

        if($res->num_rows() <= 0) return false;
        $res = $res->row_array();

        return $res['3g'];
       }

       public function getVideo($id) {
        if(!isset($id) && empty($id) && $id <= 0) return false;
        $id = (int)$id;

        $res = $this->db
                        ->select('site_video.text_'.SITELANG.' as text')
                        ->where('site_video.catalogid', $id)
                        ->order_by('site_video.id', 'ASC')
                        ->from('site_video')
                        ->get();

          if($res->num_rows() <= 0) return false;
          $res = $res->result_array();

          return $res;
       }

       public function getCartCatalog() {
        $res = $this->db->select('')->where('site_catalog.show_cart', 1)->where('site_catalog.visible', 1)->from('site_catalog')->get();
        if($res->num_rows() <= 0) return false;
        $res = $res->result_array();

        return $res;
       }

}
