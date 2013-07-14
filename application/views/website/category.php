<?php
	$category_alias = $this->uri->segments[1];
	$category = $this->Category_model->get_by_id(array( 'alias' => $category_alias ));
	$is_popular = get_popular();
	
	// page
	$page_item = 10;
	$page_active = get_page();
	
	// page link
	$page_base  = $category['link'];
	$page_base .= ($is_popular) ? '' : '/latest';
	
	// toggle
	$toggle_title = ($is_popular) ? 'Latest Post' : 'Popular Post';
	$toggle_page = ($is_popular) ? $category['link'].'/latest' : $category['link'];
	
	// post
	$param_post['is_popular'] = $is_popular;
	$param_post['category_id'] = $category['id'];
	$param_post['not_draft'] = true;
	$param_post['publish_date'] = $this->config->item('current_datetime');
	$param_post['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
	$param_post['start'] = ($page_active - 1) * $page_item;
	$param_post['limit'] = $page_item;
	$array_post = $this->Post_model->get_array($param_post);
	$page_count = ceil($this->Post_model->get_count() / $page_item);
?>

<?php $this->load->view( 'website/common/meta' ); ?>

<body class="blog boxed pattern-1 navigation-style-1">

<div id="page" class="hfeed site">
	<?php $this->load->view( 'website/common/header' ); ?>
	
    <div id="main" class="right_sidebar"><div class="inner"><div class="general_content clearboth">
		<div class="main_content"><div id="primary" class="content-area"><div id="content" class="site-content" role="main">
			<h2 class="page-title">
				<a class="toggle" href="<?php echo $toggle_page; ?>"><?php echo $toggle_title; ?></a>
				<?php echo $category['name']; ?>
			</h2>
			
			<section id="reviews_body">
				<?php foreach ($array_post as $post) { ?>
				<article class="post-562 reviews type-reviews status-publish format-standard hentry">
					<div class="pic">
						<a href="<?php echo $post['post_link']; ?>" class="w_hover img-link img-wrap">
							<img width="340" height="244" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news_small wp-post-image" alt="5">
							<span class="overlay"></span>
							<span class="link-icon"></span>
						</a>
					</div>
					<h3><a href="<?php echo $post['post_link']; ?>"><?php echo $post['name']; ?></a></h3>
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
								<li class="<?php echo $class; ?>"><a href="<?php echo $page_link; ?>" title=""><?php echo $page_counter; ?></a></li>
								<?php } ?>
							<?php } ?>
							<?php
							/*
							<li class="current"><a href="http://wpspace.net/?page_id=216" title="">1</a></li>
							<li><a href="http://wpspace.net/?page_id=216&paged=2" title="2">2</a></li>
							<li><a href="http://wpspace.net/?page_id=216&paged=3" title="3">3</a></li>
							/*	*/
							?>
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