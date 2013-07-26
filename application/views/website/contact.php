<?php $this->load->view( 'website/common/meta' ); ?>

<body class="blog boxed pattern-1 navigation-style-1">

<div id="page" class="hfeed site">
	<?php $this->load->view( 'website/common/header' ); ?>
	
    <div id="main" class="right_sidebar"><div class="inner"><div class="general_content clearboth">
		<div class="main_content"><div id="primary" class="content-area"><div id="content" class="site-content" role="main">
			<h2 class="page-title">Contact Us</h2>
			<div class="post_content">
				<div id="respond">
					<form method="post" id="commentform">
						<input type="hidden" name="action" value="update" />
						
						<p class="comment-form-author">
							<input name="name" type="text" value="" size="30" />
							<label class="required">Name</label>
						</p>
						<p class="comment-form-email">
							<input name="email" type="text" value="" size="30" />
							<label class="required">Email</label>
						</p>
						<p class="comment-form-url">
							<input name="website" type="text" value="" size="30" />
							<label>Website</label>
						</p>
						<p class="comment-form-comment">
							<textarea name="message" cols="45" rows="8"></textarea>
						</p>
						<p class="form-submit">
							<input name="submit" type="submit" value="Send Message" class="comment" />
						</p>
						<p class="cnt-message"></p>
					</form>
				</div>
			</div>
		</div></div></div>
		<?php $this->load->view( 'website/common/sidebar' ); ?>
	</div></div></div>
	
	<?php $this->load->view( 'website/common/footer' ); ?>
</div>

<?php $this->load->view( 'website/common/library_js' ); ?>

<script>
$(document).ready(function() {
	$("#commentform").validate({
		rules: {
			name: { required: true, minlength: 4 },
			email: { required: true, email: true },
			message: { required: true }
		},
		messages: {
			name: { required: 'Silahkan mengisi field ini', minlength: '4 minimal karakter' },
			email: { required: 'Silahkan mengisi field ini', email: 'Email anda tidak valid' },
			message: { required: 'Silahkan mengisi field ini' }
		}
	});
	
	$('#commentform').submit(function() {
		if (! $("#commentform").valid()) {
			return false;
		}
		
		var param = Site.Form.GetValue('commentform');
		Func.ajax({ url: web.host + 'contact/action', param: param, callback: function(result) {
			if (result.status) {
				$("#commentform")[0].reset();
				$('.cnt-message').text('Pesan anda berhasil dikirim');
			}
		} });
		
		return false;
	});
});
</script>

</body>
</html>