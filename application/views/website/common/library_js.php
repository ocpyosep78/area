<script type='text/javascript' src='<?php echo base_url('static/js/skip-link-focus-fix.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('static/js/html5.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('static/js/superfish.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('static/js/jquery.flexslider-min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('static/js/jquery.tools.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('static/js/jquery.jcarousel.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('static/js/jquery.cokie.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('static/js/jquery.elastislide.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('static/js/jquery-ui.custom.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('static/js/jquery.mobilemenu.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('static/js/jquery.validate.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('static/js/common.min.js'); ?>'></script>
<script type='text/javascript' src='<?php echo base_url('static/js/main.js'); ?>'></script>

<?php if ($this->config->item('online_widget')) { ?>
<script>
/*
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-42495224-1', 'suekarea.com');
ga('send', 'pageview');
/*	*/

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-42495224-1']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; 
ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

<script type="text/javascript">
var sc_project=9102153; var sc_invisible=1; var sc_security="a493f0aa";
var scJsHost = (("https:" == document.location.protocol) ? "https://secure." : "http://www.");
document.write("<sc"+"ript type='text/javascript' src='" + scJsHost+ "statcounter.com/counter/counter_xhtml.js'></"+"script>");
</script>

<div id="fb-root"></div>
<?php } ?>