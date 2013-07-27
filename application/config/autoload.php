<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$autoload['packages'] = array();
$autoload['libraries'] = array('database', 'session', 'cupux_movie');
$autoload['helper'] = array( 'date', 'common', 'url', 'mcrypt' );
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array(
	'User_model', 'Category_model', 'Post_Type_model', 'Post_model', 'Comment_model', 'Request_model', 'User_Type_model', 'Page_Static_model', 'Contact_model',
	'Scrape_Master_model', 'Scrape_Content_model'
);
