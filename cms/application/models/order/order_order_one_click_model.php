<?php

class Order_order_one_click_model extends CI_Model
{
    function __construct(){
     parent::__construct();
    }

    public function selectPreviewAll($from, $count = 100, $page = 0) {

        if ($from == 1 || $from == 0) $from = 0;
        else {
            $from = ($count * $from) - $count;
        }
        $page = (int)$page;

        $this->db->select('id, user_id, phone, product_id, datetime, check, status_id, canceled, name')->from('site_order_click');

        if($page === 1){
            $this->db->where('site_order_click.check', 1)->where('site_order_click.status_id', 5)->limit($count, $from);
        }elseif($page == 2){
            $this->db->where('site_order_click.check', 0)->where('site_order_click.status_id', 1)->limit($count, $from);
        } else $this->db->limit($count, $from);

        $result = $this->db->order_by('site_order_click.datetime', 'DESC')->get();
        $result = $result->result_array();

        if (count($result) <= 0) return array();

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

    public function getOrderStatuses(){
        $res = $this->db->select('*')
                ->from('cms_order_status')
                ->get()
                ->result_array();
        return $res;
    }

    public function countOrder() {
     $result = $this->db->select('COUNT(*) as count')->from('site_order_click')->get();
     $result = $result->result_array();

     if (count($result) <= 0) return 0;

     return $result[0]['count'];
    }

    public function getObject($catalogid = 0) {
     $catalogid = (int)$catalogid;
     if ($catalogid <= 0) return array();
     $res = $this->db->select('site_catalog.name'.$this->config->item('config_default_lang').' as name, link, id')->from('site_catalog')->where("site_catalog.id = ".$this->db->escape($catalogid))->limit(1)->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->row_array();
     return $res;
    }

    public function getOrder($id) {
     if (!$this->ifIsOrder($id)) redirect(base_url());

     $res = $this->db->select('*')->from('site_order_click')->where("id = '{$id}'")->limit(1)->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->row_array();

     $res['object'] = $this->getObject($res['product_id']);

     return $res;
    }

    public function ifIsOrder($id) {
        $res = $this->db->select("id")->from('site_order_click')->where("id = '{$id}'")->limit(1)->get();
        $res = $res->result_array();

        if (count($res) <= 0) return false;

        return true;

    }

    public function delOrder($id) {
     $id = (int)$id;
     if ($id <= 0) return false;

     $this->db->where('id = '.$this->db->escape($id))->limit(1)->delete('site_order_click');
     return true;
    }

    public function setCheck($id) {
     $id = (int)$id;
     if ($id <= 0) return false;

     $this->db->set('check', 1);
     $this->db->where("id = '{$id}'")->update('site_order_click');

     return true;
    }

    public function setUnCheck($id) {
     $id = (int)$id;
     if ($id <= 0) return false;

     $this->db->set('check', 0);
     $this->db->where("id = '{$id}'")->update('site_order_click');

     return true;
    }

    public function getArchive($id){
        echo id; die();
    }

}