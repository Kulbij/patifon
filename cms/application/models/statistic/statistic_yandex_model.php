<?php
require_once APPPATH.'models/base_model.php';
class Statistic_yandex_model extends CI_Model implements Base_model 
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
        return false;
        
    }
    
    //other functions
    public function selectPreviewAll() {
        $result = $this->db->select('Text as text')->from('cms_goostatistic')->where("StatisticID = 2")->limit(1)->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return '';
        
        return $result[0]['text'];
    }
}