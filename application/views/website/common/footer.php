<?php
	$last_month = date("Y-m", strtotime("-1 Month"));
	list($year, $month) = explode('-', $last_month);
	$param_popular['month'] = $month;
	$param_popular['year'] = $year;
	$param_popular['sort'] = '[{"property":"view_count","direction":"DESC"}]';
	$param_popular['limit'] = 4;
	$array_popular = $this->Post_model->get_array($param_popular);
?>

<footer id="footer" class="site-footer" role="contentinfo">
<section class="ft_section_1"><div class="footer-wrapper">
<div class="col1">
	<div id="footer_logo">
		<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('static/img/footer-logo.png'); ?>" alt="Suekarea" title="Suekarea"></a>
	</div>
	<div class="footer_text" style="text-align: justify;">Suekarea.com didirikan pada tahun 2013, di sini kami berbagi film, anime, kartun, dll secara gratis. Jadi anda bisa mendowloadnya secara gratis.<br />Seiring berjalannya waktu, Suekarea.com akan mengalami perubahan. Kami berharap anda menikmati apa yang kami berikan</div>
	<div class="block_social_footer">
	<ul>
		<li><a rel="nofollow" href="https://www.facebook.com/suekarea" class="fb" title="Suekarea FB">Facebook</a></li>
		<li><a rel="nofollow" href="https://plus.google.com/u/0/114002599803233293136?rel=author" class="gplus" title="Suekarea Google Plus">Google+</a></li>
		<li><a rel="nofollow" href="https://twitter.com/Suekarea" class="tw" title="Suekarea Twitter">Twitter</a></li>
		<li><a rel="nofollow" href="<?php echo base_url('rss'); ?>" class="rss" title="Popular RSS">RSS</a></li>
		<li><a rel="nofollow" href="<?php echo base_url('rss/latest'); ?>" class="rss" title="Latest RSS">RSS</a></li>
		<li><a rel="nofollow" href="<?php echo base_url('referer'); ?>" class="referer" title="Referer">Referer</a></li>
	</ul>
	</div>
</div>
<div class="col2">
	 <div class="block_footer_widgets">
		<div class="column"><h3>&nbsp;</h3></div>
		<div class="column">
			<div class="widget_popular_footer">
				<div class="widget_header"><h3>Most Popular</h3></div>
				<div class="widget_body">
<?php foreach ($array_popular as $post) { ?>
<div class="article">
	<?php if (!empty($post['thumbnail_small_link'])) { ?>
	<div class="pic">
		<a href="<?php echo $post['post_link']; ?>" class="w_hover" title="<?php echo $post['name']; ?>">
			<img width="112" height="80" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-widget_popular_footer wp-post-image" alt="<?php echo $post['name']; ?>" />
			<span class="overlay"></span>
		</a>
	</div>
	<?php } ?>
	<div class="text">
		<p class="title"><a href="<?php echo $post['post_link']; ?>" title="<?php echo $post['name']; ?>"><?php echo $post['name']; ?></a></p>
		<?php
		/*
		<div class="icons">
			<ul>
				<li><a href="http://wpspace.net/?reviews=sample" class="views">915</a></li>
				<li><a href="http://wpspace.net/?reviews=sample" class="comments">4</a></li>
			</ul>
		</div>
		/*	*/
		?>
	</div>
</div>
<?php } ?>
				</div>
			</div>
		</div>
		<div class="column last"><h3>&nbsp;</h3></div>
	</div>
</div>
</div></section>

<section class="ft_section_2">
<div class="footer-wrapper">
	<ul id="footer_menu">
		<li><a href="<?php echo base_url(); ?>">Home</a></li>
		<li><a href="<?php echo base_url('about-us'); ?>">About us</a></li>
		<li><a href="<?php echo base_url('contact'); ?>">Contact us</a></li>
		<li><a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a></li>
		<li><a href="<?php echo base_url('advertising'); ?>">Advertising</a></li>
		<li><a href="<?php echo base_url('widget'); ?>">Widget</a></li>
	</ul>
	<div class="copyright"><div class="footer_text">© 2013. All Rights Reserved. Created by suekarea</div></div>
</div>
</section>
</footer>

<!-- popup -->
<div id="overlay"></div>
<a href="#" id="toTop"><span></span></a>
<div id="login" class="login-popup"></div>
<div id="registration" class="registration-popup"></div>
<!-- end popup -->