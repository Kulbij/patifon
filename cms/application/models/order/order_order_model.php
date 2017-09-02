<?php

class Order_order_model extends CI_Model
{
    function __construct(){
     parent::__construct();
    }

    public function set_cancel($id, $cancel) {
     $id = (int)$id;
     $cancel = (bool)$cancel;
     if ($id <= 0) return false;

     $this->db
             ->set('canceled', $cancel)
             ->where('id = '.$this->db->escape($id))
             ->limit(1)
             ->update('site_order')
             ;

     return true;
    }
    public function saveOrderStatus($array){
       $this->db->set('status_id',$array['status'])
               ->where('id',$array['item'])
               ->update('site_order');
       return $array['item'];
    }
    public function saveOrderStatusEmail($array){
       $this->db->set('status_email_id',$array['status'])
               ->where('id',$array['item'])
               ->update('site_order');
       return $array['item'];
    }
    public function saveOrderOneClickStatus($array){
        $this->db->set('status_id',$array['status'])
               ->where('id',$array['item'])
               ->update('site_order_click');
       return $array['item'];
    }
    public function getOrderStatuses(){
        $res = $this->db->select('*')
                ->from('cms_order_status')
                ->get()
                ->result_array();
        return $res;
    }
    public function getOrderStatusEmail(){
        $res = $this->db->select('*')
                ->from('cms_order_status_email')
                ->order_by('position', 'ASC')
                ->get()
                ->result_array();
        return $res;
    }
    public function selectPreviewAll($from, $count = 100, $page = 0) {

        if ($from == 1 || $from == 0) $from = 0;
        else {
            $from = ($count * $from) - $count;
        }

        $this->db->select('id, user_id, datetime, name, check, canceled, status_id, status_email_id, email, phone')->from('site_order');

        if($page === 1){
            $this->db->where('site_order.check', 1)->where('site_order.status_id', 5)->limit($count, $from);
        }elseif($page == 2){
            $this->db->where('site_order.check', 0)->where('site_order.status_id', 1)->limit($count, $from);
        } else $this->db->limit($count, $from);

        $result = $this->db->limit($count, $from)->order_by('datetime', 'DESC')->get();
        $result = $result->result_array();

        if (count($result) <= 0) return array();
        else {
            $temp = [];
            $isname = [];
            foreach($result as $key => &$value){
                if($value['status_email_id'] == 0) $result[$key]['status_email_id'] = 3;
                $result[$key]['cart'] = $this->GetAllCartProducts($value['id']);
            } unset($value);
        }
        return $result;
    }

    public function selectAllCountOrder($link = array()){
        if(!isset($link) && empty($link)) return false;

        if($link == 'order') {
            $res = $this->db->select('COUNT(*) as count')->where('site_order.check', 0)->from('site_order')->get();
            
            if($res->num_rows() <= 0) return false;
            $res = $res->row_array()['count'];
        } else {
            $res = $result = $this->db->select('COUNT(*) as count')->where('site_order_click.check', 0)->from('site_order_click')->get();
            
            if($res->num_rows() <= 0) return false;
            $res = $res->row_array()['count'];
        }
        return $res;
    }

    public function GetAllCartProducts($id){
        $res =  $this->db->select('catalogid')->where('orderid', $id)->from('site_order_cart')->get();
        if($res->num_rows() <= 0) return array();
        $res = $res->result_array();
        $names = [];
        foreach($res as &$value){
            $res_query = $this->db->select('site_catalog.name'.$this->config->item('config_default_lang').' as name')->from('site_catalog')->where("site_catalog.id = ".$this->db->escape($value['catalogid']))->get()->result_array();
            @$names[] = $res_query[0];
        }
        return $names;
    }

    public function countOrder($cat = 0, $page = 0) {
        
        $this->db->select('COUNT(*) as count')->from('site_order');
        
        if($page == 1) {
            $this->db->where('site_order.check', 1)->where('site_order.status_id', 5);
        } elseif($page == 2) {
            $this->db->where('site_order.check', 0)->where('site_order.status_id', 1);
        }

        $result = $this->db->get();
        $result = $result->result_array();

        if (count($result) <= 0) return 0;

        return $result[0]['count'];
    }

    public function getObjectName($catalogid = 0) {
     $catalogid = (int)$catalogid;
     if ($catalogid <= 0) return '';
     $res = $this->db->select('site_catalog.name'.$this->config->item('config_default_lang').' as name')->from('site_catalog')->where("site_catalog.id = ".$this->db->escape($catalogid))->limit(1)->get();
     if ($res->num_rows() <= 0) return '';
     $res = $res->row_array();
     return $res['name'];
    }

    public function get_color_name($colorid = 0) {
     $colorid = (int)$colorid;
     if ($colorid <= 0) return '';
     $res = $this->db->select('site_catalog_filters.name'.$this->config->item('config_default_lang').' as name')->from('site_catalog_filters')->where("site_catalog_filters.id = ".$this->db->escape($colorid))->limit(1)->get();
     if ($res->num_rows() <= 0) return '';
     $res = $res->row_array();
     return $res['name'];
    }

    public function get_region_name($id = 0) {
     $id = (int)$id;
     if ($id <= 0) return '';

     $this->db
             ->select('name'.$this->config->item('config_default_lang').' as name')
             ->from('site_region')
             ->where('id = '.$this->db->escape($id))
             ->limit(1)
             ;

     $res = $this->db->get();
     if ($res->num_rows() <= 0) return '';
     $res = $res->row_array();
     return $res['name'];
    }

    public function get_region_city_name($id = 0) {
     $id = (int)$id;
     if ($id <= 0) return '';

     $this->db
             ->select('name'.$this->config->item('config_default_lang').' as name')
             ->from('site_region_city')
             ->where('id = '.$this->db->escape($id))
             ->limit(1)
             ;

     $res = $this->db->get();
     if ($res->num_rows() <= 0) return '';
     $res = $res->row_array();
     return $res['name'];
    }

    public function get_delivery_cat_name($id = 0) {
     $id = (int)$id;
     if ($id <= 0) return '';

     $this->db
             ->select('name'.$this->config->item('config_default_lang').' as name')
             ->from('site_delivery_cat')
             ->where('id = '.$this->db->escape($id))
             ->limit(1)
             ;

     $res = $this->db->get();
     if ($res->num_rows() <= 0) return '';
     $res = $res->row_array();
     return $res['name'];
    }

    public function get_delivery_type_name($id = 0) {
     $id = (int)$id;
     if ($id <= 0) return '';

     $this->db
             ->select('name'.$this->config->item('config_default_lang').' as name')
             ->from('site_delivery_type')
             ->where('id = '.$this->db->escape($id))
             ->limit(1)
             ;

     $res = $this->db->get();
     if ($res->num_rows() <= 0) return '';
     $res = $res->row_array();
     return $res['name'];
    }

    public function getOrder($id) {
     if (!$this->ifIsOrder($id)) redirect(base_url());

     $res = $this->db->select('*')->from('site_order')->where("id = '{$id}'")->limit(1)->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->row_array();

     #$res['region_name'] = $this->get_region_name($res['region']);
     #$res['city_name'] = $this->get_region_city_name($res['city']);
     #$res['delivery_name'] = $this->get_delivery_cat_name($res['delivery']);
     #$res['delivery_service_name'] = $this->get_delivery_type_name($res['delivery_service']);

     $temp = $this->db->select('*')->from('site_order_cart')->where("orderid = '{$res['id']}'")->get();
     if ($temp->num_rows() > 0) $res['ordercart'] = $temp->result_array();
     else $res['ordercart'] = array();

     foreach ($res['ordercart'] as &$value) {
      $value['name'] = $this->getObjectName($value['catalogid']);
      $value['parent_cat'] = $this->getParentCategory($value['catalogid']);
//      $value['warranty'] = $this->db->select('name_ru as name')->from('site_catalog_warranty')->where('id',$value['warranty'])->get()->row_array()['name'];
      #$value['color_name'] = $this->get_color_name($value['colorid']);

      $temp = $this->db->select('link')->from('site_catalog')->where('id = '.$this->db->escape($value['catalogid']))->limit(1)->get();
      if ($temp->num_rows() > 0) {
       $temp = $temp->row_array();
       $value['link'] = $temp['link'];
      } else $value['link'] = '';

     } unset($value);

     $temp = $this->db->select('*')->from('site_order_stat')->where("tableid = '{$res['id']}'")->limit(1)->get();
     if ($temp->num_rows() > 0) {
      $res['orderstat'] = $temp->row_array();
     } else $res['orderstat'] = array();
     return $res;
    }

    public function getParentCategory($id){
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

    public function ifIsOrder($id) {
        $res = $this->db->select("id")->from('site_order')->where("id = '{$id}'")->limit(1)->get();
        $res = $res->result_array();

        if (count($res) <= 0) return false;

        return true;

    }

    public function delOrder($id) {
     $id = (int)$id;
     if ($id <= 0) return false;

     $this->db->where('tableid = '.$this->db->escape($id))->limit(1)->delete('site_order_stat');
     $this->db->where('orderid = '.$this->db->escape($id))->limit(1)->delete('site_order_cart');
     $this->db->where('id = '.$this->db->escape($id))->limit(1)->delete('site_order');
     return true;
    }

    public function getEmailOrder($id){
        $id = (int)$id;
        if ($id <= 0) return false;

        $res = $this->db->select('site_order.email')->where('site_order.id', $id)
        ->from('site_order')->limit(1)->get();

        if($res->num_rows() <= 0) return false;
        $res = $res->row_array();

        return $res['email'];
    }

    public function sendmailOrder($id, $email){
        $id = (int)$id;
        if ($id <= 0) return false;
        if(!isset($email) && empty($email)) return false;

        $array = array('item' => $id, 'email' => $email, 'status' => 4);

        $this->load->library('send_email');
        $bool = $this->send_email->send_email($array);

         $this->saveOrderStatusEmail($array);
    }

    public function setCheck($id) {
        $this->db->set('check', 1);
        $this->db->where("id = '{$id}'")->update('site_order');
    }

    public function setUnCheck($id) {
        $this->db->set('check', 0);
        $this->db->where("id = '{$id}'")->update('site_order');
    }

    public function save($array){
        if(!isset($array) && empty($array))  return false;
        $this->db->set('site_order.text_ru', $array['shorttext_ru']);
        $this->db->where('site_order.id', $array['id'])->update('site_order');
        return $array['id'];
    }

    public function getText($id){
        if(!isset($id) && empty($id) && $id <= 0) return false;
        $id = (int)$id;
        $res = $this->db->select('site_order.text_ru')->where('site_order.id', $id)->from('site_order')->get();

        if($res->num_rows() <= 0) return false;
        $res = $res->result_array();

        return $res[0]['text_ru'];
    }

}