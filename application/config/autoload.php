<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$autoload['packages'] = array();
$autoload['libraries'] = array('database', 'session');
$autoload['helper'] = array( 'date', 'common', 'url' );
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array(
	'User_model', 'Category_model', 'Post_Type_model', 'Post_model', 'Comment_model', 'Request_model', 'User_Type_model'
);
