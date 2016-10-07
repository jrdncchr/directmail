<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['login'] = 'page/login';
$route['register/(:any)'] = 'page/register/$1';
$route['register/(:any)/(:any)'] = 'page/register/$1/$2';
$route['default_controller'] = 'page';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
