<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
$is_website = true;
$is_other_page = false;

$url_arg = preg_replace('/(^\/|\/$)/i', '', @$_SERVER['argv'][0]);
$array_arg = explode('/', $url_arg);

if (count($array_arg) >= 1) {
	$key = $array_arg[0];
	if (in_array($key, array( 'panel' ))) {
		$is_website = false;
	} else if (in_array($key, array( 'full-page' ))) {
		$is_other_page = true;
	}
}

if ($is_website) {
	$route['(anime|film|tv-serial|cartoon)'] = "website/category";
	$route['(anime|film|tv-serial|cartoon)/(:any)'] = "website/category";
	$route['contact'] = "website/contact";
	$route['(:num)/(:num)/(:any)'] = "website/detail";
}

if ($is_other_page) {
	$route['(:any)'] = "website/other";
}

$route['panel'] = "panel/home";

$route['default_controller'] = "website/home";
$route['404_override'] = '';