<?php

class Catalog_catalog_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function setVisible($id) {
        $this->db->set('visible', 1);
        $this->db->where("id = '{$id}'")->update('site_category');
    }

    public function setUnVisible($id) {
        $this->db->set('visible', 0);
        $this->db->where("id = '{$id}'")->update('site_category');
    }

    //position page
    public function setUp($id) {
     $res = $this->db->select('parentid, position')->from('site_category')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();

     if (count($res) <= 0) return false;

     $pos = $res[0];

     $res = $this->db->select('id, position')->from('site_category')->where("position < '{$pos['position']}' AND parentid = '{$pos['parentid']}'")->limit(1)->order_by('position', 'DESC')->get();
     $res = $res->result_array();

     if (count($res) <= 0) return false;

     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_category');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_category');
    }

    public function setDown($id) {
     $res = $this->db->select('parentid, position')->from('site_category')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();

     if (count($res) <= 0) return false;

     $pos = $res[0];

     $res = $this->db->select('id, position')->from('site_category')->where("position > '{$pos['position']}' AND parentid= '{$pos['parentid']}'")->limit(1)->order_by('position', 'ASC')->get();
     $res = $res->result_array();

     if (count($res) <= 0) return false;

     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_category');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_category');
    }

    //other functions
    public function selectPreviewAll($parentid = 0, $visible = false, $catid = 0) {
     $parentid = (int)$parentid;
     $return = array();
     $this->db->select('site_category.id, site_category.link, site_category.parentid, site_category.name'.$this->config->item('config_default_lang').' as name, site_category.visible_ontop, site_category.visible')->from('site_category');
     if ($parentid > 0) $this->db->where('site_category.parentid = '.$this->db->escape($parentid));
     else $this->db->where('site_category.parentid = 0');

     if ($catid > 0) $this->db->where('id <> '.$this->db->escape($catid));

     if ($visible) $this->db->where('site_category.visible = 1');

     $res = $this->db->order_by('position', 'ASC')->get();

     if ($res->num_rows() > 0) {
      $res = $res->result_array();
      foreach ($res as &$one) {
       $one['children'] = $this->selectPreviewAll($one['id'], $visible, $catid);
      } unset($one);
      $return = $res;
     }

     return $return;
    }

    public function selectAllAcc() {
        $res = $this->db->select('id, link, name_ru')
        ->where('visible', 1)->where('product-visible', 0)
        ->order_by('name_ru', 'ASC')
        ->from('site_catalog')->get();
        if($res->num_rows() <= 0) return false;
        $res = $res->result_array();

        foreach($res as $key => $value){
            $idis[] = $this->getChildrenAccID($value['id'], 0);
        } unset($value);
        $idis = array_unique($idis);

        $array_category = $this->getArrayCategoryForAcc($idis);

        foreach($array_category as $key => $one){
            $array_category[$key]['children'] = $this->getAccForCategory($one['id']);
        }

     return $array_category;
    }
    public function getArrayCategoryForAcc($idis){
        if(!isset($idis) && empty($idis) && count($idis) <= 0) return false;

        $res = $this->db->select('site_category.name_'.SITELANG.' as name, site_category.id')
        ->where_in('site_category.id', $idis)
        ->order_by('site_category.name_ru', 'ASC')
        ->from('site_category')
        ->get();

        if($res->num_rows() <= 0) return false;
        $res = $res->result_array();

        return $res;
    }
    public function getAccForCategory($id = 0){
        if($id <= 0) return false;
        $id = (int)$id;

        $res = $this->db->select('*')->where('site_catalog_category.categoryid', $id)
        ->from('site_catalog_category')
        ->get();

        if($res->num_rows() <= 0) return false;
        $res = $res->result_array();

        $idis = [];
        foreach($res as $value){
            $idis[] = $value['catalogid'];
        } unset($value);
        $idis = array_unique($idis);

        if(isset($idis) && !empty($idis) && count($idis) > 0){
            $result = $this->db->select('site_catalog.id, site_catalog.name_'.SITELANG.' as name')
            ->where('site_catalog.product-visible', 0)
            ->where_in('site_catalog.id', $idis)
            ->from('site_catalog')->order_by('site_catalog.name_ru', 'ASC')->get();

            if($result->num_rows() <= 0) return false;
            $result = $result->result_array();

            return $result;
        }
    }
    public function getChildrenAccID($id, $row = 0){
        if($id <= 0) return false;
        $id = (int)$id;

        $res = $this->db->select('*')
        ->where('site_catalog_category.catalogid', $id)
        ->from('site_catalog_category')
        ->limit(1)
        ->get();

        if($res->num_rows() <= 0) return false;
        $category = $res->row_array()['categoryid'];

        $result = $this->db->select('site_category.id, site_category.name_'.SITELANG.' as name')
        ->where('site_category.id', $category)->from('site_category')
        ->order_by('site_category.name_ru', 'ASC')
        ->limit(1)
        ->get();

        if($result->num_rows() <= 0) return false;
        if($row == 0) $result = $result->row_array()['id'];
        elseif($row == 1) $result = $result->row_array()['name'];
        
        return $result;
    }


    public function selectAllObj($id = 0) {
        $id = (int)$id;
        $res = $this->db->select('id, link, name_ru')
        ->where('visible', 1)
        ->where('site_catalog.id !=', $id)
        /// select where paket option = 0
        ->where('site_catalog.paket_option', 0)
        // end paket optino
        ->order_by('product-visible', 'DESC')
        ->order_by('position', 'ASC')
        ->from('site_catalog')->get();
        if($res->num_rows() <= 0) return false;
        $res = $res->result_array();

     return $res;
    }


    public function selectPage($id) {
     $this->db->select('*');
     $this->db->from('site_category');
     $this->db->where("site_category.id = '{$id}'");
     $res = $this->db->limit(1)->get();
     $res = $res->result_array();

     if (count($res) <= 0) return array();

     return $res;
    }

    public function getFilters($catid = 0) {
        $catid = (int)$catid;
        if ($catid <= 0) return array();

        $res = $this->db->select('filter_id')->from('site_catalog_filters_category')->where('category_id = '.$this->db->escape($catid))->get();
        if ($res->num_rows() <= 0) return array();
        $res = $res->result_array();

        $return = array();

        foreach ($res as $one) {
            $return[$one['filter_id']] = true;
        }

        return $return;
    }

    //---SAVE PAGE region

    public function savePage($array) {

        $return = 'http';

        if (isset($array['id']) && is_numeric($array['id']) && $array['id'] > 0) {

            if (isset($array['cat_image']['image_big']) && !empty($array['cat_image']['image_big']) /*&& isset($array['cat_image']['mainimg']) && !empty($array['cat_image']['mainimg'])*/) {

                $res = $this->db->select('image, image_big')->from('site_category')->where("id = '{$array['id']}'")->limit(1)->get();

                if ($res->num_rows() > 0) {

                    $res = $res->result_array();

                    $this->load->library('image_my_lib');
                    if (isset($res[0]['image_big']) && !empty($res[0]['image_big'])) {

                        $this->image_my_lib->delImage($res[0]['image_big']);

                    }
                    /*
                    if (isset($res[0]['image']) && !empty($res[0]['image'])) {

                        $this->image_my_lib->delImage($res[0]['image']);

                    }
                    */
                }

                $this->db->set('image_big', $array['cat_image']['image_big']);
                #$this->db->set('image', $array['cat_image']['image']);

            }

            /*
            $this->db->set('link', $array['link']);
            $this->db->set('manual', $array['manual']);
            */
            $this->db->set('visible', $array['visible']);

            foreach ($this->config->item('config_languages') as $value) {

             if (isset($array['title'.$value]))
              $this->db->set('title'.$value, $array['title'.$value]);

             if (isset($array['keyword'.$value]))
              $this->db->set('keyword'.$value, $array['keyword'.$value]);

             if (isset($array['description'.$value]))
              $this->db->set('description'.$value, $array['description'.$value]);

             if (isset($array['name'.$value]))
              $this->db->set('name'.$value, $array['name'.$value]);

             if (isset($array['text'.$value]))
              $this->db->set('text'.$value, $array['text'.$value]);

            }

            ###
            #$this->db->set('visible_ontop', $array['visible_ontop']);

            if (isset($array['filter_concat'])) $this->db->set('filter_concat', $array['filter_concat']);
            if (isset($array['parentid'])) $this->db->set('parentid', $array['parentid']);
            if (isset($array['parentid2'])) $this->db->set('parentid2', $array['parentid2']);
            if (isset($array['parentid3'])) $this->db->set('parentid3', $array['parentid3']);

            if ($array['manual']) $this->db->set('link', $array['link']);
            else {
             if (isset($array['link']) && !empty($array['link'])) {
              $pos = strrpos($array['link'], '-'.$array['id']);
              if ($pos !== false) $array['link'] = substr($array['link'], 0, $pos);
             }
             $this->db->set('link', rtrim($array['link'], '-').'-'.$array['id']);
            }
            $this->db->set('manual', $array['manual']);

            $this->db->where("id = '{$array['id']}'")->update('site_category');

            $return = $array['id'];

        } else {

            #$this->db->set('visible_ontop', $array['visible_ontop']);

            if (isset($array['filter_concat'])) $this->db->set('filter_concat', $array['filter_concat']);
            if (isset($array['parentid'])) $this->db->set('parentid', $array['parentid']);
            if (isset($array['parentid2'])) $this->db->set('parentid2', $array['parentid2']);
            if (isset($array['parentid3'])) $this->db->set('parentid3', $array['parentid3']);

            foreach ($this->config->item('config_languages') as $value) {
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

            }

            ###
            $this->db->set('image', '');
            if (isset($array['cat_image']['image_big']) && !empty($array['cat_image']['image_big'])) $this->db->set('image_big', $array['cat_image']['image_big']);

            if ($array['manual']) $this->db->set('link', $array['link']);
            $this->db->set('manual', $array['manual']);

            $this->db->set('visible', $array['visible']);

            $this->db->insert('site_category');

            $id_ = $this->db->insert_id();

            if (!$array['manual']) $this->db->set('link', rtrim($array['link'], '-').'-'.$id_);

            $this->db->set('position', $id_);
            $this->db->where("id = '{$id_}'")->update('site_category');

            $return = $id_;


        }

        #FILTERS

        $this->db->where('category_id = '.$this->db->escape($return))->delete('site_catalog_filters_category');

        if (!isset($array['filters'])) $array['filters'] = array();

        if (isset($array['filter_concat']) && $array['filter_concat'] && isset($array['parentid']) && $array['parentid'] > 0) {

         $filters = $this->db->select('filter_id')->from('site_catalog_filters_category')->where('category_id', $array['parentid'])->get();
         if ($filters->num_rows() > 0) {
          $filters = $filters->result_array();
          $temp = array();
          foreach ($filters as $one) array_push($temp, $one['filter_id']);

          $array['filters'] = array_unique(array_merge($array['filters'], $temp));
         }

        }

        if (isset($array['filters']) && !empty($array['filters'])) {
         foreach ($array['filters'] as $value) {
          $this->db->set('category_id', (int)$return)->set('filter_id', (int)$value)->insert('site_catalog_filters_category');
         }
        }

        #END

        return $return;

    }
    //---end SAVE PAGE

    public function delMenu($id) {

        $this->load->library('image_my_lib');

        $children = $this->db->select('site_category.id, image, image_big')->from('site_category')->where("parentid = '{$id}'")->or_where('parentid2 = '.$this->db->escape($id))->or_where('parentid3 = '.$this->db->escape($id))->get();
        $children = $children->result_array();

        $this->load->model('catalog/catalog_object_model');

        foreach ($children as $one) {

            $objects = $this->db->select('catalogid as id')->from('site_catalog_category')->where("site_catalog_category.categoryid = '{$one['id']}'")->get();
            $objects = $objects->result_array();

            foreach ($objects as $obj) {

                $this->catalog_object_model->removeObj($obj['id']);

            }

            $this->image_my_lib->delImage($one['image']);
            $this->image_my_lib->delImage($one['image_big']);

            $this->db->where("id = '{$one['id']}'")->limit(1)->delete('site_category');

        }

        $objects = $this->db->select('catalogid as id')->from('site_catalog_category')->where("site_catalog_category.categoryid = '{$id}'")->get();
        $objects = $objects->result_array();

        foreach ($objects as $obj) {

            $this->catalog_object_model->removeObj($obj['id']);

        }

        $res = $this->db->select('image, image_big')->from('site_category')->where("id = '{$id}'")->limit(1)->get();

        if ($res->num_rows() > 0) {

            $res = $res->row_array();

            if (isset($res['image']) && !empty($res['image'])) {

                $this->image_my_lib->delImage($res['image']);

            }
            if (isset($res['image_big']) && !empty($res['image_big'])) {

                $this->image_my_lib->delImage($res['image_big']);

            }

        }

        $this->db->where("id = '{$id}'")->delete('site_category');

    }

    public function setCheck($id = 0) {
     $id = (int)$id;
     if ($id <= 0) return false;
     $this->db->set('visible_ontop', 1)->where('id = '.$this->db->escape($id))->limit(1)->update('site_category');
    }

    public function setUnCheck($id = 0) {
     $id = (int)$id;
     if ($id <= 0) return false;
     $this->db->set('visible_ontop', 0)->where('id = '.$this->db->escape($id))->limit(1)->update('site_category');
    }

}