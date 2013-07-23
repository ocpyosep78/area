<?php
	$web['host'] = base_url();
	$title = (!empty($title)) ? $title : 'Suekarea - Share Movie Download and Share Anime Download';
	$desc = (!empty($desc)) ? $desc : 'Suekarea - Share Movie Download and Share Anime Download';
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php echo $title; ?></title>
	<meta name="title" content="<?php echo $title; ?>" />
	<meta name="description" content="<?php echo $desc; ?>" />
	<link rel="stylesheet" type="text/css" media="all" id="primetime-style-css" href="<?php echo base_url('static/css/style.css'); ?>" />
	<link rel="stylesheet" type="text/css" media="all" id="responsive-css" href="<?php echo base_url('static/css/responsive.css'); ?>" />
	<link rel="icon shortcut" href="<?php echo base_url('static/img/favicon.png'); ?>" type="image/x-icon" />
	<script type="text/javascript" src="<?php echo base_url('static/js/jquery.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/modernizr.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/utils.js'); ?>"></script>
	<script> var web = <?php echo json_encode($web); ?></script>
</head>