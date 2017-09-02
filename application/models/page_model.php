<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'base_model.php';

class Page_model extends Base_model {
 public function __construct() {
  parent::__construct();
 }

 public function is($link = null) {
  if (is_null($link)) return false;
  $link = parent::prepareDataString($link);

  $res = $this->db->select('id')->from('site_page')->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() > 0) return true;

  return false;
 }

 public function isOther($link = null) {
  if (is_null($link)) return false;
  $link = parent::prepareDataString($link);

  $res = $this->db->select('id')->from('site_page_other')->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() > 0) return true;

  return false;
 }

 public function ifPageFiles($link = '', $other = false) {
  if (empty($link)) return false;
  $link = parent::prepareDataString($link);

  if ($other) return false;

  $this->db
          ->select('isdoc')
          ->where('link = '.$this->db->escape($link))
          ->limit(1)
          ;

  $this->db->from('site_page');

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return (bool)$res['isdoc'];
 }

 public function isRepresent($link = '') {
  $link = parent::prepareDataString($link);
  if (empty($link)) return false;

  $res = $this->db->select('id')->from('site_map')->where('link = '.$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return false;
  return true;
 }

 public function getRepresent($link = '') {
  $link = parent::prepareDataString($link);
  if (empty($link)) return array();

  $res = $this->db->select('id, name_'.SITELANG.' as name, state_'.SITELANG.' as state, text_'.SITELANG.' as text')->from('site_map')->where('link = '.$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  return $res->row_array();
 }

 public function getRepresents() {
  $res = $this->db->select('id, class, coords, link, name_'.SITELANG.' as name, state_'.SITELANG.' as state, text_'.SITELANG.' as text')->from('site_map')->get();
  if ($res->num_rows() <= 0) return array();
  return $res->result_array();
 }

 public function getDelivery() {
  $res = $this->db->select('id, name_'.SITELANG.' as name')->from('site_delivery')->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function getDeliveryName($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return '';

  $this->db
          ->select('name_'.SITELANG.' as name')
          ->form('site_delivery')
          ->where('id = '.$this->db->escape($id))
          ->where('visible = 1')
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }

 public function _getDir() {
  $this->db
          ->select('dir_'.SITELANG.' as dir')
          ->from('site_page')
          ->where('id = 5')
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['dir'];
 }

 public function generatePMenu($parentid = 0) {

  $parentid = (int)$parentid;
  if ($parentid < 0) return array();

  #get 1 in deep
  $res = $this->db->select('id, parentid, link, name_'.SITELANG.' as name')->from('site_page')->where('visible = 1')->where('parentid = '.$this->db->escape($parentid))->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  #get children menu item
  $res_two = $this->db->select('id, parentid, link, name_'.SITELANG.' as name')->from('site_page')->where('visible = 1')->where('parentid > 0')->order_by('position', 'ASC')->get();
  if ($res_two->num_rows() <= 0) return $res;

  $res_two = $res_two->result_array();

  foreach ($res as &$one) {
   $one['children'] = array();

   foreach ($res_two as &$two) {
    $two['children'] = array();

    foreach ($res_two as $three) {
     if ($two['id'] == $three['parentid']) {
      $two['children'][] = $three;
      #unset($three);
     }
    }

    if ($one['id'] == $two['parentid']) {
     $one['children'][] = $two;
     #unset($two);
    }
   } unset($two);


  } unset($one);

  return $res;
 }

 public function getPageDocs($pageid = 0) {
  $pageid = (int)$pageid;
  if ($pageid <= 0) return array();

  $this->db
          ->select('id, file, name_'.SITELANG.' as name')
          ->from('site_files')
          ->where('pageid = '.$this->db->escape($pageid))
          ->where('visible = 1')
          ->order_by('position', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function getPageID($link = '', $other = false) {
  if (empty($link)) return 0;
  $link = parent::prepareDataString($link);

  $this->db
          ->select('id')
          ->where('link = '.$this->db->escape($link))
          ->limit(1)
          ;

  if ($other) $this->db->from('site_page_other');
  else $this->db->from('site_page');

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['id'];
 }

 public function getPageLink($id = 0, $other = false) {
  $id = (int)$id;
  if ($id <= 0) return '';

  $this->db
          ->select('link')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  if ($other) $this->db->from('site_page_other');
  else $this->db->from('site_page');

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['link'];
 }

 public function getPageFParentID($catid = 0, $ret_array = false) {
  $temp = $catid = (int)$catid;
  if ($catid <= 0 && $ret_array) return array();
  elseif ($catid <= 0) return 0;

  $return = array();
  while ($temp > 0) {
   $catid = $temp;
   if ($ret_array) $return[] = $catid;
   $temp = $this->getPageParentIDByID($catid);
  }

  if ($ret_array) return $return;
  else return $catid;
 }

 public function getPageParentIDByID($id = 0, $other = false) {
  $id = (int)$id;
  if ($id <= 0) return 0;

  $this->db
          ->select('parentid')
          ->where('id = '.$this->db->escape($id))
          ->limit(1)
          ;

  if ($other) $this->db->from('site_page_other');
  else $this->db->from('site_page');

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['parentid'];
 }

 public function getPageParentID($link = '', $other = false) {
  if (empty($link)) return 0;
  $link = parent::prepareDataString($link);

  $this->db
          ->select('parentid')
          ->where('link = '.$this->db->escape($link))
          ->limit(1)
          ;

  if ($other) $this->db->from('site_page_other');
  else $this->db->from('site_page');

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return 0;
  $res = $res->row_array();
  return $res['parentid'];
 }

 #INDEX PAGE
 public function getIndexPageTKD() {
  $res = $this->db->select('title_'.SITELANG.' as title, keyword_'.SITELANG.' as keyword, description_'.SITELANG.' as description')->from('site_indexpage')->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function getIndexPageText() {
  $res = $this->db->select('text_'.SITELANG.' as text')->from('site_indexpage')->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res['text'];
 }
 #this is the end... */

 #PAGE region
 public function getPageTKD($link = null, $other = false) {
  if (is_null($link)) return false;
  $link = parent::prepareDataString($link);

  $this->db->select('title_'.SITELANG.' as title, keyword_'.SITELANG.' as keyword, description_'.SITELANG.' as description');
  if (!$other) $this->db->from('site_page');
  else $this->db->from('site_page_other');
  $res = $this->db->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 #param switch 'head' => visible_onhead, 'top' => visible_ontop, 'foot' => visible_onfoot, 'other' => site_page_other
 public function getPageShortData($param = '', $limit = 0) {
  $limit = (int)$limit;

  $this->db->select('id, link, image, name_'.SITELANG.' as name');

  if ($param == 'other') $this->db->from('site_page_other');
  else $this->db->from('site_page');

  if ($param == 'head') $this->db->where('visible_onhead = 1');
  elseif ($param == 'top') $this->db->where('visible_ontop = 1');
  elseif ($param == 'foot') $this->db->where('visible_onfoot = 1');

  $this->db->where('visible = 1')->where('parentid = 0');

  if ($param != 'other') $this->db->order_by('position', 'ASC');

  if ($limit > 0) $this->db->limit($limit);
  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  if (isset($SDS) && $param == 'top') {
   $this->load->model('menu_model');
   $_menu = $this->menu_model->generateTopMenu(true);

   $t_res = $this->db->select('id, parentid, link, name_'.SITELANG.' as name')->from('site_page')->where('parentid <> 0')->where('visible = 1')->order_by('position', 'ASC')->get();
   if ($t_res->num_rows() > 0) $t_res = $t_res->result_array();
   else $t_res = array();

   foreach ($res as &$one) {

    $one['children'] = array();

    if (isset($one['link']) && $one['link'] == 'catalog') {
     $one['children'] = $_menu;
    } else {

     foreach ($t_res as &$two) {
      $two['children'] = array();
      /*
      foreach ($t_res as &$three) {
       if ($two['id'] == $three['parentid']) $two['children'][] = $three;
      }
      */
      if ($one['id'] == $two['parentid']) $one['children'][] = $two;

     } unset($two);

    }
   } unset($one);

  }

  return $res;
 }

 public function get() {

  $res = $this->db->select('id, parentid, link, name_'.SITELANG.' as name')->from('site_page')->where('visible = 1')->where('parentid = 0')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  $res2 = $this->db->select('id, parentid, link, name_'.SITELANG.' as name')->from('site_page')->where('visible = 1')->where('parentid <> 0')->order_by('position', 'ASC')->get();
  if ($res2->num_rows() <= 0) return $res;
  $res2 = $res2->result_array();

  foreach ($res as &$one) {
   $one['children'] = array();
   foreach ($res2 as $key => $value) {
    if ($value['parentid'] == $one['id']) {
     array_push($one['children'], $value);
     unset($res2[$key]);
    }
   }
  } unset($one);

  return $res;
 }

 public function getPageName($link, $other = false) {
  $link = parent::prepareDataString($link);
  $this->db->select('name_'.SITELANG.' as name');
  if (!$other) $this->db->from('site_page');
  else $this->db->from('site_page_other');
  $res = $this->db->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }
 public function getPageLinkOne($link, $other = false) {
  $link = parent::prepareDataString($link);
  $this->db->select('link');
  if (!$other) $this->db->from('site_page');
  else $this->db->from('site_page_other');
  $res = $this->db->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['link'];
 }

 public function getPageText($link, $other = false) {
  $link = parent::prepareDataString($link);
  $this->db->select('text_'.SITELANG.' as text');
  if (!$other) $this->db->from('site_page');
  else $this->db->from('site_page_other');
  $res = $this->db->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['text'];
 }

  public function getPageText2_ua($link, $other = false) {
  $link = parent::prepareDataString($link);
  $this->db->select('text2_ua as text2');
  if (!$other) $this->db->from('site_page');
  else $this->db->from('site_page_other');
  $res = $this->db->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['text2'];
 }

 public function getPageText2($link, $other = false) {
  $link = parent::prepareDataString($link);
  $this->db->select('text2_'.SITELANG.' as text2');
  if (!$other) $this->db->from('site_page');
  else $this->db->from('site_page_other');
  $res = $this->db->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['text2'];
 }

 public function getPageEmail($link) {
  $link = parent::prepareDataString($link);
  $this->db->select('email');
  $this->db->from('site_page');
  $res = $this->db->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['email'];
 }

 public function getPageNaT($link, $other = false) {
  $link = parent::prepareDataString($link);

  if (!$other) $this->db->select('class');

  $this->db->select('name_'.SITELANG.' as name, text_'.SITELANG.' as text, link');
  if (!$other) $this->db->from('site_page');
  else $this->db->from('site_page_other');
  $res = $this->db->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function getPageImages($link = '') {
  $link = parent::prepareDataString($link);
  $this->db->select('image, image_big, image2, image2_big');
  $this->db->from('site_page');
  $res = $this->db->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function getPageNaL($id) {
  $id = (int)$id;
  if ($id <= 0) return array();

  $this->db->select('link, name_'.SITELANG.' as name');
  $this->db->from('site_page');
  $res = $this->db->where('id = '.$this->db->escape($id))->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function getPageFChLink($pageid = 0) {
  $pageid = (int)$pageid;
  if ($pageid <= 0) return '';

  $this->db
          ->select('link')
          ->from('site_page')
          ->where('parentid = '.$this->db->escape($pageid))
          ->where('visible = 1')
          ->order_by('position', 'ASC')
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['link'];
 }

 public function getPageChildren($pageid = 0) {
  $pageid = (int)$pageid;
  if ($pageid <= 0) return array();

  $this->db
          ->select('id, link, name_'.SITELANG.' as name')
          ->from('site_page')
          ->where('parentid = '.$this->db->escape($pageid))
          ->where('visible = 1')
          ->order_by('position', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function getPageOneField($link = '', $field = '', $other = false) {
  if (empty($link) || empty($field)) return false;
  $link = parent::prepareDataString($link);
  $field = parent::prepareDataString($field);
  $this->db->select($field);
  if (!$other) $this->db->from('site_page');
  else $this->db->from('site_page_other');
  $res = $this->db->where("link = ".$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res[$field];
 }

 public function getPrice() {
  $this->db
          ->select('id, date, file, weight')
          ->from('site_price')
          ->limit(1)
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }
 #end PAGE region

 #CONTACT region
 public function getContact() {
  $this->db
          ->select('id, text_'.SITELANG.' as text')
          ->from('site_contact')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function getQTD() {
  $this->db
          ->select('id, name_'.SITELANG.' as name')
          ->from('site_feedback_name')
          ->order_by('name', 'ASC')
          ;

  $res = $this->db->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }
 #end CONTACT region

 #SITEMAP region
 public function generateSitemap() {
  $return = array();

  $this->load->model('menu_model');
  $categories = $this->menu_model->getCategoryAllPage();
  foreach ($categories as $one) {
   if (isset($one['id']) && isset($one['name'])) {
    $link = 'product/catalog/'.$one['id'];
    if ((!isset($one['link']) || empty($one['link'])) && isset($one['childrencount']) && $one['childrencount'] > 0) $link = 'product/pidcatalog/'.$one['id'];
    elseif (isset($one['link']) && !empty($one['link'])) $link = $one['link'];

    $temp = array();
    $temp['link'] = site_url($link);
    $temp['name'] = $one['name'];

    if (isset($one['children']) && !empty($one['children'])) {
     $temp['children'] = array();

     foreach ($one['children'] as $two) {
      if (isset($two['id']) && isset($two['name'])) {
       $link = 'product/catalog/'.$two['id'];
       if ((!isset($two['link']) || empty($two['link'])) && isset($two['childrencount']) && $two['childrencount'] > 0) $link = 'product/pidcatalog/'.$two['id'];
       elseif (isset($two['link']) && !empty($two['link'])) $link = $two['link'];

       $temp2 = array();
       $temp2['link'] = site_url($link);
       $temp2['name'] = $two['name'];

       if (isset($two['children']) && !empty($two['children'])) {
        $temp2['children'] = array();

        foreach ($two['children'] as $three) {
         if (isset($three['id']) && isset($three['name'])) {
          $link = 'product/catalog/'.$three['id'];
          if ((!isset($three['link']) || empty($three['link'])) && isset($three['childrencount']) && $three['childrencount'] > 0) $link = 'product/pidcatalog/'.$three['id'];
          elseif (isset($three['link']) && !empty($three['link'])) $link = $three['link'];

          $temp3 = array();
          $temp3['link'] = site_url($link);
          $temp3['name'] = $three['name'];

          $temp2['children'][] = $temp3;
         }

        }

       }

       $temp['children'][] = $temp2;
      }

     }

    }

    $return[] = $temp;
   }
  }

  $pages = $this->getPageShortData('head');
  foreach ($pages as $value) {
   if (isset($value['link']) && isset($value['name'])) {
    $temp = array();
    $temp['link'] = site_url($value['link']);
    $temp['name'] = $value['name'];
    $return[] = $temp;
   }
  }

  return $return;
 }
 #end SITEMAP region

 public function getSchedule() {
  parent::select_lang('days');
  $res = $this->db->select('id, holiday')->from('site_shopdaywork')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 #LOOKBOOR region

 public function lb_is($link = '') {
  $link = parent::prepareDataString($link);
  if (empty($link)) return false;
  $res = $this->db->select('id')->from('site_lookbook_cat')->where('link = '.$this->db->escape($link))->limit(1)->get();
  if ($res->num_rows() <= 0) return false;
  $res = $res->row_array();
  return $res['id'];
 }

 public function lb_getLast() {
  $res = $this->db->select('id, name_'.SITELANG.' as name, link, image, image_big')->from('site_lookbook_cat')->where('visible = 1')->order_by('position', 'ASC')->limit(1)->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->row_array();
  return $res;
 }

 public function lb_get() {
  $res = $this->db->select('id, name_'.SITELANG.' as name, link, image, image_big')->from('site_lookbook_cat')->where('visible = 1')->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();
  return $res;
 }

 public function lb_getName($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return '';
  $res = $this->db->select('name_'.SITELANG.' as name')->from('site_lookbook_cat')->where('visible = 1')->where('id = '.$this->db->escape($id))->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['name'];
 }

 public function lb_inLB($lbid = 0) {
  $lbid = (int)$lbid;
  if ($lbid <= 0) return array();
  $res = $this->db->select('id, name_'.SITELANG.' as name, name2_'.SITELANG.' as name2, image, image_big, image2, image2_big, object_1, object_2')->from('site_lookbook')->where('visible = 1')->where('catid = '.$this->db->escape($lbid))->order_by('position', 'ASC')->get();
  if ($res->num_rows() <= 0) return array();
  $res = $res->result_array();

  foreach ($res as &$one) {
   $one['object_1'] = $this->lb_object($one['object_1']);
   $one['object_2'] = $this->lb_object($one['object_2']);
  } unset($one);

  return $res;
 }

 private function lb_object($id = 0) {
  $id = (int)$id;
  if ($id <= 0) return '';

  $res = $this->db->select('link')->from('site_catalog')->where('id = '.$this->db->escape($id))->where('visible = 1')->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['link'];
 }

 #this is the end... */

 public function get_pp() {
  parent::select_lang('text');
  $res = $this->db->from('site_pp')->where('id = 1')->limit(1)->get();
  if ($res->num_rows() <= 0) return '';
  $res = $res->row_array();
  return $res['text'];
 }

}