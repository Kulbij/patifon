<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'main.php';

class Compare extends Main {

    public function __construct() {
	parent::__construct();
    }

    public function action_compare() {
		if (!$this->input->get('objects')) {
		    $items = $this->input->cookie('compare', true);
		    if (!$items) {
			redirect();
		    }
		    $items = json_decode($items);
		    $link = "compare?";
		    foreach ($items as $key => $one) {
			$link .= "objects[{$key}]={$one}&";
		    }
		    redirect(anchor_wta($link));
		}
		$objects = $this->input->get('objects', TRUE);
		$this->load->model('catalog_model');

		$this->data = array();
		$this->data['__LINK'] = 'compare';
		$this->data['OTHER'] = true;

		$this->data['__GEN'] = array(
		    'page_link' => $this->data['__LINK'],
		    'page_other' => $this->data['OTHER']
		);

		parent::generateInData(
			$this->data['__GEN'], 'catalog/catalog_compare_view', 'otherpage'
		);

		#page parametter
		$this->data['PAGE'] = $this->page;
		#end

		$content = array();

		$this->load->model('page_model');
		$content['categoryname'] = $this->page_model->getPageName($this->data['__LINK'], $this->data['OTHER']);
		$content['page_link'] = $this->page_model->getPageLinkOne($this->data['__LINK'], $this->data['OTHER']);
		$content['PAGENAME'] = $content['categoryname'];
		$content['catalog'] = $this->catalog_model->getCompareObjects($objects);
		foreach($content['catalog'] as &$one){
		    // $one['features'] = $this->catalog_model->getObjectFeatures($one['id']);
	    	$filters = $this->catalog_model->getFilterObjectOne($one['id']); //+++
	    	$one['filters'] = $filters;
	    	// if (isset($filters[$one['id']])){
	    	// 	$i = 0; foreach($filters[$one['id']] as $key => $value){
	    	// 		$filter[$i] = $value['name'];
	    	// 		$i++;
	    	// 	} unset($value);
	    	// 	$one['filters'] = $filter;
	    	// }


		    $one['comm_count'] = $one['comm_count'] . ' ' . parent::pluralForm($one['comm_count'],'отзыв',"отзыва","отзывов");
		    //$one['features'] = $this->parseTable($one['features']);
	        $one['links'] = $this->menu_model->getObjectCategories($one['id']);
		} unset($one);

		// echo "<pre>"; print_r($content['catalog']); die();

		$this->data['SITE_CONTENT'] = $content;

		// echo "<pre>"; print_r($this->data); die();

		$this->display_lib->catalog($this->data, $this->view);
    }

    private function parseTable($table){
		if(empty($table))
		    return [];
		$matches = [];
		preg_match_all("/435\">\s*[<\s*p.*>]*<\s*span.*>([^<]*)<\s*\/\s*span\s*>[<\s*\/\s*p\s*>]*/", $table, $matches);
		
		if(isset($matches[1]) && is_array($matches[1])){
		    $matches = $matches[1];
		}else{
		    $matches = [];
		}
		
		foreach($matches as $key => $one){	    
		    if(strlen($one) == 2){		
			unset($matches[$key]);
		    }
		}
		return $matches;
    }    
}
