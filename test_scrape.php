<?php
	include 'C:\Program Files\xampplite\htdocs\suekarea\trunk\application\helpers\common_helper.php';
	include 'C:\Program Files\xampplite\htdocs\suekarea\trunk\application\libraries\ganool.php';
	include 'C:\Program Files\xampplite\htdocs\suekarea\trunk\application\libraries\awsubs.php';
	
	/*	
	$link = 'http://ganool.com/never-let-me-go-2010-bluray-720p-600mb-ganool';
	$content = file_get_contents($link);
	Write('C:\Program Files\xampplite\htdocs\suekarea\trunk\post.txt', $content);
	exit;
	/*	*/
	
	$link = 'http://localhost:8666/suekarea/trunk/post.txt';
	$content = file_get_contents($link);
	$content = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content);
	
	// scrape
	$desc = ganool::get_desc($content);
	
	$download = ganool::get_download($content);
	echo $download; exit;
	
	