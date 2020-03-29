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


$route['branches/(:any)'] = 'branches/$1';
$route['branches'] = 'branches/index';

$route['branch_inventories/(:any)'] = 'branch_inventories/$1';
$route['branch_inventories'] = 'branch_inventories/index';

$route['brands/(:any)'] = 'brands/$1';
$route['brands'] = 'brands/index';

$route['categories/(:any)'] = 'categories/$1';
$route['categories'] = 'categories/index';

$route['items/(:any)'] = 'items/$1';
$route['items'] = 'items/index';

$route['pos/(:any)'] = 'pos/$1';
$route['pos'] = 'pos/index';

$route['sales/(:any)'] = 'sales/$1';
$route['sales'] = 'sales/index';

$route['sales_on_hold/(:any)'] = 'sales_on_hold/$1';
$route['sales_on_hold'] = 'sales_on_hold/index';

$route['stock_types/(:any)'] = 'stock_types/$1';
$route['stock_types'] = 'stock_types/index';

$route['supply_requests/(:any)'] = 'supply_requests/$1';
$route['supply_requests'] = 'supply_requests/index';

$route['users/(:any)'] = 'users/$1';
$route['users'] = 'users/index';

$route['warehouse_inventories/(:any)'] = 'warehouse_inventories/$1';
$route['warehouse_inventories'] = 'warehouse_inventories/index';


$route['(:any)'] = 'users/';
$route['default_controller'] = 'users/';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
