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
//var_dump(DEFAULT_CONTROLLER); die;
$route['default_controller'] = DEFAULT_CONTROLLER;
$route['404_override'] = 'ST_404';
$route['translate_uri_dashes'] = TRUE;

$route['ticket']                                    = '/dashboard/main';

$route['users']                                     = '/user/auth/auth';
$route['users/(:any)']                              = '/user/auth/auth/$1';
$route['users/(:any)/(:any)']                       = '/user/auth/auth/$1/$2';

$route['auth']                                      = '/user/auth/auth';
$route['auth/(:any)']                               = '/user/auth/auth/$1';
$route['auth/(:any)/(:any)']                        = '/user/auth/auth/$1/$2';
$route['profile/(:num)']                            = 'profile/index/$1';

$route['report/(:any)']                             = '/reports/report/render/$1';
$route['report/get-data/(:any)']                    = '/reports/report/get-data/$1';
$route['report/get-chart-data/(:any)']              = '/reports/report/get-chart-data/$1';

$route['ticket/verification/(:any)']                = '/ticket/verification/index/$1';
$route['ticket/qr/(:any)']                          = '/ticket/qr/index/$1';
$route['ticket/print/(:any)']                       = '/ticket/card/pdf/$1';

$frontend = 'frontend';

$route['booking/reset-password/(:any)/(:any)']      = "/booking/$frontend/reset-password/$1/$2";
$route['booking']                                   = "/booking/$frontend/register";
$route['booking/register/:any']                     = "/booking/$frontend/register";
$route['booking/login/:any']                        = "/booking/$frontend/login/";
$route['booking/logout/:any']                       = "/booking/$frontend/logout/";
$route['booking/forgot-password']                   = "/booking/$frontend/forgot-password";
$route['booking/forgot-password/:any']              = "/booking/$frontend/forgot-password";

$route['booking/:any']                              = "/booking/$frontend/register";



$route['booking/add/:any']                          = "/booking/$frontend/add/";
$route['booking/cart/:any']                         = "/booking/$frontend/cart/";
$route['booking/edit/(:num)/:any']                  = "/booking/$frontend/edit/$1";
$route['booking/remove/(:num)/:any']                = "/booking/$frontend/remove/$1";
$route['booking/checkout/:any']                     = "/booking/$frontend/checkout";
$route['booking/transaction_details/:any']          = "/booking/$frontend/transaction_details";
$route['booking/history/:any']                      = "/booking/$frontend/history";
$route['booking/order/(:any)/:any']                 = "/booking/$frontend/order/$1";
$route['booking/ticket/(:any)/:any']                = "/booking/$frontend/ticket/$1";
$route['booking/qr/(:any)/:any']                    = "/booking/$frontend/qr/$1";
$route['booking/invoice/(:any)/:any']               = "/booking/$frontend/invoice/$1";
$route['booking/refund/(:any)/:any']                = "/booking/$frontend/refund/$1";


//$route['booking/midtrans/checkout']                 = "/booking/$frontend/checkout/index";

$route['terms-of-use']                              = "/booking/$frontend/terms-of-use";
$route['refund-policy']                             = "/booking/$frontend/refund-policy";
$route['privacy-policy']                            = "/booking/$frontend/privacy-policy";


