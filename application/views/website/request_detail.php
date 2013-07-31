<?php $this->load->view( 'website/common/meta' ); ?>

<body class="blog boxed pattern-1 navigation-style-1">

<style>
.form-manual .right { padding: 5px 0; }
</style>

<div id="page" class="hfeed site">
	<?php $this->load->view( 'website/common/header' ); ?>
	
    <div id="main" class="right_sidebar"><div class="inner"><div class="general_content clearboth">
		<div class="main_content"><div id="primary" class="content-area"><div id="content" class="site-content" role="main">
			<h2 class="page-title">Submit Post</h2>
			
			<div class="post_content" style="padding: 0 0 25px 0;">
				<form method="post" id="form-request" class="form-manual form-validation">
					<input type="hidden" name="action" value="update" />
					
					<div class="left">Title</div>
					<div class="right">: <?php echo $request['name']; ?></div>
					<div class="clear"></div>
					
					<div class="left">Status</div>
					<div class="right">: <?php echo $request['status']; ?></div>
					<div class="clear"></div>
					
					
					<?php if (!empty($request['imdb'])) { ?>
					<div class="left">Link IMDB</div>
					<div class="right">: <?php echo $request['imdb']; ?></div>
					<div class="clear"></div>
					<?php } ?>
					
					<div class="left">Description</div>
					<div class="clear"></div>
					<div style="border: 1px solid #D6D6D6; padding: 5px 10px 15px 10px;"><?php echo $request['desc']; ?></div>
					
					<?php if (!empty($request['reply'])) { ?>
					<div class="left">Reply</div>
					<div class="right">: <?php echo $request['reply']; ?></div>
					<div class="clear"></div>
					<?php } ?>
				</form>
			</div>
			
			<script type="text/javascript" src="<?php echo base_url('static/js/comment.js'); ?>"></script>
		</div></div></div>
		<?php $this->load->view( 'website/common/sidebar' ); ?>
	</div></div></div>
	
	<?php $this->load->view( 'website/common/footer' ); ?>
</div>

<?php $this->load->view( 'website/common/library_js' ); ?>

</body>
</html>