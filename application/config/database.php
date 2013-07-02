<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'default';
$active_record = TRUE;

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$db['default']['hostname'] = 'localhost';
	$db['default']['username'] = 'root';
	$db['default']['password'] = '';
	$db['default']['database'] = 'job_db';
} else if ($_SERVER['SERVER_NAME'] == 'parapekerja.com' || $_SERVER['SERVER_NAME'] == 'www.parapekerja.com') {
	$db['default']['hostname'] = 'localhost';
	$db['default']['username'] = 'shoperin_job';
	$db['default']['password'] = '4gzlX6^Ozc9f';
	$db['default']['database'] = 'shoperin_job';
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
