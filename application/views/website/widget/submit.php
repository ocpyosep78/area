<?php
	// link submit
	$link_download = (isset($_GET['link'])) ? $_GET['link'] : '';
	$post = $this->Post_model->get_by_id(array( 'download' => $link_download ));
	$link_submit = base_url('submit?link='.$link_download);
	
	// meta
	$title = 'Suekarea - Widget Submit';
	$desc = 'Suekarea - Share Movie Download and Share Anime Download - Widget Submit';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title><?php echo $title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="title" content="<?php echo $title; ?>" />
	<meta name="description" content="<?php echo $desc; ?>" />
	<style type="text/css">
	body, div, a, img { margin: 0px; padding: 0px; border: none; }
	#submit { text-align: center; }
	#submit a { float: left; width: 60px; height: 15px; }
	#submit a img { width: 60px; height: 15px; }
	</style>
</head>
<body id="submit">
	<?php if (count($post) > 0) { ?>
	<a href="<?php echo $post['post_link']; ?>" target="_blank">
		<img src="<?php echo base_url('static/img/logo.png'); ?>" />
	</a>
	<?php } else { ?>
	<a href="<?php echo $link_submit; ?>" target="_blank">
		<img src="<?php echo base_url('static/img/widget_submit.png'); ?>" />
	</a>
	<?php } ?>
</body>
</html>