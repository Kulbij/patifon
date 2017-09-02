<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Menu_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }

 public function is($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return false;
  $res = $this->db->select('site_category.id')->from('site_category')->where('site_category.visible = 1')->where("site_category.id = ".$this->db->escape($categoryid))->limit(1)->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }
 public function geturl($url = ''){
  $this->db->select('id, link')->where_in('link', $url)->from('site_category');
  $res = $this->db->get();
  if($res->num_rows <= 0) return false;
  $res = $res->result_array();
  return $res;
 }
 public function selectCategory($cat = array(), $catid = array()){
  if(!isset($cat) && empty($cat)) return false;
  $catid = (int)$catid;

  $this->db->select('*');
  if(isset($catid) && !empty($catid)) {
    if($catid == '1'){
      $this->db->where('parentid2', $catid);
    } else {
      $this->db->where('parentid', $catid);
    }
  }
    $res = $this->db->from('site_category')->get();
  if($res->num_rows() <= 0) return false;
  $res = $res->result_array();
  return $res;
 }
 public function selectthiscat($id){
  $this->db->select('id, name_ru')->where('id', $id)->from('site_category');
  $res = $this->db->get();
  if($res->num_rows() <= 0) return false;
  $res = $res->result_array();
  return $res;
 }
 public function selectprevcat($id){
  $this->db->select('*')->where('id', $id)->from('site_category');
  $res = $this->db->get();
  if($res->num_rows() <= 0) return false;
  $res = $res->result_array();

  $res = $res[0]['parentid2'];

  $this->db->select('id, name_ru, link')->where('id', $res)->from('site_category');
  $res2 = $this->db->get();
  if($res2->num_rows() <= 0) return false;
  $res2 = $res2->result_array();

  return $res2;
 }
 public function getObjectCategories($objid = 0){
     if((int)$objid == 0){
         return false;
     }     
     $main = $this->db->select('link, parentid')
             ->from('site_category')
             ->join('site_catalog_category','site_catalog_category.categoryid = site_category.id')
             ->where('site_catalog_category.catalogid',$objid)
             ->where('main',1)
             ->limit(1)
             ->get()
             ->row_array();   
     $parent = $this->db->select('link')
            ->from('site_category')
             ->where('site_category.id',$main['parentid'])
             ->limit(1)
             ->get()
             ->row_array();     
     return array('categorylink' => $main['link'], 'parentcategorylink' => isset($parent['link'])?$parent['link']:'' );
 }
 public function getParentLink($categoryid = 0){
     $res = $this->db->select('parentid')
             ->from('site_category')
             ->where('id',$categoryid)
             ->limit(1)
             ->get()
             ->row_array();
     if(!isset($res['parentid']) || (int)$res['parentid'] <=  0){
         return '';
     }         
     $res = $this->db->select('link')
             ->from('site_category')
             ->where('id',$res['parentid'])
             ->get()
             ->row_array();
     return $res['link'];
 }
 public function isParentLink($categorylink = ''){
     if (empty($categorylink)) return false;
  $categorylink = parent::prepareDataString($categorylink);
  $res = $this->db->select('site_category.id')
          ->from('site_category')
          ->where('site_category.visible = 1')
          ->where('link', $categorylink)->limit(1)->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res['id'];
 }
 public function isLink($categorylink = '') {
  if (empty($categorylink)) return false;
  $categorylink = parent::prepareDataString($categorylink);
  $res = $this->db->select('site_category.id')->from('site_category')->where('site_category.visible = 1')->where("site_category.link = ".$this->db->escape($categorylink))->limit(1)->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res['id'];
 }
public function isSubLink($categorylink = '', $subcategorylink) {
  if (empty($categorylink)) return false;
  if (empty($subcategorylink)) return false;
  $categorylink = parent::prepareDataString($categorylink);
  $subcategorylink = parent::prepareDataString($subcategorylink);
  
  $res = $this->db->select('site_category.id')->from('site_category')->where('site_category.visible = 1')->where("site_category.link = ".$this->db->escape($categorylink))->limit(1)->get();
  
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  
  $res_sub = $this->db->select('site_category.id')
          ->from('site_category')
          ->where('site_category.visible = 1')
          ->where("site_category.link = ".$this->db->escape($subcategorylink))
          ->where('parentid',$res['id'])
          ->limit(1)
          ->get();
  
  if ($res_sub->num_rows() <= 0) return false;
  $res_sub = $res_sub->row_array();
  return $res_sub['id'];
 }
 public function haveParent($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return false;
  $res = $this->db->select('site_category.parentid')->from('site_category')->where('site_category.visible = 1')->where("site_category.id = ".$this->db->escape($categoryid))->limit(1)->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  if ($res['parentid'] <= 0) return false;
  return true;
 }

 public function getFirstCatLink() {
  $this->db
          ->select('link')
          ->from('site_category')
          ->where('visible = 1')
          ->order_by('position', 'ASC')
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['link'];
 }

 public function getParentFirst($catid = 0, $ret_array = false) {
  $temp = $catid = (int)$catid;
  if ($catid <= 0 && $ret_array) return array();
  elseif ($catid <= 0) return 0;

  $return = array();
  while ($temp > 0) {
   $catid = $temp;
   if ($ret_array) $return[] = $catid;
   $temp = $this->getParent($catid);
  }

  if ($ret_array) return $return;
  else return $catid;
 }

 public function getParent($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return 0;
  $res = $this->db->select('site_category.parentid')->from('site_category')->where('site_category.visible = 1')->where("site_category.id = ".$this->db->escape($categoryid))->limit(1)->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['parentid'];
 }

 public function getOne($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return array();
  $res = $this->db->select('site_category.id, site_category.parentid, site_category.link, site_category.name_'.SITELANG.' as name')->from('site_category')->where('site_category.visible = 1')->where("site_category.id = ".$this->db->escape($categoryid))->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  $res['childrencount'] = $this->getChildrenCatCount($res['id']);
  return $res;
 }

 public function getType($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return array();
  $res = $this->db->select('is_d, is_sh, is_k')->from('site_category')->where('site_category.visible = 1')->where("site_category.id = ".$this->db->escape($categoryid))->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function getName($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return '';
  $res = $this->db->select('site_category.name_'.SITELANG.' as name')->from('site_category')->where('site_category.visible = 1')->where("site_category.id = ".$this->db->escape($categoryid))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }

 public function getText($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return '';
  $res = $this->db->select('site_category.text_'.SITELANG.' as text')->from('site_category')->where('site_category.visible = 1')->where("site_category.id = ".$this->db->escape($categoryid))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['text'];
 }

 public function getText2($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return '';
  $res = $this->db->select('site_category.text2_'.SITELANG.' as text')->from('site_category')->where('site_category.visible = 1')->where("site_category.id = ".$this->db->escape($categoryid))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['text'];
 }

 public function getImage($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return '';
  $res = $this->db->select('site_category.image_big')->from('site_category')->where('site_category.visible = 1')->where("site_category.id = ".$this->db->escape($categoryid))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['image_big'];
 }

 public function getSubCategory($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return array();

  $res = $this->db->select('site_category.id')->from('site_category')->where('site_category.visible = 1')->where("site_category.parentid = ".$this->db->escape($categoryid))->or_where('site_category.parentid2 = '.$this->db->escape($categoryid))->or_where('site_category.parentid3 = '.$this->db->escape($categoryid))->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  $temp = array();
  foreach ($res as $one) {
   $temp[] = $one['id'];
  }
  $temp = array_unique($temp);

  $res = $this->db->select('site_category.id, site_category.parentid, site_category.link, site_category.name_'.SITELANG.' as name, site_category.image_big')->from('site_category')->where('site_category.visible = 1')->where_in('site_category.id', $temp)->order_by('site_category.position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  foreach ($res as &$one) {
   $one['childrencount'] = $this->getChildrenCatCount($one['id']);
  } unset($one);
  return $res;
 }

 public function getChildrenCatCount($categoryid = 0, $top = false) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return 0;
  $this->db->select('COUNT(*) as count')->from('site_category')->where('site_category.visible = 1');
  if ($top)  $this->db->where('site_category.visible_ontop = 1');
  $this->db->where("site_category.parentid = ".$this->db->escape($categoryid))->or_where('site_category.parentid2 = '.$this->db->escape($categoryid))->or_where('site_category.parentid3 = '.$this->db->escape($categoryid));
  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['count'];
 }

 public function getCategoryCatalogCount($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return 0;

  $idis_array = array_merge(array($categoryid), $this->formedCategoryIdis($categoryid));
  if (!is_array($idis_array) || empty($idis_array)) return 0;

  $res = $this->db->select('COUNT(*) as count')->from('site_catalog')->from('site_catalog_category')->where('site_catalog.id = site_catalog_category.catalogid')->where_in('site_catalog_category.categoryid', $idis_array)->where('site_catalog.visible = 1')->where_in('site_catalog_category.categoryid', $idis_array)->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['count'];
 }

 public function formedCategoryIdis($categoryid = 0) {
  $return = array();
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return array();
  $return[] = $categoryid;
  $res = $this->db->select('site_category.id')->from('site_category')->where('site_category.visible = 1')->where("site_category.parentid = ".$this->db->escape($categoryid))/*->or_where('site_category.parentid2 = '.$this->db->escape($categoryid))->or_where('site_category.parentid3 = '.$this->db->escape($categoryid))*/->get();
  if ($res->num_rows() <= 0) return $return;
  $res = $res->result_array();
  foreach ($res as $one) {
   $return[] = $one['id'];
   $return = array_merge($return, $this->formedCategoryIdis($one['id']));
  }
  return $return;
 }

 public function getTKD($categoryid = 0) {
  $categoryid = (int)$categoryid;
  if ($categoryid <= 0) return array();
  $res = $this->db->select('site_category.title_'.SITELANG.' as title, site_category.keyword_'.SITELANG.' as keyword, site_category.description_'.SITELANG.' as description')->from('site_category')->where('site_category.visible = 1')->where("site_category.id = ".$this->db->escape($categoryid))->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function getMainCat() {
  $res = $this->db->select('id, link, name_'.SITELANG.' as name')->from('site_category')->where('visible_ontop = 1')->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $idis = array();
  foreach ($res as $one) array_push($idis, $one['id']);

  $child = $this->db->select('id, parentid')->from('site_category')->where('parentid <> 0')/*->where('visible_ontop = 0')*/->where('visible = 1')->order_by('parentid', 'ASC')->get();
  if ($child->num_rows() > 0) {
   $child = $child->result_array();
   #foreach ($child as $one) array_push($idis, $one['id']);

   foreach ($res as &$one) {
    $one['child_cat'] = array();
    foreach ($child as $two) {
     if ($one['id'] == $two['parentid'] || in_array($two['parentid'], $one['child_cat']))  {
      array_push($one['child_cat'], $two['id']);
      array_push($idis, $two['id']);
     }
    }
   } unset($one);

  }

  $idis = array_unique($idis);

  $this->load->model('catalog_model');
  $objects = $this->catalog_model->getCatalogByCatIdis($idis);

  foreach ($res as &$one) {
   $one['children'] = array();

   foreach ($objects as $key => $value) {
    if ($key == $one['id'] || (isset($one['child_cat']) && in_array($key, $one['child_cat']))) {
     $one['children'] = array_merge($one['children'], $objects[$key]);
     unset($objects[$key]);
    }
   }
  } unset($one);

  return $res;
 }

 public function generateTopMenu($parent = false) {
  #get 1 in deep
  $res = $this->db->select('site_category.id, site_category.parentid, site_category.parentid2, 
    site_category.parentid3, site_category.link, site_category.name_'.SITELANG.' as name, 
    site_category.image, site_category.image_big')->from('site_category')->where('site_category.visible = 1')/*->where('site_category.visible_ontop = 1')*/->where('site_category.parentid = 0')->order_by('site_category.position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  if ($parent) return $res;

  #get children menu item
  $res_two = $this->db->select('site_category.id, site_category.parentid, site_category.parentid2, site_category.parentid3, site_category.link, site_category.name_'.SITELANG.' as name, site_category.image')->from('site_category')->where('site_category.visible = 1')->where('(site_category.parentid > 0 OR site_category.parentid2 > 0 OR site_category.parentid3 > 0)')->order_by('site_category.position', 'ASC')->get();
  if ($res_two->num_rows() <= 0) return $res;

  $res_two = $res_two->result_array();

  foreach ($res as &$one) {
   $one['children'] = array();

   foreach ($res_two as &$two) {
    $two['children'] = array();

    foreach ($res_two as $three) {
     if ($two['id'] == $three['parentid'] || $two['id'] == $three['parentid2'] || $two['id'] == $three['parentid3']) {

      $two['children'][$three['id']] = $three;

     }
    }

    if ($one['id'] == $two['parentid'] || $one['id'] == $two['parentid2'] || $one['id'] == $two['parentid3']) {

     $one['children'][$two['id']] = $two;

    }
   } unset($two);



  } unset($one);

  return $res;
 }

 public function haveChildren($categoryid = 0) {
  $categoryid = (int)$categoryid;

  $this->db
          ->select('site_category.id')
          ->from('site_category')
          ->where('site_category.visible = 1')
          ->where('site_category.parentid = '.$this->db->escape($categoryid).'
          OR site_category.parentid2 = '.$this->db->escape($categoryid).'
          OR site_category.parentid3 = '.$this->db->escape($categoryid))
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 public function getChildren($categoryid = 0) {
  $categoryid = (int)$categoryid;

  $this->db
          ->select('site_category.id, site_category.parentid,
                    site_category.parentid2, site_category.parentid3,
                    site_category.link, site_category.name_'.SITELANG.' as name,
                    site_category.image_big
                  ')
          ->from('site_category')
          ->where('site_category.visible = 1')
          ->order_by('site_category.position', 'ASC')
          ;

  if ($categoryid > 0)
   $this->db
           ->where('(site_category.parentid = '.$this->db->escape($categoryid).'
           OR site_category.parentid2 = '.$this->db->escape($categoryid).'
           OR site_category.parentid3 = '.$this->db->escape($categoryid).')')
           ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  /*
  foreach ($res as &$one) {
   $one['children'] = $this->getChildren($one['id']);
  } unset($one);
  */

  return $res;
 }

}