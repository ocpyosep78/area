<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'default';
$active_record = TRUE;

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$db['default']['hostname'] = 'localhost';
	$db['default']['username'] = 'root';
	$db['default']['password'] = '';
	$db['default']['database'] = 'suekarea_db';
} else if ($_SERVER['SERVER_NAME'] == 'suekarea.com' || $_SERVER['SERVER_NAME'] == 'www.suekarea.com') {
	$db['default']['hostname'] = 'localhost';
	$db['default']['username'] = 'infoguec_sueka';
	$db['default']['password'] = 'Cg1fcR_;!T&5';
	$db['default']['database'] = 'infoguec_suekarea_db';
}

$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */
