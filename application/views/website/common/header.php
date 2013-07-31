<?php
	$array_color = array( 'red', 'blue', 'sky-blue', 'purple', 'green', 'orange', 'gray', 'yellow' );
	$array_category = $this->Category_model->get_array();
	$is_login = $this->User_model->is_login();
	
	// generate menu
	$array_menu = array();
	foreach ($array_category as $key => $menu) {
		$color = array_shift($array_color);
		$array_menu[] = array( 'title' => $menu['name'], 'color' => $color, 'link' => $menu['link'] );
	}
	
	// add menu
	$array_menu[] = array( 'title' => 'Submit', 'color' => array_shift($array_color), 'link' => base_url('submit') );
	$array_menu[] = array( 'title' => 'Request Board', 'color' => array_shift($array_color), 'link' => base_url('request/board') );
	$array_menu[] = array( 'title' => 'About Us', 'color' => array_shift($array_color), 'link' => base_url('about-us') );
	$array_menu[] = array( 'title' => 'Contact Us', 'color' => array_shift($array_color), 'link' => base_url('contact') );
?>

<header id="header" class="site-header" role="banner"><div id="site-header">
	<section class="top">
		<div class="inner clearboth">
			<div class="top-right">
				<ul id="user-links">
					<li><a href="<?php echo base_url('submit'); ?>">Submit</a></li>
					<li><a href="<?php echo base_url('request'); ?>">Request</a></li>
					<?php if ($is_login) { ?>
					<li><a href="<?php echo base_url('logout'); ?>">Logout</a></li>
					<?php } else { ?>
					<li><a class="cursor login-popup-link">Login</a></li>
					<li><a class="cursor registration-popup-link">Registration</a></li>
					<?php } ?>
				</ul>
			</div>
			<div class="top-left"><?php echo date("d F Y"); ?></div>  
			<div class="top-center">
				<div class="block_top_menu">
					<ul id="top-left-menu">
						<li><a href="<?php echo base_url(); ?>" alt="Suekarea" title="Suekarea">Home</a></li>
						<li><a href="<?php echo base_url('about-us'); ?>">About us</a></li>
						<?php
						/*
						<li>
							<a href="http://wpspace.net/?page_id=10">Dropdown</a>
							<ul class="sub-menu">
								<li><a href="#">Drop Style 1</a></li>
								<li><a href="#">Drop Style 2</a></li>
								<li><a href="#">Drop Style 3</a></li>
							</ul>
						</li>
						<li><a href="http://wpspace.net/?page_id=303">Typography</a></li>
						/*	*/
						?>
						<li><a href="<?php echo base_url('contact'); ?>">Contact us</a></li>
					</ul>
				</div>
			</div>
			<div class="clearboth"></div>
		</div>
	</section>
	
	<section class="section2">
		<div class="inner">
			<div class="section-wrap clearboth">
				<div class="block_social_top">
					<div class="icons-label">Follow us:</div>
					<ul>
						<!--
						<li><a href="#" class="tw">Twitter</a></li>
						-->
						<li><a href="https://www.facebook.com/suekarea" class="fb" title="Suekarea FB">Facebook</a></li>
						<li><a href="https://plus.google.com/u/0/114002599803233293136?rel=author" class="gplus">Google+</a></li>
						<li><a href="<?php echo base_url('rss'); ?>" class="rss" title="Popular Post">RSS</a></li>
						<li><a href="<?php echo base_url('rss/latest'); ?>" class="rss" title="Latest Post">RSS</a></li>
					</ul>
				</div>
				
				<div class="form_search">
					<form method="post" id="searchform" class="searchform" action="<?php echo base_url('search'); ?>" role="search">
						<label for="keyword" class="screen-reader-text">Search</label>
						<input type="search" class="field" name="keyword" value="" id="keyword" placeholder="Search &hellip;" />
						<input type="submit" class="submit" value="Search" />
					</form>
				</div>
				
				<div class="newsletter">
					<div class="newsletter-title">Subscribe to our newsletter</div>
					<div class="newsletter-popup">
						<span class="bg"><span></span></span>
						<div class="indents">
							<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="_blank">
								<div class="field">
									<input type="text" placeholder="Enter Your E-mail addres" name="email" title="Enter Your Email Address" class="w_def_text" />
								</div>
								<input type="hidden" name="loc" value="en_US"/>
								<input type="hidden" name="uri" value="suekarea-popular" />
								<input type="submit" class="button" value="Subscribe">
								<div class="clearboth"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="section3">
		<div class="section-wrap clearboth">
			<div class="banner-block">
				<div class="banner">
					<?php if ($this->config->item('online_widget')) { ?>
					<script type="text/javascript">google_ad_client = "ca-pub-0445723121454332"; google_ad_slot = "8797261949"; google_ad_width = 468; google_ad_height = 60;</script>
					<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"> </script>
					<?php } else { ?>
					<a href="#"><img src="<?php echo base_url('static/upload/banner.jpg'); ?>" alt="banner" /></a>
					<?php } ?>
				</div>
			</div>
			<div class="name-and-slogan">
				<h1 class="site-title">
					<a href="<?php echo base_url(); ?>" title="Suekarea" rel="home">
						<img src="<?php echo base_url('static/img/logo.png'); ?>" alt="logo" />
					</a>
				</h1>
				<h2 class="site-description">Share Movie &amp; Anime Download</h2>
			</div>
		</div>
	</section>
	
	<section class="section-nav">
		<nav id="site-navigation" class="navigation-main" role="navigation">
			<ul id="site-main-menu" class="clearboth">
				<li class="home"><a href="<?php echo base_url(); ?>"></a></li>
				<?php foreach ($array_menu as $key => $menu) { ?>
				<li class="<?php echo $menu['color']; ?>"><a href="<?php echo $menu['link']; ?>"><?php echo $menu['title']; ?></a></li>
				<?php } ?>
				
				<?php
				/*
				<li id="menu-item-27" class="red">
					<a href="http://wpspace.net/">Home</a>
					<ul class="sub-menu">
						<li id="menu-item-35" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-35"><a href="http://wpspace.net/?news=totam-rem-aperiam-eaque-ipsa-quae-ab-illo-inventore-3&amp;gallery_style=1">Post Format With Slider</a></li>
						<li id="menu-item-36" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-36"><a href="http://wpspace.net/?news=totam-rem-aperiam-eaque-ipsa-quae-ab-illo-inventore-3">Post Format With Gallery</a></li>
						<li id="menu-item-37" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-37"><a href="http://wpspace.net/?p=242">Post Format YouTube Video</a></li>
						<li id="menu-item-566" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-566"><a href="http://wpspace.net/?reviews=some-test">Post Vimeo Video</a></li>
						<li id="menu-item-567" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-567"><a href="http://wpspace.net/?p=42">Standard Post</a></li>
					</ul>
				</li>
				/*	*/
				?>
			</ul>
		</nav>
	</section>
</div></header>
<script>
$(document).ready(function() {
	$('#searchform').submit(function() {
		var action = $('#searchform').attr('action');
		var keyword = Func.GetName($('#keyword').val());
		if (keyword.length == 0) {
			return false;
		}
		
		$('#searchform').attr('action', action += '/' + keyword);
	});
});
</script>