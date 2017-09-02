<?php

class Catalog_object_model extends CI_Model
{

private $db_az;

    function __construct()
    {
        parent::__construct();

        #FOR TEST;
        $for_test_string = $this->config->item('test_add');
        if (!empty($for_test_string) && ($pos = strpos($_SERVER['DOCUMENT_ROOT'], $for_test_string)) === false) $_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'].$for_test_string;

    }
    public function copyObject($id){
        $this->load->helper('string');
        $site_catalog = $this->db->select('*')
                ->from('site_catalog')
                ->where('id',$id)
                ->limit(1)
                ->get()
                ->row_array();
        unset($site_catalog['id']);
        $site_catalog['image'] = "";
        $site_catalog['link'] = random_string('alnum',10);
        $site_catalog['manual'] = 0;
        $site_catalog['favorite_count'] = 0;
        $site_catalog['countwatch'] = 0;
        $site_catalog['visible'] = 0;
        
        $this->db->insert('site_catalog',$site_catalog);
        $newid = $this->db->insert_id();
        //=================
        $site_catalog_accessories = $this->db->select('product_id')
                ->from('site_catalog_accessories')
                ->where('main_id',$id)
                ->get()
                ->result_array();
        foreach($site_catalog_accessories as &$one){
            $one['main_id'] = $newid;
        }unset($one);
        if(!empty($site_catalog_accessories)){
            $this->db->insert_batch('site_catalog_accessories', $site_catalog_accessories);
        }
        //===================
        $site_catalog_catalog = $this->db->select('catalogid')
                ->from('site_catalog_catalog')
                ->where('mainid',$id)
                ->get()
                ->result_array();
        foreach($site_catalog_catalog as &$one){
            $one['mainid'] = $newid;
        }unset($one);
        if(!empty($site_catalog_catalog)){
            $this->db->insert_batch('site_catalog_catalog',$site_catalog_catalog);
        }
        //====================
        $site_catalog_category = $this->db->select('categoryid, main')
                ->from('site_catalog_category')
                ->where('catalogid',$id)
                ->get()
                ->result_array();
        foreach($site_catalog_category as &$one){
            $one['catalogid'] = $newid;
        }unset($one);
         if(!empty($site_catalog_category)){
            $this->db->insert_batch('site_catalog_category',$site_catalog_category);
         }
        //====================
        $site_catalog_filters_catalog = $this->db->select('filter_id')
                ->from('site_catalog_filters_catalog')
                ->where('catalog_id',$id)
                ->get()
                ->result_array();
        foreach($site_catalog_filters_catalog as &$one){
            $one['catalog_id'] = $newid;
        }unset($one);
        if(!empty($site_catalog_filters_catalog)){
            $this->db->insert_batch('site_catalog_filters_catalog',$site_catalog_filters_catalog);
        }
        //=====================
        $site_catalog_item = $this->db->select('class, name_ru, value_ru')
                ->from('site_catalog_item')
                ->where('catalogid',$id)
                ->get()
                ->result_array();
        foreach($site_catalog_item as &$one){
            $one['catalogid'] = $newid;
        }unset($one);
        if(!empty($site_catalog_item)){
            $this->db->insert_batch('site_catalog_item',$site_catalog_item);
        }
        //======================
        $site_catalog_phone = $this->db->select('phoneid')
                ->from('site_catalog_phone')
                ->where('catalogid',$id)
                ->get()
                ->result_array();
        foreach($site_catalog_item as &$one){
            $one['catalogid'] = $newid;
        }unset($one);
        if(!empty($site_catalog_phone)){
            $this->db->insert_batch('site_catalog_phone',$site_catalog_phone);
        }
        //======================
        $site_catalog_search = $this->db->select('name, text')
                ->from('site_catalog_search')
                ->where('catalogid',$id)
                ->get()
                ->result_array();
        foreach($site_catalog_search as &$one){
            $one['catalogid'] = $newid;
            $one['catalogid_s'] = $newid;
        }unset($one);
        if(!empty($site_catalog_search)){
            $this->db->insert_batch('site_catalog_search',$site_catalog_search);
        }
        //======================        
        $site_catalog_share_catalog = $this->db->select('shareid')
                ->from('site_catalog_share_catalog')
                ->where('catalogid',$id)
                ->get()
                ->result_array();
        foreach($site_catalog_share_catalog as &$one){
            $one['catalogid'] = $newid;
        }unset($one);
        if(!empty($site_catalog_share_catalog)){
            $this->db->insert_batch('site_catalog_share_catalog',$site_catalog_share_catalog);
        }
        //======================        
//        $site_catalog_share_catalog = $this->db->select('shareid')
//                
//                ->where('catalogid',$id)
//                ->get()
//                ->result_array();
//        foreach($site_catalog_share_catalog as &$one){
//            $one['catalogid'] = $newid;
//        }unset($one);
//        if(!empty($site_catalog_share_catalog)){
//            $this->db->insert_batch('site_catalog_share_catalog',$site_catalog_share_catalog);
//        }
//        //======================      
        return $newid;
    }
    public function updateImgs($data){             
        foreach($data['el'] as $key => $value){            
            $this->db->set('position',$key)
                    ->where('id',$value)
                    ->update('site_catalog_image');                       
        }
    }
    public function sort_products($array) {
        if (!empty($array)) {
            foreach ($array['sort'] as $key => $val) {
                echo $key . '=>' . $val;
                $this->db->where('id', $key);
                $this->db->update('site_catalog', array('position' => $val));
            }
        }
    }

    public function sort_paket_option($array) {
        if (!empty($array)) {
            foreach ($array['sort'] as $key => $val) {
                echo $key . '=>' . $val;
                $this->db->where('id', $key);
                $this->db->update('site_paket_option', array('position' => $val));
            }
        }
    }
    
    public function update_catalog_search($array = array(), $objid = 0) {
     $objid = (int)$objid;
     if (!is_array($array) || empty($array) || $objid <= 0) return false;

     $rowid = $this->db->select('id')->from('site_catalog_search')->where('catalogid = '.$this->db->escape($objid))->limit(1)->get();
     if ($rowid->num_rows() > 0) {
      $rowid = $rowid->row_array();
      $rowid = $rowid['id'];
     } else $rowid = 0;

     $ins_array = array(
      'name' => '',
      'text' => ''
      );

     foreach ($this->config->item('config_languages') as $value) {

      if (isset($array['name'.$value])) $ins_array['name'] .= ' '.$array['name'.$value];
      if (isset($array['text'.$value])) $ins_array['text'] .= ' '.$array['text'.$value];

     }

     if (empty($ins_array)) return false;

     if ($rowid > 0) $this->db->where('id = '.$this->db->escape($rowid))->limit(1)->update('site_catalog_search', $ins_array);
     else {
      $ins_array['catalogid'] = $ins_array['catalogid_s'] = $objid;
      $this->db->insert('site_catalog_search', $ins_array);
     }

     return true;
    }

    public function updatus($objid = 0, $filters = array(), $category = array()) { return false;
     $objid = (int)$objid;

     if ($objid > 0) {

      #remove all current promo by object
      $query = "
       SELECT `site_catalog_share_catalog`.`id`
       FROM (`site_catalog_share_catalog`, `site_catalog_share`)
       WHERE
        `site_catalog_share_catalog`.`shareid` = `site_catalog_share`.`id`
        AND `site_catalog_share_catalog`.`catalogid` = '".$objid."'
        AND site_catalog_share.date_start <= '".date('Y-m-d')."'
        AND site_catalog_share.date_end > '".date('Y-m-d')."'

       GROUP BY `site_catalog_share_catalog`.`id`
      ";
      $res = $this->db->query($query)->result_array();
      foreach ($res as $one)
       $this->db->where('id = '.$this->db->escape($one['id']))->limit(1)->delete('site_catalog_share_catalog');

     }

     $this->load->model('catalog/catalog_s_type_model');

     $already = false;

     $temp = $this->db->select('id, rel_object_id')->from('site_catalog_share')->where('rel_object_id = '.$this->db->escape($objid))->limit(1)->get();
     if ($temp->num_rows() > 0) {
      $temp = $temp->row_array();
      $this->catalog_s_type_model->updatus($temp, $temp['id']);
     }

     if (!empty($filters)) {

      #get shares by only brand filters
      $query = "
       SELECT `site_catalog_share`.`id`, `site_catalog_share`.`rel_brand_id`
       FROM (`site_catalog_filters`, `site_catalog_share`)
       WHERE
        `site_catalog_share`.`rel_brand_id` = `site_catalog_filters`.`id`
        AND `site_catalog_filters`.`id` IN (".implode(',', $filters).")
        AND `site_catalog_filters`.`parent_id` IN (
          SELECT `scf`.`id`
          FROM `site_catalog_filters` as `scf`
          WHERE
           `scf`.`field` = 'brand'

         )

      ";
      $res = $this->db->query($query)->result_array();
      if (!empty($res)) {

       foreach ($res as $one) {
        $this->catalog_s_type_model->updatus($one, $one['id']);
       }

       $already = true;
      }

     }

     if (!$already && !empty($category)) {

      #get shares by only category
      $query = "
       SELECT `site_catalog_share`.`id`, `site_catalog_share`.`rel_category_id`
       FROM (`site_catalog_category`, `site_catalog_share`)
       WHERE
        `site_catalog_share`.`rel_category_id` = `site_catalog_category`.`categoryid`
        AND `site_catalog_category`.`categoryid` IN (".implode(',', $category).")
        AND `site_catalog_category`.`main` = 1

       GROUP BY `site_catalog_share`.`rel_category_id`

      ";
      $res = $this->db->query($query)->result_array();
      if (!empty($res)) {

       foreach ($res as $one) {
        $this->catalog_s_type_model->updatus($one, $one['id']);
       }

       $already = true;
      }

     }

     return true;
    }

    public function getFilters($id = 0) {
        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('site_catalog_category.categoryid, site_category.filter_concat')->from('site_catalog_category')->from('site_category')->where('site_catalog_category.catalogid = '.$this->db->escape($id))->where('site_catalog_category.main = 1')->where('site_catalog_category.categoryid = site_category.id')->limit(1)->get();
        if ($res->num_rows() <= 0) return array();
        $res = $res->row_array();
        $filter_concat = $res['filter_concat'];
        $catid = $res['categoryid'];

        $res = $this->db->select('filter_id')->from('site_catalog_filters_category')->where('category_id = '.$this->db->escape($catid))->get();
        if ($res->num_rows() <= 0 || $filter_concat) {

            $_temp = $res->result_array();

            $catid = $this->getObjectParentMainCat($id);
            $res = $this->db->select('filter_id')->from('site_catalog_filters_category')->where('category_id = '.$this->db->escape($catid))->get();
            if ($res->num_rows() <= 0) $res = array();
            else $res = array_merge($_temp, $res->result_array());

        } else $res = $res->result_array();

        if (empty($res)) return array();

        $idis = array();
        foreach ($res as $one) array_push($idis, $one['filter_id']);
        $idis = array_unique($idis);

        $res = $this->db->select('id, name'.$this->config->item('config_default_lang').' as name')->from('site_catalog_filters')->where_in('id', $idis)->where('parent_id = 0')->where("field <> 'price'")->get();
        if ($res->num_rows() <= 0) return array();
        $res = $res->result_array();

        $child = $this->db->select('id, parent_id, name'.$this->config->item('config_default_lang').' as name')->from('site_catalog_filters')->where('parent_id <> 0')->get();
        if ($child->num_rows() <= 0) return array();
        $child = $child->result_array();

        $return = array();

        foreach ($res as $one) {

            $one['children'] = array();

            foreach ($child as $key2 => $two) {
                if ($two['parent_id'] == $one['id']) {
                    array_push($one['children'], $two);
                    unset($two[$key2]);
                }
            }

           if (!empty($one['children'])) array_push($return, $one);

        }
  return $return;
    }

    public function getFiltersAlready($id = 0) {
     $id = (int)$id;
     if ($id <= 0) return array();

     $res = $this->db->select('filter_id')->from('site_catalog_filters_catalog')->where('catalog_id = '.$this->db->escape($id))->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();

     $return = array();

     foreach ($res as $one) {
      $return[$one['filter_id']] = true;
     }

     return $return;
    }

    public function getSizeTable($id = 0) {
        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('size_table_id, cm')->from('site_size_object')->where('object_id = '.$this->db->escape($id))->get();
        if ($res->num_rows() <= 0) return array();
        $res = $res->result_array();

        $return = array();
        foreach ($res as $one) {
            $return[$one['size_table_id']] = $one['cm'];
        }
        return $return;
    }

    public function getObjectParentMainCat($objid = 0) {
        $objid = (int)$objid;
        if ($objid <= 0) return 0;

        $res = $this->db->select('categoryid')->from('site_catalog_category')->where('catalogid = '.$this->db->escape($objid))->where('main = 1')->limit(1)->get();
        if ($res->num_rows() <= 0) return 0;
        $res = $res->row_array();
        $catid = $res['categoryid'];

        $res = $this->db->select('parentid')->from('site_category')->where('id = '.$this->db->escape($catid))->limit(1)->get();
        if ($res->num_rows() <= 0) return 0;
        $res = $res->row_array();
        if ($res['parentid'] <= 0) return $catid;

        return $res['parentid'];
    }

    public function getCurrs() {
     $res = $this->db->select('id, name')->from('site_currency')->order_by('id', 'DESC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }

    public function getFirstCat() {
     $res = $this->db->select('id')->from('site_category')->where('site_category.parentid <> 0')->order_by('position', 'ASC')->limit(1)->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->row_array();
     return $res['id'];
    }
    public function getObjectImg($objid){
        $res = $this->db->select('image')
                ->from('site_catalog')
                ->where('id',$objid)
                ->limit(1)
                ->get()
                ->row_array();
        return 'images/' . $objid . '/mainimg/'.$res['image'];
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
    public function getPreviewObj($from, $count = 50, $cat = 0, $brand = 0) {

        if ($cat == -1 && !empty($_GET)) {
            $query = "
             SELECT site_catalog.id, site_catalog.link, site_catalog.name".$this->config->item('config_default_lang')." as name, site_catalog.image, site_catalog.price, site_catalog.visible
             FROM (site_catalog)
             WHERE `site_catalog`.`id` not in (
                SELECT `site_catalog`.`id`
                FROM (`site_catalog`, `site_catalog_category`)
                WHERE `site_catalog`.`id` = `site_catalog_category`.`catalogid`
             )
              AND `site_catalog`.`parentid` = 0
              ORDER BY `site_catalog`.`name".$this->config->item('config_default_lang')."` ASC
            ";
            return $this->db->query($query)->result_array();
        }

        if ($cat == -2 && !empty($_GET)) {
            $query = "
             SELECT site_catalog.id, site_catalog.link, site_catalog.name".$this->config->item('config_default_lang')." as name, site_catalog.image, site_catalog.price, site_catalog.visible
             FROM (site_catalog)
             WHERE `site_catalog`.`id` in (
                SELECT `site_catalog`.`id`
                FROM (`site_catalog`, `site_catalog_category`)
                WHERE `site_catalog`.`id` = `site_catalog_category`.`catalogid`
                 AND `site_catalog_category`.`categoryid` IN (
                    SELECT `site_category`.`id`
                    FROM (`site_category`)
                    WHERE `site_category`.`parentid` = 0
                     AND `site_category`.`id` IN (
                        SELECT `site_category`.`parentid`
                        FROM (`site_category`)
                        WHERE `site_category`.`parentid` > 0
                     )
                 )
             )
              AND `site_catalog`.`parentid` = 0
              ORDER BY `site_catalog`.`name".$this->config->item('config_default_lang')."` ASC
            ";
            return $this->db->query($query)->result_array();
        }

        if ($from == 1 || $from == 0) $from = 0;
        else {
            $from = ($count * $from) - $count;
        }

        $this->db->select('site_catalog.id, site_catalog.in_stock, site_catalog.delivery_3_5, site_catalog.avail, site_catalog.position, site_catalog.link, site_catalog.name'.$this->config->item('config_default_lang').' as name, site_catalog.image, site_catalog.price, site_catalog.visible')->from('site_catalog');

        if ($cat > 1 && $cat != 6) $this->db->from('site_catalog_category')->where("site_catalog_category.catalogid = site_catalog.id")->where("site_catalog_category.categoryid = '{$cat}'");

        if ($brand > 0) $this->db->where("site_catalog.factoryid = '{$brand}'");

        $this->db->where("site_catalog.parentid = 0");
        

        if($cat == 1) $this->db->where('site_catalog.product-visible', 1);
        if($cat == 6) $this->db->where('site_catalog.product-visible', 0);

        // -------- where paket_option = 0 where paket option is a Paket options bay objects -----
          $this->db->where('site_catalog.paket_option', 0);
        // ---------------- end paket ---------------------

        $this->db->limit($count, $from);
        $res = $this->db
          ->order_by('site_catalog.product-visible', 'DESC')
          ->order_by('site_catalog.in_stock', 'DESC')
          ->order_by('site_catalog.delivery_3_5', 'ASC')
          ->order_by('site_catalog.position', 'ASC')
                ->get();

        if ($res->num_rows() <= 0) return array();
        $res = $res->result_array();

        foreach ($res as &$one) {
         $one['image'] = $this->image_to_ext($one['image'], '_obj');
        } unset($one);

        return $res;

    }

    public function setPriceObj($id, $price) {

        $id = (int)$id;
        if ($id <= 0) return false;

        $price = $price;

        $this->db->set('price', $price)->where("id = '{$id}'")->update('site_catalog');

        /*PRICES*/
       /* $t_temp = $this->db->select('field, koef')->from('site_currency')->get();
        if ($t_temp->num_rows() > 0) {
         $t_temp = $t_temp->result_array();
         foreach ($t_temp as $value) {
          $this->db->set($value['field'], ceil($price*$value['koef']));
         }
         $this->db->where('id = '.$this->db->escape($id))->limit(1)->update('site_catalog');
        }*/
        /*END*/

        return true;

    }

    public function setAdminRateObj($id, $rate) {

        $id = (int)$id;
        if ($id <= 0) return false;

        $rate = $rate;

        $this->db->set('admin_rate', $rate)->where("id = '{$id}'")->update('site_catalog');

        return true;

    }

    public function setWHDW($id, $width, $height, $depth) {
     $id = (int)$id;
     if ($id <= 0) return false;

     $this->db->set('size_width', $width)->set('size_height', $height)->set('size_depth', $depth)->where('id = '.$this->db->escape($id))->update('site_catalog');

     return true;
    }

    //+
    public function countProduct($cat = 0, $brand = 0) {

        $this->db->select('COUNT(*) as count');
        $this->db->from('site_catalog');

        if ($cat > 0) $this->db->from('site_catalog_category')->where("site_catalog_category.catalogid = site_catalog.id")->where("site_catalog_category.categoryid = '{$cat}'");

        if ($brand > 0) $this->db->where("site_catalog.factoryid = '{$brand}'");

        $this->db->where("site_catalog.parentid = 0");

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
    }

    public function getAcc() {
        $this->load->model('catalog/catalog_catalog_model');
        $res = $this->catalog_catalog_model->selectAllAcc(0, true);
        return $res;
    }
    public function getObj($id = 0) {
        $this->load->model('catalog/catalog_catalog_model');
        $res = $this->catalog_catalog_model->selectAllObj($id);
        return $res;
    }

    public function getCatsO($objectid = 0) {
     $objectid = (int)$objectid;
     if ($objectid <= 0) return array();
     $res = $this->db->select('site_category.id, site_category.parentid, site_category.name'.$this->config->item('config_default_lang').' as name, site_catalog_category.main')->from('site_category')->from('site_catalog_category')->where('site_catalog_category.catalogid = '.$this->db->escape($objectid))->where('site_catalog_category.categoryid = site_category.id')->order_by('site_category.position', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     foreach ($res as &$one) {
      $temp_arr = array();
      $temp_id = $one['parentid'];
      while($temp_id > 0) {
       $temp_res = $this->db->select('parentid, name'.$this->config->item('config_default_lang').' as name')->from('site_category')->where('id = '.$this->db->escape($temp_id))->limit(1)->get();
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

    public function getAccO($objectid = 0) {
     $objectid = (int)$objectid;
     if ($objectid <= 0) return array();
     $res = $this->db->select('*')->from('site_catalog_accessories')->where('site_catalog_accessories.main_id = '.$this->db->escape($objectid))->order_by('site_catalog_accessories.id', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();

    foreach ($res as $key => $value) {
      $tmp_res = array();
      $tmp_res = $this->db->select('id, name_ru')->where('id', $value['product_id'])->from('site_catalog')->limit(1)->get();
      if($tmp_res->num_rows() <= 0) return false;
      $tmp_res = $tmp_res->result_array();
      foreach ($tmp_res as $one) {
        $tmp[] = $one;
      }unset($one);
    } unset($value);

     return $tmp;
    }

    public function getObjO($objectid = 0) {
     $objectid = (int)$objectid;
     if ($objectid <= 0) return array();
     $res = $this->db->select('*')->from('site_catalog_catalog')
     ->where('site_catalog_catalog.mainid = '.$this->db->escape($objectid))
     ->order_by('site_catalog_catalog.id', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();

    foreach ($res as $key => $value) {
      $tmp_res = array();
      $tmp_res = $this->db->select('id, name_ru')->where('id', $value['catalogid'])
      ->from('site_catalog')->limit(1)->get();
      if($tmp_res->num_rows() <= 0) return false;
      $tmp_res = $tmp_res->result_array();
      foreach ($tmp_res as $one) {
        $tmp[] = $one;
      }unset($one);
    } unset($value);
     return $tmp;
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
        $result = $this->db->select('id, name'.$this->config->item('config_default_lang').' as name')->from('site_factory')->order_by('name'.$this->config->item('config_default_lang'), 'ASC')->get();
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
        #return false;

        $this->load->library('image_my_lib');

        //1. get components if is and delete that with images
        /*
        $comps = $this->db->select('id, image')->from('site_catalog')->where("parentid = '{$objid}'")->get();

        if ($comps->num_rows() > 0) {

            $comps = $comps->result_array();

            foreach ($comps as $one) {

                $this->db->where("id = '{$one['id']}'")->limit(1)->delete('site_catalog');

                $this->image_my_lib->removeObjImages($one['id'], $one['image']);
                $this->image_my_lib->removeObjDodImages($one['id'], $one['image']);

                @rmdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$one['id'].'/mainimg');
                @rmdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$one['id'].'/moreimg');
                @rmdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$one['id']);


            }

        }*/

        //2. delete object with images
        $res = $this->db->select('id, image, image_hover')->from('site_catalog')->where("id = '$objid'")->limit(1)->get();

        if ($res->num_rows() <= 0) return false;

        $res = $res->row_array();

        $this->image_my_lib->removeObjImages($res['id'], $res['image']);
        $this->image_my_lib->removeObjHoverImages($res['id'], $res['image_hover']);

        $res_imgs = $this->db->select('image')->from('site_catalog_image')->where('catalogid = '.$this->db->escape($res['id']))->get();
        if ($res_imgs->num_rows() > 0) {
         $res_imgs = $res_imgs->result_array();
         foreach ($res_imgs as $value) {
          $this->image_my_lib->removeObjDodImages($res['id'], $value['image']);
         }
        }

        @rmdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$res['id'].'/mainimg');
        @rmdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$res['id'].'/moreimg');
        @rmdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$res['id']);

        $this->db->where("id = '{$objid}'")->limit(1)->delete('site_catalog');
        $this->db->where("catalogid = '{$objid}'")->limit(1)->delete('site_catalog_search');
        #$this->db->where('object_id = '.$this->db->escape($objid))->delete('site_size_object');
        #$this->db->where("catalogid = '{$objid}'")->limit(1)->delete('site_catalog_color_catalog');
        $this->db->where("catalogid = '{$objid}'")->delete('site_catalog_item');

        $this->db->where("main_id = '{$objid}'")->delete('site_catalog_accessories');
        $this->db->where("product_id = '{$objid}'")->delete('site_catalog_accessories');
        $this->db->where("mainid = '{$objid}'")->delete('site_catalog_catalog');
        $this->db->where("catalogid = '{$objid}'")->delete('site_catalog_catalog');

        $this->db->where("catalogid = '{$objid}'")->delete('site_color_catalog');

        $this->db->where("catalogid = '{$objid}'")->delete('site_catalog_category');
        $this->db->where("catalogid = '{$objid}'")->delete('site_catalog_image');

    }

    public function removeComponent($id) {
     $id = (int)$id;
     if ($id <= 0) return false;
     $this->db->set('parentid', 0)->where('id = '.$this->db->escape($id))->limit(1)->update('site_catalog');
     return true;
    }

    public function removeComplect($id) {
     $id = (int)$id;
     $parentid = 0;
     if (isset($_POST['parentid'])) $parentid = (int)$_POST['parentid'];
     if ($parentid <= 0 || $id <= 0) return false;

     $this->db->where('catalogid = '.$this->db->escape($id))->where('maincatalogid = '.$this->db->escape($parentid))->limit(1)->delete('site_catalog_complect');
     return true;
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

    public function translitIt($text = '') {
     if (empty($text)) return '';

     $tr_array = array(
           "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
           "Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
           "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
           "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
           "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
           "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
           "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
           "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
           "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
           "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
           "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
           "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
           "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
           " "=> "-", "."=> "", "/"=> "_",
           'І' => 'i', 'і' => 'i', 'Ї' => 'ii', 'ї' => 'ii', 'Є' => 'e',
           'є' => 'e', 'Ё' => 'ee', 'ё' => 'ee', '{' => '-', '}' => '-',
           '(' => '-', ')' => '-', ';' => '-', ',' => '-'
          );

     $text = preg_replace('/[^A-Za-z0-9_\-]/', '', strtr($text, $tr_array));
     return strtolower($text);
    }

    public function delItem($id) {
     $id = (int)$id;
     if ($id <= 0) return false;
     $this->db->where('id = '.$this->db->escape($id))->delete('site_catalog_item');
    }

    public function getItems($objectid = 0) {
     $objectid = (int)$objectid;
     if ($objectid <= 0) return array();
     $res = $this->db->select('*')->from('site_catalog_item')->where('catalogid = '.$this->db->escape($objectid))->order_by('id', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }

    public function upObj($array) {

        if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id'])) {
         #@chdir($_SERVER['DOCUMENT_ROOT'].'/images');
         @mkdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id'], 0777);
        }
        if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id'].'/mainimg')) {
         #@chdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id']);
         @mkdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id'].'/mainimg', 0777);
        }
        if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id'].'/moreimg')) {
         #@chdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id']);
         @mkdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$array['id'].'/moreimg', 0777);
        }


        if ($array['manual']) $this->db->set('link', $array['link']);
        else {
         if (isset($array['link']) && !empty($array['link'])) {
          $pos = strrpos($array['link'], '-'.$array['id']);
          if ($pos !== false) $array['link'] = substr($array['link'], 0, $pos);
         }
         $this->db->set('link', rtrim($array['link'], '-').'-'.$array['id']);
        }
        $this->db->set('manual', $array['manual']);


        if (isset($array['is_slader'])) $this->db->set('is_slader', $array['is_slader']);
        if (isset($array['parentid'])) $this->db->set('parentid', $array['parentid']);
        if (isset($array['pageid'])) $this->db->set('pageid', $array['pageid']);

        if (isset($array['super'])) $this->db->set('super', $array['super']);
        if (isset($array['popular'])) $this->db->set('popular', $array['popular']);
        if (isset($array['avail'])) $this->db->set('avail', $array['avail']);
        if (isset($array['textileid'])) $this->db->set('textileid', $array['textileid']);

        if (isset($array['workhours'])) $this->db->set('workhours', $array['workhours']);
        if (isset($array['run'])) $this->db->set('run', $array['run']);
        if (isset($array['contact_price'])) $this->db->set('contact_price', (bool)$array['contact_price']);
        if (isset($array['year'])) $this->db->set('year', (int)$array['year']);
        if (isset($array['vizok'])) $this->db->set('vizok', (bool)$array['vizok']);
        if (isset($array['lizing'])) $this->db->set('lizing', (bool)$array['lizing']);
        if (isset($array['currency'])) $this->db->set('currency', (int)$array['currency']);

        if (isset($array['articul'])) $this->db->set('articul', $array['articul']);

        if (isset($array['width'])) $this->db->set('width', $array['width']);
        if (isset($array['height'])) $this->db->set('height', $array['height']);
        if (isset($array['depth'])) $this->db->set('depth', $array['depth']);

        if(isset($array['items_obj_color']) && !empty($array['items_obj_color'])) 
          $this->db->set('color', (int)$array['items_obj_color'][$array['id']]);

        if (isset($array['old_price'])) $this->db->set('old_price', $array['old_price']);

        if(isset($array['radio-vis-obj'])) $this->db->set('product-visible', $array['radio-vis-obj']);

        if (isset($array['video'])) $this->db->set('video', $array['video']);
        if (isset($array['gift'])) $this->db->set('gift', $array['gift']);
        if (isset($array['date_gift'])) $this->db->set('date_gift', $array['date_gift']);

        #$this->db->set('factoryid', $array['factoryid']);
        $this->db->set('price', $array['price']);
        $this->db->set('visible', $array['visible']);
        $this->db->set('in_stock', $array['in_stock']);
        $this->db->set('delivery_3_5', $array['delivery_3_5']);
        $this->db->set('show_cart', $array['show_cart']);

        foreach ($this->config->item('config_languages') as $value) {

         if (isset($array['engine'.$value])) $this->db->set('engine'.$value, $array['engine'.$value]);
         if (isset($array['zhatka'.$value])) $this->db->set('zhatka'.$value, $array['zhatka'.$value]);
         if (isset($array['kpp'.$value])) $this->db->set('kpp'.$value, $array['kpp'.$value]);

         if (isset($array['name'.$value]))
          $this->db->set('name'.$value, $array['name'.$value]);

         if (isset($array['title'.$value]))
          $this->db->set('title'.$value, $array['title'.$value]);

         if (isset($array['keyword'.$value]))
          $this->db->set('keyword'.$value, $array['keyword'.$value]);

         if (isset($array['description'.$value]))
          $this->db->set('description'.$value, $array['description'.$value]);

         if (isset($array['text'.$value]))
          $this->db->set('text'.$value, $array['text'.$value]);

         if (isset($array['shorttext'.$value]))
          $this->db->set('shorttext'.$value, $array['shorttext'.$value]);

         if (isset($array['features'.$value]))
          $this->db->set('features'.$value, $array['features'.$value]);

        }



        #$this->db->set('short_desc_ua', $array['short_desc_ua']);       

        $this->db->where('id = '.$this->db->escape($array['id']))->limit(1)->update('site_catalog');
        if (isset($array['shareid']) && is_array($array['shareid'])){
            $this->db->where('catalogid',$array['id'])->delete('site_catalog_share_catalog');
            foreach($array['shareid'] as $one){
             $this->db->set('shareid',$one)
                     ->set('catalogid',$array['id'])
                     ->insert('site_catalog_share_catalog');
            }
        }

        /*PRICES*/
        /*
        $t_temp = $this->db->select('field, koef')->from('site_currency')->get();
        if ($t_temp->num_rows() > 0) {
         $t_temp = $t_temp->result_array();
         foreach ($t_temp as $value) {
          $this->db->set($value['field'], ceil($array['price']*$value['koef']));
         }
         $this->db->where('id = '.$this->db->escape($array['id']))->limit(1)->update('site_catalog');
        }
        /*END*/

        if (isset($array['use_size']) && $array['use_size'] && isset($array['cm']) && !empty($array['cm'])) {

            $this->db->where('object_id = '.$this->db->escape($array['id']))->delete('site_size_object');

            foreach ($array['cm'] as $key => $value) {
                $this->db->set('object_id', $array['id'])->set('size_table_id', (int)$key)->set('cm', $value)->insert('site_size_object');
            }
        }

        $this->db->where('catalog_id = '.$this->db->escape($array['id']))->delete('site_catalog_filters_catalog');
        if (isset($array['filters']) && !empty($array['filters'])) {
            foreach ($array['filters'] as $value) {
                $this->db->set('catalog_id', (int)$array['id'])->set('filter_id', (int)$value)->insert('site_catalog_filters_catalog');
            }
        }
        /*
        if (isset($array['items_colf']) && !empty($array['items_colf'])) {
         $items = $array['items_colf'];
         $this->db->where("mainid = '{$array['id']}'")->delete('site_catalog_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('mainid', $array['id'])->set('catalogid', $items[$i])->insert('site_catalog_catalog');
         }
         $items = array();
        } else $this->db->where("mainid = '{$array['id']}'")->delete('site_catalog_catalog');
  */
        if (isset($array['items_colf']) && !empty($array['items_colf'])) {
         $items = $array['items_colf'];
         $this->db->where("mainid = '{$array['id']}'")->delete('site_catalog_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('mainid', $array['id'])->set('catalogid', $items[$i])->insert('site_catalog_catalog');
         }
        } else $this->db->where("mainid = '{$array['id']}'")->delete('site_catalog_catalog');

        if (isset($array['items_acc'])) {
         $items = $array['items_acc'];
         $this->db->where("main_id = '{$array['id']}'")->delete('site_catalog_accessories');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('main_id', $array['id'])->set('product_id', $items[$i])->insert('site_catalog_accessories');
         }
         $items = array();
        } else $this->db->where("main_id = '{$array['id']}'")->delete('site_catalog_accessories');

// delete miniimage object =========================================

        if(isset($array['el'])){
          $res =[];

          $idis = [];
          foreach($array['el'] as $one){
            $idis[] = $one;
          } unset($one);

          $res = $this->db->select('*')->where_in('site_catalog_image.id', $idis)->from('site_catalog_image')->get();
          if($res->num_rows() <= 0) $res = [];
          $res = $res->result_array();

          $result_del = $this->db->select('*')->where_in('site_catalog_image.catalogid', $array['id'])->from('site_catalog_image')->get();
          if($result_del->num_rows() <= 0) $result_del = [];
          $result_del = $result_del->result_array();

          foreach($result_del as $key => $val){
            if(in_array($val['id'], $idis)) unset($result_del[$key]);
          } unset($val);

          $this->db->where("catalogid = '{$array['id']}'")->delete('site_catalog_image');

          foreach($res as $key => $value) {
            $this->db->insert('site_catalog_image', $value);
          } unset($value);

          $this->load->library('image_my_lib');
          foreach($result_del as $res){
            $this->image_my_lib->removeObjDodImages($res['catalogid'], $res['image']);
          } unset($res);
        } else {
          $res = array();
          $res = $this->db->select('*')->where_in('site_catalog_image.catalogid', $array['id'])->from('site_catalog_image')->get();
          if($res->num_rows() > 0){
            $res = $res->result_array();

            $this->load->library('image_my_lib');

            foreach($res as $image){
              $this->image_my_lib->removeObjDodImages($image['catalogid'], $image['image']);
            } unset($res);

            $this->db->where("catalogid = '{$array['id']}'")->delete('site_catalog_image');
          }
        }

// -------------------- Paket option for telephone ------------------------------

        if(isset($array['option']) && !empty($array['option'])){
          $this->db->where('site_paket_option_catalog.mainid', $array['id'])->delete('site_paket_option_catalog');

          foreach($array['option'] as $key => $value){
            if(isset($value['id']) && !empty($value['id']) && $value['id'] > 0) {
              $this->db->set('site_paket_option_catalog.mainid', $array['id']);
              $this->db->set('site_paket_option_catalog.catalogid', $value['id']);
              $this->db->set('site_paket_option_catalog.categoryid', $value['catalogid']);
              $this->db->set('site_paket_option_catalog.visible', 1);
              $this->db->insert('site_paket_option_catalog');
            }
          } unset($value);
        } else $this->db->where('site_paket_option_catalog.mainid', $array['id'])->delete('site_paket_option_catalog');

// save date color_catalog ================================================================================

       if (isset($array['items_obj']) && !empty($array['items_obj'])) {
          $this->db->where("main_id = '{$array['id']}'")->delete('site_color_catalog');
          $this->db->where("catalogid = '{$array['id']}'")->delete('site_color_catalog');

          $fruits = [];
          $fruits = $array['items_obj'];
          krsort($fruits);

          foreach ($array['items_obj'] as $key => $value) {
            $this->db->where("catalogid = '{$key}'")->delete('site_color_catalog');
           $this->db->set('main_id', $array['id'])->set('catalogid', (int)$key)->set('colorid', (int)$value)->insert('site_color_catalog');
          } unset($value);

          foreach ($array['items_obj'] as $key => $value) {
           $this->db->set('main_id', (int)$key)->set('catalogid', (int)$array['id'])->set('colorid', (int)$array['items_obj_color'][$array['id']])->insert('site_color_catalog');

           foreach($fruits as $k => $v){
              if($k != $key) {
                $this->db->set('main_id', (int)$key)->set('catalogid', (int)$k)->set('colorid', (int)$v)->insert('site_color_catalog');
              }
            } unset($v);

          } unset($value);

         } else $this->db->where("main_id = '{$array['id']}'")->delete('site_color_catalog');

         if (isset($array['items_obj_new']) && !empty($array['items_obj_new'])) {

          $fruits = [];
          $fruits = $array['items_obj_new'];
          if(isset($array['items_obj']) && !empty($array['items_obj'])) {
            $old_items = $array['items_obj'];
          }
          krsort($fruits);

          foreach ($array['items_obj_new'] as $key => $value) {
           $this->db->set('main_id', $array['id'])->set('catalogid', (int)$key)->set('colorid', (int)$value)->insert('site_color_catalog');
          } unset($value);

          foreach ($array['items_obj_new'] as $key => $value) {
            $this->db->set('main_id', (int)$key)->set('catalogid', (int)$array['id'])->set('colorid', (int)$array['items_obj_color'][$array['id']])->insert('site_color_catalog');
            
            foreach($fruits as $k => $v){
                if($key != $k) {
                  $this->db->set('main_id', (int)$key)->set('catalogid', (int)$k)->set('colorid', (int)$v)->insert('site_color_catalog');
                }
              } unset($v);

          } unset($value);

          if(isset($array['items_obj']) && !empty($array['items_obj'])) {
            foreach($array['items_obj'] as $key => $value) {
                foreach($array['items_obj_new'] as $k => $v){
                    $this->db->set('main_id', (int)$k)->set('catalogid', (int)$key)->set('colorid', (int)$v)->insert('site_color_catalog');
                    
                      $this->db->set('main_id', (int)$key)->set('catalogid', (int)$k)->set('colorid', (int)$v)->insert('site_color_catalog');
                    
                } unset($v);
              }
            }
         }

         // ======================================= UPDATE VIDEO FOR SITE ==============================================

        if(isset($array['old_video']) && !empty($array['old_video'])) {
          $this->db->where("catalogid = '{$array['id']}'")->delete('site_video');

          foreach($array['old_video'] as $value) {
            if(isset($value) && !empty($value)) {
              $this->db->set('site_video.catalogid', $array['id'])->set('site_video.text_ru', $value)->insert('site_video');
            }
          } unset($value);
        } else $this->db->where("catalogid = '{$array['id']}'")->delete('site_video');

        if(isset($array['video_new']) && !empty($array['video_new']) && count($array['video_new']) >= 1) {
          foreach($array['video_new'] as $value) {
            if(isset($value) && !empty($value)) {
                $this->db->set('site_video.catalogid', $array['id'])->set('site_video.text_ru', $value)->insert('site_video');
              }
          } unset($value);
        }

         // ============================================== END CREATE NEW FILTERS - COLOR ===============================

        if (isset($array['items_cat'])) {
         $items = $array['items_cat'];
         $this->db->where("catalogid = '{$array['id']}'")->delete('site_catalog_category');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $array['id'])->set('categoryid', $items[$i]);

          if ((!isset($array['cat_main']) || $array['cat_main'] <= 0) && $i == 0) $this->db->set('main', 1);
          elseif (isset($array['cat_main']) && $array['cat_main'] == $items[$i]) $this->db->set('main', 1);
          else $this->db->set('main', 0);

          $this->db->insert('site_catalog_category');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$array['id']}'")->delete('site_catalog_category');

        if (isset($array['items_man'])) {
         $items = $array['items_man'];
         $this->db->where("catalogid = '{$array['id']}'")->delete('site_catalog_phone');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $array['id'])->set('phoneid', $items[$i])->insert('site_catalog_phone');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$array['id']}'")->delete('site_catalog_phone');

        if (isset($array['items_colf_sty'])) {
         $items = $array['items_colf_sty'];
         $this->db->where("catalogid = '{$array['id']}'")->delete('site_catalog_style_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $array['id'])->set('styleid', $items[$i])->insert('site_catalog_style_catalog');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$array['id']}'")->delete('site_catalog_style_catalog');

        if (isset($array['items1']) && is_array($array['items1'])) {
         foreach ($array['items1'] as $value) {
          $this->db->set('catalogid', $array['id']);

          foreach ($this->config->item('config_languages') as $_value) {
           if (isset($value['name'.$_value])) $this->db->set('name'.$_value, $value['name'.$_value]);
           if (isset($value['value'.$_value])) $this->db->set('value'.$_value, $value['value'.$_value]);
          }

          $this->db->where('id = '.$this->db->escape($value['id']))->update('site_catalog_item');
         }
        } else $this->db->where('catalogid = '.$this->db->escape($array['id']))->delete('site_catalog_item');

        if (isset($array['new_items1']) && is_array($array['new_items1'])) {
         foreach ($array['new_items1'] as $value) {
          $this->db->set('catalogid', $array['id']);

          foreach ($this->config->item('config_languages') as $_value) {
           if (isset($value['name'.$_value])) $this->db->set('name'.$_value, $value['name'.$_value]);
           if (isset($value['value'.$_value])) $this->db->set('value'.$_value, $value['value'.$_value]);
          }

          $this->db->insert('site_catalog_item');
         }
        }

        // if (isset($array['items_colors'])) {
        //  $items = $array['items_colors'];
        //  $this->db->where("catalogid = '{$array['id']}'")->where('is_corpus = 0')->delete('site_color_catalog');
        //  $count_i = count($items);
        //  for ($i = 0; $i < $count_i; ++$i) {
        //   $this->db->set('catalogid', $array['id'])->set('colorid', $items[$i])->set('is_corpus', 0)->insert('site_color_catalog');
        //  }
        //  $items = array();
        // } else $this->db->where("catalogid = '{$array['id']}'")->where('is_corpus = 0')->delete('site_color_catalog');

        // if (isset($array['items_colors_c'])) {
        //  $items = $array['items_colors_c'];
        //  $this->db->where("catalogid = '{$array['id']}'")->where('is_corpus = 1')->delete('site_color_catalog');
        //  $count_i = count($items);
        //  for ($i = 0; $i < $count_i; ++$i) {
        //   $this->db->set('catalogid', $array['id'])->set('colorid', $items[$i])->set('is_corpus', 1)->insert('site_color_catalog');
        //  }
        //  $items = array();
        // } else $this->db->where("catalogid = '{$array['id']}'")->where('is_corpus = 1')->delete('site_color_catalog');

        /*
        if (isset($array['items_colors_tt'])) {
         $items = $array['items_colors_tt'];
         $this->db->where("catalogid = '{$array['id']}'")->delete('site_sofa_textile_cat_catalog');
         foreach ($items as $key => $value) {
          $this->db->set('catalogid', $array['id'])->set('sofa_cat_id', $key)->set('price', $value)->insert('site_sofa_textile_cat_catalog');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$array['id']}'")->delete('site_sofa_textile_cat_catalog');
        */

        if (isset($array['comp'])) {
         $this->db->set('parentid', 0)->where("parentid = '{$array['id']}'")->update('site_catalog');
         $comp = $array['comp'];
         foreach ($comp as $c_c) {
          $this->db->set('parentid', $array['id'])->where("id = '{$c_c}'")->update('site_catalog');
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

        $hover_img = $this->image_my_lib->createMainHoverImage($array['id']);
        if (isset($hover_img['image']) && !empty($hover_img['image'])) {

         $res = $this->db->select('image_hover')->from('site_catalog')->where('id = '.$this->db->escape($array['id']))->limit(1)->get();
         if ($res->num_rows() > 0) {
          $res = $res->row_array();
          if (isset($res['image_hover']) && !empty($res['image_hover'])) {
           $this->image_my_lib->removeObjHoverImages($array['id'], $res['image_hover']);
          }
         }

         $this->db->set('image_hover', $hover_img['image']);
         $this->db->where("id = '{$array['id']}'");
         $this->db->update('site_catalog');
        }

        //123
        if(isset($array['radio-vis-obj']) && $array['radio-vis-obj'] == 0){
          $pos = $this->db->select('id, position')->order_by('position', 'desc')->from('site_catalog')->get();
          if($pos->num_rows() <= 0) return false;
          $pos = $pos->result_array();
          $res = $pos[0]['position'];
          //echo "<pre>"; print_r($pos); die();

          $this->db->set('position', $scs_temp)->where('id = '.$this->db->escape($scs_temp))->update('site_catalog');
        }

        if(isset($array['3g'])) {
          $this->db->set('site_catalog.3g', (int)$array['3g'])->where('site_catalog.id', $array['id'])->update('site_catalog');
        }

        // 123321
        
        if (!isset($array['upimgs'])) $array['upimgs'] = array();
        else $array['upimgs'] = @$this->image_my_lib->createImgs($array['id'], $array['upimgs']);

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

        #updatus
        #$this->updatus($array['id'], (isset($array['filters']) ? $array['filters'] : array()), (isset($array['items_cat']) ? $array['items_cat'] : array()) );
        #this is the end... */

        #update fulltext search
        $this->update_catalog_search($array, $array['id']);
        #this is the end... */

        return $array['id'];
    }

    public function insObj($array) {

        if (isset($array['is_slader'])) $this->db->set('is_slader', $array['is_slader']);
        if (isset($array['delivery_3_5'])) $this->db->set('delivery_3_5', $array['delivery_3_5']);
        if (isset($array['parentid'])) $this->db->set('parentid', $array['parentid']);
        if (isset($array['pageid'])) $this->db->set('pageid', $array['pageid']);

        if (isset($array['super'])) $this->db->set('super', $array['super']);
        if (isset($array['popular'])) $this->db->set('popular', $array['popular']);
        if (isset($array['avail'])) $this->db->set('avail', $array['avail']);
        if (isset($array['textileid'])) $this->db->set('textileid', $array['textileid']);

        if (isset($array['workhours'])) $this->db->set('workhours', $array['workhours']);
        if (isset($array['run'])) $this->db->set('run', $array['run']);
        if (isset($array['contact_price'])) $this->db->set('contact_price', (bool)$array['contact_price']);
        if (isset($array['year'])) $this->db->set('year', (int)$array['year']);
        if (isset($array['vizok'])) $this->db->set('vizok', (bool)$array['vizok']);
        if (isset($array['currency'])) $this->db->set('currency', (int)$array['currency']);

        if(isset($array['items_obj_color']) && !empty($array['items_obj_color'])) 
          $this->db->set('color', (int)$array['items_obj_color'][$array['id']]);

        if (isset($array['articul'])) $this->db->set('articul', $array['articul']);

        if (isset($array['width'])) $this->db->set('width', $array['width']);
        if (isset($array['height'])) $this->db->set('height', $array['height']);
        if (isset($array['depth'])) $this->db->set('depth', $array['depth']);

        if (isset($array['old_price'])) $this->db->set('old_price', $array['old_price']);

        if (isset($array['video'])) $this->db->set('video', $array['video']);

        if(isset($array['radio-vis-obj'])) $this->db->set('product-visible', $array['radio-vis-obj']);

        if ($array['manual']) $this->db->set('link', $array['link']);
        $this->db->set('manual', $array['manual']);

        #$this->db->set('factoryid', $array['factoryid']);
        $this->db->set('price', $array['price']);

        foreach ($this->config->item('config_languages') as $value) {

         if (isset($array['engine'.$value])) $this->db->set('engine'.$value, $array['engine'.$value]);
         if (isset($array['zhatka'.$value])) $this->db->set('zhatka'.$value, $array['zhatka'.$value]);
         if (isset($array['kpp'.$value])) $this->db->set('kpp'.$value, $array['kpp'.$value]);

         if (isset($array['name'.$value]))
          $this->db->set('name'.$value, $array['name'.$value]);

         if (isset($array['title'.$value]))
          $this->db->set('title'.$value, $array['title'.$value]);

         if (isset($array['keyword'.$value]))
          $this->db->set('keyword'.$value, $array['keyword'.$value]);

         if (isset($array['description'.$value]))
          $this->db->set('description'.$value, $array['description'.$value]);

         if (isset($array['text'.$value]))
          $this->db->set('text'.$value, $array['text'.$value]);

         if (isset($array['shorttext'.$value]))
          $this->db->set('shorttext'.$value, $array['shorttext'.$value]);

         if (isset($array['features'.$value]))
          $this->db->set('features'.$value, $array['features'.$value]);
        }
  if (isset($array['gift'])) $this->db->set('gift', $array['gift']);
        if (isset($array['date_gift'])) $this->db->set('date_gift', $array['date_gift']);

        $this->db->set('image', '');
        $this->db->set('visible', 1);
        $this->db->set('in_stock', 1);

        $this->db->set('countwatch', 0);

        $this->db->insert('site_catalog');

        $newwid = $this->db->insert_id();
        if (isset($array['shareid']) && is_array($array['shareid'])){
            foreach($array['shareid'] as $one){
                $this->db->set('shareid', $one);
                $this->db->set('catalogid',$newwid)
                        ->insert('site_catalog_share_catalog');
            }
        }

        if (!$array['manual']) $this->db->set('link', rtrim($array['link'], '-').'-'.$newwid);

        $scs_temp = $this->db->insert_id();
        if(isset($array['radio-vis-obj']) && !empty($array['radio-vis-obj']) && $array['radio-vis-obj'] == 0){
          $pos = $this->db->select('id, position')->order_by('position', 'desc')->from('site_catalog')->get();
          if($pos->num_rows() <= 0) return false;
          $pos = $pos->result_array();

          $this->db->set('position', $scs_temp)->where('id = '.$this->db->escape($scs_temp))->update('site_catalog');
        } else $this->db->set('position', $scs_temp)->where('id = '.$this->db->escape($scs_temp))->update('site_catalog');

        /*PRICES*/
        /*
        $t_temp = $this->db->select('field, koef')->from('site_currency')->get();
        if ($t_temp->num_rows() > 0) {
         $t_temp = $t_temp->result_array();
         foreach ($t_temp as $value) {
          $this->db->set($value['field'], ceil($array['price']*$value['koef']));
         }
         $this->db->where('id = '.$this->db->escape($scs_temp))->limit(1)->update('site_catalog');
        }
        /*END*/

        #@chdir($_SERVER['DOCUMENT_ROOT'].'/images');
        @mkdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$newwid, 0777);
        #@chdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$newwid);
        @mkdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$newwid.'/mainimg', 0777);
        @mkdir($_SERVER['DOCUMENT_ROOT'].'/images/'.$newwid.'/moreimg', 0777);

        if (isset($array['items_colf'])) {
         $items = $array['items_colf'];
         $this->db->where("mainid = '{$newwid}'")->delete('site_catalog_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('mainid', $newwid)->set('catalogid', $items[$i])->insert('site_catalog_catalog');
         }
         $items = array();
        } else $this->db->where("mainid = '{$newwid}'")->delete('site_catalog_catalog');

        if (isset($array['items_obj'])) {
         $items = $array['items_obj'];
         $this->db->where("mainid = '{$newwid}'")->delete('site_catalog_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('mainid', $newwid)->set('catalogid', $items[$i])->insert('site_catalog_catalog');
         }
         $items = array();
        } else $this->db->where("mainid = '{$newwid}'")->delete('site_catalog_catalog');

        if(isset($array['option']) && !empty($array['option'])){

        }

        if (isset($array['items_colf_acc'])) {
         $items = $array['items_colf_acc'];
         $this->db->where("main_id = '{$newwid}'")->delete('site_catalog_accessories');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('main_id', $newwid)->set('product_id', $items[$i])->insert('site_catalog_accessories');
         }
         $items = array();
        } else $this->db->where("main_id = '{$newwid}'")->delete('site_catalog_accessories');

        // if (isset($array['items_colf_color'])) {
        //  $this->db->where("main_id = '{$newwid}'")->delete('site_color_catalog');

        //  foreach ($array['items_colf_color'] as $key => $value) {
        //   $this->db->set('main_id', $newwid)->set('catalogid', (int)$key)->set('colorid', (int)$value)->insert('site_color_catalog');
        //  }

        // } else $this->db->where("main_id = '{$newwid}'")->delete('site_color_catalog');

        if (isset($array['items_cat'])) {
         $items = $array['items_cat'];
         $this->db->where("catalogid = '{$newwid}'")->delete('site_catalog_category');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $newwid)->set('categoryid', $items[$i]);

          if ((!isset($array['cat_main']) || $array['cat_main'] <= 0) && $i == 0) $this->db->set('main', 1);
          elseif (isset($array['cat_main']) && $array['cat_main'] == $items[$i]) $this->db->set('main', 1);
          else $this->db->set('main', 0);

          $this->db->insert('site_catalog_category');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$newwid}'")->delete('site_catalog_category');

        if (isset($array['items_man'])) {
         $items = $array['items_man'];
         $this->db->where("catalogid = '{$newwid}'")->delete('site_catalog_phone');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $newwid)->set('phoneid', $items[$i])->insert('site_catalog_phone');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$newwid}'")->delete('site_catalog_phone');

// Popular product 

        if (isset($array['items_colf']) && !empty($array['items_colf'])) {
         $items = $array['items_colf'];
         $this->db->where("mainid = '{$newwid}'")->delete('site_catalog_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('mainid', $newwid)->set('catalogid', $items[$i])->insert('site_catalog_catalog');
         }
        } else $this->db->where("mainid = '{$newwid}'")->delete('site_catalog_catalog');

// Acsessuaries product

      if (isset($array['items_acc'])) {
         $items = $array['items_acc'];
         $this->db->where("main_id = '{$newwid}'")->delete('site_catalog_accessories');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('main_id', $newwid)->set('product_id', $items[$i])->insert('site_catalog_accessories');
         }
         $items = array();
        } else $this->db->where("main_id = '{$newwid}'")->delete('site_catalog_accessories');

// insert items_obj_color

        if (isset($array['items_obj']) && !empty($array['items_obj'])) {
          $this->db->where("main_id = '{$newwid}'")->delete('site_color_catalog');
          $this->db->where("catalogid = '{$newwid}'")->delete('site_color_catalog');

          foreach ($array['items_obj'] as $key => $value) {
           $this->db->set('main_id', $newwid)->set('catalogid', (int)$key)->set('colorid', (int)$value)->insert('site_color_catalog');
          } unset($value);

          foreach ($array['items_obj'] as $key => $value) {
           $this->db->set('main_id', (int)$key)->set('catalogid', (int)$newwid)->set('colorid', (int)$array['items_obj_color'][$newwid])->insert('site_color_catalog');
           $this->db->set('main_id', (int)$key)->set('catalogid', (int)$newwid)->set('colorid', (int)$value)->insert('site_color_catalog');
          } unset($value);
         } else $this->db->where("main_id = '{$array['id']}'")->delete('site_color_catalog');

         if (isset($array['items_obj_new']) && !empty($array['items_obj_new'])) {

          foreach ($array['items_obj_new'] as $key => $value) {
           $this->db->set('main_id', $newwid)->set('catalogid', (int)$key)->set('colorid', (int)$value)->insert('site_color_catalog');
          } unset($value);

          foreach ($array['items_obj_new'] as $key => $value) {
           $this->db->set('main_id', (int)$key)->set('catalogid', (int)$newwid)->set('colorid', (int)$array['items_obj_color'][$newwid])->insert('site_color_catalog');
          } unset($value);
         }

        if (isset($array['items_colf_sty'])) {
         $items = $array['items_colf_sty'];
         $this->db->where("catalogid = '{$newwid}'")->delete('site_catalog_style_catalog');
         $count_i = count($items);
         for ($i = 0; $i < $count_i; ++$i) {
          $this->db->set('catalogid', $newwid)->set('styleid', $items[$i])->insert('site_catalog_style_catalog');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$newwid}'")->delete('site_catalog_style_catalog');

        if (isset($array['new_items1']) && is_array($array['new_items1'])) {
         foreach ($array['new_items1'] as $value) {
          $this->db->set('catalogid', $newwid);

          foreach ($this->config->item('config_languages') as $_value) {
           if (isset($value['name'.$_value])) $this->db->set('name'.$_value, $value['name'.$_value]);
           if (isset($value['value'.$_value])) $this->db->set('value'.$_value, $value['value'.$_value]);
          }

          $this->db->insert('site_catalog_item');
         }
        }

        if(isset($array['3g'])) {
          $this->db->set('site_catalog.3g', (int)$array['3g'])->where('site_catalog.id', $newwid)->update('site_catalog');
        }

        // if (isset($array['items_colors'])) {
        //  $items = $array['items_colors'];
        //  $this->db->where("catalogid = '{$newwid}'")->where('is_corpus = 0')->delete('site_color_catalog');
        //  $count_i = count($items);
        //  for ($i = 0; $i < $count_i; ++$i) {
        //   $this->db->set('catalogid', $newwid)->set('colorid', $items[$i])->set('is_corpus', 0)->insert('site_color_catalog');
        //  }
        //  $items = array();
        // } else $this->db->where("catalogid = '{$newwid}'")->where('is_corpus = 0')->delete('site_color_catalog');

        // if (isset($array['items_colors_c'])) {
        //  $items = $array['items_colors_c'];
        //  $this->db->where("catalogid = '{$newwid}'")->where('is_corpus = 1')->delete('site_color_catalog');
        //  $count_i = count($items);
        //  for ($i = 0; $i < $count_i; ++$i) {
        //   $this->db->set('catalogid', $newwid)->set('colorid', $items[$i])->set('is_corpus', 1)->insert('site_color_catalog');
        //  }
        //  $items = array();
        // } else $this->db->where("catalogid = '{$newwid}'")->where('is_corpus = 1')->delete('site_color_catalog');

        /*
        if (isset($array['items_colors_tt'])) {
         $items = $array['items_colors_tt'];
         $this->db->where("catalogid = '{$newwid}'")->delete('site_sofa_textile_cat_catalog');
         foreach ($items as $key => $value) {
          $this->db->set('catalogid', $newwid)->set('sofa_cat_id', $key)->set('price', $value)->insert('site_sofa_textile_cat_catalog');
         }
         $items = array();
        } else $this->db->where("catalogid = '{$newwid}'")->delete('site_sofa_textile_cat_catalog');
        */


        #updatus
        #if (isset($array['items_cat'])) {
         #$this->updatus(0, array(), $array['items_cat']);
        #}
        #this is the end... */

        #update fulltext search
        $this->update_catalog_search($array, $newwid);
        #this is the end... */


        return $newwid;

    }
    //---end SAVE WORK region

    //++++
    function getAllCatalog() {

        $res = $this->db->select('id, name_ua as name')->from('site_catalog')->order_by('name_ua', 'ASC')->get();
        $res = $res->result_array();

        if (count($res) <= 0) return array();

        return $res;

    }

    function getClients() {

        $res = $this->db->select('id, name')->from('site_client')->get();
        $res = $res->result_array();

        if (count($res) <= 0) return array();

        return $res;

    }

    function getAllType($thisid = 0) {

        if (is_null($thisid) || $thisid <= 0) $thisid = 0;

        $res = $this->db->select('id, name'.$this->config->item('config_default_lang').' as name')->from('site_catalog')->where("idcomponent = 0 AND id <> '{$thisid}'")->order_by('name'.$this->config->item('config_default_lang'), 'ASC')->get();
        $res = $res->result_array();

        if (count($res) <= 0) return array();

        return $res;

    }

    function getAllRegion() { return array();
     $res = $this->db->select('id, name'.$this->config->item('config_default_lang').' as name')->from('site_factory')->order_by('name', 'ASC')->get();
     $res = $res->result_array();
     if (count($res) <= 0) return array();
     return $res;
    }
    function getAllFasade() { return array();
     $res = $this->db->select('id, name')->from('site_mat_facade')->order_by('name', 'ASC')->get();
     $res = $res->result_array();
     if (count($res) <= 0) return array();
     return $res;
    }
    function getAllCorpus() { return array();
     $res = $this->db->select('id, name')->from('site_mat_corpus')->order_by('name', 'ASC')->get();
     $res = $res->result_array();
     if (count($res) <= 0) return array();
     return $res;
    }

    function getAllLook() {

        $res = $this->db->select('id, name, margin')->from('site_margin_catalog')->where("id > 0")->order_by('name', 'ASC')->get();
        $res = $res->result_array();

        if (count($res) <= 0) return array();

        return $res;

    }

    function getActions() {
     $res = $this->db->select('id, name'.$this->config->item('config_default_lang').' as name')->from('site_catalog_share')->order_by('name', 'ASC')->get();
     $res = $res->result_array();
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
     $res = $this->db->select('site_catalog.*')->from('site_catalog')->where("site_catalog.id = '{$objid}'")->limit(1)->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->row_array();
     $res['id'] = $objid;
     $res['idcat'] = $this->getCatId($objid);
     $res['image'] = $this->image_to_ext($res['image'], '_obj');
     $res['shareid'] = $this->db->select('shareid')
             ->from('site_catalog_share_catalog')
             ->where('catalogid',$objid)
             ->get()
             ->result_array();
     $_tmp = [];
     foreach($res['shareid'] as $one){
         $_tmp[] = $one['shareid'];
     }
     $res['shareid'] = $_tmp;
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

    function getObjPrices($objid = 0) { return array();
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
     $this->db->select('id, name_ru as name, image')->from('site_color');
     #if ($factoryid > 0) $this->db->where('factoryid = '.$this->db->escape($factoryid));
     $res = $this->db->order_by('name', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }

    function getGarOpt($objid = 0) {
     $objid = (int)$objid;
     if ($objid <= 0) return array();
     $res = $this->db->select('site_color.id, site_color.name_ru as name, site_color.image')->from('site_color')->from('site_color_catalog')->where('site_color.id = site_color_catalog.colorid')->where('site_color_catalog.catalogid = '.$this->db->escape($objid))->order_by('site_color.name_ru', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    function getOnlyID($id) {
     $objid = (int)$id;
     if ($objid <= 0) return array();
     $res = $this->db->select('site_color.id')->from('site_color')->from('site_color_catalog')->where('site_color.id = site_color_catalog.colorid')->where('site_color_catalog.catalogid = '.$this->db->escape($objid))->order_by('site_color.name_ru', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     $temp = array();
     foreach ($res as $one) $temp[] = $one['id'];
     return $temp;
    }

    function getGarOpt_cor($objid = 0) {
     return array();
     $objid = (int)$objid;
     if ($objid <= 0) return array();
     $res = $this->db->select('site_catalog_color.id, site_catalog_color.name, site_catalog_color.image')->from('site_catalog_color')->from('site_catalog_color_catalog')->where('site_catalog_color.id = site_catalog_color_catalog.colorid')->where('site_catalog_color_catalog.catalogid = '.$this->db->escape($objid))->where('site_catalog_color_catalog.corpus = 1')->order_by('site_catalog_color.name', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    function getOnlyID_cor($id) {
     return array();
     $objid = (int)$id;
     if ($objid <= 0) return array();
     $res = $this->db->select('site_catalog_color.id')->from('site_catalog_color')->from('site_catalog_color_catalog')->where('site_catalog_color.id = site_catalog_color_catalog.colorid')->where('site_catalog_color_catalog.catalogid = '.$this->db->escape($objid))->where('site_catalog_color_catalog.corpus = 1')->order_by('site_catalog_color.name', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     $temp = array();
     foreach ($res as $one) $temp[] = $one['id'];
     return $temp;
    }

    function getGarOptStyle() {
     $res = $this->db->select('site_catalog_style.id, site_catalog_style.name'.$this->config->item('config_default_lang').' as name')->from('site_catalog_style')->order_by('site_catalog_style.name'.$this->config->item('config_default_lang'), 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    function getGarOpt_style($objid = 0) {
    $objid = (int)$objid;
     if ($objid <= 0) return array();
     $res = $this->db->select('site_catalog_style.id, site_catalog_style.name'.$this->config->item('config_default_lang').' as name')->from('site_catalog_style')->from('site_catalog_style_catalog')->where('site_catalog_style.id = site_catalog_style_catalog.styleid')->where('site_catalog_style_catalog.catalogid = '.$this->db->escape($objid))->order_by('site_catalog_style.name'.$this->config->item('config_default_lang'), 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }
    function getOnlyID_style($objid = 0) {
     $objid = (int)$objid;
     if ($objid <= 0) return array();
     $res = $this->db->select('site_catalog_style.id')->from('site_catalog_style')->from('site_catalog_style_catalog')->where('site_catalog_style.id = site_catalog_style_catalog.styleid')->where('site_catalog_style_catalog.catalogid = '.$this->db->escape($objid))->order_by('site_catalog_style.name'.$this->config->item('config_default_lang'), 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     $temp = array();
     foreach ($res as $one) $temp[] = $one['id'];
     return $temp;
    }

    function getColorsF($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('site_catalog.id, site_catalog.name'.$this->config->item('config_default_lang').' as name')
        ->from('site_catalog')->from('site_catalog_catalog')
        ->where('site_catalog.id = site_catalog_catalog.catalogid')
        ->where("site_catalog_catalog.mainid = '{$id}'")->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();
        return $res;

    }

    function getAccesuariesID($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('site_catalog_accessories.product_id as id')->from('site_catalog_accessories')
        ->where("site_catalog_accessories.main_id = '{$id}'")->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();

        $temp = array();
        foreach ($res as $one) {

            $temp[] = $one['id'];

        }

        return $temp;

    }

    function getColorsfID($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('site_catalog_catalog.catalogid as id')->from('site_catalog_catalog')
        ->where("site_catalog_catalog.mainid = '{$id}'")->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();

        $temp = array();
        foreach ($res as $one) {

            $temp[] = $one['id'];

        }

        return $temp;

    }

    function getColorsOldID($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('site_color_catalog.catalogid as id')->from('site_color_catalog')
        ->where("site_color_catalog.main_id = '{$id}'")->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();

        $temp = array();
        foreach ($res as $one) {

            $temp[] = $one['id'];

        }

        return $temp;

    }

    function getColorsF_acc($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('site_catalog.id, site_catalog.name'.$this->config->item('config_default_lang').' as name')->from('site_catalog')->from('site_catalog_accessories')->where('site_catalog.id = site_catalog_accessories.product_id')->where("site_catalog_accessories.main_id = '{$id}'")->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();
        return $res;

    }

    function getColorsfID_acc($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('site_catalog_accessories.product_id as id')->from('site_catalog_accessories')->where("site_catalog_accessories.main_id = '{$id}'")->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();

        $temp = array();
        foreach ($res as $one) {

            $temp[] = $one['id'];

        }

        return $temp;

    }

    function getColorsF_color($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('site_catalog.id, site_catalog.name'.$this->config->item('config_default_lang').' as name, site_color_catalog.colorid')
        ->from('site_catalog')->from('site_color_catalog')
        ->where('site_catalog.id = site_color_catalog.catalogid')
        ->where("site_color_catalog.main_id = '{$id}'")->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();
        return $res;

    }

    function getColorsfID_color($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('site_color_catalog.catalogid as id')->from('site_color_catalog')->where("site_color_catalog.main_id = '{$id}'")->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();

        $temp = array();
        foreach ($res as $one) {

            $temp[] = $one['id'];

        }

        return $temp;

    }

    function getCatalogCatalog($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('site_catalog.id, site_catalog.name'.$this->config->item('config_default_lang').' as name, site_catalog_catalog.id as idcatalog')
        ->from('site_catalog')->from('site_catalog_catalog')
        ->where('site_catalog.id = site_catalog_catalog.catalogid')
        ->where("site_catalog_catalog.mainid = '{$id}'")->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();
        return $res;

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
     $res = $this->db->select('catalogid, image')->from('site_catalog_image')->where("id = '{$id}'")->limit(1)->get();
     if ($res->num_rows() <= 0) return false;
     $res = $res->row_array();
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

        $res = $this->db->select('name'.$this->config->item('config_default_lang').' as name')->from('site_catalog')->where("id = '{$res[0]['parentid']}'")->limit(1)->get();

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

        $res = $this->db->select('name'.$this->config->item('config_default_lang').' as name')->from('site_catalog')->where("id = '{$id}'")->limit(1)->get();

        if ($res->num_rows() <= 0) return false;

        $res = $res->result_array();
        return $res[0]['name'];

    }

    public function getComponents($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('id, name'.$this->config->item('config_default_lang').' as name, image')->from('site_catalog')->where("parentid = '{$id}'")->order_by('name'.$this->config->item('config_default_lang'), 'ASC')->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();
        return $res;

    }

    public function getCompIdis($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('id')->from('site_catalog')->where("parentid = '{$id}'")->order_by('name'.$this->config->item('config_default_lang'), 'ASC')->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();

        $temp = array();

        foreach ($res as $one) {

            $temp[] = $one['id'];

        }

        return $temp;

    }

    public function getComplects($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('site_catalog.id, site_catalog.name'.$this->config->item('config_default_lang').' as name, site_catalog.image, site_catalog_complect.count')->from('site_catalog')->from('site_catalog_complect')->where("site_catalog.id = site_catalog_complect.catalogid")->where('site_catalog_complect.maincatalogid = '.$this->db->escape($id))->order_by('site_catalog.name'.$this->config->item('config_default_lang'), 'ASC')->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();
        return $res;

    }

    public function getComplectIdis($id) {

        $id = (int)$id;
        if ($id <= 0) return array();

        $res = $this->db->select('site_catalog.id')->from('site_catalog')->from('site_catalog_complect')->where("site_catalog.id = site_catalog_complect.catalogid")->where('site_catalog_complect.maincatalogid = '.$this->db->escape($id))->order_by('site_catalog.name'.$this->config->item('config_default_lang'), 'ASC')->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();

        $temp = array();

        foreach ($res as $one) {

            $temp[] = $one['id'];

        }

        return $temp;

    }
    public function getObjects(){
        $res = $this->db->select('id, name_ru as name')
                ->from('site_catalog')
                ->where('visible',1)
                ->get()
                ->result_array();
        return $res;
    }
    public function getAllT($id) {

        $id = (int)$id;
        if ($id < 0) return array();

        $res = $this->db->query("SELECT site_catalog.id, site_catalog.parentid, site_catalog.name".$this->config->item('config_default_lang')." as name, site_catalog.image, sc.name".$this->config->item('config_default_lang')." as parentname FROM site_catalog LEFT JOIN site_catalog as sc ON site_catalog.parentid = sc.id WHERE site_catalog.id <> '{$id}' ORDER BY site_catalog.id ASC");

        #$res = $this->db->select('id, parentid, name, image')->from('site_catalog')->where("id <> '{$id}'")->order_by('name', 'ASC')->get();

        if ($res->num_rows() <= 0) return array();

        $res = $res->result_array();
        return $res;

    }

    public function getManagers() {
     $res = $this->db->select('id, name'.$this->config->item('config_default_lang').' as name, phone')->from('site_phone')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();
     return $res;
    }

    public function getManagersO($objectid = 0, $idis = false) {
     $objectid = (int)$objectid;
     if ($objectid <= 0) return array();

     $res = $this->db->select('site_phone.id, site_phone.name'.$this->config->item('config_default_lang').' as name, site_phone.phone')->from('site_catalog')->from('site_phone')->from('site_catalog_phone')->where("site_catalog.id = site_catalog_phone.catalogid")->where('site_catalog_phone.phoneid = site_phone.id')->order_by('site_phone.name'.$this->config->item('config_default_lang'), 'ASC')->where('site_catalog_phone.catalogid = '.$this->db->escape($objectid))->get();

     if ($res->num_rows() <= 0) return array();

     $res = $res->result_array();

     if ($idis) {
      $temp = array();
      foreach ($res as $one) {
       $temp[] = $one['id'];
      }
      $res = $temp;
     }

     return $res;
    }

    public function getNEWColors() {
     $res = $this->db->select('id, name'.$this->config->item('config_default_lang').' as name')->from('site_color')->order_by('position', 'ASC')->get();
     return $res->result_array();
    }

    public function getNEWColorsByID($objid = 0, $onlyid = false, $corpus = false) {
     $return = array();

     $objid = (int)$objid;
     if ($objid <= 0) return array();

     $this->db->select('site_color.id, site_color.name'.$this->config->item('config_default_lang').' as name')->from('site_color')->from('site_color_catalog')->where('site_color.id = site_color_catalog.colorid')->where('site_color_catalog.catalogid = '.$this->db->escape($objid))->order_by('site_color.position', 'ASC');

     if ($corpus) $this->db->where('site_color_catalog.is_corpus = 1');
     else $this->db->where('site_color_catalog.is_corpus = 0');

     $res = $this->db->get();
     if ($res->num_rows() <= 0) return $return;
     $res = $res->result_array();

     if ($onlyid) {
      foreach ($res as $one) {
       array_push($return, $one['id']);
      }
     } else $return = $res;

     return $return;
    }

    public function delAcc($id){
      $this->db->where('product_id', $id)->delete('site_catalog_accessories');
    }

    public function delObj($id){
      $this->db->where('catalogid', $id)->delete('site_color_catalog');
      $this->db->where('main_id', $id)->delete('site_color_catalog');
    }

    public function delColf($id){
      $this->db->where('catalogid', $id)->delete('site_catalog_catalog');
    }

    public function getTextile() {
     $res = $this->db->select('id, name'.$this->config->item('config_default_lang').' as name')->from('site_sofa_textile_cat')->order_by('position', 'ASC')->get();
     return $res->result_array();
    }

    public function getTextileByID($objid = 0, $onlyid = false) {
     $return = array();

     $objid = (int)$objid;
     if ($objid <= 0) return array();

     $this->db->select('site_sofa_textile_cat.id, site_sofa_textile_cat.name'.$this->config->item('config_default_lang').' as name, site_sofa_textile_cat_catalog.price')->from('site_sofa_textile_cat')->from('site_sofa_textile_cat_catalog')->where('site_sofa_textile_cat.id = site_sofa_textile_cat_catalog.sofa_cat_id')->where('site_sofa_textile_cat_catalog.catalogid = '.$this->db->escape($objid))->order_by('site_sofa_textile_cat.position', 'ASC');

     $res = $this->db->get();
     if ($res->num_rows() <= 0) return $return;
     $res = $res->result_array();

     if ($onlyid) {
      foreach ($res as $one) {
       array_push($return, $one['id']);
      }
     } else $return = $res;

     return $return;
    }

    public function getCategoryOption(){
      $res = $this->db->select('site_paket_option_category.id, site_paket_option_category.name_ru as name')
      ->from('site_paket_option_category')->get();

      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();

      foreach($res as $key => $value){
        $res[$key]['children'] = $this->generateOptionForCategory($value['id']);
      } unset($value);

      return $res;
    }

    private function generateOptionForCategory($id = 0){
      if($id <= 0) return false;
      $id = (int)$id;

      $this->db->select('site_paket_option.id, site_paket_option.name_ru as name, site_paket_option_category_catalog.catalogid, site_paket_option_category_catalog.mainid')
      ->from('site_paket_option_category_catalog')->from('site_paket_option')
      ->where('site_paket_option_category_catalog.catalogid', $id)
      ->where('site_paket_option_category_catalog.mainid = site_paket_option.id');

      $res = $this->db->get();

      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();

      return $res;
    }

    public function getIDisOption($id){
      if(!isset($id) && empty($id) && $id <= 0) return false;
      $id = (int)$id;

      $res = $this->db->select('*')->where('site_paket_option_catalog.mainid', $id)
      ->where('site_paket_option_catalog.visible', 1)
      ->from('site_paket_option_catalog')->get();

      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();

      $idis = [];
      foreach($res as $value){
        $idis[] = $value['catalogid'];
      } unset($value);

      return $idis;
    }

    public function SearchOrder($array = array()){
      if(!isset($array) && empty($array)) return false;

      $match = $array['search'];

      $this->db->select('*');
      $this->db->from('site_order');

      $this->db->like('site_order.name',$match);
      $this->db->or_like('site_order.phone',$match);

      $res = $this->db->get();

      if($res->num_rows() <= 0) {
        $phone = substr($array['search'], 0, 3);
        $phone = '('.$phone.')';
        $phone2 = substr($array['search'], 3);
        $phone2 = substr($array['search'], 3, 3);
        $phone3 = substr($array['search'], 6, 2);
        $phone4 = substr($array['search'], 8, 2);
        $phoe_all = '+38 '.$phone.' '.$phone2.'–'.$phone3.'–'.$phone4;

        $this->db->select('*');
        $this->db->from('site_order');

        $this->db->like('site_order.name',$match);
        $this->db->or_like('site_order.phone',$phoe_all);

        $res = $this->db->get();
      }

      if($res->num_rows() <= 0) {
        $phone = substr($array['search'], 0, 3);
        $phone = '('.$phone.')';
        $phone2 = substr($array['search'], 3);
        $phone2 = substr($array['search'], 3, 4);
        $phone3 = substr($array['search'], 8, 2);
        $phone4 = substr($array['search'], 11, 2);

        $phoe_all = '+38 '.$phone.$phone2.'–'.$phone3.'–'.$phone4;

        $this->db->select('*');
        $this->db->from('site_order');

        $this->db->like('site_order.name',$match);
        $this->db->or_like('site_order.phone',$phoe_all);

        $res = $this->db->get();
      }
      if($res->num_rows() <= 0) return false;

      $res = $res->result_array();

      return $res;
    }
    public function SearchOrderOneClick($array = array()){
      if(!isset($array) && empty($array)) return false;

      $match = $array['search'];

      $this->db->select('*');
      $this->db->from('site_order_click');

      $this->db->like('site_order_click.name',$match);
      $this->db->or_like('site_order_click.phone',$match);

      $res = $this->db->get();

      if($res->num_rows() <= 0) {
        $phone = substr($array['search'], 0, 3);
        $phone = '('.$phone.')';
        $phone2 = substr($array['search'], 3);
        $phone2 = substr($array['search'], 3, 3);
        $phone3 = substr($array['search'], 6, 2);
        $phone4 = substr($array['search'], 8, 2);
        $phoe_all = '+38 '.$phone.' '.$phone2.'–'.$phone3.'–'.$phone4;

        $this->db->select('*');
        $this->db->from('site_order_click');

        $this->db->like('site_order_click.name',$match);
        $this->db->or_like('site_order_click.phone',$phoe_all);

        $res = $this->db->get();
      }

      if($res->num_rows() <= 0) return false;

      $res = $res->result_array();

      return $res;
    }

    public function remove_ajax_price_object($id = 0, $price = 0){
      if(!isset($id) && empty($id) && $id <= 0) return false;

      $this->db
                ->where('site_catalog.id', $id)
                ->set('site_catalog.price', $price)
                ->update('site_catalog');
    }
    public function delete_ajax_cat($id = 0, $id_obj){
      if(!isset($id) && empty($id) <= 0) return false;

      $this->db
              ->where("site_catalog_category.catalogid = '{$id_obj}'")
              ->where('site_catalog_category.categoryid', $id)
              ->delete('site_catalog_category');
    }

    public function getVideo($id) {
        if(!isset($id) && empty($id) && $id <= 0) return false;
        $id = (int)$id;

        $res = $this->db
                      ->select('site_video.id, site_video.text_'.SITELANG.' as text, site_video.visible, site_video.position')
                      ->where('site_video.catalogid', $id)
                      ->order_by('site_video.id', 'ASC')
                      ->from('site_video')
                      ->get();

          if($res->num_rows() <= 0) return false;
          $res = $res->result_array();

          return $res;
       }

    public function get_phones($param = '', $mobile = false, $limit = 0) {
      $limit = (int)$limit;
      $this->db->select('id, image, paket, name_'.SITELANG.' as name, phone')->from('site_phone');
      
      if ($param == 'head') $this->db->where('visible_onhead = 1')->order_by('position_onhead', 'ASC');
      elseif ($param == 'top') $this->db->where('visible_ontop = 1')->order_by('position_ontop', 'ASC');
      elseif ($param == 'foot') $this->db->where('visible_onfoot = 1')->order_by('position_onfoot', 'ASC');
      else $this->db->order_by('position', 'ASC');
      
      if ($mobile) $this->db->where('mobile = 1');
      else $this->db->where('mobile = 0');
      
      $this->db->where('visible = 1');
      
      if ($limit > 0) $this->db->limit($limit);
      
      $res = $this->db->get();
      if ($res->num_rows() <= 0) return array();
      $res = $res->result_array();
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

       public function removeStatusObject($status = '', $id = 0) {
        if(!isset($status) && empty($status)) return false;
        $id = (int)$id;
        
        if($status == 'avail'){
          $data = array(
               'avail' => 1,
               'delivery_3_5' => 0,
               'in_stock' => 0
            );
        } if($status == 'delivery_3_5'){
          $data = array(
               'avail' => 0,
               'delivery_3_5' => 1,
               'in_stock' => 1
            );
        } if($status == 'in_stock'){
          $data = array(
               'avail' => 0,
               'delivery_3_5' => 0,
               'in_stock' => 1
            );
        }

        if(isset($data) && !empty($data)) {
          $this->db->where('site_catalog.id', $id);
          $this->db->update('site_catalog', $data);
         }
       }

       public function resetPositionPakets($data, $id){
        foreach($data['sort'] as $key => $value){            
            $this->db->set('position',$key)
                    ->where('main_id',$value)
                    ->update('site_pakets_ccatalog');
        }
    }
}