<?php

class Catalog_components_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function getFirstCat() {
     $res = $this->db->select('id')->from('site_category')->where('site_category.parentid <> 0')->order_by('position', 'ASC')->limit(1)->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->row_array();
     return $res['id'];
    }
    
    public function getMainImage($objid) {
        
        $res = $this->db->select('image, imagemid, imagesm')->from('site_catalog')->where("id = '$objid'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        return $res[0];
        
    }
    
    public function saveMainImage($array) {
        
        if (!isset($array['objid']) || !is_numeric($array['objid'])) return false;
        
        $this->db->set('image', $array['image']);
        $this->db->set('imagemid', $array['imagemid']);
        $this->db->set('imagesm', $array['imagesm']);
        $this->db->where("id = '{$array['objid']}'");
        $this->db->update('site_catalog');
        
        return true;
        
    }
    
    //+
    public function getPreviewObj($from, $count = 50, $cat = 0, $brand = 0, $cobject = 0, $false = false) {
        if ($from == 1 || $from == 0) $from = 0;
        else {
            $from = ($count * $from) - $count;
        }
        
        $cobject = (int)$cobject;
        if ($cobject <= 0 && $false) return array();
        
        $this->db->select('site_catalog.id, site_catalog.name, site_catalog.image, site_catalog.opt_price, site_catalog.visible, site_catalog.in_stock, site_catalog.admin_rate, site_catalog.size_height, site_catalog.size_width, site_catalog.size_depth, site_catalog.weight')->from('site_catalog')->from('site_catalog_site')->where('site_catalog.id = site_catalog_site.catalogid');
        
        if ($cat > 0) $this->db->from('site_catalog_category')->where("site_catalog_category.catalogid = site_catalog.id")->where("site_catalog_category.categoryid = '{$cat}'");
        
        if ($brand > 0) $this->db->where("site_catalog.factoryid = '{$brand}'");
        
        
        if ($cobject > 0) $this->db->where('site_catalog.parentid = '.$this->db->escape($cobject));
        else $this->db->where('site_catalog.parentid = 0');
        
        #$this->db->limit($count, $from);
        if ($cobject > 0) $this->db->order_by('site_catalog.visible', 'DESC')->order_by('site_catalog.in_stock', 'DESC')->order_by('site_catalog.id', 'DESC');
        else $this->db->order_by('name', 'ASC');
        
        $res = $this->db->get();
        
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        foreach ($res as &$value) {
         $this->db->select('site_catalog.id, site_catalog.name, site_catalog.image, site_catalog.opt_price, site_catalog.visible, site_catalog.in_stock, site_catalog.admin_rate, site_catalog.size_height, site_catalog.size_width, site_catalog.size_depth, site_catalog.weight')->from('site_catalog')->from('site_catalog_site')->where('site_catalog.id = site_catalog_site.catalogid');
         $this->db->where('site_catalog.parentid = '.$this->db->escape($value['id']));
         $res2 = $this->db->order_by('site_catalog.visible', 'DESC')->order_by('site_catalog.in_stock', 'DESC')->order_by('site_catalog.id', 'DESC')->get();
         
         if ($res2->num_rows() > 0) {
          $res2 = $res2->result_array();
          $value['children'] = $res2;
         } else $value['children'] = array();
        } unset($value);
        
        return $res;
        
    }
    
    public function setPriceObj($id, $price) {
        
        $id = (int)$id;
        if ($id <= 0) return false;
        
        $price = $price;
        
        $this->db->set('opt_price', $price)->where("id = '{$id}'")->update('site_catalog');
        
        return true;
        
    }
    
    public function setAdminRateObj($id, $rate) {
        
        $id = (int)$id;
        if ($id <= 0) return false;
        
        $rate = $rate;
        
        $this->db->set('admin_rate', $rate)->where("id = '{$id}'")->update('site_catalog');
        
        return true;
        
    }
    
    public function setWHDW($id, $width, $height, $depth, $weight) {
     $id = (int)$id;
     if ($id <= 0) return false;
     
     $this->db->set('size_width', $width)->set('size_height', $height)->set('size_depth', $depth)->set('weight', $weight)->where('id = '.$this->db->escape($id))->update('site_catalog');
     
     return true;
    }
    
    //+
    public function countProduct($cat = 0, $brand = 0) {
        
        $this->db->select('COUNT(*) as count');
        $this->db->from('site_catalog')->from('site_catalog_site')->where('site_catalog.id = site_catalog_site.catalogid');
        
        if ($cat > 0) $this->db->from('site_catalog_category')->where("site_catalog_category.catalogid = site_catalog.id")->where("site_catalog_category.categoryid = '{$cat}'");
        
        if ($brand > 0) $this->db->where("site_catalog.factoryid = '{$brand}'");
        
        #$this->db->where("site_catalog.parentid == 0");

        $res = $this->db->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return 0;
        
        return $res[0]['count'];
        
    }
    
    //+
    public function ifIs($id) {
        $res = $this->db->select("id")->from('site_catalog')->where("id = '$id'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        return true;
        
    }
    
    //+
    public function moveObj($id, $catid) {
     return false;
        $this->db->set('idcat', $catid);
        $this->db->where("id = '{$id}'")->update('site_catalog');
    }
    
    //+
    public function setVisible($id, $stock = false) {
        if ($stock) $this->db->set('in_stock', 1);
        else $this->db->set('visible', 1);
        $this->db->where("id = '{$id}'")->update('site_catalog');
    }
    
    //+
    public function setUnVisible($id, $stock = false) {
        if ($stock) $this->db->set('in_stock', 0);
        else $this->db->set('visible', 0);
        $this->db->where("id = '{$id}'")->update('site_catalog');
    }
    
    public function stocker($id = 0, $par = 0) {
     $id = (int)$id;
     if ($id <= 0) return false;
     $this->db->set('in_stock', $par)->where('id = '.$this->db->escape($id))->limit(1)->update('site_catalog');
    }
    
    //!
    public function getCats() {
        
        $this->load->model('catalog/catalog_catalog_model');
        $res = $this->catalog_catalog_model->selectPreviewAll(0, true);
        return $res;
        
        return false;
        $res = $this->db->select('id, parentid, name')->from('site_category')->where("parentid = 0")->order_by('position', 'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        $chi = $this->db->select('id, parentid, name')->from('site_category')->where("parentid > 0")->order_by('position', 'ASC')->get();
        
        if ($chi->num_rows() <= 0) return $res;
        
        $chi = $chi->result_array();
        
        foreach ($res as &$one) {
            
            $one['children'] = array();
            
            foreach ($chi as $two) {
                
                if ($one['id'] == $two['parentid']) {
                    
                    $one['children'][] = $two;
                    unset($two);
                    
                }
                
            }
            
        }
        
        return $res;
        
    }
    public function getCatsO($objectid = 0) {
     $objectid = (int)$objectid;
     if ($objectid <= 0) return array();
     $res = $this->db->select('site_category.id, site_category.parentid, site_category.name, site_catalog_category.main')->from('site_category')->from('site_catalog_category')->where('site_catalog_category.catalogid = '.$this->db->escape($objectid))->where('site_catalog_category.categoryid = site_category.id')->order_by('site_category.position', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     foreach ($res as &$one) {
      $temp_arr = array();
      $temp_id = $one['parentid'];
      while($temp_id > 0) {
       $temp_res = $this->db->select('parentid, name')->from('site_category')->where('id = '.$this->db->escape($temp_id))->limit(1)->get();
       if ($temp_res->num_rows() > 0) {
        $temp_res = $temp_res->row_array();
        $temp_arr[] = $temp_res['name'];
        $temp_id = $temp_res['parentid'];
       } else $temp_id = 0;
      }
      if (!empty($temp_arr)) {
       $temp_arr = array_reverse($temp_arr);
       $str = '';
       foreach ($temp_arr as $value) {
        $str .= $value.'/';
       }
       $one['name'] = $str.$one['name'];
      }
     } unset($one);
     return $res;
    }
    public function getCatsOID($objectid = 0) {
     $objectid = (int)$objectid;
     if ($objectid <= 0) return array();
     $res = $this->db->select('site_category.id')->from('site_category')->from('site_catalog_category')->where('site_catalog_category.catalogid = '.$this->db->escape($objectid))->where('site_catalog_category.categoryid = site_category.id')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     $temp = array();
     foreach ($res as $one) $temp[] = $one['id'];
     return $temp;
    }
    
    //!
    public function getSorts() {
        $result = $this->db->select('id, name')->from('site_factory')->order_by('name', 'ASC')->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return array();
        
        return $result;
    }
    
    public function getCatalogWork($objid) {
        
        $res = $this->db->select('catalogid as id')->from('site_catalog')->where("id = '$objid'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return 0;
        
        return $res[0]['id'];
        
    }
    
    //+
    public function removeObj($objid) {
        return false;
        //1. get components if is and delete that with images
        $comps = $this->db->select('id, img, img_big, img_pop, img_obj')->from('site_catalog')->where("idcomponent = '{$objid}'")->get();
        
        if ($comps->num_rows() > 0) {
            
            $comps = $comps->result_array();
            
            foreach ($comps as $one) {
                
                $compsimgs = $this->db->select('id, img, big_img')->from('site_img_catalog')->where("idcatalog = '{$one['id']}'")->get();
                
                if ($compsimgs->num_rows() > 0) {
                    
                    $compsimgs = $compsimgs->result_array();
                    
                    foreach ($compsimgs as $two) {
                        
                        $this->db->where("id = '{$two['id']}'")->delete('site_img_catalog');
                        
                        @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$two['img']);
                        @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$two['big_img']);
                        
                    }
                    
                }
                
                $this->db->where("id = '{$one['id']}'")->delete('site_catalog');
                
                $this->deleteImgs($one);
                
                rmdir($_SERVER['DOCUMENT_ROOT'].'/images/objectimg/'.$one['id']);
                
            }
            
        }
        
        //2. delete object with images
        $res = $this->db->select('img, img_big, img_pop, img_obj')->from('site_catalog')->where("id = '$objid'")->limit(1)->get();
        
        if ($res->num_rows() <= 0) return false;
        
        $res = $res->result_array();
        
        $imgs = $this->db->select('id, img, big_img')->from('site_img_catalog')->where("idcatalog = '$objid'")->get();
        
        if ($imgs->num_rows() > 0) {
            
            $imgs = $imgs->result_array();
            
            foreach ($imgs as $two) {

                $this->db->where("id = '{$two['id']}'")->delete('site_img_catalog');

                @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$two['img']);
                @unlink($_SERVER['DOCUMENT_ROOT'].'/'.$two['big_img']);

            }
            
        }
        
        $this->db->where("id = '{$objid}'")->delete('site_catalog');
        
        $this->deleteImgs($res[0]);
        
        @rmdir($_SERVER['DOCUMENT_ROOT'].'/images/objectimg/'.$objid);
        
    }
    
    public function deleteImgs($imgs) {
        return false;
        /*
        if (isset($imgs['img']) && !empty($imgs['img'])) @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$imgs['img']);
        
        if (isset($imgs['img_big']) && !empty($imgs['img_big'])) @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$imgs['img_big']);
        
        if (isset($imgs['img_obj']) && !empty($imgs['img_obj'])) @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$imgs['img_obj']);
        
        if (isset($imgs['img_pop']) && !empty($imgs['img_pop'])) @unlink($_SERVER['DOCUMENT_ROOT'].'/public/'.$imgs['img_pop']);
        */
    }
    
    //---SAVE WORK region
    
    public function upObj($array) {
        
        if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id'])) {
         @chdir($_SERVER['DOCUMENT_ROOT'].'/images');
         @mkdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id'], 0777);
        }
        if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id'].'/mainimg')) {
         @chdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id']);
         @mkdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id'].'/mainimg', 0777);
        }
        if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id'].'/moreimg')) {
         @chdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id']);
         @mkdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id'].'/moreimg', 0777);
        }
        
        $this->db->set('name_ua', $array['name_ua']);
        $this->db->set('name_ru', $array['name_ru']);
        $this->db->set('factoryid', $array['factoryid']);
        $this->db->set('mat_facadeid', $array['mat_facadeid']);
        $this->db->set('mat_corpsid', $array['mat_corpsid']);
        $this->db->set('opt_price', $array['price']);
        $this->db->set('size_height', $array['size_height']);
        $this->db->set('size_width', $array['size_width']);
        $this->db->set('size_depth', $array['size_depth']);
        $this->db->set('sizer', $array['sizer']);
        $this->db->set('weight', $array['weight']);
        $this->db->set('visible', $array['visible']);
        $this->db->set('in_stock', $array['in_stock']);
        $this->db->set('admin_rate', $array['admin_rate']);
        $this->db->set('present', $array['present']);
        $this->db->set('prices', $array['prices']);
        $this->db->where('id = '.$this->db->escape($array['id']))->limit(1)->update('site_catalog');
        
        $this->db->set('catalogid', $array['id']);
        $this->db->set('short_desc_ua', $array['short_desc_ua']);
        $this->db->set('short_desc_ru', $array['short_desc_ru']);
        $this->db->set('description_ua', $array['description_ua']);
        $this->db->set('description_ru', $array['description_ru']);
        $this->db->set('video', $array['video']);
        $this->db->set('percent', $array['percent']);
        $this->db->set('sum', $array['sum']);
        $this->db->set('discount', $array['discount']);
        $this->db->set('free_delivery', $array['free_delivery']);
        if (isset($array['alert_ua'])) $this->db->set('alert_ua', $array['alert_ua']);
        if (isset($array['alert_ru']))$this->db->set('alert_ru', $array['alert_ru']);
        if (isset($array['top']))$this->db->set('top', $array['top']);
        $this->db->where('catalogid = '.$this->db->escape($array['id']))->limit(1)->update('site_catalog_site');
        
        if (isset($array['items_colf'])) {
         $items = $array['items_colf'];
         $this->db->where("catalogid = '{$array['id']}'")->where('corpus = 0')->delete('site_catalog_color_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $array['id'])->set('colorid', $items[$i])->set('corpus', 0)->insert('site_catalog_color_catalog');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$array['id']}'")->where('corpus = 0')->delete('site_catalog_color_catalog');
        
        if (isset($array['items_cor'])) {
         $items = $array['items_cor'];
         $this->db->where("catalogid = '{$array['id']}'")->where('corpus = 1')->delete('site_catalog_color_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $array['id'])->set('colorid', $items[$i])->set('corpus', 1)->insert('site_catalog_color_catalog');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$array['id']}'")->where('corpus = 1')->delete('site_catalog_color_catalog');
        
        if (isset($array['items_sty'])) {
         $items = $array['items_sty'];
         $this->db->where("catalogid = '{$array['id']}'")->delete('site_catalog_style_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $array['id'])->set('styleid', $items[$i])->insert('site_catalog_style_catalog');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$array['id']}'")->delete('site_catalog_style_catalog');
        
        if (isset($array['items_cat'])) {
         $items = $array['items_cat'];
         $this->db->where("catalogid = '{$array['id']}'")->delete('site_catalog_category');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $array['id'])->set('categoryid', $items[$i]);
          if (isset($array['cat_main']) && $array['cat_main'] == $items[$i]) $this->db->set('main', 1);
          else $this->db->set('main', 0);
          $this->db->insert('site_catalog_category');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$array['id']}'")->delete('site_catalog_category');
        
        if (isset($array['comp'])) {
         $this->db->set('parentid', 0)->where("parentid = '{$array['id']}'")->update('site_catalog');
         $comp = $array['comp'];
         foreach ($comp as $c_c) {
          $this->db->set('parentid', $array['id'])->where("id = '{$c_c}'")->update('site_catalog');
         }
        }
        
        if (isset($array['items1']) && is_array($array['items1'])) {
         foreach ($array['items1'] as $value) {
          $this->db->set('catalogid', $array['id']);
          $this->db->set('name_ua', $value['name_ua']);
          $this->db->set('name_ru', $value['name_ru']);
          $this->db->set('opt_price', $value['opt_price']);
          $this->db->where('id = '.$this->db->escape($value['id']))->update('site_catalog_prices');
         }
        } else $this->db->where('catalogid = '.$this->db->escape($array['id']))->delete('site_catalog_prices');
        
        if (isset($array['new_items1']) && is_array($array['new_items1'])) {
         foreach ($array['new_items1'] as $value) {
          $this->db->set('catalogid', $array['id']);
          $this->db->set('name_ua', $value['name_ua']);
          $this->db->set('name_ru', $value['name_ru']);
          $this->db->set('opt_price', $value['opt_price']);
          $this->db->insert('site_catalog_prices');
         }
        }
        
        $this->load->library('image_my_lib');
        if (!empty($_FILES['main_image']) && !empty($_FILES['main_image']['tmp_name'])) {
         $res = $this->db->select('image')->from('site_catalog')->where("id = '{$array['id']}'")->limit(1)->get();
         if ($res->num_rows() > 0) {
          $res = $res->row_array();
          $this->image_my_lib->removeObjImages($array['id'], $res['image']);
         }
        }
        
        $main_img = $this->image_my_lib->createMainImage($array['id']);
        if (isset($main_img['image']) && !empty($main_img['image'])) {
         $this->db->set('image', $main_img['image']);
         $this->db->where("id = '{$array['id']}'");
         $this->db->update('site_catalog');
        }
        
        if (!isset($array['upimgs'])) $array['upimgs'] = array();
        else $array['upimgs'] = $this->image_my_lib->createImgs($array['id'], $array['upimgs']);
        $imgs = $array['upimgs'];
        $count_ = count($imgs);
        for ($i = 0; $i <= $count_; ++$i) {
         if (isset($imgs[$i]['image'])) {
          $this->db->set('catalogid', $array['id']);
          $this->db->set('image', $imgs[$i]['image']);
          $this->db->set('visible', 1);
          $this->db->insert('site_catalog_image');
          
          $tempid = $this->db->insert_id();
          $this->db->set('position', $tempid)->where('id = '.$this->db->escape($tempid))->update('site_catalog_image');
         }
        }
        
        return $array['id'];
        
    }
    
    public function insObj($array) {
        
        $this->db->set('name_ua', $array['name_ua']);
        $this->db->set('name_ru', $array['name_ru']);
        $this->db->set('factoryid', $array['factoryid']);
        $this->db->set('mat_facadeid', $array['mat_facadeid']);
        $this->db->set('mat_corpsid', $array['mat_corpsid']);
        $this->db->set('opt_price', $array['price']);
        $this->db->set('size_height', $array['size_height']);
        $this->db->set('size_width', $array['size_width']);
        $this->db->set('size_depth', $array['size_depth']);
        $this->db->set('sizer', $array['sizer']);
        $this->db->set('weight', $array['weight']);
        $this->db->set('admin_rate', $array['admin_rate']);
        $this->db->set('present', $array['present']);
        $this->db->set('prices', $array['prices']);
        $this->db->set('image', '');
        $this->db->set('visible', 1);
        $this->db->set('in_stock', 1);
        $this->db->insert('site_catalog');
        
        $newwid = $this->db->insert_id();
        
        $this->db->set('catalogid', $newwid);
        $this->db->set('short_desc_ua', $array['short_desc_ua']);
        $this->db->set('short_desc_ru', $array['short_desc_ru']);
        $this->db->set('description_ua', $array['description_ua']);
        $this->db->set('description_ru', $array['description_ru']);
        $this->db->set('video', $array['video']);
        $this->db->set('percent', $array['percent']);
        $this->db->set('sum', $array['sum']);
        $this->db->set('discount', $array['discount']);
        $this->db->set('free_delivery', $array['free_delivery']);
        $this->db->set('countwatch', 0);
        $this->db->set('siteid', 1);
        if (isset($array['alert_ua'])) $this->db->set('alert_ua', $array['alert_ua']);
        if (isset($array['alert_ru']))$this->db->set('alert_ru', $array['alert_ru']);
        if (isset($array['top']))$this->db->set('top', $array['top']);
        $this->db->insert('site_catalog_site');
        
        $scs_temp = $this->db->insert_id();
        $this->db->set('position', $scs_temp)->where('id = '.$this->db->escape($scs_temp))->update('site_catalog_site');
        
        @chdir($_SERVER['DOCUMENT_ROOT'].'/images');
        @mkdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$newwid, 0777);
        @chdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$newwid);
        @mkdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$newwid.'/mainimg', 0777);
        @mkdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$newwid.'/moreimg', 0777);
        
        if (isset($array['items_colf'])) {
         $items = $array['items_colf'];
         $this->db->where("catalogid = '{$newwid}'")->where('corpus = 0')->delete('site_catalog_color_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $newwid)->set('colorid', $items[$i])->set('corpus', 0)->insert('site_catalog_color_catalog');
         }
         $items = array();
        } else $this->db->set('catalogid', $newwid)->set('colorid', $items[$i])->set('corpus', 0)->insert('site_catalog_color_catalog');
        
        if (isset($array['items_cor'])) {
         $items = $array['items_cor'];
         $this->db->where("catalogid = '{$newwid}'")->where('corpus = 1')->delete('site_catalog_color_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $newwid)->set('colorid', $items[$i])->set('corpus', 1)->insert('site_catalog_color_catalog');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$newwid}'")->where('corpus = 1')->delete('site_catalog_color_catalog');
        
        if (isset($array['items_sty'])) {
         $items = $array['items_sty'];
         $this->db->where("catalogid = '{$newwid}'")->delete('site_catalog_style_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $newwid)->set('styleid', $items[$i])->insert('site_catalog_style_catalog');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$newwid}'")->delete('site_catalog_style_catalog');
        
        if (isset($array['items_cat'])) {
         $items = $array['items_cat'];
         $this->db->where("catalogid = '{$newwid}'")->delete('site_catalog_category');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $newwid)->set('categoryid', $items[$i]);
          if (isset($array['cat_main']) && $array['cat_main'] == $items[$i]) $this->db->set('main', 1);
          else $this->db->set('main', 0);
          $this->db->insert('site_catalog_category');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$newwid}'")->delete('site_catalog_category');
        
        if (isset($array['new_items1']) && is_array($array['new_items1'])) {
         foreach ($array['new_items1'] as $value) {
          $this->db->set('catalogid', $newwid);
          $this->db->set('name_ua', $value['name_ua']);
          $this->db->set('name_ru', $value['name_ru']);
          $this->db->set('opt_price', $value['opt_price']);
          $this->db->insert('site_catalog_prices');
         }
        }
        
        return $newwid;
        
    }
    //---end SAVE WORK region
    
    //++++
    function getAllCatalog() {
        
        $res = $this->db->select('id, name_ua as name')->from('site_catalog')->order_by('id', 'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        return $res;
        
    }
    
    function getClients() {
        
        $res = $this->db->select('id, name_ua as name')->from('site_client')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        return $res;
        
    }
    
    function getAllType($thisid = 0) {
        
        if (is_null($thisid) || $thisid <= 0) $thisid = 0;
        
        $res = $this->db->select('id, name_ua as name')->from('site_catalog')->where("idcomponent = 0 AND id <> '{$thisid}'")->order_by('name', 'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        return $res;
        
    }
    
    function getAllRegion() {
     $res = $this->db->select('id, name_ua as name')->from('site_factory')->order_by('name_ua', 'ASC')->get();
     $res = $res->result_array();
     if (count($res) <= 0) return array();
     return $res;
    }
    function getAllFasade() {
     $res = $this->db->select('id, name_ua as name')->from('site_mat_facade')->order_by('name_ua', 'ASC')->get();
     $res = $res->result_array();
     if (count($res) <= 0) return array();
     return $res;
    }
    function getAllCorpus() {
     $res = $this->db->select('id, name_ua as name')->from('site_mat_corpus')->order_by('name_ua', 'ASC')->get();
     $res = $res->result_array();
     if (count($res) <= 0) return array();
     return $res;
    }
    
    function getAllLook() {
        
        $res = $this->db->select('id, name_ua as name, margin')->from('site_margin_catalog')->where("id > 0")->order_by('name', 'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        return $res;
        
    }
    
    function getActions() {
        
        $res = $this->db->select('id, name_ua as name')->from('site_action')->order_by('name', 'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        return $res;
        
    }
    
    private function image_to_ext($img = '', $ext = '') {
     if (empty($img)) return '';
     if (empty($ext)) return $img;
     $two = explode('.', $img);
     $count = count($two);
     if (!is_array($two) || count($two) < 2) return '';
     $return = '';
     for ($i = 0; $i < $count - 1; ++$i) $return .= $two[$i];
     $return .= $ext.'.'.end($two);
     return $return;
    }
    
    function getObjectE($objid) {
     $objid = (int)$objid;
     $res = $this->db->select('site_catalog.*, site_catalog_site.*')->from('site_catalog')->from('site_catalog_site')->where('site_catalog.id = site_catalog_site.catalogid')->where("site_catalog.id = '{$objid}'")->limit(1)->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->row_array();
     $res['id'] = $objid;
     $res['idcat'] = $this->getCatId($objid);
     $res['image'] = $this->image_to_ext($res['image'], '_big');
     return $res;
    }
    
    function getCatId($objid = 0) {
     $objid = (int)$objid;
     if ($objid <= 0) return 0;
     $res = $this->db->select('categoryid')->from('site_catalog_category')->where('catalogid = '.$this->db->escape($objid))->where('main = 1')->limit(1)->get();
     if ($res->num_rows() <= 0) return 0;
     $res = $res->row_array();
     return $res['categoryid'];
    }
    
    function getObjPrices($objid = 0) {
     $objid = (int)$objid;
     if ($objid <= 0) return array();
     $res = $this->db->select('*')->from('site_catalog_prices')->where('catalogid = '.$this->db->escape($objid))->order_by('id', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    
    function delPrices($id = 0) {
     $id = (int)$id;
     if ($id <= 0) return false;
     $this->db->where('id = '.$this->db->escape($id))->limit(1)->delete('site_catalog_prices');
    }
    
    function getColors($factoryid = 0) {
     $factoryid = (int)$factoryid;
     if ($factoryid < 0) return array();
     $this->db->select('id, name_ua as name, image')->from('site_catalog_color');
     if ($factoryid > 0) $this->db->where('factoryid = '.$this->db->escape($factoryid));
     $res = $this->db->order_by('name_ua', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    
    function getGarOpt($objid = 0) {
     $objid = (int)$objid;
     if ($objid <= 0) return array();
     $res = $this->db->select('site_catalog_color.id, site_catalog_color.name_ua as name, site_catalog_color.image')->from('site_catalog_color')->from('site_catalog_color_catalog')->where('site_catalog_color.id = site_catalog_color_catalog.colorid')->where('site_catalog_color_catalog.catalogid = '.$this->db->escape($objid))->where('site_catalog_color_catalog.corpus = 0')->order_by('site_catalog_color.name_ua', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    function getOnlyID($id) {
     $objid = (int)$id;
     if ($objid <= 0) return array();
     $res = $this->db->select('site_catalog_color.id')->from('site_catalog_color')->from('site_catalog_color_catalog')->where('site_catalog_color.id = site_catalog_color_catalog.colorid')->where('site_catalog_color_catalog.catalogid = '.$this->db->escape($objid))->where('site_catalog_color_catalog.corpus = 0')->order_by('site_catalog_color.name_ua', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     $temp = array();
     foreach ($res as $one) $temp[] = $one['id'];
     return $temp;
    }
    
    function getGarOpt_cor($objid = 0) {
     $objid = (int)$objid;
     if ($objid <= 0) return array();
     $res = $this->db->select('site_catalog_color.id, site_catalog_color.name_ua as name, site_catalog_color.image')->from('site_catalog_color')->from('site_catalog_color_catalog')->where('site_catalog_color.id = site_catalog_color_catalog.colorid')->where('site_catalog_color_catalog.catalogid = '.$this->db->escape($objid))->where('site_catalog_color_catalog.corpus = 1')->order_by('site_catalog_color.name_ua', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    function getOnlyID_cor($id) {
     $objid = (int)$id;
     if ($objid <= 0) return array();
     $res = $this->db->select('site_catalog_color.id')->from('site_catalog_color')->from('site_catalog_color_catalog')->where('site_catalog_color.id = site_catalog_color_catalog.colorid')->where('site_catalog_color_catalog.catalogid = '.$this->db->escape($objid))->where('site_catalog_color_catalog.corpus = 1')->order_by('site_catalog_color.name_ua', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     $temp = array();
     foreach ($res as $one) $temp[] = $one['id'];
     return $temp;
    }
    
    function getGarOptStyle() {
     $res = $this->db->select('site_catalog_style.id, site_catalog_style.name_ua as name')->from('site_catalog_style')->order_by('site_catalog_style.name_ua', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    function getGarOpt_style($objid = 0) {
    $objid = (int)$objid;
     if ($objid <= 0) return array();
     $res = $this->db->select('site_catalog_style.id, site_catalog_style.name_ua as name')->from('site_catalog_style')->from('site_catalog_style_catalog')->where('site_catalog_style.id = site_catalog_style_catalog.styleid')->where('site_catalog_style_catalog.catalogid = '.$this->db->escape($objid))->order_by('site_catalog_style.name_ua', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    function getOnlyID_style($objid = 0) {
     $objid = (int)$objid;
     if ($objid <= 0) return array();
     $res = $this->db->select('site_catalog_style.id')->from('site_catalog_style')->from('site_catalog_style_catalog')->where('site_catalog_style.id = site_catalog_style_catalog.styleid')->where('site_catalog_style_catalog.catalogid = '.$this->db->escape($objid))->order_by('site_catalog_style.name_ua', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     $temp = array();
     foreach ($res as $one) $temp[] = $one['id'];
     return $temp;
    }
    
    function getColorsF($id) {
        
        $id = (int)$id;
        if ($id <= 0) return array();
        
        $res = $this->db->select('site_color.id, site_color.name_ua as name, site_color.img')->from('site_color')->from('site_color_catalog')->where('site_color.id = site_color_catalog.colorid')->where("site_color_catalog.catalogid = '{$id}'")->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        return $res;
        
    }
    
    function getColorsfID($id) {
        
        $id = (int)$id;
        if ($id <= 0) return array();
        
        $res = $this->db->select('site_color.id')->from('site_color')->from('site_color_catalog')->where('site_color.id = site_color_catalog.colorid')->where("site_color_catalog.catalogid = '{$id}'")->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        $temp = array();
        foreach ($res as $one) {
            
            $temp[] = $one['id'];
            
        }
        
        return $temp;
        
    }
    
    function ifIsColor($id) {
        
        $res = $this->db->select('id')->from('site_color')->where("id = '{$id}'")->limit(1)->get();
        
        if ($res->num_rows() <= 0) return false;
        
        return true;
        
    }
    
    function getObjImg($objid) {
     $objid = (int)$objid;
     if ($objid <= 0) return array();
     $res = $this->db->select('*')->from('site_catalog_image')->where("catalogid = '{$objid}'")->order_by('position', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    
    function delImage($id) {
     $id = (int)$id;
     if ($id <= 0) return false;
     $res2 = $this->db->select('catalogid, image')->from('site_catalog_image')->where("id = '{$id}'")->limit(1)->get();
     if ($res2->num_rows() <= 0) return false;
     $res2 = $res2->row_array();
     $this->db->where('id = '.$this->db->escape($id))->delete('site_catalog_image');
     $this->load->library('image_my_lib');
     $this->image_my_lib->removeObjDodImages($res['catalogid'], $res['image']);
     return true;
    }
    
    public function getParentI($id) {
        
        $id = (int)$id;
        if ($id <= 0) return false;
        
        $res = $this->db->select('parentid')->from('site_catalog')->where("id = '{$id}'")->limit(1)->get();
        
        if ($res->num_rows() <= 0) return false;
        
        $res = $res->result_array();
        
        if ($res[0]['parentid'] <= 0) return false;
        
        return $res[0]['parentid'];
        
    }
    
    public function getParentN($id) {
        
        $id = (int)$id;
        if ($id <= 0) return false;
        
        $res = $this->db->select('parentid')->from('site_catalog')->where("id = '{$id}'")->limit(1)->get();
        
        if ($res->num_rows() <= 0) return false;
        
        $res = $res->result_array();
        
        if ($res[0]['parentid'] <= 0) return false;
        
        $res = $this->db->select('name_ua as name')->from('site_catalog')->where("id = '{$res[0]['parentid']}'")->limit(1)->get();
        
        if ($res->num_rows() <= 0) return false;
        
        $res = $res->result_array();
        return $res[0]['name'];
        
    }
    
    public function getUParentI($id) {
        
        $id = (int)$id;
        if ($id <= 0) return false;
        
        return $id;
        
    }
    
    public function getUParentN($id) {
        
        $id = (int)$id;
        if ($id <= 0) return false;
        
        $res = $this->db->select('name_ua as name')->from('site_catalog')->where("id = '{$id}'")->limit(1)->get();
        
        if ($res->num_rows() <= 0) return false;
        
        $res = $res->result_array();
        return $res[0]['name'];
        
    }
    
    public function getComponents($id) {
        
        $id = (int)$id;
        if ($id <= 0) return array();
        
        $res = $this->db->select('id, name_ua as name, image')->from('site_catalog')->where("parentid = '{$id}'")->order_by('name_ua', 'ASC')->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        return $res;
        
    }
    
    public function getCompIdis($id) {
        
        $id = (int)$id;
        if ($id <= 0) return array();
        
        $res = $this->db->select('id')->from('site_catalog')->where("parentid = '{$id}'")->order_by('name_ua', 'ASC')->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        
        $temp = array();
        
        foreach ($res as $one) {
            
            $temp[] = $one['id'];
            
        }
        
        return $temp;
        
    }
    
    public function getAllT($id) {
        
        $id = (int)$id;
        if ($id <= 0) return array();
        
        $res = $this->db->select('id, name_ua as name, image')->from('site_catalog')->where("id <> '{$id}'")->order_by('name_ua', 'ASC')->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        return $res;
        
    }
    
}