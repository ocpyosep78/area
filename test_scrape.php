<?php
	set_time_limit(5);
	
	$is_office = true;
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
	include $path.'\application\libraries\oplovers.php';
	
	/*	
	$link = 'http://www.alibabasub.net/2013/09/kami-nomi-zo-shiru-sekai-megami-hen-episode-10-subtitle-indonesia.html';
	$curl = new curl();
	$content = $curl->get($link);
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
	
	