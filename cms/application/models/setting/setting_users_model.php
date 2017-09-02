<?php
require_once APPPATH.'models/base_model.php';
class Setting_users_model extends CI_Model implements Base_model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    //CRUD
    public function selectAll() {
        return false;
    }
    
    public function selectById($id) {
        return false;
    }
    
    public function removeById($id) {
        return false;
    }
    
    public function updateById($id, $data) {
        return false;
    }
    
    public function insert($data) {
        return false;
    }
    //--end CRUD
    
    //formed data
    public function FormData($data) {
        $data = $data->result_array();
        $out = array();
        
        $count_ = count($data);
        for ($i = 0; $i < $count_; ++$i) {
            if (isset($data[$i]['UserID'])) $out[$i]['id'] = $data[$i]['UserID'];
            if (isset($data[$i]['Login'])) $out[$i]['name'] = $data[$i]['Login'];
        }
        return $out;
    }
    
    //other functions
    public function selectPreviewAll() {
        $result = $this->db->select('UserID, Login')->from('cms_user')->where("Super = 0")->order_by("Login", 'ASC')->get();
        return $this->FormData($result);
    }
    
    public function isUser($username) {
        $result = $this->db->select('UserID')->from('cms_user')->where("Login = '$username' AND Super = 0")->limit(1)->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return false;
        
        return true;
    }
    
    public function isHotUser($name, $id) {
        $result = $this->db->select('UserID')->from('cms_user')->where("Login = '$name' AND UserID <> '$id' AND Super = 0")->limit(1)->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return false;
        
        return true;
    }
    
    public function isUserByID($id) {
        $result = $this->db->select('UserID')->from('cms_user')->where("UserID = '$id' AND Super = 0")->limit(1)->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return false;
        
        return true;
    }
    
    public function getUserID($username) {
        $result = $this->db->select('UserID')->from('cms_user')->where("Login = '$username' AND Super = 0")->limit(1)->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return 0;
        
        return $result[0]['UserID'];
    }
    
    public function saveUser($id, $array) {
        $this->db->set('Login', mb_strtolower($array['login']));
        $this->db->set('Password', md5($array['password']));
        $this->db->where("UserID = '$id'");
        $this->db->update('cms_user');
    }
    
    public function insertUser($array) {
        $this->db->set('Login', mb_strtolower($array['login']));
        $this->db->set('Password', md5($array['password']));
        $this->db->insert('cms_user');
    }
    
    public function delUser($id) {
        $this->db->where("UserID = '$id'")->delete('cms_user');
    }
}