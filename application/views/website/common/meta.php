<?php
	$web['host'] = base_url();
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Suekarea - Share Movie and Anime Download</title>
	<link rel='stylesheet' type='text/css' media='all' id='primetime-style-css' href='<?php echo base_url('static/css/style.css'); ?>' />
	<link rel='stylesheet' type='text/css' media='all' id='responsive-css' href='<?php echo base_url('static/css/responsive.css'); ?>' />
	<script type='text/javascript' src='<?php echo base_url('static/js/jquery.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo base_url('static/js/modernizr.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo base_url('static/js/utils.js'); ?>'></script>
	<script> var web = <?php echo json_encode($web); ?></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-42495224-1', 'suekarea.com');
	  ga('send', 'pageview');
	</script>
</head>