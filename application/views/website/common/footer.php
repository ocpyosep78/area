<?php
//	$last_month = date("Y-m", strtotime("-1 Month"));
//	list($year, $month) = explode('-', $last_month);
//	$param_popular['month'] = $month;
//	$param_popular['year'] = $year;
	$param_popular['sort'] = '[{"property":"view_count","direction":"DESC"}]';
	$param_popular['limit'] = 4;
	$array_popular = $this->Post_model->get_array($param_popular);
?>

<footer id="footer" class="site-footer" role="contentinfo">
<section class="ft_section_1">
	<div class="footer-wrapper">
		<div class="col1">
			<div id="footer_logo">
				<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('static/img/footer-logo.png'); ?>" alt="Suekarea" title="Suekarea"></a>
			</div>
			<div class="footer_text">Share Movie Download and Share Anime Download<br />No adfly</div>
			<?php
			/*
			<div class="block_social_footer">
				<ul>
					<li><a href="#" class="tw">Twitter</a></li>
					<li><a href="#" class="fb">Facebook</a></li>
					<li><a href="#" class="rss">RSS</a></li>
					<li><a href="#" class="gplus">Google+</a></li>
				</ul>
			</div>
			/*	*/
			?>
		</div>
		<div class="col2">
			 <div class="block_footer_widgets">
				<div class="column">
					<h3>&nbsp;</h3>
				</div>
				<div class="column">
					<div class="widget_popular_footer">
						<div class="widget_header">
							<h3>Most Popular</h3>
						</div>
						<div class="widget_body">
							<?php foreach ($array_popular as $post) { ?>
							<div class="article">
								<div class="pic">
									<a href="<?php echo $post['post_link']; ?>" class="w_hover">
										<img width="112" height="80" src="<?php echo $post['thumbnail_small_link']; ?>" class="attachment-widget_popular_footer wp-post-image" alt="21" />
										<span class="overlay"></span>
									</a>
								</div>
								<div class="text">
									<p class="title"><a href="<?php echo $post['post_link']; ?>"><?php echo $post['name']; ?></a></p>
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
				<div class="column last">
					<h3>&nbsp;</h3>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="ft_section_2">
	<div class="footer-wrapper">
		<ul id="footer_menu">
			<li id="" class=""><a href="<?php echo base_url(); ?>">Home</a></li>
			<?php
			/*
			<li id="" class=""><a href="#">Contact Us</a></li>
			<li id="" class=""><a href="#">Privacy Policy</a></li>
			/*	*/
			?>
		</ul>
		<div class="copyright">
			<div class="footer_text">© 2013. All Rights Reserved. Created by suekarea</div>
		</div>
	</div>
</section>
</footer>

<!-- PopUp -->
<div id="overlay"></div>
<a href="#" id="toTop"><span></span></a>
<div id="login" class="login-popup"></div>
<div id="registration" class="registration-popup"></div>

<?php if ($this->config->item('online_widget')) { ?>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-42495224-1', 'suekarea.com');
ga('send', 'pageview');
</script>

<script type="text/javascript">
var sc_project=9102153; var sc_invisible=1; var sc_security="a493f0aa";
var scJsHost = (("https:" == document.location.protocol) ? "https://secure." : "http://www.");
document.write("<sc"+"ript type='text/javascript' src='" + scJsHost+ "statcounter.com/counter/counter_xhtml.js'></"+"script>");
</script>
<?php } ?>