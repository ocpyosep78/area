<?php
	set_time_limit(30);
	
	$is_office = false;
	$library = 'ganool';
	
	if ($is_office) {
		$path = 'C:\Program Files\xampplite\htdocs\suekarea\trunk';
	} else {
		$localhost = 'http://localhost/suekarea/trunk/';
		$path = 'E:\Program Files\xampplite\htdocs\suekarea\trunk';
	}
	
	include $path.'\application\helpers\common_helper.php';
	include $path.'\application\libraries\\'.$library.'.php';
	
	/*	
	$link = 'http://ganool.com/the-naked-gun-2%c2%bd-the-smell-of-fear-1991-bluray-1080p-5-1ch-x264-ganool';
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
	
	