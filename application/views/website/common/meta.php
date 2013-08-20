<?php
	$web['host'] = base_url();
	$title = (!empty($title)) ? $title : 'Suekarea - Share Movie Download and Share Anime Download';
	$desc = (!empty($desc)) ? $desc : 'Suekarea - Share Movie Download and Share Anime Download';
	$tag_meta = (isset($tag_meta) && is_array($tag_meta)) ? $tag_meta : array();
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8" />
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<?php foreach ($tag_meta as $meta) { ?>
<meta property="<?php echo $meta['property']; ?>" content="<?php echo $meta['content']; ?>">
<?php } ?>
<meta name="title" content="<?php echo $title; ?>" />
<meta name="description" content="<?php echo $desc; ?>" />
<title><?php echo $title; ?></title>
<link href="https://plus.google.com/114002599803233293136/posts" rel="author"/>
<link rel="stylesheet" type="text/css" media="all" id="primetime-style-css" href="<?php echo base_url('static/css/style.css'); ?>" />
<link rel="stylesheet" type="text/css" media="all" id="responsive-css" href="<?php echo base_url('static/css/responsive.css'); ?>" />
<link rel="icon shortcut" href="<?php echo base_url('static/img/favicon.png'); ?>" type="image/x-icon" />
<link rel="alternate" type="application/rss+xml" title="Suekarea Popular Post" href="<?php echo base_url('rss'); ?>" />
<link rel="alternate" type="application/rss+xml" title="Suekarea Latest Post" href="<?php echo base_url('rss/latest'); ?>" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/modernizr.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/utils.js'); ?>"></script>
<script> var web = <?php echo json_encode($web); ?></script>
</head>