<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('SHA_SECRET',							'OraNgerti');
define('CATEGORY_ANIME',						3);
define('CATEGORY_CARTOON',						4);
define('CATEGORY_FILM',							1);
define('CATEGORY_TV_SERIAL',					2);
define('POST_TYPE_DRAFT',						1);
define('POST_TYPE_SINGLE_LINK',					2);
define('POST_TYPE_MULTI_LINK',					3);

define('CATEGORY',								'category');
define('COMMENT',								'comment');
define('POST',									'post');
define('POST_TYPE',								'post_type');
define('REQUEST',								'request');
define('USER',									'user');
define('USER_TYPE',								'user_type');