<?php

if (!function_exists('getsite_url')) {
 function getsite_url() {
  return 'http://patifon.com/';
 }
}

if (!function_exists('getsiteurl')) {
 function getsiteurl() {
  return 'http://patifon.com/';
 }
}


if (!function_exists('baseurl')) {
 function baseurl($uri = '') {
  $CI =& get_instance();
  return $CI->config->base_url($uri);
 }
}

/**
 * хелпер модифицирован для возврата baseurl + /lang/
 */
if (!function_exists('base_url')) {

    function base_url() {
        $CI = & get_instance();

        $langAllow = array('ru', 'en');

        $lang = $CI->uri->segment(1);

        if (in_array($lang, $langAllow)) {
            $lang = $lang . '/';
        } else
            $lang = '';


        return $CI->config->slash_item('base_url') . $lang;
    }

}



/**
 * хелпер модифицирован для возврата URL без index.php и со значением языка в первом сегменте uri
 */
if (!function_exists('site_url')) {

    function site_url($uri = '') {
        $CI = & get_instance();
        return base_url() . $uri;
    }

}



function lang_switch($target_lang, $allow_lang, $default_lang='ua'){

    $CI = &get_instance();

  $cur_uri = $CI->uri->uri_string();

  $cur_lang = $CI->uri->segment(1);

  if(!in_array($cur_lang, $allow_lang)){

      $cur_lang = $default_lang;

      $cur_uri = $default_lang.'/'.$cur_uri;


  }


  if($cur_lang == $target_lang){

      $target_url = $CI->config->slash_item('base_url').substr($cur_uri, 0, 50);

      return $target_url ;

      } else {

          $target_url = $CI->config->slash_item('base_url').substr(str_replace($cur_lang, $target_lang, $cur_uri),0,50);
 return $target_url ;

      }

}
