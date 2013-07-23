<?php
	$post = $this->Post_model->get_link();
	$post = $this->Post_model->get_by_id(array( 'id' => $post['id'] ));
	
	$param_post['max_id'] = $post['id'];
	$param_post['category_id'] = $post['category_id'];
	$param_post['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
	$array_post = $this->Post_model->get_array($param_post);
?>

<?php $this->load->view( 'website/common/meta', array( 'title' => 'Suekarea - Share Download - '.$post['name'], 'desc' => $post['desc_limit'] ) ); ?>

<body class="blog boxed pattern-1 navigation-style-1">

<div id="page" class="hfeed site">
	<?php $this->load->view( 'website/common/header' ); ?>
	
    <div id="main" class="right_sidebar"><div class="inner"><div class="general_content clearboth">
		<div class="main_content"><div id="primary" class="content-area"><div id="content" class="site-content" role="main">
			<h2 class="page-title"><?php echo $post['name']; ?></h2>
			
			<div id="post_content" class="post_content" role="main">
                <article class="news type-news status-publish format-video hentry format-video gallery-style-1">
					<div class="pic post_thumb">
						<img width="1240" height="620" src="<?php echo $post['thumbnail_link']; ?>" class="attachment-slider wp-post-image" alt="2">
					</div>
					<div class="post_content" style="padding: 10px 0 15px 0;"><?php echo $post['desc']; ?></div>
					<div style="text-align: center; padding: 0 0 15px 0;"><input type="button" class="reload-download" value="Download" data-id="<?php echo $post['id']; ?>" /></div>
					<div class="cnt-download" style="text-align: center; padding: 0 0 15px 0;"></div>
					
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
							<li><?php $this->load->view( 'website/common/google_plus' ); ?></li>
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
							<h3><a href="<?php echo $item['post_link']; ?>" title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></a></h3>
						</article>
						<?php } else { ?>
						<article class="item_right" style="margin-top: 14px;">
							<div class="pic">
								<a href="<?php echo $item['post_link']; ?>" class="w_hover img-link img-wrap">
									<img width="170" height="126" src="<?php echo $item['thumbnail_small_link']; ?>" class="attachment-category_news wp-post-image" />
									<span class="overlay"></span>
								</a>
							</div>
							<h3><a href="<?php echo $item['post_link']; ?>" title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></a></h3>
						</article>
						<?php } ?>
						<?php } ?>
					</div>
				</div>
				
				<?php
				/*
				<div id="comments" class="post_comments">
					<h3 class="comments_title">Comments</h3>
					<ol class="comment-list">
						<li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1">
							<div class="photo"><img src="<?php echo base_url('static/upload/b5a37fc.jpg'); ?>" height="106" width="106"></div>
							<div class="extra_wrap">
								<h5><a>admin</a></h5>
								<div class="comment_info">
									<div class="comment_date">June 2, 2013 at 6:38 am</div>
								</div>
								<div class="comment_content"><p>Test comment</p></div>
							</div>
						</li>
					</ol>
					<div id="respond">
						<h3 id="reply-title">Leave comment <small><a rel="nofollow" id="cancel-comment-reply-link" href="http://localhost/?news=dolorem-ipsum-quia-dolor-sit-amet#respond" style="display:none;">Cancel reply</a></small></h3>
						<form action="http://wpspace.net/wp-comments-post.php" method="post" id="commentform">
							<p class="comment-form-author"><input id="author" name="author" type="text" value="" size="30" aria-required="true"><label for="author" class="required">Name</label></p>
							<p class="comment-form-email"><input id="email" name="email" type="text" value="" size="30" aria-required="true"><label for="email" class="required">Email</label></p>
							<p class="comment-form-url"><input id="url" name="url" type="text" value="" size="30"><label for="url">Website</label></p>
							<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>
							<p class="form-submit">
								<input name="submit" type="submit" id="submit" value="Post comment">
								<input type="hidden" name="comment_post_ID" value="537" id="comment_post_ID">
								<input type="hidden" name="comment_parent" id="comment_parent" value="0">
							</p>
						</form>
					</div>
					<div class="nav_comments"></div>
				</div>
				/*	*/
				?>
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