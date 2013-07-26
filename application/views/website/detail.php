<?php
	$post = $this->Post_model->get_link();
	if (count($post) == 0) {
		show_404();
		exit;
	}
	
	// post detail
	$post = $this->Post_model->get_by_id(array( 'id' => $post['id'] ));
	
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
	$param_meta['tag_meta'][] = array( 'property' => 'og:image', 'content' => $post['thumbnail_link'] );
?>

<?php $this->load->view( 'website/common/meta', $param_meta ); ?>

<body class="blog boxed pattern-1 navigation-style-1">

<style>
.link-download {
	text-decoration: none; background: linear-gradient(#FFFFFF 0%, #F5F5F5 100%) repeat scroll 0 0 transparent; border: 1px solid #CDD0D1;
    border-radius: 2px 2px 2px 2px; box-shadow: 1px 1px rgba(0, 0, 0, 0.05); color: #6D6D6D !important; font-size: 12px;
    font-weight: bold; height: 27px; line-height: 26px; padding: 5px 12px;
}
</style>

<div id="page" class="hfeed site">
	<?php $this->load->view( 'website/common/header' ); ?>
	
    <div id="main" class="right_sidebar"><div class="inner"><div class="general_content clearboth">
		<div class="main_content"><div id="primary" class="content-area"><div id="content" class="site-content" role="main">
			<h2 class="page-title"><a href="<?php echo $post['post_link']; ?>" alt="<?php echo $post['name']; ?>" title="<?php echo $post['name']; ?>"><?php echo $post['name']; ?></a></h2>
			
			<div id="post_content" class="post_content" role="main">
                <article class="news type-news status-publish format-video hentry format-video gallery-style-1">
					<div class="pic post_thumb">
						<img width="1240" height="620" src="<?php echo $post['thumbnail_link']; ?>" alt="<?php echo $post['name']; ?>" title="<?php echo $post['name']; ?>" class="attachment-slider wp-post-image" />
					</div>
					<div class="post_content" style="padding: 10px 0 15px 0;"><?php echo $post['desc']; ?></div>
					
					<?php if ($post['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
					<div style="text-align: center; padding: 0 0 15px 0;">
						<a href="<?php echo $post['link_source']; ?>" class="link-download" target="_blank">Download</a>
					</div>
					<?php } else { ?>
					<div style="text-align: center; padding: 0 0 15px 0;"><input type="button" class="reload-download" value="Download" data-id="<?php echo $post['id']; ?>" /></div>
					<div class="cnt-download" style="text-align: center; padding: 0 0 15px 0;"></div>
					<?php } ?>
					
					<div class="block-social">
						<div class="soc_label">recommend to friends</div>
						<ul id="post_social_share" class="post_social_share">
							<li>
								<a href="http://www.facebook.com/share.php?u=<?php echo $post['post_link']; ?>" class="facebook_link">
									<img src="<?php echo base_url('static/img/facebook-icon-big.png'); ?>" class="facebook_icon" alt="facebook">
								</a>
							</li>
							<li>
								<a href="https://twitter.com/share?text=<?php echo urlencode($post['name']); ?>" class="twitter_link">
									<img src="<?php echo base_url('static/img/twitter-icon-big.png'); ?>" class="twitter_icon" alt="twitter">
								</a>
							</li>
							<?php if ($this->config->item('online_widget')) { ?>
							<li><?php $this->load->view( 'website/common/google_plus' ); ?></li>
							<?php } ?>
						</ul>
					</div>
				</article>
				
				<div id="recent_posts">
					<h3 class="section_title" style="margin-bottom: 0px;">Recent Post</h3>
					<div class="posts_wrapper">
						<?php foreach ($array_post as $key => $item) { ?>
						<?php if (($key % 2) == 0) { ?>
						<article class="item_left" style="margin-top: 14px;">
							<div class="pic">
								<a href="<?php echo $item['post_link']; ?>" class="w_hover img-link img-wrap">
									<img width="170" height="126" src="<?php echo $item['thumbnail_small_link']; ?>" class="attachment-category_news wp-post-image" />
									<span class="overlay"></span>
								</a>
							</div>
							<h3 style="margin: 0px;"><a href="<?php echo $item['post_link']; ?>" title="<?php echo $item['name']; ?>"><?php echo get_length_char(strip_tags($item['name']), 60, ' ...'); ?></a></h3>
						</article>
						<?php } else { ?>
						<article class="item_right" style="margin-top: 14px;">
							<div class="pic">
								<a href="<?php echo $item['post_link']; ?>" class="w_hover img-link img-wrap">
									<img width="170" height="126" src="<?php echo $item['thumbnail_small_link']; ?>" class="attachment-category_news wp-post-image" />
									<span class="overlay"></span>
								</a>
							</div>
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