<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "main/login";
$route['404_override'] = '';

//---LOGIN region
$route['index'] = "main/index";
$route['logout'] = "main/logout";
//---end LOGIN region

//---OPTION region
$route['edit/save/(:any)'] = 'edit/save/$1';
$route['edit/send/(:any)'] = 'edit/send/$1';
$route['edit/search/(:any)'] = 'edit/search/$1';
$route['edit/del/(:any)/(:num)'] = 'edit/del/$1/$2';
$route['edit/copy/(:any)/(:num)'] = 'edit/copy/$1/$2';

$route['edit/vis/(:any)/(:num)'] = 'edit/setvis/$1/$2';
$route['edit/unvis/(:any)/(:num)'] = 'edit/unsetvis/$1/$2';

$route['edit/check/(:any)/(:num)'] = 'edit/setcheck/$1/$2';
$route['edit/uncheck/(:any)/(:num)'] = 'edit/unsetcheck/$1/$2';

$route['edit/pos/(up|down)/(:any)/(:num)'] = 'edit/setposition/$1/$2/$3';

$route['edit/actions/(:any)'] = 'edit/actions/$1';

$route['edit/ajax/(:any)'] = 'edit/ajax/$1';

$route['edit/fancyajax/(:any)/(:num)'] = 'edit/fancyajax/$1/$2';
//---end OPTION region

//---PAGE region
$route['edit/page/indeximg'] = 'edit/indeximg';
$route['edit/page/indeximg/(:num)'] = 'edit/indeximg/$1';

$route['edit/page/(:any)'] = "edit/page/$1";
$route['edit/page/(:any)/(:any)'] = "edit/page/$1/$2";
//---end PAGE region

//---GALLERY region
$route['edit/gallery/gallerycat'] = 'edit/gallerycat';
$route['edit/gallery/gallerycat/(:num)'] = 'edit/gallerycat/$1';
//---end GALLERY region

//---CATALOG region
$route['edit/catalog/(:any)'] = "edit/catalog/$1";
$route['edit/catalog/(:any)/(:num)'] = "edit/catalog/$1/$2";
//---end CATALOG region

//---ORDER region
$route['edit/order/(order|order_one_click)/(:num)'] = "edit/order/$1/$2";
//---end ORDER region

//---MESSAGE region
$route['edit/message/(:any)/(:num)'] = "edit/message/$1/$2";
//---end MESSAGE region

//---CLIENTS region
$route['edit/clients/clients/(:num)'] = "edit/clients/$1";
//---end CLIENTS region

//---COMMENTS region
$route['edit/comments/comments/(:num)'] = "edit/catalog/comments/$1";
//---end COMMENTS region

//---SETTING region
$route['edit/setting/scripts'] = 'edit/setting';
$route['edit/setting/scripts/(:num)'] = 'edit/setting/$1';
$route['edit/setting/(:any)'] = "edit/user/$1";
$route['edit/setting/(:any)/(:any)'] = "edit/user/$1/$2";

$route['edit/saveuser'] = "edit/saveuser";
$route['edit/deluser/(:num)'] = "edit/deluser/$1";
//---end SETTING region

//---MAIN region
$route['(:any)'] = "main/module/$1";
$route['(:any)/(:any)'] = "main/module/$1/$2";
$route['(:any)/(:any)/(:num)'] = "main/module/$1/$2/$3";
$route['(:any)/(:any)/(:num)/(:num)'] = "main/module/$1/$2/$3/$4";
$route['(:any)/(:any)/(:num)/(:num)/(:num)'] = "main/module/$1/$2/$3/$4/$5";
//---end MAIN region

/* End of file routes.php */
/* Location: ./application/config/routes.php */