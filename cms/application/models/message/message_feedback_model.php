<?php

class Message_feedback_model extends CI_Model
{
    function __construct() {
     parent::__construct();
    }
    
    public function selectPreviewAll($from, $count = 100) {
        
        if ($from == 1 || $from == 0) $from = 0;
        else {
            $from = ($count * $from) - $count;
        }
        
        $this->db->select('id, name, date, check')->from('site_feedback');
        $result = $this->db->limit($count, $from)->order_by('date', 'DESC')->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return array();
        
        return $result;
        
    }
    
    public function countOrder() {
        $result = $this->db->select('COUNT(*) as count')->from('site_feedback')->get();
        $result = $result->result_array();
        
        if (count($result) <= 0) return 0;
        
        return $result[0]['count'];
    }
    
    public function getOrder($id) {
        
        if (!$this->ifIsOrder($id)) redirect(base_url());
        
        $res = $this->db->select('*')->from('site_feedback')->where("id = '{$id}'")->limit(1)->get();
        if ($res->num_rows() <= 0) return array();
        $res = $res->row_array();
        
        $temp = $this->db->select('id, browser, ip')->from('site_feedback_stat')->where('tableid = '.$this->db->escape($res['id']))->limit(1)->get();
        if ($temp->num_rows() > 0) {
         $temp = $temp->row_array();
         $res['browser'] = $temp['browser'];
         $res['ip'] = $temp['ip'];
        }
        
        return $res;
        
    }
    
    public function ifIsOrder($id) {
        $res = $this->db->select("id")->from('site_feedback')->where("id = '{$id}'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        return true;
        
    }
    
    public function delOrder($id) {
     $id = (int)$id;
     if ($id <= 0) return false;
     
     $this->db->where('tableid = '.$this->db->escape($id))->limit(1)->delete('site_feedback_stat');
     $this->db->where('id = '.$this->db->escape($id))->limit(1)->delete('site_feedback');
    }
    
    public function setCheck($id) {
     $this->db->set('check', 1);
     $this->db->where("id = '{$id}'")->update('site_feedback');
    }
    
    public function setUnCheck($id) {
     $this->db->set('check', 0);
     $this->db->where("id = '{$id}'")->update('site_feedback');
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
    
}