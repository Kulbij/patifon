<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Formed_lib {
 
 private $object_title;
 
 public function __construct() {
  $this->object_title = '{NAME} (Леново) купить {NAME} в Киеве, Харькове, Днепропетровске, Одессе, Донецке, Запорожье, Львове. Мобильный телефон {NAME} цена : обзор, отзывы, описание, продажа в Украине — patifon.com.ua';
  $this->category_title = "Купить Lenovo в Киеве, Харькове, Днепропетровске, Одессе, Донецке, Запорожье, Львове. Мобильный телефон цена : обзор, отзывы, описание, продажа в Украине — patifon.com.ua";
 }
 
 public function __get($variable) {
  return get_instance()->$variable;
 }
 
 public function getTKD($page = '', $inarray = array(), $segment2 = 0, $segment3 = 0) {
 $return = array();
 
 if (empty($page)) return $return;
  switch ($page) {
   case 'index': {
    $this->load->model('page_model');
    $return = $this->page_model->getIndexPageTKD();
   } break;
   case 'page': 
   case 'gallery':
   case 'articles':
   case 'news':
   case 'shares': {
    
    if ($page == 'gallery' && isset($inarray['galleryid']) && $inarray['galleryid'] > 0) {
     
     $this->load->model('gallery_model');
     $tkd = $this->gallery_model->getTKD($inarray['galleryid']);
     
     $this->load->model('page_model');
     $temp = $this->page_model->getPageTKD($page);
     
     if ((!isset($tkd['title']) || empty($tkd['title'])) && isset($temp['title'])) $tkd['title'] = $temp['title'];
     
     if ((!isset($tkd['keyword']) || empty($tkd['keyword'])) && isset($temp['keyword'])) $tkd['keyword'] = $temp['keyword'];
     
     if ((!isset($tkd['description']) || empty($tkd['description'])) && isset($temp['description'])) $tkd['description'] = $temp['description'];
     
     $return = $tkd;
    } elseif (($page == 'news' || $page == 'shares') && isset($inarray['breadid']) && isset($inarray['_TABLE'])) {
     
     $this->load->model('share_model');
     $tkd = $this->share_model->getTKD($inarray['_TABLE'], $inarray['breadid']);
     
     $this->load->model('page_model');
     $temp = $this->page_model->getPageTKD($page);
     
     if ((!isset($tkd['title']) || empty($tkd['title'])) && isset($temp['title'])) $tkd['title'] = $temp['title'];
     
     if ((!isset($tkd['keyword']) || empty($tkd['keyword'])) && isset($temp['keyword'])) $tkd['keyword'] = $temp['keyword'];
     
     if ((!isset($tkd['description']) || empty($tkd['description'])) && isset($temp['description'])) $tkd['description'] = $temp['description'];
     
     $return = $tkd;
    } else {
     $this->load->model('page_model');
     $page = $this->page_model->getPageTKD($inarray['page_link']);
     $index = $this->page_model->getIndexPageTKD();
     if ((!isset($page['title']) || empty($page['title'])) && isset($index['title'])) $page['title'] = $index['title'];
     if ((!isset($page['keyword']) || empty($page['keyword'])) && isset($index['keyword'])) $page['keyword'] = $index['keyword'];
     if ((!isset($page['description']) || empty($page['description'])) && isset($index['description'])) $page['description'] = $index['description'];
     $return = $page;
    }
    
   } break;
   case 'otherpage': {
    $this->load->model('page_model');
    $page = $this->page_model->getPageTKD($inarray['page_link'], true);
    $index = $this->page_model->getIndexPageTKD();
    if ((!isset($page['title']) || empty($page['title'])) && isset($index['title'])) $page['title'] = $index['title'];
    if ((!isset($page['keyword']) || empty($page['keyword'])) && isset($index['keyword'])) $page['keyword'] = $index['keyword'];
    if ((!isset($page['description']) || empty($page['description'])) && isset($index['description'])) $page['description'] = $index['description'];
    
    $return = $page;
    
   } break;
   case 'category': {           
   } break;

   case 'articles': {

   } break;

   case 'catalog': {          
    if (!isset($inarray['cat_id'])) $inarray['cat_id'] = 0;
    
    $this->load->model('page_model');
    $this->load->model('menu_model');
    $cat = $this->menu_model->getTKD($inarray['cat_id']);
    $index = $this->page_model->getIndexPageTKD();
    
     if (!isset($cat['title']) || empty($cat['title'])) {     
     $cat['title'] = $this->category_title;
    }
    
    if ((!isset($cat['title']) || empty($cat['title'])) && isset($index['title'])) $cat['title'] = $index['title'];
    if ((!isset($cat['keyword']) || empty($cat['keyword'])) && isset($index['keyword'])) $cat['keyword'] = $index['keyword'];
    if ((!isset($cat['description']) || empty($cat['description'])) && isset($index['description'])) $cat['description'] = $index['description'];
    $return = $cat;
    
   } break;
   case 'object': {
    $this->load->model('page_model');
    $this->load->model('menu_model');
    $this->load->model('catalog_model');
    
    if (!isset($inarray['obj_id'])) $inarray['obj_id'] = 0;
    $object = $this->catalog_model->getTKD($inarray['obj_id']);
    
    $index = $this->page_model->getIndexPageTKD();
    
    if (!isset($object['title']) || empty($object['title'])) {
     $rep_array = array(
      '{NAME}' => $this->catalog_model->getName($inarray['obj_id']),      
     );
     $object['title'] = strtr($this->object_title, $rep_array);
    }
    
    if ((!isset($object['title']) || empty($object['title'])) && isset($index['title'])) $object['title'] = $index['title'];
    if ((!isset($object['keyword']) || empty($object['keyword'])) && isset($index['keyword'])) $object['keyword'] = $index['keyword'];
    if ((!isset($object['description']) || empty($object['description'])) && isset($index['description'])) $object['description'] = $index['description'];
    $return = $object;
    
   } break;
  }
  
  $this->load->model('base_model');
  $return = $this->base_model->prepareDataString($return);
  
  return $return;
 }
 
 private function morph($n, $form1 = '', $form2 = '', $form5 = '') {
  return $n % 10 == 1 && $n % 100 != 11 ? $form1 : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $form2 : $form5);
 }
 
 public function numprice2strprice($num) {
  #initialize
  $nul = 'ноль';
  $ten = array(
       array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
       array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять')
      );
  $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
  $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
  $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
  $unit=array( // Units
      array('коп.', 'коп.', 'коп.', 1),
      array('грн.', 'грн.', 'грн.', 0),
      array('тысяча', 'тысячи', 'тысяч', 1),
      array('миллион', 'миллиона', 'миллионов', 0),
      array('миллиард', 'милиарда', 'миллиардов', 0),
  );
  
  if (SITELANG == 'ua') {
   $nul = 'нуль';
   $ten = array(
        array('', 'один', 'два', 'три', 'чотири', "п'ять", 'шість', 'сім', 'вісім', "дев'ять"),
        array('', 'одна', 'дві', 'три', 'чотири', "п'ять", 'шість', 'сім', 'вісім', "дев'ять")
       );
   $a20 = array('десять', 'одинадцять', 'дванадцять', 'тринадцять', 'чотирнадцять', "п'ятнадцять", 'шістнадцять', 'сімнадцять', 'вісімнадцять', "дев'ятнадцять");
   $tens = array(2 => 'двадцять', 'тридцять', 'сорок', "п'ятдесят", 'шістдесят', 'сімдесят', 'вісімдесят', "дев'яносто");
   $hundred = array('', 'сто', 'двісті', 'триста', 'чотириста', "п'ятсот", 'шістсот', 'сімсот', 'вісімсот', "дев'ятсот");
   $unit=array( // Units
       array('коп.', 'коп.', 'коп.', 1),
       array('грн.', 'грн.', 'грн.', 0),
       array('тисяча', 'тисячі', 'тисяч', 1),
       array('мільйон', 'мільйона', 'мільйонів', 0),
       array('мільярд', 'мільярда', 'мільярдів', 0),
   );
  }
  
  #calculation
  list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
  $out = array();
  if (intval($rub) > 0) {
      foreach(str_split($rub, 3) as $uk => $v) { // by 3 symbols
          if (!intval($v)) continue;
          $uk = sizeof($unit) - $uk - 1; // unit key
          $gender = $unit[$uk][3];
          list($i1, $i2, $i3) = array_map('intval', str_split($v,1));
          // mega-logic
          $out[] = $hundred[$i1]; # 1xx-9xx
          if ($i2 > 1) $out[] = $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
          else $out[] = ($i2 > 0) ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
          // units without rub & kop
          if ($uk > 1) $out[] = $this->morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
      } //foreach
  }
  else $out[] = $nul;
  $out[] = $this->morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
  $out[] = $kop.' '.$this->morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
  return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
 }
}