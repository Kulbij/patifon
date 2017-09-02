<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Import extends CI_Controller {

 private $_TEST = false;

 private $base;

 private $region;

 public function __construct() {
  parent::__construct();

  $this->base = $this->load->database('old', true);
 }

 public function index() {

  if ($this->input->get('password') !== 'SDFGsrhDDZerghqweEG') die('lizard king');

  $_start = microtime(true);

  ini_set('max_execution_time', 0);
  ini_set('default_socket_timeout', 3600);

  $this->region = 0;

  if ($this->region === 'sizer') {

   $dd32x32 = $this->load->database('32x32', true);
   $ddnet = $this->load->database('.net', true);
   $res = $ddnet->select('id, size')->from('site_catalog')->get()->result_array();
   if (!empty($res)) {

    foreach ($res as $one) {

     $prd = $dd32x32->select('id, import_code, width, height, depth')->from('site_catalog')->where('import_code = '.$this->db->escape($one['id']))->limit(1)->get()->row_array();
     if (!empty($prd)) {

      $size = explode('x', $one['size']);
      if (count($size) == 1) $size = explode('/', $one['size']);

      if (!empty($size)) {

       if (isset($size[0]) && empty($prd['width'])) $dd32x32->set('width', $size[0]);
       if (isset($size[1]) && empty($prd['height'])) $dd32x32->set('height', $size[1]);
       if (isset($size[2]) && empty($prd['depth'])) $dd32x32->set('depth', $size[2]);
       $dd32x32->set('import_code', $prd['import_code'])->where('id = '.$this->db->escape($prd['id']))->limit(1)->update('site_catalog');

      }

     }

    }

   }

   die('<br />-->prince of the universe<--<br />');
  }

  #0. update link
  if ($this->region === -1) {

   $products = $this->db->select('id, link')->from('site_catalog')->get()->result_array();
   if (!empty($products)) {

    foreach ($products as $one) {

     $this->db
             ->set('link', $one['link'].'-'.$one['id'])
             ->where('id = '.$this->db->escape($one['id']))
             ->limit(1)
             ->update('site_catalog')
             ;

    }

   }

   die('<br />--> end catalog');
  }

  #1. factory import

  if ($this->region == 1) {

   $factories = $this->base->select('id, name')->from('site_manufacturer')->get()->result_array();
   if (!empty($factories)) {

    foreach ($factories as $one) {
     $one['name'] = trim($one['name']);

     if (!empty($one['name'])) {

      $this->db
              ->set('parent_id', 1)
              ->set('name_ru', $one['name'])
              ->set('link', $this->_translit($one['name'], true, true))
              ->set('manual', true)
              ->set('visible', true)
              ->set('import_code', $one['id'])
              ->insert('site_catalog_filters')
              ;

      $id = (int)$this->db->insert_id();

      $this->db
              ->set('position', $id)
              ->where('id = '.$this->db->escape($id))
              ->limit(1)
              ->update('site_catalog_filters')
              ;

     }

    }

   }

   die('<br />--> end factory import');
  }

  #2. colors import
  if ($this->region == 2) {

   $colors = $this->base->select('id, name, img')->from('site_color')->order_by('id', 'ASC')->get()->result_array();

   if (!empty($colors)) {

    foreach ($colors as $one) {

     $image = end(explode('/', $one['img']));

     if (file_exists($this->input->server('DOCUMENT_ROOT').'/images-old/color/'.$image) &&\
       copy($this->input->server('DOCUMENT_ROOT').'/images-old/color/'.$image, $this->input->server('DOCUMENT_ROOT').'/public/images/data/color/'.$image)
      ) {

      $this->db
              ->set('name_ru', $one['name'])
              ->set('image', 'public/images/data/color/'.$image)
              ->set('visible', true)
              ->set('import_code', $one['id'])
              ->insert('site_color')
              ;

      $id = (int)$this->db->insert_id();

      $this->db
              ->set('position', $id)
              ->where('id = '.$this->db->escape($id))
              ->limit(1)
              ->update('site_color')
              ;

     }

    }

   }

   die('<br />--> end region import');
  }


  #3. product import
  if ($this->region == 3) {

   #svit mebliv
   $_fac = 23;

   $prod = $this->base->select('*')->from('site_catalog')->where('manufacturer = '.$this->db->escape($_fac))->order_by('idcomponent', 'ASC')->get()->result_array();
   if (!empty($prod)) {

    foreach ($prod as $one) {

     $cat = $this->db->select('id')->from('site_category')->where('import_code = '.$this->db->escape($one['idcat']))->limit(1)->get()->row_array();
     if (empty($cat)) $one['idcat'] = 0;
     else $one['idcat'] = $cat['id'];

     if (true) {

      $this->db
              ->set('name_ru', $one['name'])
              ->set('price', $one['price'])
              ->set('text_ru', $one['text'])
              ->set('title_ru', $one['title'])
              ->set('keyword_ru', $one['keyword'])
              ->set('description_ru', $one['description'])
              ->set('visible', $one['visible'])
              ->set('countwatch', $one['countwatch'])
              ->set('import_code', $one['id'])
              ->set('link', $this->_translit($one['name'], true, true))
              ->set('manual', true)
              ->insert('site_catalog')
              ;

      $id = (int)$this->db->insert_id();

      #up position
      $this->db
              ->set('position', $id)
              ->where('id = '.$this->db->escape($id))
              ->limit(1)
              ->update('site_catalog')
              ;

      #if object is component
      if ($one['idcomponent'] > 0) {

       $par = $this->db->select('id')->from('site_catalog')->where('import_code = '.$this->db->escape($one['idcomponent']))->limit(1)->get()->row_array();
       if (!empty($par)) {

        $this->db
                ->set('parentid', $par['id'])
                ->where('id = '.$this->db->escape($id))
                ->limit(1)
                ->update('site_catalog')
                ;

       }

      }

      #rel with factory
      $factory = $this->db->select('id')->from('site_catalog_filters')->where('import_code = '.$this->db->escape($_fac))->limit(1)->get()->row_array();
      if (!empty($factory)) {

       $this->db
               ->set('catalog_id', $id)
               ->set('filter_id', $factory['id'])
               ->insert('site_catalog_filters_catalog')
               ;

      }


      #rel with category
      if ($one['idcat'] > 0) {

       $this->db
               ->set('catalogid', $id)
               ->set('categoryid', $one['idcat'])
               ->set('main', true)
               ->insert('site_catalog_category')
               ;

      }

      #add search
      $this->db
              ->set('catalogid', $id)
              ->set('catalogid_s', $id)
              ->set('name', $one['name'])
              ->set('text', $one['text'])
              ->insert('site_catalog_search')
              ;

      #image
      #create objhect folder
      @mkdir($this->input->server('DOCUMENT_ROOT').'/images/'.$id, 0777);
      @mkdir($this->input->server('DOCUMENT_ROOT').'/images/'.$id.'/mainimg', 0777);
      @mkdir($this->input->server('DOCUMENT_ROOT').'/images/'.$id.'/moreimg', 0777);

      #get library
      $this->load->library('image_lib');
      require_once $this->input->server('DOCUMENT_ROOT').'/cms/application/libraries/image_my_lib.php';
      $img_lib = new Image_my_lib();

      #copy main image
      if (copy($this->input->server('DOCUMENT_ROOT').'/images-old/objectimg/'.$one['id'].'/'.end(explode('/', $one['img_big'])), $this->input->server('DOCUMENT_ROOT').'/images/'.$id.'/'.end(explode('/', $one['img_big'])))) {

       $_FILES['main_image']['tmp_name'] = $this->input->server('DOCUMENT_ROOT').'/images/'.$id.'/'.end(explode('/', $one['img_big']));
       $_FILES['main_image']['name'] = end(explode('/', $one['img_big']));

       $res = $img_lib->createMainImage($id);

       if (isset($res['image']) && !empty($res['image'])) {
        unlink($this->input->server('DOCUMENT_ROOT').'/images/'.$id.'/'.end(explode('/', $one['img_big'])));

        $this->db
                ->set('image', $res['image'])
                ->where('id = '.$this->db->escape($id))
                ->limit(1)
                ->update('site_catalog')
                ;

       }

      }

      #more images
      $images = $this->base->select('id, big_img')->from('site_img_catalog')->where('idcatalog = '.$this->db->escape($one['id']))->get();
      if ($images->num_rows() > 0) {

       $images = $images->result_array();
       $images_new = '';

       foreach ($images as $img) {

        if (copy($this->input->server('DOCUMENT_ROOT').'/images-old/objectimg/'.$one['id'].'/'.end(explode('/', $img['big_img'])), $this->input->server('DOCUMENT_ROOT').'/images/'.$id.'/moreimg/'.end(explode('/', $img['big_img'])))) {

         $images_new .= ',images/'.$id.'/moreimg/'.end(explode('/', $img['big_img']));

        }

       }

       #if not empty
       if (!empty($images_new)) {

        $images_new = $img_lib->createImgs($id, $images_new);

        foreach ($images_new as $img) {

         $this->db
                 ->set('catalogid', $id)
                 ->set('image', $img['image'])
                 ->set('visible', true)
                 ->insert('site_catalog_image')
                 ;

         $img_id = (int)$this->db->insert_id();

         $this->db
                 ->set('position', $img_id)
                 ->where('id = '.$this->db->escape($img_id))
                 ->limit(1)
                 ->update('site_catalog_image')
                 ;

        }

       }
       #this is the end... */


      }


     }


     #this is the end of product foreach... */
     #die('one product');
    }


   }



   die('<br />--> end product import');
  }



  $_time = microtime(true) - $_start;
  printf('Скрипт выполнялся %.4F сек.', $_time);

 }

 #Private functions

 private function _translit($string, $gost = true, $link = false) {
  $replace = array();
  if ($gost) {
   $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
   "Е"=>"E","е"=>"e","Ё"=>"E","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
   "Й"=>"I","й"=>"i","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n","О"=>"O","о"=>"o",
   "П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t","У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f",
   "Х"=>"Kh","х"=>"kh","Ц"=>"Tc","ц"=>"tc","Ч"=>"Ch","ч"=>"ch","Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch",
   "Ы"=>"Y","ы"=>"y","Э"=>"E","э"=>"e","Ю"=>"Iu","ю"=>"iu","Я"=>"Ia","я"=>"ia","ъ"=>"","ь"=>"",
   'І' => 'I', 'і' => 'i', 'Ї' => 'II', 'ї' => 'ii', 'Є' => 'E', 'є' => 'e',
   '/' => '-', '\\' => '', '+' => '', '(' => '', ')' => '', ':' => '', ';' => '', ',' => '', '»' => '', '«' => '', '[' => '', ']' => '', '{' => '', '}' => ''
   );
  } else {
   $arStrES = array("ае","уе","ое","ые","ие","эе","яе","юе","ёе","ее","ье","ъе","ый","ий");
   $arStrOS = array("аё","уё","оё","ыё","иё","эё","яё","юё","ёё","её","ьё","ъё","ый","ий");
   $arStrRS = array("а$","у$","о$","ы$","и$","э$","я$","ю$","ё$","е$","ь$","ъ$","@","@");

   $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
    "Е"=>"Ye","е"=>"e","Ё"=>"Ye","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
    "Й"=>"Y","й"=>"y","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n",
    "О"=>"O","о"=>"o","П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t",
    "У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f","Х"=>"Kh","х"=>"kh","Ц"=>"Ts","ц"=>"ts","Ч"=>"Ch","ч"=>"ch",
    "Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch","Ъ"=>"","ъ"=>"","Ы"=>"Y","ы"=>"y","Ь"=>"","ь"=>"",
    "Э"=>"E","э"=>"e","Ю"=>"Yu","ю"=>"yu","Я"=>"Ya","я"=>"ya","@"=>"y","$"=>"ye");

   $string = str_replace($arStrES, $arStrRS, $string);
   $string = str_replace($arStrOS, $arStrRS, $string);
  }

  $tr_string = iconv("UTF-8", "UTF-8//IGNORE", strtr($string, $replace));

  if ($link) $tr_string = mb_strtolower(str_replace(' ', '-', $tr_string));

  return trim(preg_replace('#(.)\\1{2,}#ius', '\\1', $tr_string), '-');
 }

 #end

}