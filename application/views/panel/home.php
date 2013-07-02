<?php
    $ext = base_url('static/js/extjs');
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<title>Administrator Home</title>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url('static/js/extjs/resources/css/ext-all.css'); ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url('static/js/extjs/resources/css/admin.css'); ?>" />
	<script type="text/javascript">
		URLS = <?php echo json_encode( array( 'base' => base_url(), 'ext' => $ext ) ); ?>;
	</script>
	<script type="text/javascript" src="<?php echo base_url('static/js/extjs/ext-all.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/extjs/app/app-all.js'); ?>"></script>
</head>
<body>
    <div id="loading">loading...</div>
	<div id="header" style="display: none;">
		<h1 id="logo"><a>SUEKAREA</a></h1>
		<div class="navigation"><ul>
			<li><a href="<?php echo base_url('administrator/logout'); ?>"><div>Logout</div></a></li>
		</ul></div>
	</div>
	<div id="footer" style="display:none;">
		<p>&copy; <?php echo date("Y"); ?> <a href="">Suekarea</a></p>
	</div>
</body>
</html>