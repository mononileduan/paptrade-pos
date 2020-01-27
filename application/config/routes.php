<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


$route['brands/(:any)'] = 'brands/$1';
$route['brands'] = 'brands/index';
$route['categories/(:any)'] = 'categories/$1';
$route['categories'] = 'categories/index';
$route['inventories/(:any)'] = 'inventories/$1';
$route['inventories'] = 'inventories/index';
$route['inventories_branch/(:any)'] = 'inventories_branch/$1';
$route['inventories_branch'] = 'inventories_branch/index';
$route['models/(:any)'] = 'models/$1';
$route['models'] = 'models/index';
$route['pos/(:any)'] = 'pos/$1';
$route['pos'] = 'pos/index';
$route['purchase_orders/(:any)'] = 'purchase_orders/$1';
$route['purchase_orders'] = 'purchase_orders/index';
$route['purchase_orders_dtl/(:any)'] = 'purchase_orders_dtl/$1';
$route['purchase_orders_dtl'] = 'purchase_orders_dtl/index';
$route['sales/(:any)'] = 'sales/$1';
$route['sales'] = 'sales/index';
$route['suppliers/(:any)'] = 'suppliers/$1';
$route['suppliers'] = 'suppliers/index';
$route['unit_types/(:any)'] = 'unit_types/$1';
$route['unit_types'] = 'unit_types/index';
$route['(:any)'] = 'users/';
$route['default_controller'] = 'users/';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
