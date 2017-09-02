<?php

class Page_indeximage_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function setVisible($id){
        $this->db->set('visible',1)
                ->where('id',$id)
                ->update('site_indexbanner');
    }
    public function setUnVisible($id){
        $this->db->set('visible',0)
                ->where('id',$id)
                ->update('site_indexbanner');
    }
    //other functions
    public function selectPreviewAll() {
        
        $ind = $this->db->select('id, image, position, visible, obj_id')->from('site_indexbanner')->order_by('position', 'ASC')->get();
        
        if ($ind->num_rows() <= 0) return array();
        
        $ind = $ind->result_array();
        $this->load->model('catalog/catalog_object_model','object_model');        
        foreach($ind as &$one){
            if($one['obj_id'] > 0){
                $one['image'] = $this->object_model->getObjectImg($one['obj_id']);
            }
        }
        
        return $ind;
        
    }
    
    public function selectPage($id) {
        
        if (is_null($id))
            $id = 0;

        $this->db->select('id, image, link, position, isleft, obj_id');
        $this->db->from('site_indexbanner');
        $this->db->where("id = '$id'");
        $res = $this->db->limit(1)->get();

       //if ($res->num_rows() <= 0) return array();
        
        $res = $res->result_array();
        $this->load->model('catalog/catalog_object_model','object_model');        
        $res[0]['objects'] = $this->object_model->getObjects();        
        return $res;
        
    }
    
    //position page
    public function setUp($id) {
        
        $res = $this->db->select('position')->from('site_indexbanner')->where("id = '$id'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res[0]['position'];
        
        $res = $this->db->select('id, position')->from('site_indexbanner')->where("position < '$pos'")->limit(1)->order_by('position', 'DESC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '$id'")->update('site_indexbanner');
        $this->db->set('position', $pos)->where("id = '{$res[0]['id']}'")->update('site_indexbanner');
        
    }
    
    public function setDown($id) {
        
        $res = $this->db->select('position')->from('site_indexbanner')->where("id = '$id'")->limit(1)->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $pos = $res[0]['position'];
        
        $res = $this->db->select('id, position')->from('site_indexbanner')->where("position > '$pos'")->limit(1)->order_by('position', 'ASC')->get();
        $res = $res->result_array();
        
        if (count($res) <= 0) return false;
        
        $this->db->set('position', $res[0]['position'])->where("id = '$id'")->update('site_indexbanner');
        $this->db->set('position', $pos)->where("id = '{$res[0]['id']}'")->update('site_indexbanner');
        
    }
    
    public function saveIndexImg($array) {
//        echo '<pre>';
//        print_r(func_get_args());
//        die();
        if (isset($array['isleft'])) $this->db->set('isleft', $array['isleft']);
        $this->db->set('link', $array['link']);
        $this->db->set('obj_id',$array['obj_id']);
        if (isset($array['id']) && is_numeric($array['id']) && !empty($array['image']) && !is_null($array['image'])) {
            
            $res = $this->db->select('image')->from('site_indexbanner')->where("id = '{$array['id']}'")->limit(1)->get();
            if ($res->num_rows() <= 0) return false;
            
            $res = $res->row_array();
            
            $this->load->library('image_my_lib');
            $this->image_my_lib->delImage($res['image']);
            
        }
        
        if (!empty($array['image']) && !is_null($array['image'])) {
            
            $this->db->set('image', $array['image']);
            
        }
        
        $objectid = 'http';
        
        if (isset($array['id'])) {
            
            $this->db->where("id = '{$array['id']}'")->update('site_indexbanner');
            
            $objectid = $array['id'];
            
        } else {
            
            $this->db->insert('site_indexbanner');
            $objectid = $this->db->insert_id();
            
            $this->db->set('position', $objectid)->where("id = '{$objectid}'")->update('site_indexbanner');
            
        }
        
        return $objectid;
        
    }
    //---end SAVE PAGE
    
    function delImage($id) {
        
        $image = $this->db->select('image')->from('site_indexbanner')->where("id = '$id'")->limit(1)->get();
        
        if ($image->num_rows() <= 0) return false;
        
        $image = $image->result_array();
        
        $image = $image[0]['image'];
        
        $this->db->where("id = '$id'")->delete('site_indexbanner');
        
        $this->load->library('image_my_lib');
        $this->image_my_lib->delImage($image);
        
    }
    
}