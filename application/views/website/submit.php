<?php
	$is_login = $this->User_model->is_login();
	$array_category = $this->Category_model->get_array();
	
	// default data
	$download = (isset($_GET['link'])) ? $_GET['link'] : '';
?>

<?php $this->load->view( 'website/common/meta', array( 'title' => 'Suekarea - Submit', 'desc' => 'Suekarea - Submit Form' ) ); ?>

<body class="blog boxed pattern-1 navigation-style-1">

<div id="page" class="hfeed site">
	<?php $this->load->view( 'website/common/header' ); ?>
	
    <div id="main" class="right_sidebar"><div class="inner"><div class="general_content clearboth">
		<div class="main_content"><div id="primary" class="content-area"><div id="content" class="site-content" role="main">
			<h2 class="page-title">Submit Post</h2>
			
			<?php if ($is_login) { ?>
			<div class="post_content">
				<div class="hide">
					<iframe name="iframe_thumbnail" src="<?php echo base_url('panel/upload?callback_name=post_thumbnail'); ?>"></iframe>
				</div>
				
				<form method="post" id="form-submit" class="form-manual form-validation">
					<input type="hidden" name="action" value="update" />
					
					<div class="left required">Category</div>
					<div class="right">
						<select name="category_id" class="select"><?php echo ShowOption(array( 'Array' => $array_category, 'ArrayID' => 'id', 'ArrayTitle' => 'name' )); ?></select>
					</div>
					<div class="clear"></div>
					
					<div class="left required">Title</div>
					<div class="right"><input name="name" type="text" value="" maxlength="255" placeholder="Judul Halaman" /></div>
					<div class="clear"></div>
					
					<div class="left required">Description</div>
					<div style="padding: 0 0 15px 0;"><textarea name="desc" rows="10" style="width: 95%;" placeholder="Deskripsi Halaman"></textarea></div>
					<div class="clear"></div>
					
					<div class="left required">Link Page</div>
					<div class="right"><input name="used_link" type="text" value="<?php echo $download; ?>" maxlength="255" placeholder="Link Halaman Website" /></div>
					<div class="clear"></div>
					
					<div class="left">Tag</div>
					<div class="right"><input name="tag" type="text" value="" maxlength="255" placeholder="Tag Halaman Anda (pisahkan dengan tanda koma)" /></div>
					<div class="clear"></div>
					
					<div class="left required">Thumbnail</div>
					<div class="right">
						<input name="browse" type="button" value="Browse" style="float: right; width: 125px; height: 29px; padding: 0px;" />
						<input name="thumbnail" type="text" value="" style="width: 311px;" readonly="readonly" placeholder="Pilih Thumbnail" />
					</div>
					<div class="clear"></div>
					
					<div class="left">&nbsp;</div>
					<div class="right"><input name="submit" type="submit" value="Submit" style="width: 125px; height: 29px; padding: 0px;" /></div>
					<div class="clear"></div>
					
					<p class="c_message hide"></p>
				</form>
			</div>
			<?php } else { ?>
			<div class="post_content">
				<p class="c_message">Silahkan login untuk mengirim link Anda.</p>
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
	post_thumbnail = function(p) { $('[name="thumbnail"]').val(p.file_name); }
	
	// form
	$("#form-submit").validate({
		rules: {
			category_id: { required: true },
			name: { required: true },
			desc: { required: true },
			download: { required: true, url: true },
			thumbnail: { required: true }
		}
	});
	$('[name="browse"]').click(function() { window.iframe_thumbnail.browse(); });
	
	$('#form-submit').submit(function() {
		if (! $("#form-submit").valid()) {
			return false;
		}
		
		$('.c_message').hide();
		var param = Site.Form.GetValue('form-submit');
		delete param.submit;
		Func.ajax({ url: web.host + 'submit/action', param: param, callback: function(result) {
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