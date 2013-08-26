<?php
	$post = $this->Post_model->get_link();
	if (count($post) == 0 || $post['post_type_id'] == POST_TYPE_DRAFT) {
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: '.base_url());
		exit;
	} else {
		$this->Post_model->increment_view(array( 'id' => $post['id'], 'view_count' => $post['view_count'] ));
	}
	
	// post detail
	$post = $this->Post_model->get_by_id(array( 'id' => $post['id'], 'tag_include' => true ));
	
	$param_post['max_id'] = $post['id'];
	$param_post['category_id'] = $post['category_id'];
	$param_post['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
	$param_post['limit'] = 10;
	$array_post = $this->Post_model->get_array($param_post);
	
	// param meta
	$param_meta['title'] = 'Suekarea - Share Download - '.$post['category_name'].' - '.$post['name'];
	$param_meta['desc'] = $post['desc_limit'];
	$param_meta['tag_meta'][] = array( 'property' => 'og:url', 'content' => $post['post_link'] );
	$param_meta['tag_meta'][] = array( 'property' => 'og:type', 'content' => $post['category_name'] );
	$param_meta['tag_meta'][] = array( 'property' => 'og:title', 'content' => $post['name'] );
	$param_meta['tag_meta'][] = array( 'property' => 'og:description', 'content' => get_length_char($post['desc_limit'], 200, ' ...') );
	if (!empty($post['thumbnail_link'])) {
		$param_meta['tag_meta'][] = array( 'property' => 'og:image', 'content' => $post['thumbnail_link'] );
	}
	if (!empty($post['link_canonical'])) {
		$param_meta['link_canonical'] = $post['link_canonical'];
	}
?>

<?php $this->load->view( 'website/common/meta', $param_meta ); ?>

<body class="blog boxed pattern-1 navigation-style-1">

<div id="page" class="site">
	<?php $this->load->view( 'website/common/header' ); ?>
	
    <div id="main" class="right_sidebar"><div class="inner"><div class="general_content clearboth">
		<div class="main_content hfeed"><div id="primary" class="content-area"><div id="content" class="site-content hentry" role="main">
			<h2 class="page-title entry-title">
				<a href="<?php echo $post['post_link']; ?>" title="<?php echo $post['name']; ?>" class="bookmark"><?php echo $post['name']; ?></a>
			</h2>
			
			<div id="post_content" class="post_content" role="main">
                <article>
					<?php if (!empty($post['thumbnail_link'])) { ?>
					<div class="pic post_thumb">
						<img width="1240" height="620" src="<?php echo $post['thumbnail_link']; ?>" alt="<?php echo $post['name']; ?>" title="<?php echo $post['name']; ?>" class="attachment-slider wp-post-image" />
					</div>
					<?php } ?>
					
					<div class="post_content" style="padding: 10px 0 15px 0;"><?php echo $post['desc']; ?></div>
					
					<div class="hide">
						<div class="published date updated" title="<?php echo $post['publish_date']; ?>">Update : <?php echo GetFormatDate($post['publish_date'], array( 'FormatDate' => 'd F Y' )); ?></div>
						<div class="vcard author">Publisher : <span class="fn"><?php echo $post['user_fullname']; ?></span></div>
					</div>
					
					<?php if ($post['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
					<div style="text-align: center; padding: 0 0 15px 0;">
						<a rel="nofollow" href="<?php echo $post['download']; ?>" class="link-download" target="_blank">Lihat Sumber</a>
					</div>
					<?php } else { ?>
					<div style="text-align: center; padding: 0 0 15px 0;"><input type="button" class="reload-download" value="Download" data-id="<?php echo $post['id']; ?>" /></div>
					<div class="cnt-download" style="text-align: center; padding: 0 0 15px 0;"></div>
					<?php } ?>
					
					<?php if (isset($post['array_tag']) && count($post['array_tag']) > 0) { ?>
					<ul id="post_tags">
						<?php foreach ($post['array_tag'] as $tag) { ?>
						<li><a href="<?php echo $tag['tag_link']; ?>"><?php echo $tag['tag_name']; ?></a></li>
						<?php } ?>
					</ul>
					<?php } ?>
					
					<div id="cnt-social">
						<div class="title">recommend to friends</div>
						<?php if ($this->config->item('online_widget')) { ?>
						<div class="soc-fb"><?php $this->load->view( 'website/common/fb_like', array( 'href' => $post['post_link'] ) ); ?></div>
						<div class="soc-plus"><?php $this->load->view( 'website/common/google_plus' ); ?></div>
						<div class="soc-twitter"><?php $this->load->view( 'website/common/twitter', array( 'href' => $post['post_link'] ) ); ?></div>
						<?php } ?>
						<div class="clear"></div>
					</div>
				</article>
				
				<div id="recent_posts">
					<h3 class="section_title" style="margin-bottom: 0px;">Recent Post</h3>
					<div class="posts_wrapper">
						<?php foreach ($array_post as $key => $item) { ?>
						<?php if (($key % 2) == 0) { ?>
						<article class="item_left" style="margin-top: 14px;">
							<?php if (!empty($item['thumbnail_small_link'])) { ?>
							<div class="pic">
								<a href="<?php echo $item['post_link']; ?>" class="w_hover img-link img-wrap">
									<img width="170" height="126" src="<?php echo $item['thumbnail_small_link']; ?>" class="attachment-category_news wp-post-image" />
									<span class="overlay"></span>
								</a>
							</div>
							<?php } ?>
							<h3 style="margin: 0px;"><a href="<?php echo $item['post_link']; ?>" title="<?php echo $item['name']; ?>"><?php echo get_length_char(strip_tags($item['name']), 60, ' ...'); ?></a></h3>
						</article>
						<?php } else { ?>
						<article class="item_right" style="margin-top: 14px;">
							<?php if (!empty($item['thumbnail_small_link'])) { ?>
							<div class="pic">
								<a href="<?php echo $item['post_link']; ?>" class="w_hover img-link img-wrap">
									<img width="170" height="126" src="<?php echo $item['thumbnail_small_link']; ?>" class="attachment-category_news wp-post-image" />
									<span class="overlay"></span>
								</a>
							</div>
							<?php } ?>
							<h3 style="margin: 0px;"><a href="<?php echo $item['post_link']; ?>" title="<?php echo $item['name']; ?>"><?php echo get_length_char(strip_tags($item['name']), 60, ' ...'); ?></a></h3>
						</article>
						<?php } ?>
						<?php } ?>
					</div>
				</div>
				
				<script type="text/javascript" src="<?php echo base_url('static/js/comment.js'); ?>"></script>
			</div>
		</div></div></div>
		
		<?php $this->load->view( 'website/common/sidebar' ); ?>
	</div></div></div>
	
	<?php $this->load->view( 'website/common/footer' ); ?>
</div>

<script>
	$(document).ready(function() {
		$('.reload-download').click(function() {
			$('.cnt-download').html('<img src="' + web.host + 'static/img/loading.gif" />');
			Func.ajax({ url: web.host + 'ajax/view', param: { 'action': 'view_download', id: $(this).data('id') }, is_json: 0, callback: function(view) {
				$('.cnt-download').html(view);
			} });
		});
	});
</script>

<?php $this->load->view( 'website/common/library_js' ); ?>

</body>
</html>