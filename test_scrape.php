<?php
	include 'C:\Program Files\xampplite\htdocs\suekarea\trunk\application\helpers\common_helper.php';
	include 'C:\Program Files\xampplite\htdocs\suekarea\trunk\application\libraries\ganool.php';
	include 'C:\Program Files\xampplite\htdocs\suekarea\trunk\application\libraries\awsubs.php';
	
	/*	
	$link = 'http://www.wardhanime.net/2013/09/free-episode-9-subtitle-indonesia.html';
	$content = file_get_contents($link);
	Write('C:\Program Files\xampplite\htdocs\suekarea\trunk\post.txt', $content);
	exit;
	/*	*/
	
	$link = 'http://localhost:8666/suekarea/trunk/post.txt';
	$content = file_get_contents($link);
	$content = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content);
	
	// scrape
	$desc = awsubs::get_desc($content);
	
	$download = awsubs::get_download($content);
	echo $download; exit;
	
	