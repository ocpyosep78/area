<?php
	set_time_limit(30);
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	$is_office = true;
	$library = 'awsubs';
	
	if ($is_office) {
		$localhost = 'http://localhost:8666/suekarea/trunk/';
		$path = 'C:\Program Files\xampplite\htdocs\suekarea\trunk';
	} else {
		$localhost = 'http://localhost/suekarea/trunk/';
		$path = 'E:\Program Files\xampplite\htdocs\suekarea\trunk';
	}
	
	include $path.'\application\helpers\common_helper.php';
	include $path.'\application\libraries\scrape\\'.$library.'.php';
	
	/*	
	$link = 'http://www.wardhanime.net/2013/09/ms-igloo-2-02.html';
	$curl = new curl();
	$content = $curl->get($link);
	Write($path.'\p.txt', $content);
	exit;
	/*	*/
	
	$link = $localhost.'p.txt';
	$content = file_get_contents($link);
	$content = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content);
	
	// scrape
	$desc = $library::get_desc($content);
//	echo $desc; exit;
	
	$download = $library::get_download($content);
	echo $download; exit;