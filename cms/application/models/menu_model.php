<?php
require_once 'base_model.php';
class Menu_model extends CI_Model implements Base_model
{
    function __construct()
    {
        parent::__construct();
    }

    //CRUD
    public function selectAll() {
        $res = $this->db->select('*')->from('cms_menu')->where("Visible = 1")->order_by('Position' ,'ASC')->get();
        return $this->FormData($res);
    }

    public function selectById($id) {
        $res = $this->db->select('*')->from('cms_menu')->where("MenuID = '$id'")->where("Visible = 1")->limit(1)->get();
        return $this->FormData($res);
    }

    public function removeById($id) {
        $this->db->where("MenuID = '$id'")->delete('cms_menu');
    }

    public function updateById($id, $data) {
        $this->db->where("MenuID = '$id'")->update('cms_menu', $data);
    }

    public function insert($data) {
        $this->db->set($data)->insert('cms_menu');
    }
    //--end CRUD

    //formed data
    public function FormData($data, $order = array()) {
        $data = $data->result_array();

        $out = array();

        $count_ = count($data);
        for ($i = 0; $i < $count_; ++$i) {
            if (isset($data[$i]['MenuID'])) $out[$i]['id'] = $data[$i]['MenuID'];
            if (isset($data[$i]['ParentID'])) $out[$i]['parentid'] = $data[$i]['ParentID'];
            if (isset($data[$i]['Name'])) $out[$i]['name'] = $data[$i]['Name'];
            if (isset($data[$i]['Link'])) $out[$i]['link'] = $data[$i]['Link'];
            if (isset($data[$i]['Image'])) $out[$i]['image'] = $data[$i]['Image'];
            if (isset($data[$i]['Visible'])) $out[$i]['visible'] = $data[$i]['Visible'];
            if (isset($data[$i]['Position'])) $out[$i]['position'] = $data[$i]['Position'];
        }
        return $out;

    }

    //other functions
    public function selectParent() {
        $res = $this->db->select('*')->from('cms_menu')->where("ParentID = 0 AND Visible = 1")->order_by('Position', 'ASC')->get();
        return $this->FormData($res);

    }

    public function selectChildren($parentid) {
        $res = $this->db->select('*')->from('cms_menu')->where("ParentID = '$parentid' AND Visible = 1")->order_by('Position', 'ASC')->get();
        return $this->FormData($res);
    }

    public function selectAllChildrenByLink($link) {
        $order = $link;
        $res = $this->db->select('MenuID')->from('cms_menu')->where("Link = '$link' AND Visible = 1")->limit(1)->get();
        $res = $res->result_array();

        if (count($res) <= 0) return false;

        $res = $res[0]['MenuID'];

        $result = $this->db->select('Name, Link')->from('cms_menu')->where("ParentID = '$res' AND Visible = 1")->order_by('Position', 'ASC')->get();

        return $this->FormData($result, $order);
    }

    public function selectFirstChildren($parentid) {
        $res = $this->db->select('*')->from('cms_menu')->where("ParentID = '$parentid' AND Visible = 1")->order_by('Position', 'ASC')->limit(1)->get();
        return $this->FormData($res);
    }

    public function selectChildrenByLink($link) {
        $res = $this->db->select('MenuID')->from('cms_menu')->where("Link = '$link' AND Visible = 1")->limit(1)->get();
        $res = $res->result_array();

        if (count($res) <= 0) return false;

        $res = $res[0]['MenuID'];
        return $this->selectFirstChildren($res);
    }

    public function selectMenuName($link) {
        $res = $this->db->select('Name')->from('cms_menu')->where("Link = '$link'")->limit(1)->get();
        $res = $res->result_array();

        if (count($res) <= 0) return '';

        return $res[0]['Name'];
    }

    public function getOR() {

        $count = 0;

        $res = $this->db->select('COUNT(*) as count')->from('site_order')->where("check = 0")->get();
        $res = $res->result_array();

        if (count($res) > 0) $count += $res[0]['count'];

        $res = $this->db->select('COUNT(*) as count')->from('site_order_click')->where("check = 0")->get();
        $res = $res->result_array();

        if (count($res) > 0) $count += $res[0]['count'];

        return $count;

    }

    public function getMR() {

        $count = 0;

        $res = $this->db->select('COUNT(*) as count')->from('site_feedback')->where("check = 0")->get();

        if ($res->num_rows() > 0) {

            $res = $res->result_array();
            $count += $res[0]['count'];

        }

        $res = $this->db->select('COUNT(*) as count')->from('site_feedphone')->where("check = 0")->get();

        if ($res->num_rows() > 0) {

            $res = $res->result_array();
            $count += $res[0]['count'];

        }

        $res = $this->db->select('COUNT(*) as count')->from('site_comment')->where("check = 0")->get();

        if ($res->num_rows() > 0) {

            $res = $res->result_array();
            $count += $res[0]['count'];

        }

        return $count;

    }

    public function getCNA() {
        return 0;
        $res = $this->db->select('COUNT(*) as count')->from('site_client')->where("activation = 0")->get();
        $res = $res->result_array();

        if (count($res) <= 0) return 0;

        return $res[0]['count'];

    }

    public function getCCN() {
        return 0;
        $date_yesterday = date("Y-m-d", time()-3600*24);

        $res = $this->db->select('COUNT(*) as count')->from('site_comment')->where("date >= '".date("Y-m-d")."'")->get();
        $res = $res->result_array();

        if (count($res) <= 0) return 0;

        return $res[0]['count'];

    }

}