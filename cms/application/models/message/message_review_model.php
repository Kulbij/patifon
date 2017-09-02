<?php

class Message_review_model extends CI_Model
{
    function __construct() {
     parent::__construct();
    }
    
    public function selectPreviewAll($from, $count = 100) {
        
        if ($from == 1 || $from == 0) $from = 0;
        else {
            $from = ($count * $from) - $count;
        }
        
        $this->db->select('id, id_catalog, name, datetime, check,visible, text')->from('site_comment');
        $result = $this->db->limit($count, $from)->order_by('datetime', 'DESC')->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return array();
        return $result;
        
    }
    public function selectMessages($id) {
        
        $this->db->select('id, id_catalog, name, datetime, check,visible, text')
        ->where('id_catalog', $id)
        ->order_by('datetime', 'desc')
        ->from('site_comment');
        $result = $this->db->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return array();

        return $result;
        
    }
    public function getCount($id){
      if(!isset($id)) return false;
      $id = (int)$id;
      $res = $this->db->select('id')->where('id_catalog', $id)->where('check', 0)->from('site_comment')->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      $res = count($res);
      return $res;
    }
    public function selectPreviewAll2($from, $count = 100) {
        
        if ($from == 1 || $from == 0) $from = 0;
        else {
            $from = ($count * $from) - $count;
        }

        $res = $this->db->select('site_catalog.name'.$this->config->item('config_default_lang').' as name, site_catalog.id')
        ->from('site_catalog')
        ->join('site_comment', 'site_comment.id_catalog = site_catalog.id', 'left')
        ->order_by('site_comment.datetime', 'desc')
        ->limit($count, $from)
        ->get()->result_array();
        //echo $this->db->last_query();
        echo "<pre>"; print_r($res); die();
        return $res;
      }
    public function selectProduct($id){
      $res = $this->db->select('name'.$this->config->item('config_default_lang').' as name_obj')->where('id', $id)->from('site_catalog')->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      return $res[0]['name_obj'];
    }
    public function selectAllRreview($array = ''){
      if(empty($array)) return false;

      $res = $this->db->select('id, name'.$this->config->item('config_default_lang').' as name')
      ->where_in('id', $array)
      ->from('site_catalog')->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      return $res;
    }
    public function selectAllCatsObj($array = ''){
      if(empty($array)) return false;

      $res = $this->db->select('*')
      ->where_in('catalogid', $array)
      ->where('main != 0')
      ->from('site_catalog_category')->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      return $res;
    }
    public function selectAllCategoryName($array = ''){
      if(empty($array)) return false;

      $res = $this->db->select('id, name_ru')
      ->where_in('id', $array)
      ->from('site_category')->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      return $res;
    }

    public function selectThisObj($id){
      if(empty($id)) return false;

      $res = $this->db->select('*')
      ->where('categoryid', $id)
      ->from('site_catalog_category')->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      echo "<pre>"; print_r($res); die();
      return $res;
    }

    public function getDateComments($id){
      if(empty($id)) return false;
      $id = (int)$id;
      $res = $this->db->select('datetime')->where('id_catalog', $id)->from('site_comment')->order_by('datetime', 'desc')->limit(1)->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->row_array();
      return $res['datetime'];
    }
    public function getCategory(){
      $res = $this->db->select('id, visible, link, name'.$this->config->item('config_default_lang').' as name')
      ->from('site_category')
      ->where('visible = 1')
      ->where('parentid2 = 1')
      ->order_by('position', 'ASC')
      ->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();

      foreach($res as $key => $value) {
        $res[$key]['children'] = $this->getChildrenCats($value['id']);
        if(isset($res[$key]['children']) && !empty($res[$key]['children'])) {
          foreach($res[$key]['children'] as $k => $one) {
            $res[$key]['children'][$k]['children2'] = $this->getChildren2Cats($one['id']);
          }unset($one);
        } else {
          $res[$key]['children2'] = $this->getChildren2Cats($value['id']);
        }
      }
      return $res;
    }
    public function getChildrenCats($id){
      $this->db->select('id, visible, link, name'.$this->config->item('config_default_lang').' as name')
      ->where('site_category.parentid = '.$this->db->escape($id))
      ->order_by('position', 'ASC')
      ->from('site_category');
      $res = $this->db->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      return $res;
    }
    public function getChildren2Cats($id = 1){
      $id = (int)$id;
      $this->db->select('*')
      ->where('site_catalog_category.categoryid = '.$this->db->escape($id))
      ->from('site_catalog_category');
      $res = $this->db->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();

      $num = [];
      foreach($res as $nums){
        $num[] = $nums['catalogid'];
      }unset($nums);
      $array = $this->selectObject($num);
      return $array;
    }
    public function selectObject($array, $parm = ''){
      if(!isset($array) && empty($array)) return false;
      if(empty($parm) && !isset($parm)) $parm = [];
      switch ($parm) {
        case 'visible': 
        {
          $this->db->select('visible');
        } break;
        
        default: 
        {
          $this->db->select('id, name'.$this->config->item('config_default_lang').' as name, link, visible');
        } break;
      }

      $this->db->where_in('site_catalog.id', $array)
      ->from('site_catalog');
      $res = $this->db->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      foreach($res as $key => $value){
        $res[$key]['count'] = $this->countComments($value['id']);
      }unset($value);

      if($parm == 'visible') return $res[0]['visible'];
      else return $res;
    }

    // comments ======================= data

    public function countComments($id){
      $this->db->select('COUNT(*) as count');
      $this->db->where('id_catalog = '.$this->db->escape($id))
      ->where('check', 0)
      ->from('site_comment');
      $res = $this->db->get();

      if($res->num_rows() > 0){
        $res = $res->result_array();
        return $res[0]['count'];
      } else return false;
    }
    public function set_Unvis($id){
	$this->db->where('id',$id)
		->set('visible',0)
		->update('site_comment');
    }
    public function set_review_har($id){
        $set = $this->scan_filter($id);

        if($set[0]['parent_id'] == 0){
          $security = $this->select_filter_obj($set);
          $full_filters_obj = $this->full_filters_obj_func($security);
        }else{
        $this->db->set('filter-vis', 0);
        $this->db->where('id', $id)->update('site_catalog_filters');
      }
      $this->db->set('filter-vis', 0);
        $this->db->where('id', $id)->update('site_catalog_filters');
    }

    public function scan_filter($id){
      $res = $this->db->select('id, parent_id')->from('site_catalog_filters')->where('id', $id)->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      return $res;
    }

    public function select_filter_obj($array = array()){
      
      $res = $this->db->select('id, parent_id')->from('site_catalog_filters')->where('parent_id', $array[0]['id'])->get();
      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();
      return $res;
    }

    public function full_filters_obj_func($array){

      $idis = array();
      foreach ($array as $key => $value) {
        $idis[] = $value['id'];
      }unset($value);
      //echo "<pre>"; print_r($idis); die();


      $this->db->set('filter-vis', 0)->where_in('id', $idis);

      $this->db->update('site_catalog_filters');
      
    }

    public function set_review_harvis($id){
      $set = $this->scan_filter($id);

      if($set[0]['parent_id'] == 0){
          $security = $this->select_filter_obj($set);
          $full_filters_obj = $this->full_filters_obj_func_remove($security);
        }else{

        $this->db->where('id', $id)
        ->set('filter-vis', 1)
        ->update('site_catalog_filters');
      }
      $this->db->where('id', $id)
        ->set('filter-vis', 1)
        ->update('site_catalog_filters');
    }

    public function full_filters_obj_func_remove($array){
      $idis = array();
      foreach ($array as $key => $value) {
        $idis[] = $value['id'];
      }unset($value);
      //echo "<pre>"; print_r($idis); die();


      $this->db->set('filter-vis', 1)->where_in('id', $idis);

      $this->db->update('site_catalog_filters');
    }


    public function set_vis($id){
	$this->db->where('id',$id)
		->set('visible',1)
		->update('site_comment');
    }
    public function countOrder($id) {
        $result = $this->db->select('COUNT(*) as count')->from('site_comment')->where('site_comment.id_catalog', $id)->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return 0;
        
        return $result[0]['count'];
    }

    public function countOrderAll($cat = 0, $page = 0) {
        $this->db->select('COUNT(*) as count')->from('site_comment');

        if($cat > 0) {
            $this->db->where('site_comment.id', $cat);
        }

        $result = $this->db->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return 0;
        
        return $result[0]['count'];
    }
    
    public function getOrder($id) {
        
        if (!$this->ifIsOrder($id)) redirect(base_url());
        
        $res = $this->db->select('*')
		->from('site_comment')
		->where("site_comment.id = '{$id}'")
		->limit(1)
		->get();
        if ($res->num_rows() <= 0) 
	    return array();
        $res = $res->row_array();

        if (isset($res['id_catalog'])) {
         $temp = $this->db->select('name'.$this->config->item('config_default_lang').' as name, link')->from('site_catalog')->where('id = '.$this->db->escape($res['id_catalog']))->limit(1)->get();
         if ($temp->num_rows() > 0) {
          $res['object'] = $temp->row_array();
         }
        }

        // create a new link for object to redirect to site - catalog - object

        if (isset($res['id_catalog'])) {
          $result = $this->db
          ->from('site_category')
          ->from('site_catalog_category')
          ->where('site_catalog_category.catalogid', $res['id_catalog'])
          ->where('site_catalog_category.categoryid = site_category.id')
          ->where('site_catalog_category.main = 1')
          ->select('site_category.link')
          ->limit(1)
          ->get();

          if($result->num_rows() > 0) {
            $result = $result->row_array();
            $res['object']['catalog_link'] = $result['link'];
          }
         }
        
        return $res;
        
    }
    
    public function ifIsOrder($id) {
        $res = $this->db->select("id")->from('site_comment')->where("id = '{$id}'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        return true;
        
    }

    public function save($array) {
     if (empty($array)) return false;

     if (isset($array['text']) && isset($array['id'])) {

      if (isset($array['name'])) $this->db->set('name', $array['name']);
      if (isset($array['email'])) $this->db->set('email', $array['email']);
      if (isset($array['datetime'])) $this->db->set('datetime', $array['datetime']);
      if (isset($array['mark'])) $this->db->set('mark', $array['mark']);

      $this->db
              ->set('text', $array['text'])
              ->where('id = '.$this->db->escape($array['id']))
              ->limit(1)
              ->update('site_comment')
              ;

     }

     if(isset($array['answor']) && !empty($array['answor'])){
      if(isset($array['admin']) && !empty($array['admin'])) $this->db->set('name', $array['admin']);
      if(isset($array['id']) && !empty($array['id'])) $this->db->set('parent_id', $array['id']);
      $this->db->set('mark', 5);
      $this->db->set('datetime', date('Y-m-d H:i:s'));
      if (isset($array['answor'])) $this->db->set('text', $array['answor']);
      $this->db->set('icon', 1);

      $this->db->insert('site_comment');
     }

     return true;
    }    

    public function delOrder($id) {
     $id = (int)$id;
     if ($id <= 0) return false;
     
     $this->db->where('id = '.$this->db->escape($id))->limit(1)->delete('site_comment');
    }
    
    public function setCheck($id) {
     $this->db->set('check', 1);
     $this->db->where("id = '{$id}'")->update('site_comment');
    }
    
    public function setUnCheck($id) {
     $this->db->set('check', 0);
     $this->db->where("id = '{$id}'")->update('site_comment');
    }

    public function selectAllCountOrder($link = array()){
        if(!isset($link) && empty($link)) return false;

        if($link == 'feedback') {
            $res = $this->db->select('COUNT(*) as count')->where('site_feedback.check', 0)->from('site_feedback')->limit(1)->get();
            
            if($res->num_rows() <= 0) return false;
            $res = $res->row_array()['count'];
            return $res;
        }
        if($link == 'feedphone') {
            $res = $result = $this->db->select('COUNT(*) as count')->where('site_feedphone.check', 0)->from('site_feedphone')->limit(1)->get();
            
            if($res->num_rows() <= 0) return false;
            $res = $res->row_array()['count'];
            return $res;
        } 
        if($link == 'review') {

            $res = $result = $this->db->select('COUNT(*) as count')->where('site_comment.check', 0)->from('site_comment')->limit(1)->get();
            
            if($res->num_rows() <= 0) return false;
            $res = $res->row_array()['count'];
            return $res;
        }
    }

    public function getParentComments($id){
      if($id <= 0) return false;
      $id = (int)$id;

      $res = $this->db->select('*')->where('site_comment.parent_id', $id)->from('site_comment')
      ->order_by('site_comment.datetime', 'DESC')->get();

      if($res->num_rows() <= 0) return false;
      $res = $res->result_array();

      return $res;
    }
    
}