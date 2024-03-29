<?php
	// recent post
	$param_recent['limit'] = 18;
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
	
	// adsense
	$adsense_code_1 = $this->Adsense_Html_model->get_code(array( 'adsense_type_alias' => ADSENSE_300_x_250 ));
	$adsense_code_2 = $this->Adsense_Html_model->get_code(array( 'adsense_type_alias' => ADSENSE_300_x_250 ));
?>

<div id="secondary" class="widget-area main_sidebar right_sidebar" role="complementary">
<?php if ($this->config->item('online_widget')) { ?>
<aside id="recent-video-widget-2" class="widget widget_recent_video">
	<div class="widget_header"><h3 class="widget_title">Social Media</h3></div>
	<div class="widget_body" style="padding: 5px;">
		<div class="fb-like-box" data-href="https://www.facebook.com/suekarea" data-width="292" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
		
		<div style="width: 130px; margin: 0px auto;">
			<a href="https://twitter.com/suekarea" class="twitter-follow-button" data-width="130px" data-align="left" data-show-count="false">Follow @Suekarea</a>
		</div>
	</div>
</aside>
<?php } ?>

<?php
/*
<aside class="widget" style="background-color: #eb1c15;">
	<div class="widget_header">
		<h3 class="widget_title">Light Chat Box</h3>
	</div>
	<div class="widget_body" style="padding: 0px;">
		<script type="text/javascript">var shout_master_id = 1;</script>
		<script type="text/javascript" src="<?php echo base_url('static/js/plugin/shout.js'); ?>"></script>
	</div>
</aside>
/*	*/
?>

<?php if ($this->config->item('online_widget') || true) { ?>
<aside><?php echo $adsense_code_1; ?></aside>
<?php } ?>

<aside id="news-combine-widget-2" class="widget widget_news_combine">
	<div class="widget_header"><h3 class="widget_title">Main News</h3></div>
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
	<div class="block_home_news_post"><p class="title"><a href="<?php echo $array_recent[$i]['post_link']; ?>" title="<?php echo $array_recent[$i]['name']; ?>"><?php echo $array_recent[$i]['name']; ?></a></p></div>
	<?php } ?>
</div>

<div class="tab_content">
	<?php for ($i = 0; $i < 8; $i++) { ?>
	<div class="block_home_news_post"><p class="title"><a href="<?php echo $array_popular[$i]['post_link']; ?>" title="<?php echo $array_popular[$i]['name']; ?>"><?php echo $array_popular[$i]['name']; ?></a></p></div>
	<?php } ?>
</div>
		</div>
	</div>
</aside>

<?php if ($this->config->item('online_widget')) { ?>
<aside><?php echo $adsense_code_2; ?></aside>
<?php } ?>

<aside id="recent-blogposts-widget-2" class="widget widget_recent_blogposts">
	<div class="widget_header">
		<!--	<div class="widget_subtitle"><a href="#" class="lnk_all_posts">all recent posts</a></div>	-->
		<h3 class="widget_title">Recent posts</h3>
	</div>
	<div class="widget_body">
<ul class="slides">
<li>
<?php for ($i = 8; $i < 13; $i++) { ?>
<div class="article">
	<?php if (!empty($array_recent[$i]['thumbnail_small_link'])) { ?>
	<div class="pic">
		<a href="<?php echo $array_recent[$i]['post_link']; ?>" class="w_hover img-link img-wrap" title="<?php echo $array_recent[$i]['name']; ?>">
			<img width="388" height="246" src="<?php echo $array_recent[$i]['thumbnail_small_link']; ?>" alt="<?php echo $array_recent[$i]['name']; ?>" />
			<span class="overlay"></span>
		</a>
	</div>
	<?php } ?>
	<div class="text">
		<p class="title"><a href="<?php echo $array_recent[$i]['post_link']; ?>" title="<?php echo $array_recent[$i]['name']; ?>"><?php echo $array_recent[$i]['name']; ?></a></p>
		<div class="desc">by <a href="<?php echo $array_recent[$i]['post_link']; ?>"><?php echo $array_recent[$i]['user_fullname']; ?></a></div>
	</div>
</div>
<?php } ?>
</li>
<li>
<?php for ($i = 13; $i < 18; $i++) { ?>
<div class="article">
	<?php if (!empty($array_recent[$i]['thumbnail_small_link'])) { ?>
	<div class="pic">
		<a href="<?php echo $array_recent[$i]['post_link']; ?>" title="<?php echo $array_recent[$i]['name']; ?>" class="w_hover img-link img-wrap">
			<img width="388" height="246" src="<?php echo $array_recent[$i]['thumbnail_small_link']; ?>" alt="<?php echo $array_recent[$i]['name']; ?>" />
			<span class="overlay"></span>
		</a>
	</div>
	<?php } ?>
	<div class="text">
		<p class="title"><a href="<?php echo $array_recent[$i]['post_link']; ?>" title="<?php echo $array_recent[$i]['name']; ?>"><?php echo $array_recent[$i]['name']; ?></a></p>
		<div class="desc">by <a href="<?php echo $array_recent[$i]['post_link']; ?>"><?php echo $array_recent[$i]['user_fullname']; ?></a></div>
	</div>
</div>
<?php } ?>
</li>
</ul>
<div class="pages_info">
	<span class="cur_page">1</span> of <span class="all_pages">2</span>
</div>
	</div>
</aside>

</div>