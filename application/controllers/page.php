<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'main.php';

class Page extends Main {
 public function __construct() {
  parent::__construct();
 }

 public function index($link = '' , $print = '') {

  if (!empty($print) && $print != 'print') site_404_url();

  #parent::checkRedirect($link);

  $this->load->model('page_model');

  $this->data = array();
  $this->data['OTHER'] = false;
  $this->data['PAGE'] = 'page';

  if ($this->page_model->isOther($link)) {
   $this->data['OTHER'] = true;
   $this->data['PAGE'] = 'otherpage';
  } elseif (!$this->page_model->is($link)) site_404_url();

  $pageid = $this->page_model->getPageID($link, $this->data['OTHER']);
  $isdoc = $this->page_model->ifPageFiles($link, $this->data['OTHER']);

  $par_page_id = 0;
  $par_page_link = '';
  if (!$this->data['OTHER']) {

   $par_page_id = $this->page_model->getPageFParentID($pageid);
   $par_page_link = $this->page_model->getPageLink($par_page_id, $this->data['OTHER']);

  }

  $this->data['__LINK'] = $link;

  $this->data['__GEN'] = array(
   'page_link' => $link,
   'page_other' => $this->data['OTHER'],
   'par_page_id' => $par_page_id,
   'par_page_link' => $par_page_link,
   'pageid' => $pageid,
   'pages' =>  $this->page_model->getPageFParentID($pageid, true)
  );

  $this->data['__VIEW'] = 'page/page_view';

  parent::generateInData($this->data['__GEN'], $this->data['__VIEW'], $this->data['PAGE']);

  $this->data['CATEGORY_PAR'] = $this->data['__GEN']['pages'];
  $this->data['_PRINT_LINK'] = $link;
  $this->data['PRINT_PARAMETTER'] = $print;

  $content = array();

  $content['page'] = $this->page_model->getPageNaT($link, $this->data['OTHER']);

  $this->data['SITE_CONTENT'] = $content;

  $this->display_lib->page($this->data, $this->view);
 }

 private function generateSitemap() {
  $this->load->model('page_model');
  $this->load->model('menu_model');
  $this->load->model('catalog_model');

  $return = array();

  $return['pages'] = $this->page_model->get();

  $return['cats'] = $this->menu_model->generateTopMenu();

  foreach ($return['cats'] as &$one) {
   $one['children'] = $this->catalog_model->getCatalogObject($one['id'], array(), 999999);
   $one['link'] = 'catalog/'.$one['link'];
   foreach ($one['children'] as &$two) {
    $two['link'] = 'product/'.$two['link'];
   } unset($two);
  } unset($one);

  #echo '<pre>'; print_r($return); echo '</pre>';
  return $return;
 }

 #ARTICLES

 public function action_articles($page = 1) {
  $this->load->model('article_model');

  $page = (int)$page;
  if ($page <= 0) site_404_url();

  $pagination = array();
  $pagination['COUNTONPAGE'] = 15;
  $pagination['COUNTALL'] = $this->article_model->getCount();
  $pagination['THISPAGE'] = $page;
  $pagination['COUNTPAGE'] = ceil($pagination['COUNTALL']/$pagination['COUNTONPAGE']);

  if ($pagination['COUNTPAGE'] > 0 && $page > $pagination['COUNTPAGE']) site_404_url();

  $pagination['COUNTSHOWPAGE'] = 3;
  if ($pagination['THISPAGE'] == 1 || $pagination['THISPAGE'] == $pagination['COUNTPAGE']) $pagination['COUNTSHOWPAGE'] = 6;
  if ($pagination['COUNTPAGE'] <= 10) $pagination['COUNTSHOWPAGE'] = 10;

  $this->data = array();
  $this->data['__LINK'] = 'articles';

  $this->data['__GEN'] = array(
   'page_link' => 'articles'
  );

  parent::generateInData($this->data['__GEN'], 'articles/articles_view', $this->data['__LINK']);

  #page parametter
  $this->data['PAGE'] = $this->page;

  $this->data['PAGINATION'] = $pagination;
  #end

  $this->load->model('page_model');

  $content = array();

  $content['pagename'] = $this->page_model->getPageName($this->data['__LINK']);
  $content['page_link'] = $this->page_model->getPageLinkOne($this->data['__LINK']);
  $content['content'] = $this->article_model->get(0, $page, $pagination['COUNTONPAGE']);

  $this->data['SITE_CONTENT'] = $content;

  $this->display_lib->page($this->data, $this->view);
 }

 public function action_articles_one($link = '', $print = '') {
  if (!empty($print) && $print != 'print') site_404_url();

  $this->load->model('article_model');

  $this->data = array();
  $this->data['__LINK'] = 'articles';

  $artid = $this->article_model->is($link);
  if (!$artid) site_404_url();

  $this->data['__GEN'] = array(
   'page_link' => 'articles',
   'breadid' => $artid,
  );

  parent::generateInData($this->data['__GEN'], 'articles/articles_one_view', $this->data['__LINK']);

  #DATA
  $this->data['_PRINT_LINK'] = 'articles/detail/'.$link;
  $this->data['PRINT_PARAMETTER'] = $print;
  #end

  $this->load->model('page_model');

  $content = array();

  $content['content'] = $this->article_model->getOne($artid);

  $this->data['SITE_CONTENT'] = $content;

  $this->display_lib->page($this->data, $this->view);
 }

 #end

 #SHARES

 public function action_share($page = 1) {
  $this->load->model('promo_model');

  $page = (int)$page;
  if ($page <= 0) site_404_url();

  $pagination = array();
  $pagination['COUNTONPAGE'] = 15;
  $pagination['COUNTALL'] = $this->promo_model->getCount();
  $pagination['THISPAGE'] = $page;
  $pagination['COUNTPAGE'] = ceil($pagination['COUNTALL']/$pagination['COUNTONPAGE']);

  if ($pagination['COUNTPAGE'] > 0 && $page > $pagination['COUNTPAGE']) site_404_url();

  $pagination['COUNTSHOWPAGE'] = 3;
  if ($pagination['THISPAGE'] == 1 || $pagination['THISPAGE'] == $pagination['COUNTPAGE']) $pagination['COUNTSHOWPAGE'] = 6;
  if ($pagination['COUNTPAGE'] <= 10) $pagination['COUNTSHOWPAGE'] = 10;

  $this->data = array();
  $this->data['__LINK'] = 'promotions';

  $this->data['__GEN'] = array(
   'page_link' => 'promotions'
  );

  parent::generateInData($this->data['__GEN'], 'promotions/promotions_view', $this->data['__LINK']);

  #page parametter
  $this->data['PAGE'] = $this->page;

  $this->data['PAGINATION'] = $pagination;
  #end

  $this->load->model('page_model');

  $content = array();

  $content['pagename'] = $this->page_model->getPageName($this->data['__LINK']);
  $content['content'] = $this->promo_model->get(0, $page, $pagination['COUNTONPAGE']);

  $this->data['SITE_CONTENT'] = $content;

  $this->display_lib->page($this->data, $this->view);
 }

 public function action_show_share($link = '', $print = '') {
  if (!empty($print) && $print != 'print') site_404_url();

  $this->load->model('promo_model');

  $this->data = array();
  $this->data['__LINK'] = 'promotions';

  $promo_id = $this->promo_model->is($link);
  if (!$promo_id) site_404_url();

  $this->data['__GEN'] = array(
   'page_link' => 'promotions',
   'breadid' => $promo_id,
  );

  parent::generateInData($this->data['__GEN'], 'promotions/promotions_one_view', $this->data['__LINK']);

  #DATA
  $this->data['_PRINT_LINK'] = 'promotions/detail/'.$link;
  $this->data['PRINT_PARAMETTER'] = $print;
  #end

  $this->load->model('page_model');

  $content = array();

  $content['content'] = $this->promo_model->getOne($promo_id);

  $this->data['SITE_CONTENT'] = $content;

  $this->display_lib->page($this->data, $this->view);
 }

 #end SHARES

 #GALLERY region
 public function action_gallery($galleryid = '') {
  #$galleryid = (int)$galleryid;
  #if ($galleryid < 0) site_404_url();

  $this->load->model('page_model');
  $real_galleryid = $this->page_model->lb_is($galleryid);
  if (!empty($galleryid) && $real_galleryid === false) site_404_url();

  $this->data = array();
  $this->data['__LINK'] = 'gallery';
  $this->data['__GEN'] = array(
   'page_link' => 'lookbook',
   'page_other' => true,
   'galleryid' => $real_galleryid
  );

  parent::generateInData($this->data['__GEN'], 'page/gallery_view', $this->data['__LINK']);

  $content = array();

  $this->load->model('menu_model');
  $content['menu'] = $this->menu_model->generateTopMenu();

  if ($real_galleryid > 0) {
   #$content['images'] = $this->gallery_model->getImages($galleryid);
   $content['in_lookbook'] = $this->page_model->lb_inLB($real_galleryid);
  } else {
   #$content['galleries'] = $this->gallery_model->getGalleries();
   $content['lookbooks'] = array();
   $temp = $this->page_model->lb_get();
   if (isset($temp[0])) {
    $content['lookbooks']['last'] = $temp[0];
    unset($temp[0]);
    $content['lookbooks']['other'] = $temp;
   }
  }

  $this->data['SITE_CONTENT'] = $content;

  $this->display_lib->page($this->data, $this->view);

 }
 #this is the end... */

 public function action_contact() {

  $this->load->model('page_model');

  $this->data = array();
  $this->data['__LINK'] = 'contact';
  $this->data['__GEN'] = array(
   'page_link' => 'contact'
  );

  parent::generateInData($this->data['__GEN'], 'page/contact_view', 'page');

  $content = array();

  $content['pagename'] = $this->page_model->getPageName($this->data['__LINK']);
  $content['pagetext'] = $this->page_model->getPageText($this->data['__LINK']);
  #$content['pageemail'] = $this->page_model->getPageEmail($this->data['__LINK']);
  #$content['contact'] = $this->page_model->getContact();
  #$content['destination'] = $this->page_model->getQTD();

  // $this->load->model('phone_model');
  // $content['phones'] = $this->phone_model->get();

  $this->data['SITE_CONTENT'] = $content;

  $this->display_lib->page($this->data, $this->view);
 }

}