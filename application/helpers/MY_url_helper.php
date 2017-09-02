<?php

if (!function_exists('site_404_url')) {
 function site_404_url() {
  redirect(anchor_wta(site_url('404')), 'refresh');
 }
}

if (!function_exists('site_url')) {
 function site_url($uri = '') {
  $CI = &get_instance();
  return $CI->config->base_url($uri);
 }
}

if (!function_exists('baseurl')) {
 function baseurl($uri = '') {
  $CI = &get_instance();
  return $CI->config->base_url($uri);
 }
}

if (!function_exists('resource_url')) {
 function resource_url($uri = '', $param = array()) {
  $CI = &get_instance();
  $url = $CI->config->base_url($uri);

  if (isset($param['js']) && $param['js'] && $CI->config->item('__js_version')) {

   $url .= '?ver='.$CI->config->item('__js_version');

  } else if (isset($param['css']) && $param['css'] && $CI->config->item('__css_version')) {

   $url .= '?ver='.$CI->config->item('__css_version');

  }

  return $url;
 }
}

/**
 * хелпер модифицирован для возврата baseurl + /lang/
 */
if (!function_exists('base_url')) {
 function base_url() {
  $CI = &get_instance();

  $langAllow = $CI->config->item('site_lang_all');
  $lang = $CI->uri->segment(1);
  if (in_array($lang, $langAllow))
   $lang = $lang.'/';
  else $lang = $CI->config->item('site_lang_default').'/';
  
  return $CI->config->slash_item('base_url').$lang;
 }
}


/*
* anchor for add suffix
*/
if (!function_exists('anchor')) {
 function anchor($uri = '', $title = '', $attributes = '') {
  $CI = &get_instance();
  $title = (string) $title;

  if (!is_array($uri)) {
   $site_url = (!preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
  } else {
   $site_url = site_url($uri);
  }

  if ($title == '') {
   $title = $site_url;
  }

  if ($attributes != '') {
   $attributes = _parse_attributes($attributes);
  }
  
  $base_temp = $CI->config->item('base_url');
  if (substr($base_temp, strlen($base_temp) - 1) == "/")
   $base_temp = substr($base_temp, 0, strlen($base_temp) - 1);
  
  if (substr($site_url, strlen($site_url) - 1) == "/")
   $site_url = substr($site_url, 0, strlen($site_url) - 1);
  
  $temp = explode('#', $site_url);
  if (is_array($temp) && count($temp) == 2) 
   $site_url = $temp[0].$CI->config->item('url_suffix').'#'.$temp[1];
  elseif ($site_url != $base_temp)
   $site_url = $temp[0].$CI->config->item('url_suffix');
  
  return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
 }
}

/*
* achor for generate link without tag <a> and attributes
*/
if (!function_exists('anchor_wta')) {
 function anchor_wta($uri = '') {
  $CI = &get_instance();

  if (!is_array($uri)) {
   $site_url = (!preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
  } else {
   $site_url = site_url($uri);
  }
  
  $base_temp = $CI->config->item('base_url');
  if (substr($base_temp, strlen($base_temp) - 1) == "/")
   $base_temp = substr($base_temp, 0, strlen($base_temp) - 1);
  
  if (substr($site_url, strlen($site_url) - 1) == "/")
   $site_url = substr($site_url, 0, strlen($site_url) - 1);
  
  $temp = explode('#', $site_url);
  if (is_array($temp) && count($temp) == 2)
   $site_url = $temp[0].$CI->config->item('url_suffix').'#'.$temp[1];
  elseif ($site_url != $base_temp)
   $site_url = $temp[0].$CI->config->item('url_suffix');
  
  return $site_url;
 }
}



/**
 * хелпер модифицирован для возврата URL без index.php
 * и со значением языка в первом сегменте uri
 */
if (!function_exists('site_url')) {
 function site_url($uri = '') {
  $CI = &get_instance();
  return base_url().$uri;
 }
}



function lang_switch($target_lang) {
 $CI = &get_instance();
 
 $allow_lang = $CI->config->item('site_lang_all');
 $default_lang = $CI->config->item('site_lang_default');
 
 $cur_uri = $CI->uri->uri_string();
 $cur_lang = $CI->uri->segment(1);
  
 if (!in_array($cur_lang, $allow_lang)) {
  $cur_lang = $default_lang;
  $cur_uri = $default_lang.'/'.$cur_uri;
 }
 
 $cur_uri = '/'.$cur_uri;

 if($cur_lang == $target_lang) {
  $target_url = $CI->config->slash_item('base_url').substr($cur_uri, 0, 250);
  return $target_url;
 } else {
  $target_url = $CI->config->slash_item('base_url').substr(str_replace('/'.$cur_lang, '/'.$target_lang, $cur_uri), 1, 250);
  return $target_url ;
 }
}

function lang_switch_suff($target_lang) {
 $CI = &get_instance();
 
 $allow_lang = $CI->config->item('site_lang_all');
 $default_lang = $CI->config->item('site_lang_default');
 
 $cur_uri = $CI->uri->uri_string();
 $cur_lang = $CI->uri->segment(1);

 if (!in_array($cur_lang, $allow_lang)) {
  $cur_lang = $default_lang;
  $cur_uri = $default_lang.'/'.$cur_uri;
 }

 $cur_uri = '/'.$cur_uri;

 if ($cur_lang == $target_lang) {
  $target_url = $CI->config->slash_item('base_url').substr($cur_uri, 0, 250);

  if (substr($target_url, strlen($target_url) - 1) == "/") 
   $target_url = substr($target_url, 0, strlen($target_url) - 1);
  
 } else {
  $target_url = $CI->config->slash_item('base_url').substr(str_replace('/'.$cur_lang, '/'.$target_lang, $cur_uri), 1, 250);
  
  if (substr($target_url, strlen($target_url) - 1) == "/")
   $target_url = substr($target_url, 0, strlen($target_url) - 1);

  }
  
  return str_replace('http:/', 'http://', str_replace('//', '/', $target_url.$CI->config->item('url_suffix')));
}