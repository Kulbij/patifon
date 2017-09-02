<?php
require_once 'base_model.php';
class User_model extends CI_Model implements Base_model 
{
    function __construct()
    {
        parent::__construct();
        $this->load->database('default');
    }
    
    //CRUD
    public function selectAll() {
        $res = $this->db->select('*')->from('cms_user')->where("Super = 0")->get();
        return $this->FormData($res);
    }
    
    public function selectById($id) {
        $res = $this->db->select('*')->from('cms_user')->where("UserID = '$id' AND Super = 0")->get();
        return $this->FormData($res);
    }
    
    public function removeById($id) {
        $this->db->where("UserID = '$id' AND Super = 0")->delete('cms_user');
    }
    
    public function updateById($id, $data) {
        $this->db->where("UserID = '$id'")->update('cms_user', $data);
    }
    
    public function insert($data) {
        $this->db->set($data)->insert('cms_user');
    }
    //--end CRUD
    
    //formed data
    public function FormData($data) {
        $data = $data->result_array();
        
        $out = array();
        
        $count_ = count($data);
        for ($i = 0; $i < $count_; ++$i) {
            if (isset($data[$i]['UserID'])) $out[$i]['id'] = $data[$i]['UserID'];
            if (isset($data[$i]['Login'])) $out[$i]['login'] = $data[$i]['Login'];
            if (isset($data[$i]['Password'])) $out[$i]['password'] = $data[$i]['Password'];
            if (isset($data[$i]['Super'])) $out[$i]['super'] = $data[$i]['Super'];
        }
        return $out;
        
    }
    
    //other functions
    
    function checkUser($login, $password) {
        
        $res = $this->db->select('UserID')->from('cms_user')->where("Login = '$login' AND Password = '$password'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        return $res[0]['UserID'];
        
    }
    
    function selectNameByID($id) {
        $res = $this->db->select('Login')->from('cms_user')->where("UserID = '$id'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        return $res[0]['Login'];
    }
    
}