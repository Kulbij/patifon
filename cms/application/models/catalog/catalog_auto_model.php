<?php

class Catalog_auto_model extends CI_Model
{
  function __construct() {
   parent::__construct();
  }
  
  public function getFactory() {
   $res = $this->db->select('id, name_ua as name')->from('site_factory')->order_by('name_ua', 'ASC')->get();
   if ($res->num_rows() <= 0) return array();
   $res = $res->result_array();
   return $res;
  }
  
  public function getCategory($menuid = 0) {
   $this->load->model('catalog/catalog_catalog_model');
   $res = $this->catalog_catalog_model->selectPreviewAll();
   return $res;
  }
  
  public function getObject($menuid = 0, $factoryid = 0) {

   $complect = array();
   $res = $this->db->select('catalogid')->from('site_catalog_complect')->where('count = 0')->get();
   if ($res->num_rows() > 0) {
    $res = $res->result_array();
    foreach ($res as $value) {
     $complect[] = $value['catalogid'];
    }
   }
   
   $this->db->select('site_catalog.id, site_catalog.factoryid, site_catalog.name_ua as name')->from('site_catalog')->where('site_catalog.parentid = 0');
   if (!empty($complect)) $this->db->where_not_in('site_catalog.id', $complect);
   #->from('site_catalog_complect')->where('site_catalog_complect.catalogid <> site_catalog.id')->where('site_catalog_complect.count = 0');
   if ($factoryid > 0) $this->db->where('factoryid = '.$this->db->escape($factoryid));
   if ($menuid > 0) $this->db->from('site_catalog_category')->where('site_catalog_category.catalogid = site_catalog.id')->where('site_catalog_category.categoryid = '.$this->db->escape($menuid));
   $res = $this->db->order_by('site_catalog.name_ua', 'ASC')->get();
   if ($res->num_rows() <= 0) return array();
   $res = $res->result_array();
   
   foreach ($res as &$one) {
    $one['category'] = $this->getCategoryByObject($one['id']);
   }
   
   return $res;
  }
  
  public function getCategoryByObject($objectid = 0) {
   $objectid = (int)$objectid;
   if ($objectid <= 0) return array();
   $res = $this->db->select('categoryid as id')->from('site_catalog_category')->where('catalogid = '.$this->db->escape($objectid))->get();
   if ($res->num_rows() <= 0) return array();
   $res = $res->result_array();
   return $res;
  }
  
  public function getObjectComponentID($objectid = 0) {
   $objectid = (int)$objectid;
   if ($objectid <= 0) return array();
   $res = $this->db->select('id')->from('site_catalog')->where('parentid = '.$this->db->escape($objectid))->get();
   if ($res->num_rows() <= 0) return array();
   $res = $res->result_array();
   
   $temp = array();
   foreach ($res as $one) $temp[] = $one['id'];
   
   return $temp;
  }
  
  public function getObjectComplectID($objectid = 0) {
   $objectid = (int)$objectid;
   if ($objectid <= 0) return array();
   $res = $this->db->select('catalogid as id')->from('site_catalog_complect')->where('maincatalogid = '.$this->db->escape($objectid))->where('count = 0')->get();
   if ($res->num_rows() <= 0) return array();
   $res = $res->result_array();
   
   $temp = array();
   foreach ($res as $one) $temp[] = $one['id'];
   
   return $temp;
  }
  
  public function getFacade() {
   $res = $this->db->select('id, name_ua as name')->from('site_mat_facade')->order_by('name_ua', 'ASC')->get();
   if ($res->num_rows() <= 0) return array();
   $res = $res->result_array();
   return $res;
  }
  
  public function getCorpus() {
   $res = $this->db->select('id, name_ua as name')->from('site_mat_corpus')->order_by('name_ua', 'ASC')->get();
   if ($res->num_rows() <= 0) return array();
   $res = $res->result_array();
   return $res;
  }
  
  #auto 
  private function formedObjArray($objectid = 0, $categoryid = 0, $factoryid = 0) {
   $objectarray = array();
   if ($objectid > 0) {
    $objectarray = array_merge($this->getObjectComponentID($objectid), $this->getObjectComplectID($objectid));
    $objectarray[] = $objectid;
   } elseif ($factoryid > 0 || $categoryid > 0) {
    $temp_object = $this->getObject($categoryid, $factoryid);
    foreach ($temp_object as $one) {
     $temp_comp = array_merge($this->getObjectComponentID($one['id']), $this->getObjectComplectID($one['id']));
     if (!empty($temp_comp)) $objectarray = array_merge($objectarray, $temp_comp);
     $objectarray[] = $one['id'];
    }
   } else return array();
   return $objectarray;
  }
  
  public function saveAutoPrice($array) {
   if (!isset($array['in_factory']) && !isset($array['in_category']) && !isset($array['in_object'])) return false;
   $factoryid = (int)$array['in_factory'];
   $categoryid = (int)$array['in_category'];
   $objectid = (int)$array['in_object'];
   
   $objectarray = $this->formedObjArray($objectid, $categoryid, $factoryid);
   if (empty($objectarray)) return false;
   
   $res = $this->db->select('site_catalog.id, site_catalog.opt_price, site_catalog_site.percent, site_catalog_site.sum, site_catalog_site.discount')->from('site_catalog')->from('site_catalog_site')->where('site_catalog.id = site_catalog_site.catalogid')->where_in('site_catalog.id', $objectarray)->get();
   if ($res->num_rows() <= 0) return false;
   $res = $res->result_array();
   
   $update_array = array();
   if (isset($array['opt']['change']) && $array['opt']['change'] == 1) {
    
    foreach ($res as $one) {
     $temp = array();
     $temp['id'] = $one['id'];
     $temp['opt_price'] = round(($one['opt_price']*$array['opt']['percent']+$array['opt']['sum']-$array['opt']['discount']), $array['opt']['round']);
     $update_array[] = $temp;
     
     $this->db->set('opt_price', $temp['opt_price'])->where('id', $temp['id'])->update('site_catalog');
     
     #site_catalog_prices
     $prices = $this->db->select('id, opt_price')->from('site_catalog_prices')->where('catalogid = '.$this->db->escape($one['id']))->get();
     if ($prices->num_rows() > 0) {
      $prices = $prices->result_array();
      foreach ($prices as $price) {
       $temp_price = round(($price['opt_price']*$array['opt']['percent']+$array['opt']['sum']-$array['opt']['discount']), $array['opt']['round']);
       $this->db->set('opt_price', $temp_price)->where('id = '.$this->db->escape($price['id']))->limit(1)->update('site_catalog_prices');
      }
     }
     #end site_catalog_prices
     
    }
    #if (!empty($update_array)) $this->db->update_batch('site_catalog', $update_array, 'id');
   }
   
   $update_array = array();
   if (isset($array['dybok']['change']) && $array['dybok']['change'] == 1) {
    foreach ($res as $one) {
     $temp = array();
     $temp['catalogid'] = $one['id'];
     if (isset($array['dybok']['prev']) && $array['dybok']['prev'] == 1) {
      $temp['percent'] = $one['percent'] * $array['dybok']['percent'];
      $temp['sum'] = $one['sum'] + $array['dybok']['sum'];
      $temp['discount'] = $one['discount'] + $array['dybok']['discount'];
     } else {
      $temp['percent'] = $array['dybok']['percent'];
      $temp['sum'] = $array['dybok']['sum'];
      $temp['discount'] = $array['dybok']['discount'];
     }
     $update_array[] = $temp;
     
     $this->db->set('percent', $temp['percent'])->set('sum', $temp['sum'])->set('discount', $temp['discount'])->where('catalogid = '.$this->db->escape($temp['catalogid']))->update('site_catalog_site');
    }
    #if (!empty($update_array)) $this->db->update_batch('site_catalog_site', $update_array, 'catalogid');
   }
   
   if (isset($array['present']) && isset($array['present_change']) && $array['present_change'] == 1) {
    foreach ($res as $one) {
     $this->db->set('present', $array['present'])->where('id = '.$this->db->escape($one['id']))->limit(1)->update('site_catalog');
    }
   }
   
   return true;
  }
  
  public function saveAutoMaterial($array) {
   if (!isset($array['in_factory']) && !isset($array['in_category']) && !isset($array['in_object'])) return false;
   if (!isset($array['mat_facadeid']) || !isset($array['mat_corpsid'])) return false;
   $factoryid = (int)$array['in_factory'];
   $categoryid = (int)$array['in_category'];
   $objectid = (int)$array['in_object'];
   
   $mat_facadeid = (int)$array['mat_facadeid'];
   $mat_corpsid = (int)$array['mat_corpsid'];
   if ($mat_facadeid <= 0 && $mat_corpsid <= 0) return false;
   
   $objectarray = $this->formedObjArray($objectid, $categoryid, $factoryid);
   if (empty($objectarray)) return false;
   
   $this->db->set('mat_facadeid', $mat_facadeid)->set('mat_corpsid', $mat_corpsid)->where_in('id', $objectarray)->update('site_catalog');
   
   /*
   $res = $this->db->select('site_catalog.id, site_catalog.mat_facadeid, site_catalog.mat_corpsid')->from('site_catalog')->where_in('site_catalog.id', $objectarray)->get();
   if ($res->num_rows() <= 0) return false;
   $res = $res->result_array();
   
   $update_array = array();
   foreach ($res as $one) {
    $temp = array();
    $temp['id'] = $one['id'];
    if ($mat_facadeid > 0) $temp['mat_facadeid'] = $mat_facadeid;
    if ($mat_corpsid > 0) $temp['mat_corpsid'] = $mat_corpsid;
    $update_array[] = $temp;
   }*/
   #if (!empty($update_array)) $this->db->update_batch('site_catalog', $update_array, 'id');
   
   return true;
  }
  #end auto 
  
  public function recountComplect() {
   $res = $this->db->select('catalogid')->from('site_catalog_complect')->where('count = 0')->order_by('catalogid', 'ASC')->get();
   if ($res->num_rows() <= 0) return true;
   $res = $res->result_array();
   $idis = array();
   foreach ($res as $one) $idis[] = $one['catalogid'];
   
   $res = $this->db->select('site_catalog_complect.maincatalogid, site_catalog_complect.catalogid, site_catalog_complect.count, site_catalog.opt_price, site_catalog.weight')->from('site_catalog')->from('site_catalog_complect')->where('site_catalog.id = site_catalog_complect.catalogid')->where_in('site_catalog_complect.maincatalogid', $idis)->order_by('site_catalog_complect.maincatalogid', 'ASC')->get();
   if ($res->num_rows() <= 0) return true;
   $res = $res->result_array();
   
   $temp = array();
   $temp['opt_price'] = 0;
   $temp['weight'] = 0;
   $id = 0;
   foreach ($res as $one) {
    if ($id != $one['maincatalogid']) {
     if (!empty($temp) && !empty($temp['opt_price']) && !empty($temp['weight'])) {
      $this->db->set('opt_price', $temp['opt_price'])->set('weight', $temp['weight'])->where('id = '.$this->db->escape($id))->limit(1)->update('site_catalog');
     }
     $id = $one['maincatalogid'];
     $temp = array();
     $temp['opt_price'] = 0;
     $temp['weight'] = 0;
    }
    
    $temp['opt_price'] += (float)($one['opt_price']*$one['count']);
    $temp['weight'] += (float)($one['weight']*$one['count']);
   }
   if (!empty($temp) && !empty($temp['opt_price']) && !empty($temp['weight'])) {
    $this->db->set('opt_price', $temp['opt_price'])->set('weight', $temp['weight'])->where('id = '.$this->db->escape($id))->limit(1)->update('site_catalog');
   }
   return true;
  }
  
}