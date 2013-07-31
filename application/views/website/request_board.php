<?php
	// page
	$page_item = 10;
	$page_active = get_page();
	$page_base  = base_url('request/board');
	
	// request
	$param_request['start'] = ($page_active - 1) * $page_item;
	$param_request['limit'] = $page_item;
	$array_request = $this->Request_model->get_array($param_request);
	$page_count = ceil($this->Request_model->get_count() / $page_item);
?>

<?php $this->load->view( 'website/common/meta' ); ?>

<body class="blog boxed pattern-1 navigation-style-1">

<div id="page" class="hfeed site">
	<?php $this->load->view( 'website/common/header' ); ?>
	
    <div id="main" class="right_sidebar"><div class="inner"><div class="general_content clearboth">
		<div class="main_content"><div id="primary" class="content-area"><div id="content" class="site-content" role="main">
			<h2 class="page-title">Request Board</h2>
			
			<section id="reviews_body">
				<?php if (count($array_request) == 0) { ?>
				<div>No request found.</div>
				<?php } else { ?>
				<?php foreach ($array_request as $post) { ?>
				<article class="post-562 reviews type-reviews status-publish format-standard hentry">
					<h3 style="margin-bottom: 5px;"><a href="<?php echo $post['request_link']; ?>"><?php echo $post['name']; ?></a></h3>
					<div class="text">Status : <?php echo $post['status']; ?></div>
					<div class="text"><?php echo GetFormatDate($post['request_time'], array( 'FormatDate' => 'd F Y' )).' - '.$post['desc']; ?></div>
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
						</ul>
					</div>
					<div class="page_x_of_y">Page <span><?php echo $page_active; ?></span> of <span><?php echo $page_count; ?></span></div>
				</div>
				<?php } ?>
			</section>
		</div></div></div>
		<?php $this->load->view( 'website/common/sidebar' ); ?>
	</div></div></div>
	
	<?php $this->load->view( 'website/common/footer' ); ?>
</div>

<?php $this->load->view( 'website/common/library_js' ); ?>

</body>
</html>