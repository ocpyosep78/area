<?php
	preg_match('/\/([\w\-]+)$/i', $_SERVER['REQUEST_URI'], $match);
	$alias = (!empty($match[1])) ? $match[1] : '';
	
	$page_static = $this->Page_Static_model->get_by_id(array( 'alias' => $alias ));
	
	// popular post
	$param_popular['is_popular'] = 1;
	$param_popular['limit'] = 9;
	$param_popular['not_draft'] = true;
	$param_popular['publish_date'] = $this->config->item('current_datetime');
	$param_popular['sort'] = '[{"property":"publish_date","direction":"DESC"}]';
	$array_popular = $this->Post_model->get_array($param_popular);
	
	// meta
	$title = 'Suekarea - '.$page_static['name'];
	$desc = 'Suekarea - '.get_length_char(strip_tags($page_static['desc']), 125, ' ...');
?>

<?php $this->load->view( 'website/common/meta', array( 'title' => $title, 'desc' => $desc ) ); ?>

<body class="blog boxed pattern-1 navigation-style-1">

<div id="page" class="hfeed site">
	<?php $this->load->view( 'website/common/header' ); ?>
	
    <div id="main" class="without_sidebar"><div class="inner"><div class="general_content clearboth">
		<div class="main_content">
			<h2 class="page-title"><?php echo $page_static['name']; ?></h2>
			<div id="post_content" class="post_content" role="main">
                <article>
					<div class="post_content" style="padding: 0 0 25px 0;"><?php echo $page_static['desc']; ?></div>
					<div id="cnt-social">
						<div class="title">recommend to friends</div>
						<?php if ($this->config->item('online_widget')) { ?>
						<div class="soc-fb"><?php $this->load->view( 'website/common/fb_like', array( 'href' => $page_static['page_link'] ) ); ?></div>
						<div class="soc-plus"><?php $this->load->view( 'website/common/google_plus' ); ?></div>
						<div class="soc-twitter"><?php $this->load->view( 'website/common/twitter', array( 'href' => $page_static['page_link'] ) ); ?></div>
						<?php } ?>
						<div class="clear"></div>
					</div>
					
					<?php	/*
					<ul id="post_tags">
						<li><a href="http://wpspace.net/?tag=business">Business</a></li>
						<li><a href="http://wpspace.net/?tag=finance">Finance</a></li>
						<li><a href="http://wpspace.net/?tag=partners">Partners</a></li>
					</ul>
					*/	?>
				</article>
				
				<div id="recent_posts">
					<h3 class="section_title">Popular Post</h3>
					<div class="posts_wrapper">
						<?php foreach ($array_popular as $post) { ?>
						<article class="item_left" style="padding: 0 0 15px 0;">
							<div class="pic">
								<a href="<?php echo $post['post_link']; ?>" class="w_hover img-link img-wrap" title="<?php echo $post['name']; ?>" alt="<?php echo $post['name']; ?>">
									<img width="170" height="126" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-category_news wp-post-image" title="<?php echo $post['name']; ?>" alt="<?php echo $post['name']; ?>" />
									<span class="overlay"></span>
								</a>
							</div>
							<h3><a href="<?php echo $post['post_link']; ?>" title="<?php echo $post['name']; ?>" alt="<?php echo $post['name']; ?>"><?php echo get_length_char($post['name'], 25, ' ...'); ?></a></h3>
							<div class="post-desc">by <a href="<?php echo $post['post_link']; ?>"><?php echo $post['user_fullname']; ?></a></div>
						</article>
						<?php } ?>
					</div>
				</div>
				
				<script type="text/javascript" src="<?php echo base_url('static/js/comment.js'); ?>"></script>
			</div>
		</div>
	</div></div></div>
	
	<?php $this->load->view( 'website/common/footer' ); ?>
</div>

<?php $this->load->view( 'website/common/library_js' ); ?>

</body>
</html>