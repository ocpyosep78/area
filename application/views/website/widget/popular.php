<?php
	$param_popular['filter'] = '[{"type":"date","comparison":"gt","value":"'.date("m/d/Y", strtotime( "-2 weeks" )).'","field":"Post.publish_date"}]';
	$param_popular['not_draft'] = true;
	$param_popular['sort'] = '[{"property":"view_count","direction":"DESC"}]';
	$param_popular['limit'] = 6;
	$array_popular = $this->Post_model->get_array($param_popular);
	
	// meta
	$title = 'Suekarea - Share Movie Download and Share Anime Download - Widget Popular';
	$desc = 'Download';
	foreach ($array_popular as $post) {
		$desc .= ' - '.$post['name'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title><?php echo $title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="title" content="<?php echo $title; ?>" />
	<meta name="description" content="<?php echo $desc; ?>" />
	<style type="text/css">
	#popular { margin: 0px; padding: 0px; }
	#popular .box { width: 298px; border: 1px solid #CCCCCC; }
	#popular .post { float: left; width: 145px; height: 94px; padding: 1px 2px; }
	#popular .post img { width: 100%; }
	</style>
</head>
<body id="popular">
	<div class="box">
		<?php foreach ($array_popular as $post) { ?>
		<div class="post">
			<a href="<?php echo $post['post_link']; ?>" title="<?php echo $post['name']; ?>" target="_blank">
				<img src="<?php echo $post['thumbnail_small_link']; ?>" alt="<?php echo $post['name']; ?>" /></a>
		</div>
		<?php } ?>
		<div style="clear: both;"></div>
	</div>
</body>
</html>