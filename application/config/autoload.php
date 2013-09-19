<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$autoload['packages'] = array();
$autoload['libraries'] = array('database', 'session');
$autoload['helper'] = array( 'date', 'common', 'url', 'mcrypt' );
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array(
	'User_model', 'Category_model', 'Post_Type_model', 'Post_model', 'Comment_model', 'Request_model', 'User_Type_model', 'Page_Static_model', 'Contact_model',
	'Scrape_Master_model', 'Scrape_Content_model', 'Tag_model', 'Post_Tag_model', 'Link_Short_model', 'Shout_Master_model', 'Shout_Content_model'
);
