<?php
	// recent post
	$param_recent['limit'] = 12;
	$param_recent['not_draft'] = true;
	$param_recent['publish_date'] = $this->config->item('current_datetime');
	$param_recent['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
	$array_recent = $this->Post_model->get_array($param_recent);
	
	// popular post
	$param_popular['is_popular'] = 1;
	$param_popular['limit'] = 8;
	$param_popular['not_draft'] = true;
	$param_popular['publish_date'] = $this->config->item('current_datetime');
	$param_popular['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
	$array_popular = $this->Post_model->get_array($param_popular);
?>

<div id="secondary" class="widget-area main_sidebar right_sidebar" role="complementary">
<?php if ($this->config->item('online_widget')) { ?>
<aside>
	<script type="text/javascript">google_ad_client = "ca-pub-0445723121454332"; google_ad_slot = "9098313148"; google_ad_width = 300; google_ad_height = 250;</script>
	<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</aside>
<?php } ?>

<aside id="news-combine-widget-2" class="widget widget_news_combine">
	<div class="widget_header">
		<h3 class="widget_title">Main News</h3>
	</div>
	<div class="widget_body">
		<div class="block_news_tabs">
			<div class="tabs">
				<ul>
					<li><a href="#1" class="current"><span>Latest</span></a></li>
					<li><a href="#2"><span>Popular</span></a></li>
				</ul>
			</div>
		 
			<div class="tab_content" id="1">
				<?php for ($i = 0; $i < 8; $i++) { ?>
				<div class="block_home_news_post">
					<p class="title"><a href="<?php echo $array_recent[$i]['post_link']; ?>" title="<?php echo $array_recent[$i]['name']; ?>"><?php echo $array_recent[$i]['name']; ?></a></p>
				</div>
				<?php } ?>
			</div>
			
			<div class="tab_content">
				<?php for ($i = 0; $i < 8; $i++) { ?>
				<div class="block_home_news_post">
					<p class="title"><a href="<?php echo $array_popular[$i]['post_link']; ?>" title="<?php echo $array_recent[$i]['name']; ?>"><?php echo $array_popular[$i]['name']; ?></a></p>
				</div>
				<?php } ?>
			</div>
			
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('.block_news_tabs').tabs('div.tab_content', { tabs: 'div.tabs a', initialIndex: 0 });
				});
			</script>
		</div>
	</div>
</aside>

<?php if ($this->config->item('online_widget')) { ?>
<aside>
	<script type="text/javascript">google_ad_client = "ca-pub-0445723121454332"; google_ad_slot = "1575046342"; google_ad_width = 300; google_ad_height = 250;</script>
	<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</aside>
<?php } ?>

<aside id="recent-blogposts-widget-2" class="widget widget_recent_blogposts">
	<div class="widget_header">
		<!--	<div class="widget_subtitle"><a href="#" class="lnk_all_posts">all recent posts</a></div>	-->
		<h3 class="widget_title">Recent posts</h3>
	</div>
	<div class="widget_body">
		<ul class="slides">
			<li>
				<?php for ($i = 8; $i < 10; $i++) { ?>
				<div class="article">
					<div class="pic">
						<a href="<?php echo $array_recent[$i]['post_link']; ?>" class="w_hover img-link img-wrap">
							<img width="388" height="246" src="<?php echo $array_recent[$i]['thumbnail_small_link']; ?>" title="<?php echo $array_recent[$i]['name']; ?>" class="attachment-recent_news_homepage wp-post-image" alt="1" />
							<span class="overlay"></span>
						</a>
					</div>
					<div class="text">
						<p class="title"><a href="<?php echo $array_recent[$i]['post_link']; ?>" title="<?php echo $array_recent[$i]['name']; ?>"><?php echo $array_recent[$i]['name']; ?></a></p>
						<?php if ($array_recent[$i]['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
						<div class="desc">by <a href="<?php echo $array_recent[$i]['download']; ?>"><?php echo $array_recent[$i]['user_fullname']; ?></a></div>
						<?php } else { ?>
						<div class="desc">by <a href="<?php echo $array_recent[$i]['post_link']; ?>"><?php echo $array_recent[$i]['user_fullname']; ?></a></div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
			</li>
			<li>
				<?php for ($i = 10; $i < 12; $i++) { ?>
				<div class="article">
					<div class="pic">
						<a href="<?php echo $array_recent[$i]['post_link']; ?>" title="<?php echo $array_recent[$i]['name']; ?>" class="w_hover img-link img-wrap">
							<img width="388" height="246" src="<?php echo $array_recent[$i]['thumbnail_small_link']; ?>" class="attachment-recent_news_homepage wp-post-image" alt="1" />
							<span class="overlay"></span>
						</a>
					</div>
					<div class="text">
						<p class="title"><a href="<?php echo $array_recent[$i]['post_link']; ?>" title="<?php echo $array_recent[$i]['name']; ?>"><?php echo $array_recent[$i]['name']; ?></a></p>
						<?php if ($array_recent[$i]['post_type_id'] == POST_TYPE_SINGLE_LINK) { ?>
						<div class="desc">by <a href="<?php echo $array_recent[$i]['download']; ?>"><?php echo $array_recent[$i]['user_fullname']; ?></a></div>
						<?php } else { ?>
						<div class="desc">by <a href="<?php echo $array_recent[$i]['post_link']; ?>"><?php echo $array_recent[$i]['user_fullname']; ?></a></div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
			</li>
		</ul>
		<div class="pages_info">
			<span class="cur_page">1</span> of <span class="all_pages">2</span>
		</div>
	</div>
	<script type="text/javascript">
		var curSlide = 1;
		jQuery(document).ready(function() {
			jQuery(".widget_recent_blogposts .widget_body").flexslider({
			  animation: "fade",
			  slideshow: false,
			  controlNav: false,
			  directionNav: true,
			  prevText:"",
			  nextText:"",
			  smoothHeight: true,
			  controlsContainer: ".flex-container",
			  after: function(slider) {
				jQuery(".widget_recent_blogposts .cur_page").eq(0).html(slider.currentSlide + 1);
			  }
			});
		});			
	</script>
</aside>

<?php if ($this->config->item('online_widget')) { ?>
<aside>
	<script type="text/javascript">google_ad_client = "ca-pub-0445723121454332"; google_ad_slot = "6005245942"; google_ad_width = 300; google_ad_height = 250;</script>
	<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</aside>
<?php } ?>

</div>