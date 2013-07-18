<?php
	// slide
	$param_slide['is_hot'] = 1;
	$param_slide['limit'] = 9;
	$param_slide['not_draft'] = true;
	$param_slide['publish_date'] = $this->config->item('current_datetime');
	$param_slide['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
	$array_slide = $this->Post_model->get_array($param_slide);
	
	// film
	$param_film['is_popular'] = 1;
	$param_film['limit'] = 5;
	$param_film['category_id'] = CATEGORY_FILM;
	$param_film['not_draft'] = true;
	$param_film['publish_date'] = $this->config->item('current_datetime');
	$param_film['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
	$array_film = $this->Post_model->get_array($param_film);
	
	// anime
	$param_anime['is_popular'] = 1;
	$param_anime['limit'] = 5;
	$param_anime['category_id'] = CATEGORY_ANIME;
	$param_anime['not_draft'] = true;
	$param_anime['publish_date'] = $this->config->item('current_datetime');
	$param_anime['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
	$array_anime = $this->Post_model->get_array($param_anime);
	
	// tv serial
	$param_tv['is_popular'] = 1;
	$param_tv['limit'] = 3;
	$param_tv['category_id'] = CATEGORY_TV_SERIAL;
	$param_tv['not_draft'] = true;
	$param_tv['publish_date'] = $this->config->item('current_datetime');
	$param_tv['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
	$array_tv = $this->Post_model->get_array($param_tv);
	
	// cartoon
	$param_cartoon['is_popular'] = 1;
	$param_cartoon['limit'] = 3;
	$param_cartoon['category_id'] = CATEGORY_CARTOON;
	$param_cartoon['not_draft'] = true;
	$param_cartoon['publish_date'] = $this->config->item('current_datetime');
	$param_cartoon['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
	$array_cartoon = $this->Post_model->get_array($param_cartoon);
	
	// meta
	$desc = 'Download';
	foreach ($array_slide as $post) {
		$desc .= ' - '.$post['name'];
	}
?>

<?php $this->load->view( 'website/common/meta', array( 'desc' => $desc ) ); ?>

<body class="blog boxed pattern-1 navigation-style-1">

<div id="page" class="hfeed site">
<?php $this->load->view( 'website/common/header' ); ?>

<div id="main" class="right_sidebar"><div class="inner"><div class="general_content clearboth">
	<div class="main_content"><div id="primary" class="content-area"><div id="content" class="site-content" role="main">
		<div class="block_home_slider style2"><div class="slider-wrapper">
			<div id="home_slider" class="flexslider">
				<ul class="slides">
					<?php for ($i = 0; $i < 6; $i++) { ?>
					<li>
						<div class="slide">
							<a href="<?php echo $array_slide[$i]['post_link']; ?>">
								<img src="<?php echo $array_slide[$i]['thumbnail_link']; ?>" alt="<?php echo $array_slide[$i]['name']; ?>">
							</a>
							<div class="caption">
								<p class="title"><?php echo $array_slide[$i]['name']; ?></p>
								<p class="body"><?php echo $array_slide[$i]['desc_limit']; ?></p>
							</div>
						</div>
					</li>
					<?php } ?>
				</ul>
			</div>
			
			<ul id="thumb_controls">
				<?php for ($i = 0; $i < 6; $i++) { ?>
				<li class="slider-item1"><img src="<?php echo $array_slide[$i]['thumbnail_small_link']; ?>"><span class="left_bot"></span><span class="right_top"></span></li>
				<?php } ?>
			</ul>
		</div></div>
		
		<div class="recent_news_home clearboth">
			<?php for ($i = 6; $i < 9; $i++) { ?>
			<div class="block_home_post">
				<div class="post-image">
					<a href="<?php echo $array_slide[$i]['post_link']; ?>" class="img-link img-wrap w_hover">
						<img width="388" height="246" src="<?php echo $array_slide[$i]['thumbnail_small_link']; ?>" class="attachment-recent_news_homepage wp-post-image" alt="<?php echo $array_slide[$i]['name']; ?>" />
						<span class="link-icon"></span>
						<span class="overlay"></span>
					</a>
				</div>
				<div class="post-content">
					<div class="title"><a href="<?php echo $array_slide[$i]['post_link']; ?>"><?php echo $array_slide[$i]['name']; ?></a></div>
				</div>
			</div>
			<?php } ?>
		</div>
		
		<div class="home_category_news clearboth">
			<div class="border-top"></div><h2 class="block-title">Film</h2>
			<div class="items-wrap">
				<?php foreach ($array_film as $key => $post) { ?>
				<?php if ($key == 0) { ?>
				<div class="block_home_post first-post">
					<div class="post-image">
						<a href="<?php echo $post['post_link']; ?>" class="img-link img-wrap w_hover">
							<img width="600" height="352" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news_first wp-post-image" alt="<?php echo $post['name']; ?>" />
							<span class="link-icon"></span>
							<span class="overlay"></span>
						</a>
					</div>
					<div class="post-content">
						<div class="title"><a href="<?php echo $post['post_link']; ?>"><?php echo $post['name']; ?></a></div>
					</div>
					<div class="post-body"><?php echo $post['desc_limit']; ?></div>
					<?php if ($post['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
					<div class="post-desc">by <a href="<?php echo $post['link_source']; ?>">Suekarea</a></div>
					<?php } else { ?>
					<div class="post-desc">by <a href="<?php echo $post['post_link']; ?>">Suekarea</a></div>
					<?php } ?>
				</div>
				<?php } else if ($key <= 2) { ?>
				<div class="block_home_post bd-bot">
					<div class="post-image">
						<a href="<?php echo $post['post_link']; ?>" class="img-link img-wrap w_hover">
							<img width="170" height="126" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news wp-post-image" alt="<?php echo $post['name']; ?>" />
							<span class="link-icon"></span>
							<span class="overlay"></span>
						</a>
					</div>
					<div class="post-content">
						<div class="title"><a href="<?php echo $post['post_link']; ?>"><?php echo $post['name']; ?></a></div>
					</div>
					<?php if ($post['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
					<div class="post-desc">by <a href="<?php echo $post['link_source']; ?>">Suekarea</a></div>
					<?php } else { ?>
					<div class="post-desc">by <a href="<?php echo $post['post_link']; ?>">Suekarea</a></div>
					<?php } ?>
				</div>
				<?php } else { ?>
				<div class="block_home_post">
					<div class="post-image">
						<a href="<?php echo $post['post_link']; ?>" class="img-link img-wrap w_hover">
							<img width="170" height="126" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news wp-post-image" alt="<?php echo $post['name']; ?>" />
							<span class="link-icon"></span>
							<span class="overlay"></span>
						</a>
					</div>
					<div class="post-content">
						<div class="title"><a href="<?php echo $post['post_link']; ?>"><?php echo $post['name']; ?></a></div>
					</div>
					<?php if ($post['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
					<div class="post-desc">by <a href="<?php echo $post['link_source']; ?>">Suekarea</a></div>
					<?php } else { ?>
					<div class="post-desc">by <a href="<?php echo $post['post_link']; ?>">Suekarea</a></div>
					<?php } ?>
				</div>
				<?php } ?>
				<?php } ?>
			</div>
			<div class="view-all"><a href="<?php echo base_url('film'); ?>">View all Film</a></div>
		</div>
		
		<div class="home_category_news clearboth">
			<div class="border-top"></div><h2 class="block-title">Anime</h2>
			<div class="items-wrap">
				<?php foreach ($array_anime as $key => $post) { ?>
				<?php if ($key == 0) { ?>
				<div class="block_home_post first-post">
					<div class="post-image">
						<a href="<?php echo $post['post_link']; ?>" class="img-link img-wrap w_hover">
							<img width="600" height="352" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news_first wp-post-image" alt="<?php echo $post['name']; ?>" />
							<span class="link-icon"></span>
							<span class="overlay"></span>
						</a>
					</div>
					<div class="post-content">
						<div class="title"><a href="<?php echo $post['post_link']; ?>"><?php echo $post['name']; ?></a></div>
					</div>
					<div class="post-body"><?php echo $post['desc_limit']; ?></div>
					<?php if ($post['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
					<div class="post-desc">by <a href="<?php echo $post['link_source']; ?>">Suekarea</a></div>
					<?php } else { ?>
					<div class="post-desc">by <a href="<?php echo $post['post_link']; ?>">Suekarea</a></div>
					<?php } ?>
				</div>
				<?php } else if ($key <= 2) { ?>
				<div class="block_home_post bd-bot">
					<div class="post-image">
						<a href="<?php echo $post['post_link']; ?>" class="img-link img-wrap w_hover">
							<img width="170" height="126" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news wp-post-image" alt="<?php echo $post['name']; ?>" />
							<span class="link-icon"></span>
							<span class="overlay"></span>
						</a>
					</div>
					<div class="post-content">
						<div class="title"><a href="<?php echo $post['post_link']; ?>"><?php echo $post['name']; ?></a></div>
					</div>
					<?php if ($post['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
					<div class="post-desc">by <a href="<?php echo $post['link_source']; ?>">Suekarea</a></div>
					<?php } else { ?>
					<div class="post-desc">by <a href="<?php echo $post['post_link']; ?>">Suekarea</a></div>
					<?php } ?>
				</div>
				<?php } else { ?>
				<div class="block_home_post">
					<div class="post-image">
						<a href="<?php echo $post['post_link']; ?>" class="img-link img-wrap w_hover">
							<img width="170" height="126" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news wp-post-image" alt="<?php echo $post['name']; ?>" />
							<span class="link-icon"></span>
							<span class="overlay"></span>
						</a>
					</div>
					<div class="post-content">
						<div class="title"><a href="<?php echo $post['post_link']; ?>"><?php echo $post['name']; ?></a></div>
					</div>
					<?php if ($post['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
					<div class="post-desc">by <a href="<?php echo $post['link_source']; ?>">Suekarea</a></div>
					<?php } else { ?>
					<div class="post-desc">by <a href="<?php echo $post['post_link']; ?>">Suekarea</a></div>
					<?php } ?>
				</div>
				<?php } ?>
				<?php } ?>
			</div>
			<div class="view-all"><a href="<?php echo base_url('anime'); ?>">View all Anime</a></div>
		</div>
		
		<div class="two_columns_news clearboth">
			<div class="home_category_news_small clearboth">
				<div class="border-top"></div><h2 class="block-title">TV Serial</h2>
				<div class="items-wrap">
					<?php foreach ($array_tv as $key => $post) { ?>
					<?php if ($key == 0) { ?>
					<div class="block_home_post first-post">
						<div class="post-image">
							<a href="<?php echo $post['post_link']; ?>" class="img-link img-wrap w_hover">
								<img width="600" height="352" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news_first wp-post-image" alt="<?php echo $post['name']; ?>" />
								<span class="link-icon"></span>
								<span class="overlay"></span>
							</a>
						</div>
						<div class="post-content">
							<div class="title"><a href="<?php echo $post['post_link']; ?>"><?php echo $post['name']; ?></a></div>
						</div>
						<div class="post-body"><?php echo get_length_char($post['desc_limit'], 125, ' ...'); ?></div>
						<?php if ($post['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
						<div class="post-desc">by <a href="<?php echo $post['link_source']; ?>">Suekarea</a></div>
						<?php } else { ?>
						<div class="post-desc">by <a href="<?php echo $post['post_link']; ?>">Suekarea</a></div>
						<?php } ?>
					</div>
					<?php } else { ?>
					<div class="block_home_post">
						<div class="post-image">
							<a href="<?php echo $post['post_link']; ?>" class="img-link img-wrap w_hover">
								<img width="170" height="126" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news wp-post-image" alt="<?php echo $post['name']; ?>" />
								<span class="link-icon"></span>
								<span class="overlay"></span>
							</a>
						</div>
						<div class="post-content">
							<div class="title"><a href="<?php echo $post['post_link']; ?>"><?php echo $post['name']; ?></a></div>
						</div>
						<?php if ($post['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
						<div class="post-desc">by <a href="<?php echo $post['link_source']; ?>">Suekarea</a></div>
						<?php } else { ?>
						<div class="post-desc">by <a href="<?php echo $post['post_link']; ?>">Suekarea</a></div>
						<?php } ?>
					</div>
					<?php } ?>
					<?php } ?>
				</div>
				<div class="view-all"><a href="<?php echo base_url('tv-serial'); ?>">View all TV Serial</a></div>
			</div>
			
			<div class="home_category_news_small clearboth">
				<div class="border-top"></div><h2 class="block-title">Cartoon</h2>
				<div class="items-wrap">
					<?php foreach ($array_cartoon as $key => $post) { ?>
					<?php if ($key == 0) { ?>
					<div class="block_home_post first-post">
						<div class="post-image">
							<a href="<?php echo $post['post_link']; ?>" class="img-link img-wrap w_hover">
								<img width="600" height="352" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news_first wp-post-image" alt="<?php echo $post['name']; ?>" />
								<span class="link-icon"></span>
								<span class="overlay"></span>
							</a>
						</div>
						<div class="post-content">
							<div class="title"><a href="<?php echo $post['post_link']; ?>"><?php echo $post['name']; ?></a></div>
						</div>
						<div class="post-body"><?php echo get_length_char($post['desc_limit'], 125, ' ...'); ?></div>
						<?php if ($post['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
						<div class="post-desc">by <a href="<?php echo $post['link_source']; ?>">Suekarea</a></div>
						<?php } else { ?>
						<div class="post-desc">by <a href="<?php echo $post['post_link']; ?>">Suekarea</a></div>
						<?php } ?>
					</div>
					<?php } else { ?>
					<div class="block_home_post">
						<div class="post-image">
							<a href="<?php echo $post['post_link']; ?>" class="img-link img-wrap w_hover">
								<img width="170" height="126" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news wp-post-image" alt="<?php echo $post['name']; ?>" />
								<span class="link-icon"></span>
								<span class="overlay"></span>
							</a>
						</div>
						<div class="post-content">
							<div class="title"><a href="<?php echo $post['post_link']; ?>"><?php echo $post['name']; ?></a></div>
						</div>
						<?php if ($post['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
						<div class="post-desc">by <a href="<?php echo $post['link_source']; ?>">Suekarea</a></div>
						<?php } else { ?>
						<div class="post-desc">by <a href="<?php echo $post['post_link']; ?>">Suekarea</a></div>
						<?php } ?>
					</div>
					<?php } ?>
					<?php } ?>
				</div>
				<div class="view-all"><a href="<?php echo base_url('cartoon'); ?>">View all Cartoon</a></div>
			</div>
		</div>
	</div></div></div>
	
	<?php $this->load->view( 'website/common/sidebar' ); ?>
</div></div></div>

<?php $this->load->view( 'website/common/footer' ); ?>
</div>

<?php $this->load->view( 'website/common/library_js' ); ?>

<script>
jQuery(function () {
	$('#home_slider').flexslider({
		animation: 'fade', animationLoop: true, slideshow: true, slideshowSpeed: 7000, animationSpeed: 600, controlNav: true, directionNav: true, pauseOnAction: true,
		pauseOnHover: false, useCSS: false, manualControls: '#thumb_controls li', start: function(){}, end: function(){}, added: function(){}, removed: function(){}
	});
});
</script>

</body>
</html>