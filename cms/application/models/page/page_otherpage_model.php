<?php

class Page_otherpage_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    //other functions
    public function selectPreviewAll() {

        $this->db->select('id, link, name'.$this->config->item('config_default_lang').' as name');        
        $this->db->from('site_page_other');
        $res = $this->db->order_by('id' ,'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return array();
        
        return $res;
        
    }
    
    public function selectPage($link) {
        
        $this->db->select('*');        
        $this->db->from('site_page_other');
        $this->db->where("link = '$link'");
        $res = $this->db->limit(1)->get();
        $res = $res->result_array();

        if (count($res) <= 0) return array();

        if ($link == 'invoice') {

         $temp = $this->db->select('*')->from('site_pp')->where('id = 1')->limit(1)->get();
         if ($temp->num_rows() > 0) {
          $temp = $temp->row_array();
          $res[0]['pp'] = $temp;
         } else $res[0]['pp'] = array();

        }

        return $res;
        
    }
    
    //---SAVE PAGE region
    
    public function savePage($array) {
     
     foreach ($this->config->item('config_languages') as $value) {
      if (isset($array['name'.$value]))
       $this->db->set('name'.$value, $array['name'.$value]);
      
      if (isset($array['title'.$value]))
       $this->db->set('title'.$value, $array['title'.$value]);
      
      if (isset($array['keyword'.$value]))
       $this->db->set('keyword'.$value, $array['keyword'.$value]);
      
      if (isset($array['description'.$value]))
       $this->db->set('description'.$value, $array['description'.$value]);
      
     }
     
     $this->db->where("link = '{$array['link']}'")->update('site_page_other');


     if ($array['link'] == 'invoice') {

      foreach ($this->config->item('config_languages') as $value) {
       $this->db->set('text'.$value, $array['pp'.$value]);
      }
      $this->db->where('id = 1')->limit(1)->update('site_pp');

     }

     return true;
    }
    //---end SAVE PAGE
    
}