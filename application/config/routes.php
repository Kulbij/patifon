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
 *
 *
 * avi,bmp,png,css,doc,gif,htm,html,ico,jpeg,jpg,js,mp3,swf,txt,xls,zip,wml,wmlc,wmls,wmlsc,wbmp,fla,flv,xml,mpg,mpeg,pdf
 *
*/
$route['default_controller'] = 'main/index';
$route['404_override'] = 'main/show404';
$route['404'] = 'main/show404';

#$route['import'] = 'import/index';

$route['catalog/(:any)/(:any)/page/(:num)'] = 'catalog/sub_or_object/$1/$2/$3';

#SHARES region
$route['promotions'] = 'page/action_share';
$route['promotions/page/(:num)'] = 'page/action_share/$1';
$route['promotions/detail/(:any)'] = 'page/action_show_share/$1';
$route['promotions/detail/(:any)/print'] = 'page/action_show_share/$1/print';
#end SHARES region */
$route['compare'] = 'compare/action_compare';
#ARTICLES region
$route['articles'] = 'page/action_articles';
$route['articles/page/(:num)'] = 'page/action_articles/$1';
$route['articles/detail/(:any)'] = 'page/action_articles_one/$1';
$route['articles/detail/(:any)/print'] = 'page/action_articles_one/$1/print';
#this is the end... */

/* create a sand massages */

$route['msg/send/(:num)'] = 'message/SendMessagesForUser/$1';
$route['msg/(:num)'] = 'message/send/$1';

#PRODUCT region
#$route['catalog'] = 'catalog/index';

$route['catalog/search'] = 'catalog/action_search';
$route['catalog/search/page/(:num)'] = 'catalog/action_search/$1';

$route['catalog/(:any)/(:any)/(:any)/(reviews)/page/(:num)'] = 'object/index/$3/$4/$5';
$route['catalog/(:any)/(:any)/(reviews)/page/(:num)'] = 'object/index/$2/$3/$4';
$route['catalog/(:any)/(:any)/(:any)/tab/(:any)'] = 'object/index/$3/$4';
$route['catalog/(:any)/(:any)/tab/(:any)'] = 'object/index/$2/$3';
$route['catalog/(:any)/(:any)/filter/(:any)'] = 'catalog/sub_or_object/$1/$2/$3';
$route['catalog/(:any)/(:any)/reviews/page/(:num)'] = 'object/index/$1/$2/$3';
$route['catalog/(:any)/(:any)/filter'] = 'catalog/sub_or_object/$1/$2';
$route['catalog/(:any)/filter/(:any)'] = 'catalog/index/$1/$2';
$route['catalog/(:any)/(:any)/(:any)'] = 'object/index/$3';
$route['catalog/(:any)/filter'] = 'catalog/index/$1/$2';
$route['catalog/(:any)/(:any)/cat'] = 'catalog/sub_or_object/$1/$2';
$route['catalog/(:any)/(:any)'] = 'catalog/sub_or_object/$1/$2';
$route['catalog/(:any)'] = 'catalog/index/$1';

$route['pidcatalog/(:any)'] = 'catalog/pidcatalog/$1';


$route['product/(:any)/(:any)/page/(:num)'] = 'object/index/$1/$2/$3';
$route['product/(:any)/(:any)'] = 'object/index/$1/$2';
$route['product/(:any)'] = 'object/index/$1';
#end PRODUCT region

#$route['contact/print'] = 'page/action_contact/print';
$route['contact'] = 'page/action_contact';

#Registration Users
$route['registration'] = 'auth/registration';
$route['registration/ok'] = 'auth/good_reg';
$route['auth/check_reg/(:any)'] = 'auth/checkreg/$1';

#CART region
#$route['cart'] = 'cart/index';
$route['cart/clear'] = 'cart/action_clear';
$route['cart/order'] = 'cart/action_order';
//$route['cart/invoice/print/pdf'] = 'cart/action_invoice/print/pdf';
$route['cart/invoice/print'] = 'cart/action_invoice/print';
$route['cart/invoice'] = 'cart/action_invoice';
$route['cart/(:any)'] = 'cart/ajax_cartaction/$1';
#end CART region

$route['images/(:num)/(:any)/(:any)'] = 'main/watermark/$1/$2/$3';

$route['img'] = 'main/watermark';
$route['img/(:any)'] = 'main/watermark/$1';
$route['img/(:num)/(:any)'] = "main/watermark/$1/$2";
//$route['img/(:num)/(:any)/(:any)'] = "main/watermark/$1/$2/$3";

$route['ajax/(:any)'] = 'ajax/index/$1';
$route['ajax/(:any)/(:any)'] = 'ajax/index/$1/$2';

$route['(:any)/(:any)'] = 'page/index/$1/$2';
$route['(:any)'] = 'page/index/$1';

#end DEFAULT

/* End of file routes.php */
/* Location: ./application/config/routes.php */