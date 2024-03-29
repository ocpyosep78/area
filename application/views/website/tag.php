<?php
	$tag_alias = $this->uri->segments[2];
	$tag = $this->Tag_model->get_by_id(array( 'alias' => $tag_alias ));
	if (empty($tag_alias) || count($tag) == 0) {
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: '.base_url());
		exit;
	}
	
	// page
	$page_item = 10;
	$page_active = get_page();
	$page_base  = $tag['tag_link'];
	
	// post
	$param_post['tag_id'] = $tag['id'];
	$param_post['not_draft'] = true;
	$param_post['publish_date'] = $this->config->item('current_datetime');
	$param_post['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
	$param_post['start'] = ($page_active - 1) * $page_item;
	$param_post['limit'] = $page_item;
	$array_post = $this->Post_Tag_model->get_array($param_post);
	$page_count = ceil($this->Post_Tag_model->get_count() / $page_item);
	
	// meta
	$param_meta['title'] = 'Suekarea - '.$tag['name'].' - Page '.$page_active;
	$param_meta['desc'] = 'Download';
	foreach ($array_post as $post) {
		$param_meta['desc'] .= ' - '.$post['post_name'];
	}
	
	// get more meta
	if (strlen($param_meta['desc']) <= 75 && count($array_post) > 0) {
		$title = $array_post[0]['post_name'];
		$desc = $array_post[0]['post_desc'];
		
		$more_desc = strip_tags(trim(str_replace($title, '', $desc)));
		$param_meta['desc'] = get_length_char($param_meta['desc'].' - '.$more_desc, 250, '');
	}
	
	$page_at_url = preg_match('/\/page-[\d+]$/i', $_SERVER['REQUEST_URI'], $match);
	if ($page_active == 1 && !$page_at_url) {
		$param_meta['link_canonical'] = $tag['tag_link'].'/page-1';
	}
?>

<?php $this->load->view( 'website/common/meta', $param_meta ); ?>

<body class="blog boxed pattern-1 navigation-style-1">

<div id="page" class="hfeed site">
	<?php $this->load->view( 'website/common/header' ); ?>
	
    <div id="main" class="right_sidebar"><div class="inner"><div class="general_content clearboth">
		<div class="main_content"><div id="primary" class="content-area"><div id="content" class="site-content" role="main">
			<h2 class="page-title">Tag : <?php echo $tag['name']; ?></h2>
			
			<section id="reviews_body">
				<?php foreach ($array_post as $post) { ?>
				<article class="reviews type-reviews status-publish format-standard hentry">
					<?php if (!empty($post['thumbnail_small_link'])) { ?>
					<div class="pic">
						<a href="<?php echo $post['post_link']; ?>" title="<?php echo $post['post_name']; ?>" class="w_hover img-link img-wrap">
							<img width="340" height="244" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news_small wp-post-image" alt="<?php echo $post['post_name']; ?>" />
							<span class="overlay"></span>
							<span class="link-icon"></span>
						</a>
					</div>
					<?php } ?>
					<h3><a href="<?php echo $post['post_link']; ?>" title="<?php echo $post['post_name']; ?>"><?php echo $post['post_name']; ?></a></h3>
					<div class="text"><?php echo $post['desc_limit']; ?></div>
				</article>
				<?php } ?>
				
				<div id="nav_pages" class="nav_pages">
					<div class="pages">
						<ul>
							<?php for ($i = -5; $i <= 5; $i++) { ?>
								<?php $class = ($i == 0) ? 'current' : ''; ?>
								<?php $page_counter = $page_active + $i; ?>
								<?php $page_link = $page_base.'/page-'.$page_counter; ?>
								<?php if ($page_counter > 0 && $page_counter <= $page_count) { ?>
								<li class="<?php echo $class; ?>"><a href="<?php echo $page_link; ?>" title="<?php echo $tag['name'].' - Page '.$page_counter; ?>"><?php echo $page_counter; ?></a></li>
								<?php } ?>
							<?php } ?>
						</ul>
					</div>
					<div class="page_x_of_y">Page <span><?php echo $page_active; ?></span> of <span><?php echo $page_count; ?></span></div>
				</div>
			</section>
		</div></div></div>
		
		<?php $this->load->view( 'website/common/sidebar' ); ?>
	</div></div></div>
	
	<?php $this->load->view( 'website/common/footer' ); ?>
</div>

<?php $this->load->view( 'website/common/library_js' ); ?>

</body>
</html>