<?php
	set_time_limit(5);
	
	$is_office = false;
	$library = 'alibaba';
	
	if ($is_office) {
		$path = 'C:\Program Files\xampplite\htdocs\suekarea\trunk';
	} else {
		$localhost = 'http://localhost/suekarea/trunk/';
		$path = 'E:\Program Files\xampplite\htdocs\suekarea\trunk';
	}
	
	include $path.'\application\helpers\common_helper.php';
	include $path.'\application\libraries\ganool.php';
	include $path.'\application\libraries\awsubs.php';
	include $path.'\application\libraries\alibaba.php';
	
	/*	
	$link = 'http://www.alibabasub.net/2013/09/hunter-x-hunter-2011-episode-95-subtitle-indonesia.html';
	$content = file_get_contents($link);
	Write($path.'\post.txt', $content);
	exit;
	/*	*/
	
	$link = $localhost.'post.txt';
	$content = file_get_contents($link);
	$content = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content);
	
	// scrape
	$desc = $library::get_desc($content);
	$download = $library::get_download($content);
	
	echo $download; exit;
	
	