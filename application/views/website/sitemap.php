<?php
	preg_match('/(\d{4})(\d{2})\.xml$/i', $_SERVER['REQUEST_URI'], $match);
	$year = (!empty($match[1])) ? $match[1] : date("Y");
	$month = (!empty($match[2])) ? $match[2] : date("m");
	
	$param_post['year'] = $year;
	$param_post['month'] = $month;
	$param_post['limit'] = 1000;
	$array_post = $this->Post_model->get_array($param_post);
	
	header('content-type: application/xhtml+xml; charset=utf-8');
    echo "<?xml version='1.0' encoding='UTF-8'?>\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
<?php foreach ($array_post as $post) { ?>
<url>
	<loc><?php echo $post['post_link']; ?></loc> 
	<?php if (!empty($post['thumbnail_link'])) { ?>
	<image:image><image:loc><?php echo $post['thumbnail_link']; ?></image:loc></image:image>
	<?php } ?>
</url>
<?php } ?>
</urlset>