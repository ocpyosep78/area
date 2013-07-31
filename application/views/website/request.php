<?php
	$is_login = $this->User_model->is_login();
?>

<?php $this->load->view( 'website/common/meta' ); ?>

<body class="blog boxed pattern-1 navigation-style-1">

<div id="page" class="hfeed site">
	<?php $this->load->view( 'website/common/header' ); ?>
	
    <div id="main" class="right_sidebar"><div class="inner"><div class="general_content clearboth">
		<div class="main_content"><div id="primary" class="content-area"><div id="content" class="site-content" role="main">
			<h2 class="page-title">Submit Post</h2>
			
			<?php if ($is_login) { ?>
			<div class="post_content">
				<form method="post" id="form-request" class="form-manual form-validation">
					<input type="hidden" name="action" value="update" />
					
					<div class="left required">Title</div>
					<div class="right"><input name="name" type="text" value="" maxlength="255" placeholder="Judul Film" /></div>
					<div class="clear"></div>
					
					<div class="left required">Link IMDB</div>
					<div class="right"><input name="imdb" type="text" value="" maxlength="255" placeholder="http://www.imdb.com/title/tt1690953/" /></div>
					<div class="clear"></div>
					
					<div class="left required">Description</div>
					<div style="padding: 0 0 15px 0;"><textarea name="desc" rows="10" style="width: 95%;" placeholder="Deskripsi Film"></textarea></div>
					<div class="clear"></div>
					
					<div class="left">&nbsp;</div>
					<div class="right"><input name="submit" type="submit" value="Submit" style="width: 125px; height: 29px; padding: 0px;" /></div>
					<div class="clear"></div>
					
					<p class="c_message hide"></p>
				</form>
			</div>
			<?php } else { ?>
			<div class="post_content">
				<p class="c_message">Silahkan login untuk melakukan request.</p>
			</div>
			<?php } ?>
		</div></div></div>
		<?php $this->load->view( 'website/common/sidebar' ); ?>
	</div></div></div>
	
	<?php $this->load->view( 'website/common/footer' ); ?>
</div>

<?php $this->load->view( 'website/common/library_js' ); ?>

<script>
$(document).ready(function() {
	// form
	$("#form-request").validate({
		rules: {
			name: { required: true },
			imdb: { required: true },
			desc: { required: true }
		}
	});
	
	$('#form-request').submit(function() {
		if (! $("#form-request").valid()) {
			return false;
		}
		
		$('.c_message').hide();
		var param = Site.Form.GetValue('form-request');
		delete param.submit;
		Func.ajax({ url: web.host + 'request/action', param: param, callback: function(result) {
			if (result.status) {
				window.location = result.redirect;
			} else {
				$('.c_message').slideDown();
				$('.c_message').text(result.message);
			}
		} });
		
		return false;
	});
});
</script>

</body>
</html>