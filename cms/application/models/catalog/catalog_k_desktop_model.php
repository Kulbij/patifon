<?php

class Catalog_k_desktop_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getCats() { return array();
     $this->load->model('catalog/catalog_catalog_model');
     return $this->catalog_catalog_model->selectPreviewAll();
    }

    public function setVisible($id) {
        $this->db->set('visible', 1);
        $this->db->where("id = '{$id}'")->update('site_catalog_warranty');
    }

    public function setUnVisible($id) {
        $this->db->set('visible', 0);
        $this->db->where("id = '{$id}'")->update('site_catalog_warranty');
    }

    //position page
    public function setUp($id) {
     $res = $this->db->select('position')->from('site_catalog_warranty')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();

     if (count($res) <= 0) return false;

     $pos = $res[0];

     $res = $this->db->select('id, position')->from('site_catalog_warranty')->where("position < '{$pos['position']}'")->limit(1)->order_by('position', 'DESC')->get();
     $res = $res->result_array();

     if (count($res) <= 0) return false;

     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_catalog_warranty');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_catalog_warranty');
    }

    public function setDown($id) {
     $res = $this->db->select('position')->from('site_catalog_warranty')->where("id = '{$id}'")->limit(1)->get();
     $res = $res->result_array();

     if (count($res) <= 0) return false;

     $pos = $res[0];

     $res = $this->db->select('id, position')->from('site_catalog_warranty')->where("position > '{$pos['position']}'")->limit(1)->order_by('position', 'ASC')->get();
     $res = $res->result_array();

     if (count($res) <= 0) return false;

     $this->db->set('position', $res[0]['position'])->where("id = '{$id}'")->update('site_catalog_warranty');
     $this->db->set('position', $pos['position'])->where("id = '{$res[0]['id']}'")->update('site_catalog_warranty');
    }

    //other functions
    public function selectPreviewAll() {
     $res = $this->db->select('id, name_ru as name, visible, position')->from('site_catalog_warranty')->order_by('position', 'ASC')->get();
     if ($res->num_rows() <= 0) return array();
     $res = $res->result_array();

     return $res;
    }

    public function selectPage($id) {
     $id = (int)$id;
     if ($id <= 0) return array();

     $res = $this->db->select('*')->from('site_catalog_warranty')->where('id = '.$this->db->escape($id))->limit(1)->get();
     if ($res->num_rows() <= 0) return $return;
     $res = $res->result_array();

     return $res;
    }

    //---SAVE PAGE region

    public function savePage($array) {
     $objectid = 0;

     foreach ($this->config->item('config_languages') as $value) {
      $this->db->set('name'.$value, $array['name'.$value]);
     }
     $this->db->set('price',$array['price']);
     if (isset($array['id']) && is_numeric($array['id'])) {

      $this->db->where("id = '{$array['id']}'")->update('site_catalog_warranty');
      $objectid = $array['id'];

     } else {

      $this->db->insert('site_catalog_warranty');
      $objectid = $this->db->insert_id();

      $this->db->set('position', $objectid)->where('id = '.$this->db->escape($objectid))->limit(1)->update('site_catalog_warranty');

     }

     return $objectid;
    }

    //---end SAVE PAGE

    public function deleteV($id) {
     $id = (int)$id;
     if ($id <= 0) return false;

     $this->db->where('id = '.$this->db->escape($id))->delete('site_catalog_warranty');
     return true;
    }

}