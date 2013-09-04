<?php
	include 'E:\Program Files\xampplite\htdocs\suekarea\trunk\application\helpers\common_helper.php';
	include 'E:\Program Files\xampplite\htdocs\suekarea\trunk\application\libraries\ganool.php';
	
	/*
	$link = 'http://ganool.com/kotonoha-no-niwa';
	$content = file_get_contents($link);
	Write('E:\Program Files\xampplite\htdocs\suekarea\trunk\post.txt', $content);
	exit;
	/*	*/
	
	$link = 'http://localhost/suekarea/trunk/post.txt';
	$content = file_get_contents($link);
	$content = preg_replace('/[^\x20-\x7E|\x0A]/i', '', $content);
	
	// scrape
	$desc = ganool::get_desc($content);
	
	$download = ganool::get_download($content);
	echo $download; exit;
	
	