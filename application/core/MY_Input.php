<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Input extends CI_Input {

 /**
   * value
   *
   * @param array
   * @param key
   * @param empty - if check for empty
   * @param default - return default value
   *
   * @relation -
   *
   * @return mixed
   * @author ME
   **/
 public function value($array = array(), $key = '', $empty = false, $default = array()) {
  if (!isset($array[$key]) || ($empty && empty($array[$key]))) return $default;
  return $array[$key];
 }

 /* ALIAS for value function */
 public function value_array($array = array(), $key = '', $empty = false, $default = array()) {
  return $this->value($array, $key, $empty, $default);
 }

 /**
   * value
   *
   * @param stdClass
   * @param key
   * @param empty - if check for empty
   * @param default - return default value
   *
   * @relation -
   *
   * @return mixed
   * @author ME
   **/
 public function value_class($class = null, $key = '', $empty = false, $default = array()) {
  if (is_object($class) && !isset($class->$key) || ($empty && empty($class->$key))) return $default;
  return $class->$key;
 }

 public function price_format($price = 0, $decimal = 0, $point = ',', $thousand = ' ') {
  $price = (float)$price;
  if ($price <= 0) return 0;

  if ($price == (int)$price) $price = number_format($price, 0, $point, $thousand);
  else $price = number_format($price, $decimal, $point, $thousand);

  return $price;
 }

 public function pl_form($n, $form1 = '', $form2 = '', $form5 = '') {
  return $n % 10 == 1 && $n % 100 != 11 ? $form1 : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $form2 : $form5);
 }

 public function prepare_user_identity_phone($phone) {

  $symbs = array(
   ' ',   
   '(',
   ')',
   '–'
  );

  return str_replace($symbs, '', $phone);
 }

 public function generate_string($in_string = '', $length = 0) {

  if ($length <= 0) $length = 6;

  $vowels = 'aeuyAEUY';
  $consonants = 'bdgh23jmnpqrstv45zBDGH67JLMNPQ89RSTVWXZ'.md5($in_string);
  $password = '';
  $alt = time() % 2;

  for ($i = 0; $i < $length; $i++) {
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

 public function get_referer($baseurl) {
  if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $baseurl) !== false) return $_SERVER['HTTP_REFERER'];

  return site_url();
 }

 public function curl_init($link, $xml) {
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $link);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

  $response = curl_exec($ch);

  curl_close($ch);

  return $response;
 }

}