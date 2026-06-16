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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['auth/registeruser'] = 'auth/register_user';
$route['auth_staff/regiter_staffonly'] = 'auth/register_staff';
$route['auth/login'] = 'auth/login';
$route['dashboard/admin'] = 'dashboard/admin';
$route['buku/searchBooks'] = 'Buku/searchBooks';
$route['buku/detail/(:any)'] = 'buku/detail/$1';
$route['buku/search_api'] = 'Buku/search_api';
$route['WHOOOPLIBRARY'] = 'dashboard/user';
$route['approved/cek_approve'] = 'approved/cek_approve';
$route['approved/cek_reject'] = 'approved/cek_reject';
$route['deposit/konfirmasi_deposit/(:num)/(:any)'] = 'deposit/konfirmasi_deposit/$1/$2';
$route['search'] = 'user/search';
$route['search/(:any)'] = 'user/search/$1';
$route['search/(:any)/(:any)'] = 'user/search/$1/$2';
$route['usersettings'] = 'UserSettings/index';
$route['usersettings/update_profile'] = 'UserSettings/update_profile';
$route['usersettings/change_password'] = 'UserSettings/change_password';
$route['usersettings/delete_account'] = 'UserSettings/delete_account';
$route['translate_uri_dashes'] = FALSE;
