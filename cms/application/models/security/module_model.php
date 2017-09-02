<?php
require_once APPPATH.'models/base_model.php';
class Module_model extends CI_Model implements Base_model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    //CRUD
    public function selectAll() {
        $res = $this->db->select('*')->from('cms_menu')->get();
        return $this->FormData($res);
    }
    
    public function selectById($id) {
        $res = $this->db->select('*')->from('cms_menu')->where("MenuID = '$id'")->get();
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
    public function FormData($data) {
        $data = $data->result_array();
        
        $out = array();
        
        $count_ = count($data);
        for ($i = 0; $i < $count_; ++$i) {
            if (isset($data[$i]['MenuID'])) $out[$i]['id'] = $data[$i]['MenuID'];
            if (isset($data[$i]['ParentID'])) $out[$i]['parent'] = $data[$i]['ParentID'];
            if (isset($data[$i]['Name'])) $out[$i]['name'] = $data[$i]['Name'];
            if (isset($data[$i]['Link'])) $out[$i]['link'] = $data[$i]['Link'];
            if (isset($data[$i]['Image'])) $out[$i]['image'] = $data[$i]['Image'];
            if (isset($data[$i]['Visible'])) $out[$i]['visible'] = $data[$i]['Visible'];
            if (isset($data[$i]['Position'])) $out[$i]['position'] = $data[$i]['Position'];
        }
        return $out;
        
    }
    
    //other functions
    public function selectModule($id = null, $parent = false) {
        $this->db->select('*')->from('cms_menu')->where("Visible = 1");
        
        if (!is_null($id)) {
            if (!is_numeric($id)) return false;
            
            $this->db->where("MenuID = '$id'");
        }
        
        if ($parent === true) {
            $this->db->where("ParentID = 0");
        }
        
        $res = $this->db->get();
        return $this->db->FormData($res);
    }
    
    public function selectLinkModule($id = null, $parent = false) {
        $this->db->select('MenuID, Link')->from('cms_menu')->where("Visible = 1");
        
        if (!is_null($id)) {
            if (!is_numeric($id)) return false;
            
            $this->db->where("MenuID = '$id'");
        }
        
        if ($parent === true) {
            $this->db->where("ParentID = 0");
        }
        
        $res = $this->db->get();
        return $this->FormData($res);
    }
    
    public function selectChildLinkModule($parentid) {
        $res = $this->db->select('MenuID, Link')->from('cms_menu')->where("ParentID = '$parentid' AND Visible = 1")->get();
        return $this->FormData($res);
    }
    
    public function isModule($module) {
        $res = $this->db->select('MenuID')->from('cms_menu')->where("Link = '$module' AND ParentID = 0 AND Visible = 1")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        return true;
        
    }
    public function isSubmodule($submodule) {
        if (is_null($submodule)) return true;
        
        $res = $this->db->select('MenuID')->from('cms_menu')->where("Link = '$submodule' AND ParentID <> 0")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        return true;
    }
    
    public function getByLink($link, $parent = false) {
        $this->db->select('Name')->from('cms_menu')->where("Link = '$link'");
        if ($parent) $this->db->where("ParentID = 0");
		else $this->db->where("ParentID <> 0");
        $res = $this->db->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return '';
        
        return $res[0]['Name'];
    }
    
    ///ONLY FOR UKRMEBLI
    
    public function getCat($objid) {
        
        $objid = (int)$objid;
        if ($objid <= 0) return array();
        
        $res = $this->db->select("site_catalog_category.categoryid")->from('site_catalog_category')->where("site_catalog_category.catalogid = '{$objid}'")->where('site_catalog_category.main = 1')->limit(1)->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        $res = $res[0]['categoryid'];
        
        if ($res <= 0) return array();
        
        $res = $this->db->select("site_category.id, site_category.name".$this->config->item('config_default_lang')." as name")->from('site_category')->where("site_category.id = '{$res}'")->limit(1)->get();
        
        if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        $res = $res[0];
        
        return $res;
        
    }
    
    ////////////////////
    
}