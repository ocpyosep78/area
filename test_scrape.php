<?php
	set_time_limit(30);
	
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
	
	/*	*/
	$link = 'http://www.cupux-movie.com/feeds/posts/default?alt=rss';
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
	
	