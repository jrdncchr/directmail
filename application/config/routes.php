<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['login'] = 'auth/login';
$route['logout'] = 'dashboard/logout';
$route['register/(:any)'] = 'auth/register/$1';
$route['register/(:any)/(:any)'] = 'auth/register/$1/$2';
$route['default_controller'] = 'auth';

$route['404_override'] = 'auth/not_found';
$route['translate_uri_dashes'] = FALSE;
