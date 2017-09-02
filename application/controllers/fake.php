<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fake extends CI_Controller {
 private $db2;
 private $db3;
 
 public function __construct() {
  parent::__construct();
  /*
  $this->db2 = $this->load->database('default', TRUE, TRUE);
  $this->db3 = $this->load->database('oldsite', TRUE, TRUE);*/
  $this->load->library('image_lib');
  #$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] . '/dybok';
 }

 private function image_to_ext($img = '', $ext = '') {
  if (empty($img)) return '';
  if (empty($ext)) return $img;
  $two = explode('.', $img);
  $count = count($two);
  if (!is_array($two) || count($two) < 2) return '';
  $return = '';
  for ($i = 0; $i < $count - 1; ++$i) $return .= $two[$i];
  $return .= $ext.'.'.end($two);
  return $return;
 
 }
 
 protected function generate($tf) {
	 return md5(md5(date("l dS of F Y h:I:s A").$this->__generate()).md5($tf));
     
    }
    
    private function __generate() {
        
        $vowels = 'aeuyAEUY';
        $consonants = 'bdghjmnpqrstvzBDGHJLMNPQRSTVWXZ23456789';
        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < 7; $i++) {
        if ($alt == 1) {
        $password .= $consonants[(rand() % strlen($consonants))];
        $alt = 0;
              } else {
               $password .= $vowels[(rand() % strlen($vowels))];
               $alt = 1;
              }
             }
        return $password;
        
    }
    
    public function getFilename ($file) {
        
        if (($pos = strrpos($file, '.')) !== false) {
            
            return substr($file, 0, $pos);
            
        }
        
    }
    
    public function getJustFilename ($file) {
     if (($ppos = strrpos($file, "/")) !== false && ($pos = strrpos($file, '.')) !== false) {
      return substr($file, $ppos + 1, $pos);
     }
    }
    
    public function getExt ($file) {
     return end(explode('.', $file));
    }
     
    protected function getFExt($name) {
        $p = '';
        $ext = strtolower(substr(strrchr($name,'.'), 1));

        switch (true)
        {
            case in_array($ext, array('jpeg','jpe','jpg')):
            {
                $p = 'jpeg';
                break;
            }
            case ($ext=='gif'):
            {
                $p = 'gif';
                break;
            }
            case ($ext=='png'):
            {
                $p = 'png';
                break;
            }
        }

        return  '.' .$p;
    }
 
 private function createcreatecreate($img, $width, $height, $where, $public = true, $dendy = '') {
  return $this->imgresize($img, $width, $height, $where, $public, $dendy);
 }
 
 private function imgresize($src, $width = 1024, $height = 768, $where = '', $public = true, $dendy = '') {
    $new_img = '';
    
    if (!empty($dendy)) {
     if ($dendy == 'default') $dendy = '';
     $new_img = 'images/'.$where.'/'.$this->getFilename(end(explode('/', $src))).$dendy.'.'.$this->getExt($src);
    } else {
     $new_img = 'images/'.$where.'/'.$this->generate($src).'.'.$this->getExt($src);
    }
    
    if ($public) {
     $this->image_lib->clear();
     $imgsize = getimagesize($_SERVER['DOCUMENT_ROOT'].'/public/'.$src);
     if (($imgsize[0] > $width || $imgsize[1] > $height) /*|| ($width != 1024 && $height != 768)*/) {
      $this->img_resize($_SERVER['DOCUMENT_ROOT'].'/public/'.$src, $_SERVER['DOCUMENT_ROOT'].'/public/'.$new_img, $width, $height);
     } else {
      copy($_SERVER['DOCUMENT_ROOT'].'/public/'.$src, $_SERVER['DOCUMENT_ROOT'].'/public/'.$new_img);
     }
    } else {
     $this->image_lib->clear();
     $imgsize = getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$src);
     #$new_img = 'images/'.$where.'/'.$this->generate($src).'.'.$this->getExt($src);
     if (($imgsize[0] > $width || $imgsize[1] > $height) /*|| ($width != 1024 && $height != 768)*/) {
      $this->img_resize($_SERVER['DOCUMENT_ROOT'].'/'.$src, $_SERVER['DOCUMENT_ROOT'].'/'.$new_img, $width, $height);
     } else {
      copy($_SERVER['DOCUMENT_ROOT'].'/'.$src, $_SERVER['DOCUMENT_ROOT'].'/'.$new_img);
     }
    }
    
    return $new_img;
  }
  
  private function img_resize($src, $dest, $width, $height, $rgb=0xffffff, $quality=100)
{
  if (!file_exists($src)) return false;

  $size = getimagesize($src);

  if ($size === false) return false;

  // Определяем исходный формат по MIME-информации, предоставленной
  // функцией getimagesize, и выбираем соответствующую формату
  // imagecreatefrom-функцию.
  $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
  $icfunc = "imagecreatefrom" . $format;
  if (!function_exists($icfunc)) return false;

  $x_ratio = $width / $size[0];
  $y_ratio = $height / $size[1];

  $ratio       = min($x_ratio, $y_ratio);
  $use_x_ratio = ($x_ratio == $ratio);

  $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
  $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
  $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
  $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

  $isrc = $icfunc($src);
  $idest = imagecreatetruecolor($width, $height);

  imagefill($idest, 0, 0, $rgb);
  imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0,
    $new_width, $new_height, $size[0], $size[1]);

  imagejpeg($idest, $dest, $quality);

  imagedestroy($isrc);
  imagedestroy($idest);

  return true;
}

 public function index($parametter = '') {
  #redirect(site_url());
  die();
  
  ini_set('max_execution_time', 0);
  
  $width = 660;
  $height = 452;
  
  $sql = $this->db->select('id, name_ua as name, image')->order_by('id', 'ASC')->where('visible = 1')->get('site_catalog');
  $i = 0;
  foreach($sql->result() as $row) { if (file_exists($_SERVER['DOCUMENT_ROOT'].'/images/'.$row->id.'/mainimg/'.$this->image_to_ext($row->image, ''))) {
   $bigupfile = $_SERVER['DOCUMENT_ROOT'].'/images/'.$row->id.'/mainimg/'.$this->image_to_ext($row->image, '');
   $file = 'images/'.$row->id.'/mainimg/'.$this->image_to_ext($row->image, '');
   $objid = $row->id;
   #$file = 'public/big/'.$objid.'/'.$row->image;
    
   #$allay = @getimagesize($bigupfile);
   #if ($allay[0] < $width && $allay[1] < $height && !is_file($_SERVER['DOCUMENT_ROOT'].'/'.$file)) {
    #echo ' NO_FILE --> ', $row->id, ' <--> ||| > ';
    #if (!is_file($_SERVER['DOCUMENT_ROOT'].'/images/'.$row->id.'/mainimg/'.$row->image)) {
     #echo ' NO_FILE_FILE --> ', $row->id, ' <--> ', $row->image, '<br />';
    #}
    /* else {
     @unlink($bigupfile);
     $this->createcreatecreate('images/'.$row->id.'/mainimg/'.$row->image, 660, 452, $objid.'/mainimg', false, '_big');
     echo ' BIG --> ', $row->id, ' <> ', $row->name, '<br />';
    }*/
   #} 
   /* else {
    if (is_null($allay)) {
     $this->createcreatecreate($file, 660, 452, $objid.'/mainimg', false, 'default');*/
     $this->createcreatecreate($file, 660, 452, $objid.'/mainimg', false, '_big');
     $this->createcreatecreate($file, 380, 260, $objid.'/mainimg', false, '_obj');
     $this->createcreatecreate($file, 200, 137, $objid.'/mainimg', false, '_top');
     $this->createcreatecreate($file, 280, 191, $objid.'/mainimg', false, '_dis');
     $this->createcreatecreate($file, 240, 164, $objid.'/mainimg', false, '_cat');
     $this->createcreatecreate($file, 180, 123, $objid.'/mainimg', false, '_pop');
     
     
     
     
     
     #--------------------images
     $res = $this->db->select('id, catalogid, image')->from('site_catalog_image')->get();
     if ($res->num_rows() > 0) {
      $res = $res->result_array();
      foreach ($res as $value) {
       if (file_exists($_SERVER['DOCUMENT_ROOT'].'/images/'.$value['catalogid'].'/moreimg/'.$this->image_to_ext($value['image'], ''))) {
        $bigupfile = $_SERVER['DOCUMENT_ROOT'].'/images/'.$value['catalogid'].'/moreimg/'.$this->image_to_ext($value['image'], '');
        $file = 'images/'.$value['catalogid'].'/moreimg/'.$this->image_to_ext($value['image'], '');
        $objid = $value['catalogid'];
        
        $this->createcreatecreate($file, 660, 452, $objid.'/moreimg', false, 'default');
        $this->createcreatecreate($file, 120, 82, $objid.'/moreimg', false, '_sm');
       }
      }
     }
     #-----------------------end
     
     
     
     
     
     echo ' ALL --> ', $row->id, ' <> ', $row->name, '<br />';
   /* } elseif ($allay[0] < $width && $allay[1] < $height) {
     #@unlink($bigupfile);
     $this->createcreatecreate($file, 660, 452, $objid.'/mainimg', false, '_big');
     echo ' BIG --> ', $row->id, ' <> ', $row->name, '<br />';
    }
   }*/
   
   #if ($i > 50) die();
   #++$i;
   
   }
  }
 
 
 
 
 
 
 
 
 
 
 
 
 
 die(); die(); die();
 
 
 
 
 
 $res = $this->db->select('id, regionid, name_ua, name_ru')->from('site_city')->get();
 if ($res->num_rows() <= 0) return array();
 $res = $res->result_array();
 
 foreach ($res as &$one) {
  $res2 = $this->db->select('id')->from('site_city')->where("site_city.name_ru = ".$this->db->escape($one['name_ru']))->where('site_city.regionid = '.$this->db->escape($one['regionid']))->get(); #->where('site_city.id <> '.$this->db->escape($one['id']))->get();
  if ($res2->num_rows() > 0) {
   $res2 = $res2->result_array();
   $temp = array();
   foreach ($res2 as $two) {
    $temp[] = $two['id'];
   }
   
   if (!empty($temp)) {
    $this->db->where_in('id', $temp)->delete('site_city');
    unset($one['id']);
    $this->db->insert('site_city', $one);
    $newid = $this->db->insert_id();
    $this->db->set('cityid', $newid)->where_in('cityid', $temp)->update('site_city_delivery');
    echo '<pre>'; print_r($temp); echo '</pre><br />';
    //break;
   }
   //echo 1, '<br />';
  }
 } unset($one);
 
 die();
 $res = $this->db->select('id, image')->from('site_catalog')->get();
 if ($res->num_rows() > 0) {
  $res = $res->result_array();
  foreach ($res as $value) {
   $this->db->where('catalogid = '.$this->db->escape($value['id']))->where('image = '.$this->db->escape($value['image']))->limit(1)->delete('site_catalog_image');
   echo $value['id'], ' <> ', $value['image'], ' <br />';
  }
 }
 
 die();
 
  switch($parametter) {
   case 'catalog': {
    $this->GS_catalog();
   } break;
   case 'region': {
    $this->GS_region();
   } break;
   case 'pp': {
    $this->GS_PP();
   } break;
   case 'factory': {
    $this->GS_factory();
   } break;
   case 'fasade': {
    $this->GS_fasade();
   } break;
   case 'corpus': {
    $this->GS_corpus();
   } break;
   case 'ser_del': {
    $this->GS_serdelka();
   } break;
   case 'site': {
    $this->GS_site();
   } break;
   case 'cat_share': {
    $this->GS_catshare();
   } break;
   case 'category': {
    $this->GS_category();
   } break;
  }
 }
 
 private function GS_catalog() {
  if (isset($_POST['trigger']) && $_POST['trigger']) {
   $data = $this->db3->select('*')->from('s_tov')->get();
   if ($data->num_rows() <= 0) return false;
   $data = $data->result_array();
   echo '<pre>'; print_r($data); echo '</pre>';
  } else $this->setText('Заповнення таблиці `site_catalog` --> ');
 }
 
 private function GS_category() {
  if (isset($_POST['trigger']) && $_POST['trigger']) {
   $data = $this->db3->select('*')->from('s_cat')->get();
   if ($data->num_rows() <= 0) return false;
   $data = $data->result_array();
   foreach ($data as $one) {
    $this->db2->set('parentid', $one['pid_menu']);
    $this->db2->set('name_ua', $one['ua_name']);
    $this->db2->set('name_ru', $one['ru_name']);
    $this->db2->set('shortname_ua', $one['ua_short']);
    $this->db2->set('shortname_ru', $one['ru_short']);
    $this->db2->set('position', $one['priority']);
    $this->db2->insert('site_category');
    
    $pid_data = $this->db3->select('*')->from('s_cat_dybok')->where("id = '{$one['id']}'")->limit(1)->get();
    if ($pid_data->num_rows() > 0) {
     $pid_data = $pid_data->result_array();
     $pid_data = $pid_data[0];
     $this->db2->set('siteid', 1);
     $this->db2->set('name_ua', $one['ua_name']);
     $this->db2->set('name_ru', $one['ru_name']);
     $this->db2->set('shortname_ua', $one['ua_short']);
     $this->db2->set('shortname_ru', $one['ru_short']);
     $this->db2->set('position', $one['priority']);
     $this->db2->insert('site_category_site');
    }
    
    echo 'Insert --> ', $this->db2->insert_id(), ' <> ', $one['ua_name'], ' ... ', '<br />';
   }
   #echo '<pre>'; print_r($data); echo '</pre>';
  } else $this->setText('Заповнення таблиці `site_category` --> ');
 }
 
 private function GS_catshare() {
  if (isset($_POST['trigger']) && $_POST['trigger']) {
   $data = $this->db3->select('*')->from('s_type_tov')->where("n_type > 0")->get();
   if ($data->num_rows() <= 0) return false;
   $data = $data->result_array();
   foreach ($data as $one) {
    $this->db2->set('name', $one['name_type']);
    $this->db2->set('description', '');
    $this->db2->insert('site_catalog_share');
    echo 'Insert --> ', $this->db2->insert_id(), ' <> ', $one['name_type'], ' ... ', '<br />';
   }
   #echo '<pre>'; print_r($data); echo '</pre>';
  } else $this->setText('Заповнення таблиці `site_catalog_share` --> ');
 }
 
 private function GS_site() {
  if (isset($_POST['trigger']) && $_POST['trigger']) {
   $data = $this->db3->select('*')->from('s_site')->get();
   if ($data->num_rows() <= 0) return false;
   $data = $data->result_array();
   foreach ($data as $one) {
    $this->db2->set('name', $one['name_site']);
    $this->db2->set('address', $one['allname_site']);
    $this->db2->insert('site_site');
    echo 'Insert --> ', $this->db2->insert_id(), ' <> ', $one['name_site'], ' ... ', '<br />';
   }
   #echo '<pre>'; print_r($data); echo '</pre>';
  } else $this->setText('Заповнення таблиці `site_site` --> ');
 }
 
 private function GS_serdelka() {
  if (isset($_POST['trigger']) && $_POST['trigger']) {
   $data = $this->db3->select('*')->from('ser_del')->get();
   if ($data->num_rows() <= 0) return false;
   $data = $data->result_array();
   foreach ($data as $one) {
    $this->db2->set('href', $one['ahref']);
    $this->db2->set('formula', $one['formula']);
    $this->db2->set('name_ua', $one['ua_name']);
    $this->db2->set('description_ua', $one['ua_opis']);
    $this->db2->set('name_ru', $one['ru_name']);
    $this->db2->set('description_ru', $one['ru_opis']);
    $this->db2->set('position', $one['sort']);
    $this->db2->set('visible', $one['visible']);
    $this->db2->insert('site_delivery');
    echo 'Insert --> ', $this->db2->insert_id(), ' <> ', $one['ua_name'], ' ... ', '<br />';
   }
   #echo '<pre>'; print_r($data); echo '</pre>';
  } else $this->setText('Заповнення таблиці `site_delivery` --> ');
 }
 
 private function GS_corpus() {
  if (isset($_POST['trigger']) && $_POST['trigger']) {
   $data = $this->db3->select('*')->from('mat_korpus')->get();
   if ($data->num_rows() <= 0) return false;
   $data = $data->result_array();
   foreach ($data as $one) {
    $this->db2->set('name_ua', $one['ua_name_kor']);
    $this->db2->set('name_ru', $one['ru_name_kor']);
    $this->db2->insert('site_mat_corpus');
    echo 'Insert --> ', $this->db2->insert_id(), ' <> ', $one['ua_name_kor'], ' ... ', '<br />';
   }
   #echo '<pre>'; print_r($data); echo '</pre>';
  } else $this->setText('Заповнення таблиці `site_corpus` --> ');
 }
 
 private function GS_fasade() {
  if (isset($_POST['trigger']) && $_POST['trigger']) {
   $data = $this->db3->select('*')->from('mat_fasad')->get();
   if ($data->num_rows() <= 0) return false;
   $data = $data->result_array();
   foreach ($data as $one) {
    $this->db2->set('name_ua', $one['ua_name_fas']);
    $this->db2->set('name_ru', $one['ru_name_fas']);
    $this->db2->insert('site_mat_facade');
    echo 'Insert --> ', $this->db2->insert_id(), ' <> ', $one['ua_name_fas'], ' ... ', '<br />';
   }
   #echo '<pre>'; print_r($data); echo '</pre>';
  } else $this->setText('Заповнення таблиці `site_fasade` --> ');
 }
 
 private function GS_factory() {
  if (isset($_POST['trigger']) && $_POST['trigger']) {
   $data = $this->db3->select('*')->from('factory')->get();
   if ($data->num_rows() <= 0) return false;
   $data = $data->result_array();
   foreach ($data as $one) {
    $this->db2->set('name_ua', $one['ua_name_fac']);
    $this->db2->set('city_ua', $one['ua_city_fac']);
    $this->db2->set('description_ua', $one['ua_opis_fac']);
    $this->db2->set('name_ru', $one['ru_name_fac']);
    $this->db2->set('city_ru', $one['ru_city_fac']);
    $this->db2->set('description_ru', $one['ru_opis_fac']);
    if ($one['id_fac'] == 1) $this->db2->set('valuta', 10.7);
    elseif ($one['id_fac'] == 17) $this->db2->set('valuta', 11);
    else $this->db2->set('valuta', 1.00);
    $this->db2->insert('site_factory');
    echo 'Insert factory --> ', $this->db2->insert_id(), ' <> ', $one['ua_name_fac'], ' ... ', '<br />';
   }
   #echo '<pre>'; print_r($data); echo '</pre>';
  } else $this->setText('Заповнення таблиці `site_factory` --> ');
 }
 
 private function GS_PP() {
  if (isset($_POST['trigger']) && $_POST['trigger']) {   
   $data = $this->db3->select('*')->from('pp')->get();
   if ($data->num_rows() <= 0) return false;
   $data = $data->result_array();
   foreach ($data as $one) {
    $this->db2->set('name_ua', $one['name_pp']);
    $this->db2->set('shortname_ua', $one['pname_pp']);
    $this->db2->set('name_ru', $one['name_pp']);
    $this->db2->set('shortname_ru', $one['pname_pp']);
    $this->db2->set('edrpou', $one['edrpou_pp']);
    $this->db2->set('phone', $one['tel_pp']);
    $this->db2->insert('site_pp');
    $newppid = $this->db2->insert_id();
    echo 'Insert pp --> ', $newppid, '<br />';
    
    if (isset($one['rr_pp']) && !empty($one['rr_pp'])) {
     $this->db2->set('ppid', $newppid);
     $this->db2->set('score', $one['rr_pp']);
     $this->db2->set('bank_ua', $one['bank_pp']);
     $this->db2->set('bank_ru', $one['bank_pp']);
     $this->db2->set('bank_mfo', $one['mfo_pp']);
     $this->db2->insert('site_pp_score');
     echo 'Insert score --> ', $this->db2->insert_id(), '<br />';
    }
    
    if (isset($one['card']) && !empty($one['card'])) {
     $this->db2->set('ppid', $newppid);
     $this->db2->set('score', $one['card']);
     $this->db2->set('bank_ua', $one['bank_pp']);
     $this->db2->set('bank_ru', $one['bank_pp']);
     $this->db2->set('bank_mfo', $one['mfo_pp']);
     $this->db2->insert('site_pp_score');
     echo 'Insert score --> ', $this->db2->insert_id(), '<br />';
    }
   }
   #echo '<pre>'; print_r($data); echo '</pre>';
  } else $this->setText('Заповнення таблиці `site_pp` & `site_pp_score` --> ');
 }
 
 private function GS_region() {
  if (isset($_POST['trigger']) && $_POST['trigger']) {
   $data = $this->db3->select('*')->from('region')->get();
   if ($data->num_rows() <= 0) return false;
   $data = $data->result_array();
   foreach ($data as $one) {
    $this->db2->set('name_ua', $one['ua_name']);
    $this->db2->set('region_name_ua', $one['ua_region']);
    $this->db2->set('region_name2_ua', $one['ua_region2']);
    $this->db2->set('name_ru', $one['ru_name']);
    $this->db2->set('region_name_ru', $one['ru_region']);
    $this->db2->set('region_name2_ru', $one['ru_region2']);
    $this->db2->set('markup', $one['multi']);
    $this->db2->set('ppid', $one['id_pp']);
    $this->db2->insert('site_region');
    echo $this->db2->insert_id(), '<br />';
   }
   echo '<br />All data inserted succefully!';
  } else $this->setText('Заповнення таблиці `site_region` --> ');
 }
 
 private function setText($text = '') {
  if (empty($text)) $text = 'Розпочати операцію?';
  
  echo $text, '<br />', '<form action="" method="post"><input type="submit" name="trigger" value="Жги!" /></form>';
 }
}